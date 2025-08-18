<?php use Core\View; ?>
<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>
<div class="container-main">
    <div class="wishlist">
        <div class="wishlist__sidebar">
            <div class="wishlist__avatar">
                <div class="wishlist__avatar-wrapper">
                    <img id="avatar-img" src="<?= htmlspecialchars($user['avatar_url'] ?? '/img/avatars/avatar.png') ?>"
                        alt="Avatar người dùng" />
                </div>
                <h3 class="wishlist__name"><?= htmlspecialchars($user['name'] ?? 'Người dùng') ?></h3>
                <p class="wishlist__phone"><?= htmlspecialchars($user['phone_number'] ?? '') ?></p>
                <button id="edit-avatar-btn" type="button" class="wishlist__edit-avatar-btn">Sửa avatar</button>
                <form id="avatar-form" class="wishlist__avatar-form" action="/wishlist/avatar" method="post"
                    enctype="multipart/form-data" style="display:none;">
                    <input type="file" name="avatar" accept="image/*" id="avatar-input" required />
                    <button type="submit">Cập nhật</button>
                </form>
            </div>

            <ul class="wishlist__menu">
                <li><a href="/profile">Tổng quan</a></li>
                <li><a href="/history">Đơn hàng của tôi</a></li>
                <li><a href="/wishlist">Sản phẩm yêu thích</a></li>
                <li><a href="/history">Lịch sử mua hàng</a></li>
                <li><a href="/logout">Đăng xuất</a></li>
            </ul>
        </div>

        <div class="wishlist__content">
            <h2 class="wishlist__title">Sản phẩm yêu thích</h2>

            <?php if (empty($wishlist)): ?>
            <p class="wishlist__empty">Bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>
            <?php else: ?>
            <div class="wishlist__grid">
                <?php foreach ($wishlist as $item): ?>
                <div class="wishlist__card">

                    <div class="wishlist__card-name-wrapper">
                        <span class="wishlist__heart">❤️</span>
                        <span
                            class="wishlist__card-name"><?= htmlspecialchars((string)($item['product_name'] ?? 'Sản phẩm chưa có tên')) ?></span>
                    </div>

                    <img src="/img/products/default/<?= htmlspecialchars((string)($item['image_url'] ?? '/img/no-image.png')) ?>"
                        alt="<?= htmlspecialchars((string)($item['product_name'] ?? 'Sản phẩm')) ?>"
                        class="wishlist__card-img">

                    <form method="post" action="/wishlist/remove">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['product_id']) ?>">
                        <button type="submit" class="wishlist__remove">Xóa</button>

                    </form>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php View::endSection(); ?>