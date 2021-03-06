/**
 * @author Lewis Mckeown
 **/
/*-------------------------------
  Generate the charts comparing
  the evaluated story data and
  put them in the labelled
  canvases in stats.php
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
  ,"datasets":[{"label":"Positively Evaluated"
  ,"data":[gsd.markov_event
    ,gsd.random_event
    ,gsd.markov_action
    ,gsd.cm_action
    ,gsd.random_action
    ,gsd.random_location
    ,gsd.markov_location]
  ,"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}
  ,{"label":"Negatively Evaluated"
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
  ,"datasets":[{"label":"Positively Evaluated"
  ,"data":[gsd.no_doppelgangers
    ,gsd.ignore_death
    ,gsd.allow_doppelgangers
    ,gsd.respect_death]
  ,"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}
  ,{"label":"Negatively Evaluated"
  ,"data":[bsd.no_doppelgangers
    ,bsd.ignore_death
    ,bsd.allow_doppelgangers
    ,bsd.respect_death]
  ,"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff"}]}});



  /*------------------------
    AVG creativity ratings
   ------------------------*/
   new Chart(
     document.getElementById("avg-creativity-chart")
     ,{"type":"line"
     ,"data":{"labels":["Unconstrained","Moderately Constrained (set 1)","Moderately Constrained (set 2)","Tightly Constrained"]
     ,"datasets":[{"label":"Average Creativity Ratings","data": avgCreativity
     ,"fill":false
     ,"borderColor":"rgb(75, 192, 192)"
     ,"lineTension":0.1}]}
     //,"options":{"scales":{"yAxes":[{"ticks":{"suggestedMin":-2, "suggestedMax":2}}]
    //}}
   });

   /*------------------------
     Like to Dislike chart
    ------------------------*/
   new Chart(
     document.getElementById("like-dislike-chart")
     ,{"type":"bar"
     ,"data":{"labels":["Liked","Not Liked"]
     ,"datasets":[{"label":"Unconstrained"
      ,"data":[likeToDislike[1], likeToDislike[0]]
      ,"fill":false,"backgroundColor":["rgba(246, 114, 128, 0.2)","rgba(246, 114, 128, 0.2)"] //rgb(249, 196, 172) rgba(255, 99, 132, 0.2)
      ,"borderColor":["rgb(246, 114, 128)","rgb(246, 114, 128)"]
      ,"borderWidth":1}
      ,{"label":"Moderately Constrained (set 1)"
      ,"data":[likeToDislike[3], likeToDislike[2]]
      ,"fill":false,"backgroundColor":["rgba(192, 108, 132, 0.2)","rgba(192, 108, 132, 0.2)"] //rgba(255, 159, 64, 0.2)
      ,"borderColor":["rgb(192, 108, 132)","rgb(192, 108, 132)"]
      ,"borderWidth":1}
      ,{"label":"Moderately Constrained (set 2)"
      ,"data":[likeToDislike[5], likeToDislike[4]]
      ,"fill":false,"backgroundColor":["rgba(108, 91, 123, 0.2)","rgba(108, 91, 123, 0.2)"] //rgba(199, 189, 132, 0.2)
      ,"borderColor":["rgb(108, 91, 123)","rgb(108, 91, 123)"]
      ,"borderWidth":1}
      ,{"label":"Tightly Constrained"
      ,"data":[likeToDislike[7], likeToDislike[6]]
      ,"fill":false,"backgroundColor":["rgba(53, 92, 125, 0.2)","rgba(53, 92, 125, 0.2)"] //rgba(67, 99, 132, 0.2)
      ,"borderColor":["rgb(53, 92, 125)","rgb(53, 92, 125)"]
      ,"borderWidth":1}
      ]
    }
      ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}
    });

    /*-----------------------------
      Like to Dislike Totals chart
     -----------------------------*/
    new Chart(
      document.getElementById("like-dislike-total-chart")
        ,{"type":"bar"
        ,"data":{"labels":["Liked", "Not Liked"]
        ,"datasets":[{"label":"Liked and Not Liked"
        ,"data":[likeToDislike[8], likeToDislike[9]]
        ,"fill":false,"backgroundColor":[good_story_colour, bad_story_colour] //rgb(249, 196, 172) rgba(255, 99, 132, 0.2)
        ,"borderColor":[good_story_border_colour, bad_story_border_colour]
        ,"borderWidth":1}

       ]
     }
       ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}
     });

     /*-----------------------------------
       Creative/NotCreative/Neutral chart
      -----------------------------------*/
     new Chart(
       document.getElementById("cnc-chart")
         ,{"type":"bar"
         ,"data":{"labels":["Creative", "Not Creative", "Neutral"]
         ,"datasets":[{"label":["Creative", "Not Creative", "Neutral"]
         ,"data":[cnc[0], cnc[1], cnc[2]]
         ,"fill":false,"backgroundColor":[good_story_colour, bad_story_colour, "rgba(113, 115, 117, 0.2)"] //rgb(249, 196, 172) rgba(255, 99, 132, 0.2)
         ,"borderColor":[good_story_border_colour, bad_story_border_colour, "rgb(113, 115, 117)"]
         ,"borderWidth":1}

        ]
      }
        ,"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}
      });


  /*-------------------------------
    Deprecated charts stuff
    These are no longer populated
    or used in the stats page
   -------------------------------*/
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
