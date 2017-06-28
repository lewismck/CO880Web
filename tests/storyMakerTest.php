<?php
/*
 *For including all tests of StoryMaker class
 *Includes the classes.php file for access to all the currently written classes
 *And the connect.php file for connecting to the db
 */

require_once ('../ajax/php/classes.php');
require_once ('../ajax/php/connect.php');

/*Some hastily written tests:*/
class StoryMakerTest extends PHPUnit_Framework_TestCase {

    //Check that a query with no results returns false
    public function testGetActionFalse(){
      $a = new StoryMaker;

      $falseQuery = "SELECT * FROM action WHERE ac_id=30;";
      $result = $a->getAction($falseQuery);

      $this->assertFalse($result);
    }

    //Check that the location object is created properly
    public function testGetLocationTrue(){
      $sm = new StoryMaker;

      $query = "SELECT * FROM location WHERE loc_id=6;";
      $loc = $sm->getLocation($query);

      $this->assertEquals($loc->name, "Owl Cave");
      $this->assertEquals($loc->id, 6);
    }

    //check the stats function returns 0's when checking for indexes that aren't in the action/event/location table
    function testStatsFalse(){
      $sm = new StoryMaker;

      $stats = $sm->getStoryStatistics("5 9 5", "99", "99"); //These aren't presently entries in the good_story table so should return a frequency of 0
      $this->assertEquals($stats['locFreq'], 0);
      $this->assertEquals($stats['acFreq'], 0);
      $this->assertEquals($stats['eventFreq'], 0);
    }
  }
?>
