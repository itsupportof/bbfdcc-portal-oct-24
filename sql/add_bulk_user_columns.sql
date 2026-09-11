-- Schema changes for bulk user creation + forced first-login password change.
--
-- 1) must_change_password: when 1, the user is forced to set a new password
--    on their next login before they can use the portal. (ALREADY APPLIED.)
-- 2) Widen email so long addresses aren't truncated during CSV import.
--    (PENDING - run in phpMyAdmin.)

ALTER TABLE `user` ADD COLUMN `must_change_password` TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE `user` MODIFY `email` VARCHAR(255) NOT NULL;
