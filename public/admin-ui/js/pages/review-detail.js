document.addEventListener("DOMContentLoaded", function () {
   // Xử lý click vào nút "Trả lời"
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

            // Clear textarea
            const textarea = replyForm.querySelector("textarea");
            if (textarea) {
               textarea.value = "";
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
