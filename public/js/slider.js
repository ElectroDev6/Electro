document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".slider__item");
  const dots = document.querySelectorAll(".slider__dot");

  function resetAnimations() {
    items.forEach((item) => {
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

  function activateSlide(index) {
    const item = items[index];
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
          el.style.transition = `opacity 0.5s ease ${el === title ? "0.2s" : el === description ? "0.4s" : "0.6s"}, transform 0.5s ease ${el === title ? "0.2s" : el === description ? "0.4s" : "0.6s"}`;
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

  dots.forEach((dot) => {
    dot.addEventListener("click", () => {
      const index = +dot.dataset.index;

      dots.forEach((dot) => dot.classList.remove("active"));
      dot.classList.add("active");

      resetAnimations();
      activateSlide(index);
    });
  });

  // Initialize the first slide
  activateSlide(0);
});
