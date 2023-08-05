@php
    if (empty($role)) {
        $role = new App\Models\Role();
    }
@endphp

<input type="hidden" name="form" value="role">

<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="role-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autofocus class="form-control @error('name') is-invalid @enderror" id="role-name" name="name" required value="{{ old('name', $role->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
@php
    $permissions = Spatie\Permission\Models\Permission::all();
    $old_permissions = old('permissions', $role->permissions()->pluck('id'));
    if (empty($old_permissions)) {
        $old_permissions = collect();
    } else if (is_array($old_permissions)) {
        $old_permissions = collect($old_permissions);
    }
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label">{{ __('Permissions') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <div class="mt-sm-2">
            @php
                $subset = $permissions->filter(function ($permission) {
                    return stripos($permission->name, 'user');
                });
            @endphp
            @foreach ($subset as $permission)
                <div class="form-check">
                    <input class="form-check-input" id="role-permission-{{ $permission->getKey() }}" name="permissions[]" type="checkbox" role="switch" value="{{ $permission->getKey() }}" @if ($old_permissions->contains($permission->getKey())) checked @endif>
                    <label class="form-check-label" for="role-permission-{{ $permission->getKey() }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="mt-sm-2">
            @php
                $subset = $permissions->filter(function ($permission) {
                    return stripos($permission->name, 'role');
                });
            @endphp
            @foreach ($subset as $permission)
                <div class="form-check">
                    <input class="form-check-input" id="role-permission-{{ $permission->getKey() }}" name="permissions[]" type="checkbox" role="switch" value="{{ $permission->getKey() }}" @if ($old_permissions->contains($permission->getKey())) checked @endif>
                    <label class="form-check-label" for="role-permission-{{ $permission->getKey() }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
        @error('permissions')
            <div class="invalid-feedback d-inline-block">{{ $message }}</div>
        @enderror
    </div>
</div>
