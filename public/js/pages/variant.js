export default class ProductDetail {
  constructor(variants) {
    this.variants = variants;
    this.selectedOptions = { Color: null, Capacity: null }; // Sử dụng tên thuộc tính thay vì ID
    this.selectedSkuId = variants[0]?.sku_id || null; // SKU mặc định
    this.init();
  }

  init() {
    this.cacheDom();
    this.bindEvents();
    this.selectDefaultVariant();
  }

  cacheDom() {
    this.mainImage = document.getElementById("main-product-image");
    this.thumbnailButtons = document.querySelectorAll(".product-detail__thumbnail");
    this.optionButtons = document.querySelectorAll(".product-detail__option-btn");
    this.priceCurrent = document.querySelector(".product-detail__current-price");
    this.priceOriginal = document.querySelector(".product-detail__original-price");
    this.stockDisplay = document.querySelector(".product-detail__stock");
    this.addToCartBtn = document.querySelector(".product-detail__btn-add-cart");
    this.buyNowBtn = document.querySelector(".button-buy-now");
    this.discountBadge = document.querySelector(".product-detail__discount-badge");
  }

  bindEvents() {
    this.thumbnailButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const img = btn.querySelector("img");
        this.mainImage.src = img.dataset.galleryUrl;
        this.thumbnailButtons.forEach((el) => el.classList.remove("product-detail__thumbnail--active"));
        btn.classList.add("product-detail__thumbnail--active");
      });
    });

    this.optionButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const optionType = btn.dataset.optionId === "1" ? "Color" : "Capacity";
        let value = btn.dataset.value.toLowerCase();
        console.log("Option type:", optionType, "Value:", value);

        this.selectedOptions[optionType] = value;

        document.querySelectorAll(`.product-detail__option-btn[data-option-id="${btn.dataset.optionId}"]`).forEach((el) => el.classList.remove("product-detail__color-btn--active", "product-detail__capacity-btn--active"));
        btn.classList.add(btn.dataset.optionId === "1" ? "product-detail__color-btn--active" : "product-detail__capacity-btn--active");

        const matchedVariant = this.variants.find((variant) => {
          if (!variant.attributes) return false;

          // Kiểm tra nếu user đã chọn hết tất cả attribute của variant này
          const allAttributesSelected = variant.attributes.every((attr) => this.selectedOptions[attr.attribute_name] !== undefined);
          if (!allAttributesSelected) return false;

          // So sánh từng giá trị đã chọn
          return variant.attributes.every((attr) => {
            const selectedValue = this.selectedOptions[attr.attribute_name];
            const variantValue = attr.option_value.toLowerCase();
            return selectedValue === variantValue;
          });
        });

        this.selectedSkuId = matchedVariant ? matchedVariant.sku_id : this.variants[0].sku_id;
        console.log("Biến thể được chọn:", matchedVariant);

        this.updateVariantDisplay();
      });
    });
  }

  selectDefaultVariant() {
    const defaultVariant = this.variants[0];
    if (defaultVariant && defaultVariant.attributes) {
      defaultVariant.attributes.forEach((attr) => {
        this.selectedOptions[attr.attribute_name] = attr.option_value;
      });
    }
    this.updateVariantDisplay();
  }

  updateVariantDisplay() {
    // console.log("==> Bắt đầu updateVariantDisplay()");
    // console.log("Lựa chọn hiện tại:", this.selectedOptions);
    // console.log("SKU ID hiện tại:", this.selectedSkuId);

    const variant = this.variants.find((v) => v.sku_id === this.selectedSkuId);
    if (!variant) {
      console.error("❌ Không tìm thấy biến thể với sku_id:", this.selectedSkuId);
      return;
    }

    // console.log("✅ Biến thể tìm thấy:", variant);
    // console.log("Ảnh của biến thể:", variant.images);

    // Cập nhật giá
    this.priceCurrent.textContent = new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(variant.price_discount);
    this.priceOriginal.textContent = variant.discount_percent ? new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(variant.price_original) : "";

    // Cập nhật badge giảm giá
    const discountBadge = document.querySelector(".product-detail__discount-badge");
    if (variant.discount_percent && Number(variant.discount_percent) > 0) {
      discountBadge.textContent = `-${variant.discount_percent}%`;
      discountBadge.style.display = "block";
    } else {
      discountBadge.style.display = "none";
    }

    // Cập nhật tồn kho và nút hành động
    if (this.stockDisplay) this.stockDisplay.textContent = `Còn ${variant.stock_quantity} sản phẩm`;
    if (this.addToCartBtn) this.addToCartBtn.setAttribute("data-sku-id", variant.sku_id);
    if (this.buyNowBtn) this.buyNowBtn.setAttribute("data-sku-id", variant.sku_id);

    // Cập nhật ảnh chính
    let defaultImage = variant.images.length > 0 ? variant.images[0] : null;
    if (defaultImage && defaultImage.gallery_url) {
      this.mainImage.src = defaultImage.gallery_url;
      // console.log("🖼️ Ảnh chính cập nhật:", defaultImage.gallery_url);
    } else {
      console.warn("⚠️ Không có ảnh hợp lệ trong biến thể, giữ ảnh hiện tại:", this.mainImage.src);
    }

    // Cập nhật các thumbnail
    const thumbnailContainer = document.querySelector("#thumbnail-container");
    if (thumbnailContainer) {
      thumbnailContainer.innerHTML = ""; // Xóa các thumbnail hiện tại
      variant.images.forEach((img, index) => {
        const thumbnailDiv = document.createElement("div");
        thumbnailDiv.classList.add("product-detail__thumbnail");
        if (index === 0) thumbnailDiv.classList.add("product-detail__thumbnail--active");

        const imgEl = document.createElement("img");
        imgEl.src = img.thumbnail_url;
        imgEl.dataset.galleryUrl = img.gallery_url;
        imgEl.alt = "Thumbnail";

        thumbnailDiv.appendChild(imgEl);
        thumbnailContainer.appendChild(thumbnailDiv);

        imgEl.addEventListener("click", () => {
          this.mainImage.src = img.gallery_url;
          document.querySelectorAll(".product-detail__thumbnail").forEach((el) => el.classList.remove("product-detail__thumbnail--active"));
          thumbnailDiv.classList.add("product-detail__thumbnail--active");
        });
      });
    } else {
      console.error("❌ Không tìm thấy container thumbnail!");
    }

    // console.log("==> Kết thúc updateVariantDisplay()");
  }
}
