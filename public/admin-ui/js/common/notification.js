const notification = document.getElementById("success-notification");
const successMessage = document.getElementById("success-message");

// Show notification if success message exists
document.addEventListener("DOMContentLoaded", () => {
   if (successMessage) {
      if (successMessage.textContent.trim() !== "") {
         notification.classList.add("show");
         console.log(
            "Notification shown with message:",
            successMessage.textContent
         );

         setTimeout(() => {
            notification.classList.remove("show");
            // Remove success query parameter from URL
            const url = new URL(window.location);
            url.searchParams.delete("success");
            window.history.replaceState({}, document.title, url);
         }, 3000);
      }
   }
});

// Hide notification on click
if (notification) {
   notification.addEventListener("click", () => {
      notification.classList.remove("show");
      const url = new URL(window.location);
      url.searchParams.delete("success");
      window.history.replaceState({}, document.title, url);
   });
}
