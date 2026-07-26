<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOEIC Simulator</title>
    <link rel="icon" type="image/png" href="{{ asset(config('tenant.active.favicon')) }}">
    <meta name="description" content="Platform simulasi TOEIC untuk sekolah mitra, dikembangkan oleh mahasiswa Sistem Informasi Itenas dalam program PKM Pengabdian Masyarakat.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 48px rgba(14,36,66,.12); }

        [data-reveal] { opacity: 0; transform: translateY(20px); transition: opacity .6s ease, transform .6s ease; }
        [data-reveal].visible { opacity: 1; transform: translateY(0); }
        [data-reveal-delay="1"] { transition-delay: .12s; }
        [data-reveal-delay="2"] { transition-delay: .24s; }

        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-7px)} }
        .float { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="bg-white antialiased overflow-x-hidden">


{{-- NAVBAR --}}
<nav style="background:rgba(255,255,255,.97); border-bottom:1px solid #f1f5f9; position:sticky; top:0; z-index:50; backdrop-filter:blur(8px);">
    <div class="max-w-5xl mx-auto px-6 py-3 flex items-center justify-between">
        <img src="{{ asset('assets/Logo-Toeic-Biru.png') }}" alt="TOEIC Simulator" style="height:30px; object-fit:contain;">
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" style="font-size:13px; font-weight:600; color:#475569;" class="hover:text-[#1a365d] transition-colors">Masuk</a>
            <a href="{{ route('register') }}" style="background:#1a395b; color:#fff; font-size:13px; font-weight:700; padding:8px 20px; border-radius:999px;" class="hover:opacity-90 transition-opacity">Daftar Sekarang</a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section style="background:linear-gradient(145deg,#0e2442 0%,#1a395b 55%,#1b4f72 100%); position:relative; overflow:hidden; padding:72px 24px 88px;">
    {{-- grid overlay --}}
    <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:36px 36px;pointer-events:none;"></div>
    {{-- glow blobs --}}
    <div style="position:absolute;top:-100px;right:-100px;width:420px;height:420px;border-radius:50%;background:rgba(85,182,187,.08);filter:blur(90px);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-80px;left:-80px;width:360px;height:360px;border-radius:50%;background:rgba(59,130,246,.07);filter:blur(80px);pointer-events:none;"></div>

    <div class="max-w-5xl mx-auto relative" style="z-index:1;">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-14">

            {{-- LEFT --}}
            <div class="flex-1 text-center lg:text-left flex flex-col items-center lg:items-start">
                
                {{-- Logo toeic putih --}}
                <img src="{{ asset('assets/Logo-Toeic-Putih.png') }}" alt="TOEIC Simulator" style="height:84px; object-fit:contain; margin-bottom:28px;" class="hidden lg:block">
                <img src="{{ asset('assets/Logo-Toeic-Putih.png') }}" alt="TOEIC Simulator" style="height:64px; object-fit:contain; margin-bottom:24px;" class="lg:hidden">

                <p style="color:rgba(255,255,255,.7);font-size:16px;line-height:1.75;max-width:540px;margin-bottom:36px;">
                    Platform simulasi TOEIC berbasis web, dikembangkan oleh mahasiswa Program Studi Sistem Informasi Itenas untuk mendukung pelatihan bahasa Inggris di sekolah mitra PKM.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="{{ route('register') }}" style="background:#fff;color:#0e2442;font-size:14px;font-weight:700;padding:14px 32px;border-radius:999px;text-align:center;box-shadow:0 8px 32px rgba(0,0,0,.25);" class="hover:opacity-90 transition-opacity">
                        Mulai Latihan — Gratis
                    </a>
                    <a href="#tentang" style="border:1.5px solid rgba(255,255,255,.25);color:#fff;font-size:14px;font-weight:600;padding:14px 32px;border-radius:999px;text-align:center;" class="hover:bg-white/10 transition-all">
                        Pelajari Program ↓
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex flex-wrap justify-center lg:justify-start gap-8 mt-14">
                    @foreach([['200+','Soal Latihan'],['7','Bagian TOEIC'],['Instan','Penilaian'],['Gratis','Untuk Peserta PKM']] as [$v,$l])
                    <div class="text-center lg:text-left">
                        <p style="font-size:22px;font-weight:800;color:#fff;">{{ $v }}</p>
                        <p style="font-size:11px;color:rgba(255,255,255,.45);margin-top:2px;font-weight:500;">{{ $l }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Institusi --}}
            <div class="flex-shrink-0 float w-full lg:w-auto mt-12 lg:mt-0">
                <div style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.12); border-radius:32px; padding:36px; width:100%; max-width:340px; margin:0 auto; backdrop-filter: blur(16px); box-shadow: 0 32px 64px rgba(0,0,0,0.3); display: flex; flex-direction: column; gap: 20px; align-items: center;">
                    <p style="font-size:12px;font-weight:700;color:rgba(255,255,255,0.6);letter-spacing:.1em; text-transform: uppercase; margin-bottom: 4px;">Didukung Oleh</p>
                    
                    {{-- Itenas --}}
                    <div style="background:#fff; border-radius:20px; padding:16px 24px; width:100%; display:flex; justify-content:center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <img src="{{ asset('assets/logo-Itenas-2.png') }}" alt="Itenas" style="height:52px; object-fit:contain;">
                    </div>
                    
                    {{-- LPPM --}}
                    <div style="background:#fff; border-radius:20px; padding:16px 24px; width:100%; display:flex; justify-content:center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <img src="{{ asset('assets/lppm.png') }}" alt="LP2M Itenas" style="height:44px; object-fit:contain;">
                    </div>

                    {{-- Prodi SI --}}
                    <div style="background:#fff; border-radius:20px; padding:16px 24px; width:100%; display:flex; justify-content:center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <img src="{{ asset('assets/Logo-Sistem-Informasi.jpg') }}" alt="Prodi Sistem Informasi" style="height:44px; object-fit:contain;">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- TENTANG PROGRAM --}}
