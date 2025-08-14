class DetailPage {
  constructor(productData) {
    this.productData = productData;
  }

  init() {
    this.bindCommentForm();
    this.bindReplyButtons();
  }

  bindCommentForm() {
    const form = document.getElementById("comment-form");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(form);
      const data = Object.fromEntries(formData);
      data.product_id = form.dataset.productId;

      try {
        const response = await fetch("/comment/add", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        });

        const result = await response.json();
        if (result.success) {
          alert("Bình luận đã được gửi, đang chờ duyệt.");
          form.reset();
          document.getElementById("parent-review-id").value = "";
        } else {
          alert(result.error || "Có lỗi xảy ra.");
        }
      } catch (error) {
        alert("Lỗi kết nối: " + error.message);
      }
    });
  }

  bindReplyButtons() {
    document.querySelectorAll(".product-detail__reply-btn").forEach((btn) => {
      btn.addEventListener("click", () => {
        const parentReviewIdInput = document.getElementById("parent-review-id");
        const commentContent = document.getElementById("comment-content");

        if (parentReviewIdInput) {
          parentReviewIdInput.value = btn.dataset.reviewId;
        }
        if (commentContent) {
          commentContent.focus();
        }
      });
    });
  }
}
