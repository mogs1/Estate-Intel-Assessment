<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }
        if ($request->filled('publisher')) {
            $query->where('publisher', $request->publisher);
        }
        if ($request->filled('release_date')) {
            $query->whereYear('release_date', $request->release_date);
        }

        return response()->json([
            'status_code' => 200,
            'status'      => 'success',
            'data'        => $query->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string',
            'isbn'            => 'required|string',
            'authors'         => 'required|array',
            'country'         => 'required|string',
            'number_of_pages' => 'required|integer',
            'publisher'       => 'required|string',
            'release_date'    => 'required|string',
        ]);

        $book = Book::create($data);

        return response()->json([
            'status_code' => 201,
            'status'      => 'success',
            'data'        => ['book' => $book],
        ], 201);
    }

    public function show(Book $book)
    {
        return response()->json([
            'status_code' => 200,
            'status'      => 'success',
            'data'        => $book,
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'name'            => 'sometimes|string',
            'isbn'            => 'sometimes|string',
            'authors'         => 'sometimes|array',
            'country'         => 'sometimes|string',
            'number_of_pages' => 'sometimes|integer',
            'publisher'       => 'sometimes|string',
            'release_date'    => 'sometimes|string',
        ]);

        $book->update($data);

        return response()->json([
            'status_code' => 200,
            'status'      => 'success',
            'message'     => "The book {$book->name} was updated successfully",
            'data'        => $book,
        ]);
    }

    public function destroy(Book $book)
    {
        $name = $book->name;
        $book->delete();

        return response()->json([
            'status_code' => 204,
            'status'      => 'success',
            'message'     => "The book '{$name}' was deleted successfully",
            'data'        => [],
        ]);
    }
}