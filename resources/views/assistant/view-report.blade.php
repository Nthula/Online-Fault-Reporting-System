<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Report Header with Status Badge -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-medium">{{ $report->category }}</h3>
                            <p class="text-gray-600 mt-2">{{ $report->description }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm rounded-full 
                            {{ $report->status === 'solved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($report->status) }}
                            @if($report->status === 'solved' && $report->solved_at)
                                <span class="text-xs">({{ $report->solved_at->diffForHumans() }})</span>
                            @endif
                        </span>
                    </div>

                    <!-- Report Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Reported By</p>
                            <p class="font-medium">{{ $report->user->name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Block/Room</p>
                            <p class="font-medium">{{ $report->user->residence ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Date Reported</p>
                            <p class="font-medium">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Validation Status</p>
                            <p class="font-medium">
                                @if($report->validated)
                                    <span class="text-green-600">Validated</span>
                                @else
                                    <span class="text-yellow-600">Pending Validation</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Validation Section -->
                    @if(!$report->validated)
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Validate Report</h4>
                        <form method="POST" action="{{ route('assistant.reports.validate', $report->report_id) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Validate Report
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- Solution Details (if solved) -->
                    @if($report->status === 'solved' && $report->solved_at)
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Resolution Details</h4>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Date Solved</p>
                                    <p class="font-medium">{{ $report->solved_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Time to Resolution</p>
                                    <p class="font-medium">{{ $report->created_at->diffForHumans($report->solved_at, true) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Attachments (if any) -->
                    @if($report->image)
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Attachments</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" class="max-w-full h-auto rounded-md">
                        </div>
                    </div>
                    @endif

                    <!-- Back Button -->
                    <div class="mt-6">
                        <a href="{{ route('assistant.reports') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to all reports
                        </a>
                    </div>
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