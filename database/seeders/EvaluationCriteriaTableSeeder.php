<?php

namespace Database\Seeders;

use App\Models\EvaluationCriteria;
use Illuminate\Database\Seeder;

class EvaluationCriteriaTableSeeder extends Seeder
{
    public function run()
    {
        $commonCriteria = [
            [
                'bahagian' => 'III',
                'kriteria' => 'KUANTITI HASIL KERJA',
                'description' => 'Kuantiti hasil kerja seperti jumlah, bilangan, kadar, kekerapan dan sebagainya berbanding dengan sasaran kuantiti kerja yang diterapkan',
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            [
                'bahagian' => 'III',
                'kriteria' => 'KUALITI HASIL KERJA',
                'description' => "1. Dinilai dari segi kesempurnaan, teratur dan kemas.\n2. Dinilai dari segi usaha dan inisiatif untuk mencapai kesempurnaan hasil kerja",
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            [
                'bahagian' => 'III',
                'kriteria' => 'KETEPATAN MASA',
                'description' => 'Kebolehan menghasilkan kerja atau melaksanakan tugas dalam tempoh masa yang ditetapkan',
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            [
                'bahagian' => 'III',
                'kriteria' => 'KEBERKESANAN HASIL KERJA',
                'description' => "Dinilai dari segi memenuhi kehendak 'stake-holder' atau pelanggan",
                'wajaran' => 50,
                'kumpulan_pyd' => null
            ],
            [
                'bahagian' => 'VI',
                'kriteria' => 'Kegiatan dan Sumbangan di Luar Tugas Rasmi',
                'description' => 'Berasaskan maklumat di Bahagian II perenggan 1, Pegawai Penilai dikehendaki memberi penilaian dengan menggunakan skala 1 hingga 10. Tiada sebarang markah boleh diberikan (kosong) jika PYD tidak mencatat kegiatan atau sumbangannya.',
                'wajaran' => 5,
                'kumpulan_pyd' => null
            ],
        ];

        $pengurusanCriteria = [
            [
                'bahagian' => 'IV',
                'kriteria' => 'ILMU PENGETAHUAN DAN KEMAHIRAN DALAM BIDANG KERJA',
                'description' => 'Mempunyai ilmu pengetahuan dan kemahiran dalam menghasilkan kerja meliputi kebolehan mengenalpasti, menganalisis serta menyelesaikan masalah',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'PELAKSANAAN DASAR, PERATURAN DAN ARAHAN PENTADBIRAN',
                'description' => 'Kebolehan menghayati dan melaksanakan dasar, peraturan dan arahan pentadbiran berkaitan dengan bidang tugasnya',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'KEBERKESANAN KOMUNIKASI',
                'description' => "Kebolehan menyampaikan maksud, pendapat, kefahaman atau arahan secara lisan dan tulisan berkaitan dengan bidang tugas merangkumi penguasaan Bahasa melalui tulisan dan lisan dengan menggunakan tatabahasa dan persembahan yang baik",
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'CIRI-CIRI MEMIMPIN',
                'description' => 'Mempunyai wawasan, komitmen, kebolehan membuat keputusan, menggerak dan memberi dorongan kepada pegawai kearah pencapaian objektif organisasi',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'KEBOLEHAN MENGELOLA',
                'description' => 'Keupayaan dan kebolehan menggembleng segala sumber dalam kawalannya seperti kewangan, tenaga manusia, peralatan dan maklumat bagi merancang, mengatur, membahagi dan mengendalikan sesuatu tugas untuk mencapai objektif organisasi',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'DISIPLIN',
                'description' => 'Mempunyai daya kawal diri dari segi mental dan fizikal termasuk mematuhi peraturan, menepati masa, menunaikan janji dan bersifat sabar',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'PROAKTIF DAN INOVATIF',
                'description' => 'Kebolehan menjangka kemungkinan, mencipta dan mengeluarkan idea baru serta membuat pembaharuan bagi mempertingkatkan kualiti dan produktiviti organisasi',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'JALINAN HUBUNGAN DAN KERJASAMA',
                'description' => 'Kebolehan pegawai dalam mewujudkan suasana kerjasama yang harmoni dan mesra serta boleh menyesuaikan diri dalam semua keadaan',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Pengurusan dan Professional'
            ],
        ];

        $sokongan1Criteria = [
            [
                'bahagian' => 'IV',
                'kriteria' => 'ILMU PENGETAHUAN DAN KEMAHIRAN DALAM BIDANG KERJA',
                'description' => 'Mempunyai ilmu pengetahuan dan kemahiran/kepakaran dalam menghasilkan kerja meliputi kebolehan mengenalpasti,menganalisis serta menyelesaikan masalah',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'PELAKSANAAN DASAR, PERATURAN DAN ARAHAN PENTADBIRAN',
                'description' => 'Kebolehan menghayati dan melaksanakan dasar, peraturan dan arahan pentadbiran berkaitan dengan bidang tugasnya',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'KEBERKESANAN KOMUNIKASI',
                'description' => 'Kebolehan menyampaikan maksud, pendapat, kefahaman atau arahan secara lisan dan tulisan berkaitan dengan bidang tugas merangkumi penguasaan bahasa melalui tulisan dan lisan dengan menggunakan tatabahasa dan persembahan yang baik',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'KEBOLEHAN MENGELOLA',
                'description' => 'Keupayaan dan kebolehan menggembleng segala sumber dalam kawalannya seperti kewangan, tenaga manusia, peralatan dan maklumat bagi merancang, mengatur, membahagi dan mengendalikan sesuatu tugas untuk mencapai objektif organisasi',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'DISIPLIN',
                'description' => 'Mempunyai daya kawal diri dari segi mental dan fizikal termasuk mematuhi peraturan, menepati masa, menunaikan janji dan bersifat sabar',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'PROAKTIF DAN INOVATIF',
                'description' => 'Kebolehan menjangka kemungkinan, mencipta dan mengeluarkan idea baru serta membuat pembaharuan bagi mempertingkatkan kualiti dan produktiviti organisasi',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'JALINAN HUBUNGAN DAN KERJASAMA',
                'description' => 'Kebolehan pegawai dalam mewujudkan suasana kerjasama yang harmoni dan mesra serta boleh menyesuaikan diri dalam semua keadaan',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (I)'
            ],
        ];

        $sokongan2Criteria = [
            [
                'bahagian' => 'IV',
                'kriteria' => 'KEBOLEHAN MENGELOLA',
                'description' => 'Keupayaan dan kebolehan menggemleng segala sumber dalam kawalannya seperti kewangan, tenaga manusia, peralatan dan maklumat bagi merancang, mengatur, membahagi dan mengendalikan sesuatu tugas untuk mencapai objektif organisai',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'DISIPLIN',
                'description' => 'Mempunyai daya kawal diri dari segi mental dan fizikal termasuk mematuhi peraturan, menepati masa, menunaikan janji dan bersifat sabar',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'PROAKTIF DAN INOVATIF',
                'description' => 'Kebolehan menjangka kemungkinan, mencipta dan mengeluarkan idea baru serta membuat pembaharuan bagi mempertingkatkan kualiti dan produktiviti organisasi',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'IV',
                'kriteria' => 'JALINAN HUBUNGAN DAN KERJASAMA',
                'description' => 'Kebolehan pegawai dalam mewujudkan suasana kerjasama yang harmoni dan mesra serta boleh menyesuaikan diri dalam semua keadaan',
                'wajaran' => 25,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'ILMU PENGETAHUAN DAN KEMAHIRAN DALAM BIDANG KERJA',
                'description' => 'Mempunyai ilmu pengetahuan dan kemahiran dalam menghasilkan kerja meliputi kebolehan mengenalpasti, menganalisis serta menyelessaikan masalah',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'PELAKSANAAN PERATURAN DAN ARAHAN',
                'description' => 'Kebolehan menghayati dan melaksanakan, peraturan dan arahan pentadbiran berkaitan dengan bidang tugasnya',
                'wajaran' => 20,
                'kumpulan_pyd' => 'Pegawai Kumpulan Perkhidmatan Sokongan (II)'
            ],
            [
                'bahagian' => 'V',
                'kriteria' => 'KEBERKESANAN KOMUNIKASI',
                'description' => 'Kebolehan menyampaikan maksud, pendapat, kefahaman atau arahan',
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