<?= $this->extend('layouts/dna'); ?>

<?= $this->section('rules'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#add-rule" aria-expanded="false" aria-controls="collapseExample">
        Add rule
    </button>
    <br/>
    <br/>
    <div class="collapse" id="add-rule">
        <div class="card card-body panel panel-default">
            <div class="panel-body">
                <form action="/dna/rules/add" class="form-horizontal" method="post">
                    <div class="form-group">
                        <label for="name" class="col-xs-3 control-label">Name</label>
                        <div class="col-xs-5">
                                <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="num" class="col-xs-3 control-label">From</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="from" name="from">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="num" class="col-xs-3 control-label">To</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" id="to" name="to">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shop_id" class="col-xs-3 control-label">Shop</label>
                        <div class="col-xs-5">
                            <select id="shop_id" name="shop_id">
                                <?php foreach ($shops as $shop) : ?>
                                    <option value="<?=$shop->id?>"><?= $shop->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="num" class="col-xs-3 control-label">Type</label>
                        <div class="col-xs-5">
                            <select id="type" name="type">
                                    <option name="cyclically">Cyclically</option>
                                    <option name="random">Random</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-3 col-xs-9">
                            <button type="submit" class="btn btn-default">Add</button>
                            <button type="button" data-toggle="collapse" data-target="#add-rule" class="btn btn-default">Cancel</button>
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
                        <th>From</th>
                        <th>To</th>
                        <th>Type</th>
                        <th>Shop</th>
                        <th>Enabled</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rules as $rule) : ?>
                    <tr>
                        <td><?= $rule->rule_name ?></td>
                        <td><?= $rule->from ?></td>
                        <td><?= $rule->to ?></td>
                        <td><?= $rule->type ?></td>
                        <td><?= $rule->shop_name ?></td>
                        <td><?php echo (int) $rule->is_enabled ? 'Yes' : 'No' ?></td>
                        <td><a href="/dna/rules/edit/<?= $rule->rule_id ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
