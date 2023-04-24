<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_user'); ?>

<div class="container">
    <button class="btn btn-danger" type="button">
        Delete user!
    </button>
    <br/>
    <br/>

    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <form action="/dna/editUser" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="login" class="col-xs-3 control-label">Login<label class="red">*</label></label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="login" name="login" value="<?=$user->login?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-xs-3 control-label">Password<label class="red">*</label></label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm" class="col-xs-3 control-label">Confirm<label class="red">*</label></label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="confirm" name="confirm">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Email</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="email" name="email" value="<?=$user->email?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="col-xs-3 control-label">Role</label>
                    <div class="col-xs-5">
                        <select id="role" name="role">
                            <?php foreach ($roles as $role) : ?>
                                <option <?php if($role->id == $user->role) echo 'selected="selected"' ?>
                                        name="<?= $role->id ?>"><?= $role->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
