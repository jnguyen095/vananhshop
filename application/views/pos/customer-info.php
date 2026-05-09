<?php
if(isset($user)){
?>
    <div class="col-sm-7"><i class="glyphicon glyphicon-user"></i>&nbsp;<?=$user->FullName?></div>
    <div class="col-sm-3"><i class="glyphicon glyphicon-earphone">&nbsp;<?=$user->Phone?></i></div>
    <div class="col-sm-2 text-right"><a href="#" data-toggle="tooltip" title="Chỉnh sửa người dùng" ><i class="glyphicon glyphicon-edit"></i></a></div>
    <div class="col-sm-12"><i class="glyphicon glyphicon-home"></i>&nbsp;<?=$user->Address?></div>
    <input type="hidden" name="userId" value="<?=$user->Us3rID?>"/>
<?php } else {?>
    <div class="col-sm-12 text-danger text-center">Chưa chọn khách hàng</div>
<?php } ?>