CREATE TABLE `transfers` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `payer_id` BIGINT UNSIGNED NOT NULL,
  `payee_id` BIGINT UNSIGNED NOT NULL,
  `amount` DECIMAL (10, 2) NOT NULL DEFAULT 0,
  `status` ENUM ('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`payer_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`payee_id`) REFERENCES `users` (`id`)
);
