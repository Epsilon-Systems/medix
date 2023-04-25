ALTER TABLE `#__joomtestimonials` CHANGE `testimonial` `testimonial` text NULL ;
ALTER TABLE `#__joomtestimonials` CHANGE `vote` `vote` tinyint(1) NOT NULL DEFAULT 0;
ALTER TABLE `#__joomtestimonials` CHANGE `params` `params` text NULL ;