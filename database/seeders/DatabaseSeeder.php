<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\Candidate;
use App\Models\CandidateScore;
use App\Models\SwotEvaluation;
use App\Services\SmartSwotService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        User::firstOrCreate(
            ['email' => 'admin@sentraniaga.com'],
            [
                'name' => 'Administrator SPK',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'hrd@sentraniaga.com'],
            [
                'name' => 'Tim HRD Sentra Niaga',
                'password' => Hash::make('password'),
                'role' => 'hrd',
            ]
        );

        // 2. Seed Criteria C1 - C4
        $criterias = [
            [
                'code' => 'C1',
                'name' => 'Integritas (Catatan Kriminal)',
                'type' => 'benefit',
                'weight' => 30,
                'min_val' => 1,
                'max_val' => 5,
                'sub_criterias' => [
                    1 => 'Pernah terlibat kasus kriminal berat',
                    2 => 'Pernah terlibat kasus ringan / pelanggaran',
                    3 => 'Tidak ada catatan, belum ada SKCK',
                    4 => 'Memiliki SKCK bersih',
                    5 => 'SKCK bersih + referensi karakter dari institusi',
                ]
            ],
            [
                'code' => 'C2',
                'name' => 'Kesehatan Fisik',
                'type' => 'benefit',
                'weight' => 25,
                'min_val' => 1,
                'max_val' => 5,
                'sub_criterias' => [
                    1 => 'Ada penyakit berat / tidak layak tugas lapangan',
                    2 => 'Kondisi kurang prima, ada keterbatasan fisik',
                    3 => 'Sehat, belum ada hasil medical check-up',
                    4 => 'Sehat berdasarkan medical check-up',
                    5 => 'Sehat prima + lulus tes fisik (lari, push-up, dll)',
                ]
            ],
            [
                'code' => 'C3',
                'name' => 'Pengalaman Kerja',
                'type' => 'benefit',
                'weight' => 25,
                'min_val' => 1,
                'max_val' => 5,
                'sub_criterias' => [
                    1 => 'Tidak ada pengalaman sama sekali',
                    2 => '< 1 tahun pengalaman security',
                    3 => '1–2 tahun pengalaman security',
                    4 => '3–5 tahun pengalaman security',
                    5 => '> 5 tahun atau pernah di lingkungan perkantoran/mal',
                ]
            ],
            [
                'code' => 'C4',
                'name' => 'Kesiapan Shift',
                'type' => 'benefit',
                'weight' => 20,
                'min_val' => 1,
                'max_val' => 5,
                'sub_criterias' => [
                    1 => 'Hanya bisa shift tertentu, tidak fleksibel',
                    2 => 'Bisa 2 shift, ada kendala transportasi',
                    3 => 'Bisa semua shift tapi belum terbukti',
                    4 => 'Bisa semua shift, domisili dekat lokasi',
                    5 => 'Siap semua shift + pengalaman shift malam sebelumnya',
                ]
            ]
        ];

        foreach ($criterias as $critData) {
            $subData = $critData['sub_criterias'];
            unset($critData['sub_criterias']);

            $crit = Criteria::updateOrCreate(
                ['code' => $critData['code']],
                $critData
            );

            foreach ($subData as $val => $desc) {
                SubCriteria::updateOrCreate(
                    [
                        'criteria_id' => $crit->id,
                        'value' => $val,
                    ],
                    ['description' => $desc]
                );
            }
        }

        // 3. Seed Candidates & Scores
        $candidatesData = [
            [
                'code' => 'K01',
                'nik' => '3275011204950001',
                'name' => 'Ahmad Rifai',
                'gender' => 'L',
                'phone' => '081234567891',
                'address' => 'Jl. Ahmad Yani No. 12, Bekasi Selatan',
                'scores' => ['C1' => 5, 'C2' => 5, 'C3' => 4, 'C4' => 5],
                'swot' => ['S' => 4.8, 'W' => 1.5, 'O' => 4.5, 'T' => 1.5]
            ],
            [
                'code' => 'K02',
                'nik' => '3275012508960002',
                'name' => 'Budi Santoso',
                'gender' => 'L',
                'phone' => '081234567892',
                'address' => 'Jl. Hasibuan No. 45, Bekasi Timur',
                'scores' => ['C1' => 4, 'C2' => 4, 'C3' => 5, 'C4' => 4],
                'swot' => ['S' => 4.2, 'W' => 2.0, 'O' => 4.0, 'T' => 2.0]
            ],
            [
                'code' => 'K03',
                'nik' => '3275011902940003',
                'name' => 'Candra Wijaya',
                'gender' => 'L',
                'phone' => '081234567893',
                'address' => 'Jl. Cut Mutia No. 88, Rawalumbu, Bekasi',
                'scores' => ['C1' => 4, 'C2' => 3, 'C3' => 3, 'C4' => 4],
                'swot' => ['S' => 3.5, 'W' => 2.5, 'O' => 3.5, 'T' => 2.5]
            ],
            [
                'code' => 'K04',
                'nik' => '3275010811970004',
                'name' => 'Dedi Kurniawan',
                'gender' => 'L',
                'phone' => '081234567894',
                'address' => 'Jl. Joyo Martono No. 10, Tambun, Bekasi',
                'scores' => ['C1' => 3, 'C2' => 4, 'C3' => 2, 'C4' => 3],
                'swot' => ['S' => 3.0, 'W' => 3.0, 'O' => 3.0, 'T' => 3.0]
            ],
            [
                'code' => 'K05',
                'nik' => '3275011406980005',
                'name' => 'Eko Prasetyo',
                'gender' => 'L',
                'phone' => '081234567895',
                'address' => 'Jl. Sultan Agung No. 5, Medansatria, Bekasi',
                'scores' => ['C1' => 2, 'C2' => 2, 'C3' => 1, 'C4' => 2],
                'swot' => ['S' => 2.0, 'W' => 4.0, 'O' => 2.0, 'T' => 4.0]
            ],
        ];

        foreach ($candidatesData as $cData) {
            $scores = $cData['scores'];
            $swotData = $cData['swot'];
            unset($cData['scores'], $cData['swot']);

            $cand = Candidate::updateOrCreate(
                ['code' => $cData['code']],
                $cData
            );

            foreach ($scores as $cCode => $val) {
                $crit = Criteria::where('code', $cCode)->first();
                if ($crit) {
                    CandidateScore::updateOrCreate(
                        [
                            'candidate_id' => $cand->id,
                            'criteria_id' => $crit->id,
                        ],
                        ['score_val' => $val]
                    );
                }
            }

            SwotEvaluation::updateOrCreate(
                ['candidate_id' => $cand->id],
                [
                    'strengths_score' => $swotData['S'],
                    'weaknesses_score' => $swotData['W'],
                    'opportunities_score' => $swotData['O'],
                    'threats_score' => $swotData['T'],
                ]
            );
        }

        // Run initial SMART-SWOT calculations
        app(SmartSwotService::class)->calculateAll();
    }
}
