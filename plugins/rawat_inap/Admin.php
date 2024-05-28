<?php

namespace Plugins\Rawat_Inap;

use Systems\AdminModule;
use Plugins\Icd\DB_ICD;

class Admin extends AdminModule
{

  private $_uploads = WEBAPPS_PATH . '/berkasrawat/pages/upload';
  public function navigation()
  {
    return [
      'Kelola'   => 'manage',
    ];
  }

  public function anyManage()
  {
    $tgl_masuk = '';
    $tgl_masuk_akhir = '';
    $status_pulang = '';
    $nama_pegawai = '';
    $this->assign['stts_pulang'] = [];

    if (isset($_POST['periode_rawat_inap'])) {
      $tgl_masuk = $_POST['periode_rawat_inap'];
    }
<<<<<<< HEAD
    if (isset($_POST['periode_rawat_inap_akhir'])) {
      $tgl_masuk_akhir = $_POST['periode_rawat_inap_akhir'];
    }
    if (isset($_POST['status_pulang'])) {
      $status_pulang = $_POST['status_pulang'];
=======

    public function anyManage()
    {
        $tgl_masuk = '';
        $tgl_masuk_akhir = '';
        $status_pulang = '';
        $status_periksa = '';
        $this->assign['stts_pulang'] = [];

        if(isset($_POST['periode_rawat_inap'])) {
          $tgl_masuk = $_POST['periode_rawat_inap'];
        }
        if(isset($_POST['periode_rawat_inap_akhir'])) {
          $tgl_masuk_akhir = $_POST['periode_rawat_inap_akhir'];
        }
        if(isset($_POST['status_pulang'])) {
          $status_pulang = $_POST['status_pulang'];
        }
        if(isset($_POST['status_periksa'])) {
          $status_periksa = $_POST['status_periksa'];
        }
        $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();
        $master_berkas_digital = $this->db('master_berkas_digital')->toArray();
        $this->_Display($tgl_masuk, $tgl_masuk_akhir, $status_pulang, $status_periksa);
        return $this->draw('manage.html', ['rawat_inap' => $this->assign, 'cek_vclaim' => $cek_vclaim, 'master_berkas_digital' => $master_berkas_digital]);
    }

    public function anyDisplay()
    {
        $tgl_masuk = '';
        $tgl_masuk_akhir = '';
        $status_pulang = '';
        $status_periksa = '';
        $this->assign['stts_pulang'] = [];

        if(isset($_POST['periode_rawat_inap'])) {
          $tgl_masuk = $_POST['periode_rawat_inap'];
        }
        if(isset($_POST['periode_rawat_inap_akhir'])) {
          $tgl_masuk_akhir = $_POST['periode_rawat_inap_akhir'];
        }
        if(isset($_POST['status_pulang'])) {
          $status_pulang = $_POST['status_pulang'];
        }
        if(isset($_POST['status_periksa'])) {
          $status_periksa = $_POST['status_periksa'];
        }
        $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();
        $this->_Display($tgl_masuk, $tgl_masuk_akhir, $status_pulang, $status_periksa);
        echo $this->draw('display.html', ['rawat_inap' => $this->assign, 'cek_vclaim' => $cek_vclaim]);
        exit();
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    }
    $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();

<<<<<<< HEAD
    $username = $this->core->getUserInfo('username', null, true);

    $master_berkas_digital = $this->db('master_berkas_digital')->toArray();
    
    $this->_Display($tgl_masuk, $tgl_masuk_akhir, $status_pulang);
    return $this->draw('manage.html', [
      'rawat_inap' => $this->assign, 
      'cek_vclaim' => $cek_vclaim, 
      'master_berkas_digital' => $master_berkas_digital, 
      'username' => $username
    ]);
  }
=======
    public function _Display($tgl_masuk='', $tgl_masuk_akhir='', $status_pulang='', $status_periksa='')
    {
        $this->_addHeaderFiles();

        $this->assign['kamar'] = $this->db('kamar')->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')->where('statusdata', '1')->toArray();
        $this->assign['dokter']         = $this->db('dokter')->where('status', '1')->toArray();
        $this->assign['penjab']       = $this->db('penjab')->where('status', '1')->toArray();
        $this->assign['no_rawat'] = '';
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

  public function anyDisplay()
  {
    $tgl_masuk = '';
    $tgl_masuk_akhir = '';
    $status_pulang = '';
    $this->assign['stts_pulang'] = [];

    if (isset($_POST['periode_rawat_inap'])) {
      $tgl_masuk = $_POST['periode_rawat_inap'];
    }
    if (isset($_POST['periode_rawat_inap_akhir'])) {
      $tgl_masuk_akhir = $_POST['periode_rawat_inap_akhir'];
    }
    if (isset($_POST['status_pulang'])) {
      $status_pulang = $_POST['status_pulang'];
    }
    $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();

    $username = $this->core->getUserInfo('username', null, true);

    $this->_Display($tgl_masuk, $tgl_masuk_akhir, $status_pulang);
    echo $this->draw('display.html', ['rawat_inap' => $this->assign, 'cek_vclaim' => $cek_vclaim, 'username' => $username]);
    exit();
  }

  public function _Display($tgl_masuk = '', $tgl_masuk_akhir = '', $status_pulang = '')
  {
    $this->_addHeaderFiles();

    $this->assign['kamar'] = $this->db('kamar')->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')->where('statusdata', '1')->toArray();
    $this->assign['dokter'] = $this->db('dokter')->where('status', '1')->toArray();
    $this->assign['penjab']   = $this->db('penjab')->where('status', '1')->toArray();
    $this->assign['no_rawat'] = '';

    $bangsal = str_replace(",", "','", $this->core->getUserInfo('cap', null, true));

    $sql = "SELECT
            kamar_inap.*,
            reg_periksa.*,
            pasien.*,
            kamar.*,
            bangsal.*,
            penjab.*
          FROM
            kamar_inap,
            reg_periksa,
            pasien,
            kamar,
            bangsal,
            penjab
          WHERE
            kamar_inap.no_rawat=reg_periksa.no_rawat
          AND
            reg_periksa.no_rkm_medis=pasien.no_rkm_medis
          AND
            kamar_inap.kd_kamar=kamar.kd_kamar
          AND
            bangsal.kd_bangsal=kamar.kd_bangsal
          AND
            reg_periksa.kd_pj=penjab.kd_pj";

<<<<<<< HEAD
     $username = $this->core->getUserInfo('username', null, true);
  //  if ((!in_array($this->core->getUserInfo('role'), ['admin', 'apoteker', 'laboratorium', 'radiologi', 'manajemen', 'gizi'],  true)) 
  //  && (!in_array ($this->core->getPegawaiInfo('bidang', $username), ['Mubarak'], true)) ) {
    if (!in_array($this->core->getUserInfo('role'), ['admin', 'medis','apoteker', 'laboratorium', 'radiologi', 'manajemen', 'gizi', 'ppi/mpp', 'ok', 'paramedis'],  true)){
      $sql .= " AND bangsal.kd_bangsal IN ('$bangsal')";
    }
    if ($status_pulang == '') {
      $sql .= " AND kamar_inap.stts_pulang = '-'";
    }
    if ($status_pulang == 'all' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
      $sql .= " AND kamar_inap.stts_pulang = '-' AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
    }
    if ($status_pulang == 'masuk' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
      $sql .= " AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
    }
    if ($status_pulang == 'pulang' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
      $sql .= " AND kamar_inap.tgl_keluar BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
=======
        if ($this->core->getUserInfo('role') != 'admin') {
          $sql .= " AND bangsal.kd_bangsal IN ('$bangsal')";
        }
        if($status_pulang == '') {
          $sql .= " AND kamar_inap.stts_pulang = '-'";
        }
        if($status_pulang == 'all' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
          $sql .= " AND kamar_inap.stts_pulang = '-' AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
        }
        if($status_pulang == 'masuk' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
          $sql .= " AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
        }
        if($status_pulang == 'pulang' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
          $sql .= " AND kamar_inap.tgl_keluar BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
        }
        if($status_periksa == 'lunas' && $status_pulang == '-' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
          $sql .= " AND reg_periksa.status_bayar = 'Sudah Bayar' AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
        }

        $stmt = $this->db()->pdo()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $this->assign['list'] = [];
        foreach ($rows as $row) {
          $row['status_billing'] = 'Sudah Bayar';
          $get_billing = $this->db('mlite_billing')->where('no_rawat', $row['no_rawat'])->like('kd_billing', 'RI%')->oneArray();
          if(empty($get_billing['kd_billing'])) {
            $row['kd_billing'] = 'RI.'.date('d.m.Y.H.i.s');
            $row['tgl_billing'] = date('Y-m-d H:i');
            $row['status_billing'] = 'Belum Bayar';
          }

          $dpjp_ranap = $this->db('dpjp_ranap')
            ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
            ->where('no_rawat', $row['no_rawat'])
            ->toArray();
          $row['dokter'] = $dpjp_ranap;
          $bridging_sep = $this->db('bridging_sep')->where('no_rawat', $row['no_rawat'])->oneArray();
          $row['no_sep'] = isset_or($bridging_sep['no_sep']);
          $this->assign['list'][] = $row;
        }

        if (isset($_POST['no_rawat'])){
          $this->assign['kamar_inap'] = $this->db('kamar_inap')
            ->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')
            ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
            ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
            ->join('dpjp_ranap', 'dpjp_ranap.no_rawat=kamar_inap.no_rawat')
            ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
            ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
            ->where('kamar_inap.no_rawat', $_POST['no_rawat'])
            ->oneArray();
        } else {
          $this->assign['kamar_inap'] = [
            'tgl_masuk' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
            'tgl_keluar' => date('Y-m-d'),
            'jam_keluar' => date('H:i:s'),
            'no_rkm_medis' => '',
            'nm_pasien' => '',
            'no_rawat' => '',
            'kd_dokter' => '',
            'kd_kamar' => '',
            'kd_pj' => '',
            'diagnosa_awal' => '',
            'diagnosa_akhir' => '',
            'stts_pulang' => '',
            'lama' => ''
          ];
        }
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    }

    $stmt = $this->db()->pdo()->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

<<<<<<< HEAD
    $this->assign['list'] = [];
    foreach ($rows as $row) {
      $dpjp_ranap = $this->db('dpjp_ranap')
        ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
        ->where('no_rawat', $row['no_rawat'])
        ->toArray();
      $row['dokter'] = $dpjp_ranap;
      $row['con_no_rawat'] = convertNorawat($row['no_rawat']);
      $this->assign['list'][] = $row;
    }

    if (isset($_POST['no_rawat'])) {
      $this->assign['kamar_inap'] = $this->db('kamar_inap')
        ->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
        ->join('dpjp_ranap', 'dpjp_ranap.no_rawat=kamar_inap.no_rawat')
        ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
        ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
        ->where('kamar_inap.no_rawat', $_POST['no_rawat'])
        ->oneArray();
    } else {
      $this->assign['kamar_inap'] = [
        'tgl_masuk' => date('Y-m-d'),
        'jam_masuk' => date('H:i:s'),
        'tgl_keluar' => date('Y-m-d'),
        'jam_keluar' => date('H:i:s'),
        'no_rkm_medis' => '',
        'nm_pasien' => '',
        'no_rawat' => '',
        'kd_dokter' => '',
        'kd_kamar' => '',
        'kd_pj' => '',
        'diagnosa_awal' => '',
=======
      $this->assign['kamar'] = $this->db('kamar')->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')->where('statusdata', '1')->toArray();
      $this->assign['dokter'] = $this->db('dokter')->where('status', '1')->toArray();
      $this->assign['penjab'] = $this->db('penjab')->where('status', '1')->toArray();
      $this->assign['stts_pulang'] = ['Sehat','Rujuk','APS','+','Meninggal','Sembuh','Membaik','Pulang Paksa','-','Pindah Kamar','Status Belum Lengkap','Atas Persetujuan Dokter','Atas Permintaan Sendiri','Lain-lain'];
      $this->assign['no_rawat'] = '';
      if (isset($_POST['no_rawat'])){
        $this->assign['kamar_inap'] = $this->db('kamar_inap')
          ->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')
          ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
          ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
          ->join('dpjp_ranap', 'dpjp_ranap.no_rawat=kamar_inap.no_rawat')
          ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
          ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
          ->where('kamar_inap.no_rawat', $_POST['no_rawat'])
          ->oneArray();
        echo $this->draw('form.html', [
          'rawat_inap' => $this->assign
        ]);
      } else {
        $this->assign['kamar_inap'] = [
          'tgl_masuk' => date('Y-m-d'),
          'jam_masuk' => date('H:i:s'),
          'tgl_keluar' => date('Y-m-d'),
          'jam_keluar' => date('H:i:s'),
          'no_rkm_medis' => '',
          'nm_pasien' => '',
          'no_rawat' => '',
          'kd_dokter' => '',
          'kd_kamar' => '',
          'kd_pj' => '',
          'diagnosa_awal' => '',
          'diagnosa_akhir' => '',
          'stts_pulang' => '',
          'lama' => ''
        ];
        echo $this->draw('form.html', [
          'rawat_inap' => $this->assign
        ]);
      }
      exit();
    }

    public function anyStatusDaftar()
    {
      if(isset($_POST['no_rkm_medis'])) {
        $rawat = $this->db('reg_periksa')
          ->where('no_rkm_medis', $_POST['no_rkm_medis'])
          ->where('status_bayar', 'Belum Bayar')
          ->limit(1)
          ->oneArray();
          if($rawat) {
            $stts_daftar ="Transaki tanggal ".date('Y-m-d', strtotime($rawat['tgl_registrasi']))." belum diselesaikan" ;
            $bg_status = 'text-danger';
          } else {
            $result = $this->db('reg_periksa')->where('no_rkm_medis', $_POST['no_rkm_medis'])->oneArray();
            if(!empty($result['no_rawat'])) {
              $stts_daftar = 'Lama';
              $bg_status = 'text-info';
            } else {
              $stts_daftar = 'Baru';
              $bg_status = 'text-success';
            }
          }
        echo $this->draw('stts.daftar.html', ['stts_daftar' => $stts_daftar, 'bg_status' =>$bg_status]);
      } else {
        $rawat = $this->db('reg_periksa')
          ->where('no_rawat', $_POST['no_rawat'])
          ->oneArray();
        echo $this->draw('stts.daftar.html', ['stts_daftar' => $rawat['stts_daftar']]);
      }
      exit();
    }

    public function postSave()
    {
      $kamar = $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->oneArray();
      $kamar_inap = $this->db('kamar_inap')->save([
        'no_rawat' => $_POST['no_rawat'],
        'kd_kamar' => $_POST['kd_kamar'],
        'trf_kamar' => $kamar['trf_kamar'],
        'lama' => $_POST['lama'],
        'tgl_masuk' => $_POST['tgl_masuk'],
        'jam_masuk' => $_POST['jam_masuk'],
        'ttl_biaya' => $kamar['trf_kamar']*$_POST['lama'],
        'tgl_keluar' => '0000-00-00',
        'jam_keluar' => '00:00:00',
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
        'diagnosa_akhir' => '',
        'stts_pulang' => '',
        'lama' => ''
      ];
    }
  }

  public function anyForm()
  {

    $this->assign['kamar'] = $this->db('kamar')->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')->where('statusdata', '1')->toArray();
    $this->assign['dokter'] = $this->db('dokter')->where('status', '1')->toArray();
    $this->assign['penjab'] = $this->db('penjab')->toArray();
    $this->assign['stts_pulang'] = ['Sehat', 'Rujuk', 'APS', '+', 'Meninggal', 'Sembuh', 'Membaik', 'Pulang Paksa', '-', 'Pindah Kamar', 'Status Belum Lengkap', 'Atas Persetujuan Dokter', 'Atas Permintaan Sendiri', 'Lain-lain'];
    $this->assign['no_rawat'] = '';
    if (isset($_POST['no_rawat'])) {
      $this->assign['kamar_inap'] = $this->db('kamar_inap')
        ->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
        ->join('dpjp_ranap', 'dpjp_ranap.no_rawat=kamar_inap.no_rawat')
        ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
        ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
        ->where('kamar_inap.no_rawat', $_POST['no_rawat'])
        ->oneArray();
      echo $this->draw('form.html', [
        'rawat_inap' => $this->assign
      ]);
<<<<<<< HEAD
    } else {
      $this->assign['kamar_inap'] = [
        'tgl_masuk' => date('Y-m-d'),
        'jam_masuk' => date('H:i:s'),
        'tgl_keluar' => date('Y-m-d'),
        'jam_keluar' => date('H:i:s'),
        'no_rkm_medis' => '',
        'nm_pasien' => '',
        'no_rawat' => '',
        'kd_dokter' => '',
        'kd_kamar' => '',
        'kd_pj' => '',
        'diagnosa_awal' => '',
        'diagnosa_akhir' => '',
        'stts_pulang' => '',
        'lama' => ''
      ];
      echo $this->draw('form.html', [
        'rawat_inap' => $this->assign
      ]);
    }
    exit();
  }

  public function anyStatusDaftar()
  {
    if (isset($_POST['no_rkm_medis'])) {
      $rawat = $this->db('reg_periksa')
        ->where('no_rkm_medis', $_POST['no_rkm_medis'])
        ->where('status_bayar', 'Belum Bayar')
        ->limit(1)
        ->oneArray();
      if ($rawat) {
        $stts_daftar = "Transaki tanggal " . date('Y-m-d', strtotime($rawat['tgl_registrasi'])) . " belum diselesaikan";
        $bg_status = 'text-danger';
      } else {
        $result = $this->db('reg_periksa')->where('no_rkm_medis', $_POST['no_rkm_medis'])->oneArray();
        if ($result >= 1) {
          $stts_daftar = 'Lama';
          $bg_status = 'text-info';
        } else {
          $stts_daftar = 'Baru';
          $bg_status = 'text-success';
        }
=======
      if($kamar_inap) {
        $this->db('dpjp_ranap')->save(['no_rawat' => $_POST['no_rawat'], 'kd_dokter' => $_POST['kd_dokter']]);
        $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->save(['status' => 'ISI']);
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      }
      echo $this->draw('stts.daftar.html', ['stts_daftar' => $stts_daftar, 'bg_status' => $bg_status]);
    } else {
      $rawat = $this->db('reg_periksa')
        ->where('no_rawat', $_POST['no_rawat'])
        ->oneArray();
      echo $this->draw('stts.daftar.html', ['stts_daftar' => $rawat['stts_daftar']]);
    }
    exit();
  }

<<<<<<< HEAD
  public function postSave()
  {
    $kamar = $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->oneArray();
    $kamar_inap = $this->db('kamar_inap')->save([
      'no_rawat' => $_POST['no_rawat'],
      'kd_kamar' => $_POST['kd_kamar'],
      'trf_kamar' => $kamar['trf_kamar'],
      'lama' => $_POST['lama'],
      'tgl_masuk' => $_POST['tgl_masuk'],
      'jam_masuk' => $_POST['jam_masuk'],
      'ttl_biaya' => $kamar['trf_kamar'] * $_POST['lama'],
      'tgl_keluar' => '0000-00-00',
      'jam_keluar' => '00:00:00',
      'diagnosa_akhir' => '',
      'diagnosa_awal' => $_POST['diagnosa_awal'],
      'stts_pulang' => '-'
    ]);
    if ($kamar_inap) {
=======
    public function postSaveKeluar()
    {
      $kamar = $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->oneArray();
      $this->db('kamar_inap')->where('no_rawat', $_POST['no_rawat'])->save([
        'stts_pulang' => $_POST['stts_pulang'],
        'lama' => $_POST['lama'],
        'tgl_keluar' => $_POST['tgl_keluar'],
        'jam_keluar' => $_POST['jam_keluar'],
        'diagnosa_akhir' => $_POST['diagnosa_akhir'],
        'ttl_biaya' => $kamar['trf_kamar']*$_POST['lama']
      ]);
      $this->db('reg_periksa')->where('no_rawat', $_POST['no_rawat'])->save([
        'kd_pj' => $_POST['kd_pj'],
        'stts' => 'Sudah'
      ]);
      $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->save(['status' => 'KOSONG']);
      exit();
    }

    public function postSetDPJP()
    {
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      $this->db('dpjp_ranap')->save(['no_rawat' => $_POST['no_rawat'], 'kd_dokter' => $_POST['kd_dokter']]);
    }
    exit();
  }

  public function postSaveKeluar()
  {
    $kamar = $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->oneArray();
    $this->db('kamar_inap')->where('no_rawat', $_POST['no_rawat'])->save([
      'stts_pulang' => $_POST['stts_pulang'],
      'lama' => $_POST['lama'],
      'tgl_keluar' => $_POST['tgl_keluar'],
      'jam_keluar' => $_POST['jam_keluar'],
      'diagnosa_akhir' => $_POST['diagnosa_akhir'],
      'ttl_biaya' => $kamar['trf_kamar'] * $_POST['lama']
    ]);
    exit();
  }

<<<<<<< HEAD
  public function postSetDPJP()
  {
    $this->db('dpjp_ranap')->save(['no_rawat' => $_POST['no_rawat'], 'kd_dokter' => $_POST['kd_dokter']]);
    exit();
  }

  public function postHapusDPJP()
  {
    $this->db('dpjp_ranap')->where('no_rawat', $_POST['no_rawat'])->where('kd_dokter', $_POST['kd_dokter'])->delete();
    exit();
  }

  public function anyPasien()
  {
    $cari = $_POST['cari'];
    if (isset($_POST['cari'])) {
      $sql = "SELECT
=======
    public function postUbahPenjab()
    {
      $this->db('reg_periksa')->where('no_rawat', $_POST['no_rawat'])->save([
        'kd_pj' => $_POST['kd_pj']
      ]);
      exit();
    }

    public function anyPasien()
    {
      $cari = $_POST['cari'];
      if(isset($_POST['cari'])) {
        $sql = "SELECT
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
            pasien.nm_pasien,
            pasien.no_rkm_medis,
            reg_periksa.no_rawat
          FROM
            reg_periksa,
            pasien
          WHERE
            reg_periksa.status_lanjut='Ranap'
          AND
            pasien.no_rkm_medis=reg_periksa.no_rkm_medis
          AND
            (reg_periksa.no_rkm_medis LIKE ? OR reg_periksa.no_rawat LIKE ? OR pasien.nm_pasien LIKE ?)
          LIMIT 10";

      $stmt = $this->db()->pdo()->prepare($sql);
      $stmt->execute(['%' . $cari . '%', '%' . $cari . '%', '%' . $cari . '%']);
      $pasien = $stmt->fetchAll();

      /*$pasien = $this->db('reg_periksa')
          ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
          ->like('reg_periksa.no_rkm_medis', '%'.$_POST['cari'].'%')
          ->where('status_lanjut', 'Ranap')
          ->asc('reg_periksa.no_rkm_medis')
          ->limit(15)
          ->toArray();*/
    }
    echo $this->draw('pasien.html', ['pasien' => $pasien]);
    exit();
  }

  public function getAntrian()
  {
    $settings = $this->settings('settings');
    $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($settings)));
    $rawat_inap = $this->db('reg_periksa')
      ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
      ->join('poliklinik', 'poliklinik.kd_poli=reg_periksa.kd_poli')
      ->join('dokter', 'dokter.kd_dokter=reg_periksa.kd_dokter')
      ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
      ->where('no_rawat', $_GET['no_rawat'])
      ->oneArray();
    echo $this->draw('antrian.html', ['rawat_inap' => $rawat_inap]);
    exit();
  }

  public function postHapus()
  {
    $this->db('kamar_inap')->where('no_rawat', $_POST['no_rawat'])->delete();
    exit();
  }

  public function postSaveDetail()
  {
    if ($_POST['kat'] == 'tindakan') {
      $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $_POST['kd_jenis_prw'])->oneArray();
      if ($_POST['provider'] == 'rawat_inap_dr') {
        $this->db('rawat_inap_dr')->save([
          'no_rawat' => $_POST['no_rawat'],
          'kd_jenis_prw' => $_POST['kd_jenis_prw'],
          'kd_dokter' => $_POST['kode_provider'],
          'tgl_perawatan' => $_POST['tgl_perawatan'],
          'jam_rawat' => $_POST['jam_rawat'],
          'material' => $jns_perawatan['material'],
          'bhp' => $jns_perawatan['bhp'],
          'tarif_tindakandr' => $jns_perawatan['tarif_tindakandr'],
          'kso' => $jns_perawatan['kso'],
          'menejemen' => $jns_perawatan['menejemen'],
          'biaya_rawat' => $jns_perawatan['total_byrdr']
        ]);
      }
<<<<<<< HEAD
      if ($_POST['provider'] == 'rawat_inap_pr') {
        $this->db('rawat_inap_pr')->save([
          'no_rawat' => $_POST['no_rawat'],
          'kd_jenis_prw' => $_POST['kd_jenis_prw'],
          'nip' => $_POST['kode_provider2'],
          'tgl_perawatan' => $_POST['tgl_perawatan'],
          'jam_rawat' => $_POST['jam_rawat'],
          'material' => $jns_perawatan['material'],
          'bhp' => $jns_perawatan['bhp'],
          'tarif_tindakanpr' => $jns_perawatan['tarif_tindakanpr'],
          'kso' => $jns_perawatan['kso'],
          'menejemen' => $jns_perawatan['menejemen'],
          'biaya_rawat' => $jns_perawatan['total_byrdr']
        ]);
=======
      echo $this->draw('pasien.html', ['pasien' => $pasien]);
      exit();
    }

    public function getAntrian()
    {
      $settings = $this->settings('settings');
      $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($settings)));
      $rawat_inap = $this->db('reg_periksa')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->join('poliklinik', 'poliklinik.kd_poli=reg_periksa.kd_poli')
        ->join('dokter', 'dokter.kd_dokter=reg_periksa.kd_dokter')
        ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
        ->where('no_rawat', $_GET['no_rawat'])
        ->oneArray();
      echo $this->draw('antrian.html', ['rawat_inap' => $rawat_inap]);
      exit();
    }

    public function postHapus()
    {
      $this->db('kamar_inap')->where('no_rawat', $_POST['no_rawat'])->delete();
      exit();
    }

    public function postSaveDetail()
    {
      if($_POST['kat'] == 'tindakan') {
        $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $_POST['kd_jenis_prw'])->oneArray();
        if($_POST['provider'] == 'rawat_inap_dr') {
          $this->db('rawat_inap_dr')->save([
            'no_rawat' => $_POST['no_rawat'],
            'kd_jenis_prw' => $_POST['kd_jenis_prw'],
            'kd_dokter' => $_POST['kode_provider'],
            'tgl_perawatan' => $_POST['tgl_perawatan'],
            'jam_rawat' => $_POST['jam_rawat'],
            'material' => $jns_perawatan['material'],
            'bhp' => $jns_perawatan['bhp'],
            'tarif_tindakandr' => $jns_perawatan['tarif_tindakandr'],
            'kso' => $jns_perawatan['kso'],
            'menejemen' => $jns_perawatan['menejemen'],
            'biaya_rawat' => $jns_perawatan['total_byrdr']
          ]);
        }
        if($_POST['provider'] == 'rawat_inap_pr') {
          $this->db('rawat_inap_pr')->save([
            'no_rawat' => $_POST['no_rawat'],
            'kd_jenis_prw' => $_POST['kd_jenis_prw'],
            'nip' => $_POST['kode_provider2'],
            'tgl_perawatan' => $_POST['tgl_perawatan'],
            'jam_rawat' => $_POST['jam_rawat'],
            'material' => $jns_perawatan['material'],
            'bhp' => $jns_perawatan['bhp'],
            'tarif_tindakanpr' => $jns_perawatan['tarif_tindakanpr'],
            'kso' => $jns_perawatan['kso'],
            'menejemen' => $jns_perawatan['menejemen'],
            'biaya_rawat' => $jns_perawatan['total_byrpr']
          ]);
        }
        if($_POST['provider'] == 'rawat_inap_drpr') {
          $this->db('rawat_inap_drpr')->save([
            'no_rawat' => $_POST['no_rawat'],
            'kd_jenis_prw' => $_POST['kd_jenis_prw'],
            'kd_dokter' => $_POST['kode_provider'],
            'nip' => $_POST['kode_provider2'],
            'tgl_perawatan' => $_POST['tgl_perawatan'],
            'jam_rawat' => $_POST['jam_rawat'],
            'material' => $jns_perawatan['material'],
            'bhp' => $jns_perawatan['bhp'],
            'tarif_tindakandr' => $jns_perawatan['tarif_tindakandr'],
            'tarif_tindakanpr' => $jns_perawatan['tarif_tindakanpr'],
            'kso' => $jns_perawatan['kso'],
            'menejemen' => $jns_perawatan['menejemen'],
            'biaya_rawat' => $jns_perawatan['total_byrdrpr']
          ]);
        }
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      }
      if ($_POST['provider'] == 'rawat_inap_drpr') {
        $this->db('rawat_inap_drpr')->save([
          'no_rawat' => $_POST['no_rawat'],
          'kd_jenis_prw' => $_POST['kd_jenis_prw'],
          'kd_dokter' => $_POST['kode_provider'],
          'nip' => $_POST['kode_provider2'],
          'tgl_perawatan' => $_POST['tgl_perawatan'],
          'jam_rawat' => $_POST['jam_rawat'],
          'material' => $jns_perawatan['material'],
          'bhp' => $jns_perawatan['bhp'],
          'tarif_tindakandr' => $jns_perawatan['tarif_tindakandr'],
          'tarif_tindakanpr' => $jns_perawatan['tarif_tindakanpr'],
          'kso' => $jns_perawatan['kso'],
          'menejemen' => $jns_perawatan['menejemen'],
          'biaya_rawat' => $jns_perawatan['total_byrdr']
        ]);
      }
        if ($_POST['provider'] == 'rawat_inap_far') {
        $this->db('rawat_inap_pr')->save([
          'no_rawat' => $_POST['no_rawat'],
          'kd_jenis_prw' => $_POST['kd_jenis_prw'],
          'nip' => $_POST['kode_provider3'],
          'tgl_perawatan' => $_POST['tgl_perawatan'],
          'jam_rawat' => $_POST['jam_rawat'],
          'material' => $jns_perawatan['material'],
          'bhp' => $jns_perawatan['bhp'],
          'tarif_tindakanpr' => $jns_perawatan['tarif_tindakanpr'],
          'kso' => $jns_perawatan['kso'],
          'menejemen' => $jns_perawatan['menejemen'],
          'biaya_rawat' => $jns_perawatan['total_byrdr']
        ]);
      }
    }
    if ($_POST['kat'] == 'obat') {

<<<<<<< HEAD
      $no_resep = $this->core->setNoResep($_POST['tgl_perawatan']);

        $resep_obat = $this->core->mysql('resep_obat')
          ->save([
            'no_resep' => $no_resep,
            'tgl_perawatan' => '0000-00-00',
            'jam' => '00:00:00',
            'no_rawat' => $_POST['no_rawat'],
            'kd_dokter' => $_POST['kode_provider'],
            'tgl_peresepan' => $_POST['tgl_perawatan'],
            'jam_peresepan' => $_POST['jam_rawat'],
            'status' => 'ranap',
            'tgl_penyerahan' => '0000-00-00',
            'jam_penyerahan' => '00:00:00'
          ]);

        $this->core->mysql('resep_dokter')
          ->save([
            'no_resep' => $no_resep,
            'kode_brng' => $_POST['kd_jenis_prw'],
            'jml' => $_POST['jml'],
            'aturan_pakai' => $_POST['aturan_pakai']
          ]);
    }
   
   if($_POST['kat'] == 'laboratorium') {
        $cek_lab = $this->db('permintaan_lab')->where('no_rawat', $_POST['no_rawat'])->where('tgl_permintaan', date('Y-m-d'))->oneArray();
        if(!$cek_lab) {
          $max_id = $this->db('permintaan_lab')->select(['noorder' => 'ifnull(MAX(CONVERT(RIGHT(noorder,4),signed)),0)'])->where('tgl_permintaan', date('Y-m-d'))->oneArray();
          if(empty($max_id['noorder'])) {
            $max_id['noorder'] = '0000';
          }
          $_next_noorder = sprintf('%04s', ($max_id['noorder'] + 1));
          $noorder = 'PL'.date('Ymd').''.$_next_noorder;
=======
        $no_resep = $this->core->setNoResep($_POST['tgl_perawatan']);
        $cek_resep = $this->db('resep_obat')->where('no_rawat', $_POST['no_rawat'])->where('tgl_peresepan', $_POST['tgl_perawatan'])->where('tgl_perawatan', '0000-00-00')->where('status', 'ranap')->oneArray();

        if(empty($cek_resep)) {
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

          $permintaan_lab = $this->db('permintaan_lab')
            ->save([
<<<<<<< HEAD
              'noorder' => $noorder,
              'no_rawat' => $_POST['no_rawat'],
              'tgl_permintaan' => $_POST['tgl_perawatan'],
              'jam_permintaan' => $_POST['jam_rawat'],
              'tgl_sampel' => '0000-00-00',
              'jam_sampel' => '00:00:00',
              'tgl_hasil' => '0000-00-00',
              'jam_hasil' => '00:00:00',
              'dokter_perujuk' => $_POST['kode_perujuk'],
              'status' => 'Ranap'
            ]);
          $this->db('permintaan_pemeriksaan_lab')
=======
              'no_resep' => $no_resep,
              'tgl_perawatan' => '0000-00-00',
              'jam' => '00:00:00',
              'no_rawat' => $_POST['no_rawat'],
              'kd_dokter' => $_POST['kode_provider'],
              'tgl_peresepan' => $_POST['tgl_perawatan'],
              'jam_peresepan' => $_POST['jam_rawat'],
              'status' => 'ranap',
              'tgl_penyerahan' => '0000-00-00',
              'jam_penyerahan' => '00:00:00'
            ]);

          if ($this->db('resep_obat')->where('no_resep', $no_resep)->where('kd_dokter', $_POST['kode_provider'])->oneArray()) {
            $this->db('resep_dokter')
              ->save([
                'no_resep' => $no_resep,
                'kode_brng' => $_POST['kd_jenis_prw'],
                'jml' => $_POST['jml'],
                'aturan_pakai' => $_POST['aturan_pakai']
              ]);
          }

        } else {

          $no_resep = $cek_resep['no_resep'];

          $this->db('resep_dokter')
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
            ->save([
              'noorder' => $noorder,
              'kd_jenis_prw' => $_POST['kd_jenis_prw'],
              'stts_bayar' => 'Belum'
            ]);

<<<<<<< HEAD
        } else {
          $noorder = $cek_lab['noorder'];
          $this->db('permintaan_pemeriksaan_lab')
            ->save([
              'noorder' => $noorder,
              'kd_jenis_prw' => $_POST['kd_jenis_prw'],
              'stts_bayar' => 'Belum'
            ]);
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
        }
      }

      if($_POST['kat'] == 'radiologi') {
        $cek_rad = $this->db('permintaan_radiologi')->where('no_rawat', $_POST['no_rawat'])->where('tgl_permintaan', date('Y-m-d'))->oneArray();
        if(!$cek_rad) {
          $max_id = $this->db('permintaan_radiologi')->select(['noorder' => 'ifnull(MAX(CONVERT(RIGHT(noorder,4),signed)),0)'])->where('tgl_permintaan', date('Y-m-d'))->oneArray();
          if(empty($max_id['noorder'])) {
            $max_id['noorder'] = '0000';
          }
          $_next_noorder = sprintf('%04s', ($max_id['noorder'] + 1));
          $noorder = 'PR'.date('Ymd').''.$_next_noorder;

          $permintaan_rad = $this->db('permintaan_radiologi')
            ->save([
              'noorder' => $noorder,
              'no_rawat' => $_POST['no_rawat'],
              'tgl_permintaan' => $_POST['tgl_perawatan'],
              'jam_permintaan' => $_POST['jam_rawat'],
              'tgl_sampel' => '0000-00-00',
              'jam_sampel' => '00:00:00',
              'tgl_hasil' => '0000-00-00',
              'jam_hasil' => '00:00:00',
              'dokter_perujuk' => $_POST['kode_perujuk'],
              'status' => 'Ranap'
            ]);
          $this->db('permintaan_pemeriksaan_radiologi')
            ->save([
              'noorder' => $noorder,
              'kd_jenis_prw' => $_POST['kd_jenis_prw'],
              'stts_bayar' => 'Belum'
            ]);
            $this->db('diagnosa_pasien_klinis')
            ->save([
              'noorder' => $noorder,
              'klinis' => $_POST['diagnosa_klinis']
            ]);

        } else {
          $noorder = $cek_rad['noorder'];
          $this->db('permintaan_pemeriksaan_radiologi')
            ->save([
              'noorder' => $noorder,
              'kd_jenis_prw' => $_POST['kd_jenis_prw'],
              'stts_bayar' => 'Belum'
            ]);
             $this->db('diagnosa_pasien_klinis')
            ->save([
              'noorder' => $noorder,
              'klinis' => $_POST['diagnosa_klinis']
            ]);
        }
      }
    exit();
  }

   public function postHapusDetail()
  {
    if ($_POST['provider'] == 'rawat_inap_dr') {
      $this->db('rawat_inap_dr')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
    }
<<<<<<< HEAD
    if ($_POST['provider'] == 'rawat_inap_pr') {
      $this->db('rawat_inap_pr')
=======

    public function postHapusDetail()
    {
      if($_POST['provider'] == 'rawat_inap_dr') {
        $this->db('rawat_inap_dr')
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
<<<<<<< HEAD
=======
      }
      if($_POST['provider'] == 'rawat_inap_pr') {
        $this->db('rawat_inap_pr')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
      }
      if($_POST['provider'] == 'rawat_inap_drpr') {
        $this->db('rawat_inap_drpr')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
      }
      exit();
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    }
    if ($_POST['provider'] == 'rawat_inap_drpr') {
      $this->db('rawat_inap_drpr')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
    }
    exit();
  }

  public function postHapusResep()
  {
    if (isset($_POST['kd_jenis_prw'])) {
      $this->db('resep_dokter')
        ->where('no_resep', $_POST['no_resep'])
        ->where('kode_brng', $_POST['kd_jenis_prw'])
        ->delete();
    } else {
      $this->db('resep_obat')
        ->where('no_resep', $_POST['no_resep'])
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('tgl_peresepan', $_POST['tgl_peresepan'])
        ->where('jam_peresepan', $_POST['jam_peresepan'])
        ->delete();
    }

    exit();
  }

  public function postHapusLab()
    {

        $this->db('permintaan_pemeriksaan_lab')
        ->where('noorder', $_POST['noorder'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->delete();

        $ceklab = $this->db('permintaan_pemeriksaan_lab')->where('noorder', $_POST['noorder'])->oneArray();
        if (empty($ceklab) ){
        $this->db('permintaan_lab')
        ->where('noorder', $_POST['noorder'])
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('tgl_permintaan', $_POST['tgl_permintaan'])
        ->where('jam_permintaan', $_POST['jam_permintaan'])
        ->delete();
        }
      exit();
    }

         public function postHapusRad()
    {
<<<<<<< HEAD
        $this->db('permintaan_pemeriksaan_radiologi')
        ->where('noorder', $_POST['noorder'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->delete();

        $cekrad = $this->db('permintaan_pemeriksaan_radiologi')->where('noorder', $_POST['noorder'])->oneArray();
        if (empty($cekrad) ){
        $this->db('permintaan_radiologi')
        ->where('noorder', $_POST['noorder'])
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('tgl_permintaan', $_POST['tgl_permintaan'])
        ->where('jam_permintaan', $_POST['jam_permintaan'])
        ->delete();

         $this->db('diagnosa_pasien_klinis')
        ->where('noorder', $_POST['noorder'])
        ->where('klinis', $_POST['diagnosa_klinis'])
        ->delete();
        }
      exit();
    }

   public function anyRincian()
    {
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      $rows_rawat_inap_dr = $this->db('rawat_inap_dr')->where('no_rawat', $_POST['no_rawat'])->toArray();
      $rows_rawat_inap_pr = $this->db('rawat_inap_pr')->where('no_rawat', $_POST['no_rawat'])->toArray();
      $rows_rawat_inap_drpr = $this->db('rawat_inap_drpr')->where('no_rawat', $_POST['no_rawat'])->toArray();

      $jumlah_total = 0;
      $rawat_inap_dr = [];
      $rawat_inap_pr = [];
      $rawat_inap_drpr = [];
      $i = 1;

      if($rows_rawat_inap_dr) {
        foreach ($rows_rawat_inap_dr as $row) {
          $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $jumlah_total = $jumlah_total + $row['biaya_rawat'];
          $row['provider'] = 'rawat_inap_dr';
          $rawat_inap_dr[] = $row;
        }
      }

      if($rows_rawat_inap_pr) {
        foreach ($rows_rawat_inap_pr as $row) {
          $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $jumlah_total = $jumlah_total + $row['biaya_rawat'];
          $row['provider'] = 'rawat_inap_pr';
<<<<<<< HEAD
          $cek_role = $this->db('mlite_users')->where('username', $row['nip'])->oneArray();
          $row['role'] = $cek_role['role'];
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
          $rawat_inap_pr[] = $row;
        }
      }

      if($rows_rawat_inap_drpr) {
        foreach ($rows_rawat_inap_drpr as $row) {
          $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $jumlah_total = $jumlah_total + $row['biaya_rawat'];
          $row['provider'] = 'rawat_inap_drpr';
          $rawat_inap_drpr[] = $row;
        }
      }

      $rows = $this->db('resep_obat')
        ->join('dokter', 'dokter.kd_dokter=resep_obat.kd_dokter')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('resep_obat.status', 'ranap')
        ->toArray();
      $resep = [];
      $jumlah_total_resep = 0;
      foreach ($rows as $row) {
        $row['nomor'] = $i++;
        $row['resep_dokter'] = $this->db('resep_dokter')->join('databarang', 'databarang.kode_brng=resep_dokter.kode_brng')->where('no_resep', $row['no_resep'])->toArray();
        foreach ($row['resep_dokter'] as $value) {
          $value['dasar'] = $value['jml'] * $value['dasar'];
          $jumlah_total_resep += floatval($value['dasar']);
        }
        $resep[] = $row;
      }
<<<<<<< HEAD
    
     $rows_laboratorium = $this->db('permintaan_lab')->join('permintaan_pemeriksaan_lab', 'permintaan_pemeriksaan_lab.noorder=permintaan_lab.noorder')->where('no_rawat', $_POST['no_rawat'])->toArray();
      $jumlah_total_lab = 0;
      $laboratorium = [];

      if($rows_laboratorium) {
        foreach ($rows_laboratorium as $row) {
          $jns_perawatan = $this->db('jns_perawatan_lab')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $row['kelas'] = $jns_perawatan['kelas'];
          $row['total_byr'] = $jns_perawatan['total_byr'];
          $jumlah_total_lab += $jns_perawatan['total_byr'];
          $laboratorium[] = $row;
        }
      }

      $rows_radiologi = $this->db('permintaan_radiologi')->join('permintaan_pemeriksaan_radiologi', 'permintaan_pemeriksaan_radiologi.noorder=permintaan_radiologi.noorder')->where('no_rawat', $_POST['no_rawat'])->toArray();
      $jumlah_total_rad = 0;
      $radiologi = [];

      if($rows_radiologi) {
        foreach ($rows_radiologi as $row) {
          $jns_perawatan = $this->db('jns_perawatan_radiologi')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $row['kelas'] = $jns_perawatan['kelas'];
          $row['total_byr'] = $jns_perawatan['total_byr'];
          $jumlah_total_rad += $jns_perawatan['total_byr'];

          $klinis = $this->db('diagnosa_pasien_klinis')->where('noorder', $row['noorder'])->oneArray();
          $row['diagnosa_klinis'] = $klinis['klinis'];
          $radiologi[] = $row;
        }
      }
    
      echo $this->draw('rincian.html', [
        'rawat_inap_dr' => $rawat_inap_dr, 
        'rawat_inap_pr' => $rawat_inap_pr, 
        'rawat_inap_drpr' => $rawat_inap_drpr, 
        'jumlah_total' => $jumlah_total, 
        'jumlah_total_resep' => $jumlah_total_resep, 
        'resep' =>$resep,
        'laboratorium' => $laboratorium,
        'radiologi' => $radiologi,
        'jumlah_total_lab' => $jumlah_total_lab,
        'jumlah_total_rad' => $jumlah_total_rad,
        'no_rawat' => $_POST['no_rawat']]);
      exit();
   }

  public function anySoap()
  {

    $username = $this->core->getUserInfo('username', null, true);
    $prosedurs = $this->db('prosedur_pasien')
      ->where('no_rawat', $_POST['no_rawat'])
      ->asc('prioritas')
      ->toArray();
    $prosedur = [];
    foreach ($prosedurs as $row) {
      $icd9 = $this->db('icd9')->where('kode', $row['kode'])->oneArray();
      $row['nama'] = $icd9['deskripsi_panjang'];
      $prosedur[] = $row;
    }
    $diagnosas = $this->db('diagnosa_pasien')
      ->where('no_rawat', $_POST['no_rawat'])
      ->asc('prioritas')
      ->toArray();
    $diagnosa = [];
    foreach ($diagnosas as $row) {
      $icd10 = $this->db('penyakit')->where('kd_penyakit', $row['kd_penyakit'])->oneArray();
      $row['nama'] = $icd10['nm_penyakit'];
      $diagnosa[] = $row;
    }

    $i = 1;
    $row['nama_petugas'] = '';
    $row['departemen_petugas'] = '';
    $rows = $this->db('pemeriksaan_ralan')
      ->where('no_rawat', $_POST['no_rawat'])
      ->toArray();
    $result = [];
    foreach ($rows as $row) {
      $row['nomor'] = $i++;
      $row['nama_petugas'] = $this->core->getPegawaiInfo('nama', $row['nip']);
      $row['departemen_petugas'] = $this->core->getDepartemenInfo($this->core->getPegawaiInfo('departemen', $row['nip']));
      $row['bidang'] = $this->core->getPegawaiInfo('bidang', $row['nip']);
      $row['jbtn_petugas'] = $this->core->getPegawaiInfo('jbtn', $row['nip']);
      $result[] = $row;
    }

    $rows_ranap = $this->db('pemeriksaan_ranap')
    //  ->join('petugas', 'pemeriksaan_ranap.nip=petugas.nip')
      ->where('no_rawat', $_POST['no_rawat'])
      ->desc('tgl_perawatan')
      ->toArray();
    $result_ranap = [];
    foreach ($rows_ranap as $row) {
      $row['nomor'] = $i++;
      $row['nama_petugas'] = $this->core->getPegawaiInfo('nama', $row['nip']);
      $row['departemen_petugas'] = $this->core->getDepartemenInfo($this->core->getPegawaiInfo('departemen', $row['nip']));
      $row['bidang'] = $this->core->getPegawaiInfo('bidang', $row['nip']);
      $row['jbtn_petugas'] = $this->core->getPegawaiInfo('jbtn', $row['nip']);
      $result_ranap[] = $row;
    }

    echo $this->draw('soap.html', ['pemeriksaan' => $result, 'pemeriksaan_ranap' => $result_ranap, 'diagnosa' => $diagnosa, 'prosedur' => $prosedur, 'username' => $username]);
    exit();

  }

  public function postSaveSOAP()
  {
    $check_db = $this->db()->pdo()->query("SHOW COLUMNS FROM `pemeriksaan_ranap` LIKE 'evaluasi'");
    $check_db->execute();
    $check_db = $check_db->fetch();

    if ($check_db) {
      $_POST['nip'] = $this->core->getUserInfo('username', null, true);
      $_POST['verified_at'] = null;
    } else {
      unset($_POST['evaluasi']);
    }

    if (!$this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->oneArray()) {
      $this->db('pemeriksaan_ranap')->save($_POST);
    } else {
      $this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->save($_POST);
    }
    // echo json_encode($_POST);
    exit();
  }

  public function postHapusSOAP()
  {
    $this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->delete();
    exit();
  }

  public function anyLayanan()
  {
    $layanan = $this->db('jns_perawatan')
      ->where('status', '1')
      ->like('nm_perawatan', '%' . $_POST['layanan'] . '%')
      ->limit(10)
      ->toArray();
    echo $this->draw('layanan.html', ['layanan' => $layanan]);
    exit();
  }

  public function anyObat()
  {
    $obat = $this->db('databarang')
      ->join('gudangbarang', 'gudangbarang.kode_brng=databarang.kode_brng')
      ->where('status', '1')
      ->where('gudangbarang.kd_bangsal', $this->settings->get('farmasi.deporanap'))
      ->like('databarang.nama_brng', '%' . $_POST['obat'] . '%')
      ->limit(10)
      ->toArray();
    echo $this->draw('obat.html', ['obat' => $obat]);
    exit();
  }

  public function postAturanPakai()
  {

    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('master_aturan_pakai')->like('aturan', $key)->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li class="list-group-item link-class">' . $row["aturan"] . '</li>';
        }
      }
      echo $output;
    }

    exit();
  }

  public function anyLaboratorium()
    {
      $laboratorium = $this->db('jns_perawatan_lab')
        ->where('status', '1')
        ->like('nm_perawatan', '%'.$_POST['laboratorium'].'%')
        ->limit(10)
        ->toArray();
      echo $this->draw('laboratorium.html', ['laboratorium' => $laboratorium]);
=======
      echo $this->draw('rincian.html', ['rawat_inap_dr' => $rawat_inap_dr, 'rawat_inap_pr' => $rawat_inap_pr, 'rawat_inap_drpr' => $rawat_inap_drpr, 'jumlah_total' => $jumlah_total, 'jumlah_total_resep' => $jumlah_total_resep, 'resep' =>$resep, 'no_rawat' => $_POST['no_rawat']]);
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      exit();
    }

    public function anyRadiologi()
    {
      $radiologi = $this->db('jns_perawatan_radiologi')
        ->where('status', '1')
        ->like('nm_perawatan', '%'.$_POST['radiologi'].'%')
        ->limit(10)
        ->toArray();
      echo $this->draw('radiologi.html', ['radiologi' => $radiologi]);
      exit();
    }

  public function anyBerkasDigital()
  {
    $berkas_digital = $this->db('berkas_digital_perawatan')
     ->join('master_berkas_digital', 'master_berkas_digital.kode=berkas_digital_perawatan.kode')
    ->where('no_rawat', $_POST['no_rawat'])->toArray();
    echo $this->draw('berkasdigital.html', ['berkas_digital' => $berkas_digital]);
    exit();
  }

  public function postSaveBerkasDigital()
  {

    $dir    = $this->_uploads;
    $cntr   = 0;

    $image = $_FILES['file']['tmp_name'];
    $img = new \Systems\Lib\Image();
    $id = convertNorawat($_POST['no_rawat']);
    if ($img->load($image)) {
      $imgName = time() . $cntr++;
      $imgPath = $dir . '/' . $id . '_' . $imgName . '.' . $img->getInfos('type');
      $lokasi_file = 'pages/upload/' . $id . '_' . $imgName . '.' . $img->getInfos('type');
      $img->save($imgPath);
      $query = $this->db('berkas_digital_perawatan')->save(['no_rawat' => $_POST['no_rawat'], 'kode' => $_POST['kode'], 'lokasi_file' => $lokasi_file]);
      if ($query) {
        echo '<br><img src="' . WEBAPPS_URL . '/berkasrawat/' . $lokasi_file . '" width="150" />';
      }
    }

    exit();
  }

  public function anyHais()
  {

    $i = 1;
    $rows = $this->db('data_hais')
      ->where('no_rawat', $_POST['no_rawat'])
      ->toArray();

    $result = [];
    foreach ($rows as $row) {
      // $row = $rows;
      $row['nomor'] = $i++;

      $pasien = $this->db('reg_periksa')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->where('no_rawat', $row['no_rawat'])
        ->oneArray();

      $row['no_rkm_medis'] = $pasien['no_rkm_medis'];
      $row['nm_pasien'] = $pasien['nm_pasien'];

      $result[] = $row;
    }

    echo $this->draw('hais.html', ['hais' => $result]);
    exit();
  }

  public function postSaveHAIS()
  {
    $is_edit = $_POST['edit'];
    unset($_POST['edit']);
    if (!$this->db('data_hais')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->oneArray()) {
      $this->db('data_hais')->save($_POST);
    } else if ($is_edit) {
      $this->db('data_hais')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->save($_POST);
    }
    exit();
  }

  public function postHapusHAIS()
  {
    $this->db('data_hais')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->delete();
    exit();
  }


  public function anyDietPasien()
  {

    $i = 1;
    $rows = $this->db('detail_beri_diet')
      ->where('no_rawat', $_POST['no_rawat'])
      ->toArray();

    $result = [];
    foreach ($rows as $row) {
      // $row = $rows;
      $row['nomor'] = $i++;

      $pasien = $this->db('reg_periksa')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->where('no_rawat', $row['no_rawat'])
        ->oneArray();

      $row['nm_pasien'] = $pasien['nm_pasien'];

      
      //$this->db('kamar_inap')
        // ->where('no_rawat', $row['no_rawat'])
        // ->oneArray();
      $kamar_inap = $this->db('kamar_inap')
        ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
        ->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')
        ->where('no_rawat', $row['no_rawat'])
        ->oneArray();
      //$row['kd_kamar'] = $kamar_inap['kd_kamar'];
      $row['nm_bangsal'] = $kamar_inap['nm_bangsal'];


      $row['diagnosa'] = $this->db('diagnosa_pasien')
        ->select(['nm_penyakit' => 'penyakit.nm_penyakit'])
        ->join('penyakit', 'penyakit.kd_penyakit=diagnosa_pasien.kd_penyakit')
        ->where('no_rawat', $row['no_rawat'])
        ->asc('prioritas')
        ->toArray();

    //  $penyakit = $this->db('diagnosa_pasien') 
    //  ->join('penyakit', 'penyakit.kd_penyakit=diagnosa_pasien.kd_penyakit')
    //  ->where('no_rawat', $row['no_rawat'])
    //  ->oneArray();

    //  $row['nm_penyakit'] = $penyakit['nm_penyakit'];
      

      $diet = $this->db('diet')
        ->where('kd_diet', $row['kd_diet'])
        ->oneArray();
      $row['nama_diet'] = $diet['nama_diet'];

      $result[] = $row;
    }

    echo $this->draw('dietpasien.html', ['dietpasien' => $result]);
    exit();
  }


  public function postDiet()
  {

    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('diet')->like('nama_diet', $key)->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li data-id="' . $row['kd_diet'] . '" class="list-group-item link-class">' . $row["nama_diet"] . '</li>';
        }
      }
      echo $output;
    }

    exit();
  }

  public function postSaveDietPasien()
  {
    if (!$this->db('detail_beri_diet')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->where('waktu', $_POST['waktu'])->oneArray()) {
      $this->db('detail_beri_diet')->save($_POST);
    } else {
      $this->db('detail_beri_diet')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->where('waktu', $_POST['waktu'])->save($_POST);
    }
    exit();
  }

  public function postHapusDietPasien()
  {
    $this->db('detail_beri_diet')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->where('waktu', $_POST['waktu'])->delete();
    exit();
  }

  public function anyJadwalOperasi()
  {

    $i = 1;
    $rows = $this->db('booking_operasi')
      ->where('no_rawat', $_POST['no_rawat'])
      ->toArray();

    $result = [];
    foreach ($rows as $row) {
      // $row = $rows;
      $row['nomor'] = $i++;

      $pasien = $this->db('reg_periksa')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->where('no_rawat', $row['no_rawat'])
        ->oneArray();

      $row['no_rkm_medis'] = $pasien['no_rkm_medis'];
      $row['nm_pasien'] = $pasien['nm_pasien'];
      $row['umur'] = $pasien['umur'];
      $row['jk'] = $pasien['jk'];

      $kamar_inap = $this->db('kamar_inap')
       ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
       ->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')
       ->where('no_rawat', $row['no_rawat'])
       ->oneArray();
      $row['kd_kamar'] = $kamar_inap['kd_kamar'];
     // $row['nm_bangsal'] = $kamar_inap['nm_bangsal'];

      $row['diagnosa'] = $this->db('diagnosa_pasien')
        ->select(['nm_penyakit' => 'penyakit.nm_penyakit'])
        ->join('penyakit', 'penyakit.kd_penyakit=diagnosa_pasien.kd_penyakit')
        ->where('no_rawat', $row['no_rawat'])
        ->asc('prioritas')
        ->toArray();

      $dokter = $this->db('dokter')
        ->where('kd_dokter', $row['kd_dokter'])
        ->oneArray();
      $row['nm_dokter'] = $dokter['nm_dokter'];

      $paket_operasi = $this->db('paket_operasi')
        ->where('kode_paket', $row['kode_paket'])
        ->oneArray();
      $row['nm_perawatan'] = $paket_operasi['nm_perawatan'];

      $result[] = $row;
    }

    echo $this->draw('jadwaloperasi.html', ['jadwaloperasi' => $result]);
    exit();
  }


  public function postDokter()
  {

    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('dokter')->like('nm_dokter', $key)->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li data-id="' . $row['kd_dokter'] . '" class="list-group-item link-class">' . $row["nm_dokter"] . '</li>';
        }
      }
      echo $output;
    }

    exit();
  }

  public function postPaketOperasi()
  {

    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('paket_operasi')->like('nm_perawatan', $key)->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li data-id="' . $row['kode_paket'] . '" class="list-group-item link-class">' . $row["nm_perawatan"] . '</li>';
        }
      }
      echo $output;
    }

    exit();
  }

  public function postSaveJadwalOperasi()
  {
    $is_edit = $_POST['edit'];
    unset($_POST['edit']);
    if (!$this->db('booking_operasi')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->oneArray()) {
      $this->db('booking_operasi')->save($_POST);
    } else if ($is_edit) {
      $this->db('booking_operasi')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->save($_POST);
    }
    exit();
  }

  public function postHapusJadwalOperasi()
  {
    $this->db('booking_operasi')->where('no_rawat', $_POST['no_rawat'])->where('tanggal', $_POST['tanggal'])->delete();
    exit();
  }

  public function anyFormKerohanian()
  {
    $this->_addHeaderFiles();
    $i = 1;

    $this->getSelectBootstrap();
    $selectrohani = $this->getInfoJenisRoh();
    $this->anyKerohanian($_POST['no_rawat']);
    echo $this->draw('kerohanian.html', ['kerohanian' => $this->assign,'select33' => $selectrohani]);
    exit();
  }

  public function anyDisplayKerohanian()
  {
    $this->_addHeaderFiles();
    $i = 1;

    $this->getSelectBootstrap();
    $selectrohani = $this->getInfoJenisRoh();
    $this->anyKerohanian($_POST['no_rawat']);
    echo $this->draw('rohani.html', ['kerohanian' => $this->assign,'select33' => $selectrohani]);
    exit();
  }

  public function anyKerohanian($no_rawat)
  {
    $this->_addHeaderFiles();
    $i = 1;

    $rows = $this->db('permintaan_kerohanian')
      ->where('no_rawat', $no_rawat)
      ->toArray();

    $this->assign['list'] = [];
    foreach ($rows as $row) {
      $row['nomor'] = $i++;

      $pasien = $this->db('reg_periksa')
      ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
      ->where('no_rawat', $row['no_rawat'])
      ->oneArray();

      $row['nm_pasien'] = $pasien['nm_pasien'];

      $kamar_inap = $this->db('kamar_inap')
        ->where('no_rawat', $row['no_rawat'])
        ->oneArray();
      $row['kd_kamar'] = $kamar_inap['kd_kamar'];

      $petugas = $this->db('petugas')
        ->where('nip', $row['perujuk'])
        ->oneArray();
      $row['nama'] = $petugas['nama'];

      $row['ppk'] = $this->db('permintaan_pemeriksaan_kerohanian')
        ->select(['nama_rh' => 'jns_kerohanian.nama_rh'])
        ->join('jns_kerohanian', 'jns_kerohanian.kd_rh=permintaan_pemeriksaan_kerohanian.kd_rh')
        ->where('noorder', $row['noorder'])
        ->toArray();

      $this->assign['list'][] = $row;
    }
  }

  public function postSaveKerohanian()
  {
    $no_rawat = $_POST['no_rawat'];
    $noorder = $_POST['noorder'];
    $_POST['kd_rh'] = implode(',', $_POST['kd_rh']);
    $cek_noraw = $this->db('permintaan_kerohanian')->where('no_rawat',$no_rawat)->where('tgl_permintaan', $_POST['tgl_permintaan'])->oneArray();
    if (!$cek_noraw) {
      $max_id = $this->db('permintaan_kerohanian')->select(['noorder' => 'ifnull(MAX(CONVERT(RIGHT(noorder,4),signed)),0)'])->where('tgl_permintaan', date('Y-m-d'))->oneArray();
      if (empty($max_id['noorder'])) {
        $max_id['noorder'] = '0000';
      }
      $_next_noorder = sprintf('%04s', ($max_id['noorder'] + 1));
      $noorder = 'PRH' . date('Ymd') . '' . $_next_noorder;

      $this->db('permintaan_kerohanian')
        ->save([
          'noorder' => $noorder,
          'no_rawat' => $_POST['no_rawat'],
          'kd_kamar' => $_POST['kd_kamar'],
          'tgl_permintaan' => $_POST['tgl_permintaan'],
          'perujuk' => $_POST['perujuk'],
          'petugas' => $this->core->getUserInfo('username', null, true),
          'keterangan' => $_POST['keterangan']
        ]);

      $kd_rh = [];
      $kd_rh = explode(',', $_POST['kd_rh']);
      for ($i = 0; $i < count($kd_rh); $i++) {
        $this->db('permintaan_pemeriksaan_kerohanian')
          ->save([
            'noorder' => $noorder,
            'kd_rh' => $kd_rh[$i],
            'stts' => 'Belum'
          ]);
      }

      echo 200;
      // return $no_rawat;
    }
    exit();
  }

  public function postHapusKerohanian()
  {
    $this->db('permintaan_pemeriksaan_kerohanian')
      ->where('noorder', $_POST['noorder'])
      ->delete();

    $cek_noorder = $this->db('permintaan_pemeriksaan_kerohanian')
      ->where('noorder', $_POST['noorder'])
      ->oneArray();

    if (!$cek_noorder) {
      $this->db('permintaan_kerohanian')
        ->where('noorder', $_POST['noorder'])
        ->where('tgl_permintaan', $_POST['tgl_permintaan'])
        ->delete();
    }
    exit();
  }

  public function postPetugas()
  {
    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('petugas')->like('nama', $key)->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li data-id="' . $row['nip'] . '" class="list-group-item link-class">' . $row["nama"] . '</li>';
        }
      }
      echo $output;
    }
    exit();
  }

  public function postNoRoh()
  {
    $date = $_POST['tgl_permintaan'];
    $last_no_order = $this->db()->pdo()->prepare("SELECT ifnull(MAX(CONVERT(RIGHT(noorder,4),signed)),0) FROM permintaan_kerohanian WHERE tgl_permintaan = '$date'");
    $last_no_order->execute();
    $last_no_order = $last_no_order->fetch();
    if (empty($last_no_order[0])) {
      $last_no_order[0] = '0000';
    }
    $next_no_order = sprintf('%04s', ($last_no_order[0] + 1));
    $next_no_order = 'PRH' . date('Ymd') . '' . $next_no_order;

    echo $next_no_order;
    exit();
  }

  public function getInfoJenisRoh($kd_rh = null)
  {
    $result = [];
    $rows = $this->db()->pdo()->prepare("SELECT kd_rh, nama_rh FROM jns_kerohanian");
    //SELECT `kd_rh`, `nama_rh` FROM `jns_kerohanian`;
    $rows->execute();
    $rows = $rows->fetchAll();

    if (!$kd_rh) {
      $kd_rhArray = [];
    } else {
      $kd_rhArray = explode(',', $kd_rh);
    }

    foreach ($rows as $row) {
      if (empty($kd_rhArray)) {
        $attr = '';
      } else {
        if (in_array($row['kd_rh'], $kd_rhArray)) {
          $attr = 'selected';
        } else {
          $attr = '';
        }
      }
      $result[] = ['kd_rh' => $row['kd_rh'], 'nama_rh' => $row['nama_rh'], 'attr' => $attr];
    }
    return $result;
  }

  public function anySkriningCek()
  {
      $rows = $this->db('evaluasi_awal_mpp')
        ->where('no_rawat', $_POST['no_rawat'])
        ->toArray();

      $result = [];
      foreach ($rows as $row) {
        $pasien = $this->db('reg_periksa')
          ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
          ->where('no_rawat', $row['no_rawat'])
          ->oneArray();

        $row['no_rkm_medis'] = $pasien['no_rkm_medis'];
        $row['nm_pasien'] = $pasien['nm_pasien'];

        $kamar_inap = $this->db('kamar_inap')
          ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
          ->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')
          ->where('no_rawat', $row['no_rawat'])
          ->oneArray();

        $row['kd_kamar'] = $kamar_inap['kd_kamar'];

          $ceklist_skrining = explode(',', $row['skrining_ceklist']);

          $ceklist_skrining = array_filter($ceklist_skrining);

          $row['ceklist_skrining'] = $ceklist_skrining;

        $result[] = $row;
      }

    echo $this->draw('skriningceklist.html', ['skrining' => $result]);
    exit();
     
  }

  public function postSaveSkriningCek()
  {
    $data = isset($_POST['data']) ? $_POST['data'] : array();
    $no_rawat = $_POST['no_rawat'];
    $tanggal = date('Y-m-d');
    $skrining = implode(", ", $data);
    $catatan_skrining = isset($_POST['catatan_skrining']) ? $_POST['catatan_skrining'] : '';

<<<<<<< HEAD
    if (!empty($data)) {
      $jumlahCek = count($data);

      if (!$this->db('evaluasi_awal_mpp')->where('no_rawat', $_POST['no_rawat'])->oneArray()) {
        $query = $this->db('evaluasi_awal_mpp')
          ->save([
            'no_rawat' => $no_rawat,
            'tanggal' => $tanggal,
            'skrining_ceklist' => $skrining,
            'nilai_skrining' => $jumlahCek,
            'catatan_skrining' => ($jumlahCek < 7) ? $catatan_skrining : '',
            'petugas' => $this->core->getUserInfo('username', null, true)
          ]);
      } else {
        $query = $this->db('evaluasi_awal_mpp')
          ->where('no_rawat', $_POST['no_rawat'])
          ->save([
            'tanggal' => $tanggal,
            'skrining_ceklist' => $skrining,
            'nilai_skrining' => $jumlahCek,
            'catatan_skrining' => ($jumlahCek < 7) ? $catatan_skrining : '',
            'petugas' => $this->core->getUserInfo('username', null, true)
          ]);
      }

      if ($query) {
        $this->notify('success', 'Data Berhasil Update');
      } else {
        $this->notify('failure', 'Gagal Update');
=======
    public function postSaveSOAP()
    {
      $_POST['nip'] = $this->core->getUserInfo('username', null, true);

      if(!$this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->where('nip', $_POST['nip'])->oneArray()) {
        $this->db('pemeriksaan_ranap')->save($_POST);
      } else {
        $this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->where('nip', $_POST['nip'])->save($_POST);
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      }
    }
  }

  public function postCatatanSkrining()
  {
        $data = isset($_POST['data']) ? $_POST['data'] : array();
        $no_rawat = $_POST['no_rawat'];
        $tanggal = date('Y-m-d');
        $skrining = implode(", ", $data);
        $catatan_skrining = $_POST['catatan_skrining'];
        
      if (!empty($data)) {
      $jumlahCek = count($data);

      if (!$this->db('evaluasi_awal_mpp')->where('no_rawat', $_POST['no_rawat'])->oneArray()) {
        $query = $this->db('evaluasi_awal_mpp')
          ->save([
            'no_rawat' => $no_rawat,
            'tanggal' => $tanggal,
            'skrining_ceklist' => $skrining,
            'nilai_skrining' => $jumlahCek,
            'petugas' => $this->core->getUserInfo('username', null, true),
            'catatan_skrining' => $catatan_skrining
          ]);
      } else {
        $query = $this->db('evaluasi_awal_mpp')
          ->where('no_rawat', $_POST['no_rawat'])
          ->save([
            'tanggal' => $tanggal,
            'skrining_ceklist' => $skrining,
            'nilai_skrining' => $jumlahCek,
            'petugas' => $this->core->getUserInfo('username', null, true),
            'catatan_skrining' => $catatan_skrining
          ]);
      }

      if ($query) {
        $this->notify('success', 'Data Berhasil Update');
      } else {
        $this->notify('failure', 'Gagal Update');
      }
    } else {
      $this->notify('failure', 'Tidak ada data yang dipilih');
    }
    redirect(url([ADMIN, 'rawat_inap', 'skriningcek']));
  }

  public function anyOrthanc()
  {
      $rows = $this->db('reg_periksa')->where('no_rawat', $_POST['no_rawat'])->toArray();

      $result = [];
      foreach ($rows as $row) {
          $no_rawat = $row['no_rawat'];
          $norm = $row['no_rkm_medis'];

          $tgl1 = $this->db('periksa_radiologi')->where('no_rawat', $row['no_rawat'])->limit(1)->asc('tgl_periksa')->oneArray();
          $tanggal1 = str_replace("-", "", $tgl1['tgl_periksa']);


          $tgl2 = $this->db('periksa_radiologi')->where('no_rawat', $row['no_rawat'])->limit(1)->desc('tgl_periksa')->oneArray();
          $tanggal2 = str_replace("-", "", $tgl2['tgl_periksa']);

          $pacs = [];

          $arr = array(
              "Level" => "Study",
              "Expand" => true,
              "Query" => array(
                  "StudyDate" => $tanggal1 . "-" . $tanggal2,
                  "PatientID" => $norm
              )
          );

          $pacs['data'] = json_encode($arr);

          $url_orthanc = $this->settings->get('orthanc.server');
          $urlfind = $url_orthanc . '/tools/find';

          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $urlfind);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
          curl_setopt($curl, CURLOPT_USERPWD, $this->settings->get('orthanc.username') . ":" . $this->settings->get('orthanc.password'));
          curl_setopt($curl, CURLOPT_TIMEOUT, 30);
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $pacs['data']);
          $response = curl_exec($curl);
          curl_close($curl);

          $patient = json_decode($response, TRUE);

          if (isset($patient[0]["ID"])) {
             foreach ($patient as $study) {
              foreach ($study["Series"] as $series) {
                  $urlSeries = $url_orthanc . '/series/' . $series;

                  $curl = curl_init();
                  curl_setopt($curl, CURLOPT_URL, $urlSeries);
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                  curl_setopt($curl, CURLOPT_USERPWD, $this->settings->get('orthanc.username') . ":" . $this->settings->get('orthanc.password'));
                  $response = curl_exec($curl);
                  curl_close($curl);

                  $seriesData = json_decode($response, true);

                  $seriesDate = isset($seriesData['MainDicomTags']['SeriesDate']) ? $seriesData['MainDicomTags']['SeriesDate'] : "";
                  $acquisitionDescription = isset($seriesData['MainDicomTags']['AcquisitionDeviceProcessingDescription']) ? $seriesData['MainDicomTags']['AcquisitionDeviceProcessingDescription'] : "";

                  $instance = $seriesData['Instances'][0];
                  $imageURL = $url_orthanc . '/instances/' . $instance . '/preview';
                  $gambar = '';
                  foreach ($seriesData['Instances'] as $instance) {
                      $imageURL = $url_orthanc . '/instances/' . $instance . '/preview';
                      $gambar .= '<a href="' . $url_orthanc . '/web-viewer/app/viewer.html?series=' . $series . '" target="_blank">';
                      $gambar .= '<img src="' . $imageURL . '" alt="Image" style="width: 600px;">';
                      $gambar .= '</a><br><br><br>';
                    }
                }
                  $result[] = array(
                      'Tanggal' => date('d-m-Y', strtotime($seriesDate)),
                      'Deskripsi' => $acquisitionDescription,
                      'Gambar' => $gambar
                  );
              }
          } 
      }

      echo $this->draw('data.orthanc.html', ['pacs' => $result]);
      exit();
  }

   public function anyResume()
  {
      
      $no_rawat = $_GET['no_rawat'];
      $rows = $this->db('resume_pasien_ranap')
      ->where('no_rawat', $no_rawat)
      ->toArray();
      $result = [];
      foreach ($rows as $row) {

      $pasien = $this->db('reg_periksa')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
        ->where('no_rawat', $row['no_rawat'])
        ->oneArray();
      $row['no_rkm_medis'] = $pasien['no_rkm_medis'];
      $row['nm_pasien'] = $pasien['nm_pasien'];
      $row['tgl_lahir'] = date('d-m-Y', strtotime($pasien['tgl_lahir']));
      $row['png_jawab'] = $pasien['png_jawab'];

      $tgl_masuk = $this->db('kamar_inap')
        ->where('no_rawat', $row['no_rawat'])
        ->asc('tgl_masuk')
        ->oneArray();
      $row['tgl_masuk'] = date('d-m-Y', strtotime($tgl_masuk['tgl_masuk']));
      $row['jam_masuk'] = $tgl_masuk['jam_masuk'];

      $tgl_keluar = $this->db('kamar_inap')
        ->where('no_rawat', $row['no_rawat'])
        ->where('stts_pulang', '<>', 'Pindah Kamar')
        ->oneArray();
      $row['tgl_keluar'] = date('d-m-Y', strtotime($tgl_keluar['tgl_keluar']));
      $row['jam_keluar'] = $tgl_keluar['jam_keluar'];

      $kamar_inap = $this->db('kamar_inap')
        ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
        ->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')
        ->where('no_rawat', $row['no_rawat'])
        ->where('kamar_inap.stts_pulang', '<>', 'Pindah Kamar')
        ->oneArray();
      $row['nm_bangsal'] = $kamar_inap['nm_bangsal'];
      $row['kelas'] = $kamar_inap['kelas'];

      $dokter = $this->db('dokter')
        ->where('kd_dokter', $row['kd_dokter'])
        ->oneArray();
      $row['nm_dokter'] = $dokter['nm_dokter'];

      $skdp = $this->db('booking_registrasi')
         ->join('poliklinik', 'poliklinik.kd_poli=booking_registrasi.kd_poli')
        ->where('booking_registrasi.no_rkm_medis', $row['no_rkm_medis'])
        ->where('booking_registrasi.status', 'Belum')
        ->oneArray();
      $row['skdp'] = date('d-m-Y', strtotime($skdp['tanggal_periksa']));
      $row['poli'] = $skdp['nm_poli'];

          $result[] = $row;
    }
      echo $this->draw('resume.html', ['resume_pasien' => $result]);
      exit();
  }

  public function postProviderList()
  {

    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('dokter')->like('nm_dokter', $key)->where('status', '1')->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li class="list-group-item link-class">' . $row["kd_dokter"] . ': ' . $row["nm_dokter"] . '</li>';
        }
      }
      echo $output;
    }

    exit();
  }

  public function postProviderList2()
  {

    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('petugas')->like('nama', $key)->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li class="list-group-item link-class">' . $row["nip"] . ': ' . $row["nama"] . '</li>';
        }
      }
      echo $output;
    }

