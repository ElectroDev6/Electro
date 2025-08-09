export default class ScrollHandler {
  constructor({ btnSelector, containerSelector, scrollAmount }) {
    this.btnSelector = btnSelector;
    this.containerSelector = containerSelector;
    this.scrollAmount = scrollAmount;
    this.init();
  }

  init() {
    const buttons = document.querySelectorAll(this.btnSelector);

    buttons.forEach((btn) => {
      const isRight = btn.classList.contains("arrow-btn--right");
      const container = btn.closest(".category-product").querySelector(this.containerSelector);

      btn.addEventListener("click", () => {
        if (container) {
          container.scrollBy({
            left: isRight ? this.scrollAmount : -this.scrollAmount,
            behavior: "smooth",
          });
        }
      });
    });
  }
}
