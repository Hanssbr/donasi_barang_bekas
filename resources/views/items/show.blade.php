@extends('layouts.lte')

@section('title-content', 'Daftar Barang')
@section('content')

    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .item-description {
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-body h5 {
            font-size: 1.1rem;
            max-height: 2.4em;
            /* kira-kira 2 baris */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-img-top.img-fixed {
            height: 200px;
            object-fit: cover;
        }
    </style>


    <div class="row">
        <!-- Menampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($items as $item)
            <div class="col-md-4 mb-4"> <!-- Ganti 4 dengan 3 untuk 4 item per baris jika ingin lebih rapat -->
                <div class="card h-100">
                    @if ($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}" class="card-img-top img-fixed" alt="photo">
                    @else
                        <img src="{{ asset('assets/assets/img/error.jpg') }}" class="card-img-top img-fixed" alt="photo">
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
                        <p class="card-text item-description">{{ $item->description }}</p>

                        <!-- Link atau aksi lain bisa ditambahkan -->
                        <a href="{{ route('submissions.create', ['item' => $item->id]) }}" class="btn btn-primary">Ajukan
                            permintaan</a>
                        <a href="{{ route('report.index', ['item' => $item->id]) }}" class="btn btn-danger"><i
                                class="bi bi-flag-fill"></i></a>
                        <form action="{{ route('favorites.toggle', $item->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit"
                                class="btn btn-sm {{ $item->isFavoritedBy(auth()->user()) ? 'btn-danger' : 'btn-outline-danger' }}">
                                @if ($item->isFavoritedBy(auth()->user()))
                                    <i class="bi bi-heart-fill"></i>
                                @else
                                    <i class="bi bi-heart"></i>
                                @endif
                            </button>
                        </form>
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <form action="{{ route('admin.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus item ini?')" class="mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth


                    </div>
                    <a href="{{ route('comments.show', $item->id) }}" class="btn btn-secondary">
                        Lihat Komentar
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
