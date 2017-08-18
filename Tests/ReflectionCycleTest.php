<?php
/**
 * @author Lewis Mckeown
 * Relies on proper functioning of StoryMaker class
 * Should run after StoryMakerTest.php
 **/
require_once ('./ajax/php/classes.php');
require_once ('./ajax/php/connect.php');


class RCTest extends PHPUnit_Framework_TestCase{

    public function testAcCM(){
      //StoryMaker for the ReflectionCycle constructor
      $sm = new StoryMaker();
      $rc = new ReflectionCycle($sm);

      //Make some Characters
      $char1 = $sm->makeCharacter();
      $char2 = $sm->makeCharacter();

      //Check both characters were created equal
      $this->assertEquals($char1->emotional_state, $char2->emotional_state);

      //Make char2 happier
      $char2->emotional_state = 1;


      $action = $rc->actionCycleCM($char1, $char2);

      //Check that the CM logic has picked an action to improve char1's mood
      $this->assertTrue($action->c1_es >= 1);
    }

    public function testGetAcByID(){
      $sm = new StoryMaker(); //StoryMaker for the ReflectionCycle constructor
      $rc = new ReflectionCycle($sm);

      //Make some Characters
      $char1 = $sm->makeCharacter();
      $char2 = $sm->makeCharacter();

      $action = $rc->getActionByID(14, $char1, $char2);

      $this->assertEquals($action->id, 14);
    }

    public function testGetEvByID(){
      $sm = new StoryMaker(); //StoryMaker for the ReflectionCycle constructor
      $rc = new ReflectionCycle($sm);

      $event = $rc->getEventByID(14);

      $this->assertEquals($event->id, 14);
    }

    public function testGetLocByID(){
      //StoryMaker for the ReflectionCycle constructor
      $sm = new StoryMaker();
      $rc = new ReflectionCycle($sm);

      $location = $rc->getLocationByID(14);

      $this->assertEquals($location->id, 14);
    }
  }
?>
