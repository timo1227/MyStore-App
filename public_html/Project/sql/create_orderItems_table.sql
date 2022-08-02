CREATE Table IF NOT EXISTS `OrderItems` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT REFERENCES `Orders`(`id`),
    `item_id` INT REFERENCES `RM_Items`(`id`),
    `quantity` INT,
    `unit_price` INT NOT NULL,
    UNIQUE KEY (`order_id`, `item_id`)
)