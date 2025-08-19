// services.js
export async function getCurrentUser() {
   try {
      const res = await fetch("/admin/users/getCurrentUser");
      if (!res.ok) throw new Error("Phản hồi mạng không thành công");
      return await res.json();
   } catch (error) {
      console.error("Lỗi khi lấy thông tin người dùng:", error);
      return null;
   }
}

export async function getNotification() {
   try {
      const res = await fetch("/admin/notifications");
      if (!res.ok) throw new Error("Phản hồi mạng không thành công");
      return await res.json();
   } catch (error) {
      console.error("Lỗi khi lấy thông tin notification:", error);
      return null;
   }
}
