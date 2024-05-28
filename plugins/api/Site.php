<?php

namespace Plugins\Api;

use Systems\SiteModule;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Site extends SiteModule
{
<<<<<<< HEAD
  public function routes()
  {
    $this->route('api', 'getIndex');
    $this->route('api/apam', 'getApam');
    $this->route('api/wag', 'getWags');
    $this->route('api/sendAbsen/(:str)/(:str)', 'getSendAbsen');
    $this->route('api/autoregis', 'getAutoRegist');
    $this->route('api/utd', 'getUtd');
  }
=======

    public function routes()
    {
        $this->route('api', 'getIndex');
        $this->route('api/apam', 'getApam');
        $this->route('api/berkasdigital', 'getBerkasDigital');
        $this->route('api/barcode', 'getBarcode');
    }
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

  public function getIndex()
  {
    echo $this->draw('index.html');
    exit();
  }

  public function getApam()
  {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

<<<<<<< HEAD
    $key = $this->settings->get('api.apam_key');
    $token = trim(isset($_REQUEST['token']) ? $_REQUEST['token'] : null);
    if ($token == $key) {
      $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
      switch ($action) {
        case "signin":
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $no_ktp = trim($_REQUEST['no_ktp']);
          $pasien = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->where('no_ktp', $no_ktp)->oneArray();
          if ($pasien) {
            $data['state'] = 'valid';
            $data['no_rkm_medis'] = $pasien['no_rkm_medis'];
          } else {
            $data['state'] = 'invalid';
          }
          echo json_encode($data);
          break;
        case "register":
          $nama_lengkap = trim($_REQUEST['nama_lengkap']);
          $email = trim($_REQUEST['email']);
          $nomor_ktp = trim($_REQUEST['nomor_ktp']);
          $nomor_telepon = trim($_REQUEST['nomor_telepon']);
          $this->db('mlite_apamregister')->where('email', $email)->delete();
          $pasien = $this->db('mlite_apamregister')->save([
            'nama_lengkap' => $nama_lengkap,
            'email' => $email,
            'nomor_ktp' => $nomor_ktp,
            'nomor_telepon' => $nomor_telepon
          ]);
          if ($this->db('pasien')->where('no_ktp', $nomor_ktp)->orWhere('email', $email)->oneArray()) {
            $data['state'] = 'duplicate';
          } else if ($pasien) {
            $rand = mt_rand(100000, 999999);
            $data['state'] = 'valid';
            $data['email'] = $email;
            $data['kode_validasi'] = $rand;
            $data['time_wait'] = time();
            $this->sendRegisterEmail($email, $nama_lengkap, $rand);
          } else {
            $data['state'] = 'invalid';
          }
          echo json_encode($data);
          break;
        case "postregister":
          $results = array();
          //$_REQUEST['email'] = '000009';
          $email = trim($_REQUEST['email']);
          $sql = "SELECT * FROM mlite_apamregister WHERE email = '$email'";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results[0]);
          break;
        case "saveregister":
=======
        $key = $this->settings->get('api.apam_key');
        $token = trim(isset($_REQUEST['token'])? $_REQUEST['token'] : null);
        if($token == $key) {
          $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
          switch($action){
            case "signin":
              $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
              $no_ktp = trim($_REQUEST['no_ktp']);
              $retensi_pasien = $this->db('retensi_pasien')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
              $pasien = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->where('no_ktp', $no_ktp)->oneArray();
              if($retensi_pasien) {
                $data['state'] = 'retensi';
              } else if($pasien) {
                $data['state'] = 'valid';
                $data['no_rkm_medis'] = $pasien['no_rkm_medis'];
              } else  { 
                $data['state'] = 'invalid';
              }
              echo json_encode($data);
            break;
            case "register":
              $nama_lengkap = trim($_REQUEST['nama_lengkap']);
              $email = trim($_REQUEST['email']);
              $nomor_ktp = trim($_REQUEST['nomor_ktp']);
              $nomor_telepon = trim($_REQUEST['nomor_telepon']);
              $this->db('mlite_apamregister')->where('email', $email)->delete();
              $pasien = $this->db('mlite_apamregister')->save([
                'nama_lengkap' => $nama_lengkap,
                'email' => $email,
                'nomor_ktp' => $nomor_ktp,
                'nomor_telepon' => $nomor_telepon
              ]);
              if($this->db('pasien')->where('no_ktp', $nomor_ktp)->orWhere('email', $email)->oneArray()) {
                $data['state'] = 'duplicate';
              } else if($pasien) {
                $rand = mt_rand(100000, 999999);
                $data['state'] = 'valid';
                $data['email'] = $email;
                $data['kode_validasi'] = $rand;
                $data['time_wait'] = time();
                $this->sendRegisterEmail($email, $nama_lengkap, $rand);
              } else {
                $data['state'] = 'invalid';
              }
              echo json_encode($data);
            break;
            case "postregister":
              $results = array();
              //$_REQUEST['email'] = '000009';
              $email = trim($_REQUEST['email']);
              $sql = "SELECT * FROM mlite_apamregister WHERE email = '$email'";
              $query = $this->db()->pdo()->prepare($sql);
              $query->execute();
              $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                $results[] = $row;
              }
              echo json_encode($results[0]);
            break;
            case "saveregister":
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

          unset($_POST);

          $no_rkm_medis = '000001';
          /*$max_id = $this->db('pasien')->select(['no_rkm_medis' => 'ifnull(MAX(CONVERT(RIGHT(no_rkm_medis,6),signed)),0)'])->oneArray();
              if($max_id['no_rkm_medis']) {
                $no_rkm_medis = sprintf('%06s', ($max_id['no_rkm_medis'] + 1));
              }*/

          $last_no_rm = $this->db('set_no_rkm_medis')->oneArray();
          $last_no_rm = substr($last_no_rm['no_rkm_medis'], 0, 6);
          $next_no_rm = sprintf('%06s', ($last_no_rm + 1));
          $no_rkm_medis = $next_no_rm;

          $_POST['nm_pasien'] = trim($_REQUEST['nm_pasien']);
          $_POST['email'] = trim($_REQUEST['email']);
          $_POST['no_ktp'] = trim($_REQUEST['no_ktp']);
          $_POST['no_tlp'] = trim($_REQUEST['no_tlp']);

          $_POST['no_rkm_medis'] = $no_rkm_medis;
          $_POST['jk'] = trim($_REQUEST['jk']);
          $_POST['tmp_lahir'] = '-';
          $_POST['tgl_lahir'] = trim($_REQUEST['tgl_lahir']);
          $_POST['nm_ibu'] = '-';
          $_POST['alamat'] = trim($_REQUEST['alamat']);
          $_POST['gol_darah'] = '-';
          $_POST['pekerjaan'] = '-';
          $_POST['stts_nikah'] = 'JOMBLO';
          $_POST['agama'] = '-';
          $_POST['tgl_daftar'] = date('Y-m-d');
          $_POST['umur'] = $this->hitungUmur($_POST['tgl_lahir']);
          $_POST['pnd'] = '-';
          $_POST['keluarga'] = 'AYAH';
          $_POST['namakeluarga'] = '-';
          $_POST['kd_pj'] = $this->settings->get('api.apam_kdpj');
          $_POST['no_peserta'] = '';
          $_POST['kd_kel'] = '1';
          $_POST['kd_kec'] = $this->settings->get('api.apam_kdkec');
          $_POST['kd_kab'] = $this->settings->get('api.apam_kdkab');
          $_POST['pekerjaanpj'] = '-';
          $_POST['alamatpj'] = '-';
          $_POST['kelurahanpj'] = '-';
          $_POST['kecamatanpj'] = '-';
          $_POST['kabupatenpj'] = '-';
          $_POST['perusahaan_pasien'] = '-';
          $_POST['suku_bangsa'] = '1';
          $_POST['bahasa_pasien'] = '1';
          $_POST['cacat_fisik'] = '1';
          $_POST['nip'] = '';
          $_POST['kd_prop'] = $this->settings->get('api.apam_kdprop');
          $_POST['propinsipj'] = '-';

<<<<<<< HEAD
          $query = $this->db('pasien')->save($_POST);
          if ($query) {
            $check_table = $this->db()->pdo()->query("SHOW TABLES LIKE 'set_no_rkm_medis'");
            $check_table->execute();
            $check_table = $check_table->fetch();
            if ($check_table) {
              $this->core->db()->pdo()->exec("UPDATE set_no_rkm_medis SET no_rkm_medis='$_POST[no_rkm_medis]'");
            }
=======
              $query = $this->db('pasien')->save($_POST);
              if($query) {
                $check_table = $this->db()->pdo()->query("SHOW TABLES LIKE 'set_no_rkm_medis'");
                $check_table->execute();
                $check_table = $check_table->fetch();
                if($check_table) {
                  $this->db()->pdo()->exec("UPDATE set_no_rkm_medis SET no_rkm_medis='$_POST[no_rkm_medis]'");
                }
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

            $this->db('mlite_apamregister')->where('email', $_POST['email'])->delete();

            $data['state'] = 'valid';
            $data['no_rkm_medis'] = $_POST['no_rkm_medis'];
          } else {
            $data['state'] = 'invalid';
          }

          echo json_encode($data);
          break;
        case "notifikasi":
          $results = array();
          //$_REQUEST['no_rkm_medis'] = '000009';
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $sql = "SELECT * FROM mlite_notifications WHERE no_rkm_medis = '$no_rkm_medis' AND status = 'unread'";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $result = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            $row['state'] = 'valid';
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "notifikasilist":
          $results = array();
          //$_REQUEST['no_rkm_medis'] = '000009';
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $result = $this->db('mlite_notifications')
            ->where('no_rkm_medis', $no_rkm_medis)
            ->desc('id')
            ->toArray();
          foreach ($result as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "tandaisudahdibaca":
          $id = trim($_REQUEST['id']);
          $this->db('mlite_notifications')->where('id', $id)->update('status', 'read');
          break;
        case "notifbooking":
          $data = array();
          //$_REQUEST['no_rkm_medis'] = '000009';
          $date = date('Y-m-d');
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $sql = "SELECT stts FROM reg_periksa WHERE tgl_registrasi = '$date' AND no_rkm_medis = '$no_rkm_medis' AND (stts = 'Belum' OR stts = 'Berkas Diterima')";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $result = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            $results[] = $row;
          }

          if (!$result) {
            $data['state'] = 'invalid';
            echo json_encode($data);
          } else {
            if ($results[0]["stts"] == 'Belum') {
              $data['state'] = 'notifbooking';
              $data['stts'] = $this->settings->get('api.apam_status_daftar');
              echo json_encode($data);
            } else if ($results[0]["stts"] == 'Berkas Diterima') {
              $data['state'] = 'notifberkas';
              $data['stts'] = $this->settings->get('api.apam_status_dilayani');
              echo json_encode($data);
            } else {
              $data['state'] = 'invalid';
              echo json_encode($data);
            }
          }
          break;
        case "antrian":
          $data['state'] = 'valid';
          echo json_encode($data);
          break;
        case "booking":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $sql = "SELECT a.tanggal_booking, a.tanggal_periksa, a.no_reg, a.status, b.nm_poli, c.nm_dokter, d.png_jawab FROM booking_registrasi a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj WHERE a.no_rkm_medis = '$no_rkm_medis' ORDER BY a.tanggal_periksa DESC";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "lastbooking":
          $data['state'] = 'valid';
          echo json_encode($data);
          break;
        case "bookingdetail":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $tanggal_periksa = trim($_REQUEST['tanggal_periksa']);
          $no_reg = trim($_REQUEST['no_reg']);
          $sql = "SELECT a.tanggal_booking, a.tanggal_periksa, a.no_reg, a.status, b.nm_poli, c.nm_dokter, d.png_jawab FROM booking_registrasi a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.tanggal_periksa = '$tanggal_periksa' AND a.no_reg = '$no_reg'";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "kamar":
          $results = array();
          $query = $this->db()->pdo()->prepare("SELECT nama.kelas, (SELECT COUNT(*) FROM kamar WHERE kelas=nama.kelas AND statusdata='1') AS total, (SELECT COUNT(*) FROM kamar WHERE  kelas=nama.kelas AND statusdata='1' AND status='ISI') AS isi, (SELECT COUNT(*) FROM kamar WHERE  kelas=nama.kelas AND statusdata='1' AND status='KOSONG') AS kosong FROM (SELECT DISTINCT kelas FROM kamar WHERE statusdata='1') AS nama ORDER BY nama.kelas ASC");
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "dokter":
          $tanggal = @$_REQUEST['tanggal'];

          if ($tanggal) {
            $getTanggal = $tanggal;
          } else {
            $getTanggal = date('Y-m-d');
          }
          $results = array();

          $hari = $this->db()->pdo()->prepare("SELECT DAYNAME('$getTanggal') AS dt");
          $hari->execute();
          $hari = $hari->fetch(\PDO::FETCH_OBJ);

          $namahari = "";
          if ($hari->dt == "Sunday") {
            $namahari = "AKHAD";
          } else if ($hari->dt == "Monday") {
            $namahari = "SENIN";
          } else if ($hari->dt == "Tuesday") {
            $namahari = "SELASA";
          } else if ($hari->dt == "Wednesday") {
            $namahari = "RABU";
          } else if ($hari->dt == "Thursday") {
            $namahari = "KAMIS";
          } else if ($hari->dt == "Friday") {
            $namahari = "JUMAT";
          } else if ($hari->dt == "Saturday") {
            $namahari = "SABTU";
          }

          $sql = $this->db()->pdo()->prepare("SELECT dokter.nm_dokter, dokter.jk, poliklinik.nm_poli, DATE_FORMAT(jadwal.jam_mulai, '%H:%i') AS jam_mulai, DATE_FORMAT(jadwal.jam_selesai, '%H:%i') AS jam_selesai, dokter.kd_dokter FROM jadwal INNER JOIN dokter INNER JOIN poliklinik on dokter.kd_dokter=jadwal.kd_dokter AND jadwal.kd_poli=poliklinik.kd_poli WHERE jadwal.hari_kerja='$namahari'");
          $sql->execute();
          $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

          if (!$result) {
            $send_data['state'] = 'notfound';
            echo json_encode($send_data);
          } else {
            foreach ($result as $row) {
              $results[] = $row;
            }
            echo json_encode($results);
          }
          break;
        case "riwayat":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $query = $this->db()->pdo()->prepare("SELECT a.tgl_registrasi, a.no_rawat, a.no_reg, b.nm_poli, c.nm_dokter, d.png_jawab FROM reg_periksa a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.stts = 'Sudah' ORDER BY a.tgl_registrasi DESC");
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "riwayatdetail":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $tgl_registrasi = trim($_REQUEST['tgl_registrasi']);
          $no_reg = trim($_REQUEST['no_reg']);
          $query = $this->db()->pdo()->prepare("SELECT a.tgl_registrasi, a.no_rawat, a.no_reg, b.nm_poli, c.nm_dokter, d.png_jawab, e.keluhan, e.pemeriksaan, GROUP_CONCAT(DISTINCT g.nm_penyakit SEPARATOR '<br>') AS nm_penyakit, GROUP_CONCAT(DISTINCT i.nama_brng SEPARATOR '<br>') AS nama_brng, GROUP_CONCAT(CONCAT_WS(':', k.pemeriksaan, j.nilai)SEPARATOR '<br>') AS pemeriksaan_lab, GROUP_CONCAT(CONCAT_WS(':', m.nm_perawatan, n.hasil)SEPARATOR '<br>') AS hasil_radiologi, GROUP_CONCAT(DISTINCT o.lokasi_gambar SEPARATOR '<br>') AS gambar_radiologi FROM reg_periksa a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj LEFT JOIN pemeriksaan_ralan e ON a.no_rawat = e.no_rawat LEFT JOIN diagnosa_pasien f ON a.no_rawat = f.no_rawat LEFT JOIN penyakit g ON f.kd_penyakit = g.kd_penyakit LEFT JOIN detail_pemberian_obat h ON a.no_rawat = h.no_rawat LEFT JOIN databarang i ON h.kode_brng = i.kode_brng LEFT JOIN detail_periksa_lab j ON a.no_rawat = j.no_rawat LEFT JOIN template_laboratorium k ON j.id_template = k.id_template LEFT JOIN periksa_radiologi l ON a.no_rawat = l.no_rawat LEFT JOIN jns_perawatan_radiologi m ON l.kd_jenis_prw = m.kd_jenis_prw LEFT JOIN hasil_radiologi n ON a.no_rawat = n.no_rawat LEFT JOIN gambar_radiologi o ON a.no_rawat = o.no_rawat WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.tgl_registrasi = '$tgl_registrasi' AND a.no_reg = '$no_reg' GROUP BY a.no_rawat");
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "riwayatranap":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $query = $this->db()->pdo()->prepare("SELECT reg_periksa.tgl_registrasi, reg_periksa.no_reg, dokter.nm_dokter, bangsal.nm_bangsal, penjab.png_jawab, reg_periksa.no_rawat FROM kamar_inap, reg_periksa, pasien, bangsal, kamar, penjab, dokter, dpjp_ranap WHERE kamar_inap.no_rawat = reg_periksa.no_rawat AND reg_periksa.no_rkm_medis = pasien.no_rkm_medis AND kamar_inap.no_rawat = reg_periksa.no_rawat AND kamar_inap.kd_kamar = kamar.kd_kamar AND kamar.kd_bangsal = bangsal.kd_bangsal AND reg_periksa.kd_pj = penjab.kd_pj AND dpjp_ranap.no_rawat = reg_periksa.no_rawat AND dpjp_ranap.kd_dokter = dokter.kd_dokter AND pasien.no_rkm_medis = '$no_rkm_medis' ORDER BY reg_periksa.tgl_registrasi DESC");
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "riwayatranapdetail":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $tgl_registrasi = trim($_REQUEST['tgl_registrasi']);
          $no_reg = trim($_REQUEST['no_reg']);
          $sql = "SELECT
                  a.tgl_registrasi,
                  a.no_rawat,
                  a.no_reg,
                  b.nm_bangsal,
                  c.nm_dokter,
                  d.png_jawab,
                  GROUP_CONCAT(DISTINCT e.keluhan SEPARATOR '<br>') AS keluhan,
                  GROUP_CONCAT(DISTINCT e.pemeriksaan SEPARATOR '<br>') AS pemeriksaan,
                  GROUP_CONCAT(DISTINCT g.nm_penyakit SEPARATOR '<br>') AS nm_penyakit,
                  GROUP_CONCAT(DISTINCT i.nama_brng SEPARATOR '<br>') AS nama_brng,
                  GROUP_CONCAT(CONCAT_WS(':', m.pemeriksaan, l.nilai)SEPARATOR '<br>') AS pemeriksaan_lab,
                  GROUP_CONCAT(CONCAT_WS(':', o.nm_perawatan, p.hasil)SEPARATOR '<br>') AS hasil_radiologi,
                  GROUP_CONCAT(DISTINCT q.lokasi_gambar SEPARATOR '<br>') AS gambar_radiologi
                FROM reg_periksa a
                LEFT JOIN kamar_inap j ON a.no_rawat = j.no_rawat
                LEFT JOIN kamar k ON j.kd_kamar = k.kd_kamar
                LEFT JOIN bangsal b ON k.kd_bangsal = b.kd_bangsal
                LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter
                LEFT JOIN penjab d ON a.kd_pj = d.kd_pj
                LEFT JOIN pemeriksaan_ranap e ON a.no_rawat = e.no_rawat
                LEFT JOIN diagnosa_pasien f ON a.no_rawat = f.no_rawat
                LEFT JOIN penyakit g ON f.kd_penyakit = g.kd_penyakit
                LEFT JOIN detail_pemberian_obat h ON a.no_rawat = h.no_rawat
                LEFT JOIN databarang i ON h.kode_brng = i.kode_brng
                LEFT JOIN detail_periksa_lab l ON a.no_rawat = l.no_rawat
                LEFT JOIN template_laboratorium m ON l.id_template = m.id_template
                LEFT JOIN periksa_radiologi n ON a.no_rawat = n.no_rawat
                LEFT JOIN jns_perawatan_radiologi o ON n.kd_jenis_prw = o.kd_jenis_prw
                LEFT JOIN hasil_radiologi p ON a.no_rawat = p.no_rawat
                LEFT JOIN gambar_radiologi q ON a.no_rawat = q.no_rawat
                WHERE a.no_rkm_medis = '$no_rkm_medis'
                AND a.tgl_registrasi = '$tgl_registrasi'
                AND a.no_reg = '$no_reg'
                GROUP BY a.no_rawat";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "billing":
          $results = array();
          //$_REQUEST['no_rkm_medis'] = '000009';
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $query = $this->db()->pdo()->prepare("SELECT a.tgl_registrasi, a.no_rawat, a.no_reg, b.nm_poli, c.nm_dokter, d.png_jawab, e.kd_billing, e.jumlah_harus_bayar FROM reg_periksa a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj INNER JOIN mlite_billing e ON a.no_rawat = e.no_rawat WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.stts = 'Sudah' ORDER BY e.tgl_billing, e.jam_billing DESC");
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $row['total_bayar'] = number_format($row['jumlah_harus_bayar'], 2, ',', '.');
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "profil":
          $results = array();
          //$_REQUEST['no_rkm_medis'] = '000009';
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $sql = "SELECT * FROM pasien WHERE no_rkm_medis = '$no_rkm_medis'";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $personal_pasien = $this->db('personal_pasien')->where('no_rkm_medis', $row['no_rkm_medis'])->oneArray();
            $row['foto'] = 'img/' . $row['jk'] . '.png';
            if ($personal_pasien) {
              $row['foto'] = $this->settings->get('api.apam_webappsurl') . '/photopasien/' . $personal_pasien['gambar'];
            }
            $results[] = $row;
          }
          echo json_encode($results[0]);
          break;
        case "jadwalklinik":
          $results = array();
          $tanggal = trim($_REQUEST['tanggal']);

          $tentukan_hari = date('D', strtotime($tanggal));
          $day = array(
            'Sun' => 'AKHAD',
            'Mon' => 'SENIN',
            'Tue' => 'SELASA',
            'Wed' => 'RABU',
            'Thu' => 'KAMIS',
            'Fri' => 'JUMAT',
            'Sat' => 'SABTU'
          );
          $hari = $day[$tentukan_hari];

          $sql = "SELECT a.kd_poli, b.nm_poli, DATE_FORMAT(a.jam_mulai, '%H:%i') AS jam_mulai, DATE_FORMAT(a.jam_selesai, '%H:%i') AS jam_selesai FROM jadwal a, poliklinik b, dokter c WHERE a.kd_poli = b.kd_poli AND a.kd_dokter = c.kd_dokter AND a.hari_kerja LIKE '%$hari%' GROUP BY b.kd_poli";

          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "jadwaldokter":
          $results = array();
          $tanggal = trim($_REQUEST['tanggal']);
          $kd_poli = trim($_REQUEST['kd_poli']);

          $tentukan_hari = date('D', strtotime($tanggal));
          $day = array(
            'Sun' => 'AKHAD',
            'Mon' => 'SENIN',
            'Tue' => 'SELASA',
            'Wed' => 'RABU',
            'Thu' => 'KAMIS',
            'Fri' => 'JUMAT',
            'Sat' => 'SABTU'
          );
          $hari = $day[$tentukan_hari];

          $sql = "SELECT a.kd_dokter, c.nm_dokter FROM jadwal a, poliklinik b, dokter c WHERE a.kd_poli = b.kd_poli AND a.kd_dokter = c.kd_dokter AND a.kd_poli = '$kd_poli' AND a.hari_kerja LIKE '%$hari%'";

          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "carabayar":
          $results = array();
          $sql = "SELECT * FROM penjab";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "daftar":
          $send_data = array();

          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $tanggal = trim($_REQUEST['tanggal']);
          $kd_poli = trim($_REQUEST['kd_poli']);
          $kd_dokter = trim($_REQUEST['kd_dokter']);
          $kd_pj = trim($_REQUEST['kd_pj']);

          $tentukan_hari = date('D', strtotime($tanggal));
          $day = array(
            'Sun' => 'AKHAD',
            'Mon' => 'SENIN',
            'Tue' => 'SELASA',
            'Wed' => 'RABU',
            'Thu' => 'KAMIS',
            'Fri' => 'JUMAT',
            'Sat' => 'SABTU'
          );
          $hari = $day[$tentukan_hari];

          $jadwal = $this->db('jadwal')->where('kd_poli', $kd_poli)->where('hari_kerja', $hari)->oneArray();

          $check_kuota = $this->db('booking_registrasi')->select(['count' => 'COUNT(DISTINCT no_reg)'])->where('kd_poli', $kd_poli)->where('tanggal_periksa', $tanggal)->oneArray();

          if ($this->settings->get('settings.dokter_ralan_per_dokter') == 'true') {
            $check_kuota = $this->db('booking_registrasi')->select(['count' => 'COUNT(DISTINCT no_reg)'])->where('kd_poli', $kd_poli)->where('kd_dokter', $kd_dokter)->where('tanggal_periksa', $tanggal)->oneArray();
          }

          $curr_count = $check_kuota['count'];
          $curr_kuota = $jadwal['kuota'];
          $online = $curr_kuota / $this->settings->get('api.apam_limit');

          $check = $this->db('booking_registrasi')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal_periksa', $tanggal)->oneArray();

          if ($curr_count > $online) {
            $send_data['state'] = 'limit';
            echo json_encode($send_data);
          } else if (!$check) {
            $mysql_date = date('Y-m-d');
            $mysql_time = date('H:m:s');
            $waktu_kunjungan = $tanggal . ' ' . $mysql_time;

            $max_id = $this->db('booking_registrasi')->select(['no_reg' => 'ifnull(MAX(CONVERT(RIGHT(no_reg,3),signed)),0)'])->where('kd_poli', $kd_poli)->where('tanggal_periksa', $tanggal)->desc('no_reg')->limit(1)->oneArray();
            if ($this->settings->get('settings.dokter_ralan_per_dokter') == 'true') {
              $max_id = $this->db('booking_registrasi')->select(['no_reg' => 'ifnull(MAX(CONVERT(RIGHT(no_reg,3),signed)),0)'])->where('kd_poli', $kd_poli)->where('kd_dokter', $kd_dokter)->where('tanggal_periksa', $tanggal)->desc('no_reg')->limit(1)->oneArray();
            }
            if (empty($max_id['no_reg'])) {
              $max_id['no_reg'] = '000';
            }
            $no_reg = sprintf('%03s', ($max_id['no_reg'] + 1));

            unset($_POST);
            $_POST['no_rkm_medis'] = $no_rkm_medis;
            $_POST['tanggal_periksa'] = $tanggal;
            $_POST['kd_poli'] = $kd_poli;
            $_POST['kd_dokter'] = $kd_dokter;
            $_POST['kd_pj'] = $kd_pj;
            $_POST['no_reg'] = $no_reg;
            $_POST['tanggal_booking'] = $mysql_date;
            $_POST['jam_booking'] = $mysql_time;
            $_POST['waktu_kunjungan'] = $waktu_kunjungan;
            $_POST['limit_reg'] = '1';
            $_POST['status'] = 'Belum';

            $this->db('booking_registrasi')->save($_POST);

            $send_data['state'] = 'success';
            echo json_encode($send_data);

<<<<<<< HEAD
            $get_pasien = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
            $get_poliklinik = $this->db('poliklinik')->where('kd_poli', $kd_poli)->oneArray();
            if ($get_pasien['no_tlp'] != '') {
              $ch = curl_init();
              $url = "https://banoewa.com/send-message";
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS, "api_key=" . $this->settings->get('settings.waapitoken') . "&sender=" . $this->settings->get('settings.waapiphonenumber') . "&number=" . $get_pasien['no_tlp'] . "&message=Terima kasih sudah melakukan pendaftaran Online di " . $this->settings->get('settings.nama_instansi') . ". \n\nDetail pendaftaran anda adalah, \nTanggal: " . date('Y-m-d', strtotime($waktu_kunjungan)) . " \nNomor Antrian: " . $no_reg . " \nPoliklinik: " . $get_poliklinik['nm_poli'] . " \nStatus: Menunggu \n\nBawalah kartu berobat anda. \nDatanglah 30 menit sebelumnya.\n\n-------------------\nPesan WhatsApp ini dikirim otomatis oleh " . $this->settings->get('settings.nama_instansi') . " \nTerima Kasih"); // Define what you want to post
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
              $output = curl_exec($ch);
              curl_close($ch);
            }
          } else {
            $send_data['state'] = 'duplication';
            echo json_encode($send_data);
          }
          break;
        case "sukses":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $date = date('Y-m-d');
          $sql = "SELECT a.tanggal_booking, a.tanggal_periksa, a.no_reg, a.status, b.nm_poli, c.nm_dokter, d.png_jawab FROM booking_registrasi a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.tanggal_booking = '$date' AND a.jam_booking = (SELECT MAX(ax.jam_booking) FROM booking_registrasi ax WHERE ax.tanggal_booking = a.tanggal_booking) ORDER BY a.tanggal_booking ASC LIMIT 1";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results, JSON_PRETTY_PRINT);
          break;
        case "pengaduan":
          $results = array();
          $petugas_array = explode(',', $this->settings->get('api.apam_normpetugas'));
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $sql = "SELECT a.*, b.nm_pasien, b.jk FROM mlite_pengaduan a, pasien b WHERE a.no_rkm_medis = b.no_rkm_medis";
          if (in_array($no_rkm_medis, $petugas_array)) {
            $sql .= "";
          } else {
            $sql .= " AND a.no_rkm_medis = '$no_rkm_medis'";
          }
          $sql .= " ORDER BY a.tanggal DESC";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "pengaduandetail":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $pengaduan_id = trim($_REQUEST['pengaduan_id']);
          $sql = $this->db()->pdo()->prepare("SELECT * FROM mlite_pengaduan_detail WHERE pengaduan_id = '$pengaduan_id'");
          $sql->execute();
          $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

          if (!$result) {
            $data['state'] = 'invalid';
            echo json_encode($data);
          } else {
            foreach ($result as $row) {
              $pasien = $this->db('pasien')->where('no_rkm_medis', $row['no_rkm_medis'])->oneArray();
              $row['nama'] = $pasien['nm_pasien'];
              $results[] = $row;
            }
            echo json_encode($results);
          }
          break;
        case "simpanpengaduan":
          $send_data = array();
          $max_id = $this->db('mlite_pengaduan')->select(['id' => 'ifnull(MAX(CONVERT(RIGHT(id,6),signed)),0)'])->like('tanggal', '' . date('Y-m-d') . '%')->oneArray();
          if (empty($max_id['id'])) {
            $max_id['id'] = '000000';
          }
          $_next_id = sprintf('%06s', ($max_id['id'] + 1));
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $message = trim($_REQUEST['message']);
          unset($_POST);
          $_POST['id'] = date('Ymd') . '' . $_next_id;
          $_POST['no_rkm_medis'] = $no_rkm_medis;
          $_POST['pesan'] = $message;
          $_POST['tanggal'] = date('Y-m-d H:i:s');

          $this->db('mlite_pengaduan')->save($_POST);

          $send_data['state'] = 'success';
          echo json_encode($send_data);
          break;
        case "simpanpengaduandetail":
          $send_data = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $message = trim($_REQUEST['message']);
          $pengaduan_id = trim($_REQUEST['pengaduan_id']);

          unset($_POST);
          $_POST['pengaduan_id'] = $pengaduan_id;
          $_POST['no_rkm_medis'] = $no_rkm_medis;
          $_POST['pesan'] = $message;
          $_POST['tanggal'] = date('Y-m-d H:i:s');
          $this->db('mlite_pengaduan_detail')->save($_POST);

          $send_data['state'] = 'success';
          echo json_encode($send_data);
          break;
        case "cekrujukan":
          $data['state'] = 'valid';
          echo json_encode($data);
          break;
        case "rawatjalan":
          $results = array();
          $sql = "SELECT * FROM poliklinik WHERE status = '1'";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $row['registrasi'] = number_format($row['registrasi'], 2, ',', '.');
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "rawatinap":
          $results = array();
          $sql = "SELECT bangsal.*, kamar.* FROM bangsal, kamar WHERE kamar.statusdata = '1' AND bangsal.kd_bangsal = kamar.kd_bangsal";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $row['trf_kamar'] = number_format($row['trf_kamar'], 2, ',', '.');
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "laboratorium":
          $results = array();
          $sql = "SELECT * FROM jns_perawatan_lab WHERE status = '1'";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "radiologi":
          $results = array();
          $sql = "SELECT * FROM jns_perawatan_radiologi WHERE status = '1'";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "hitungralan":
          //$_REQUEST['no_rkm_medis'] = '000009';
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $hitung = $this->db('reg_periksa')->select(['count' => 'COUNT(DISTINCT no_rawat)'])->where('no_rkm_medis', $no_rkm_medis)->oneArray();
          echo $hitung['count'];
          break;
        case "hitungranap":
          //$_REQUEST['no_rkm_medis'] = '000009';
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $hitung = $this->db('kamar_inap')->select(['count' => 'COUNT(DISTINCT kamar_inap.no_rawat)'])->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
          echo $hitung['count'];
          break;
        case "layananunggulan":
          $data[] = array_column($this->db('mlite_settings')->where('module', 'website')->toArray(), 'value', 'field');
          echo json_encode($data);
          break;
        case "lastblog":
          $limit = $this->settings->get('blog.latestPostsCount');
          $results = [];
          $rows = $this->db('mlite_blog')
            ->leftJoin('mlite_users', 'mlite_users.id = mlite_blog.user_id')
            ->where('status', 2)
            ->where('published_at', '<=', time())
            ->desc('published_at')
            ->limit($limit)
            ->select(['mlite_blog.id', 'mlite_blog.title', 'mlite_blog.cover_photo', 'mlite_blog.published_at', 'mlite_blog.slug', 'mlite_blog.intro', 'mlite_blog.content', 'mlite_users.username', 'mlite_users.fullname'])
            ->toArray();

          foreach ($rows as &$row) {
            //$this->filterRecord($row);
            $tags = $this->db('mlite_blog_tags')
              ->leftJoin('mlite_blog_tags_relationship', 'mlite_blog_tags.id = mlite_blog_tags_relationship.tag_id')
              ->where('mlite_blog_tags_relationship.blog_id', $row['id'])
              ->select('name')
              ->oneArray();
            $row['tag'] = $tags['name'];
            $row['tanggal'] = getDayIndonesia(date('Y-m-d', date($row['published_at']))) . ', ' . dateIndonesia(date('Y-m-d', date($row['published_at'])));
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "blog":
          $results = [];
          $rows = $this->db('mlite_blog')
            ->leftJoin('mlite_users', 'mlite_users.id = mlite_blog.user_id')
            ->where('status', 2)
            ->where('published_at', '<=', time())
            ->desc('published_at')
            ->select(['mlite_blog.id', 'mlite_blog.title', 'mlite_blog.cover_photo', 'mlite_blog.published_at', 'mlite_blog.slug', 'mlite_blog.intro', 'mlite_blog.content', 'mlite_users.username', 'mlite_users.fullname'])
            ->toArray();

          foreach ($rows as &$row) {
            //$this->filterRecord($row);
            $tags = $this->db('mlite_blog_tags')
              ->leftJoin('mlite_blog_tags_relationship', 'mlite_blog_tags.id = mlite_blog_tags_relationship.tag_id')
              ->where('mlite_blog_tags_relationship.blog_id', $row['id'])
              ->select('name')
              ->oneArray();
            $row['tag'] = $tags['name'];
            $row['tanggal'] = getDayIndonesia(date('Y-m-d', date($row['published_at']))) . ', ' . dateIndonesia(date('Y-m-d', date($row['published_at'])));
            $results[] = $row;
          }
          echo json_encode($results);
          break;
        case "blogdetail":
          $id = trim($_REQUEST['id']);
          $results = [];
          $rows = $this->db('mlite_blog')
            ->where('id', $id)
            ->select(['id', 'title', 'cover_photo', 'content', 'published_at'])
            ->oneArray();
          $rows['tanggal'] = getDayIndonesia(date('Y-m-d', date($rows['published_at']))) . ', ' . dateIndonesia(date('Y-m-d', date($rows['published_at'])));
          $results[] = $rows;
          echo json_encode($results);
          break;
        case "telemedicine":
          $tanggal = @$_REQUEST['tanggal'];

          if ($tanggal) {
            $getTanggal = $tanggal;
          } else {
            $getTanggal = date('Y-m-d');
          }
          $results = array();

          $hari = $this->db()->pdo()->prepare("SELECT DAYNAME('$getTanggal') AS dt");
          $hari->execute();
          $hari = $hari->fetch(\PDO::FETCH_OBJ);

          $namahari = "";
          if ($hari->dt == "Sunday") {
            $namahari = "AKHAD";
          } else if ($hari->dt == "Monday") {
            $namahari = "SENIN";
          } else if ($hari->dt == "Tuesday") {
            $namahari = "SELASA";
          } else if ($hari->dt == "Wednesday") {
            $namahari = "RABU";
          } else if ($hari->dt == "Thursday") {
            $namahari = "KAMIS";
          } else if ($hari->dt == "Friday") {
            $namahari = "JUMAT";
          } else if ($hari->dt == "Saturday") {
            $namahari = "SABTU";
          }

          $sql = $this->db()->pdo()->prepare("SELECT dokter.nm_dokter, dokter.jk, poliklinik.nm_poli, DATE_FORMAT(jadwal.jam_mulai, '%H:%i') AS jam_mulai, DATE_FORMAT(jadwal.jam_selesai, '%H:%i') AS jam_selesai, dokter.kd_dokter, poliklinik.kd_poli FROM jadwal INNER JOIN dokter INNER JOIN poliklinik on dokter.kd_dokter=jadwal.kd_dokter AND jadwal.kd_poli=poliklinik.kd_poli WHERE jadwal.hari_kerja='$namahari'");
          $sql->execute();
          $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

          if (!$result) {
            $send_data['state'] = 'notfound';
            echo json_encode($send_data);
          } else {
            foreach ($result as $row) {
              $row['biaya'] = $this->settings->get('api.duitku_paymentAmount');
              $results[] = $row;
            }
            echo json_encode($results);
          }
          break;
        case "duitku_callback":
          $apiKey = $this->settings->get('api.duitku_merchantKey'); // from duitku // settings.duitku_merchantKey
          $merchantCode = isset($_POST['merchantCode']) ? $_POST['merchantCode'] : null;
          $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
          $merchantOrderId = isset($_POST['merchantOrderId']) ? $_POST['merchantOrderId'] : null;
          $productDetail = isset($_POST['productDetail']) ? $_POST['productDetail'] : null;
          $additionalParam = isset($_POST['additionalParam']) ? $_POST['additionalParam'] : null;
          $paymentMethod = isset($_POST['paymentCode']) ? $_POST['paymentCode'] : null;
          $resultCode = isset($_POST['resultCode']) ? $_POST['resultCode'] : null;
          $merchantUserId = isset($_POST['merchantUserId']) ? $_POST['merchantUserId'] : null;
          $reference = isset($_POST['reference']) ? $_POST['reference'] : null;
          $signature = isset($_POST['signature']) ? $_POST['signature'] : null;

          if (!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {
            $params = $merchantCode . $amount . $merchantOrderId . $apiKey;
            $calcSignature = md5($params);
            if ($signature == $calcSignature) {
              //Your code here
              if ($resultCode == "00") {
                echo "SUCCESS"; // Save to database
=======
                  $get_pasien = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
                  $get_poliklinik = $this->db('poliklinik')->where('kd_poli', $kd_poli)->oneArray();
                  $waapiserver = $this->settings->get('wagateway.server');
                  $url = $waapiserver."/wagateway/kirimpesan";
                  if($get_pasien['no_tlp'] !='') {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "type=text&api_key=".$this->settings->get('wagateway.token')."&sender=".$this->settings->get('wagateway.phonenumber')."&number=".$get_pasien['no_tlp']."&message=Terima kasih sudah melakukan pendaftaran Online di ".$this->settings->get('settings.nama_instansi').". \n\nDetail pendaftaran anda adalah, \nTanggal: ".date('Y-m-d', strtotime($waktu_kunjungan))." \nNomor Antrian: ".$no_reg." \nPoliklinik: ".$get_poliklinik['nm_poli']." \nStatus: Menunggu \n\nBawalah kartu berobat anda. \nDatanglah 30 menit sebelumnya.\n\n-------------------\nPesan WhatsApp ini dikirim otomatis oleh ".$this->settings->get('settings.nama_instansi')." \nTerima Kasih"); // Define what you want to post
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT,30);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                  }
              }
              else{
                  $send_data['state'] = 'duplication';
                  echo json_encode($send_data);
              }
            break;
            case "sukses":
              $results = array();
              $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
              $date = date('Y-m-d');
              $sql = "SELECT a.tanggal_booking, a.tanggal_periksa, a.no_reg, a.status, b.nm_poli, c.nm_dokter, d.png_jawab FROM booking_registrasi a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.tanggal_booking = '$date' AND a.jam_booking = (SELECT MAX(ax.jam_booking) FROM booking_registrasi ax WHERE ax.tanggal_booking = a.tanggal_booking) ORDER BY a.tanggal_booking ASC LIMIT 1";
              $query = $this->db()->pdo()->prepare($sql);
              $query->execute();
              $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                $results[] = $row;
              }
              echo json_encode($results, JSON_PRETTY_PRINT);
            break;
            case "pengaduan":
              $results = array();
              $petugas_array = explode(',', $this->settings->get('api.apam_normpetugas'));
              $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
              $sql = "SELECT a.*, b.nm_pasien, b.jk FROM mlite_pengaduan a, pasien b WHERE a.no_rkm_medis = b.no_rkm_medis";
              if(in_array($no_rkm_medis, $petugas_array)) {
                $sql .= "";
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
              } else {
                echo "FAILED"; // Please update the status to FAILED in database
              }
            } else {
              throw new Exception('Bad Signature');
            }
          } else {
            throw new Exception('Bad Parameter');
          }
          break;
        case "telemedicinedaftar":
          $send_data = array();

          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $tanggal = trim($_REQUEST['tanggal']);
          $kd_poli = trim($_REQUEST['kd_poli']);
          $kd_dokter = trim($_REQUEST['kd_dokter']);
          $kd_pj = $this->settings->get('api.duitku_kdpj');

          $tentukan_hari = date('D', strtotime($tanggal));
          $day = array(
            'Sun' => 'AKHAD',
            'Mon' => 'SENIN',
            'Tue' => 'SELASA',
            'Wed' => 'RABU',
            'Thu' => 'KAMIS',
            'Fri' => 'JUMAT',
            'Sat' => 'SABTU'
          );
          $hari = $day[$tentukan_hari];

          $jadwal = $this->db('jadwal')->where('kd_poli', $kd_poli)->where('hari_kerja', $hari)->oneArray();

          $check_kuota = $this->db('booking_registrasi')->select(['count' => 'COUNT(DISTINCT no_reg)'])->where('kd_poli', $kd_poli)->where('tanggal_periksa', $tanggal)->oneArray();

<<<<<<< HEAD
          if ($this->settings->get('settings.dokter_ralan_per_dokter') == 'true') {
            $check_kuota = $this->db('booking_registrasi')->select(['count' => 'COUNT(DISTINCT no_reg)'])->where('kd_poli', $kd_poli)->where('kd_dokter', $kd_dokter)->where('tanggal_periksa', $tanggal)->oneArray();
          }

          $curr_count = $check_kuota['count'];
          $curr_kuota = $jadwal['kuota'];
          $online = $curr_kuota / $this->settings->get('api.apam_limit');

          $check = $this->db('booking_registrasi')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal_periksa', $tanggal)->oneArray();
=======
              $send_data['state'] = 'success';
              echo json_encode($send_data);
            break;
            case "cekrujukan":
              $data['state'] = 'valid';
              echo json_encode($data);
            break;
            case "rawatjalan":
              $results = array();
              $sql = "SELECT * FROM poliklinik WHERE status = '1'";
              $query = $this->db()->pdo()->prepare($sql);
              $query->execute();
              $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                $row['registrasi'] = number_format($row['registrasi'],2,',','.');
                $results[] = $row;
              }
              echo json_encode($results);
            break;
            case "rawatinap":
              $results = array();
              $sql = "SELECT bangsal.*, kamar.* FROM bangsal, kamar WHERE kamar.statusdata = '1' AND bangsal.kd_bangsal = kamar.kd_bangsal";
              $query = $this->db()->pdo()->prepare($sql);
              $query->execute();
              $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                $row['trf_kamar'] = number_format($row['trf_kamar'],2,',','.');
                $results[] = $row;
              }
              echo json_encode($results);
            break;
            case "laboratorium":
              $results = array();
              $sql = "SELECT * FROM jns_perawatan_lab WHERE status = '1'";
              $query = $this->db()->pdo()->prepare($sql);
              $query->execute();
              $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                $results[] = $row;
              }
              echo json_encode($results);
            break;
            case "radiologi":
              $results = array();
              $sql = "SELECT * FROM jns_perawatan_radiologi WHERE status = '1'";
              $query = $this->db()->pdo()->prepare($sql);
              $query->execute();
              $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                $results[] = $row;
              }
              echo json_encode($results);
            break;
            case "hitungralan":
              //$_REQUEST['no_rkm_medis'] = '000009';
              $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
              $hitung = $this->db('reg_periksa')->select(['count' => 'COUNT(DISTINCT no_rawat)'])->where('no_rkm_medis', $no_rkm_medis)->oneArray();
              echo $hitung['count'];
            break;
            case "hitungranap":
              //$_REQUEST['no_rkm_medis'] = '000009';
              $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
              $hitung = $this->db('kamar_inap')->select(['count' => 'COUNT(DISTINCT kamar_inap.no_rawat)'])->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
              echo $hitung['count'];
            break;
            case "layananunggulan":
              $data[] = array_column($this->db('mlite_settings')->where('module', 'website')->toArray(), 'value', 'field');
              echo json_encode($data);
            break;
            case "lastnews":
              $limit = $this->settings->get('website.latestPostsCount');
              $results = [];
              $rows = $this->db('mlite_news')
                      ->leftJoin('mlite_users', 'mlite_users.id = mlite_news.user_id')
                      ->where('status', 2)
                      ->where('published_at', '<=', time())
                      ->desc('published_at')
                      ->limit($limit)
                      ->select(['mlite_news.id', 'mlite_news.title', 'mlite_news.cover_photo', 'mlite_news.published_at', 'mlite_news.slug', 'mlite_news.intro', 'mlite_news.content', 'mlite_users.username', 'mlite_users.fullname'])
                      ->toArray();

              foreach ($rows as &$row) {
                  //$this->filterRecord($row);
                  $tags = $this->db('mlite_news_tags')
                      ->leftJoin('mlite_news_tags_relationship', 'mlite_news_tags.id = mlite_news_tags_relationship.tag_id')
                      ->where('mlite_news_tags_relationship.news_id', $row['id'])
                      ->select('name')
                      ->oneArray();
                  $row['tag'] = isset_or($tags['name']);
                  $row['tanggal'] = getDayIndonesia(date('Y-m-d', date($row['published_at']))).', '.dateIndonesia(date('Y-m-d', date($row['published_at'])));
                  $results[] = $row;
              }
              echo json_encode($results);
            break;
            case "news":
              $results = [];
              $rows = $this->db('mlite_news')
                      ->leftJoin('mlite_users', 'mlite_users.id = mlite_news.user_id')
                      ->where('status', 2)
                      ->where('published_at', '<=', time())
                      ->desc('published_at')
                      ->select(['mlite_news.id', 'mlite_news.title', 'mlite_news.cover_photo', 'mlite_news.published_at', 'mlite_news.slug', 'mlite_news.intro', 'mlite_news.content', 'mlite_users.username', 'mlite_users.fullname'])
                      ->toArray();

              foreach ($rows as &$row) {
                  //$this->filterRecord($row);
                  $tags = $this->db('mlite_news_tags')
                      ->leftJoin('mlite_news_tags_relationship', 'mlite_news_tags.id = mlite_news_tags_relationship.tag_id')
                      ->where('mlite_news_tags_relationship.news_id', $row['id'])
                      ->select('name')
                      ->oneArray();
                  $row['tag'] = $tags['name'];
                  $row['tanggal'] = getDayIndonesia(date('Y-m-d', date($row['published_at']))).', '.dateIndonesia(date('Y-m-d', date($row['published_at'])));
                  $results[] = $row;
              }
              echo json_encode($results);
            break;
            case "newsdetail":
              $id = trim($_REQUEST['id']);
              $results = [];
              $rows = $this->db('mlite_news')
                      ->where('id', $id)
                      ->select(['id','title','cover_photo', 'content', 'published_at'])
                      ->oneArray();
              $rows['tanggal'] = getDayIndonesia(date('Y-m-d', date($rows['published_at']))).', '.dateIndonesia(date('Y-m-d', date($rows['published_at'])));
              $results[] = $rows;
              echo json_encode($results);
            break;
            case "telemedicine":
              $tanggal = @$_REQUEST['tanggal'];
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

          if ($curr_count > $online) {
            $send_data['state'] = 'limit';
            echo json_encode($send_data);
          } else if (!$check) {
            $mysql_date = date('Y-m-d');
            $mysql_time = date('H:m:s');
            $waktu_kunjungan = $tanggal . ' ' . $mysql_time;

            $max_id = $this->db('booking_registrasi')->select(['no_reg' => 'ifnull(MAX(CONVERT(RIGHT(no_reg,3),signed)),0)'])->where('kd_poli', $kd_poli)->where('tanggal_periksa', $tanggal)->desc('no_reg')->limit(1)->oneArray();
            if ($this->settings->get('settings.dokter_ralan_per_dokter') == 'true') {
              $max_id = $this->db('booking_registrasi')->select(['no_reg' => 'ifnull(MAX(CONVERT(RIGHT(no_reg,3),signed)),0)'])->where('kd_poli', $kd_poli)->where('kd_dokter', $kd_dokter)->where('tanggal_periksa', $tanggal)->desc('no_reg')->limit(1)->oneArray();
            }
            if (empty($max_id['no_reg'])) {
              $max_id['no_reg'] = '000';
            }
            $no_reg = sprintf('%03s', ($max_id['no_reg'] + 1));

            unset($_POST);
            $_POST['no_rkm_medis'] = $no_rkm_medis;
            $_POST['tanggal_periksa'] = $tanggal;
            $_POST['kd_poli'] = $kd_poli;
            $_POST['kd_dokter'] = $kd_dokter;
            $_POST['kd_pj'] = $kd_pj;
            $_POST['no_reg'] = $no_reg;
            $_POST['tanggal_booking'] = $mysql_date;
            $_POST['jam_booking'] = $mysql_time;
            $_POST['waktu_kunjungan'] = $waktu_kunjungan;
            $_POST['limit_reg'] = '1';
            $_POST['status'] = 'Belum';

            $this->db('booking_registrasi')->save($_POST);

            $send_data['state'] = 'success';
            echo json_encode($send_data);


            $pasien = $this->db('pasien')->where('no_rkm_medis', $_REQUEST['no_rkm_medis'])->oneArray();
            $merchantCode = $this->settings->get('api.duitku_merchantCode'); // from duitku // settings.duitku_merchantCode
            $merchantKey = $this->settings->get('api.duitku_merchantKey'); // from duitku // settings.duitku_merchantKey
            $paymentAmount = $this->settings->get('api.duitku_paymentAmount'); // settings.duitku_paymentAmount
            $paymentMethod = $this->settings->get('api.duitku_paymentMethod'); // WW = duitku wallet, VC = Credit Card, MY = Mandiri Clickpay, BK = BCA KlikPay
            $merchantOrderId = time(); // from merchant, unique
            $productDetails = $this->settings->get('api.duitku_productDetails'); //settings.duitku_productDetails
            $email = $pasien['email']; // your customer email
            $phoneNumber = $pasien['no_tlp']; // your customer phone number (optional)
            $additionalParam = ''; // optional
            $merchantUserInfo = ''; // optional
            $customerVaName = $pasien['nm_pasien']; // display name on bank confirmation display
            $callbackUrl = url() . '/api/apam/?action=duitku_callback&token=' . $token; // url for callback
            $returnUrl = url() . '/api/apam/?action=duitku&token=' . $token; // url for redirect
            $expiryPeriod = $this->settings->get('api.duitku_expiryPeriod'); // set the expired time in minutes

            $signature = md5($merchantCode . $merchantOrderId . $paymentAmount . $merchantKey);

            $item1 = array(
              'name' => $this->settings->get('api.duitku_productDetails'), //settings.duitku_productDetails
              'price' => $this->settings->get('api.duitku_paymentAmount'), //settings.duitku_paymentAmount
              'quantity' => 1
            );
            $itemDetails = array(
              $item1
            );

            $params = array(
              'merchantCode' => $merchantCode,
              'paymentAmount' => $paymentAmount,
              'paymentMethod' => $paymentMethod,
              'merchantOrderId' => $merchantOrderId,
              'productDetails' => $productDetails,
              'additionalParam' => $additionalParam,
              'merchantUserInfo' => $merchantUserInfo,
              'customerVaName' => $customerVaName,
              'email' => $email,
              'phoneNumber' => $phoneNumber,
              'itemDetails' => $itemDetails,
              'callbackUrl' => $callbackUrl,
              'returnUrl' => $returnUrl,
              'signature' => $signature,
              'expiryPeriod' => $expiryPeriod
            );

            $params_string = json_encode($params);
            $url = 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry'; // Sandbox
            // $url = 'https://passport.duitku.com/webapi/api/merchant/v2/inquiry'; // Production
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Content-Length: ' . strlen($params_string)
            ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            //execute post
            $request = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode == 200) {
              $result_duitku = json_decode($request, true);
              $this->db('mlite_duitku')->save([
                'tanggal' => $waktu_kunjungan,
                'no_rkm_medis' => $pasien['no_rkm_medis'],
                'paymentUrl' => $result_duitku['paymentUrl'],
                'merchantCode' => $result_duitku['merchantCode'],
                'reference' => $result_duitku['reference'],
                'vaNumber' => $result_duitku['vaNumber'],
                'amount' => $result_duitku['amount'],
                'statusCode' => $result_duitku['statusCode'],
                'statusMessage' => $result_duitku['statusMessage']
              ]);
            }

