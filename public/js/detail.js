import DetailPage from "../js/pages/detail.js";
import ProductVariantManager from "../js/pages/variant.js";
import ProductDetailTabs from "../js/partials/tabs-detail.js";
import BtnBuyNow from "../js/partials/btnBuyNow.js";

document.addEventListener("DOMContentLoaded", () => {
  const { variants, images } = window.productData;
  new ProductVariantManager(variants, images);
  new ProductDetailTabs();
  new DetailPage(window.productData);
  new BtnBuyNow();
});
