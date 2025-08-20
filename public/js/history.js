document.addEventListener("DOMContentLoaded", () => {
  const menuItems = document.querySelectorAll(".profile__menu li");
  console.log(menuItems);

  menuItems.forEach((item) => {
    item.addEventListener("click", () => {
      menuItems.forEach((i) => i.classList.remove("active"));
      item.classList.add("active");
    });
  });
});
