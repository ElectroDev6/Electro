import ScrollToTop from "./components/scrollBtn.js";
import SearchSuggestion from "./components/searchSuggestion.js";

document.addEventListener("DOMContentLoaded", () => {
  new ScrollToTop("scrollToTopBtn");
  new SearchSuggestion("header__input", "/search/suggestions");

  const headerTop = document.querySelector(".header__top");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
      headerTop.classList.add("is-hidden");
    } else {
      headerTop.classList.remove("is-hidden");
    }
  });
});
