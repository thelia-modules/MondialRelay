
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- mondial_relay_pickup_address
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mondial_relay_pickup_address`;

CREATE TABLE `mondial_relay_pickup_address`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `json_relay_data` LONGTEXT NOT NULL,
    `order_address_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mondial_relay_delivery_price
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mondial_relay_delivery_price`;

CREATE TABLE `mondial_relay_delivery_price`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `max_weight` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `price_with_tax` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `area_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fi_mondial_relay_delivery_price_area_id` (`area_id`),
    CONSTRAINT `fk_mondial_relay_delivery_price_area_id`
        FOREIGN KEY (`area_id`)
        REFERENCES `area` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mondial_relay_delivery_insurance
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mondial_relay_delivery_insurance`;

CREATE TABLE `mondial_relay_delivery_insurance`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `level` INTEGER NOT NULL,
    `max_value` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    `price_with_tax` DECIMAL(16,6) DEFAULT 0.000000 NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mondial_relay_zone_configuration
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mondial_relay_zone_configuration`;

CREATE TABLE `mondial_relay_zone_configuration`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `delivery_time` INTEGER NOT NULL,
    `delivery_type` INTEGER(1) NOT NULL,
    `area_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fi_mondial_relay_zone_configuration_area_id` (`area_id`),
    CONSTRAINT `fk_mondial_relay_zone_configuration_area_id`
        FOREIGN KEY (`area_id`)
        REFERENCES `area` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