<section id="tentang" class="py-20 lg:py-28 px-6 bg-white">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col lg:flex-row items-start gap-12 lg:gap-20">

            {{-- Kiri --}}
            <div class="w-full lg:w-[42%] flex-shrink-0" data-reveal>
                <div style="position:relative;">
                    <div style="position:absolute;bottom:-10px;right:-10px;width:100%;height:100%;border-radius:24px;background:#f8fafc;border:1px solid #e2e8f0;"></div>
                    <div style="position:relative;background:#1a395b;border-radius:24px;padding:32px;color:#fff;">
                        <span style="display:inline-block;background:rgba(85,182,187,.2);color:#6ecdd2;font-size:11px;font-weight:700;padding:5px 12px;border-radius:999px;margin-bottom:20px;">PKM-PMP</span>
                        <h3 style="color:#ffffff;font-size:17px;font-weight:800;line-height:1.5;margin-bottom:14px;">Pengabdian Masyarakat melalui Teknologi Digital</h3>
                        <p style="font-size:13px;color:rgba(255,255,255,.7);line-height:1.75;margin-bottom:24px;">
                            Program ini hadir untuk membantu siswa sekolah mitra berlatih TOEIC secara mandiri — terstruktur, terukur, dan tanpa biaya.
                        </p>
                        <ul style="display:flex;flex-direction:column;gap:12px;">
                            @foreach(['Pelatihan TOEIC gratis untuk sekolah mitra','Bimbingan langsung dari tim mahasiswa Itenas','Akses platform selama masa PKM berlangsung','Pendanaan resmi dari LP2M Itenas'] as $p)
                            <li style="display:flex;align-items:flex-start;gap:10px;">
                                <span style="width:18px;height:18px;border-radius:50%;background:rgba(85,182,187,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                                    <svg width="10" height="10" viewBox="0 0 20 20" fill="#55b6bb"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </span>
                                <p style="font-size:13px;color:rgba(255,255,255,.75);">{{ $p }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Kanan --}}
            <div class="w-full lg:flex-1" data-reveal data-reveal-delay="1">
                <span style="font-size:11px;font-weight:700;color:#55b6bb;letter-spacing:.08em;text-transform:uppercase;">Tentang Program</span>
                <h2 style="font-size:30px;font-weight:800;color:#1a365d;line-height:1.3;margin:12px 0 20px;">Mengapa Platform<br>Ini Dikembangkan?</h2>
                <p style="color:#64748b;font-size:14px;line-height:1.8;margin-bottom:14px;">
                    Akses terhadap simulasi tes TOEIC yang terstandarisasi masih sangat terbatas di sekolah-sekolah menengah. Banyak siswa yang belum pernah mencoba format tes ini sebelum menghadapi ujian sesungguhnya.
                </p>
                <p style="color:#64748b;font-size:14px;line-height:1.8;margin-bottom:28px;">
                    Melalui program PKM Pengabdian Masyarakat, tim mahasiswa Prodi Sistem Informasi Itenas menghadirkan platform latihan TOEIC berbasis web yang gratis, mudah diakses, dan dilengkapi penilaian otomatis.
                </p>

                {{-- 4 highlight cards --}}
                <div class="grid grid-cols-2 gap-3">
                    @foreach([
                        ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','Simulasi TOEIC','Format standar internasional','#eff6ff','#2563eb'],
                        ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10','Skor Otomatis','Nilai instan setelah selesai','#f0fdf4','#16a34a'],
                        ['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0','Timer Ujian','Sesuai standar TOEIC','#fefce8','#ca8a04'],
                        ['M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','Riwayat Belajar','Pantau perkembangan skor','#faf5ff','#9333ea'],
                    ] as [$icon,$title,$desc,$bg,$color])
                    <div style="background:{{ $bg }};border-radius:16px;padding:16px;display:flex;align-items:flex-start;gap:12px;" class="card-hover">
                        <svg width="18" height="18" fill="none" stroke="{{ $color }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;">
                            <path d="{{ $icon }}"/>
                        </svg>
                        <div>
                            <p style="font-size:13px;font-weight:700;color:#1e293b;">{{ $title }}</p>
                            <p style="font-size:11px;color:#64748b;margin-top:2px;">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CARA MENGGUNAKAN --}}
