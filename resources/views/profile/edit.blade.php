@extends('layouts.lte')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Profile') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Update Profile Information --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Update Profile Information') }}</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Update Password') }}</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-danger">{{ __('Delete Account') }}</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </section>
@endsection
