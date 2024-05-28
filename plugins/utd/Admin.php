<?php

namespace Plugins\Utd;

use Systems\AdminModule;
use Plugins\Utd\DB_Wilayah;
<<<<<<< HEAD
use Systems\Lib\Fpdf\FPDF;
use Systems\Lib\Fpdf\PDF_MC_Table;
use Systems\Lib\Fpdf\PDF_Code128;
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

class Admin extends AdminModule
{

  public function navigation()
  {
      return [
          'Kelola'   => 'manage',
          'Data Pendonor' => 'pendonor',
          'Data Donor' => 'donor',
          'Stok Darah' => 'stokdarah',
          'Komponen Darah' => 'komponendarah'
      ];
  }

  public function getManage()
  {
    $sub_modules = [
      ['name' => 'Data Pendonor', 'url' => url([ADMIN, 'utd', 'pendonor']), 'icon' => 'group', 'desc' => 'Data Pendonor'],
      ['name' => 'Data Donor', 'url' => url([ADMIN, 'utd', 'donor']), 'icon' => 'heart', 'desc' => 'Data Donor'],
      ['name' => 'Stok Darah', 'url' => url([ADMIN, 'utd', 'stokdarah']), 'icon' => 'database', 'desc' => 'Data Donor'],
      ['name' => 'Komponen Darah', 'url' => url([ADMIN, 'utd', 'komponendarah']), 'icon' => 'clipboard', 'desc' => 'Komponen Donor'],
    ];
    return $this->draw('manage.html', ['sub_modules' => $sub_modules]);
  }

  public function getPendonor()
  {
    $this->_addHeaderFiles();
    $pendonor = $this->db('utd_pendonor')
      ->join('propinsi', 'propinsi.kd_prop=utd_pendonor.kd_prop')
      ->join('kabupaten', 'kabupaten.kd_kab=utd_pendonor.kd_kab')
      ->join('kecamatan', 'kecamatan.kd_kec=utd_pendonor.kd_kec')
      ->join('kelurahan', 'kelurahan.kd_kel=utd_pendonor.kd_kel')
      ->toArray();
    return $this->draw('data.pendonor.html', [
      'pendonor' => $pendonor,
      'nomor' => $this->setNoPendonor(),
      'waapitoken' => $this->settings->get('wagateway.token'),
      'waapiphonenumber' => $this->settings->get('wagateway.phonenumber')
    ]);
  }

