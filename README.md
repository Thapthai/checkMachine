# ResinApp System

โปรเจคนี้เป็นระบบจัดการ ResinApp ซึ่งพัฒนาด้วย Laravel สำหรับการจัดการและควบคุมแอปต่าง ๆ ที่เกี่ยวข้อง โดย `ResinController` (อยู่ใน `Controllers\NewVersion\ResinController.php`) ทำหน้าที่เป็นตัวหลักในการจัดการฟังก์ชันการทำงานของแอปนี้ 

## Technologies Used

- **Framework**: Laravel
- **Backend Language**: PHP (รองรับทั้งเวอร์ชัน 7.3 และ 8.0)
- **Database**: Sqlsrv 
- **Image Manipulation**: Intervention Image
- **Excel Export**: Maatwebsite Excel
- **Barcode Generation**: Picqer PHP Barcode Generator
- **Authentication**: Laravel Sanctum และ Socialite (รองรับ Line Login)

## Key Features

- **Data Management**: จัดการข้อมูลที่เกี่ยวข้องกับ resinApp ผ่าน `Controllers\NewVersion\ResinController.php`
- **User Authentication**: ระบบล็อกอินโดยใช้ Laravel Sanctum และ Line Login ผ่าน Socialite
- **Image Processing**: รองรับการปรับแต่งและจัดการรูปภาพผ่าน Intervention Image

## System Architecture

- **Controller (Controllers\NewVersion\ResinController.php)**: จัดการฟังก์ชันต่าง ๆ ของ resinApp
- **Database**: จัดเก็บข้อมูลของผู้ใช้และข้อมูลที่เกี่ยวข้องกับ resinApp
- **Laravel Sanctum**: จัดการระบบ Authentication ภายในแอป
- **Line Login**: จัดการการล็อกอินผ่านบัญชี LINE โดยใช้ Socialite

## Installation and Setup

1. Clone โปรเจคและเข้าสู่โฟลเดอร์ 
2. ติดตั้ง dependencies: `composer install`
3. คัดลอก `.env.example` ไปเป็น `.env` และตั้งค่าให้เหมาะสม
4. สร้าง application key: `php artisan key:generate`
5. รันการ migrate เพื่อสร้างฐานข้อมูล: `php artisan migrate` (กรณี ใช้ database ใหม่)
6. เริ่มต้น server: `php artisan serve`

## How It Works

1. ResinApp จัดการข้อมูลผ่าน `Controllers\NewVersion\ResinController.php` โดยใช้ Laravel MVC framework
2. ระบบจัดเก็บและจัดการรูปภาพที่อัพโหลด โดยรองรับการปรับขนาดและการแปลงรูปภาพตามความต้องการ
3. จัดการ แผนการตรวจโดย Admin

## Database Diagram
![MTCheck_er](https://github.com/user-attachments/assets/5db99742-8cd0-4033-a078-fbc51864631d)


## License

[MIT license](https://opensource.org/licenses/MIT)
