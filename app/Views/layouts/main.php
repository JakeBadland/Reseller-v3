<!DOCTYPE html>
<html dir="ltr" lang="">
<head>

    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reseller v5.8.7</title>

    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/custom.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css?<?=uniqid()?>">

</head>
<body>
<div class="header">
    <?php if(isset($shops)) : ?>
<!--    <img class="menu-icon" src="/img/menu.png">-->
    <button class="menu-icon btn btn-primary">Shops</button>
    <div class="menu panel">
            <?php foreach ($shops as $shop) : ?>
                <div><a href="/<?=$shop['shop_id']?>/1"><?=$shop['shop_name']?></a></div>
            <?php endforeach ?>
    </div>
    <label style="margin-left: 20px">
        <?php echo ($user)? $user->login : ''; ?>
    </label>

    <?= $paginator; ?>

    <?php endif ?>
</div>
<div class="body">
    <?= $this->renderSection('content') ?>
    <?= $this->renderSection('login') ?>
    <?= $this->renderSection('error') ?>
    <?= $this->renderSection('viber') ?>
    <?= $this->renderSection('radio') ?>
    <?= $this->renderSection('edit_order') ?>
    <?= $this->renderSection('test') ?>
</div>
<div class="footer"></div>

</body>
</html>