  public function postSavePendonor()
  {
    if($_POST['simpan']) {
<<<<<<< HEAD
      $cek_nik = $this->db('utd_pendonor')->where('no_ktp', $_POST['no_ktp'])->oneArray();
      if ($cek_nik) {
        $this->notify('failure', 'Maaf, data pendonor sudah tersedia..!!');
        redirect(url([ADMIN, 'utd', 'pendonor']));
        return;
      }
      
      unset($_POST['simpan']);

=======
      unset($_POST['simpan']);
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      if(!$this->db('propinsi')->where('kd_prop', $_POST['kd_prop'])->oneArray()){
        $this->db('propinsi')->save(['kd_prop' => $_POST['kd_prop'], 'nm_prop' => $_POST['nm_prop']]);
      }
      if(!$this->db('kabupaten')->where('kd_kab', $_POST['kd_kab'])->oneArray()){
        $this->db('kabupaten')->save(['kd_kab' => $_POST['kd_kab'], 'nm_kab' => $_POST['nm_kab']]);
      }
      if(!$this->db('kecamatan')->where('kd_kec', $_POST['kd_kec'])->oneArray()){
        $this->db('kecamatan')->save(['kd_kec' => $_POST['kd_kec'], 'nm_kec' => $_POST['nm_kec']]);
      }
      if(!$this->db('kelurahan')->where('nm_kel', $_POST['nm_kel'])->oneArray()){
        $result = $this->db('kelurahan')->select('kd_kel')->desc('kd_kel')->limit(1)->oneArray();
        $_POST['kd_kel'] = $result['kd_kel'] + 1;
        $this->db('kelurahan')->save(['kd_kel' => $_POST['kd_kel'], 'nm_kel' => $_POST['nm_kel']]);
      }
      unset($_POST['nm_prop']);
      unset($_POST['nm_kab']);
      unset($_POST['nm_kec']);
      unset($_POST['nm_kel']);
<<<<<<< HEAD
      $_POST['nama'] = strtoupper($_POST['nama']); 
      $_POST['tmp_lahir'] = strtoupper($_POST['tmp_lahir']);
      $_POST['alamat'] = strtoupper($_POST['alamat']); 
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      $this->db('utd_pendonor')->save($_POST);
      $this->notify('success', 'Data pendonor telah disimpan');
    } else if ($_POST['update']) {
      $no_pendonor = $_POST['no_pendonor'];
      unset($_POST['update']);
      unset($_POST['no_pendonor']);
      if(!$this->db('propinsi')->where('kd_prop', $_POST['kd_prop'])->oneArray()){
        $this->db('propinsi')->save(['kd_prop' => $_POST['kd_prop'], 'nm_prop' => $_POST['nm_prop']]);
      }
      if(!$this->db('kabupaten')->where('kd_kab', $_POST['kd_kab'])->oneArray()){
        $this->db('kabupaten')->save(['kd_kab' => $_POST['kd_kab'], 'nm_kab' => $_POST['nm_kab']]);
      }
      if(!$this->db('kecamatan')->where('kd_kec', $_POST['kd_kec'])->oneArray()){
        $this->db('kecamatan')->save(['kd_kec' => $_POST['kd_kec'], 'nm_kec' => $_POST['nm_kec']]);
      }
      if(!$this->db('kelurahan')->where('nm_kel', $_POST['nm_kel'])->oneArray()){
        $result = $this->db('kelurahan')->select('kd_kel')->desc('kd_kel')->limit(1)->oneArray();
        $_POST['kd_kel'] = $result['kd_kel'] + 1;
        $this->db('kelurahan')->save(['kd_kel' => $_POST['kd_kel'], 'nm_kel' => $_POST['nm_kel']]);
      }
      unset($_POST['nm_prop']);
      unset($_POST['nm_kab']);
      unset($_POST['nm_kec']);
      unset($_POST['nm_kel']);
<<<<<<< HEAD
      $_POST['nama'] = strtoupper($_POST['nama']); 
      $_POST['tmp_lahir'] = strtoupper($_POST['tmp_lahir']);
      $_POST['alamat'] = strtoupper($_POST['alamat']); 
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      $this->db('utd_pendonor')
        ->where('no_pendonor', $no_pendonor)
        ->save($_POST);
      $this->notify('failure', 'Data pendonor telah diubah');
    }
    redirect(url([ADMIN, 'utd', 'pendonor']));
  }

<<<<<<< HEAD
//   public function postSavePendonor()
// {
//   if ($_POST['simpan']) {
//     unset($_POST['simpan']);
//     if (!$this->db('propinsi')->where('kd_prop', $_POST['kd_prop'])->oneArray()) {
//       $this->db('propinsi')->save(['kd_prop' => $_POST['kd_prop'], 'nm_prop' => $_POST['nm_prop']]);
//     }
//     if (!$this->db('kabupaten')->where('kd_kab', $_POST['kd_kab'])->oneArray()) {
//       $this->db('kabupaten')->save(['kd_kab' => $_POST['kd_kab'], 'nm_kab' => $_POST['nm_kab']]);
//     }
//     if (!$this->db('kecamatan')->where('kd_kec', $_POST['kd_kec'])->oneArray()) {
//       $this->db('kecamatan')->save(['kd_kec' => $_POST['kd_kec'], 'nm_kec' => $_POST['nm_kec']]);
//     }
//     if (!$this->db('kelurahan')->where('nm_kel', $_POST['nm_kel'])->oneArray()) {
//       $result = $this->db('kelurahan')->select('kd_kel')->desc('kd_kel')->limit(1)->oneArray();
//       $_POST['kd_kel'] = $result['kd_kel'] + 1;
//       $this->db('kelurahan')->save(['kd_kel' => $_POST['kd_kel'], 'nm_kel' => $_POST['nm_kel']]);
//     }
//     unset($_POST['nm_prop']);
//     unset($_POST['nm_kab']);
//     unset($_POST['nm_kec']);
//     unset($_POST['nm_kel']);
//     $saved = $this->db('utd_pendonor')->save($_POST);

//     if ($saved) {
//       $this->notify('success', 'Data pendonor telah disimpan');
//     } else {
//       // Data not saved, echo an error message
//       echo "Data not saved in the database.";
//       // Or you can use the following to log the error
//       // error_log('Error: Data pendonor failed to be saved.');
//       $this->notify('failure', 'Data pendonor failed to be saved.');
//     }
//   } else if ($_POST['update']) {
//     $no_pendonor = $_POST['no_pendonor'];
//     unset($_POST['update']);
//     unset($_POST['no_pendonor']);
//     if (!$this->db('propinsi')->where('kd_prop', $_POST['kd_prop'])->oneArray()) {
//       $this->db('propinsi')->save(['kd_prop' => $_POST['kd_prop'], 'nm_prop' => $_POST['nm_prop']]);
//     }
//     if (!$this->db('kabupaten')->where('kd_kab', $_POST['kd_kab'])->oneArray()) {
//       $this->db('kabupaten')->save(['kd_kab' => $_POST['kd_kab'], 'nm_kab' => $_POST['nm_kab']]);
//     }
//     if (!$this->db('kecamatan')->where('kd_kec', $_POST['kd_kec'])->oneArray()) {
//       $this->db('kecamatan')->save(['kd_kec' => $_POST['kd_kec'], 'nm_kec' => $_POST['nm_kec']]);
//     }
//     if (!$this->db('kelurahan')->where('nm_kel', $_POST['nm_kel'])->oneArray()) {
//       $result = $this->db('kelurahan')->select('kd_kel')->desc('kd_kel')->limit(1)->oneArray();
//       $_POST['kd_kel'] = $result['kd_kel'] + 1;
//       $this->db('kelurahan')->save(['kd_kel' => $_POST['kd_kel'], 'nm_kel' => $_POST['nm_kel']]);
//     }
//     unset($_POST['nm_prop']);
//     unset($_POST['nm_kab']);
//     unset($_POST['nm_kec']);
//     unset($_POST['nm_kel']);
//     $updated = $this->db('utd_pendonor')
//       ->where('no_pendonor', $no_pendonor)
//       ->save($_POST);

//     if ($updated) {
//       $this->notify('success', 'Data pendonor telah diubah');
//     } else {
//       // Data not updated, echo an error message
//       echo "Data not updated in the database.";
//       // Or you can use the following to log the error
//       // error_log('Error: Data pendonor failed to be updated.');
//       $this->notify('failure', 'Data pendonor failed to be updated.');
//     }
//   }

//   redirect(url([ADMIN, 'utd', 'pendonor']));
// }


=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
  public function getHapusPendonor($no_pendonor)
  {
    $this->db('utd_pendonor')
      ->where('no_pendonor', $no_pendonor)
      ->delete();
    redirect(url([ADMIN, 'utd', 'pendonor']));
  }

