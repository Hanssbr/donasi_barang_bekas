<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="name">{{ __('Name') }}</label>
        <input id="name" name="name" type="text" class="form-control"
            value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name">
    </div>

    <div class="form-group mt-3">
        <label for="email">{{ __('Email') }}</label>
        <input id="email" name="email" type="email" class="form-control"
            value="{{ old('email', auth()->user()->email) }}" required autocomplete="username">
    </div>

    {{-- Upload Foto --}}
    <div class="form-group mt-3">
        <label for="photo">Foto Profil</label>
        <input id="photo" name="photo" type="file" class="form-control" accept="image/*">

        @if (auth()->user()->photo)
            <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="mt-2 rounded-circle" width="100">
        @endif
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Save') }}
        </button>
    </div>
</form>
