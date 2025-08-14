class CartHandler {
  constructor() {
    document.addEventListener("click", (event) => this.handleQuantityClick(event));
    document.addEventListener("DOMContentLoaded", () => this.initEventListeners());
  }

  changeQuantity(btn, change) {
    const input = btn.parentElement.querySelector(".quantity-input");
    let newValue = parseInt(input.value) + change;
    if (newValue < 1) newValue = 1;
    input.value = newValue;
    btn.closest("form").submit();
  }

  handleQuantityClick(event) {
    const btn = event.target.closest(".quantity-btn-minus, .quantity-btn-plus");
    if (!btn) return;

    event.preventDefault();
    this.changeQuantity(btn, btn.classList.contains("quantity-btn-minus") ? -1 : 1);
  }

  initEventListeners() {
    const confirmButton = document.querySelector("#confirm-order-btn");
    if (confirmButton) {
      confirmButton.addEventListener("click", (e) => this.confirmOrder(e));
    }

    const checkoutForm = document.querySelector(".order-page");
    if (checkoutForm) {
      checkoutForm.addEventListener("submit", (e) => this.submitCheckout(e, checkoutForm));
    }
  }

  confirmOrder(e) {
    e.preventDefault();
    fetch("/cart/confirm", {
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.href = data.redirect;
        } else {
          alert(data.message);
          if (data.redirect) window.location.href = data.redirect;
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Đã xảy ra lỗi. Vui lòng thử lại.");
      });
  }

  submitCheckout(e, form) {
    e.preventDefault();
    fetch("/checkout/submit", {
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams(new FormData(form)),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.href = data.redirect;
        } else {
          alert(data.message);
          if (data.redirect) window.location.href = data.redirect;
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại.");
      });
  }

  updateCartCount() {
    fetch("/cart/count")
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          document.getElementById("cartCount").textContent = data.count;
        }
      })
      .catch((err) => console.error("Error updating cart count:", err));
  }
}
