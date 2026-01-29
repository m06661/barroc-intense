@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Machines</h1>

        <table class="w-full border">
            <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Type</th>
                <th class="p-2 border">Serial</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Customer</th>
            </tr>
            </thead>
            <tbody>
            @foreach($machines as $machine)
                <tr>
                    <td class="p-2 border">{{ $machine->type }}</td>
                    <td class="p-2 border">{{ $machine->serial_number }}</td>
                    <td class="p-2 border">{{ $machine->status }}</td>
                    <td class="p-2 border">
                        {{ $machine->customer->name ?? '—' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
