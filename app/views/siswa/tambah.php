<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Siswa</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
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


    <!-- CONTENT -->
    <div class="container pb-5">

        <div class="row justify-content-center">

            <div class="col-md-9 col-lg-8">

                <!-- CARD -->
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4 p-md-5">

                        <!-- JUDUL -->
                        <div class="mb-4">

                            <h2 class="fw-bold mb-1">
                                Tambah Data Siswa
                            </h2>

                            <p class="text-muted mb-0">
                                Tambahkan beberapa siswa sekaligus.
                            </p>

                        </div>


                        <form action="index.php?action=siswa_store"
                              method="POST">


                            <!-- PILIH KELAS -->
                            <div class="mb-4">

                                <label for="kelas"
                                       class="form-label fw-semibold">
                                    Kelas
                                </label>

                                <select name="kelas"
                                        id="kelas"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        -- Pilih Kelas --
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


                            <!-- NAMA SISWA -->
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Nama Siswa
                                </label>

                                <div id="student-list">

                                    <!-- SISWA 1 -->
                                    <div class="student-input mb-3">

                                        <label class="form-label text-muted">
                                            Siswa 1
                                        </label>

                                        <input type="text"
                                               name="nama_siswa[]"
                                               class="form-control"
                                               placeholder="Masukkan nama siswa"
                                               required>

                                    </div>

                                </div>


                                <!-- TOMBOL TAMBAH -->
                                <button type="button"
                                        class="btn btn-outline-primary"
                                        onclick="tambahSiswa()">

                                    + Tambah Siswa

                                </button>

                            </div>


                            <!-- TOMBOL -->
                            <div class="d-flex justify-content-end gap-2">

                                <a href="index.php?action=siswa_index"
                                   class="btn btn-outline-secondary">

                                    Kembali

                                </a>

                                <button type="submit"
                                        class="btn btn-primary">

                                    Simpan Semua

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- JAVASCRIPT -->
    <script>

        let jumlahSiswa = 1;

        function tambahSiswa() {

            jumlahSiswa++;

            const studentList =
                document.getElementById("student-list");

            const div =
                document.createElement("div");

            div.classList.add(
                "student-input",
                "mb-3"
            );

            div.innerHTML = `

                <label class="form-label text-muted">
                    Siswa ${jumlahSiswa}
                </label>

                <input
                    type="text"
                    name="nama_siswa[]"
                    class="form-control"
                    placeholder="Masukkan nama siswa"
                    required
                >

            `;

            studentList.appendChild(div);
        }

    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>