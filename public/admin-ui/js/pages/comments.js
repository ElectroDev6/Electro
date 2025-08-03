import NotificationSystem from "/admin-ui/js/common/notification.js";
document.addEventListener("DOMContentLoaded", () => {
   const params = new URLSearchParams(window.location.search);
   const successMessage = params.get("success");

   if (successMessage) {
      NotificationSystem.success(decodeURIComponent(successMessage), 5000);
      window.history.replaceState({}, document.title, window.location.pathname);
   }

   const tableBody = document.querySelector(".comment-table__body");
   const originalRows = Array.from(
      tableBody.querySelectorAll(".comments-table__row")
   );

   const filters = {
      status: "",
      sort: "newest",
      search: "",
   };

   document
      .querySelector('select[name="status"]')
      ?.addEventListener("change", (e) => {
         filters.status = e.target.value;
      });

   document
      .querySelector('select[name="sort"]')
      ?.addEventListener("change", (e) => {
         filters.sort = e.target.value;
      });

   document
      .querySelector('input[name="search"]')
      ?.addEventListener("input", (e) => {
         filters.search = e.target.value.toLowerCase();
      });

   document
      .querySelector(".comment-filters__search-btn")
      ?.addEventListener("click", (e) => {
         e.preventDefault();
         applyFilters();
      });

   document
      .querySelector(".comment-filters__reset-btn")
      ?.addEventListener("click", (e) => {
         e.preventDefault();
         resetFilters();
         applyFilters();
      });

   function applyFilters() {
      let rows = [...originalRows];
      // Filter by status
      if (filters.status) {
         rows = rows.filter((row) => {
            const statusEl = row.querySelector(".comment-status");

            console.log(`filters.status: `, filters.status);
            return statusEl?.classList.contains(
               `comment-status--${filters.status}`
            );
         });
      }

      // Filter by search
      if (filters.search) {
         rows = rows.filter((row) => {
            const name =
               row
                  .querySelector(".comment-user__name")
                  ?.textContent.toLowerCase() || "";
            const product = row.cells[2]?.textContent.toLowerCase() || "";
            const content =
               row
                  .querySelector(".comment-content")
                  ?.textContent.toLowerCase() || "";
            return (
               name.includes(filters.search) ||
               product.includes(filters.search) ||
               content.includes(filters.search)
            );
         });
      }

      // Sort
      rows.sort((a, b) => {
         const dateA = parseRowDate(a);
         const dateB = parseRowDate(b);
         if (filters.sort === "oldest") return dateA - dateB;
         if (filters.sort === "most_liked") {
            const likeA = parseInt(
               a.querySelector(".comment-likes__count")?.textContent || 0
            );
            const likeB = parseInt(
               b.querySelector(".comment-likes__count")?.textContent || 0
            );
            return likeB - likeA;
         }
         return dateB - dateA; // default: newest
      });

      // Update DOM
      tableBody.innerHTML = "";
      console.log(rows);

      if (rows.length > 0) {
         rows.forEach((row) => tableBody.appendChild(row));
      } else {
         const tr = document.createElement("tr");
         tr.innerHTML = `
            <td colspan="8" class="comment-table__cell" style="text-align:center;padding:2rem;">
               <p style="color:#999;">Không tìm thấy bình luận nào phù hợp.</p>
            </td>`;
         tableBody.appendChild(tr);
      }
   }

   function parseRowDate(row) {
      const date =
         row.querySelector(".comment-date__date")?.textContent || "01/01/1970";
      const time =
         row.querySelector(".comment-date__time")?.textContent || "00:00";
      const [d, m, y] = date.split("/").map(Number);
      const [h, min] = time.split(":").map(Number);
      return new Date(y, m - 1, d, h, min).getTime();
   }

   function resetFilters() {
      filters.status = "";
      filters.sort = "newest";
      filters.search = "";

      document.querySelector('select[name="status"]').value = "";
      document.querySelector('select[name="sort"]').value = "newest";
      document.querySelector('input[name="search"]').value = "";
   }

   // Lọc lần đầu nếu cần
   applyFilters();
});
