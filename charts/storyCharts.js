/**
 * @author Lewis Mckeown
 **/
/*-------------------------------
  Generate the charts comparing
  the evaluated story data and
  put them in the labelled
  canvases
 -------------------------------*/
function generateCharts(){
  /*Fill an array with enough colour entries for every x tick on the charts*/
  var good_story_colour = "rgba(54, 162, 235, 0.2)"; //blue
  var good_story_border_colour = "rgb(54, 162, 235)";
  var bad_story_colour = "rgba(255, 99, 132, 0.2)"; //red
  var bad_story_border_colour = "rgb(255, 99, 132)";
  var gs_c = [];
  var gs_bc = [];
  var bs_c = [];
  var bs_bc = [];
  for(i = 0; i < ac_labels.length; i++){ //assumes actions is largest table...
    gs_c.push(good_story_colour);
    gs_bc.push(good_story_border_colour);
    bs_c.push(bad_story_colour);
    bs_bc.push(bad_story_border_colour);
  }

  /*----------------------------
    Good/Bad Radar Comparison 1
   ----------------------------*/
  new Chart(
  document.getElementById("comparison-story-chart")
  ,{"type":"radar","data":{"labels":["Markov Event"
    ,"Random Event"
    ,"Markov Action"
    ,"Character Motivation Action"
    ,"Random Action"
    , "Random Location"
    , "Markov Location"]
  ,"datasets":[{"label":"Good Story Data"
  ,"data":[gsd.markov_event
    ,gsd.random_event
    ,gsd.markov_action
    ,gsd.cm_action
    ,gsd.random_action
    ,gsd.random_location
    ,gsd.markov_location]
  ,"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}
  ,{"label":"Bad Story Data"
  ,"data":[bsd.markov_event
    ,bsd.random_event
    ,bsd.markov_action
    ,bsd.cm_action
    ,bsd.random_action
    ,bsd.random_location
    ,bsd.markov_location]
  ,"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}
    ]}});

  /*----------------------------
    Good/Bad Radar Comparison 2
   ----------------------------*/
  new Chart(
  document.getElementById("comparison-story-chart-2")
  ,{"type":"radar","data":{"labels":["No Doppelgangers"
    ,"Ignore Death"
    ,"Allow Doppelgangers"
    ,"Respect Death"]
  ,"datasets":[{"label":"Good Story Data"
  ,"data":[gsd.no_doppelgangers
    ,gsd.ignore_death
    ,gsd.allow_doppelgangers
    ,gsd.respect_death]
  ,"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}
  ,{"label":"Bad Story Data"
  ,"data":[bsd.no_doppelgangers
    ,bsd.ignore_death
    ,bsd.allow_doppelgangers
    ,bsd.respect_death]
  ,"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}]}});

  /*------------------------
    Action Frequency Chart
   ------------------------*/
  /*Get the data and components in the right order*/
  var ac_gs_data = [];
  var ac_bs_data = [];
  for(i = 0; i < ac_labels.length; i++){
    ac_gs_data.push(sortedActions[ac_values[i]]);
    ac_bs_data.push(sortedBadActions[ac_values[i]]);
  }
  /*Build the chart*/
  new Chart(document.getElementById("action_frequency_chart")
  ,{"type":"bar"
  ,"data":{"labels":ac_labels
  ,"datasets":[{"label":"Good Story Data"
  ,"data":ac_gs_data
    ,"fill":false
    ,"backgroundColor":gs_c
    ,"borderColor":gs_bc
    ,"borderWidth":1}
    ,{"label":"Bad Story Data"
  ,"data": ac_bs_data
  ,"fill":false
  ,"backgroundColor":bs_c
  ,"borderColor":bs_bc
  ,"borderWidth":1}]}
  ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]
    ,"xAxes":[{"ticks":{"display":false}}]
    }}
  });

  /*------------------------
    Event Frequency Chart
   ------------------------*/
   /*Get the data and components in the right order*/
   var ev_gs_data = [];
   var ev_bs_data = [];
   for(i = 0; i < ev_labels.length; i++){
     ev_gs_data.push(sortedEvents[ev_values[i]]);
     ev_bs_data.push(sortedBadEvents[ev_values[i]]);
   }
   /*Build the chart*/
  new Chart(document.getElementById("event_frequency_chart")
  ,{"type":"bar"
  ,"data":{"labels":ev_labels
  ,"datasets":[{"label":"Good Story Data"
  ,"data": ev_gs_data
    ,"fill":false
    ,"backgroundColor":gs_c
    ,"borderColor":gs_bc
    ,"borderWidth":1}
    ,{"label":"Bad Story Data"
  ,"data": ev_bs_data
  ,"fill":false
  ,"backgroundColor":bs_c
  ,"borderColor":bs_bc
  ,"borderWidth":1}]}
    ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]
    ,"xAxes":[{"ticks":{"display":false}}]
  }}
  });

  /*------------------------
    Location Frequency Chart
   ------------------------*/
   /*Get the data and components in the right order*/
   var loc_gs_data = [];
   var loc_bs_data = [];
   for(i = 0; i < loc_labels.length; i++){
     loc_gs_data.push(sortedLocations[loc_values[i]]);
     loc_bs_data.push(sortedBadLocations[loc_values[i]]);
   }
   /*Build the chart*/
  new Chart(document.getElementById("location_frequency_chart")
  ,{"type":"bar"
  ,"data":{"labels":loc_labels,"datasets":[{"label":"Good Story Data"
  ,"data":loc_gs_data
    ,"fill":false
    ,"backgroundColor":gs_c
    ,"borderColor":gs_bc
    ,"borderWidth":1}
    ,{"label":"Bad Story Data"
  ,"data":loc_bs_data
  ,"fill":false
  ,"backgroundColor":bs_c
  ,"borderColor":bs_bc
  ,"borderWidth":1}]}
    ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]
    ,"xAxes":[{"ticks":{"display":false}}]
  }}
  });

}
/*---------------------------
  Deprecated chartJS stuff
 ---------------------------*/
