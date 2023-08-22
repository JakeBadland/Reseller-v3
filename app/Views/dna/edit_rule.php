<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_rule'); ?>

<div class="container">
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#delete-rule" aria-expanded="false" aria-controls="collapseExample" style="float: right">
        Delete rule
    </button>
    <br/>
    <br/>

    <div class="collapse" id="delete-rule">
        <div class="card card-body panel panel-default">
            <div class="panel-body">
                <form action="/dna/rules/delete" class="form-horizontal" method="post">
                    <h3 class="col-xs-3 control-label">Are you sure?</h3>
                    <div class="form-group">
                        <div class="col-xs-5">
                            <input type="hidden" class="form-control" name="rule_id" value="<?=$rule->id?>">
                        </div>
                    </div>
                    <button type="submit">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <form action="/dna/rules/edit" class="form-horizontal" method="post">
                <input type="hidden" name="id" value="<?=$rule->id?>">
                <div class="form-group">
                    <label for="name" class="col-xs-3 control-label">Name</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?=$rule->name?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="from" class="col-xs-3 control-label">From</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="from" name="from" value="<?=$rule->from?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="to" class="col-xs-3 control-label">To</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="to" name="to" value="<?=$rule->to?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="col-xs-3 control-label">Type</label>
                    <div class="col-xs-5">
                        <select id="type" name="type">
                            <option value="cyclically" <?php if ($rule->type == 'cyclically'): echo 'selected="selected"'?><?php endif?>>Cyclically</option>
                            <option value="random" <?php if ($rule->type == 'random'): echo 'selected="selected"'?><?php endif?>>Random</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="shop_id" class="col-xs-3 control-label">Shop</label>
                    <div class="col-xs-5">
                        <select id="shop_id" name="shop_id">
                            <?php foreach ($shops as $shop) : ?>
                                <option value="<?=$shop->id?>" <?php if ($rule->shop_id == $shop->id) echo 'selected="selected"'?>><?= $shop->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="is_enabled" class="col-xs-3 control-label">Enabled</label>
                    <div class="col-xs-5">
                        <input type="checkbox" class="check-big" id="is_enabled" name="is_enabled" <?php if ((int) $rule->is_enabled) echo 'checked="checked"';?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label"></label>
                    <div class="col-xs-5">
                        <br/>
                        <button class="btn btn-primary dropdown-toggle" type="button" id="add_card" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select card
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="Select-card">
                            <?php foreach ($cards as $card): ?>
                                <li><a href="#" class="card-link" data-id="<?= $card->id ?>"><?= $card->bank ?> <?= $card->name ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="rule_cards" id="rule_cards" value="<?php foreach ($rule_cards as $card): echo $card->id . ','; endforeach; ?>">
                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-5">
                        <div class="card card-body panel panel-default">
                            <div class="list-group selected-cards">
                                <?php foreach ($rule_cards as $card) : ?>
                                <div class="rule-card-item">
                                    <a href="#" class="" data-id="<?= $card->id ?>"><?= $card->bank ?> <?= $card->name ?></a>
                                    <a style="float: right" href="/dna/cards/edit/<?=$card->id?>">edit</a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
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

<script>
    $(document).ready(function () {
        $('body').on('click', '.card-link', function () {
            $('.selected-cards').append('<div class="rule-card-item"><a href="#" data-id=' + $(this).attr('data-id') + '>' + $(this).text() + '</a><a class="fr" href="/dna/cards/edit/' + $(this).attr('data-id') + '">edit</a></div>')
            recalculate();
        });

        $('.selected-cards').on('click', 'a', function (){
            $(this).parent('div').remove();
            recalculate();
        })
    });

    function recalculate(){
        let cards = $('.selected-cards').find('a');
        let ids = '';
        $.each(cards, function (i, card) {
            ids += $(card).attr('data-id') + ',';
        });
        $('#rule_cards').val(ids);
    }
</script>

<?= $this->endSection(); ?>
