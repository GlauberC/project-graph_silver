function addPropClick(){
  $(".radioProp").prop("checked", false)
  $("div.prop-option").hide();
  $("button.btn-prop-save").addClass('disabled');
}
function propEquivalence(){
  $("button.btn-prop-save").removeClass('disabled');
  $("div#propMod").hide();
  $("div#propEqui").show();
  choice=0
}
function propModel(){
  $("button.btn-prop-save").removeClass('disabled');
  $("div#propEqui").hide();
  $("div#propMod").show();
  choice=1
}

function propertyPhp(){
  nVerifyList = 0
  getinputFromEdit();
  $("div.loaderParse").html("<div class='loader'></div>");

  // Getting the input from the user

  var txt = inputFromEdit;
  // The Ajax invocation
  var xhttp = new XMLHttpRequest();
  txt = "EXPLORE=>" + "FIRST" + '=>' + txt;
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          // When create_graph.php finishes, we can recover its output by using the responseText field
          // I used the content of create_graph.php to update the text "graph_txt"
          $("div#verifyPHP")[0].innerHTML = this.responseText;
      }
  };
  // Note that the URL is create_graph.php and I use "?txt" to send the needed parameter (the input from the user)
  xhttp.open("GET", "php/verify.php?txt=" + encodeURIComponent(txt), true);
  // Calling create_graph.php
  xhttp.send();
}

function savebtn(){
  var prop;
  if(choice == 0){

    // create a new element to verify table
    var process1 = $('.bissim-process1').val();
    var process2 = $('.bissim-process2').val();
    prop = $(".property-id").val();
    $('.verify-list').append("<tr class = 'element"+nVerifyList+"'><td class='status"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
    "<td class = 'time"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
    "<td>"+ prop +"</td>" +
    "<td class = 'verify"+nVerifyList+"' process1 = '"+process1+"' process2 = '"+process2+"'><span class='glyphicon glyphicon-play-circle btn btn-sm' onClick='verify_action("+ nVerifyList+", \"bissi\")'></span></td>" +
    "<td><span class='glyphicon glyphicon-pencil btn btn-sm'></span></td>" +
    "<td><span class='glyphicon glyphicon-trash btn btn-sm' onClick='verify_delete("+ nVerifyList+")'></span></td></tr>");
  }else if(choice == 1){
    console.log('Test');
    var processModel = $('.model-process').val();
    var formula = $('.formula-id').val();
    prop = $(".model-process-select").val() + "  =  " + $(".formula-id").val();
    $('.verify-list').append("<tr class = 'element"+nVerifyList+"'><td class='status"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
    "<td class = 'time"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
    "<td>"+ prop +"</td>" +
    "<td class = 'verify"+nVerifyList+"' processModel = '"+processModel+"' formula = '"+formula+"'><span class='glyphicon glyphicon-play-circle btn btn-sm' onClick='verify_action("+ nVerifyList+", \"model\")'></span></td>" +
    "<td><span class='glyphicon glyphicon-pencil btn btn-sm'></span></td>" +
    "<td><span class='glyphicon glyphicon-trash btn btn-sm' onClick='verify_delete("+ nVerifyList+")'></span></td></tr>");
  }
  nVerifyList++;
}

function verify_action_php(Command, classStatus, classTime){
  'Method get to boton verify'
  // The Ajax invocation

  $.ajax({
    type: "GET",
    data: { txt: Command },
    url: 'php/verify-action.php',
    success: function (request) {
      var request_array = request.split(';')
      var time = request_array[0]
      var bool_request = request_array[1]
      $(classStatus).html(bool_request);
      $(classTime).html(time);
    }
  });
}

function verify_action(n, func){
  var classStatus = '.status' + n
  var classTime = '.time' + n
  $(classTime).html("<div class='mini-loader'></div>");
  $(classStatus).html("<div class='mini-loader'></div>");

  if(func == "bissi"){
    process1 = $('.verify' + n).attr('process1');
    process2 = $('.verify' + n).attr('process2');
    var maude = "red in BISIMULATION : bisimilar? ({\'"+ process1 + "}, {\'"+ process2 + "} ,("+ inputFromEdit.replace(/;/ig,',') +")) .";
    verify_action_php(maude, classStatus, classTime);
  }else{
    model_option = "tt"
    processModel = $('.verify' + n).attr('processModel');
    formula = $('.verify' + n).attr('formula');
    formula = formula.replace(/([a-z]\w*)/ig, " \'$1 ");      //add ' before process
    var maude = "red in SLML_MC : modelCheck({\'"+ processModel + "},("+ inputFromEdit.replace(/;/ig,',') + "), << "+ formula +" >> "+ model_option +") .";
    // verify_action_php(maude, '.test');
    verify_action_php(maude, classStatus, classTime);
  }
}

function verify_delete(n){
  element_class = ".element" +n;
  $(element_class).remove()
}
