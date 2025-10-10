@extends('layouts.app') @section('title','Nueva estación')
@section('content')
<h1 class="h4 mb-3">Nueva estación</h1>
<form method="POST" action="/stations">
@csrf
<div class="mb-2"><label class="form-label">Nombre</label><input name="name" class="form-control" required></div>
<div class="mb-2"><label class="form-label">Código</label><input name="code" class="form-control"></div>
<div class="mb-2"><label class="form-label">Ciudad</label>
<select name="id_city" class="form-select" required>
@foreach($cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
</select>
</div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="status" checked id="st">
<label class="form-check-label" for="st">Activo</label>
</div>
<button class="btn btn-primary">Guardar</button>
</form>
@endsection