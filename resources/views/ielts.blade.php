@extends('layouts.user')

@section('title', 'TOEFL Preparation')

@section('content')
<section class="w-full relative pt-40 pb-32 flex flex-col items-center justify-center overflow-hidden select-none bg-gradient-to-br from-slate-50 via-slate-100 via-40% to-[#1A456C] text-center">
    <div class="max-w-[800px] mx-auto px-[5%] relative z-10 text-white" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="font-sans font-extrabold text-4xl md:text-5xl lg:text-[3rem] mb-6 leading-tight drop-shadow-sm">
            Reach Your TOEFL Goals<br>with IC Edu
        </h1>
        <p class="font-sans text-base md:text-lg mb-10 font-medium opacity-95 leading-relaxed max-w-[700px] mx-auto">
            Prepare to crush the TOEFL with our personalized and easy-to-use prep tools! With in-depth practice tests and interactive lessons, IC.Edu has everything you need to boost your score.
        </p>
        <div>
            <a href="#" class="inline-block bg-[#1a3a5a] text-white font-bold px-12 py-3.5 rounded-full hover:bg-[#152e4a] transition-all shadow-lg text-sm md:text-base">
                Practice Now
            </a>
        </div>
    </div>
</section>


<section class="w-full bg-white pt-16 pb-32 relative">
   <x-landing.about-exam/>
</br>
</br>
     <x-landing.dropdown-test/> 
     <x-landing.choose-exam/>
</section>
<x-landing.unlock/>



@push('scripts')
<script>
    function toggleAccordion(headerElement) {
        // Ambil elemen parent dan konten di bawahnya
        const parent = headerElement.closest('.accordion-item');
        const content = parent.querySelector('.accordion-content');
        const icon = headerElement.querySelector('.accordion-icon');

        // Cek apakah konten saat ini tersembunyi
        const isHidden = content.classList.contains('hidden');

        if (isHidden) {
            // Tampilkan
            content.classList.remove('hidden');
            icon.textContent = '-';
            icon.classList.remove('text-2xl');
            icon.classList.add('text-3xl'); 
        } else {
            // Sembunyikan
            content.classList.add('hidden');
            icon.textContent = '+';
            icon.classList.remove('text-3xl');
            icon.classList.add('text-2xl');
        }
    }
</script>
@endpush
@endsection