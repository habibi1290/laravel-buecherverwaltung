<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/*
WithHeadings bedeutet:
Die Excel-Datei soll Überschriften in der ersten Zeile haben.

FromCollection bedeutet:
Die Excel-Daten kommen aus einer Laravel Collection.
*/
class BooksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Book::select(
            'title',
            'author',
            'category',
            'isbn',
            'cover',
            'description'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Author',
            'Category',
            'ISBN',
            'Cover',
            'Description',
        ];
    }
}
