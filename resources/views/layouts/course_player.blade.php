<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Course Player') - {{ config('app.name', 'IC-EDU') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/test_taker.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --cp-sidebar-width: 340px;
            --cp-topbar-height: 64px;
        }
        body { margin: 0; padding: 0; overflow: hidden; background: var(--bg); font-family: 'Plus Jakarta Sans', sans-serif; }
        .cp-container { display: flex; flex-direction: column; height: 100vh; }
        
        .cp-topbar {
            height: var(--cp-topbar-height);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 20px;
            z-index: 50;
        }
        .cp-topbar-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text); font-weight: 800; font-family: 'Poppins', sans-serif; }
        .cp-topbar-title { border-left: 1px solid var(--border); padding-left: 20px; font-weight: 700; color: var(--text); font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; }
        .cp-topbar-exit { display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; background: var(--base); color: var(--muted); font-size: 0.8rem; font-weight: 700; text-decoration: none; border: 1px solid var(--border); transition: all 0.2s; }
        .cp-topbar-exit:hover { background: var(--border); color: var(--text); }
        
        .cp-body { display: flex; flex: 1; overflow: hidden; }
        
        .cp-content {
            flex: 1;
            overflow-y: auto;
            position: relative;
            background: var(--bg);
            scroll-behavior: smooth;
        }
        
        .cp-sidebar {
            width: var(--cp-sidebar-width);
            flex-shrink: 0;
            background: var(--surface);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 40;
            box-shadow: -4px 0 20px rgba(0,0,0,0.02);
            transition: margin-right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-right: 0;
        }
        .cp-sidebar.collapsed {
            margin-right: calc(var(--cp-sidebar-width) * -1);
        }
        
        .cp-sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }
        .cp-sidebar-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
            background: var(--surface);
        }
        .cp-module {
            margin-bottom: 8px;
        }
        .cp-module-title {
            padding: 12px 20px;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            background: var(--surface);
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(8px);
            background: rgba(255,255,255,0.9);
        }
        .cp-lesson {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px 12px 24px;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }
        .cp-lesson:hover { background: var(--base); }
        .cp-lesson.active { background: #eff6ff; }
        .cp-lesson.active::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--blue); }
        
        .cp-lesson-icon { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: white; border: 1.5px solid var(--border); flex-shrink: 0; color: var(--muted); transition: all 0.3s; }
        .cp-lesson.completed .cp-lesson-icon { background: #10b981; border-color: #10b981; color: white; }
        .cp-lesson.active .cp-lesson-icon { border-color: var(--blue); color: var(--blue); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        
        .cp-lesson-info { min-width: 0; flex: 1; }
        .cp-lesson-title { font-size: 0.85rem; font-weight: 700; color: var(--text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cp-lesson-meta { font-size: 0.7rem; font-weight: 600; color: var(--muted); display: flex; align-items: center; gap: 8px; }
        
        .cp-topbar-actions { display: flex; align-items: center; gap: 12px; }
        .cp-sidebar-toggle { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; background: transparent; color: var(--text); border: none; cursor: pointer; transition: all 0.2s; }
        .cp-sidebar-toggle:hover { background: var(--base); }

        /* Layout modifications for smaller screens */
        @media (max-width: 1024px) {
            .cp-body { flex-direction: column-reverse; }
            .cp-sidebar { width: 100%; height: 350px; border-left: none; border-top: 1px solid var(--border); margin-right: 0; }
            .cp-sidebar.collapsed { margin-right: 0; display: none; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="cp-container">
        <header class="cp-topbar" style="justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, var(--blue), #4f46e5); display: flex; align-items: center; justify-content: center;">
                    <svg style="width:14px;height:14px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253"/></svg>
                </div>
                <div>
                    <p style="font-size: 0.6rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; line-height: 1;">IC-EDU Course</p>
                    <p style="font-size: 0.85rem; font-weight: 800; color: var(--text); line-height: 1.2;">{{ $course->title ?? 'Course Player' }}</p>
                </div>
            </div>
            
            <div class="cp-topbar-actions">
                <a href="{{ isset($course) ? route('test_taker.course.show', $course->id) : route('test_taker.dashboard') }}" class="cp-topbar-exit">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Course Overview
                </a>
                <button class="cp-sidebar-toggle" id="btn-toggle-sidebar" title="Toggle Sidebar">
                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </header>
        
        <div class="cp-body">
            <main class="cp-content">
                @yield('content')
            </main>
            
            <aside class="cp-sidebar" id="cp-sidebar">
                <div class="cp-sidebar-header">
                    <h3 style="font-size: 1.15rem; font-weight: 900; color: var(--text);">Course Content</h3>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px;">
                        <p style="font-size: 0.75rem; font-weight: 700; color: var(--muted);">{{ $completedCount ?? 0 }} / {{ $totalLessons ?? 0 }} Completed</p>
                        @php $progressPct = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0; @endphp
                        <p style="font-size: 0.75rem; font-weight: 800; color: var(--blue);">{{ $progressPct }}%</p>
                    </div>
                    <div style="height: 6px; border-radius: 99px; background: var(--base); margin-top: 8px; overflow: hidden; border: 1px solid var(--border);">
                        <div style="height: 100%; width: {{ $progressPct }}%; background: #10b981; transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);"></div>
                    </div>
                </div>
                
                <div class="cp-sidebar-list">
                    @foreach($course->modules as $module)
                    <div class="cp-module">
                        <div class="cp-module-title">{{ $module->title }}</div>
                        @foreach($module->lessons as $l)
                            @php
                                $isActive = (isset($lesson) && $lesson->id === $l->id);
                                $isLCompleted = in_array($l->id, $completedLessonIds ?? []);
                                
                                $icon = match($l->type) {
                                    'video' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                    'pdf' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
                                    'text' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>',
                                    'quiz' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                    'audio' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>',
                                    'link' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>',
                                    default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                                };
                                
                                if ($isLCompleted) {
                                    $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>';
                                }
                            @endphp
                            <a href="{{ route('test_taker.course.lesson', [$course->id, $l->id]) }}" class="cp-lesson {{ $isActive ? 'active' : '' }} {{ $isLCompleted ? 'completed' : '' }}">
                                <div class="cp-lesson-icon">
                                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                                </div>
                                <div class="cp-lesson-info">
                                    <div class="cp-lesson-title">{{ $l->title }}</div>
                                    <div class="cp-lesson-meta">
                                        {{ ucfirst($l->type) }}
                                        @if($l->duration_minutes) &bull; {{ $l->duration_minutes }} min @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('btn-toggle-sidebar');
            const sidebar = document.getElementById('cp-sidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
