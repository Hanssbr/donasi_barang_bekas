@extends('layouts.lte')
@section('title-content', 'Posting Barang')

@section('content')
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">Edit Barang</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            <!--begin::Body-->
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Barang</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{ $item->name }}" />
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <input type="category" class="form-control" id="category" name="category"
                        value="{{ $item->category }}" />
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="location" class="form-control" id="location" name="location"
                        value="{{ $item->location }}" />
                </div>
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Kondisi</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" id="condition_layak"
                                value="layak" {{ old('condition', $item->condition) == 'layak' ? 'checked' : '' }} />
                            <label class="form-check-label" for="condition_layak"> Layak </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" id="condition_rusak_ringan"
                                value="rusak ringan"
                                {{ old('condition', $item->condition) == 'rusak ringan' ? 'checked' : '' }} />
                            <label class="form-check-label" for="condition_rusak_ringan"> Rusak ringan </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" id="condition_rusak_berat"
                                value="rusak berat"
                                {{ old('condition', $item->condition) == 'rusak berat' ? 'checked' : '' }} />
                            <label class="form-check-label" for="condition_rusak_berat"> Rusak berat </label>
                        </div>
                    </div>
                </fieldset>
                <div class="input-group mb-3">
                    <span class="input-group-text">Description</span>
                    <textarea class="form-control" aria-label="With textarea" name="description" required>{{ $item->description }}</textarea>
                </div>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="photo" name="photo" />
                    <label class="input-group-text" for="photo">Upload</label>
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Posting</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
@endsection
