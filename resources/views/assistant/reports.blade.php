<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                    {{ __('Fault Reports') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Manage and validate all reported faults</p>
            </div>
            <div class="flex space-x-3">
                <form method="GET" action="{{ route('assistant.reports') }}" class="relative" id="searchForm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        placeholder="Search reports..." 
                        value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200 w-64 text-gray-700"
                        x-on:input.debounce.500ms="$el.form.submit()"
                    >
                </form>
                <a 
                    href="{{ route('assistant.reports.create') }}" 
                    class="flex items-center space-x-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium py-2 px-4 rounded-full shadow-md hover:shadow-lg transition duration-200"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>File New Fault</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="p-6">
                    <!-- Reports Table -->
                    <div class="overflow-hidden rounded-lg border border-gray-100 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="text-xs text-white uppercase bg-gradient-to-r from-red-700 to-red-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider rounded-tl-lg">
                                        #
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Issuer
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Residence
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Issue Type
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Fault Image
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Department
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Date Reported
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider rounded-tr-lg">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($reports as $report)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                        {{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-800 font-medium">{{ strtoupper(substr($report->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $report->user->name }}</div>
                                                @if($report->validated)
                                                <div class="text-xs text-green-600 flex items-center mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Validated by {{ $report->validator->name ?? 'Admin' }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $report->user->residence }} {{ "-"}} {{ $report->room_number }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $report->category ?? "N/A" }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($report->image)
                                            <a href="{{ Storage::url($report->image) }}" target="_blank" class="block">
                                                <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden border border-gray-200">
                                                    <img src="{{ Storage::url($report->image) }}" 
                                                         alt="Fault Image" 
                                                         class="h-full w-full object-cover hover:opacity-80 transition-opacity">
                                                </div>
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs italic">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $report->category ?? "N/A" }} Department</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $report->created_at->format('M d, Y H:i') ?? "N/A" }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                            {{ $report->status === 'solved' ? 'bg-green-100 text-green-800' : 
                                               ($report->validated ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $report->validated ? 'Validated' : ($report->status ?? "Pending") }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-4">
                                            @if(!$report->validated)
                                            <form 
                                                method="POST" 
                                                action="{{ route('assistant.reports.update', $report) }}" 
                                                class="inline"
                                            >
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="validate_report" value="1">
                                                <button 
                                                    type="submit" 
                                                    class="text-green-600 hover:text-green-800 transition duration-150 flex items-center"
                                                    title="Validate"
                                                >
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    {{-- Validate --}}
                                                </button>
                                            </form>
                                            @endif
                                            
                                            <a 
                                                href="{{ route('assistant.reports.show', $report->report_id) }}" 
                                                class="text-blue-600 hover:text-blue-800 transition duration-150 flex items-center"
                                                title="View Details"
                                            >
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{-- View --}}
                                            </a>

                                            @if($report->status === 'solved')
                                                <button 
                                                    data-feedback-button 
                                                    data-report-id="{{ $report->report_id }}" 
                                                    class="text-purple-600 hover:text-purple-800 transition duration-150 flex items-center"
                                                    title="Provide Feedback"
                                                >
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                    </svg>
                                                    {{-- Feedback --}}
                                                </button>
                                            @endif
                                            
                                            <form 
                                                method="POST" 
                                                action="{{ route('student.reports.destroy', $report) }}" 
                                                class="inline"
                                                x-on:submit.prevent="if(confirm('Are you sure you want to delete this report?')) { $el.submit() }"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="text-red-600 hover:text-red-800 transition duration-150 flex items-center"
                                                    title="Delete"
                                                >
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    {{-- Remove --}}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <h3 class="mt-2 text-lg font-medium text-gray-900">No reports found</h3>
                                            <p class="mt-1 text-sm text-gray-500">
                                                @if(request('search'))
                                                    No reports match your search criteria
                                                @else
                                                    No faults have been reported yet
                                                @endif
                                            </p>
                                            <div class="mt-6">
                                                <a href="{{ route('assistant.reports.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    File New Fault
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($reports->hasPages())
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} reports
                            @if(request('search')) (filtered) @endif
                        </div>
                        <div class="flex space-x-1">
                            {{ $reports->appends(['search' => request('search')])->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button" data-close-modal class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Provide Feedback
                        </h3>
                        <div class="mt-2">
                            <form id="feedbackForm" method="POST" action="{{ route('assistant.feedbacks.store') }}">
                                @csrf
                                <input type="hidden" name="report_id">
                                
                                <div class="mt-4">
                                    <label for="comments" class="block text-sm font-medium text-gray-700 text-left">Your Feedback</label>
                                    <textarea id="comments" name="comments" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required></textarea>
                                </div>
                                
                                <div class="mt-4 flex items-center">
                                    <input id="student_validation" name="student_validation" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" required>
                                    <label for="student_validation" class="ml-2 block text-sm text-gray-700">
                                        Confirm the issue has been resolved to your satisfaction
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" form="feedbackForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:col-start-2 sm:text-sm">
                        Submit Feedback
                    </button>
                    <button type="button" data-close-modal class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const feedbackModal = document.querySelector('#feedbackModal');
            const feedbackForm = document.querySelector('#feedbackForm');
            const closeModalButtons = document.querySelectorAll('[data-close-modal]');
            const feedbackButtons = document.querySelectorAll('[data-feedback-button]');

            let currentReportId = null;

            // Open modal
            feedbackButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    currentReportId = button.dataset.reportId;
                    feedbackForm.querySelector('input[name="report_id"]').value = currentReportId;
                    feedbackModal.classList.remove('hidden');
                });
            });

            // Close modal
            closeModalButtons.forEach(button => {
                button.addEventListener('click', () => {
                    feedbackModal.classList.add('hidden');
                    currentReportId = null;
                });
            });

            // Close modal on background click
            feedbackModal.addEventListener('click', (event) => {
                if (event.target === feedbackModal) {
                    feedbackModal.classList.add('hidden');
                    currentReportId = null;
                };
            });
        });
    </script>
</x-app-layout>