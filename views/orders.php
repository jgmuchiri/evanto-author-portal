<?php
$orders = $eap_client->fetchData($eap_client->methods['user']['purchases']);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><h4>Purchases <span class="badge"><?php echo $orders->count; ?></span> </h4></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Item</th>
                <th>Price</th>
                <th>License</th>
                <th>Support until</th>
                <th>Author</th>
                <th>Last update</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($orders->results)):
                foreach ($orders->results as $result): ?>
                    <tr>
                        <td><?php echo date('d M Y', strtotime($result->sold_at)); ?></td>
                        <td class="text-sm"><a target="_blank"
                               href="<?php echo $result->item->url; ?>"><?php echo $result->item->name; ?></a>
                            <br/>
                            <code><?php echo $result->code; ?></code>
                        </td>
                        <td>$<?php echo $result->amount; ?></td>
                        <td><?php echo $result->license; ?></td>
                        <td><?php echo date('d M Y', strtotime($result->supported_until)); ?></td>
                        <td><a target="_blank"
                               href="<?php echo $result->item->author_url; ?>"><?php echo $result->item->author_username; ?></a>
                        </td>
                        <td><?php echo date('d M Y', strtotime($result->item->updated_at)); ?></td>
                        <td>
                            <a href=""><i class="fa fa-download"></i> </a>
                        </td>
                    </tr>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    </div>
</div>
