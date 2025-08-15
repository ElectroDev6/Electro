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
    const res = await fetch(`${this.apiUrl}?q=${encodeURIComponent(query)}`);
    const data = await res.json();
    this.renderSuggestions(data);
  }

  renderSuggestions(items) {
    this.suggestionBox.innerHTML = items.map((item) => `<div class="suggestion-item" style="padding:8px;cursor:pointer">${item.name}</div>`).join("");
    this.addClickEvents();
  }

  addClickEvents() {
    this.suggestionBox.querySelectorAll(".suggestion-item").forEach((el) => {
      el.addEventListener("click", () => {
        this.input.value = el.textContent;
        this.suggestionBox.innerHTML = "";
      });
    });
  }
}