<<<<<<< HEAD
            $get_pasien = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
            $get_poliklinik = $this->db('poliklinik')->where('kd_poli', $kd_poli)->oneArray();
            if ($get_pasien['no_tlp'] != '') {
              $ch = curl_init();
              $url = "https://banoewa.com/send-message";
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS, "api_key=" . $this->settings->get('settings.waapitoken') . "&sender=" . $this->settings->get('settings.waapiphonenumber') . "&number=" . $get_pasien['no_tlp'] . "&message=Terima kasih sudah melakukan pendaftaran Online Telemedicine di " . $this->settings->get('settings.nama_instansi') . ". \n\nDetail pendaftaran Telemedicine anda adalah, \nTanggal: " . date('Y-m-d', strtotime($waktu_kunjungan)) . " \nNomor Antrian: " . $no_reg . " \nPoliklinik: " . $get_poliklinik['nm_poli'] . " \nStatus: Menunggu \n\nSilahkan lakukan pembayaran dengan mengklik link berikut " . $result_duitku['paymentUrl'] . ".\n\n-------------------\nPesan WhatsApp ini dikirim otomatis oleh " . $this->settings->get('settings.nama_instansi') . " \nTerima Kasih"); // Define what you want to post
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
              $output = curl_exec($ch);
              curl_close($ch);
            }
          } else {
            $send_data['state'] = 'duplication';
            echo json_encode($send_data);
          }
          break;
        case "telemedicinesukses":
          $results = array();
          $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
          $date = date('Y-m-d');
          $sql = "SELECT a.tanggal_booking, a.tanggal_periksa, a.no_reg, a.status, b.nm_poli, c.nm_dokter, d.png_jawab, a.jam_booking FROM booking_registrasi a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.tanggal_booking = '$date' AND a.jam_booking = (SELECT MAX(ax.jam_booking) FROM booking_registrasi ax WHERE ax.tanggal_booking = a.tanggal_booking) ORDER BY a.tanggal_booking ASC LIMIT 1";
          $query = $this->db()->pdo()->prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($rows as $row) {
            $mlite_duitku = $this->db('mlite_duitku')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal', $row['tanggal_booking'] . ' ' . $row['jam_booking'])->oneArray();
            $row['paymentUrl'] = $mlite_duitku['paymentUrl'];
            $results[] = $row;
          }
          echo json_encode($results, JSON_PRETTY_PRINT);
          break;
        default:
          echo 'Default';
          break;
      }
    } else {
      echo 'Error';
    }
    exit();
  }

  public function hitungUmur($tanggal_lahir)
  {
    $birthDate = new \DateTime($tanggal_lahir);
    $today = new \DateTime("today");
    $umur = "0 Th 0 Bl 0 Hr";
    if ($birthDate < $today) {
      $y = $today->diff($birthDate)->y;
      $m = $today->diff($birthDate)->m;
      $d = $today->diff($birthDate)->d;
      $umur =  $y . " Th " . $m . " Bl " . $d . " Hr";
    }
    return $umur;
  }

  private function sendRegisterEmail($email, $receiver, $number)
  {
    $mail = new PHPMailer(true);
    $temp  = @file_get_contents(MODULES . "/api/email/apam.welcome.html");

    $temp  = str_replace("{SITENAME}", $this->core->settings->get('settings.nama_instansi'), $temp);
    $temp  = str_replace("{ADDRESS}", $this->core->settings->get('settings.alamat') . " - " . $this->core->settings->get('settings.kota'), $temp);
    $temp  = str_replace("{TELP}", $this->core->settings->get('settings.nomor_telepon'), $temp);
    $temp  = str_replace("{NUMBER}", $number, $temp);

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = $this->settings->get('api.apam_smtp_host');
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $this->settings->get('api.apam_smtp_port');

    $mail->Username = $this->settings->get('api.apam_smtp_username');
    $mail->Password = $this->settings->get('api.apam_smtp_password');

    // Sender and recipient settings
    $mail->setFrom($this->core->settings->get('settings.email'), $this->core->settings->get('settings.nama_instansi'));
    $mail->addAddress($email, $receiver);

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = "Verifikasi pendaftaran anda di " . $this->core->settings->get('settings.nama_instansi');
    $mail->Body = $temp;

    $mail->send();
  }

  public function getWags()
  {
    header("Refresh:180");
    $datetime = new \DateTime('tomorrow');
    $dateyesterday = new \DateTime('yesterday');
    $date = $datetime->format('Y-m-d');
    $datebefore = $dateyesterday->format('Y-m-d');
    $dateIndo = $datetime->format('d-m-Y');
    $mysql_date = date('Y-m-d');
    $timestamp = date("Y-m-d H:i:s");
    $time = date("H:i:s");

    $sender = $this->settings->get('api.wagateway_phonenumber');
    $url = $this->settings->get('api.wagateway_server');

    $getWaBefore = $this->db('bridging_wa')->where('tanggal', $datebefore)->where('poli', '!=', 'UTD')->toArray();
    if (count($getWaBefore) > 0) {
      echo 'Link Release</br>';
      $this->db('bridging_wa')->where('tanggal', $datebefore)->where('poli', '!=', 'UTD')->delete();
    }

    $getCheckWA = $this->db('bridging_wa')->where('tanggal', $mysql_date)->where('poli', '!=', 'UTD')->toArray();
    $getCheckBooking = $this->db('booking_registrasi')->where('tanggal_periksa', $date)->toArray();
    if (count($getCheckWA) < count($getCheckBooking)) {
      echo 'Link Start</br>';
      $getBooking = $this->db('booking_registrasi')
        ->select(['nm_pasien' => 'pasien.nm_pasien', 'no_tlp' => 'pasien.no_tlp', 'nm_poli' => 'poliklinik.nm_poli', 'no_rkm_medis' => 'pasien.no_rkm_medis'])
        ->join('pasien', 'pasien.no_rkm_medis = booking_registrasi.no_rkm_medis')->join('poliklinik', 'poliklinik.kd_poli = booking_registrasi.kd_poli')
        ->where('booking_registrasi.tanggal_periksa', $date)->toArray();
      for ($i = 0; $i < count($getBooking); $i++) {
        $namaPasien = $getBooking[$i]['nm_pasien'];
        $tlpPasien = $getBooking[$i]['no_tlp'];
        $poliklinik = $getBooking[$i]['nm_poli'];
        $no_rkm_medis = $getBooking[$i]['no_rkm_medis'];
        $this->db('bridging_wa')->save([
          'no_rkm_medis' => $no_rkm_medis,
          'nama' => $namaPasien,
          'tanggal' => $mysql_date,
          'no_telp' => $tlpPasien,
          'poli' => $poliklinik,
          'status' => '-',
          'created_at' => $timestamp,
          'updated_at' => $timestamp,
        ]);
      }
    }

    echo 'Mulai Mengirim Whatsapp</br>';
    $getCron = $this->db('bridging_wa')->where('tanggal', $mysql_date)->where('status', '-')->where('no_telp', '!=', '')->where('poli', '!=', 'UTD')->limit(2)->toArray();
    for ($i = 0; $i < count($getCron); $i++) {
      $namaPasien = $getCron[$i]['nama'];
      $tlpPasien = $getCron[$i]['no_telp'];
      $poliklinik = $getCron[$i]['poli'];
      $no_rkm_medis = $getCron[$i]['no_rkm_medis'];
      $msg = "Assalamualaikum " . $namaPasien . ". \nUlun RSHD SIAP WA Bot dari Rumah Sakit H. Damanhuri Barabai .
        \nHandak behabar dan meingatakan pian, kalau nya BESOK tanggal " . $dateIndo . " pian ada JADWAL PERIKSA ke " . $poliklinik . " di Rumah Sakit H. Damanhuri Barabai . Pian bisa datang LANGSUNG ke ANJUNGAN PASIEN MANDIRI (APM) .
        \nPastikan RUJUKAN BPJS pian masih berlaku. Jika sudah habis, maka mintalah rujukan kembali untuk berobat ke Rumah Sakit.Terima kasih \n \nWassalamualaikum
        \nDaftar Online Tanpa Antri via Apam Barabai Klik Disini >>> https://play.google.com/store/apps/details?id=com.rshdbarabai.apam&hl=in&gl=US";
      $kirimWa = postWagsApi($tlpPasien, $msg, $sender, $url);
      if ($kirimWa == '200') {
        $simpanNotif = $this->db('bridging_wa')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal', $mysql_date)->save([
          'status' => 'Success',
          'updated_at' => $timestamp,
        ]);
        if ($simpanNotif) {
          echo 'Berhasil Kirim Whatsapp ke ' . $no_rkm_medis . ' dengan Nama '.$namaPasien.'</br>\n';
        }
      } else {
        $simpanNotif = $this->db('bridging_wa')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal', $mysql_date)->save([
          'status' => 'Failed',
          'updated_at' => $timestamp,
        ]);
        if ($simpanNotif) {
          echo 'Gagal Kirim Whatsapp ke ' . $no_rkm_medis . ' dengan Nama '.$namaPasien.'</br>\n';
        }
      }
    }
    if (!$getCron) {
      # code...
      echo 'Semua pasien kontrol sudah dikirimi pesan Whatsapp .';
    }
    echo 'Selesai Mengirim Whatsapp</br>';
    exit();
  }

  public function getAutoRegist()
  {
    date_default_timezone_set($this->settings->get('settings.timezone'));
    $date = date('Y-m-d');
    $no = 1;
    $checkBooking = $this->db('booking_registrasi')->where('tanggal_periksa', $date)->where('status', 'Belum')->toArray();
    foreach ($checkBooking as $value) {
      # code...
      $poliklinik = $this->db('poliklinik')->where('kd_poli', $value['kd_poli'])->oneArray();

      $pasien = $this->db('pasien')->where('no_rkm_medis', $value['no_rkm_medis'])->oneArray();

      $birthDate = new \DateTime($pasien['tgl_lahir']);
      $today = new \DateTime("today");
      $umur_daftar = "0";
      $status_umur = 'Hr';
      if ($birthDate < $today) {
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        $umur_daftar = $d;
        $status_umur = "Hr";
        if ($y != '0') {
          $umur_daftar = $y;
          $status_umur = "Th";
        }
        if ($y == '0' && $m != '0') {
          $umur_daftar = $m;
          $status_umur = "Bl";
        }
      }

      $_POST['no_reg'] = $value['no_reg'];
      $_POST['no_rawat'] = $this->setNoRawat();
      $_POST['tgl_registrasi'] = $date;
      $_POST['jam_reg'] = '06:00:00';
      $_POST['kd_dokter'] = $value['kd_dokter'];
      $_POST['no_rkm_medis'] = $value['no_rkm_medis'];
      $_POST['kd_poli'] = $value['kd_poli'];
      $_POST['p_jawab'] = '-';
      $_POST['almt_pj'] = '-';
      $_POST['hubunganpj'] = '-';
      $_POST['biaya_reg'] = $poliklinik['registrasi'];
      $_POST['stts'] = 'Belum';
      $cek_stts_daftar = $this->db('reg_periksa')->where('no_rkm_medis', $value['no_rkm_medis'])->count();
      $_POST['stts_daftar'] = 'Baru';
      if ($cek_stts_daftar > 0) {
        $_POST['stts_daftar'] = 'Lama';
      }
      $_POST['status_lanjut'] = 'Ralan';
      $_POST['kd_pj'] = $value['kd_pj'];
      $_POST['umurdaftar'] = $umur_daftar;
      $_POST['sttsumur'] = $status_umur;
      $_POST['status_bayar'] = 'Belum Bayar';
      $cek_status_poli = $this->db('reg_periksa')->where('no_rkm_medis', $value['no_rkm_medis'])->where('kd_poli', $value['kd_poli'])->count();
      $_POST['status_poli'] = 'Baru';
      if ($cek_status_poli > 0) {
        $_POST['status_poli'] = 'Lama';
      }
      // echo $_POST;
      $query = $this->db('reg_periksa')->save($_POST);
      if ($query) {
        # code...
        // echo json_encode($_POST);
        $this->db('booking_registrasi')->where('no_rkm_medis', $value['no_rkm_medis'])->where('tanggal_periksa', $date)->save(['status' => 'Terdaftar']);
        $this->db('skdp_bpjs')->where('no_rkm_medis', $value['no_rkm_medis'])->where('tanggal_datang', $date)->save(['status' => 'Sudah Periksa']);
        $updateSkdp = $this->db('skdp_bpjs')->where('no_rkm_medis', $value['no_rkm_medis'])->where('tanggal_datang', $date)->where('status', 'Sudah Periksa')->oneArray();
        if ($updateSkdp) {
          echo $no . '.' . $value['no_rkm_medis'] . ' Berhasil Didaftarkan Dan Update SKDP';
          echo '<br>';
        }
      }
      $no++;
    }
    if (!$checkBooking) {
      echo 'Tidak Ada Data Booking Untuk Hari Ini';
    }
    exit();
  }

  public function setNoRawat()
  {
    date_default_timezone_set($this->settings->get('settings.timezone'));
    $date = date('Y-m-d');
    $last_no_rawat = $this->db()->pdo()->prepare("SELECT ifnull(MAX(CONVERT(RIGHT(no_rawat,6),signed)),0) FROM reg_periksa WHERE tgl_registrasi = '$date'");
    $last_no_rawat->execute();
    $last_no_rawat = $last_no_rawat->fetch();
    if (empty($last_no_rawat[0])) {
      $last_no_rawat[0] = '000000';
    }
    $next_no_rawat = sprintf('%06s', ($last_no_rawat[0] + 1));
    $next_no_rawat = date('Y/m/d') . '/' . $next_no_rawat;

    return $next_no_rawat;
  }

  public function getUtd()
  {
    $sender = $this->settings->get('api.wagateway_phonenumber');
    $url = $this->settings->get('api.wagateway_server');
    $timestamp = date("Y-m-d H:i:s");
    $mysql_date = date('Y-m-d');
    $dateyesterday = new \DateTime('yesterday');
    $datebefore = $dateyesterday->format('Y-m-d');
    $day_male = date('Y-m-d', strtotime('-78 days'));
    $day_female = date('Y-m-d', strtotime('-92 days'));

    echo 'Mulai mencari pasien yang sudah siap donor .....<br>';

    $getWaBefore = $this->db('bridging_wa')->where('tanggal', $datebefore)->where('poli', 'UTD')->toArray();
    if (count($getWaBefore) > 0) {
      echo 'Melakukan Pembersihan ......</br>';
      $this->db('bridging_wa')->where('tanggal', $datebefore)->where('poli', 'UTD')->delete();
    }

    $getCheckWA = $this->db('bridging_wa')->where('tanggal', $mysql_date)->where('poli', 'UTD')->where('status', '-')->toArray();
    if (count($getCheckWA) == 0) {
      # code...
      $cek_db_male = $this->db('utd_donor')->where('tanggal', $day_male)->where('jk', 'L')->where('LENGTH(no_telp)', '>=', '11')->toArray();
      foreach ($cek_db_male as $value) {
        $no_rkm_medis_exchange = substr($value['no_donor'], 3);
        $cek_wa_male = $this->db('bridging_wa')->where('no_rkm_medis', $no_rkm_medis_exchange)->oneArray();
        if (!$cek_wa_male) {
          # code...
          $this->db('bridging_wa')->save([
            'no_rkm_medis' => $no_rkm_medis_exchange,
            'nama' => $value['nama'],
            'tanggal' => $mysql_date,
            'no_telp' => $value['no_telp'],
            'poli' => 'UTD',
            'status' => '-',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
          ]);
          echo 'Melakukan Persiapan Sebelum Kirim Whatsapp ...';
        }
        // echo $value['no_telp'].' > '.$value['nama'].' > '. $no_rkm_medis_exchange.'<br>';
      }

      $cek_db_female = $this->db('utd_donor')->where('tanggal', $day_female)->where('jk', 'P')->where('LENGTH(no_telp)', '>=', '11')->toArray();
      foreach ($cek_db_female as $value) {
        $no_rkm_medis_exchange = substr($value['no_donor'], 3);
        $cek_wa_female = $this->db('bridging_wa')->where('no_rkm_medis', $no_rkm_medis_exchange)->oneArray();
        if (!$cek_wa_female) {
          $this->db('bridging_wa')->save([
            'no_rkm_medis' => $no_rkm_medis_exchange,
            'nama' => $value['nama'],
            'tanggal' => $mysql_date,
            'no_telp' => $value['no_telp'],
            'poli' => 'UTD',
            'status' => '-',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
          ]);
          echo 'Melakukan Persiapan Sebelum Kirim Whatsapp ...';
        }
        // echo $value['no_telp'].' > '.$value['nama'].' > '. $no_rkm_medis_exchange.'<br>';
      }
    }

    $getCron = $this->db('bridging_wa')->where('tanggal', $mysql_date)->where('status', '-')->where('no_telp', '!=', '')->where('poli', 'UTD')->limit(2)->toArray();
    if (!$getCron) {
      # code...
      echo 'Semua pendonor sudah dikirimi pesan Whatsapp .';
    } else {
      echo 'Mulai Mengirim Pesan Whatsapp .....<br>';
      for ($i = 0; $i < count($getCron); $i++) {
        $namaPasien = $getCron[$i]['nama'];
        $tlpPasien = $getCron[$i]['no_telp'];
        $poliklinik = $getCron[$i]['poli'];
        $no_rkm_medis = $getCron[$i]['no_rkm_medis'];
        $msg = "Assalamualaikum wr.wb " . $namaPasien . ". \nKami dari Unit Transfusi Darah RSUD H.DAMANHURI BARABAI\n
          Mengingatkan bahwa Bapak/Ibu telah melakukan donor darah sebelumnya dan sudah dapat melakukan donor darah
          kembali karena waktu untuk donor darah sudah sampai. \nKami tunggu ya kedatangannya.\nTerima kasih. Wassalamualaikum";
        $kirimWa = postWagsApi($tlpPasien, $msg, $sender, $url);
        if ($kirimWa == '200') {
          $simpanNotif = $this->db('bridging_wa')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal', $mysql_date)->save([
            'status' => 'Success',
            'updated_at' => $timestamp,
          ]);
          if ($simpanNotif) {
            echo 'Berhasil Kirim Whatsapp ke pendonor dengan Nama ' . $namaPasien . ' \n</br>';
=======
                  $get_pasien = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
                  $get_poliklinik = $this->db('poliklinik')->where('kd_poli', $kd_poli)->oneArray();
                  $waapiserver = $this->settings->get('wagateway.server');
                  $url = $waapiserver."/wagateway/kirimpesan";
                  if($get_pasien['no_tlp'] !='') {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "type=text&api_key=".$this->settings->get('wagateway.token')."&sender=".$this->settings->get('wagateway.phonenumber')."&number=".$get_pasien['no_tlp']."&message=Terima kasih sudah melakukan pendaftaran Online Telemedicine di ".$this->settings->get('settings.nama_instansi').". \n\nDetail pendaftaran Telemedicine anda adalah, \nTanggal: ".date('Y-m-d', strtotime($waktu_kunjungan))." \nNomor Antrian: ".$no_reg." \nPoliklinik: ".$get_poliklinik['nm_poli']." \nStatus: Menunggu \n\nSilahkan lakukan pembayaran dengan mengklik link berikut ".$result_duitku['paymentUrl'].".\n\n-------------------\nPesan WhatsApp ini dikirim otomatis oleh ".$this->settings->get('settings.nama_instansi')." \nTerima Kasih"); // Define what you want to post
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT,30);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                  }

              }
              else{
                  $send_data['state'] = 'duplication';
                  echo json_encode($send_data);
              }
            break;
            case "telemedicinesukses":
              $results = array();
              $no_rkm_medis = trim($_REQUEST['no_rkm_medis']);
              $date = date('Y-m-d');
              $sql = "SELECT a.tanggal_booking, a.tanggal_periksa, a.no_reg, a.status, b.nm_poli, c.nm_dokter, d.png_jawab, a.jam_booking FROM booking_registrasi a LEFT JOIN poliklinik b ON a.kd_poli = b.kd_poli LEFT JOIN dokter c ON a.kd_dokter = c.kd_dokter LEFT JOIN penjab d ON a.kd_pj = d.kd_pj WHERE a.no_rkm_medis = '$no_rkm_medis' AND a.tanggal_booking = '$date' AND a.jam_booking = (SELECT MAX(ax.jam_booking) FROM booking_registrasi ax WHERE ax.tanggal_booking = a.tanggal_booking) ORDER BY a.tanggal_booking ASC LIMIT 1";
              $query = $this->db()->pdo()->prepare($sql);
              $query->execute();
              $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                $mlite_duitku = $this->db('mlite_duitku')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal', $row['tanggal_booking'].' '.$row['jam_booking'])->oneArray();
                $row['paymentUrl'] = $mlite_duitku['paymentUrl'];
                $results[] = $row;
              }
              echo json_encode($results, JSON_PRETTY_PRINT);
            break;
            case "simpanretensirekammedik":
              $send_data = array();
              unset($_POST);
              $_POST['no_rkm_medis'] =  trim($_REQUEST['no_rkm_medis']);
              $_POST['terakhir_daftar'] = date('Y-m-d');
              $_POST['tgl_retensi'] = date('Y-m-d');
              $_POST['lokasi_pdf'] = '-';

              $simpan = $this->db('retensi_pasien')->save($_POST);
              if($simpan) {
                $data['state'] = 'success';
              } else {
                $data['state'] = 'error';
              }
              echo json_encode($data);
            break;
            default:
              echo 'Default';
            break;
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
          }
        } else {
          $simpanNotif = $this->db('bridging_wa')->where('no_rkm_medis', $no_rkm_medis)->where('tanggal', $mysql_date)->save([
            'status' => 'Failed',
            'updated_at' => $timestamp,
          ]);
          if ($simpanNotif) {
            echo 'Gagal Kirim Whatsapp ke pendonor dengan Nama ' . $namaPasien . ' \n</br>';
          }
        }
      }
      echo 'Selesai Mengirim Whatsapp</br>';
    }
