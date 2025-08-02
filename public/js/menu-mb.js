document.addEventListener("DOMContentLoaded", function () {
  const searchMobileToggle = document.querySelector(".header__search-mobile-toggle");
  const searchDropdown = document.querySelector(".header__search-dropdown");
  const header = document.querySelector("header"); // Cần selector cho phần tử header để tính toán top position

  // Hàm để xử lý click vào icon search mobile
  if (searchMobileToggle && searchDropdown) {
    searchMobileToggle.addEventListener("click", function (e) {
      e.stopPropagation(); // Ngăn sự kiện click lan ra document
      searchDropdown.classList.toggle("active");
    });
  }

  // Hàm để đóng dropdown khi click ra ngoài
  document.addEventListener("click", function (e) {
    // Kiểm tra nếu click không nằm trong dropdown và không nằm trong icon toggle
    if (searchDropdown && searchMobileToggle && !searchDropdown.contains(e.target) && !searchMobileToggle.contains(e.target)) {
      searchDropdown.classList.remove("active");
    }
  });

  // Ngăn chặn sự kiện click lan truyền khi click bên trong dropdown để nó không đóng ngay lập tức
  if (searchDropdown) {
    searchDropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }
});
