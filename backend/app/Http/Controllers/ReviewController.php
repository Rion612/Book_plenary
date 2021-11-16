<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewFormRequest;
use App\Review;
use App\Traits\ApiResponseWithHttpStatus;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    use ApiResponseWithHttpStatus;
    //
    public function index(ReviewFormRequest $request){
        try {
            $review = new Review();
            $review->rating = $request->rating;
            $review->book_id = $request->book_id;
            $review->user_id = $request->user_id;
            $review->review = $request->review;
            $review->save();
            return $this->apiResponse('Review successfully submitted', null, $review,Response::HTTP_OK, true,null);
        } catch (\Exception $e) {
            return $this->apiResponse('Review is not submitted', null, null, Response::HTTP_BAD_REQUEST, true,null);
        }

    }
    public function getAllReiview(){
        $reviews = Review::all();
        return response([
            'reviews' => $reviews,
        ], 200);
    }
}
