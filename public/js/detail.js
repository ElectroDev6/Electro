import ProductVariantManager from "../js/pages/variant.js";
import ProductDetailTabs from "../js/pages/tabs-detail.js";

document.addEventListener("DOMContentLoaded", () => {
  const { variants, images } = window.productData;
  new ProductVariantManager(variants, images);
  new ProductDetailTabs();
});
