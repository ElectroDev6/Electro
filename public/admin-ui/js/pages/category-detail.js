function toggleEditForm() {
   const formContainer = document.getElementById("edit-form-container");
   const detailCard = document.getElementById("category-detail-card");
   if (formContainer.classList.contains("active")) {
      formContainer.classList.remove("active");
      detailCard.style.display = "block";
   } else {
      formContainer.classList.add("active");
      detailCard.style.display = "none";
   }
}
function isNumberKey(evt) {
   var charCode = evt.which ? evt.which : evt.keyCode;
   if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
   }
   return true;
}
function handleNumberInput(input) {
   let value = input.value.replace(/[^0-9]/g, "");
   if (parseInt(value) < 0) {
      value = "0";
   }
   if (parseInt(value) > 999999) {
      value = "999999";
   }
   input.value = value;
}
function validateForm() {
   const name = document.getElementById("name").value.trim();
   const totalProducts = document.getElementById("total_products").value;
   const imageInput = document.getElementById("image");
   if (!name) {
      alert("Vui lòng chọn tên danh mục!");
      return false;
   }
   if (!totalProducts || totalProducts < 0) {
      alert("Số lượng sản phẩm phải là số không âm!");
      return false;
   }
   if (imageInput.files && imageInput.files[0]) {
      const file = imageInput.files[0];
      const maxSize = 2 * 1024 * 1024; // 2MB
      const allowedTypes = [
         "image/jpeg",
         "image/jpg",
         "image/png",
         "image/gif",
      ];
      if (file.size > maxSize) {
         alert("File ảnh không được vượt quá 2MB!");
         return false;
      }
      if (!allowedTypes.includes(file.type)) {
         alert("Chỉ chấp nhận file ảnh định dạng JPG, PNG, GIF!");
         return false;
      }
   }
   return true;
}
function confirmDelete(categoryId, categoryName) {
   if (
      confirm(
         `Are you sure you want to delete the category "${categoryName}"? This action cannot be undone.`
      )
   ) {
      window.location.href = `/admin/categories/delete?id=${categoryId}`;
   }
}
