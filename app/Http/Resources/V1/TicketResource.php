<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{

    //public static $wrap = 'ticket';
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {        
            return [
                'type' => 'ticket',
                'id' => $this->id,
                'attributes' => [
                    'title' => $this->title, // Add more fields as needed
                    'description' => $this->description,
                    'status' => $this->status,
                    'createdAt' => $this->created_at->toDateTimeString(),
                    'updatedAt' => $this->updated_at->toDateTimeString()
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'User',
                            'id' => $this->user_id
                        ]
                    ]
                ],
                'links' => [
                    'self' => route('tickets.show', ['ticket' => $this->id])
                ]
            ];
        
    }
}
