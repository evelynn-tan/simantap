# ERD SIMANTAP - Sistem Manajemen Barang Milik Negara
## BPS Kota Tanjungpinang

**Tanggal**: 4 Desember 2025  
**Versi**: 2.0 (Sesuai Implementasi Laravel)

---

## Diagram ERD

```mermaid
erDiagram
    %% ========== USER & AUTH ==========
    users {
        INT userID PK "AUTO_INCREMENT"
        VARCHAR255 email UK "UNIQUE"
        VARCHAR255 password
        ENUM role "operator, pegawai"
        VARCHAR100 remember_token "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    pegawais {
        INT pegawaiID PK "AUTO_INCREMENT"
        INT userID FK "UNIQUE"
        VARCHAR255 nama_lengkap
        VARCHAR255 nip UK "UNIQUE"
        VARCHAR255 jabatan
        VARCHAR255 divisi
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    operators {
        INT userID PK_FK "NO AUTO_INCREMENT"
    }

    %% ========== MASTER DATA ==========
    kategoris {
        INT categoryID PK "AUTO_INCREMENT"
        VARCHAR255 nama_kategori
        TEXT deskripsi "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    barangs {
        INT barangID PK "AUTO_INCREMENT"
        VARCHAR255 kode_barang "Auto: BRG-001"
        VARCHAR255 namaBarang
        INT categoryID FK
        ENUM satuan "rim,pcs,buah,box,pack,set,lembar,meter,kg,liter"
        INT stok "DEFAULT 0"
        TEXT deskripsi "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% ========== PENGAJUAN ==========
    pengajuans {
        INT pengajuanID PK "AUTO_INCREMENT"
        INT pegawaiID FK
        TIMESTAMP requested_at
        TEXT description
        ENUM status "menunggu, disetujui, ditolak"
        TEXT alasan_penolakan "NULLABLE"
        INT approved_by FK "NULLABLE, ke users"
        TIMESTAMP approved_at "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    pengajuan_details {
        INT pengajuanDetailID PK "AUTO_INCREMENT"
        INT pengajuanID FK
        INT barangID FK
        INT jumlah
        ENUM status "menunggu, disetujui, ditolak"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% ========== TRANSAKSI (UNIFIED) ==========
    transaksis {
        INT transaksiID PK "AUTO_INCREMENT"
        INT userID FK "Operator"
        DATE tanggal
        ENUM jenis "masuk, keluar, penyesuaian"
        VARCHAR255 sumber "NULLABLE"
        TEXT keterangan "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    detail_rangggings {
        INT detailRanggingID PK "AUTO_INCREMENT"
        INT transaksiID FK
        INT barangID FK
        INT jumlah
        INT stok_sebelum "Audit trail"
        INT stok_sesudah "Audit trail"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% ========== STOCK OPNAME ==========
    stock_opnames {
        INT opnameID PK "AUTO_INCREMENT"
        INT userID FK "Operator"
        DATE tanggal_opname
        TEXT keterangan "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    stock_opname_details {
        INT opnameDetailID PK "AUTO_INCREMENT"
        INT opnameID FK
        INT barangID FK
        INT stok_sistem
        INT stok_fisik
        INT stok_selisih "fisik - sistem"
        TEXT keterangan "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% ========== LAPORAN ==========
    laporans {
        INT laporanID PK "AUTO_INCREMENT"
        INT userID FK "Operator"
        ENUM jenis "pengajuan, stok, transaksi"
        DATE periode_awal
        DATE periode_akhir
        INT total_items "DEFAULT 0"
        JSON isi "NULLABLE"
        ENUM status "draft, final, approved"
        TIMESTAMP finalized_at "NULLABLE"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    %% ========== RELATIONSHIPS ==========
    users ||--o| pegawais : "1:1 if pegawai"
    users ||--o| operators : "1:1 if operator"
    
    pegawais ||--o{ pengajuans : "mengajukan"
    users ||--o{ pengajuans : "approves (approved_by)"
    
    pengajuans ||--|{ pengajuan_details : "memiliki"
    barangs ||--o{ pengajuan_details : "diminta"
    
    kategoris ||--o{ barangs : "mengkategorikan"
    
    users ||--o{ transaksis : "melakukan"
    transaksis ||--|{ detail_rangggings : "memiliki"
    barangs ||--o{ detail_rangggings : "ditransaksikan"
    
    users ||--o{ stock_opnames : "melakukan"
    stock_opnames ||--|{ stock_opname_details : "memiliki"
    barangs ||--o{ stock_opname_details : "diopname"
    
    users ||--o{ laporans : "membuat"
```

---

## Ringkasan Tabel

| No | Tabel | Deskripsi | Jumlah Kolom |
|----|-------|-----------|--------------|
| 1 | `users` | Master user (auth) | 6 |
| 2 | `pegawais` | Profile pegawai | 7 |
| 3 | `operators` | Marker operator (hanya FK) | 1 |
| 4 | `kategoris` | Master kategori barang | 4 |
| 5 | `barangs` | Master data barang | 8 |
| 6 | `pengajuans` | Header pengajuan barang | 9 |
| 7 | `pengajuan_details` | Detail item pengajuan | 6 |
| 8 | `transaksis` | Transaksi masuk/keluar/penyesuaian | 7 |
| 9 | `detail_rangggings` | Detail transaksi + audit trail | 7 |
| 10 | `stock_opnames` | Header stock opname | 5 |
| 11 | `stock_opname_details` | Detail opname per barang | 8 |
| 12 | `laporans` | Laporan dengan workflow | 10 |

---

## Perubahan dari ERD Lama

| Aspek | ERD Lama | ERD Baru |
|-------|----------|----------|
| Pegawai | PK = userID | PK = pegawaiID (terpisah) |
| Transaksi | 2 tabel (Masuk/Keluar) | 1 tabel + ENUM jenis |
| Detail Transaksi | 2 tabel | 1 tabel `detail_rangggings` |
| Audit Trail | Tidak ada | `stok_sebelum`, `stok_sesudah` |
| NIP Pegawai | Tidak ada | Ada (unique) |
| Kode Barang | Tidak ada | Auto-generated |
| Status Laporan | Tidak ada | Workflow (draft/final/approved) |

---

## Role & Permissions

```
┌─────────────────────────────────────────────────────┐
│                    OPERATOR                         │
├─────────────────────────────────────────────────────┤
│ ✓ Kelola Data Barang (CRUD)                        │
│ ✓ Kelola Kategori                                   │
│ ✓ Approve/Tolak Pengajuan                          │
│ ✓ Input Transaksi Masuk/Keluar                     │
│ ✓ Melakukan Stock Opname                           │
│ ✓ Generate Laporan                                  │
│ ✓ Kelola User (Pegawai)                            │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│                    PEGAWAI                          │
├─────────────────────────────────────────────────────┤
│ ✓ Lihat Daftar Barang                              │
│ ✓ Ajukan Permintaan Barang                         │
│ ✓ Monitor Status Permintaan                        │
│ ✓ Edit Profil Sendiri                              │
└─────────────────────────────────────────────────────┘
```
