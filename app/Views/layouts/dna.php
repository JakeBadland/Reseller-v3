<!DOCTYPE html>
<html dir="ltr" lang="">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reseller</title>

    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/custom.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">

</head>
<body>

<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
<!--                    class="active"-->
                    <li><a href="/dna/users">Users</a></li>
<!--                    <li><a href="#">Roles</a></li>-->
                    <li><a href="/dna/shops">Shops</a></li>
                    <li><a href="/dna/cards">Cards</a></li>
                    <li><a href="/dna/rules">Rules</a></li>
                    <li><a href="/dna/templates">Templates</a></li>
                    <!--<li><a href="#">Items</a></li>-->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div>
    <?= $this->renderSection('users') ?>
    <?= $this->renderSection('shops') ?>
    <?= $this->renderSection('items') ?>
    <?= $this->renderSection('cards') ?>
    <?= $this->renderSection('rules') ?>
    <?= $this->renderSection('templates') ?>
    <?= $this->renderSection('edit_user') ?>
    <?= $this->renderSection('edit_shop') ?>
    <?= $this->renderSection('edit_rule') ?>
    <?= $this->renderSection('edit_template') ?>
    <?= $this->renderSection('error') ?>
</div>
<div class="footer"></div>

</body>
</html>