// /admin/js/common/pagination.js
document.addEventListener("DOMContentLoaded", () => {
   function initializePagination(containerSelector, itemsPerPage = 6) {
      console.log(
         document.querySelectorAll('[data-target="pagination-container"]')
      );
      const url = window.location.pathname; // Ví dụ: "/admin/orders/edit/123"
      const lastPart = url.substring(url.lastIndexOf("/") + 1);
      const container = document.querySelector(containerSelector);
      if (!container) return;
      let currentPage = 1;
      const rows = container.querySelectorAll(`.${lastPart}-table__row`);
      const pagination = container.querySelector(".pagination");
      const paginationInfo = pagination.querySelector(".pagination__info");
      const paginationControls = pagination.querySelector(
         ".pagination__controls"
      );

      function renderItems() {
         const start = (currentPage - 1) * itemsPerPage;
         const end = start + itemsPerPage;

         rows.forEach((row, index) => {
            row.style.display = index >= start && index < end ? "" : "none";
         });
      }

      function updatePagination() {
         const totalPages = Math.ceil(rows.length / itemsPerPage);
         paginationControls.innerHTML = "";
         for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.className = `pagination__btn ${
               i === currentPage ? "pagination__btn--active" : ""
            }`;
            btn.textContent = i;
            btn.addEventListener("click", () => {
               currentPage = i;
               renderItems();
               updatePagination();
            });
            paginationControls.appendChild(btn);
         }
         paginationInfo.textContent = `Hiển thị ${
            (currentPage - 1) * itemsPerPage + 1
         }-${Math.min(currentPage * itemsPerPage, rows.length)} trong số ${
            rows.length
         } mục`;
      }

      // Khởi tạo
      renderItems();
      updatePagination();
   }
   document
      .querySelectorAll('[data-target="pagination-container"]')
      .forEach((container) => {
         initializePagination(
            `.${container.className.split(" ").join(".")}`,
            6
         );
      });
});
