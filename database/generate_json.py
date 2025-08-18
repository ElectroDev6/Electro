import pandas as pd
import json
import os

# Đường dẫn thư mục
base_dir = os.path.dirname(os.path.abspath(__file__)).replace("\\database", "")
raw_dir = os.path.join(base_dir, "database", "raw")
seed_dir = os.path.join(base_dir, "database", "seed")
os.makedirs(seed_dir, exist_ok=True)

# Kiểm tra thư mục raw
if not os.path.exists(raw_dir):
    print(f"❌ Thư mục {raw_dir} không tồn tại.")
    exit(1)

# Hàm xử lý bảng không phân cấp
def process_flat_table(table, csv_file, columns):
    try:
        df = pd.read_csv(os.path.join(raw_dir, csv_file), quotechar='"', keep_default_na=False)
        df = df[columns]
        data = df.to_dict('records')
        for row in data:
            for col in row:
                if pd.isna(row[col]):
                    row[col] = None
                elif row[col] == 'TRUE' or row[col] == '1':
                    row[col] = True
                elif row[col] == 'FALSE' or row[col] == '0':
                    row[col] = False
        with open(os.path.join(seed_dir, f"{table}.json"), 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
        print(f"✅ Đã sinh file {table}.json")
    except FileNotFoundError:
        print(f"❌ File '{csv_file}' không tìm thấy trong {raw_dir}.")
        exit(1)
    except Exception as e:
        print(f"❌ Lỗi khi xử lý {csv_file}: {str(e)}")
        exit(1)

# Hàm xử lý bảng phân cấp
def process_nested_table(table, csv_file, nested_field, nested_columns):
    try:
        df = pd.read_csv(os.path.join(raw_dir, csv_file), quotechar='"', keep_default_na=False)
        data = []
        skus_path = os.path.join(seed_dir, "skus.json")
        available_skus = set()
        if os.path.exists(skus_path):
            with open(skus_path, 'r', encoding='utf-8') as f:
                skus_data = json.load(f)
                for item in skus_data:
                    for sku in item.get('skus', []):
                        available_skus.add(sku['sku_code'])

        for product_id, group in df.groupby('product_id'):  # Nhóm theo product_id
            record = {'product_id': int(product_id)}  # product_id từ groupby là số
            items = []
            for _, row in group.iterrows():
                item = {col: row[col] for col in nested_columns if col in row}
                if table == 'skus':
                    # Sử dụng sku_code trực tiếp từ skus.csv
                    sku_item = {
                        'sku_code': row['sku_code'],
                        'product_id': int(row['product_id']),  # Lấy từ cột product_id
                        'price': float(row['price']) if 'price' in row and pd.notna(row['price']) else None,
                        'stock_quantity': int(row['stock_quantity']) if 'stock_quantity' in row and pd.notna(row['stock_quantity']) else 0,
                        'is_default': int(row['is_default']) if 'is_default' in row and pd.notna(row['is_default']) else False,
                        'is_active': int(row['is_active']) if 'is_active' in row and pd.notna(row['is_active']) else False
                    }
                    items.append(sku_item)
                elif table == 'variant_images':
                    # Tạo sku_code từ sku_code_prefix, capacity, và color
                    sku_code = f"{row['sku_code_prefix'].strip()}-{row['capacity'].strip()}-{row['color'].strip().upper()}"
                    if sku_code.upper() in {sku.upper() for sku in available_skus}:
                        # Tạo image_set đầy đủ với image_index
                        base_image_set = row['image_set']
                        image_index = row['image_index'] if pd.notna(row['image_index']) else ''
                        image_set = f"{base_image_set}-{image_index}.webp" if image_index else f"{base_image_set}.webp"
                        image_item = {
                            'sku_code': sku_code,
                            'image_set': image_set,
                            'is_default': int(row['is_default']) if pd.notna(row['is_default']) else False,
                            'sort_order': int(row['sort_order'])
                        }
                        items.append(image_item)
            record[nested_field] = items
            data.append(record)
        with open(os.path.join(seed_dir, f"{table}.json"), 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
        print(f"✅ Đã sinh file {table}.json")
    except FileNotFoundError:
        print(f"❌ File '{csv_file}' không tìm thấy trong {raw_dir}.")
        exit(1)
    except Exception as e:
        print(f"❌ Lỗi khi xử lý {csv_file}: {str(e)}")
        exit(1)

# Hàm xử lý attribute_option_sku
def process_attribute_option_sku():
    try:
        skus_df = pd.read_csv(os.path.join(raw_dir, 'skus.csv'))
        attribute_options_df = pd.read_csv(os.path.join(raw_dir, 'attribute_options.csv'))
        attribute_options_map = {row['value'].lower(): int(row['attribute_option_id']) for _, row in attribute_options_df.iterrows()}
        
        attribute_options_data = []
        for product_id, group in skus_df.groupby('product_id'):
            attribute_options = []
            for _, row in group.iterrows():
                parts = row['sku_code'].split('-')
                if len(parts) >= 3:
                    model = parts[0]
                    capacity = parts[1].lower()
                    color = parts[2].lower()
                    if not capacity.endswith('gb') and capacity.isdigit():
                        capacity += 'gb'
                    for attr_value in [color, capacity]:
                        attribute_option_id = attribute_options_map.get(attr_value, None)
                        if attribute_option_id is not None:
                            option = {
                                'sku_code': row['sku_code'],
                                'attribute_option_id': attribute_option_id
                            }
                            attribute_options.append(option)
            attribute_options_data.append({
                'product_id': int(product_id),
                'attribute_options': [opt for opt in attribute_options if opt.get('attribute_option_id') is not None]
            })
        with open(os.path.join(seed_dir, "attribute_option_sku.json"), 'w', encoding='utf-8') as f:
            json.dump(attribute_options_data, f, indent=2, ensure_ascii=False)
        print("✅ Đã sinh file attribute_option_sku.json")
    except FileNotFoundError as e:
        print(f"❌ File không tìm thấy: {str(e)}")
        exit(1)
    except Exception as e:
        print(f"❌ Lỗi khi xử lý attribute_option_sku: {str(e)}")
        exit(1)

# Xử lý bảng không phân cấp
process_flat_table('categories', 'categories.csv', ['name', 'image', 'description', 'slug'])
process_flat_table('subcategories', 'subcategories.csv', ['subcategory_id','category_id', 'name', 'subcategory_slug'])
process_flat_table('brands', 'brands.csv', ['name', 'description', 'logo_url'])
process_flat_table('products', 'products.csv', ['name', 'brand_id', 'subcategory_id', 'slug', 'is_featured'])
process_flat_table('product_contents', 'product_contents.csv', ['product_id', 'description', 'image_url'])
process_flat_table('product_specs', 'product_specs.csv', ['product_id', 'spec_name', 'spec_value', 'display_order'])
process_flat_table('attributes', 'attributes.csv', ['name', 'display_type'])
process_flat_table('attribute_options', 'attribute_options.csv', ['attribute_id', 'value', 'display_order'])
process_flat_table('promotions', 'promotions.csv', ['sku_code', 'discount_percent', 'start_date', 'end_date'])
process_flat_table('users', 'users.csv', ['name', 'email', 'password_hash', 'phone_number', 'gender', 'birth_date', 'role', 'is_active', 'avatar_url'])
process_flat_table('user_address', 'user_address.csv', ['user_id', 'address', 'ward_commune', 'district', 'province_city'])
process_flat_table('cart', 'cart.csv', ['user_id', 'session_id'])
process_flat_table('cart_items', 'cart_items.csv', ['cart_id', 'sku_id', 'quantity', 'selected', 'color', 'warranty_enabled', 'voucher_code'])
process_flat_table('reviews', 'reviews.csv', ['user_id', 'product_id', 'parent_review_id', 'rating', 'comment_text','status'])
process_flat_table('wishlist', 'wishlist.csv', ['user_id', 'product_id', 'added_at'])
process_flat_table('coupons', 'coupons.csv', ['code', 'discount_percent', 'start_date', 'expires_at', 'max_usage', 'is_active'])
process_flat_table('orders', 'orders.csv', ['user_id', 'user_address_id', 'coupon_id', 'status', 'total_price'])
process_flat_table('order_items', 'order_items.csv', ['order_id', 'sku_id', 'quantity', 'price'])
process_flat_table('payments', 'payments.csv', ['order_id', 'payment_method', 'amount', 'payment_date', 'status'])
process_flat_table('shipping', 'shipping.csv', ['order_id', 'carrier', 'tracking_number', 'estimated_delivery', 'status'])

# Xử lý bảng phân cấp
process_nested_table('skus', 'skus.csv', 'skus', ['sku_code', 'product_id', 'price', 'stock_quantity', 'is_default', 'is_active'])
process_nested_table('variant_images', 'images.csv', 'images', ['product_id', 'name', 'sku_code_prefix', 'capacity', 'color', 'image_set', 'image_index', 'is_default', 'sort_order'])

# Xử lý attribute_option_sku
process_attribute_option_sku()