<section style="background:#f8fafc;padding:80px 24px;" class="lg:py-28">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14" data-reveal>
            <span style="font-size:11px;font-weight:700;color:#55b6bb;letter-spacing:.08em;text-transform:uppercase;">Cara Menggunakan</span>
            <h2 style="font-size:28px;font-weight:800;color:#1a365d;margin:12px 0 10px;">Mulai Berlatih dalam 3 Langkah</h2>
            <p style="font-size:14px;color:#64748b;">Mudah dan cepat — tidak perlu instalasi apapun.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['01','Daftar Akun','Buat akun gratis menggunakan email sekolah atau email pribadi. Proses pendaftaran hanya butuh kurang dari 2 menit.','#eff6ff','#1d4ed8'],
                ['02','Pilih Latihan','Pilih mode latihan per bagian atau ikuti simulasi ujian penuh. Semua soal mengikuti format TOEIC standar.','#f0fdf4','#15803d'],
                ['03','Lihat Hasil','Selesai ujian, skor langsung tampil lengkap dengan rincian per bagian. Kerjakan lagi untuk melihat perkembangan.','#faf5ff','#7e22ce'],
            ] as [$no,$title,$desc,$bg,$color])
            <div style="background:#fff;border-radius:20px;padding:28px;border:1px solid #e2e8f0;" class="card-hover" data-reveal>
                <div style="width:48px;height:48px;border-radius:14px;background:{{ $bg }};color:{{ $color }};font-size:20px;font-weight:800;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                    {{ $no }}
                </div>
                <h3 style="font-size:15px;font-weight:700;color:#1a365d;margin-bottom:8px;">{{ $title }}</h3>
                <p style="font-size:13px;color:#64748b;line-height:1.75;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- INSTITUSI --}}
