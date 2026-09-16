<?php

require_once __DIR__ . '/../models/SiswaModel.php';

class SiswaController
{
    private $model;

    public function __construct()
    {
        $this->model = new SiswaModel();
    }

    // Menampilkan daftar siswa
    public function index()
    {
        $siswa = $this->model->getAll();
        $classes = $this->model->getClassOptions();
        require_once __DIR__ . '/../views/siswa/index.php';
    }

    // Menampilkan halaman tambah siswa
    public function create()
    {
        $classes = $this->model->getClassOptions();
        require_once __DIR__ . '/../views/siswa/tambah.php';
    }

    // Menyimpan data siswa
    public function store()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $kelas        = $_POST['kelas'] ?? '';
    $namaSiswa    = $_POST['nama_siswa'] ?? [];
    $jenisKelamin = $_POST['jenis_kelamin'] ?? [];  

    if (empty($kelas)) {
        header("Location: index.php?action=siswa_create&message=error");
        exit;
    }

    if (empty($namaSiswa)) {
        header("Location: index.php?action=siswa_create&message=error");
        exit;
    }

    if (!is_array($namaSiswa)) {
        $namaSiswa = [$namaSiswa];
    }
    if (!is_array($jenisKelamin)) {
        $jenisKelamin = [$jenisKelamin];
    }

    $berhasil = true;

    foreach ($namaSiswa as $index => $nama) {
        $nama = trim($nama);
        if ($nama === '') continue;

        //Ambil jenis kelamin berdasarkan index
        $jk = $jenisKelamin[$index] ?? 'L';

        $data = [
            'nama_siswa'     => $nama,
            'kelas'          => $kelas,
            'jenis_kelamin'  => $jk
        ];

        if (!$this->model->create($data)) {
            $berhasil = false;
            break;
        }
    }

    if ($berhasil) {
        header("Location: index.php?action=siswa_index&message=success");
    } else {
        header("Location: index.php?action=siswa_create&message=error");
    }
    exit;
}

    // Edit siswa
    public function edit()
    {
        if (isset($_GET['id'])) {
            $siswa = $this->model->getById($_GET['id']);
            $classes = $this->model->getClassOptions();
            require_once __DIR__ . '/../views/siswa/edit.php';
        }
    }

    // Update siswa
    public function update()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $id = $_POST['id'];
    $data = [
        'nama_siswa'     => $_POST['nama_siswa'],
        'kelas'          => $_POST['kelas'],
        'jenis_kelamin'  => $_POST['jenis_kelamin'] ?? 'L'  
    ];

    if ($this->model->update($id, $data)) {
        header("Location: index.php?action=siswa_index&message=updated");
    } else {
        header("Location: index.php?action=siswa_edit&id=" . $id . "&message=error");
    }
    exit;
}

    // Hapus siswa
    public function delete()
    {
        if (isset($_GET['id'])) {
            if ($this->model->delete($_GET['id'])) {
                // ✅ PERBAIKAN: page=siswa → action=siswa_index
                header("Location: index.php?action=siswa_index&message=deleted");
                exit;
            } else {
                header("Location: index.php?action=siswa_index&message=delete_error");
                exit;
            }
        }
    }

    // Filter berdasarkan kelas
    public function filterByClass()
    {
        if (!empty($_GET['kelas'])) {
            $siswa = $this->model->getByClass($_GET['kelas']);
        } else {
            $siswa = $this->model->getAll();
        }

        $classes = $this->model->getClassOptions();
        require_once __DIR__ . '/../views/siswa/index.php';
    }
}
?>