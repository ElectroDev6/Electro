export default class SliderHandler {
  constructor({ itemSelector, dotSelector }) {
    this.items = document.querySelectorAll(itemSelector);
    this.dots = document.querySelectorAll(dotSelector);
    this.init();
  }

  resetAnimations() {
    this.items.forEach((item) => {
      item.classList.remove("active");

      const content = item.querySelector(".slider__content");
      const title = item.querySelector(".slider__title");
      const description = item.querySelector(".slider__description");
      const price = item.querySelector(".slider__price");
      const button = item.querySelector(".slider__btn");
      const image = item.querySelector(".slider__image");

      [content, title, description, price, button, image].forEach((el) => {
        if (el) {
          el.style.transition = "none";
          el.style.opacity = "0";

          if (el === image) {
            el.style.transform = "translateX(50px)";
          } else if (el === button) {
            el.style.transform = "translateY(20px)";
          } else {
            el.style.transform = "translateX(-50px)";
          }
        }
      });
    });
  }

  activateSlide(index) {
    const item = this.items[index];
    if (!item) return;

    item.classList.add("active");

    const content = item.querySelector(".slider__content");
    const title = item.querySelector(".slider__title");
    const description = item.querySelector(".slider__description");
    const price = item.querySelector(".slider__price");
    const button = item.querySelector(".slider__btn");
    const image = item.querySelector(".slider__image");

    setTimeout(() => {
      if (image) {
        image.style.transition = "opacity 0.5s ease, transform 0.5s ease";
        image.style.opacity = "1";
        image.style.transform = "translateX(0)";
      }
    }, 0);

    setTimeout(() => {
      [content, title, description, price].forEach((el) => {
        if (el) {
          const delay = el === title ? "0.2s" : el === description ? "0.4s" : el === price ? "0.6s" : "0s";

          el.style.transition = `opacity 0.5s ease ${delay}, transform 0.5s ease ${delay}`;
          el.style.opacity = "1";
          el.style.transform = "translateX(0)";
        }
      });
    }, 200);

    setTimeout(() => {
      if (button) {
        button.style.transition = "opacity 0.5s ease 0.8s, transform 0.5s ease 0.8s";
        button.style.opacity = "1";
        button.style.transform = "translateY(0)";
      }
    }, 400);
  }

  bindDotEvents() {
    this.dots.forEach((dot) => {
      dot.addEventListener("click", () => {
        const index = +dot.dataset.index;
        this.dots.forEach((d) => d.classList.remove("active"));
        dot.classList.add("active");
        this.resetAnimations();
        this.activateSlide(index);
      });
    });
  }

  init() {
    if (!this.items.length || !this.dots.length) return;
    this.bindDotEvents();
    this.activateSlide(0); // Khởi tạo slide đầu tiên
  }
}
