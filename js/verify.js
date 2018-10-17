var choice //in property menu
function addPropClick(n = null, typeProp='default'){
  $('.parse-model-check').hide();
  if(typeProp=='default'){
    $('.btn-prop-edit').hide()
    $('.btn-prop-save').show()
    $(".radio").show();
    $('.property-id').val('');
    $('.formula-id').val('');
    $(".radioProp").prop("checked", false)
    $("div.prop-option").hide();
    $("button.btn-prop-save").addClass('disabled');
  }else{
    $('.btn-prop-edit').show()
    $('.btn-prop-save').hide()
    $('.btn-prop-edit').attr('onClick', 'editbtn('+n+',\"'+typeProp+'\")');
    if(typeProp == 'model'){
      $(".radio").hide();
      $("#propBisim").hide();
      $("#propMod").show();
      choice = 1;
      var process_class = ".verify" + n;
      var proc = $(process_class).attr('processmodel');
      $('.model-process').val(proc);

      var prop_class = ".property-formula"+ n;
      var formula = $(prop_class).html();
      formula = formula.replace(/&nbsp;/ig,"");
      formula = formula.replace(/&lt;/ig, "<");
      formula = formula.replace(/&gt;/ig, ">");
      formula = formula.replace(/.+\|=/ig,"");
      $('.formula-id').val(formula);

    }else{
      $(".radio").hide();
      $("#propBisim").show();
      $("#propMod").hide();
      choice = 0;
      $('verify')
      var process_class = ".verify" + n;
      var proc1 = $(process_class).attr('process1');
      var proc2 = $(process_class).attr('process2');
      $('#leftp').val(proc1);
      $('#rightp').val(proc2);

      var prop_class = ".property-label"+ n;
      var prop = $(prop_class).html();
      $('.property-id').val(prop);

    }

  }

}
function editbtn(n, typeProp){
  var time_class = ".time" + n;
  var status_class = ".status" + n;
  var process_class = ".verify" + n;

  if (typeProp == 'bissi'){
    var proc1 = $('#leftp').val();
    var proc2 = $('#rightp').val();
    
    $(process_class).attr("process1", proc1);
    $(process_class).attr("process2", proc2);

    var prop_class = ".property-label"+ n;
    var prop_label = $('.property-id').val();
    $(prop_class).html(prop_label);
    $(status_class).html("<span class='glyphicon glyphicon-option-horizontal'></span>");
    $(time_class).html("<span class='glyphicon glyphicon-option-horizontal'></span>");
    get_verify_session();
    closeModal();

  }
  else if(typeProp == 'model'){
    var procModel = $('.model-process').val();
    $(process_class).attr("processmodel", procModel);

    var formula = $('.formula-id').val();
    var command = "parse " + formula_adjust(formula) + " .";
    var prop_class = ".property-formula"+ n;


    $.ajax({
      type: "GET",
      data: { txt: command },
      url: 'php/parse-model-check.php',
      success: function (request) {
        if(request.includes("Prop:")){
          prop = $(".model-process-select").val() + "&nbsp;&nbsp;|=&nbsp;&nbsp;" + $(".formula-id").val();
          $(status_class).html("<span class='glyphicon glyphicon-option-horizontal'></span>");
          $(time_class).html("<span class='glyphicon glyphicon-option-horizontal'></span>");
          $(prop_class).html(prop);
          get_verify_session();
          closeModal();
        }else{
          $('.parse-model-check').show()
          if(request.includes("bad token")){
            re = /bad\stoken.+/i;
            error = request.match(re) ;
            $('.parse-model-check').html("<div class='alert alert-danger'><strong>Syntax Error: </strong>"+ error +"</div>");
          }else if (request.includes("didn't expect token")) {
            re = /token.+/i;
            error = request.match(re);
            error = error[0].replace('\'', '');
            error = error.replace(':', '')
            $('.parse-model-check').html("<div class='alert alert-danger'><strong>Syntax Error: </strong> didn\'t expect "+ error +"</div>");
          }else{
            $('.parse-model-check').html("<div class='alert alert-danger'><strong>Error: </strong>Non valid expression</div>");
          }
        }
      }
    });
  }
}
function propBisimulation(){
  $("button.btn-prop-save").removeClass('disabled');
  $("div#propMod").hide();
  $("div#propBisim").show();
  choice=0
}
function propModel(){
  $("button.btn-prop-save").removeClass('disabled');
  $("div#propBisim").hide();
  $("div#propMod").show();
  choice=1
}

