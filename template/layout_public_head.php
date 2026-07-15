<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title><?= $page_title ?? 'DISDUKCAPIL Kota Padang' ?></title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/app.css?v=<?= filemtime('assets/css/app.css') ?>" />
  <link rel="shortcut icon" href="assets/images/logo-pdf.png" />
</head>

<body class="bg-surface-page font-sans text-slate-700 min-h-screen flex flex-col">
  <header class="bg-white/90 backdrop-blur-md text-slate-800 shadow-soft-raised-sm sticky top-0 z-30 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
      <a href="index.php?controller=landing&action=index" class="flex items-center">
        <img src="assets/images/logo-pdf.png" alt="Logo DISDUKCAPIL Kota Padang" class="h-10 w-auto object-contain">
      </a>
      <nav class="flex items-center gap-2 text-sm font-medium">
        <a href="index.php?controller=landing&action=index" class="btn-gov-ghost !text-slate-600 hover:!bg-slate-100 hover:!text-slate-900">Beranda</a>
        <a href="index.php?controller=penilaianKuesioner&action=index" class="btn-gov-ghost !text-slate-600 hover:!bg-slate-100 hover:!text-slate-900">Kuesioner</a>
        <a href="index.php?controller=auth&action=index" class="btn-gov-gold !min-h-0 !py-2.5 !px-5 text-xs uppercase font-extrabold tracking-wider">Login</a>
      </nav>
    </div>
  </header>

  <main class="flex-1">
