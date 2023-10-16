@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Post</h1>

        @if ($errors->any())
            <div class="alert alert-danger"></div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="{{ route('admin.posts.update', $post->slug) }}" method="POST">
            @csrf()
            @method('PATCH')

            <div class="mb-5"><label class="form-label">Titolo</label><input type="text" class="form-control" name="title"
                    value="{{ $post->title }}">
            </div>
            <div class="mb-5"><label class="form-label">Immagine</label><input type="text" class="form-control"
                    name="image" value="{{ $post->image }}">
            </div>
            <div class="mb-5"><label class="form-label">Contenuto</label>
                <textarea class="form-control" name="body">{{ $post->body }}</textarea>
            </div>

            <button class="btn btn-primary">Aggiorna</button>

        </form>
    </div>
@endsection