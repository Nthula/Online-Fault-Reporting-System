<!-- filepath: c:\Users\Wangu\Herd\FaultManagementSystem\resources\views\admin\users-edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('admin.users') }}" class="flex items-center space-x-1 text-red-600 hover:text-red-800 transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Users</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900">Edit User Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Update the details for the selected user account.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" value="{{ __('Full Name') }}" class="text-gray-700 mb-2" />
                                <x-text-input 
                                    id="name" 
                                    class="block w-full text-gray-900" 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}" 
                                    required 
                                />
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" value="{{ __('Email Address') }}" class="text-gray-700 mb-2" />
                                <x-text-input 
                                    id="email" 
                                    class="block w-full text-gray-900" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}" 
                                    required 
                                />
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Block/Room -->
                            <div>
                                <x-input-label for="residence" value="{{ __('Block/Room') }}" class="text-gray-700 mb-2" />
                                <select 
                                    id="residence" 
                                    name="residence" 
                                    class="block w-full text-gray-900 rounded-lg border-gray-300"
                                    required
                                >
                                    <option value="">Select Block</option>
                                    <option value="Block 471" {{ $user->residence == 'Block 471' ? 'selected' : '' }}>Block 471</option>
                                    <option value="Block 472" {{ $user->residence == 'Block 472' ? 'selected' : '' }}>Block 472</option>
                                    <!-- Add other blocks as needed -->
                                </select>
                                @error('residence')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <x-input-label for="role" value="{{ __('Role') }}" class="text-gray-700 mb-2" />
                                <select 
                                    id="role" 
                                    name="role" 
                                    class="block w-full text-gray-900 rounded-lg border-gray-300"
                                    required
                                >
                                    <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="assistant" {{ $user->role == 'assistant' ? 'selected' : '' }}>RA (Resident Assistant)</option>
                                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Department Manager</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-700 text-white font-medium hover:from-red-700 hover:to-red-800">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>