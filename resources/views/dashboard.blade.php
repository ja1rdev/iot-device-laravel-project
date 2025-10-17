@extends('layout.app')
@section('title','Panel IoT')

@push('css')
<style>
  .iot-hero{
    background: radial-gradient(1200px 500px at 10% -10%, #e8f2ff 20%, transparent 70%),
                radial-gradient(900px 400px at 110% 10%, #ffe9f5 10%, transparent 60%),
                linear-gradient(135deg,#f7f8fb 0%, #eef5ff 100%);
    border-radius: 1.5rem;
  }
  .iot-chip { position: absolute; right: -40px; top: -40px; width: 220px; opacity: .15; transform: rotate(15deg); }
  .iot-badge { background:#f0f7ff; color:#0b5ed7; border:1px solid #d9e8ff }
  .metric-card { border-radius: 1rem; }
  .metric-value { font-size: 1.6rem; font-weight: 700; }
  .muted { color:#6c757d }
  .icon-24 { width:24px; height:24px; vertical-align:-5px }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
  <div class="col-12 mb-4">
    <div class="iot-hero p-4 p-md-5 shadow-sm position-relative overflow-hidden">
      <svg class="iot-chip" viewBox="0 0 200 200" fill="none">
        <rect x="40" y="40" width="120" height="120" rx="12" stroke="#0d6efd" stroke-width="4" fill="white"/>
        <g stroke="#0d6efd" stroke-width="3">
          <line x1="100" y1="10" x2="100" y2="40"/>
          <line x1="10" y1="100" x2="40" y2="100"/>
          <line x1="160" y1="100" x2="190" y2="100"/>
          <line x1="100" y1="160" x2="100" y2="190"/>
        </g>
        <circle cx="100" cy="100" r="22" fill="#0d6efd" opacity="0.2"/>
      </svg>

      <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
        <span class="badge iot-badge">ESP32 · LTE (SIM7670G) · PostgreSQL</span>
        <span class="badge iot-badge">Stations • Sensors • Sensor Data</span>
      </div>

      <h1 class="h3 mb-2">Panel IoT — Monitoreo & Registros</h1>
      <p class="mb-4 muted">
        Visualiza lecturas de <strong>sensor_data</strong> por <strong>estación</strong> y
        practica el flujo MVC de Laravel: rutas → controlador → modelo → vista → gráfico.
      </p>

      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('stations.create') }}" class="btn btn-primary">
          <svg class="icon-24 me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round"/></svg>
          Nueva estación
        </a>
        <a href="{{ route('stations.index') }}" class="btn btn-outline-secondary">
          <svg class="icon-24 me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2"/>
            <path d="M3 10h18M9 20V10M15 20V10" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Ver estaciones
        </a>
        <a href="{{ route('sensors.index') }}" class="btn btn-outline-secondary">
          <svg class="icon-24 me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="7" y="7" width="10" height="10" rx="2" stroke-width="2"/>
            <path d="M12 2v3M12 19v3M2 12h3M19 12h3" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Ver sensores
        </a>
      </div>
    </div>
  </div>

  <!-- Sensors online -->
  <div class="col-12 col-md-4 mb-3">
    <div class="card metric-card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="muted">Sensores en línea</span>
          <svg class="icon-24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M2 20a10 10 0 0 1 20 0" stroke-width="2" stroke-linecap="round"/>
            <path d="M6 20a6 6 0 0 1 12 0" stroke-width="2" stroke-linecap="round"/>
            <circle cx="12" cy="20" r="1.5" fill="currentColor"/>
          </svg>
        </div>
        <div class="metric-value mt-1">{{ $sensorsOnline }}</div>
        <div class="muted small">status = true</div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4 mb-3">
    <div class="card metric-card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="muted">Última sincronización</span>
          <svg class="icon-24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="9" stroke-width="2"/>
            <path d="M12 7v5l3 2" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="metric-value mt-1">{{ $lastSync ? \Carbon\Carbon::parse($lastSync)->format('Y-m-d H:i') : '—' }}</div>
        <div class="muted small">sensor_data.created_at</div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4 mb-3">
    <div class="card metric-card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <span class="muted">Base de datos</span>
          <svg class="icon-24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <ellipse cx="12" cy="5" rx="7" ry="3" stroke-width="2"/>
            <path d="M5 5v6c0 1.66 3.13 3 7 3s7-1.34 7-3V5" stroke-width="2"/>
            <path d="M5 11v6c0 1.66 3.13 3 7 3s7-1.34 7-3v-6" stroke-width="2"/>
          </svg>
        </div>
        <div class="metric-value mt-1"></div>
        <div class="muted small">Conectado vía PDO</div>
      </div>
    </div>
  </div>

  <!-- Selector + Chart -->
  <div class="col-12 mb-4">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h2 class="h5 mb-3">Telemetría por estación</h2>
        <div class="row g-2 mb-3">
          <div class="col-md-4">
            <label class="form-label">Estación</label>
            <select id="station_id" class="form-select">
              <option value="">Seleccione una estación</option>
              @foreach($stations as $st)
                <option value="{{ $st->id }}">{{ $st->name }} — {{ $st->city?->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Desde</label>
            <input type="datetime-local" id="from" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">Hasta</label>
            <input type="datetime-local" id="to" class="form-control">
          </div>
          <div class="col-md-2">
            <label class="form-label">Agrupar</label>
            <select id="group" class="form-select">
              <option value="hour">Por hora</option>
              <option value="minute">Por minuto</option>
              <option value="day">Por día</option>
            </select>
          </div>
        </div>
        <canvas id="chart" height="120"></canvas>
      </div>
    </div>
  </div>

  <!-- Modules -->
  <div class="col-12">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h2 class="h5 mb-3">Módulos</h2>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="border rounded-4 h-100 p-3">
              <div class="d-flex align-items-center mb-2">
                <svg class="icon-24 me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="6" y="3" width="12" height="18" rx="2" stroke-width="2"/>
                  <path d="M9 7h6M9 11h6M9 15h6" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <strong>Estaciones</strong>
              </div>
              <p class="mb-3 muted small">Crea y lista estaciones por ciudad.</p>
              <div class="d-flex gap-2">
                <a href="{{ route('stations.create') }}" class="btn btn-sm btn-primary">Nueva</a>
                <a href="{{ route('stations.index') }}" class="btn btn-sm btn-outline-secondary">Ver</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="border rounded-4 h-100 p-3">
              <div class="d-flex align-items-center mb-2">
                <svg class="icon-24 me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="7" y="7" width="10" height="10" rx="2" stroke-width="2"/>
                  <path d="M12 2v3M12 19v3M2 12h3M19 12h3" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <strong>Sensores</strong>
              </div>
              <p class="mb-3 muted small">Registra sensores (por department) y asócialos en lecturas.</p>
              <a href="{{ route('sensors.index') }}" class="btn btn-sm btn-outline-secondary">Ver sensores</a>
            </div>
          </div>
          <div class="col-md-4">
            <div class="border rounded-4 h-100 p-3">
              <div class="d-flex align-items-center mb-2">
                <svg class="icon-24 me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path d="M3 20h18M7 16v-6M12 20v-10M17 20v-14" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <strong>Tiempo real</strong>
              </div>
              <p class="mb-3 muted small">Gráficas con datos agrupados por minuto/hora/día.</p>
              <button class="btn btn-sm btn-outline-secondary" disabled>Próximamente</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chart;
async function loadSeries(){
  const station = document.getElementById('station_id').value;
  const group   = document.getElementById('group').value;
  const fromEl  = document.getElementById('from').value;
  const toEl    = document.getElementById('to').value;

  const qs = new URLSearchParams({ station_id: station, group });
  if(fromEl) qs.append('from', new Date(fromEl).toISOString());
  if(toEl)   qs.append('to',   new Date(toEl).toISOString());

  const res  = await fetch(`/api/telemetry?${qs.toString()}`);
  const json = await res.json();

  const data = {
    labels: json.labels,
    datasets: [
      { label:'Temperatura (°C)', data: json.temp, borderWidth:2, fill:false, tension:.3, pointRadius:0 },
      { label:'Humedad (%)',      data: json.hum,  borderWidth:2, fill:false, tension:.3, pointRadius:0 }
    ]
  };
  const opts = { responsive:true, animation:false, scales:{ x:{title:{display:true,text:'Tiempo'}}, y:{title:{display:true,text:'Valor'}} } };

  if(chart) chart.destroy();
  chart = new Chart(document.getElementById('chart').getContext('2d'), { type:'line', data, options:opts });
}
document.getElementById('station_id').addEventListener('change', loadSeries);
document.getElementById('group').addEventListener('change', loadSeries);
document.getElementById('from').addEventListener('change', loadSeries);
document.getElementById('to').addEventListener('change', loadSeries);
window.addEventListener('DOMContentLoaded', loadSeries);
</script>
@endpush


@push('css')
<style>

</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Personalize colors
const colors = { temp:'#ef4444', tempBg:'rgba(239,68,68,.1)', hum:'#3b82f6', humBg:'rgba(59,130,246,.1)' };
// Inside loadSeries(), when building datasets:
datasets: [
  { label:'Temperatura (°C)', data: json.temp, borderColor:colors.temp, backgroundColor:colors.tempBg, borderWidth:2, fill:true, tension:.3, pointRadius:0 },
  { label:'Humedad (%)',      data: json.hum,  borderColor:colors.hum,  backgroundColor:colors.humBg,  borderWidth:2, fill:true, tension:.3, pointRadius:0 }
]
</script>
@endpush