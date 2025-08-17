export default class BtnBuyNow {
  constructor() {
    this.cartCountSelector = ".header__count";
    this.init();
  }

  init() {
    // Gắn sự kiện click cho tất cả nút "Mua ngay"
    document.querySelectorAll(".button-buy-now").forEach((btn) => {
      btn.addEventListener("click", () => {
        const productId = btn.dataset.productId;
        this.add(productId);
      });
    });
  }

  async add(productId) {
    console.log("Adding to cart from home - Product ID:", productId);

    try {
      const response = await fetch("/detail/add-to-cart", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify({
          product_id: productId,
          quantity: 1,
          warranty_enabled: false,
        }),
      });

      const data = await response.json();
      if (data.success) {
        alert(data.message || "Đã thêm sản phẩm vào giỏ hàng!");
        await this.updateCount();

        window.location.href = "/cart";
      } else {
        alert(data.message || "Đã xảy ra lỗi khi thêm vào giỏ hàng.");
      }
    } catch (error) {
      console.error("Add to cart error:", error);
      alert("Đã xảy ra lỗi khi thêm vào giỏ hàng.");
    }
  }

  async updateCount() {
    try {
      const response = await fetch("/cart/item-count", {
        method: "GET",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      });

      const data = await response.json();
      if (data.success) {
        const countElement = document.querySelector(this.cartCountSelector);
        if (countElement) {
          countElement.textContent = data.count;
        }
      }
    } catch (error) {
      console.error("Error fetching cart count:", error);
    }
  }
}
