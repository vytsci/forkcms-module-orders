DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_profile_id` int(11) DEFAULT NULL,
  `customer_profile_id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `billable` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_number` varchar(255) DEFAULT NULL,
  `invoice_issued_on` datetime DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_on` datetime DEFAULT NULL,
  `cancelled_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `PAYMENT` (`payment_id`),
  KEY `CART` (`cart_id`),
  KEY `PROFILE_AS_SUPPLIER` (`supplier_profile_id`),
  KEY `PROFILE_AS_CUSTOMER` (`customer_profile_id`),
  CONSTRAINT `fk_orders_to_carts` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_to_payments` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_to_profiles_as_customer` FOREIGN KEY (`customer_profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_to_profiles_as_supplier` FOREIGN KEY (`supplier_profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `orders_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `external_id` int(11) NOT NULL,
  `module` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL DEFAULT '1',
  `options` text,
  `callback_success` varchar(255) NOT NULL DEFAULT 'callbackOrdersItemsSuccess',
  `callback_cancel` varchar(255) NOT NULL DEFAULT 'callbackOrdersItemsCancel',
  PRIMARY KEY (`id`),
  KEY `ORDER` (`order_id`),
  CONSTRAINT `fk_orders_items_to_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