function propertyPhp(){
  
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
      var property = $('.verify-list').html()
      if(property == null){
        nVerifyList = 0
      }else{
        $('.status-element').html("<span class='glyphicon glyphicon-option-horizontal'></span>");
        $('.time-element').html("<span class='glyphicon glyphicon-option-horizontal'></span>");
        var re = /element\d/ig;
        var element_numbers = property.match(re);
        if((element_numbers != null)){
          nVerifyList = parseInt(element_numbers[element_numbers.length-1].replace('element', '')) + 1
        }
        
      }
  };
  // Note that the URL is create_graph.php and I use "?txt" to send the needed parameter (the input from the user)
  xhttp.open("GET", "php/verify.php?txt=" + encodeURIComponent(txt), true);
  // Calling create_graph.php
  xhttp.send();
  
}
function closeModal(){
  $('#property-modal').modal('toggle');
}
function savebtn(){
  var prop;
  if(choice == 0){

    // create a new element to verify table
    var process1 = $('.bissim-process1').val();
    var process2 = $('.bissim-process2').val();
    prop = $(".property-id").val();
    $('.verify-list').append("<tr class = 'element"+nVerifyList+"'><td class='status-element status"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
    "<td class = 'time-element time"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
    "<td class = 'property-label"+nVerifyList+"'>"+ prop +"</td>" +
    "<td class = 'verify"+nVerifyList+"' process1 = '"+process1+"' process2 = '"+process2+"'><span class='glyphicon glyphicon-play-circle btn btn-sm' onClick='verify_action("+ nVerifyList+", \"bissi\")'></span></td>" +
    "<td><span class='glyphicon glyphicon-pencil btn btn-sm' data-toggle='modal' href='#property-modal' onClick='addPropClick("+ nVerifyList+", \"bissi\")'></span></td>" +
    "<td><span class='glyphicon glyphicon-trash btn btn-sm' onClick='verify_delete("+ nVerifyList+")'></span></td></tr>");
    nVerifyList++;
    get_verify_session();
    closeModal();
  }else if(choice == 1){
    var processModel = $('.model-process').val();
    var formula = $('.formula-id').val();
    var command = "parse " + formula_adjust(formula) + " .";



    $.ajax({
      type: "GET",
      data: { txt: command },
      url: 'php/parse-model-check.php',
      success: function (request) {
        if(request.includes("Prop:")){
          prop = $(".model-process-select").val() + "&nbsp;&nbsp;|=&nbsp;&nbsp;" + $(".formula-id").val();
          $('.verify-list').append("<tr class = 'element"+nVerifyList+"'><td class='status-element status"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
          "<td class = 'time-element time"+nVerifyList+"'> <span class='glyphicon glyphicon-option-horizontal'></span> </td>" +
          "<td class = 'property-formula"+nVerifyList+"'>"+ prop +"</td>" +
          "<td class = 'verify"+nVerifyList+"' processModel = '"+processModel+"' formula = '"+formula+"'><span class='glyphicon glyphicon-play-circle btn btn-sm' onClick='verify_action("+ nVerifyList+", \"model\")'></span></td>" +
          "<td><span class='glyphicon glyphicon-pencil btn btn-sm' data-toggle='modal' href='#property-modal' onClick='addPropClick("+ nVerifyList+", \"model\")'></span></td>" +
          "<td><span class='glyphicon glyphicon-trash btn btn-sm' onClick='verify_delete("+ nVerifyList+")'></span></td></tr>");
          nVerifyList++;
          get_verify_session();
          closeModal();
        }else{
          $('.parse-model-check').show()
          if(request.includes("bad token")){
            re = /bad\stoken.+/i;
            error = request.match(re) ;
            $('.parse-model-check').html("<div class='alert alert-danger'><strong>Syntax Error: </strong>"+ error +"</div>");
          }else if (request.includes("didn't expect token")) {
            re = /token.+/i;
            error = request.match(re);
            error = error[0].replace('\'', '');
            error = error.replace(':', '')
            $('.parse-model-check').html("<div class='alert alert-danger'><strong>Syntax Error: </strong> didn\'t expect "+ error +"</div>");
          }else{
            $('.parse-model-check').html("<div class='alert alert-danger'><strong>Error: </strong>Non valid expression</div>");
          }
        }
      }
    });
  }

}


function verify_action_php(command, classStatus, classTime){
  'Method get to boton verify'
  // The Ajax invocation

  $.ajax({
    type: "GET",
    data: { txt: command },
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
function get_verify_session(){
  var properties = $('.verify-list').html();
  $.ajax({
    type: "GET",
    data: { txt: properties },
    url: 'php/verify-property-session.php'
  });
}

function formula_adjust(formula){
  formula = formula.replace(/([a-z]\w*)/ig, " \'$1 ");      //add ' before process
  formula = formula.replace('\'tt','tt');
  formula = formula.replace('\'ff','ff');
  formula = formula.replace('\'AND','AND');
  formula = formula.replace('\'OR','OR');
  formula = formula.replace('\'ANY','ANY');
  return formula;
}

function get_command_ModelC(processModel, formula){
  formula = formula_adjust(formula);
  var maude = "red in SLML_MC : modelCheck({\'"+ processModel + "},("+ inputFromEdit.replace(/;/ig,',') + "), "+ formula +") .";
  return maude;
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
    processModel = $('.verify' + n).attr('processModel');
    formula = $('.verify' + n).attr('formula');

    // verify_action_php(maude, '.test');
    var maude = get_command_ModelC(processModel, formula);
    verify_action_php(maude, classStatus, classTime);

  }
}

function verify_delete(n){
  element_class = ".element" +n;
  $(element_class).remove();
  get_verify_session();
}


function insert_on_formulaTXT(areaId, text) {
  var txtarea = document.getElementById(areaId);
  if (!txtarea) {
    return;
  }

  var scrollPos = txtarea.scrollTop;
  var strPos = 0;
  var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
    "ff" : (document.selection ? "ie" : false));
  if (br == "ie") {
    txtarea.focus();
    var range = document.selection.createRange();
    range.moveStart('character', -txtarea.value.length);
    strPos = range.text.length;
  } else if (br == "ff") {
    strPos = txtarea.selectionStart;
  }

  var front = (txtarea.value).substring(0, strPos);
  var back = (txtarea.value).substring(strPos, txtarea.value.length);
  txtarea.value = front + text + back;
  strPos = strPos + text.length;
  if (br == "ie") {
    txtarea.focus();
    var ieRange = document.selection.createRange();
    ieRange.moveStart('character', -txtarea.value.length);
    ieRange.moveStart('character', strPos);
    ieRange.moveEnd('character', 0);
    ieRange.select();
  } else if (br == "ff") {
    txtarea.selectionStart = strPos;
    txtarea.selectionEnd = strPos;
    txtarea.focus();
  }

  txtarea.scrollTop = scrollPos;
}
