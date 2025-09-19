<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Demo Laravel + PostgreSQL')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <style>body{background:#f7f8fb}.card{border-radius:1rem}</style>
  @stack('css')
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white border-bottom mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">Laravel + PGSQL</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="">Tabla</a></li>
        <li class="nav-item"><a class="nav-link" href="">Formulario</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container mb-5">@yield('content')</main>

<footer class="text-center text-muted py-4">
  <small>Demo Bootstrap 5 + DataTables · Laravel + PostgreSQL</small>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
@stack('js')
</body>
</html>