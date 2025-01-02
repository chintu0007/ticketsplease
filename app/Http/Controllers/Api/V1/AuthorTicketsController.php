<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Models\User;

class AuthorTicketsController extends ApiController
{
    public function index($author_id, TicketFilter $filters) {
        return TicketResource::collection(
            Ticket::where('user_id', $author_id)->filter($filters)->paginate()
        );
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store($author_id, StoreTicketRequest $request)
    {   

        try {
            $user = User::findOrFail($author_id);
        } catch (ModelNotFoundException $exception) {
            return $this->ok('User not found', [
                'error' => 'The provided user id does not exists'
            ]);
        }
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author_id
        ];
        return new TicketResource(Ticket::create($model));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $author_id, $ticket_id) {
        
        // PATCH
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->update($request->mappedAttributes());
                return new TicketResource($ticket);
            }  
            // TODO: ticket doesn't belong to user
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
        
    }


    /**
     * Replace the specified resource from storage.
     */

    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id) {


        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->update($request->mappedAttributes());
                return new TicketResource($ticket);
            }  
            // TODO: ticket doesn't belong to user
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }

    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        try {            
            $ticket = Ticket::findOrFail($ticket_id);
            if ($ticket->user_id == $author_id) {                
                $ticket->delete();
                return $this->ok('Ticket successfully deleted');                
            }            
            return $this->error('Ticket cannot be found', 404);

        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found', 404);
        }
        
    }
}
