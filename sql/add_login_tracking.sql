-- Login tracking: per-user last login + a full login history. (ALREADY APPLIED.)
--
-- user.last_login  - stamped on each successful login (shown on Current Users).
-- login_log        - one row per successful login (shown on the Login Log page).

ALTER TABLE `user` ADD COLUMN `last_login` DATETIME NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `login_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userid` INT NULL,
  `email` VARCHAR(255) NULL,
  `name` VARCHAR(255) NULL,
  `role` INT NULL,
  `ip` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `login_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_login_log_userid` (`userid`),
  KEY `idx_login_log_time` (`login_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
