/*Mostly AJAX functions which call getstory.php or are called during getstory.php's operation*/

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
