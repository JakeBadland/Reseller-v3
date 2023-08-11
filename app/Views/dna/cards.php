<?= $this->extend('layouts/dna'); ?>

<?= $this->section('cards'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#add-card" aria-expanded="false" aria-controls="collapseExample">
        Add card
    </button>
    <br/>
    <br/>
    <div class="collapse" id="add-card">
        <div class="card card-body panel panel-default">
            <div class="panel-body">
                <form action="/dna/cards/add" class="form-horizontal" method="post">
                    <div class="form-group">
                        <label for="name" class="col-xs-3 control-label">Name</label>
                        <div class="col-xs-5">
                                <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="num" class="col-xs-3 control-label">Number</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="number" name="number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="num" class="col-xs-3 control-label">Short</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="short" name="short">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank" class="col-xs-3 control-label">Bank</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="bank" name="bank">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-3 col-xs-9">
                            <button type="submit" class="btn btn-default">Add</button>
                            <button type="button" data-toggle="collapse" data-target="#add-card" class="btn btn-default">Cancel</button>
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
                        <th>Number</th>
                        <th>Balance</th>
                        <th>Limit</th>
                        <th>Short</th>
                        <th>Bank</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cards as $card) : ?>
                    <tr>
                        <td><?= $card->name ?></td>
                        <td><?= $card->number ?></td>
                        <td><?= $card->current_balance ?></td>
                        <td><?= $card->limit_balance ?></td>
                        <td><?= $card->short ?></td>
                        <td><?= $card->bank ?></td>
                        <td><a href="/dna/cards/edit/<?= $card->id ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
