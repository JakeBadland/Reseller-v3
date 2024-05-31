<?= $this->extend('layouts/main'); ?>

<?= $this->section('radio'); ?>

<div class="container">
    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <table>
                <tr>
                    <th class="col-xs-3">Name</th>
                    <th class="col-xs-3">Link</th>
                </tr>

                <?php foreach ($stations as $item) : ?>
                    <tr>
                        <td class="col-xs-3"><?= $item['name'] ?></td>
                        <td class="col-xs-3"><a target="_blank" href="<?= $item['link'] ?>"><?= $item['link'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    table{
        width: 100%;
    }
</style>

<?= $this->endSection(); ?>
