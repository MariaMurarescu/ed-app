<?php

namespace App\Http\Controllers;

// Import necessary traits and classes from the Laravel framework
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Define the Controller class that extends the BaseController class
class Controller extends BaseController
{
    // Use the AuthorizesRequests and ValidatesRequests traits
    use AuthorizesRequests, ValidatesRequests;
}
