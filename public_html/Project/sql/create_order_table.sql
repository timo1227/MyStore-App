
CREATE TABLE IF NOT EXISTS `Orders` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT,
    `created`    timestamp default current_timestamp,
    `total_price` INT,
    `address` VARCHAR(255) NOT NULL,
    `payment_method` VARCHAR(255) NOT NULL,
    `money_received` INT NOT NULL,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES Users(`id`)
)

