<div class="bg-[#d9e6ea] p-4 rounded-xl w-72">

    {{-- Image --}}
    <div class="bg-white rounded-lg h-32 mb-3 overflow-hidden">
        <img
            src="{{ $image ?? asset('images/default.jpg') }}"
            class="w-full h-full object-cover">
    </div>

    {{-- Title --}}
    <h3 class="font-semibold text-sm mb-2">
        {{ $title }}
    </h3>

    {{-- Footer --}}
    <div class="flex justify-between items-center">
        <span class="text-xs text-gray-600">
            {{ $price }}
        </span>

        <a href="{{ $link }}" class="bg-blue-900 text-white text-xs px-3 py-1 rounded-full">
            Details
        </a>
    </div>
</div>