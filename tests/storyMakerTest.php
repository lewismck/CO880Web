<?php
/**
 * @author Lewis Mckeown
 * Test some of the key functionality of the StoryMaker class
 **/
//Relative to the directory you're running the tests from
require_once ('./ajax/php/classes.php');
require_once ('./ajax/php/connect.php');


class SMTest extends PHPUnit_Framework_TestCase{

    public function testCharWhoIsnt(){

      $sm = new StoryMaker();

      //Make some Characters
      $char1 = $sm->makeCharacter();
      $char2 = $sm->getCharacterWhoIsnt($char1->id);

      $this->assertFalse($char1->id === $char2->id);

    }

    public function testCharEs(){
      $sm = new StoryMaker();

      //Make some Characters
      $char1 = $sm->makeCharacter();
      $char2 = $sm->makeCharacter();

      $this->assertEquals($char1->emotional_state, $char2->emotional_state);
    }

    public function testCheckExitsts(){
      $sm = new StoryMaker();

      $bool = $sm->checkExists('event', 12);

      $this->assertTrue($bool);
    }

    public function testGetCharByID(){
      $sm = new StoryMaker();

      $char1 = $sm->getCharacterByID(2);

      $this->assertEquals($char1->id, 2);
    }
  }
?>
