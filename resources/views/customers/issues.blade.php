@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Storingshistorie – {{ $customer->name }}</h2>

    <p>
        <strong>Totaal storingen:</strong> {{ $stats['total'] }} <br>
        <strong>Laatste 30 dagen:</strong> {{ $stats['last_30_days'] }}
    </p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Machine</th>
            <th>Datum</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($issues as $issue)
            <tr>
                <td>{{ $issue->id }}</td>
                <td>{{ $issue->machine->type }} ({{ $issue->machine->serial_number }})</td>
                <td>{{ $issue->reported_at }}</td>
                <td>{{ $issue->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
