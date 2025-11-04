<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $query = Book::where('is_active', true);
        $totalBooks = Book::where('is_active', true)->count();
        $selectedCategory = null;

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
            $selectedCategory = Category::find($request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        $sort = $request->get('sort', 'latest');
        switch($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->inRandomOrder();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $books = $query->paginate(9);

        return view('user.books-list', compact('books', 'categories', 'totalBooks', 'selectedCategory'));
    }

    public function show(Book $book)
    {
        if (!$book->is_active) {
            abort(404);
        }

        $relatedBooks = Book::where('is_active', true)
                            ->where('category_id', $book->category_id)
                            ->where('id', '!=', $book->id)
                            ->limit(4)
                            ->get();

        return view('user.book-detail', compact('book', 'relatedBooks'));
    }

    public function about()
    {
        return view('pages.about');
    }
}