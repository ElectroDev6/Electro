import NotificationSystem from "/admin-ui/js/common/notification.js";
const params = new URLSearchParams(window.location.search);
const successMessage = params.get("success");
if (successMessage) {
   NotificationSystem.success(decodeURIComponent(successMessage), 5000);
   window.history.replaceState({}, document.title, window.location.pathname);
}
