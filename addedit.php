<?php
require_once 'guide.php';
if(!empty($_GET['guide_id'])){
		$guideData = guideList($_GET['guide_id']);
		$guideTitle = $guideDesc = $guideId ='';
		if(!empty($guideData[0])){
				$guideTitle = $guideData[0]['question_title'];
				$guideDesc = $guideData[0]['question_description'];
				$guideId = $guideData[0]['id'];
		}
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Sales Script</title>
  </head>
  <body style="background-color: #E7E9EB;">
    <h1>Sales Script</h1>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    
    <div class="container">
    	<div class="row">
    		<div class="col-md-4"></div>
    		<div class="col-md-8 pull-left">
		    	<form class="createStep" id=createStep1>
			    	
					</form>
				</div>
			</div>
    </div>
  </body>
  <script>
  		$(document).ready(function(){
  				init();
  		});
  		function init(){
  				var guideTitle = '<?=$guideTitle;?>';
  				var guideDesc = '<?=$guideDesc;?>';
  				var guideId = '<?=$guideId;?>';
  				var i=1;
  				$('.createStep').attr('id','createStep'+i);
  				var html ='<div class="form-group">'
					    +'<label for="stepNamme">Step Name</label>'
					    +'<input type="text" name="question_title" class="form-control" id="stepTitle'+i+'" aria-describedby="stepName" placeholder="Enter Step Title" value="'+guideTitle+'"> <input type="hidden" name="question_id" class="form-control" id="question_id" aria-describedby="stepName_id" value="'+guideId+'">'
					    +'<small class="form-text text-muted">Please enter the step title</small>'
						+'</div>'
						+'<div class="form-group">'
					    +'<label for="stepDescription">Step Description</label>'
					    +'<textarea class="form-control" name="question_description" id="stepDescription'+i+'" aria-describedby="stepDescription" placeholder="Enter Step Description">'+guideDesc+'</textarea>'
					    +'<small class="form-text text-muted">Please enter the step description</small>'
		        +'</div>'

					  +'<div class="stepChoiceForm pull-left" id="">'
					  	+'<a id="createChoices" onclick="createQuestion('+i+');" href="javascript:void(0);">Save Question <i class="fa fa-save"></i></a> &nbsp;<span>Next Step(s)</span>'
					  	+'<a id="createChoices" onclick="createChoices('+i+');" href="javascript:void(0);"><i class="fa fa-plus"></i></a>'
					  +'</div>';
					  $('#createStep'+i).html(html);

  		}
		function createQuestion(num){
			var stepTitle = $('.createStep #stepTitle'+num).val();
    	var stepDescription = $('.createStep #stepDescription'+num).val();
			var question_id = $('.createStep #question_id').val();
			console.log(question_id);
    		if($.trim(stepTitle)=='' || $.trim(stepDescription)==''){
    			 	alert('Please enter step title and description');
    			 	return false;
    		}
			if(question_id=="")
    			saveQuestion(stepTitle,stepDescription,num);
			else
					updateQuestion(stepTitle,stepDescription,question_id,num);
		}
    	function createChoices(num){    		
    		var choiceOptionLength = $('.stepChoiceForm .choiceOptions').length;
    		var elementCount = (choiceOptionLength+1);
    		var html = '<div class="choiceOptions" id="choiceOption'+elementCount+'" style="margin-top:10px;">'
	    					+'<div class="form-group">'
						    +'<label for="choiceName">Choice'+elementCount+'</label>'
						    +'<input type="text" name="choice_title'+elementCount+'" class="form-control" id="choiceTitle'+elementCount+'" aria-describedby="choiceName"><br/>'
						    +'<label for="choiceButtonLabel">Button Label</label>'
						    +'<input type="text" name="choice_button_label'+elementCount+'" class="form-control" id="choiceButtonLabel'+elementCount+'" aria-describedby="choiceButtonLabel"><br/>'
						    +'<a id="saveChoices" onclick="saveChoices('+elementCount+');" href="javascript:void(0);">Save <i class="fa fa-save"></i></a></div>';
				$('.stepChoiceForm').append(html);
    	}

    	function saveQuestion(title,description,num){
    			var postData = {"title" : title, "description":description};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
							if(response!=false)
								$("#question_id").val(response);
					});
					request.fail(function(err){
							console.log(err);
					})
    	}
    	function updateQuestion(title,description,question_id,num){
    			var postData = {"title" : title, "description":description,"question_id":question_id};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
							console.log(response);
					});
					request.fail(function(err){
							console.log(err);
					})
    	}
    	
		function saveChoices(num){
    		var stepTitle = $('.stepChoiceForm #choiceTitle'+num).val();
    		var stepDescription = $('.stepChoiceForm #choiceButtonLabel'+num).val();
				var questionID = $('.createStep #question_id').val();
    		if($.trim(stepTitle)=='' || $.trim(stepDescription)==''){
    			 	alert('Please enter step Choice and Button Label');
    			 	return false;
    		}
    		saveOption(stepTitle,stepDescription,questionID,num);    		
    	}

		function saveOption(choicetitle,choicedescription,questionID,num){
					var postData = {"question_id":questionID ,"option_title" : choicetitle, "option_label":choicedescription};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
							alert("Choice saved successfully");
					});
					request.fail(function(err){
							alert(err);
					})
    	}
    </script>
</html>