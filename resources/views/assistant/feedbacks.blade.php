<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maintenance Feedbacks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Feedback List</h3>

                    @if($feedbacks->isEmpty())
                        <p class="text-gray-500">No feedbacks available.</p>
                    @else
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Reporter</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Block/Room Number</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Feedback</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Student Validation</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Date Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feedbacks as $feedback)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $feedback->report->user->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $feedback->report->user->residence }} {{ "/"}} {{ $feedback->report->room_number }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $feedback->comments }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $feedback->student_validation ? 'Validated' : 'Not Validated' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $feedback->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
