@extends('layouts.lte')
@section('title-content', 'Posting Barang')

@section('content')
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">Keterangan Barang</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            <!--begin::Body-->
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Barang</label>
                    <input type="name" class="form-control" id="name" name="name" required />
                </div>
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Kategori</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="category" value="pakaian"
                                checked />
                            <label class="form-check-label" for="gridRadios1"> Pakaian </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="category"
                                value="elektronik" />
                            <label class="form-check-label" for="category"> Elektronik </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="category" value="buku" />
                            <label class="form-check-label" for="gridRadios2"> Buku </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="category" value="mainan" />
                            <label class="form-check-label" for="gridRadios2"> Mainan </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" id="category" value="lainnya" />
                            <label class="form-check-label" for="gridRadios2"> Lainnya </label>
                        </div>
                    </div>
                </fieldset>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="location" class="form-control" id="location" name="location" required />
                </div>
                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">Kondisi</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" id="condition" value="layak"
                                checked />
                            <label class="form-check-label" for="gridRadios1"> Layak </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" id="condition"
                                value="rusak ringan" />
                            <label class="form-check-label" for="condition"> Rusak ringan </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" id="condition"
                                value="rusak berat" />
                            <label class="form-check-label" for="gridRadios2"> Rusak berat </label>
                        </div>
                    </div>
                </fieldset>
                <div class="input-group mb-3">
                    <span class="input-group-text">Description</span>
                    <textarea class="form-control" aria-label="With textarea" name="description" required></textarea>
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
