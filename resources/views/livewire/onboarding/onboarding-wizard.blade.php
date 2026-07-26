<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ============================================================
         LEFT PANEL
    ============================================================ --}}
    <div class="hidden lg:flex flex-col justify-between w-[40%] min-h-screen relative overflow-hidden"
         style="background: linear-gradient(160deg, #0b2740 0%, #1A456C 55%, #1e5c82 100%);">

        {{-- Dot pattern --}}
        <div class="absolute inset-0 pointer-events-none" style="
            background-image: radial-gradient(circle, rgba(111,175,181,0.11) 1px, transparent 1px);
            background-size: 26px 26px;
        "></div>

        {{-- Glow circles --}}
        <div class="absolute -top-28 -right-28 w-80 h-80 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(111,175,181,0.16) 0%, transparent 70%);"></div>
        <div class="absolute bottom-36 -left-24 w-64 h-64 rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(111,175,181,0.09) 0%, transparent 70%);"></div>

        {{-- Logo + copy --}}
        <div class="relative z-10 pt-10 px-10">
            <img src="{{ asset(config('tenant.active.logo_light')) }}" alt="iC.Edu"
                 class="object-contain"
                 style="height:52px; filter:brightness(0) invert(1);">

            <div class="mt-10">
                @if($currentStep === 1)
                    <p class="text-xs font-bold uppercase mb-4" style="color:#6FAFB5; letter-spacing:0.18em;">Getting Started</p>
                    <h1 class="leading-[1.15]"
                        style="color:white; font-size:clamp(28px,3vw,38px); font-weight:800; font-family:'Poppins',sans-serif;">
                        Your study<br>journey<br>begins <span style="color:#6FAFB5;">here.</span>
                    </h1>
                @elseif($currentStep === 2)
                    <p class="text-xs font-bold uppercase mb-4" style="color:#6FAFB5; letter-spacing:0.18em;">Your Goal</p>
                    <h1 class="leading-[1.15]"
                        style="color:white; font-size:clamp(28px,3vw,38px); font-weight:800; font-family:'Poppins',sans-serif;">
                        Set your<br>sights<br><span style="color:#6FAFB5;">high.</span>
                    </h1>
                @elseif($currentStep === 3)
                    <p class="text-xs font-bold uppercase mb-4" style="color:#6FAFB5; letter-spacing:0.18em;">Learning Style</p>
                    <h1 class="leading-[1.15]"
                        style="color:white; font-size:clamp(28px,3vw,38px); font-weight:800; font-family:'Poppins',sans-serif;">
                        Learn your<br>own<br><span style="color:#6FAFB5;">way.</span>
                    </h1>
                @else
                    <p class="text-xs font-bold uppercase mb-4" style="color:#6FAFB5; letter-spacing:0.18em;">All Set</p>
                    <h1 class="leading-[1.15]"
                        style="color:white; font-size:clamp(28px,3vw,38px); font-weight:800; font-family:'Poppins',sans-serif;">
                        Ready to<br>ace your<br><span style="color:#6FAFB5;">exam!</span>
                    </h1>
                    <p class="mt-4 text-sm leading-relaxed" style="color:rgba(255,255,255,0.45); max-width:210px;">
                        Your iC.Edu profile is all set. Time to get to work.
                    </p>
                @endif
            </div>
        </div>

        {{-- Mascot --}}
        <div class="relative z-10 flex justify-center items-center" style="flex:1; min-height:0;">
            @if($currentStep === 1)
                <img src="{{ asset('assets/maskot/hero%20maskot.png') }}" alt=""
                     class="select-none object-contain"
                     style="width:92%; max-height:420px; filter:drop-shadow(0 28px 56px rgba(0,0,0,0.45));">
            @elseif($currentStep === 2)
                <img src="{{ asset('assets/onboarding2.png') }}" alt=""
                     class="select-none object-contain"
                     style="width:88%; max-height:400px; filter:drop-shadow(0 28px 56px rgba(0,0,0,0.45));">
            @elseif($currentStep === 3)
                <img src="{{ asset('assets/maskot/pen%20maskot.png') }}" alt=""
                     class="select-none object-contain"
                     style="width:88%; max-height:400px; filter:drop-shadow(0 28px 56px rgba(0,0,0,0.45));">
            @else
                <img src="{{ asset('assets/onboarding4.png') }}" alt=""
                     class="select-none object-contain"
                     style="width:88%; max-height:400px; filter:drop-shadow(0 28px 56px rgba(0,0,0,0.45));">
            @endif
        </div>

        {{-- Step bar --}}
        <div class="relative z-10 px-10 pb-10">
            <div class="flex gap-1.5 mb-2">
                @for($i = 1; $i <= $totalSteps; $i++)
                    <div class="h-[3px] rounded-full transition-all duration-500"
                         style="flex:{{ $i <= $currentStep ? '1' : '0 0 18px' }}; background:{{ $i <= $currentStep ? '#6FAFB5' : 'rgba(111,175,181,0.2)' }};"></div>
                @endfor
            </div>
            <p class="text-xs" style="color:rgba(255,255,255,0.3);">Step {{ $currentStep }} of {{ $totalSteps }}</p>
        </div>
    </div>


    {{-- ============================================================
         RIGHT PANEL
    ============================================================ --}}
    <div class="flex-1 flex flex-col min-h-screen overflow-y-auto" style="background:#FAFBFD;">

        {{-- Mobile top bar --}}
        <div class="lg:hidden flex items-center justify-between px-5 py-4"
             style="background:linear-gradient(135deg,#0b2740,#1A456C); border-bottom:1px solid rgba(255,255,255,0.07);">
            <img src="{{ asset(config('tenant.active.logo_light')) }}" alt="iC.Edu"
                 class="h-7 object-contain" style="filter:brightness(0) invert(1);">
            <div class="flex items-center gap-2">
                @for($i = 1; $i <= $totalSteps; $i++)
                    <div class="h-1 rounded-full transition-all duration-300"
                         style="width:{{ $i <= $currentStep ? '20px' : '8px' }}; background:{{ $i <= $currentStep ? '#6FAFB5' : 'rgba(111,175,181,0.3)' }};"></div>
                @endfor
            </div>
        </div>

        {{-- ── Centered form wrapper ── --}}
        <div class="flex-1 flex flex-col items-center px-6 pt-10 pb-10">
            <div class="w-full flex flex-col" style="max-width:580px;">

                {{-- ── Step Progress Bar ── --}}
                <div class="hidden lg:block mb-9">
                    <div class="w-full rounded-full overflow-hidden" style="height:3px; background:#f0f4f8;">
                        <div class="h-full rounded-full transition-all duration-500"
                             style="width:{{ ($currentStep / $totalSteps) * 100 }}%;
                                    background:linear-gradient(to right, #1A456C, #6FAFB5);"></div>
                    </div>
                </div>


                {{-- ====== STEP 1 — Avatar + Profile ====== --}}
                @if($currentStep === 1)

                    <div class="mb-6">
                        <p class="text-xs font-bold uppercase mb-2" style="color:#6FAFB5; letter-spacing:0.18em;">Profile Setup</p>
                        <h2 class="leading-tight" style="font-size:29px; font-weight:800; color:#0D1B2A; font-family:'Poppins',sans-serif;">
                            Choose your study<br>companion.
                        </h2>
                        <p class="mt-2.5 text-base" style="color:#64748b;">Pick a mascot, or upload your own photo.</p>
                    </div>

                    {{-- Avatar grid --}}
                    @php $presets = ['1.png','2.png','3.png','4.png','5.png','6.png','7.png']; @endphp
                    <div class="mb-6">
                        <div class="grid grid-cols-4 gap-3 mb-3">
                            @foreach($presets as $avatar)
                                @php $isActivePreset = $photo_source === 'preset' && $profile_photo === 'presets/'.$avatar; @endphp
                                <button type="button"
                                    wire:click="selectPreset('{{ $avatar }}')"
                                    class="relative rounded-2xl overflow-hidden transition-all duration-200"
                                    style="aspect-ratio:1; {{ $isActivePreset ? 'box-shadow:0 0 0 2.5px #1A456C,0 4px 16px rgba(26,69,108,0.15); transform:scale(1.04);' : 'box-shadow:0 0 0 1.5px #e2e8f0;' }}"
                                >
                                    <div class="w-full h-full flex items-center justify-center p-1.5 transition-colors duration-200"
                                         style="background:{{ $isActivePreset ? '#EEF5FF' : 'white' }};">
                                        <img src="{{ asset('assets/avatars/presets/'.$avatar) }}"
                                             alt="Avatar {{ $loop->iteration }}"
                                             class="w-full h-full object-contain" draggable="false">
                                    </div>
                                    @if($isActivePreset)
                                        <div class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full flex items-center justify-center"
                                             style="background:#1A456C;">
                                            <svg width="8" height="7" viewBox="0 0 8 7" fill="none">
                                                <path d="M1 3.5L3 5.5L7 1" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                </button>
                            @endforeach

                            {{-- Upload slot — gambar tetap tampil meski user klik preset --}}
                            @php $isActiveUpload = $photo_source === 'upload' && $uploaded_photo && !$errors->has('uploaded_photo'); @endphp
                            <label class="relative rounded-2xl cursor-pointer transition-all duration-200 flex flex-col items-center justify-center gap-1"
                                   style="aspect-ratio:1;
                                       {{ $isActiveUpload ? 'box-shadow:0 0 0 2.5px #1A456C, 0 4px 16px rgba(26,69,108,0.15);' : '' }}
                                       {{ $uploaded_photo && !$errors->has('uploaded_photo') ? '' : 'border:1.5px dashed #cbd5e1; background:white;' }}
                                   ">
                                <input type="file" wire:model="uploaded_photo"
                                       accept="image/png,image/jpeg,image/webp" class="sr-only">

                                @if($uploaded_photo && !$errors->has('uploaded_photo'))
                                    {{-- Foto yang diupload SELALU tampil, tidak hilang meski pilih preset --}}
                                    <div class="absolute inset-0 rounded-2xl overflow-hidden">
                                        <img src="{{ $uploaded_photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity"
                                             style="background:rgba(13,27,42,0.5);">
                                            <p class="text-white text-xs font-semibold">Change</p>
                                        </div>
                                    </div>
                                    {{-- Badge aktif hanya saat photo_source === 'upload' --}}
                                    @if($isActiveUpload)
                                        <div class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full flex items-center justify-center"
                                             style="background:#1A456C; z-index:10;">
                                            <svg width="8" height="7" viewBox="0 0 8 7" fill="none">
                                                <path d="M1 3.5L3 5.5L7 1" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                @else
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="text-[10px] font-semibold" style="color:#94a3b8;">Upload</p>
                                @endif
                            </label>
                        </div>

                        @error('uploaded_photo')
                            <p class="text-xs mt-1 font-medium" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                        <div wire:loading wire:target="uploaded_photo" class="flex items-center gap-2 mt-1">
                            <div class="w-3 h-3 animate-spin rounded-full" style="border:2px solid #e2e8f0; border-top-color:#1A456C;"></div>
                            <p class="text-xs" style="color:#64748b;">Uploading...</p>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 mb-5">
                        <div class="flex-1 h-px" style="background:#e2e8f0;"></div>
                        <p class="text-xs font-semibold" style="color:#94a3b8;">Registered Information</p>
                        <div class="flex-1 h-px" style="background:#e2e8f0;"></div>
                    </div>

                    {{-- Read-only account info --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color:#0D1B2A;">Username</label>
                            <div class="w-full text-sm flex items-center gap-2"
                                 style="border:1.5px solid #e2e8f0; border-radius:12px; padding:13px 16px; background:#f8fafc; color:#64748b; font-family:inherit; cursor:default; user-select:none;">
                                <x-lucide-user class="w-4 h-4 flex-shrink-0" style="color:#94a3b8;" />
                                <span class="truncate">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2" style="color:#0D1B2A;">Email</label>
                            <div class="w-full text-sm flex items-center gap-2"
                                 style="border:1.5px solid #e2e8f0; border-radius:12px; padding:13px 16px; background:#f8fafc; color:#64748b; font-family:inherit; cursor:default; user-select:none;">
                                <x-lucide-mail class="w-4 h-4 flex-shrink-0" style="color:#94a3b8;" />
                                <span class="truncate">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>

                @endif


                {{-- ====== STEP 2 — Target Exam ====== --}}
                @if($currentStep === 2)

                    <div class="mb-6">
                        <p class="text-xs font-bold uppercase mb-2" style="color:#6FAFB5; letter-spacing:0.18em;">Your Goal</p>
                        <h2 class="leading-tight" style="font-size:29px; font-weight:800; color:#0D1B2A; font-family:'Poppins',sans-serif;">
                            Which exam are<br>you conquering?
                        </h2>
                    </div>

                    {{-- Exam cards --}}
                    <div class="mb-5">
                        <div class="grid grid-cols-3 gap-2.5">
                            @foreach([
                                ['key'=>'TOEIC', 'sub'=>'Business English',     'range'=>'10–990'],
                                ['key'=>'IELTS', 'sub'=>'Academic / General',   'range'=>'1–9'],
                                ['key'=>'TOEFL', 'sub'=>'University Admission', 'range'=>'0–120'],
                            ] as $exam)
                                <button type="button"
                                    wire:click="$set('target_exam','{{ $exam['key'] }}')"
                                    class="py-5 px-4 rounded-2xl text-left transition-all duration-200"
                                    style="{{ $target_exam === $exam['key'] ? 'background:#1A456C; box-shadow:0 6px 20px rgba(26,69,108,0.25);' : 'background:white; border:1.5px solid #e2e8f0;' }}"
                                >
                                    <p class="text-base font-bold" style="color:{{ $target_exam === $exam['key'] ? 'white' : '#0D1B2A' }};">{{ $exam['key'] }}</p>
                                    <p class="text-xs mt-1 leading-snug" style="color:{{ $target_exam === $exam['key'] ? 'rgba(255,255,255,0.5)' : '#94a3b8' }};">{{ $exam['sub'] }}</p>
                                </button>
                            @endforeach
                        </div>
                        @error('target_exam')
                            <p class="text-xs mt-2 font-medium" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Score input --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold mb-2" style="color:#0D1B2A;">
                            Target Score
                            <span class="font-normal" style="color:#94a3b8;">
                                — optional
                                @if($target_exam==='TOEIC') &nbsp;(max 990) @elseif($target_exam==='IELTS') &nbsp;(max 9.0) @elseif($target_exam==='TOEFL') &nbsp;(max 120) @elseif($target_exam==='DET') &nbsp;(max 160) @endif
                            </span>
                        </label>
                        <input type="number" wire:model.live="target_score" min="0"
                            placeholder="@if($target_exam==='TOEIC') e.g. 750 @elseif($target_exam==='IELTS') e.g. 7.0 @elseif($target_exam==='TOEFL') e.g. 100 @else Enter your target @endif"
                            class="w-full text-sm outline-none transition-all"
                            style="border:1.5px solid #e2e8f0; border-radius:12px; padding:13px 16px; background:white; color:#0D1B2A; font-family:inherit;"
                            onfocus="this.style.borderColor='#1A456C'; this.style.boxShadow='0 0 0 4px rgba(26,69,108,0.07)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        @error('target_score')
                            <p class="text-xs mt-1.5 font-medium" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Score benchmark card --}}
                    @if($target_exam)
                        @php
                            $benchmarks = [
                                'TOEIC' => [['label'=>'Basic',    'score'=>'400–600',  'note'=>'Entry level'],    ['label'=>'Good',     'score'=>'600–800',  'note'=>'Most jobs'],        ['label'=>'Excellent','score'=>'800+',  'note'=>'Top positions']],
                                'IELTS' => [['label'=>'Basic',    'score'=>'4.0–5.5',  'note'=>'Foundation'],     ['label'=>'Good',     'score'=>'6.0–7.0',  'note'=>'Most universities'],['label'=>'Excellent','score'=>'7.5+',  'note'=>'Top universities']],
                                'TOEFL' => [['label'=>'Basic',    'score'=>'42–71',    'note'=>'Foundation'],     ['label'=>'Good',     'score'=>'72–94',    'note'=>'Most programs'],    ['label'=>'Excellent','score'=>'95+',   'note'=>'Competitive']],
                            ];
                            $bm = $benchmarks[$target_exam] ?? null;
                        @endphp
                        @if($bm)
                            <div class="rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0; background:white;">
                                <div class="px-5 pt-4 pb-3" style="border-bottom:1px solid #f1f5f9;">
                                    <p class="text-sm font-bold" style="color:#0D1B2A;">{{ $target_exam }} Score Guide</p>
                                </div>
                                <div class="grid grid-cols-3 divide-x" style="border-color:#f1f5f9;">
                                    @foreach($bm as $b)
                                        <div class="px-3 py-4 text-center">
                                            <p class="text-[11px] font-bold uppercase tracking-wide mb-1.5" style="color:#94a3b8;">{{ $b['label'] }}</p>
                                            <p class="text-base font-bold mb-1" style="color:#1A456C; font-family:'Poppins',sans-serif;">{{ $b['score'] }}</p>
                                            <p class="text-xs" style="color:#94a3b8;">{{ $b['note'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="rounded-2xl flex flex-col items-center justify-center py-8"
                             style="border:1.5px dashed #e2e8f0; background:white;">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mb-3"
                                 style="background:#f1f5f9;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6FAFB5" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold" style="color:#94a3b8;">Select an exam to see score ranges</p>
                        </div>
                    @endif

                @endif


                {{-- ====== STEP 3 — Learning Profile ====== --}}
                @if($currentStep === 3)

                    <div class="mb-6">
                        <p class="text-xs font-bold uppercase mb-2" style="color:#6FAFB5; letter-spacing:0.18em;">Learning Profile</p>
                        <h2 class="leading-tight" style="font-size:29px; font-weight:800; color:#0D1B2A; font-family:'Poppins',sans-serif;">
                            Help us match<br>you perfectly.
                        </h2>
                    </div>

                    {{-- English Level --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold mb-3" style="color:#0D1B2A;">Your current English level</label>
                        <div class="grid grid-cols-3 gap-2.5">
                            @foreach([
                                ['value'=>'beginner',     'label'=>'Beginner',     'desc'=>'Just starting out',      'icon'=>'sprout'],
                                ['value'=>'intermediate', 'label'=>'Intermediate', 'desc'=>'Everyday conversations', 'icon'=>'book-open'],
                                ['value'=>'advanced',     'label'=>'Advanced',     'desc'=>'Nearly fluent',          'icon'=>'zap'],
                            ] as $option)
                                @php $isActive = $english_level === $option['value']; @endphp
                                <button type="button"
                                    wire:click="$set('english_level','{{ $option['value'] }}')"
                                    class="py-6 px-4 rounded-2xl text-center transition-all duration-200"
                                    style="{{ $isActive ? 'background:#1A456C; box-shadow:0 6px 20px rgba(26,69,108,0.22);' : 'background:white; border:1.5px solid #e2e8f0;' }}"
                                >
                                    <div class="flex justify-center mb-2.5">
                                        <x-dynamic-component
                                            :component="'lucide-' . $option['icon']"
                                            class="w-6 h-6"
                                            :style="'color:' . ($isActive ? 'rgba(255,255,255,0.85)' : '#6FAFB5')"
                                        />
                                    </div>
                                    <p class="text-sm font-bold" style="color:{{ $isActive ? 'white' : '#0D1B2A' }};">{{ $option['label'] }}</p>
                                    <p class="text-xs mt-1 leading-snug" style="color:{{ $isActive ? 'rgba(255,255,255,0.5)' : '#94a3b8' }};">{{ $option['desc'] }}</p>
                                </button>
                            @endforeach
                        </div>
                        @error('english_level')
                            <p class="text-xs mt-2 font-medium" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Learning Purpose --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold mb-3" style="color:#0D1B2A;">Why are you learning English?</label>
                        <div class="grid grid-cols-2 gap-2.5">
                            @foreach([
                                ['value'=>'career',       'label'=>'Career',       'sub'=>'Work & professional growth',    'icon'=>'briefcase'],
                                ['value'=>'study_abroad', 'label'=>'Study Abroad', 'sub'=>'University or exchange program','icon'=>'plane'],
                                ['value'=>'personal',     'label'=>'Personal',     'sub'=>'Travel or self-enrichment',     'icon'=>'globe'],
                                ['value'=>'other',        'label'=>'Other',        'sub'=>'Another reason',                'icon'=>'sparkles'],
                            ] as $option)
                                @php $isPurposeActive = $learning_purpose === $option['value']; @endphp
                                <button type="button"
                                    wire:click="$set('learning_purpose','{{ $option['value'] }}')"
                                    class="py-5 px-5 rounded-2xl text-left transition-all duration-200"
                                    style="{{ $isPurposeActive ? 'background:#1A456C; box-shadow:0 6px 20px rgba(26,69,108,0.22);' : 'background:white; border:1.5px solid #e2e8f0;' }}"
                                >
                                    <x-dynamic-component
                                        :component="'lucide-' . $option['icon']"
                                        class="w-5 h-5 mb-2.5"
                                        :style="'color:' . ($isPurposeActive ? 'rgba(255,255,255,0.85)' : '#6FAFB5')"
                                    />
                                    <p class="text-base font-bold" style="color:{{ $isPurposeActive ? 'white' : '#0D1B2A' }};">{{ $option['label'] }}</p>
                                    <p class="text-xs mt-1 leading-snug" style="color:{{ $isPurposeActive ? 'rgba(255,255,255,0.5)' : '#94a3b8' }};">{{ $option['sub'] }}</p>
                                </button>
                            @endforeach
                        </div>
                        @error('learning_purpose')
                            <p class="text-xs mt-2 font-medium" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Personalization hint --}}
                    <div class="rounded-2xl px-4 py-3.5 flex items-start gap-3"
                         style="background:linear-gradient(135deg,rgba(26,69,108,0.05),rgba(111,175,181,0.08)); border:1px solid rgba(111,175,181,0.2);">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                             style="background:rgba(111,175,181,0.2);">
                            <x-lucide-layers class="w-4 h-4" style="color:#6FAFB5;" />
                        </div>
                        <div>
                            <p class="text-xs font-bold mb-0.5" style="color:#1A456C;">Personalized for you</p>
                            <p class="text-xs leading-relaxed" style="color:#64748b;">We'll use this to recommend exercises, mock exams, and study plans that fit your pace.</p>
                        </div>
                    </div>

                @endif


                {{-- ====== STEP 4 — Done! ====== --}}
                @if($currentStep === 4)

                    <div class="flex flex-col items-center text-center pt-4">

                        {{-- Avatar --}}
                        <div class="relative mb-6">
                            <div class="w-24 h-24 rounded-[24px] overflow-hidden flex items-center justify-center"
                                 style="background:#EEF5FF; box-shadow:0 12px 40px rgba(26,69,108,0.16);">
                                @if($uploaded_photo && !$errors->has('uploaded_photo'))
                                    <img src="{{ $uploaded_photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($profile_photo && str_starts_with($profile_photo,'presets/'))
                                    <img src="{{ asset('assets/avatars/'.$profile_photo) }}" class="w-full h-full object-contain p-2">
                                @elseif($profile_photo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($profile_photo) }}" class="w-full h-full object-cover">
                                @else
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#1A456C" stroke-width="1.5">
                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-full flex items-center justify-center"
                                 style="background:linear-gradient(135deg,#1A456C,#6FAFB5); box-shadow:0 4px 12px rgba(26,69,108,0.3);">
                                <svg width="12" height="10" viewBox="0 0 12 10" fill="none">
                                    <path d="M1 5L4.5 8.5L11 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>

                        <p class="text-xs font-bold uppercase mb-2.5" style="color:#6FAFB5; letter-spacing:0.18em;">All Set!</p>
                        <h2 class="mb-1" style="font-size:26px; font-weight:800; color:#0D1B2A; font-family:'Poppins',sans-serif;">
                            Welcome, {{ Auth::user()->name }}!
                        </h2>
                        <p class="text-base mb-6" style="color:#64748b; max-width:300px; line-height:1.6;">
                            Your iC.Edu profile is ready. Let's start building toward your goal.
                        </p>

                        {{-- Summary --}}
                        <div class="w-full text-left rounded-2xl overflow-hidden mb-5" style="border:1px solid #e2e8f0;">
                            @foreach([
                                ['label'=>'Target Exam',   'value'=>$target_exam ?: '—'],
                                ['label'=>'Target Score',  'value'=>$target_score ? (string)$target_score : '—'],
                                ['label'=>'English Level', 'value'=>$english_level ? ucfirst($english_level) : '—'],
                                ['label'=>'Learning For',  'value'=>$learning_purpose ? ucfirst(str_replace('_',' ',$learning_purpose)) : '—'],
                            ] as $idx => $row)
                                <div class="flex items-center justify-between px-5 py-3.5"
                                     style="background:{{ $idx % 2 === 0 ? '#f8fafc' : 'white' }}; {{ $idx < 3 ? 'border-bottom:1px solid #e2e8f0;' : '' }}">
                                    <span class="text-xs font-semibold" style="color:#94a3b8;">{{ $row['label'] }}</span>
                                    <span class="text-sm font-bold" style="color:#0D1B2A;">{{ $row['value'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Motivational note --}}
                        <div class="w-full rounded-2xl px-4 py-3.5 flex items-center gap-3 text-left"
                             style="background:linear-gradient(135deg,#1A456C,#2d7a80);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.8">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="text-xs leading-relaxed" style="color:rgba(255,255,255,0.85);">
                                Your first practice session is ready. Consistency beats intensity — just start!
                            </p>
                        </div>
                    </div>

                @endif


                {{-- ====== NAVIGATION ====== --}}
                <div class="flex items-center justify-between mt-8 pt-5" style="border-top:1px solid #e2e8f0;">
                    @if($currentStep > 1)
                        <button type="button" wire:click="previousStep"
                            class="flex items-center gap-1.5 text-sm font-semibold transition-all duration-200"
                            style="padding:10px 18px; border-radius:12px; border:1.5px solid #e2e8f0; background:white; color:#64748b; font-family:inherit;"
                            onmouseover="this.style.borderColor='#1A456C'; this.style.color='#1A456C';"
                            onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b';">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 2.5L4 7l5 4.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Back
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if($currentStep < $totalSteps)
                        <button type="button" wire:click="nextStep"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-60 cursor-not-allowed"
                            class="flex items-center gap-2 text-sm font-bold text-white transition-all duration-200"
                            style="padding:10px 24px; border-radius:12px; background:#1A456C; border:none; font-family:inherit; box-shadow:0 4px 16px rgba(26,69,108,0.28); cursor:pointer;"
                            onmouseover="if(!this.disabled) this.style.background='#163a5c';"
                            onmouseout="this.style.background='#1A456C';">
                            <span wire:loading wire:target="nextStep">Saving...</span>
                            <span wire:loading.remove wire:target="nextStep" class="flex items-center gap-2">
                                Continue
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 7h8M7.5 3l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </button>
                    @else
                        <button type="button" wire:click="completeOnboarding"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-60 cursor-not-allowed"
                            class="flex items-center gap-2 text-sm font-bold text-white"
                            style="padding:10px 24px; border-radius:12px; background:linear-gradient(135deg,#1A456C 0%,#2d7a80 100%); border:none; font-family:inherit; box-shadow:0 4px 20px rgba(26,69,108,0.35); cursor:pointer;">
                            <span wire:loading wire:target="completeOnboarding">Setting up...</span>
                            <span wire:loading.remove wire:target="completeOnboarding" class="flex items-center gap-2">
                                Go to Dashboard
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 7h8M7.5 3l4 4-4 4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </button>
                    @endif
                </div>

            </div>{{-- /max-width container --}}
        </div>{{-- /centered wrapper --}}
    </div>{{-- /right panel --}}

</div>
