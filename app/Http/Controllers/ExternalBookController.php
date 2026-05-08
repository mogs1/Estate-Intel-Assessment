<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalBookController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name', '');

        $response = Http::get('https://www.anapioficeandfire.com/api/books', [
            'name' => $name,
        ]);

        $books = $response->json();

        if (empty($books)) {
            return response()->json([
                'status_code' => 404,
                'status'      => 'not found',
                'data'        => [],
            ], 404);
        }

        $formatted = collect($books)->map(function ($book) {
            return [
                'name'            => $book['name'],
                'isbn'            => $book['isbn'],
                'authors'         => $book['authors'],
                'number_of_pages' => $book['numberOfPages'],
                'publisher'       => $book['publisher'],
                'country'         => $book['country'],
                'release_date'    => substr($book['released'], 0, 10),
            ];
        });

        return response()->json([
            'status_code' => 200,
            'status'      => 'success',
            'data'        => $formatted,
        ]);
    }
}