<?php
include_once 'guide.php';
$guides = guideList(); 
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
    <h1><a href="guide_list.php">Guide List</a></h1>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    
	<div class="container">
        <div class="row"></div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcomb-list">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?php
                            if(!empty($_GET['success'])){?>
							    <div class="alert alert-success">
                                    <?=$_GET['success'];?>
                                </div>
                            <?}?>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="breadcomb-wp pull-right">
								<div class="breadcomb-ctn">
									<a href="addedit.php" class="btn btn-primary" title="Add Guide">Add Guide</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
    <div class="form-example-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="table-responsive">
                           <table id="data-table-basic" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Guide Name</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                               <tbody>
                                    <?php
                                    if(!empty($guides)){
                                        $cnt = 1;
                                        foreach($guides as $g){
                                            if(!empty($g['answer_option_id'])){
                                                continue;
                                            }
                                            ?>
                                             <tr>
                                                <td><?=$cnt;?></td>
                                                <td><?=$g['question_title'];?></td>
                                                <td><?=$g['status'];?></td>
                                                <td><?=date('F d, Y',strtotime($g['created_at']));?></td>
                                                <td><a class='btn btn-primary' href="addedit.php?guide_id=<?=$g['id'];?>">Edit </a> &nbsp &nbsp
                                                    <a href="guide.php?guide_id=<?=$g['id'];?>&type=delete" class='btn btn-danger'>Delete</a> &nbsp &nbsp
                                                    <?php
                                                    if($g['status']=='draft'){?>
                                                        <a href="guide.php?guide_id=<?=$g['id'];?>&type=publish" class='btn btn-warning'>Publish</a> &nbsp &nbsp
                                                    <?php
                                                    }?>
                                                    
                                                    <a href="preview_new.php?guide_id=<?=$g['id'];?>" class='btn btn-primary'>Preview</a><td>
                                                    
                                            </tr>    
                                            <?php
                                            $cnt ++;
                                        }
                                    }   else{
                                        echo "<tr><td colspan='6'>No Record Found</td></tr>";
                                    }                                 
                                    ?>                                      
                               </tbody>
                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>    
    </body>
</html>