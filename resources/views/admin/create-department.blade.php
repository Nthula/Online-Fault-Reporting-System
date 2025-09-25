<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                    {{ __('Create New Department') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Add a new department to manage maintenance requests</p>
            </div>
            <a href="{{ route('admin.departments') }}" class="flex items-center space-x-1 text-red-600 hover:text-red-800 transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Departments</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900">Department Details</h3>
                        <p class="mt-1 text-sm text-gray-500">Fill in the information for the new department</p>
                    </div>

                    <form method="POST" action="{{ route('admin.departments.store') }}" class="space-y-8">
                        @csrf
                    
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Department Name -->
                            <div>
                                <x-input-label for="name" value="{{ __('Department Name') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="name" 
                                        class="block w-full pl-10 text-gray-900" 
                                        type="text" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        required 
                                        autofocus 
                                        placeholder="Maintenance Department"
                                    />
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                    
                            <!-- Department Manager -->
                            <div>
                                <x-input-label for="manager" value="{{ __('Department Manager') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    @php
                                        $managers = $users->where('role', 'manager');
                                    @endphp
                                    <select 
                                        name="manager" 
                                        id="manager" 
                                        class="block w-full pl-3 pr-10 py-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 appearance-none bg-white bg-[url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e")] bg-no-repeat bg-right-2 bg-[length:1.5rem]"
                                        required
                                    >
                                        @if($managers->isNotEmpty())
                                            <option value="">Select a Manager</option>
                                            @foreach($managers as $manager)
                                                <option value="{{ $manager->id }}" {{ old('manager') == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name }} ({{ $manager->email }})
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">No Managers Available</option>
                                        @endif
                                    </select>
                                </div>
                                @error('manager')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($managers->isEmpty())
                                    <p class="mt-2 text-sm text-amber-600">
                                        No managers available. <a href="{{ route('admin.users.create') }}" class="font-medium underline hover:text-amber-700">Create a manager</a> first.
                                    </p>
                                @endif
                            </div>

                            <!-- Department Category Type -->
                            <div>
                                <x-input-label for="category_type" value="{{ __('Fault Category Type') }}" class="text-gray-700 mb-2" />
                                <div class="relative">
                                    <select 
                                        name="category_type" 
                                        id="category_type" 
                                        class="block w-full pl-3 pr-10 py-2.5 text-gray-900 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 appearance-none bg-white bg-[url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e")] bg-no-repeat bg-right-2 bg-[length:1.5rem]"
                                        required
                                    >
                                        <option value="">Select Category Type</option>
                                        <option value="plumbing" {{ old('category_type') == 'plumbing' ? 'selected' : '' }}>Plumbing</option>
                                        <option value="electrical" {{ old('category_type') == 'electrical' ? 'selected' : '' }}>Electrical</option>
                                        <option value="carpentry" {{ old('category_type') == 'carpentry' ? 'selected' : '' }}>Carpentry</option>
                                        <option value="security" {{ old('category_type') == 'security' ? 'selected' : '' }}>Security</option>
                                        <option value="cleaning" {{ old('category_type') == 'cleaning' ? 'selected' : '' }}>Cleaning/Sanitation</option>
                                        <option value="grounds" {{ old('category_type') == 'grounds' ? 'selected' : '' }}>Grounds & Landscaping</option>
                                        <option value="appliance" {{ old('category_type') == 'appliance' ? 'selected' : '' }}>Appliance Repair</option>
                                        <option value="network" {{ old('category_type') == 'network' ? 'selected' : '' }}>Internet/Network</option>
                                        <option value="other" {{ old('category_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                @error('category_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" value="{{ __('Department Description') }}" class="text-gray-700 mb-2" />
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    rows="4" 
                                    class="block w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 text-gray-900"
                                    placeholder="Brief description of the department's responsibilities"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="flex justify-end space-x-4 pt-8 border-t border-gray-100">
                            <a href="{{ route('admin.departments') }}" class="px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-700 text-white font-medium hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 shadow-md hover:shadow-lg">
                                Create Department
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>