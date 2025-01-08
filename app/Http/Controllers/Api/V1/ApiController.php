<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ticket;
use App\Traits\ApiResponses;
use Illuminate\Auth\AuthenticationException;
use App\Policies\V1\TicketPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
    use ApiResponses;
    //use AuthorizesRequests;

    protected $policyClass;
    public function include(string $relationship) : bool {
        $param = request()->get('include');

        if (!isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));
        return in_array(strtolower($relationship), $includeValues);
    }


    public function isAble($ability, $targetModel) {
        $gate = Gate::policy(Ticket::class, TicketPolicy::class);
        try {
            $gate->authorize($ability, [$targetModel, $this->policyClass]);
            return true;
        } catch (AuthenticationException $ex) {
            return false;
        }

    }
}
