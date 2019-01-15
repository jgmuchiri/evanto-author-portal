<?php
$results = $eap_client->fetchData($eap_client->methods['catalog']['random']);
if(!empty($results->{'random-new-files'})):

    foreach ($results->{'random-new-files'} as $result):
        ?>
        <div class="col-md-4" style="margin-bottom: 10px;">
            <div class="card-content">
                <div class="card-img">
                    <?php if(isset($_GET['site']) && $_GET['site'] == 'audiojungle'):  ?>
                        <audio controls>
                            <source src="<?php echo $result->live_preview_url; ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    <?php else: ?>
                        <img style="height:210px;"
                             src="<?php echo $result->live_preview_url; ?>"/>
                    <?php endif; ?>


                    <span class="card-img-title"><?php echo $result->item; ?></span>

                    <div class="card-img-info">
                        Author: <a href="<?php echo $result->author_url; ?>"><?php echo $result->user; ?></a> |
                        Rating: <?php echo $result->rating; ?> |
                        Sales: <?php echo $result->sales; ?>
                    </div>
                </div>
                <div class="card-desc" style="border-top: solid 1px #ccc">
                    <div class="card-summary"><?php echo $item->summary; ?></div>
                    <hr/>
                    <strong>$<?php echo $result->cost; ?></strong>
                    <a class="btn-card pull-right" href="<?php echo $result->url; ?>" target="_blank">View</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
