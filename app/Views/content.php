<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

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
                <TD><?= $order->id ?></TD>
                <TD><?= $order->price ?></TD>
                <TD><?= $order->deliveryProvider ?></TD>
                <TD><?= $order->description ?></TD>
                <TD style="background-color: rgb(0,255,255)"><?= $order->purchaseType ?></TD>
                <TD><?= $order->prepaid ?></TD>
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

                /*
                let tmpElement = $('<textarea style="opacity:0;"></textarea>');
                let parent = $(this).closest('td').siblings().each(function () {
                    tmpElement.html(tmpElement.html() + $(this).html() + '\t'); //
                });

                tmpElement.appendTo($('body')).focus().select();
                document.execCommand("copy");
                tmpElement.remove();
                */
            })

        });
    </script>
</div>

<?= $this->endSection(); ?>
