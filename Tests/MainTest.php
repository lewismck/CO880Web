<?php
/**
 * @author Lewis Mckeown
 * Test the core functionality of the Main class
 **/
require_once ('./ajax/php/classes.php');
require_once ('./ajax/php/connect.php');


class MainTest extends PHPUnit_Framework_TestCase{

    public function testSetup(){
      $main = new Main();

      //Run the setup function to get it's data from the KB
      $setupData = $main->setup();

      //Use the global queries from queries.php
      global $KBQuery;


      $KBData = executeQuery($KBQuery);
      //Good story data
      $event_seq_kb = $KBData[0]['event_seq'];
      $event_seq_setup = $setupData->event_seq;

      //Check the KB and setup return the same data
      $this->assertEquals($event_seq_kb, $event_seq_setup);
    }

    public function testParseParams(){
      $main = new Main();
      //Make some test params
      $testParams = ['func' => 'test'];

      $parsedParams = $main->parseParams($testParams);

      $this->assertEquals($parsedParams->func, 'test');
    }

    public function testKBDataToArray(){
      $main = new Main();

      $testKBData = '1,2,2,3';
      $returnedArray = $main->turnKBDataToArray($testKBData);

      //Check the returned frequencies are all correct
      $this->assertEquals($returnedArray['2'], 2);
      $this->assertEquals($returnedArray['1'], 1);
      $this->assertEquals($returnedArray['3'], 1);

    }
  }
?>