<<<<<<< HEAD
    exit();
  }

  public function postPerujukList()
  {

    if(isset($_POST["query"])){
      $output = '';
      $key = "%".$_POST["query"]."%";
      $rows = $this->db('dokter')->like('nm_dokter', $key)->where('status', '1')->limit(10)->toArray();
      $output = '';
      if(count($rows)){
        foreach ($rows as $row) {
          $output .= '<li class="list-group-item link-class">'.$row["kd_dokter"].': '.$row["nm_dokter"].'</li>';
        }
      }
      echo $output;
    }
    exit();
  }

  public function postProviderList3()
  {

    if (isset($_POST["query"])) {
      $output = '';
      $key = "%" . $_POST["query"] . "%";
      $rows = $this->db('mlite_users')->like('fullname', $key)->where('role', 'apoteker')->limit(10)->toArray();
      $output = '';
      if (count($rows)) {
        foreach ($rows as $row) {
          $output .= '<li class="list-group-item link-class">' . $row["username"] . ': ' . $row["fullname"] . '</li>';
        }
      }
      echo $output;
    }

    exit();
  }

  public function postMaxid()
  {
    $max_id = $this->db('reg_periksa')->select(['no_rawat' => 'ifnull(MAX(CONVERT(RIGHT(no_rawat,6),signed)),0)'])->where('tgl_registrasi', date('Y-m-d'))->oneArray();
    if (empty($max_id['no_rawat'])) {
      $max_id['no_rawat'] = '000000';
    }
    $_next_no_rawat = sprintf('%06s', ($max_id['no_rawat'] + 1));
    $next_no_rawat = date('Y/m/d') . '/' . $_next_no_rawat;
    echo $next_no_rawat;
    exit();
  }

  public function postMaxAntrian()
  {
    $max_id = $this->db('reg_periksa')->select(['no_reg' => 'ifnull(MAX(CONVERT(RIGHT(no_reg,3),signed)),0)'])->where('kd_poli', $_POST['kd_poli'])->where('tgl_registrasi', date('Y-m-d'))->desc('no_reg')->limit(1)->oneArray();
    if (empty($max_id['no_reg'])) {
      $max_id['no_reg'] = '000';
    }
    $_next_no_reg = sprintf('%03s', ($max_id['no_reg'] + 1));
    echo $_next_no_reg;
    exit();
  }

  public function convertNorawat($text)
  {
    setlocale(LC_ALL, 'en_EN');
    $text = str_replace('/', '', trim($text));
    return $text;
  }


    public function anyManage_RawatGabung()
  {
    $tgl_masuk = '';
    $tgl_masuk_akhir = '';
    $status_pulang = '';
    $nama_pegawai = '';
    $this->assign['stts_pulang'] = [];

    if (isset($_POST['periode_rawat_gabung'])) {
      $tgl_masuk = $_POST['periode_rawat_gabung'];
    }
    if (isset($_POST['periode_rawat_gabung_akhir'])) {
      $tgl_masuk_akhir = $_POST['periode_rawat_gabung_akhir'];
    }
    if (isset($_POST['status_pulang'])) {
      $status_pulang = $_POST['status_pulang'];
    }
    $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();

    $username = $this->core->getUserInfo('username', null, true);

    $master_berkas_digital = $this->db('master_berkas_digital')->toArray();
    
    $this->_DisplayRawatGabung($tgl_masuk, $tgl_masuk_akhir, $status_pulang);
    return $this->draw('manage.rawatgabung.html', [
      'rawat_gabung' => $this->assign, 
      'cek_vclaim' => $cek_vclaim, 
      'master_berkas_digital' => $master_berkas_digital, 
      'username' => $username
    ]);
  }

  public function anyDisplayRawatGabung()
  {
    $tgl_masuk = '';
    $tgl_masuk_akhir = '';
    $status_pulang = '';
    $this->assign['stts_pulang'] = [];

    if (isset($_POST['periode_rawat_gabung'])) {
      $tgl_masuk = $_POST['periode_rawat_gabung'];
    }
    if (isset($_POST['periode_rawat_gabung_akhir'])) {
      $tgl_masuk_akhir = $_POST['periode_rawat_gabung_akhir'];
    }
    if (isset($_POST['status_pulang'])) {
      $status_pulang = $_POST['status_pulang'];
    }
    $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();

    $username = $this->core->getUserInfo('username', null, true);

    $this->_DisplayRawatGabung($tgl_masuk, $tgl_masuk_akhir, $status_pulang);
    echo $this->draw('display.rawatgabung.html', ['rawat_gabung' => $this->assign, 'cek_vclaim' => $cek_vclaim, 'username' => $username]);
    exit();
  }

    public function _DisplayRawatGabung($tgl_masuk = '', $tgl_masuk_akhir = '', $status_pulang = '')
  {
    $this->_addHeaderFiles();

    $this->assign['kamar'] = $this->db('kamar')->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')->where('statusdata', '1')->toArray();
    $this->assign['dokter'] = $this->db('dokter')->where('status', '1')->toArray();
    $this->assign['penjab']   = $this->db('penjab')->where('status', '1')->toArray();
    $this->assign['no_rawat'] = '';

    $bangsal = str_replace(",", "','", $this->core->getUserInfo('cap', null, true));

    $sql = "SELECT 
            ranap_gabung.no_rawat2 AS no_rawat, 
            pasien.nm_pasien, 
            reg_periksa.no_rkm_medis,
            reg_periksa.kd_pj,
            pasien.no_peserta,
            penjab.png_jawab, 
            kamar_inap.kd_kamar, 
            kamar_inap.tgl_masuk,
            kamar_inap.jam_masuk,
            kamar_inap.jam_keluar,
            kamar_inap.tgl_keluar,
            kamar_inap.stts_pulang,
            kamar.kd_bangsal, 
            bangsal.nm_bangsal,
            dpjp_ranap.kd_dokter as dok
          FROM
            ranap_gabung,
            kamar_inap,
            reg_periksa,
            pasien,
            kamar,
            bangsal,
            penjab,
            dpjp_ranap
          WHERE
            ranap_gabung.no_rawat2 = reg_periksa.no_rawat
          AND
            ranap_gabung.no_rawat = kamar_inap.no_rawat
          AND
            reg_periksa.no_rkm_medis = pasien.no_rkm_medis
          AND
            kamar_inap.kd_kamar=kamar.kd_kamar
          AND
            bangsal.kd_bangsal=kamar.kd_bangsal
          AND
            reg_periksa.kd_pj = penjab.kd_pj
          AND
            dpjp_ranap.no_rawat = reg_periksa.no_rawat";

     $username = $this->core->getUserInfo('username', null, true);
    if (!in_array($this->core->getUserInfo('role'), ['admin', 'medis','apoteker', 'laboratorium', 'radiologi', 'manajemen', 'gizi', 'ppi/mpp', 'ok', 'paramedis'],  true)){
      $sql .= " AND bangsal.kd_bangsal IN ('$bangsal')";
    }
    if ($status_pulang == '') {
      $sql .= " AND kamar_inap.stts_pulang = '-'";
    }
    if ($status_pulang == 'all' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
      $sql .= " AND kamar_inap.stts_pulang = '-' AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
    }
    if ($status_pulang == 'masuk' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
      $sql .= " AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
    }
    if ($status_pulang == 'pulang' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
      $sql .= " AND kamar_inap.tgl_keluar BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
    }

    $stmt = $this->db()->pdo()->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $this->assign['list'] = [];
    foreach ($rows as $row) {
      $dpjp_ranap = $this->db('dpjp_ranap')
        ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
        ->where('no_rawat', $row['no_rawat'])
=======
    public function anyLayanan()
    {
      $layanan = $this->db('jns_perawatan_inap')
        ->where('status', '1')
        ->like('nm_perawatan', '%'.$_POST['layanan'].'%')
        ->limit(10)
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
        ->toArray();
      $row['dokter'] = $dpjp_ranap;
      $row['con_no_rawat'] = convertNorawat($row['no_rawat']);
      $this->assign['list'][] = $row;
    }

    if (isset($_POST['no_rawat'])) {
      $this->assign['kamar_inap'] = $this->db('kamar_inap')
        ->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
        ->join('dpjp_ranap', 'dpjp_ranap.no_rawat=kamar_inap.no_rawat')
        ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
        ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
        ->where('kamar_inap.no_rawat', $_POST['no_rawat'])
        ->oneArray();
    } else {
      $this->assign['kamar_inap'] = [
        'tgl_masuk' => date('Y-m-d'),
        'jam_masuk' => date('H:i:s'),
        'tgl_keluar' => date('Y-m-d'),
        'jam_keluar' => date('H:i:s'),
        'no_rkm_medis' => '',
        'nm_pasien' => '',
        'no_rawat' => '',
        'kd_dokter' => '',
        'kd_kamar' => '',
        'kd_pj' => '',
        'diagnosa_awal' => '',
        'diagnosa_akhir' => '',
        'stts_pulang' => '',
        'lama' => ''
      ];
    }
  }

  public function getJavascript()
  {
    header('Content-type: text/javascript');
    echo $this->draw(MODULES . '/rawat_inap/js/admin/rawat_inap.js');
    exit();
  }

  public function getSelectBootstrap()
  {

    $this->core->addCSS(url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css'));
    $this->core->addJS(url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js'));
  }

  private function _addHeaderFiles()
  {
    $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));
    $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'));
    $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'));
    $this->core->addJS(url('assets/jscripts/lightbox/lightbox.min.js'));
    $this->core->addCSS(url('assets/jscripts/lightbox/lightbox.min.css'));
    $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
    $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
    $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));
    $this->core->addJS(url([ADMIN, 'rawat_inap', 'javascript']), 'footer');
    $this->getSelectBootstrap();
    // $this->core->addJS(url([ADMIN, 'rawat_inap', 'selectbootstrap']), 'footer');
    // var_dump(url([ADMIN, 'rawat_inap', 'selectbootstrap'])); die;
  }

