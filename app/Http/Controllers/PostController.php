<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(Request $request)
{
    $search = $request->input('search');

    $posts = Post::query()
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view('posts.index', compact('posts', 'search'));
}

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.min' => 'Judul minimal 3 karakter.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'content.required' => 'Isi postingan wajib diisi.',
            'content.min' => 'Isi postingan minimal 10 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        
        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('posts', 'public');
        }

        Post::create($validated);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Postingan berhasil ditambahkan!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.min' => 'Judul minimal 3 karakter.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'content.required' => 'Isi postingan wajib diisi.',
            'content.min' => 'Isi postingan minimal 10 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Postingan berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Postingan berhasil dihapus!');
    }
}