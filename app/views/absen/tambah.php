<?php
$siswa = $siswa ?? [];
$keterangan = $keterangan ?? [
    'Hadir',
    'Izin',
    'Sakit',
    'Alfa'
];

$jenis_kelamin = $jenis_kelamin ?? [
    'L',
    'P'
];

$mata_pelajaran = $mata_pelajaran ?? [
    'Matematika',
    'Bahasa Indonesia',
    'Bahasa Inggris',
    'Mapel Konsentrasi RPL',
    'PPKn',
    'Pendidikan Agama',
    'PKWU'
];

$guru = $guru ?? [
    'Aditya Dwi Aryanto, M.Kom',
    'Siti Aminah, S.Pd',
    'Ahmad Fauzi, M.Kom',
    'Dewi Lestari, S.Pd',
    'Rudi Hartono, S.Kom'
];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Absensi</title>


    <!-- Bootstrap 5 -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body class="bg-light">


<!-- =====================================================
     NAVBAR
====================================================== -->

<nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4">

    <div class="container">

        <a
            class="navbar-brand fw-bold text-primary"
            href="index.php?action=siswa_index"
        >
            Daftar Hadir
        </a>


        <div class="navbar-nav">

            <a
                class="nav-link"
                href="index.php?action=siswa_index"
            >
                Siswa
            </a>


            <a
                class="nav-link active fw-semibold"
                href="index.php?action=absen_index"
            >
                Absensi
            </a>

        </div>

    </div>

</nav>


<!-- =====================================================
     CONTENT
====================================================== -->

<div class="container pb-5">

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-7">


            <!-- =================================================
                 CARD
            ================================================== -->

            <div class="card border-0 shadow-sm rounded-4">


                <div class="card-body p-4">


                    <!-- HEADER -->

                    <h3 class="fw-bold mb-1">
                        Tambah Data Absensi
                    </h3>


                    <p class="text-secondary mb-4">
                        Masukkan data kehadiran siswa.
                    </p>


                    <!-- =================================================
                         FORM
                    ================================================== -->

                    <form
                        action="index.php?action=absen_store"
                        method="POST"
                    >


                        <!-- =============================================
                             NAMA SISWA
                        ============================================== -->

                        <div class="mb-3">

                            <label
                                for="id_siswa"
                                class="form-label fw-semibold"
                            >
                                Nama Siswa
                            </label>


                            <select
                                name="id_siswa"
                                id="id_siswa"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Siswa --
                                </option>


                                <?php foreach (
                                    $siswa as $s
                                ): ?>

                                    <option
                                        value="<?= htmlspecialchars(
                                            $s['id_siswa']
                                        ) ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $s['nama_siswa']
                                        ) ?>

                                        -

                                        <?= htmlspecialchars(
                                            $s['kelas']
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- =============================================
                             JENIS KELAMIN
                        ============================================== -->

                        <div class="mb-3">

                            <label
                                for="jenis_kelamin"
                                class="form-label fw-semibold"
                            >
                                Jenis Kelamin
                            </label>


                            <select
                                name="jenis_kelamin"
                                id="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>


                                <option value="L">
                                    Laki-laki
                                </option>


                                <option value="P">
                                    Perempuan
                                </option>

                            </select>

                        </div>


                        <!-- =============================================
                             TANGGAL
                        ============================================== -->

                        <div class="mb-3">

                            <label
                                for="tanggal"
                                class="form-label fw-semibold"
                            >
                                Tanggal
                            </label>


                            <input
                                type="date"
                                name="tanggal"
                                id="tanggal"
                                class="form-control"
                                value="<?= date('Y-m-d') ?>"
                                required
                            >

                        </div>


                        <!-- =============================================
                             MATA PELAJARAN
                        ============================================== -->

                        <div class="mb-3">

                            <label
                                for="mata_pelajaran"
                                class="form-label fw-semibold"
                            >
                                Mata Pelajaran
                            </label>


                            <select
                                name="mata_pelajaran"
                                id="mata_pelajaran"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Mata Pelajaran --
                                </option>


                                <?php foreach (
                                    $mata_pelajaran as $mp
                                ): ?>

                                    <option
                                        value="<?= htmlspecialchars(
                                            $mp
                                        ) ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $mp
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- =============================================
                             GURU
                        ============================================== -->

                        <div class="mb-3">

                            <label
                                for="guru"
                                class="form-label fw-semibold"
                            >
                                Guru
                            </label>


                            <select
                                name="guru"
                                id="guru"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Guru --
                                </option>


                                <?php foreach (
                                    $guru as $g
                                ): ?>

                                    <option
                                        value="<?= htmlspecialchars(
                                            $g
                                        ) ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $g
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- =============================================
                             KETERANGAN
                        ============================================== -->

                        <div class="mb-4">

                            <label
                                class="form-label fw-semibold"
                            >
                                Keterangan
                            </label>


                            <div class="d-flex flex-wrap gap-3">


                                <?php foreach (
                                    $keterangan as $ket
                                ): ?>

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="keterangan"
                                            id="ket_<?= strtolower(
                                                $ket
                                            ) ?>"
                                            value="<?= htmlspecialchars(
                                                $ket
                                            ) ?>"
                                            required
                                        >


                                        <label
                                            class="form-check-label"
                                            for="ket_<?= strtolower(
                                                $ket
                                            ) ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $ket
                                            ) ?>

                                        </label>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </div>


                        <!-- =============================================
                             BUTTON
                        ============================================== -->

                        <div
                            class="d-flex justify-content-end gap-2"
                        >

                            <a
                                href="index.php?action=absen_index"
                                class="btn btn-outline-secondary px-4"
                            >
                                Kembali
                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary px-4"
                            >
                                Simpan
                            </button>

                        </div>


                    </form>


                </div>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     BOOTSTRAP JS
====================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>