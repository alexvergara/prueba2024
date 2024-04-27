CREATE TABLE `notifications` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `transaction_id` BIGINT UNSIGNED NOT NULL,
  `type` ENUM ('email', 'sms'),
  `status` ENUM ('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending',
  `body` TEXT NOT NULL,
  FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`)
);
