@extends('layouts.app')
@section('title','Estaciones')
@section('content')
<h1 class="h4 mb-3">Estaciones</h1>
<a class="btn btn-primary mb-3" href="/stations/create">Nueva</a>
<table class="table table-sm table-striped">
<thead><tr><th>Nombre</th><th>Código</th><th>Ciudad</th><th>Departamento</th><th>País</th><th>Estado</th></tr></thead>
<tbody>
@foreach($stations as $s)
<tr>
<td>{{ $s->name }}</td>
<td>{{ $s->code }}</td>
<td>{{ $s->city->name }}</td>
<td>{{ $s->city->department->name }}</td>
<td>{{ $s->city->department->country->name }}</td>
<td>{!! $s->status ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>' !!}</td>
</tr>
@endforeach
</tbody>
</table>
@endsection