@php
    if (empty($user)) {
        $user = new App\Models\User([
            'enabled' => true,
        ]);
    }
@endphp

<input type="hidden" name="form" value="user">

<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="user-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autofocus class="form-control @error('name') is-invalid @enderror" id="user-name" name="name" required value="{{ old('name', $user->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="user-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input class="form-control @error('email') is-invalid @enderror" id="user-email" name="email" type="email" required value="{{ old('email', $user->email) }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="user-password">
        {{ __('Password') }}
        @if (!$user->exists)
            <span class="text-danger">&ast;</span>
        @endif
    </label>
    <div class="col-sm-8 col-md-4">
        <div class="mb-3 mb-md-0">
            <input class="form-control @error('password') is-invalid @enderror" id="user-password" name="password" type="password" @if (!$user->exists) required @endif>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">{{ __('Choose a strong and secure one.') }}</small>
        </div>
    </div>
    <div class="col-sm-8 col-md-4 offset-sm-4 offset-md-0">
        <!--suppress HtmlFormInputWithoutLabel -->
        <input class="form-control" id="user-password-confirmation" name="password_confirmation" type="password" @if (!$user->exists) required @endif>
        <small class="form-text text-muted">{{ __('The new password, once more.') }}</small>
    </div>
</div>
@can('viewAny', App\Models\Role::class)
    @php
        $roles = App\Models\Role::all();
        $old_roles = old('roles', $user->roles()->pluck('id'));
        if (empty($old_roles)) {
            $old_roles = collect();
        } else if (is_array($old_roles)) {
            $old_roles = collect($old_roles);
        }
    @endphp
    <div class="row mb-3">
        <label class="col-sm-4 col-form-label" for="user-roles">{{ __('Roles') }}</label>
        <div class="col-sm-8">
            <select class="form-select @error('roles') is-valid @enderror" data-widget="dropdown" id="user-roles" multiple name="roles[]">
                @foreach($roles as $role)
                    <option value="{{ $role->getKey() }}" @if ($old_roles->contains($role->getKey())) selected @endif>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endcan
@php
    $old_enabled = old('form') === 'user' ? old('enabled') : $user->enabled;
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="user-enabled">{{ __('Enabled?') }}</label>
    <div class="col-sm-8">
        <div class="form-check form-switch mt-sm-2">
            <input class="form-check-input @error('enabled') is-invalid @enderror" id="user-enabled" name="enabled" type="checkbox" role="switch" value="1" @if ($user->enabled) checked @endif>
            <label class="form-check-label" for="user-enabled">{{ __('Yes') }}</label>
        </div>
        @error('enabled')
            <div class="invalid-feedback d-inline-block">{{ $message }}</div>
        @enderror
    </div>
</div>