  public function postCetak()
  {
    $this->db()->pdo()->exec("DELETE FROM `mlite_temporary`");
    $cari = $_POST['cari'];
    $this->db()->pdo()->exec("INSERT INTO `mlite_temporary` (
      `temp1`,
      `temp2`,
      `temp3`,
      `temp4`,
      `temp5`,
      `temp6`,
      `temp7`,
      `temp8`,
      `temp9`,
      `temp10`,
      `temp11`,
      `temp12`,
      `temp13`,
      `temp14`
    )
    SELECT *
    FROM `utd_pendonor`
    WHERE (`no_pendonor` LIKE '%$cari%' OR `nama` LIKE '%$cari%' OR `alamat` LIKE '%$cari%')
    ");
<<<<<<< HEAD
=======

    $cetak = $this->db('mlite_temporary')->toArray();
    return $this->draw('cetak.utd.html', ['cetak' => $cetak]);
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    exit();
  }

  public function getCetakPendonor()
  {
<<<<<<< HEAD
    $tmp = $this->db('mlite_temporary')->toArray();
    $logo = $this->settings->get('settings.logo');

    $pdf = new PDF_MC_Table('L','mm','Legal');
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetTopMargin(10);
    $pdf->SetLeftMargin(10);
    $pdf->SetRightMargin(10);

    $pdf->Image('../'.$logo, 10, 8, '18', '18', 'png');
    $pdf->SetFont('Arial', '', 24);
    $pdf->Text(30, 16, $this->settings->get('settings.nama_instansi'));
    $pdf->SetFont('Arial', '', 10);
    $pdf->Text(30, 21, $this->settings->get('settings.alamat').' - '.$this->settings->get('settings.kota'));
    $pdf->Text(30, 25, $this->settings->get('settings.nomor_telepon').' - '.$this->settings->get('settings.email'));
    $pdf->Line(10, 30, 345, 30);
    $pdf->Line(10, 31, 345, 31);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Text(10, 40, 'DATA PENDONOR');
    $pdf->Ln(34);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetWidths(array(30,65,35,25,25,90,35,30));
    $pdf->Row(array('No. Pendonor','Nama Pasien','No. KTP','J. Kelamin','Tgl. Lahir','Alamat','G.Darah/Resus','No. Telp'));
    $pdf->SetFont('Arial', '', 10);
    foreach ($tmp as $hasil) {
      $j_kelamin = 'Laki-Laki';
      if($hasil['temp4'] == 'P') {
        $j_kelamin = 'Perempuan';
      }
      $pdf->Row(array($hasil['temp1'],$hasil['temp2'],$hasil['temp3'],$j_kelamin,$hasil['temp6'],$hasil['temp7'],$hasil['temp12'].' / '.$hasil['temp13'],$hasil['temp14']));
    }
    $pdf->Output('cetak'.date('Y-m-d').'.pdf','I');
  }

  // public function getDonor()
  // {
  //   $this->_addHeaderFiles();
  //   $donor = $this->db('utd_donor')
  //     ->join('utd_pendonor', 'utd_pendonor.no_pendonor=utd_donor.no_pendonor')
  //     ->join('kelurahan', 'kelurahan.kd_kel=utd_pendonor.kd_kel')
  //     ->join('kecamatan', 'kecamatan.kd_kec=utd_pendonor.kd_kec')
  //     ->join('kabupaten', 'kabupaten.kd_kab=utd_pendonor.kd_kab')
  //     ->join('propinsi', 'propinsi.kd_prop=utd_pendonor.kd_prop')
  //     ->toArray();
  //   $pendonor = $this->db('utd_pendonor')->toArray();
  //   $petugas = $this->db('petugas')->toArray();
  //   return $this->draw('data.donor.html', [
  //     'donor' => $donor, 
  //     'nomor' => $this->setNoDonor(),
  //     'pendonor' => $pendonor, 
  //     'petugas' => $petugas]);
  // }

