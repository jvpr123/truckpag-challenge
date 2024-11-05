<?php

namespace App\Http\Controllers;

use App\Core\UseCases\GetApiStatesUseCase;

class ApiStateController extends Controller
{
    public function index(GetApiStatesUseCase $useCase)
    {
        $states = $useCase->execute();
        return response()->json($states);
    }
}
