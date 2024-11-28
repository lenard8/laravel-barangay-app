<?php

namespace App\Http\Controllers;

use App\Models\Updates;
use Illuminate\Http\Request;

class UpdatesController extends Controller
{
    public function insertupdate(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string'
        ]);
    
        $post = Updates::create($fields);
        return response()->json($post, 201); 
    }

    public function viewupdate()
    {
        $news = Updates::all();
        return response()->json($news); 
    }

    public function updateupdate(Request $request, $id)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string'
        ]);

        $post = Updates::find($id);

        if (!$post) {
            return response()->json(['message' => 'Update not found'], 404);
        }

        $post->update($fields);
        return response()->json(['message' => 'Update successfully updated', 'update' => $post], 200);
    }

    public function deleteupdate($id)
    {
        $post = Updates::find($id);

        if (!$post) {
            return response()->json(['message' => 'Update not found'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Update successfully deleted'], 200);
    }
}
