// header.js
import { getCurrentUser } from "./services.js";
document.addEventListener("DOMContentLoaded", async function () {
   const userElement = document.querySelector(".dropdown-menu__title");
   const data = await getCurrentUser();
   if (data && data.success) {
      userElement.textContent = data.user.name || "Người dùng không tên";
   } else {
      userElement.innerHTML = '<a href="/login.php">Đăng nhập</a>';
   }
});
