@extends('layouts.lte')
@section('title-content', 'Komentar untuk ' . $item->name)

@section('content')
    <h2>Komentar untuk "{{ $item->name }}"</h2>


    @if ($item->comments->isEmpty())
        <p>Belum ada komentar.</p>
    @else
        @foreach ($item->comments as $comment)
            <div class="border rounded p-3 mb-3">
                <strong>{{ $comment->user->name ?? 'Anonim' }}</strong> berkomentar :
                <p>{{ $comment->content }}</p>
                <small class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    @endif
    @auth
        <form action="{{ route('comments.store', $item->id) }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <textarea name="content" rows="5" class="form-control" placeholder="Tulis komentar..."></textarea>
            </div>
            <button type="submit" class="btn btn-info">Kirim</button>
        </form>
    @endauth
@endsection