<<<<<<< HEAD
  protected function data_icd($table)
  {
    return new DB_ICD($table);
  }
}
=======
    public function anyBerkasDigital()
    {
      $berkas_digital = $this->db('berkas_digital_perawatan')->where('no_rawat', $_POST['no_rawat'])->toArray();
      echo $this->draw('berkasdigital.html', ['berkas_digital' => $berkas_digital]);
      exit();
    }

    public function postSaveBerkasDigital()
    {

      if(MULTI_APP) {

        $curl = curl_init();
        $filePath = $_FILES['file']['tmp_name'];

        curl_setopt_array($curl, array(
          CURLOPT_URL => str_replace('webapps','',WEBAPPS_URL).'api/berkasdigital',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('file'=> new \CURLFILE($filePath),'token' => $this->settings->get('api.berkasdigital_key'), 'no_rawat' => $_POST['no_rawat'], 'kode' => $_POST['kode']),
          CURLOPT_HTTPHEADER => array(),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $json = json_decode($response, true);
        if($json['status'] == 'Success') {
          echo '<br><img src="'.WEBAPPS_URL.'/berkasrawat/'.$json['msg'].'" width="150" />';
        } else {
          echo 'Gagal menambahkan gambar';
        }

      } else {      
        $dir    = $this->_uploads;
        $cntr   = 0;

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
              echo '<br><img src="'.WEBAPPS_URL.'/berkasrawat/'.$lokasi_file.'" width="150" />';
            }
        }
      }
      exit();

    }

    public function postProviderList()
    {

      if(isset($_POST["query"])){
        $output = '';
        $key = "%".$_POST["query"]."%";
        $rows = $this->db('dokter')->like('nm_dokter', $key)->where('status', '1')->limit(10)->toArray();
        $output = '';
        if(count($rows)){
          foreach ($rows as $row) {
            $output .= '<li class="list-group-item link-class">'.$row["kd_dokter"].': '.$row["nm_dokter"].'</li>';
          }
        }
        echo $output;
      }

      exit();

    }

    public function postProviderList2()
    {

      if(isset($_POST["query"])){
        $output = '';
        $key = "%".$_POST["query"]."%";
        $rows = $this->db('petugas')->like('nama', $key)->limit(10)->toArray();
        $output = '';
        if(count($rows)){
          foreach ($rows as $row) {
            $output .= '<li class="list-group-item link-class">'.$row["nip"].': '.$row["nama"].'</li>';
          }
        }
        echo $output;
      }

      exit();

    }

    public function postCekWaktu()
    {
      echo date('H:i:s');
      exit();
    }

    public function postMaxid()
    {
      $max_id = $this->db('reg_periksa')->select(['no_rawat' => 'ifnull(MAX(CONVERT(RIGHT(no_rawat,6),signed)),0)'])->where('tgl_registrasi', date('Y-m-d'))->oneArray();
      if(empty($max_id['no_rawat'])) {
        $max_id['no_rawat'] = '000000';
      }
      $_next_no_rawat = sprintf('%06s', ($max_id['no_rawat'] + 1));
      $next_no_rawat = date('Y/m/d').'/'.$_next_no_rawat;
      echo $next_no_rawat;
      exit();
    }

    public function postMaxAntrian()
    {
      $max_id = $this->db('reg_periksa')->select(['no_reg' => 'ifnull(MAX(CONVERT(RIGHT(no_reg,3),signed)),0)'])->where('kd_poli', $_POST['kd_poli'])->where('tgl_registrasi', date('Y-m-d'))->desc('no_reg')->limit(1)->oneArray();
      if(empty($max_id['no_reg'])) {
        $max_id['no_reg'] = '000';
      }
      $_next_no_reg = sprintf('%03s', ($max_id['no_reg'] + 1));
      echo $_next_no_reg;
      exit();
    }

    public function convertNorawat($text)
    {
        setlocale(LC_ALL, 'en_EN');
        $text = str_replace('/', '', trim($text));
        return $text;
    }

    public function getSepDetail($no_sep){
      $sep = $this->db('bridging_sep')->where('no_sep', $no_sep)->oneArray();
      $this->tpl->set('sep', $this->tpl->noParse_array(htmlspecialchars_array($sep)));

      $potensi_prb = $this->db('bpjs_prb')->where('no_sep', $no_sep)->oneArray();
      $data_sep['potensi_prb'] = $potensi_prb['prb'];
      echo $this->draw('sep.detail.html', ['data_sep' => $data_sep]);
      exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $cek_pegawai = $this->db('pegawai')->where('nik', $this->core->getUserInfo('username', $_SESSION['mlite_user']))->oneArray();
        $cek_role = '';
        if($cek_pegawai) {
          $cek_role = $this->core->getPegawaiInfo('nik', $this->core->getUserInfo('username', $_SESSION['mlite_user']));
        }
        echo $this->draw(MODULES.'/rawat_inap/js/admin/rawat_inap.js', ['cek_role' => $cek_role]);
        exit();
    }

    private function _addHeaderFiles()
    {
        $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));
        $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'));
        $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'));
        $this->core->addJS(url('assets/jscripts/lightbox/lightbox.min.js'));
        $this->core->addCSS(url('assets/jscripts/lightbox/lightbox.min.css'));
        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));
        $this->core->addJS(url([ADMIN, 'rawat_inap', 'javascript']), 'footer');
    }

    protected function data_icd($table)
    {
        return new DB_ICD($table);
    }

}
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