  public function getDonor()
  {
    $this->_addHeaderFiles();

    $date = date('Y-m-d');

=======
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'orientation' => 'L'
    ]);

    $mpdf->SetHTMLHeader($this->core->setPrintHeader());
    $mpdf->SetHTMLFooter($this->core->setPrintFooter());
          
    $url = url('admin/tmp/cetak.utd.html');
    $html = file_get_contents($url);
    $mpdf->WriteHTML($this->core->setPrintCss(),\Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

    // Output a PDF file directly to the browser
    $mpdf->Output();
    exit();      

  }

  public function getDonor()
  {
    $this->_addHeaderFiles();
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    $donor = $this->db('utd_donor')
      ->join('utd_pendonor', 'utd_pendonor.no_pendonor=utd_donor.no_pendonor')
      ->join('kelurahan', 'kelurahan.kd_kel=utd_pendonor.kd_kel')
      ->join('kecamatan', 'kecamatan.kd_kec=utd_pendonor.kd_kec')
      ->join('kabupaten', 'kabupaten.kd_kab=utd_pendonor.kd_kab')
      ->join('propinsi', 'propinsi.kd_prop=utd_pendonor.kd_prop')
<<<<<<< HEAD
      ->where('utd_donor.tanggal', $date)
      ->toArray();
    $pendonor = $this->db('utd_pendonor')->toArray();
    $petugas = $this->db('petugas')->toArray();
    return $this->draw('data.donor.html', [
      'donor' => $donor, 
      'nomor' => $this->setNoDonor(),
      'pendonor' => $pendonor, 
      'petugas' => $petugas]);
  }

 public function postDonor()
{
    $this->_addHeaderFiles();
    // $this->core->addCSS(url('https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css'));
    // $this->core->addJS(url('https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js'), 'footer');
    // $this->core->addJS(url('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'), 'footer');
    // $this->core->addJS(url('https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js'), 'footer');
    // $this->core->addJS(url('https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js'), 'footer');
    // $this->core->addJS(url('https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js'), 'footer');

    if (isset($_POST['submit'])) {

        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];

        if (!empty($date1) && !empty($date2)) {
            // $sql = "SELECT * FROM utd_donor WHERE tanggal BETWEEN '$date1' AND '$date2'";
              $sql = "SELECT * FROM utd_donor, utd_pendonor, kelurahan, kecamatan, kabupaten, propinsi 
               WHERE utd_pendonor.no_pendonor=utd_donor.no_pendonor
               AND kelurahan.kd_kel=utd_pendonor.kd_kel
               AND kecamatan.kd_kec=utd_pendonor.kd_kec
               AND kabupaten.kd_kab=utd_pendonor.kd_kab
               AND propinsi.kd_prop=utd_pendonor.kd_prop
               AND utd_donor.tanggal BETWEEN '$date1' AND '$date2'";
            
            // $query =  $this->db('utd_donor')
            // ->join('utd_pendonor', 'utd_pendonor.no_pendonor=utd_donor.no_pendonor')
            // ->join('kelurahan', 'kelurahan.kd_kel=utd_pendonor.kd_kel')
            // ->join('kecamatan', 'kecamatan.kd_kec=utd_pendonor.kd_kec')
            // ->join('kabupaten', 'kabupaten.kd_kab=utd_pendonor.kd_kab')
            // ->join('propinsi', 'propinsi.kd_prop=utd_pendonor.kd_prop')
            //   // ->whereBetween('utd_donor.tanggal', [$date1, $date2])
            //  // ->where('utd_donor.tanggal', $date1)
            //  // ->where('utd_donor.tanggal', $date2)
            //  ->toArray();
        $stmt = $this->db()->pdo()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

            $this->assign['donor'] = $rows;
        } else {
            $this->assign['donor'] = $this->getDonor()['donor'];
        }
    }

    $pendonor = $this->db('utd_pendonor')->toArray();
    $petugas = $this->db('petugas')->toArray();
    return $this->draw('data.donor.html', [
        'donor' => $this->assign['donor'], 
        'nomor' => $this->setNoDonor(),
        'pendonor' => $pendonor, 
        'petugas' => $petugas
    ]);
}



  //  public function postDonor()
  // {
  //   $this->_addHeaderFiles();

  //   if (isset($_POST['submit'])) {
  //     // $date1 = $_POST['date1'];
  //     // $date2 = $_POST['date2'];


  //       $tgl_kunjungan = date('Y-m-d');
  //       $tgl_kunjungan_akhir = date('Y-m-d');
  //       // $status_periksa = '';
  //       // $status_bayar = '';

  //       if (isset($_GET['awal'])) {
  //           $tgl_kunjungan = $_GET['awal'];
  //       }
  //       if (isset($_GET['akhir'])) {
  //           $tgl_kunjungan_akhir = $_GET['akhir'];
  //       }


  //     if (!empty($date1) && !empty($date2)) {
  //       $sql = "SELECT * 
  //           FROM utd_donor, utd_pendonor, kelurahan, kecamatan, kabupaten, propinsi 
  //           WHERE utd_pendonor.no_pendonor=utd_donor.no_pendonor
  //           AND kelurahan.kd_kel=utd_pendonor.kd_kel
  //           AND kecamatan.kd_kec=utd_pendonor.kd_kec
  //           AND kabupaten.kd_kab=utd_pendonor.kd_kab
  //           AND propinsi.kd_prop=utd_pendonor.kd_prop
  //           AND utd_donor.tanggal BETWEEN '$date1' AND '$date2' 
  //           GROUP BY utd_donor.tanggal";

  //       $stmt = $this->db()->pdo()->prepare($sql);
  //       $stmt->execute();
  //       $rows = $stmt->fetchAll();

  //       $this->assign['list'] = [];
  //       foreach ($rows as $row) {
  //         $this->assign['list'][] = $row;
  //       }
  //     } else {
  //       $this->getDonor();
  //     }
  //   }
  //   return $this->draw('data.donor.html', [
  //     'donor' => $this->assign]);
  // }

  //   public function getPendonor()
  // {
  //   $this->_addHeaderFiles();
  //   $pendonor = $this->db('utd_pendonor')
  //     ->join('propinsi', 'propinsi.kd_prop=utd_pendonor.kd_prop')
  //     ->join('kabupaten', 'kabupaten.kd_kab=utd_pendonor.kd_kab')
  //     ->join('kecamatan', 'kecamatan.kd_kec=utd_pendonor.kd_kec')
  //     ->join('kelurahan', 'kelurahan.kd_kel=utd_pendonor.kd_kel')
  //     ->toArray();
  //   return $this->draw('data.pendonor.html', [
  //     'pendonor' => $pendonor,
  //     'nomor' => $this->setNoPendonor(),
  //     'waapitoken' => $this->settings->get('wagateway.token'),
  //     'waapiphonenumber' => $this->settings->get('wagateway.phonenumber')
  //   ]);
  // }



