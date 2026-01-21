<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - DISDUKCAPIL Kota Padang</title>

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
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
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

        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .animated-bg-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s ease-in-out infinite;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            right: -50px;
            animation-delay: 5s;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, 30px) rotate(90deg); }
            50% { transform: translate(0, 60px) rotate(180deg); }
            75% { transform: translate(-30px, 30px) rotate(270deg); }
        }

        .particles-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFloat 15s infinite;
        }

        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(100vh) translateX(0);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        .right-panel {
            flex: 1;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .parallax-layer {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.08;
            transition: transform 0.1s ease-out;
        }

        .layer-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            top: -10%;
            right: -10%;
        }

        .layer-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #7c3aed, #3b82f6);
            bottom: -10%;
            left: -10%;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
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

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-white {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-field {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(79, 70, 229, 0.1);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.9);
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            border: 1px solid rgba(239, 68, 68, 0.3);
            backdrop-filter: blur(10px);
        }

        .icon-circle {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: breathe 3s ease-in-out infinite;
        }

        @keyframes breathe {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        @media (max-width: 1024px) {
            .left-panel {
                display: none;
            }
            .right-panel {
                flex: 1;
            }
        }

        @media (max-width: 768px) {
            * {
                cursor: auto;
            }
            .custom-cursor, .cursor-dot {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="custom-cursor" id="customCursor"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <div class="login-wrapper">
        <div class="left-panel">
            <div class="animated-bg-left">
                <div class="floating-shape shape-1"></div>
                <div class="floating-shape shape-2"></div>
                <div class="floating-shape shape-3"></div>
            </div>

            <div class="particles-left" id="particlesLeft"></div>

            <div class="relative z-10 text-center px-12">
                <div class="icon-circle" data-aos="zoom-in" data-aos-duration="1000">
                    <i class="fas fa-building-columns text-6xl text-white"></i>
                </div>

                <h1 class="text-5xl md:text-6xl font-black mb-4 gradient-text-white" data-aos="fade-up" data-aos-delay="200">
                    DISDUKCAPIL
                </h1>
                <p class="text-2xl text-white/90 font-light mb-8" data-aos="fade-up" data-aos-delay="300">
                    Kota Padang
                </p>

                <div class="grid grid-cols-3 gap-4 mt-12" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card rounded-2xl p-6">
                        <i class="fas fa-users text-4xl text-white mb-3"></i>
                        <p class="text-3xl font-black text-white">24+</p>
                        <p class="text-sm text-white/80">Kecamatan</p>
                    </div>
                    <div class="stat-card rounded-2xl p-6">
                        <i class="fas fa-building text-4xl text-white mb-3"></i>
                        <p class="text-3xl font-black text-white">100+</p>
                        <p class="text-sm text-white/80">Kelurahan</p>
                    </div>
                    <div class="stat-card rounded-2xl p-6">
                        <i class="fas fa-id-card text-4xl text-white mb-3"></i>
                        <p class="text-3xl font-black text-white">1M+</p>
                        <p class="text-sm text-white/80">Penduduk</p>
                    </div>
                </div>

                <div class="mt-12" data-aos="fade-up" data-aos-delay="500">
                    <p class="text-lg text-white/80 leading-relaxed">
                        Melayani dengan sepenuh hati untuk masyarakat Kota Padang
                    </p>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="parallax-layer layer-1" id="parallax1"></div>
            <div class="parallax-layer layer-2" id="parallax2"></div>

            <div class="relative z-10 w-full max-w-lg px-8">
                <div class="glass-card rounded-3xl p-10" data-aos="fade-left" data-aos-duration="1200">
                    <div class="mb-8">
                        <h2 class="text-3xl font-black mb-2 gradient-text">
                            Selamat Datang
                        </h2>
                        <p class="text-gray-600">Silakan login untuk mengakses dashboard</p>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert-error rounded-xl p-4 mb-6" data-aos="shake">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <p class="text-red-700 font-medium"><?= $_SESSION['error'] ?></p>
                        </div>
                    </div>
                    <?php
                        unset($_SESSION['error']);
                    endif;
                    ?>

                    <form method="POST" action="index.php?controller=auth&action=login" class="space-y-5">
                        <div data-aos="fade-up" data-aos-delay="200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-indigo-600"></i>Username
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="username"
                                       required
                                       class="interactive input-field w-full px-5 py-4 rounded-xl outline-none text-gray-900 font-medium"
                                       placeholder="Masukkan username">
                                <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <div data-aos="fade-up" data-aos-delay="300">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-indigo-600"></i>Password
                            </label>
                            <div class="relative">
                                <input type="password"
                                       name="password"
                                       required
                                       class="interactive input-field w-full px-5 py-4 rounded-xl outline-none text-gray-900 font-medium"
                                       placeholder="Masukkan password"
                                       id="passwordInput">
                                <button type="button"
                                        onclick="togglePassword()"
                                        class="interactive absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="400">
                            <label class="flex items-center">
                                <input type="checkbox" class="interactive w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm font-medium text-gray-600">Ingat saya</span>
                            </label>
                            <a href="#" class="interactive text-sm font-semibold text-indigo-600 hover:text-indigo-700">Lupa password?</a>
                        </div>

                        <div data-aos="fade-up" data-aos-delay="500">
                            <button type="submit"
                                    class="interactive btn-primary w-full py-4 rounded-xl font-bold text-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center" data-aos="fade-up" data-aos-delay="600">
                        <p class="text-gray-600">
                            <i class="fas fa-home mr-2"></i>
                            <a href="index.php?controller=landing&action=index" class="interactive font-semibold text-indigo-600 hover:text-indigo-700">
                                Kembali ke Beranda
                            </a>
                        </p>
                    </div>
                </div>

                <div class="text-center mt-6" data-aos="fade-up" data-aos-delay="800">
                    <p class="text-gray-500 text-sm">
                        &copy; <?= date('Y') ?> DISDUKCAPIL Kota Padang
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-out-cubic',
            once: true,
        });

        function createParticles() {
            const container = document.getElementById('particlesLeft');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
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

        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>
