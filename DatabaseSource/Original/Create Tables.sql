/*CREATE TABLE statements*/

 /*
  * STORY TABLES
  */
 /*Bad Story Table*/
 CREATE TABLE `bad_story` (
   `story_id` int(11) NOT NULL AUTO_INCREMENT,
   `event_sequence` text COLLATE utf8_unicode_ci,
   `location_sequence` text COLLATE utf8_unicode_ci,
   `action_sequence` text COLLATE utf8_unicode_ci,
   PRIMARY KEY (`story_id`)
 )

 /*Good_Story Table*/
 CREATE TABLE `good_story` (
   `story_id` int(11) NOT NULL AUTO_INCREMENT,
   `event_sequence` text COLLATE utf8_unicode_ci NOT NULL,
   `location_sequence` text COLLATE utf8_unicode_ci NOT NULL,
   `action_sequence` text COLLATE utf8_unicode_ci,
   PRIMARY KEY (`story_id`)
 )

 /*evaluated_story Table*/
 CREATE TABLE evaluated_story (
   story_id int(11) NOT NULL AUTO_INCREMENT,
   event_sequence varchar(150) NOT NULL,
   location_sequence varchar(150) NOT NULL,
   action_sequence varchar(150) NOT NULL,
   rating varchar(2),
   respect_death int(1) DEFAULT 1,
   allow_doppelgangers int(1) DEFAULT 0,
   character_motive int(1) DEFAULT 1,
   invert_cm int(1) DEFAULT 0,
   markov_event int(1) DEFAULT 1,
   markov_location int(1) DEFAULT 1,
   markov_action int(1) DEFAULT 0,
   n_gram_size int(2) DEFAULT 2,
   PRIMARY KEY (story_id)
 );
/*
 * ACTION TABLES
 */
/*Action Table*/
CREATE TABLE `action` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`ac_id`),
  KEY `consequence` (`consequence`),
  CONSTRAINT `action_ibfk_1` FOREIGN KEY (`consequence`) REFERENCES `action_consequence` (`con_id`)
)

/*Action Consequence Table*/
CREATE TABLE `action_consequence` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `ac_id` int(11) DEFAULT NULL,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`con_id`),
  KEY `ac_id` (`ac_id`),
  CONSTRAINT `action_consequence_ibfk_1` FOREIGN KEY (`ac_id`) REFERENCES `action` (`ac_id`)
)

/*
 * EVENT TABLES
 */
/*Event Table*/
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `brief` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `consequence` (`consequence`),
  CONSTRAINT `event_ibfk_1` FOREIGN KEY (`consequence`) REFERENCES `event_consequence` (`con_id`)
)

/*event_consequence Table*/
CREATE TABLE `event_consequence` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`con_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_consequence_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`)
)

/*
 * LOCATION TABLE
 */
/*Location Table*/
CREATE TABLE `location` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`loc_id`)
)

/*
 * CHARACTER TABLES
 */
/*Character_obj Table*/
CREATE TABLE `character_obj` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `charObj` text COLLATE utf8_unicode_ci NOT NULL,
  `story_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`c_id`),
  KEY `story_id` (`story_id`),
  CONSTRAINT `character_obj_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `good_story` (`story_id`)
)

/*Character_desc Table*/
CREATE TABLE `character_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `age` int(11) NOT NULL,
  `temperment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`desc_id`)
)

/*S_Character Table*/
CREATE TABLE `s_character` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `fName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `c_desc` int(11) DEFAULT NULL,
  PRIMARY KEY (`c_id`),
  KEY `s_character` (`c_desc`),
  CONSTRAINT `s_character_ibfk_1` FOREIGN KEY (`c_desc`) REFERENCES `character_desc` (`desc_id`)
)

/*Good_Character Table*/
CREATE TABLE `good_character` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT,
  `story_id` int(11) DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL,
  `desc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`gc_id`),
  KEY `story_id` (`story_id`),
  KEY `c_id` (`c_id`),
  KEY `desc_id` (`desc_id`),
  CONSTRAINT `good_character_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `good_story` (`story_id`),
  CONSTRAINT `good_character_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `s_character` (`c_id`),
  CONSTRAINT `good_character_ibfk_3` FOREIGN KEY (`desc_id`) REFERENCES `character_desc` (`desc_id`)
)
