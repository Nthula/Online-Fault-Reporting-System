<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <div class="flex space-x-2">
                <form method="GET" action="{{ route('admin.users') }}" class="relative" id="searchForm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        placeholder="Search users..." 
                        value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 w-64"
                        x-on:input.debounce.500ms="$el.form.submit()"
                    >
                </form>
                <a href="{{ route('admin.users.create') }}" class="flex items-center space-x-1 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold py-2 px-4 rounded-full shadow-md hover:shadow-lg transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add User</span>
                </a>
                <!-- Import Students Button -->
                <button 
                    type="button" 
                    class="flex items-center space-x-1 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold py-2 px-4 rounded-full shadow-md hover:shadow-lg transition duration-200"
                    onclick="document.getElementById('importModal').classList.remove('hidden')"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Import Students</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="p-6">
                    <!-- Users Table -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 shadow-sm">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="text-xs text-white uppercase bg-gradient-to-r from-red-700 to-red-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium rounded-tl-xl">#</th>
                                    <th scope="col" class="px-6 py-4 font-medium">User</th>
                                    <th scope="col" class="px-6 py-4 font-medium">Email</th>
                                    <th scope="col" class="px-6 py-4 font-medium">Residence</th>
                                    <th scope="col" class="px-6 py-4 font-medium">Role</th>
                                    <th scope="col" class="px-6 py-4 font-medium rounded-tr-xl">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($users as $user)
                                <tr class="bg-white hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 text-gray-500 font-medium">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                                <span class="text-red-800 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                                <p class="text-sm text-gray-500">Joined {{ $user->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="mailto:{{ $user->email }}" class="text-red-600 hover:text-red-800 hover:underline">{{ $user->email }}</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->role == 'student' || $user->role == 'assistant')
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ $user->residence }}</span>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-800',
                                                'student' => 'bg-green-100 text-green-800',
                                                'assistant' => 'bg-yellow-100 text-yellow-800'
                                            ];
                                            $defaultColor = 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-3 py-1 text-xs rounded-full {{ $roleColors[$user->role] ?? $defaultColor }} capitalize">{{ $user->role }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <a 
                                                href="{{ route('admin.users.show', $user->id) }}" 
                                                class="text-blue-600 hover:text-blue-800 transition duration-150 flex items-center"
                                                title="View Details"
                                            >
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 transition duration-150" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" x-on:submit.prevent="if(confirm('Are you sure you want to delete this user?')) { $el.submit(); }">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition duration-150" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white">
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            <p class="text-xl font-medium">No users found</p>
                                            <p class="mt-1">@if(request('search'))Try a different search term @else Add your first user to get started @endif</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                            @if(request('search')) (filtered) @endif
                        </div>
                        <div class="flex space-x-1">
                            {{ $users->appends(['search' => request('search')]) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
<div 
    id="importModal" 
    class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50"
>
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">Import Students</h3>
            <button 
                class="text-gray-400 hover:text-gray-600 transition duration-150"
                onclick="document.getElementById('importModal').classList.add('hidden')"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.import.students') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="students_file" class="block text-sm font-medium text-gray-700">Upload SQL File</label>
                    <input 
                        type="file" 
                        name="students_file" 
                        id="students_file" 
                        accept=".sql" 
                        class="mt-2 block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        required
                    >
                </div>
                <div class="flex justify-end space-x-2">
                    <button 
                        type="button" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-md transition duration-200"
                        onclick="document.getElementById('importModal').classList.add('hidden')"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:shadow-lg transition duration-200"
                    >
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <style>
        .pagination .page-item.active .page-link {
            background-color: #991b1b;
            border-color: #991b1b;
            color: white;
        }
        .pagination .page-link {
            color: #991b1b;
            border-radius: 0.375rem;
            margin: 0 0.125rem;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
        }
        .pagination .page-link:hover {
            background-color: #f3f4f6;
        }
    </style>
</x-app-layout>