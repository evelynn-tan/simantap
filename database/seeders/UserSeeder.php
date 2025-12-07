<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Operator;

/**
 * UserSeeder - Seeder untuk data User, Pegawai, dan Operator
 * 
 * Membuat akun operator BMN dan pegawai BPS untuk sistem SIMANTAP
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Users, Operators, dan Pegawai...');

        // =========== SEED OPERATORS ===========
        $this->seedOperators();

        // =========== SEED PEGAWAI ===========
        $this->seedPegawai();

        $this->command->info('✓ Users seeded successfully!');
    }

    /**
     * Seed data Operator BMN
     */
    private function seedOperators(): void
    {
        $operators = [
            [
                'email' => 'operator1@bps.go.id',
                'password' => 'password',
            ],
            [
                'email' => 'operator2@bps.go.id',
                'password' => 'password',
            ],
        ];

        foreach ($operators as $data) {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'operator',
            ]);

            Operator::create([
                'userID' => $user->userID,
            ]);
        }

        $this->command->info('  → Created ' . count($operators) . ' Operator accounts');
    }

    /**
     * Seed data Pegawai BPS
     */
    private function seedPegawai(): void
    {
        $pegawaiData = [
            [
                'email' => 'nabhan@bps.go.id',
                'nama_lengkap' => 'Nabhan Athallah',
                'nip' => '19850510200921001',
                'jabatan' => 'Statistisi Ahli Pertama',
                'divisi' => 'Fungsional',
            ],
            [
                'email' => 'faruq@bps.go.id',
                'nama_lengkap' => 'M. Faruq Hafidzullah',
                'nip' => '199002152012022001',
                'jabatan' => 'Statistisi Ahli Muda',
                'divisi' => 'Fungsional',
            ],
            [
                'email' => 'danang@bps.go.id',
                'nama_lengkap' => 'Danang Ivan Pangestu',
                'nip' => '198608202010011002',
                'jabatan' => 'Pranata Komputer',
                'divisi' => 'Fungsional',
            ],
            [
                'email' => 'difya@bps.go.id',
                'nama_lengkap' => 'Difya Ayu Meisya',
                'nip' => '199105152013022001',
                'jabatan' => 'Statistisi Penyelia',
                'divisi' => 'Fungsional',
            ],
            [
                'email' => 'aulia@bps.go.id',
                'nama_lengkap' => 'Aulia Ul Hasanah',
                'nip' => '199203182014022002',
                'jabatan' => 'Analis Data',
                'divisi' => 'Fungsional',
            ],
            [
                'email' => 'evelyn@bps.go.id',
                'nama_lengkap' => 'Evelyn Tan Eldisha',
                'nip' => '199401202015022001',
                'jabatan' => 'Pranata Humas',
                'divisi' => 'Fungsional',
            ],
            [
                'email' => 'indri@bps.go.id',
                'nama_lengkap' => 'Indri Putri Lestari',
                'nip' => '199502202016022003',
                'jabatan' => 'Staf Keuangan',
                'divisi' => 'Administrasi',
            ],
            [
                'email' => 'bambang@bps.go.id',
                'nama_lengkap' => 'Bambang Setiawan',
                'nip' => '198712102008011004',
                'jabatan' => 'Koordinator Umum',
                'divisi' => 'Administrasi',
            ],
            [
                'email' => 'siti@bps.go.id',
                'nama_lengkap' => 'Siti Marhaeni',
                'nip' => '199003112017022005',
                'jabatan' => 'Asisten Statistisi',
                'divisi' => 'Fungsional',
            ],
            [
                'email' => 'rudi@bps.go.id',
                'nama_lengkap' => 'Rudi Hartono',
                'nip' => '198506302009021006',
                'jabatan' => 'Teknisi',
                'divisi' => 'Teknis',
            ],
        ];

        foreach ($pegawaiData as $data) {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'pegawai',
            ]);

            Pegawai::create([
                'userID' => $user->userID,
                'nama_lengkap' => $data['nama_lengkap'],
                'nip' => $data['nip'],
                'jabatan' => $data['jabatan'],
                'divisi' => $data['divisi'],
            ]);
        }

        $this->command->info('  → Created ' . count($pegawaiData) . ' Pegawai accounts');
    }
}
