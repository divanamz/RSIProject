const searchInput = document.getElementById("searchInput");
if (searchInput) {
    searchInput.addEventListener("keyup", function() {
        let input = this.value.toLowerCase();
        let cards = document.querySelectorAll(".blog-card");

        cards.forEach(card => {
            let title = card.querySelector(".title").textContent.toLowerCase();
            card.style.display = title.includes(input) ? "grid" : "none";
        });
    });
}

// KLIK CARD → DETAIL
document.querySelectorAll(".blog-card").forEach(card => {
    card.addEventListener("click", function() {
        let id = this.getAttribute("data-id");
        window.location.href = `detail.php?id=${id}`;
    });
});

// POPUP DAFTAR
document.addEventListener("DOMContentLoaded", function () {

    const btnDaftar = document.querySelector(".detail-btn");
    const popup = document.getElementById("popupDaftar");
    const closeBtn = document.getElementById("closePopup");

    if (btnDaftar && popup && closeBtn) {
        btnDaftar.addEventListener("click", () => popup.style.display = "flex");
        closeBtn.addEventListener("click", () => popup.style.display = "none");

        popup.addEventListener("click", (e) => {
            if (e.target === popup) popup.style.display = "none";
        });
    }

});

