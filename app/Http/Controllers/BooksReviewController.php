<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookReviewResource;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookResource;

class BooksReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
        $this->middleware(['auth.admin'])->only(['destroy']);
    }

    public function store(int $bookId, PostBookReviewRequest $request)
    {
        // @TODO implement

        $book = Book::find($bookId);

        try {

            $bookReview = new BookReview();
            $bookReview->book_id = $bookId;
            $bookReview->user_id = Auth::user()->id;
            $bookReview->review = $request->review;
            $bookReview->comment = $request->comment;
            $bookReview->save();

            $query = $bookReview::find($bookReview->id);

            return new BookReviewResource($query);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'ERROR',
                'error' => $th->getMessage()
            ], 404);
        }
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        $book = Book::find($bookId);

        try {
            //code...
            $delete = $book->delete();

            if ($delete) {
                $data = [
                    'status' => '1',
                    'msg' => 'success'
                ];
            } else {
                $data = [
                    'status' => '0',
                    'msg' => 'fail'
                ];
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'ERROR',
                'error' => $th->getMessage()
            ], 404);
        }

    }
}
