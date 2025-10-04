CREATE DATABASE IF NOT EXISTS presensi;
USE presensi;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  -- `role` enum('admin','pegawai') DEFAULT 'pegawai',
  `qr_token` varchar(128) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`)
);

-- Ubah tabel users: hapus kolom role
-- ALTER TABLE users DROP COLUMN role;

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` enum('in','out') NOT NULL,
  `scanned_token` varchar(128) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lon` decimal(10,7) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_date` (`user_id`,`created_at`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `remember_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` char(24) NOT NULL,
  `token_hash` char(64) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_id` (`user_id`)
);

-- Tabel position
CREATE TABLE IF NOT EXISTS `positions` (
    `id_positions` INT AUTO_INCREMENT PRIMARY KEY,
    `positions` VARCHAR(100) NOT NULL
);

-- Tabel departement
CREATE TABLE IF NOT EXISTS `departements` (
    `id_departements` INT AUTO_INCREMENT PRIMARY KEY,
    `departements` VARCHAR(100) NOT NULL
);

-- Tabel employee_status
CREATE TABLE IF NOT EXISTS `employee_status` (
    `id_status` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_status` VARCHAR(100) NOT NULL
);

-- Tabel user_employee
CREATE TABLE IF NOT EXISTS `user_employee` (
    `id` INT NOT NULL,
    `id_positions` INT NOT NULL,
    `id_departements` INT NOT NULL,
    `id_status` INT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT `fk_user` FOREIGN KEY (`id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_positions` FOREIGN KEY (`id_positions`) REFERENCES `positions`(`id_positions`),
    CONSTRAINT `fk_departements` FOREIGN KEY (`id_departements`) REFERENCES `departements`(`id_departements`),
    CONSTRAINT `fk_status` FOREIGN KEY (`id_status`) REFERENCES `employee_status`(`id_status`)
);

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `year` int NOT NULL,
  `month` tinyint NOT NULL,
  `created_by` int DEFAULT NULL,
  `note` text,
  `default_checkin` time NOT NULL DEFAULT '08:00:00',
  `default_checkout` time NOT NULL DEFAULT '16:00:00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_year_month` (`year`,`month`)
);

CREATE TABLE IF NOT EXISTS `schedule_days` (
  `id` int NOT NULL AUTO_INCREMENT,
  `schedule_id` int NOT NULL,
  `the_date` date NOT NULL,
  `status` enum('work','off') NOT NULL DEFAULT 'work',
  `note` varchar(255) DEFAULT NULL,
  `checkin_time` time DEFAULT NULL,
  `checkout_time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_schedule_date` (`schedule_id`,`the_date`),
  KEY `idx_schedule` (`schedule_id`),
  CONSTRAINT `schedule_days_fk` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE
)