public function postSaveDonor()
{
    if ($_POST['simpan']) {
        // $cek_date = new \DateTime($_POST['tanggal']);
        //  if ($cek_date->format('Y-m-d') != date('Y-m-d')) {
        //         $this->notify('failure', 'Mohon maaf, tanggal tidak sesuai dengan hari ini');
        //         redirect(url([ADMIN, 'utd', 'donor']));
        //         return;
        // }
        $cek_jk = $this->db('utd_pendonor')->select('jk')->where('no_pendonor', $_POST['no_pendonor'])->oneArray();
        $tgl_donor_akhir = $this->db('utd_donor')->select('tanggal')->where('no_pendonor', $_POST['no_pendonor'])->desc('tanggal')->limit(1)->oneArray();
        
        // Mengecek apakah ada data donor sebelum memeriksa jenis kelamin dan selisih tanggal
        if (!$tgl_donor_akhir) {
            // Jika tidak ada data donor, langsung simpan
            unset($_POST['simpan']);
            $this->db('utd_donor')->save($_POST);
            $this->notify('success', 'Data donor telah disimpan');
        } else {
            // Menghitung selisih hari antara tanggal donor terakhir dan hari ini
            $tanggal_sekarang = new \DateTime(date('Y-m-d'));
            $tanggal_donor_terakhir = new \DateTime($tgl_donor_akhir['tanggal']);
            $interval = $tanggal_sekarang->diff($tanggal_donor_terakhir);
            $jumlah_hari = $interval->days;

            if ($cek_jk['jk'] == 'P') {
                if ($jumlah_hari <= 90) {
                    $confirmation = $this->notify('failure','Maaf, tidak bisa simpan karena terakhir donor kurang dari 90 hari');
                    if (!$confirmation) {
                        redirect(url([ADMIN, 'utd', 'donor']));
                        return;
                    }
                }
            } elseif ($cek_jk['jk'] == 'L') {
                if ($jumlah_hari <= 65) {
                    $confirmation = $this->notify('failure','Maaf, tidak bisa simpan karena terakhir donor kurang dari 65 hari');
                    if (!$confirmation) {
                        redirect(url([ADMIN, 'utd', 'donor']));
                        return;
                    }
                }
            }

            unset($_POST['simpan']);
            $this->db('utd_donor')->save($_POST);
            $this->notify('success', 'Data donor telah disimpan');
        }
    } else if ($_POST['update']) {
        $no_donor = $_POST['no_donor'];
        unset($_POST['update']);
        unset($_POST['no_donor']);
        $this->db('utd_donor')
            ->where('no_donor', $no_donor)
            ->save($_POST);
        $this->notify('failure', 'Data donor telah diubah');
    }
    redirect(url([ADMIN, 'utd', 'donor']));
}

// public function postSaveDonor()
// {
//     if ($_POST['simpan']) {
//         $cek_jk = $this->db('utd_pendonor')->select('jk')->where('no_pendonor', $_POST['no_pendonor'])->oneArray();
//         $tgl_donor_akhir = $this->db('utd_donor')->select('tanggal')->where('no_pendonor', $_POST['no_pendonor'])->desc('tanggal')->limit(1)->oneArray();

//         // Mengecek apakah ada data donor sebelum memeriksa jenis kelamin dan selisih tanggal
//         if (!$tgl_donor_akhir) {
//             // Jika tidak ada data donor, langsung simpan
//             unset($_POST['simpan']);
//             $this->db('utd_donor')->save($_POST);
//             $this->notify('success', 'Data donor telah disimpan');
//         } else {
//             // Menghitung selisih hari antara tanggal donor terakhir dan hari ini
//             $tanggal_sekarang = new \DateTime(date('Y-m-d'));
//             $tanggal_donor_terakhir = new \DateTime($tgl_donor_akhir['tanggal']);
//             $interval = $tanggal_sekarang->diff($tanggal_donor_terakhir);
//             $jumlah_hari = $interval->days;

