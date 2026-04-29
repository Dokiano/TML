@extends('layouts.main')

@section('content')

<style>
/* ══════════════════════════════════════════
   DASHBOARD — clean corporate aesthetic
   Font: Nunito (already loaded in main)
══════════════════════════════════════════ */
:root {
    --blue:   #4a7fd4;
    --green:  #4caf7d;
    --orange: #f59e0b;
    --red:    #ef4444;
    --bg:     #f0f4f9;
    --card:   #ffffff;
    --text:   #1e293b;
    --muted:  #64748b;
    --border: #e2e8f0;
    --shadow: 0 2px 12px rgba(74,127,212,0.10);
    --shadow-hover: 0 8px 28px rgba(74,127,212,0.18);
}

.dashboard-wrap {
    background: var(--bg);
    min-height: 100vh;
    padding: 28px 24px 40px;
    font-family: 'Nunito', sans-serif;
}

/* ── Greeting Bar ── */
.greeting-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 10px;
}
.greeting-bar .greet-left h2 {
    font-size: 1.45rem;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}
.greeting-bar .greet-left p {
    color: var(--muted);
    font-size: 0.85rem;
    margin: 2px 0 0;
}
.greeting-bar .filter-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
}
.greeting-bar .filter-wrap label {
    font-size: 0.82rem;
    color: var(--muted);
    white-space: nowrap;
    margin: 0;
}
.greeting-bar .filter-wrap select {
    font-size: 0.83rem;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 6px 12px;
    background: var(--card);
    color: var(--text);
    box-shadow: var(--shadow);
    outline: none;
    cursor: pointer;
}
.greeting-bar .filter-wrap select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(74,127,212,0.12);
}

/* ── Alert ── */
.dash-alert {
    background: linear-gradient(90deg, #d1fae5, #ecfdf5);
    border-left: 4px solid var(--green);
    border-radius: 10px;
    padding: 12px 18px;
    font-size: 0.88rem;
    color: #065f46;
    font-weight: 600;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ── Quick Nav Cards ── */
.quick-nav-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}
@media (max-width: 900px) { .quick-nav-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 580px) { .quick-nav-grid { grid-template-columns: 1fr; } }

.qnav-card {
    background: var(--card);
    border-radius: 14px;
    box-shadow: var(--shadow);
    padding: 20px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    transition: transform 0.22s ease, box-shadow 0.22s ease;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
}
.qnav-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
    border-radius: 14px 0 0 14px;
}
.qnav-card.blue::before  { background: var(--blue); }
.qnav-card.green::before { background: var(--green); }
.qnav-card.orange::before { background: var(--orange); }

.qnav-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
    text-decoration: none;
}
.qnav-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.qnav-card.blue  .qnav-icon { background: rgba(74,127,212,0.12); color: var(--blue); }
.qnav-card.green .qnav-icon { background: rgba(76,175,125,0.12); color: var(--green); }
.qnav-card.orange .qnav-icon { background: rgba(245,158,11,0.12); color: var(--orange); }

.qnav-text h6 {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 2px;
    line-height: 1.3;
}
.qnav-text p {
    font-size: 0.75rem;
    color: var(--muted);
    margin: 0;
}

/* ── Charts Section ── */
.charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 720px) { .charts-grid { grid-template-columns: 1fr; } }

