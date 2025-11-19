@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Assign Roles to Users</h1>

        @foreach ($users as $user)
            <form action="{{ route('roles.assign.save', $user->id) }}" method="POST" class="mb-4 p-3 border rounded">
                @csrf

                <h3>{{ $user->name }} ({{ $user->email }})</h3>

                <div class="mb-3">
                    @foreach ($roles as $role)
                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"{{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>

                <button class="btn btn-primary">Save</button>
            </form>
        @endforeach
    </div>
@endsection
