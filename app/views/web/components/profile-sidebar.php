 <!-- SIDEBAR -->
 <div class="profile__sidebar">
     <div class="profile__avatar">
         <img id="avatar-img" src="<?= htmlspecialchars($user['avatar_url'] ?? '/img/avatars/avatar.png') ?>"
             alt="Avatar người dùng" />
     </div>
     <h3 class="profile__name"><?= htmlspecialchars($user['name'] ?? 'Người dùng') ?></h3>
     <p class="profile__phone"><?= htmlspecialchars($user['phone_number'] ?? '') ?></p>

     <button id="edit-avatar-btn" type="button" class="profile__edit-avatar-btn">Sửa avatar</button>

     <form id="avatar-form" class="profile__avatar-form" action="/profile/avatar" method="post"
         enctype="multipart/form-data" style="display:none;">
         <input type="file" name="avatar" accept="image/*" id="avatar-input" required />
         <button type="submit">Cập nhật</button>
     </form>

     <ul class="profile__menu">
         <li><a href="/profile">Tổng quan</a></li>
         <li><a href="/history">Đơn hàng của tôi</a></li>
         <li><a href="/wishlist">Sản phẩm yêu thích</a></li>
         <li><a href="/history">Lịch sử mua hàng</a></li>
         <li><a href="/logout">Đăng xuất</a></li>
     </ul>
 </div>