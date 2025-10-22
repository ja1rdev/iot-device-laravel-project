@extends('layout.app')
@section('title','Sensores')
@push('css')
<style>
.table.table-sm.table-striped thead th,
.table.table-sm.table-striped tbody td,
.table.table-sm.table-striped tfoot td {
  color: #ffffff !important;
}

.table.table-sm.table-striped a {
  color: #e6eef8 !important;
}

.table.table-sm.table-striped .badge {
  color: #ffffff !important;
}
</style>
@endpush
@section('content')
<h1 class="h4 mb-3">Sensores</h1>
<a class="btn btn-primary mb-3" href="/sensors/create">Nuevo</a>
<table class="table table-sm table-striped">
<thead><tr><th>Nombre</th><th>Código</th><th>Abrev</th><th>Departamento</th><th>País</th><th>Estado</th></tr></thead>
<tbody>
@foreach($sensors as $s)
<tr>
<td>{{ $s->name }}</td>
<td>{{ $s->code }}</td>
<td>{{ $s->abbrev }}</td>
<td>{{ $s->department->name }}</td>
<td>{{ $s->department->country->name }}</td>
<td>{!! $s->status ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>' !!}</td>
</tr>
@endforeach
</tbody>
</table>
@endsection