@extends('layouts.app')

@section('title', 'Klantdossier – ' . $customer->name)

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start pt-20 pb-12 px-6 lg:px-8" style="background-color: #FFFBEA;">

    <!-- Titel -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900">Klantdossier</h1>
        <p class="mt-2 text-gray-700 text-lg">
            Dossier van <span class="font-semibold">{{ $customer->name }}</span>.
            Upload documenten, bekijk bestanden en controleer ontbrekende gegevens.
        </p>
    </div>

    <!-- Container -->
    <div class="bg-white rounded-xl shadow-lg w-full max-w-6xl border border-gray-100 p-8 space-y-10">

        {{-- Flash message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Ontbrekende gegevens -->
        @if(count($missing) > 0)
            <div class="bg-red-100 border border-red-300 text-red-800 px-6 py-5 rounded-lg shadow-sm">
                <h2 class="text-2xl font-semibold mb-3">Ontbrekende gegevens</h2>
                <p class="mb-2 text-gray-800">De volgende velden ontbreken in het klantdossier:</p>
                <ul class="list-disc pl-6 text-gray-800">
                    @foreach($missing as $field)
                        <li>{{ ucfirst(str_replace('_', ' ', $field)) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Document upload -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Document uploaden</h2>

            <form method="POST" action="{{ route('documents.store', $customer->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Bestand</label>
                    <input type="file"
                           name="document"
                           class="block w-full border-gray-300 rounded-md shadow-sm bg-white
                                  focus:ring-yellow-500 focus:border-yellow-500"
                           required>
                </div>

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-5 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 transition">
                    Uploaden
                </button>
            </form>
        </div>

        <!-- Documentenlijst -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Documenten</h2>

            @if(count($files) === 0)
                <p class="text-gray-700">Er zijn nog geen documenten voor deze klant.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Bestand
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Geüpload op
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Acties
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($files as $file)
                                <tr class="hover:bg-yellow-50 transition-colors">
                                    <td class="px-6 py-4 text-gray-800 font-medium">
                                        {{ basename($file) }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700">
                                        {{ date('d-m-Y H:i', Storage::disk('public')->lastModified($file)) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-3">

                                            <!-- Download -->
                                            <a href="{{ asset('storage/'.$file) }}"
                                               download
                                               class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition text-sm">
                                                Download
                                            </a>

                                            <!-- Verwijderen -->
                                            <form action="{{ route('documents.destroy', [$customer->id, basename($file)]) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition text-sm">
                                                    Verwijderen
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
