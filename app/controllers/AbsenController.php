<?php

require_once __DIR__ . '/../models/AbsenModel.php';
require_once __DIR__ . '/../models/SiswaModel.php';

class AbsenController
{
    private $model;
    private $siswaModel;


    // ==========================================
    // CONSTRUCTOR
    // ==========================================
    public function __construct()
    {
        $this->model = new AbsenModel();
        $this->siswaModel = new SiswaModel();
    }


    // ==========================================
    // HALAMAN UTAMA ABSENSI
    // ==========================================
    public function index()
    {
        // Bulan dan tahun yang dipilih
        $bulan = isset($_GET['bulan'])
            ? (int) $_GET['bulan']
            : date('n');

        $tahun = isset($_GET['tahun'])
            ? (int) $_GET['tahun']
            : date('Y');

        // Filter kelas
        $kelas = isset($_GET['kelas'])
            ? $_GET['kelas']
            : '';


        // Ambil semua siswa
        $siswa = $this->model->getAllStudents($kelas);


        // Ambil data absensi pada bulan tersebut
        $absensiBulanan = $this->model->getMonthlyAttendance(
            $bulan,
            $tahun,
            $kelas
        );


        // Statistik
        $statistik = $this->model->getStatistics();


        // Jumlah hari dalam bulan
        $jumlahHari = cal_days_in_month(
            CAL_GREGORIAN,
            $bulan,
            $tahun
        );


        // Daftar nama bulan
        $namaBulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];


        require_once __DIR__ . '/../views/absen/index.php';
    }


    // ==========================================
    // HALAMAN TAMBAH ABSENSI
    // ==========================================
    public function create()
    {
        $siswa = $this->siswaModel->getAll();

        $keterangan = $this->model->getKeteranganOptions();

        $jenis_kelamin = $this->model->getJenisKelaminOptions();

        $mata_pelajaran = $this->model->getMataPelajaranOptions();

        $guru = $this->model->getGuruOptions();

        require_once __DIR__ . '/../views/absen/tambah.php';
    }


    // ==========================================
    // SIMPAN ABSENSI
    // ==========================================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'id_siswa'       => $_POST['id_siswa'],
                'jenis_kelamin'  => $_POST['jenis_kelamin'],
                'keterangan'     => $_POST['keterangan'],
                'tanggal'        => $_POST['tanggal'],
                'guru'            => $_POST['guru'],
                'mata_pelajaran' => $_POST['mata_pelajaran']
            ];


            if ($this->model->create($data)) {

                header(
                    "Location: index.php?action=absen_index&message=success"
                );

            } else {

                header(
                    "Location: index.php?action=absen_create&message=error"
                );
            }

            exit;
        }
    }


    // ==========================================
    // HALAMAN EDIT ABSENSI
    // ==========================================
    public function edit()
    {
        if (isset($_GET['id'])) {

            $absen = $this->model->getById($_GET['id']);


            // Data tidak ditemukan
            if (!$absen) {

                header(
                    "Location: index.php?action=absen_index&message=notfound"
                );

                exit;
            }


            $siswa = $this->siswaModel->getAll();

            $keterangan = $this->model->getKeteranganOptions();

            $jenis_kelamin = $this->model->getJenisKelaminOptions();

            $mata_pelajaran = $this->model->getMataPelajaranOptions();

            $guru = $this->model->getGuruOptions();


            require_once __DIR__ . '/../views/absen/edit.php';

        } else {

            header(
                "Location: index.php?action=absen_index"
            );

            exit;
        }
    }


    // ==========================================
    // UPDATE ABSENSI
    // ==========================================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            $data = [
                'id_siswa'       => $_POST['id_siswa'],
                'jenis_kelamin'  => $_POST['jenis_kelamin'],
                'keterangan'     => $_POST['keterangan'],
                'tanggal'        => $_POST['tanggal'],
                'guru'            => $_POST['guru'],
                'mata_pelajaran' => $_POST['mata_pelajaran']
            ];


            if ($this->model->update($id, $data)) {

                header(
                    "Location: index.php?action=absen_index&message=updated"
                );

            } else {

                header(
                    "Location: index.php?action=absen_edit&id="
                    . $id
                    . "&message=error"
                );
            }

            exit;
        }
    }


    // ==========================================
    // HAPUS ABSENSI
    // ==========================================
    public function delete()
    {
        if (isset($_GET['id'])) {

            if ($this->model->delete($_GET['id'])) {

                header(
                    "Location: index.php?action=absen_index&message=deleted"
                );
            }

            exit;
        }
    }


    // ==========================================
    // FILTER BERDASARKAN TANGGAL
    // ==========================================
    public function filterByDate()
    {
        if (
            isset($_GET['tanggal']) &&
            !empty($_GET['tanggal'])
        ) {

            $absensi = $this->model->getByDate(
                $_GET['tanggal']
            );

        } else {

            $absensi = $this->model->getAll();
        }


        $statistik = $this->model->getStatistics();

        require_once __DIR__ . '/../views/absen/index.php';
    }


    // ==========================================
    // FILTER BERDASARKAN KELAS
    // ==========================================
    public function filterByClass()
    {
        if (
            isset($_GET['kelas']) &&
            !empty($_GET['kelas'])
        ) {

            $absensi = $this->model->getByClass(
                $_GET['kelas']
            );

        } else {

            $absensi = $this->model->getAll();
        }


        $statistik = $this->model->getStatistics();

        require_once __DIR__ . '/../views/absen/index.php';
    }
}

?>