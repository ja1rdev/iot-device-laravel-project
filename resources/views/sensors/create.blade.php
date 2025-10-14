@extends('layout.app')
@section('title','Nuevo sensor')
@section('content')
<h1 class="h4 mb-3">Nuevo sensor</h1>
<form method="POST" action="/sensors">
@csrf
<div class="mb-2"><label class="form-label">Nombre</label><input name="name" class="form-control" required></div>
<div class="mb-2"><label class="form-label">Código (único)</label><input name="code" class="form-control" required></div>
<div class="mb-2"><label class="form-label">Abreviatura</label><input name="abbrev" class="form-control"></div>
<div class="mb-2"><label class="form-label">Departamento</label>
<select name="id_department" class="form-select" required>
@foreach($departments as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
</select>
</div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="status" checked id="ss">
<label class="form-check-label" for="ss">Activo</label>
</div>
<button class="btn btn-primary">Guardar</button>
</form>
@endsection