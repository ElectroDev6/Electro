import MenuHandler from "../js/components/menuHandler.js";
import SearchHandler from "../js/components/menuMobileHandler.js";
import ScrollHandler from "../js/components/scrollHandler.js";
import SliderHandler from "../js/partials/sliderHandler.js";
import BtnBuyNow from "../js/partials/btnBuyNow.js";
import SaleCountdown from "../js/partials/countDown.js";
import Countdown from "../js/partials/countDowtTest.js";

document.addEventListener("DOMContentLoaded", () => {
  new MenuHandler({
    toggleBtnSelector: "#menu-toggle",
    menuSelector: ".category-menu",
    submenuItemSelector: ".category-menu__item--has-submenu",
    overlaySelector: ".overlay",
  });

  new SearchHandler({
    toggleBtnSelector: ".header__search-mobile-toggle",
    dropdownSelector: ".header__search-dropdown",
  });

  new ScrollHandler({
    btnSelector: ".arrow-btn",
    containerSelector: ".scroll-horizontal",
    scrollAmount: 300,
  });

  new SliderHandler({
    itemSelector: ".slider__item",
    dotSelector: ".slider__dot",
  });

  new BtnBuyNow();
  new SaleCountdown();

  const productEl = document.querySelector(".product-featured");
  if (productEl) {
    new Countdown(productEl);
  }
});
