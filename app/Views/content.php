<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php $ruleModel = new \App\Models\RuleModel(); ?>

<div 
        id="container" 
        data-shop-id="<?=$shop_info->id?>" 
        data-shop-token="<?=$shop_info->token?>"
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

            <TR id="tr<?=$key?>" data-order-id="<?=$order->orderId?>">
                <TD>
                    <BUTTON <?=$back?> class="copy">Copy</BUTTON>
                </TD>
                <TD class="cards-button-td">
                    <BUTTON <?=$back?> class="cards">Cards</BUTTON>
                </TD>
                <TD class="storeName" style="background-color: rgb(<?=$color?>)"><?= $order->store ?></TD>
                <TD><?= $order->name ?></TD>
                <TD><?= $order->phone ?></TD>
                <TD><?= $order->address ?></TD>
                <TD><?= $order->date ?></TD>
                <TD><?= $order->orderId ?></TD>
                <TD><?= $order->price ?></TD>
                <TD><?= $order->deliveryProvider ?></TD>
                <TD><?= $order->description ?></TD>
                <TD style="background-color: rgb(0,255,255)"><?= $order->purchaseType ?></TD>

                <?php $ruleCard = $ruleModel->getRuleCard($shop_info, $order, true); ?>

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
                    <TD >
                        <a href="/viber/<?=$order->orderId?>/<?=$ruleCard->id?>"><BUTTON class="viber-btn">Viber</BUTTON></a>
                    </TD>
                <?php endif ?>

            </TR>

        <?php endforeach; ?>
    </TABLE>

    <div class="cards-menu">
        <div id="cards_list">
            <?php foreach ($cards as $card) : ?>
                <div><a href="#" class="short-card-item"><?=$card->short?></a></div>
            <?php endforeach; ?>
        </div>
        <div><a class="close-cards" href="#">Close</a></div>
    </div>
    
    <script>
        $(document).ready(function () {
            $('body').on('click', '.short-card-item', function () {
                let rowId = $('#container').attr('data-selected-row');
                $('#' + rowId).find('.card-short-name').text($(this).text());
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

            $('body').on('click', '.copy', function () {
                let $parentTr = $(this).closest('tr');
                let $parentTd = $(this).closest('td');
                let urlField = $parentTr.get(0);
                let $viberBtn = $parentTr.find('.viber-btn');
                let $cardsTd = $parentTr.find('.cards-button-td')

                $cardsTd.hide();

                //status : [ pending, received, delivered, canceled, draft, paid ]
                let data = {
                    order_id    : $parentTr.attr('data-order-id'),
                    token       : $('#container').attr('data-shop-token'),
                    status      : 'received'
                };

                $viberBtn.hide();
                $(this).css("background-color", "");
                $(this).parent('td').remove();

                // create a Range object
                let range = document.createRange();
                // set the Node to select the "range"
                range.selectNode(urlField);
                // add the Range to the set of window selections
                window.getSelection().addRange(range);
                // execute 'copy', can't 'cut' in this case
                document.execCommand('copy');

                window.getSelection().removeAllRanges();
                $parentTr.prepend($parentTd);
                $viberBtn.show();
                $cardsTd.show();

                $.post( "/change-status", data, function( data ) {
                    //console.log(data);
                });

            })

        });
    </script>
</div>

<?= $this->endSection(); ?>
