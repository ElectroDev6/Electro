function changeQuantity(btn, change) {
  const input = btn.parentElement.querySelector(".quantity-input");
  let newValue = parseInt(input.value) + change;
  if (newValue < 1) newValue = 1;
  input.value = newValue;

  // Gửi form tự động
  btn.closest("form").submit();
}

document.addEventListener("click", (event) => {
  const btn = event.target.closest(".quantity-btn-minus, .quantity-btn-plus");
  if (!btn) return;

  event.preventDefault();
  changeQuantity(btn, btn.classList.contains("quantity-btn-minus") ? -1 : 1);
});
