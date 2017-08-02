<?php
  /*--------------------------------------
    Queries used by the classes.php file
    split by what class uses them, named
    after the function call followed by
    some clarification
    e.g checkExistsX where X is action,
    location, event.
  --------------------------------------*/

  /*--------------
    Main queries
   --------------*/
  /*Get the good, bad and unrated story sequences (as 3 rows) */
  $KBQuery = "SELECT
                GROUP_CONCAT(TRIM(es.event_sequence) SEPARATOR ',') event_seq
              , GROUP_CONCAT(TRIM(es.action_sequence) SEPARATOR ',') action_seq
              , GROUP_CONCAT(TRIM(es.location_sequence) SEPARATOR ',') location_seq
              FROM evaluated_story es
              WHERE es.rating = 'g'
              UNION SELECT
               GROUP_CONCAT(TRIM(es.event_sequence) SEPARATOR ',') event_seq
              , GROUP_CONCAT(TRIM(es.action_sequence) SEPARATOR ',') action_seq
              , GROUP_CONCAT(TRIM(es.location_sequence) SEPARATOR ',')location_seq
              FROM evaluated_story es
              WHERE es.rating = 'b'
              UNION
              SELECT
                GROUP_CONCAT(TRIM(es.event_sequence) SEPARATOR ',') event_seq
              , GROUP_CONCAT(TRIM(es.action_sequence) SEPARATOR ',') action_seq
              , GROUP_CONCAT(TRIM(es.location_sequence) SEPARATOR ',') location_seq
              FROM evaluated_story es
              WHERE es.rating = 'x'";

  $eventSeedGet = "SELECT e.event_id, e.brief FROM event e;";//TODO check the seeds all exist in the evaluated story table?

  $locationSeedGet = "SELECT l.loc_id, l.name FROM location l;";//TODO check the seeds all exist in the evaluated story table?

  $actionSeedGet = "SELECT a.ac_id, a.brief FROM action a;";//TODO check the seeds all exist in the evaluated story table?

  $saveStoryInsert = "INSERT INTO evaluated_story (event_sequence, location_sequence, action_sequence, rating, respect_death, allow_doppelgangers, action_choice, location_choice, event_choice) VALUES";

  $getLatestStoryIDQuery = "SELECT story_id FROM evaluated_story WHERE story_id = (SELECT MAX(story_id) FROM evaluated_story);";

  $updateStoryRating = "UPDATE evaluated_story es SET es.rating = ";

  $saveCharacterInsert = "INSERT INTO evaluated_characters (character_obj, story_id) VALUES(";

  /*-------------------------
    Reflection Cycle Queries
              &
      StoryMaker Queries
   ------------------------*/
  $actionStatementGet = "SELECT action.*
                        , ac.brief AS con_brief
                        , ac.long_desc AS con_long
                        , ac.tone AS con_tone
                        , ac.c1_es
                        , ac.c2_es
                        , ac.c1_es_desc
                        , ac.c2_es_desc
                        , ac.is_dead
                        , ac.invert_c1_c2
                        , ac.solo_action
                        FROM action
                        JOIN action_consequence ac ON action.consequence=ac.con_id ";

  $eventStatementGet = "SELECT event.*
                        , ec.brief AS con_brief
                        , ec.long_desc AS con_long
                        , ec.tone AS con_tone
                        FROM event
                        JOIN event_consequence ec ON event.consequence = ec.con_id ";

  $locationStatementGet = "SELECT * FROM location ";

  $characterStatementGet = "SELECT
                            s_character.*
                            , cd.age
                            , cd.temperment FROM s_character
                            JOIN character_desc cd ON s_character.c_desc=cd.desc_id ";

  $checkExistsEvent = "SELECT e.event_id
                       FROM event e
                       WHERE e.event_id =";

  $checkExistsAction = "SELECT a.ac_id
                        FROM action a
                        WHERE a.ac_id =";

  $checkExistsLocation = "SELECT l.loc_id
                          FROM location l
                          WHERE l.loc_id =";

/*------------------------
  Chart and Graph queries
 -----------------------*/
  /*
   * Good story pie
   * random event
   * markov event
   * random location
   * markov location
   * random action
   * markov action
   * cm action
   * don't allow doppelgangers
   * allow doppelgangers
   * don't respect death
   * respect death
   */
  $goodStoryChart = "SELECT
                    COUNT(*) story_data
                    FROM evaluated_story es
                    WHERE es.rating = 'g' AND es.event_choice = 'random'
                    UNION all
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'g' AND es.event_choice = 'markov'
                    UNION ALL
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'g' AND es.location_choice = 'random'
                    UNION all
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'g' AND es.location_choice = 'markov'
                    UNION ALL
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'g' AND es.action_choice = 'random'
                    UNION all
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'g' AND es.action_choice = 'markov'
                    UNION ALL
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'g' AND es.action_choice = 'cm'
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='g' AND es.allow_doppelgangers  = 0
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='g' AND es.allow_doppelgangers  = 1
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='g' AND es.respect_death  = 0
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='g' AND es.respect_death  = 1;";

  /*
   * Bad story pie
   * random event
   * markov event
   * random location
   * markov location
   * random action
   * markov action
   * cm action
   * don't allow doppelgangers
   * allow doppelgangers
   * don't respect death
   * respect death
   */
  $badStoryChart = "SELECT
                    COUNT(*) story_data
                    FROM evaluated_story es
                    WHERE es.rating = 'b' AND es.event_choice = 'random'
                    UNION all
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'b' AND es.event_choice = 'markov'
                    UNION ALL
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'b' AND es.location_choice = 'random'
                    UNION all
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'b' AND es.location_choice = 'markov'
                    UNION ALL
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'b' AND es.action_choice = 'random'
                    UNION all
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'b' AND es.action_choice = 'markov'
                    UNION ALL
                    SELECT
                    COUNT(*)
                    FROM evaluated_story es
                    WHERE es.rating = 'b' AND es.action_choice = 'cm'
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='b' AND es.allow_doppelgangers  = 0
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='b' AND es.allow_doppelgangers  = 1
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='b' AND es.respect_death  = 0
                    UNION ALL
                    SELECT COUNT(*) FROM evaluated_story es WHERE es.rating='b' AND es.respect_death  = 1;";


 ?>
