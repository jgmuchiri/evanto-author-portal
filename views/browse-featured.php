<?php
$results = $eap_client->fetchData($eap_client->methods['catalog']['featured']);
if(!empty($results->features)):
    $result = $results->features->featured_file;
    $free = $results->features->free_file;
    ?>
    <div class="col-md-4" style="margin-bottom: 10px;">
        <h4>Featured file</h4>
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

                <hr/>
                <strong>$<?php echo $result->cost; ?></strong>
                <a class="btn-card pull-right" href="<?php echo $result->url; ?>" target="_blank">View</a>
            </div>
        </div>
    </div>

    <div class="col-md-4" style="margin-bottom: 10px;">
        <h4>Free file</h4>
        <div class="card-content">
            <div class="card-img">
                <?php if(isset($_GET['site']) && $_GET['site'] == 'audiojungle.net'): ?>
                    <audio controls>
                        <source src="<?php echo $free->live_preview_url; ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                <?php else: ?>
                    <img style="height:210px;"
                         src="<?php echo $free->live_preview_url; ?>"/>
                <?php endif; ?>


                <span class="card-img-title"><?php echo $free->item; ?></span>

                <div class="card-img-info">
                    Author: <a href="<?php echo $free->author_url; ?>"><?php echo $free->user; ?></a> |
                    Rating: <?php echo $free->rating; ?> |
                    Sales: <?php echo $free->sales; ?>
                </div>
            </div>
            <div class="card-desc" style="border-top: solid 1px #ccc">

                <hr/>
                <strong>$<?php echo $free->cost; ?></strong>
                <a class="btn-card pull-right" href="<?php echo $result->url; ?>" target="_blank">View</a>
            </div>
        </div>
    </div>
<?php endif; ?>
