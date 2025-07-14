   <div class="container">
       <?php if ($product): ?>
           <div class="product-header">
               <!-- Phần hình ảnh sản phẩm -->
               <div class="product-gallery">
                   <?php if (!empty($product['images'])): ?>
                       <img
                           src="<?= htmlspecialchars(asset($product['images'][0]['url'])) ?>"
                           alt="<?= htmlspecialchars($product['images'][0]['alt_text'] ?? $product['name']) ?>"
                           class="main-image"
                           id="mainImage">

                       <?php if (count($product['images']) > 1): ?>
                           <div class="thumbnail-list">
                               <?php foreach ($product['images'] as $index => $image): ?>
                                   <img
                                       src="<?= htmlspecialchars(asset($image['url'])) ?>"
                                       alt="<?= htmlspecialchars($image['alt_text'] ?? $product['name']) ?>"
                                       class="thumbnail <?= $index === 0 ? 'active' : '' ?>"
                                       onclick="changeMainImage(this, <?= $index ?>)">
                               <?php endforeach; ?>
                           </div>
                       <?php endif; ?>
                   <?php else: ?>
                       <p>Không có hình ảnh cho sản phẩm này.</p>
                   <?php endif; ?>
               </div>
               <!-- Phần thông tin sản phẩm -->
               <div class="product-info">
                   <h1><?php echo htmlspecialchars($product['name']); ?></h1>

                   <!-- Thông tin thương hiệu -->
                   <div class="brand-info">
                       <?php if (!empty($product['brand_logo'])): ?>
                           <img src="<?php echo htmlspecialchars($product['brand_logo']); ?>"
                               alt="<?php echo htmlspecialchars($product['brand_name']); ?>"
                               class="brand-logo">
                       <?php endif; ?>
                       <span><strong>Thương hiệu:</strong> <?php echo htmlspecialchars($product['brand_name'] ?? 'N/A'); ?></span>
                   </div>

                   <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></p>

                   <!-- Phần giá -->
                   <div class="price-section">
                       <?php if (!empty($product['variants'])): ?>
                           <?php $defaultVariant = $product['variants'][0]; ?>
                           <div class="current-price">
                               <?php echo number_format($defaultVariant['final_price'], 0, ',', '.'); ?>₫
                           </div>
                           <?php if ($defaultVariant['discount_percentage'] > 0): ?>
                               <span class="original-price">
                                   <?php echo number_format($defaultVariant['original_price'], 0, ',', '.'); ?>₫
                               </span>
                               <span class="discount-badge">
                                   -<?php echo $defaultVariant['discount_percentage']; ?>%
                               </span>
                           <?php endif; ?>
                       <?php endif; ?>
                   </div>

                   <!-- Phần variants -->
                   <?php if (!empty($product['variants'])): ?>
                       <div class="variants-section">
                           <!-- Màu sắc -->
                           <?php
                            $colors = [];
                            $storages = [];
                            foreach ($product['variants'] as $variant) {
                                if (!isset($colors[$variant['color_name']])) {
                                    $colors[$variant['color_name']] = $variant['color_hex'];
                                }
                                if (!in_array($variant['storage_capacity'], $storages)) {
                                    $storages[] = $variant['storage_capacity'];
                                }
                            }
                            ?>

                           <?php if (!empty($colors)): ?>
                               <div class="variant-group">
                                   <h4>Màu sắc:</h4>
                                   <div class="variant-options">
                                       <?php foreach ($colors as $colorName => $hexCode): ?>
                                           <div class="color-option"
                                               style="background-color: <?php echo $hexCode; ?>"
                                               title="<?php echo htmlspecialchars($colorName); ?>">
                                           </div>
                                       <?php endforeach; ?>
                                   </div>
                               </div>
                           <?php endif; ?>

                           <?php if (!empty($storages)): ?>
                               <div class="variant-group">
                                   <h4>Dung lượng:</h4>
                                   <div class="variant-options">
                                       <?php foreach ($storages as $storage): ?>
                                           <div class="variant-option">
                                               <?php echo htmlspecialchars($storage); ?>
                                           </div>
                                       <?php endforeach; ?>
                                   </div>
                               </div>
                           <?php endif; ?>
                       </div>
                   <?php endif; ?>

                   <!-- Thông tin tồn kho -->
                   <?php if (!empty($product['stock_quantity'])): ?>
                       <div class="stock-info <?php echo $product['stock_quantity'] < 10 ? 'low-stock' : ''; ?>">
                           <strong>Tồn kho:</strong> <?php echo $product['stock_quantity']; ?> sản phẩm
                           <?php if ($product['stock_quantity'] < 10): ?>
                               <br><small>⚠️ Chỉ còn ít sản phẩm!</small>
                           <?php endif; ?>
                       </div>
                   <?php endif; ?>

                   <!-- Khuyến mãi -->
                   <?php if (!empty($product['promotions'])): ?>
                       <div class="promotions">
                           <h4>🎉 Khuyến mãi đặc biệt:</h4>
                           <?php foreach ($product['promotions'] as $promotion): ?>
                               <div class="promotion-item">
                                   <strong><?php echo htmlspecialchars($promotion['name']); ?></strong>
                                   <?php if (!empty($promotion['description'])): ?>
                                       <p><?php echo htmlspecialchars($promotion['description']); ?></p>
                                   <?php endif; ?>
                               </div>
                           <?php endforeach; ?>
                       </div>
                   <?php endif; ?>
               </div>
           </div>

           <!-- Phần tabs -->
           <div class="tabs">
               <div class="tab-buttons">
                   <button class="tab-button active" onclick="showTab('description')">Mô tả</button>
                   <button class="tab-button" onclick="showTab('specifications')">Thông số kỹ thuật</button>
                   <button class="tab-button" onclick="showTab('warranty')">Bảo hành</button>
                   <button class="tab-button" onclick="showTab('reviews')">Đánh giá</button>
               </div>

               <!-- Tab Mô tả -->
               <div id="description" class="tab-content active">
                   <?php if (!empty($product['descriptions'])): ?>
                       <?php foreach ($product['descriptions'] as $desc): ?>
                           <h3><?php echo htmlspecialchars($desc['title']); ?></h3>
                           <p><?php echo nl2br(htmlspecialchars($desc['content_text'])); ?></p>
                       <?php endforeach; ?>
                   <?php else: ?>
                       <p>Chưa có mô tả cho sản phẩm này.</p>
                   <?php endif; ?>
               </div>

               <!-- Tab Thông số kỹ thuật -->
               <div id="specifications" class="tab-content">
                   <?php if (!empty($product['specifications'])): ?>
                       <table class="specs-table">
                           <?php
                            $currentGroup = '';
                            foreach ($product['specifications'] as $spec):
                                if ($currentGroup !== $spec['spec_group']):
                                    if ($currentGroup !== '') echo '</table><h3>' . htmlspecialchars($spec['spec_group']) . '</h3><table class="specs-table">';
                                    else echo '<h3>' . htmlspecialchars($spec['spec_group']) . '</h3>';
                                    $currentGroup = $spec['spec_group'];
                                endif;
                            ?>
                               <tr>
                                   <th><?php echo htmlspecialchars($spec['spec_name']); ?></th>
                                   <td><?php echo htmlspecialchars($spec['spec_value']); ?></td>
                               </tr>
                           <?php endforeach; ?>
                       </table>
                   <?php else: ?>
                       <p>Chưa có thông số kỹ thuật cho sản phẩm này.</p>
                   <?php endif; ?>
               </div>

               <!-- Tab Bảo hành -->
               <div id="warranty" class="tab-content">
                   <?php if (!empty($product['warranty'])): ?>
                       <?php foreach ($product['warranty'] as $warranty): ?>
                           <div class="warranty-item">
                               <h4><?php echo htmlspecialchars($warranty['name']); ?></h4>
                               <p><strong>Thời gian:</strong> <?php echo $warranty['duration_months']; ?> tháng</p>
                               <p><strong>Giá:</strong> <?php echo number_format($warranty['current_price'], 0, ',', '.'); ?>₫</p>
                               <?php if (!empty($warranty['description'])): ?>
                                   <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($warranty['description']); ?></p>
                               <?php endif; ?>
                               <?php if (!empty($warranty['coverage'])): ?>
                                   <p><strong>Bảo hành:</strong> <?php echo htmlspecialchars($warranty['coverage']); ?></p>
                               <?php endif; ?>
                           </div>
                       <?php endforeach; ?>
                   <?php else: ?>
                       <p>Chưa có thông tin bảo hành cho sản phẩm này.</p>
                   <?php endif; ?>
               </div>

               <!-- Tab Đánh giá -->
               <div id="reviews" class="tab-content">
                   <?php if (!empty($product['reviews'])): ?>
                       <?php foreach ($product['reviews'] as $review): ?>
                           <div class="review-item">
                               <div class="review-header">
                                   <div>
                                       <strong><?php echo htmlspecialchars($review['username']); ?></strong>
                                       <?php if ($review['is_verified_purchase']): ?>
                                           <span style="color: #28a745;">✓ Đã mua hàng</span>
                                       <?php endif; ?>
                                   </div>
                                   <div class="stars">
                                       <?php for ($i = 1; $i <= 5; $i++): ?>
                                           <?php echo $i <= $review['rating'] ? '★' : '☆'; ?>
                                       <?php endfor; ?>
                                   </div>
                               </div>
                               <h4><?php echo htmlspecialchars($review['title']); ?></h4>
                               <p><?php echo nl2br(htmlspecialchars($review['review_content'])); ?></p>
                               <small>Ngày đánh giá: <?php echo date('d/m/Y', strtotime($review['created_at'])); ?></small>
                           </div>
                       <?php endforeach; ?>
                   <?php else: ?>
                       <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                   <?php endif; ?>
               </div>
           </div>
       <?php else: ?>
           <div style="text-align: center; padding: 50px;">
               <h2>Không tìm thấy sản phẩm</h2>
               <p>Sản phẩm bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
           </div>
       <?php endif; ?>
   </div>

   <script>
       function changeMainImage(thumbnail, index) {
           const mainImage = document.getElementById('mainImage');
           const thumbnails = document.querySelectorAll('.thumbnail');

           mainImage.src = thumbnail.src;
           mainImage.alt = thumbnail.alt;

           thumbnails.forEach(thumb => thumb.classList.remove('active'));
           thumbnail.classList.add('active');
       }

       function showTab(tabName) {
           // Ẩn tất cả tab content
           document.querySelectorAll('.tab-content').forEach(tab => {
               tab.classList.remove('active');
           });

           // Bỏ active cho tất cả tab button
           document.querySelectorAll('.tab-button').forEach(button => {
               button.classList.remove('active');
           });

           // Hiển thị tab được chọn
           document.getElementById(tabName).classList.add('active');
           event.target.classList.add('active');
       }

       // Xử lý chọn variant
       document.querySelectorAll('.variant-option').forEach(option => {
           option.addEventListener('click', function() {
               const group = this.parentElement;
               group.querySelectorAll('.variant-option').forEach(opt => {
                   opt.classList.remove('selected');
               });
               this.classList.add('selected');
           });
       });

       document.querySelectorAll('.color-option').forEach(option => {
           option.addEventListener('click', function() {
               const group = this.parentElement;
               group.querySelectorAll('.color-option').forEach(opt => {
                   opt.classList.remove('selected');
               });
               this.classList.add('selected');
           });
       });
   </script>