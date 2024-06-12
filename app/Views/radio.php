<?= $this->extend('layouts/main'); ?>

<?= $this->section('radio'); ?>

<?php

$user = new \App\Models\UserModel();
$user = $user->get();

?>

<div class="container">
    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <table>
                <tr>
                    <th class="col-xs-3">Name</th>
                    <th class="col-xs-3">Link</th>
                    <?php if ($user) : ?>
                        <td class="col-xs-3">Views</td>
                    <?php endif; ?>
                </tr>

                <?php foreach ($stations as $item) : ?>
                    <tr data-radio-id="<?= $item->id ?>">
                        <td class="col-xs-3"><?= $item->name ?></td>
                        <td class="col-xs-3">
                            <a target="_blank" class="radio-link" href="<?= $item->link ?>"><?= $item->link ?></a>
                        </td>
                        <?php if ($user) : ?>
                        <td class="col-xs-3"><?= $item->views ?></td>
                        <?php endif; ?>
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

<script>
    $(document).ready(function () {
        $('body').on('click', '.radio-link', function (e) {
            e.preventDefault();

            let data = {
                'radio_id'  : $(this).parents('tr').attr('data-radio-id'),
                'link'      : $(this).attr('href')
            };

            $.post( "/radio-up", data, function() {
                window.location.href = data.link;
            });
        });
    });
</script>

<?= $this->endSection(); ?>
