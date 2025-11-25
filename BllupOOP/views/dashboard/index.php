<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="style/assets/Logo.ico" type="x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/css/style-dashboard.css">
</head>

<body>
    <?php include_once('views/layouts/header.php'); ?>

    <header class="hero-header">
        <div class="overlay container">
            <h1 class="display-2 fw-medium" style="font-family: 'Crimson Pro', serif;">Hi, <?= htmlspecialchars($_SESSION['user']['fullname']) ?>!</h1>
            <h5 class="text-light" style="font-family: 'Crimson Pro', serif;">Book Flights, Hotels, and Vehicles in One Place.</h5>
        </div>
    </header>

    <section id="Accomodation" class="container my-5">
    <div class="d-flex justify-content-between align-items-center ">
        <h4 class="mb-0">Accomodation</h4>
        <a href="?c=accommodation&m=index" class="btn btn-dark btn-sm">Lainnya</a>
    </div>
    <hr class="border border-dark border-3 opacity-50">

    <div id="dashboard-accommodation-list" class="row row-cols-2 row-cols-sm-2 row-cols-lg-4 g-4">
        </div>
</section>

    <section id="flight" class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="mb-0">Flights</h4>
            <a href="fitur/flight.php" class="btn btn-dark btn-sm">Lainnya</a>
        </div>
        <hr class="border border-dark border-3 opacity-50">
        <div class="container my-4">
            <div class="row row-cols-2 row-cols-sm-2 row-cols-lg-4 g-4">
                <div class="card p-3 border-2 rounded-3 h-100">
                    <a href="fitur/flight.php" class="text-decoration-none text-dark">
                        <div class="fw-semibold text-muted small">Malang ke</div>
                        <h5 class="fw-bold mb-1">Jakarta</h5>
                        <div class="text-muted small mb-1">Sekali jalan</div>
                        <div class="text-muted small">23 Mei 25</div>
                        <div class="text-danger fw-bold text-end fs-5">IDR ..........</div>
                        <hr class="my-2">
                        <div class="d-flex align-items-center mb-1">
                            <small class="text-muted">Lion Air • Ekonomi</small>
                        </div>
                    </a>
                </div>
                <div class="card p-3 border-2 rounded-3 h-100">
                    <a href="fitur/flight.php" class="text-decoration-none text-dark">
                        <div class="fw-semibold text-muted small">Jakarta ke</div>
                        <h5 class="fw-bold mb-1">Bali</h5>
                        <div class="text-muted small mb-1">Sekali jalan</div>
                        <div class="text-muted small">23 Mei 25</div>
                        <div class="text-danger fw-bold text-end fs-5">IDR ..........</div>
                        <hr class="my-2">
                        <div class="d-flex align-items-center mb-1">
                            <small class="text-muted">Lion Air • Ekonomi</small>
                        </div>
                    </a>
                </div>
                <div class="card p-3 border-2 rounded-3 h-100">
                    <a href="fitur/flight.php" class="text-decoration-none text-dark">
                        <div class="fw-semibold text-muted small">Jakarta ke</div>
                        <h5 class="fw-bold mb-1">Surabaya</h5>
                        <div class="text-muted small mb-1">Sekali jalan</div>
                        <div class="text-muted small">23 Mei 25</div>
                        <div class="text-danger fw-bold text-end fs-5">IDR ..........</div>
                        <hr class="my-2">
                        <div class="d-flex align-items-center mb-1">
                            <small class="text-muted">Lion Air • Ekonomi</small>
                        </div>
                    </a>
                </div>
                <div class="card p-3 border-2 rounded-3 h-100">
                    <a href="fitur/flight.php" class="text-decoration-none text-dark">
                        <div class="fw-semibold text-muted small">Surabaya ke</div>
                        <h5 class="fw-bold mb-1">Bali</h5>
                        <div class="text-muted small mb-1">Sekali jalan</div>
                        <div class="text-muted small">23 Mei 25</div>
                        <div class="text-danger fw-bold text-end fs-5">IDR ..........</div>
                        <hr class="my-2">
                        <div class="d-flex align-items-center mb-1">
                            <small class="text-muted">Lion Air • Ekonomi</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5 mb-5">
        <div class="row align-items-center">
            <div class="col-md-4 text-center text-md-start">
                <h2 class="fw-bold">Travlie Promo!<br>Check it out</h2>
                <a href="?c=promo&m=index" class="btn btn-light text-primary fw-semibold mt-3">Lihat semua promo</a>
            </div>
            <div class="col-md-8">
                <div class="mb-3">
                    <button class="btn btn-outline-secondary promo-filter-btn" data-category="All">All</button>
                    <button class="btn btn-outline-secondary promo-filter-btn" data-category="Flight">Flight</button>
                    <button class="btn btn-outline-secondary promo-filter-btn" data-category="Accommodation">Accommodation</button>
                    <button class="btn btn-outline-secondary promo-filter-btn" data-category="Vehicle Rent">Vehicle Rent</button>
                </div>
                <div id="promo-display-area" class="row g-3">
                </div>
            </div>
        </div>
    </section>

    <section id="rent" class="container my-5">
        <div class="d-flex justify-content-between align-items-center ">
            <h4 class="mb-0">Vehicle Rent</h4>
            <a href="?c=vehicle&m=rent" class="btn btn-dark btn-sm">Lainnya</a>

        </div>
        <hr class="border border-dark border-3 opacity-50">
        <button class="btn rounded-3 btn-outline-primary ">Sewa Mobil</button>
        <button class="btn rounded-3 btn-outline-primary ">Sewa Motor</button>
        <div class="container mt-4">
            <div class="row row-cols-2 row-cols-sm-2 row-cols-lg-4 ">
                <div class="col">
                    <a href="fitur/rent.php" class="text-decoration-none text-dark">
                        <div class="card ">
                            <img src="solaris.png" class="card-img-top" alt="...">
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="fitur/rent.php" class="text-decoration-none text-dark">
                        <div class="card ">
                            <img src="solaris.png" class="card-img-top" alt="...">
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="fitur/rent.php" class="text-decoration-none text-dark">
                        <div class="card ">
                            <img src="solaris.png" class="card-img-top" alt="...">
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="fitur/rent.php" class="text-decoration-none text-dark">
                        <div class="card ">
                            <img src="solaris.png" class="card-img-top" alt="...">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="bus-travel" class="container my-5">
        <div class="d-flex justify-content-between align-items-center ">
            <h4 class="mb-0">Bus & Travel</h4>
            <a href="?c=bus&m=index" class="btn btn-dark btn-sm">Lainnya</a>
        </div>
        <hr class="border border-dark border-3 opacity-50">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <a href="fitur/bus-detail.php" class="text-decoration-none text-dark">
                    <div class="card">
                        <img src="https://placehold.co/600x400/2a9d8f/white?text=Bus" class="card-img-top p-3" alt="Bus Jakarta - Bandung">
                        <div class="card-body">
                            <h6 class="card-title">Bus Jakarta - Bandung</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="fitur/bus-detail.php" class="text-decoration-none text-dark">
                    <div class="card">
                        <img src="https://placehold.co/600x400/e9c46a/white?text=Travel" class="card-img-top p-3" alt="Travel Surabaya - Malang">
                        <div class="card-body">
                            <h6 class="card-title">Travel Surabaya - Malang</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="fitur/bus-detail.php" class="text-decoration-none text-dark">
                    <div class="card">
                        <img src="https://placehold.co/600x400/f4a261/white?text=Bus" class="card-img-top p-3" alt="Bus Solo - Yogyakarta">
                        <div class="card-body">
                            <h6 class="card-title">Bus Solo - Yogyakarta</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="fitur/bus-detail.php" class="text-decoration-none text-dark">
                    <div class="card">
                        <img src="https://placehold.co/600x400/e76f51/white?text=Travel" class="card-img-top p-3" alt="Travel Semarang - Jepara">
                        <div class="card-body">
                            <h6 class="card-title">Travel Semarang - Jepara</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <?php include_once('views/layouts/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="style/js/dashboard.js"></script>
    
</body>
</html>