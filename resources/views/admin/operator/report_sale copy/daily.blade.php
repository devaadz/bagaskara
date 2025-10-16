@extends('admin.operator.report_sale.layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('reports.index') }}" class="btn btn-light border d-flex align-items-center me-4">
           Kembali
       </a>
        <h2>📅 Penjualan Harian</h2>
        <form action="{{ route('reports.daily') }}" method="GET" class="d-flex align-items-center gap-2">
            <input 
                type="date" 
                name="date" 
                value="{{ request('date', $date ?? now()->toDateString()) }}" 
                class="form-control"
                style="width: 200px;"
            >
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>
    </div>

    <h5 class="mb-4">Tanggal: <b>{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</b></h5>

    <canvas id="dailyChart"></canvas>

    <div class="mt-4 p-3 bg-light rounded shadow-sm">
        <h4 class="mb-0">💰 Total Omset Hari Ini: 
            <b>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</b>
        </h4>
    </div>
</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('dailyChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($data->pluck('category.category_name')) !!},
        datasets: [
            {
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($data->pluck('total_revenue')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                yAxisID: 'y1',
            },
            {
                label: 'Jumlah Terjual',
                data: {!! json_encode($data->pluck('total_qty')) !!},
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                yAxisID: 'y2',
            }
        ]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: { position: 'bottom' },
            title: {
                display: true,
                text: 'Penjualan Harian per Kategori'
            }
        },
        scales: {
            y1: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Pendapatan (Rp)'
                }
            },
            y2: {
                type: 'linear',
                display: true,
                position: 'right',
                grid: {
                    drawOnChartArea: false,
                },
                title: {
                    display: true,
                    text: 'Jumlah Terjual'
                }
            }
        }
    }
});
</script>
@endsection
