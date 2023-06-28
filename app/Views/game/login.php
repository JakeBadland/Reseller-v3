<?= $this->extend('layouts/game'); ?>

<?= $this->section('login'); ?>

<div class="container login-form">
    <form action="/game/login" method="post">
        <input type="text" name="login" placeholder="Login"><br/><br/>
        <input type="password" name="password" placeholder="Password"><br/><br/>
        <input type="submit" value="Login">
        <div><?php echo isset($error)? $error: '' ?></div>
    </form>
</div>

<?= $this->endSection(); ?>