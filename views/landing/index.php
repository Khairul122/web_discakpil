<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data['title'] ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#7c3aed',
                    },
                }
            }
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            cursor: none;
        }

        body {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
            color: #1e293b;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #4f46e5, #7c3aed, #3b82f6);
            z-index: 10001;
            transition: width 0.1s ease;
        }

        .custom-cursor {
            position: fixed;
            width: 20px;
            height: 20px;
            border: 2px solid #4f46e5;
            border-radius: 50%;
            pointer-events: none;
            z-index: 10002;
            transition: transform 0.15s ease, background 0.15s ease;
            transform: translate(-50%, -50%);
        }

        .custom-cursor.hover {
            transform: translate(-50%, -50%) scale(2.5);
            background: rgba(79, 70, 229, 0.1);
            border-color: #7c3aed;
        }

        .cursor-dot {
            position: fixed;
            width: 6px;
            height: 6px;
            background: #4f46e5;
            border-radius: 50%;
            pointer-events: none;
            z-index: 10003;
            transform: translate(-50%, -50%);
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .parallax-layer {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            transition: transform 0.1s ease-out;
        }

        .layer-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            top: 10%;
            left: 20%;
        }

        .layer-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #7c3aed, #3b82f6);
            top: 60%;
            right: 15%;
        }

        .layer-3 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            bottom: 20%;
            left: 30%;
        }

        .glass {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(0, 0, 0, 0.05);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(0, 0, 0, 0.05),
                0 0 0 1px rgba(255, 255, 255, 0.5);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.7);
            transform: translateY(-8px) scale(1.02);
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(0, 0, 0, 0.05),
                0 0 0 1px rgba(79, 70, 229, 0.2);
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 50%;
            animation: particleFloat 20s infinite;
        }

        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.6;
            }
            100% {
                transform: translateY(-100vh) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            display: inline-block;
        }

        .gradient-text::after {
            content: attr(data-text);
            position: absolute;
            left: 0;
            top: 0;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gradient-text:hover::after {
            opacity: 1;
        }

        .glow-effect {
            transition: all 0.3s ease;
        }

        .glow-effect:hover {
            text-shadow:
                0 0 20px rgba(79, 70, 229, 0.5),
                0 0 40px rgba(124, 58, 237, 0.3),
                0 0 60px rgba(59, 130, 246, 0.2);
        }

        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #4f46e5, #7c3aed);
            border-radius: 6px;
            border: 2px solid #f1f5f9;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #4338ca, #6d28d9);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(12px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-overlay.active ~ .content-wrapper {
            transform: scale(0.98);
            filter: blur(8px);
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 2.5rem;
            max-width: 650px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            transform: scale(0.8) translateY(20px);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow:
                0 25px 80px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(0, 0, 0, 0.05);
        }

        .modal-overlay.active .modal-content {
            transform: scale(1) translateY(0);
        }

        .hero-gradient {
            background: radial-gradient(ellipse at top, rgba(79, 70, 229, 0.06) 0%, transparent 50%),
                        radial-gradient(ellipse at bottom, rgba(124, 58, 237, 0.04) 0%, transparent 50%);
        }

        .typing-cursor {
            display: inline-block;
            width: 3px;
            height: 1.2em;
            background: #4f46e5;
            margin-left: 4px;
            animation: blink 1s infinite;
            vertical-align: middle;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }

        .icon-container {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.08));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(79, 70, 229, 0.15);
            transition: all 0.3s ease;
        }

        .icon-container:hover {
            transform: scale(1.1);
            border-color: rgba(79, 70, 229, 0.3);
        }

        .icon-container.pulse i {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .misi-number {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow:
                0 12px 40px rgba(79, 70, 229, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }

        .misi-number:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .btn-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .btn-glow:hover::before {
            left: 100%;
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 25px;
            top: 40px;
            bottom: -40px;
            width: 2px;
            background: linear-gradient(180deg, #4f46e5, transparent);
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: 17px;
            top: 20px;
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
            transition: all 0.3s ease;
        }

        .timeline-item:hover .timeline-dot {
            box-shadow: 0 0 0 8px rgba(79, 70, 229, 0.3);
            transform: scale(1.2);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.2), transparent);
            margin: 0;
        }

        .visi-animation {
            width: 200px;
            height: 200px;
            position: relative;
            margin: 0 auto 2rem;
        }

        .visi-ring {
            position: absolute;
            border-radius: 50%;
            border: 3px solid rgba(79, 70, 229, 0.2);
            animation: rotate 10s linear infinite;
        }

        .visi-ring:nth-child(1) {
            width: 100%;
            height: 100%;
            animation-duration: 15s;
        }

        .visi-ring:nth-child(2) {
            width: 70%;
            height: 70%;
            top: 15%;
            left: 15%;
            animation-duration: 10s;
            animation-direction: reverse;
        }

        .visi-ring:nth-child(3) {
            width: 40%;
            height: 40%;
            top: 30%;
            left: 30%;
            animation-duration: 5s;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .visi-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: breathe 3s ease-in-out infinite;
        }

        @keyframes breathe {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.1); }
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            transition: all 0.4s ease;
        }

        .nav-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .stagger-grid-1 { transform: translateY(0); }
        .stagger-grid-2 { transform: translateY(30px); }
        .stagger-grid-3 { transform: translateY(60px); }
        .stagger-grid-4 { transform: translateY(90px); }

        @media (max-width: 1024px) {
            .stagger-grid-1, .stagger-grid-2, .stagger-grid-3, .stagger-grid-4 {
                transform: translateY(0);
            }
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .accordion-item.active .accordion-content {
            max-height: 200px;
        }

        .accordion-item.active .accordion-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>

    <div class="scroll-progress" id="scrollProgress"></div>

    <div class="custom-cursor" id="customCursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <div class="animated-bg">
        <div class="parallax-layer layer-1" id="parallax1"></div>
        <div class="parallax-layer layer-2" id="parallax2"></div>
        <div class="parallax-layer layer-3" id="parallax3"></div>
    </div>

    <div class="particles" id="particles"></div>

    <div class="content-wrapper">

        <nav class="nav-wrapper glass">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center">
                        <a href="index.php?controller=landing&action=index" class="flex items-center space-x-3 interactive">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-building-columns text-white text-xl"></i>
                            </div>
                            <span class="text-xl font-black gradient-text" data-text="DISDUKCAPIL">DISDUKCAPIL</span>
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="#beranda" class="interactive text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:bg-indigo-50">Beranda</a>
                            <a href="#tentang" class="interactive text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:bg-indigo-50">Tentang</a>
                            <a href="#visi" class="interactive text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:bg-indigo-50">Visi</a>
                            <a href="#misi" class="interactive text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:bg-indigo-50">Misi</a>
                             <a href="index.php?controller=auth&action=login" class="interactive text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:bg-indigo-50">Login</a>
                              <a href="index.php?controller=penilaianKuesioner&action=login" class="interactive text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold transition-all hover:bg-indigo-50">Penilaian</a>
                        </div>
                    </div>
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="interactive text-gray-700 hover:text-indigo-600 p-2">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden glass border-t border-gray-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="#beranda" class="interactive text-gray-700 hover:text-indigo-600 block px-4 py-2 rounded-lg text-base font-semibold">Beranda</a>
                    <a href="#tentang" class="interactive text-gray-700 hover:text-indigo-600 block px-4 py-2 rounded-lg text-base font-semibold">Tentang</a>
                    <a href="#visi" class="interactive text-gray-700 hover:text-indigo-600 block px-4 py-2 rounded-lg text-base font-semibold">Visi</a>
                    <a href="#misi" class="interactive text-gray-700 hover:text-indigo-600 block px-4 py-2 rounded-lg text-base font-semibold">Misi</a>
                </div>
            </div>
        </nav>

        <section id="beranda" class="min-h-screen flex items-center justify-center hero-gradient relative pt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <div data-aos="fade-down" data-aos-duration="1200">
                        <h1 class="text-6xl md:text-8xl font-black mb-8 leading-tight text-gray-900">
                            <span class="gradient-text glow-effect interactive" data-text="<?= $data['page_title'] ?>"><?= $data['page_title'] ?></span>
                        </h1>
                    </div>

                    <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <p class="text-3xl md:text-4xl font-light text-gray-600 mb-6">
                            <span id="typingText"></span><span class="typing-cursor"></span>
                        </p>
                    </div>

                    <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-12 leading-relaxed">
                            Mewujudkan pelayanan administrasi kependudukan yang prima, modern, dan terpercaya
                            untuk seluruh masyarakat Kota Padang melalui inovasi digital dan teknologi terkini
                        </p>
                    </div>

                    <div data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="600">
                        <div class="flex flex-col sm:flex-row gap-5 justify-center">
                            <a href="#tentang" class="btn-glow interactive px-10 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl font-bold text-white shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                                <i class="fas fa-rocket mr-3"></i>Jelajahi Layanan
                            </a>
                            <a href="#misi" class="btn-glow interactive px-10 py-5 glass rounded-xl font-bold text-gray-700 hover:bg-white transition-all hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-info-circle mr-3"></i>Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                <i class="fas fa-chevron-down text-3xl text-gray-400 interactive"></i>
            </div>
        </section>

        <div class="section-divider"></div>

        <section id="tentang" class="py-32 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20" data-aos="fade-up">
                    <h2 class="text-5xl md:text-6xl font-black mb-8 gradient-text"><?= $data['tentang']['judul'] ?></h2>
                    <p class="text-2xl text-gray-600 max-w-3xl mx-auto font-medium"><?= $data['tentang']['deskripsi'] ?></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php foreach ($data['tentang']['poin'] as $index => $poin): ?>
                    <div class="glass-card rounded-3xl p-8 stagger-grid-<?= $index + 1 ?>"
                         data-aos="<?= $index % 2 === 0 ? 'fade-right' : 'fade-left' ?>"
                         data-aos-duration="1000"
                         data-aos-delay="<?= $index * 150 ?>">
                        <div class="icon-container pulse">
                            <i class="<?= $poin['icon'] ?> text-4xl text-indigo-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900"><?= $poin['judul'] ?></h3>
                        <p class="text-gray-600 leading-relaxed mb-6"><?= $poin['deskripsi'] ?></p>
                        <button onclick="showModal('<?= $poin['judul'] ?>', '<?= addslashes($poin['deskripsi']) ?>')"
                                class="interactive text-indigo-600 hover:text-indigo-700 font-bold flex items-center transition-colors">
                            <span>Selengkapnya</span>
                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-2 transition-transform"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        <section id="visi" class="py-32 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="glass-card rounded-3xl p-16 md:p-20 relative overflow-hidden" data-aos="flip-left" data-aos-duration="1200">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full blur-3xl opacity-70"></div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-purple-100 to-blue-100 rounded-full blur-3xl opacity-70"></div>

                    <div class="relative z-10">
                        <div class="visi-animation" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="visi-ring"></div>
                            <div class="visi-ring"></div>
                            <div class="visi-ring"></div>
                            <i class="fas fa-eye visi-icon"></i>
                        </div>

                        <div class="flex items-center justify-center mb-8" data-aos="fade-up" data-aos-delay="200">
                            <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mr-5 shadow-xl">
                                <i class="fas fa-bullseye text-4xl text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-black text-gray-900">Visi Kami</h3>
                                <p class="text-gray-600 font-medium">Arah dan tujuan pelayanan</p>
                            </div>
                        </div>

                        <p class="text-3xl md:text-4xl leading-relaxed text-gray-900 text-center" data-aos="fade-up" data-aos-delay="400">
                            <?= $data['visi'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        <section id="misi" class="py-32 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20" data-aos="fade-up">
                    <h2 class="text-5xl md:text-6xl font-black mb-8 gradient-text">Misi Kami</h2>
                    <p class="text-2xl text-gray-600">Langkah strategis dalam mewujudkan visi bersama</p>
                </div>

                <div class="max-w-4xl mx-auto space-y-6">
                    <?php foreach ($data['misi'] as $index => $misi): ?>
                    <div class="accordion-item glass-card rounded-2xl interactive"
                         data-aos="fade-up"
                         data-aos-duration="800"
                         data-aos-delay="<?= $index * 100 ?>"
                         onclick="toggleAccordion(this)">
                        <div class="timeline-item p-8">
                            <div class="timeline-dot"></div>
                            <div class="flex items-start gap-6">
                                <div class="misi-number">
                                    <?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xl text-gray-700 leading-relaxed font-semibold">
                                        <?= $misi ?>
                                    </p>
                                    <div class="accordion-content mt-4">
                                        <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                                            <p class="text-sm text-gray-600">
                                                Implementasi misi ini dilakukan melalui kerja sama yang sinergis
                                                dengan seluruh stakeholder terkait dan komitmen berkelanjutan
                                                untuk peningkatan kualitas pelayanan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down accordion-icon text-indigo-600 text-xl transition-transform duration-300"></i>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        <footer class="py-20 bg-gradient-to-b from-gray-50 to-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                    <div data-aos="fade-up">
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-xl">
                                <i class="fas fa-building-columns text-white text-2xl"></i>
                            </div>
                            <span class="text-2xl font-black gradient-text">DISDUKCAPIL</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4 font-medium">
                            Dinas Kependudukan dan Pencatatan Sipil Kota Padang
                        </p>
                        <p class="text-gray-500 text-sm">
                            Melayani dengan sepenuh hati untuk masyarakat Kota Padang
                        </p>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="100">
                        <h4 class="text-xl font-black mb-6 text-gray-900">Kontak Kami</h4>
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt w-7 text-indigo-600 text-xl"></i>
                                <span class="ml-4 font-medium">Kota Padang, Sumatera Barat</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-phone w-7 text-indigo-600 text-xl"></i>
                                <span class="ml-4 font-medium">(0751) 123456</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-envelope w-7 text-indigo-600 text-xl"></i>
                                <span class="ml-4 font-medium">info@disdukcapil.padang.go.id</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock w-7 text-indigo-600 text-xl"></i>
                                <span class="ml-4 font-medium">Senin - Jumat: 08.00 - 16.00 WIB</span>
                            </div>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="200">
                        <h4 class="text-xl font-black mb-6 text-gray-900">Tautan Cepat</h4>
                        <div class="space-y-3">
                            <a href="#beranda" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                                <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
                                <span class="ml-3">Beranda</span>
                            </a>
                            <a href="#tentang" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                                <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
                                <span class="ml-3">Tentang Kami</span>
                            </a>
                            <a href="#visi" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                                <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
                                <span class="ml-3">Visi</span>
                            </a>
                            <a href="#misi" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                                <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
                                <span class="ml-3">Misi</span>
                            </a>
                            <a href="index.php?controller=auth&action=login" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                                <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
                                <span class="ml-3">Login</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-300 pt-10 text-center" data-aos="fade-up">
                    <p class="text-gray-500 font-medium">
                        &copy; <?= date('Y') ?> Dinas Kependudukan dan Pencatatan Sipil Kota Padang. All Rights Reserved.
                    </p>
                </div>
            </div>
        </footer>

    </div>

    <div id="modal-overlay" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-start mb-8">
                <h3 id="modal-title" class="text-3xl font-black gradient-text"></h3>
                <button onclick="closeModal()" class="interactive text-gray-400 hover:text-gray-600 transition-colors p-2">
                    <i class="fas fa-times text-3xl"></i>
                </button>
            </div>
            <div id="modal-body" class="text-gray-700 leading-relaxed"></div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-out-cubic',
            once: true,
            offset: 100,
        });

        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (Math.random() * 15 + 15) + 's';
                container.appendChild(particle);
            }
        }

        createParticles();

        const cursor = document.getElementById('customCursor');
        const cursorDot = document.getElementById('cursorDot');

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            cursorDot.style.left = e.clientX + 'px';
            cursorDot.style.top = e.clientY + 'px';

            moveParallax(e.clientX, e.clientY);
        });

        function moveParallax(x, y) {
            const layers = document.querySelectorAll('.parallax-layer');
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;
            const moveX = (x - centerX) / 30;
            const moveY = (y - centerY) / 30;

            layers.forEach((layer, index) => {
                const speed = (index + 1) * 0.5;
                layer.style.transform = `translate(${moveX * speed}px, ${moveY * speed}px)`;
            });
        }

        document.querySelectorAll('.interactive').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });

        const typingText = document.getElementById('typingText');
        const phrases = ['Melayani dengan Sepenuh Hati', 'Profesional dan Terpercaya', 'Inovatif dan Modern'];
        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;

        function typeText() {
            const currentPhrase = phrases[phraseIndex];

            if (isDeleting) {
                typingText.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
            } else {
                typingText.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
            }

            let typeSpeed = isDeleting ? 50 : 100;

            if (!isDeleting && charIndex === currentPhrase.length) {
                typeSpeed = 2000;
                isDeleting = true;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                typeSpeed = 500;
            }

            setTimeout(typeText, typeSpeed);
        }

        typeText();

        const scrollProgress = document.getElementById('scrollProgress');

        window.addEventListener('scroll', () => {
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (window.pageYOffset / windowHeight) * 100;
            scrollProgress.style.width = scrolled + '%';
        });

        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        function showModal(title, content) {
            const overlay = document.getElementById('modal-overlay');
            const modalTitle = document.getElementById('modal-title');
            const modalBody = document.getElementById('modal-body');

            modalTitle.textContent = title;
            modalBody.innerHTML = `
                <p class="text-xl leading-relaxed mb-6 font-medium">${content}</p>
                <div class="p-6 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border-2 border-indigo-100">
                    <h4 class="font-bold mb-3 text-xl text-indigo-700"><i class="fas fa-info-circle mr-2"></i>Informasi Layanan</h4>
                    <p class="text-base text-gray-700 leading-relaxed">
                        Untuk informasi lebih lanjut mengenai layanan ini, silakan hubungi kantor DISDUKCAPIL Kota Padang
                        atau kunjungi loket pelayanan kami pada jam kerja.
                    </p>
                </div>
            `;

            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const overlay = document.getElementById('modal-overlay');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('modal-overlay').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                closeModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        function toggleAccordion(element) {
            const allItems = document.querySelectorAll('.accordion-item');
            const wasActive = element.classList.contains('active');

            allItems.forEach(item => {
                item.classList.remove('active');
            });

            if (!wasActive) {
                element.classList.add('active');
            }
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        const navbar = document.querySelector('.nav-wrapper');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.4)';
                navbar.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.08)';
            }
        });
    </script>

</body>
</html>
