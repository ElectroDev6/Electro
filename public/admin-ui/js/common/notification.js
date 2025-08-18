const successNotification = document.getElementById("success-notification");
const successMessage = document.getElementById("success-message");

const errorNotification = document.getElementById("error-notification");
const errorMessage = document.getElementById("error-message");

document.addEventListener("DOMContentLoaded", () => {
   // Success
   if (successMessage && successMessage.textContent.trim() !== "") {
      showNotification(successNotification, "success");
   }

   // Error
   if (errorMessage && errorMessage.textContent.trim() !== "") {
      showNotification(errorNotification, "error");
   }
});

function showNotification(element, type) {
   if (!element) return;

   element.classList.add("show");
   console.log(
      `Notification (${type}) shown with message:`,
      element.textContent.trim()
   );

   setTimeout(() => {
      element.classList.remove("show");
      removeQueryParam(type);
   }, 3000);

   element.addEventListener("click", () => {
      element.classList.remove("show");
      removeQueryParam(type);
   });
}

function removeQueryParam(type) {
   const url = new URL(window.location);
   url.searchParams.delete(type);
   window.history.replaceState({}, document.title, url);
}
