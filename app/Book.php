<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class Book extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'description',
        'published_year'
    ];

    // protected static function booted()
    // {
    //     $this->registerPolicies();

    //     Gate::define('edit-settings', function (User $user) {
    //         return $user->isAdmin
    //                     ? Response::allow()
    //                     : Response::deny('You must be an administrator.');
    //     });
    // }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class, 'book_id', 'id');
    }
}
