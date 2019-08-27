<div class="page-content">
    <div class="page-head">
        <div class="page-title">
            <h1>Edit <small>User</small></h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <span class="active">Edit User</span>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-7">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-user font-dark"></i>
                        <span class="caption-subject uppercase"> Edit User </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php echo form_open('user/edit_user', array("class" => "form-horizontal")) ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Username</label>
                                <div class="col-md-9">
                                    <input type="hidden" name="iduser" value="<?php echo $iduser ?>">
                                    <input type="text" name="user" class="form-control" value="<?php echo $username ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Password</label>
                                <div class="col-md-9">
                                    <input type="password" name="pass" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Ulangi Password</label>
                                <div class="col-md-9">
                                    <input type="password" name="ulang_pass" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">Submit</button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>