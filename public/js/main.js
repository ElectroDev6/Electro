import ScrollToTop from "./components/scrollBtn.js";
import SearchSuggestion from "./components/searchSuggestion.js";

document.addEventListener("DOMContentLoaded", () => {
  new ScrollToTop("scrollToTopBtn");
  new SearchSuggestion("header__input", "/search/suggestions");
});
