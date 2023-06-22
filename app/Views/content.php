<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php $ruleModel = new \App\Models\RuleModel(); ?>

<div class="">
    <TABLE>
        <?php foreach ($orders as $key => $order): ?>

            <?php $back = ''; ?>

            <?php if (!$order->address || !$order->deliveryProvider) : ?>
                <?php $back = "style='background-color: red'"; ?>
            <?php endif ?>

            <?php if ($order->status == 'pending') : ?>
                <?php $back = "style='background-color: yellow'"; ?>
            <?php endif ?>

            <TR id="tr<?=$key?>" >
                <TD >
                    <BUTTON <?=$back?> class="copy">Copy</BUTTON>
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
                    <TD style="background-color: rgb(255,0,255)"><?= $ruleCard->short ?></TD>
                    <TD></TD>
                <?php endif ?>
                <?php if ($order->prepaid): ?>
                    <TD style="background-color: rgb(255,0,255)"><?= $ruleCard->short ?></TD>
                <?php endif ?>

                <?php if ($order->purchaseType) : ?>
                <TD >
                    <a href="/viber/<?=$order->orderId?>/<?=$ruleCard->id?>"><BUTTON class="">Viber</BUTTON></a>
                </TD>
                <?php endif ?>

            </TR>

        <?php endforeach; ?>
    </TABLE>

    <script>
        $(document).ready(function () {

            $('body').on('click', '.copy', function () {
                let $parentTr = $(this).closest('tr');
                let $parentTd = $(this).closest('td');

                let urlField = $parentTr.get(0);
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
            })

        });
    </script>
</div>

<?= $this->endSection(); ?>
