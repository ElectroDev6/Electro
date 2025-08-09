export default class MenuHandler {
  constructor({ toggleBtnSelector, menuSelector, submenuItemSelector, overlaySelector }) {
    this.toggleBtn = document.querySelector(toggleBtnSelector);
    this.menu = document.querySelector(menuSelector);
    this.submenuItems = document.querySelectorAll(submenuItemSelector);
    this.overlay = document.querySelector(overlaySelector);

    if (this.toggleBtn && this.menu && this.overlay) {
      this.initEvents();
    }
  }

  isMobileView() {
    return window.innerWidth <= 1230;
  }

  showOverlay() {
    this.overlay.classList.add("active");
  }

  hideOverlay() {
    this.overlay.classList.remove("active");
  }

  toggleMenu() {
    if (!this.isMobileView()) return;

    this.menu.classList.toggle("active");
    if (this.menu.classList.contains("active")) {
      this.showOverlay();
    } else {
      this.hideOverlay();
      this.submenuItems.forEach((item) => item.classList.remove("active"));
    }
  }

  toggleSubmenu(clickedItem) {
    if (!this.isMobileView()) return;

    this.submenuItems.forEach((item) => {
      if (item !== clickedItem && item.classList.contains("active")) {
        item.classList.remove("active");
      }
    });

    clickedItem.classList.toggle("active");

    const anySubmenuActive = Array.from(this.submenuItems).some((item) => item.classList.contains("active"));
    if (this.menu.classList.contains("active") || anySubmenuActive) {
      this.showOverlay();
    } else {
      this.hideOverlay();
    }
  }

  handleDocumentClick(e) {
    if (!this.isMobileView()) return;

    const target = e.target;

    if (!this.menu.contains(target) && !this.toggleBtn.contains(target)) {
      this.menu.classList.remove("active");
      this.submenuItems.forEach((item) => item.classList.remove("active"));
      this.hideOverlay();
    } else {
      this.submenuItems.forEach((item) => {
        if (!item.contains(target) && item.classList.contains("active")) {
          item.classList.remove("active");
        }
      });
    }

    const anyActive = this.menu.classList.contains("active") || Array.from(this.submenuItems).some((item) => item.classList.contains("active"));

    if (!anyActive) this.hideOverlay();
  }

  initEvents() {
    this.toggleBtn.addEventListener("click", (e) => {
      if (!this.isMobileView()) return;
      e.stopPropagation();
      this.toggleMenu();
    });

    this.submenuItems.forEach((item) => {
      item.addEventListener("click", (e) => {
        if (!this.isMobileView()) return;
        e.stopPropagation();
        this.toggleSubmenu(item);
      });
    });

    document.addEventListener("click", this.handleDocumentClick.bind(this));

    this.overlay.addEventListener("click", () => {
      if (!this.isMobileView()) return;
      this.menu.classList.remove("active");
      this.submenuItems.forEach((item) => item.classList.remove("active"));
      this.hideOverlay();
    });
  }
}
