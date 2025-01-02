<?php

namespace App\Errors;

enum APIError: string
{
    case Unauthorized = 'unauthorized';
    case WrongArguments = 'wrong_arg';
    case NotFound = 'not_found';
    case Internal = 'internal';
    case Forbidden = 'forbidden';
}
