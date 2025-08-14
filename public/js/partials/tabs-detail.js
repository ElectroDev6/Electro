export default class ProductDetailTabs {
  constructor() {
    this.tabButtons = document.querySelectorAll(".product-detail__tab-btn");
    this.tabPanels = document.querySelectorAll(".product-detail__tab-panel");
    this.commentForm = document.querySelector(".product-detail__comment-form form");
    this.reviewImages = document.querySelectorAll(".product-detail__review-images img");

    this.init();
  }

  init() {
    this.bindTabEvents();
    this.bindCommentFormEvents();
    this.bindImageEvents();
  }

  bindTabEvents() {
    this.tabButtons.forEach((button) => {
      button.addEventListener("click", (e) => this.handleTabClick(e));
    });
  }

  handleTabClick(e) {
    const button = e.target;
    const tabId = button.getAttribute("data-tab");

    // Remove active classes
    this.tabButtons.forEach((btn) => btn.classList.remove("product-detail__tab-btn--active"));
    this.tabPanels.forEach((panel) => panel.classList.remove("product-detail__tab-panel--active"));

    // Add active class to clicked button
    button.classList.add("product-detail__tab-btn--active");

    // Show corresponding panel
    const targetPanel = document.getElementById(`${tabId}-panel`);
    if (targetPanel) {
      targetPanel.classList.add("product-detail__tab-panel--active");
    }

    this.smoothScrollToTabs();
  }

  bindCommentFormEvents() {
    if (this.commentForm) {
      this.commentForm.addEventListener("submit", (e) => this.handleCommentSubmit(e));
    }
  }

  handleCommentSubmit(e) {
    e.preventDefault();

    const name = document.getElementById("comment-name").value;
    const email = document.getElementById("comment-email").value;
    const content = document.getElementById("comment-content").value;

    if (!this.validateCommentForm(name, email, content)) {
      return;
    }

    this.submitComment(name, email, content);
  }

  validateCommentForm(name, email, content) {
    if (!name.trim() || !email.trim() || !content.trim()) {
      alert("Vui lòng điền đầy đủ thông tin!");
      return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Email không hợp lệ!");
      return false;
    }

    return true;
  }

  submitComment(name, email, content) {
    const submitButton = this.commentForm.querySelector(".product-detail__comment-submit");
    const originalText = submitButton.textContent;

    submitButton.textContent = "Đang gửi...";
    submitButton.disabled = true;

    setTimeout(() => {
      this.addNewComment(name, content);
      this.commentForm.reset();

      submitButton.textContent = originalText;
      submitButton.disabled = false;

      alert("Cảm ơn bạn đã để lại bình luận!");
    }, 1500);
  }

  addNewComment(name, content) {
    const reviewsList = document.querySelector(".product-detail__reviews-list");
    const newComment = document.createElement("div");
    newComment.className = "product-detail__review-item";
    newComment.style.opacity = "0";
    newComment.style.transform = "translateY(20px)";

    newComment.innerHTML = `
            <div class="product-detail__reviewer-info">
                <img src="/img/avatars/avatar.png" alt="User avatar" class="product-detail__reviewer-avatar" />
                <div class="product-detail__reviewer-details">
                    <h4 class="product-detail__reviewer-name">${this.escapeHtml(name)}</h4>
                    <div class="product-detail__review-rating">★★★★★</div>
                    <span class="product-detail__review-date">Vừa xong</span>
                </div>
            </div>
            <div class="product-detail__review-content">
                <p>${this.escapeHtml(content)}</p>
            </div>
        `;

    reviewsList.insertBefore(newComment, reviewsList.firstChild);

    setTimeout(() => {
      newComment.style.transition = "all 0.3s ease";
      newComment.style.opacity = "1";
      newComment.style.transform = "translateY(0)";
    }, 100);
  }

  bindImageEvents() {
    this.reviewImages.forEach((img) => {
      img.addEventListener("click", (e) => this.showImageModal(e.target.src));
      img.style.cursor = "pointer";
    });
  }

  showImageModal(imageSrc) {
    const existingModal = document.querySelector(".image-modal");
    if (existingModal) {
      existingModal.remove();
    }

    const modal = this.createImageModal(imageSrc);
    document.body.appendChild(modal);

    this.bindModalEvents(modal);
  }

  createImageModal(imageSrc) {
    const modal = document.createElement("div");
    modal.className = "image-modal";
    modal.innerHTML = `
            <div class="image-modal__overlay">
                <div class="image-modal__content">
                    <img src="${imageSrc}" alt="Enlarged image" />
                    <button class="image-modal__close">&times;</button>
                </div>
            </div>
        `;

    this.addModalStyles();
    return modal;
  }

  addModalStyles() {
    if (!document.querySelector("#modal-styles")) {
      const modalStyles = `
                .image-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.8);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 1000;
                }
                
                .image-modal__content {
                    position: relative;
                    max-width: 90%;
                    max-height: 90%;
                }
                
                .image-modal__content img {
                    max-width: 100%;
                    max-height: 100%;
                    border-radius: 8px;
                }
                
                .image-modal__close {
                    position: absolute;
                    top: -10px;
                    right: -10px;
                    background: white;
                    border: none;
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    font-size: 18px;
                    cursor: pointer;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
                }
            `;

      const styleSheet = document.createElement("style");
      styleSheet.id = "modal-styles";
      styleSheet.textContent = modalStyles;
      document.head.appendChild(styleSheet);
    }
  }

  bindModalEvents(modal) {
    modal.addEventListener("click", (e) => {
      if (e.target === modal || e.target.classList.contains("image-modal__overlay")) {
        modal.remove();
      }
    });

    modal.querySelector(".image-modal__close").addEventListener("click", () => {
      modal.remove();
    });

    const closeModalWithEscape = (e) => {
      if (e.key === "Escape") {
        modal.remove();
        document.removeEventListener("keydown", closeModalWithEscape);
      }
    };

    document.addEventListener("keydown", closeModalWithEscape);
  }

  smoothScrollToTabs() {
    const tabsSection = document.querySelector(".product-detail__tabs-section");
    if (tabsSection) {
      tabsSection.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  }

  escapeHtml(text) {
    const map = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#039;",
    };

    return text.replace(/[&<>"']/g, (m) => map[m]);
  }
}
