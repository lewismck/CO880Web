<?php
/*
 *For including all tests of Person methods
 *Includes the classes.php file for access to all the currently written classes
 */
//use phpunit\framework\TestCase;
require_once ('./php/classes.php');
require_once ('./php/connect.php');


/*Test methods in person class - not a huge number of methods to test*/
class PersonTest extends PHPUnit_Framework_TestCase{

    public function testKill(){
        // Arrange
        $a = new Person('1', 'Test', 'Tester', 'm', '1', '33', 'Test String');

        // Act
        $a->kill();

        // Assert
        $this->assertFalse($a->isAlive);
    }

    public function testID(){
      $a = new Person('1', 'Test', 'Tester', 'm', '1', '33', 'Test String');
      $this->assertEquals($a->id, '1');
   }

   public function testDescribe(){
     $a = new Person('1', 'Test', 'Tester', 'm', '1', '33', 'Test String');

     $this->assertEquals($a->describe(), "Name: " . $a->firstname . " " . $a->lastname . "<br>"
            ."Age: ". $a->age ."<br>Gender: " . $a->gender . "<br>"
            ."Description: ". $a->temperment."<br>");

   }
  }
?>
