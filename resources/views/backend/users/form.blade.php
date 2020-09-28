@php
    if (empty($user)) {
        $user = new App\User([
            'role' => 'staff',
            'enabled' => true,
        ]);
    }
@endphp

<input type="hidden" name="form" value="user">
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="user-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autofocus class="form-control @error('name') is-invalid @enderror" id="user-name" name="name" required value="{{ old('name', $user->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="user-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input class="form-control @error('email') is-invalid @enderror" id="user-email" name="email" type="email" required value="{{ old('email', $user->email) }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="user-password">
        {{ __('Password') }}
        @if (!$user->exists)
            <span class="text-danger">&ast;</span>
        @endif
    </label>
    <div class="col-sm-8">
        <input class="form-control @error('password') is-invalid @enderror" id="user-password" name="password" type="password" @if (!$user->exists) required @endif>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="user-password-confirmation">
        {{ __('Confirm password') }}
        @if (!$user->exists)
            <span class="text-danger">&ast;</span>
        @endif
    </label>
    <div class="col-sm-8">
        <input class="form-control" id="user-password-confirmation" name="password_confirmation" type="password" @if (!$user->exists) required @endif>
    </div>
</div>
@php
    $old_role = old('role', $user->role);
@endphp
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="user-role-admin">{{ __('Role') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <div class="custom-control custom-radio">
            <input class="custom-control-input" id="user-role-none" name="role" type="radio" value="" @if (empty($old_role)) checked @endif>
            <label class="custom-control-label" for="user-role-none">{{ __('None') }}</label>
        </div>
        @foreach(config('fixtures.roles') as $id => $name)
            <div class="custom-control custom-radio">
                <input class="custom-control-input" id="user-role-{{ $id }}" name="role" type="radio" value="{{ $id }}" @if ($old_role === $id) checked @endif>
                <label class="custom-control-label" for="user-role-{{ $id }}">{{ $name }}</label>
            </div>
        @endforeach
    </div>
</div>
@php
    $old_enabled = old('form') === 'user' ? old('enabled') : $user->enabled;
@endphp
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="user-enabled">{{ __('Enabled?') }}</label>
    <div class="col-sm-8">
        <div class="custom-control custom-switch mt-sm-2">
            <input class="custom-control-input @error('enabled') is-invalid @enderror" id="user-enabled" type="checkbox" name="enabled" value="1" @if ($old_enabled) checked @endif>
            <label class="custom-control-label" for="user-enabled">{{ __('Yes') }}</label>
            @error('enabled')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
