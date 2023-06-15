<?= $this->extend('layouts/dna'); ?>

<?= $this->section('edit_template'); ?>

<div class="container">
    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <form action="/dna/templates/edit" class="form-horizontal" method="post">
                <input type="hidden" name="id" value="<?=$template->id?>">
                <div class="form-group">
                    <textarea name="value" class="template-text"><?=$template->value?></textarea>
                </div>
                <div class="form-group">
                    <button style="margin-left: 15px;" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            <div>
                <label>Допустимые шаблонные ключи:</label>
            </div>
            '%FIRST_NAME%'
            '%MARKET%'
            '%PAY_DAY%'
            '%PAY_PERCENT%'
            '%BANK%'
            '%SUM1%'
            '%BANK_PERCENT%'
            '%SUM2%'
            '%SALE_ID%'
            '%DELIVERY_DAY%'
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
