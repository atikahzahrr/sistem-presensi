<?php
$bulan = $bulan ?? date('n');
$tahun = $tahun ?? date('Y');
$kelas = $kelas ?? '';
$jumlahHari = $jumlahHari ?? cal_days_in_month(
    CAL_GREGORIAN,
    $bulan,
    $tahun
);

$namaBulan = $namaBulan ?? [
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

$statistik = $statistik ?? [];

$siswa = $siswa ?? [];

$absensiBulanan = $absensiBulanan ?? [];


// ======================================================
// MENYIAPKAN DATA ABSENSI
// ======================================================

$dataAbsensi = [];

if (!empty($absensiBulanan)) {

    foreach ($absensiBulanan as $absen) {

        $idSiswa = $absen['id_siswa'];

        $tanggal = (int) date(
            'j',
            strtotime($absen['tanggal'])
        );

        $dataAbsensi[$idSiswa][$tanggal] = [
            'keterangan' => $absen['keterangan'],
            'id_absen' => $absen['id_absen']
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Absensi</title>


    <!-- ==================================================
         BOOTSTRAP
    =================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- ==================================================
         STYLE
    =================================================== -->

    <style>

        body {
            background-color: #f8f9fa;
            color: #212529;
        }


        /* ===============================================
           CARD
        =============================================== */

        .card {
            border-radius: 12px;
        }


        /* ===============================================
           TABEL ABSENSI
        =============================================== */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }


        .attendance-table {
            min-width: max-content;
            margin-bottom: 0;
        }


        .attendance-table th,
        .attendance-table td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            height: 45px;
        }


        /* Kolom No */

        .attendance-table .col-no {
            width: 55px;
            min-width: 55px;
            position: sticky;
            left: 0;
            z-index: 4;
            background-color: white;
        }


        /* Kolom Nama */

        .attendance-table .col-nama {
            width: 220px;
            min-width: 220px;
            text-align: left;
            position: sticky;
            left: 55px;
            z-index: 4;
            background-color: white;
        }


        /* Header tabel */

        .attendance-table thead th {
            background-color: #cfe2ff;
            color: #212529;
            font-weight: 600;
            border-color: #b6cbe5;
        }


        .attendance-table thead .col-no,
        .attendance-table thead .col-nama {
            background-color: #cfe2ff;
        }


        /* Kolom tanggal */

        .tanggal-column {
            min-width: 48px;
            width: 48px;
        }


        /* ===============================================
           STATUS ABSENSI
        =============================================== */

        .status {
            font-weight: bold;
            font-size: 14px;
        }


        .status-hadir {
            color: #198754;
        }


        .status-izin {
            color: #ffc107;
        }


        .status-sakit {
            color: #0dcaf0;
        }


        .status-alfa {
            color: #dc3545;
        }


        .status-kosong {
            color: #adb5bd;
        }


        /* ===============================================
           NAMA SISWA
        =============================================== */

        .nama-siswa {
            font-weight: 500;
        }


        /* ===============================================
           INFO PERIODE
        =============================================== */

        .periode {
            font-size: 14px;
            color: #6c757d;
        }


        /* ===============================================
           RESPONSIVE
        =============================================== */

        @media (max-width: 768px) {

            .col-nama {
                width: 170px !important;
                min-width: 170px !important;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVBAR
====================================================== -->

<nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4">

    <div class="container-fluid px-4">

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

<div class="container-fluid px-4 pb-5">


    <!-- =================================================
         HEADER
    ================================================== -->

    <div
        class="d-flex justify-content-between align-items-center mb-4"
    >

        <div>

            <h1 class="fw-bold mb-1">
                Data Absensi
            </h1>

            <p class="text-secondary mb-0">
                Rekap kehadiran siswa
            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="index.php?action=siswa_index"
                class="btn btn-outline-secondary"
            >
                Lihat Siswa
            </a>


            <a
                href="index.php?action=absen_create"
                class="btn btn-primary"
            >
                + Tambah Absensi
            </a>

        </div>

    </div>


    <!-- =================================================
         PESAN
    ================================================== -->

    <?php if (isset($_GET['message'])): ?>

        <?php

        $message = $_GET['message'];

        $alertType = 'danger';

        $alertText = 'Terjadi kesalahan!';


        if ($message == 'success') {

            $alertType = 'success';

            $alertText =
                'Data absensi berhasil ditambahkan!';

        } elseif ($message == 'updated') {

            $alertType = 'success';

            $alertText =
                'Data absensi berhasil diupdate!';

        } elseif ($message == 'deleted') {

            $alertType = 'success';

            $alertText =
                'Data absensi berhasil dihapus!';

        } elseif ($message == 'notfound') {

            $alertType = 'warning';

            $alertText =
                'Data absensi tidak ditemukan!';

        }

        ?>

        <div
            class="alert alert-<?= $alertType ?> alert-dismissible fade show"
            role="alert"
        >

            <?= $alertText ?>


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- =================================================
         STATISTIK
    ================================================== -->

    <div class="row g-3 mb-4">


        <!-- TOTAL -->

        <div class="col-md-6 col-lg">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-secondary mb-2">
                        Total Absensi
                    </p>

                    <h2 class="fw-bold mb-0">

                        <?= $statistik['total_absen'] ?? 0 ?>

                    </h2>

                </div>

            </div>

        </div>


        <!-- HADIR -->

        <div class="col-md-6 col-lg">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-success mb-2">
                        Hadir
                    </p>

                    <h2 class="fw-bold text-success mb-0">

                        <?= $statistik['hadir'] ?? 0 ?>

                    </h2>

                </div>

            </div>

        </div>


        <!-- IZIN -->

        <div class="col-md-6 col-lg">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-warning mb-2">
                        Izin
                    </p>

                    <h2 class="fw-bold text-warning mb-0">

                        <?= $statistik['izin'] ?? 0 ?>

                    </h2>

                </div>

            </div>

        </div>


        <!-- SAKIT -->

        <div class="col-md-6 col-lg">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-info mb-2">
                        Sakit
                    </p>

                    <h2 class="fw-bold text-info mb-0">

                        <?= $statistik['sakit'] ?? 0 ?>

                    </h2>

                </div>

            </div>

        </div>


        <!-- ALFA -->

        <div class="col-md-6 col-lg">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <p class="text-danger mb-2">
                        Alfa
                    </p>

                    <h2 class="fw-bold text-danger mb-0">

                        <?= $statistik['alfa'] ?? 0 ?>

                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- =================================================
         FILTER
    ================================================== -->

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Filter Data
            </h5>


            <form
                method="GET"
                action="index.php"
            >

                <input
                    type="hidden"
                    name="action"
                    value="absen_index"
                >


                <div class="row g-3 align-items-end">


                    <!-- BULAN -->

                    <div class="col-md-3">

                        <label
                            for="bulan"
                            class="form-label"
                        >
                            Bulan
                        </label>


                        <select
                            name="bulan"
                            id="bulan"
                            class="form-select"
                        >

                            <?php foreach (
                                $namaBulan
                                as $nomor => $nama
                            ): ?>

                                <option
                                    value="<?= $nomor ?>"
                                    <?= (
                                        $bulan == $nomor
                                    )
                                        ? 'selected'
                                        : ''
                                    ?>
                                >

                                    <?= $nama ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- TAHUN -->

                    <div class="col-md-3">

                        <label
                            for="tahun"
                            class="form-label"
                        >
                            Tahun
                        </label>


                        <select
                            name="tahun"
                            id="tahun"
                            class="form-select"
                        >

                            <?php

                            $tahunSekarang = date('Y');

                            for (
                                $t = $tahunSekarang - 2;
                                $t <= $tahunSekarang + 2;
                                $t++
                            ):

                            ?>

                                <option
                                    value="<?= $t ?>"
                                    <?= (
                                        $tahun == $t
                                    )
                                        ? 'selected'
                                        : ''
                                    ?>
                                >

                                    <?= $t ?>

                                </option>

                            <?php endfor; ?>

                        </select>

                    </div>


                    <!-- KELAS -->

                    <div class="col-md-4">

                        <label
                            for="kelas"
                            class="form-label"
                        >
                            Kelas
                        </label>


                        <select
                            name="kelas"
                            id="kelas"
                            class="form-select"
                        >

                            <option value="">
                                Semua Kelas
                            </option>


                            <option
                                value="XII RPL 1"
                                <?= (
                                    $kelas == 'XII RPL 1'
                                )
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                XII RPL 1
                            </option>


                            <option
                                value="XII RPL 2"
                                <?= (
                                    $kelas == 'XII RPL 2'
                                )
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                XII RPL 2
                            </option>


                            <option
                                value="XII RPL 3"
                                <?= (
                                    $kelas == 'XII RPL 3'
                                )
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                XII RPL 3
                            </option>

                        </select>

                    </div>


                    <!-- BUTTON -->

                    <div class="col-md-2 d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Filter
                        </button>


                        <a
                            href="index.php?action=absen_index"
                            class="btn btn-outline-secondary"
                        >
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- =================================================
         TABEL REKAP
    ================================================== -->

    <div class="card border-0 shadow-sm">


        <!-- HEADER CARD -->

        <div class="card-body border-bottom">

            <h5 class="fw-bold mb-1">
                Rekap Absensi
            </h5>


            <div class="periode">

                <?= $namaBulan[$bulan] ?? '' ?>

                <?= $tahun ?>


                <?php if (!empty($kelas)): ?>

                    • <?= htmlspecialchars($kelas) ?>

                <?php endif; ?>

            </div>

        </div>


        <!-- =================================================
             TABEL
        ================================================== -->

        <div class="table-wrapper">

            <table
                class="table table-bordered attendance-table"
            >

                <!-- =========================================
                     HEADER TABEL
                ========================================== -->

                <thead>

                    <tr>

                        <th
                            class="col-no"
                            rowspan="2"
                        >
                            No
                        </th>


                        <th
                            class="col-nama"
                            rowspan="2"
                        >
                            Nama Siswa
                        </th>


                        <th
                            colspan="<?= $jumlahHari ?>"
                            class="text-center"
                        >
                            Tanggal
                        </th>

                    </tr>


                    <tr>

                        <?php for (
                            $hari = 1;
                            $hari <= $jumlahHari;
                            $hari++
                        ): ?>

                            <th class="tanggal-column">

                                <?= $hari ?>

                            </th>

                        <?php endfor; ?>

                    </tr>

                </thead>


                <!-- =========================================
                     BODY TABEL
                ========================================== -->

                <tbody>

                    <?php if (!empty($siswa)): ?>


                        <?php foreach (
                            $siswa as $nomor => $row
                        ): ?>

                            <tr>


                                <!-- NOMOR -->

                                <td class="col-no">

                                    <?= $nomor + 1 ?>

                                </td>


                                <!-- NAMA -->

                                <td class="col-nama">

                                    <span class="nama-siswa">

                                        <?= htmlspecialchars(
                                            $row['nama_siswa']
                                        ) ?>

                                    </span>

                                </td>


                                <!-- TANGGAL -->

                                <?php for (
                                    $hari = 1;
                                    $hari <= $jumlahHari;
                                    $hari++
                                ): ?>


                                    <?php

                                    $status = null;

                                    $idAbsen = null;


                                    if (
                                        isset(
                                            $dataAbsensi[
                                                $row['id_siswa']
                                            ][$hari]
                                        )
                                    ) {

                                        $status =
                                            $dataAbsensi[
                                                $row['id_siswa']
                                            ][$hari][
                                                'keterangan'
                                            ];

                                        $idAbsen =
                                            $dataAbsensi[
                                                $row['id_siswa']
                                            ][$hari][
                                                'id_absen'
                                            ];
                                    }

                                    ?>


                                    <td class="tanggal-column">


                                        <?php if (
                                            $status == 'Hadir'
                                        ): ?>

                                            <span
                                                class="status status-hadir"
                                                title="Hadir"
                                            >
                                                H
                                            </span>


                                        <?php elseif (
                                            $status == 'Izin'
                                        ): ?>

                                            <span
                                                class="status status-izin"
                                                title="Izin"
                                            >
                                                I
                                            </span>


                                        <?php elseif (
                                            $status == 'Sakit'
                                        ): ?>

                                            <span
                                                class="status status-sakit"
                                                title="Sakit"
                                            >
                                                S
                                            </span>


                                        <?php elseif (
                                            $status == 'Alfa'
                                        ): ?>

                                            <span
                                                class="status status-alfa"
                                                title="Alfa"
                                            >
                                                A
                                            </span>


                                        <?php else: ?>

                                            <span
                                                class="status status-kosong"
                                                title="Belum ada data"
                                            >
                                                -
                                            </span>

                                        <?php endif; ?>


                                    </td>

                                <?php endfor; ?>


                            </tr>

                        <?php endforeach; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="<?= $jumlahHari + 2 ?>"
                                class="text-center py-5 text-secondary"
                            >

                                Belum ada data siswa.

                            </td>

                        </tr>


                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- =================================================
             KETERANGAN
        ================================================== -->

        <div class="card-body border-top">

            <div class="d-flex flex-wrap gap-4">


                <span>

                    <strong class="text-success">
                        H
                    </strong>

                    = Hadir

                </span>


                <span>

                    <strong class="text-warning">
                        I
                    </strong>

                    = Izin

                </span>


                <span>

                    <strong class="text-info">
                        S
                    </strong>

                    = Sakit

                </span>


                <span>

                    <strong class="text-danger">
                        A
                    </strong>

                    = Alfa

                </span>


                <span>

                    <strong class="text-secondary">
                        -
                    </strong>

                    = Belum ada data

                </span>

            </div>

        </div>


    </div>


</div>


<!-- =====================================================
     BOOTSTRAP JAVASCRIPT
====================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>