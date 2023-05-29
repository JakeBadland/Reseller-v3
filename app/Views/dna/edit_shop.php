<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_shop'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#delete-shop" aria-expanded="false" aria-controls="collapseExample">
        Delete shop
    </button>
    <br/>
    <br/>

    <div class="collapse" id="delete-shop">
        <div class="card card-body panel panel-default">
            <div class="panel-body">
                <form action="/dna/shops/delete" class="form-horizontal" method="post">
                    <h3 class="col-xs-3 control-label">Are you sure?</h3>
                    <div class="form-group">
                        <div class="col-xs-5">
                            <input type="hidden" class="form-control" name="shop_id" value="<?=$shop->id?>">
                        </div>
                    </div>
                    <button type="submit">Confirm</button>
                </form>
            </div>
        </div>
    </div>


    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <form action="/dna/editShop" class="form-horizontal" method="post">
                <input type="hidden" name="id" value="<?=$shop->id?>">
                <div class="form-group">
                    <label for="login" class="col-xs-3 control-label">Name</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?=$shop->name?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-xs-3 control-label">Token</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="token" name="token" value="<?=$shop->token?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm" class="col-xs-3 control-label">Color</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="color" name="color" value="<?=$shop->color?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="col-xs-3 control-label">Card</label>
                    <div class="col-xs-5">
                        <select id="card" name="card">
                            <?php foreach ($cards as $card) : ?>
                                <option <?php if($card->id == $shop->card_id) echo 'selected="selected"' ?>
                                        name="<?= $card->id ?>"><?= $card->name ?></option>
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
