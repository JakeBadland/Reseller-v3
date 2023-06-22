<!DOCTYPE html>
<html dir="ltr" lang="">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reseller v5.2.12</title>

    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/custom.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">

</head>
<body>
<div class="header">
    <?php if(isset($shops)) : ?>
    <img class="menu-icon" src="/img/menu.png">
    <div class="menu panel">
            <?php foreach ($shops as $shop) : ?>
                <div><a href="/<?=$shop['shop_id']?>"><?=$shop['shop_name']?></a></div>
            <?php endforeach ?>
    </div>
    <label style="margin-left: 20px">
        <?php echo ($user)? $user->login : ''; ?>
    </label>
    <?php endif ?>
</div>
<div class="body">
    <?= $this->renderSection('content') ?>
    <?= $this->renderSection('login') ?>
    <?= $this->renderSection('error') ?>
    <?= $this->renderSection('viber') ?>
</div>
<div class="footer"></div>

</body>
</html>