//             if ($cek_jk['jk'] == 'P') {
//                 if ($jumlah_hari <= 90) {
//                     $confirmation = $this->notify('failure','Maaf, tidak bisa simpan karena terakhir donor kurang dari 90 hari');
//                     if (!$confirmation) {
//                         redirect(url([ADMIN, 'utd', 'donor']));
//                         return;
//                     }
//                 }
//             } elseif ($cek_jk['jk'] == 'L') {
//                 if ($jumlah_hari <= 65) {
//                     $confirmation = $this->notify('failure','Maaf, tidak bisa simpan karena terakhir donor kurang dari 65 hari');
//                     if (!$confirmation) {
//                         redirect(url([ADMIN, 'utd', 'donor']));
//                         return;
//                     }
//                 }
//             }

//             unset($_POST['simpan']);
//             $this->db('utd_donor')->save($_POST);
//             $this->notify('success', 'Data donor telah disimpan');
//         }
//     } else if ($_POST['update']) {
//         $no_donor = $_POST['no_donor'];
//         unset($_POST['update']);
//         unset($_POST['no_donor']);
//         $this->db('utd_donor')
//             ->where('no_donor', $no_donor)
//             ->save($_POST);
//         $this->notify('failure', 'Data donor telah diubah');
//     }
//     redirect(url([ADMIN, 'utd', 'donor']));
// }

  // public function postSaveDonor()
  // {
  //   if($_POST['simpan']) {
  //     unset($_POST['simpan']);
  //     $this->db('utd_donor')->save($_POST);
  //     $this->notify('success', 'Data donor telah disimpan');
  //   } else if ($_POST['update']) {
  //     $no_donor = $_POST['no_donor'];
  //     unset($_POST['update']);
  //     unset($_POST['no_donor']);
  //     $this->db('utd_donor')
  //       ->where('no_donor', $no_donor)
  //       ->save($_POST);
  //     $this->notify('failure', 'Data donor telah diubah');
  //   }
  //   redirect(url([ADMIN, 'utd', 'donor']));
  // }
=======
      ->toArray();
    $pendonor = $this->db('utd_pendonor')->toArray();
    $petugas = $this->db('petugas')->toArray();
    return $this->draw('data.donor.html', ['donor' => $donor, 'pendonor' => $pendonor, 'petugas' => $petugas]);
  }

  public function postSaveDonor()
  {
    if($_POST['simpan']) {
      unset($_POST['simpan']);
      $this->db('utd_donor')->save($_POST);
      $this->notify('success', 'Data donor telah disimpan');
    } else if ($_POST['update']) {
      $no_donor = $_POST['no_donor'];
      unset($_POST['update']);
      unset($_POST['no_donor']);
      $this->db('utd_donor')
        ->where('no_donor', $no_donor)
        ->save($_POST);
      $this->notify('failure', 'Data donor telah diubah');
    }
    redirect(url([ADMIN, 'utd', 'donor']));
  }
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

  public function getHapusDonor($no_donor)
  {
    $this->db('utd_donor')
      ->where('no_donor', $no_donor)
      ->delete();
    redirect(url([ADMIN, 'utd', 'donor']));
  }

  public function getStokDarah()
  {
    $this->_addHeaderFiles();
<<<<<<< HEAD

=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    $stokdarah = $this->db('utd_stok_darah')
      ->join('utd_komponen_darah', 'utd_komponen_darah.kode=utd_stok_darah.kode_komponen')
      ->toArray();
    $komponendarah = $this->db('utd_komponen_darah')->toArray();
<<<<<<< HEAD
    $donor = $this->db('utd_donor')->join('utd_pendonor', 'utd_pendonor.no_pendonor=utd_donor.no_pendonor')->where('utd_donor.tanggal', date('Y-m-d'))->toArray();
    return $this->draw('stok.darah.html', [
      'stokdarah' => $stokdarah, 
      'komponendarah' => $komponendarah,
      'donor' => $donor,]);
=======
    return $this->draw('stok.darah.html', ['stokdarah' => $stokdarah, 'komponendarah' => $komponendarah]);
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
  }

  public function postSaveStokDarah()
  {
    if($_POST['simpan']) {
      unset($_POST['simpan']);
      $this->db('utd_stok_darah')->save($_POST);
      $this->notify('success', 'Data stok darah telah disimpan');
    } else if ($_POST['update']) {
      $no_kantong = $_POST['no_kantong'];
      unset($_POST['update']);
      unset($_POST['no_kantong']);
      $this->db('utd_stok_darah')
        ->where('no_kantong', $no_kantong)
        ->save($_POST);
      $this->notify('failure', 'Data stok darah telah diubah');
    }
    redirect(url([ADMIN, 'utd', 'stokdarah']));
  }

  public function getHapusStokDarah($no_kantong)
  {
    $this->db('utd_stok_darah')
      ->where('no_kantong', $no_kantong)
      ->delete();
    redirect(url([ADMIN, 'utd', 'stokdarah']));
  }

<<<<<<< HEAD
//   public function postlama()
// {
//     $kodeKomponen = $_POST['kode_komponen'];

//     $lama = $this->db('utd_komponen_darah')->select('lama')->where('kode', $kodeKomponen)->oneArray();

