<?php

namespace Plugins\Presensi;

use Systems\AdminModule;

class Admin extends AdminModule
{

    public function navigation()
    {
        if ($this->core->getUserInfo('role') == 'admin') {
            return [
                'Kelola' => 'manage',
                'Presensi Masuk' => 'presensi',
                'Rekap Presensi' => 'rekap_presensi',
                'Rekap BKD' => 'rekap_bkd',
                'Barcode Presensi' => 'barcode',
                'Jam Jaga' => 'jamjaga',
                'Jadwal Pegawai' => 'jadwal',
                'Jadwal Tambahan' => 'jadwal_tambahan',
<<<<<<< HEAD
                'Validasi Presensi' => 'validasi',
                'Auto Verif Presensi' => 'auto_verif',
                'Pengaturan' => 'pengaturan_api'
=======
                'Pengaturan' => 'settings'
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
            ];
        } else if($this->core->getPegawaiInfo('departemen', $this->core->getUserInfo('username', null, true)) == 'KPG'){
            return [
                'Kelola' => 'manage',
                'Presensi Masuk' => 'presensi',
                'Rekap Presensi' => 'rekap_presensi',
                'Rekap BKD' => 'rekap_bkd',
                'Jadwal Pegawai' => 'jadwal',
                'Jadwal Tambahan' => 'jadwal_tambahan'
            ];
        } else if($this->core->getUserInfo('username') == '198201092007011006'){
            return [
                'Kelola' => 'manage',
                'Rekap BKD' => 'rekap_bkd',
            ];
        } else {
            return [
                'Kelola' => 'manage',
                'Presensi Masuk' => 'presensi',
                'Rekap Presensi' => 'rekap_presensi',
                'Jadwal Pegawai' => 'jadwal',
                'Jadwal Tambahan' => 'jadwal_tambahan'
            ];
        }
    }

    public function getManage()
    {
        if ($this->core->getUserInfo('role') == 'admin') {
            $sub_modules = [
                ['name' => 'Presensi', 'url' => url([ADMIN, 'presensi', 'presensi']), 'icon' => 'cubes', 'desc' => 'Presensi Pegawai'],
                ['name' => 'Rekap Presensi', 'url' => url([ADMIN, 'presensi', 'rekap_presensi']), 'icon' => 'cubes', 'desc' => 'Rekap Presensi Pegawai'],
                ['name' => 'Rekap BKD', 'url' => url([ADMIN, 'presensi', 'rekap_bkd']), 'icon' => 'cubes', 'desc' => 'Rekap Bridging Presensi Pegawai ke BKD'],
                ['name' => 'Barcode Presensi', 'url' => url([ADMIN, 'presensi', 'barcode']), 'icon' => 'cubes', 'desc' => 'Barcode Presensi Pegawai'],
                ['name' => 'Jam Jaga', 'url' => url([ADMIN, 'presensi', 'jamjaga']), 'icon' => 'cubes', 'desc' => 'Jam Jaga Pegawai'],
                ['name' => 'Jadwal', 'url' => url([ADMIN, 'presensi', 'jadwal']), 'icon' => 'cubes', 'desc' => 'Jadwal Pegawai'],
                ['name' => 'Jadwal Tambahan', 'url' => url([ADMIN, 'presensi', 'jadwal_tambahan']), 'icon' => 'cubes', 'desc' => 'Jadwal Tambahan Pegawai'],
<<<<<<< HEAD
                ['name' => 'Validasi Presensi', 'url' => url([ADMIN, 'presensi', 'validasi_presensi']), 'icon' => 'check-square', 'desc' => 'Validasi Rekap Presensi'],
                ['name' => 'Validasi Manual Presensi', 'url' => url([ADMIN, 'presensi', 'validasi_manual']), 'icon' => 'check-square', 'desc' => 'Validasi Manual Rekap Presensi'],
                ['name' => 'Auto Verif Presensi', 'url' => url([ADMIN, 'presensi', 'auto_verif']), 'icon' => 'check-square', 'desc' => 'Cek Auto Verif Presensi'],
                ['name' => 'Pengaturan API', 'url' => url([ADMIN, 'presensi', 'pengaturan_api']), 'icon' => 'gear', 'desc' => 'Pengaturan API Presensi'],
=======
                ['name' => 'Pengaturan', 'url' => url([ADMIN, 'presensi', 'settings']), 'icon' => 'cubes', 'desc' => 'Pengaturan Presensi']
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
            ];
        } else if($this->core->getPegawaiInfo('departemen', $this->core->getUserInfo('username', null, true)) == 'KPG'){
            $sub_modules = [
                ['name' => 'Presensi', 'url' => url([ADMIN, 'presensi', 'presensi']), 'icon' => 'cubes', 'desc' => 'Presensi Pegawai'],
                ['name' => 'Rekap Presensi', 'url' => url([ADMIN, 'presensi', 'rekap_presensi']), 'icon' => 'cubes', 'desc' => 'Rekap Presensi Pegawai'],
                ['name' => 'Rekap BKD', 'url' => url([ADMIN, 'presensi', 'rekap_bkd']), 'icon' => 'cubes', 'desc' => 'Rekap Bridging Presensi Pegawai ke BKD'],
                ['name' => 'Jadwal', 'url' => url([ADMIN, 'presensi', 'jadwal']), 'icon' => 'cubes', 'desc' => 'Jadwal Pegawai'],
                ['name' => 'Jadwal Tambahan', 'url' => url([ADMIN, 'presensi', 'jadwal_tambahan']), 'icon' => 'cubes', 'desc' => 'Jadwal Tambahan Pegawai'],
            ];
        } else if($this->core->getUserInfo('username') == '198201092007011006'){
            $sub_modules = [
                ['name' => 'Rekap BKD', 'url' => url([ADMIN, 'presensi', 'rekap_bkd']), 'icon' => 'cubes', 'desc' => 'Rekap Bridging Presensi Pegawai ke BKD'],
            ];
        } else {
            $sub_modules = [
                ['name' => 'Presensi', 'url' => url([ADMIN, 'presensi', 'presensi']), 'icon' => 'cubes', 'desc' => 'Presensi Pegawai'],
                ['name' => 'Rekap Presensi', 'url' => url([ADMIN, 'presensi', 'rekap_presensi']), 'icon' => 'cubes', 'desc' => 'Rekap Presensi Pegawai'],
                ['name' => 'Jadwal', 'url' => url([ADMIN, 'presensi', 'jadwal']), 'icon' => 'cubes', 'desc' => 'Jadwal Pegawai'],
                ['name' => 'Jadwal Tambahan', 'url' => url([ADMIN, 'presensi', 'jadwal_tambahan']), 'icon' => 'cubes', 'desc' => 'Jadwal Tambahan Pegawai']
            ];
        }
        return $this->draw('manage.html', ['sub_modules' => $sub_modules]);
    }

