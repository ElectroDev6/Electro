## 🚀 Hướng dẫn Cài đặt & Khởi chạy (Setup Guide)

Làm theo các bước sau để khởi chạy dự án trên môi trường Local của bạn:

### 1. Chuẩn bị Môi trường

Đảm bảo bạn đã cài đặt:
* **PHP** (phiên bản 7.4 trở lên).
* **MySQL** hoặc MariaDB.
* **Composer** (Quản lý thư viện PHP).
* **Node.js** và **npm** (để quản lý Frontend Assets).

### 2. Tải về và Cài đặt Dependencies

1.  **Clone Repository:**
    ```bash
    git clone [https://github.com/ElectroDev6/Electro.git](https://github.com/ElectroDev6/Electro.git)
    cd Electro
    ```
2.  **Cài đặt Dependencies Frontend:**
    ```bash
    npm install
    ```
3.  **Cài đặt Dependencies Backend (Vendor):**
    ```bash
    composer install
    ```

### 3. Cấu hình Database

1.  **Tạo file `.env`:** Copy file cấu hình mẫu và đổi tên thành `.env` trong thư mục `config`.
    ```bash
    cp config/.env.example config/.env
    ```
2.  **Chỉnh sửa file `config/.env`:** Cập nhật thông tin kết nối Database của bạn.

    ```dotenv
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=electro_db # Đặt tên DB mà bạn muốn tạo
    DB_USERNAME=root
    DB_PASSWORD=@Khanhduy23803 # Thay bằng mật khẩu MySQL của bạn
    ```
3.  **Khởi tạo Database và Data Mẫu (Seeding):**
    Sử dụng công cụ CLI tự cấu hình để chạy các file migration và seeder.

    ```bash
    # Di chuyển vào thư mục database
    cd database
    # Chạy script để tạo database và insert data mẫu
    php db-cli.php
    # Trở lại thư mục gốc
    cd ..
    ```

### 4. Khởi động Dự án

1.  **Chạy Frontend Tooling:** Khởi động quá trình biên dịch SASS và theo dõi thay đổi.
    ```bash
    npm run dev
    ```
2.  **Khởi động Server:** Sử dụng server Localhost (Apache, Nginx, hoặc PHP built-in server) và cấu hình **Document Root** trỏ tới thư mục **`/public`**.

    * **Nếu dùng PHP built-in server (Chỉ nên dùng cho mục đích test):**
        ```bash
        php -S localhost:8080 -t public
        ```

Truy cập: `http://localhost:8080` (hoặc cổng/đường dẫn đã cấu hình) để xem kết quả.
