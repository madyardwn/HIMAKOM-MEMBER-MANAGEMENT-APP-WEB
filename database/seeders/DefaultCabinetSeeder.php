<?php

namespace Database\Seeders;

use App\Models\Cabinet;
use App\Models\DBU;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCabinetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabinet = Cabinet::create([
            'name' => 'DARMA REVOLUSI',
            'description' => 'Perubahan dari sosial maupun budaya yang berlangsung cepat dan melibatkan poin utama dari dasar atau kehidupan.',
            'logo' => config('tablar.default.logo.path'),
            'year' => 2022,
            'is_active' => true,
            'visi' => 'Terwujudnya anggota HIMAKOM POLBAN yang kompeten dalam bidang IPTEK maupun bakat pada dirinya,juga memiliki rasa sosial yang tinggi,beretika dengan baik, serta beradab mulia.',
            'misi' => 'Menfasilitasi para anggota HIMAKOM POLBAN dalam mengembangkan potensi diri yang positif pada minatnya baik itu dalam akademik maupun non akademik
            Meningkatkan sikap melek teknologi informasi tentang perkembangan teknologi di era saat ini
            Meningkatkan nilai-nilai kebersamaan antar anggota HIMAKOM POLBAN agar terwujudnya rasa kepedulian sesama anggota didalam HIMAKOM maupun diluar HIMAKOM',
        ]);
        $cabinet->dbus()->attach(DBU::all('id'));
    }
}
