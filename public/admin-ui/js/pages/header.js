// header.js
import { getCurrentUser } from "./services.js";
import { getNotification } from "./services.js";

document.addEventListener("DOMContentLoaded", async function () {
   const data = await getCurrentUser();
   const notification = await getNotification();
   const countIsViewed = notification?.data.filter(
      (n) => n.is_viewed === 0
   ).length;
   const userElement = document.querySelector(".header__user-name");
   const headerUserImage = document.querySelector(".header__user-image");
   const headerNotificationBadge = document.querySelector(
      ".header__notification-badge"
   );
   headerNotificationBadge.textContent = countIsViewed;
   if (!data.user.avatar_url) {
      headerUserImage.src = "/img/avatars/default-avatar.jpg";
      userElement.textContent = data.user.name || "Người dùng không tên";
      return;
   }
   if (data && data.success) {
      userElement.textContent = data.user.name || "Người dùng không tên";
      headerUserImage.src =
         data.user.avatar_url || "/images/default-avatar.png";
   } else {
      userElement.innerHTML = '<a href="/login.php">Đăng nhập</a>';
   }
});