    public function getJamJaga($page = 1)
    {
        $this->_addHeaderFiles();
        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        $status = '1';
        if (isset($_GET['status']))
            $status = $_GET['status'];

        // pagination
        $totalRecords = $this->db('jam_jaga')
            ->like('shift', '%' . $phrase . '%')
            ->orLike('dep_id', '%' . $phrase . '%')
            ->toArray();
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'jamjaga', '%d']));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        $rows = $this->db('jam_jaga')
            ->like('shift', '%' . $phrase . '%')
            ->orLike('dep_id', '%' . $phrase . '%')
            ->offset($offset)
            ->limit($perpage)
            ->toArray();

        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['editURL'] = url([ADMIN, 'presensi', 'jagaedit', $row['no_id']]);
                // $row['delURL']  = url([ADMIN, 'master', 'petugasdelete', $row['nip']]);
                // $row['restoreURL']  = url([ADMIN, 'master', 'petugasrestore', $row['nip']]);
                // $row['viewURL'] = url([ADMIN, 'master', 'petugasview', $row['nip']]);
                $this->assign['list'][] = $row;
            }
        }

        $this->assign['getStatus'] = isset($_GET['status']);
        $this->assign['addURL'] = url([ADMIN, 'presensi', 'jagaadd']);
        // $this->assign['printURL'] = url([ADMIN, 'master', 'petugasprint']);

        return $this->draw('index.html', ['jamjaga' => $this->assign]);
    }

    public function getJagaAdd()
    {
        $this->_addHeaderFiles();
        if (!empty($redirectData = getRedirectData())) {
            $this->assign['form'] = filter_var_array($redirectData, FILTER_SANITIZE_STRING);
        } else {
            $this->assign['form'] =
                [
                    'no_id' => '',
                    'dep_id' => '',
                    'shift' => '',
                    'jam_masuk' => '',
                    'jam_pulang' => ''
                ];
        }

        $this->assign['dep_id'] = $this->db('departemen')->toArray();
        $this->assign['shift'] = $this->db('jam_masuk')->toArray();

        return $this->draw('jagaadd.form.html', ['jagaadd' => $this->assign]);
    }

    public function getJagaEdit($id)
    {
        $this->_addHeaderFiles();
        $rows = $this->db('jam_jaga')
            ->where('no_id', $id)
            ->oneArray();
        $this->assign['form'] = $rows;

        $this->assign['dep_id'] = $this->db('departemen')->toArray();
        $this->assign['shift'] = $this->db('jam_masuk')->toArray();

        return $this->draw('jagaadd.form.html', ['jagaadd' => $this->assign]);
    }

    public function postJagaSave($id = null)
    {
        $errors = 0;

        if (!$id) {
            $location = url([ADMIN, 'presensi', 'jamjaga']);
        } else {
            $location = url([ADMIN, 'presensi', 'jamjaga']);
        }

        if (checkEmptyFields(['dep_id'], $_POST)) {
            $this->notify('failure', 'Isian kosong');
            redirect($location, $_POST);
        }

        if (!$errors) {
            unset($_POST['save']);

            if (!$id) {
                $query = $this->db('jam_jaga')->save($_POST);
            } else {
                $query = $this->db('jam_jaga')->where('no_id', $id)->save($_POST);
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

    public function getJadwal($page = 1)
    {
        $this->_addHeaderFiles();
        $perpage = '10';
        $phrase = '';
        $bulan = date('m');

        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        if (isset($_GET['b'])) {
            $bulan = $_GET['b'];
        }

        $tahun = date('Y');
        if (isset($_GET['y'])) {
            $tahun = $_GET['y'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        if ($this->core->getUserInfo('role') == 'admin') {
            $totalRecords = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->like('jadwal_pegawai.bulan', $bulan . '%')
                ->like('jadwal_pegawai.tahun', $tahun . '%')
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->toArray();
        } else {
            $totalRecords = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->where('jadwal_pegawai.bulan', $bulan)
                ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->toArray();
        }
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'jadwal', '%d?b=' . $bulan . '&s=' . $phrase]));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        if ($this->core->getUserInfo('role') == 'admin') {
            $rows = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->like('jadwal_pegawai.tahun', $tahun . '%')
                ->like('jadwal_pegawai.bulan', $bulan . '%')
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        } else {
            $rows = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->where('jadwal_pegawai.bulan', $bulan)
                ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        }
        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['editURL'] = url([ADMIN, 'presensi', 'jadwaledit', $row['id'], $bulan, $tahun]);
                // $row['delURL']  = url([ADMIN, 'master', 'petugasdelete', $row['nip']]);
                // $row['restoreURL']  = url([ADMIN, 'master', 'petugasrestore', $row['nip']]);
                // $row['viewURL'] = url([ADMIN, 'master', 'petugasview', $row['nip']]);
                $this->assign['list'][] = $row;
            }
        }

        $this->assign['getStatus'] = isset($_GET['status']);
        $this->assign['addURL'] = url([ADMIN, 'presensi', 'jadwaladd']);
        $month = array(
            '01' => 'JAN',
            '02' => 'FEB',
            '03' => 'MAR',
            '04' => 'APR',
            '05' => 'MEI',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AGU',
            '09' => 'SEP',
            '10' => 'OKT',
            '11' => 'NOV',
            '12' => 'DES',
        );

       $year = array( 
        '2020' => '2020', 
        '2021' => '2021', 
        '2022' => '2022', 
        '2023' => '2023'
        );
        
        $this->assign['showBulan'] = $month[$bulan];
        $this->assign['showTahun'] = $year[$tahun];
        // $this->assign['printURL'] = url([ADMIN, 'master', 'petugasprint']);
        $this->assign['bulan'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023', '2024', '2025');
        return $this->draw('jadwal.manage.html', ['jadwal' => $this->assign]);
    }

    public function getJadwalAdd()
    {
        $this->_addHeaderFiles();
        if (!empty($redirectData = getRedirectData())) {
            $this->assign['form'] = filter_var_array($redirectData, FILTER_SANITIZE_STRING);
        } else {
            $this->assign['form'] = [
                'id' => '',
                'tahun' => '',
                'bulan' => '',
                'h1' => '',
                'h2' => '',
                'h3' => '',
                'h4' => '',
                'h5' => '',
                'h6' => '',
                'h7' => '',
                'h8' => '',
                'h9' => '',
                'h10' => '',
                'h11' => '',
                'h12' => '',
                'h13' => '',
                'h14' => '',
                'h15' => '',
                'h16' => '',
                'h17' => '',
                'h18' => '',
                'h19' => '',
                'h20' => '',
                'h21' => '',
                'h22' => '',
                'h23' => '',
                'h24' => '',
                'h25' => '',
                'h26' => '',
                'h27' => '',
                'h28' => '',
                'h29' => '',
                'h30' => '',
                'h31' => '',
            ];
        }
        $username = $this->core->getUserInfo('username', null, true);
        if ($this->core->getUserInfo('role') == 'admin') {
            $this->assign['id'] = $this->db('pegawai')
                ->where('stts_aktif', 'AKTIF')
                ->toArray();
        } else {
            $this->assign['id'] = $this->db('pegawai')
                ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
                ->where('stts_aktif', 'AKTIF')
                ->toArray();
        }
        if ($this->core->getUserInfo('role') == 'admin') {
            $this->assign['h1'] = $this->db('jam_masuk')->toArray();
        } else {
            $this->assign['h1'] = $this->db('jam_jaga')->where('dep_id', $this->core->getPegawaiInfo('departemen', $username))->toArray();
        }
        $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023', '2024', '2025');
        //$this->assign['tahun'] = date('Y');
        $this->assign['bulan'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

        return $this->draw('jadwal.form.html', ['jadwal' => $this->assign]);
    }

    public function getJadwalEdit($id, $bulan, $tahun)
    {
        $this->_addHeaderFiles();
        if ($bulan == "") {
            $bulan = date('m');
        }

        $row = $this->db('jadwal_pegawai')->where('id', $id)->where('tahun', $tahun)->where('bulan', $bulan)->oneArray();
        if (!empty($row)) {
            $username = $this->core->getUserInfo('username', null, true);
            $this->assign['form'] = $row;
            if ($this->core->getUserInfo('role') == 'admin') {
                $this->assign['id'] = $this->db('pegawai')
                    ->where('stts_aktif', 'AKTIF')
                    ->toArray();
            } else {
                $this->assign['id'] = $this->db('pegawai')
                    ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                    ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
                    ->where('stts_aktif', 'AKTIF')
                    ->toArray();
            }
            if ($this->core->getUserInfo('role') == 'admin') {
                $this->assign['h1'] = $this->db('jam_masuk')->toArray();
            } else {
                $this->assign['h1'] = $this->db('jam_jaga')->where('dep_id', $this->core->getPegawaiInfo('departemen', $username))->toArray();
            }
            $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023', '2024', '2025');
            //$this->assign['tahun'] = $tahun;
            $this->assign['bulan'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

            return $this->draw('jadwal.form.html', ['jadwal' => $this->assign]);
        } else {
            redirect(url([ADMIN, 'presensi', 'jadwal']));
        }
    }

    public function postJadwalSave($id = null)
    {
        $errors = 0;

        if (!$id) {
            $location = url([ADMIN, 'presensi', 'jadwal']);
        } else {
            $location = url([ADMIN, 'presensi', 'jadwaledit', $id, $_POST['bulan'], $_POST['tahun']]);
        }

        //if (checkEmptyFields(['id'], $_POST)){
        //    $this->notify('failure', 'Isian kosong');
        //    redirect($location, $_POST);
        // }

        if (!$errors) {
            unset($_POST['save']);

            if (!$id) {
                $query = $this->db('jadwal_pegawai')->save($_POST);
            } else {
                $query = $this->db('jadwal_pegawai')->where('id', $id)->where('tahun', $_POST['tahun'])->where('bulan', $_POST['bulan'])->save($_POST);
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

    public function getJadwal_Tambahan($page = 1)
    {
        $this->_addHeaderFiles();
        $perpage = '10';
        $phrase = '';
        if(isset($_GET['s']))
          $phrase = $_GET['s'];

        $bulan = date('m');
        if (isset($_GET['b'])) {
            $bulan = $_GET['b'];
        }

        $tahun = date('Y');
        if (isset($_GET['y'])) {
            $tahun = $_GET['y'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        if($this->core->getUserInfo('role') == 'admin'){
        $totalRecords = $this->db('jadwal_tambahan')
            ->join('pegawai','pegawai.id=jadwal_tambahan.id')
            ->where('jadwal_tambahan.tahun',$tahun)
            ->like('jadwal_tambahan.bulan',$bulan.'%')
            ->like('pegawai.nama', '%'.$phrase.'%')
            ->toArray();
        }else{
            $totalRecords = $this->db('jadwal_tambahan')
            ->join('pegawai','pegawai.id=jadwal_tambahan.id')
            ->where('jadwal_tambahan.tahun',$tahun)
            ->where('jadwal_tambahan.bulan',$bulan)
            ->where('departemen', $this->core->getPegawaiInfo('departemen',$username))

            ->like('pegawai.nama', '%'.$phrase.'%')
            ->toArray();
        }
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'jadwal_tambahan', '%d?b='.$bulan.'&s='.$phrase]));
        $this->assign['pagination'] = $pagination->nav('pagination','5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        if($this->core->getUserInfo('role') == 'admin'){
            $rows = $this->db('jadwal_tambahan')
            ->join('pegawai','pegawai.id=jadwal_tambahan.id')
            ->where('jadwal_tambahan.tahun',$tahun)
            ->like('jadwal_tambahan.bulan',$bulan.'%')
            ->like('pegawai.nama', '%'.$phrase.'%')
            ->offset($offset)
            ->limit($perpage)
            ->toArray();
        }else{
        $rows = $this->db('jadwal_tambahan')
            ->join('pegawai','pegawai.id=jadwal_tambahan.id')
            ->where('jadwal_tambahan.tahun',$tahun)
            ->where('jadwal_tambahan.bulan',$bulan)
            ->where('departemen', $this->core->getPegawaiInfo('departemen',$username))

            ->like('pegawai.nama', '%'.$phrase.'%')
            ->offset($offset)
            ->limit($perpage)
            ->toArray();
        }
        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['editURL'] = url([ADMIN, 'presensi', 'jadwaltambahedit', $row['id'] , $bulan , $tahun]);
                // $row['delURL']  = url([ADMIN, 'master', 'petugasdelete', $row['nip']]);
                // $row['restoreURL']  = url([ADMIN, 'master', 'petugasrestore', $row['nip']]);
                // $row['viewURL'] = url([ADMIN, 'master', 'petugasview', $row['nip']]);
                $this->assign['list'][] = $row;
            }
        }

        $this->assign['getStatus'] = isset($_GET['status']);
        $this->assign['addURL'] = url([ADMIN, 'presensi', 'jadwaltambahadd']);
        $month = array(
            '01' => 'JAN',
            '02' => 'FEB',
            '03' => 'MAR',
            '04' => 'APR',
            '05' => 'MEI',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AGU',
            '09' => 'SEP',
            '10' => 'OKT',
            '11' => 'NOV',
            '12' => 'DES',
        );
        $this->assign['showBulan'] = $month[$bulan];
        // $this->assign['printURL'] = url([ADMIN, 'master', 'petugasprint']);
        $this->assign['bulan'] = array('','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023', '2024', '2025');
        return $this->draw('jadwal_tambah.manage.html', ['jadwal_tambah' => $this->assign]);
    }

    public function getJadwalTambahAdd()
    {
        $this->_addHeaderFiles();
        if (!empty($redirectData = getRedirectData())){
            $this->assign['form'] = filter_var_array($redirectData, FILTER_SANITIZE_STRING);
        } else {
            $this->assign['form'] = [
                'id' => '',
                'tahun' => '',
                'bulan' => '',
                'h1' => '',
                'h2' => '',
                'h3' => '',
                'h4' => '',
                'h5' => '',
                'h6' => '',
                'h7' => '',
                'h8' => '',
                'h9' => '',
                'h10' => '',
                'h11' => '',
                'h12' => '',
                'h13' => '',
                'h14' => '',
                'h15' => '',
                'h16' => '',
                'h17' => '',
                'h18' => '',
                'h19' => '',
                'h20' => '',
                'h21' => '',
                'h22' => '',
                'h23' => '',
                'h24' => '',
                'h25' => '',
                'h26' => '',
                'h27' => '',
                'h28' => '',
                'h29' => '',
                'h30' => '',
                'h31' => '',
            ];
        }
        $username = $this->core->getUserInfo('username', null, true);
        if($this->core->getUserInfo('role') == 'admin'){
            $this->assign['id'] = $this->db('pegawai')
                                    ->where('stts_aktif','AKTIF')
                                    ->toArray();
        }else{
            $this->assign['id'] = $this->db('pegawai')
                                ->where('departemen', $this->core->getPegawaiInfo('departemen',$username))

                                ->where('stts_aktif','AKTIF')
                                ->toArray();
        }
        if($this->core->getUserInfo('role') == 'admin'){
            $this->assign['h1'] = $this->db('jam_masuk')->toArray();
        }else{
            $this->assign['h1'] = $this->db('jam_jaga')->where('dep_id', $this->core->getPegawaiInfo('departemen',$username))->toArray();
        }
        $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023', '2024', '2025');
        $this->assign['bulan'] = array('','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

        return $this->draw('jadwal_tambah.form.html', ['jadwal' => $this->assign]);
    }

    public function getJadwalTambahEdit($id,$bulan,$tahun)
    {
        $this->_addHeaderFiles();
        $row = $this->db('jadwal_tambahan')->where('id', $id)->where('tahun', $tahun)->where('bulan', $bulan)->oneArray();
        if (!empty($row)){
            $username = $this->core->getUserInfo('username', null, true);
            $this->assign['form'] = $row;
            if($this->core->getUserInfo('role') == 'admin'){
                $this->assign['id'] = $this->db('pegawai')
                                        ->where('stts_aktif','AKTIF')
                                        ->toArray();
            }else{
                $this->assign['id'] = $this->db('pegawai')
                                    ->where('departemen', $this->core->getPegawaiInfo('departemen',$username))
                                    ->where('stts_aktif','AKTIF')
                                    ->toArray();
            }
            if ($this->core->getUserInfo('role') == 'admin') {
                $this->assign['h1'] = $this->db('jam_masuk')->toArray();
            } else {
                $this->assign['h1'] = $this->db('jam_jaga')->where('dep_id', $this->core->getPegawaiInfo('departemen', $username))->toArray();
            }
            $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023', '2024', '2025');
            $this->assign['bulan'] = array('','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

            return $this->draw('jadwal_tambah.form.html', ['jadwal' => $this->assign]);
        } else {
            redirect(url([ADMIN,'presensi','jadwal_tambahan']));
        }

    }

    public function postJadwalTambahSave($id = null)
    {
        $errors = 0;

        if (!$id){
            $location = url([ADMIN, 'presensi', 'jadwal_tambahan']);
        } else {
            $location = url([ADMIN, 'presensi', 'jadwaltambahedit', $id]);
        }

        if (!$errors) {
            unset($_POST['save']);

            if (!$id) {
                $query = $this->db('jadwal_tambahan')->save($_POST);
            } else {
                $query = $this->db('jadwal_tambahan')->where('id', $id)->where('tahun', $_POST['tahun'])->where('bulan', $_POST['bulan'])->save($_POST);
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

    public function getRekap_Presensi($page = 1)
    {
        $this->_addHeaderFiles();
        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        $tgl_kunjungan = date('Y-m-d');
        $tgl_kunjungan_akhir = date('Y-m-d');
        // $status_periksa = '';
        // $status_bayar = '';

        if (isset($_GET['awal'])) {
            $tgl_kunjungan = $_GET['awal'];
        }
        if (isset($_GET['akhir'])) {
            $tgl_kunjungan_akhir = $_GET['akhir'];
        }

        $ruang = '';
        if (isset($_GET['ruang'])) {
            $ruang = $_GET['ruang'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        if ($this->core->getUserInfo('role') == 'admin') {
            $totalRecords = $this->db('rekap_presensi')
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', $tgl_kunjungan . ' 00:00:00')
                ->where('jam_datang', '<=', $tgl_kunjungan_akhir . ' 23:59:59')
                ->like('bidang', '%' . $ruang . '%')
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->toArray();
        } else {
            $totalRecords = $this->db('rekap_presensi')
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', $tgl_kunjungan . ' 00:00:00')
                ->where('jam_datang', '<=', $tgl_kunjungan_akhir . ' 23:59:59')
                ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->toArray();
        }
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'rekap_presensi', '%d?awal=' . $tgl_kunjungan . '&akhir=' . $tgl_kunjungan_akhir . '&ruang=' . $ruang . '&s=' . $phrase]));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();

        if ($this->core->getUserInfo('role') == 'admin') {
            $rows = $this->db('rekap_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'departemen' => 'pegawai.departemen',
                    'jbtn' => 'pegawai.jbtn',
                    'bidang' => 'pegawai.bidang',
                    'id' => 'rekap_presensi.id',
                    'shift' => 'rekap_presensi.shift',
                    'jam_datang' => 'rekap_presensi.jam_datang',
                    'jam_pulang' => 'rekap_presensi.jam_pulang',
                    'status' => 'rekap_presensi.status',
                    'durasi' => 'rekap_presensi.durasi',
                    'photo' => 'rekap_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', $tgl_kunjungan . ' 00:00:00')
                ->where('jam_datang', '<=', $tgl_kunjungan_akhir . ' 23:59:59')
                ->like('bidang', '%' . $ruang . '%')
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        } else {
            $rows = $this->db('rekap_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'departemen' => 'pegawai.departemen',
                    'jbtn' => 'pegawai.jbtn',
                    'bidang' => 'pegawai.bidang',
                    'id' => 'rekap_presensi.id',
                    'shift' => 'rekap_presensi.shift',
                    'jam_datang' => 'rekap_presensi.jam_datang',
                    'jam_pulang' => 'rekap_presensi.jam_pulang',
                    'status' => 'rekap_presensi.status',
                    'durasi' => 'rekap_presensi.durasi',
                    'photo' => 'rekap_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>=', $tgl_kunjungan . ' 00:00:00')
                ->where('jam_datang', '<=', $tgl_kunjungan_akhir . ' 23:59:59')
                ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
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
                $row['mapURL']  = url([ADMIN, 'presensi', 'googlemap', $row['id'], date('Y-m-d', strtotime($row['jam_datang']))]);

                $day = array(
                    'Sun' => 'AKHAD',
                    'Mon' => 'SENIN',
                    'Tue' => 'SELASA',
                    'Wed' => 'RABU',
                    'Thu' => 'KAMIS',
                    'Fri' => 'JUMAT',
                    'Sat' => 'SABTU'
                );

                $jam_datang = $this->db('rekap_presensi')
                    ->select([
                        'EXTRACT(MONTH FROM rekap_presensi.jam_datang) as month',
                        'EXTRACT(YEAR FROM rekap_presensi.jam_datang) as year',
                        'EXTRACT(DAY FROM rekap_presensi.jam_datang) as day',
                        'shift' => 'rekap_presensi.shift'
                    ])
                    ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                    ->where('rekap_presensi.id', $row['id'])
                    ->where('rekap_presensi.jam_datang', $row['jam_datang'])
                    ->asc('jam_datang')
                    ->oneArray();
                $stts1 = '';
                $stts2 = '';

                $s = $row['jam_datang'];
                $dt = new \DateTime($s);
                $tm = $dt->format('h:i:s');

                $w = $row['jam_pulang'];
                $dd = new \DateTime($w);
                $tp = $dd->format('H:i:s');

                $row['date'] = $day[date('D', strtotime(date($jam_datang['year'] . '-' . $jam_datang['month'] . '-' . $jam_datang['day'])))];
                switch (true) {
                    case ($row['date'] == 'SENIN' and $jam_datang['shift'] == 'Pagi'):
                        $interval = 'INTERVAL 6 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '08:11:00' and $tm < '08:30:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '08:31:00' and $tm < '09:00:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '09:01:00' and $tm < '09:30:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '09:31:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '14:01:00' and $tp < '14:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '13:31:00' and $tp < '14:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '13:01:00' and $tp < '13:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '13:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SENIN' and $jam_datang['shift'] == 'Siang'):
                        $interval = 'INTERVAL 5 HOUR';
                        $efektif = 'INTERVAL 1 HOUR';
                        break;
                        if ($tm > '14:41:00' and $tm < '15:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '15:01:00' and $tm < '15:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '15:31:00' and $tm < '16:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '16:00:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '20:01:00' and $tp < '20:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '19:31:00' and $tp < '20:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '19:01:00' and $tp < '19:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '19:00:00') {
                            $stts2 = 'PSW4';
                        }
                    case ($row['date'] == 'SENIN' and $jam_datang['shift'] == 'Siang - Gizi'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SENIN' and $jam_datang['shift'] == 'Malam'):
                        $interval = 'INTERVAL 10 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 2 HOUR';
                        if ($tm > '20:41:00' and $tm < '21:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '21:01:00' and $tm < '21:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '21:31:00' and $tm < '22:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '22:01:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '07:31:00' and $tp < '07:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '07:01:00' and $tp < '07:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '06:31:00' and $tp < '07:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '06:30:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SENIN' and $jam_datang['shift'] == 'Malam - Gizi (Masak)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SENIN' and $jam_datang['shift'] == 'Malam - Gizi (Saji)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SENIN' and $jam_datang['shift'] == 'Malam - Gizi (Cuci)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SELASA' and $jam_datang['shift'] == 'Pagi'):
                        $interval = 'INTERVAL 6 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '08:11:00' and $tm < '08:30:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '08:31:00' and $tm < '09:00:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '09:01:00' and $tm < '09:30:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '09:31:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '14:01:00' and $tp < '14:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '13:31:00' and $tp < '14:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '13:01:00' and $tp < '13:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '13:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SELASA' and $jam_datang['shift'] == 'Siang'):
                        $interval = 'INTERVAL 5 HOUR';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '14:41:00' and $tm < '15:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '15:01:00' and $tm < '15:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '15:31:00' and $tm < '16:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '16:00:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '20:01:00' and $tp < '20:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '19:31:00' and $tp < '20:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '19:01:00' and $tp < '19:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '19:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SELASA' and $jam_datang['shift'] == 'Siang - Gizi'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SELASA' and $jam_datang['shift'] == 'Malam'):
                        $interval = 'INTERVAL 10 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 2 HOUR';
                        if ($tm > '20:41:00' and $tm < '21:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '21:01:00' and $tm < '21:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '21:31:00' and $tm < '22:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '22:01:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '07:31:00' and $tp < '07:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '07:01:00' and $tp < '07:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '06:31:00' and $tp < '07:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '06:30:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SELASA' and $jam_datang['shift'] == 'Malam - Gizi (Masak)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SELASA' and $jam_datang['shift'] == 'Malam - Gizi (Saji)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SELASA' and $jam_datang['shift'] == 'Malam - Gizi (Cuci)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'RABU' and $jam_datang['shift'] == 'Pagi'):
                        $interval = 'INTERVAL 6 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '08:11:00' and $tm < '08:30:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '08:31:00' and $tm < '09:00:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '09:01:00' and $tm < '09:30:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '09:31:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '14:01:00' and $tp < '14:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '13:31:00' and $tp < '14:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '13:01:00' and $tp < '13:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '13:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'RABU' and $jam_datang['shift'] == 'Siang'):
                        $interval = 'INTERVAL 5 HOUR';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '14:41:00' and $tm < '15:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '15:01:00' and $tm < '15:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '15:31:00' and $tm < '16:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '16:00:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '20:01:00' and $tp < '20:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '19:31:00' and $tp < '20:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '19:01:00' and $tp < '19:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '19:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'RABU' and $jam_datang['shift'] == 'Siang - Gizi'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'RABU' and $jam_datang['shift'] == 'Malam'):
                        $interval = 'INTERVAL 10 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 2 HOUR';
                        if ($tm > '20:41:00' and $tm < '21:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '21:01:00' and $tm < '21:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '21:31:00' and $tm < '22:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '22:01:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '07:31:00' and $tp < '07:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '07:01:00' and $tp < '07:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '06:31:00' and $tp < '07:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '06:30:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'RABU' and $jam_datang['shift'] == 'Malam - Gizi (Masak)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'RABU' and $jam_datang['shift'] == 'Malam - Gizi (Saji)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'RABU' and $jam_datang['shift'] == 'Malam - Gizi (Cuci)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'KAMIS' and $jam_datang['shift'] == 'Pagi'):
                        $interval = 'INTERVAL 6 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '08:11:00' and $tm < '08:30:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '08:31:00' and $tm < '09:00:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '09:01:00' and $tm < '09:30:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '09:31:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '14:01:00' and $tp < '14:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '13:31:00' and $tp < '14:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '13:01:00' and $tp < '13:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '13:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'KAMIS' and $jam_datang['shift'] == 'Siang'):
                        $interval = 'INTERVAL 5 HOUR';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '14:41:00' and $tm < '15:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '15:01:00' and $tm < '15:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '15:31:00' and $tm < '16:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '16:00:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '20:01:00' and $tp < '20:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '19:31:00' and $tp < '20:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '19:01:00' and $tp < '19:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '19:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'KAMIS' and $jam_datang['shift'] == 'Siang - Gizi'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'KAMIS' and $jam_datang['shift'] == 'Malam'):
                        $interval = 'INTERVAL 10 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 2 HOUR';
                        if ($tm > '20:41:00' and $tm < '21:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '21:01:00' and $tm < '21:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '21:31:00' and $tm < '22:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '22:01:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '07:31:00' and $tp < '07:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '07:01:00' and $tp < '07:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '06:31:00' and $tp < '07:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '06:30:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'KAMIS' and $jam_datang['shift'] == 'Malam - Gizi (Masak)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'KAMIS' and $jam_datang['shift'] == 'Malam - Gizi (Saji)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'KAMIS' and $jam_datang['shift'] == 'Malam - Gizi (Cuci)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'JUMAT' and $jam_datang['shift'] == 'Pagi'):
                        $interval = 'INTERVAL 3 HOUR';
                        $efektif = 'INTERVAL 30 MINUTE';
                        if ($tm > '08:11:00' and $tm < '08:30:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '08:31:00' and $tm < '09:00:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '09:01:00' and $tm < '09:30:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '09:31:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '10:30:00' and $tp < '10:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '10:01:00' and $tp < '10:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '09:30:00' and $tp < '10:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '09:29:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'JUMAT' and $jam_datang['shift'] == 'Siang'):
                        $interval = 'INTERVAL 5 HOUR';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '14:41:00' and $tm < '15:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '15:01:00' and $tm < '15:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '15:31:00' and $tm < '16:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '16:00:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '20:01:00' and $tp < '20:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '19:31:00' and $tp < '20:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '19:01:00' and $tp < '19:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '19:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'JUMAT' and $jam_datang['shift'] == 'Siang - Gizi'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'JUMAT' and $jam_datang['shift'] == 'Malam'):
                        $interval = 'INTERVAL 10 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 2 HOUR';
                        if ($tm > '20:41:00' and $tm < '21:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '21:01:00' and $tm < '21:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '21:31:00' and $tm < '22:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '22:01:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '07:31:00' and $tp < '07:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '07:01:00' and $tp < '07:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '06:31:00' and $tp < '07:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '06:30:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'JUMAT' and $jam_datang['shift'] == 'Malam - Gizi (Masak)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'JUMAT' and $jam_datang['shift'] == 'Malam - Gizi (Saji)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'JUMAT' and $jam_datang['shift'] == 'Malam - Gizi (Cuci)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SABTU' and $jam_datang['shift'] == 'Pagi'):
                        $interval = 'INTERVAL 5 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '08:11:00' and $tm < '08:30:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '08:31:00' and $tm < '09:00:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '09:01:00' and $tm < '09:30:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '09:31:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '13:00:00' and $tp < '13:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '13:31:00' and $tp < '14:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '13:01:00' and $tp < '13:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '13:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SABTU' and $jam_datang['shift'] == 'Siang'):
                        $interval = 'INTERVAL 5 HOUR';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '14:41:00' and $tm < '15:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '15:01:00' and $tm < '15:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '15:31:00' and $tm < '16:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '16:00:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '20:01:00' and $tp < '20:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '19:31:00' and $tp < '20:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '19:01:00' and $tp < '19:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '19:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SABTU' and $jam_datang['shift'] == 'Siang - Gizi'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SABTU' and $jam_datang['shift'] == 'Malam'):
                        $interval = 'INTERVAL 10 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 2 HOUR';
                        if ($tm > '20:41:00' and $tm < '21:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '21:01:00' and $tm < '21:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '21:31:00' and $tm < '22:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '22:01:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '07:31:00' and $tp < '07:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '07:01:00' and $tp < '07:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '06:31:00' and $tp < '07:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '06:30:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'SABTU' and $jam_datang['shift'] == 'Malam - Gizi (Masak)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SABTU' and $jam_datang['shift'] == 'Malam - Gizi (Saji)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'SABTU' and $jam_datang['shift'] == 'Malam - Gizi (Cuci)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'AKHAD' and $jam_datang['shift'] == 'Pagi'):
                        $interval = 'INTERVAL 6 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '08:11:00' and $tm < '08:30:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '08:31:00' and $tm < '09:00:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '09:01:00' and $tm < '09:30:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '09:31:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '14:01:00' and $tp < '14:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '13:31:00' and $tp < '14:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '13:01:00' and $tp < '13:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '13:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'AKHAD' and $jam_datang['shift'] == 'Siang'):
                        $interval = 'INTERVAL 5 HOUR';
                        $efektif = 'INTERVAL 1 HOUR';
                        if ($tm > '14:41:00' and $tm < '15:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '15:01:00' and $tm < '15:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '15:31:00' and $tm < '16:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '16:00:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '20:01:00' and $tp < '20:19:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '19:31:00' and $tp < '20:00:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '19:01:00' and $tp < '19:30:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '19:00:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'AKHAD' and $jam_datang['shift'] == 'Siang - Gizi'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'AKHAD' and $jam_datang['shift'] == 'Malam'):
                        $interval = 'INTERVAL 10 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 2 HOUR';
                        if ($tm > '20:41:00' and $tm < '21:00:00') {
                            $stts1 = 'TL1';
                        } elseif ($tm > '21:01:00' and $tm < '21:30:00') {
                            $stts1 = 'TL2';
                        } elseif ($tm > '21:31:00' and $tm < '22:00:00') {
                            $stts1 = 'TL3';
                        } elseif ($tm > '22:01:00') {
                            $stts1 = 'TL4';
                        }
                        if ($tp > '07:31:00' and $tp < '07:49:00') {
                            $stts2 = 'PSW1';
                        } elseif ($tp > '07:01:00' and $tp < '07:30:00') {
                            $stts2 = 'PSW2';
                        } elseif ($tp > '06:31:00' and $tp < '07:00:00') {
                            $stts2 = 'PSW3';
                        } elseif ($tp < '06:30:00') {
                            $stts2 = 'PSW4';
                        }
                        break;
                    case ($row['date'] == 'AKHAD' and $jam_datang['shift'] == 'Malam - Gizi (Masak)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'AKHAD' and $jam_datang['shift'] == 'Malam - Gizi (Saji)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    case ($row['date'] == 'AKHAD' and $jam_datang['shift'] == 'Malam - Gizi (Cuci)'):
                        $interval = 'INTERVAL 0 HOUR';
                        $efektif = 'INTERVAL 0 HOUR';
                        break;
                    default:
                        $interval = 'INTERVAL 5 * 60 + 30 MINUTE';
                        $efektif = 'INTERVAL 1 HOUR';
                        break;
                }

                $row['efektif'] = $this->db('rekap_presensi')
                    ->select([
                        'efektif' => 'CAST(rekap_presensi.durasi as TIME) - ' . $efektif,
                        'kurang' => 'CAST(rekap_presensi.durasi as TIME) - ' . $interval
                    ])
                    ->where('rekap_presensi.id', $row['id'])
                    ->where('rekap_presensi.jam_datang', $row['jam_datang'])
                    ->oneArray();
                $row['stts1'] = $stts1;
                $row['stts2'] = $stts2;
                $this->assign['list'][] = $row;
            }
        }

        $secondplus = 0;
        $secondminus = 0;
        foreach ($this->assign['list'] as $time) {
            list($hour, $minute, $second) = explode(':', $time['efektif']['kurang']);
            if (strpos($hour, '-') !== false) {
                $hour = 0 - $hour;
                $secondplus += $hour * 3600;
                $secondplus += $minute * 60;
                $secondplus += $second;
            } else {
                $secondminus += $hour * 3600;
                $secondminus += $minute * 60;
                $secondminus += $second;
            }
        }

        $hours = floor($secondplus / 3600);
        $secondplus -= $hours * 3600;
        $minutes = floor($secondplus / 60);
        $secondplus -= $minutes * 60;
        $timesplus = $hours . ':' . $minutes . ':' . $secondplus;

        $hours = floor($secondminus / 3600);
        $secondminus -= $hours * 3600;
        $minutes = floor($secondminus / 60);
        $secondminus -= $minutes * 60;
        $timesminus = $hours . ':' . $minutes . ':' . $secondminus;


        $this->assign['totalminus'] = '-' . $timesplus;

        $this->assign['totalplus'] = $timesminus;

        $this->assign['getStatus'] = isset($_GET['status']);
        $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023', '2024', '2025');
        $this->assign['bulan'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $this->assign['tanggal'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31');
        $this->assign['bidang'] = $this->db('bidang')->toArray();
        return $this->draw('rekap_presensi.html', ['rekap' => $this->assign]);
    }

    public function getGoogleMap($id, $tanggal)
    {
        $geo = $this->db('mlite_geolocation_presensi')->where('id', $id)->where('tanggal', $tanggal)->oneArray();
        $pegawai = $this->db('pegawai')->where('id', $id)->oneArray();

        $this->tpl->set('geo', $geo);
        $this->tpl->set('pegawai', $pegawai);
        echo $this->tpl->draw(MODULES . '/presensi/view/admin/google_map.html', true);
        exit();
    }

    public function getPresensi($page = 1)
    {
        $this->_addHeaderFiles();

        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        $ruang = '';
        if (isset($_GET['ruang'])) {
            $ruang = $_GET['ruang'];
        }

        $dep = '';
        if (isset($_GET['dep'])) {
            $dep = $_GET['dep'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        if ($this->core->getUserInfo('role') == 'admin') {
            $totalRecords = $this->db('temporary_presensi')
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->like('departemen', '%' . $dep . '%')
                ->like('bidang', '%' . $ruang . '%')
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->toArray();
        } else {
            $totalRecords = $this->db('temporary_presensi')
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->toArray();
        }
        //$pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'presensi', '%d']));
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'presensi', '%d', '?s=' . $phrase . '&ruang=' . $ruang . '&dep=' . $dep]));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        if ($this->core->getUserInfo('role') == 'admin') {
            $rows = $this->db('temporary_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'jbtn' => 'pegawai.jbtn',
                    'bidang' => 'pegawai.bidang',
                    'id' => 'temporary_presensi.id',
                    'shift' => 'temporary_presensi.shift',
                    'jam_datang' => 'temporary_presensi.jam_datang',
                    'status' => 'temporary_presensi.status',
                    'photo' => 'temporary_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->like('departemen', '%' . $dep . '%')
                ->like('bidang', '%' . $ruang . '%')
                ->like('nama', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        } else {
            $rows = $this->db('temporary_presensi')
                ->select([
                    'nama' => 'pegawai.nama',
                    'jbtn' => 'pegawai.jbtn',
                    'bidang' => 'pegawai.bidang',
                    'id' => 'temporary_presensi.id',
                    'shift' => 'temporary_presensi.shift',
                    'jam_datang' => 'temporary_presensi.jam_datang',
                    'status' => 'temporary_presensi.status',
                    'photo' => 'temporary_presensi.photo'
                ])
                ->join('pegawai', 'pegawai.id = temporary_presensi.id')
                ->where('departemen', $this->core->getPegawaiInfo('departemen', $username))
                ->where('bidang', $this->core->getPegawaiInfo('bidang', $username))
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
                $row['mapURL']  = url([ADMIN, 'presensi', 'googlemap', $row['id'], date('Y-m-d', strtotime($row['jam_datang']))]);
                $row['editURL'] = url([ADMIN, 'presensi', 'presensipulang', $row['id']]);
                $this->assign['list'][] = $row;
            }
        }
        $this->assign['bidang'] = $this->db('bidang')->toArray();
        $this->assign['dep'] = $this->db('departemen')->toArray();

        return $this->draw('presensi.html', ['presensi' => $this->assign]);
    }

    public function getPresensiPulang($id)
    {
        $cek = $this->db('temporary_presensi')->where('id', $id)->oneArray();
        $jam_jaga       = $this->db('jam_jaga')->join('pegawai', 'pegawai.departemen = jam_jaga.dep_id')->where('pegawai.id', $id)->where('jam_jaga.shift', $cek['shift'])->oneArray();
        $location = url([ADMIN, 'presensi', 'presensi']);
        if ($cek) {

            $status = $cek['status'];
            if ((strtotime(date('Y-m-d H:i:s')) - strtotime(date('Y-m-d') . ' ' . $jam_jaga['jam_pulang'])) < 0) {
                $status = $cek['status'] . ' & PSW';
            }

            $awal  = new \DateTime($cek['jam_datang']);
            $akhir = new \DateTime();
            $diff = $akhir->diff($awal, true); // to make the difference to be always positive.
            $durasi = $diff->format('%H:%I:%S');

            $ubah = $this->db('temporary_presensi')
                ->where('id', $id)
                ->save([
                    'jam_pulang' => date('Y-m-d H:i:s'),
                    'status' => $status,
                    'durasi' => $durasi
                ]);

            if ($ubah) {
                $presensi = $this->db('temporary_presensi')->where('id', $id)->oneArray();
                $insert = $this->db('rekap_presensi')
                    ->save([
                        'id' => $presensi['id'],
                        'shift' => $presensi['shift'],
                        'jam_datang' => $presensi['jam_datang'],
                        'jam_pulang' => $presensi['jam_pulang'],
                        'status' => $presensi['status'],
                        'keterlambatan' => $presensi['keterlambatan'],
                        'durasi' => $presensi['durasi'],
                        'keterangan' => '-',
                        'photo' => $presensi['photo']
                    ]);
                if ($insert) {
                    $this->notify('success', 'Presensi pulang telah disimpan');
                    $this->db('temporary_presensi')->where('id', $cek['id'])->delete();
                    redirect($location);
                }
            }
        }
    }

    /* Master Barcode Section */
    public function getBarcode($page = 1)
    {
        $this->_addHeaderFiles();
        $perpage = '10';

        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        // pagination
        $totalRecords = $this->db('barcode')
            ->select('id')
            ->like('barcode', '%' . $phrase . '%')
            ->toArray();
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'barcode', '%d']));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        $rows = $this->db('barcode')
            ->join('pegawai', 'pegawai.id = barcode.id')
            ->like('barcode', '%' . $phrase . '%')
            ->orLike('nama', '%' . $phrase . '%')
            ->offset($offset)
            ->limit($perpage)
            ->toArray();

        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['editURL'] = url([ADMIN, 'presensi', 'barcodeedit', $row['id']]);
                $row['delURL']  = url([ADMIN, 'presensi', 'barcodedelete', $row['id']]);
                $this->assign['list'][] = $row;
            }
        }

        $this->assign['addURL'] = url([ADMIN, 'presensi', 'barcodeadd']);

        return $this->draw('barcode.manage.html', ['barcode' => $this->assign]);
    }

    public function getBarcodeAdd()
    {
        $this->_addHeaderFiles();
        if (!empty($redirectData = getRedirectData())) {
            $this->assign['form'] = filter_var_array($redirectData, FILTER_SANITIZE_STRING);
        } else {
            $this->assign['form'] = [
                'id' => '',
                'barcode' => ''
            ];
        }

        $this->assign['title'] = 'Tambah Barcode';
        $this->assign['pegawai'] = $this->db('pegawai')
            ->select([
                'id' => 'id',
                'nik' => 'nik',
                'nama' => 'nama'
            ])
            ->toArray();

        return $this->draw('barcode.form.html', ['barcode' => $this->assign]);
    }

    public function getBarcodeEdit($id)
    {
        $this->_addHeaderFiles();
        $row = $this->db('barcode')->oneArray($id);
        if (!empty($row)) {
            $this->assign['form'] = $row;
            $this->assign['title'] = 'Edit Barcode';
            $this->assign['pegawai'] = $this->db('pegawai')
                ->select([
                    'id' => 'id',
                    'nik' => 'nik',
                    'nama' => 'nama'
                ])
                ->toArray();

            return $this->draw('barcode.form.html', ['barcode' => $this->assign]);
        } else {
            redirect(url([ADMIN, 'presensi', 'barcode']));
        }
    }

    public function getBarcodeDelete($id)
    {
        if ($this->db('barcode')->delete($id)) {
            $this->notify('success', 'Hapus sukses');
        } else {
            $this->notify('failure', 'Hapus gagal');
        }
        redirect(url([ADMIN, 'presensi', 'barcode']));
    }

    public function postBarcodeSave($id = null)
    {
        $errors = 0;

        if (!$id) {
            $location = url([ADMIN, 'presensi', 'barcodeadd']);
        } else {
            $location = url([ADMIN, 'presensi', 'barcodeedit', $id]);
        }

        if (checkEmptyFields(['id', 'barcode'], $_POST)) {
            $this->notify('failure', 'Isian kosong');
            redirect($location, $_POST);
        }

        if (!$errors) {
            unset($_POST['save']);

            if (!$id) {    // new
                $query = $this->db('barcode')->save($_POST);
            } else {        // edit
                $query = $this->db('barcode')->where('id', $id)->save($_POST);
            }

            if ($query) {
                $this->notify('success', 'Simpan sukes');
            } else {
                $this->notify('failure', 'Simpan gagal');
            }

            redirect($location);
        }

        redirect($location, $_POST);
    }

