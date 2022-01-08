@php
    if (empty($role)) {
        $role = new App\Role();
    }
@endphp

<input type="hidden" name="form" value="role">
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="role-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autofocus class="form-control @error('name') is-invalid @enderror" id="role-name" name="name" required value="{{ old('name', $role->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
@php
    $permissions = Spatie\Permission\Models\Permission::query()->get();
    $old_permissions = old('permissions', $role->permissions->pluck('id'));
    if (empty($old_permissions)) {
        $old_permissions = collect();
    } else if (is_array($old_permissions)) {
        $old_permissions = collect($old_permissions);
    }
@endphp
<div class="form-group row">
    <label class="col-sm-4 col-form-label">{{ __('Permissions') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <div class="mt-sm-2">
            @php
                $subset = $permissions->filter(function ($permission) {
                    return stripos($permission->name, 'user');
                });
            @endphp
            @foreach ($subset as $permission)
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="role-permission-{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->id }}" @if ($old_permissions->contains($permission->id)) checked @endif>
                    <label class="custom-control-label" for="role-permission-{{ $permission->id }}">{{ $permission->name }}</label>
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
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="role-permission-{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->id }}" @if ($old_permissions->contains($permission->id)) checked @endif>
                    <label class="custom-control-label" for="role-permission-{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
        @error('permissions')
            <div class="is-invalid" style="display: none;"></div>
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
