document.addEventListener("DOMContentLoaded", function () {
   // Xử lý click vào nút "Trả lời" hoặc "Chỉnh sửa"
   const triggers = document.querySelectorAll(".reply-trigger");
   triggers.forEach((trigger) => {
      trigger.addEventListener("click", function (e) {
         e.preventDefault();

         // Ẩn tất cả form reply khác
         const allForms = document.querySelectorAll(".reply-form");
         allForms.forEach((form) => {
            form.style.display = "none";
         });

         // Hiển thị form hiện tại
         const targetId = this.getAttribute("data-target");
         const replyForm = document.getElementById(targetId);

         if (replyForm) {
            replyForm.style.display = "block";

            const textarea = replyForm.querySelector("textarea");
            if (textarea) {
               textarea.focus();
               textarea.setSelectionRange(
                  textarea.value.length,
                  textarea.value.length
               );

               // Nếu là chỉnh sửa, giữ nguyên nội dung cũ
               const action = this.getAttribute("data-action");
               if (action === "edit" && textarea.value) {
                  textarea.setSelectionRange(0, textarea.value.length); // Chọn toàn bộ để dễ chỉnh sửa
               } else {
                  textarea.value = ""; // Xóa nội dung nếu là reply mới
               }
            }
         }
      });
   });

   // Xử lý click vào nút "Hủy" và nút đóng "X"
   const cancelButtons = document.querySelectorAll(
      ".reply-form__cancel, .reply-form__close"
   );
   cancelButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
         e.preventDefault();
         const targetId = this.getAttribute("data-target");
         const replyForm = document.getElementById(targetId);

         if (replyForm) {
            replyForm.style.display = "none";

            // Giữ nguyên nội dung cũ khi hủy nếu là chỉnh sửa
            const textarea = replyForm.querySelector("textarea");
            if (textarea) {
               // Không clear nếu là chỉnh sửa
            }
         }
      });
   });

   // Đóng form khi click ra ngoài
   document.addEventListener("click", function (e) {
      if (
         !e.target.closest(".reply-form") &&
         !e.target.closest(".reply-trigger")
      ) {
         const allForms = document.querySelectorAll(".reply-form");
         allForms.forEach((form) => {
            form.style.display = "none";
         });
      }
   });
});
