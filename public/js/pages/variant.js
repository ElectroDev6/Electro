export default class ProductDetail {
  constructor(variants) {
    this.variants = variants;
    this.selectedOptions = { 1: null, 2: null }; // 1: Color, 2: Capacity
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
        const optionId = btn.dataset.optionId;
        const value = btn.dataset.value;
        const skuId = parseInt(btn.dataset.skuId);

        document.querySelectorAll(`.product-detail__option-btn[data-option-id="${optionId}"]`).forEach((el) => el.classList.remove("product-detail__color-btn--active", "product-detail__capacity-btn--active"));
        btn.classList.add(optionId === "1" ? "product-detail__color-btn--active" : "product-detail__capacity-btn--active");

        this.selectedOptions[optionId] = value;
        this.selectedSkuId = skuId; // Cập nhật SKU dựa trên data-sku-id
        this.updateVariantDisplay();
      });
    });
  }

  selectDefaultVariant() {
    const defaultVariant = this.variants[0];
    if (defaultVariant && defaultVariant.attributes) {
      defaultVariant.attributes.forEach((attr, index) => {
        this.selectedOptions[index === 0 ? "1" : "2"] = attr.option_value; // Cập nhật Color và Capacity
      });
    }
    this.updateVariantDisplay();
  }

  updateVariantDisplay() {
    console.log("==> Bắt đầu updateVariantDisplay()");
    console.log("Lựa chọn hiện tại:", this.selectedOptions);
    console.log("SKU ID hiện tại:", this.selectedSkuId);
    console.log("✅ Tìm kiếm variant với sku_id. Danh sách variants:", this.variants);
    console.log(
      "Danh sách sku_ids trong variants:",
      this.variants.map((v) => v.sku_id)
    );

    const variant = this.variants.find((v) => v.sku_id === this.selectedSkuId);
    if (!variant) {
      console.warn("❌ Không tìm thấy variant với sku_id:", this.selectedSkuId);
      return;
    }

    console.log("✅ Variant tìm thấy:", variant);
    console.log("Ảnh của variant:", variant.images); // Thêm log này

    // ✅ Cập nhật giá
    this.priceCurrent.textContent = new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(variant.price_discount);
    this.priceOriginal.textContent = variant.discount_percent ? new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(variant.price_original) : "";
    console.log("💰 Giá cập nhật:", variant.price_discount);

    // ✅ Cập nhật tồn kho và nút hành động
    if (this.stockDisplay) this.stockDisplay.textContent = `Còn ${variant.stock_quantity} sản phẩm`;
    if (this.addToCartBtn) this.addToCartBtn.setAttribute("data-sku-id", variant.sku_id);
    if (this.buyNowBtn) this.buyNowBtn.setAttribute("data-sku-id", variant.sku_id);

    // ✅ Cập nhật ảnh chính
    let defaultImage = variant.images.length > 0 ? variant.images[0] : null; // Lấy ảnh đầu tiên nếu có
    console.log("🖼️ Ảnh mặc định:", defaultImage);
    if (defaultImage) {
      this.mainImage.src = defaultImage.gallery_url;
      console.log("🖼️ Ảnh chính cập nhật:", defaultImage.gallery_url);
    } else {
      console.log("⚠️ Không có ảnh trong variant, giữ ảnh hiện tại:", this.mainImage.src);
      // Giữ ảnh hiện tại nếu không có ảnh mới
    }

    this.thumbnailButtons.forEach((el) => el.classList.remove("product-detail__thumbnail--active"));
    if (defaultImage) {
      const matchedThumbnail = Array.from(this.thumbnailButtons).find((btn) => {
        const img = btn.querySelector("img");
        return img && img.dataset.galleryUrl === defaultImage.gallery_url;
      });
      if (matchedThumbnail) matchedThumbnail.classList.add("product-detail__thumbnail--active");
    }

    // ✅ Cập nhật các thumbnail
    this.thumbnailButtons.forEach((btn, index) => {
      const imgEl = btn.querySelector("img");
      if (imgEl && variant.images[index]) {
        imgEl.src = variant.images[index].thumbnail_url;
        imgEl.dataset.galleryUrl = variant.images[index].gallery_url;
      } else if (imgEl) {
        imgEl.src = ""; // Xóa ảnh nếu không có dữ liệu
        imgEl.dataset.galleryUrl = "";
      }
    });

    console.log("==> Kết thúc updateVariantDisplay()");
  }
}
