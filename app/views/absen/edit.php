<?php
$absen = $absen ?? [];
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

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Absensi</title>


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
     FORM EDIT
====================================================== -->

<div class="container pb-5">

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-7">


            <div class="card border-0 shadow-sm rounded-4">


                <!-- HEADER -->

                <div class="card-body p-4">

                    <h3 class="fw-bold mb-1">
                        Edit Data Absensi
                    </h3>

                    <p class="text-secondary mb-4">
                        Ubah data kehadiran siswa.
                    </p>


                    <!-- =====================================
                         FORM
                    ====================================== -->

                    <form
                        method="POST"
                        action="index.php?action=absen_update"
                    >


                        <!-- ID ABSENSI -->

                        <input
                            type="hidden"
                            name="id"
                            value="<?= htmlspecialchars(
                                $absen['id_absen'] ?? ''
                            ) ?>"
                        >


                        <!-- =================================
                             NAMA SISWA
                        ================================== -->

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
                                        value="<?= $s['id_siswa'] ?>"
                                        <?= (
                                            ($s['id_siswa'] ?? '')
                                            ==
                                            ($absen['id_siswa'] ?? '')
                                        )
                                            ? 'selected'
                                            : ''
                                        ?>
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


                        <!-- =================================
                             JENIS KELAMIN
                        ================================== -->

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


                                <option
                                    value="L"
                                    <?= (
                                        ($absen['jenis_kelamin'] ?? '')
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
                                        ($absen['jenis_kelamin'] ?? '')
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


                        <!-- =================================
                             TANGGAL
                        ================================== -->

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
                                value="<?= htmlspecialchars(
                                    $absen['tanggal'] ?? ''
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- =================================
                             KETERANGAN
                        ================================== -->

                        <div class="mb-3">

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
                                            <?= (
                                                ($absen['keterangan'] ?? '')
                                                == $ket
                                            )
                                                ? 'checked'
                                                : ''
                                            ?>
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


                        <!-- =================================
                             GURU
                        ================================== -->

                        <div class="mb-3">

                            <label
                                for="guru"
                                class="form-label fw-semibold"
                            >
                                Guru
                            </label>


                            <input
                                type="text"
                                name="guru"
                                id="guru"
                                class="form-control"
                                value="<?= htmlspecialchars(
                                    $absen['guru'] ?? ''
                                ) ?>"
                                placeholder="Masukkan nama guru"
                                required
                            >

                        </div>


                        <!-- =================================
                             MATA PELAJARAN
                        ================================== -->

                        <div class="mb-4">

                            <label
                                for="mata_pelajaran"
                                class="form-label fw-semibold"
                            >
                                Mata Pelajaran
                            </label>


                            <input
                                type="text"
                                name="mata_pelajaran"
                                id="mata_pelajaran"
                                class="form-control"
                                value="<?= htmlspecialchars(
                                    $absen['mata_pelajaran'] ?? ''
                                ) ?>"
                                placeholder="Masukkan mata pelajaran"
                                required
                            >

                        </div>


                        <!-- =================================
                             BUTTON
                        ================================== -->

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="index.php?action=absen_index"
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