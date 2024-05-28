<?php

namespace Plugins\Profil;

use Systems\AdminModule;

class Admin extends AdminModule
{

    public function navigation()
    {
        return [
            'Kelola' => 'manage',
            'Biodata' => 'biodata',
            'Cuti' => 'cuti',
            'Presensi Masuk' => 'presensi',
            'Rekap Presensi' => 'rekap_presensi',
            'Jadwal Pegawai' => 'jadwal',
            'Ganti Password' => 'ganti_pass'
        ];
    }

    public function getManage()
    {
        $sub_modules = [
            ['name' => 'Biodata', 'url' => url([ADMIN, 'profil', 'biodata']), 'icon' => 'cubes', 'desc' => 'Biodata Pegawai'],
            ['name' => 'Izin & Cuti', 'url' => url([ADMIN, 'profil', 'cuti']), 'icon' => 'list', 'desc' => 'Permintaan Izin / Cuti '],
            ['name' => 'Presensi', 'url' => url([ADMIN, 'profil', 'presensi']), 'icon' => 'cubes', 'desc' => 'Presensi Pegawai'],
            ['name' => 'Rekap Presensi', 'url' => url([ADMIN, 'profil', 'rekap_presensi']), 'icon' => 'cubes', 'desc' => 'Rekap Presensi Pegawai'],
            ['name' => 'Jadwal', 'url' => url([ADMIN, 'profil', 'jadwal']), 'icon' => 'cubes', 'desc' => 'Jadwal Pegawai'],
            ['name' => 'Ganti Password', 'url' => url([ADMIN, 'profil', 'ganti_pass']), 'icon' => 'cubes', 'desc' => 'Ganti Pasword'],
            ['name' => 'Perbaikan Barang', 'url' => url([ADMIN, 'profil', 'permintaanperbaikan']), 'icon' => 'paperclip', 'desc' => 'Permohonan Perbaikan Barang'],
        ];
        $username = $this->core->getUserInfo('username', null, true);
        $cek_profil = $this->db('pegawai')->where('nik', $username)->oneArray();
        if(!$cek_profil) {
          $profil['nama'] = 'Admin Utama';
          $profil['nik'] = 'admin';
        } else {
          $profil['nama'] = $cek_profil['nama'];
          $profil['nik'] = $cek_profil['nik'];
        }
        $tanggal = getDayIndonesia(date('Y-m-d')) . ', ' . dateIndonesia(date('Y-m-d'));
        $presensi = [];
        $absensi = [];
        if($cek_profil) {
          $presensi = [];
          $absensi = [];
          if($this->db('rekap_presensi')->where('id', $cek_profil['id'])->oneArray()){
            $presensi = $this->db('rekap_presensi')->where('id', $cek_profil['id'])->where('photo', '!=', '')->like('jam_datang', date('Y-m') . '%')->toArray();
            $absensi = $this->db('rekap_presensi')->where('id', $cek_profil['id'])->where('photo', '')->like('jam_datang', date('Y-m') . '%')->toArray();
          }
        }
        $fotoURL = url(MODULES . '/kepegawaian/img/default.png');
        if (!empty($cek_profil['photo'])) {
            $fotoURL = WEBAPPS_URL . '/penggajian/' . $cek_profil['photo'];
        }
        return $this->draw('manage.html', ['sub_modules' => $sub_modules, 'profil' => $profil, 'tanggal' => $tanggal, 'presensi' => $presensi, 'absensi' => $absensi, 'fotoURL' => $fotoURL]);
    }

    public function getBiodata($id = null)
    {
        $this->_addHeaderFiles();
        if ($id) {
            $row = $this->db('pegawai')->where('id', $id)->oneArray();
            $username = $row['nik'];
            $this->assign['title'] = 'Edit Biodata Pegawai';
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $row = $this->db('pegawai')->where('nik', $username)->oneArray();
            $this->assign['title'] = 'Edit Biodata';
        }
        $nipk_baru = '';

        // $this->assign['form'] = $row;
        //     if ($this->assign['form']['stts_kerja'] == 'FT') {
        //         $this->assign['rsk'] = $this->db('simpeg_skkontrak')->where('nip', $username)->desc('tgl_sk')->toArray();
        //         $this->assign['petugas'] = $this->db('petugas')->where('nip', $username)->oneArray();
                
        //     }
        //         $nipk_baru = $username;
        //         $nipkBaru = $this->db('pegawai_mapping')->select('nipk')->where('nipk_baru', $username)->oneArray();
        //         if ($nipkBaru) {
        //             $username = $nipkBaru['nipk'];
        //         }
        // if(empty($nipkBaru)){
        //   $petugas = $this->db('petugas')->where('nip', $username)->oneArray();
        //   $username = $petugas['nip'];
        // }else{
        //       $username = $nipkBaru['nipk'];
        // }
            
        $this->assign['form'] = $row;
        if ($this->assign['form']['stts_kerja'] == 'FT') {
            $this->assign['rsk'] = $this->db('simpeg_skkontrak')->where('nip', $username)->desc('tgl_sk')->toArray();
            $this->assign['petugas'] = $this->db('petugas')->where('nip', $username)->oneArray();
            $nipk_baru = $username;
            $nipkBaru = $this->db('pegawai_mapping')->select('nipk')->where('nipk_baru', $username)->oneArray();
            if ($nipkBaru) {
                $username = $nipkBaru['nipk'];
            }
        }

        //  $this->assign['form'] = $row;
        // if ($this->assign['form']['stts_kerja'] == 'FT') {
        //     $this->assign['rsk'] = $this->db('simpeg_skkontrak')->where('nip', $username)->desc('tgl_sk')->toArray();
        //     $this->assign['petugas'] = $this->db('petugas')->where('nip', $username)->oneArray();
            
        // }
        //     $nipk_baru = $username;
        //     $nipkBaru = $this->db('pegawai_mapping')->select('nipk')->where('nipk_baru', $username)->oneArray();
        //     if ($nipkBaru) {
        //         $username = $nipkBaru['nipk'];
        //     }
        // $this->assign['petugas'] = $this->db('petugas')->where('nip', $username)->oneArray();

        $this->assign['jk'] = ['Pria', 'Wanita'];
        $this->assign['departemen'] = $this->db('departemen')->toArray();
        $this->assign['bidang'] = $this->db('bidang')->toArray();
        $this->assign['stts_wp'] = $this->db('stts_wp')->toArray();
        $this->assign['pendidikan'] = $this->db('pendidikan')->toArray();
        $this->assign['jnj_jabatan'] = $this->db('jnj_jabatan')->toArray();
        $this->assign['identpeg'] = $this->db('simpeg_identpeg')->where('NIP', $username)->oneArray();
        $this->assign['peg'] = $this->db('petugas')->where('nip', $username)->oneArray();
        $this->assign['petugas'] = $this->db('petugas')->where('nip', $username)->oneArray();
        $this->assign['fotoURL'] = url(WEBAPPS_PATH . '/penggajian/' . $row['photo']);
        $this->assign['knapang'] = [
            '0' => '',
            '1' => 'Reguler',
            '2' => 'Pilihan'
        ];
        $this->assign['agama'] = [
            '1' => 'Islam',
            '2' => 'Kristen Protestan',
            '3' => 'Katolik',
            '4' => 'Hindu',
            '5' => 'Budha',
            '6' => 'Konghucu'
        ];
        $this->assign['urlBerkas'] = UPLOADS . '/simpeg/';
        $stmt = $this->db()->pdo()->prepare("SELECT * FROM simpeg_rpendum WHERE NIP IN ('$username','$nipk_baru') ORDER BY TSTTB DESC");
        $stmt->execute();
        $this->assign['rpendum'] = $stmt->fetchAll();
        $unker = $this->db()->pdo()->prepare("SELECT * FROM simpeg_unker WHERE NIP IN ('$username','$nipk_baru') AND status = '1'");
        $unker->execute();
        $this->assign['runker'] = $unker->fetchAll();
        $bkstmbh = $this->db()->pdo()->prepare("SELECT * FROM simpeg_bkstambah WHERE nip IN ('$username','$nipk_baru') AND status = '1'");
        $bkstmbh->execute();
        $this->assign['bkstambah'] = $bkstmbh->fetchAll();
        $sert = $this->db()->pdo()->prepare("SELECT * FROM simpeg_rsertifikasi WHERE nip IN ('$username','$nipk_baru') ORDER BY tgl_str DESC");
        $sert->execute();
        $this->assign['rsertifikasi'] = $sert->fetchAll();
        $akan = $this->db()->pdo()->prepare("SELECT * FROM simpeg_rakand WHERE NIP IN ('$username','$nipk_baru')");
        $akan->execute();
        $this->assign['rakand'] = $akan->fetchAll();
        $ibuk = $this->db()->pdo()->prepare("SELECT * FROM simpeg_ribukand WHERE NIP IN ('$username','$nipk_baru')");
        $ibuk->execute();
        $this->assign['ribukand'] = $ibuk->fetchAll();
        $istri = $this->db()->pdo()->prepare("SELECT * FROM simpeg_rsistri WHERE NIP IN ('$username','$nipk_baru')");
        $istri->execute();
        $this->assign['rsistri'] = $istri->fetchAll();
        $anak = $this->db()->pdo()->prepare("SELECT * FROM simpeg_ranak WHERE NIP IN ('$username','$nipk_baru')");
        $anak->execute();
        $this->assign['ranak'] = $anak->fetchAll();
        $kel = $this->db()->pdo()->prepare("SELECT * FROM simpeg_rkeluarga WHERE NIP IN ('$username','$nipk_baru')");
        $kel->execute();
        $this->assign['rkeluarga'] = $kel->fetchAll();
        $diktek = $this->db()->pdo()->prepare("SELECT * FROM simpeg_rdiktek WHERE NIP IN ('$username','$nipk_baru') ORDER BY TMULAI DESC");
        $diktek->execute();
        $this->assign['rdiktek'] = $diktek->fetchAll();
        $seminar = $this->db()->pdo()->prepare("SELECT * FROM simpeg_rseminar WHERE NIP IN ('$username','$nipk_baru') ORDER BY TMULAI DESC");
        $seminar->execute();
        $this->assign['rseminar'] = $seminar->fetchAll();
        $this->assign['rpangkat'] = $this->db('simpeg_rpangkat')->where('NIP', $username)->desc('TMTPANG')->toArray();
        $this->assign['rjabatan'] = $this->db('simpeg_rjabatan')->where('NIP', $username)->desc('TMTJABAT')->toArray();
        $this->assign['rdppp'] = $this->db('simpeg_rdppp')->where('NIP', $username)->desc('THNILAI')->toArray();
        $this->assign['gkkhir'] = $this->db('simpeg_gkkhir')->where('NIP', $username)->desc('TMTNGAJ')->toArray();
        $this->assign['rdiknstr'] = $this->db('simpeg_rdiknstr')->where('NIP', $username)->desc('TMULAI')->toArray();
        $this->assign['rdikfung'] = $this->db('simpeg_rdikfung')->where('NIP', $username)->desc('TMULAI')->toArray();
        $this->assign['rdikstr'] = $this->db('simpeg_rdikstr')->where('NIP', $username)->desc('TMULAI')->toArray();
        $this->assign['rjabfung'] = $this->db('simpeg_rjabfung')->where('NIP', $username)->desc('tgl_sk')->toArray();
        $this->assign['rtubel'] = $this->db('simpeg_rtubel')->where('NIP', $username)->desc('TSTTB')->toArray();
        $this->assign['rpangkatlast'] = $this->db('simpeg_rpangkat')->where('NIP', $username)->where('ISAKHIR', '1')->desc('TMTPANG')->toArray();
        $this->assign['tpu'] = [
            '01' => 'SD',
            '02' => 'SLTP',
            '03' => 'SLTA',
            '04' => 'D-I',
            '05' => 'D-II',
            '06' => 'D-III/SM/Akademi',
            '07' => 'D-IV',
            '08' => 'S-1',
            '09' => 'S-2',
            '10' => 'S-3',
            '11' => 'Pendidikan Profesi'
        ];
        $this->assign['sttstubel'] = [
            '1' => 'Lulus',
            '2' => 'Sedang Sekolah',
            '3' => 'Tidak Lulus'
        ];
        $this->assign['jnsjab'] = [
            '' => '',
            '1' => 'Struktural',
            '2' => 'Fungsional Tertentu',
            '3' => 'Fungsional Umum atau Administrasi'
        ];
        $this->assign['diknstr'] = [
            '1' => 'Pra Jabatan',
            '2' => 'Ujian Dinas Tingkat I',
            '3' => 'Ujian Dinas Tingkat II',
            '4' => 'Ujian Dinas Tingkat III',
        ];
        $this->assign['dikstr'] = [
            '1' => 'DIKLAT PIM TK. I',
            '2' => 'DIKLAT PIM TK. II',
            '3' => 'DIKLAT PIM TK. III',
            '4' => 'DIKLAT PIM TK. IV',
            '5' => 'SEPADA',
        ];
        $this->assign['golruang'] = [
            '145' => 'IV/e (Pembina Utama)',
            '144' => 'IV/d (Pembina Utama Madya)',
            '143' => 'IV/c (Pembina Utama Muda)',
            '142' => 'IV/b (Pembina Tingkat 1)',
            '141' => 'IV/a (Pembina)',
            '134' => 'III/d (Penata Tingkat 1)',
            '133' => 'III/c (Penata)',
            '132' => 'III/b (Penata Muda Tingkat 1)',
            '131' => 'III/a (Penata Muda)',
            '124' => 'II/d (Pengatur Tingkat 1)',
            '123' => 'II/c (Pengatur)',
            '122' => 'II/b (Pengatur Muda Tingkat 1)',
            '121' => 'II/a (Pengatur Muda)',
            '114' => 'I/d (Juru Tingkat 1)',
            '113' => 'I/c (Juru)',
            '112' => 'I/b (Juru Muda Tingkat 1)',
            '111' => 'I/a (Juru Muda)',
        ];
        $this->assign['profesi'] = [
            '1' => 'Psikologi Klinik',
            '2' => 'Promotor Kesehatan',
            '3' => 'Epidemiolog Kesehatan',
            '4' => 'Praktisi Kesehatan Tradisional',
            '5' => 'Audiologis',
            '6' => 'Pembimbing Kesehatan Kerja',
            '7' => 'Dokter',
            '8' => 'Dokter Gigi',
            '9' => 'Apoteker',
            '10' => 'Asisten Apoteker',
            '11' => 'Perawat',
            '12' => 'Bidan',
            '13' => 'ATLM',
            '14' => 'Radiografer',
            '15' => 'Ahli Gizi',
            '16' => 'Perekam Medis',
            '17' => 'Sanitarian',
            '18' => 'ATEM',
            '19' => 'Surveilans'
        ];
        $this->assign['eselon'] = [
            '11' => 'I. a',
            '12' => 'I. b',
            '21' => 'II. a',
            '22' => 'II. b',
            '31' => 'III. a',
            '32' => 'III. b',
            '41' => 'IV. a',
            '42' => 'IV. b',
            '51' => 'V. a',
            '52' => 'V. b',
            '99' => '---',
        ];
        $this->assign['stunj'] = [
            'D' => 'Dapat Tunjangan',
            'T' => 'Tidak Dapat Tunjangan',
        ];
        $this->assign['jkel'] = [
            '1' => 'Laki - Laki',
            '2' => 'Perempuan',
        ];
        $this->assign['hubungan'] = [
            'K' => 'Anak Kandung',
            'T' => 'Anak Tiri',
            'A' => 'Anak Angkat',
        ];
        $this->assign['hub_kel'] = array('Mertua', 'Saudara Kandung', 'Saudara Istri/Suami');
        $this->assign['nikah'] = [
            'N' => 'Menikah',
            'C' => 'Cerai',
            'M' => 'Meninggal',
            'B' => 'Ada',
        ];
        $this->assign['statusHidup'] = [
            'B' => 'Ada',
            'M' => 'Meninggal',
        ];
        $this->assign['stts_kerja'] = [
            'FT' => 'Honorer / Kontrak',
            'PNS' => 'Pegawai Negeri Sipil',
        ];
        $this->assign['stts_aktif'] = [
            'KELUAR' => 'Keluar',
            'AKTIF' => 'Aktif',
        ];
        $this->assign['kpej'] = [
            '0' => 'Bupati',
            '1' => 'Sekretaris Daerah',
            '2' => 'Direktur',
        ];
        return $this->draw('biodata.html', ['biodata' => $this->assign]);
    }

