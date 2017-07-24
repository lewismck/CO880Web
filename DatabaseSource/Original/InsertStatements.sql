/*INSERT STATEMENTS*/
/*
 * STORY TABLES
 */
/*Bad Story*/
INSERT INTO `bad_story` VALUES (1,'5','3','3'),(2,'6','1','1'),(3,'6','6','2');

/*Good Story*/
--INSERT INTO good_story (event_sequence, location_sequence) VALUES(‘’,’’);
INSERT INTO `good_story` VALUES (1,'5','4','5'),(2,'6','4','5'),(3,'6','3','2'),(4,'6','5','1'),(5,'6','3','5'),(6,'5','5','4'),(7,'3','6','3'),(8,'5','2','4'),(9,'5','4','4'),(10,'5','4','3'),(11,'5','2','5'),(12,'6','1','2'),(13,'5','2','4'),(14,'6','5','4'),(15,'6','4','4'),(16,'6','3','1'),(17,'5','5','1'),(18,'6','6','3'),(19,'6','5','5'),(20,'3','4','5'),(21,'5','1','2'),(22,'5','2','1'),(23,'5','1','5'),(24,'9 9','9 9','9 9'),(25,'6','2','5'),(26,'5','2','2'),(27,'3','5','5'),(28,'6','1','4'),(29,'6','2','1'),(30,'6','3','3'),(31,'5','4','1');

/*
 * LOCATION TABLE
 */
 --INSERT INTO location (name, brief, long_desc) VALUES(‘’,’’,’’);
INSERT INTO `location` VALUES (1,'the coffee shop','a cheap place to get coffee','low rent, New York coffee joint with booths and plastic covered seats'),(2,'Ennet House Drug and Alcohol Recovery centre','a rehabilitation centre','located near the Enfield Tennis Academy and home to all manner of recovering addicts, was once the scene of a shootout'),(3,'The Double R Diner','a small local diner, serves coffee and pie','local diner, known for coffee and cherry pie.'),(4,'Ghostwood National Forest','Forest surrounding a small town, known for strange occurences','known for strange occurences and unusual places, like Owl Cave and the Black Lodge'),(5,'The Great Northern Hotel','a large hotel with a rustic vibe','wood panelled walls and native american statues are common in the enormous hotel, as are strange occurences'),(6,'Owl Cave','Known for many owls inhabiting it','filled with ancient native American petroglyphs, contains a map behind a wall moved by a hidden mechanism');

/*
 * EVENT TABLES
 */
/*Event*/
--INSERT INTO event (brief, long_desc, tone) VALUES (‘’,’’,’’);
INSERT INTO `event` VALUES (3,'The body of a local is found','The discovery of a body sparks an investigation involving the FBI and the local Sherrifs, unsettling the whole town.','unsettling',1),(5,'A town wide drug smuggling operation is revealed','A border crossing drug dealing empire is uncovered, probably involving several local businesses and prominent figures','surprising',3),(6,'A plot to burn down the Sawmill is hatched','An unknown group, or possibly a lone actor has begun to work on a way to burn down the local saw mill, perhaps for insurance or revenge','exciting',4);

/*Event consequence*/
INSERT INTO `event_consequence` VALUES (1,3,'Out of town investigators arrive and everyone is a suspect','an FBI agent is called from out of town to aid in the investigation, murder is suspected and everyone\'s secrets are at risk as they\'re placed under scrutiny of the law','unsettling'),(3,5,'More police arrive in town from all accross the country','as police presence increases and scrutiny on the locals rises, the atmosphere becomes unpleasant','unsettling'),(4,6,'the sawmill is burned to the ground overnight, the town is shocked','The sawmill is set ablaze late at night and burns throroughly before any authorities can arrive. It seems no one was harmed, but the mill is no more and there\'s little evidence','shocking');

/*
 * CHARACTER TABLES
 */
