@extends('layouts.test_taker')
@section('title', 'Browse Exams')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">
    
    {{-- HEADER SECTION --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 1.8rem; font-weight: 900; color: var(--text); letter-spacing: -0.02em;">Browse Exams</h1>
        <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">Discover and enroll in available simulation exams and tryouts.</p>
    </div>

    {{-- FILTER TABS --}}
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 32px;">
        <button style="padding: 10px 20px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; background: var(--text); color: white; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(15,23,42,0.15);">
            All Exams
        </button>
        <button style="padding: 10px 20px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; background: white; color: var(--muted); border: 1.5px solid var(--border); cursor: pointer; transition: all .2s;"
                onmouseover="this.style.borderColor='var(--blue)'; this.style.color='var(--blue)';"
                onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--muted)';">
            Latest
        </button>
        <button style="padding: 10px 20px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; background: white; color: var(--muted); border: 1.5px solid var(--border); cursor: pointer; transition: all .2s;"
                onmouseover="this.style.borderColor='var(--blue)'; this.style.color='var(--blue)';"
                onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--muted)';">
            Popular
        </button>
    </div>

    {{-- EXAMS GRID --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr)); gap: 24px;">
        @forelse($exams as $exam)
        @php
            $bgColors = [
                ['bg' => 'linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%)', 'tx' => '#1d4ed8', 'accent' => '#3b82f6', 'emoji' => '🎧'],
                ['bg' => 'linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%)', 'tx' => '#6d28d9', 'accent' => '#7c3aed', 'emoji' => '🗣️'],
                ['bg' => 'linear-gradient(135deg, #bbf7d0 0%, #86efac 100%)', 'tx' => '#15803d', 'accent' => '#16a34a', 'emoji' => '📖'],
                ['bg' => 'linear-gradient(135deg, #fef08a 0%, #fde047 100%)', 'tx' => '#a16207', 'accent' => '#ca8a04', 'emoji' => '✍️'],
                ['bg' => 'linear-gradient(135deg, #fbcfe8 0%, #f9a8d4 100%)', 'tx' => '#9d174d', 'accent' => '#db2777', 'emoji' => '📝'],
            ];
            $color = $bgColors[$loop->index % count($bgColors)];
            $isStrict = $exam->mode === 'strict';
        @endphp
        
        <div class="card anim-in d{{ ($loop->index % 5) + 1 }}" style="display: flex; flex-direction: column; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(37,99,235,0.1)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            
            {{-- Illustration Area --}}
            <div style="height: 180px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; background: {{ $color['bg'] }};">
                
                {{-- Category Badge --}}
                <div style="position: absolute; top: 16px; left: 16px; background: rgba(255,255,255,0.9); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: {{ $color['tx'] }}; backdrop-filter: blur(4px);">
                    {{ $exam->examType->name ?? 'Exam' }}
                </div>
                
                {{-- Duration Badge --}}
                <div style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.8); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; color: #334155; backdrop-filter: blur(4px);">
                    ⏱️ {{ $exam->total_duration }} Mins
                </div>

                {{-- Emoji Icon --}}
                <div style="font-size: 4rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1)); user-select: none; transition: transform 0.3s;"
                     onmouseover="this.style.transform='scale(1.1) rotate(5deg)';"
                     onmouseout="this.style.transform='scale(1) rotate(0)';">
                    {{ $color['emoji'] }}
                </div>

                {{-- Strict Mode Badge --}}
                @if($isStrict)
                <div style="position: absolute; bottom: 12px; left: 12px; display: flex; align-items: center; gap: 5px; background: rgba(30,30,30,0.75); color: #fde68a; padding: 4px 10px; border-radius: 8px; font-size: 0.62rem; font-weight: 800; backdrop-filter: blur(4px); letter-spacing: 0.04em;">
                    🔒 STRICT MODE
                </div>
                @endif

                <div style="position: absolute; bottom: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.2; background: {{ $color['accent'] }}; filter: blur(20px);"></div>
            </div>

            {{-- Content Area --}}
            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text); line-height: 1.3; margin-bottom: 8px;">
                    {{ $exam->title }}
                </h3>
                <p style="font-size: 0.8rem; color: var(--muted); line-height: 1.6; margin-bottom: 20px; flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $exam->description ?? 'A comprehensive exam simulation to test your skills and readiness. Start now to evaluate your performance.' }}
                </p>

                {{-- Meta Info --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border); margin-bottom: 20px;">
                    <div>
                        <p style="font-size: 0.65rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Status</p>
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 99px; font-size: 0.65rem; font-weight: 800; background: #ecfdf5; color: #16a34a;">
                            ● Active
                        </span>
                    </div>
                    <div>
                        <p style="font-size: 0.65rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Mode</p>
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 99px; font-size: 0.65rem; font-weight: 800; {{ $isStrict ? 'background:#fef3c7;color:#b45309;' : 'background:#f1f5f9;color:#64748b;' }}">
                            {{ $isStrict ? '🔒 Strict' : '🔓 Practice' }}
                        </span>
                    </div>
                </div>

                {{-- Action Button --}}
                <a href="{{ route('test_taker.exam.detail', $exam->id) }}" 
                   style="display: block; width: 100%; text-align: center; padding: 12px; border-radius: 12px; background: {{ $color['accent'] }}; color: white; font-size: 0.85rem; font-weight: 800; text-decoration: none; transition: background 0.2s;"
                   onmouseover="this.style.filter='brightness(1.1)';"
                   onmouseout="this.style.filter='brightness(1)';">
                    View Details
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; background: white; border: 1.5px dashed var(--border); border-radius: 20px;">
            <div style="font-size: 3rem; margin-bottom: 16px;">📭</div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--text);">No Exams Available</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 8px;">Check back later or contact your administrator when new exams are published.</p>
        </div>
        @endforelse
    </div>
    
</div>
@endsection
