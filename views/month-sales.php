<?php
$sales = $eap_client->fetchData($eap_client->methods['user']['month-sales'])->{"earnings-and-sales-by-month"};
?>
<div class="row">
    <div class="col-md-12">
        <div class="bcard border-success">
            <div class="bcard-header">
                <div class="bcard-title"><h4>Monthly sales</h4></div>
            </div>
            <div class="bcard-body table-responsive">
                <?php if(!empty($sales)): ?>
                    <table class="table table-striped eap-table mdl-data-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sales</th>
                            <th>Earnings</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><?php echo date('M, Y', strtotime($sale->month)); ?></td>
                                <td><?php echo $sale->sales; ?></td>
                                <td><?php echo $sale->earnings; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
