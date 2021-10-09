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
  				$backLink = "preview.php?option_id=".$getPreviousData[0]['answer_option_id'];
  		}
  		else{
  				$backLink = "preview.php?guide_id=".$getPreviousData[0]['id'];
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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    
    <div class="container">
    	<div class="row" style="margin-top:30px;">
    		<div class="col-md-4"></div>
    		<div class="col-md-8">
    					<div id="guideTitle">
    							<h3><p><?=$guideTitle;?></p></h3>
    					</div>
              <div style="margin-top:20px;"></div>
    					<div id="guideDescription">
    							<h5><p><?=$guideDesc;?></p></h5>
    					</div>
              <div style="margin-top:50px;"></div>
    					<div id="choiceBox">
    						<?php
    						if(!empty($guideoptionData)){
    								foreach($guideoptionData as $option){
    										?>
    											<a href="preview.php?option_id=<?=$option['id'];?>" class="btn btn-success"><?=ucfirst($option['option_label']);?> &rarr;</a> <br/> <br/>
    										<?php
    								}
                    if(!empty($backLink)){
                    ?>
                        <a href="<?=$backLink;?>" class="btn btn-success"> &larr;</a>
                    <?php
                    }
    						}
    						?>	

    					</div>
				</div>
			</div>
    </div>
  </body>
  	<scipt>
    </script>
</html>