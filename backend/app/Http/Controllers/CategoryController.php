<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\Http\Requests\CategoryFormRequest;
use App\Traits\ApiResponseWithHttpStatus;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    //
    use ApiResponseWithHttpStatus;
    public function createCategories(CategoryFormRequest $request)
    {
        try {
            $categories = new Category();
            $categories->type = $request->type;
            $categories->save();
            return $this->apiResponse('Category successfully created', null, $categories, Response::HTTP_OK, true);
        } catch (\Exception $e) {
            return $this->apiResponse('Category is not created', null, null, Response::HTTP_BAD_REQUEST, true);
        }
    }
    public function getAllCategories()
    {
        $categories = Category::all();
        return response([
            'categories' => $categories,
        ], 200);
    }
    public function deleteCategory($id)
    {
        $item = Category::find($id);
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
    public function booksPerCategory($id)
    {
        try {
            $cate = Category::find($id);
            $books = $cate->books;
            return response([
                'books' => $books
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Something is wrong!'
            ], 400);
        }
    }
}
