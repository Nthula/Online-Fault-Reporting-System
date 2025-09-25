<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report a Fault') }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">Help us maintain your living space by reporting issues promptly</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Fault Details</h3>
                    <p class="mt-1 text-sm text-gray-600">Please provide accurate information to help us address your concern quickly</p>
                </div>
                
                <form method="POST" action="{{ route('assistant.reports.store') }}" enctype="multipart/form-data" class="p-8">
                    @csrf
                
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Issue Type Dropdown -->
                            <div class="space-y-2">
                                <x-input-label for="issue_type" value="{{ __('Issue Type *') }}" class="font-medium" />
                                <select id="issue_type" name="issue_type" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out py-2 px-3 border" required>
                                    <option value="" disabled selected>Select an issue type</option>
                                    <option value="Electrical" class="py-2">Electrical</option>
                                    <option value="Plumbing" class="py-2">Plumbing</option>
                                    <option value="HVAC" class="py-2">HVAC</option>
                                    <option value="Furniture" class="py-2">Furniture</option>
                                    <option value="Structural" class="py-2">Structural</option>
                                    <option value="Other" class="py-2">Other</option>
                                </select>
                                @error('issue_type')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <!-- Block Dropdown -->
                            <div class="space-y-2">
                                <x-input-label for="block" value="{{ __('Block *') }}" class="font-medium" />
                                <select id="block" name="block" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out py-2 px-3 border" required>
                                    <option value="" disabled selected>Select your block</option>
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
                                </select>
                                @error('block')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Room Number -->
                            <div class="space-y-2">
                                <x-input-label for="room_number" value="{{ __('Room Number *') }}" class="font-medium" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="room_number" name="room_number" placeholder="e.g. 205" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out py-2 px-3 border" required>
                                </div>
                                @error('room_number')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <x-input-label for="description" value="{{ __('Description *') }}" class="font-medium" />
                            <textarea id="description" name="description" rows="4" placeholder="Describe the issue in detail..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out py-2 px-3 border" required></textarea>
                            <p class="text-sm text-gray-500 mt-1">Be as specific as possible about the problem</p>
                            @error('description')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Image Upload -->
                        <div class="space-y-2">
                            <x-input-label for="image" value="{{ __('Upload Image (Optional)') }}" class="font-medium" />
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                </div>
                            </div>
                            @error('image')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                
                    <div class="flex justify-end mt-8 space-x-3">
                        <x-button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-800">
                            {{ __('Cancel') }}
                        </x-button>
                        <x-button class="bg-blue-600 hover:bg-blue-700 text-white shadow-lg shadow-blue-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Submit Report') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>