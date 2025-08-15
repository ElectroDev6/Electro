export default class ScrollToTop {
  constructor(buttonId) {
    this.button = document.getElementById(buttonId);

    if (!this.button) {
      console.error(`Button with id "${buttonId}" not found.`);
      return;
    }

    this.handleScroll = this.handleScroll.bind(this);
    this.scrollToTop = this.scrollToTop.bind(this);

    this.init();
  }

  init() {
    window.addEventListener("scroll", this.handleScroll);
    this.button.addEventListener("click", this.scrollToTop);
  }

  handleScroll() {
    if (window.scrollY > 200) {
      this.button.classList.add("show");
    } else {
      this.button.classList.remove("show");
    }
  }

  scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  }
}
