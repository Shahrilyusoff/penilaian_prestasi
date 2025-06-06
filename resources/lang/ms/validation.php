<?php

return [
    'accepted' => 'Sila terima :attribute.',
    'active_url' => ':attribute bukan URL yang sah.',
    'after' => ':attribute mestilah tarikh selepas :date.',
    'after_or_equal' => ':attribute mestilah tarikh selepas atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash' => ':attribute hanya boleh mengandungi huruf, nombor, sengkang dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh mengandungi huruf dan nombor.',
    'array' => ':attribute mestilah array.',
    'before' => ':attribute mestilah tarikh sebelum :date.',
    'before_or_equal' => ':attribute mestilah tarikh sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ':attribute mestilah antara :min dan :max.',
        'file' => ':attribute mestilah antara :min dan :max kilobait.',
        'string' => ':attribute mestilah antara :min dan :max aksara.',
        'array' => ':attribute mestilah antara :min dan :max item.',
    ],
    'boolean' => 'Medan :attribute mestilah benar atau salah.',
    'confirmed' => 'Pengesahan :attribute tidak sepadan.',
    'date' => ':attribute bukan tarikh yang sah.',
    'date_equals' => ':attribute mestilah tarikh sama dengan :date.',
    'date_format' => ':attribute tidak sepadan dengan format :format.',
    'different' => ':attribute dan :other mestilah berbeza.',
    'digits' => ':attribute mestilah :digits digit.',
    'digits_between' => ':attribute mestilah antara :min dan :max digit.',
    'dimensions' => ':attribute mempunyai dimensi imej yang tidak sah.',
    'distinct' => 'Medan :attribute mempunyai nilai pendua.',
    'email' => ':attribute mestilah alamat e-mel yang sah.',
    'ends_with' => ':attribute mestilah berakhir dengan salah satu dari yang berikut: :values.',
    'exists' => ':attribute yang dipilih tidak sah.',
    'file' => ':attribute mestilah fail.',
    'filled' => 'Medan :attribute mesti mempunyai nilai.',
    'gt' => [
        'numeric' => ':attribute mestilah lebih besar daripada :value.',
        'file' => ':attribute mestilah lebih besar daripada :value kilobait.',
        'string' => ':attribute mestilah lebih besar daripada :value aksara.',
        'array' => ':attribute mestilah mempunyai lebih daripada :value item.',
    ],
    'gte' => [
        'numeric' => ':attribute mestilah lebih besar daripada atau sama dengan :value.',
        'file' => ':attribute mestilah lebih besar daripada atau sama dengan :value kilobait.',
        'string' => ':attribute mestilah lebih besar daripada atau sama dengan :value aksara.',
        'array' => ':attribute mestilah mempunyai :value item atau lebih.',
    ],
    'image' => ':attribute mestilah imej.',
    'in' => ':attribute yang dipilih tidak sah.',
    'in_array' => 'Medan :attribute tidak wujud dalam :other.',
    'integer' => ':attribute mestilah integer.',
    'ip' => ':attribute mestilah alamat IP yang sah.',
    'ipv4' => ':attribute mestilah alamat IPv4 yang sah.',
    'ipv6' => ':attribute mestilah alamat IPv6 yang sah.',
    'json' => ':attribute mestilah JSON string yang sah.',
    'lt' => [
        'numeric' => ':attribute mestilah kurang daripada :value.',
        'file' => ':attribute mestilah kurang daripada :value kilobait.',
        'string' => ':attribute mestilah kurang daripada :value aksara.',
        'array' => ':attribute mestilah mempunyai kurang daripada :value item.',
    ],
    'lte' => [
        'numeric' => ':attribute mestilah kurang daripada atau sama dengan :value.',
        'file' => ':attribute mestilah kurang daripada atau sama dengan :value kilobait.',
        'string' => ':attribute mestilah kurang daripada atau sama dengan :value aksara.',
        'array' => ':attribute mestilah tidak mempunyai lebih daripada :value item.',
    ],
    'max' => [
        'numeric' => ':attribute tidak boleh lebih besar daripada :max.',
        'file' => ':attribute tidak boleh lebih besar daripada :max kilobait.',
        'string' => ':attribute tidak boleh lebih besar daripada :max aksara.',
        'array' => ':attribute tidak boleh mempunyai lebih daripada :max item.',
    ],
    'mimes' => ':attribute mestilah fail jenis: :values.',
    'mimetypes' => ':attribute mestilah fail jenis: :values.',
    'min' => [
        'numeric' => ':attribute mestilah sekurang-kurangnya :min.',
        'file' => ':attribute mestilah sekurang-kurangnya :min kilobait.',
        'string' => ':attribute mestilah sekurang-kurangnya :min aksara.',
        'array' => ':attribute mestilah mempunyai sekurang-kurangnya :min item.',
    ],
    'not_in' => ':attribute yang dipilih tidak sah.',
    'not_regex' => 'Format :attribute tidak sah.',
    'numeric' => ':attribute mestilah nombor.',
    'password' => 'Kata laluan tidak betul.',
    'present' => 'Medan :attribute mesti wujud.',
    'regex' => 'Format :attribute tidak sah.',
    'required' => 'Medan :attribute diperlukan.',
    'required_if' => 'Medan :attribute diperlukan apabila :other ialah :value.',
    'required_unless' => 'Medan :attribute diperlukan kecuali :other ada dalam :values.',
    'required_with' => 'Medan :attribute diperlukan apabila :values wujud.',
    'required_with_all' => 'Medan :attribute diperlukan apabila :values wujud.',
    'required_without' => 'Medan :attribute diperlukan apabila :values tidak wujud.',
    'required_without_all' => 'Medan :attribute diperlukan apabila tiada :values wujud.',
    'same' => ':attribute dan :other mesti sepadan.',
    'size' => [
        'numeric' => ':attribute mestilah :size.',
        'file' => ':attribute mestilah :size kilobait.',
        'string' => ':attribute mestilah :size aksara.',
        'array' => ':attribute mesti mengandungi :size item.',
    ],
    'starts_with' => ':attribute mesti bermula dengan salah satu daripada yang berikut: :values.',
    'string' => ':attribute mestilah string.',
    'timezone' => ':attribute mestilah zon masa yang sah.',
    'unique' => ':attribute telah pun diambil.',
    'uploaded' => ':attribute gagal dimuat naik.',
    'url' => 'Format :attribute tidak sah.',
    'uuid' => ':attribute mestilah UUID yang sah.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    'attributes' => [
        'name' => 'nama',
        'email' => 'emel',
        'password' => 'kata laluan',
        'password_confirmation' => 'pengesahan kata laluan',
        'current_password' => 'kata laluan semasa',
        'jawatan' => 'jawatan',
        'gred' => 'gred',
        'kementerian_jabatan' => 'kementerian/jabatan',
        'pyd_group_id' => 'kumpulan PYD',
        'peranan' => 'peranan',
        'tahun' => 'tahun',
        'tarikh_mula' => 'tarikh mula',
        'tarikh_tamat' => 'tarikh tamat',
        'status' => 'status',
        'boleh_ubah_selepas_tamat' => 'boleh ubah selepas tamat',
        'aktiviti_projek' => 'aktiviti/projek',
        'petunjuk_prestasi' => 'petunjuk prestasi',
        'tambahan_pertengahan_tahun' => 'tambahan pertengahan tahun',
        'guguran_pertengahan_tahun' => 'guguran pertengahan tahun',
        'laporan_akhir_pyd' => 'laporan akhir PYD',
        'ulasan_akhir_ppp' => 'ulasan akhir PPP',
        'pyd_id' => 'PYD',
        'ppp_id' => 'PPP',
        'ppk_id' => 'PPK',
        'kegiatan_sumbangan' => 'kegiatan dan sumbangan',
        'latihan_dihadiri' => 'latihan dihadiri',
        'latihan_diperlukan' => 'latihan diperlukan',
        'tempoh_penilaian_ppp_mula' => 'tempoh penilaian PPP mula',
        'tempoh_penilaian_ppp_tamat' => 'tempoh penilaian PPP tamat',
        'ulasan_keseluruhan_ppp' => 'ulasan keseluruhan PPP',
        'kemajuan_kerjaya_ppp' => 'kemajuan kerjaya PPP',
        'tempoh_penilaian_ppk_mula' => 'tempoh penilaian PPK mula',
        'tempoh_penilaian_ppk_tamat' => 'tempoh penilaian PPK tamat',
        'ulasan_keseluruhan_ppk' => 'ulasan keseluruhan PPK',
        'markah_ppp' => 'markah PPP',
        'markah_ppk' => 'markah PPK',
    ],
];