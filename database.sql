CREATE TABLE `clients` (
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `activated` TINYINT NOT NULL,
  `recover_code` INT DEFAULT NULL,
  `uid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `websites` (
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `suspended` TINYINT NOT NULL,
  `date_created` DATETIME NOT NULL,
  `client_email` VARCHAR(255) NOT NULL,
  `uid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
