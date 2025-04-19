@extends('layouts.lte')

@section('title-content', 'Daftar Barang')
@section('content')

    <div class="row">
        @foreach ($items as $item)
            <div class="col-md-4 mb-4"> <!-- Ganti 4 dengan 3 untuk 4 item per baris jika ingin lebih rapat -->
                <div class="card">
                    @if ($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}" class="card-img-top" alt="photo">
                    @else
                        <img src="{{ asset('assets/assets/img/error.jpg') }}" class="card-img-top" alt="photo">
                    @endif

                    <div class="card-body">
                        <!-- Nama barang -->
                        <div class="mb-2">
                            <h5>{{ $item->name }}</h5>
                        </div>

                        <!-- Menampilkan category dan condition sebagai badge, di bawah judul -->
                        <div class="mb-2">
                            <p class="badge bg-primary me-2">{{ $item->category }}</p>
                            <p class="badge bg-info">{{ $item->condition }}</p>
                        </div>

                        <!-- Menampilkan location di bawah badge -->
                        <p class="text-muted mb-2">{{ $item->location }} <i class="bi bi-geo-alt-fill"></i></p>

                        <!-- Deskripsi -->
                        <p class="card-text">{{ $item->description }}</p>

                        <!-- Link atau aksi lain bisa ditambahkan -->
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

@endsection
