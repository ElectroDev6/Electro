// ./components/ReviewFetcher.js
export default class ReviewFetcher {
   constructor(
      {
         headerNotificationCount,
         headerNotification,
         notification,
         notificationList,
      },
      apiUrl
   ) {
      this.headerNotificationCount = document.getElementById(
         headerNotificationCount
      );
      this.headerNotification = document.getElementById(headerNotification);
      this.notification = document.querySelector(`.${notification}`);
      this.notificationList = document.querySelector(`.${notificationList}`);
      this.apiUrl = apiUrl;
      this.initialize();
   }

   addEventNotification() {
      if (this.headerNotification) {
         this.headerNotification.addEventListener("click", () => {
            this.notification.classList.toggle("show");
         });
      }
   }

   async fetchReviews() {
      try {
         const res = await fetch(this.apiUrl);
         if (!res.ok) throw new Error("Phản hồi mạng không thành công");
         const data = await res.json();
         this.headerNotificationCount.textContent = data.reviews.filter(
            (n) => !n.is_viewed
         ).length;
         this.renderNotification(data.reviews, data.userCurrent);
         return data;
      } catch (error) {
         console.error("Lỗi khi lấy thông tin người dùng:", error);
         return null;
      }
   }

   renderNotification(reviews, userCurrent) {
      if (!this.notificationList) return;
      console.log(reviews);

      const html = reviews
         .filter((item) => item.parent_user_id !== userCurrent)
         .map((item) => {
            const userName =
               item.parent_user_name_from_users_table || "Người dùng";
            const productLink = `/products/${item.product_slug}`;
            const message = `
            <strong>${userName}</strong> đã trả lời bình luận của bạn 
            về sản phẩm <a href="${productLink}">${item.product_name}</a>
         `;
            return `
            <div class="notification__item ${
               !item.is_viewed ? "notification__item--unread" : ""
            }">
               <div class="notification__icon">
                  <img src="/Favicon-icon.png" alt="" class="notification__icon--img">
               </div>
               <div class="notification__content">
                  <p class="notification__text">
                     ${message}
                  </p>
                  <span class="notification__time">
                     ${new Date(item.review_date).toLocaleString("vi-VN")}
                  </span>
               </div>
            </div>
         `;
         })
         .join("");

      this.notificationList.innerHTML = html;
   }

   initialize() {
      // gọi trực tiếp, không cần DOMContentLoaded nữa
      this.fetchReviews();
      this.addEventNotification();
   }
}
