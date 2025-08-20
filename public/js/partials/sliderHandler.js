export default class SliderHandler {
  constructor({ itemSelector, dotSelector }) {
    this.items = document.querySelectorAll(itemSelector);
    this.dots = document.querySelectorAll(dotSelector);
    this.currentIndex = 0; // lưu slide hiện tại
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
          if (el === image) el.style.transform = "translateX(50px)";
          else if (el === button) el.style.transform = "translateY(20px)";
          else el.style.transform = "translateX(-50px)";
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
        this.goToSlide(index);
      });
    });
  }

  bindTouchEvents() {
    if (!this.items.length) return;
    const container = this.items[0].parentElement;

    let startX = 0;
    let endX = 0;

    // Touch
    container.addEventListener("touchstart", (e) => {
      startX = e.touches[0].clientX;
      endX = startX;
    });
    container.addEventListener("touchmove", (e) => {
      endX = e.touches[0].clientX;
      e.preventDefault();
    });
    container.addEventListener("touchend", () => this.handleSwipe(startX, endX));

    // Mouse
    let isDown = false;
    container.addEventListener("mousedown", (e) => {
      isDown = true;
      startX = e.clientX;
      endX = startX;
    });
    container.addEventListener("mousemove", (e) => {
      if (!isDown) return;
      endX = e.clientX;
    });
    container.addEventListener("mouseup", () => {
      if (!isDown) return;
      isDown = false;
      this.handleSwipe(startX, endX);
    });
    container.addEventListener("mouseleave", () => {
      if (isDown) {
        isDown = false;
        this.handleSwipe(startX, endX);
      }
    });
  }

  handleSwipe(startX, endX) {
    const diff = startX - endX;
    if (Math.abs(diff) > 50) {
      if (diff > 0) this.nextSlide();
      else this.prevSlide();
    }
  }

  nextSlide() {
    let index = this.currentIndex + 1;
    if (index >= this.items.length) index = 0;
    this.goToSlide(index);
  }

  prevSlide() {
    let index = this.currentIndex - 1;
    if (index < 0) index = this.items.length - 1;
    this.goToSlide(index);
  }

  goToSlide(index) {
    this.currentIndex = index;
    this.resetAnimations();
    this.activateSlide(index);
    this.dots.forEach((d) => d.classList.remove("active"));
    this.dots[index].classList.add("active");
  }

  init() {
    if (!this.items.length || !this.dots.length) return;
    this.bindDotEvents();
    this.bindTouchEvents();
    this.activateSlide(0);
  }
}
