CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `identification` VARCHAR (20) NOT NULL UNIQUE,
  `full_name` VARCHAR (255) NOT NULL,
  `password` VARCHAR (255) NOT NULL,
  `email` VARCHAR (255) NOT NULL UNIQUE,
  `balance` DECIMAL (10, 2) NOT NULL DEFAULT 0,
  `role` ENUM ('user', 'merchant') NOT NULL DEFAULT 'user',
  `notify_by` ENUM ('email', 'sms') NOT NULL DEFAULT 'email',
  PRIMARY KEY (`id`)
);

