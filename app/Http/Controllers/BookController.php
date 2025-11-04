<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('is_active', true);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
        }

        $books = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        if (!$book->is_active) {
            abort(404);
        }

        return view('books.show', compact('book'));
    }

    public function about()
    {
        return view('books.about');
    }
}