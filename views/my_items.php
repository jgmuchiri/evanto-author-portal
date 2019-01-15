<div class="panel border-success">
    <div class="panel-heading">
        <div class="panel-title"><h4>My Items</h4></div>
    </div>
    <div class="panel-body">

        <?php foreach ($eap_client->sites as $site):
            $uri = $eap_client->methods['profile']['newest'].','.$site.'.json';
            $my_items = $eap_client->fetchData($uri);
            ?>
            <h3><?php echo strtoupper($site); ?></h3>
            <div class="row">
                <?php if(!empty($my_items->{'new-files-from-user'})):
                    foreach ($my_items->{'new-files-from-user'} as $my_item):  ?>
                        <div class="col-sm-6" style="margin-bottom:10px">
                            <div class="row">
                                <div class="col-xs-2">
                                    <img src="<?php echo $my_item->thumbnail; ?>" class="thumbnail"/>
                                </div>
                                <div class="col-xs-10" style="padding-left:35px;">
                                    <strong>
                                        <a target="_blank"
                                           href="<?php echo $my_item->url; ?>"><?php echo $my_item->item; ?></a>
                                    </strong>
                                    <br/>
                                    <strong>price</strong>: $<?php echo $my_item->cost; ?> |
                                    <strong>rating</strong>: <?php echo $my_item->rating; ?> |
                                    <strong>sales</strong>: <?php echo $my_item->sales; ?> <br/>
                                    <strong>last update</strong>: <?php echo date('d M, Y', strtotime($my_item->last_update)); ?> |
                                    <strong>category</strong>: <?php echo $my_item->category; ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

