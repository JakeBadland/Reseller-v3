<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_shop'); ?>

<div class="container">
    <!--<button href="#" class="btn btn-primary toggle-panel">Add rule</button>-->
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
</div>



<script>
    $(document).ready(function () {
        /*
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
        */
    });
</script>

<?= $this->endSection(); ?>
