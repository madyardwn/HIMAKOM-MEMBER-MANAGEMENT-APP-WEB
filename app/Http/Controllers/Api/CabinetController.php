<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabinet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CabinetController extends Controller
{
    // {
    //     "status": "success",
    //     "data": [
    //       {
    //         "id": 1,
    //         "name": "Darma Revolusi",
    //         "description": "Perubahan dari sosial maupun budaya yang berlangsung cepat dan melibatkan poin utama dari dasar atau kehidupan.",
    //         "visi": "Terwujudnya anggota HIMAKOM POLBAN yang kompeten dalam bidang IPTEK maupun bakat pada dirinya,juga memiliki rasa sosial yang tinggi,beretika dengan baik, serta beradab mulia.",
    //         "misi": "Menfasilitasi para anggota HIMAKOM POLBAN dalam mengembangkan potensi diri yang positif pada minatnya baik itu dalam akademik maupun non akademik\r\nMeningkatkan sikap melek teknologi informasi tentang perkembangan teknologi di era saat ini\r\nMeningkatkan nilai-nilai kebersamaan antar anggota HIMAKOM POLBAN agar terwujudnya rasa kepedulian sesama anggota didalam HIMAKOM maupun diluar HIMAKOM",
    //         "logo": "http://dev.neracietas.site/storage/cabinets/logo/2023-10-03-03-17-58_Dharma Revolusi.jpg",
    //         "filosofy": "http://dev.neracietas.site/storage/cabinets/filosofy/2023-10-03-03-17-58_Dharma Revolusi.png",
    //         "filosofies": [
    //           {
    //             "id": 1,
    //             "cabinet_id": 1,
    //             "label": "Eagle: Elang sebagai peran yang berani tangkas dan dapat fokus pada target perkembangan teknologi, mampu meingkatkan potensi dirinya ketika di udara.",
    //             "logo": "http://dev.neracietas.site/storage/filosofy/2HqZrkY27fdbE4fraQL8q3261d72o1AmW49jFNCp.png"
    //           },
    //           {
    //             "id": 2,
    //             "cabinet_id": 1,
    //             "label": "Biru tua: Kesetiaan, kepercayaan dan kestabilan. Menggambarkan kabinet yang setia dan stabil serta dipercaya oleh anggota HIMAKOM.\r\n\r\nPutih: Kesucian, kejujuran dan kebersihan. Menggambarkan kabinet yang jujur, transparan dan baik.",
    //             "logo": "http://dev.neracietas.site/storage/filosofy/CpPcDqxqt9gR96g1LWkLZdJ3qMpb78yMObGrJUop.png"
    //           },
    //           {
    //             "id": 3,
    //             "cabinet_id": 1,
    //             "label": "Teknologi: Kemajuan dan Revolusi. Simbol kemajuan dan inovasi dapat membawa perubahan positif dalam HIMAKOM ini, yang sesuai dengan nama kabinet kita yaitu Darma Revolusi",
    //             "logo": "http://dev.neracietas.site/storage/filosofy/2cWT4MfLqejehFuYToFxEzVKB9v26xoN23vJERhK.png"
    //           },
    //           {
    //             "id": 4,
    //             "cabinet_id": 1,
    //             "label": "Dua sayap: Melambangkan 2 prodi yang ada di Himakom, yang berarti bila satu prodi tidak ada atau satu sayap tida ada maka elang atau HIMAKOM tidak akan bisa terbang",
    //             "logo": "http://dev.neracietas.site/storage/filosofy/4b6pg4asosGBPXTdvE3oU7K061ts6EO38YObC0gH.png"
    //           },
    //           {
    //             "id": 5,
    //             "cabinet_id": 1,
    //             "label": "Ujung lancip: Melambangkan ketajaman, kecepatan, dan keberanian dari HIMAKOM kabinet Darma Revolusi",
    //             "logo": "http://dev.neracietas.site/storage/filosofy/pS6RFTpZXdh2L7vFBBneviHxXB3RHWm5D6KJyFJR.png"
    //           },
    //           {
    //             "id": 6,
    //             "cabinet_id": 1,
    //             "label": "Menileh ke kanan: Anggapan bahwa arah kanan adalah yang baik. Harapan untuk HIMAKOM menjadi himpunan yang benar dan bermaksud agar HIMAKOM tidak menempuh jalan yang salah",
    //             "logo": "http://dev.neracietas.site/storage/filosofy/DgfiCxMcHcX1GBqiRhYdNgqtPrXsMuu1GQNNxgof.png"
    //           }
    //         ]
    //       }
    //     ]
    // }
    public function cabinet(Request $request)
    {
        try {
            $users = Cabinet::with('users.roles')
                ->withWhereHas('users', function ($query) {
                    $query->withWhereHas('roles', function ($query) {
                        $query->where('name', '=', 'ketua-himpunan')
                            ->orWhere('name', '=', 'wakil-ketua-himpunan')
                            ->orWhere('name', '=', 'ketua-divisi')
                            ->orWhere('name', '=', 'wakil-ketua-divisi');
                    });
                })
                ->where('is_active', '=', true)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $users,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get users.',
            ], 500);
        }
    }
}
