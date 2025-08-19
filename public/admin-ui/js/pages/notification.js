// header.js
import { getNotification } from "./services.js";

document.addEventListener("DOMContentLoaded", async function () {
   const data = await getNotification();
   if (data && data.success) {
      renderNotifications(data.data);
      renderNotificationsMessage(data.data2);
   }
});

function renderNotifications(notifications) {
   const countIsViewed = notifications.filter((n) => n.is_viewed === 0).length;
   const list = document.querySelector(".notification-list");
   const notificationPanelTitle = document.querySelector(
      ".notification-panel__title"
   );
   notificationPanelTitle.textContent = `Bạn có ${countIsViewed} thông báo mới`;
   list.innerHTML = "";
   const html = notifications
      .map(
         ({
            user_name,
            rating,
            review_date,
            product_name,
            is_viewed,
            review_id,
         }) => `
    <li class="notification-item ${
       is_viewed === 0 ? "is_viewed" : ""
    }" data-id="${review_id}">
        <div class="notification-item__avatar">
            <img src="/icons/info_icon.svg" alt="icon" class="notification-item__avatar-img">
         </div>
         <div class="notification-item__content">
            <div class="notification-item__sender">${user_name}</div>
            <div class="notification-item__message">Đã đánh giá ${rating} sao cho "${product_name}"</div>
            <div class="notification-item__time">${getTimeAgo(
               review_date
            )}</div>
         </div>
    </li>
   `
      )
      .join(" ");
   list.innerHTML = html;
}

function renderNotificationsMessage(notifications) {
   const countIsViewed = notifications.filter((n) => !n.is_viewed).length;
   const list = document.querySelector(".notification-list-message");
   console.log(notifications);
   const notificationPanelTitle = document.querySelector(
      ".notification-panel__title"
   );
   notificationPanelTitle.textContent = `Bạn có ${countIsViewed} thông báo mới`;
   list.innerHTML = "";
   const html = notifications
      .map(
         ({
            user_name,
            rating,
            review_date,
            product_name,
            is_viewed,
            review_id,
         }) => `
    <li class="notification-item ${
       is_viewed === 0 ? "is_viewed" : ""
    }" data-id="${review_id}">
        <div class="notification-item__avatar">
            <img src="/icons/info_icon.svg" alt="icon" class="notification-item__avatar-img">
         </div>
         <div class="notification-item__content">
            <div class="notification-item__sender">${user_name}</div>
            <div class="notification-item__message">Đã đánh giá ${rating} sao cho "${product_name}"</div>
            <div class="notification-item__time">${getTimeAgo(
               review_date
            )}</div>
         </div>
    </li>
   `
      )
      .join(" ");
   list.innerHTML = html;
}

function getTimeAgo(date) {
   const now = new Date();
   const reviewDate = new Date(date);
   const diff = Math.floor((now - reviewDate) / 60000); // phút

   if (diff < 60) return `${diff} phút trước`;
   if (diff < 1440) return `${Math.floor(diff / 60)} giờ trước`;
   return `${Math.floor(diff / 1440)} ngày trước`;
}

document.addEventListener("click", async (e) => {
   const item = e.target.closest(".notification-item");
   if (item) {
      const idReview = item.dataset.id;
      window.location.href = `/admin/reviews/detail?id=${idReview}`;
   }
});
