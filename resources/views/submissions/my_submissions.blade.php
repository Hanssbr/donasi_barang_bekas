@extends('layouts.lte')
@section('title-content', 'History')

@section('content')
    <h1 class="mb-4">Daftar Pengajuan Donasi Anda</h1>

    @if ($submissions->isEmpty())
        <div class="alert alert-info">
            Anda belum mengajukan permintaan donasi.
        </div>
    @else
        <div class="row">
            @foreach ($submissions as $submission)
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">
                                <strong>Item:</strong>
                                @if ($submission->item)
                                    {{ $submission->item->name }}
                                @else
                                    <span class="text-danger">Item tidak ditemukan</span>
                                @endif
                            </h5><br>

                            <p class="card-text">
                                <strong>Pesan:</strong> {{ $submission->message }}<br>
                                <strong>Status:</strong>
                                <span
                                    class="badge
                                    @if ($submission->status === 'pending') bg-warning
                                    @elseif($submission->status === 'disetujui') bg-success
                                    @elseif($submission->status === 'ditolak') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($submission->status) }}
                                </span><br>
                                <small class="text-muted">Pengajuan dibuat pada
                                    {{ $submission->created_at->format('d M Y') }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
