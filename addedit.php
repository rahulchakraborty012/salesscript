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
		$guideoptionData = guideOptions($_GET['guide_id']);
}
$option_id="";
$backLink='';
if(!empty($_GET['option_id'])){
	$option_id=$_GET['option_id'];
	$guideData = guideList('',$_GET['option_id']);
	$guideTitle = $guideDesc = $guideId ='';
	if(!empty($guideData[0])){
			$guideTitle = $guideData[0]['question_title'];
			$guideDesc = $guideData[0]['question_description'];
			$guideId = $guideData[0]['id'];
			$guideoptionData = guideOptions($guideId);			
	}	
   
  $getPreviousData = getBackLink($_GET['option_id']);
  if(!empty($getPreviousData[0])){
  		if(!empty($getPreviousData[0]['answer_option_id'])){
  				$backLink = "addedit.php?option_id=".$getPreviousData[0]['answer_option_id'];
  		}
  		else{
  				$backLink = "addedit.php?guide_id=".$getPreviousData[0]['id'];
  		}
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
     <h3> <a href="guide_list.php"> Back to Guide List</a></h3>
      <?php
      if(!empty($backLink)){?>
      		<h4> <a href="<?=$backLink;?>" class="btn btn-primary">Back to Previous Step</a></h4>
    	<?php
      }?>     
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
  <?php include('alert.php')?>   
    
    <div class="container">
    	<div class="row">
    		<div class="col-md-4"></div>
    		<div class="col-md-8 pull-left">
    			<h1> <?= ($_GET['guide_id'])?'Edit':'Add' ?> Sales Script</h1>  <br>
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
					  	+'<a id="createChoices" onclick="createQuestion('+i+');" href="javascript:void(0);" class="btn btn-success">Save Question <i class="fa fa-save"></i></a> &nbsp;'
					  	+'<a id="createChoices" onclick="createChoices('+i+');" href="javascript:void(0);" class="btn btn-primary">Add Choice(s) &nbsp;<i class="fa fa-plus"></i></a>'
					  +'</div>';
					  $('#createStep'+i).html(html);
						EditChoices(i);
  		}
		function createQuestion(num){
			var stepTitle = $('.createStep #stepTitle'+num).val();
    	var stepDescription = $('.createStep #stepDescription'+num).val();
			var question_id = $('.createStep #question_id').val();
			var option_id = '<?= $option_id; ?>';
			console.log(question_id);
    		if($.trim(stepTitle)=='' || $.trim(stepDescription)==''){
    			 	displayAlert("Please enter step title and description",'error');
    			 	return false;
    		}
			if(question_id=="")
    			saveQuestion(stepTitle,stepDescription,option_id,num);
			else
					updateQuestion(stepTitle,stepDescription,question_id,option_id,num);
		}
    	function createChoices(num){    
    		var stepTitle = $('.createStep #stepTitle'+num).val();
    		var stepDescription = $('.createStep #stepDescription'+num).val();
				var question_id = $('.createStep #question_id').val();
    		if($.trim(stepTitle)=='' || $.trim(stepDescription)==''){
    			 	displayAlert("Please enter step title and description",'error');
    			 	return false;
    		}
		
    		var choiceOptionLength = $('.stepChoiceForm .choiceOptions').length;
    		var elementCount = (choiceOptionLength+1);
    		
		    var html = '<div class="choiceOptions" id="choiceOption'+elementCount+'" style="margin-top:10px;">'
	    					+'<div class="form-group">'
						    +'<label for="choiceName">Choice'+elementCount+'</label>'
						    +'<input type="text" name="choice_title'+elementCount+'" class="form-control" id="choiceTitle'+elementCount+'" aria-describedby="choiceName"><br/>'
						    +'<label for="choiceButtonLabel">Button Label</label>'
						    +'<input type="text" name="choice_button_label'+elementCount+'" class="form-control" id="choiceButtonLabel'+elementCount+'" aria-describedby="choiceButtonLabel"><input type="hidden" name="choiceid'+elementCount+'" class="form-control" id="choiceid'+elementCount+'" aria-describedby="addchoice_id" value=""><br/>'
						    +'<a id="saveChoices" onclick="saveChoices('+elementCount+');" href="javascript:void(0);" class="btn btn-success">Save <i class="fa fa-save"></i></a> <a id="removeChoices" onclick="RemoveNewChoices('+elementCount+');" href="javascript:void(0);" class="btn btn-danger">Remove <i class="fa fa-close"></i></a>&nbsp;'
					  	+'<a id="createnewquestion'+elementCount+'" onclick="createnewQuestion('+elementCount+');" href="javascript:void(0);" class="btn btn-success hidden">Go to next step</a></span></div>';

				$('.stepChoiceForm').append(html);
    	}

    	function EditChoices(num){  
				<?php
				if(!empty($guideoptionData)){
					$cnt=0;
					foreach($guideoptionData as $g){ 
						$cnt+1;
					?>
					var choiceOptionLength = $('.stepChoiceForm .choiceOptions').length;
					var elementCount = (choiceOptionLength+1);		
					var html = '<div class="choiceOptions" id="choiceOption'+<?= $cnt; ?>+'" style="margin-top:10px;">'
					+'<div class="form-group">'
					+'<label for="choiceName">Choice'+elementCount+'</label>'
					+'<input type="text" name="choice_title'+elementCount+'" class="form-control" id="choiceTitle'+elementCount+'" aria-describedby="choiceName" value="<?= $g['option_title']; ?>"><br/>'
					+'<label for="choiceButtonLabel">Button Label</label>'
					+'<input type="text" name="choice_button_label'+elementCount+'" class="form-control" id="choiceButtonLabel'+elementCount+'" aria-describedby="choiceButtonLabel" value="<?= $g['option_label']; ?>"><input type="hidden" name="choice_id'+elementCount+'" class="form-control" id="choiceid'+elementCount+'" aria-describedby="choiceid" value="<?= $g['id']; ?>"><br/>'
					+'<a id="saveChoices" onclick="saveChoices('+elementCount+');" href="javascript:void(0);" class="btn btn-success">Save <i class="fa fa-save"></i></a>  <a id="removeChoices" onclick="removeChoices('+elementCount+');" href="javascript:void(0);" class="btn btn-danger">Remove <i class="fa fa-remove"></i></a> &nbsp;'
	  	+'<a id="createnewquestion'+elementCount+'" onclick="createnewQuestion('+elementCount+');" href="javascript:void(0);" class="btn btn-success">Go to next step</a></div>';

						$('.stepChoiceForm').append(html);
				<?php }
				}                                
			?>   		
    	}

    	function saveQuestion(title,description, option_id, num){
    			var postData = {"title" : title, "description":description, "option_id":option_id};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
							if(response!=false){								
								$("#question_id").val(response);
								displayAlert('Question Saved successfully','success');
							}
					});
					request.fail(function(err){
							console.log(err);
					})
    	}
    	function updateQuestion(title,description,question_id,option_id,num){
    			var postData = {"title" : title, "description":description,"question_id":question_id,"option_id":option_id};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
							displayAlert('Question Updated successfully','success');
					});
					request.fail(function(err){
							console.log(err);
					})
    	}
    	
		function saveChoices(num){
    		var stepTitle = $('.stepChoiceForm #choiceTitle'+num).val();
    		var stepDescription = $('.stepChoiceForm #choiceButtonLabel'+num).val();
				var questionID = $('.createStep #question_id').val();
				var choiceID = $('.stepChoiceForm #choiceid'+num).val();
    		if(($.trim(stepTitle)=='' || $.trim(stepDescription)=='') && questionID=='' ){
    			 	displayAlert('Please enter step Choice and Button Label','error');
    			 	return false;
    		}
				if(choiceID=="")
						saveOption(stepTitle,stepDescription,questionID,choiceID,num);
				else
						updateOption(stepTitle,stepDescription,questionID,choiceID,num); 		
    	}

		function saveOption(choicetitle,choicedescription,questionID,choiceID,num){
					var postData = {"question_id":questionID ,"option_title" : choicetitle, "option_label":choicedescription, "choiceID":choiceID};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){			
							var choiceid=	response;			
							$("#choiceid"+num).val(choiceid);
							if(choiceid)
									$("#createnewquestion"+num).removeClass('hidden');
							displayAlert('Choice saved successfully','success');
					});
					request.fail(function(err){
							displayAlert(err,'error');
					})
    	}

    	function updateOption(choicetitle,choicedescription,questionID,choiceID, num){
					var postData = {"question_id":questionID ,"option_title" : choicetitle, "option_label":choicedescription, "choiceID":choiceID};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
						displayAlert("Choice updated successfully",'success');
					});
					request.fail(function(err){
						
						if(err.status=='200')
						window.location="addedit.php?guide_id="+'<?=$guideId;?>';
					})
    	}
		function removeChoices(num){
			var choiceID = $('.stepChoiceForm #choiceid'+num).val();
					var postData = {"choiceID":choiceID ,"type" : "deleteOption"};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
							EditChoices(num);
							displayAlert('Choice removed successfully','success');
					});
					request.fail(function(err){
						console.log(err.status);
						if(err.status=='200')
						window.location="addedit.php?guide_id="+'<?=$guideId;?>';
					})
    	}
		function RemoveNewChoices(num){
				removeChoices(num);
				$("#choiceOption"+num).remove();
			
		}
		function createnewQuestion(num){
			var choiceID = $('.stepChoiceForm #choiceid'+num).val();
			window.location="addedit.php?option_id="+choiceID;	
		}
    </script>
</html>