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
            (n) =>
               !n.is_viewed &&
               n.parent_review_id !== null && // Chỉ lấy phản hồi
               n.parent_user_id === data.userCurrent
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
      // Nếu không có review nào thì clear danh sách và return
      console.log(reviews);

      if (!reviews || reviews.length === 0) {
         this.notificationList.innerHTML = `
         <div class="notification__empty" style="margin: 25px auto;
    width: fit-content">
            Không có thông báo nào
         </div>
      `;
         return;
      }

      const html = reviews
         .filter(
            (item) =>
               item.parent_review_id !== null && // Chỉ lấy phản hồi
               item.parent_user_id === userCurrent && // Phản hồi liên quan đến đánh giá của userCurrent
               item.user_id !== userCurrent // Loại bỏ phản hồi do chính userCurrent viết
         )
         .map((item) => {
            const userName = item.user_name || "Người dùng"; // Lấy tên người viết phản hồi
            const productLink = `/products/${item.product_slug}`;
            const message = `<strong>${userName}</strong> đã trả lời bình luận của bạn về sản phẩm 
                            <a href="${productLink}">${item.product_name}</a>`;
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
