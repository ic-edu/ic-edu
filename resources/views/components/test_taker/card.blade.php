@props([
    'title' => 'Course Title',
    'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'description' => 'Course description goes here.',
    'badge' => 'Beginner',
    'duration' => '2h 30m',
    'lessons' => '12 Lessons',
    'progress' => null,
    'link' => '#'
])

<div class="group flex flex-col bg-white rounded-[1.5rem] shadow-sm hover:shadow-xl hover:border-gray-200 hover:-translate-y-1 transition-all duration-300 w-full cursor-pointer relative p-4" onclick="window.location.href='{{ $link }}'">
    <!-- Image Section -->
    <div class="relative h-56 w-full overflow-hidden rounded-[1rem] bg-gray-100 text-center">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <div class="absolute top-3 left-3">
            <span class="bg-white/95 backdrop-blur-md text-gray-800 tracking-wide text-[0.7rem] uppercase font-bold px-3 py-1.5 rounded-full shadow-sm">
                {{ $badge }}
            </span>
        </div>
        
        @if($progress !== null)
        <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gray-200/50 backdrop-blur-sm">
            <div class="h-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)]" style="width: {{ $progress }}%"></div>
        </div>
        @endif
    </div>

    <!-- Content Section -->
    <div class="pt-5 pb-2 px-2 flex flex-col flex-grow">
        <div class="flex items-center gap-4 text-xs text-gray-500 font-medium mb-3">
            <div class="flex items-center gap-1.5">
                <x-lucide-clock class="w-4 h-4 text-blue-500/70" />
                <span>{{ $duration }}</span>
            </div>
            <div class="flex items-center gap-1.5">
                <x-lucide-book-open class="w-4 h-4 text-blue-500/70" />
                <span>{{ $lessons }}</span>
            </div>
        </div>
        
        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-2 line-clamp-2 leading-tight">
            {{ $title }}
        </h3>
        
        <p class="text-sm text-gray-500 line-clamp-2 mb-6 flex-grow leading-relaxed">
            {{ $description }}
        </p>

        <!-- Footer -->
        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($progress > 0 && $progress < 100)
                    <span class="text-sm font-bold text-blue-600">Continue Learning</span>
                @elseif($progress == 100)
                    <span class="text-sm font-bold text-green-600 flex items-center gap-1.5"><x-lucide-check-circle class="w-4 h-4" /> Completed</span>
                @else
                    <span class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Start Course</span>
                @endif
            </div>
            <div class="bg-gray-50 group-hover:bg-blue-50 text-gray-400 group-hover:text-blue-600 p-2.5 rounded-full transition-colors duration-300 transform group-hover:translate-x-1">
                <x-lucide-arrow-right class="w-4 h-4" />
            </div>
        </div>
    </div>
</div>
