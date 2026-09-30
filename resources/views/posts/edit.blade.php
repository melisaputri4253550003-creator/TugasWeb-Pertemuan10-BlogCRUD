@extends('layouts.master')

@section('title', 'Edit Postingan')

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Postingan</h1>
            <p>Perbarui informasi postingan.</p>
        </div>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <x-card>

        <form
            action="{{ route('posts.update', $post) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Judul Postingan</label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    placeholder="Masukkan judul postingan"
                >

                @error('title')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Isi Postingan</label>

                <textarea
                    id="content"
                    name="content"
                    placeholder="Tulis isi postingan..."
                >{{ old('content', $post->content) }}</textarea>

                @error('content')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if($post->image)
                <div class="form-group">
                    <label>Gambar Saat Ini</label>

                    <img
                        src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        style="
                            width: 300px;
                            max-height: 200px;
                            object-fit: cover;
                            border-radius: 8px;
                            display: block;
                        "
                    >
                </div>
            @endif

            <div class="form-group">
                <label for="image">Ganti Gambar</label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                >

                <small>
                    Kosongkan jika tidak ingin mengganti gambar.
                </small>

                @error('image')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="actions">

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('posts.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

            </div>

        </form>

    </x-card>

@endsection