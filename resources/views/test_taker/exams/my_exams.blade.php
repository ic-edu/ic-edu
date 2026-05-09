@extends('layouts.test_taker')
@section('title', 'My Enrolled Exams')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">
    
    {{-- HEADER SECTION --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 1.8rem; font-weight: 900; color: var(--text); letter-spacing: -0.02em;">My Exams</h1>
        <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">Ujian dan simulasi yang Anda miliki saat ini.</p>
    </div>

    @if(session('success'))
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
        {{ session('error') }}
    </div>
    @endif

    {{-- EXAMS GRID --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr)); gap: 24px;">
        @forelse($enrollments as $enrollment)
        @php
            $exam = $enrollment->exam;
            $latestAttempt = $exam->attempts->first();
            
            $bgColors = [
                ['bg' => 'linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%)', 'tx' => '#1d4ed8', 'accent' => '#3b82f6', 'emoji' => '🎧'],
                ['bg' => 'linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%)', 'tx' => '#6d28d9', 'accent' => '#7c3aed', 'emoji' => '🗣️'],
                ['bg' => 'linear-gradient(135deg, #bbf7d0 0%, #86efac 100%)', 'tx' => '#15803d', 'accent' => '#16a34a', 'emoji' => '📖'],
                ['bg' => 'linear-gradient(135deg, #fef08a 0%, #fde047 100%)', 'tx' => '#a16207', 'accent' => '#ca8a04', 'emoji' => '✍️'],
                ['bg' => 'linear-gradient(135deg, #fbcfe8 0%, #f9a8d4 100%)', 'tx' => '#9d174d', 'accent' => '#db2777', 'emoji' => '📝'],
            ];
            $color = $bgColors[$loop->index % count($bgColors)];
        @endphp
        
        <div class="card anim-in d{{ ($loop->index % 5) + 1 }}" style="display: flex; flex-direction: column; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: default;">
            
            {{-- Illustration Area --}}
            <div style="height: 180px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; background: {{ $color['bg'] }};">
                
                {{-- Category Badge --}}
                <div style="position: absolute; top: 16px; left: 16px; background: rgba(255,255,255,0.9); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: {{ $color['tx'] }}; backdrop-filter: blur(4px);">
                    {{ $exam->examType->name ?? 'Exam' }}
                </div>
                
                {{-- Duration Badge --}}
                <div style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.8); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; color: #334155; backdrop-filter: blur(4px);">
                    ⏱️ {{ $exam->duration ?? ($exam->total_duration ?? 120) }} Mins
                </div>

                <div style="font-size: 4rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1)); user-select: none;">
                    {{ $color['emoji'] }}
                </div>

                <div style="position: absolute; bottom: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.2; background: {{ $color['accent'] }}; filter: blur(20px);"></div>
            </div>

            {{-- Content Area --}}
            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text); line-height: 1.3; margin-bottom: 8px;">
                    {{ $exam->title }}
                </h3>
                <p style="font-size: 0.8rem; color: var(--muted); line-height: 1.6; margin-bottom: 20px; flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ strip_tags($exam->description) ?? 'A comprehensive exam simulation to test your skills and readiness.' }}
                </p>

                {{-- Action Area --}}
                <div style="padding-top: 16px; border-top: 1px solid var(--border); margin-bottom: 10px;">
                    @if($latestAttempt && $latestAttempt->status === 'finished')
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 0.75rem; font-weight: 700; color: #f59e0b;">Status Nilai:</span>
                                <span style="font-size: 0.8rem; font-weight: 800; color: #f59e0b;">Menunggu Penilaian Akhir</span>
                            </div>
                            <button disabled style="width: 100%; padding: 12px; border-radius: 12px; background: #e5e7eb; color: #9ca3af; font-size: 0.85rem; font-weight: 800; border: none; cursor: not-allowed;">
                                Exam Completed
                            </button>
                        </div>
                    @elseif($latestAttempt && $latestAttempt->status === 'graded')
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 0.75rem; font-weight: 700; color: #16a34a;">Status Nilai:</span>
                                <span style="font-size: 0.8rem; font-weight: 800; color: #16a34a;">Selesai Dinilai</span>
                            </div>
                            <a href="{{ route('test_taker.exam.result', $latestAttempt->id) }}" style="display: block; text-align: center; width: 100%; padding: 12px; border-radius: 12px; background: #10b981; color: white; font-size: 0.85rem; font-weight: 800; text-decoration: none; transition: filter 0.2s;" onmouseover="this.style.filter='brightness(1.1)';" onmouseout="this.style.filter='brightness(1)';">
                                Lihat Hasil Akhir
                            </a>
                        </div>
                    @else
                        <form action="{{ route('test_taker.exam.start', $exam->id) }}" method="POST">
                            @csrf
                            @if($latestAttempt && $latestAttempt->status === 'ongoing')
                                <button type="submit" 
                                        style="width: 100%; padding: 12px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b, #ea580c); color: white; font-size: 0.85rem; font-weight: 800; border: none; cursor: pointer; transition: filter 0.2s;"
                                        onmouseover="this.style.filter='brightness(1.1)';" onmouseout="this.style.filter='brightness(1)';">
                                    Resume Exam
                                </button>
                            @else
                                <button type="submit" 
                                        style="width: 100%; padding: 12px; border-radius: 12px; background: var(--primary); color: white; font-size: 0.85rem; font-weight: 800; border: none; cursor: pointer; transition: filter 0.2s;"
                                        onmouseover="this.style.filter='brightness(1.1)';" onmouseout="this.style.filter='brightness(1)';">
                                    Start Exam
                                </button>
                            @endif
                        </form>
                    @endif
                </div>
                
                <a href="{{ route('test_taker.exam.detail', $exam->id) }}" style="text-align: center; font-size: 0.75rem; font-weight: 700; color: var(--blue); text-decoration: none; margin-top: 8px;">
                    View Exam Details →
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; background: white; border: 1.5px dashed var(--border); border-radius: 20px;">
            <div style="font-size: 3rem; margin-bottom: 16px;">📚</div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--text);">Anda belum memiliki ujian</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 8px; margin-bottom: 16px;">Silakan enroll (daftar) pada ujian simulasi yang tersedia.</p>
            <a href="{{ route('test_taker.exam.index') }}" style="display: inline-block; padding: 10px 20px; background: var(--primary); color: white; font-size: 0.85rem; font-weight: 700; border-radius: 8px; text-decoration: none;">Browse Exams</a>
        </div>
        @endforelse
    </div>
    
</div>
@endsection
