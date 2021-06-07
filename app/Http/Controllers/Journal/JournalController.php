<?php

namespace App\Http\Controllers\Journal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Journal;

class JournalController extends Controller
{

    private $client;
    private $url;

    public function __construct() {
        $this->url = "/prediction";
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => env('TENSORFLOW', 'http://34.126.151.200:9898'),
        ]);
    }

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

        // Get prediction
        $response = $this->client->post($this->url, ['form_params' => [
            'story' => $request->story,
        ]]);
        $serverResponse = json_decode((string) $response->getBody());

        $image = [];
        if ($request->hasFile('image')) {
            $image = ['image' => $request->file('image')->store('journals')];
        }

        $data = Auth::user()->journals()->create($request->only('story') + ['prediction' => $serverResponse->data->prediction] + $image);

        return response()->json([
            'status' => 'success',
            'message' => 'Journal saved Successfully',
            'data' => [
                'journal' => $data,
            ],
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'story' => ['required'],
            'image' => ['image', 'max:1024'],
        ]);

        $journal = Journal::find($id);
        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found',
            ], 404);
        }

        // Get prediction
        $response = $this->client->post($this->url, ['form_params' => [
            'story' => $request->story,
        ]]);
        $serverResponse = json_decode((string) $response->getBody());

        $image = [];
        if ($request->hasFile('image')) {
            if ($image = ['image' => $request->file('image')->store('journals')]) {
                // Jika sukses upload, hapus yg lama
                if (Storage::exists($journal->image)) {
                    Storage::delete($journal->image);
                }
            }
        }

        $journal->update($request->only('story') + ['prediction' => $serverResponse->data->prediction] + $image);
        return response()->json([
            'status' => 'success',
            'message' => 'Journal updated Successfully',
            'data' => [
                'journal' => $journal,
            ],
        ], 200);
    }

    public function delete($id)
    {
        $journal = Journal::find($id);
        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found',
            ], 404);
        }

        if ($journal->delete()) {
            // Delete image if exists
            if (Storage::exists($journal->image)) {
                Storage::delete($journal->image);
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Journal deleted Successfully',
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Delete failed, please contact developer',
        ], 500);
    }
}