@extends('layout.app')
@section('title','Nueva estación')

@push('css')
<style>
/* Dark select styling */
.form-select.dark {
  background: var(--surface) !important;
  color: var(--text) !important;
  border: 1px solid rgba(255,255,255,0.04) !important;
}

/* Dropdown options */
.form-select.dark option {
  background: var(--surface) !important;
  color: var(--text) !important;
}

/* Disabled placeholder option */
.form-select.dark option[disabled] {
  color: var(--muted) !important;
}

/* Focus state */
.form-select.dark:focus {
  box-shadow: 0 0 0 .2rem rgba(var(--bs-primary-rgb), .08) !important;
  border-color: var(--brand) !important;
}
</style>
@endpush

@section('content')
<h1 class="h4 mb-3">Nueva estación</h1>

<form method="POST" action="/stations">
  @csrf

  <div class="mb-2">
    <label class="form-label">Nombre</label>
    <input name="name" class="form-control" required>
  </div>

  <div class="mb-2">
    <label class="form-label">Código</label>
    <input name="code" class="form-control">
  </div>

  <div class="mb-2">
    <label class="form-label">Ciudad</label>
    <select name="id_city" class="form-select dark" required>
      <option value="" disabled selected>Seleccione una ciudad</option>
      @foreach($cities as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="status" checked id="st">
    <label class="form-check-label" for="st">Activo</label>
  </div>

  <button class="btn btn-primary">Guardar</button>
</form>
@endsection