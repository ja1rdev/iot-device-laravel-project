@extends('layout.app')

@section('title','Inicio')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="img/sensors.png" class="card-img-top" alt="sensors">
                <div class="card-body">
                    <h5 class="card-title">Gestion de registros</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="img/iot.jpg" class="card-img-top" alt="sensors">
                <div class="card-body">
                    <h5 class="card-title">Dispositivos IoT</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="img/dashboard.jpg" class="card-img-top" alt="sensors">
                <div class="card-body">
                    <h5 class="card-title">Panel en tiempo real</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection 