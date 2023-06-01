<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_shop'); ?>

<div class="container">
    <button href="#" class="btn btn-primary toggle-panel">Add rule</button>
    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#delete-shop" aria-expanded="false" aria-controls="collapseExample" style="float: right">
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
                <input type="hidden" id="shop_id" name="id" value="<?=$shop->id?>">
                <div class="form-group">
                    <label for="name" class="col-xs-3 control-label">Name</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="name" name="name" value="<?=$shop->name?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="token" class="col-xs-3 control-label">Token</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="token" name="token" value="<?=$shop->token?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="color" class="col-xs-3 control-label">Color</label>
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

    <?php if ($rule) : ?>
        <div class="card card-body panel panel-default rule-panel">
            <input type="hidden" id="rule_id" value="<?=$rule->id?>">
            <div class="panel-body">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select card
                        <span class="caret"></span>
                    </button>
                    <input class="input-from" type="text" id="from" name="from" placeholder="from" value="<?= $rule->from ?>">
                    <input class="input-to" type="text" id="to" name="to" placeholder="to" value="<?= $rule->to ?>">
                    <input class="form-check-input btn-check enable-rule-btn" type="checkbox" value="" <?php if ($rule->enabled == '1') echo 'checked="checked"'; ?> id="is_enabled" />
                    <label class="form-check-label" for="is_enabled" checked>Rule enabled</label>
                    <ul class="dropdown-menu" aria-labelledby="Select-card">
                        <?php foreach ($cards as $card): ?>
                            <li><a href="#" class="card-link" data-id="<?= $card->id ?>"><?= $card->name ?></a></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <br/>
                <div class="card card-body panel panel-default">
                    <div class="panel-body selected-cards">
                        <?php foreach ($rule_cards as $card) : ?>
                            <div><a href="#" data-id="<?=$card->id?>"> <?=$card->name?> </a></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div>
                    <input type="radio" name="select_type" value="cyclically" <?php if ($rule->type == 'cyclically') echo 'checked="checked"'; ?>>
                    <label for="selectType1">Cyclically</label>

                    <input type="radio" name="select_type" value="random" <?php if ($rule->type == 'random') echo 'checked="checked"'; ?>>
                    <label for="selectType2">Random</label>
                </div>
                <?php if ($rule) : ?>
                    <button type="submit" style="" class="btn btn-primary update-rule">Update rule</button>
                <?php else : ?>
                    <button type="submit" style="" class="btn btn-primary save-rule">Save rule</button>
                <?php endif ?>
                <button type="submit" style="float: right" class="btn btn-primary delete-rule">Delete rule</button>
            </div>
    <?php else : ?>
        <div class="card card-body panel panel-default rule-panel" style="display: none">
            <div class="panel-body">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select card
                        <span class="caret"></span>
                    </button>
                    <input class="input-from" type="text" id="from" name="from" placeholder="from">
                    <input class="input-to" type="text" id="to" name="to" placeholder="to">
                    <input class="form-check-input btn-check enable-rule-btn" type="checkbox" value="" checked="checked" id="is_enabled" />
                    <label class="form-check-label" for="is_enabled" checked>Rule enabled</label>
                    <ul class="dropdown-menu" aria-labelledby="Select-card">
                        <?php foreach ($cards as $card): ?>
                            <li><a href="#" class="card-link" data-id="<?= $card->id ?>"><?= $card->name ?></a></li>
                        <?php endforeach ?>
                    </ul>
                </div>

                <br/>
                <div class="card card-body panel panel-default">
                    <div class="panel-body selected-cards">

                    </div>
                </div>

                <div>
                    <input type="radio" name="select_type" value="cyclically" checked="checked">
                    <label for="selectType1">Cyclically</label>

                    <input type="radio" name="select_type" value="random">
                    <label for="selectType2">Random</label>
                </div>

                <button type="submit" style="" class="btn btn-primary save-rule">Save rule</button>
                <button type="submit" style="float: right" class="btn btn-primary delete-rule">Delete rule</button>
            </div>

            <?php endif ?>

    </div>
</div>

<script>
    $(document).ready(function () {
        $('body').on('click', '.card-link', function () {
            $('.selected-cards').append('<div><a href=# data-id=' + $(this).attr('data-id') + '>' + $(this).text() + '</a></div>')
        });
        
        $('.selected-cards').on('click', 'a', function (){
            $(this).parent('div').remove();
        })

        $('body').on('click', '.toggle-panel', function () {
            $('.rule-panel').show();
        });

        $('body').on('click', '.save-rule', function () {
            let data = {};
            
            data.from = $('.input-from').val();
            data.to = $('.input-to').val();
            data.enabled = ($('#is_enabled').is(':checked') ? 1 : 0);
            data.type = $('input:radio[name="select_type"]:checked').val();
            data.shop_id = $('#shop_id').val();
            data.cards = [];

            let cards = $('.selected-cards div a');
            for (let i = 0; i<cards.length; i++){
                data.cards.push($(cards[i]).attr('data-id'));
            }

            $.post("/dna/rules/add", data, function( result ) {
                $('.rule-panel').hide();
                window.alert('Rule saved');
                //console.log(result);
            });
        });

        $('body').on('click', '.update-rule', function () {
            let data = {};

            data.from = $('.input-from').val();
            data.to = $('.input-to').val();
            data.enabled = ($('#is_enabled').is(':checked') ? 1 : 0);
            data.type = $('input:radio[name="select_type"]:checked').val();
            data.shop_id = $('#shop_id').val();
            data.rule_id = $('#rule_id').val();
            data.cards = [];

            let cards = $('.selected-cards div a');
            for (let i = 0; i<cards.length; i++){
                data.cards.push($(cards[i]).attr('data-id'));
            }

            $.post("/dna/rules/update", data, function( result ) {
                $('.rule-panel').hide();
                window.alert('Rule updated');
            });
        });

        $('body').on('click', '.delete-rule', function () {
            let data = {};

            $('.rule-panel').hide();
            data.rule_id = $('#rule_id').val();

            $.post("/dna/rules/delete", data, function( result ) {
                $('.rule-panel').hide();
                window.alert('Rule deleted');
            });

        });
    });
</script>

<?= $this->endSection(); ?>
