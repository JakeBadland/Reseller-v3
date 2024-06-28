<?= $this->extend('layouts/main'); ?>

<?= $this->section('test'); ?>

<div class="container">
    <div class="card card-body panel panel-default">
        <div class="panel-body">

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
        console.log('redady');
        });
    });
</script>

<?= $this->endSection(); ?>
