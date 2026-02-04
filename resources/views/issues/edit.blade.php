@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Issue</h1>

    <form method="POST" action="{{ route('issues.update', $issue) }}">
        @csrf
        @method('PUT')
        @include('issues._form')
        <button class="mt-4 bg-yellow-500 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
</div>
@endsection
