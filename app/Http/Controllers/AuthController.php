<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use App\Traits\Apiresponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use Apiresponses;

     
    public function login(ApiLoginRequest $request) {

        return $this->ok($request->get('email'));
    
    }
    public function register() {
        return $this->ok('Register');
    }
}
