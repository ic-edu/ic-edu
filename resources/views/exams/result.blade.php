<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exam Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Your Exam Result</h3>

                <div class="space-y-4">
                    <div class="flex items
                        <span class="font-semibold w-48">Exam Title:</span>
                        <span>{{ $attempt->exam->title }}</span>
                    </div>
                    <div class="flex items-center
                        <span class="font-semibold w-48">Total
                        Score:</span>
                        <span>{{ $attempt->total_score }}</span>
                    </div>
                    <div class="flex items-center
                        <span class="font-semibold w-48">Status:</span>
                        <span class="capitalize">{{ $attempt->status }}</span>
                    </div>
                    <div class="flex items
                        <span class="font-semibold w-48">Started At:</span>
                        <span>{{ $attempt->start_time->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items

                        <span class="font-semibold w-48">Ended At:</span>
                        <span>{{ $attempt->end_time ? $attempt->end_time->format('d M Y, H:i') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
