<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'cover' => 'nullable|url|max:1000',
            'description' => 'nullable|string|max:5000',
        ]);

        $book->update($validated);

        return redirect()->route('home')->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return redirect()->route('home')->with('success', 'Book deleted successfully.');
    }
}
