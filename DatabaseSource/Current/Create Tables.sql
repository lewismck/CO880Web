/**
 * @author Lewis Mckeown
 **/
 /*--------------------------------------------------------------
    This document contains a list of SQL statements that can
    be used to recreate the database for the software
    (minus some foreign key links).
  ---------------------------------------------------------------*/

/*-------------------
      Action
 -------------------*/
 CREATE TABLE `action` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT,
  `brief` varchar(255) NOT NULL,
  `long_desc` varchar(200),
  `tone` varchar(50) DEFAULT NULL,
  `consequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`ac_id`),
  KEY `consequence` (`consequence`),
  CONSTRAINT `action_ibfk_1` FOREIGN KEY (`consequence`) REFERENCES `action_consequence` (`con_id`)
)
/*-------------------
  Action Consequence
 -------------------*/
 CREATE TABLE `action_consequence` (
   `con_id` int(11) NOT NULL AUTO_INCREMENT,
   `ac_id` int(11) DEFAULT NULL,
   `brief` varchar(255) NOT NULL,
   `long_desc` varchar(200)  ,
   `tone` varchar(50)   NOT NULL,
   `c1_es` int(11) DEFAULT NULL,
   `c2_es` int(11) DEFAULT NULL,
   `c1_es_desc` varchar(50) DEFAULT NULL,
   `c2_es_desc` varchar(50) DEFAULT NULL,
   `is_dead` varchar(10) DEFAULT NULL,
   `invert_c1_c2` int(1) DEFAULT '0',
   `solo_action` int(1) DEFAULT '0',
   PRIMARY KEY (`con_id`),
   KEY `ac_id` (`ac_id`),
   CONSTRAINT `action_consequence_ibfk_1` FOREIGN KEY (`ac_id`) REFERENCES `action` (`ac_id`)
 )

 /*-------------------
        Event
  -------------------*/
  CREATE TABLE `event` (
    `event_id` int(11) NOT NULL AUTO_INCREMENT,
    `brief` varchar(300)  DEFAULT NULL,
    `long_desc` text ,
    `tone` varchar(50)  DEFAULT NULL,
    `consequence` int(11) DEFAULT NULL,
    PRIMARY KEY (`event_id`),
    KEY `consequence` (`consequence`),
    CONSTRAINT `event_ibfk_1` FOREIGN KEY (`consequence`) REFERENCES `event_consequence` (`con_id`)
  )

  /*-------------------
    Event Consequence
   -------------------*/
   CREATE TABLE `event_consequence` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `brief` varchar(255)  NOT NULL,
  `long_desc` text ,
  `tone` varchar(50)  DEFAULT NULL,
  PRIMARY KEY (`con_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_consequence_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`)
)

/*-------------------
      Location
 -------------------*/
 CREATE TABLE `location` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255)  NOT NULL,
  `brief` varchar(255)  NOT NULL,
  `long_desc` text ,
  PRIMARY KEY (`loc_id`)
)

/*-------------------
  Evaluated Story
 -------------------*/
 CREATE TABLE `evaluated_story` (
  `story_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_sequence` varchar(150)  NOT NULL,
  `location_sequence` varchar(150)  NOT NULL,
  `action_sequence` varchar(150)  NOT NULL,
  `rating` varchar(2)  DEFAULT NULL,
  `respect_death` int(1) DEFAULT '1',
  `allow_doppelgangers` int(1) DEFAULT '0',
  `invert_cm` int(1) DEFAULT '0',
  `n_gram_size` int(2) DEFAULT '2',
  `event_choice` varchar(10)  DEFAULT 'markov',
  `location_choice` varchar(10)  DEFAULT 'markov',
  `action_choice` varchar(10)  DEFAULT 'markov',
  PRIMARY KEY (`story_id`)
)

/*-------------------
  Archived Story
 -------------------*/
 CREATE TABLE `archived_story_data` (
  `story_id` int(11) NOT NULL DEFAULT '0',
  `event_sequence` varchar(150)  NOT NULL,
  `location_sequence` varchar(150)  NOT NULL,
  `action_sequence` varchar(150)  NOT NULL,
  `rating` varchar(2)  DEFAULT NULL,
  `respect_death` int(1) DEFAULT '1',
  `allow_doppelgangers` int(1) DEFAULT '0',
  `character_motive` int(1) DEFAULT '1',
  `invert_cm` int(1) DEFAULT '0',
  `markov_event` int(1) DEFAULT '1',
  `markov_location` int(1) DEFAULT '1',
  `markov_action` int(1) DEFAULT '0',
  `n_gram_size` int(2) DEFAULT '2',
  `random_action` int(1) DEFAULT '0',
  `event_choice` varchar(10)  DEFAULT 'markov',
  `location_choice` varchar(10)  DEFAULT 'markov',
  `action_choice` varchar(10)  DEFAULT 'markov'
)

/*-------------------
  User Feedback
 -------------------*/
 CREATE TABLE user_feedback (
   id int(11) NOT NULL AUTO_INCREMENT,
   story_id int(11) NOT NULL,
   dataset varchar(50) NOT NULL,
   creativity_rating int(11) NOT NULL,
   liked varchar(5),
   timeRated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (id)
 );

/*-------------------
  Story Character
 -------------------*/
 CREATE TABLE `s_character` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `fName` varchar(50)  NOT NULL,
  `lName` varchar(50)  NOT NULL,
  `gender` char(1)  DEFAULT NULL,
  `c_desc` int(11) DEFAULT NULL,
  PRIMARY KEY (`c_id`),
  KEY `s_character` (`c_desc`),
  CONSTRAINT `s_character_ibfk_1` FOREIGN KEY (`c_desc`) REFERENCES `character_desc` (`desc_id`)
)

/*----------------------
  Character Description
 ----------------------*/
 REATE TABLE `character_desc` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `age` int(11) NOT NULL,
  `temperment` varchar(255)  NOT NULL,
  PRIMARY KEY (`desc_id`)
)

/*---------------------
  Evaluated Character
 ---------------------*/
 CREATE TABLE `evaluated_character` (
  `c_id` int(10) NOT NULL AUTO_INCREMENT,
  `character_obj` varchar(1000)  DEFAULT NULL,
  `story_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`c_id`)
)
