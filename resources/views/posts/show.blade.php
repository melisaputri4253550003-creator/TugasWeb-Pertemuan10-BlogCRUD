@extends('layouts.master')

@section('title', $post->title)

@section('content')

    <div class="page-header">
        <div>
            <h1>Detail Postingan</h1>
            <p>Informasi lengkap postingan.</p>
        </div>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <x-card>

        @if($post->image)
            <img
                src="{{ asset('storage/' . $post->image) }}"
                alt="{{ $post->title }}"
                style="
                    width: 100%;
                    max-height: 450px;
                    object-fit: cover;
                    border-radius: 10px;
                    margin-bottom: 25px;
                "
            >
        @endif

        <h1>{{ $post->title }}</h1>

        <small style="
            display: block;
            margin: 10px 0 25px;
            color: #6b7280;
        ">
            Dipublikasikan:
            {{ $post->created_at->format('d M Y, H:i') }}
        </small>

        <div style="
            line-height: 1.8;
            white-space: pre-line;
        ">
            {{ $post->content }}
        </div>

        <div class="actions">

            <a
                href="{{ route('posts.edit', $post) }}"
                class="btn btn-warning"
            >
                Edit Postingan
            </a>

            <form
                action="{{ route('posts.destroy', $post) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus postingan ini?')"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    Hapus
                </button>
            </form>

        </div>

    </x-card>

@endsection