document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("menu-toggle");
  const menu = document.querySelector(".category-menu");
  const submenuItems = document.querySelectorAll(".category-menu__item--has-submenu");
  const overlay = document.querySelector(".overlay");

  function showOverlay() {
    overlay.classList.add("active");
  }

  function hideOverlay() {
    overlay.classList.remove("active");
  }

  toggleBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    menu.classList.toggle("active");

    if (menu.classList.contains("active")) {
      showOverlay();
    } else {
      hideOverlay();
      submenuItems.forEach((item) => {
        item.classList.remove("active");
      });
    }
  });

  submenuItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.stopPropagation();
      submenuItems.forEach((otherItem) => {
        if (otherItem !== this && otherItem.classList.contains("active")) {
          otherItem.classList.remove("active");
        }
      });
      this.classList.toggle("active");

      if (menu.classList.contains("active")) {
        showOverlay();
      } else if (item.classList.contains("active")) {
        showOverlay();
      } else {
        let anySubmenuActive = Array.from(submenuItems).some((sItem) => sItem.classList.contains("active"));
        if (!anySubmenuActive) {
          hideOverlay();
        }
      }
    });
  });

  document.addEventListener("click", function (e) {
    const target = e.target;

    if (!menu.contains(target) && !toggleBtn.contains(target)) {
      if (menu.classList.contains("active")) {
        menu.classList.remove("active");
        hideOverlay();
      }
      submenuItems.forEach((item) => {
        item.classList.remove("active");
      });
    }

    let clickedOutsideSubmenuItem = true;
    submenuItems.forEach((item) => {
      if (item.contains(target)) {
        clickedOutsideSubmenuItem = false;
      } else if (item.classList.contains("active")) {
        item.classList.remove("active");
      }
    });

    if (!menu.classList.contains("active") && !Array.from(submenuItems).some((item) => item.classList.contains("active"))) {
      hideOverlay();
    }
  });

  overlay.addEventListener("click", function () {
    if (menu.classList.contains("active")) {
      menu.classList.remove("active");
    }
    submenuItems.forEach((item) => {
      item.classList.remove("active");
    });
    hideOverlay();
  });
});
