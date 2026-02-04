<div class="space-y-4">

    {{-- Machine --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Machine
        </label>
        <select name="machine_id"
                class="w-full border-gray-300 rounded p-2"
                required>
            <option value="">Select a machine</option>
            @foreach($machines as $machine)
                <option value="{{ $machine->id }}"
                    {{ old('machine_id', $issue->machine_id ?? '') == $machine->id ? 'selected' : '' }}>
                    {{ $machine->type }}
                    ({{ $machine->serial_number }})
                    – {{ $machine->customer->name }}
                </option>
            @endforeach
        </select>
        @error('machine_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Priority --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Priority
        </label>
        <select name="priority"
                class="w-full border-gray-300 rounded p-2"
                required>
            @foreach(['normal', 'low', 'medium', 'high'] as $prio)
                <option value="{{ $prio }}"
                    {{ old('priority', $issue->priority ?? 'normal') == $prio ? 'selected' : '' }}>
                    {{ ucfirst($prio) }}
                </option>
            @endforeach
        </select>
        @error('priority')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    @if(isset($issue))
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Status
        </label>
        <select name="status"
                class="w-full border-gray-300 rounded p-2"
                required>
            @foreach(['open', 'in progress', 'resolved'] as $state)
                <option value="{{ $state }}"
                    {{ old('status', $issue->status) == $state ? 'selected' : '' }}>
                    {{ ucfirst($state) }}
                </option>
            @endforeach
        </select>
    </div>
    @endif


    {{-- Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Description
        </label>
        <textarea name="description"
                  rows="4"
                  class="w-full border-gray-300 rounded p-2"
                  required>{{ old('description', $issue->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>
