<?php

namespace App\Http\Controllers;

use App\Traits\Apiresponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use Apiresponses;
    public function login() {

        return $this->ok('Hello, Login with Traits!');

        // return response()->json([
        //     'message' => 'Hello Login!'
        // ], 200);
    }
}
