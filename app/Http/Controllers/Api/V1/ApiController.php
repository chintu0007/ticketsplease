<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponses;
    public function include(string $relationship) : bool {
        $param = request()->get('include');

        if (!isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }
}