.chart-card {
    background: var(--card);
    border-radius: 14px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    padding: 22px 24px;
}
.chart-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
}
.chart-card-header .chart-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
}
.chart-card-header h5 {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
}
.chart-card-header small {
    color: var(--muted);
    font-size: 0.76rem;
    margin-left: auto;
}
.chart-canvas-wrap {
    position: relative;
    max-height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ── Modals ── */
.modal-content { border-radius: 14px; overflow: hidden; border: none; }
.modal-header  { background: linear-gradient(90deg, var(--blue), #6ab0f5); padding: 14px 20px; }
.modal-header .modal-title { font-size: 0.95rem; font-weight: 700; color: #fff; }
.modal-body    { padding: 20px; background: #f8fafc; }
.modal-footer  { background: #f8fafc; border-top: 1px solid var(--border); padding: 12px 20px; }

table thead th { background: var(--blue); color: #fff; font-size: 0.8rem; font-weight: 600; }
table tbody tr:hover { background: #f0f6ff; }
table tbody td { font-size: 0.82rem; vertical-align: middle; }

.score-badge {
    display: inline-block;
    padding: 2px 9px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.82rem;
    background: #e0edff;
    color: var(--blue);
    min-width: 30px;
    text-align: center;
}
</style>

<div class="dashboard-wrap">

    {{-- ── Greeting Bar ── --}}
    <div class="greeting-bar">
        <div class="greet-left">
            {{-- Tampilkan nama user jika sudah login, tamu jika belum --}}
            @auth
                <h2>Selamat Datang, {{ Auth::user()->nama_user }} 👋</h2>
            @else
                <h2>Selamat Datang 👋</h2>
            @endauth
            <p>{{ now()->translatedFormat('l, d F Y') }} &nbsp;·&nbsp; DCMS Dashboard</p>
        </div>

        {{-- Filter departemen hanya tampil untuk admin/manajemen yang sudah login --}}
        @auth
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manajemen')
            <form method="GET" action="{{ route('dashboard.index') }}" class="filter-wrap">
                <label for="departemen">Filter Departemen:</label>
                <select name="departemen" id="departemen" onchange="this.form.submit()">
                    <option value="">Semua Departemen</option>
                    @foreach($departemenList as $departemen)
                        <option value="{{ $departemen }}" {{ $selectedDepartemen == $departemen ? 'selected' : '' }}>
                            {{ $departemen }}
                        </option>
                    @endforeach
                </select>
            </form>
            @endif
        @endauth
    </div>

    {{-- ── Alert Success ── --}}
    @if(session('success'))
    <div class="dash-alert">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Quick Nav Cards ── --}}
    <div class="quick-nav-grid">
        <a href="/riskregister" class="qnav-card blue">
            <div class="qnav-icon"><i class="bi bi-shield-exclamation"></i></div>
            <div class="qnav-text">
                <h6>Risk &amp; Opportunity Register</h6>
                <p>Kelola risiko &amp; peluang organisasi</p>
            </div>
        </a>
        {{-- <a href="/ppk" class="qnav-card green">
            <div class="qnav-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="qnav-text">
                <h6>Proses Peningkatan Kinerja (PPK)</h6>
                <p>Mekanisme pencegahan &amp; peningkatan</p>
            </div>
        </a>
        <a href="{{ route('dok.dashboard') }}" class="qnav-card orange">
            <div class="qnav-icon"><i class="bi bi-folder2-open"></i></div>
            <div class="qnav-text">
                <h6>Master List Dokumen</h6>
                <p>Kelola dokumen &amp; review TML</p>
            </div>
        </a> --}}
    </div>

    {{-- ── Charts ── --}}
    <div class="charts-grid">

        {{-- Status Risiko --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <span class="chart-dot" style="background:#4a7fd4;"></span>
                <h5>Status Risiko</h5>
                <small>Klik segmen untuk detail</small>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="statusPieChart"></canvas>
            </div>
        </div>

        {{-- Tingkatan Risiko --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <span class="chart-dot" style="background:#4caf7d;"></span>
                <h5>Tingkatan Risiko / Peluang</h5>
                <small>Klik segmen untuk detail</small>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="tingkatanPieChart"></canvas>
            </div>
        </div>

    </div>
</div>

{{-- ══ MODALS ══ --}}

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Detail Status Risiko</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Tingkatan Modal -->
<div class="modal fade" id="tingkatanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tingkatanModalLabel">Detail Tingkatan Risiko</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusDetails    = @json($statusDetails);
    const tingkatanDetails = @json($tingkatanDetails);

    // ── Build table HTML ──────────────────────────────────────────────
    function buildTableHTML(data, filterValue) {
        const sorted = [...data].sort((a, b) => {
            const scoreA = Number(a.severity ?? a.nilai_severity ?? 0) * Number(a.probability ?? a.nilai_probability ?? 0);
            const scoreB = Number(b.severity ?? b.nilai_severity ?? 0) * Number(b.probability ?? b.nilai_probability ?? 0);
            if (scoreB !== scoreA) return scoreB - scoreA;
            return Number(b.severity ?? b.nilai_severity ?? 0) - Number(a.severity ?? a.nilai_severity ?? 0);
        });

        const rows = sorted.map((r, i) => {
            const sev   = r.severity    ?? r.nilai_severity    ?? null;
            const prob  = r.probability ?? r.nilai_probability ?? null;
            const score = (sev !== null && prob !== null) ? Number(sev) * Number(prob) : null;
            const scoreHtml = score !== null ? `<span class="score-badge">${score}</span>` : '<span class="text-muted">-</span>';
            const url = (r.jenis_iso_id == 2)
                ? `/riskregister-iso37001/${r.id_divisi}`
                : `/riskregister/${r.id_divisi}?keyword=${encodeURIComponent(r.nama_issue ?? '')}`;
            return `<tr>
                <td class="text-center">${i+1}</td>
                <td><a href="${url}">${r.nama_issue ?? '-'}</a></td>
                <td>${r.nama_resiko ?? '-'}</td>
                <td>${r.peluang ?? '-'}</td>
                <td class="text-center">${sev ?? '<span class="text-muted">-</span>'}</td>
                <td class="text-center">${prob ?? '<span class="text-muted">-</span>'}</td>
                <td class="text-center">${scoreHtml}</td>
                <td>${r.nama_divisi ?? '-'}</td>
            </tr>`;
        }).join('');

        return `
        <h5 class="mb-3">
            <span class="fw-bold" style="color:#4a7fd4;">${filterValue}</span>
            <small class="text-muted ms-2">(${data.length} risiko)</small>
        </h5>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead><tr>
                    <th class="text-center" style="width:45px;">No</th>
                    <th>Issue</th><th>Risiko</th><th>Peluang</th>
                    <th class="text-center">Severity</th>
                    <th class="text-center">Probability</th>
                    <th class="text-center">Skor</th>
                    <th>Departemen</th>
                </tr></thead>
                <tbody>${rows || '<tr><td colspan="8" class="text-center text-muted py-3">Tidak ada data.</td></tr>'}</tbody>
            </table>
        </div>`;
    }

    function showModal(filterType, filterValue) {
        const data    = filterType === 'status' ? (statusDetails[filterValue] || []) : (tingkatanDetails[filterValue] || []);
        const modalId = filterType === 'status' ? '#statusModal' : '#tingkatanModal';
        document.querySelector(`${modalId} .modal-body`).innerHTML = buildTableHTML(data, filterValue);
        new bootstrap.Modal(document.querySelector(modalId)).show();
    }

    // ── Chart colours ────────────────────────────────────────────────
    const colorsStatus    = ['#fbbf24','#ef4444','#22c55e','#60a5fa','#a78bfa','#f97316'];
    const colorsTingkatan = ['#ef4444','#fbbf24','#22c55e','#60a5fa','#a78bfa'];

    const chartDefaults = {
        type: 'pie',
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 11, family: 'Nunito' }, padding: 12, usePointStyle: true }
                },
                tooltip: {
                    callbacks: {
                        label: function(t) {
                            const total = t.chart.data.datasets[0].data.reduce((a,b) => a+b, 0);
                            const pct   = ((t.raw / total) * 100).toFixed(1);
                            return `  ${t.label}: ${t.raw} (${pct}%)`;
                        }
                    }
                }
            }
        }
    };

    // Status chart
    const statusLabels = @json($statusCounts->keys());
    const statusValues = @json($statusCounts->values());
    const statusChart  = new Chart(document.getElementById('statusPieChart'), {
        ...chartDefaults,
        data: {
            labels: statusLabels,
            datasets: [{ data: statusValues, backgroundColor: colorsStatus, borderWidth: 2, borderColor: '#fff' }]
        },
        options: {
            ...chartDefaults.options,
            onClick: (e, els) => {
                if (els.length) showModal('status', statusLabels[els[0].index]);
            }
        }
    });

    // Tingkatan chart
    const tingkatanLabels = @json($tingkatanCounts->keys());
    const tingkatanValues = @json($tingkatanCounts->values());
    const tingkatanChart  = new Chart(document.getElementById('tingkatanPieChart'), {
        ...chartDefaults,
        data: {
            labels: tingkatanLabels,
            datasets: [{ data: tingkatanValues, backgroundColor: colorsTingkatan, borderWidth: 2, borderColor: '#fff' }]
        },
        options: {
            ...chartDefaults.options,
            onClick: (e, els) => {
                if (els.length) showModal('tingkatan', tingkatanLabels[els[0].index]);
            }
        }
    });
});
</script>
@endsection