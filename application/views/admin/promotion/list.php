<?php
/**
 * Promotion list view
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vân Anh Shop | Quản lý khuyến mãi</title>
    <?php $this->load->view('/admin/common/header-js') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php $this->load->view('/admin/common/admin-header')?>
    <?php $this->load->view('/admin/common/left-menu') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Quản lý khuyến mãi</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                <li class="active">Quản lý khuyến mãi</li>
            </ol>
        </section>

        <?php
echo form_open('admin/promotion/list', array('id' => 'frmPost'));
        ?>
        <section class="content container-fluid">
            <?php if (!empty($message_response)) {
                echo '<div class="alert alert-success">';
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
                echo $message_response;
                echo '</div>';
            }
            ?>

            <div class="box">
                <div class="box-body">
                    <div class="search-filter">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Từ khóa</label>
                                <div class="form-group">
                                    <input type="text" name="searchFor" placeholder="Tìm theo tên khuyến mãi" class="form-control" id="searchKey">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>Loại khuyến mãi</label>
                                <div class="form-group">
                                    <select name="type" id="sl_type" class="form-control">
                                        <option value="">Tất cả</option>
                                        <?php foreach ($types as $key => $label) { ?>
                                            <option value="<?=$key?>"><?= $label ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>Trạng thái</label>
                                <div class="form-group">
                                    <label><input id="status_all" checked="checked" type="radio" name="status" value="-1"> Tất cả</label>
                                    <label><input id="status_active" type="radio" name="status" value="1"> Hoạt động</label>
                                    <label><input id="status_inactive" type="radio" name="status" value="0"> Ngừng</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-primary" onclick="sendRequest()">Tìm kiếm</a>
                        </div>
                    </div>

                    <div class="row no-margin top-buttons">
                        <a class="btn btn-primary" id="addNew" href="<?=base_url('/admin/promotion/edit.html')?>">Thêm khuyến mãi</a>
                        <a class="btn btn-danger" id="deleteMulti">Xóa nhiều</a>
                    </div>

                    <div class="table-responsive">
                        <table class="admin-table table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><input name="checkAll" value="1" type="checkbox"></th>
                                    <th data-action="sort" data-title="Name" data-direction="ASC"><span>Tên khuyến mãi</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
                                    <th data-action="sort" data-title="Type" data-direction="ASC"><span>Loại</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
                                    <th data-action="sort" data-title="DiscountValue" data-direction="ASC"><span>Giá trị giảm</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
                                    <th data-action="sort" data-title="StartDate" data-direction="ASC"><span>Thời gian</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
                                    <th><span>Điều kiện</span></th>
                                    <th data-action="sort" data-title="Active" data-direction="ASC"><span>Trạng thái</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($promotions)) {
                                foreach ($promotions as $promotion) { ?>
                                    <tr>
                                        <td><input name="checkList[]" type="checkbox" value="<?=$promotion->PromotionsID?>"></td>
                                        <td><?=$promotion->Name?></td>
                                        <td><?=isset($types[$promotion->Type]) ? $types[$promotion->Type] : $promotion->Type?></td>
                                        <td><?=$promotion->DiscountValue?> <?=($promotion->DiscountType == 'percentage') ? '%' : 'đ'?></td>
                                        <td><?=isset($promotion->StartDate) ? date('d/m/Y', strtotime($promotion->StartDate)) : '---'?> - <?=isset($promotion->EndDate) ? date('d/m/Y', strtotime($promotion->EndDate)) : '---'?></td>
                                        <td><?=$promotion->ConditionCount?> điều kiện</td>
                                        <td>
                                            <?php if ($promotion->Active == 1) { ?>
                                                <span class="label label-success">Hoạt động</span>
                                            <?php } else { ?>
                                                <span class="label label-warning">Ngừng</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?=base_url('/admin/promotion/edit-'.$promotion->PromotionsID.'.html')?>" title="Chỉnh sửa"><i class="glyphicon glyphicon-edit"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="8" class="text-center">Chưa có khuyến mãi nào.</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="text-center"><?php echo $pagination; ?></div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" id="crudaction" name="crudaction" value="">
        <?php echo form_close(); ?>
    </div>

    <?php $this->load->view('/admin/common/admin-footer')?>
</div>

<script src="<?=base_url('/theme/admin/js/jquery.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/adminlte.min.js')?>"></script>
<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
<script type="text/javascript">
    var sendRequest = function() {
        var query = $('#searchKey').val() || '';
        var type = $('#sl_type').val() || '';
        var status = $('input[name=status]:checked').val();
        window.location.href = '<?=base_url('admin/promotion/list.html')?>?query=' + encodeURIComponent(query) + '&type=' + encodeURIComponent(type) + '&status=' + encodeURIComponent(status) + '&orderField=' + curOrderField + '&orderDirection=' + curOrderDirection;
    };

    $('#deleteMulti').on('click', function() {
        if ($('input[name="checkList[]"]:checked').length === 0) {
            bootbox.alert('Vui lòng chọn ít nhất một khuyến mãi.');
            return;
        }
        bootbox.confirm('Bạn có chắc muốn xóa những khuyến mãi đã chọn?', function(result) {
            if (result) {
                $('#crudaction').val('delete-multiple');
                $('#frmPost').submit();
            }
        });
    });

    $('#searchKey').val(decodeURIComponent(getNamedParameter('query') || ''));
    $('#sl_type').val(decodeURIComponent(getNamedParameter('type') || ''));
    var status = decodeURIComponent(getNamedParameter('status') || '-1');
    $('#status_' + (status === '1' ? 'active' : status === '0' ? 'inactive' : 'all')).prop('checked', true);

    var curOrderField = getNamedParameter('orderField') || '';
    var curOrderDirection = getNamedParameter('orderDirection') || '';
    var currentSort = $('[data-action="sort"][data-title="' + getNamedParameter('orderField') + '"]');
    if (curOrderDirection === 'ASC') {
        currentSort.attr('data-direction', 'DESC').find('i.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top active');
    } else {
        currentSort.attr('data-direction', 'ASC').find('i.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom active');
    }

    $('[data-action="sort"]').on('click', function(e) {
        curOrderField = $(this).data('title');
        curOrderDirection = $(this).data('direction');
        sendRequest();
    });
</script>
