<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\User;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function index()
    {
        $cat = Category::all()->count();
        $users = User::where('is_admin', 0)->count();
        $books = Book::all()->count();
        return response([
            'totalCategories' => $cat,
            'totalUsers' => $users,
            'totalBooks' => $books,
        ], 200);
    }
}
