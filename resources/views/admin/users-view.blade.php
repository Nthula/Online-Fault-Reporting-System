<!-- filepath: c:\Users\Wangu\Herd\FaultManagementSystem\resources\views\admin\users-view.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('View User') }}
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
                        <h3 class="text-lg font-medium text-gray-900">User Details</h3>
                        <p class="mt-1 text-sm text-gray-500">Below are the details of the selected user.</p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Full Name</h4>
                            <p class="text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Email Address</h4>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Block/Room</h4>
                            <p class="text-gray-900">{{ $user->residence }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700">Role</h4>
                            <p class="text-gray-900 capitalize">{{ $user->role }}</p>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium hover:from-blue-700 hover:to-blue-800">
                            Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>