/*S_character*/
--INSERT INTO s_character (fName, lName, gender) VALUES(‘’,’’,’’);
INSERT INTO `s_character` VALUES (1,'Kate','Gompert','f',1),(2,'George','Costanza','m',2),(3,'Dale','Cooper','m',3),(4,'Harry','Truman','m',4),(5,'Laura','Palmer','f',5),(6,'Leland','Palmer','m',6),(7,'Benjamin','Horne','m',7),(8,'Audrey','Horne','f',8),(9,'Log','Lady','f',9),(10,'Dr. Lawrence','Jacoby','m',10);

/*Character_desc*/
--INSERT INTO character_desc (age, temperment) VALUES(,’’);
INSERT INTO `character_desc` VALUES (1,27,'lethargic, addicted to prescription drugs that relax you.. a lot'),(2,38,'lazy, uncooperative, selfish and self motivated'),(3,33,'Mild mannered FBI agent, in love with rural life'),(4,37,'Respected sheriff, head of local police department'),(5,19,'Well known high school student'),(6,47,'Known for compulsive singing and dancing, a lawyer by trade'),(7,47,'Wealthy business owner, proprietor of Great Northern Hotel'),(8,18,'Inquisitive and sullen teenager'),(9,63,'Divines fortunes and the future through a log carried everywhere with them'),(10,52,'eccentric local psychiatrist, obsessed with Hawaii');

/*character_obj*/
INSERT INTO `character_obj` VALUES (1,'O:6:\"Person\":8:{s:7:\"isAlive\";b:1;s:2:\"id\";s:1:\"7\";s:9:\"firstname\";s:8:\"Benjamin\";s:8:\"lastname\";s:5:\"Horne\";s:6:\"gender\";s:1:\"m\";s:6:\"descID\";s:1:\"7\";s:3:\"age\";s:2:\"47\";s:10:\"temperment\";s:58:\"Wealthy business owner, proprietor of Great Northern Hotel\";}',NULL),(2,'O:6:\"Person\":8:{s:7:\"isAlive\";b:1;s:2:\"id\";s:1:\"4\";s:9:\"firstname\";s:5:\"Harry\";s:8:\"lastname\";s:6:\"Truman\";s:6:\"gender\";s:1:\"m\";s:6:\"descID\";s:1:\"4\";s:3:\"age\";s:2:\"37\";s:10:\"temperment\";s:50:\"Respected sheriff, head of local police department\";}',NULL);

/*Good_character*/
--INSERT INTO good_character (story_id, c_id, desc_id) VALUES (‘’,’’,’’);

/*
 * ACTION TABLES
 */
/*Action*/
INSERT INTO action (brief, long_desc, tone) VALUES('', '', '');
--Consequence
INSERT INTO action_consequence (brief, long_desc, tone, c1_es, c2_es, c1_es_desc, c2_es_desc, is_dead) VALUES('','','',,,'','','');
--Update
UPDATE action SET consequence = ?? WHERE ac_id = ??;
UPDATE action_consequence SET ac_id = ?? WHERE con_id = ??;

INSERT INTO `action` VALUES (1,'cries in front of','starts to bow their head, lips quivering, eyes welling up, and begins to sob','sad',1),(2,'drinks coffee with','enjoys a cup of damn fine freshly brewed coffee','pleasant',2),(3,'hallucinates BOB in front of','Begins to stammer and point into thin air, then starts screaming','terrifying',3),(4,'murders','poisons with a blow dart','scary',4),(5,'stalks','begins following and cataloguing the movements and interactions of','creepy',5);

/*action_consequence*/
INSERT INTO `action_consequence` VALUES (1,1,'is embarassed after being seen to cry by','they stammer and try to stop themselves from sobbing','awkawrd'),(2,2,'becomes friends with','the time spent together is pleasant and the two develop a friendship','pleasant'),(3,3,'comes around after hallucinating, but is too terrified to talk to','after hallucinating they are unable to speak coherently and keep looking around somewhat erraticaly, unsettling','spooky'),(4,4,'has to hide the body of','searches for somewhere to dispose of the body, is worried about getting caught with','unsettling'),(5,5,'becomes infatuated with','continues to obsess over and follow','creepy');
