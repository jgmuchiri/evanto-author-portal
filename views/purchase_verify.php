<?php
include plugin_dir_path(__FILE__).'../lib/Verify_purchase.php';
$purchases = new Verify_purchase(['bearer' => get_option(EAP_AUTHOR_KEY)]);

$customer = $purchases->verify();
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><h4>Verify Envato Purchase Code</h4></div>
    </div>
    <form action="" method="POST" id="verify-envato-purchase">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-8">
                    <input type="text"
                           name="purchase_code"
                           value=""
                           class="form-control" placeholder="Enter Purchase Code"/>
                </div>
            </div>

        </div>
        <div class="panel-footer">
            <button class="btn btn-success">Verify Purchase</button>
        </div>
    </form>
</div>

<br/>
<div class="row">
    <div class="col-sm-12">
        <?php if($customer): ?>
            <?php if(is_object($customer)): ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><h4 class="text-success"><i class="fa fa-check"></i> Verified!</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <td>Item ID:</td>
                                <td><?php echo $customer->item_id; ?></td>
                            </tr>
                            <tr>
                                <td>Product name:</td>
                                <td><?php echo $customer->item_name; ?></td>
                            </tr>
                            <tr>
                                <td>Purchased on:</td>
                                <td><?php echo date('d M Y H:ia', strtotime($customer->created_at)); ?></td>
                            </tr>
                            <tr>
                                <td>Buyer's name:</td>
                                <td><?php echo $customer->buyer; ?></td>
                            </tr>
                            <tr>
                                <td>License Type:</td>
                                <td><?php echo $customer->licence; ?></td>
                            </tr>
                            <tr>
                                <td>Supported ends:</td>
                                <td><?php echo date('d M Y H:ia', strtotime($customer->supported_until)); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

            <?php else: ?>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>
                                <i class="fa fa-close"></i>
                                <?php echo $customer['error']; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $customer['message']; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>