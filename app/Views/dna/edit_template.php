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
            <pre>
'%FIRST_NAME%'      - Имя покупателя
'%MARKET%'          - Название магазина
'%PAY_DAY%'         - День оплаты
'%PAY_PERCENT%'     - Сумма предоплаты
'%BANK%'            - Реквизиты для оплаты
'%SUM1%'            - Сумма заказа
'%BANK_PERCENT%'    - Банковкий процент
'%SUM2%'            - Итоговая сумма с учетом процента банка
'%SALE_ID%'         - Номер заказа
'%DELIVERY_DAY%'    - День отправки
            </pre>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
