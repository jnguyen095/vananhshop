<?php
/**
 * Promotion edit view
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vân Anh Shop | Quản lý khuyến mãi</title>
    <?php $this->load->view('/admin/common/header-js') ?>
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
    <link rel="stylesheet" href="<?=base_url('/theme/admin/css/bootstrap-datepicker.min.css')?>">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php $this->load->view('/admin/common/admin-header')?>
    <?php $this->load->view('/admin/common/left-menu') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Thông tin khuyến mãi</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                <li><a href="<?=base_url('/admin/promotion/list.html')?>">Quản lý khuyến mãi</a></li>
                <li class="active">Thông tin khuyến mãi</li>
            </ol>
        </section>

        <section class="content container-fluid">
            <?php if (!empty($message_response)) {
                echo '<div class="alert alert-danger">';
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
                echo $message_response;
                echo '</div>';
            }
            ?>

            <div class="box">
                <div class="box-body">
                    <?php
                    $actionUrl = 'admin/promotion/edit';
                    if (isset($promotion->PromotionsID) && $promotion->PromotionsID > 0) {
                        $actionUrl .= '-' . $promotion->PromotionsID;
                    }
                    echo form_open($actionUrl, array('id' => 'frmPromotion', 'class' => 'form-horizontal'));
                    ?>

                    <div class="form-group">
                        <div class="col-md-2"><label>Tên khuyến mãi <span class="required">*</span></label></div>
                        <div class="col-md-6">
                            <input type="text" name="Name" class="form-control" value="<?=isset($promotion->Name) ? $promotion->Name : ''?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2"><label>Mô tả</label></div>
                        <div class="col-md-6">
                            <textarea name="Description" rows="4" class="form-control"><?=isset($promotion->Description) ? $promotion->Description : ''?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2"><label>Loại khuyến mãi <span class="required">*</span></label></div>
                        <div class="col-md-4">
                            <select name="Type" class="form-control">
                                <option value="">Chọn loại</option>
                                <?php foreach ($promotionTypes as $key => $label) { ?>
                                    <option value="<?=$key?>" <?=isset($promotion->Type) && $promotion->Type == $key ? 'selected' : ''?>><?=$label?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2"><label>Giá trị giảm <span class="required">*</span></label></div>
                        <div class="col-md-2">
                            <input type="text" name="DiscountValue" class="form-control" value="<?=isset($promotion->DiscountValue) ? $promotion->DiscountValue : ''?>">
                        </div>
                        <div class="col-md-2">
                            <select name="DiscountType" class="form-control">
                                <option value="percentage" <?=isset($promotion->DiscountType) && $promotion->DiscountType == 'percentage' ? 'selected' : ''?>>Phần trăm</option>
                                <option value="fixed" <?=isset($promotion->DiscountType) && $promotion->DiscountType == 'fixed' ? 'selected' : ''?>>Số tiền</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2"><label>Thời gian áp dụng</label></div>
                        <div class="col-md-2">
                            <input type="text" name="StartDate" class="form-control datepicker" placeholder="Từ ngày" value="<?=isset($promotion->StartDate) ? date('d/m/Y', strtotime($promotion->StartDate)) : ''?>">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="EndDate" class="form-control datepicker" placeholder="Đến ngày" value="<?=isset($promotion->EndDate) ? date('d/m/Y', strtotime($promotion->EndDate)) : ''?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2"><label>Trạng thái</label></div>
                        <div class="col-md-4">
                            <input type="checkbox" name="Active" value="1" class="form-control minimal" <?=(!isset($promotion->Active) || $promotion->Active == 1) ? 'checked' : ''?>> Kích hoạt
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <div class="col-md-2"><label>Điều kiện áp dụng</label></div>
                        <div class="col-md-10">
                            <table class="table table-bordered" id="conditionTable">
                                <thead>
                                <tr>
                                    <th>Loại điều kiện</th>
                                    <th>Giá trị điều kiện</th>
                                    <th style="width: 120px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($conditions)) {
                                    foreach ($conditions as $condition) {
										?>
                                        <tr>
                                            <td>
                                                <select name="ConditionType[]" class="form-control">
                                                    <option value="">Chọn điều kiện</option>
                                                    <?php foreach ($conditionTypes as $key => $label) { ?>
                                                        <option value="<?=$key?>" <?=($condition->ConditionType == $key) ? 'selected' : ''?>><?=$label?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><input type="text" name="ConditionValue[]" class="form-control" value="<?=htmlspecialchars($condition->ConditionValue)?>"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-condition">Xóa</button></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td>
                                            <select name="ConditionType[]" class="form-control">
                                                <option value="">Chọn điều kiện</option>
                                                <?php foreach ($conditionTypes as $key => $label) { ?>
                                                    <option value="<?=$key?>"><?=$label?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><input type="text" name="ConditionValue[]" class="form-control"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-condition">Xóa</button></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-default" id="addCondition">Thêm điều kiện</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <a class="btn btn-default" href="<?=base_url('/admin/promotion/list.html')?>">Trở lại</a>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>

                    <input type="hidden" id="crudaction" name="crudaction" value="insert">
                    <?php if (isset($promotion->PromotionsID) && $promotion->PromotionsID > 0) { ?>
                        <input type="hidden" name="PromotionsID" value="<?=$promotion->PromotionsID?>">
                    <?php } ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>

    <?php $this->load->view('/admin/common/admin-footer')?>
</div>

<script src="<?=base_url('/theme/admin/js/jquery.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/adminlte.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#addCondition').on('click', function() {
            var row = '<tr>' +
                '<td><select name="ConditionType[]" class="form-control"><option value="">Chọn điều kiện</option>';
            <?php foreach ($conditionTypes as $key => $label) { ?>
                row += '<option value="<?=$key?>"><?=htmlspecialchars($label)?></option>';
            <?php } ?>
            row += '</select></td>' +
                '<td><input type="text" name="ConditionValue[]" class="form-control"></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm remove-condition">Xóa</button></td>' +
                '</tr>';
            $('#conditionTable tbody').append(row);
        });

        $('#conditionTable').on('click', '.remove-condition', function() {
            $(this).closest('tr').remove();
        });

		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass   : 'iradio_minimal-blue'
		});
    });
</script>
