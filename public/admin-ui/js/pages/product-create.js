document.addEventListener("DOMContentLoaded", function () {
   let variantCounter = 0;
   let featureCounter = 1;
   let specCounter = 1;

   // DOM Elements
   const mainImagePreview = document.getElementById("mainImagePreview");
   const mainImageInput = document.getElementById("mainImageInput");
   const featuresContainer = document.getElementById("featuresContainer");
   const specsContainer = document.getElementById("specsContainer");
   const variantsContainer = document.getElementById("variantsContainer");
   mainImagePreview.addEventListener("click", function () {
      mainImageInput.click();
   });

   document.getElementById("addSpecBtn").addEventListener("click", function () {
      const specItem = document.createElement("div");
      specItem.className = "product-create__list-item";
      specItem.innerHTML = `
         <input type="text" 
                class="product-create__input" 
                name="specs[${specCounter}][name]" 
                placeholder="Tên thông số (VD: Chip xử lý)">
         <input type="text" 
                class="product-create__input" 
                name="specs[${specCounter}][value]" 
                placeholder="Giá trị (VD: A17 Pro Bionic)">
         <button type="button" class="product-create__btn product-create__btn--icon product-create__btn--danger remove-spec">
             <i class="fas fa-times"></i>
         </button>
      `;
      specsContainer.appendChild(specItem);
      specCounter++;
   });
   specsContainer.addEventListener("click", function (e) {
      if (e.target.closest(".remove-spec")) {
         const specItem = e.target.closest(".product-create__list-item");
         specItem.remove();
      }
   });
   document
      .getElementById("addVariantBtn")
      .addEventListener("click", function () {
         addVariant();
      });

   function addVariant() {
      const variantItem = document.createElement("div");
      variantItem.className = "product-create__variant-item";

      // Generate color options
      let colorOptions = '<option value="">Chọn màu sắc</option>';
      colors.forEach((color) => {
         colorOptions += `<option value="${color.color_id}">${color.name}</option>`;
      });

      // Generate capacity options
      let capacityOptions = '<option value="">Chọn dung lượng</option>';
      capacities.forEach((capacity) => {
         capacityOptions += `<option value="${capacity.capacity_id}">${capacity.name}</option>`;
      });

      variantItem.innerHTML = `
        <div class="product-create__variant-header">
            <h4 class="product-create__variant-title">
                <i class="fas fa-cube"></i> Biến thể #${variantCounter + 1}
            </h4>
            <button type="button" class="product-create__btn product-create__btn--icon product-create__btn--danger remove-variant">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="product-create__variant-content">
            <div class="product-create__form-grid">
                <div class="product-create__form-group">
                    <label class="product-create__label">
                        Màu sắc <span class="required">*</span>
                    </label>
                    <select class="product-create__select" name="variants[${variantCounter}][color_id]" required>
                        ${colorOptions}
                    </select>
                </div>
                <div class="product-create__form-group">
                    <label class="product-create__label">
                        Dung lượng <span class="required">*</span>
                    </label>
                    <select class="product-create__select" name="variants[${variantCounter}][capacity_id]" required>
                        ${capacityOptions}
                    </select>
                </div>
                <div class="product-create__form-group">
                    <label class="product-create__label">
                        Giá bán <span class="required">*</span>
                    </label>
                    <input type="number" 
                           class="product-create__input" 
                           name="variants[${variantCounter}][price]" 
                           placeholder="VD: 29990000" 
                           min="0"
                           required>
                </div>
                <div class="product-create__form-group">
                    <label class="product-create__label">
                        Giá khuyến mãi
                    </label>
                    <input type="number" 
                           class="product-create__input" 
                           name="variants[${variantCounter}][discount_price]" 
                           placeholder="VD: 25990000" 
                           min="0">
                </div>
                <div class="product-create__form-group">
                    <label class="product-create__label">
                        Số lượng tồn kho <span class="required">*</span>
                    </label>
                    <input type="number" 
                           class="product-create__input" 
                           name="variants[${variantCounter}][stock_quantity]" 
                           placeholder="VD: 50" 
                           min="0"
                           required>
                </div>
                <div class="product-create__form-group">
                    <label class="product-create__label">
                        SKU (Mã sản phẩm)
                    </label>
                    <input type="text" 
                           class="product-create__input" 
                           name="variants[${variantCounter}][sku]" 
                           placeholder="VD: IP15PM-TN-512GB">
                </div>
            </div>
            <div class="product-create__variant-images">
                <h5 class="product-create__variant-subtitle">
                    <i class="fas fa-images"></i> Ảnh biến thể
                </h5>
                <div class="product-create__images-grid" id="variantImages${variantCounter}">
                    <div class="product-create__image-upload-item">
                        <div class="product-create__image-preview-small" onclick="triggerVariantImageUpload(${variantCounter}, 0)">
                            <i class="fas fa-plus"></i>
                            <span>Thêm ảnh</span>
                            <input type="file" 
                                   accept="image/*" 
                                   style="display: none;" 
                                   name="variants[${variantCounter}][images][0][file]">
                        </div>
                        <input type="text" 
                               class="product-create__input" 
                               name="variants[${variantCounter}][images][0][alt]" 
                               placeholder="Mô tả ảnh">
                    </div>
                </div>
                <button type="button" class="product-create-btn product-create-btn--outline" onclick="addVariantImage(${variantCounter})">
                    <i class="fas fa-plus"></i> Thêm ảnh khác
                </button>
            </div>
        </div>
    `;
      variantsContainer.appendChild(variantItem);
      variantCounter++;
   }

   // Remove variant
   variantsContainer.addEventListener("click", function (e) {
      if (e.target.closest(".remove-variant")) {
         const variantItem = e.target.closest(".product-create__variant-item");
         variantItem.remove();
      }
   });

   // Variant image upload trigger
   window.triggerVariantImageUpload = function (variantIndex, imageIndex) {
      const input = document.querySelector(
         `#variantImages${variantIndex} .product-create__image-upload-item:nth-child(${
            imageIndex + 1
         }) input[type="file"]`
      );
      input.click();
   };

   // Add variant image
   window.addVariantImage = function (variantIndex) {
      const imageContainer = document.getElementById(
         `variantImages${variantIndex}`
      );
      const imageCount = imageContainer.children.length;

      const newImageItem = document.createElement("div");
      newImageItem.className = "product-create__image-upload-item";
      newImageItem.innerHTML = `
         <div class="product-create__image-preview-small" onclick="triggerVariantImageUpload(${variantIndex}, ${imageCount})">
             <i class="fas fa-plus"></i>
             <span>Thêm ảnh</span>
             <input type="file" 
                    accept="image/*" 
                    style="display: none;" 
                    name="variants[${variantIndex}][images][${imageCount}][file]">
         </div>
         <input type="text" 
                class="product-create__input" 
                name="variants[${variantIndex}][images][${imageCount}][alt]" 
                placeholder="Mô tả ảnh">
      `;
      imageContainer.appendChild(newImageItem);
   };

   const productCreateSelectCategory = document.getElementById("category_id");
   productCreateSelectCategory.addEventListener("change", updateSubcategories);

   function updateSubcategories() {
      const categoryId = document.getElementById("category_id").value;
      const subcategorySelect = document.getElementById("subcategory_id");

      subcategorySelect.innerHTML =
         '<option value="">-- Chọn danh mục con --</option>';
      if (categoryId) {
         fetch(`/admin/categories/subcategories?category_id=${categoryId}`)
            .then((response) => response.json())
            .then((data) => {
               if (data.error) {
                  console.error("Lỗi:", data.error);
                  return;
               }
               data.forEach((item) => {
                  const option = document.createElement("option");
                  option.value = item.subcategory_id;
                  option.text = item.name;
                  subcategorySelect.appendChild(option);
               });
            })
            .catch((error) =>
               console.error("Error fetching subcategories:", error)
            );
      }
   }

   addVariant();
});
