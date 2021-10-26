<?php
require_once 'guide.php';
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
    <title id="guidetitle"></title>
  </head>
  <body style="background-color: #E7E9EB;">     
    <h3> <a href="guide_list.php"> Back to Guide List</a></h3>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    
    <div class="container">

    </div>
  </body>
    <script>
      var guideId = "<?=$_GET['guide_id']?>";
      var optionId  = "<?=$_GET['option_id'];?>";
      if(typeof optionId !='undefined' && optionId!='')
        var url = 'previewList.php?option_id='+ optionId;
      if(typeof guideId != 'undefined' && guideId!='')
        var url = 'previewList.php?guide_id='+ guideId;
      getContent(url);
      function getContent(url){
        let browserUrl = url;
        browserUrl= browserUrl.replace("previewList", "preview_new");
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
              var data1= data.split(",");
              $('.container').text('');
                var result = $('#guidetitle').html(data1[1]);
                var result = $('.container').html(data1[0]);
                window.history.pushState("data","Preview",browserUrl);
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('slow')
            }
        });
      }
      function updateCounter(optionId){
        var postData = {"optionId":optionId ,"type" : "updateCounter"};
    			var request = $.ajax({
						  url: "guide.php",
						  method: "POST",
						  data: postData,
						  dataType: "json"
					});
					request.done(function(response){
					});
					request.fail(function(err){
					})
      }
    </script>
</html>