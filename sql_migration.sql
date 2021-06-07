-- dark logo field 

ALTER TABLE `fc_sitesettings` ADD `site_dark_logo` VARCHAR(20) NOT NULL AFTER `site_logo`;

-- Gift amount calculation 

ALTER TABLE `fc_order_items` ADD `giftamount` VARCHAR(15) NULL AFTER `dealPercentage`;

-- add merchant id for seller account

ALTER TABLE `fc_shops` ADD `merchant_id` VARCHAR(50) NULL AFTER `braintree_type`;

-- add merchant id for seller account

ALTER TABLE `fc_groupgiftpayamts` ADD `status` VARCHAR(50) NULL AFTER `cdate`;
