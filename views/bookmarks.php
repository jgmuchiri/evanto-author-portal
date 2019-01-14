<?php
$bookmarks = $eap_client->fetchData($eap_client->methods['user']['bookmarks']);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><h4>Bookmarks</h4></div>
    </div>
    <div class="panel-body">

        <div class="row">
            <?php if(!empty($bookmarks->bookmarks)):

                foreach ($bookmarks->bookmarks as $bookmark):

                    $item = $eap_client->fetchData($eap_client->methods['catalog']['item'].'?id='.$bookmark->item_id);
                    ?>
                    <div style="padding:10px;margin-bottom:10px" class="col-sm-6">
                        <div class="row">
                            <div class="col-xs-2">
                                <img src="<?php echo $item->previews->icon_preview->icon_url; ?>"/>
                            </div>
                            <div class="col-xs-10">
                                <strong><a target="_blank" href="<?php echo $item->url; ?>"><?php echo $item->name; ?></a></strong>
                                <br/>
                                <span class="text-muted">
                            rating: <?php echo $item->rating; ?> by <?php echo $item->rating_count; ?> users
                            | sales: <?php echo $item->number_of_sales; ?>
                        </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>

</div>
