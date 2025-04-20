@extends('layouts.lte')
@section('title-content', 'Permintaan Barang')

@section('content')
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">Keterangan Permintaan Barang</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        @if (Auth::id() !== $item->user_id)
            <form action="{{ route('submissions.store', $item->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="message" class="form-label">Pesan Permintaan</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="Mengapa Anda ingin item ini?"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Ajukan Permintaan</button>
            </form>
        @endif
        <!--end::Form-->
    </div>
@endsection