<section class="py-20 lg:py-28 px-6 bg-white">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14" data-reveal>
            <span style="font-size:11px;font-weight:700;color:#55b6bb;letter-spacing:.08em;text-transform:uppercase;">Institusi & Mitra</span>
            <h2 style="font-size:28px;font-weight:800;color:#1a365d;margin:12px 0 10px;">Didukung Institusi Terpercaya</h2>
            <p style="font-size:14px;color:#64748b;max-width:420px;margin:0 auto;">Kolaborasi akademik dan industri untuk menghadirkan pendidikan bahasa Inggris yang merata.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @foreach([
                ['assets/logo-Itenas-2.png','Itenas','Institut Teknologi Nasional','Itenas Bandung','Institusi Penyelenggara','#eff6ff','#1d4ed8','Perguruan tinggi teknologi yang menaungi program PKM ini secara kelembagaan dan akademik.'],
                ['assets/lppm.png','LP2M Itenas','LP2M Itenas','Lembaga Penelitian & Pengabdian','Pemberi Dana','#f0fdf4','#15803d','Memberikan pendanaan resmi dan pembinaan selama program PKM berlangsung.'],
                ['assets/Logo-Sistem-Informasi.jpg','Prodi SI','Prodi Sistem Informasi','Itenas Bandung','Pengembang Platform','#faf5ff','#7e22ce','Tim mahasiswa dan dosen Prodi SI yang merancang dan mengembangkan platform ini.'],
            ] as [$img,$alt,$name,$sub,$role,$bg,$color,$desc])
            <div style="border:1px solid #e2e8f0;border-radius:24px;padding:28px;display:flex;flex-direction:column;align-items:center;text-align:center;" class="card-hover" data-reveal>
                <div style="width:80px;height:80px;border-radius:18px;background:#fff;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;overflow:hidden;padding:8px;margin-bottom:18px;box-shadow:0 2px 8px rgba(0,0,0,.06);">
                    <img src="{{ asset($img) }}" alt="{{ $alt }}" style="width:100%;height:100%;object-fit:contain;">
                </div>
                <span style="font-size:11px;font-weight:700;padding:4px 12px;border-radius:999px;background:{{ $bg }};color:{{ $color }};margin-bottom:14px;">{{ $role }}</span>
                <h3 style="font-size:14px;font-weight:800;color:#1a365d;margin-bottom:4px;">{{ $name }}</h3>
                <p style="font-size:11px;color:#94a3b8;font-weight:500;margin-bottom:12px;">{{ $sub }}</p>
                <p style="font-size:12px;color:#64748b;line-height:1.7;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>

        {{-- Mitra industri --}}
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:18px;padding:24px;" class="flex flex-col sm:flex-row items-center gap-5" data-reveal>
            <div style="width:60px;height:60px;border-radius:14px;background:#fff;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;padding:6px;">
                <img src="{{ asset(config('tenant.active.logo_light')) }}" alt="PT Edukasi Persada Indonesia" style="width:100%;height:100%;object-fit:contain;">
            </div>
            <div class="text-center sm:text-left">
                <span style="font-size:11px;font-weight:700;color:#b45309;background:#fef3c7;padding:3px 10px;border-radius:999px;">Mitra Industri</span>
                <h3 style="font-size:14px;font-weight:800;color:#1a365d;margin:8px 0 4px;">PT Edukasi Persada Indonesia</h3>
                <p style="font-size:12px;color:#64748b;line-height:1.7;max-width:560px;">Lembaga pendidikan bahasa Inggris yang menyediakan infrastruktur platform, bank soal, dan dukungan operasional sebagai mitra industri program PKM ini.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="background:linear-gradient(145deg,#0e2442 0%,#1a395b 55%,#1b4f72 100%);padding:80px 24px;text-align:center;position:relative;overflow:hidden;" class="lg:py-28">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:500px;height:250px;background:rgba(85,182,187,.08);border-radius:50%;filter:blur(70px);pointer-events:none;"></div>
    <div class="max-w-xl mx-auto relative" style="z-index:1;" data-reveal>
        <img src="{{ asset('assets/Logo-Toeic-Putih.png') }}" alt="TOEIC Simulator" style="height:44px;object-fit:contain;margin:0 auto 28px;display:block;opacity:.9;">
        <h2 style="font-size:32px;font-weight:800;color:#fff;line-height:1.35;margin-bottom:16px;">Siap Berlatih TOEIC<br>Hari Ini?</h2>
        <p style="color:rgba(255,255,255,.6);font-size:14px;line-height:1.75;margin-bottom:36px;">
            Daftar gratis dan mulai latihan soal TOEIC sekarang. Terbuka untuk seluruh peserta program PKM dari sekolah mitra Itenas.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('register') }}" style="background:#fff;color:#0e2442;font-size:14px;font-weight:700;padding:14px 36px;border-radius:999px;box-shadow:0 8px 32px rgba(0,0,0,.25);" class="hover:opacity-90 transition-opacity">
                Daftar Sekarang — Gratis
            </a>
            <a href="{{ route('login') }}" style="border:1.5px solid rgba(255,255,255,.25);color:#fff;font-size:14px;font-weight:600;padding:14px 36px;border-radius:999px;" class="hover:bg-white/10 transition-all">
                Sudah punya akun? Masuk
            </a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer style="background:#0a1e36;padding:28px 24px;border-top:1px solid rgba(255,255,255,.06);">
    <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <img src="{{ asset('assets/Logo-Toeic-Putih.png') }}" alt="TOEIC Simulator" style="height:22px;object-fit:contain;opacity:.7;">
        <p style="font-size:11px;color:rgba(255,255,255,.3);text-align:center;">
            PKM Pengabdian Masyarakat · Prodi Sistem Informasi Itenas · Didukung LP2M Itenas & PT Edukasi Persada Indonesia
        </p>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" style="font-size:11px;color:rgba(255,255,255,.35);" class="hover:text-white/60 transition-colors">Masuk</a>
            <a href="{{ route('register') }}" style="font-size:11px;color:rgba(255,255,255,.35);" class="hover:text-white/60 transition-colors">Daftar</a>
        </div>
    </div>
</footer>

<script>
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));
</script>
</body>
</html>
