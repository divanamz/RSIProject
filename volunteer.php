<?php
$pageTitle = "Pendaftaran Volunteer";
include 'db.php';
include '..\header.php';

// ==========================
// HANDLE FORM DAFTAR (AJAX)
// ==========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activity_id'])) {

    $user_profile_id = 1; // sementara sebelum ada login
    $activity_id = $_POST['activity_id'];

    $query = "INSERT INTO volunteer (user_profile_id, activity_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_profile_id, $activity_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }

    exit; 
}

$query = "SELECT * FROM program ORDER BY activity_id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Volunteer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vol.css">
</head>

<body>
    <!-- SEARCH -->
    <div class="search-section">
        <input 
            type="text" 
            id="searchInput" 
            placeholder="Cari program volunteer..."
            onkeyup="searchCards()"
        >
    </div>

    <!-- CARD GRID -->
    <div class="blog-grid-container" id="cardContainer">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>

                <div 
                    class="blog-card" 
                    onclick="window.location='detail.php?id=<?= $row['activity_id']; ?>'"
                    data-title="<?= strtolower($row['program_name']); ?>"
                >
                    <div class="image-wrapper">
                        <img src="vol.png" alt="Gambar Program">
                    </div>

                    <div class="card-body">
                        <h3 class="title"><?= htmlspecialchars($row['program_name']); ?></h3>
                        <p><?= htmlspecialchars($row['date']); ?></p>
                        <p><?= htmlspecialchars($row['location']); ?></p>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; width:100%;">Belum ada program volunteer.</p>
        <?php endif; ?>

    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div class="logo">
                <span class="dot-text">..</span> brix **templates**
            </div>

            <nav class="footer-links">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Pricing</a>
                <a href="#">Blog</a>
                <a href="#">Contact</a>
            </nav>

            <div class="social-icons">
                <span>f</span>
                <span>t</span>
                <span>i</span>
                <span>l</span>
            </div>
        </div>

        <p class="copyright">
            Copyright © 2023 BRIX Templates | All Rights Reserved
        </p>
    </footer>

    <!-- JAVASCRIPT SEARCH -->
    <script>
        function searchCards() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let cards = document.querySelectorAll(".blog-card");

            cards.forEach(card => {
                let title = card.dataset.title;
                card.style.display = title.includes(input) ? "block" : "none";
            });
        }
    </script>

</body>
</html>