//     if ($lama) {
//         echo $lama['lama'];
//     } else {
//         echo 'Kode komponen tidak valid';
//     }
// }
public function postlama()
{
    $kodeKomponen = $_POST['kode_komponen'];

    $lama = $this->db('utd_komponen_darah')->select('lama')->where('kode', $kodeKomponen)->oneArray();

    if ($lama) {
        echo json_encode(array('lama' => $lama['lama']));
    } else {
        echo json_encode(array('lama' => 'Kode komponen tidak valid'));
    }
    exit();
}



  // public function getKomponenDarah()
  // {
  //   $this->_addHeaderFiles();
  //   $komponendarah = $this->db('utd_komponen_darah')
  //     ->toArray();
  //   return $this->draw('komponen.darah.html', [
  //     'kode' => $this->setKodeKomponenDarah(),
  //     'komponendarah' => $komponendarah]);
  // }

  // public function postSaveKomponenDarah()
  // {
  //   if($_POST['simpan']) {
  //     unset($_POST['simpan']);
  //     $this->db('utd_komponen_darah')->save($_POST);
  //     $this->notify('success', 'Data komponen darah telah disimpan');
  //   } else if ($_POST['update']) {
  //     $kode = $_POST['kode'];
  //     unset($_POST['update']);
  //     unset($_POST['kode']);
  //     $this->db('utd_komponen_darah')
  //       ->where('kode', $kode)
  //       ->save($_POST);
  //     $this->notify('failure', 'Data komponen darah telah diubah');
  //   }
  //   redirect(url([ADMIN, 'utd', 'komponendarah']));
  // }

   public function getKomponenDarah()
=======
  public function getKomponenDarah()
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
  {
    $this->_addHeaderFiles();
    $komponendarah = $this->db('utd_komponen_darah')
      ->toArray();
    return $this->draw('komponen.darah.html', ['komponendarah' => $komponendarah]);
  }

  public function postSaveKomponenDarah()
  {
    if($_POST['simpan']) {
      unset($_POST['simpan']);
      $this->db('utd_komponen_darah')->save($_POST);
      $this->notify('success', 'Data komponen darah telah disimpan');
    } else if ($_POST['update']) {
      $kode = $_POST['kode'];
      unset($_POST['update']);
      unset($_POST['kode']);
      $this->db('utd_komponen_darah')
        ->where('kode', $kode)
        ->save($_POST);
      $this->notify('failure', 'Data komponen darah telah diubah');
    }
    redirect(url([ADMIN, 'utd', 'komponendarah']));
  }

  public function getHapusKomponenDarah($kode)
  {
    $this->db('utd_komponen_darah')
      ->where('kode', $kode)
      ->delete();
    redirect(url([ADMIN, 'utd', 'komponendarah']));
  }

  public function anyWilayah()
  {
    $show = isset($_GET['show']) ? $_GET['show'] : "";
    switch($show){
      default:
      break;
      case "caripropinsi":
        if(isset($_POST["query"])){
          $output = '';
          $key = "%".$_POST["query"]."%";
<<<<<<< HEAD
          $rows = $this->db('propinsi')->like('nm_prop', $key)->asc('kd_prop')->limit(10)->toArray();
=======
          $rows = $this->data_wilayah('propinsi')->like('nm_prop', $key)->asc('kd_prop')->limit(10)->toArray();
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
          $output = '';
          if(count($rows)){
            foreach ($rows as $row) {
              $output .= '<li class="list-group-item link-class">'.$row["kd_prop"].': '.$row["nm_prop"].'</li>';
            }
          }
          echo $output;
        }
      break;
      case "carikabupaten":
        if(isset($_POST["query"])){
          $output = '';
          $key = "%".$_POST["query"]."%";
<<<<<<< HEAD
          $rows = $this->db('kabupaten')->like('nm_kab', $key)->asc('kd_kab')->limit(10)->toArray();
=======
          $rows = $this->data_wilayah('kabupaten')->like('nm_kab', $key)->asc('kd_kab')->limit(10)->toArray();
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
          $output = '';
          if(count($rows)){
            foreach ($rows as $row) {
              $output .= '<li class="list-group-item link-class">'.$row["kd_kab"].': '.$row["nm_kab"].'</li>';
            }
          }
          echo $output;
        }
      break;
      case "carikecamatan":
        if(isset($_POST["query"])){
          $output = '';
          $key = "%".$_POST["query"]."%";
<<<<<<< HEAD
          $rows = $this->db('kecamatan')->like('nm_kec', $key)->asc('kd_kec')->limit(10)->toArray();
=======
          $rows = $this->data_wilayah('kecamatan')->like('nm_kec', $key)->asc('kd_kec')->limit(10)->toArray();
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
          $output = '';
          if(count($rows)){
            foreach ($rows as $row) {
              $output .= '<li class="list-group-item link-class">'.$row["kd_kec"].': '.$row["nm_kec"].'</li>';
            }
          }
          echo $output;
        }
      break;
      case "carikelurahan":
        if(isset($_POST["query"])){
          $output = '';
          $key = "%".$_POST["query"]."%";
          $rows = $this->db('kelurahan')->like('nm_kel', $key)->asc('kd_kel')->limit(10)->toArray();
          $output = '';
          if(count($rows)){
            foreach ($rows as $row) {
              $output .= '<li class="list-group-item link-class">'.$row["kd_kel"].': '.$row["nm_kel"].'</li>';
            }
          }
          echo $output;
        }
      break;
    }
    exit();
  }

