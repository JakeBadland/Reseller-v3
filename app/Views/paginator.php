<div class="pager">
    <?php if ($pager['first'] != $pager['left']) : ?>
    <a href="/<?=$shopId?>/<?=$pager['first']?>"><button class="pager-btn">First</button></a>
    <?php endif ?>
    <?php if ($pager['current'] > $pager['first']) : ?>
    <a href="/<?=$shopId?>/<?=$pager['left']?>"><button class="pager-btn"><?=$pager['left']?></button></a>
    <?php endif ?>
    <button class="pager-btn"><?=$pager['current']?></button>
    <?php if ($pager['current'] < $pager['last']) : ?>
    <a href="/<?=$shopId?>/<?=$pager['right']?>"><button class="pager-btn"><?=$pager['right']?></button></a>
    <?php endif ?>
    <?php if ($pager['last'] != $pager['right']) : ?>
    <a href="/<?=$shopId?>/<?=$pager['last']?>"><button class="pager-btn">Last</button></a>
    <?php endif ?>
</div>