CREATE DATABASE presensi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE presensi;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nik VARCHAR(50) UNIQUE NOT NULL,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150),
  password VARCHAR(255) NOT NULL, -- hanya untuk admin/login; pegawai bisa tidak punya password
  role ENUM('admin','pegawai') DEFAULT 'pegawai',
  qr_token VARCHAR(128) NOT NULL, -- token unik dipakai di QR
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  type ENUM('in','out') NOT NULL,
  scanned_token VARCHAR(128) NOT NULL,
  photo_path VARCHAR(255), -- optional: foto bukti
  lat DECIMAL(10,7), lon DECIMAL(10,7), -- optional geolocation
  ip_address VARCHAR(45),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX idx_user_date ON attendance(user_id, created_at);
