<div class="row alert-div" style="display: none;">
    <div class="col-md-7"></div>
    <div class="col-md-4" style="margin-left: 100px;">
        <div class="alert alert-success success" role="alert" style="display:none;">
            <span class="success-msg"></span>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" onclick="closeMsgBox('success')">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger error" role="alert" style="display:none;">
            <span class="error-msg"></span>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" onclick="closeMsgBox('error')">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>

<script>
    function displayAlert(msg,alertType){
        $('.alert-div').show();
        $('.'+alertType).show();
        $('.'+alertType+'-msg').text(msg);
        $("html, body").animate({ scrollTop: 0 }, "slow");
        setTimeout(function(){ 
            closeMsgBox(alertType);
        }, 3000);
    }

    function closeMsgBox(className){
        $('.alert-div').hide();
        $('.'+className).hide();
        $('.'+className+'-msg').text('');
    }
</script>