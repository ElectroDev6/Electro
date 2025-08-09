import NotificationSystem from "/admin-ui/js/common/notification.js";
// Handle URL success messages
const params = new URLSearchParams(window.location.search);
const successMessage = params.get("success");

if (successMessage) {
   NotificationSystem.success(decodeURIComponent(successMessage), 5000);
   window.history.replaceState({}, document.title, window.location.pathname);
}

// Simple notification function
function showNotification(message, type) {
   const notification = document.createElement("div");
   notification.className = `alert alert-${
      type === "success" ? "success" : "danger"
   }`;
   notification.textContent = message;

   const container = document.querySelector(".comment-detail");
   container.insertBefore(notification, container.firstChild);

   // Auto hide after 5 seconds
   setTimeout(() => {
      if (notification.parentNode) {
         notification.remove();
      }
   }, 5000);
}

// Show main reply form
function showMainReplyForm() {
   const form = document.getElementById("main-reply-form");
   if (form) {
      form.style.display = "block";
      const textarea = form.querySelector("textarea");
      if (textarea) textarea.focus();
   }
}

// Hide main reply form
function hideMainReplyForm() {
   const form = document.getElementById("main-reply-form");
   if (form) {
      form.style.display = "none";
      const textarea = form.querySelector("textarea");
      if (textarea) textarea.value = "";
   }
}

// Show inline reply form
function showReplyForm(replyId) {
   const form = document.getElementById("reply-form-" + replyId);
   if (form) {
      form.style.display = "block";
      const textarea = form.querySelector("textarea");
      if (textarea) textarea.focus();
   }
}

// Hide inline reply form
function hideReplyForm(replyId) {
   const form = document.getElementById("reply-form-" + replyId);
   if (form) {
      form.style.display = "none";
      const textarea = form.querySelector("textarea");
      if (textarea) textarea.value = "";
   }
}

// Form validation before submit
function validateReplyForm(formId) {
   const form = document.getElementById(formId);
   const textarea = form.querySelector("textarea");
   const content = textarea.value.trim();

   if (!content) {
      showNotification("Vui lòng nhập nội dung phản hồi!", "error");
      textarea.focus();
      return false;
   }

   return true;
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
   // Handle reply buttons
   document.querySelectorAll(".reply-btn").forEach((button) => {
      button.addEventListener("click", function (e) {
         e.preventDefault();
         const replyId = this.getAttribute("data-reply-to");
         if (replyId) {
            showReplyForm(replyId);
         }
      });
   });

   // Handle cancel buttons
   document.querySelectorAll(".cancel-reply-btn").forEach((button) => {
      button.addEventListener("click", function (e) {
         e.preventDefault();
         const replyId = this.getAttribute("data-reply-id");
         if (replyId) {
            hideReplyForm(replyId);
         }
      });
   });

   // Handle main reply button
   const mainReplyBtn = document.querySelector(".show-main-reply-btn");
   if (mainReplyBtn) {
      mainReplyBtn.addEventListener("click", function (e) {
         e.preventDefault();
         showMainReplyForm();
      });
   }

   // Handle main reply cancel
   const mainCancelBtn = document.querySelector(".cancel-main-reply-btn");
   if (mainCancelBtn) {
      mainCancelBtn.addEventListener("click", function (e) {
         e.preventDefault();
         hideMainReplyForm();
      });
   }

   // Handle form submissions (validation)
   document.querySelectorAll("form[id*='reply-form']").forEach((form) => {
      form.addEventListener("submit", function (e) {
         const formId = this.id;
         if (!validateReplyForm(formId)) {
            e.preventDefault();
         }
      });
   });

   // Auto-resize textareas
   document.querySelectorAll("textarea").forEach((textarea) => {
      textarea.addEventListener("input", function () {
         this.style.height = "auto";
         this.style.height = this.scrollHeight + "px";
      });
   });

   // Escape key to close forms
   document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
         // Close any open reply forms
         document.querySelectorAll("[id*='reply-form']").forEach((form) => {
            if (form.style.display === "block") {
               form.style.display = "none";
               const textarea = form.querySelector("textarea");
               if (textarea) textarea.value = "";
            }
         });
      }
   });
});

// Make functions globally available if needed
window.showMainReplyForm = showMainReplyForm;
window.hideMainReplyForm = hideMainReplyForm;
window.showReplyForm = showReplyForm;
window.hideReplyForm = hideReplyForm;
