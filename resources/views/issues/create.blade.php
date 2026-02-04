@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Create Issue</h1>

    <form method="POST" action="{{ route('issues.store') }}">
        @csrf
        @include('issues._form')
        <button class="mt-4 bg-yellow-500 text-white px-4 py-2 rounded">
            Save
        </button>
    </form>
</div>
@endsection
