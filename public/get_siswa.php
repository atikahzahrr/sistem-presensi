<?php
require_once __DIR__ . '/../app/models/SiswaModel.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $siswaModel = new SiswaModel();
    $siswa = $siswaModel->getById($_GET['id']);
    
    if ($siswa) {
        echo json_encode([
            'success'        => true,
            'nama_siswa'     => $siswa['nama_siswa'],
            'kelas'          => $siswa['kelas'],
            'jenis_kelamin'  => $siswa['jenis_kelamin'] ?? 'L'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Siswa tidak ditemukan']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID tidak diberikan']);
}