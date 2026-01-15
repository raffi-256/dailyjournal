<?php
//menyertakan code dari file koneksi
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link rel="icon" href="img/logo.png" />

    <style>
      .accordion-button:not(.collapsed) {
        background-color: #da6a73;
        color: white;
      }
      .dark-mode {
        background-color: #121212 !important;
        color: #f1f1f1 !important;
      }
      .dark-mode .navbar {
        background-color: #1f1f1f !important;
      }
      .dark-mode .card,
      .dark-mode .accordion-body {
        background-color: #1e1e1e;
        color: #eee;
      }
      .dark-mode footer {
        background-color: #1f1f1f;
      }
      body.dark-mode .navbar .nav-link {
        color: white !important;
      }
      body.dark-mode .navbar .nav-link:hover {
        color: #ffc107 !important;
      }
      body.dark-mode .card {
        background-color: #1f1f1f !important;
        color: #f1f1f1 !important;
      }
      body.dark-mode .card-title {
        color: #fff !important;
      }
      body.dark-mode .card-text,
      body.dark-mode small,
      body.dark-mode .text-body-secondary {
        color: #ddd !important;
      }
      body.dark-mode .accordion-button {
        background-color: #2b2b2b !important;
        color: #ffffff !important;
        box-shadow: none !important;
      }
      body.dark-mode .accordion-button:not(.collapsed) {
        background-color: #333333 !important;
        color: #ffffff !important;
      }
      body.dark-mode .accordion-body {
        background-color: #1e1e1e !important;
        color: #f1f1f1 !important;
      }
      body.dark-mode .accordion-item {
        background-color: #1e1e1e !important;
        border-color: #444 !important;
      }
    </style>
  </head>

  <body>
    <!-- NAVBAR START -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">My Daily Journal</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
            <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#article">Article</a></li>
            <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
            <li class="nav-item"><a class="nav-link" href="#schedule">Schedule</a></li>
            <li class="nav-item"><a class="nav-link" href="#aboutme">About Me</a></li>
            <li class="nav-item ms-3 d-flex align-items-center">
              <a class="nav-link" href="login.php" target="_blank">Login</a>
              <button id="btnDark" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-moon"></i>
              </button>
              <button id="btnLight" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-sun"></i>
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- HERO START -->
    <section id="hero" class="text-center bg-danger-subtle p-5 text-sm-start">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="img/banner.jpg" class="img-fluid" width="300" />
          <div>
            <h1 class="fw-bold display-4">
              Create Memories, Save Memories, Everyday
            </h1>
            <h4 class="lead display-6">
              Mencatat semua kegiatan sehari-hari yang ada tanpa terkecuali
            </h4>
            <span id="tanggal"></span> <span id="jam"></span>
          </div>
        </div>
      </div>
    </section>
    <!-- HERO END -->

    <!-- ARTICLE START -->
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <?php
          $sql = "SELECT * FROM article ORDER BY tanggal DESC";
          $hasil = $conn->query($sql);

          while ($row = $hasil->fetch_assoc()) {
          ?>
            <div class="col">
              <div class="card h-100">
                <img src="img/<?= htmlspecialchars($row["gambar"]) ?>" class="card-img-top" />
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($row["judul"]) ?></h5>
                  <p class="card-text"><?= htmlspecialchars($row["isi"]) ?></p>
                </div>
                <div class="card-footer">
                  <small class="text-body-secondary"><?= $row["tanggal"] ?></small>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>
    <!-- ARTICLE END -->

    <!-- ================== GALLERY START (SUDAH FIX & TERHUBUNG DB) ================== -->
    <section id="gallery" class="bg-danger-subtle text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Gallery</h1>

        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">

            <?php
            $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
            $hasil = $conn->query($sql);
            $active = "active";

            if ($hasil && $hasil->num_rows > 0) :
              while ($row = $hasil->fetch_assoc()) :
            ?>
                <div class="carousel-item <?= $active; ?>">
                  <img
                    src="img/<?= htmlspecialchars($row['gambar']); ?>"
                    class="d-block w-100"
                    style="max-height:500px; object-fit:cover;"
                    alt="<?= htmlspecialchars($row['judul']); ?>"
                  />
                  <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                    <h5><?= htmlspecialchars($row['judul']); ?></h5>
                    <p><?= $row['tanggal']; ?> | <?= htmlspecialchars($row['username']); ?></p>
                  </div>
                </div>
            <?php
                $active = ""; // hanya slide pertama yang active
              endwhile;
            else :
            ?>
              <div class="carousel-item active">
                <div class="text-center p-5">Belum ada data gallery</div>
              </div>
            <?php endif; ?>

          </div>

          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon"></span>
          </button>

          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </section>
    <!-- ================== GALLERY END ================== -->

    <!-- ACTIVITY START -->
    <section id="schedule" class="text-center p-5">
      <h1 class="fw-bold display-4 pb-3">Schedule</h1>
      <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 g-4 justify-content-center">
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-book text-danger fs-1"></i>
            <h5 class="mt-3">Membaca</h5>
            <p>Menambah wawasan setiap pagi sebelum beraktivitas.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-laptop text-danger fs-1"></i>
            <h5 class="mt-3">Menulis</h5>
            <p>Mencatat setiap pengalaman harian di jurnal pribadi.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-people text-danger fs-1"></i>
            <h5 class="mt-3">Diskusi</h5>
            <p>Bertukar ide dengan teman dalam kelompok belajar.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-bicycle text-danger fs-1"></i>
            <h5 class="mt-3">Olahraga</h5>
            <p>Menjaga kesehatan dengan bersepeda sore hari.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-film text-danger fs-1"></i>
            <h5 class="mt-3">Movie</h5>
            <p>Menonton film yang bagus di bioskop.</p>
          </div>
        </div>
        <div class="col">
          <div class="p-4 border rounded shadow-sm h-100">
            <i class="bi bi-bag text-danger fs-1"></i>
            <h5 class="mt-3">Belanja</h5>
            <p>Membeli kebutuhan bulanan di supermarket.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- ACTIVITY END -->

    <!-- ABOUT ME START -->
    <section id="aboutme" class="bg-danger-subtle text-center p-5">
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
              Universitas Dian Nuswantoro Semarang (2024-Now)
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <strong>This is the first item’s accordion body.</strong>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
              SMA Negeri 1 Semarang (2024–2021)
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse">
            <div class="accordion-body">
              <strong>This is the second item’s accordion body.</strong>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
              SMP Negeri 2 Semarang (2021–2018)
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse">
            <div class="accordion-body">
              <strong>This is the third item’s accordion body.</strong>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ABOUT ME END -->

    <!-- FOOTER START -->
    <footer class="text-center p-5">
      <div>
        <i class="h2 bi bi-instagram p-2"></i>
        <i class="h2 bi bi-twitter p-2"></i>
        <i class="h2 bi bi-whatsapp p-2"></i>
      </div>
      <div><p>Ibnu Rifai Ardiansyah &copy; 2023</p></div>
    </footer>
    <!-- FOOTER END -->

    <!-- Back to Top -->
    <button id="backToTop" class="btn btn-danger rounded-circle position-fixed bottom-0 end-0 m-3 d-none">
      <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      var btnDark = document.getElementById("btnDark");
      var btnLight = document.getElementById("btnLight");

      btnDark.onclick = function () {
        document.body.classList.add("dark-mode");
      };

      btnLight.onclick = function () {
        document.body.classList.remove("dark-mode");
      };
    </script>

    <script>
      function tampilwaktu() {
        const waktu = new Date();
        const tanggal = waktu.getDate();
        const bulan = waktu.getMonth() + 1;
        const tahun = waktu.getFullYear();
        const jam = waktu.getHours();
        const menit = waktu.getMinutes();
        const detik = waktu.getSeconds();

        document.getElementById("tanggal").innerHTML = tanggal + "/" + bulan + "/" + tahun;
        document.getElementById("jam").innerHTML = jam + ":" + menit + ":" + detik;
      }
      setInterval(tampilwaktu, 1000);
    </script>

    <script>
      const backToTop = document.getElementById("backToTop");
      window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
          backToTop.classList.remove("d-none");
          backToTop.classList.add("d-block");
        } else {
          backToTop.classList.remove("d-block");
          backToTop.classList.add("d-none");
        }
      });
      backToTop.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
      });
    </script>
  </body>
</html>
