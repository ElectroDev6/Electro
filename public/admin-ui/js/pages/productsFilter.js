const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

class ProductFilter {
   constructor() {
      this.elements = {
         searchProduct: $("#searchProduct"),
         categorySelect: $("#categoryFilter"),
         brandSelect: $("#brandFilter"),
         filterButton: $("#filterButton"),
         resetButton: $("#resetButton"),
         productRows: $$(".products-table__row"),
      };
      this.init();
      this.setupEventListeners();
   }
   init() {
      if (
         !this.elements.searchProduct ||
         !this.elements.categorySelect ||
         !this.elements.brandSelect ||
         !this.elements.filterButton ||
         !this.elements.resetButton ||
         !this.elements.productRows.length // Check if productRows is empty
      ) {
         console.error(
            "One or more filter elements not found or no product rows available"
         );
         return;
      }
   }

   setupEventListeners() {
      if (this.elements.filterButton) {
         this.elements.filterButton.addEventListener("click", () =>
            this.filterProducts()
         );
      }
      if (this.elements.resetButton) {
         this.elements.resetButton.addEventListener("click", () =>
            this.resetFilters()
         );
      }
   }

   filterProducts() {
      if (!this.elements.productRows || !this.elements.productRows.length) {
         console.warn("No product rows to filter");
         return;
      }

      const searchTerm = (this.elements.searchProduct?.value || "")
         .toLowerCase()
         .trim();
      const selectedCategory = (
         this.elements.categorySelect?.value || ""
      ).toLowerCase();
      const selectedBrand = (
         this.elements.brandSelect?.value || ""
      ).toLowerCase();

      this.elements.productRows.forEach((row) => {
         const name = (
            row.querySelector(".product-table__name")?.textContent || ""
         ).toLowerCase();
         const category = (
            row.querySelector(".product-table__cell:nth-child(2)")
               ?.textContent || ""
         ).toLowerCase();
         const brand = (row.dataset.brand || "").toLowerCase();
         const priceText = (
            row.querySelector(".product-table__cell:nth-child(3)")
               ?.textContent || ""
         )
            .replace(/đ/g, "")
            .replace(/\./g, "");
         const price = parseFloat(priceText) || 0;

         const matchesName = !searchTerm || name.includes(searchTerm);
         const matchesCategory =
            !selectedCategory || category === selectedCategory;
         const matchesBrand = !selectedBrand || brand === selectedBrand;

         row.style.display =
            matchesName && matchesCategory && matchesBrand ? "" : "none";
      });
   }

   resetFilters() {
      if (this.elements.searchProduct) this.elements.searchProduct.value = "";
      if (this.elements.categorySelect) this.elements.categorySelect.value = "";
      if (this.elements.brandSelect) this.elements.brandSelect.value = "";
      this.filterProducts();
   }
}

document.addEventListener("DOMContentLoaded", () => {
   try {
      new ProductFilter();
   } catch (error) {
      console.error("Error initializing ProductFilter:", error);
   }
});
