@extends('layouts.app')

@section('content')
    <div class="container">

        <h2>Issue #{{ $issue->id }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h4>Machine: {{ $issue->machine->type }} ({{ $issue->machine->serial_number }})</h4>
                <p><strong>Customer:</strong> {{ $issue->machine->customer->name }}</p>
                <p><strong>Reported at:</strong> {{ $issue->reported_at }}</p>
                <p><strong>Status:</strong> {{ $issue->status }}</p>
                <p><strong>Description:</strong> {{ $issue->description }}</p>
            </div>
        </div>

        <h3>Action Log</h3>

        <table class="table table-striped mb-4">
            <thead>
            <tr>
                <th>Date</th>
                <th>Technician</th>
                <th>Action</th>
                <th>Result</th>
                <th>Solution?</th>
            </tr>
            </thead>
            <tbody>
            @foreach($issue->actions as $action)
                <tr>
                    <td>{{ $action->action_date }}</td>
                    <td>{{ $action->technician->name ?? '—' }}</td>
                    <td>{{ $action->action_description }}</td>
                    <td>{{ $action->result }}</td>
                    <td>{{ $action->is_solution ? '✔️' : '❌' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Add New Action</h3>

        <form action="{{ route('issues.actions.add', $issue->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Technician ID</label>
                <input type="number" name="technician_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Action Description</label>
                <textarea name="action_description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Result</label>
                <textarea name="result" class="form-control"></textarea>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_solution" value="1" class="form-check-input">
                <label class="form-check-label">This solved the issue</label>
            </div>

            <button class="btn btn-primary">Add Action</button>
        </form>

        <hr class="mt-5">

        <h3>Previous Issues for this Machine</h3>

        <ul>
            @foreach($history as $old)
                <li>
                    <a href="{{ route('issues.show', $old->id) }}">
                        Issue #{{ $old->id }} — {{ $old->reported_at }} — {{ $old->status }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
