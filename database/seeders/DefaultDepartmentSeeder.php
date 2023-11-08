<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'MAJELIS PERWAKILAN ANGGOTA',
            'short_name' => 'MPA',
            'description' => 'Majelis Perwakilan Anggota merupakan organisasi legislatif yang bertanggung jawab terhadap pembuatan serta mengamandemen Anggaran Dasar dan Anggaran Rumah Tangga di Himpunan Mahasiswa Komputer Politeknik Negeri Bandung.',
            'logo' => 'MPA.png',
        ]);

        Department::create([
            'name' => 'DEPARTEMEN RISET, PENDIDIKAN, DAN TEKNOLOGI',
            'short_name' => 'RISETDIKTI',
            'description' => 'Departemen Riset, Pendidikan, dan Teknologi (RISETDIKTI) adalah departemen yang berfungsi untuk mewadahi kegiatan anggota HIMAKOM POLBAN yang berkaitan dengan pengembangan akademik, penelitian dan teknologi.',
            'logo' => 'RISETDIKTI.png',
        ]);

        Department::create([
            'name' => 'DEPARTEMEN ROHANI ISLAM',
            'short_name' => 'ROHIS',
            'description' => 'Departemen Rohani Islam adalah departemen yang berfokus dalam pembinaan dan pendalaman ajaran agama Islam, serta sebagai penunjang kenyamanan beribadah umat muslim di lingkungan HIMAKOM POLBAN.',
            'logo' => 'ROHIS.png',
        ]);

        Department::create([
            'name' => 'DEPARTEMEN PENGEMBANGAN SUMBER DAYA ANGGOTA',
            'short_name' => 'PSDA',
            'description' => 'Departemen Pengembangan Sumber Daya Anggota merupakan sebuah departemen yang berfokus dalam mengembangkan kualitas dan potensi anggota Himpunan Mahasiswa Jurusan Teknik Komputer dan Informatika POLBAN.',
            'logo' => 'PSDA.png',
        ]);

        Department::create([
            'name' => 'DEPARTEMEN SENI DAN OLAHRAGA',
            'short_name' => 'SENOR',
            'description' => 'Departement Seni dan Olahraga (SENOR) adalah departemen yang bekerja untuk mewadahi kegiatan-kegiatan anggota HIMAKOM POLBAN yang berkaitan dengan kegiatan Olahraga dan Seni.',
            'logo' => 'SENOR.png',
        ]);

        Department::create([
            'name' => 'BIRO KEUANGAN',
            'short_name' => 'KEUANGAN',
            'description' => 'Biro Keuangan adalah biro yang mengelola dan melayani administrasi keuangan HIMAKOM POLBAN.',
            'logo' => 'KEUANGAN.png',
        ]);

        Department::create([
            'name' => 'BIRO KOMUNIKASI DAN INFORMASI',
            'short_name' => 'KOMINFO',
            'description' => 'Biro Komunikasi dan Informasi HIMAKOM Politeknik Negeri Bandung, yang kemudian disingkat menjadi Biro Kominfo HIMAKOM POLBAN, merupakan biro yang berfokus pada bidang pelayanan komunikasi dan informasi.',
            'logo' => 'KOMINFO.png',
        ]);

        Department::create([
            'name' => 'BIRO ADMINISTRASI DAN KESEKRETARIATAN',
            'short_name' => 'ADKES',
            'description' => 'Biro Administrasi dan Kesekretariatan merupakan biro yang bertanggung jawab terhadap pembuatan serta pengelolaan administrasi dan kesekretariatan di Himpunan Mahasiswa Komputer Politeknik Negeri Bandung.',
            'logo' => 'ADKES.png',
        ]);

        Department::create([
            'name' => 'UNIT KEWIRAUSAHAAN',
            'short_name' => 'WIRUS',
            'description' => 'Unit Kewirausahaan merupakan salah satu unit  yang terdapat dalam struktur organisasi Himpunan Mahasiswa Komputer (HIMAKOM). Unit ini bertanggung jawab untuk mengembangkan keterampilan dan pengetahuan kewirausahaan di kalangan mahasiswa komputer.',
            'logo' => 'WIRUS.png',
        ]);

        Department::create([
            'name' => 'UNIT TEKNOLOGI',
            'short_name' => 'TEKNO',
            'description' => 'Unit Teknologi adalah unit kegiatan yang berfokus pada teknologi, khususnya dalam pengembangan sumber daya anggota dalam rangka meningkatkan kualitas keilmuan di bidang informatika.',
            'logo' => 'TEKNO.png',
        ]);

        Department::create([
            'name' => 'DEPARTEMEN LUAR HIMPUNAN',
            'short_name' => 'LUHIM',
            'description' => 'Departemen Luar Himpunan merupakan departemen yang berfokus dalam menjalin hubungan dan kerjasama antara HIMAKOM POLBAN dengan pihak eksternal dan alumni HIMAKOM POLBAN sehingga terbentuk forum bilateral maupun multilateral.',
            'logo' => 'LUHIM.png',
        ]);
    }
}