<<<<<<< HEAD
    public function getRekap_Bkd($page = 1)
    {
        $this->_addHeaderFiles();
        $perpage = '10';
        $phrase = '';
        $bulan = '';

        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        $bulan = date('m');
        if (isset($_GET['b'])) {
            $bulan = $_GET['b'];
        }

        $tahun = date('Y');
        if (isset($_GET['y'])) {
            $tahun = $_GET['y'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        if ($this->core->getUserInfo('role') == 'admin') {
            $totalRecords = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->like('jadwal_pegawai.bulan', $bulan . '%')
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->toArray();
        } else {
            $totalRecords = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->where('jadwal_pegawai.bulan', $bulan)
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->toArray();
        }
        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'rekap_bkd', '%d?b=' . $bulan . '&s=' . $phrase]));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();
        if ($this->core->getUserInfo('role') == 'admin') {
            $rows = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->like('jadwal_pegawai.bulan', $bulan . '%')
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        } else {
            $rows = $this->db('jadwal_pegawai')
                ->join('pegawai', 'pegawai.id=jadwal_pegawai.id')
                ->where('jadwal_pegawai.tahun', $tahun)
                ->where('jadwal_pegawai.bulan', $bulan)
                ->like('pegawai.nama', '%' . $phrase . '%')
                ->offset($offset)
                ->limit($perpage)
                ->toArray();
        }
        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['editURL'] = url([ADMIN, 'presensi', 'rekap_bkdedit', $row['id'], $bulan, $tahun]);
                $row['kehadiran'] = $this->db('rekap_bkd')->where('id',$row['id'])->where('bulan',$bulan)->where('tahun',$tahun)->oneArray();
                $this->assign['list'][] = $row;
            }
        }

        $this->assign['bulan'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $this->assign['tahun'] = array('', '2020', '2021', '2022', '2023');
        return $this->draw('rekapbkd.manage.html', ['rekap' => $this->assign]);
    }

    public function getRekap_Bkdedit($id, $bulan, $tahun)
    {
        $this->_addHeaderFiles();
        $row = $this->db('rekap_bkd')->where('id', $id)->where('tahun', $tahun)->where('bulan', $bulan)->oneArray();
        if (!empty($row)) {
            $this->assign['form'] = $row;
        }

        $this->assign['id'] = $this->db('pegawai')
            ->where('id', $id)
            ->oneArray();

        $this->assign['tahun'] = $tahun;
        $this->assign['bulan'] = $bulan;

        return $this->draw('rekapbkd.edit.html', ['rekap' => $this->assign]);
    }

    public function postRekapBkdSimpan($id = null)
    {
        $errors = 0;
        if (!$id) {
            $location = url([ADMIN, 'presensi', 'rekap_bkd']);
        } else {
            $location = url([ADMIN, 'presensi', 'rekap_bkdedit', $id , $_POST['bulan'] , $_POST['tahun']]);
        }

        if (!$errors) {
            unset($_POST['save']);
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $_POST['updated_at'] = date('Y-m-d H:i:s');
            if (!$id) {
                $query = $this->db('rekap_bkd')->save($_POST);
            } else {
                $query = $this->db('rekap_bkd')->where('id', $id)->where('tahun', $_POST['tahun'])->where('bulan', $_POST['bulan'])->save($_POST);
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

    public function getPengaturan_Api()
=======
    public function getSettings()
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    {
      $this->_addHeaderFiles();
      $this->assign['title'] = 'Pengaturan Presensi';
      $this->assign['presensi'] = htmlspecialchars_array($this->settings('presensi'));
      return $this->draw('settings.html', ['settings' => $this->assign]);
    }

    public function postSaveSettings()
    {
<<<<<<< HEAD
        foreach ($_POST['presensi'] as $key => $val) {
            $this->settings('presensi', $key, $val);
        }
        $this->notify('success', 'Pengaturan telah disimpan');
        redirect(url([ADMIN, 'presensi', 'pengaturan_api']));
    }

    public function getValidasi_Presensi($page = 1)
    {
        $this->_addHeaderFiles();

        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        // $tgl_kunjungan = '2021-01';
        $tgl_kunjungan_akhir = date('Y-m-d');

        if (isset($_GET['awal'])) {
            $tgl_kunjungan = $_GET['awal'];
        }
        if (isset($_GET['akhir'])) {
            $tgl_kunjungan_akhir = $_GET['akhir'];
        }

        $ruang = '';
        if (isset($_GET['ruang'])) {
            $ruang = $_GET['ruang'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        $totalRecords = $this->db('rekap_presensi')
            ->join('pegawai', 'pegawai.id = rekap_presensi.id')
            ->where('stts_aktif','AKTIF')
            ->like('jam_datang', '%' . $tgl_kunjungan . '%')
            ->like('bidang', '%' . $ruang . '%')
            ->like('nama', '%' . $phrase . '%')
            ->group('rekap_presensi.id')
            ->asc('jam_datang')
            ->toArray();

        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'validasi_presensi', '%d?awal=' . $tgl_kunjungan . '&akhir=' . $tgl_kunjungan_akhir . '&ruang=' . $ruang . '&s=' . $phrase]));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();

        $rows = $this->db('rekap_presensi')
            ->select([
                'nama' => 'pegawai.nama',
                'departemen' => 'pegawai.departemen',
                'jbtn' => 'pegawai.jbtn',
                'bidang' => 'pegawai.bidang',
                'id' => 'rekap_presensi.id',
            ])
            ->join('pegawai', 'pegawai.id = rekap_presensi.id')
            ->where('stts_aktif','AKTIF')
            ->like('bidang', '%' . $ruang . '%')
            ->like('nama', '%' . $phrase . '%')
            ->group('rekap_presensi.id')
            ->asc('jam_datang')
            ->offset($offset)
            ->limit($perpage)
            ->toArray();
        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['editURL'] = url([ADMIN, 'presensi', 'rekappresensibyid', $row['id']]);
                $this->assign['list'][] = $row;
            }
        }
        $this->assign['bidang'] = $this->db('bidang')->toArray();
        $this->assign['title'] = 'Validasi Presensi';

        return $this->draw('validasi.html', ['rekap' => $this->assign]);
=======
      foreach ($_POST['presensi'] as $key => $val) {
        $this->settings('presensi', $key, $val);
      }
      $this->notify('success', 'Pengaturan telah disimpan');
      redirect(url([ADMIN, 'presensi', 'settings']));
>>>>>>> 2b8f21087b743017fadbcbdcc3683d00a4e5404d
    }

    public function getRekapPresensiById($id)
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

        $username = $this->db('pegawai')->select('nik')->where('id',$id)->oneArray();

        $totalRecords = $this->db('rekap_presensi')
                ->join('pegawai', 'pegawai.id = rekap_presensi.id')
                ->where('jam_datang', '>', date('Y-' . $bulan) . '-01')
                ->where('jam_datang', '<', date('Y-' . $bulan) . '-31')
                ->where('nik', $username)
                ->asc('jam_datang')
                ->toArray();

        if ($this->core->getUserInfo('id') == 1 and isset($_GET['bulan'])) {
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
                ->where('jam_datang', '>', date('Y-' . $bulan) . '-01')
                ->where('jam_datang', '<', date('Y-' . $bulan) . '-31')
                ->where('rekap_presensi.id', $id)
                ->like('nama', '%' . $phrase . '%')
                ->orLike('shift', '%' . $phrase . '%')
                ->asc('jam_datang')
                ->toArray();
        } elseif (isset($_GET['bulan'])) {
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
                ->where('jam_datang', '>', date('Y-' . $bulan) . '-01')
                ->where('jam_datang', '<', date('Y-' . $bulan) . '-31')
                ->where('rekap_presensi.id', $id)
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
                ->where('jam_datang', '>', date('Y-' . $bulan) . '-01')
                ->where('jam_datang', '<', date('Y-' . $bulan) . '-31')
                ->where('rekap_presensi.id', $id)
                ->asc('jam_datang')
                ->toArray();
        }

        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $this->assign['list'][] = $row;
            }
        }
        $this->assign['totalRecords'] = $totalRecords;
        $this->assign['getStatus'] = isset($_GET['status']);
        $this->assign['getBulan'] = $bulan;
        $this->assign['getUser'] = $username['nik'];
        $this->assign['bulan'] = array('', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        return $this->draw('rekap_presensi_byid.html', ['rekap' => $this->assign]);
    }

    public function getValidasi_Manual($page = 1)
    {
        $this->_addHeaderFiles();

        $perpage = '10';
        $phrase = '';
        if (isset($_GET['s']))
            $phrase = $_GET['s'];

        // $tgl_kunjungan = '2021-01';
        $tgl_kunjungan_akhir = date('Y-m-d');

        if (isset($_GET['awal'])) {
            $tgl_kunjungan = $_GET['awal'];
        }
        if (isset($_GET['akhir'])) {
            $tgl_kunjungan_akhir = $_GET['akhir'];
        }

        $ruang = '';
        if (isset($_GET['ruang'])) {
            $ruang = $_GET['ruang'];
        }

        $username = $this->core->getUserInfo('username', null, true);

        // pagination
        $totalRecords = $this->db('pegawai')
            ->where('stts_aktif','AKTIF')
            ->in('departemen',array("SP","UM"))
            ->like('nama', '%' . $phrase . '%')
            ->toArray();

        $pagination = new \Systems\Lib\Pagination($page, count($totalRecords), 10, url([ADMIN, 'presensi', 'validasi_manual', '%d?s=' . $phrase]));
        $this->assign['pagination'] = $pagination->nav('pagination', '5');
        $this->assign['totalRecords'] = $totalRecords;

        // list
        $offset = $pagination->offset();

        $rows = $this->db('pegawai')
            ->select([
                'nama' => 'pegawai.nama',
                'departemen' => 'pegawai.departemen',
                'jbtn' => 'pegawai.jbtn',
                'bidang' => 'pegawai.bidang',
                'id' => 'pegawai.id',
            ])
            ->where('stts_aktif','AKTIF')
            ->in('departemen',array("SP","UM"))
            ->like('nama', '%' . $phrase . '%')
            ->offset($offset)
            ->limit($perpage)
            ->toArray();
        $this->assign['list'] = [];
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = htmlspecialchars_array($row);
                $row['editURL'] = url([ADMIN, 'presensi', 'rekappresensibyid', $row['id']]);
                $this->assign['list'][] = $row;
            }
        }
        $this->assign['bidang'] = $this->db('bidang')->toArray();
        $this->assign['title'] = 'Validasi Manual Presensi';

        return $this->draw('validasi.manual.html', ['rekap' => $this->assign]);
    }

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
        $year = date('Y');
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
        for ($i=0; $i < count($_POST['shift']); $i++) {
            $jamMasukShift = $this->db('jam_jaga')->where('shift',$_POST['shift'][$i])->oneArray();
            if (strtotime($_POST['jam_datang'][$i]) > strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) {
                if((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) > (10 * 60) && (strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) < (31 * 60)){
                    $jml_pot_tl1 = $jml_pot_tl1 + 1;
                }
                if((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) > (30 * 60) && (strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) < (61 * 60)){
                    $jml_pot_tl2 = $jml_pot_tl2 + 1;
                }
                if((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) > (60 * 60) && (strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) < (91 * 60)){
                    $jml_pot_tl3 = $jml_pot_tl3 + 1;
                }
                if((strtotime($_POST['jam_datang'][$i]) - strtotime(substr($_POST['jam_datang'][$i],0,10) .' '. $jamMasukShift['jam_masuk'])) > (90 * 60)){
                    $jml_pot_tl4 = $jml_pot_tl4 + 1;
                }
            }
            if (strtotime($_POST['jam_pulang'][$i]) < strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang'])) {
                if((strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (10 * 60) && (strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) < (31 * 60)){
                    $jml_pot_psw1 = $jml_pot_psw1 + 1;
                }
                if((strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (30 * 60) && (strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) < (61 * 60)){
                    $jml_pot_psw2 = $jml_pot_psw2 + 1;
                }
                if((strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (60 * 60) && (strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) < (91 * 60)){
                    $jml_pot_psw3 = $jml_pot_psw3 + 1;
                }
                if((strtotime(substr($_POST['jam_pulang'][$i],0,10) .' '. $jamMasukShift['jam_pulang']) - strtotime($_POST['jam_pulang'][$i])) > (90 * 60)){
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
        $cekMalam = $this->db('temporary_presensi')->where('id',$biodata['id'])->like('jam_datang','%'.$cekTanggal.'%')->like('shift','%malam%')->oneArray();
        if ($cekMalam) {
            $jlh = $jlh + 1;
        }

        $cekBkd = $this->db('bridging_bkd_presensi')->where('id',$biodata['id'])->where('bulan',$_POST['bulan'])->where('tahun',$year)->oneArray();
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
        }else{
            $query = $this->db('bridging_bkd_presensi')->where('id',$biodata['id'])->where('bulan',$_POST['bulan'])->where('tahun',$year)->update([
                'jumlah_kehadiran' => $jlh,
                'jumlah_hari_kerja' => $jadwal,
                'persentase_hari_kerja' => '1',
                'jml_pot_keterlambatan' => $jml_pot_terlambat,
                'jml_pot_pulang_lebih_awal' => $jml_pot_pulang,
            ]);
        }
        // print_r($query);
        if ($query) {
            echo 'Sukses';
            $this->notify('success', 'Simpan Sukses');
        } else {
            $this->notify('failure', 'Gagal Simpan');
        }
        exit();
    }

    private function days_in_month($month, $year)
    {
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public function getAuto_Verif()
    {
        $this->_addHeaderFiles();
        return $this->draw('bedcovidlist.html');
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        echo $this->draw(MODULES . '/presensi/js/admin/app.js');
        exit();
    }

    private function _addHeaderFiles()
    {
        // CSS
        $this->core->addCSS(url('assets/css/jquery-ui.css'));
        $this->core->addCSS(url('assets/jscripts/lightbox/lightbox.min.css'));
        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));

        // JS
        $this->core->addJS(url('assets/jscripts/jquery-ui.js'), 'footer');
        $this->core->addJS(url('assets/jscripts/lightbox/lightbox.min.js'), 'footer');
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));

        // MODULE SCRIPTS
        $this->core->addJS(url([ADMIN, 'presensi', 'javascript']), 'footer');
    }

}
