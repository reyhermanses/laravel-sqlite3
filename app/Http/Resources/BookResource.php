<?php

namespace App\Http\Resources;

use App\Book;
use App\Author;
use Tests\CreatesApplication;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    use CreatesApplication;
    use RefreshDatabase;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'description' => $this->description,
            'authors' => $this->authors->map(function (Author $author) {
                return ['id' => $author->id, 'name' => $author->name, 'surname' => $author->surname];
            })->toArray(),
            'review' => [
                'avg' => (int) round($this->reviews->avg('review')),
                'count' => (int) $this->reviews->count(),
            ],
        ];
      
    }
    
}
