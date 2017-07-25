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
  //var charcount = $("#charcount").val();
    $.ajax({
      type: "GET",
      url: "ajax/php/main.php?func=getStory&ev_seq="+ev_seq+"&ev_cycle_count="+$("#ev_cycle_count").val()+"&ac_cycle_count="+ac_cycle_count+"&no_dop="+no_dop+"&rd="+rd+"&loc_cycle_count="+$("#loc_cycle_count").val()+"&loc_seq="+loc_seq,
      dataType: "html",
      success: function(response){
            $("#storyBox").html(response);
            printOutline2();
            //printActionCycle();
            printLocations($("#loc_cycle_count").val()-1);
            $('[data-toggle="tooltip"]').tooltip();
      }
    });
}


/*
 * Print an outline of the story
 */
function printOutline2(){
  var shortestCycle = '';
  var shortestCycleCount = Math.min(locArray.length, actionArray.length, eventArray.length);
  if (shortestCycleCount = locArray.length){
    shortestCycle = 'loc';
  }
  else if (shortestCycleCount = actionArray.length) {
    shortestCycle = 'action';
  }
  else {
    shortestCycle = 'event';
  }

  $("#outlineBox").html(''); //clear the outline box

  for(i = 0; i <= shortestCycleCount-1; i++){
    //Split the characters emotional states up into an array to display alongside each action
    var c1_es_array = char1.arc_desc.split(",");
    var c2_es_array = char2.arc_desc.split(",");
    //Assign some character variables for showing their data
    var char1Info = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+char1.temperment+" Mood: "+c1_es_array[i+1]+"'>"+char1.firstname+"</a>";
    var char2Info = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+char2.temperment+" Mood: "+c2_es_array[i+1]+"'>"+char2.firstname+"</a>";
    //Assign action and consequence variables
    var actionInfo = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+actionArray[i].longDesc+"'>"+actionArray[i].brief+"</a>";
    var acConseqenceInfo = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+actionArray[i].conBrief+"'>"+actionArray[i].conBrief+"</a>";
    //Assign event and consequence variables
    var eventInfo = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+eventArray[i].longDesc+"'>"+eventArray[i].brief+"</a>";
    var evConseqenceInfo = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+eventArray[i].conBrief+"'>"+eventArray[i].conBrief+"</a>";
    //Locations
    locationInfo = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+locArray[i].brief+"'>"+locArray[i].name+"</a>";

    //Print the data linked together in order
    $("#outlineBox").append(eventInfo +" at " + locationInfo
    + " Meanwhile " + char1Info+ " "+actionInfo+" "+char2Info
    +".<br>"+char1Info+" "+acConseqenceInfo+" "+char2Info
    + ". As " + evConseqenceInfo + ".<br><br>");
      //event.brief + " at the " + loc.name + " Meanwhile " char1Info + " " + actionInfo + " " + char2Info + " " + conseqenceInfo + ". As " + event.conBrief

  }
  //if the shortestCycleCount is less than the longest then run the other attributes calling their printXcycle functions and providing an offset

}

/*
 * Display the generated action cycle to the user
 */
function printActionCycle(){
  var n = actionArray.length;//Check the actual length of the returned array in case respect death is toggled and a character died before the action cycle limit was reached
  //$("#outlineBox").html(''); //clear the outline box

  //Loop through the actions printing what happens
  for(var i = 0; i <= n-1; i++){
    //Split the characters emotional states up into an array to display alongside each action
    var c1_es_array = char1.arc_desc.split(",");
    var c2_es_array = char2.arc_desc.split(",");
    //Assign some character variables for showing their data
    var char1Info = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+char1.temperment+" Mood: "+c1_es_array[i+1]+"'>"+char1.firstname+"</a>";
    var char2Info = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+char2.temperment+" Mood: "+c2_es_array[i+1]+"'>"+char2.firstname+"</a>";
    //Assign action and consequence variables
    var actionInfo = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+actionArray[i].longDesc+"'>"+actionArray[i].brief+"</a>";
    var conseqenceInfo = "<a href='#' data-toggle='tooltip' data-placement='top' title='"+actionArray[i].conBrief+"'>"+actionArray[i].conBrief+"</a>";

    //Print the data linked together in order
    $("#outlineBox").append(char1Info+" "+actionInfo+" "+char2Info
    +". <br>So "+char1Info+" "+conseqenceInfo+" "+char2Info+".<br><br>");
  }
}

/*
 *
 */
function printLocations(n){
  //$("#outlineBox").html('');
  for(var i = 0; i <= n; i++){
      var currentLocation = new Object()
      currentLocation = locArray[i];
      locIdentifier = 'l';
      $("#outlineBox").append("<a href='#' data-toggle='tooltip' data-placement='top' title='"+currentLocation.brief+"'>"+currentLocation.name+"</a><br>");
      //"<a class='text-success' onclick='showDetails("+currentLocation+","+i+","+locIdentifier+");' style='cursor: pointer;'>"+currentLocation.name+"</a><br><br><div id='locationInfo"+i+"'></div>"
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
   }
   console.log(result);
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
