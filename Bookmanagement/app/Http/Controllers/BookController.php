<?php


namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'cover' => ['nullable', 'url', 'max:1000'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);
        Book::create($validated);

        return redirect()
            ->route('home')
            ->with('success', 'Buch wurde gespeichert.');
    }
}
