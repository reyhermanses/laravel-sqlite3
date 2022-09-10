<?php

namespace App\Http\Resources;

use App\User;
use Tests\CreatesApplication;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReviewResource extends JsonResource
{
    use CreatesApplication;
    use RefreshDatabase;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'review' => $this->review,
            'comment' => $this->comment,
            'user' => User::selectRaw('id, name')->find($this->user_id),
        ];
    }
}
