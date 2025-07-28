document.addEventListener("DOMContentLoaded", function () {
  const scrollAmount = 300;

  // Chọn tất cả arrow button
  document.querySelectorAll(".arrow-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const isRight = btn.classList.contains("arrow-btn--right");

      // Tìm phần container gần nhất (cùng cấp với button)
      const container = btn.closest(".category-product").querySelector(".category-product__list");

      if (container) {
        container.scrollBy({
          left: isRight ? scrollAmount : -scrollAmount,
          behavior: "smooth",
        });
      }
    });
  });
});
