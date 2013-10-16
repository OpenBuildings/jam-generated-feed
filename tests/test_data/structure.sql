DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(254) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`, `name`, `price`, `currency`)
VALUES
  (1,'Chair',290.40,'GBP'),
  (2,'Rug',30.00,'GBP'),
  (3,'Matrass',130.99,'EUR');