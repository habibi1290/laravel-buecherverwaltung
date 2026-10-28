<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookAPIController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
        ]);

        $title = trim($validated['title'] ?? '');
        $author = trim($validated['author'] ?? '');
        $isbn = trim($validated['isbn'] ?? '');

        if ($title === '' && $author === '' && $isbn === '') {
            return response()->json([
                'found' => false,
                'message' => 'Bitte Titel, Autor oder ISBN eingeben.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Mehrere Suchvarianten
        |--------------------------------------------------------------------------
        | Google Books findet nicht immer jedes Buch mit nur einer Suchvariante.
        | Deshalb probieren wir mehrere Varianten nacheinander.
        */
        $queries = [];

        if ($isbn !== '') {
            $queries[] = 'isbn:' . $isbn;
        }

        if ($title !== '' && $author !== '') {
            $queries[] = 'intitle:' . $title . ' inauthor:' . $author;
            $queries[] = $title . ' ' . $author;
        }

        if ($title !== '') {
            $queries[] = 'intitle:' . $title;
            $queries[] = $title;
        }

        if ($author !== '') {
            $queries[] = 'inauthor:' . $author;
            $queries[] = $author;
        }

        $book = null;
        $lastStatus = null;

        //Jetzt wird jede Suchanfrage aus $queries nacheinander ausprobiert.
        foreach ($queries as $query) {

           // Hier sendest du eine GET-Anfrage an Google Books.
            $response = Http::get('https://www.googleapis.com/books/v1/volumes', [

                //q ist der Suchbegriff für Google Books.
                'q' => $query,
                //Hier wird dein Google Books API-Key mitgesendet.
                'key' => config('services.google_books.api_key'),
                //Google soll maximal 10 Ergebnisse zurückgeben.
                'maxResults' => 10,
                //Google soll nur Bücher liefern, keine Magazine.
                'printType' => 'books',
            ]);

            //Speichert den HTTP-Status.
            $lastStatus = $response->status();

            if (!$response->successful()) {
                continue;
            }


            //Google Books liefert die Treffer unter items.
            $items = $response->json('items') ?? [];

            if (!empty($items)) {
                $book = $this->getBestBook($items, $title, $author, $isbn);
                break;
            }
        }

        //Wenn nach allen Suchvarianten kein Buch gefunden wurde:
        if (!$book) {
            return response()->json([
                'found' => false,
                'message' => 'Kein Buch gefunden.',
                'status' => $lastStatus,
                'api_key_exists' => config('services.google_books.api_key') ? true : false,
            ]);
        }

        //Die wichtigsten Google-Books-Daten stehen in volumeInfo.
        $volumeInfo = $book['volumeInfo'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Kategorie holen
        |--------------------------------------------------------------------------
        */

        //Holt die Kategorien aus Google Books.
        $categories = $volumeInfo['categories'] ?? [];
        //Die finale Kategorie ist erstmal null.
        $category = null;

        //Wenn Google eine mainCategory liefert:
        if (!empty($volumeInfo['mainCategory'])) {

            //Dann wird diese Hauptkategorie genommen.
            $category = $volumeInfo['mainCategory'];

            //Wenn keine mainCategory existiert, aber Kategorien vorhanden sind:
        } elseif (!empty($categories) && is_array($categories)) {
            $category = trim(explode('/', $categories[0])[0]);
        }

        /*
        |--------------------------------------------------------------------------
        | Kategorie übersetzen
        |--------------------------------------------------------------------------
        */
        $categoryMap = [
            'Fiction' => 'Roman',
            'Juvenile Fiction' => 'Kinder- und Jugendroman',
            'Young Adult Fiction' => 'Jugendroman',
            'Nonfiction' => 'Sachbuch',
            'Biography & Autobiography' => 'Biografie',
            'Business & Economics' => 'Wirtschaft',
            'Computers' => 'Informatik',
            'Education' => 'Bildung',
            'History' => 'Geschichte',
            'Science' => 'Wissenschaft',
            'Self-Help' => 'Ratgeber',
            'Health & Fitness' => 'Gesundheit',
            'Cooking' => 'Kochen',
            'Travel' => 'Reisen',
            'Religion' => 'Religion',
            'Philosophy' => 'Philosophie',
            'Psychology' => 'Psychologie',
            'Political Science' => 'Politik',
            'Social Science' => 'Sozialwissenschaft',
            'Art' => 'Kunst',
            'Music' => 'Musik',
            'Poetry' => 'Poesie',
            'Drama' => 'Drama',
            'Comics & Graphic Novels' => 'Comics & Graphic Novels',
            'Technology & Engineering' => 'Technik & Ingenieurwesen',
            'Medical' => 'Medizin',
            'Law' => 'Recht',
            'Sports & Recreation' => 'Sport & Freizeit',
        ];

        //Gibt es eine Kategorie?
        //Und existiert diese Kategorie in der Übersetzungstabelle?
        if ($category && isset($categoryMap[$category])) {
            //Wenn ja, wird die englische Kategorie durch die deutsche ersetzt.
            $category = $categoryMap[$category];
        }

        /*
        |--------------------------------------------------------------------------
        | ISBN holen
        |--------------------------------------------------------------------------
        */
        $foundIsbn = null;

        foreach ($volumeInfo['industryIdentifiers'] ?? [] as $identifier) {
            if (($identifier['type'] ?? null) === 'ISBN_13') {
                $foundIsbn = $identifier['identifier'] ?? null;
                break;
            }

            if (($identifier['type'] ?? null) === 'ISBN_10') {
                $foundIsbn = $identifier['identifier'] ?? null;
            }
        }

        return response()->json([
            'found' => true,
            'title' => $volumeInfo['title'] ?? null,
            'authors' => $volumeInfo['authors'] ?? [],
            'isbn' => $foundIsbn,
            'cover' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
            'category' => $category,
            'description' => $volumeInfo['description'] ?? null,
        ]);
    }

    private function getBestBook(array $items, string $title, string $author, string $isbn): ?array
    {

        if ($isbn !== '') {
            foreach ($items as $item) {
                $volumeInfo = $item['volumeInfo'] ?? [];
                $identifiers = $volumeInfo['industryIdentifiers'] ?? [];

                foreach ($identifiers as $identifier) {
                    if (($identifier['identifier'] ?? '') === $isbn) {
                        return $item;
                    }
                }
            }
        }

        foreach ($items as $item) {
            $volumeInfo = $item['volumeInfo'] ?? [];

            if (!empty($volumeInfo['imageLinks']['thumbnail'])) {
                return $item;
            }
        }

        return $items[0] ?? null;
    }
}
