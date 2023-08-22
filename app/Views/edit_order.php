<?= $this->extend('layouts/main'); ?>

<?= $this->section('edit_order'); ?>

<?php $ruleModel = new \App\Models\RuleModel(); ?>

<div class="container">
    <TABLE>
        <?php $back = ''; ?>
        <?php if (!$order->address || !$order->deliveryProvider) : ?>
            <?php $back = "style='background-color: red'"; ?>
        <?php endif ?>
        <?php if ($order->status == 'pending') : ?>
            <?php $back = "style='background-color: yellow'"; ?>
        <?php endif ?>
        <?php $ruleCard = $ruleModel->getRuleCard($shopInfo, $order, true); ?>
        <TR id="row"
            data-order-id="<?= $order->orderId ?>"
            data-selected-card-id="<?= $ruleCard->id ?>"
        >
            <TD class="storeName" style="background-color: rgb(<?= $shopInfo->color ?>)"><?= $order->store ?></TD>
            <TD><?= $order->name ?></TD>
            <TD><?= $order->phone ?></TD>
            <TD><?= $order->address ?></TD>
            <TD><?= $order->date ?></TD>
            <TD><?= $order->orderId ?></TD>
            <TD><input type="hidden" class="final-price" value="<?= $order->finalPrice ?>"><?= $order->price ?>
            </TD>
            <TD><?= $order->deliveryProvider ?></TD>
            <TD><?= $order->description ?></TD>
            <TD style="background-color: rgb(0,255,255)"><?= $order->purchaseType ?></TD>
            <?php if ($order->prepaid): ?>
                <TD><?= $order->prepaid ?></TD>
            <?php else : ?>
                <TD class="card-short-name"
                    style="background-color: rgb(255,0,255)"><?= $ruleCard->short ?></TD>
            <?php endif ?>
            <?php if ($order->prepaid): ?>
                <TD style="background-color: rgb(255,0,255)"
                    class="card-short-name"><?= $ruleCard->short ?></TD>
            <?php endif ?>
        </TR>
    </TABLE>
    <br/>
    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <label for="final_price">Add to balance: </label>
            <input type="text" id="final_price" value="<?= $order->finalPrice ?>">
            <br/>
            <br/>
            <label for="">Cards: </label>
            <div id="cards_list">
                <?php foreach ($cards as $card) : ?>
                    <div class="short-card-item <?php echo ($card->id == $ruleCard->id)? 'selected': ''?>"
                         href="#"
                         data-card-id="<?= $card->id ?>">
                        <span class="short-card-name"><?= $card->short ?></span>
                        [<span class="balance-current"><?= $card->current_balance ?></span>
                        /
                        <span class="balance-limit"><?= $card->limit_balance ?></span>]
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <button id="copy_btn">Copy</button>
            <button id="back_btn" class="fr">Back</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let cardId = <?= $ruleCard->id ?>;

        function setCurrentBalance(cardId, balance) {
            $('#cards_list').find('.short-card-item').each(function (index) {
                if ($(this).attr('data-card-id') == cardId) {
                    $(this).find('.balance-current').text(balance);
                }
            });
        }

        $('body').on('click', '.short-card-item', function () {
            let cardName = $(this).find('.short-card-name').text();
            cardId = $(this).attr('data-card-id');

            $('#row').find('.card-short-name').text(cardName);

            $(".short-card-item"). removeClass('selected');
            $(this).addClass('selected');
        });

        $('body').on('click', '#copy_btn', function () {
            let $parentTr = $('#row');
            let finalPrice = $('#final_price').val();

            //navigator.clipboard.writeText('');
            window.getSelection().removeAllRanges();

            // create a Range object
            let urlField = $parentTr.get(0);
            let range = document.createRange();
            // set the Node to select the "range"
            range.selectNode(urlField);
            // add the Range to the set of window selections
            window.getSelection().addRange(range);
            // execute 'copy', can't 'cut' in this case
            document.execCommand('copy');

            window.getSelection().removeAllRanges();

            $.post("/get-current-balance", {cardId}, function (data) {
                data = JSON.parse(data);
                let balanceCurrent = parseInt(data.balance);
                balanceCurrent += parseInt(finalPrice);

                data = {
                    order_id: $parentTr.attr('data-order-id'),
                    token: '<?= $shopInfo->token ?>',
                    status: 'received'
                    //status : [ pending, received, delivered, canceled, draft, paid ]
                };
                $.post("/change-status", data, function (data) {
                });

                data = {
                    'card_id': cardId,
                    'price': balanceCurrent
                };
                $.post("/set-current-balance", data, function (data) {
                });

                setCurrentBalance(cardId, balanceCurrent);
            });
        });

        $('body').on('click', '#back_btn', function () {
            history.back();
        });

    });
</script>

<?= $this->endSection(); ?>
