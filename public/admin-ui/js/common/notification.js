// Notification System
const NotificationSystem = {
   container: null,
   notifications: [],
   init() {
      // Create container if not exists
      if (!this.container) {
         this.container = document.createElement("div");
         this.container.id = "notification-container";
         document.body.appendChild(this.container);
      }
   },

   show(type, message, duration = 4000) {
      this.init();

      const id = Date.now();
      const notification = this.createElement(id, type, message);

      this.container.appendChild(notification);
      this.notifications.push({ id, element: notification });

      // Show animation
      setTimeout(() => {
         notification.classList.add("notification--show");
      }, 50);

      // Auto hide
      if (duration > 0) {
         setTimeout(() => {
            this.hide(id);
         }, duration);
      }

      return id;
   },

   hide(id) {
      const notificationData = this.notifications.find((n) => n.id === id);
      if (!notificationData) return;

      const { element } = notificationData;
      element.classList.remove("notification--show");
      element.classList.add("notification--hide");

      setTimeout(() => {
         if (element.parentNode) {
            element.parentNode.removeChild(element);
         }
         this.notifications = this.notifications.filter((n) => n.id !== id);
      }, 300);
   },

   createElement(id, type, message) {
      const notification = document.createElement("div");
      notification.className = `notification notification--${type}`;
      notification.setAttribute("data-id", id);

      notification.innerHTML = `
                    <div class="notification__message">${message}</div>
                    <button class="notification__close" onclick="NotificationSystem.hide(${id})">
                        ×
                    </button>
                `;

      return notification;
   },

   success(message, duration) {
      return this.show("success", message, duration);
   },

   error(message, duration) {
      return this.show("error", message, duration);
   },
};

export default NotificationSystem;
