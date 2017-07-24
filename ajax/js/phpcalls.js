/*Mostly AJAX functions which call getstory.php or are called during getstory.php's operation*/
  //var locArray = [];
/*
 * Calls a php script that returns a randomly generated story outline.
 * kb parameter to potentially be used as a flag to indicate whether to
 * generate using information from the knowledge base rather
 * than randomly chosen components
 */
function generateStory(kb) {
  $("#storyBox").html("<h3><strong>Generating...</strong></h3>");
  //var charcount = $("#charcount").val();
    $.ajax({
      type: "GET",
      url: "ajax/php/getstory.php?kb="+kb,
      dataType: "html",
      success: function(response){
            $("#storyBox").html(response);
      }
    });
}
/*
 * Call the setup section in main.php to get the KB returned as variables
 *
 */
function mainSetup() {
  //var func = $("#functionCall").val();
  //$("#storyBox").html("<h3><strong>Testing...</strong></h3>");
  //var charcount = $("#charcount").val();
    $.ajax({
      type: "GET",
      url: "ajax/php/main.php?func=setup",
      dataType: "html",
      success: function(response){
            $("#storyParams").html(response);
      }
    });
}

/*
 * TODO Hardcoded value getting from inputs now - will make function accept parameters later
 * Call the setup section in main.php to get the KB returned as variables
 * @param ev_seq
 * @param ac_seq
 * @param ev_cycle
 * @param ac_cycle
 * @param loc_cycle
 * @param respect_death
 * @param no_dop
 * @param use_cm //TODO implement in parseParams
 * @return
 */
function getStory() {
  var ev_cycle_count = ($("#ev_cycle_count").val()*1)+2;//Add n to the cycle count to ensure that enough IDs are returned
  var ev_seed = $("#ev_seed").val();
  var loc_cycle_count = ($("#loc_cycle_count").val()*1)+2;//Add n to the cycle count to ensure that enough IDs are returned
  var loc_seed = $("#loc_seed").val();
  var ac_cycle_count = $("#ac_cycle_count").val();
  var no_dop = $("#no_dop").val();
  var rd = $("#rd").val();
  //Build Markov chains of the requested story components
  /*Event*/
  var ev_n_grams = makeNgrams(ev_seq_kb, 2);
  var ev_seq = markovIt(ev_seed, ev_n_grams, 2, ev_cycle_count);
  /*Location*/
  var loc_n_grams = makeNgrams(loc_seq_kb, 2);
  var loc_seq = markovIt(loc_seed, loc_n_grams, 2, loc_cycle_count);
  //$("#storyBox").html("<h3><strong>Testing...</strong></h3>");
  //var charcount = $("#charcount").val();
    $.ajax({
      type: "GET",
      url: "ajax/php/main.php?func=getStory&ev_seq="+ev_seq+"&ev_cycle_count="+ev_cycle_count+"&ac_cycle_count="+ac_cycle_count+"&no_dop="+no_dop+"&rd="+rd+"&loc_cycle_count="+loc_cycle_count+"&loc_seq="+loc_seq,
      dataType: "html",
      success: function(response){
            $("#storyBox").html(response);
            makeOutLine($("#loc_cycle_count").val());
      }
    });
}

function makeOutLine(n){
  for(var i = 0; i <= n; i++){
      $("#outlineBox").append(locArray[i].brief+"<br>");
  }
}

/**
  * exists in the KB and can be used for processing
  * MARKOV and N-Gram code
  * Function to make N-Grams of a string returns arrays
  * Function to generate an n length sequence given a set of N-Grams
  **/
 function makeNgrams(src, n){
   var ngrams = {};

   for (var i = 0; i <= src.length-n; i++){
     var gram = src.substring(i, i+n);
     if(!ngrams[gram]){
       ngrams[gram] = [];
     }
     ngrams[gram].push(src.charAt(i+n));
   }
   console.log(ngrams);
   return ngrams;
 }

 function markovIt(seed, ngrams, n, limit){
   var currentGram = seed;
   var result = currentGram;

   //Include check for when exceeding length of txt
   for(var i = 0; i < limit; i++){
     var possibilities = ngrams[currentGram];
     //console.log(possibilities);
     var next = possibilities[Math.floor(Math.random() * possibilities.length)];
     result += next;
     var len = result.length;
     currentGram = result.substring(len-n, len);
     //console.log(result);
   }
   console.log(result);
   //$("#resultBox").append(result+"<br>");
   return result;
 }

/*
 * Print text to the outlineBox div
 * Highlight in RED if duplicate
 * Recieves a string of html formatted text: outline
 * a flag to indicate if a story is a duplicate and so to
 * display it in a red box
 */
function printOutline(outline, dupe){
  if(dupe == 0){
    $("#outlineBox").html("<h3>outline</h3>"+outline);
  }
  if(dupe == 1){
    $("#outlineBox").html("<h3>Outline</h3><br><p class='bg-danger'>Duplicate story: "+outline+"</p>");
  }
}

/*
 * Calls a php script that returns a list of facts about the
 * good stories in the knowledge base
 * Should be called when a new story is evaluated to keep data up to date.
 */
function getData() {
  $("#dataBox").html("<h3><strong>Getting Info...</strong></h3>");
  //var charcount = $("#charcount").val();
    $.ajax({
      type: "GET",
      url: "ajax/php/storydata.php",
      dataType: "html",
      success: function(response){
            $("#dataBox").html(response);
      }
    });
}

/*
 * Calls the evaluatestory.php script giving the story parameters and
 * a rating flag ('g' or 'b')
 */
function evaluateStory(eventSequence, locationSequence, actionSequence, rating){
  $("#evaluateBox").html("<h3>Evaluating</h3>");
  $.ajax({
    type: "GET",
    url: "ajax/php/evaluatestory.php?r="+rating+"&event="+eventSequence+"&loc="+locationSequence+"&action="+actionSequence,
    dataType: "html",
    success: function(response){
          $("#evaluateBox").html(response);
    }
  });
}

 /*
  * Show the details of a selected action/event/location/character
  * Recieves:
  * a php object converted to a JSON object: storyObj.
  * an ID to select which div to put the details in: id
  * an object type flag to identify which case to use: type //if statements now
  */
  function showDetails(storyObj, id, type){
    //output for action
    if(type == "a"){
      if($('#actionInfo'+id).html() == ""){
          $('#actionInfo'+id).html("Tone: "+storyObj.tone+"<br>"); //get the type right because of object specific method/attribute calls
        }
        else{$('#actionInfo'+id).html("");}
      }
      //handle character
      if(type == "c"){
        if($('#characterInfo'+id).html() == ""){
           $('#characterInfo'+id).html("Age: "+storyObj.age+"<br>Description: "+storyObj.temperment+"<br>");
         }
         else{$('#characterInfo'+id).html("");}
      }
      //handle event
      if(type == 'e'){
        if($('#eventInfo'+id).html() == ""){
           $('#eventInfo'+id).html("Description: "+storyObj.longDesc+"<br>Tone: "+storyObj.tone+"<br>");
         }
         else{$('#eventInfo'+id).html("");}
      }
      //handle location
      if(type == "l"){
        if($('#locationInfo'+id).html() == ""){
            $('#locationInfo'+id).html("Description: "+storyObj.longDesc+"<br>");
          }
        else{$('#locationInfo'+id).html("");}
      }
  }
