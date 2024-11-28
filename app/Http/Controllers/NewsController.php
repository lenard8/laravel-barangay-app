<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Http\Request;
use App\Models\Post;
class NewsController extends Controller
{

    
    public function insert(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
    
        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            // Get the original filename of the uploaded image
            $imageName = $request->file('image')->getClientOriginalName();
            
            // Move the image to the public directory under components/Images
            $request->file('image')->move(public_path('components/Images'), $imageName);
        }
    
        // Create the news post in the database
        $post = News::create([
            'title' => $fields['title'],
            'content' => $fields['content'],
            'date' => $fields['date'],
            'image' => $imageName, // Store the image filename
        ]);
    
        // Return the post, including the image filename
        return response()->json($post, 201); 
    }
    
    public function view()
    {
        // Fetch all records from the news table
        $news = News::all();
    
        // Return the records in JSON format
        return response()->json($news); 
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $fields = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        // Find the post by its id
        $post = News::find($id);

        // If the post is not found, return an error
        if (!$post) {
            return response()->json(['message' => 'News not found'], 404);
        }

        // Update the post with new data
        $post->update([
            'title' => $fields['title'],
            'content' => $fields['content'],
            'date' => $fields['date'],
            'image' => $fields['image'] ?? $post->image, // Keep old image if no new image is provided
        ]);

        // Return the updated post
        return response()->json($post);
    }

    
    public function delete($id)
    {
        // Find the post by its id
        $post = News::find($id);

        // If the post is not found, return an error
        if (!$post) {
            return response()->json(['message' => 'News not found'], 404);
        }

        // Delete the post
        $post->delete();

        // Return a success message
        return response()->json(['message' => 'News deleted successfully']);
    }
  
}
