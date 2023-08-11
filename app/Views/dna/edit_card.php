<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_user'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#delete-card" aria-expanded="false" aria-controls="collapseExample" style="float: right">
        Delete card
    </button>
    <br/>
    <br/>

    <div class="collapse" id="delete-card">
        <div class="card card-body panel panel-default">
            <div class="panel-body">
                <form action="/dna/cards/delete" class="form-horizontal" method="post">
                    <h3 class="col-xs-3 control-label">Are you sure?</h3>
                    <div class="form-group">
                        <div class="col-xs-5">
                            <input type="hidden" class="form-control" name="card_id" value="<?=$card->id?>">
                        </div>
                    </div>
                    <button type="submit">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <form action="/dna/editCard" class="form-horizontal" method="post">
                <input type="hidden" name="id" value="<?=$card->id?>">
                <div class="form-group">
                    <label for="login" class="col-xs-3 control-label">Name</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?=$card->name?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-xs-3 control-label">Number</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="number" name="number" value="<?=$card->number?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-xs-3 control-label">Short name</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="short" name="short" value="<?=$card->short?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="bank" class="col-xs-3 control-label">Bank</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="bank" name="bank" value="<?=$card->bank?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="current_balance" class="col-xs-3 control-label">Current balance</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="current_balance" name="current_balance" value="<?=$card->current_balance?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="limit" class="col-xs-3 control-label">Limit</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="limit" name="limit_balance" value="<?=$card->limit_balance?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="auto_clear" class="col-xs-3 control-label">Auto clear</label>
                    <div class="col-xs-5">
                        <input type="checkbox" class="auto_clear" id="auto_clear" name="auto_clear" <?= ($card->auto_clear)? 'checked' : '' ?>>
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

<style>

</style>


<?= $this->endSection(); ?>
