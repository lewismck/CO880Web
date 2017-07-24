<?php
  /*--------------------------------------
    Queries used by the classes.php file
    split by what class uses them, named
    after the function call followed by
    some clarification
    e.g checkExistsX where X is action,
    location, event.
  --------------------------------------*/
  /*
   * Main queries
   */
   $KBQuery = "SELECT
                 GROUP_CONCAT(TRIM(event_sequence) SEPARATOR ',') event_seq
               , GROUP_CONCAT(TRIM(action_sequence) SEPARATOR ',') action_seq
               , GROUP_CONCAT(TRIM(location_sequence) SEPARATOR ',') location_seq
               FROM evaluated_story es
               WHERE es.rating = 'g';";

   $eventSeedGet = "SELECT e.event_id, e.brief FROM event e;";

   $locationSeedGet = "SELECT l.loc_id, l.name FROM location l;";
  /*
   *StoryMaker queries
   *
   */
  $eventStatementGet = "SELECT event.*
                       , ec.brief AS con_brief
                       , ec.long_desc AS con_long
                       , ec.tone AS con_tone
                       FROM event
                       JOIN event_consequence ec ON event.consequence = ec.con_id ";

  $locationStatementGET = "SELECT * FROM location ";

  $checkExistsEvent = "SELECT e.event_id
                       FROM event e
                       WHERE e.event_id =";

  $checkExistsAction = "SELECT a.ac_id
                        FROM action a
                        WHERE a.ac_id =";

  $checkExistsLocation = "SELECT l.loc_id
                          FROM location l
                          WHERE l.loc_id =";
 ?>
