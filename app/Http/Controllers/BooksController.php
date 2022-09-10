<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostBookRequest;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
        $this->middleware(['auth.admin'])->only(['store']);
    }

    public function index(Request $request)
    {
        // @TODO implement


        return BookResource::collection(Book::paginate(10));
    }

    public function store(PostBookRequest $request)
    {
        $admin = Auth::user()->is_admin;

        if ($admin) {
            $author = $request->authors;

            $book = new Book();

            $book->isbn = $request->isbn;
            $book->title = $request->title;
            $book->description = $request->description;
            $book->published_year = $request->published_year;
            $book->save();


            $book->authors()->sync(['book_id' => $book->id, 'author_id' => $author]);


            // $saveAuthor = DB::insert('insert into book_author (book_id, author_id) values (' . $saveBook->id . ',' . $author . ')');


            $retriev = Book::find($book->id);

            return new BookResource($retriev);
        } else {
            return response()->json('only admin', 403);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });
    }
}
