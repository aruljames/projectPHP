CREATE TABLE `pphp`.`core_config` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `config_key` VARCHAR(60) NOT NULL ,
    `type` VARCHAR(60) NOT NULL ,
    `value` TEXT NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (`id`, `config_key`)
    ) ENGINE = InnoDB;
