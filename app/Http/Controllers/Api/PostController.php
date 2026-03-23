<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:102400',
            'caption' => 'nullable|string',
            'hashtags' => 'nullable|array',
            'selected_networks' => 'required|array',
        ]);

        $file = $request->file('file');
        $fileType = $file->getMimeType();
        
        if (str_starts_with($fileType, 'image/')) {
            $fileType = 'image';
        } elseif (str_starts_with($fileType, 'video/')) {
            $fileType = 'video';
        } else {
            return response()->json(['error' => 'Tipo de archivo no soportado'], 422);
        }

        $path = $file->store('posts', 'public');

        $post = Post::create([
            'file_path' => $path,
            'file_type' => $fileType,
            'caption' => $validated['caption'] ?? '',
            'hashtags' => $validated['hashtags'] ?? [],
            'selected_networks' => $validated['selected_networks'],
            'status' => 'pending',
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'caption' => 'nullable|string',
            'hashtags' => 'nullable|array',
            'selected_networks' => 'nullable|array',
            'status' => 'nullable|string',
        ]);

        $post->update($validated);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if ($post->file_path) {
            Storage::disk('public')->delete($post->file_path);
        }
        $post->delete();

        return response()->json(['message' => 'Post eliminado']);
    }

    public function share(Request $request, Post $post)
    {
        $networks = $post->selected_networks;
        $fullCaption = $post->caption . "\n\n" . implode(' ', $post->hashtags ?? []);
        
        return response()->json([
            'networks' => $networks,
            'caption' => $fullCaption,
            'file_url' => Storage::disk('public')->url($post->file_path),
        ]);
    }
}
