<?php
require_once 'conf.php';

$id = $_GET['id'];
$tgl = $_GET['day'];
$day = date('w', strtotime($tgl));
//var_dump($tgl);
$timeStampData = microtime();
list($msec, $sec) = explode(' ', $timeStampData);
$msec = round($msec * 1000);
$estimasi = $sec . $msec + 1800000;
$hari = array("minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu");


$datapeserta     = bukafetch("SELECT A.*, B.PASIEN_ID NIK  FROM PASIEN_VISITATION A LEFT JOIN PASIEN B ON A.NO_REGISTRATION = B.NO_REGISTRATION                                                              
                            WHERE A.IDXDAFTAR= '$id'"); 
                            //print_r($datapeserta);
if (!empty($datapeserta['NO_REGISTRATION'])) {
$kddokter = $datapeserta['EMPLOYEE_ID'];
$sekarang = $hari[$day];
$jadwal = bukafetch("SELECT A.*,    B.nama_poli poli,
                                        C.nama_dokter dokter,
                                        C.kd_dpjp dpjp,
                                        B.kd_poli_bpjs kdpoli,
                                        B.clinic_id clinic
                                    FROM
                                        m_jadwal A
                                        INNER JOIN m_poli_bpjs B ON A.kd_poli = B.kd_poli_bpjs
                                        INNER JOIN m_dokter_bpjs C ON A.kd_dokter = C.employee_id 
                                    WHERE
                                        A.hari_kerja= '$sekarang' 
                                        AND A.kd_dokter= '$kddokter'"); 
                                        // print_r($jadwal);
        if (!empty($jadwal['poli'])) {
                switch ($datapeserta['CLINIC_ID']) {
                    case "P005":
                        $kode = "D";
                        break;
                    case "P010":
                        $kode = "I";
                        break;
                    case "P008":
                        $kode = "G";
                        break;
                    case "P001":
                        $kode = "A";
                        break;
                    case "P021":
                        $kode = "K";
                        break;
                    case "P011":
                        $kode = "J";
                        break;
                    case "P003":
                        $kode = "B";
                        break;
                    case "P033":
                        $kode = "S";
                        break;
                    case "P030":
                        $kode = "M";
                        break;
                    case "P004":
                        $kode = "C";
                        break;
                    case "P009":
                        $kode = "H";
                        break;
                };

                $mulai = $jadwal['jam_mulai']->format('H:i');
                $selesai = $jadwal['jam_selesai']->format('H:i');

                $response =     $client->request('POST', 'antrean/add', [
                    'headers' => getSignature(),
                    'json' => [
                        'kodebooking' => $datapeserta['idbooking'], //idbooking
                        'jenispasien' => 'JKN',
                        'nomorkartu' => $datapeserta['PASIEN_ID'], //kk_no
                        'nik' => $datapeserta['NIK'], //pasien_id
                        'nohp' => '08588888888', //phone
                        'kodepoli' => $datapeserta['KDPOLI'], //kodepoli
                        'namapoli' => $jadwal['poli'],
                        'pasienbaru' => $datapeserta['ISNEW'], //isnew
                        'norm' =>  $datapeserta['NO_REGISTRATION'], //no_registration
                        'tanggalperiksa' => $tgl,
                        'kodedokter' => $jadwal['dpjp'],
                        'namadokter' => $jadwal['dokter'], // nama dokter
                        'jampraktek' => $mulai . '-' . $selesai ,  //jam praktek
                        'jeniskunjungan' => 1,
                        'nomorreferensi' => $datapeserta['NORUJUKAN'], //rujukan
                        'nomorantrean' => $kode . '-' . $datapeserta['TICKET_NO'], // antrean
                        'angkaantrean' => $datapeserta['TICKET_NO'], //angka
                        'estimasidilayani' => $estimasi,
                        'sisakuotajkn' => 5, // sisa
                        'kuotajkn' => 30, // kouta
                        'sisakuotanonjkn' => 5, // sisa
                        'kuotanonjkn' => 30, // kouta
                        'keterangan' => 'Peserta harap 30 menit lebih awal guna pencatatan administrasi.'
                    ]
                ]);
                $en = json_decode($response->getBody()->getContents());
                if ($en->metadata->code == 200) {
                    pop("Berhasil", "success", "Antrian berhasil ditambahkan", "http://localhost/simrs/antrean/PasienVisitationList");
                    bukaquery2("UPDATE PASIEN_VISITATION SET APPROVAL_RESPONAJUKAN=1 WHERE IDXDAFTAR = $id");
                } else {
                    pop("Gagal", "error", $en->metadata->message, "http://localhost/simrs/antrean/PasienVisitationList");
                };
            };
};
