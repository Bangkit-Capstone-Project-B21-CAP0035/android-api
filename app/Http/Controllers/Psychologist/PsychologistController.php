<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Psychologist;

class PsychologistController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => [
                'psychologists' => Psychologist::latest()->get(),
            ],
        ], 200);
    }
}