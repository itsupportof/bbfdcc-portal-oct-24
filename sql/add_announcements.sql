-- Announcements feature: post announcements shown in the portal and
-- (optionally) emailed to all users through a throttled queue. (ALREADY APPLIED.)

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `created_by` INT NULL,
  `created_by_name` VARCHAR(255) NULL,
  `send_email` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ann_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `announcement_recipients` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `announcement_id` INT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'pending',
  `attempts` INT NOT NULL DEFAULT 0,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ar_ann` (`announcement_id`),
  KEY `idx_ar_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
