
function createNewStoryChart(){


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
  ,"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)"}
    ]}});

    /*----------------------------
      Good/Bad Radar Comparison 2
     ----------------------------*/
    new Chart(
    document.getElementById("comparison-story-chart-2")
    ,{"type":"radar","data":{"labels":["No Doppelgangers"
      ,"Allow Doppelgangers"
      ,"Ignore Death"
      ,"Respect Death"]
    ,"datasets":[{"label":"Good Story Data"
    ,"data":[gsd.no_doppelgangers
      ,gsd.allow_doppelgangers
      ,gsd.ignore_death
      ,gsd.respect_death]
    ,"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}
    ,{"label":"Bad Story Data"
    ,"data":[bsd.no_doppelgangers
      ,bsd.allow_doppelgangers
      ,bsd.ignore_death
      ,bsd.respect_death]
    ,"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)"}]}});

    // new Chart(
    //   document.getElementById("good-story-constraints")
    // ,{"type":"doughnut"
    // ,"data":{"labels":["No Doppelgangers"
    //   ,"Allow Doppelgangers"
    //   ,"Ignore Death"
    //   ,"Respect Death"]
    // ,"datasets":[{"label":"Good Story Constraints"
    // ,"data":[gsd.no_doppelgangers
    //   ,gsd.allow_doppelgangers
    //   ,gsd.ignore_death
    //   ,gsd.respect_death]
    // ,"backgroundColor":["rgb(255, 99, 132)"
    //   ,"rgb(54, 162, 235)"
    //   ,"rgb(255, 205, 86)"
    //   ,"rgb(255, 59, 102)"]}]}});
    //
    //
    //   new Chart(
    //   document.getElementById("bad-story-constraints")
    //   ,{"type":"doughnut","data":{"labels":["No Doppelgangers"
    //     ,"Allow Doppelgangers"
    //     ,"Ignore Death"
    //     ,"Respect Death"]
    //   ,"datasets":[{"label":"Good Story Constraints"
    //   ,"data":[bsd.no_doppelgangers
    //     ,bsd.allow_doppelgangers
    //     ,bsd.ignore_death
    //     ,bsd.respect_death]
    //   ,"backgroundColor":["rgb(255, 99, 132)"
    //     ,"rgb(54, 162, 235)"
    //     ,"rgb(255, 205, 86)"
    //     ,"rgb(255, 59, 102)"]}]}});

      /*------------------------
        Action Frequency Chart
       ------------------------*/
      new Chart(document.getElementById("action_frequency_chart")
      ,{"type":"bar"
      ,"data":{"labels":[ac_labels[0]
        ,ac_labels[1]
        ,ac_labels[2]
        ,ac_labels[3]
        ,ac_labels[4]
        ,ac_labels[5]
        ,ac_labels[6]
        ,ac_labels[7]
        ,ac_labels[8]
        ,ac_labels[9]
        ,ac_labels[10]
        ,ac_labels[11]
        ,ac_labels[12]
        ,ac_labels[13]],"datasets":[{"label":"Good Story Data"
      ,"data":[sortedActions[ac_values[0]]
        ,sortedActions[ac_values[1]]
        ,sortedActions[ac_values[2]]
        ,sortedActions[ac_values[3]]
        ,sortedActions[ac_values[4]]
        ,sortedActions[ac_values[5]]
        ,sortedActions[ac_values[6]]
        ,sortedActions[ac_values[7]]
        ,sortedActions[ac_values[8]]
        ,sortedActions[ac_values[9]]
        ,sortedActions[ac_values[10]]
        ,sortedActions[ac_values[11]]
        ,sortedActions[ac_values[12]]
        ,sortedActions[ac_values[13]]]
      ,"fill":false
      ,"backgroundColor":["rgba(54, 162, 235, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],"borderColor":["rgb(54, 162, 235)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"]
      ,"borderWidth":1}
      ,{"label":"Bad Story Data"
    ,"data":[sortedBadActions[ac_values[0]]
      ,sortedBadActions[ac_values[1]]
      ,sortedBadActions[ac_values[2]]
      ,sortedBadActions[ac_values[3]]
      ,sortedBadActions[ac_values[4]]
      ,sortedBadActions[ac_values[5]]
      ,sortedBadActions[ac_values[6]]
      ,sortedBadActions[ac_values[7]]
      ,sortedBadActions[ac_values[8]]
      ,sortedBadActions[ac_values[9]]
      ,sortedBadActions[ac_values[10]]
      ,sortedBadActions[ac_values[11]]
      ,sortedBadActions[ac_values[12]]
      ,sortedBadActions[ac_values[13]]]
    ,"fill":false
    ,"backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],"borderColor":["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"]
    ,"borderWidth":1}]}
    ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]
      ,"xAxes":[{"ticks":{"display":false}}]
      }}
    });

    /*------------------------
      Event Frequency Chart
     ------------------------*/
    new Chart(document.getElementById("event_frequency_chart")
    ,{"type":"bar"
    ,"data":{"labels":[ev_labels[0]
      ,ev_labels[1]
      ,ev_labels[2]
      ,ev_labels[3]
      ,ev_labels[4]
      ,ev_labels[5]
      ,ev_labels[6]],"datasets":[{"label":"Good Story Data"
    ,"data":[sortedEvents[ev_values[0]]
      ,sortedEvents[ev_values[1]]
      ,sortedEvents[ev_values[2]]
      ,sortedEvents[ev_values[3]]
      ,sortedEvents[ev_values[4]]
      ,sortedEvents[ev_values[5]]
      ,sortedEvents[ev_values[6]]
      ]
    ,"fill":false
    ,"backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],"borderColor":["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"]
    ,"borderWidth":1}
    ,{"label":"Bad Story Data"
  ,"data":[sortedBadEvents[ev_values[0]]
    ,sortedBadEvents[ev_values[1]]
    ,sortedBadEvents[ev_values[2]]
    ,sortedBadEvents[ev_values[3]]
    ,sortedBadEvents[ev_values[4]]
    ,sortedBadEvents[ev_values[5]]
    ,sortedBadEvents[ev_values[6]]]
  ,"fill":false
  ,"backgroundColor":["rgba(54, 162, 235, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],"borderColor":["rgb(54, 162, 235, 0.2)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"]
  ,"borderWidth":1}]}
    ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]
    ,"xAxes":[{"ticks":{"display":false}}]
  }}
  });

  /*------------------------
    Location Frequency Chart
   ------------------------*/
  new Chart(document.getElementById("location_frequency_chart")
  ,{"type":"bar"
  ,"data":{"labels":[loc_labels[0]
    ,loc_labels[1]
    ,loc_labels[2]
    ,loc_labels[3]
    ,loc_labels[4]
    ,loc_labels[5]
    ,loc_labels[6]
    ,loc_labels[7]
    ,loc_labels[8]],"datasets":[{"label":"Good Story Data"
  ,"data":[sortedLocations[loc_values[0]]
    ,sortedLocations[loc_values[1]]
    ,sortedLocations[loc_values[2]]
    ,sortedLocations[loc_values[3]]
    ,sortedLocations[loc_values[4]]
    ,sortedLocations[loc_values[5]]
    ,sortedLocations[loc_values[6]]
    ,sortedLocations[loc_values[7]]
    ,sortedLocations[loc_values[8]]
    ]
    ,"fill":false
    ,"backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],"borderColor":["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"]
    ,"borderWidth":1}
    ,{"label":"Bad Story Data"
  ,"data":[sortedBadLocations[loc_values[0]]
    ,sortedBadLocations[loc_values[1]]
    ,sortedBadLocations[loc_values[2]]
    ,sortedBadLocations[loc_values[3]]
    ,sortedBadLocations[loc_values[4]]
    ,sortedBadLocations[loc_values[5]]
    ,sortedBadLocations[loc_values[6]]
    ,sortedBadLocations[loc_values[7]]
    ,sortedBadLocations[loc_values[8]]
  ]
  ,"fill":false
  ,"backgroundColor":["rgba(54, 162, 235, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],"borderColor":["rgb(54, 162, 235, 0.2)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"]
  ,"borderWidth":1}]}
    ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]
    ,"xAxes":[{"ticks":{"display":false}}]
  }}
  });

}
/*---------------------------
  Deprecated chartJS stuff
 ---------------------------*/
