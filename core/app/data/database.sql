DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL,
  `image` varchar(255),
  `price` decimal(10,2),
  `model_make_id` varchar(255),
  `model_name` varchar(255),
  `model_trim` varchar(255) ,
  `model_year` int(11),
  `model_body` varchar(255) ,
  `model_engine_position` varchar(255) ,
  `model_engine_cc` int(11) ,
  `model_engine_cyl` int(11) ,
  `model_engine_type` varchar(255) ,
  `model_engine_stroke_mm` varchar(255) ,
  `model_engine_valves_per_cyl` int(11) ,
  `model_engine_power_ps` int(11) ,
  `model_engine_power_rpm` int(11) ,
  `model_engine_torque_nm` int(11) ,
  `model_engine_torque_rpm` int(11) ,
  `model_engine_bore_mm` varchar(255) ,
  `model_engine_compression` varchar(100) ,
  `model_engine_fuel` varchar(255) ,
  `model_top_speed_kph` int(11) ,
  `model_0_to_100_kph` int(11) ,
  `model_drive` varchar(255) ,
  `model_transmission_type` varchar(255) ,
  `model_seats` varchar(255) ,
  `model_doors` int(11) ,
  `model_weight_kg` int(11) ,
  `model_length_mm` int(11) ,
  `model_width_mm` int(11) ,
  `model_height_mm` int(11) ,
  `model_wheelbase_mm` int(11) ,
  `model_lkm_hwy` decimal(10,2) ,
  `model_lkm_mixed` decimal(10,2) ,
  `model_lkm_city` decimal(10,2) ,
  `model_fuel_cap_l` decimal(10,2) ,
  `model_sold_in_us` int(11) ,
  `model_co2` varchar(255) ,
  `model_make_display` varchar(255) ,
  `make_display` varchar(255) ,
  `make_country` varchar(255) ,

  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cars
-- ----------------------------
INSERT INTO cars (
  model_id, model_make_id, model_name,
  model_trim,model_year,model_body,
  model_engine_position,model_engine_cc,model_engine_cyl,
  model_engine_type,model_engine_valves_per_cyl,model_engine_power_ps,
  model_engine_power_rpm,model_engine_torque_nm,model_engine_torque_rpm,
  model_engine_bore_mm,model_engine_fuel,model_top_speed_kph,
  model_0_to_100_kph,model_drive,model_transmission_type,
  model_seats,model_doors,model_weight_kg,
  model_length_mm,model_width_mm,model_height_mm,
  model_wheelbase_mm,model_lkm_hwy,model_lkm_mixed,
  model_lkm_city,model_fuel_cap_l,model_sold_in_us,
  model_co2,model_make_display,make_display,
  make_country
)
 VALUES (
   174847,'Acura', 'ILX',
  '4dr Sedan (2.0L 4cyl 5A)',2014, 'Compact Cars',
  'Front',2000,4,
  'Inline',4,150,
   null,140,null,
   null,10.2,null,
   null,'Front Wheel Driv','Automatic',
   null,4,1000,
   null,null,null,
   null,null,20,
   28.2,50,13,
   1,'Acura','Acura',
   'USA'
   ),
   (
   174848,'Acura', 'ILX',
  '4dr EWEE (2.0L 4cyl 5A)',2014, 'Compact Cars',
  'Back',2000,4,
  'OUT',4,150,
   null,140,null,
   null,10.2,null,
   null,'Front Wheel Driv','Automatic',
   null,4,1000,
   null,null,null,
   null,null,20,
   28.2,50,13,
   1,'NINja','Acura',
   'AUS'
   ),
   (
   174849,'Acura', 'ILX',
  '4dr EWEE (2.0L 4cyl 5A)',2014, 'Compact Cars',
  'Back',2000,4,
  'OUT',4,150,
   null,140,null,
   null,10.2,null,
   null,'Front Wheel Driv','Automatic',
   null,4,1000,
   null,null,null,
   null,null,20,
   28.2,50,13,
   1,'NINja','Acura',
   'AUS'
   ),
   (
   174850,'Acura', 'ILX',
  '4dr EWEE (2.0L 4cyl 5A)',2014, 'Compact Cars',
  'Back',2000,4,
  'OUT',4,150,
   null,140,null,
   null,10.2,null,
   null,'Front Wheel Driv','Automatic',
   null,4,1000,
   null,null,null,
   null,null,20,
   28.2,50,13,
   1,'NINja','Acura',
   'AUS'
   ),
    (174851,'Acura', 'ILX',
  '4dr EWEE (2.0L 4cyl 5A)',2014, 'Compact Cars',
  'Back',2000,4,
  'OUT',4,150,
   null,140,null,
   null,10.2,null,
   null,'Front Wheel Driv','Automatic',
   null,4,1000,
   null,null,null,
   null,null,20,
   28.2,50,13,
   1,'NINja','Acura',
   'AUS'
   ),
   (
   174852,'Acura', 'ILX',
  '4dr EWEE (2.0L 4cyl 5A)',2014, 'Compact Cars',
  'Back',2000,4,
  'OUT',4,150,
   null,140,null,
   null,10.2,null,
   null,'Front Wheel Driv','Automatic',
   null,4,1000,
   null,null,null,
   null,null,20,
   28.2,50,13,
   1,'NINja','Acura',
   'AUS'
   ),
      (
   174853,'Acura', 'ILX',
  '4dr EWEE (2.0L 4cyl 5A)',2014, 'Compact Cars',
  'Back',2000,4,
  'OUT',4,150,
   null,140,null,
   null,10.2,null,
   null,'Front Wheel Driv','Automatic',
   null,4,1000,
   null,null,null,
   null,null,20,
   28.2,50,13,
   1,'NINja','Acura',
   'AUS'
   );



