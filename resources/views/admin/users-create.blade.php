<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Create New User') }}
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
                        <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Fill in the details for the new user account.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-8">
                        @csrf
                    
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" value="{{ __('Full Name') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="name" 
                                        class="block w-full pl-10 text-gray-900" 
                                        type="text" 
                                        name="name" 
                                        required 
                                        autofocus 
                                        placeholder="John Doe"
                                    />
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                    
                            <!-- Email -->
                            <div>
                                <x-input-label for="email" value="{{ __('Email Address') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="email" 
                                        class="block w-full pl-10 text-gray-900" 
                                        type="email" 
                                        name="email" 
                                        required 
                                        placeholder="john@example.com"
                                    />
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                    
                            <!-- Password -->
                            <div>
                                <x-input-label for="password" value="{{ __('Password') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="password" 
                                        class="block w-full pl-10 text-gray-900" 
                                        type="password" 
                                        name="password" 
                                        required 
                                        placeholder="••••••••"
                                    />
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Minimum 8 characters</p>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                    
                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="password_confirmation" 
                                        class="block w-full pl-10 text-gray-900" 
                                        type="password" 
                                        name="password_confirmation" 
                                        required 
                                        placeholder="••••••••"
                                    />
                                </div>
                            </div>

                            <!-- Block/Room Dropdown -->
                            <div>
                                <x-input-label for="block" value="{{ __('Block/Room') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <select 
                                        id="block" 
                                        name="block" 
                                        class="block w-full pl-3 pr-10 py-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 appearance-none bg-white bg-[url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e")] bg-no-repeat bg-right-2 bg-[length:1.5rem]"
                                        required
                                    >
                                        <option value="">Select Block</option>
                                        <option value="Block 471">Block 471</option>
                                        <option value="Block 472">Block 472</option>
                                        <option value="Block 473">Block 473</option>
                                        <option value="Block 474">Block 474</option>
                                        <option value="Block 475">Block 475</option>
                                        <option value="Block 476">Block 476</option>
                                        <option value="Block 478">Block 478</option>
                                        <option value="Block 479">Block 479</option>
                                        <option value="Block 480">Block 480</option>
                                        <option value="Admin Block">Admin Block</option>
                                        <option value="Maintenance Block">Maintenance Block</option>
                                    </select>
                                </div>
                                @error('block')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                    
                            <!-- Role -->
                            <div>
                                <x-input-label for="role" value="{{ __('Role') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <select 
                                        name="role" 
                                        id="role" 
                                        class="block w-full pl-3 pr-10 py-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 appearance-none bg-white bg-[url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e")] bg-no-repeat bg-right-2 bg-[length:1.5rem]"
                                        required 
                                        onchange="toggleDepartmentField()"
                                    >
                                        <option value="student">Student</option>
                                        <option value="assistant">RA (Resident Assistant)</option>
                                        <option value="manager">Department Manager</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-700 text-white font-medium hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 shadow-md hover:shadow-lg">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDepartmentField() {
            const role = document.getElementById('role').value;
                    }
    </script>
</x-app-layout>