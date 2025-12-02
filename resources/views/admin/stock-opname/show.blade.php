@extends('layouts.admin', ['activeMenu' => 'stock-opname'])

{{-- Mengisi section 'title' di layout utama --}}
@section('title', 'Rincian Stock Opname - SIMANTAP')

{{-- Mengisi section 'content' di layout utama --}}
@section('content')
    
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rincian Stock Opname
            </h2>
        </div>
    </header>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 md:p-12">

                <h3 class="text-2xl font-bold text-gray-900">Rincian Sesi Stock Opname</h3>
                <p class="text-gray-600 mb-6">
                    Sesi Opname pada {{ $opname->tanggal_opname->format('d F Y \p\u\k\u\l H:i') }}
                </p>

                {{-- Ringkasan Metrik --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                        <dt class="text-sm font-medium text-gray-500">Total Barang Diperiksa</dt>
                        <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $opname->details->count() }}</dd>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                        <dt class="text-sm font-medium text-gray-500">Total Item Selisih</dt>
                        {{-- Menggunakan stokSelisih yang sudah dikoreksi --}}
                        <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $opname->details->where('stokSelisih', '!=', 0)->count() }}</dd>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                        <dt class="text-sm font-medium text-gray-500">Operator</dt>
                        <dd class="mt-1 text-xl font-semibold text-gray-900">{{ $opname->operator->name }}</dd>
                    </div>
                </div>
                
                <h4 class="text-xl font-bold text-gray-900 mb-4">Daftar Barang</h4>
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-6">No</th>
                                <th scope="col" class="py-3 px-6">Nama Barang</th>
                                <th scope="col" class="py-3 px-6">Kategori</th>
                                <th scope="col" class="py-3 px-6 text-center">Stok Sistem</th>
                                <th scope="col" class="py-3 px-6 text-center">Stok Fisik</th>
                                <th scope="col" class="py-3 px-6 text-center">Selisih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($opname->details as $detail)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $detail->barang->nama_barang }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ $detail->barang->kategori->nama_kategori ?? 'N/A' }}
                                </td>
                                
                                {{-- Menggunakan CamelCase stokSistem --}}
                                <td class="py-4 px-6 text-center font-medium text-gray-700">{{ $detail->stokSistem }}</td>
                                
                                {{-- Menggunakan CamelCase stokFisik --}}
                                <td class="py-4 px-6 text-center font-medium text-blue-600">{{ $detail->stokFisik }}</td>
                                
                                {{-- Menggunakan CamelCase stokSelisih --}}
                                <td class="py-4 px-6 text-center font-bold
                                    @if ($detail->stokSelisih > 0)
                                        text-green-600
                                    @elseif ($detail->stokSelisih < 0)
                                        text-red-600
                                    @else
                                        text-gray-700
                                    @endif
                                ">
                                    {{ $detail->stokSelisih }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Selesai
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection