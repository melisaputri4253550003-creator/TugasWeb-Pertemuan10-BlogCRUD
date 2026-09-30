@extends('layouts.master')

@section('title', 'Daftar Postingan')

@section('content')

    <div class="page-header">
        <div>
            <h1>Daftar Postingan</h1>
            <p>Kelola semua postingan blog.</p>
        </div>

        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            + Tambah Postingan
        </a>
    </div>
    <form
    action="{{ route('posts.index') }}"
    method="GET"
    style="
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    "
>
    <input
        type="text"
        name="search"
        value="{{ $search ?? '' }}"
        placeholder="Cari judul atau isi postingan..."
    >

    <button type="submit" class="btn btn-primary">
        🔎 Cari
    </button>

    @if(!empty($search))
        <a
            href="{{ route('posts.index') }}"
            class="btn btn-secondary"
        >
            Reset
        </a>
    @endif
</form>

    @if($posts->count())

        @foreach($posts as $post)

            <x-card>

                @if($post->image)
                    <img
                        src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        style="width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;"
                    >
                @endif

                <h2>{{ $post->title }}</h2>

                <p style="margin-top: 10px;">
                    {{ \Illuminate\Support\Str::limit($post->content, 150) }}
                </p>

                <small style="display: block; margin-top: 10px; color: #6b7280;">
                    {{ $post->created_at->format('d M Y H:i') }}
                </small>

                <div class="actions">

                    <a
                        href="{{ route('posts.show', $post) }}"
                        class="btn btn-primary"
                    >
                        Lihat
                    </a>

                    <a
                        href="{{ route('posts.edit', $post) }}"
                        class="btn btn-warning"
                    >
                        Edit
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

        @endforeach

        <div style="margin-top: 25px;">
            {{ $posts->links() }}
        </div>

    @else

        <x-card>
            <p>Belum ada postingan.</p>
        </x-card>

    @endif

@endsection