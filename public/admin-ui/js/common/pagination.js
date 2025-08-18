const paginationButtons = document.querySelectorAll(".pagination__btn");
// Initialize pagination state
function updatePagination() {
   const currentPage =
      new URLSearchParams(window.location.search).get("page") || "1";
   paginationButtons.forEach((btn) => {
      btn.classList.remove("pagination__btn--active");
      // Only apply active class to the page number button matching the current page
      if (
         btn.classList.contains("page-btn") &&
         btn.dataset.page === currentPage
      ) {
         btn.classList.add("pagination__btn--active");
      }
   });
}
// Prevent clicks on disabled buttons
paginationButtons.forEach((btn) => {
   btn.addEventListener("click", (e) => {
      if (btn.classList.contains("pagination__btn--disabled")) {
         e.preventDefault();
      }
   });
});
// Run on page load
document.addEventListener("DOMContentLoaded", () => {
   updatePagination();
});
