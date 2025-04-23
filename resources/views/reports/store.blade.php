@extends('layouts.lte')
@section('title-content', 'Barang Yang di report')

@section('content')
    <h2>Report "{{ $item->name }}"</h2>
    @auth
        <form action="{{ route('report.store', $item->id) }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <textarea name="report" rows="5" class="form-control" placeholder="Tulis komentar..."></textarea>
            </div>
            <button type="submit" class="btn btn-info">Kirim</button>
        </form>
    @endauth
@endsection