    public function postBiodataSave($id = null)
    {
        $errors = 0;
        if (!$id) {
            $location = url([ADMIN, 'profil', 'biodata']);
        } else {
            $location = url([ADMIN, 'profil', 'biodata', $id]);
        }

        if (checkEmptyFields(['nama'], $_POST)) {
            $this->notify('failure', 'Isian kosong');
            redirect($location, $_POST);
        }

        if (!$errors) {
            unset($_POST['save']);

            if (($photo = isset_or($_FILES['photo']['tmp_name'], false)) || !$id) {
                $img = new \Systems\Lib\Image;

                if (empty($photo) && !$id) {
                    $photo = MODULES . '/profil/img/default.png';
                }
                if ($img->load($photo)) {
                    if ($img->getInfos('width') < $img->getInfos('height')) {
                        $img->crop(0, 0, $img->getInfos('width'), $img->getInfos('width'));
                    } else {
                        $img->crop(0, 0, $img->getInfos('height'), $img->getInfos('height'));
                    }

                    if ($img->getInfos('width') > 512) {
                        $img->resize(512, 512);
                    }

                    if ($id) {
                        $pegawai = $this->db('pegawai')->oneArray($id);
                    }

                    $_POST['photo'] = "pages/pegawai/photo/" . $pegawai['nik'] . "." . $img->getInfos('type');

                    if (!empty($pegawai['photo'])) {
                        # code...
                        $_POST['photo'] = $pegawai['photo'];
                    }
                }
            }

            $pegawai = $this->db('pegawai')->where('id', $id)->oneArray();
            if (!empty($pegawai['photo'])) {
                # code...
                $_POST['photo'] = $pegawai['photo'];
            }
            if ($_POST['departemen'] == '-') {
                $_POST['departemen'] = $pegawai['departemen'];
            }
            $petugas = $this->db('petugas')->where('nip', $pegawai['nik'])->oneArray();
            if (!$id) {    // new
                $query = $this->db('pegawai')->save([
                    'nama' => $_POST['nama'],
                    'alamat' => $_POST['alamat'],
                    'tmp_lahir' => $_POST['tmp_lahir'],
                    'tgl_lahir' => $_POST['tgl_lahir'],
                    'jk' => $_POST['jk'],
                    'stts_kerja' => $_POST['stts_kerja'],
                    'pendidikan' => $_POST['pendidikan'],
                    'departemen' => $_POST['departemen'],
                    'jbtn' => $_POST['jbtn'],
                    'jnj_jabatan' => $_POST['jnj_jabatan'],
                    'no_ktp' => $_POST['no_ktp'],
                    'npwp' => $_POST['npwp'],
                    'stts_wp' => $_POST['stts_wp'],
                    'mulai_kontrak' => $_POST['mulai_kontrak'],
                    'stts_aktif' => $_POST['stts_aktif'],
                    'photo' => $_POST['photo'],
                ]);
                $query2 = $this->db('petugas')->save([
                    'no_telp' => $_POST['no_hp'],
                    'agama' => $_POST['agama'],
                ]);
            } else {        // edit
                $query = $this->db('pegawai')->where('id', $id)->save([
                    'nama' => $_POST['nama'],
                    'alamat' => $_POST['alamat'],
                    'tmp_lahir' => $_POST['tmp_lahir'],
                    'tgl_lahir' => $_POST['tgl_lahir'],
                    'jk' => $_POST['jk'],
                    'stts_kerja' => $_POST['stts_kerja'],
                    'pendidikan' => $_POST['pendidikan'],
                    'departemen' => $_POST['departemen'],
                    'jbtn' => $_POST['jbtn'],
                    'jnj_jabatan' => $_POST['jnj_jabatan'],
                    'no_ktp' => $_POST['no_ktp'],
                    'npwp' => $_POST['npwp'],
                    'stts_wp' => $_POST['stts_wp'],
                    'mulai_kontrak' => $_POST['mulai_kontrak'],
                    'stts_aktif' => $_POST['stts_aktif'],
                    'photo' => $_POST['photo'],
                ]);
                if (!$petugas) {
                    $query2 = $this->db('petugas')->save([
                        'nip' => $pegawai['nik'],
                        'nama' => $_POST['nama'],
                        'no_telp' => $_POST['no_hp'],
                        'agama' => $_POST['agama'],
                        'status' => '1',
                    ]);
                }
                $query2 = $this->db('petugas')->where('nip', $pegawai['nik'])->save([
                    'no_telp' => $_POST['no_hp'],
                    'agama' => $_POST['agama'],
                ]);
            }

            if ($query) {
                if (isset($img) && $img->getInfos('width')) {
                    if (isset($pegawai)) {
                        unlink(WEBAPPS_PATH . "/penggajian/" . $pegawai['photo']);
                    }

                    $img->save(WEBAPPS_PATH . "/penggajian/" . $_POST['photo']);
                }

                $this->notify('success', 'Simpan sukes');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            // echo $query;
            redirect($location);
        }

        redirect($location, $_POST);
    }
    // ============================================== SIMPEG =======================================================

    public function getLihatBerkas($id)
    {
        $this->tpl->set('bacafile', $id);
        $folder = substr($id, 0, strpos($id, "_"));
        $this->tpl->set('folder', $folder);
        echo $this->draw('load_pdf.html');
        exit();
    }

    public function postUnkerSave($idPeg = null)
    {
        $id = $_POST['id'];

        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        $errors = 0;

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $queryEdit = $this->db('simpeg_unker')->where('NIP', $username)->where('status', '1')->save([
                    'status' => '0'
                ]);
                $query = $this->db('simpeg_unker')->save([
                    'NIP' => $username,
                    'UNIT' => $_POST['UNIT'],
                    'SUNIT' => $_POST['SUNIT'],
                    'SSUNIT' => $_POST['SSUNIT'],
                    'status' => '1'
                ]);
                if ($_POST['SSUNIT'] != '-') {
                    # code...
                    $queryEdit1 = $this->db('pegawai')->where('nik', $username)->save([
                        'bidang' => $_POST['SSUNIT']
                    ]);
                } else if ($_POST['SUNIT'] != '-' && $_POST['SSUNIT'] == '-') {
                    $queryEdit1 = $this->db('pegawai')->where('nik', $username)->save([
                        'bidang' => $_POST['SUNIT']
                    ]);
                } else {
                    $queryEdit1 = $this->db('pegawai')->where('nik', $username)->save([
                        'bidang' => $_POST['UNIT']
                    ]);
                }
            }

            if ($query) {
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postBkstambahSave($idPeg = null)
    {
        $id = $_POST['id'];

        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        $errors = 0;

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_bkstambah')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_bkstambah')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_bkstambah')->save([
                    'nip' => $username,
                    'nm_berkas' => strtoupper($_POST['nm_berkas']),
                    'nm_file' => $_POST['nm_file'],
                    'status' => '1'
                ]);
            } else {        // edit
                $query = $this->db('simpeg_bkstambah')->where('id', $id)->save([
                    'status' => '0'
                ]);
                $querybaru = $this->db('simpeg_bkstambah')->save([
                    'nip' => $username,
                    'nm_berkas' => strtoupper($_POST['nm_berkas']),
                    'nm_file' => $_POST['nm_file'],
                    'status' => '1'
                ]);
            }
            if ($query) {
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postPangkatSave($idPeg = null)
    {
        $id = $_POST['ID_PANGKAT'];

        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];
        $errors = 0;

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rpangkat')->select('nm_file')->where('ID_PANGKAT', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rpangkat')->select('nm_file')->where('ID_PANGKAT', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rpangkat')->save([
                    'NIP' => $username,
                    'KGOLRU' => $_POST['KGOLRU'],
                    'KNPANG' => $_POST['KNPANG'],
                    'TMTPANG' => $_POST['TMTPANG'],
                    'NSKPANG' => $_POST['NSKPANG'],
                    'NPEJABAT' => $_POST['NPEJABAT'],
                    'TSKPANG' => $_POST['TSKPANG'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rpangkat')->where('ID_PANGKAT', $id)->save([
                    'NIP' => $username,
                    'KGOLRU' => $_POST['KGOLRU'],
                    'KNPANG' => $_POST['KNPANG'],
                    'TMTPANG' => $_POST['TMTPANG'],
                    'NSKPANG' => $_POST['NSKPANG'],
                    'NPEJABAT' => $_POST['NPEJABAT'],
                    'TSKPANG' => $_POST['TSKPANG'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postJabatanSave($idPeg = null)
    {
        $id = $_POST['ID_JAB'];
        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];
        $errors = 0;

        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rjabatan')->select('nm_file')->where('ID_JAB', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rjabatan')->select('nm_file')->where('ID_JAB', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rjabatan')->save([
                    'NIP' => $username,
                    'NUNKER' => $_POST['NUNKER'],
                    'JNSJAB' => $_POST['JNSJAB'],
                    'KESELON' => $_POST['KESELON'],
                    'NJAB' => $_POST['NJAB'],
                    'TMTJABAT' => $_POST['TMTJABAT'],
                    'NSKJABAT' => $_POST['NSKJABAT'],
                    'TSKJABAT' => $_POST['TSKJABAT'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rjabatan')->where('ID_JAB', $id)->save([
                    'NIP' => $username,
                    'NUNKER' => $_POST['NUNKER'],
                    'JNSJAB' => $_POST['JNSJAB'],
                    'KESELON' => $_POST['KESELON'],
                    'NJAB' => $_POST['NJAB'],
                    'TMTJABAT' => $_POST['TMTJABAT'],
                    'NSKJABAT' => $_POST['NSKJABAT'],
                    'TSKJABAT' => $_POST['TSKJABAT'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postSkpSave($idPeg = null)
    {
        $id = $_POST['ID_DP3'];
        $errors = 0;

        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rdppp')->select('nm_file')->where('ID_DP3', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rdppp')->select('nm_file')->where('ID_DP3', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rdppp')->save([
                    'NIP' => $username,
                    'THNILAI' => $_POST['THNILAI'],
                    'NSETIA' => $_POST['NSETIA'],
                    'NPRES' => $_POST['NPRES'],
                    'NINISIATIF' => $_POST['NINISIATIF'],
                    'NTJAWAB' => $_POST['NTJAWAB'],
                    'NTAAT' => $_POST['NTAAT'],
                    'NJUJUR' => $_POST['NJUJUR'],
                    'NKSAMA' => $_POST['NKSAMA'],
                    'NPKARSA' => $_POST['NPKARSA'],
                    'NPIMPIN' => $_POST['NPIMPIN'],
                    'jabat_nilai' => $_POST['jabat_nilai'],
                    'SEBUTAN' => '',
                    'atasan_jabat_nilai' => $_POST['atasan_jabat_nilai'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rdppp')->where('ID_DP3', $id)->save([
                    'NIP' => $username,
                    'THNILAI' => $_POST['THNILAI'],
                    'NSETIA' => $_POST['NSETIA'],
                    'NPRES' => $_POST['NPRES'],
                    'NINISIATIF' => $_POST['NINISIATIF'],
                    'NTJAWAB' => $_POST['NTJAWAB'],
                    'NTAAT' => $_POST['NTAAT'],
                    'NJUJUR' => $_POST['NJUJUR'],
                    'NKSAMA' => $_POST['NKSAMA'],
                    'NPKARSA' => $_POST['NPKARSA'],
                    'NPIMPIN' => $_POST['NPIMPIN'],
                    'jabat_nilai' => $_POST['jabat_nilai'],
                    'SEBUTAN' => '',
                    'atasan_jabat_nilai' => $_POST['atasan_jabat_nilai'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postGajiBerSave($idPeg = null)
    {
        $id = $_POST['ID_KGB'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_gkkhir')->select('nm_file')->where('ID_KGB', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_gkkhir')->select('nm_file')->where('ID_KGB', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_gkkhir')->save([
                    'NIP' => $username,
                    'NPEJABAT' => $_POST['NPEJABAT'],
                    'NO_SK' => $_POST['NO_SK'],
                    'TGL_SK' => $_POST['TGL_SK'],
                    'TMTNGAJ' => $_POST['TMTNGAJ'],
                    'KGOLRU' => $_POST['KGOLRU'],
                    'MSKERJA' => $_POST['MSKERJA'],
                    'MSKERJA_BLN' => $_POST['MSKERJA_BLN'],
                    'GPOKKHIR' => $_POST['GPOKKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_gkkhir')->where('ID_KGB', $id)->save([
                    'NIP' => $username,
                    'NPEJABAT' => $_POST['NPEJABAT'],
                    'NO_SK' => $_POST['NO_SK'],
                    'TGL_SK' => $_POST['TGL_SK'],
                    'TMTNGAJ' => $_POST['TMTNGAJ'],
                    'KGOLRU' => $_POST['KGOLRU'],
                    'MSKERJA' => $_POST['MSKERJA'],
                    'MSKERJA_BLN' => $_POST['MSKERJA_BLN'],
                    'GPOKKHIR' => $_POST['GPOKKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postRjabFungSave($idPeg = null)
    {
        $id = $_POST['id'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rjabfung')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rjabfung')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rjabfung')->save([
                    'NIP' => $username,
                    'no_sk' => $_POST['no_sk'],
                    'tgl_sk' => $_POST['tgl_sk'],
                    'utama' => $_POST['utama'],
                    'penunjang' => $_POST['penunjang'],
                    'total' => $_POST['total'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rjabfung')->where('id', $id)->save([
                    'NIP' => $username,
                    'no_sk' => $_POST['no_sk'],
                    'tgl_sk' => $_POST['tgl_sk'],
                    'utama' => $_POST['utama'],
                    'penunjang' => $_POST['penunjang'],
                    'total' => $_POST['total'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postRiwserSave($idPeg = null)
    {
        $id = $_POST['id'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }
        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rsertifikasi')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rsertifikasi')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rsertifikasi')->save([
                    'nip' => $username,
                    'id_profesi' => $_POST['id_profesi'],
                    'no_str' => $_POST['no_str'],
                    'tgl_str' => $_POST['tgl_str'],
                    'tgl_laku_str' => $_POST['tgl_laku_str'],
                    'no_sip' => $_POST['no_sip'],
                    'tgl_sip' => $_POST['tgl_sip'],
                    'tgl_laku_sip' => $_POST['tgl_laku_sip'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rsertifikasi')->where('id', $id)->save([
                    'nip' => $username,
                    'id_profesi' => $_POST['id_profesi'],
                    'no_str' => $_POST['no_str'],
                    'tgl_str' => $_POST['tgl_str'],
                    'tgl_laku_str' => $_POST['tgl_laku_str'],
                    'no_sip' => $_POST['no_sip'],
                    'tgl_sip' => $_POST['tgl_sip'],
                    'tgl_laku_sip' => $_POST['tgl_laku_sip'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postSkKontrakSave($idPeg = null)
    {
        $id = $_POST['id'];

        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];
        $errors = 0;

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_skkontrak')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_skkontrak')->select('nm_file')->where('id', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }


        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_skkontrak')->save([
                    'nip' => $username,
                    'kpej' => $_POST['kpej'],
                    'npej' => $_POST['npej'],
                    'no_sk' => $_POST['no_sk'],
                    'tgl_sk' => $_POST['tgl_sk'],
                    'tgl_tmt' => $_POST['tgl_tmt'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_skkontrak')->where('id', $id)->save([
                    'nip' => $username,
                    'kpej' => $_POST['kpej'],
                    'npej' => $_POST['npej'],
                    'no_sk' => $_POST['no_sk'],
                    'tgl_sk' => $_POST['tgl_sk'],
                    'tgl_tmt' => $_POST['tgl_tmt'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postPendumSave($idPeg = null)
    {
        $id = $_POST['ID_PENDUM'];
        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rpendum')->select('nm_file')->where('ID_PENDUM', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rpendum')->select('nm_file')->where('ID_PENDUM', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rpendum')->save([
                    'NIP' => $username,
                    'KTPU' => $_POST['KTPU'],
                    'JURUSAN' => $_POST['JURUSAN'],
                    'PROG_STUDI' => $_POST['PROG_STUDI'],
                    'NEGARA' => $_POST['NEGARA'],
                    'NSEK' => $_POST['NSEK'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'NKEPSEK' => $_POST['NKEPSEK'],
                    'NSTTB' => $_POST['NSTTB'],
                    'TSTTB' => $_POST['TSTTB'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rpendum')->where('ID_PENDUM', $id)->save([
                    'NIP' => $username,
                    'KTPU' => $_POST['KTPU'],
                    'JURUSAN' => $_POST['JURUSAN'],
                    'PROG_STUDI' => $_POST['PROG_STUDI'],
                    'NEGARA' => $_POST['NEGARA'],
                    'NSEK' => $_POST['NSEK'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'NKEPSEK' => $_POST['NKEPSEK'],
                    'NSTTB' => $_POST['NSTTB'],
                    'TSTTB' => $_POST['TSTTB'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postDiknonSave($idPeg = null)
    {
        $id = $_POST['ID_DIKNSTR'];
        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rdiknstr')->select('nm_file')->where('ID_DIKNSTR', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rdiknstr')->select('nm_file')->where('ID_DIKNSTR', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rdiknstr')->save([
                    'NIP' => $username,
                    'KDIKNSTR' => $_POST['KDIKNSTR'],
                    'NDIKNSTR' => $_POST['NDIKNSTR'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rdiknstr')->where('ID_DIKNSTR', $id)->save([
                    'NIP' => $username,
                    'KDIKNSTR' => $_POST['KDIKNSTR'],
                    'NDIKNSTR' => $_POST['NDIKNSTR'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postDikStrSave($idPeg = null)
    {
        $id = $_POST['ID_DIKSTR'];
        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rdikstr')->select('nm_file')->where('ID_DIKSTR', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rdikstr')->select('nm_file')->where('ID_DIKSTR', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rdikstr')->save([
                    'NIP' => $username,
                    'KDIKSTR' => $_POST['KDIKSTR'],
                    'NDIKSTR' => $_POST['NDIKSTR'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rdikstr')->where('ID_DIKSTR', $id)->save([
                    'NIP' => $username,
                    'KDIKSTR' => $_POST['KDIKSTR'],
                    'NDIKSTR' => $_POST['NDIKSTR'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postDikFungSave($idPeg = null)
    {
        $id = $_POST['ID_DIKFUNG'];
        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rdikfung')->select('nm_file')->where('ID_DIKFUNG', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rdikfung')->select('nm_file')->where('ID_DIKFUNG', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rdikfung')->save([
                    'NIP' => $username,
                    'NDIKFUNG' => $_POST['NDIKFUNG'],
                    'KDIKFUNG' => '0',
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rdikfung')->where('ID_DIKFUNG', $id)->save([
                    'NIP' => $username,
                    'NDIKFUNG' => $_POST['NDIKFUNG'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postDikTekSave($idPeg = null)
    {
        $id = $_POST['ID_DIKTEK'];
        $_POST['ISAKHIR'] = ($_POST['ISAKHIR'] == null) ? '0' : $_POST['ISAKHIR'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rdiktek')->select('nm_file')->where('ID_DIKTEK', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rdiktek')->select('nm_file')->where('ID_DIKTEK', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rdiktek')->save([
                    'NIP' => $username,
                    'NDIKTEK' => $_POST['NDIKTEK'],
                    'KDIKTEK' => '0',
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rdiktek')->where('ID_DIKTEK', $id)->save([
                    'NIP' => $username,
                    'NDIKTEK' => $_POST['NDIKTEK'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'ANGKATAN' => $_POST['ANGKATAN'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'NSTTPP' => $_POST['NSTTPP'],
                    'TSTTPP' => $_POST['TSTTPP'],
                    'ISAKHIR' => $_POST['ISAKHIR'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postSemSave($idPeg = null)
    {
        $id = $_POST['ID_SEMINAR'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rseminar')->select('nm_file')->where('ID_SEMINAR', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rseminar')->select('nm_file')->where('ID_SEMINAR', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rseminar')->save([
                    'NIP' => $username,
                    'NSEMINAR' => $_POST['NSEMINAR'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'NPIAGAM' => $_POST['NPIAGAM'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'TPIAGAM' => $_POST['TPIAGAM'],
                    'SKP' => '',
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rseminar')->where('ID_SEMINAR', $id)->save([
                    'NIP' => $username,
                    'NSEMINAR' => $_POST['NSEMINAR'],
                    'TEMPAT' => $_POST['TEMPAT'],
                    'PAN' => $_POST['PAN'],
                    'NPIAGAM' => $_POST['NPIAGAM'],
                    'TMULAI' => $_POST['TMULAI'],
                    'TAKHIR' => $_POST['TAKHIR'],
                    'JAM' => $_POST['JAM'],
                    'TPIAGAM' => $_POST['TPIAGAM'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postTubelSave($idPeg = null)
    {
        $id = $_POST['ID_TUBEL'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }

        if ($_FILES['file']['size'] == 0) {
            $checkBerkas = $this->db('simpeg_rtubel')->select('nm_file')->where('ID_TUBEL', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $_POST['nm_file'] = $checkBerkas['nm_file'];
            } else {
                $_POST['nm_file'] = '';
            }
            // cover_image is empty (and not an error)
        } else {
            $targetFolder = UPLOADS . '/simpeg/' . $username;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }
            $nm_berkas = $username . '_' . time() . '.pdf';
            $checkBerkas = $this->db('simpeg_rtubel')->select('nm_file')->where('ID_TUBEL', $id)->oneArray();
            if ($checkBerkas['nm_file'] != '') {
                $nm_berkas = $checkBerkas['nm_file'];
            }
            $copy_file = false;
            $copy_file = move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder . '/' . $nm_berkas);
            if ($copy_file == true) {
                $_POST['nm_file'] = $nm_berkas;
            } else {
                $errors += 1;
            }
        }

        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rtubel')->save([
                    'NIP' => $username,
                    'NSEK' => $_POST['NSEK'],
                    'PROG_STUDI' => $_POST['PROG_STUDI'],
                    'JURUSAN' => $_POST['JURUSAN'],
                    'NSTTB' => $_POST['NSTTB'],
                    'TSTTB' => $_POST['TSTTB'],
                    'STATUS' => $_POST['STATUS'],
                    'nm_file' => $_POST['nm_file']
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rtubel')->where('ID_TUBEL', $id)->save([
                    'NIP' => $username,
                    'NSEK' => $_POST['NSEK'],
                    'PROG_STUDI' => $_POST['PROG_STUDI'],
                    'JURUSAN' => $_POST['JURUSAN'],
                    'NSTTB' => $_POST['NSTTB'],
                    'TSTTB' => $_POST['TSTTB'],
                    'STATUS' => $_POST['STATUS'],
                    'nm_file' => $_POST['nm_file']
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postAyahSave($idPeg = null)
    {
        $id = $_POST['ID_AYAH'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }
        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rakand')->save([
                    'NIP' => $username,
                    'NAYAH' => $_POST['NAYAH'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'ALJALAN' => $_POST['ALJALAN'],
                    'NOTELP' => $_POST['NOTELP'],
                    'WIL' => $_POST['WIL'],
                    'KPOS' => $_POST['KPOS'],
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rakand')->where('ID_AYAH', $id)->save([
                    'NIP' => $username,
                    'NAYAH' => $_POST['NAYAH'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'ALJALAN' => $_POST['ALJALAN'],
                    'NOTELP' => $_POST['NOTELP'],
                    'WIL' => $_POST['WIL'],
                    'KPOS' => $_POST['KPOS'],
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postIbuSave($idPeg = null)
    {
        $id = $_POST['ID_IBU'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }
        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_ribukand')->save([
                    'NIP' => $username,
                    'NIBU' => $_POST['NIBU'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'ALJALAN' => $_POST['ALJALAN'],
                    'NOTELP' => $_POST['NOTELP'],
                    'WIL' => $_POST['WIL'],
                    'KPOS' => $_POST['KPOS'],
                ]);
            } else {        // edit
                $query = $this->db('simpeg_ribukand')->where('ID_IBU', $id)->save([
                    'NIP' => $username,
                    'NIBU' => $_POST['NIBU'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'ALJALAN' => $_POST['ALJALAN'],
                    'NOTELP' => $_POST['NOTELP'],
                    'WIL' => $_POST['WIL'],
                    'KPOS' => $_POST['KPOS'],
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postIssuSave($idPeg = null)
    {
        $id = $_POST['ID_ISTRI'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }
        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rsistri')->save([
                    'NIP' => $username,
                    'NISUA' => $_POST['NISUA'],
                    'KTLAHIR' => $_POST['KTLAHIR'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'TIJASAH' => $_POST['TIJASAH'],
                    'TKAWIN' => $_POST['TKAWIN'],
                    'STUNJ' => $_POST['STUNJ'],
                    'STATUS' => $_POST['STATUS'],
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rsistri')->where('ID_ISTRI', $id)->save([
                    'NIP' => $username,
                    'NISUA' => $_POST['NISUA'],
                    'KTLAHIR' => $_POST['KTLAHIR'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'TIJASAH' => $_POST['TIJASAH'],
                    'TKAWIN' => $_POST['TKAWIN'],
                    'STUNJ' => $_POST['STUNJ'],
                    'STATUS' => $_POST['STATUS'],
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postAnakSave($idPeg = null)
    {
        $id = $_POST['ID_ANAK'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }
        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_ranak')->save([
                    'NIP' => $username,
                    'NANAK' => $_POST['NANAK'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'TIJASAH' => $_POST['TIJASAH'],
                    'KELUARGA' => $_POST['KELUARGA'],
                    'TUNJ' => $_POST['TUNJ'],
                    'KJKEL' => $_POST['KJKEL'],
                    'STATUS' => $_POST['STATUS'],
                ]);
            } else {        // edit
                $query = $this->db('simpeg_ranak')->where('ID_ANAK', $id)->save([
                    'NIP' => $username,
                    'NANAK' => $_POST['NANAK'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'TIJASAH' => $_POST['TIJASAH'],
                    'KELUARGA' => $_POST['KELUARGA'],
                    'TUNJ' => $_POST['TUNJ'],
                    'KJKEL' => $_POST['KJKEL'],
                    'STATUS' => $_POST['STATUS'],
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postKeluargaSave($idPeg = null)
    {
        $id = $_POST['ID_KELUARGA'];

        $errors = 0;
        if ($idPeg) {
            $row = $this->db('pegawai')->where('id', $idPeg)->oneArray();
            $username = $row['nik'];
            $location = url([ADMIN, 'profil', 'biodata', $idPeg]);
        } else {
            $username = $this->core->getUserInfo('username', null, true);
            $location = url([ADMIN, 'profil', 'biodata']);
        }
        if (!$errors) {
            unset($_POST['save']);
            if (!$id) {    // new
                $query = $this->db('simpeg_rkeluarga')->save([
                    'NIP' => $username,
                    'NAMA' => $_POST['NAMA'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'SEX' => $_POST['SEX'],
                    'HUB_KEL' => $_POST['HUB_KEL'],
                    'NOTELP' => $_POST['NOTELP'],
                    'ALJALAN' => $_POST['ALJALAN'],
                    'WIL' => $_POST['WIL'],
                    'KPOS' => $_POST['KPOS'],
                ]);
            } else {        // edit
                $query = $this->db('simpeg_rkeluarga')->where('ID_KELUARGA', $id)->save([
                    'NIP' => $username,
                    'NAMA' => $_POST['NAMA'],
                    'TGLLAHIR' => $_POST['TGLLAHIR'],
                    'TLAHIR' => $_POST['TLAHIR'],
                    'NKERJA' => $_POST['NKERJA'],
                    'SEX' => $_POST['SEX'],
                    'HUB_KEL' => $_POST['HUB_KEL'],
                    'NOTELP' => $_POST['NOTELP'],
                    'ALJALAN' => $_POST['ALJALAN'],
                    'WIL' => $_POST['WIL'],
                    'KPOS' => $_POST['KPOS'],
                ]);
            }
            if ($query) {
                // echo $query;
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
        }
        redirect($location, $_POST);
    }

    public function postDeleteSimpeg()
    {
        $tableTarget = '';
        $idTarget = '';
        $notification = '';
        switch ($_POST['tabel']) {
            case 'pangkat':
                $tableTarget = 'simpeg_rpangkat';
                $idTarget = 'ID_PANGKAT';
                break;
            case 'jabatan':
                $tableTarget = 'simpeg_rjabatan';
                $idTarget = 'ID_JAB';
                break;
            case 'skp':
                $tableTarget = 'simpeg_rdppp';
                $idTarget = 'ID_DP3';
                break;
            case 'gkkhir':
                $tableTarget = 'simpeg_gkkhir';
                $idTarget = 'ID_KGB';
                break;
            case 'angkre':
                $tableTarget = 'simpeg_rjabfung';
                $idTarget = 'id';
                break;
            case 'riwser':
                $tableTarget = 'simpeg_rsertifikasi';
                $idTarget = 'id';
                break;
            case 'pendum':
                $tableTarget = 'simpeg_rpendum';
                $idTarget = 'ID_PENDUM';
                break;
            case 'diknstr':
                $tableTarget = 'simpeg_rdiknstr';
                $idTarget = 'ID_DIKNSTR';
                break;
            case 'dikstr':
                $tableTarget = 'simpeg_rdikstr';
                $idTarget = 'ID_DIKSTR';
                break;
            case 'dikfung':
                $tableTarget = 'simpeg_rdikfung';
                $idTarget = 'ID_DIKFUNG';
                break;
            case 'diktek':
                $tableTarget = 'simpeg_rpendum';
                $idTarget = 'ID_DIKTEK';
                break;
            case 'seminar':
                $tableTarget = 'simpeg_rseminar';
                $idTarget = 'ID_SEMINAR';
                break;
            case 'rtubel':
                $tableTarget = 'simpeg_rtubel';
                $idTarget = 'ID_TUBEL';
                break;
            case 'skkontrak':
                $tableTarget = 'simpeg_skkontrak';
                $idTarget = 'id';
                break;
            case 'unker':
                $tableTarget = 'simpeg_unker';
                $idTarget = 'id';
                break;
            case 'bkstambah':
                $tableTarget = 'simpeg_bkstambah';
                $idTarget = 'id';
                break;
            case 'ayah':
                $tableTarget = 'simpeg_rakand';
                $idTarget = 'ID_AYAH';
                break;
            case 'ibu':
                $tableTarget = 'simpeg_ribukand';
                $idTarget = 'ID_IBU';
                break;
            case 'istri':
                $tableTarget = 'simpeg_rsistri';
                $idTarget = 'ID_ISTRI';
                break;
            case 'anak':
                $tableTarget = 'simpeg_ranak';
                $idTarget = 'ID_ANAK';
                break;
            case 'keluarga':
                $tableTarget = 'simpeg_rkeluarga';
                $idTarget = 'ID_KELUARGA';
                break;
            default:
                $tableTarget = '';
                $idTarget = '';
                break;
        }
        if ($tableTarget != '') {
            # code...
            $search = $this->db($tableTarget)->where($idTarget, $_POST['id'])->oneArray();
            if ($search) {
                $this->db($tableTarget)->where($idTarget, $_POST['id'])->delete();
                $searchAgain = $this->db($tableTarget)->where($idTarget, $_POST['id'])->oneArray();
                if (!$searchAgain) {
                    $notification = 'Data Berhasil Dihapus';
                }
            } else {
                $notification = 'Data Tidak Ditemukan';
            }
        } else {
            $notification = 'Data Tidak Ada';
        }
        echo $notification;
        exit();
    }
    // ============================================== LAIN LAIN =======================================================
    public function getJadwal($page = 1)
    {

        $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
        $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $this->_addHeaderFiles();
        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        $status = '1';
        if (isset($_GET['status']))
            $status = $_GET['status'];

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        if ($this->core->getUserInfo('id') == 1) {
            $totalRecords = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', date('Y'))
                ->where('jadwal_pegawai.bulan', date('m'))
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->toArray();
        } else {
            $totalRecords = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', date('Y'))
                ->where('jadwal_pegawai.bulan', date('m'))
                ->where('nik', $username)
                // ->like('pegawai.nama', '%'.$phrase.'%')
                ->toArray();
        }
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'profil', 'jadwal', '%d']));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        if ($this->core->getUserInfo('id') == 1) {
            $rows = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', date('Y'))
                ->where('jadwal_pegawai.bulan', date('m'))
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        } else {
            $rows = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', date('Y'))
                ->where('jadwal_pegawai.bulan', date('m'))
                ->where('nik', $username)
                // ->like('pegawai.nama', '%'.$phrase.'%')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        }
        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                // $row['editURL'] = url([ADMIN, 'presensi', 'jadwaledit', $row['id']]);
                // $row['delURL']  = url([ADMIN, 'master', 'petugasdelete', $row['nip']]);
                // $row['restoreURL']  = url([ADMIN, 'master', 'petugasrestore', $row['nip']]);
                // $row['viewURL'] = url([ADMIN, 'master', 'petugasview', $row['nip']]);
                $this->assign['list'][] = $row;
            }
        }

        /*
        $year = date('Y');
        $month = date('m');
        // $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $day = $this->days_in_month($month, $year);

        for ($i = 1; $i < $day + 1; $i++) {
            $i;
        }
        */

        $this->assign['getStatus'] = isset($_GET['status']);
        // $this->assign['addURL'] = url([ADMIN, 'presensi', 'jadwaladd']);
        // $this->assign['printURL'] = url([ADMIN, 'master', 'petugasprint']);

        return $this->draw('jadwal.manage.html', ['jadwal' => $this->assign, 'array_hari' => $array_hari, 'array_bulan' => $array_bulan]);
    }

    public function getRekap_Presensi($page = 1)
    {
        $this->_addHeaderFiles();
        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        $status = '1';
        if (isset($_GET['status']))
            $status = $_GET['status'];

        $bulan = date('m');
        if (isset($_GET['b'])) {
            $bulan = $_GET['b'];
        }

      	$year = date('Y');
        if (isset($_GET['y'])) {
            $year = $_GET['y'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        if ($this->core->getUserInfo('id') == 1 and isset($_GET['b'])) {
            $totalRecords = $this->db('rekap_presensi')
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', date($year . '-' . $bulan) . '-01')
                ->where('jam_datang', '<=', date($year . '-' . $bulan) . '-32')
                ->like('nama', '%' . $phrase . '%')
                ->orLike('shift', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->toArray();
        } elseif (isset($_GET['b'])) {
            $totalRecords = $this->db('rekap_presensi')
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', date($year . '-' . $bulan) . '-01')
                ->where('jam_datang', '<=', date($year . '-' . $bulan) . '-32')
                ->where('nik', $username)
                ->asc('jam_datang')
                ->toArray();
        } else {
            $totalRecords = $this->db('rekap_presensi')
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', date($year . '-' . $bulan) . '-01')
                ->where('jam_datang', '<=', date($year . '-' . $bulan) . '-32')
                ->where('nik', $username)
                ->asc('jam_datang')
                ->toArray();
        }
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'profil', 'rekap_presensi', '%d?y=' . $year . '&b=' . $bulan . '&s=' . $phrase]));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();

        if ($this->core->getUserInfo('id') == 1 and isset($_GET['b'])) {
            $rows = $this->db('rekap_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'departemen' => 'pegawai.departemen',
                    'id' => 'rekap_presensi.id',
                    'shift' => 'rekap_presensi.shift',
                    'jam_datang' => 'rekap_presensi.jam_datang',
                    'jam_pulang' => 'rekap_presensi.jam_pulang',
                    'status' => 'rekap_presensi.status',
                    'durasi' => 'rekap_presensi.durasi',
                    'photo' => 'rekap_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', date($year . '-' . $bulan) . '-01')
                ->where('jam_datang', '<=', date($year . '-' . $bulan) . '-32')
                ->like('nama', '%' . $phrase . '%')
                ->orLike('shift', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        } elseif (isset($_GET['b'])) {
            $rows = $this->db('rekap_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'departemen' => 'pegawai.departemen',
                    'id' => 'rekap_presensi.id',
                    'shift' => 'rekap_presensi.shift',
                    'jam_datang' => 'rekap_presensi.jam_datang',
                    'jam_pulang' => 'rekap_presensi.jam_pulang',
                    'status' => 'rekap_presensi.status',
                    'durasi' => 'rekap_presensi.durasi',
                    'photo' => 'rekap_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', date($year . '-' . $bulan) . '-01')
                ->where('jam_datang', '<=', date($year . '-' . $bulan) . '-32')
                ->where('nik', $username)
                ->asc('jam_datang')
                ->toArray();
        } else {
            $rows = $this->db('rekap_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'departemen' => 'pegawai.departemen',
                    'id' => 'rekap_presensi.id',
                    'shift' => 'rekap_presensi.shift',
                    'jam_datang' => 'rekap_presensi.jam_datang',
                    'jam_pulang' => 'rekap_presensi.jam_pulang',
                    'status' => 'rekap_presensi.status',
                    'durasi' => 'rekap_presensi.durasi',
                    'photo' => 'rekap_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', date($year . '-' . $bulan) . '-01')
                ->where('jam_datang', '<=', date($year . '-' . $bulan) . '-32')
                ->where('nik', $username)
                ->asc('jam_datang')
                ->toArray();
        }

        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['mapURL']  = url([ADMIN, 'profil', 'googlemap', $row['id'], date('Y-m-d', strtotime($row['jam_datang']))]);
                $beritaAcara = url([ADMIN, 'profil', 'beritaacara', $row['id'], $bulan]);
                $cek = $this->db('rekap_ba')->where('id',$row['id'])->where('bulan',$bulan)->where('tahun',$year)->oneArray();
                $this->assign['list'][] = $row;
            }
        }

        $this->assign['rekapBkd'] = $this->db('bridging_bkd_presensi')->join('pegawai','pegawai.id = bridging_bkd_presensi.id')->where('pegawai.nik',$username)->where('bridging_bkd_presensi.bulan',$bulan)->where('bridging_bkd_presensi.tahun',$year)->oneArray();
        $this->assign['getStatus'] = isset($_GET['status']);
        $this->assign['getBulan'] = $bulan;
        $this->assign['getTahun'] = $year;
        $this->assign['beritaAcara'] = $beritaAcara;
        $this->assign['checkBa'] = $cek;
        $this->assign['getUser'] = $username;
        $this->assign['bulan'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $this->assign['tahun'] = array('', '2021', '2022', '2023', '2024');
        return $this->draw('rekap_presensi.html', ['rekap' => $this->assign]);
    }

    public function getGoogleMap($id, $tanggal)
    {
        $geo = $this->db('mlite_geolocation_presensi')->where('id', $id)->where('tanggal', $tanggal)->oneArray();
        $pegawai = $this->db('pegawai')->where('id', $id)->oneArray();

        $this->tpl->set('geo', $geo);
        $this->tpl->set('pegawai', $pegawai);
        echo $this->tpl->draw(MODULES . '/profil/view/admin/google_map.html', true);
        exit();
    }

    public function getBeritaAcara($id, $bulan)
    {
        $year = date('Y');
        $pegawai = $this->db('pegawai')->where('id', $id)->oneArray();
        $ba = $this->db('rekap_ba')->where('id', $id)->where('bulan', $bulan)->where('tahun', $year)->oneArray();
        $this->tpl->set('tahun', $year);
        $this->tpl->set('pegawai', $pegawai);
        $this->tpl->set('bulan', $bulan);
        $this->tpl->set('ba', $ba);
        echo $this->tpl->draw(MODULES . '/profil/view/admin/berita_acara.html', true);
        exit();
    }

    public function postRekapBkdSimpan($id = null)
    {
        $errors = 0;
        if (!$id) {
            $location = url([ADMIN, 'profil', 'rekap_presensi']);
        } else {
            $location = url([ADMIN, 'profil', 'rekap_presensi', $id, $_POST['bulan'], $_POST['tahun']]);
        }

        if (!$errors) {
            unset($_POST['save']);
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $_POST['updated_at'] = date('Y-m-d H:i:s');
            if (!$id) {
                $query = $this->db('rekap_bkd')->save($_POST);
                $query2 = $this->db('rekap_ba')->save($_POST);
            } else {
                $query = $this->db('rekap_bkd')->where('id', $id)->where('tahun', $_POST['tahun'])->where('bulan', $_POST['bulan'])->save($_POST);
                $query = $this->db('rekap_ba')->where('id', $id)->where('tahun', $_POST['tahun'])->where('bulan', $_POST['bulan'])->save($_POST);
            }
            if ($query) {
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }
            redirect($location);
            print_r($_POST);
            print_r($query);
        }

        redirect($location, $_POST);
    }

    public function getPresensi($page = 1)
    {
        $this->_addHeaderFiles();

        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        if ($this->core->getUserInfo('id') == 1) {
            $totalRecords = $this->db('temporary_presensi')
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->like('nama', '%' . $phrase . '%')
                // ->orLike('jam_datang', '%'.date('Y-m').'%')
                ->asc('jam_datang')
                ->toArray();
        } else {
            $totalRecords = $this->db('temporary_presensi')
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->where('nik', $username)
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->toArray();
        }
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'presensi', '%d']));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        if ($this->core->getUserInfo('id') == 1) {
            $rows = $this->db('temporary_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'id' => 'temporary_presensi.id',
                    'shift' => 'temporary_presensi.shift',
                    'jam_datang' => 'temporary_presensi.jam_datang',
                    'status' => 'temporary_presensi.status',
                    'photo' => 'temporary_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        } else {
            $rows = $this->db('temporary_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'id' => 'temporary_presensi.id',
                    'shift' => 'temporary_presensi.shift',
                    'jam_datang' => 'temporary_presensi.jam_datang',
                    'status' => 'temporary_presensi.status',
                    'photo' => 'temporary_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->where('nik', $username)
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        }
        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['mapURL']  = url([ADMIN, 'profil', 'googlemap', $row['id'], date('Y-m-d', strtotime($row['jam_datang']))]);
                $this->assign['list'][] = $row;
            }
        }

        return $this->draw('presensi.html', ['presensi' => $this->assign]);
    }

    public function getGanti_Pass()
    {
        $this->_addHeaderFiles();
        $username = $this->core->getUserInfo('username', null, true);
        $this->assign['username'] = $username;
        $this->assign['title'] = 'Ganti Password';

        return $this->draw('ganti_pass.html', ['ganti_pass' => $this->assign]);
    }

    public function postGanti_Save($id = null)
    {
        $errors = 0;

        $row_user = $this->db('mlite_users')->where('id', $this->core->getUserInfo('id'))->oneArray();

        // location to redirect
        if (!$id) {
            $location = url([ADMIN, 'profil', 'ganti_pass']);
        } else {
            $location = url([ADMIN, 'profil', 'ganti_pass', $id]);
        }

        // check if required fields are empty
        if (checkEmptyFields(['pass_lama', 'pass_baru'], $_POST)) {
            $this->notify('failure', 'Isian kosong');
            redirect($location, $_POST);
        }

        // check if password is longer than 5 characters
        if ($_POST['pass_baru'] == $_POST['pass_lama']) {
            $errors++;
            $this->notify('failure', 'Kata kunci sama');
        }

        // CREATE / EDIT
        if (!$errors) {
            unset($_POST['save']);

            if ($row_user && password_verify(trim($_POST['pass_lama']), $row_user['password'])) {
                $password = password_hash($_POST['pass_baru'], PASSWORD_BCRYPT);
                $query = $this->db('mlite_users')->where('id', $this->core->getUserInfo('id'))->save(['password' => $password]);
            }

            if ($query) {
                $this->notify('success', 'Simpan sukses');
            } else {
                $this->notify('failure', 'Kata kunci lama salah');
            }

            redirect($location);
        }

        redirect($location, $_POST);
    }

<<<<<<< HEAD
    public function postBridgingBkd()
    {
        $jadwal = 0;
        $jml_pot_tl1 = 0;
        $jml_pot_tl2 = 0;
        $jml_pot_tl3 = 0;
        $jml_pot_tl4 = 0;
        $jml_pot_psw1 = 0;
        $jml_pot_psw2 = 0;
        $jml_pot_psw3 = 0;
        $jml_pot_psw4 = 0;
        $year = $_POST['tahun'];
        $biodata = $this->db('pegawai')->select(['id' => 'id', 'nama' => 'nama', 'nip' => 'nik', 'status' => 'stts_kerja'])->where('nik', $_POST['nik'])->oneArray();
        // $day = cal_days_in_month(CAL_GREGORIAN, $_POST['bulan'], $year);
        $day = $this->days_in_month($_POST['bulan'], $year);
        for ($i = 1; $i <= $day; $i++) {
            $jad = $this->db('jadwal_pegawai')->select('h' . $i)->where('id', $biodata['id'])->where('tahun', $year)->where('bulan', $_POST['bulan'])->oneArray();
            if ($jad['h' . $i] != "") {
                $jadwal = $jadwal + 1;
            }
        }
        // $absen = $this->db('rekap_presensi')->where('id', $biodata['id'])->where('jam_datang', 'LIKE', $year . '-' . $_POST['bulan'] . '%')->toArray();
        $jlh = count($_POST['shift']);

        // $no = 1;
        for ($i = 0; $i < count($_POST['shift']); $i++) {
            $jamMasukShift = $this->db('jam_jaga')->where('shift', $_POST['shift'][$i])->oneArray();
            if (strtotime($_POST['jam_datang'][$i]) > strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) {
                if ((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) > (10 * 60) && (strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) < (31 * 60)) {
                    $jml_pot_tl1 = $jml_pot_tl1 + 1;
                }
                if ((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) > (30 * 60) && (strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) < (61 * 60)) {
                    $jml_pot_tl2 = $jml_pot_tl2 + 1;
                }
                if ((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) > (60 * 60) && (strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) < (91 * 60)) {
                    $jml_pot_tl3 = $jml_pot_tl3 + 1;
                }
                if ((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_masuk'])) > (90 * 60)) {
                    $jml_pot_tl4 = $jml_pot_tl4 + 1;
                }
            }
            if (strtotime($_POST['jam_pulang'][$i]) < strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang'])) {
                if ((strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (10 * 60) && (strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) < (31 * 60)) {
                    $jml_pot_psw1 = $jml_pot_psw1 + 1;
                }
                if ((strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (30 * 60) && (strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) < (61 * 60)) {
                    $jml_pot_psw2 = $jml_pot_psw2 + 1;
                }
                if ((strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (60 * 60) && (strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) < (91 * 60)) {
                    $jml_pot_psw3 = $jml_pot_psw3 + 1;
                }
                if ((strtotime(substr($_POST['jam_pulang'][$i], 0, 10) . ' ' . $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (90 * 60)) {
                    $jml_pot_psw4 = $jml_pot_psw4 + 1;
                }
            }
        }

        $jml_pot_tl1 = $jml_pot_tl1 * (0.5 / 100);
        $jml_pot_tl2 = $jml_pot_tl2 * (1 / 100);
        $jml_pot_tl3 = $jml_pot_tl3 * (1.25 / 100);
        $jml_pot_tl4 = $jml_pot_tl4 * (1.5 / 100);
        $jml_pot_terlambat = $jml_pot_tl1 + $jml_pot_tl2 + $jml_pot_tl3 + $jml_pot_tl4;

        $jml_pot_psw1 = $jml_pot_psw1 * (0.5 / 100);
        $jml_pot_psw2 = $jml_pot_psw2 * (1 / 100);
        $jml_pot_psw3 = $jml_pot_psw3 * (1.25 / 100);
        $jml_pot_psw4 = $jml_pot_psw4 * (1.5 / 100);
        $jml_pot_pulang = $jml_pot_psw1 + $jml_pot_psw2 + $jml_pot_psw3 + $jml_pot_psw4;

        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $cekTanggal = $date->format('Y-m-d');
        $cekMalam = $this->db('temporary_presensi')->where('id', $biodata['id'])->like('jam_datang', '%' . $cekTanggal . '%')->like('shift', '%malam%')->oneArray();
        if ($cekMalam) {
            $jlh = $jlh + 1;
        }

        $cekBkd = $this->db('bridging_bkd_presensi')->where('id', $biodata['id'])->where('bulan', $_POST['bulan'])->where('tahun', $year)->oneArray();
        if (!$cekBkd) {
            $query = $this->db('bridging_bkd_presensi')->save([
                'id' => $biodata['id'],
                'nama' => $biodata['nama'],
                'nip' => $biodata['nip'],
                'tahun' => $year,
                'bulan' => $_POST['bulan'],
                'jumlah_kehadiran' => $jlh,
                'jumlah_hari_kerja' => $jadwal,
                'persentase_hari_kerja' => '1',
                'jml_pot_keterlambatan' => $jml_pot_terlambat,
                'jml_pot_pulang_lebih_awal' => $jml_pot_pulang,
                'status' => $biodata['status'],
            ]);
        } else {
            $query = $this->db('bridging_bkd_presensi')->where('id', $biodata['id'])->where('bulan', $_POST['bulan'])->where('tahun', $year)->update([
                'jumlah_kehadiran' => $jlh,
                'jumlah_hari_kerja' => $jadwal,
                'persentase_hari_kerja' => '1',
                'jml_pot_keterlambatan' => $jml_pot_terlambat,
                'jml_pot_pulang_lebih_awal' => $jml_pot_pulang,
            ]);
        }

        $cekBkd = $this->db('bridging_bkd_presensi')->where('id', $biodata['id'])->where('bulan', $_POST['bulan'])->where('tahun', $year)->oneArray();
        if ($cekBkd) {
            echo 200;
        } else {
            echo 201;
        }
        exit();
    }

    private function days_in_month($month, $year)
    {
        // calculate number of days in a month
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public function getCuti()
    {
        $this->_addHeaderFiles();
        $this->assign['title'] = 'Pengajuan Izin & Cuti';
        $this->assign['nik'] = $this->core->getUserInfo('username', null, true);
        $this->assign['list'] = $this->db('izin_cuti')->where('nip',$this->assign['nik'])->desc('id')->toArray();
        $this->assign['pilihCuti'] = array('0'=>'-- Pilih Izin --','1' => 'Cuti Tahunan', '2'=>'Cuti Besar', '3'=>'Cuti Sakit', '4'=>'Cuti Melahirkan', '5'=>'Cuti Karena Alasan Penting', '6'=>'Cuti Di Luar Tanggungan Negara', '7'=>'Izin');
        $username = $this->core->getUserInfo('username', null, true);

      return $this->draw('cuti.html',['cuti' => $this->assign, 'username'=> $username]);
    }

    public function postSimpanCuti()
    {
        $numberDays = '';
        $kodeSurat = '';
        $noSurat = '01';
        $noCuti = '';
        $cutiTahunan = 12;
        $sisaCuti = '';
        $location = url([ADMIN, 'profil', 'cuti']);

        $tanggalAwal = strtotime($_POST['tanggal_awal']);
        $tanggalAkhir = strtotime($_POST['tanggal_akhir']);
        $timeDiff = abs($tanggalAkhir - $tanggalAwal);
        $numberDays = $timeDiff/86400;
        $numberDays = $numberDays + 1;
        $tahun = date('Y',$tanggalAwal);

        $jenisCuti = $_POST['jenis_cuti'];
        $noSurat = $this->db()->pdo()->prepare("SELECT max(SUBSTRING(no_surat, 5, 2)) FROM izin_cuti WHERE jenis_cuti = '$jenisCuti'");
        $noSurat->execute();
        $noSurat = $noSurat->fetch();
        $noSurat = sprintf('%02s', ($noSurat[0] + 1));

        switch ($_POST['jenis_cuti']) {
            case '1':
                $kodeSurat = '851';
                $noCuti = $kodeSurat.'/'.$noSurat.'/'.'RSUD-UMPEG'.'/'.date('Y');
                $sisaCuti = $cutiTahunan - $numberDays;
                break;
            case '5':
                $kodeSurat = '850';
                $noCuti = $kodeSurat.'/'.$noSurat.'/'.'RSUD-UMPEG'.'/'.date('Y');
                break;
            case '4':
                $kodeSurat = '854';
                $noCuti = $kodeSurat.'/'.$noSurat.'/'.'RSUD-UMPEG'.'/'.date('Y');
                break;

            default:
                $noCuti = '';
                break;
        }

        $lastId = $this->db('izin_cuti')->lastInsertId();
        $this->db('izin_cuti')->save([
            'id' => $lastId,
            'nip' => $_POST['nip'],
            'jenis_cuti' => $_POST['jenis_cuti'],
            'alasan' => $_POST['alasan'],
            'no_telp' => $_POST['telp'],
            'lama' => $numberDays,
            'sisa_cuti_tahunan' => $sisaCuti,
            'tahun' => $tahun,
            'tgl_buat' => $_POST['tanggal_buat'],
            'tgl_awal' => $_POST['tanggal_awal'],
            'tgl_akhir' => $_POST['tanggal_akhir'],
            'alamat' => $_POST['alamat'],
            'tgl_surat' => date('Y-m-d'),
            'no_surat' => $noCuti,
            'status' => 'Belum Disetujui',
            'pengganti_visite' =>  $_POST['pengganti_visite'],
            'created_at' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if (!$lastId) {
            $this->notify('success', 'Simpan sukses');
        } else {
            $this->notify('failure', 'Gagal Simpan');
        }
        redirect($location);
        exit();
    }


    public function getEditCuti($id)
    {
        $this->_addHeaderFiles();

        $cuti = $this->db('izin_cuti')->where('id', $id)->oneArray();
        //$pegawai = $this->db('pegawai')->select('departemen')->where('nik', $id)->oneArray();
        $username = $this->core->getUserInfo('username', null, true);
        // $pilihCuti = array('0'=>'-- Pilih Izin --','1' => 'Cuti Tahunan', '2'=>'Cuti Besar', '3'=>'Cuti Sakit', '4'=>'Cuti Melahirkan', '5'=>'Cuti Karena Alasan Penting', '6'=>'Cuti Di Luar Tanggungan Negara', '7'=>'Izin');
        $this->tpl->set('cuti', $cuti);
        $this->tpl->set('username', $username);

        echo $this->tpl->draw(MODULES . '/profil/view/admin/edit.cuti.html', true);
        exit();
    }

    public function postEditCuti()
    {

        $this->_addHeaderFiles();

        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));

        $numberDays = '';
        // $kodeSurat = '';
        // $noSurat = '';
        // $noCuti = '';
        $cutiTahunan = 12;
        $sisaCuti = '';
        $location = url([ADMIN, 'profil', 'cuti']);

        $tanggalAwal = strtotime($_POST['tanggal_awal']);
        $tanggalAkhir = strtotime($_POST['tanggal_akhir']);
        $timeDiff = abs($tanggalAkhir - $tanggalAwal);
        $numberDays = $timeDiff / 86400;
        $numberDays = $numberDays + 1;
        $tahun = date('Y', $tanggalAwal);

        $id = $_POST['id'];
        $errors = 0;

        $query = $this->db('izin_cuti')
            ->where('id', $id)
            ->save([
                // 'nip' => $_POST['nik'],
                //'jenis_cuti' => $_POST['jenis_cuti'],
                'alasan' => $_POST['alasan'],
                'no_telp' => $_POST['telp'],
                'lama' => $numberDays,
                'sisa_cuti_tahunan' => $sisaCuti,
                'tahun' => $tahun,
                'tgl_buat' => $_POST['tanggal_buat'],
                'tgl_awal' => $_POST['tanggal_awal'],
                'tgl_akhir' => $_POST['tanggal_akhir'],
                'alamat' => $_POST['alamat'],
                'tgl_surat' => date('Y-m-d'),
                //'no_surat' => $noCuti,
                'created_at' => null,
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'Belum Disetujui',
                'pengganti_visite' => $_POST['pengganti_visite'],
                'keterangan' => $_POST['keterangan'],
            ]);
        if ($query) {
            $this->notify('success', 'Data Berhasil Update');
        } else {
            $this->notify('failure', 'Gagal Update');
        }
        redirect($location);
    }


    public function getCetakIzin($id)
    {
        $cuti_pegawai = $this->db('izin_cuti')
            ->select([
                'tgl_buat' => 'izin_cuti.tgl_buat',
                'tgl_awal' => 'izin_cuti.tgl_awal',
                'tgl_akhir' => 'izin_cuti.tgl_akhir',
                'lama'     => 'izin_cuti.lama',
                'alasan'   => 'izin_cuti.alasan',
                'nama'     => 'pegawai.nama',
                'jbtn'     => 'pegawai.jbtn',
                'bidang'   => 'pegawai.bidang',
                'nip' => 'pegawai.nik',
                'stts_kerja' => 'pegawai.stts_kerja'

            ])

            ->join('pegawai', 'pegawai.nik = izin_cuti.nip')
            ->where('izin_cuti.id', $id)
            ->oneArray();

        $tanggal_buat = $cuti_pegawai['tgl_buat'];
        $date = dateIndonesia(date('Y-m-d', strtotime($tanggal_buat)));

        $tanggal_awal = $cuti_pegawai['tgl_awal'];
        $date1 = dateIndonesia(date('Y-m-d', strtotime($tanggal_awal)));

        $tanggal_akhir = $cuti_pegawai['tgl_akhir'];
        $date2 = dateIndonesia(date('Y-m-d', strtotime($tanggal_akhir)));

        $tentukan_hari1 = date('D', strtotime($tanggal_awal));
        $day = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $hari1 = $day[$tentukan_hari1];

        $tentukan_hari2 = date('D', strtotime($tanggal_akhir));
        $hari2 = $day[$tentukan_hari2];

        $nama2 = $cuti_pegawai['nama'];
        $nip2 = $cuti_pegawai['nip'];

        $lama = $cuti_pegawai['lama'];
        $hari = $lama > 1 ? $hari1 . ' s.d ' . $hari2 : ($lama = 1 ? $hari1 : '');
        echo $hari;

        $tanggal = $lama > 1 ? $date1 . ' s.d ' . $date2 : ($lama = 1 ? $date1 : '');
        echo $tanggal;

        $stts_kerja = $cuti_pegawai['stts_kerja'];
        $ft = 'FT';
        $pns = 'PNS';

        $stts = $stts_kerja != $ft ? 'Direktur RSUD H. Damanhuri Barabai' : ($stts_kerja = $ft ? 'Kepala Bagian Tata Usaha' : '');
        echo $stts;

        $nm_kepala = $stts_kerja != $pns ? 'Hernadi, SKM' : ($stts_kerja = $pns ? 'dr. Nanda Sujud Andi Yudha Utama, Sp. B' : '');
        echo $nm_kepala;

        $nip_kpl1 = '';
        $nip_kpl2 = '';

        switch ($cuti_pegawai['stts_kerja']) {
            case 'FT':
                $nip_kpl1 = '19710301 199101 1 003';
                break;
            case 'PNS':
                $nip_kpl2 = '19840920 201001 1 007';
                break;

            default:
                $nip_kpl1 = '';
                $nip_kpl2 = '';
                break;
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(MODULES . '/profil/template/cetakIzin.docx');
        $templateProcessor->setValues([
            'nama'      => $cuti_pegawai['nama'],
            'nip'      => $cuti_pegawai['nip'],
            'jbtn'     => $cuti_pegawai['jbtn'],
            'hari'     => $hari,
            'tgl_buat' => $date,
            'tgl_awal' => $tanggal,
            'lama'     => $cuti_pegawai['lama'],
            'alasan'   => $cuti_pegawai['alasan'],
            'bidang'   => $cuti_pegawai['bidang'],
            'nama2'    => $nama2,
            'nip2'     => $nip2,
            'stts_kerja' => $cuti_pegawai['stts_kerja'],
            'stts'       => $stts,
            'nm_kepala'  => $nm_kepala,
            'nip_kpl1'   => $nip_kpl1,
            'nip_kpl2'   => $nip_kpl2

        ]);
        $file = "Surat_Izin_" . date("d-m-Y") . ".docx";
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $templateProcessor->saveAs('php://output');
        exit();
    }

    public function getCetakCuti($id)
    {
        $cuti_pegawai = $this->db('izin_cuti')
            ->select([
                'tgl_buat'            => 'izin_cuti.tgl_buat',
                'tgl_awal'            => 'izin_cuti.tgl_awal',
                'tgl_akhir'           => 'izin_cuti.tgl_akhir',
                'lama'                => 'izin_cuti.lama',
                'alasan'              => 'izin_cuti.alasan',
                'sisa_cuti_tahunan'   => 'izin_cuti.sisa_cuti_tahunan',
                'alamat'              => 'izin_cuti.alamat',
                'no_telp'             => 'izin_cuti.no_telp',
                'jenis_cuti'          => 'izin_cuti.jenis_cuti',
                'nama'                => 'pegawai.nama',
                'jbtn'                => 'pegawai.jbtn',
                'nip'                 => 'pegawai.nik',
                'bidang'              => 'pegawai.bidang',
                // 'ms_kerja'            => 'pegawai.ms_kerja'
                //'username'            => 'mlite_users.username'

            ])

            ->join('pegawai', 'pegawai.nik = izin_cuti.nip')
            // ->join('mlite_users', 'mlite_users.fullname = pegawai.nama')
            ->where('izin_cuti.id', $id)
            ->oneArray();

        $tanggal_buat = $cuti_pegawai['tgl_buat'];
        $date = dateIndonesia(date('Y-m-d', strtotime($tanggal_buat)));

        $tanggal_awal = $cuti_pegawai['tgl_awal'];
        $date1 = dateIndonesia(date('Y-m-d', strtotime($tanggal_awal)));

        $tanggal_akhir = $cuti_pegawai['tgl_akhir'];
        $date2 = dateIndonesia(date('Y-m-d', strtotime($tanggal_akhir)));

        $jns1 = '';
        $jns2 = '';
        $jns3 = '';
        $jns4 = '';
        $jns5 = '';
        $jns6 = '';

        switch ($cuti_pegawai['jenis_cuti']) {
            case '1':
                $jns1 = 'YA';
                break;
            case '2':
                $jns2 = 'YA';
                break;
            case '3':
                $jns3 = 'YA';
                break;
            case '4':
                $jns4 = 'YA';
                break;
            case '5':
                $jns5 = 'YA';
                break;
            case '6':
                $jns6 = 'YA';
                break;

            default:
                $jns1 = '';
                $jns2 = '';
                $jns3 = '';
                $jns4 = '';
                $jns5 = '';
                $jns6 = '';
                break;
        }

        $nama2 = $cuti_pegawai['nama'];
        $nip2 = $cuti_pegawai['nip'];

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(MODULES . '/profil/template/cetakCuti.docx');
        $templateProcessor->setValues([
            'nama'              => $cuti_pegawai['nama'],
            'nip'               => $cuti_pegawai['nip'],
            'jbtn'              => $cuti_pegawai['jbtn'],
            'bidang'            => $cuti_pegawai['bidang'],
            'ms_kerja'          => $cuti_pegawai['ms_kerja'],
            'alasan'            => $cuti_pegawai['alasan'],
            'lama'              => $cuti_pegawai['lama'],
            'alamat'            => $cuti_pegawai['alamat'],
            'tgl_buat'          => $date,
            'tgl_awal'          => $date1,
            'tgl_akhir'         => $date2,
            'sisa_cuti_tahunan' => $cuti_pegawai['sisa_cuti_tahunan'],
            'no_telp'           => $cuti_pegawai['no_telp'],
            'nama2'             => $nama2,
            'nip2'              => $nip2,
            'jns1'              => $jns1,
            'jns2'              => $jns2,
            'jns3'              => $jns3,
            'jns4'              => $jns4,
            'jns5'              => $jns5,
            'jns6'              => $jns6

        ]);

        $file = "Surat_Cuti_" . date("d-m-Y") . ".docx";
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $templateProcessor->saveAs('php://output');
        exit();
    }

    public function getIzinDok($id)
    {
        $cuti_pegawai = $this->db('izin_cuti')
            ->select([
                'tgl_buat'         => 'izin_cuti.tgl_buat',
                'tgl_awal'         => 'izin_cuti.tgl_awal',
                'tgl_akhir'        => 'izin_cuti.tgl_akhir',
                'lama'             => 'izin_cuti.lama',
                'alasan'           => 'izin_cuti.alasan',
                'pengganti_visite' => 'izin_cuti.pengganti_visite',
                'nama'             => 'pegawai.nama',
                'jbtn'             => 'pegawai.jbtn',
                'bidang'           => 'pegawai.bidang',
                'nip'              => 'pegawai.nik',
                'departemen'       => 'pegawai.departemen',
               // 'nipk_baru'        => 'pegawai_mapping.nipk_baru'
            ])

            ->join('pegawai', 'pegawai.nik = izin_cuti.nip')
           // ->join('pegawai_mapping', 'pegawai_mapping.nipk = pegawai.nik')
            ->where('izin_cuti.id', $id)
            ->oneArray();

        $tanggal_buat = $cuti_pegawai['tgl_buat'];
        $date = dateIndonesia(date('Y-m-d', strtotime($tanggal_buat)));

        $tanggal_awal = $cuti_pegawai['tgl_awal'];
        $date1 = dateIndonesia(date('Y-m-d', strtotime($tanggal_awal)));

        $tanggal_akhir = $cuti_pegawai['tgl_akhir'];
        $date2 = dateIndonesia(date('Y-m-d', strtotime($tanggal_akhir)));

        $tentukan_hari1 = date('D', strtotime($tanggal_awal));
        $day = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $hari1 = $day[$tentukan_hari1];

        $tentukan_hari2 = date('D', strtotime($tanggal_akhir));
        $hari2 = $day[$tentukan_hari2];

        $nama2 = $cuti_pegawai['nama'];
        // $nip2 = $cuti_pegawai['nipk_baru'];
        $nip2 = $cuti_pegawai['nip'];

        $lama = $cuti_pegawai['lama'];
        $hari = $lama > 1 ? $hari1 . ' s.d ' . $hari2 : ($lama = 1 ? $hari1 : '');
        echo $hari;

        $tanggal = $lama > 1 ? $date1 . ' s.d ' . $date2 : ($lama = 1 ? $date1 : '');
        echo $tanggal;

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(MODULES . '/profil/template/izinDok.docx');
        $templateProcessor->setValues([
            'nama'             => $cuti_pegawai['nama'],
            'nip'              => $cuti_pegawai['nip'],
            // 'nip'              => $cuti_pegawai['nipk_baru'],
            'jbtn'             => $cuti_pegawai['jbtn'],
            'hari'             => $hari,
            'tgl_buat'         => $date,
            'tgl_awal'         => $tanggal,
            'lama'             => $cuti_pegawai['lama'],
            'alasan'           => $cuti_pegawai['alasan'],
            'bidang'           => $cuti_pegawai['bidang'],
            'nama2'            => $nama2,
            'nip2'             => $nip2,
            //'pengganti_visite' => $dokpen
            'pengganti_visite' => $cuti_pegawai['pengganti_visite']

        ]);
        $file = "Surat_Izin_Dokter" . date("d-m-Y") . ".docx";
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $templateProcessor->saveAs('php://output');
        exit();
    }

    public function getCutiDok($id)
    {
        $cuti_pegawai = $this->db('izin_cuti')
            ->select([
                'tgl_buat'         => 'izin_cuti.tgl_buat',
                'tgl_awal'         => 'izin_cuti.tgl_awal',
                'tgl_akhir'        => 'izin_cuti.tgl_akhir',
                'lama'             => 'izin_cuti.lama',
                'alasan'           => 'izin_cuti.alasan',
                'sisa_cuti_tahunan'=> 'izin_cuti.sisa_cuti_tahunan',
                'alamat'           => 'izin_cuti.alamat',
                'no_telp'          => 'izin_cuti.no_telp',
                'jenis_cuti'       => 'izin_cuti.jenis_cuti',
                'pengganti_visite' => 'izin_cuti.pengganti_visite',
                'nama'             => 'pegawai.nama',
                'jbtn'             => 'pegawai.jbtn',
                'nip'              => 'pegawai.nik',
                'bidang'           => 'pegawai.bidang',
                'departemen'       => 'pegawai.departemen',
                //'nipk_baru'        => 'pegawai_mapping.nipk_baru'
            ])

            ->join('pegawai', 'pegawai.nik = izin_cuti.nip')
            //->join('pegawai_mapping', 'pegawai_mapping.nipk = pegawai.nik')
            ->where('izin_cuti.id', $id)
            ->oneArray();

        $tanggal_buat = $cuti_pegawai['tgl_buat'];
        $date = dateIndonesia(date('Y-m-d', strtotime($tanggal_buat)));

        $tanggal_awal = $cuti_pegawai['tgl_awal'];
        $date1 = dateIndonesia(date('Y-m-d', strtotime($tanggal_awal)));

        $tanggal_akhir = $cuti_pegawai['tgl_akhir'];
        $date2 = dateIndonesia(date('Y-m-d', strtotime($tanggal_akhir)));

        $jns1 = '';
        $jns2 = '';
        $jns3 = '';
        $jns4 = '';
        $jns5 = '';
        $jns6 = '';

        switch ($cuti_pegawai['jenis_cuti']) {
            case '1':
                $jns1 = 'YA';
                break;
            case '2':
                $jns2 = 'YA';
                break;
            case '3':
                $jns3 = 'YA';
                break;
            case '4':
                $jns4 = 'YA';
                break;
            case '5':
                $jns5 = 'YA';
                break;
            case '6':
                $jns6 = 'YA';
                break;

            default:
                $jns1 = '';
                $jns2 = '';
                $jns3 = '';
                $jns4 = '';
                $jns5 = '';
                $jns6 = '';
                break;
        }

        $nama2 = $cuti_pegawai['nama'];
        $nip2 = $cuti_pegawai['nip'];
       // $nip2 = $cuti_pegawai['nipk_baru'];

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(MODULES . '/profil/template/cutiDok.docx');
        $templateProcessor->setValues([
            'nama'              => $cuti_pegawai['nama'],
            'nip'               => $cuti_pegawai['nip'],
           // 'nip'               => $cuti_pegawai['nipk_baru'],
            'jbtn'              => $cuti_pegawai['jbtn'],
            'bidang'            => $cuti_pegawai['bidang'],
            'ms_kerja'          => $cuti_pegawai['ms_kerja'],
            'alasan'            => $cuti_pegawai['alasan'],
            'lama'              => $cuti_pegawai['lama'],
            'alamat'            => $cuti_pegawai['alamat'],
            'pengganti_visite'  => $cuti_pegawai['pengganti_visite'],
            'tgl_buat'          => $date,
            'tgl_awal'          => $date1,
            'tgl_akhir'         => $date2,
            'sisa_cuti_tahunan' => $cuti_pegawai['sisa_cuti_tahunan'],
            'no_telp'           => $cuti_pegawai['no_telp'],
            'nama2'             => $nama2,
            'nip2'              => $nip2,
            'jns1'              => $jns1,
            'jns2'              => $jns2,
            'jns3'              => $jns3,
            'jns4'              => $jns4,
            'jns5'              => $jns5,
            'jns6'              => $jns6,

        ]);

        $file = "Surat_Cuti_Dokter" . date("d-m-Y") . ".docx";
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $templateProcessor->saveAs('php://output');
        exit();
    }

     public function getPermintaanPerbaikan()
    {
        $this->_addHeaderFiles();
        $this->assign['title'] = 'Permintaan Perbaikan Barang';
        $this->assign['form'] = [ 'no_permintaan' => $this->setNoPermintaan(),
                                  'no_inventaris' => '',
                                  'nik' => '',
                                  'tanggal' => '',
                                  'deskripsi_kerusakan' => ''];
        // $this->assign['aset'] = $this->db('inventaris')->join('inventaris_barang', 'inventaris_barang.kode_barang=inventaris.kode_barang')->toArray();
        $this->assign['nik'] = $this->core->getUserInfo('username', null, true);
        $this->assign['aset'] = $this->db('inventaris')
                                ->join('inventaris_barang', 'inventaris_barang.kode_barang=inventaris.kode_barang')
                                ->join('inventaris_merk', 'inventaris_merk.id_merk=inventaris_barang.id_merk')
                                ->join('inventaris_ruang', 'inventaris_ruang.id_ruang=inventaris.id_ruang')
                                ->asc('inventaris_barang.nama_barang')
                                ->toArray();
        // $this->assign['list'] = $this->db('permintaan_perbaikan_inventaris')->where('nik', $this->assign['nik'])->desc('no_permintaan')->toArray();
   
        // $sql = "SELECT * FROM `permintaan_perbaikan_inventaris` WHERE nik='{$this->assign['nik']}'";
        $sql = "SELECT permintaan_perbaikan_inventaris.*, 
                    inventaris.*, 
                    inventaris_barang.*, 
                    inventaris_merk.*, 
                    inventaris_ruang.* 
                FROM permintaan_perbaikan_inventaris, 
                    inventaris, inventaris_barang, 
                    inventaris_merk, 
                    inventaris_ruang 
                WHERE permintaan_perbaikan_inventaris.no_inventaris = inventaris.no_inventaris 
                AND inventaris_barang.kode_barang=inventaris.kode_barang 
                AND inventaris_barang.id_merk=inventaris_merk.id_merk 
                AND inventaris.id_ruang=inventaris_ruang.id_ruang 
                AND permintaan_perbaikan_inventaris.nik='{$this->assign['nik']}'";

        $stmt = $this->db()->pdo()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $this->assign['list'] = [];
        foreach ($rows as $row) {
            $perbaikan_inventaris = $this->db('perbaikan_inventaris')
            ->where('no_permintaan', $row['no_permintaan'])
            ->oneArray();
            $row['status_perbaikan'] = 'Belum';
          if($perbaikan_inventaris) {
            $row['status_perbaikan'] = 'Sudah';
          }

          // $inventaris =$this->db('inventaris')->join('inventaris_barang', 'inventaris_barang.kode_barang=inventaris.kode_barang')->where('no_inventaris', $row['no_inventaris'])->oneArray();
          // $row['nama_barang'] = $inventaris['nama_barang'];

          $this->assign['list'][] = $row;
        }
        // $row['ubah'] = url([ADMIN,'inventaris','permintaanperbaikanubah',$row['no_permintaan']]);

      return $this->draw('form.permintaan.perbaikan.html',['permintaanperbaikan' => $this->assign]);
    }

    public function postPermintaanPerbaikanSimpan($no_permintaan = null)
  {

    $errors = 0;
  
    $location = url([ADMIN, 'profil', 'permintaanperbaikan']);

    if (!$this->db('permintaan_perbaikan_inventaris')->where('no_permintaan', $no_permintaan)->oneArray()) {    // new
        $query = $this->db('permintaan_perbaikan_inventaris')->save(
          [
            'no_permintaan' => $_POST['no_permintaan'],
            'no_inventaris' => $_POST['no_inventaris'],
            'nik' => $_POST['nip'],
            'tanggal' => $_POST['tanggal'],
            'deskripsi_kerusakan' => $_POST['deskripsi_kerusakan']
          ]
        );
     } 
    // else {        // edit
    //     $query = $this->db('permintaan_perbaikan_inventaris')->where('no_permintaan', $no_permintaan)->save(
    //       [
    //         'no_inventaris' => $_POST['no_inventaris'],
    //         'nik' => $_POST['nip'],
    //         'tanggal' => $_POST['tanggal'],
    //         'deskripsi_kerusakan' => $_POST['deskripsi_kerusakan']
    //       ]
    //     );
    // }

    if ($query) {
        $this->notify('success', 'Permintaan perbaikan inventaris berhasil disimpan.');
    } else {
        $this->notify('failure', 'Gagal menyimpan permintaan perbaikan inventaris.');
    }

    redirect($location, $_POST);
  }

   public function getEditPermintaanPerbaikan($no_permintaan)
    {
        $this->_addHeaderFiles();
        $permintaanperbaikan = $this->db('permintaan_perbaikan_inventaris')->where('no_permintaan', $no_permintaan)->oneArray();
        $aset =  $this->db('inventaris')
            
            ->join('inventaris_barang', 'inventaris_barang.kode_barang=inventaris.kode_barang')
                                ->join('inventaris_merk', 'inventaris_merk.id_merk=inventaris_barang.id_merk')
                                ->join('inventaris_ruang', 'inventaris_ruang.id_ruang=inventaris.id_ruang')
                                ->asc('inventaris_barang.nama_barang')
                                ->toArray();
        $this->tpl->set('permintaanperbaikan', $permintaanperbaikan);
        $this->tpl->set('aset', $aset);

        echo $this->tpl->draw(MODULES . '/profil/view/admin/edit.permintaanperbaikan.html', true);
        exit();
    }

      public function postEditPermintaanPerbaikan()
    {

        $this->_addHeaderFiles();

        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));

        $location = url([ADMIN, 'profil', 'permintaanperbaikan']);
        $no_permintaan = $_POST['no_permintaan'];
        $errors = 0;

        $query = $this->db('permintaan_perbaikan_inventaris')
            ->where('no_permintaan', $no_permintaan)
            ->save([
                'no_inventaris' => $_POST['no_inventaris'],
                'nik' => $_POST['nip'],
                'tanggal' => $_POST['tanggal'],
                'deskripsi_kerusakan' => $_POST['deskripsi_kerusakan']
            ]);
        if ($query) {
            $this->notify('success', 'Data Permintaan Perbaikan Berhasil Update');
        } else {
            $this->notify('failure', 'Gagal Update permintaan perbaikan inventaris');
        }
        redirect($location);
    }

  //  public function getEditPermintaanPerbaikan($no_permintaan)
  // {
  //   $this->_addHeaderFiles();
  //   $this->assign['title'] = 'Permintaan Perbaikan Barang';
  //   $this->assign['form'] = $this->db('permintaan_perbaikan_inventaris')
  //     ->where('no_permintaan', $no_permintaan)
  //     ->oneArray();
  //   $this->assign['aset'] = $this->db('inventaris')
  //     ->join('inventaris_barang', 'inventaris_barang.kode_barang=inventaris.kode_barang')
  //     ->toArray();
  //   $this->assign['pegawai'] = $this->db('pegawai')
  //     ->where('stts_aktif', 'AKTIF')
  //     ->toArray();
  //   return $this->draw('form.permintaan.perbaikan.html', ['permintaanperbaikan' => $this->assign]);
  // }


  public function setNoPermintaan()
  {
      $date = date('Y-m-d');
      $last_no_order = $this->db()->pdo()->prepare("SELECT ifnull(MAX(CONVERT(RIGHT(no_permintaan,4),signed)),0) FROM permintaan_perbaikan_inventaris WHERE tanggal LIKE '%$date%'");
      $last_no_order->execute();
      $last_no_order = $last_no_order->fetch();
      if(empty($last_no_order[0])) {
        $last_no_order[0] = '0000';
      }
      $next_no_order = sprintf('%04s', ($last_no_order[0] + 1));
      $next_no_order = 'PI'.date('Ymd').''.$next_no_order;

      return $next_no_order;
  }

=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    public function getJavascript()
    {
        header('Content-type: text/javascript');
        echo $this->draw(MODULES . '/profil/js/admin/app.js');
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES . '/profil/css/admin/app.css');
        exit();
    }

    private function _addHeaderFiles()
    {
        // CSS
<<<<<<< HEAD
        $this->core->addCSS(url('assets/css/jquery-ui.css'));
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
        $this->core->addCSS(url('plugins/profil/css/admin/timeline.min.css'));
        $this->core->addCSS(url('assets/jscripts/lightbox/lightbox.min.css'));

        // JS
<<<<<<< HEAD
        $this->core->addJS(url('assets/jscripts/jquery-ui.js'), 'footer');
=======
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
        $this->core->addJs(url('plugins/profil/js/admin/timeline.min.js'), 'footer');
        $this->core->addJS(url('assets/jscripts/lightbox/lightbox.min.js'), 'footer');

        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));

        // MODULE SCRIPTS
        $this->core->addJS(url([ADMIN, 'profil', 'javascript']), 'footer');
        $this->core->addCSS(url([ADMIN, 'profil', 'css']));
    }

}
