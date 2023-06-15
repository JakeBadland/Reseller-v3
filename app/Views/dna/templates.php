<?= $this->extend('layouts/dna'); ?>

<?= $this->section('rules'); ?>

<div class="container">
    <div class="card card-body panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Key</th>
                        <th>Sample value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($templates as $template) : ?>
                    <tr>
                        <td><?= $template->id ?></td>
                        <td><?= $template->key ?></td>
                        <td><?= substr($template->value, 0, 60) ?>...</td>
                        <td><a href="/dna/templates/edit/<?= $template->id ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
