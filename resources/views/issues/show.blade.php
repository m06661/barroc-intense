@extends('layouts.app')

@section('content')




<div class="bg-yellow-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto flex justify-end gap-2 mb-6">
    <a href="{{ route('issues.edit', $issue) }}"
       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
        Edit
    </a>

    <form method="POST"
          action="{{ route('issues.destroy', $issue) }}">
        @csrf
        @method('DELETE')
        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                onclick="return confirm('Delete this issue?')">
            Delete
        </button>
    </form>
</div>

    <div class="max-w-5xl mx-auto space-y-8">

        <h1 class="text-4xl font-bold text-yellow-700">
            Issue #{{ $issue->id }}
        </h1>

        @if($frequency >= 3)
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded">
                ⚠ Deze machine heeft {{ $frequency }} storingen gehad in de afgelopen 30 dagen.
            </div>
        @endif

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">
                Storingsfrequentie (laatste 6 maanden)
            </h2>
            <canvas id="issueChart"
                    data-labels='@json($chartData->pluck("date"))'
                    data-data='@json($chartData->pluck("count"))'>
            </canvas>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Details</h2>

            <p><strong>Machine:</strong> {{ $issue->machine->type }} ({{ $issue->machine->serial_number }})</p>
            <p><strong>Customer:</strong> {{ $issue->machine->customer->name }}</p>
            <p><strong>Reported at:</strong> {{ $issue->reported_at }}</p>
            <p><strong>Status:</strong> {{ ucfirst($issue->status) }}</p>
            <p class="mt-2"><strong>Description:</strong><br>{{ $issue->description }}</p>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Action Log</h2>

            <table class="w-full border">
                <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Technician</th>
                    <th class="p-2 text-left">Action</th>
                    <th class="p-2 text-left">Result</th>
                    <th class="p-2 text-left">Solution</th>
                </tr>
                </thead>
                <tbody>
                @forelse($issue->actions as $action)
                    <tr class="border-t">
                        <td class="p-2">{{ $action->action_date }}</td>
                        <td class="p-2">{{ $action->technician->name ?? '—' }}</td>
                        <td class="p-2">{{ $action->action_description }}</td>
                        <td class="p-2">{{ $action->result }}</td>
                        <td class="p-2">{{ $action->is_solution ? '✔️' : '❌' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            Nog geen acties geregistreerd
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Add New Action</h2>

            <form action="{{ route('issues.actions.add', $issue->id) }}" method="POST" class="space-y-4">
                @csrf

                <select name="technician_id" required
                        class="w-full border rounded p-2">
                    <option value="">Select technician</option>
                    @foreach($technicians as $technician)
                        <option value="{{ $technician->id }}">
                            {{ $technician->name }}
                        </option>
                    @endforeach
                </select>


                <textarea name="action_description" required
                          class="w-full border rounded p-2"
                          placeholder="Action description"></textarea>

                <textarea name="result"
                          class="w-full border rounded p-2"
                          placeholder="Result"></textarea>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_solution" value="1">
                    This solved the issue
                </label>

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Add Action
                </button>
            </form>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">
                Previous Issues for this Machine
            </h2>

            <ul class="list-disc list-inside">
                @forelse($history as $old)
                    <li>
                        <a href="{{ route('issues.show', $old->id) }}"
                           class="text-yellow-700 hover:underline">
                            Issue #{{ $old->id }} — {{ $old->status }}
                        </a>
                    </li>
                @empty
                    <li class="text-gray-500">Geen eerdere issues</li>
                @endforelse
            </ul>
        </div>

    </div>
</div>
@endsection
