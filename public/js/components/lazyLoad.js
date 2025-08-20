export default class LazyLoader {
  constructor({ imgSelector = "img.lazy", bgSelector = ".lazy-bg", iframeSelector = "iframe.lazy" } = {}) {
    this.imgs = document.querySelectorAll(imgSelector);
    this.bgs = document.querySelectorAll(bgSelector);
    this.iframes = document.querySelectorAll(iframeSelector);
    this.init();
  }

  init() {
    if (!("IntersectionObserver" in window)) {
      // Nếu trình duyệt cũ, load tất cả luôn
      this.loadAll();
      return;
    }

    const options = {
      root: null,
      rootMargin: "0px",
      threshold: 0.1,
    };

    this.observer = new IntersectionObserver(this.onIntersection.bind(this), options);

    this.imgs.forEach((img) => this.observer.observe(img));
    this.bgs.forEach((bg) => this.observer.observe(bg));
    this.iframes.forEach((iframe) => this.observer.observe(iframe));
  }

  onIntersection(entries, observer) {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;

      const el = entry.target;

      if (el.tagName === "IMG") {
        el.src = el.dataset.src;
        el.classList.remove("lazy");
      } else if (el.tagName === "IFRAME") {
        el.src = el.dataset.src;
        el.classList.remove("lazy");
      } else if (el.classList.contains("lazy-bg")) {
        el.style.backgroundImage = `url('${el.dataset.bg}')`;
        el.classList.remove("lazy-bg");
      }

      observer.unobserve(el);
    });
  }

  loadAll() {
    this.imgs.forEach((img) => {
      img.src = img.dataset.src;
      img.classList.remove("lazy");
    });
    this.bgs.forEach((bg) => {
      bg.style.backgroundImage = `url('${bg.dataset.bg}')`;
      bg.classList.remove("lazy-bg");
    });
    this.iframes.forEach((iframe) => {
      iframe.src = iframe.dataset.src;
      iframe.classList.remove("lazy");
    });
  }
}
