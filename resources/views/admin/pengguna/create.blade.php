@extends('layouts.admin')
@section('title', 'Tambah Pengguna Baru')
@section('header', 'Tambah Pengguna Baru')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 24px;
            border-bottom: none;
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 28px;
        }

        .error-alert {
            background: #fee;
            border: 2px solid #fcc;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
            color: #c00;
        }

        .error-alert ul {
            list-style: none;
            margin: 0;
        }

        .error-alert li {
            padding: 4px 0;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        label {
            display: block;
            font-weight: 600;
            color: #1e3c72;
            margin-bottom: 8px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .required::after {
            content: " *";
            color: #ef4444;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
            background: #f9fafb;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            outline: none;
            border-color: #2a5298;
            background: white;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232a5298' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .pegawai-fields {
            display: block;
        }

        .card-footer {
            padding: 20px 28px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        button, .btn-cancel {
            padding: 11px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-cancel {
            width: 160px;
            background: #e5e7eb;
            color: #374151;
            border: 1px solid #d1d5db;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cancel:hover {
            background: #d1d5db;
            transform: translateY(-1px);
        }

        .btn-submit {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            min-width: 140px;
        }

        .btn-submit:hover {
            box-shadow: 0 8px 16px rgba(42, 82, 152, 0.3);
            transform: translateY(-2px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .operator-info {
            background: #fef3cd;
            border: 1px solid #ffc107;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #856404;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .card-body {
                padding: 20px;
            }

            .card-footer {
                flex-direction: column-reverse;
            }

            .btn-submit {
                width: 100%;
            }
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-user-plus"></i>
                    Tambah Pengguna Baru
                </h3>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="error-alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-circle-exclamation"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="tambahPenggunaForm" action="{{ route('admin.pengguna.store') }}" method="POST">
                    @csrf
                    
                    <!-- Role (pindah ke atas agar bisa toggle field lainnya) -->
                    <div class="form-group">
                        <label for="role" class="required">Role</label>
                        <select id="role" name="role" required onchange="togglePegawaiFields()">
                            <option value="pegawai" {{ old('role', 'pegawai') === 'pegawai' ? 'selected' : '' }}>Pegawai BPS</option>
                            <option value="operator" {{ old('role') === 'operator' ? 'selected' : '' }}>Operator BMN</option>
                        </select>
                    </div>

                    <!-- Info untuk Operator -->
                    <div class="operator-info" id="operatorInfo" style="display: none;">
                        <i class="fas fa-info-circle"></i>
                        <strong>Operator BMN</strong> adalah user sistem tanpa identitas personal. Hanya butuh email dan password untuk login.
                    </div>

                    <!-- Fields khusus Pegawai -->
                    <div id="pegawaiFields" class="pegawai-fields">
                        <!-- Row 1: Nama & NIP -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="required">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap"
                                >
                            </div>
                            <div class="form-group">
                                <label for="nip" class="required">NIP</label>
                                <input 
                                    type="text" 
                                    id="nip" 
                                    name="nip" 
                                    value="{{ old('nip') }}"
                                    placeholder="Nomor Induk Pegawai"
                                >
                            </div>
                        </div>

                        <!-- Row 2: Jabatan & Divisi -->
                        <div class="form-row" style="margin-top: 20px;">
                            <div class="form-group">
                                <label for="jabatan" class="required">Jabatan</label>
                                <input 
                                    type="text" 
                                    id="jabatan" 
                                    name="jabatan" 
                                    value="{{ old('jabatan') }}"
                                    placeholder="Contoh: Analis Data"
                                >
                            </div>
                            <div class="form-group">
                                <label for="divisi" class="required">Divisi</label>
                                <input 
                                    type="text" 
                                    id="divisi" 
                                    name="divisi" 
                                    value="{{ old('divisi') }}"
                                    placeholder="Contoh: Statistik"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Email (untuk semua role) -->
                    <div class="form-group" style="margin-top: 20px;">
                        <label for="email" class="required">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="nama@bps.go.id"
                            required
                        >
                    </div>

                    <!-- Row: Password -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password" class="required">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Minimal 8 karakter"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="required">Konfirmasi Password</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Ulangi password"
                                required
                            >
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.pengguna.index') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" form="tambahPenggunaForm" class="btn-submit">
                    <i class="fas fa-check"></i> Simpan Pengguna
                </button>
            </div>
        </div>
    </div>

    <script>
        function togglePegawaiFields() {
            const role = document.getElementById('role').value;
            const pegawaiFields = document.getElementById('pegawaiFields');
            const operatorInfo = document.getElementById('operatorInfo');
            const pegawaiInputs = pegawaiFields.querySelectorAll('input');

            if (role === 'operator') {
                // Hide pegawai fields for operator
                pegawaiFields.style.display = 'none';
                operatorInfo.style.display = 'block';
                // Remove required from pegawai fields
                pegawaiInputs.forEach(input => {
                    input.removeAttribute('required');
                });
            } else {
                // Show pegawai fields
                pegawaiFields.style.display = 'block';
                operatorInfo.style.display = 'none';
                // Add required to pegawai fields
                pegawaiInputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            togglePegawaiFields();
        });
    </script>
@endsection