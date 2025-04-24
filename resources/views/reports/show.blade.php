@extends('layouts.lte')

@section('title-content', 'Laporan Barang')

@section('content')

    <div class="container">
        <h3>Daftar Laporan Barang</h3>

        @if ($reports->isEmpty())
            <p>Tidak ada laporan barang.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Pelapor</th>
                        <th>Deskripsi Laporan</th>
                        <th>Tanggal Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->item->name }}</td>
                            <td>{{ $report->user->name }}</td>
                            <td>{{ $report->report }}</td>
                            <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
