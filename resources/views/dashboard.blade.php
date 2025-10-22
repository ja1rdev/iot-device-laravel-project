@extends('layout.app')
@section('title','Panel IoT')

@push('css')
<style>
/* Dark theme and CSS variables */
.iot-hero{
  background:
    radial-gradient(1200px 500px at 10% -10%, rgba(14,165,255,0.06) 0%, transparent 40%),
    radial-gradient(900px 400px at 110% 10%, rgba(96,240,255,0.03) 0%, transparent 50%),
    linear-gradient(135deg, rgba(7,16,35,0.9) 0%, rgba(4,8,20,0.95) 100%);
  border-radius: 1.5rem;
  color: var(--text);
  position: relative;
}

/* SVG chip styling */
.iot-chip { position: absolute; right: -40px; top: -40px; width: 220px; opacity: .15; transform: rotate(15deg); }
.iot-chip rect{ fill: rgba(255,255,255,0.02); stroke: var(--brand-600); stroke-width: 3; }
.iot-chip g{ stroke: var(--brand-600); stroke-width: 2.5; }
.iot-chip circle{ fill: var(--brand-600); opacity: .12; }

/* Badges and metric cards */
.iot-badge { background: rgba(14,165,255,0.06); color: var(--brand); border: 1px solid rgba(14,165,255,0.12); }
.metric-card { border-radius: 1rem; background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.02)); }
.metric-value { font-size: 1.6rem; font-weight: 700; color: var(--text); }
.muted { color: var(--muted) !important; }
.icon-24 { width:24px; height:24px; vertical-align:-5px; color: var(--text); }

/* Modules cards border style */
.border.rounded-4 { border-color: rgba(255,255,255,0.04) !important; }

/* Dark select styling (applied by adding class "dark" to selects) */
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
<div class="row justify-content-center">
  <div class="col-12 mb-4">
    <div class="iot-hero p-4 p-md-5 shadow-sm position-relative overflow-hidden">
      <svg class="iot-chip" viewBox="0 0 200 200" fill="none" aria-hidden="true">
        <rect x="40" y="40" width="120" height="120" rx="12"/>
        <g>
          <line x1="100" y1="10" x2="100" y2="40"/>
          <line x1="10" y1="100" x2="40" y2="100"/>
          <line x1="160" y1="100" x2="190" y2="100"/>
          <line x1="100" y1="160" x2="100" y2="190"/>
        </g>
        <circle cx="100" cy="100" r="22"/>
      </svg>

      <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
        <span class="badge iot-badge mb-3">ESP32 S3 ROOM  ·  C++  ·  Python  ·  PHP · PostgreSQL</span>
        <!-- <span class="badge iot-badge">Stations • Sensors • Sensor Data</span> -->
      </div>

      <h1 class="h3 mb-4">Panel IoT — Monitoreo & Registros</h1>
      <!-- <p class="mb-4 muted">
        Visualiza lecturas de <strong>sensor_data</strong> por <strong>estación</strong> y
        practica el flujo MVC de Laravel: rutas → controlador → modelo → vista → gráfico.
      </p> -->

      <div class="d-flex flex-wrap gap-2 mb-5">
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
        <!-- <div class="muted small">status = true</div> -->
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
        <!-- <div class="muted small">sensor_data.created_at</div> -->
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
        <div class="metric-value mt-1">{{ $lastSync ? \Carbon\Carbon::parse($lastSync)->format('Y-m-d H:i') : '—' }}</div>
        <!-- <div class="muted small">Conectado vía PDO</div> -->
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
            <select id="station_id" class="form-select dark">
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
            <select id="group" class="form-select dark">
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
// Read color palette from CSS variables
function getPalette(){
  const css = getComputedStyle(document.documentElement);
  return {
    hum: css.getPropertyValue('--brand').trim() || '#0ea5ff',
    humBg: 'rgba(14,165,255,0.12)',
    temp: '#ff7a59',
    tempBg: 'rgba(255,122,89,0.12)'
  };
}

let chart;
async function loadSeries(){
  const palette = getPalette();
  const station = document.getElementById('station_id').value;
  const group   = document.getElementById('group').value;
  const fromEl  = document.getElementById('from').value;
  const toEl    = document.getElementById('to').value;

  // if no station selected, clear chart
  if(!station){
    if(chart){ chart.destroy(); chart = null; }
    return;
  }

  const qs = new URLSearchParams({ station_id: station, group });
  if(fromEl) qs.append('from', new Date(fromEl).toISOString());
  if(toEl)   qs.append('to',   new Date(toEl).toISOString());

  const res  = await fetch(`/api/telemetry?${qs.toString()}`);
  if(!res.ok){
    console.error('Error fetching telemetry', res.status);
    return;
  }
  const json = await res.json();

  const data = {
    labels: json.labels || [],
    datasets: [
      {
        label:'Temperatura (°C)',
        data: json.temp || [],
        borderColor: palette.temp,
        backgroundColor: palette.tempBg,
        borderWidth:2, fill:true, tension:.3, pointRadius:0
      },
      {
        label:'Humedad (%)',
        data: json.hum || [],
        borderColor: palette.hum,
        backgroundColor: palette.humBg,
        borderWidth:2, fill:true, tension:.3, pointRadius:0
      }
    ]
  };

  const opts = {
    responsive:true,
    animation:false,
    scales:{
      x:{ title:{ display:true, text:'Tiempo'}, grid:{ color:'rgba(255,255,255,0.03)' }, ticks:{ color: getComputedStyle(document.documentElement).getPropertyValue('--muted').trim() } },
      y:{ title:{ display:true, text:'Valor'}, grid:{ color:'rgba(255,255,255,0.03)' }, ticks:{ color: getComputedStyle(document.documentElement).getPropertyValue('--muted').trim() } }
    },
    plugins:{
      legend:{ labels:{ color: getComputedStyle(document.documentElement).getPropertyValue('--text').trim() } }
    }
  };

  if(chart) chart.destroy();
  chart = new Chart(document.getElementById('chart').getContext('2d'), { type:'line', data, options:opts });
}

// Attach events (guard if elements not present)
document.addEventListener('DOMContentLoaded', () => {
  const stationEl = document.getElementById('station_id');
  const groupEl   = document.getElementById('group');
  const fromEl    = document.getElementById('from');
  const toEl      = document.getElementById('to');

  if(stationEl) stationEl.addEventListener('change', loadSeries);
  if(groupEl) groupEl.addEventListener('change', loadSeries);
  if(fromEl) fromEl.addEventListener('change', loadSeries);
  if(toEl) toEl.addEventListener('change', loadSeries);

  // Initial load (if a station is preselected)
  loadSeries();
});
</script>
@endpush