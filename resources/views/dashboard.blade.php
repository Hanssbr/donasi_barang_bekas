@extends('layouts.lte')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Welcome Back @if (Auth::user()->role === 'admin')
                            Admin
                        @endif {{ Auth::user()->name }}</h5>
                </div>
            @endsection
