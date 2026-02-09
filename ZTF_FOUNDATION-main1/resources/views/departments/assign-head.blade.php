@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Assigner un Chef au Département</h2>
        
        <form action="{{ route('departments.assign.head') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="mb-4">
                <label for="department" class="block text-gray-700 text-sm font-bold mb-2">
                    Sélectionner le département
                </label>
                <select name="department_id" id="department" class="w-full border rounded-md py-2 px-3">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">
                            {{ $department->name }}
                            @if($department->head_id)
                                (Chef actuel: {{ $department->head->name ?? 'Non défini' }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="head" class="block text-gray-700 text-sm font-bold mb-2">
                    Sélectionner le nouveau chef
                </label>
                <select name="head_id" id="head" class="w-full border rounded-md py-2 px-3">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} ({{ $user->matricule }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Assigner comme Chef
                </button>
            </div>
        </form>

        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold mb-4">Chefs de Département Actuels</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Département
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Chef Actuel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date d'assignation
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($departments as $department)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $department->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ optional($department->head)->matricule ?? 'Non assigné' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($department->head_assigned_at && $department->head_assigned_at instanceof \DateTime)
                                    {{ $department->head_assigned_at->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($department->head_id)
                                    <form action="{{ route('departments.remove.head', $department->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Retirer
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection