export default class SearchSuggestion {
  constructor(inputId, apiUrl) {
    this.input = document.getElementById(inputId);
    this.apiUrl = apiUrl;
    if (!this.input) return;
    this.init();
  }

  init() {
    this.createSuggestionBox();
    this.input.addEventListener("input", () => this.onInputChange());
    // Enter: nếu có gợi ý, ưu tiên item đầu
    this.input.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        const first = this.suggestionBox.querySelector(".suggestion-item");
        if (first) {
          window.location.href = first.dataset.url;
          e.preventDefault();
        }
      }
    });
  }

  createSuggestionBox() {
    this.suggestionBox = document.createElement("div");
    this.suggestionBox.className = "suggestion-box";
    this.input.parentNode.style.position = "relative";
    Object.assign(this.suggestionBox.style, {
      position: "absolute",
      top: this.input.offsetHeight + "px",
      left: "0",
      width: "100%",
      background: "#fff",
      border: "1px solid #ddd",
      zIndex: "1000",
    });
    this.input.parentNode.appendChild(this.suggestionBox);
  }

  async onInputChange() {
    const query = this.input.value.trim();
    if (query.length < 2) {
      this.suggestionBox.innerHTML = "";
      return;
    }

    try {
      const res = await fetch(`${this.apiUrl}?q=${encodeURIComponent(query)}`);

      // Log status và content-type để kiểm tra
      console.log("Status:", res.status);
      console.log("Content-Type:", res.headers.get("content-type"));

      const text = await res.text(); // đọc dạng text
      console.log("Raw response:", text); // log toàn bộ response

      let data;
      try {
        data = JSON.parse(text); // parse thủ công để bắt lỗi JSON
      } catch (err) {
        console.error("JSON parse error:", err);
        return;
      }

      this.renderSuggestions(data);
    } catch (err) {
      console.error("Fetch error:", err);
    }
  }

  renderSuggestions(items) {
    this.suggestionBox.innerHTML = items
      .map((item) => {
        // Giữ tương thích cũ: nếu BE chưa trả url → fallback theo type
        const url = item.url || (item.type === "product" ? `detail/${item.slug}` : item.type === "subcategory" ? `/products/${item.category_slug}/${item.slug}` : item.type === "category" ? `/products/${item.slug}` : "#");

        const badge = item.type === "product" ? "Sản phẩm" : item.type === "subcategory" ? "Dòng/Loại" : item.type === "category" ? "Danh mục" : "";

        return `
        <div class="suggestion-item" data-url="${url}" style="padding:8px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee">
          <span>${item.name}</span>
          <small style="opacity:.6">${badge}</small>
        </div>`;
      })
      .join("");

    this.addClickEvents();
  }

  addClickEvents() {
    this.suggestionBox.querySelectorAll(".suggestion-item").forEach((el) => {
      el.addEventListener("click", () => {
        const url = el.dataset.url;
        if (url && url !== "#") window.location.href = url;
      });
    });
  }
}