// //Good story doughnut
// new Chart(
// document.getElementById("good-story-chart")
// ,{"type":"doughnut","data":{"labels":["Markov Event"
//   ,"Random Event"
//   ,"Markov Action"
//   ,"Character Motivation Action"
//   ,"Random Action"
//   , "Random Location"
//   , "Markov Location"]
// ,"datasets":[{"label":"Good Story Data"
// ,"data":[gsd.markov_event
//   ,gsd.random_event
//   ,gsd.markov_action
//   ,gsd.cm_action
//   ,gsd.random_action
//   ,gsd.random_location
//   ,gsd.markov_location]
// ,"backgroundColor":["rgb(255, 99, 132)"
//   ,"rgb(54, 162, 235)"
//   ,"rgb(255, 205, 86)"
//   ,"rgb(255, 59, 102)"
//   ,"rgb(255, 204, 132)"
//   , "rgb(255, 100, 90)"]}]}});

// new Chart(
//   document.getElementById("good-story-constraints")
// ,{"type":"doughnut"
// ,"data":{"labels":["No Doppelgangers"
//   ,"Allow Doppelgangers"
//   ,"Ignore Death"
//   ,"Respect Death"]
// ,"datasets":[{"label":"Good Story Constraints"
// ,"data":[gsd.no_doppelgangers
//   ,gsd.allow_doppelgangers
//   ,gsd.ignore_death
//   ,gsd.respect_death]
// ,"backgroundColor":["rgb(255, 99, 132)"
//   ,"rgb(54, 162, 235)"
//   ,"rgb(255, 205, 86)"
//   ,"rgb(255, 59, 102)"]}]}});
//
//
//   new Chart(
//   document.getElementById("bad-story-constraints")
//   ,{"type":"doughnut","data":{"labels":["No Doppelgangers"
//     ,"Allow Doppelgangers"
//     ,"Ignore Death"
//     ,"Respect Death"]
//   ,"datasets":[{"label":"Good Story Constraints"
//   ,"data":[bsd.no_doppelgangers
//     ,bsd.allow_doppelgangers
//     ,bsd.ignore_death
//     ,bsd.respect_death]
//   ,"backgroundColor":["rgb(255, 99, 132)"
//     ,"rgb(54, 162, 235)"
//     ,"rgb(255, 205, 86)"
//     ,"rgb(255, 59, 102)"]}]}});

// new Chart(document.getElementById("chartjs-3"),{"type":"radar","data":{"labels":["Eating","Drinking","Sleeping","Designing","Coding","Cycling","Running"],"datasets":[{"label":"My First Dataset","data":[65,59,90,81,56,55,40],"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBackgroundColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(255, 99, 132)"},{"label":"My Second Dataset","data":[28,48,40,19,96,27,100],"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(54, 162, 235)"}]},"options":{"elements":{"line":{"tension":0,"borderWidth":3}}}});
