-- Tracks failed login attempts per account so the login lockout survives across
-- sessions and an Admin can clear it (via ?page=lockedAccounts).
--
-- Columns:
--   email      - the account email (primary key)
--   attempts   - consecutive failed login count
--   lock_until - when set and in the future, the account is locked until then
--   updated_at - last change (auto-maintained)
--
-- Safe to run more than once (IF NOT EXISTS).

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `email` VARCHAR(255) NOT NULL,
  `attempts` INT NOT NULL DEFAULT 0,
  `lock_until` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
