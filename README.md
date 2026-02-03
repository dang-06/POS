# Hệ Thống POS Laravel

Hệ thống bán hàng (POS) hiện đại được xây dựng bằng Laravel cho các doanh nghiệp bán lẻ và nhà hàng.

## 🚀 Tính Năng

- 📊 **Bảng Điều Khiển** - Tổng quan và phân tích doanh số
- 📦 **Quản Lý Sản Phẩm** - Thêm, sửa và quản lý sản phẩm theo danh mục
- 🛒 **Giao Diện POS** - Thanh toán nhanh với quét mã vạch
- 📦 **Quản Lý Đơn Hàng** - Theo dõi và quản lý đơn bán hàng
- 👥 **Quản Lý Khách Hàng** - Duy trì cơ sở dữ liệu khách hàng
- 🚚 **Nhà Cung Cấp & Mua Hàng** - Xử lý nhà cung cấp và đơn mua hàng
- ⚙️ **Cài Đặt** - Cấu hình thông tin cửa hàng và tiền tệ

## 📋 Yêu Cầu Hệ Thống

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL

## 🛠️ Hướng Dẫn Cài Đặt

### 1. Sao Chép Dự Án

```bash
git clone https://github.com/dang-06/POS.git
cd POS
```

### 2. Cài Đặt Thư Viện

```bash
composer install
npm install
```

### 3. Thiết Lập Môi Trường

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Cấu Hình Cơ Sở Dữ Liệu

Chỉnh sửa file `.env` và thiết lập thông tin cơ sở dữ liệu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tên_cơ_sở_dữ_liệu
DB_USERNAME=tên_người_dùng
DB_PASSWORD=mật_khẩu
```

### 5. Chạy Migration & Seed Database

```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets

```bash
npm run build
# hoặc cho môi trường phát triển
npm run dev
```

### 7. Tạo Storage Link

```bash
php artisan storage:link
```

### 8. Khởi Chạy Server

```bash
php artisan serve
```

Truy cập `http://localhost:8000` trên trình duyệt.

## 🔑 Tài Khoản Mặc Định

- **Email:** admin@gmail.com
- **Mật khẩu:** admin123

## 👨‍💻 Tác Giả

Được tạo bởi [dang-06](https://github.com/dang-06)

## 🤝 Đóng Góp

Mọi đóng góp, báo lỗi và yêu cầu tính năng đều được chào đón!

## ⭐ Ủng Hộ Dự Án

Hãy cho một ⭐️ nếu dự án này hữu ích với bạn!