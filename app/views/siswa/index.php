<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4">
        <div class="container">

            <a class="navbar-brand fw-bold text-primary"
               href="index.php?action=siswa_index">
                Daftar Hadir
            </a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link active fw-semibold"
                   href="index.php?action=siswa_index">
                    Siswa
                </a>

                <a class="nav-link"
                   href="index.php?action=absen_index">
                    Absensi
                </a>
            </div>

        </div>
    </nav>


    <!-- Content -->
    <div class="container pb-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="fw-bold mb-1">Data Siswa</h1>
                <p class="text-muted mb-0">
                    Daftar siswa kelas XII RPL
                </p>
            </div>

            <div>
                <a href="index.php?action=siswa_create"
                   class="btn btn-primary">
                    + Tambah Siswa
                </a>

                <a href="index.php?action=absen_index"
                   class="btn btn-outline-secondary">
                    Lihat Absensi
                </a>
            </div>

        </div>


        <!-- Pesan -->
        <?php if (isset($_GET['message'])): ?>

            <?php
                $message = $_GET['message'];

                if ($message == 'success') {
                    $text = "Data siswa berhasil ditambahkan!";
                    $type = "success";
                } elseif ($message == 'updated') {
                    $text = "Data siswa berhasil diupdate!";
                    $type = "success";
                } elseif ($message == 'deleted') {
                    $text = "Data siswa berhasil dihapus!";
                    $type = "success";
                } elseif ($message == 'delete_error') {
                    $text = "Siswa tidak dapat dihapus karena memiliki data absensi!";
                    $type = "danger";
                } else {
                    $text = "Terjadi kesalahan!";
                    $type = "danger";
                }
            ?>

            <div class="alert alert-<?= $type ?> alert-dismissible fade show"
                 role="alert">

                <?= $text ?>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>


        <!-- Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <form method="GET">

                    <input type="hidden"
                           name="action"
                           value="siswa_filter">

                    <div class="row align-items-end g-3">

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Filter Kelas
                            </label>

                            <select name="kelas"
                                    class="form-select">

                                <option value="">
                                    Semua Kelas
                                </option>

                                <option value="XII RPL 1">
                                    XII RPL 1
                                </option>

                                <option value="XII RPL 2">
                                    XII RPL 2
                                </option>

                                <option value="XII RPL 3">
                                    XII RPL 3
                                </option>

                            </select>

                        </div>

                        <div class="col-md-auto">

                            <button type="submit"
                                    class="btn btn-primary">
                                Filter
                            </button>

                            <a href="index.php?action=siswa_index"
                               class="btn btn-outline-secondary">
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        <!-- Tabel -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>ID</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th class="text-center">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($siswa)): ?>

                                <?php foreach ($siswa as $row): ?>

                                    <tr>

                                        <td>
                                            <?= $row['id_siswa'] ?>
                                        </td>

                                        <td>
                                            <span class="fw-semibold">
                                                <?= htmlspecialchars($row['nama_siswa']) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge text-bg-primary">
                                                <?= htmlspecialchars($row['kelas']) ?>
                                            </span>
                                        </td>

                                        <td class="text-center">

                                            <a href="index.php?action=siswa_edit&id=<?= $row['id_siswa'] ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                Edit
                                            </a>

                                            <a href="index.php?action=siswa_delete&id=<?= $row['id_siswa'] ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                                Hapus
                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="4"
                                        class="text-center text-muted py-4">

                                        Belum ada data siswa

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>