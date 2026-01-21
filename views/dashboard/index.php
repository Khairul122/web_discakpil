<!DOCTYPE html>
<html lang="id">
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
        }

        body {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
            color: #1e293b;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(0, 0, 0, 0.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>

    <nav class="glass-card border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-building-columns text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black gradient-text">DISDUKCAPIL</h1>
                        <p class="text-sm text-gray-600">Dashboard</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="font-bold text-gray-900"><?= htmlspecialchars($data['user']['nama_lengkap']) ?></p>
                        <p class="text-sm text-gray-600 capitalize"><?= htmlspecialchars($data['user']['role']) ?></p>
                    </div>
                    <a href="index.php?controller=dashboard&action=logout"
                       class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 rounded-xl font-bold text-white shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass-card rounded-3xl p-10" data-aos="fade-up">
            <div class="text-center mb-10">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
                    <i class="fas fa-user-shield text-5xl text-white"></i>
                </div>
                <h2 class="text-4xl font-black gradient-text mb-4">
                    Selamat Datang, <?= htmlspecialchars($data['user']['nama_lengkap']) ?>!
                </h2>
                <p class="text-xl text-gray-600">
                    Anda login sebagai <span class="font-bold text-indigo-600 capitalize"><?= htmlspecialchars($data['user']['role']) ?></span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border-2 border-blue-200" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-users text-2xl text-white"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">Penduduk</h3>
                    </div>
                    <p class="text-3xl font-black text-blue-600">0</p>
                    <p class="text-sm text-gray-600 mt-2">Total Data Penduduk</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border-2 border-purple-200" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-id-card text-2xl text-white"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">KTP</h3>
                    </div>
                    <p class="text-3xl font-black text-purple-600">0</p>
                    <p class="text-sm text-gray-600 mt-2">Permohonan KTP</p>
                </div>

                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-6 border-2 border-indigo-200" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-file-alt text-2xl text-white"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">KK</h3>
                    </div>
                    <p class="text-3xl font-black text-indigo-600">0</p>
                    <p class="text-sm text-gray-600 mt-2">Kartu Keluarga</p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 border-2 border-gray-200" data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-2xl font-black text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-indigo-600 mr-2"></i>
                    Informasi Sistem
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span>Sistem autentikasi berfungsi dengan baik</span>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span>Dashboard siap untuk dikembangkan lebih lanjut</span>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span>Database terkoneksi dengan benar</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-out-cubic',
            once: true,
        });
    </script>

</body>
</html>
