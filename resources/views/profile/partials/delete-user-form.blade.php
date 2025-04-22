<form method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('DELETE')

    <p class="text-danger">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>

    <div class="form-group mt-3">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="Enter your password"
            required>
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-danger">
            {{ __('Delete Account') }}
        </button>
    </div>
</form>
