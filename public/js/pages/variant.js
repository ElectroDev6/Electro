export default class ProductVariantManager {
  constructor(variants, images) {
    console.log("Variants:", variants);
    console.log("Images:", images);
    this.variants = variants;
    this.images = images;
    this.selectedOptions = { Color: null, Capacity: null };
    this.selectedSkuId = variants[0]?.sku_id || null;
    this.init();
  }

  init() {
    this.cacheDom();
    this.bindEvents();
    this.selectDefaultVariant();
    this.updateCapacityButtons();
  }

  cacheDom() {
    this.mainImage = document.getElementById("main-product-image");
    this.thumbnailContainer = document.querySelector("#thumbnail-container");
    this.optionButtons = document.querySelectorAll(".product-detail__option-btn");
    this.colorButtons = document.querySelectorAll(".product-detail__color-btn");
    this.capacityButtons = document.querySelectorAll(".product-detail__capacity-btn");
    this.priceCurrent = document.querySelector(".product-detail__current-price");
    this.priceOriginal = document.querySelector(".product-detail__original-price");
    this.discountBadge = document.querySelector(".product-detail__discount-badge");
    this.stockDisplay = document.querySelector(".product-detail__stock");
    this.addToCartBtn = document.querySelector(".product-detail__btn-add-cart");
    this.qtyInput = document.querySelector(".product-detail__qty-input");
    this.qtyMinusBtn = document.querySelector(".product-detail__qty-btn--minus");
    this.qtyPlusBtn = document.querySelector(".product-detail__qty-btn--plus");
  }

  bindEvents() {
    this.thumbnailContainer?.addEventListener("click", (e) => {
      const img = e.target.closest("img");
      if (img && img.dataset.galleryUrl) {
        console.log("Thumbnail clicked - Setting main image to:", img.dataset.galleryUrl);
        this.mainImage.src = img.dataset.galleryUrl;
        this.thumbnailContainer.querySelectorAll(".product-detail__thumbnail").forEach((el) => el.classList.remove("product-detail__thumbnail--active"));
        img.parentElement.classList.add("product-detail__thumbnail--active");
      }
    });

    this.optionButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const optionType = btn.dataset.optionId === "1" ? "Color" : "Capacity";
        const value = btn.dataset.value.toLowerCase();
        console.log(`Option selected - Type: ${optionType}, Value: ${value}`);

        this.selectedOptions[optionType] = value;

        document.querySelectorAll(`.product-detail__option-btn[data-option-id="${btn.dataset.optionId}"]`).forEach((el) => el.classList.remove(`product-detail__${optionType.toLowerCase()}-btn--active`));
        btn.classList.add(`product-detail__${optionType.toLowerCase()}-btn--active`);

        if (optionType === "Color") {
          console.log("Color changed, updating capacity buttons");
          this.updateCapacityButtons();
        }

        const matchedVariant = this.variants.find((variant) => {
          if (!variant.attributes) return false;
          return variant.attributes.every((attr) => {
            const selectedValue = this.selectedOptions[attr.attribute_name];
            return selectedValue && selectedValue.toLowerCase() === attr.option_value.toLowerCase();
          });
        });

        this.selectedSkuId = matchedVariant ? matchedVariant.sku_id : this.variants[0].sku_id;
        console.log("Selected SKU:", this.selectedSkuId, "Options:", this.selectedOptions);
        this.updateVariantDisplay();
      });
    });

    this.qtyPlusBtn?.addEventListener("click", () => {
      const currentQty = parseInt(this.qtyInput.value) || 1;
      const variant = this.variants.find((v) => v.sku_id === this.selectedSkuId);
      if (variant && currentQty < variant.stock_quantity) {
        this.qtyInput.value = currentQty + 1;
        console.log("Quantity increased to:", this.qtyInput.value);
      } else {
        console.warn("Cannot increase quantity - Stock limit or variant not found:", { stock: variant?.stock_quantity, currentQty });
      }
    });

    this.qtyMinusBtn?.addEventListener("click", () => {
      const currentQty = parseInt(this.qtyInput.value) || 1;
      if (currentQty > 1) {
        this.qtyInput.value = currentQty - 1;
        console.log("Quantity decreased to:", this.qtyInput.value);
      } else {
        console.log("Cannot decrease quantity - Already at minimum");
      }
    });

    this.addToCartBtn?.addEventListener("click", () => {
      const quantity = parseInt(this.qtyInput.value) || 1;
      const color = this.selectedOptions.Color || this.variants[0]?.attributes.find((attr) => attr.attribute_name === "Color")?.option_value.toLowerCase() || "";
      const imageUrl = this.getImageUrl(color);
      console.log("Adding to cart - Data:", {
        sku_id: this.selectedSkuId,
        quantity: quantity,
        color: color,
        image_url: imageUrl,
      });

      fetch("/detail/add-to-cart", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify({
          sku_id: this.selectedSkuId,
          quantity: quantity,
          color: color,
          warranty_enabled: false,
          image_url: imageUrl,
        }),
      })
        .then((response) => {
          console.log("Add to cart response status:", response.status);
          return response.json();
        })
        .then((data) => {
          console.log("Add to cart response data:", data);
          if (data.success) {
            alert(data.message);
            console.log("Add to cart successful, updating cart count");
            this.updateCartCount();
            if (data.redirect) {
              console.log("Redirecting to:", data.redirect);
              window.location.href = data.redirect;
            }
          } else {
            console.error("Add to cart failed:", data.message || "Unknown error");
            alert(data.message || "Đã xảy ra lỗi khi thêm vào giỏ hàng.");
          }
        })
        .catch((error) => {
          console.error("Add to cart error:", error);
          alert("Đã xảy ra lỗi khi thêm vào giỏ hàng.");
        });
    });
  }

  getImageUrl(color) {
    const selectedColor = color || this.selectedOptions.Color || this.variants[0]?.attributes.find((attr) => attr.attribute_name === "Color")?.option_value.toLowerCase() || "";
    let imagesForVariant = this.images[this.selectedSkuId] || {};
    console.log("Getting image for SKU:", this.selectedSkuId, "Color:", selectedColor);

    if (!imagesForVariant.thumbnail_url || !imagesForVariant.gallery_urls) {
      const fallbackVariant = this.variants.find((v) => {
        if (!v.attributes) return false;
        return v.attributes.some((attr) => attr.attribute_name === "Color" && attr.option_value.toLowerCase() === selectedColor);
      });
      console.log("No images for SKU, using fallback variant:", fallbackVariant?.sku_id);
      imagesForVariant = this.images[fallbackVariant?.sku_id] || {};
    }

    const imageUrl = imagesForVariant.thumbnail_url ? `${imagesForVariant.thumbnail_url[0]}` : "/img/placeholder.jpg";
    console.log("Selected image URL:", imageUrl);
    return imageUrl;
  }

  updateCartCount() {
    console.log("Fetching cart item count from /cart/item-count");
    fetch("/cart/item-count", {
      method: "GET",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => {
        console.log("Cart count response status:", response.status);
        return response.json();
      })
      .then((data) => {
        console.log("Cart count response data:", data);
        if (data.success) {
          const countElement = document.querySelector(".header__count");
          console.log("Cart count element:", countElement, "Count:", data.count);
          if (countElement) {
            countElement.textContent = data.count;
          } else {
            console.warn("Cart count element not found");
          }
        } else {
          console.error("Failed to fetch cart count:", data.message || "Unknown error");
        }
      })
      .catch((error) => {
        console.error("Error fetching cart count:", error);
      });
  }

  selectDefaultVariant() {
    const defaultVariant = this.variants[0];
    if (defaultVariant && defaultVariant.attributes) {
      defaultVariant.attributes.forEach((attr) => {
        this.selectedOptions[attr.attribute_name] = attr.option_value.toLowerCase();
      });
      this.selectedSkuId = defaultVariant.sku_id;
    }
    console.log("Default SKU:", this.selectedSkuId, "Options:", this.selectedOptions);
    this.updateVariantDisplay();
    this.updateCapacityButtons();
  }

  updateCapacityButtons() {
    const selectedColor = this.selectedOptions.Color;
    this.capacityButtons.forEach((btn) => {
      const capacity = btn.dataset.value.toLowerCase();
      const isValid = this.variants.some((variant) => {
        if (!variant.attributes) return false;
        return variant.attributes.some((attr) => attr.attribute_name === "Color" && attr.option_value.toLowerCase() === selectedColor && variant.attributes.some((attr2) => attr2.attribute_name === "Capacity" && attr2.option_value.toLowerCase() === capacity));
      });
      btn.style.display = isValid ? "inline-block" : "none";
      if (isValid && !btn.classList.contains(`product-detail__capacity-btn--active`) && capacity === this.selectedOptions.Capacity) {
        btn.classList.add("product-detail__capacity-btn--active");
      }
    });
  }

  updateVariantDisplay() {
    const variant = this.variants.find((v) => v.sku_id === this.selectedSkuId);
    if (!variant) {
      console.error("Không tìm thấy biến thể với sku_id:", this.selectedSkuId);
      return;
    }

    this.priceCurrent.textContent = new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(variant.price_discount);

    this.priceOriginal.textContent = variant.discount_percent
      ? new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(variant.price_original)
      : "";

    if (variant.discount_percent && Number(variant.discount_percent) > 0) {
      this.discountBadge.textContent = `-${variant.discount_percent}%`;
      this.discountBadge.style.display = "block";
    } else {
      this.discountBadge.style.display = "none";
    }

    if (this.stockDisplay) {
      this.stockDisplay.textContent = `Còn ${variant.stock_quantity} sản phẩm`;
    }

    if (this.addToCartBtn) this.addToCartBtn.setAttribute("data-sku-id", variant.sku_id);
    if (this.buyNowBtn) this.buyNowBtn.setAttribute("data-sku-id", variant.sku_id);

    let imagesForVariant = this.images[this.selectedSkuId] || {};
    if (!imagesForVariant.thumbnail_url || !imagesForVariant.gallery_urls) {
      const color = this.selectedOptions.Color;
      const fallbackVariant = this.variants.find((v) => {
        if (!v.attributes) return false;
        return v.attributes.some((attr) => attr.attribute_name === "Color" && attr.option_value.toLowerCase() === color);
      });
      if (fallbackVariant) {
        imagesForVariant = this.images[fallbackVariant.sku_id] || {};
      }
    }

    const thumbnailUrls = imagesForVariant.thumbnail_url || [];
    const galleryUrls = imagesForVariant.gallery_urls || [];

    console.log("Images for SKU", this.selectedSkuId, ":", { thumbnailUrls, galleryUrls });

    if (thumbnailUrls.length > 0 && galleryUrls.length > 0) {
      this.mainImage.src = `/img/products/gallery/${galleryUrls[0]}`;
      this.thumbnailContainer.innerHTML = "";
      thumbnailUrls.forEach((thumbnail, index) => {
        const thumbnailDiv = document.createElement("div");
        thumbnailDiv.classList.add("product-detail__thumbnail");
        if (index === 0) thumbnailDiv.classList.add("product-detail__thumbnail--active");

        const imgEl = document.createElement("img");
        imgEl.src = `/img/products/thumbnails/${thumbnail}`;
        imgEl.dataset.galleryUrl = `/img/products/gallery/${galleryUrls[index] || thumbnail}`;
        imgEl.alt = "Thumbnail";

        thumbnailDiv.appendChild(imgEl);
        this.thumbnailContainer.appendChild(thumbnailDiv);
      });
    } else {
      console.warn("Không có hình ảnh cho biến thể này:", this.selectedSkuId);
      this.mainImage.src = "/img/placeholder.jpg";
      this.thumbnailContainer.innerHTML = "";
    }
  }
}
