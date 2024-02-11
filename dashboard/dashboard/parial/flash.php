
<?php
    if (isset($_SESSION['notification']['message'])) :
?>
<div class="alert alert-<?=$_SESSION['notification']['type']?> alert-dismissible">
    <div class="row">
        <div class="col-md-11">
            <h4><?=$_SESSION['notification']['message']?></h4>
        </div>
        <div class="col-md-1">
            <a href="" class="close" data-dismiss="alert" arial-label="close"style="color:red; text-decoration:none; font-size:20px; font-style:bold;">&times;</a>
        </div>
    </div>
</div>
<?php
    $_SESSION['notification']=[];
    endif;
?>
