<?php
$results = $eap_client->fetchData($eap_client->methods['catalog']['random']);
if(isset($_GET['site']) && !empty($_GET['site'])) {
    $site = $_GET['site'];
} else {
    $site = EVANTO_DEFAULT_SITE;
}

if(isset($_GET['type']) && !empty($_GET['type'])) {
    $type = $_GET['type'];
} else {
    $type = 'random';
}
?>
<h3>Browse Evanto <strong style="color:#a15f23"><?php echo ucfirst($site); ?></strong> Catalog</h3>
<br/>
<?php foreach ($eap_client->sites as $csite): ?>
    <a class="label label-default"
       style="padding:8px 10px;background:#9a8484"
       href="<?php echo '?page='.$_GET['page'].'&tab=browse&site='.$csite.'&type='.$type; ?>"><?php echo ucfirst($csite); ?></a>
<?php endforeach; ?>
<hr/>

<div class="btn-group" style="margin-bottom:5px;">
    <a href="<?php echo '?page='.$_GET['page'].'&tab=browse&site='.$site.'&type=random'; ?>"
       class="btn btn-default">Random</a>
    <a href="<?php echo '?page='.$_GET['page'].'&tab=browse&site='.$site.'&type=featured'; ?>"
       class="btn btn-default">Featured</a>
    <a href="<?php echo '?page='.$_GET['page'].'&tab=browse&site='.$site.'&type=popular'; ?>"
       class="btn btn-default">Popular</a>
</div>
<hr/>

<section class="details-card">
    <div class="row">
        <?php
        switch ($type) {
            case 'random':
                include "browse-random.php";
                break;
            case 'featured':
                include "browse-featured.php";
                break;
            case 'popular':
                include "browse-popular.php";
                break;
            default:
                include "browse-random.php";
                break;

        }

        ?>
    </div>
</section>

