<section class="details-card">
    <div class="row">
        <?php
        $results = $eap_client->fetchData($eap_client->methods['catalog']['popular']);

        if(!empty($results->{'popular'}->items_last_week)):

            foreach ($results->{'popular'}->items_last_week as $result):
                ?>
                <div class="col-md-4" style="margin-bottom: 10px;">
                    <div class="card-content">
                        <div class="card-img">
                            <?php if(isset($_GET['site']) && $_GET['site'] == 'audiojungle'): ?>
                                <audio controls class="card-audio">
                                    <source src="<?php echo $result->live_preview_url; ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <br/>
                            <?php else: ?>
                                <img style="height:210px;"
                                     src="<?php echo $result->live_preview_url; ?>"/>
                            <?php endif; ?>

                            <span class="card-img-title"><?php echo $result->item; ?></span>

                            <div class="card-img-info <?php if(isset($_GET['site']) && $_GET['site'] == 'audiojungle'): ?>card-audio-info<?php endif; ?>">
                                Author: <a href="<?php echo $result->user; ?>"><?php echo $result->user; ?></a> |
                                Rating: <?php echo $result->rating; ?> |
                                Sales: <?php echo $result->sales; ?>
                            </div>
                        </div>
                        <div class="card-desc" style="border-top: solid 1px #ccc">
                            <hr/>
                            <strong>$<?php echo $result->cost; ?></strong>
                            <a class="btn-card pull-right" href="<?php echo $result->url; ?>" target="_blank"> <i
                                        class="fa fa-eye"></i>
                                View</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>