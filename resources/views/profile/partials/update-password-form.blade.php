<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="current_password">{{ __('Current Password') }}</label>
        <input id="current_password" name="current_password" type="password" class="form-control" required autocomplete="current-password">
    </div>

    <div class="form-group mt-3">
        <label for="password">{{ __('New Password') }}</label>
        <input id="password" name="password" type="password" class="form-control" required autocomplete="new-password">
    </div>

    <div class="form-group mt-3">
        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Update Password') }}
        </button>
    </div>
</form>
