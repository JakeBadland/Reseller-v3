<?= $this->extend('layouts/main'); ?>

<?= $this->section('viber'); ?>

<div class="container">
    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <form action="" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="name" class="col-xs-3 control-label">Phone</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $order->phone ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-xs-3 control-label">Text</label>
                    <div class="col-xs-5" >
                        <div style="width: 100%; height: 200px;" id="template"><?=$template?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pay_day" class="col-xs-3 control-label">Pay day</label>
                    <div class="col-xs-5">
                        <select id="pay_day" name="pay_day">
                            <option value="завтра">завтра</option>
                            <option value="понеділок">понеділок</option>
                            <option value="вівторок">вівторок</option>
                            <option value="середа">середа</option>
                            <option value="четвер">четвер</option>
                            <option value="п'ятниця">п'ятниця</option>
                            <option value="субота">субота</option>
                            <option value="неділя">неділя</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="send_day" class="col-xs-3 control-label">Send day</label>
                    <div class="col-xs-5">
                        <select id="send_day" name="send_day">
                            <option value="завтра">завтра</option>
                            <option value="понеділок">понеділок</option>
                            <option value="вівторок">вівторок</option>
                            <option value="середа">середа</option>
                            <option value="четвер">четвер</option>
                            <option value="п'ятниця">п'ятниця</option>
                            <option value="субота">субота</option>
                            <option value="неділя">неділя</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <!--<button type="button" class="btn btn-primary">Send</button>-->
                        <button type="button" id="copy_text" class="btn btn-primary">Copy message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('body').on('change', '#pay_day', function () {
            let day = $(this).find(':selected').text();
            $('#pay_day_label').text(day);
        });

        $('body').on('change', '#send_day', function () {
            let day = $(this).find(':selected').text();
            $('#delivery_day_label').text(day);
        });

        $('body').on('click', '#copy_text', function () {
            // create a Range object
            let range = document.createRange();
            // set the Node to select the "range"
            range.selectNode($('#template').get(0));
            // add the Range to the set of window selections
            window.getSelection().addRange(range);
            // execute 'copy', can't 'cut' in this case
            document.execCommand('copy');

            window.getSelection().removeAllRanges();
        });
    });
</script>

<?= $this->endSection(); ?>