<<<<<<< HEAD
    exit();
  }
=======

    public function hitungUmur($tanggal_lahir)
    {
      	$birthDate = new \DateTime($tanggal_lahir);
      	$today = new \DateTime("today");
      	$umur = "0 Th 0 Bl 0 Hr";
        if ($birthDate < $today) {
        	$y = $today->diff($birthDate)->y;
        	$m = $today->diff($birthDate)->m;
        	$d = $today->diff($birthDate)->d;
          $umur =  $y." Th ".$m." Bl ".$d." Hr";
        }
      	return $umur;
    }

    private function sendRegisterEmail($email, $receiver, $number)
    {
	    $mail = new PHPMailer(true);
      $temp  = @file_get_contents(MODULES."/api/email/apam.welcome.html");

      $temp  = str_replace("{SITENAME}", $this->core->settings->get('settings.nama_instansi'), $temp);
      $temp  = str_replace("{ADDRESS}", $this->core->settings->get('settings.alamat')." - ".$this->core->settings->get('settings.kota'), $temp);
      $temp  = str_replace("{TELP}", $this->core->settings->get('settings.nomor_telepon'), $temp);
      $temp  = str_replace("{NUMBER}", $number, $temp);

	    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
      $mail->isSMTP();
      $mail->Host = $this->settings->get('api.apam_smtp_host');
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = $this->settings->get('api.apam_smtp_port');

      $mail->Username = $this->settings->get('api.apam_smtp_username');
      $mail->Password = $this->settings->get('api.apam_smtp_password');

      // Sender and recipient settings
      $mail->setFrom($this->core->settings->get('settings.email'), $this->core->settings->get('settings.nama_instansi'));
      $mail->addAddress($email, $receiver);

      // Setting the email content
      $mail->IsHTML(true);
      $mail->Subject = "Verifikasi pendaftaran anda di ".$this->core->settings->get('settings.nama_instansi');
      $mail->Body = $temp;

      $mail->send();
    }

    public function getBerkasDigital()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With");
        $dir    = WEBAPPS_PATH.'/berkasrawat/pages/upload';
        $cntr   = 0;

        $key = $this->settings->get('api.berkasdigital_key');
        $token = trim(isset($_POST['token'])?$_POST['token']:null);

        if($token == $key) {

          $image = $_FILES['file']['tmp_name'];
          $img = new \Systems\Lib\Image();
          $id = convertNorawat($_POST['no_rawat']);
          if ($img->load($image)) {
              $imgName = time().$cntr++;
              $imgPath = $dir.'/'.$id.'_'.$imgName.'.'.$img->getInfos('type');
              $lokasi_file = 'pages/upload/'.$id.'_'.$imgName.'.'.$img->getInfos('type');
              $img->save($imgPath);
              $query = $this->db('berkas_digital_perawatan')->save(['no_rawat' => $_POST['no_rawat'], 'kode' => $_POST['kode'], 'lokasi_file' => $lokasi_file]);
              if($query) {
                $data['status'] = 'Success';
                $data['msg'] = $lokasi_file;
                echo json_encode($data);
              }
          }

        } else {
          echo 'Error';
        }

        exit();
    }

    public function getBarcode() {

      $filepath = (isset($_GET["filepath"])?$_GET["filepath"]:"");
      $text = (isset($_GET["text"])?$_GET["text"]:"0");
      $size = (isset($_GET["size"])?$_GET["size"]:"20");
      $orientation = (isset($_GET["orientation"])?$_GET["orientation"]:"horizontal");
      $code_type = (isset($_GET["codetype"])?$_GET["codetype"]:"code128");
      $print = (isset($_GET["print"])&&$_GET["print"]=='true'?true:false);
      $SizeFactor = (isset($_GET["sizefactor"])?$_GET["sizefactor"]:"1");

    	$code_string = "";
    	// Translate the $text into barcode the correct $code_type
    	if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
    		$chksum = 104;
    		// Must not change order of array elements as the checksum depends on the array's key to validate final code
    		$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
    		$code_keys = array_keys($code_array);
    		$code_values = array_flip($code_keys);
    		for ( $X = 1; $X <= strlen($text); $X++ ) {
    			$activeKey = substr( $text, ($X-1), 1);
    			$code_string .= $code_array[$activeKey];
    			$chksum=($chksum + ($code_values[$activeKey] * $X));
    		}
    		$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

    		$code_string = "211214" . $code_string . "2331112";
    	} elseif ( strtolower($code_type) == "code128a" ) {
    		$chksum = 103;
    		$text = strtoupper($text); // Code 128A doesn't support lower case
    		// Must not change order of array elements as the checksum depends on the array's key to validate final code
    		$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
    		$code_keys = array_keys($code_array);
    		$code_values = array_flip($code_keys);
    		for ( $X = 1; $X <= strlen($text); $X++ ) {
    			$activeKey = substr( $text, ($X-1), 1);
    			$code_string .= $code_array[$activeKey];
    			$chksum=($chksum + ($code_values[$activeKey] * $X));
    		}
    		$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

    		$code_string = "211412" . $code_string . "2331112";
    	} elseif ( strtolower($code_type) == "code39" ) {
    		$code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

    		// Convert to uppercase
    		$upper_text = strtoupper($text);

    		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
    			$code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
    		}

    		$code_string = "1211212111" . $code_string . "121121211";
    	} elseif ( strtolower($code_type) == "code25" ) {
    		$code_array1 = array("1","2","3","4","5","6","7","8","9","0");
    		$code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

    		for ( $X = 1; $X <= strlen($text); $X++ ) {
    			for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
    				if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
    					$temp[$X] = $code_array2[$Y];
    			}
    		}

    		for ( $X=1; $X<=strlen($text); $X+=2 ) {
    			if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
    				$temp1 = explode( "-", $temp[$X] );
    				$temp2 = explode( "-", $temp[($X + 1)] );
    				for ( $Y = 0; $Y < count($temp1); $Y++ )
    					$code_string .= $temp1[$Y] . $temp2[$Y];
    			}
    		}

    		$code_string = "1111" . $code_string . "311";
    	} elseif ( strtolower($code_type) == "codabar" ) {
    		$code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
    		$code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

    		// Convert to uppercase
    		$upper_text = strtoupper($text);

    		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
    			for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
    				if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
    					$code_string .= $code_array2[$Y] . "1";
    			}
    		}
    		$code_string = "11221211" . $code_string . "1122121";
    	}

    	// Pad the edges of the barcode
    	$code_length = 20;
    	if ($print) {
    		$text_height = 30;
    	} else {
    		$text_height = 0;
    	}

    	for ( $i=1; $i <= strlen($code_string); $i++ ){
    		$code_length = $code_length + (integer)(substr($code_string,($i-1),1));
            }

    	if ( strtolower($orientation) == "horizontal" ) {
    		$img_width = $code_length*$SizeFactor;
    		$img_height = $size;
    	} else {
    		$img_width = $size;
    		$img_height = $code_length*$SizeFactor;
    	}

    	$image = imagecreate($img_width, $img_height + $text_height);
    	$black = imagecolorallocate ($image, 0, 0, 0);
    	$white = imagecolorallocate ($image, 255, 255, 255);

    	imagefill( $image, 0, 0, $white );
    	if ( $print ) {
    		imagestring($image, 5, 31, $img_height, $text, $black );
    	}

    	$location = 10;
    	for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
    		$cur_size = $location + ( substr($code_string, ($position-1), 1) );
    		if ( strtolower($orientation) == "horizontal" )
    			imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
    		else
    			imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
    		$location = $cur_size;
    	}

    	// Draw barcode to the screen or save in a file
    	if ( $filepath=="" ) {
    		header ('Content-type: image/png');
    		imagepng($image);
    		imagedestroy($image);
    	} else {
    		imagepng($image,$filepath);
    		imagedestroy($image);
    	}
    }

>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
}
