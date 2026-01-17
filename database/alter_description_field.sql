-- Alter tickets table to support larger description (for base64 images)
ALTER TABLE `tickets` MODIFY COLUMN `description` LONGTEXT;

-- Alter comments table to support larger body content (for base64 images)
ALTER TABLE `comments` MODIFY COLUMN `body` LONGTEXT;
