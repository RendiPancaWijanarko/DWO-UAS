<!-- ================================================== VIEW ================================================== -->
<?php if ($action == 'view' || empty($action)) { ?>
    <div class="page">
        <div class="page-title blue">
            <h3><?php echo $breadcrumb; ?></h3>
            <p>Informasi terkait <?php echo $breadcrumb; ?></p>
        </div>
        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel rounded-0">
                        <div class="panel-heading">
                            <h5 class="panel-title">View Data: <?php echo $breadcrumb; ?></h5>
                        </div>
                        <div class="panel rounded-0">
                            <div class="panel-body">
                                <iframe name="mondrian" src="http://localhost:8080/mondrian/index.jsp" style="height: 300px; width: 1140px;"></iframe>
                            </div>
                        </div>
                        <!-- ========== Flashdata ========== -->
                        <?php if ($this->session->flashdata('success')) : ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-check sign"></i>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php elseif ($this->session->flashdata('warning')) : ?>
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-check sign"></i>
                                <?php echo $this->session->flashdata('warning'); ?>
                            </div>
                        <?php elseif ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-warning sign"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        <!-- ========== End Flashdata ========== -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>