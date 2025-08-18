// Avatar preview functionality
const avatarInput = document.getElementById("avatar_url");
const avatarPreview = document.getElementById("avatarPreview");
const avatarImage = document.getElementById("avatarImage");
const removeButton = document.getElementById("removeAvatar");
const fileName = document.querySelector(".file-group__name");

avatarInput.addEventListener("change", function (e) {
   const file = e.target.files[0];
   if (file) {
      if (file.size > 5 * 1024 * 1024) {
         alert("Kích thước file không được vượt quá 5MB");
         e.target.value = "";
         return;
      }
      if (!file.type.startsWith("image/")) {
         alert("Vui lòng chọn file ảnh hợp lệ");
         e.target.value = "";
         return;
      }
      const reader = new FileReader();
      reader.onload = function (event) {
         avatarImage.src = event.target.result;
         avatarPreview.classList.add("show");
         fileName.textContent = file.name;
      };
      reader.readAsDataURL(file);
   }
});

removeButton.addEventListener("click", function () {
   avatarInput.value = "";
   avatarPreview.classList.remove("show");
   fileName.textContent = "";
   avatarImage.src = "";
});

const dropZone = document.querySelector(".file-group__label");
dropZone.addEventListener("dragover", function (e) {
   e.preventDefault();
   dropZone.style.borderColor = "#3b82f6";
   dropZone.style.backgroundColor = "#eff6ff";
});
dropZone.addEventListener("dragleave", function (e) {
   e.preventDefault();
   dropZone.style.borderColor = "#cbd5e1";
   dropZone.style.backgroundColor = "#f8fafc";
});
dropZone.addEventListener("drop", function (e) {
   e.preventDefault();
   dropZone.style.borderColor = "#cbd5e1";
   dropZone.style.backgroundColor = "#f8fafc";
   const files = e.dataTransfer.files;
   if (files.length > 0) {
      avatarInput.files = files;
      avatarInput.dispatchEvent(new Event("change"));
   }
});

const selectElements = document.querySelectorAll(".select-group__field");
selectElements.forEach((select) => {
   select.addEventListener("change", function () {
      if (this.value !== "") {
         this.classList.add("has-value");
      } else {
         this.classList.remove("has-value");
      }
   });
   if (select.value !== "") {
      select.classList.add("has-value");
   }
});

const inputElements = document.querySelectorAll(".input-group__field");
inputElements.forEach((input) => {
   if (!input.classList.contains("input-group__field--date-top")) {
      input.addEventListener("input", function () {
         if (this.value.trim() !== "") {
            this.classList.add("has-value");
         } else {
            this.classList.remove("has-value");
         }
      });
      if (input.value.trim() !== "") {
         input.classList.add("has-value");
      }
   }
});

// Restrict phone number input to numbers only
const phoneInput = document.getElementById("phone_number");
phoneInput.addEventListener("input", function (e) {
   this.value = this.value.replace(/[^0-9]/g, "");
   if (this.value.length > 11) {
      this.value = this.value.slice(0, 11);
   }
});
