<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title><?= $page_title ?? 'DISDUKCAPIL Kota Padang' ?></title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Merriweather:wght@600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/app.css" />
  <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body class="bg-surface-page font-sans text-slate-700 min-h-screen flex flex-col">
  <header class="bg-gradient-to-r from-gov-blue-900 to-gov-blue-800 text-white shadow-soft-raised-sm sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
      <a href="index.php?controller=landing&action=index" class="flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 shadow-soft-raised-sm">
          <i class="fas fa-building-columns text-gov-blue-950"></i>
        </div>
        <div class="leading-tight">
          <p class="font-serif font-bold text-sm">DISDUKCAPIL</p>
          <p class="text-xs text-white/70">Kota Padang</p>
        </div>
      </a>
      <nav class="flex items-center gap-2 text-sm font-medium">
        <a href="index.php?controller=landing&action=index" class="btn-gov-ghost !text-white hover:!bg-white/10">Beranda</a>
        <a href="index.php?controller=penilaianKuesioner&action=index" class="btn-gov-ghost !text-white hover:!bg-white/10">Kuesioner</a>
        <a href="index.php?controller=auth&action=index" class="btn-gov-gold !min-h-0 !py-2">Login</a>
      </nav>
    </div>
  </header>

  <main class="flex-1">
