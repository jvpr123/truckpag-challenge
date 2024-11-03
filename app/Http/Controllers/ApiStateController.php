<?php

namespace App\Http\Controllers;

class ApiStateController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'API state route']);
    }
}
