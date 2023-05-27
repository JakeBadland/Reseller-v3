<?= $this->extend('layouts/dna'); ?>

<?= $this->section('shops'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#add-shop" aria-expanded="false" aria-controls="collapseExample">
        Add shop
    </button>
    <br/>
    <br/>
    <div class="collapse" id="add-shop">
        <div class="card card-body panel panel-default">
            <div class="panel-body">
                <form action="/dna/shops/add" class="form-horizontal" method="post">
                    <div class="form-group">
                        <label for="name" class="col-xs-3 control-label">Name<label class="red">*</label></label>
                        <div class="col-xs-5">
                                <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="num" class="col-xs-3 control-label">Token<label class="red">*</label></label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="token" name="token">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="num" class="col-xs-3 control-label">Color<label class="red">*</label></label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-3 col-xs-9">
                            <button type="submit" class="btn btn-default">Add</button>
                            <button type="button" data-toggle="collapse" data-target="#add-shop" class="btn btn-default">Cancel</button>
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
                        <th>Name</th>
                        <th>Token</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($shops as $shop) : ?>
                    <tr>
                        <td><?= $shop->name ?></td>
                        <td><?= $shop->token ?></td>
                        <td><?= $shop->color ?></td>
                        <td><a href="/dna/shops/edit/<?= $shop->id ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
