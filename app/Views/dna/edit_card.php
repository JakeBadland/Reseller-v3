<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_user'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#delete-card" aria-expanded="false" aria-controls="collapseExample">
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
                    <label for="login" class="col-xs-3 control-label">Name<label class="red">*</label></label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?=$card->name?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-xs-3 control-label">Number<label class="red">*</label></label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="number" name="number" value="<?=$card->number?>">
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
