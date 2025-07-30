export default class SearchHandler {
  constructor({ toggleBtnSelector, dropdownSelector }) {
    this.toggleBtn = document.querySelector(toggleBtnSelector);
    this.dropdown = document.querySelector(dropdownSelector);

    if (this.toggleBtn && this.dropdown) {
      this.initEvents();
    }
  }

  initEvents() {
    this.toggleBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      this.dropdown.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
      if (!this.dropdown.contains(e.target) && !this.toggleBtn.contains(e.target)) {
        this.dropdown.classList.remove("active");
      }
    });

    this.dropdown.addEventListener("click", (e) => {
      e.stopPropagation();
    });
  }
}
