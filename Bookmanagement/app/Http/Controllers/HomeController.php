<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);
        $search = $validated['search'] ?? null;
        $category = $validated['category'] ?? null;


        $books = Book::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('author', 'LIKE', '%' . $search . '%');
                });
            })
            ->when($category, function ($query, $category) {
                $query->whereRaw('LOWER(category) LIKE ?', [
                    '%' . strtolower(trim($category)) . '%'
                ]);
            })
            ->get();

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

        return view('home', [
            'books' => $books,
            'categoryMap' => $categoryMap,
        ]);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', [
            'book' => $book
        ]);
    }
}
