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
    this.bindReplyButtonEvents();
  }

  bindTabEvents() {
    this.tabButtons.forEach((button) => {
      button.addEventListener("click", (e) => this.handleTabClick(e));
    });
  }

  handleTabClick(e) {
    const button = e.target;
    const tabId = button.getAttribute("data-tab");

    this.tabButtons.forEach((btn) => btn.classList.remove("product-detail__tab-btn--active"));
    this.tabPanels.forEach((panel) => panel.classList.remove("product-detail__tab-panel--active"));

    button.classList.add("product-detail__tab-btn--active");
    const targetPanel = document.getElementById(`${tabId}-panel`);
    if (targetPanel) {
      targetPanel.classList.add("product-detail__tab-panel--active");
    }

    this.smoothScrollToTabs();
  }

  bindReplyButtonEvents() {
    const replyButtons = document.querySelectorAll(".product-detail__reply-btn");
    replyButtons.forEach((button) => {
      button.addEventListener("click", (e) => this.handleReplyClick(e));
    });
  }

  handleReplyClick(e) {
    const button = e.target;
    const reviewId = button.getAttribute("data-review-id");
    const parentReviewInput = document.getElementById("parent-review-id");

    if (parentReviewInput) {
      parentReviewInput.value = reviewId || ""; // Gán review_id vào input hidden
    }

    // Tùy chọn: Cuộn đến form bình luận và focus vào textarea
    const commentForm = document.querySelector(".product-detail__comment-form");
    if (commentForm) {
      commentForm.scrollIntoView({ behavior: "smooth" });
      document.getElementById("comment-content").focus();
    }
  }

  bindCommentFormEvents() {
    if (this.commentForm) {
      this.commentForm.addEventListener("submit", (e) => this.handleCommentSubmit(e));
    }
  }

  handleCommentSubmit(e) {
    e.preventDefault();

    const content = document.getElementById("comment-content").value;
    const productId = this.commentForm.getAttribute("data-product-id");
    const parentReviewId = document.getElementById("parent-review-id").value;

    if (!this.validateCommentForm(content)) {
      return;
    }

    this.submitComment(productId, parentReviewId, content);
  }

  validateCommentForm(content) {
    if (!content.trim()) {
      alert("Vui lòng nhập nội dung bình luận!");
      return false;
    }
    return true;
  }

  submitComment(productId, parentReviewId, content) {
    const submitButton = this.commentForm.querySelector(".product-detail__comment-submit");
    const originalText = submitButton.textContent;

    submitButton.textContent = "Đang gửi...";
    submitButton.disabled = true;

    const payload = {
      product_id: productId,
      comment_text: content,
      parent_review_id: parentReviewId !== "" ? parseInt(parentReviewId) : null,
    };

    fetch("/comment/add", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    })
      .then((response) => {
        console.log("Server response status:", response.status);
        if (!response.ok) {
          return response.json().then((data) => {
            console.log("Server error JSON:", data);
            throw new Error(data.error || "Lỗi không xác định");
          });
        }
        return response.json();
      })
      .then((data) => {
        console.log("Server success JSON:", data);
        if (data.success) {
          this.lastInsertedReviewId = data.review_id; // Lưu review_id từ server
          this.addNewComment(data.user_name, content, parentReviewId);
          this.commentForm.reset();
          alert("Cảm ơn bạn đã để lại bình luận!");
        }
      })
      .catch((error) => {
        console.error("Client error:", error);
        alert("Lỗi: " + error.message);
      })
      .finally(() => {
        submitButton.textContent = originalText;
        submitButton.disabled = false;
      });
  }

  addNewComment(name, content, parentReviewId = null) {
    const reviewsList = document.querySelector(".product-detail__reviews-list");
    const newComment = document.createElement("div");
    newComment.className = "product-detail__review-item" + (parentReviewId ? " product-detail__reply" : "");
    newComment.style.opacity = "0";
    newComment.style.transform = "translateY(20px)";

    newComment.innerHTML = `
        <div class="product-detail__reviewer-info">
            <img src="/img/avatars/avatar.png" alt="User avatar" class="product-detail__reviewer-avatar" />
            <div class="product-detail__reviewer-details">
                <h4 class="product-detail__reviewer-name">${this.escapeHtml(name)}</h4>
                <span class="product-detail__review-date">Vừa xong</span>
            </div>
        </div>
        <div class="product-detail__review-content">
            <p>${this.escapeHtml(content)}</p>
        </div>
    `;

    if (parentReviewId) {
      // Tìm bình luận cha và thêm bình luận con vào replies
      const parentReview = document.querySelector(`.product-detail__review-item [data-review-id="${parentReviewId}"]`)?.closest(".product-detail__review-item");
      if (parentReview) {
        let repliesDiv = parentReview.querySelector(".product-detail__replies");
        if (!repliesDiv) {
          repliesDiv = document.createElement("div");
          repliesDiv.className = "product-detail__replies";
          parentReview.appendChild(repliesDiv);
        }
        repliesDiv.appendChild(newComment);
      } else {
        // Nếu không tìm thấy bình luận cha, thêm vào đầu danh sách
        reviewsList.insertBefore(newComment, reviewsList.firstChild);
      }
    } else {
      // Bình luận cha, thêm vào đầu danh sách
      reviewsList.insertBefore(newComment, reviewsList.firstChild);
    }

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
