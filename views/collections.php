<?php
$collections = $eap_client->fetchData($eap_client->methods['profile']['collections']);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><h4>Collections</h4></div>
    </div>

</div>
<?php foreach ($collections->collections as $collection): ?>
    <div class="" style="padding:10px;border:solid 1px #333;margin-bottom:10px">
        <a target="_blank" href="https://codecanyon.net/collections/<?php echo $collections->id; ?>"><?php echo $collection->name; ?></a>
        <br/>
        <?php if(!empty($collections->description)): ?>
            <?php echo $collections->description; ?>
            <br/>
        <?php endif; ?>
        <?php echo $collections->private ? '<span class="label label-success">Private</span>' : '<span class="label label-danger">Public</span>'; ?>
    </div>
<?php endforeach; ?>