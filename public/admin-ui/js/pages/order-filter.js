import NotificationSystem from "/admin-ui/js/common/notification.js";
document.addEventListener("DOMContentLoaded", function () {
   const params = new URLSearchParams(window.location.search);
   const successMessage = params.get("success");

   if (successMessage) {
      NotificationSystem.success(decodeURIComponent(successMessage), 5000);
      window.history.replaceState({}, document.title, window.location.pathname);
   }
   const statusSelect = document.querySelector('select[name="status"]');
   const dateSelect = document.querySelector('select[name="date"]');
   const searchInput = document.querySelector('input[name="search"]');
   const filterBtn = document.querySelector(".order-filter__btn--primary");
   const resetBtn = document.querySelector(".order-filter__btn--secondary");
   const tableRows = document.querySelectorAll(".orders-table__row");

   // Lọc khi click nút Lọc
   filterBtn.addEventListener("click", function () {
      filterOrders();
   });

   // Reset khi click nút Reset
   resetBtn.addEventListener("click", function () {
      statusSelect.value = "";
      dateSelect.value = "";
      searchInput.value = "";
      showAllRows();
   });

   function filterOrders() {
      const statusValue = statusSelect.value.toLowerCase();
      const dateValue = dateSelect.value;
      const searchValue = searchInput.value.toLowerCase();

      tableRows.forEach(function (row) {
         let show = true;

         // Lọc theo trạng thái
         if (statusValue) {
            const statusSpan = row.querySelector(".order-table__status");
            if (statusSpan) {
               const statusText = statusSpan.textContent.trim();
               const statusMap = {
                  pending: "Chờ duyệt",
                  paid: "Chờ duyệt",
                  delivering: "Đang giao hàng",
                  delivered: "Đã giao",
                  canceled: "Đã hủy",
               };
               if (statusText !== statusMap[statusValue]) {
                  show = false;
               }
            }
         }

         // Lọc theo ngày
         if (dateValue && show) {
            const dateCell = row.cells[0].textContent.trim();
            // Lấy ngày từ format "HH:mm:ss dd/mm/yyyy"
            const dateParts = dateCell.split(" ");
            if (dateParts.length >= 2) {
               const rowDateStr = dateParts[1]; // dd/mm/yyyy
               const rowDateParts = rowDateStr.split("/");
               if (rowDateParts.length === 3) {
                  const rowDate =
                     rowDateParts[2] +
                     "-" +
                     rowDateParts[1].padStart(2, "0") +
                     "-" +
                     rowDateParts[0].padStart(2, "0"); // yyyy-mm-dd
                  if (rowDate !== dateValue) {
                     show = false;
                  }
               }
            }
         }

         // Lọc theo tìm kiếm
         if (searchValue && show) {
            const orderId = row.cells[1].textContent.toLowerCase();
            const customerName = row.cells[2].textContent.toLowerCase();
            if (
               !orderId.includes(searchValue) &&
               !customerName.includes(searchValue)
            ) {
               show = false;
            }
         }

         // Hiện/ẩn row
         row.style.display = show ? "" : "none";
      });
   }

   function showAllRows() {
      tableRows.forEach(function (row) {
         row.style.display = "";
      });
   }
});
