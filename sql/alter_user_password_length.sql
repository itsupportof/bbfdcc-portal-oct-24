-- Widen the user.password column to hold modern password hashes.
--
-- The column was varchar(40), sized for legacy 32-char MD5 hashes. A bcrypt
-- hash (password_hash / PASSWORD_DEFAULT) is 60 characters, so it was being
-- silently truncated to 40 chars and could never verify on login.
--
-- After running this, any account whose hash was already truncated
-- (LIKE '$2y$%' AND LENGTH(password) < 60) must reset its password again.

ALTER TABLE `user` MODIFY `password` VARCHAR(255) NOT NULL;
