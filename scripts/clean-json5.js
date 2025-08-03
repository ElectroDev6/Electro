// scripts/clean-json5.js
const JSON5 = require("json5");
const fs = require("fs");
const path = require("path");

const rawDir = path.join(__dirname, "../database/raw");
const seedDir = path.join(__dirname, "../database/seed");

// Các tên file không có phần mở rộng
const files = ["brands", "categories", "products", "product_descriptions", "product_options", "product_option_values", "product_variants", "product_variant_values", "variant_images"];

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
