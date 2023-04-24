<?= $this->extend('layouts/dna'); ?>

<?= $this->section('users'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Add user
    </button>
    <br/>
    <br/>
    <div class="collapse" id="collapseExample">
        <div class="card card-body panel panel-default">
            <div class="panel-body">
                <form action="/dna/addUser" class="form-horizontal" method="post">
                    <div class="form-group">
                        <label for="login" class="col-xs-3 control-label">Login<label class="red">*</label></label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="login" name="login">
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
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-xs-3 control-label">Role</label>
                        <div class="col-xs-5">
                            <select id="role" name="role">
                                <?php foreach ($roles as $role) : ?>
                                <option name="<?=$role->id?>"><?= $role->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-3 col-xs-9">
                            <button type="submit" class="btn btn-default">Add</button>
                            <button type="button" data-toggle="collapse" data-target="#collapseExample" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user->login ?></td>
                        <td><?= $user->email ?></td>
                        <td><a href="/dna/editUser/<?= $user->id ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
