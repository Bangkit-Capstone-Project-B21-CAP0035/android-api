<?php

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Journal;

class JournalController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => [
                'journals' => Auth::user()->journals,
            ],
        ], 200);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'story' => ['required'],
            'image' => ['image', 'max:1024'],
        ]);

        $image = [];
        if ($request->hasFile('image')) {
            $image = ['image' => $request->file('image')->store('journals')];
        }

        $data = Auth::user()->journals()->create($request->only('story') + $image);

        return response()->json([
            'status' => 'success',
            'message' => 'Journal saved Successfully',
            'data' => [
                'journals' => $data,
            ],
        ], 200);
    }
}