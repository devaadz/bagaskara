@extends('admin.layouts.layout')
@section('content')
<div class="container mx-auto p-8">
    <h2 class="text-2xl font-bold mb-6 text-center">📊 Laporan Penjualan</h2>
    <p class="text-center text-gray-600 mb-8">Pilih jenis laporan yang ingin kamu lihat:</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('reports.daily') }}" class="block bg-blue-500 hover:bg-blue-600 text-white rounded-2xl shadow p-6 text-center transition">
            <h3 class="text-xl font-semibold mb-2">Harian</h3>
            <p>Lihat total & grafik penjualan hari ini</p>
        </a>

        <a href="{{ route('reports.weekly') }}" class="block bg-green-500 hover:bg-green-600 text-white rounded-2xl shadow p-6 text-center transition">
            <h3 class="text-xl font-semibold mb-2">Mingguan</h3>
            <p>Pantau tren penjualan minggu ini</p>
        </a>

        <a href="{{ route('reports.monthly') }}" class="block bg-yellow-500 hover:bg-yellow-600 text-white rounded-2xl shadow p-6 text-center transition">
            <h3 class="text-xl font-semibold mb-2">Bulanan</h3>
            <p>Lihat performa setiap hari dalam bulan ini</p>
        </a>

        <a href="{{ route('reports.yearly') }}" class="block bg-purple-500 hover:bg-purple-600 text-white rounded-2xl shadow p-6 text-center transition">
            <h3 class="text-xl font-semibold mb-2">Tahunan</h3>
            <p>Analisis pendapatan per bulan tahun ini</p>
        </a>
    </div>

    <div class="mt-10 text-center text-gray-500 text-sm">
        <p>Versi laporan otomatis — Data diambil dari tabel <code>sales_summary</code></p>
    </div>
</div>
@endsection
