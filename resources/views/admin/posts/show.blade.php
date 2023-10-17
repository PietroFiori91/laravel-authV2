@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="navbar my-5">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-link">
                <i class="fas fa-chevron-left"></i>Torna alla lista Post</a>
        </div>
        <h1>{{ $post->title }}</h1>

        <img src="{{ asset('/storage/' . $post->image) }}" alt="" class="img-fluid">

        <small>Data pubblicazione: {{ $post->published_at?->format('d/m/Y H:i') }}</small>

        <img src="{{ $post->image }}" alt="" class="img-fluid">

        <p>{{ $post->body }}</p>
    </div>
@endsection
