@extends('layouts.app')

@section('title', 'Klant Details – ' . $customer->name)

@section('content')
    <div class="min-h-screen pt-20 pb-12 px-6 lg:px-8" style="background-color: #FFFBEA;">

        <div class="max-w-7xl mx-auto">

            <!-- Terug knop -->
            <div class="mb-6">
                <a href="{{ route('customers.index') }}" class="text-yellow-600 hover:text-yellow-700 font-semibold text-lg">
                    ← Terug naar Klanten
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md mb-6">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">✅</span>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- KLANT HEADER -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6 border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl font-extrabold text-gray-900">{{ $customer->name }}</h1>
                        <div class="mt-3 space-y-1 text-gray-700">
                            <p>📧 {{ $customer->email }}</p>
                            @if($customer->phone)
                                <p>📞 {{ $customer->phone }}</p>
                            @endif
                            @if($customer->address)
                                <p>📍 {{ $customer->address }}</p>
                            @endif
                            <p>👤 {{ $customer->contact_person }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                    <span class="px-4 py-2 {{ $customer->getFunnelStageColor() }} text-white text-lg rounded-full inline-block">
                        {{ $customer->getFunnelStageIcon() }} {{ $customer->getFunnelStageLabel() }}
                    </span>
                        @if(isset($customer->assignedUser) && $customer->assignedUser)
                            <div class="mt-3 text-sm text-gray-600">
                                Accountmanager: <strong>{{ $customer->assignedUser->name }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TABS -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">

                <!-- Tab Headers -->
                <div class="border-b border-gray-200">
                    <nav class="flex">
                        <button onclick="showTab('sales-funnel')" id="tab-sales-funnel"
                                class="tab-button px-8 py-4 text-sm font-semibold border-b-2 border-transparent hover:border-yellow-500 transition">
                            📊 Sales Funnel
                        </button>
                        <button onclick="showTab('info')" id="tab-info"
                                class="tab-button px-8 py-4 text-sm font-semibold border-b-2 border-transparent hover:border-yellow-500 transition">
                            ℹ️ Klantgegevens
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-8">

                    <!-- TAB 1: SALES FUNNEL -->
                    <div id="content-sales-funnel" class="tab-content">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- Linker kolom: Acties -->
                            <div class="space-y-6">

                                <!-- Stadium Wijzigen -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Stadium Wijzigen</h3>
                                    <form action="{{ route('customers.update-stage', $customer->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="funnel_stage" class="w-full border-gray-300 rounded p-2 mb-3">
                                            <option value="lead" {{ $customer->funnel_stage == 'lead' ? 'selected' : '' }}>🔍 Lead</option>
                                            <option value="prospect" {{ $customer->funnel_stage == 'prospect' ? 'selected' : '' }}>💼 Prospect</option>
                                            <option value="quote_sent" {{ $customer->funnel_stage == 'quote_sent' ? 'selected' : '' }}>📄 Offerte Verstuurd</option>
                                            <option value="customer" {{ $customer->funnel_stage == 'customer' ? 'selected' : '' }}>✅ Klant</option>
                                            <option value="delivered" {{ $customer->funnel_stage == 'delivered' ? 'selected' : '' }}>🚚 Geleverd</option>
                                        </select>
                                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow transition">
                                            Stadium Opslaan
                                        </button>
                                    </form>
                                </div>

                                <!-- Accountmanager Toewijzen -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Accountmanager</h3>
                                    <form action="{{ route('customers.update-assignment', $customer->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="assigned_to" class="w-full border-gray-300 rounded p-2 mb-3">
                                            <option value="">Niet toegewezen</option>
                                            @foreach($accountManagers as $manager)
                                                <option value="{{ $manager->id }}" {{ $customer->assigned_to == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow transition">
                                            Toewijzen
                                        </button>
                                    </form>
                                </div>

                                <!-- Nieuwe Activiteit -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Nieuwe Activiteit</h3>
                                    <form action="{{ route('customers.add-activity', $customer->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                            <select name="activity_type" class="w-full border-gray-300 rounded p-2" required>
                                                <option value="call">📞 Telefoongesprek</option>
                                                <option value="email">📧 Email</option>
                                                <option value="meeting">🤝 Afspraak</option>
                                                <option value="quote">📄 Offerte</option>
                                                <option value="order">🛒 Bestelling</option>
                                                <option value="note">📝 Notitie</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Titel</label>
                                            <input type="text" name="title" class="w-full border-gray-300 rounded p-2" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Beschrijving</label>
                                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded p-2"></textarea>
                                        </div>
                                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg shadow transition">
                                            Activiteit Toevoegen
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <!-- Rechter kolom: Tijdlijn -->
                            <div class="lg:col-span-2">
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Activiteiten Tijdlijn</h3>

                                    @if(isset($customer->activities) && $customer->activities->count() > 0)
                                        <div class="space-y-4">
                                            @foreach($customer->activities as $activity)
                                                <div class="border-l-4 {{ $activity->activity_type == 'stage_change' ? 'border-purple-500' : 'border-blue-500' }} pl-4 pb-4 bg-white p-3 rounded">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <span class="text-2xl mr-2">{{ $activity->getActivityTypeIcon() }}</span>
                                                            <span class="font-semibold text-lg">{{ $activity->title }}</span>
                                                            <span class="ml-2 text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">
                                                            {{ $activity->getActivityTypeLabel() }}
                                                        </span>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $activity->created_at->format('d-m-Y H:i') }}
                                                        </div>
                                                    </div>
                                                    @if($activity->description)
                                                        <p class="text-gray-700 ml-10">{{ $activity->description }}</p>
                                                    @endif
                                                    @if(isset($activity->creator) && $activity->creator)
                                                        <div class="text-xs text-gray-500 ml-10 mt-1">
                                                            Door: {{ $activity->creator->name }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-center py-8">Nog geen activiteiten geregistreerd.</p>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- TAB 2: KLANTGEGEVENS -->
                    <div id="content-info" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Naam</h3>
                                <p class="text-gray-700">{{ $customer->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Email</h3>
                                <p class="text-gray-700">{{ $customer->email }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Telefoon</h3>
                                <p class="text-gray-700">{{ $customer->phone ?? 'Niet beschikbaar' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Adres</h3>
                                <p class="text-gray-700">{{ $customer->address ?? 'Niet beschikbaar' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Contactpersoon</h3>
                                <p class="text-gray-700">{{ $customer->contact_person }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">IBAN</h3>
                                <p class="text-gray-700">{{ $customer->iban ?? 'Niet beschikbaar' }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Contract Type</h3>
                                <p class="text-gray-700">{{ $customer->contract_type }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Status</h3>
                                <p class="text-gray-700">{{ $customer->status }}</p>
                            </div>

                            <!-- Link naar oude documenten pagina -->
                            <div class="md:col-span-2 mt-4">
                                <a href="{{ route('documents.index', $customer->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                                    📄 Bekijk Documenten
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-yellow-500', 'text-yellow-600');
                button.classList.add('border-transparent', 'text-gray-600');
            });

            document.getElementById('content-' + tabName).classList.remove('hidden');

            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.add('border-yellow-500', 'text-yellow-600');
            activeButton.classList.remove('border-transparent');
        }

        window.addEventListener('DOMContentLoaded', () => {
            showTab('sales-funnel');
        });
    </script>
@endsection
