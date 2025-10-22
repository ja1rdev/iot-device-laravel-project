<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Demo Laravel + PostgreSQL')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- Main styles colors -->
  <style>
  :root{
    --bg-dark: #071023;
    --surface: #0f1724;
    --brand: #0ea5ff;
    --brand-600: #2563eb;
    --accent: #60f0ff;
    --text: #e6eef8;
    --muted: #94a3b8;

    --bs-body-bg: var(--bg-dark);
    --bs-body-color: var(--text);
    --bs-primary: var(--brand);
    --bs-primary-rgb: 14,165,255;
  }

  html,body{
    height:100%;
  }

  body{
    background: var(--bg-dark);
    color: var(--text);
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
  }

  .card{
    background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.02));
    border-radius: 1rem;
    color: var(--text);
    border: 0;
    box-shadow: 0 8px 30px rgba(2,8,23,0.6);
  }

  /* Navbar uses transparent dark background */
  .navbar{
    background: rgba(0,0,0,0.35) !important;
  }

  .navbar .nav-link, .navbar .navbar-brand{
    color: var(--text) !important;
  }

  /* Subtle form control styles to match dark theme */
  .form-control, .form-select {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.04);
    color: var(--text);
  }
  .form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 .2rem rgba(var(--bs-primary-rgb), .08);
    border-color: var(--brand);
  }

  /* Small responsive container spacing */
  main.container { padding-top: 1rem; padding-bottom: 3rem; }

  /* Footer */
  footer { color: var(--muted); }

  </style>

  @stack('css')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg border-bottom mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">IOT Device Laravel</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Tabla</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Formulario</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<main class="container mb-5">@yield('content')</main>

<!--
<footer class="text-center text-muted py-4">
  <small>Demo Bootstrap 5 + DataTables · Laravel + PostgreSQL</small>
</footer>
-->

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

{{-- Use the 'scripts' stack in your views --}}
@stack('scripts')
</body>
</html>