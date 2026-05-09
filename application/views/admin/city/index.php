<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City Management - Import Excel</title>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <?php $this->load->view('/admin/common/admin-header')?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view('/admin/common/left-menu') ?>


        <h1>Import Cities and Districts from Excel</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <p style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
        <?php endif; ?>
        <form action="<?php echo base_url('admin/CityManagement_controller/import'); ?>" method="post" enctype="multipart/form-data">
            <label for="excel_file">Select Excel File:</label>
            <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls" required>
            <br><br>
            <button type="submit">Import</button>
        </form>
    </div>
</body>
</html>