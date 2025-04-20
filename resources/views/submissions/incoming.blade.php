@extends('layouts.lte')
@section('title-content', 'Permintaan Donasi Masuk')

@section('content')
    <h1>Permintaan Donasi untuk Barang Anda</h1>

    @if ($submissions->isEmpty())
        <p>Tidak ada permintaan donasi masuk.</p>
    @else
        <div class="row">
            @foreach ($submissions as $submission)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Diajukan oleh:</strong>
                                {{ optional($submission->user)->name ?? 'User tidak ditemukan' }}</p>
                            <p><strong>Pesan:</strong> {{ $submission->message }}</p>
                            <p><strong>Status:</strong>
                                <span
                                    class="badge
                                    @if ($submission->status == 'pending') bg-warning @elseif ($submission->status == 'disetujui') bg-success @elseif ($submission->status == 'ditolak') bg-danger @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </p>
                            <small>Dikirim pada {{ $submission->created_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
