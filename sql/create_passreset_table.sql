-- Creates the `passreset` table used by the password-reset flow.
-- Referenced by lib.php (getAResetLink / resetPasword) and reset-password.php.
--
-- Columns:
--   id        - primary key (read as $row3['id']; used in DELETE ... WHERE id)
--   userid    - the user's id (from the `user` table)
--   email     - the account email the reset was requested for
--   token     - reset token, bin2hex(random_bytes(50)) = 100 hex chars
--   timestamp - set on creation; reset-password.php expires links older than the current day
--
-- Safe to run more than once (IF NOT EXISTS).

CREATE TABLE IF NOT EXISTS `passreset` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userid` INT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_passreset_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
