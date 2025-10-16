@extends('admin.operator.report_sale.layout')

@section('chart')
<script>
const ctx = document.getElementById('chart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($days) !!},
        datasets: [
            @foreach($chartData as $category => $data)
            {
                label: "{{ $category }}",
                data: {!! json_encode($data) !!},
                borderColor: "#" + Math.floor(Math.random()*16777215).toString(16),
                fill: false,
                tension: 0.3
            },
            @endforeach
        ]
    },
    options: {
        plugins: {
            title: { display: true, text: 'Grafik Penjualan Bulanan per Kategori' },
            legend: { position: 'bottom' }
        },
        scales: {
            y: { title: { display: true, text: 'Pendapatan (Rp)' }, beginAtZero: true }
        }
    }
});
</script>
@endsection
