<?php
$siswa = $siswa ?? [];
$classes = $classes ?? [
    'XII RPL 1',
    'XII RPL 2',
    'XII RPL 3'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php?action=siswa_index">Daftar Hadir</a>
        <div class="navbar-nav">
            <a class="nav-link active fw-semibold" href="index.php?action=siswa_index">Siswa</a>
            <a class="nav-link" href="index.php?action=absen_index">Absensi</a>
        </div>
    </div>
</nav>

<!-- FORM EDIT -->
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <!-- HEADER -->
                    <h3 class="fw-bold mb-1">Edit Data Siswa</h3>
                    <p class="text-secondary mb-4">Ubah informasi data siswa.</p>

                    <form method="POST" action="index.php?action=siswa_update">
                        <input
                            type="hidden"
                            name="id"
                            value="<?= htmlspecialchars(
                                $siswa['id_siswa'] ?? ''
                            ) ?>"
                        >


                        <!--  NAMA SISWA -->
                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label fw-semibold">Nama Siswa</label>
                            <input
                                type="text"
                                name="nama_siswa"
                                id="nama_siswa"
                                class="form-control"
                                value="<?= htmlspecialchars(
                                    $siswa['nama_siswa'] ?? ''
                                ) ?>"
                                placeholder="Masukkan nama siswa"
                                required>
                        </div>


                        <!--  JENIS KELAMIN -->
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select
                                name="jenis_kelamin"
                                id="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>


                                <option
                                    value="L"
                                    <?= (
                                        ($siswa['jenis_kelamin'] ?? '')
                                        == 'L'
                                    )
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    Laki-laki
                                </option>


                                <option
                                    value="P"
                                    <?= (
                                        ($siswa['jenis_kelamin'] ?? '')
                                        == 'P'
                                    )
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    Perempuan
                                </option>

                            </select>

                        </div>


                        <!-- =================================================
                             KELAS
                        ================================================== -->

                        <div class="mb-4">

                            <label
                                for="kelas"
                                class="form-label fw-semibold"
                            >
                                Kelas
                            </label>


                            <select
                                name="kelas"
                                id="kelas"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Kelas --
                                </option>


                                <?php foreach (
                                    $classes as $class
                                ): ?>

                                    <option
                                        value="<?= htmlspecialchars(
                                            $class
                                        ) ?>"
                                        <?= (
                                            $class
                                            ==
                                            ($siswa['kelas'] ?? '')
                                        )
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >

                                        <?= htmlspecialchars(
                                            $class
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- =================================================
                             BUTTON
                        ================================================== -->

                        <div
                            class="d-flex justify-content-end gap-2"
                        >

                            <a
                                href="index.php?action=siswa_index"
                                class="btn btn-outline-secondary px-4"
                            >
                                Batal
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary px-4"
                            >
                                Update
                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>