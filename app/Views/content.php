<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php $ruleModel = new \App\Models\RuleModel(); ?>

<div 
        id="container" 
        data-shop-id="<?=$shopInfo->id?>"
        data-shop-token="<?=$shopInfo->token?>"
        data-selected-row=""
>
    <TABLE>
        <?php foreach ($orders as $key => $order): ?>
            <?php $back = ''; ?>
            <?php if (!$order->address || !$order->deliveryProvider) : ?>
                <?php $back = "style='background-color: red'"; ?>
            <?php endif ?>
            <?php if ($order->status == 'pending') : ?>
                <?php $back = "style='background-color: yellow'"; ?>
            <?php endif ?>
            <?php if ($order->purchaseType == 'Пром-оплата' && $order->status !== 'received') : ?>
                <?php $back = "style='background-color: blue'"; ?>
            <?php endif ?>
            <?php $ruleCard = $ruleModel->getRuleCard($shopInfo, $order, true); ?>
            <TR id="tr<?=$key?>"
                data-order-id="<?=$order->orderId?>"
                data-selected-card-id="<?= $ruleCard->id ?>"
            >
                <TD>
                    <BUTTON <?=$back?> class="copy">Copy</BUTTON>
                </TD>
                <TD class="storeName" style="background-color: rgb(<?=$shopInfo->color?>)"><?= $order->store ?></TD>
                <TD><?= $order->name ?></TD>
                <TD><?= $order->phone ?></TD>
                <TD><?= $order->address ?></TD>
                <TD><?= $order->date ?></TD>
                <TD><?= $order->orderId ?></TD>
                <TD><input type="hidden" class="final-price" value="<?= $order->finalPrice ?>"><?= $order->price ?></TD>
                <TD><?= $order->deliveryProvider ?></TD>
                <TD><?= $order->description ?></TD>
                <TD style="background-color: rgb(0,255,255)"><?= $order->purchaseType ?></TD>
                <?php if ($order->prepaid): ?>
                    <TD><?= $order->prepaid ?></TD>
                <?php else : ?>
                    <TD class="card-short-name" style="background-color: rgb(255,0,255)"><?= $ruleCard->short ?></TD>
                    <TD></TD>
                <?php endif ?>
                <?php if ($order->prepaid): ?>
                    <TD style="background-color: rgb(255,0,255)" class="card-short-name"><?= $ruleCard->short ?></TD>
                <?php endif ?>
                <?php if ($order->purchaseType) : ?>
                    <TD><a href="/viber/<?=$order->orderId?>/<?=$ruleCard->id?>"><BUTTON class="viber-btn">Viber</BUTTON></a></TD>
                <?php endif ?>
                <TD class="edit-button-td">
                    <a class="edit-btn" href="/edit-order/<?= $order->orderId ?>"><BUTTON>Edit</BUTTON></a>
                </TD>
            </TR>
        <?php endforeach; ?>
    </TABLE>
    <?= $paginator; ?>

    <!--
    <div class="cards-menu">
        <div id="cards_list">
            <?php foreach ($cards as $card) : ?>
                    <div class="short-card-item" href="#" data-card-id="<?=$card->id?>">
                        <span class="short-card-name"><?=$card->short?></span>
                        [<span class="balance-current"><?=$card->current_balance?></span>
                        /
                        <span class="balance-limit"><?= $card->limit_balance ?>
                        </span>]
                    </div>
            <?php endforeach; ?>
        </div>
        <div><a class="close-cards" href="#">Close</a></div>
    </div>
    -->
    
    <script>
        let global = {
            balanceCurrent : 3
        };

        function getCurrentBalance(cardId){
            let result = 0;
            $('#cards_list').find('.short-card-item').each(function( index ) {
                if ($(this).attr('data-card-id') == cardId){
                    result = parseInt($(this).find('.balance-current').text());
                }
            });
            if (result){return result;} else {return 0;}
        }

        function setCurrentBalance(cardId, balance){
            $('#cards_list').find('.short-card-item').each(function( index ) {
                if ($(this).attr('data-card-id') == cardId){
                    $(this).find('.balance-current').text(balance);
                }
            });
        }

        function copyRow($this){
            let $parentTr = $this.closest('tr');
            let $parentTd = $this.closest('td');
            let $viberBtn = $parentTr.find('.viber-btn').closest('td');
            let $editBtn = $parentTr.find('.edit-btn').closest('td');

            //prepare for copy
            //navigator.clipboard.writeText('');
            window.getSelection().removeAllRanges();
            $viberBtn.hide();
            $editBtn.hide();
            $this.css("background-color", "");
            $parentTd.remove();

            // create a Range object
            let urlField = $parentTr.get(0);
            let range = document.createRange();
            // set the Node to select the "range"
            range.selectNode(urlField);
            // add the Range to the set of window selections
            window.getSelection().addRange(range);
            // execute 'copy', can't 'cut' in this case
            document.execCommand('copy');

            //restore interface elements
            window.getSelection().removeAllRanges();
            $parentTr.prepend($parentTd);
            $viberBtn.show();
            $editBtn.show();
        }
        
        $(document).ready(function () {
            /*
            $('body').on('click', '.short-card-item', function () {
                let $balanceCurrent = $(this).find('.balance-current');
                let $balanceLimit = $(this).find('.balance-limit');

                let rowId = $('#container').attr('data-selected-row');
                
                let $row = $('#' + rowId);
                let price = parseInt($row.find('.final-price').val());

                if ( (parseInt($balanceCurrent.text()) + price) > parseInt($balanceLimit.text()) ){
                    window.alert('Warning! The allowable limit will be exceeded. Ignoring...');
                    return;
                }
                
                //save card id
                $('#' + rowId).attr('data-selected-card-id', $(this).attr('data-card-id'));
                
                //show card name
                $row.find('.card-short-name').text($(this).find('.short-card-name').text());
            });
            
            $('body').on('click', '.cards', function () {
                let $cards = $('.cards-menu');
                
                //save selected row id
                $('#container').attr('data-selected-row', $(this).closest('tr').attr('id'));

                $cards.css('top', $(this).position().top + 27 + 'px');
                $cards.show();
             });

            $('body').on('click', '.close-cards', function () {
                $('.cards-menu').hide();
            });
            */

            $('body').on('click', '.copy', function () {
                let $this = $(this);
                let $parentTr = $this.closest('tr');
                let cardId = $parentTr.attr('data-selected-card-id');
                let orderPrice = $parentTr.find('.final-price').val();

                $.post( "/get-current-balance", {cardId}, function( data ) {
                    data = JSON.parse(data);
                    let balanceCurrent = parseInt(data.balance);
                    balanceCurrent += parseInt(orderPrice);

                    copyRow($this);

                    data = {
                        order_id    : $parentTr.attr('data-order-id'),
                        token       : $('#container').attr('data-shop-token'),
                        status      : 'received'
                        //status : [ pending, received, delivered, canceled, draft, paid ]
                    };
                    $.post( "/change-status", data, function( data ) {});

                    data = {
                        'card_id' : cardId,
                        'price' : balanceCurrent
                    };
                    $.post( "/set-current-balance", data, function( data ) {});
                });
            })
        });
    </script>
</div>

<?= $this->endSection(); ?>
