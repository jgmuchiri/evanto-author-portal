<?php
$collections = $eap_client->fetchData($eap_client->methods['profile']['collections']);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><h4>Collections</h4></div>
    </div>

    <div class="panel-body">

        <?php if(!empty($collections->collections)):
            foreach ($collections->collections as $collection):
                $items = $eap_client->fetchData($eap_client->methods['profile']['collection'].'?id='.$collection->id);
                ?>
                <div class="" style="padding:10px;border:solid 1px #333;margin-bottom:10px">
                    <h3><a target="_blank"
                           href="https://codecanyon.net/collections/<?php echo $collection->id; ?>"><?php echo $collection->name; ?></a>
                        <span class="text-right text-sm">
                <span class="badge"><?php echo $collection->item_count; ?></span>
            | <?php echo $collection->private ? '<span class="label label-success">Private</span>' : '<span class="label label-danger">Public</span>'; ?>
            </span>
                    </h3>
                    <?php if(!empty($collection->description)): ?>
                        <hr/>
                        <?php echo $collection->description; ?>
                    <?php endif; ?>
                    <hr/>
                    <div class="row">
                        <?php foreach ($items->items as $item): ?>
                            <div class="col-sm-6" style="margin-bottom:10px">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <img class="thumbnail" src="<?php echo $item->previews->icon_preview->icon_url; ?>"/>
                                    </div>
                                    <div class="col-xs-10" style="padding-left:35px;vertical-align: middle;">
                                        <a target="_blank" href="<?php echo $item->url; ?>"><?php echo $item->name; ?></a>
                                        <br/>
                                        <a href=""
                                        <span class="text-muted">
                            rating: <?php echo $item->rating; ?> by <?php echo $item->rating_count; ?> users
                            | sales: <?php echo $item->number_of_sales; ?>
                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach;
        endif; ?>
    </div>

</div>