@extends('layouts.lte')

@section('title-content', 'Barang Favorit')

@section('content')
    <div class="row">
        <!-- Menampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($favorites->isEmpty())
            <div class="col-12">
                <p>Kamu belum menambahkan barang ke favorit.</p>
            </div>
        @else
            @foreach ($favorites as $favorite)
                @php
                    $item = $favorite->item;
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if ($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" class="card-img-top" alt="photo">
                        @else
                            <img src="{{ asset('assets/assets/img/error.jpg') }}" class="card-img-top" alt="photo">
                        @endif

                        <div class="card-body">
                            <div class="mb-2">
                                <h5>{{ $item->name }}</h5>
                            </div>

                            <div class="mb-2">
                                <p class="badge bg-primary me-2">{{ $item->category }}</p>
                                <p class="badge bg-info">{{ $item->condition }}</p>
                            </div>

                            <p class="text-muted mb-2">{{ $item->location }} <i class="bi bi-geo-alt-fill"></i></p>

                            <p class="card-text">{{ $item->description }}</p>

                            <a href="{{ route('submissions.create', ['item' => $item->id]) }}"
                                class="btn btn-primary">Ajukan Permintaan</a>
                            <a href="{{ route('report.index', ['item' => $item->id]) }}" class="btn btn-danger"><i
                                    class="bi bi-flag-fill"></i></a>

                            <form action="{{ route('favorites.toggle', $item->id) }}" method="POST"
                                style="display:inline">
                                @csrf
                                <button type="submit"
                                    class="btn {{ $item->isFavoritedBy(auth()->user()) ? 'btn-danger' : 'btn-outline-danger' }}">
                                    @if ($item->isFavoritedBy(auth()->user()))
                                        <i class="bi bi-heart-fill"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('comments.show', $item->id) }}" class="btn btn-secondary">
                            Lihat Komentar
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
