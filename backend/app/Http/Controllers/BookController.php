<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    public function createBooks(Request $request)
    {
        try {
            $book = new Book();
            $book->name = $request->name;
            $book->writer = $request->writer;
            $book->description = $request->description;
            if ($request->hasFile('image')) {
                $destination_path = "public/images/books";
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $path = $request->file('image')->storeAs($destination_path, $imageName);
                $book->bookImage = $imageName;
            }
            $c = explode(",", $request->categories);

            foreach ($c as $cat) {
                $categoriesArray[] = (int)($cat);
            }
            $book->save();
            $book->categories()->attach($categoriesArray);
            return response([
                'message' => 'Successfully created!'
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => $e
            ], 400);
        }
    }
    public function getAllBooks()
    {

        try {
            $books = Book::all();
            return response([
                'books' => $books
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Something is wrong!'
            ], 400);
        }
    }
    public function categoriesPerBook($id)
    {
        try {
            $book = Book::find($id);
            $cate = $book->categories;
            return response([
                'categories' => $cate
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Something is wrong!'
            ], 400);
        }
    }
    public function deleteDelete($id)
    {
        $item = Book::find($id);
        try {
            $item->delete();
            return response([
                'message' => 'Item is deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Item is not deleted successfully!'
            ], 400);
        }
    }
    public function getSingleBook($id){
        
        try {
            $book = Book::find($id);
            return response([
                'book' => $book
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Something is wrong'
            ], 400);
        }
    }
    public function updateBooks(Request $request,$id)
    {
        try {
            $book = Book::find($id);
            $book->name = $request->name;
            $book->writer = $request->writer;
            $book->description = $request->description;
            if ($request->hasFile('image')) {
                $destination_path = "public/images/books";
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $path = $request->file('image')->storeAs($destination_path, $imageName);
                $book->bookImage = $imageName;
            }
            $c = explode(",", $request->categories);

            foreach ($c as $cat) {
                $categoriesArray[] = (int)($cat);
            }
            $book->save();
            $book->categories()->attach($categoriesArray);
            return response([
                'message' => 'Successfully updated!'
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => $e
            ], 400);
        }
    }
}
