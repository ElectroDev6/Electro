// scripts/clean-json5.js
const JSON5 = require("json5");
const fs = require("fs");
const path = require("path");

const rawDir = path.join(__dirname, "../database/raw");
const seedDir = path.join(__dirname, "../database/seed");

// Các tên file không có phần mở rộng
const files = ["users", "user_address", "categories", "subcategories", "brands", "products", "product_descriptions", "attributes", "attribute_options", "skus", "attribute_option_sku", "variant_images", "promotions", "cart", "cart_items", "reviews", "wishlist", "coupons", "orders", "order_items", "payments", "shipping"];

files.forEach((name) => {
  const srcPath = path.join(rawDir, `${name}.json5`);
  const destPath = path.join(seedDir, `${name}.json`);

  try {
    const rawContent = fs.readFileSync(srcPath, "utf8");
    const data = JSON5.parse(rawContent);

    fs.writeFileSync(destPath, JSON.stringify(data, null, 2));
    console.log(`✅ Đã làm sạch và lưu: ${name}.json`);
  } catch (err) {
    console.error(`❌ Lỗi khi xử lý ${name}.json5:`);
    console.error(err.message);
  }
});
