<?php
require_once __DIR__ . '/../config/database.php';

class AbsenModel {
    private $conn;
    private $table_name = "data_absen";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT
                    data_absen.id_absen,
                    data_absen.id_siswa,
                    siswa.nama_siswa,
                    siswa.kelas,
                    data_absen.jenis_kelamin,
                    data_absen.keterangan,
                    data_absen.tanggal,
                    data_absen.guru,
                    data_absen.mata_pelajaran,
                    data_absen.create_at
                FROM " . $this->table_name . "
                JOIN siswa ON data_absen.id_siswa = siswa.id_siswa
                ORDER BY data_absen.create_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT
                    data_absen.*,
                    siswa.nama_siswa,
                    siswa.kelas
                FROM " . $this->table_name . "
                JOIN siswa ON data_absen.id_siswa = siswa.id_siswa
                WHERE data_absen.id_absen = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . "
                  (id_siswa, jenis_kelamin, keterangan, tanggal, guru, mata_pelajaran)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['id_siswa'],
            $data['jenis_kelamin'],
            $data['keterangan'],
            $data['tanggal'],
            $data['guru'],
            $data['mata_pelajaran']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . "
                  SET id_siswa = ?, jenis_kelamin = ?, keterangan = ?,
                      tanggal = ?, guru = ?, mata_pelajaran = ?
                  WHERE id_absen = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['id_siswa'],
            $data['jenis_kelamin'],
            $data['keterangan'],
            $data['tanggal'],
            $data['guru'],
            $data['mata_pelajaran'],
            $id
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_absen = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getByDate($tanggal) {
        $query = "SELECT data_absen.*, siswa.nama_siswa, siswa.kelas
                  FROM " . $this->table_name . "
                  JOIN siswa ON data_absen.id_siswa = siswa.id_siswa
                  WHERE data_absen.tanggal = ?
                  ORDER BY siswa.nama_siswa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tanggal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStudent($id_siswa) {
        $query = "SELECT data_absen.*, siswa.nama_siswa, siswa.kelas
                  FROM " . $this->table_name . "
                  JOIN siswa ON data_absen.id_siswa = siswa.id_siswa
                  WHERE data_absen.id_siswa = ?
                  ORDER BY data_absen.tanggal DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_siswa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatistics() {
        $query = "SELECT
                    COUNT(*) as total_absen,
                    SUM(CASE WHEN keterangan = 'Hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN keterangan = 'Izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN keterangan = 'Sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN keterangan = 'Alfa' THEN 1 ELSE 0 END) as alfa
                  FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByClass($kelas) {
        $query = "SELECT
                    data_absen.id_absen,
                    siswa.nama_siswa,
                    siswa.kelas,
                    data_absen.jenis_kelamin,
                    data_absen.keterangan,
                    data_absen.tanggal,
                    data_absen.guru,
                    data_absen.mata_pelajaran
                  FROM " . $this->table_name . "
                  JOIN siswa ON data_absen.id_siswa = siswa.id_siswa
                  WHERE siswa.kelas = ?
                  ORDER BY data_absen.tanggal DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$kelas]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
// MENGAMBIL DATA ABSENSI BULANAN
// ==========================================
public function getMonthlyAttendance($bulan, $tahun, $kelas = '')
{
    $query = "SELECT
                data_absen.id_absen,
                data_absen.id_siswa,
                siswa.nama_siswa,
                siswa.kelas,
                data_absen.jenis_kelamin,
                data_absen.keterangan,
                data_absen.tanggal,
                data_absen.guru,
                data_absen.mata_pelajaran
              FROM " . $this->table_name . "
              JOIN siswa
                ON data_absen.id_siswa = siswa.id_siswa
              WHERE MONTH(data_absen.tanggal) = ?
              AND YEAR(data_absen.tanggal) = ?";

    $params = [$bulan, $tahun];

    if (!empty($kelas)) {
        $query .= " AND siswa.kelas = ?";
        $params[] = $kelas;
    }

    $query .= " ORDER BY siswa.nama_siswa ASC,
                       data_absen.tanggal ASC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// ==========================================
// MENGAMBIL SEMUA SISWA
// ==========================================
public function getAllStudents($kelas = '')
{
    $query = "SELECT
                id_siswa,
                nama_siswa,
                jenis_kelamin,
                kelas
              FROM siswa";

    $params = [];

    if (!empty($kelas)) {
        $query .= " WHERE kelas = ?";
        $params[] = $kelas;
    }

    $query .= " ORDER BY nama_siswa ASC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getKeteranganOptions() {
        return ['Hadir', 'Izin', 'Sakit', 'Alfa'];
    }

    public function getJenisKelaminOptions() {
        return ['L', 'P'];
    }

public function getMataPelajaranOptions() {
    return [
        'Matematika',
        'Bahasa Indonesia',
        'Bahasa Inggris',
        'Mapel Konsentrasi RPL',
        'PPKn',
        'Pendidikan Agama',
        'PKWU'
    ];
}

public function getGuruOptions() {
    return [
        'Aditya Dwi Aryanto, M.Kom',
        'Siti Aminah, S.Pd',
        'Ahmad Fauzi, M.Kom',
        'Dewi Lestari, S.Pd',
        'Rudi Hartono, S.Kom'
    ];
}
}
?>