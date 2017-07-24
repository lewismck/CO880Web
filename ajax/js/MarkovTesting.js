function makeNgrams(src, n){
  //var txt = "56666535555656665663555996536665";
  //var order = 1;
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
  $("#resultBox").append(result+"<br>");
  return result;
}

/*AJAX*/
/*
 *
 *
 */
 function eventCycle(eventSequence, cycleCount){
   $("#test1").html("<h3>Evaluating</h3>");
   $.ajax({
     type: "GET",
     url: "event_cycle.php?seq="+eventSequence+"&cycleCount="+cycleCount,
     dataType: "html",
     success: function(response){
           $("#test1").html(response);
     }
   });
 }
// function runMe(){
//   for (var i = 0; i < txt.length-order; i++){
//     var gram = txt.substring(i, i + order);
//     ngrams.push(gram);
//   }
//   console.log(ngrams);
// }
