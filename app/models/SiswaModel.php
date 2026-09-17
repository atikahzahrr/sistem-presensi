<?php
require_once __DIR__ . '/../config/database.php';

class SiswaModel
{
    private $conn;
    private $table_name = "siswa";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Mengambil semua data siswa
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_siswa DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil siswa berdasarkan ID
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_siswa = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengambil siswa berdasarkan kelas
    public function getByClass($kelas)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE kelas = ? ORDER BY nama_siswa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$kelas]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil pilihan kelas
    public function getClassOptions()
    {
        return [
            'XII RPL 1',
            'XII RPL 2',
            'XII RPL 3'
        ];
    }

    // Menambahkan siswa (menerima array data)
    public function create($data)
{
    $query = "INSERT INTO " . $this->table_name . " (nama_siswa, kelas, jenis_kelamin)
              VALUES (:nama_siswa, :kelas, :jenis_kelamin)";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([
        ':nama_siswa'     => $data['nama_siswa'],
        ':kelas'          => $data['kelas'],
        ':jenis_kelamin'  => $data['jenis_kelamin'] ?? 'L'
    ]);
}

    // Update siswa
    public function update($id, $data)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama_siswa = :nama_siswa, kelas = :kelas 
                  WHERE id_siswa = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nama_siswa' => $data['nama_siswa'],
            ':kelas'      => $data['kelas'],
            ':id'         => $id
        ]);
    }

    // Hapus siswa
    public function delete($id)
{
    try {
        $query = "DELETE FROM siswa WHERE id_siswa = ?";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([$id]);

    } catch (PDOException $e) {

        // Jika siswa masih memiliki data absensi
        if ($e->getCode() == '23000') {
            return false;
        }

        return false;
    }
}
}
?>