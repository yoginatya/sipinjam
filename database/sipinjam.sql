-- SiPinjam - database schema + demo data
-- Database: MySQL 8+
CREATE DATABASE IF NOT EXISTS `db_sipinjam` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_sipinjam`;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `return_transactions`,`loan_details`,`loans`,`items`,`categories`,`sessions`,`password_reset_tokens`,`users`,`cache`,`cache_locks`,`jobs`,`job_batches`,`failed_jobs`,`migrations`;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nim` varchar(30) DEFAULT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `angkatan` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','admin') NOT NULL DEFAULT 'mahasiswa',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nim_unique` (`nim`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cache` (`key` varchar(255) NOT NULL, `value` mediumtext NOT NULL, `expiration` int NOT NULL, PRIMARY KEY (`key`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `cache_locks` (`key` varchar(255) NOT NULL, `owner` varchar(255) NOT NULL, `expiration` int NOT NULL, PRIMARY KEY (`key`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `jobs` (`id` bigint unsigned NOT NULL AUTO_INCREMENT, `queue` varchar(255) NOT NULL, `payload` longtext NOT NULL, `attempts` tinyint unsigned NOT NULL, `reserved_at` int unsigned DEFAULT NULL, `available_at` int unsigned NOT NULL, `created_at` int unsigned NOT NULL, PRIMARY KEY (`id`), KEY `jobs_queue_index` (`queue`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `job_batches` (`id` varchar(255) NOT NULL, `name` varchar(255) NOT NULL, `total_jobs` int NOT NULL, `pending_jobs` int NOT NULL, `failed_jobs` int NOT NULL, `failed_job_ids` longtext NOT NULL, `options` mediumtext, `cancelled_at` int DEFAULT NULL, `created_at` int NOT NULL, `finished_at` int DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `failed_jobs` (`id` bigint unsigned NOT NULL AUTO_INCREMENT, `uuid` varchar(255) NOT NULL, `connection` text NOT NULL, `queue` text NOT NULL, `payload` longtext NOT NULL, `exception` longtext NOT NULL, `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `stock` int NOT NULL DEFAULT 0,
  `available_stock` int NOT NULL DEFAULT 0,
  `condition` enum('baik','rusak_ringan','rusak_berat') NOT NULL DEFAULT 'baik',
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_code_unique` (`code`),
  KEY `items_category_id_foreign` (`category_id`),
  CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `loans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `loan_code` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `purpose` text,
  `status` enum('pending','approved','borrowed','returned','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loans_loan_code_unique` (`loan_code`),
  KEY `loans_user_id_foreign` (`user_id`),
  CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `loan_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loan_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT 1,
  `condition_before` enum('baik','rusak_ringan','rusak_berat') NOT NULL DEFAULT 'baik',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loan_details_loan_id_foreign` (`loan_id`),
  KEY `loan_details_item_id_foreign` (`item_id`),
  CONSTRAINT `loan_details_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loan_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `return_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `loan_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `condition_after` enum('baik','rusak_ringan','rusak_berat') DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_transactions_loan_id_foreign` (`loan_id`),
  KEY `return_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `return_transactions_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `return_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`name`,`nim`,`prodi`,`email`,`password`,`role`,`created_at`,`updated_at`) VALUES
('Administrator SiPinjam',NULL,NULL,'admin@kampus.ac.id','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC4xQhX0x2x1hJw0g7q','admin',NOW(),NOW()),
('Budi Santoso','23010001','Teknik Informatika','mahasiswa@kampus.ac.id','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC4xQhX0x2x1hJw0g7q','mahasiswa',NOW(),NOW());
-- Password for both demo users: password

INSERT INTO `categories` (`name`,`description`,`created_at`,`updated_at`) VALUES
('Elektronik','Perangkat elektronik kampus.',NOW(),NOW()),
('Multimedia','Peralatan foto, video, dan presentasi.',NOW(),NOW()),
('Laboratorium','Peralatan untuk kegiatan praktikum.',NOW(),NOW()),
('Olahraga','Peralatan kegiatan olahraga mahasiswa.',NOW(),NOW());

INSERT INTO `items` (`category_id`,`code`,`name`,`description`,`stock`,`available_stock`,`condition`,`status`,`created_at`,`updated_at`) VALUES
(1,'ELK-001','Proyektor Epson','Proyektor untuk presentasi kelas dan kegiatan kampus.',5,5,'baik','available',NOW(),NOW()),
(1,'ELK-002','Laptop Lenovo','Laptop inventaris untuk kegiatan akademik.',8,8,'baik','available',NOW(),NOW()),
(2,'MM-001','Kamera Canon','Kamera dokumentasi kegiatan kampus.',3,3,'baik','available',NOW(),NOW()),
(2,'MM-002','Tripod Kamera','Tripod untuk kebutuhan dokumentasi.',6,6,'baik','available',NOW(),NOW()),
(3,'LAB-001','Arduino Uno','Board mikrokontroler untuk praktikum.',20,20,'baik','available',NOW(),NOW()),
(4,'ORG-001','Bola Futsal','Bola futsal untuk kegiatan olahraga.',10,10,'baik','available',NOW(),NOW());
