CREATE Table IF NOT EXISTS `Ratings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `item_id` INT REFERENCES `RM_Items`(`id`),
    `user_id` int(11) NOT NULL,
    `rating` int(11) NOT NULL CONSTRAINT `rating_range` CHECK (rating >= 0 AND rating <= 5),
    `comment` TEXT,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
)