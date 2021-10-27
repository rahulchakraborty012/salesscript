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
$backLink1='';
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
					$backLink = "previewList.php?option_id=".$getPreviousData[0]['answer_option_id'];
				}
				else {
					$backLink = "previewList.php?guide_id=".$getPreviousData[0]['id'];
				}
		}
		if(empty($guideoptionData)){
				$guideId = getFirstGuideId($_GET['option_id']);
				if(!empty($guideId)){
					$backLink1 = "previewList.php?guide_id=".$guideId;
				}
		}  	
}

if(!empty($option_id)){
		$addMoreGuideId = getAddMoreLink($option_id);
		$addMoreLink = 'addedit.php?guide_id='.$addMoreGuideId;
} else if(!empty($guideId)){
		$addMoreLink = 'addedit.php?guide_id='.$guideId;
}

$content = '
    	<div class="row" style="margin-top:30px;">
    		<div class="col-md-4"></div>
    		<div class="col-md-8">
    					<div id="guideTitle">
    							<h3><p>'.$guideTitle.'</p></h3>
    					</div>
              <div style="margin-top:20px;"></div>
    					<div id="guideDescription">
    							<h5><p>'.$guideDesc.'</p></h5>
    					</div>
              <div style="margin-top:50px;"></div>
    					<div id="choiceBox">';

    						if(!empty($guideoptionData)){
    							foreach($guideoptionData as $option){
											$id= $option["id"];
											$label = ucfirst($option["option_label"]);
											$url = "previewList.php?option_id=$id";
											$funName = "getContent('$url');";
											$CountfunName  = "updateCounter('$id')";
											$content .=	'<a onclick="'.$funName.''.$CountfunName.'" href="javascript:void(0)" class="btn btn-success">'.$label.' &rarr;</a> <br/> <br/>';
									}
									if(!empty($backLink)){
										$funName = "getContent('$backLink')";
										$content .= '<a onclick="'.$funName.'" href="javascript:void(0)" class="btn btn-success"> &larr;</a><br/><br/> ';
									}
							}
							if(!empty($guideData[0])){
								$content .=' <a href="'.$addMoreLink.'" href="javascript:void(0)" class="btn btn-success">Add More Option</a><br/><br/>';
							}
						
							if(empty($guideoptionData)){
								$funName = "getContent('$backLink1')";
								$content .= '<a onclick="'.$funName.'" href="javascript:void(0)" class="btn btn-success" style="margin-left: 10px;"> Back To start</a><br/>';
							}
    					'</div>
				</div>
			</div>';
echo $content;
echo "^".$guideTitle;
die;
?>