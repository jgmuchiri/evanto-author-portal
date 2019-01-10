<?php
$purchases = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.EAP_VERIFIED_PURCHASES);
if(isset($_POST['dump_purchases']))
{
    $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.EAP_VERIFIED_PURCHASES);
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><h4>Verified Purchases</h4></div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Buyer</th>
                <th>Purchase date</th>
                <th>Licence type</th>
                <th>Support ends</th>
            </tr>
            </thead>
            <?php foreach ($purchases as $purchase): ?>
                <tr>
                    <td><?php echo $purchase->item_id; ?></td>
                    <td><?php echo $purchase->item_name; ?></td>
                    <td><?php echo $purchase->buyer; ?></td>
                    <td><?php echo date('d M Y H:ia', strtotime($purchase->created_at)); ?></td>
                    <td><?php echo $purchase->licence; ?></td>
                    <td><?php echo date('d M Y H:ia', strtotime($purchase->supported_until)); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="panel-footer">
        <form method="post" onsubmit="deletePurchases()">
            <input type="hidden" name="dump_purchases"/>
            <button class="btn btn-danger btn-xs">DELETE ALL PURCHASES</button>
        </form>
    </div>
</div>