<<<<<<< HEAD
    public function getKartuDonor($no_pendonor)
  {
      $data_pendonor = $this->db('utd_pendonor')->where('no_pendonor', $no_pendonor)->toArray();

      $nama_pendonor = $data_pendonor[0]['nama'];
      $golongan_darah = $data_pendonor[0]['golongan_darah'];
      $resus = $data_pendonor[0]['resus'];

      $pdf = new PDF_Code128('L', 'mm', array(59, 98));
      $pdf->AddPage();
      $pdf->SetFont('Arial', '', 10);

      $pdf->Code128(45, 40, $no_pendonor, 40, 15, 'R');
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->SetXY(8, 0);

      $pdf->Cell(0, 10, $nama_pendonor, 0, 2, 'R');
      $pdf->Cell(0, 10, $golongan_darah .' '.  $resus , 0, 2, 'R');
      $pdf->Cell(0, 10, $no_pendonor, 0, 2, 'R');

      $pdf->Output('kartudonor_' . $no_pendonor . '.pdf', 'I');
  }





  // public function getKartuDonor($no_pendonor)
  // {
  //     $pdf=new PDF_Code128('L', 'mm', array(59,98));
  //     $pdf->AddPage();
  //     $pdf->SetFont('Arial','',10);
  //     $pdf->Code128(9,35,$no_pendonor,80,20);
  //     $pdf->SetFont('Arial','B',16);
  //     $pdf->SetXY(8,0);
  //     $pdf->Cell(0,35,$no_pendonor);
  //     $pdf->Output('kartudonor_'.$no_pendonor.'.pdf','I');
  // }

=======
  public function getKartuDonor($no_pendonor)
  {
      $pdf=new PDF_Code128('L', 'mm', array(59,98));
      $pdf->AddPage();
      $pdf->SetFont('Arial','',10);
      $pdf->Code128(9,35,$no_pendonor,80,20);
      $pdf->SetFont('Arial','B',16);
      $pdf->SetXY(8,0);
      $pdf->Cell(0,35,$no_pendonor);
      $pdf->Output('kartudonor_'.$no_pendonor.'.pdf','I');
  }

>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
  public function setNoPendonor()
  {
      $date = date('Y-m-d');
      $last_no = $this->db()->pdo()->prepare("SELECT ifnull(MAX(CONVERT(RIGHT(no_pendonor,6),signed)),0) FROM utd_pendonor");
      $last_no->execute();
      $last_no = $last_no->fetch();
      if(empty($last_no[0])) {
        $last_no[0] = '000000';
      }
      $next_no = sprintf('%06s', ($last_no[0] + 1));
<<<<<<< HEAD
      $next_no = 'DO'.$next_no;
=======
      $next_no = 'UTD'.$next_no;
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

      return $next_no;
  }

<<<<<<< HEAD
    public function setNoDonor()
  {
      $date = date('Y-m-d');
      $last_no = $this->db()->pdo()->prepare("SELECT ifnull(MAX(CONVERT(RIGHT(no_donor,3),signed)),0) FROM utd_donor WHERE tanggal = '$date'");
      $last_no->execute();
      $last_no = $last_no->fetch();
      if(empty($last_no[0])) {
        $last_no[0] = '000';
      }
      $next_no = sprintf('%03s', ($last_no[0] + 1));
      $next_no = date('ymd').''.$next_no;

      return $next_no;
  }

  // public function setKodeKomponenDarah()
  // {
  //     $date = date('Y-m-d');
  //     $last_no = $this->db()->pdo()->prepare("SELECT ifnull(MAX(CONVERT(RIGHT(kode,2),signed)),0) FROM utd_komponen_darah");
  //     $last_no->execute();
  //     $last_no = $last_no->fetch();
  //     if(empty($last_no[0])) {
  //       $last_no[0] = '00';
  //     }
  //     $next_no = sprintf('%02s', ($last_no[0] + 1));
  //     $next_no = 'UTD'.$next_no;

  //     return $next_no;
  // }

=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
  public function getCss()
  {
      header('Content-type: text/css');
      echo $this->draw(MODULES.'/utd/css/admin/utd.css');
      exit();
  }

  public function getJavascript()
  {
      header('Content-type: text/javascript');
      echo $this->draw(MODULES.'/utd/js/admin/utd.js');
      exit();
  }

  private function _addHeaderFiles()
  {
<<<<<<< HEAD
      // CSS
      $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));
      $this->core->addCSS(url('assets/css/jquery-ui.css'));
      $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
      $this->core->addCSS(url('assets/jscripts/lightbox/lightbox.min.css'));
      $this->core->addCSS(url([ADMIN, 'utd', 'css']));

      // JS
      $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'));
      $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'));
      $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
      $this->core->addJS(url('assets/jscripts/lightbox/lightbox.min.js'));
=======
      $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));
      $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
      $this->core->addCSS(url([ADMIN, 'utd', 'css']));
      $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'));
      $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'));
      $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
      $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));
      $this->core->addJS(url('assets/jscripts/jquery.confirm.js'));
      $this->core->addJS(url([ADMIN, 'utd', 'javascript']), 'footer');
  }

<<<<<<< HEAD
   protected function data_wilayah($table)
    {
        return new DB_Wilayah($table);
    }
=======
  protected function data_wilayah($table)
  {
      return new DB_Wilayah($table);
  }
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d

}
