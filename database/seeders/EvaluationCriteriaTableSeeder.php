<?php

namespace Database\Seeders;

use App\Models\EvaluationCriteria;
use Illuminate\Database\Seeder;

class EvaluationCriteriaTableSeeder extends Seeder
{
    public function run()
    {
        // Common criteria for all groups
        $commonCriteria = [
            // Bahagian III - Penghasilan Kerja (50%)
            [
                'bahagian' => 'III',
                'kriteria' => 'Kuantiti Hasil Kerja',
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            [
                'bahagian' => 'III',
                'kriteria' => 'Kualiti Hasil Kerja',
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            [
                'bahagian' => 'III',
                'kriteria' => 'Ketepatan Masa',
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            [
                'bahagian' => 'III',
                'kriteria' => 'Keberkesanan Hasil Kerja',
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            
            // Bahagian VI - Kegiatan dan Sumbangan (5%)
            [
                'bahagian' => 'VI',
                'kriteria' => 'Kegiatan dan Sumbangan di Luar Tugas Rasmi',
                'wajaran' => 5,
                'kumpulan_pyd' => null
            ],
        ];

        // Criteria for Pengurusan dan Professional
        $pengurusanCriteria = [
            // Bahagian IV - Pengetahuan dan Kemahiran (25%)
            [
                'bahagian' => 'IV',
                'kriteria' => 'Ilmu Pengetahuan dan Kemahiran dalam Bidang Kerja',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'Pelaksanaan Dasar, Peraturan dan Arahan Pentadbiran',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'Keberkesanan Komunikasi',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            
            // Bahagian V - Kualiti Peribadi (20%)
            [
                'bahagian' => 'V',
                'kriteria' => 'Ciri-ciri Memimpin',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Kebolehan Mengelola',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Disiplin',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Proaktif dan Inovatif',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Jalinan Hubungan dan Kerjasama',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
        ];

        // Criteria for Sokongan (I)
        $sokongan1Criteria = [
            // Bahagian IV - Kualiti Peribadi (25%)
            [
                'bahagian' => 'IV',
                'kriteria' => 'Kebolehan Mengelola',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'Disiplin',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'Proaktif dan Inovatif',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'Jalinan Hubungan dan Kerjasama',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            
            // Bahagian V - Kualiti Peribadi (20%)
            [
                'bahagian' => 'V',
                'kriteria' => 'Kebolehan Mengelola',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Disiplin',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Proaktif dan Inovatif',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Jalinan Hubungan dan Kerjasama',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
        ];

        // Criteria for Sokongan (II)
        $sokongan2Criteria = [
            // Bahagian IV - Pengetahuan dan Kemahiran (25%)
            [
                'bahagian' => 'IV',
                'kriteria' => 'Ilmu Pengetahuan dan Kemahiran dalam Bidang Kerja',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'Pelaksanaan Peraturan dan Arahan Pentadbiran',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'Keberkesanan Komunikasi',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            
            // Bahagian V - Kualiti Peribadi (20%)
            [
                'bahagian' => 'V',
                'kriteria' => 'Kebolehan Mengelola',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Disiplin',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Proaktif dan Inovatif',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'Jalinan Hubungan dan Kerjasama',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
        ];

        $allCriteria = array_merge(
            $commonCriteria,
            $pengurusanCriteria,
            $sokongan1Criteria,
            $sokongan2Criteria
        );

        foreach ($allCriteria as $criteria) {
            EvaluationCriteria::create($criteria);
        }
    }
}