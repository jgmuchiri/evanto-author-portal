<?php
$sales = $eap_client->fetchData($eap_client->methods['user']['month-sales'])->{"earnings-and-sales-by-month"};
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel border-success">
            <div class="panel-heading">
                <div class="panel-title"><h4>Monthly sales</h4></div>
            </div>
            <div class="panel-body">

                <div class="chart-container" style="position: relative; height:400%; width:100%">
                    Select year:
                    <select name="year" onchange="window.location.href='?page=<?php echo $_GET['page']; ?>&tab=month-sales&year='+this.value">
                        <?php for ($i = date('Y') - 10; $i <= date('Y'); $i++): ?>
                            <option
                                <?php
                                if((isset($_GET['year']) && $i == $_GET['date']) ||
                                    (!isset($_GET['year']) && $i == date('Y'))): ?>
                                    selected
                                <?php endif; ?>
                                    value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <canvas id="myChart"></canvas>
                </div>

                <div class="clearfix">
                    <hr/>
                </div>
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
                                <td><?php echo date('m, Y', strtotime($sale->month)); ?></td>
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
<?php
if(isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = date('Y');
}
$mySales = [];
$myEarns = [];
foreach ($sales as $sale) {
    for ($i = 1; $i <= 12; $i++) {
        if(date('m', strtotime($sale->month)) == $i && date('Y', strtotime($sale->month)) == $year) {
            $mySales[$i] = $sale->sales;
        }
    }
}

foreach ($sales as $sale) {
    for ($i = 1; $i <= 12; $i++) {
        if(date('m', strtotime($sale->month)) == $i && date('Y', strtotime($sale->month)) == $year) {
            $myEarns[$i] = $sale->earnings;
        }
    }
}

?>
<script type="text/javascript">
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach($mySales as $month=>$sale): ?>
                <?php echo $month.','; ?>
                <?php endforeach; ?>
            ],
            datasets: [{
                label: '# of Sales',
                data: [
                    <?php foreach($mySales as $sale): ?>
                    <?php echo $sale.','; ?>
                    <?php endforeach; ?>
                ],
                backgroundColor: [
                    <?php foreach($mySales as $month=>$sale): ?>
                    'rgba(255, 99, 132, 0.2)',
                    <?php endforeach; ?>

                ],
                borderColor: [
                    <?php foreach($mySales as $month=>$sale): ?>
                    'rgba(255,99,132,1)',
                    <?php endforeach; ?>
                ],
                borderWidth: 1
            },
                {
                    label: 'Earnings',
                    data: [
                        <?php foreach($myEarns as $earn): ?>
                        <?php echo $earn.','; ?>
                        <?php endforeach; ?>
                    ],
                    backgroundColor: [
                        <?php foreach($myEarns as $earn): ?>
                        'rgba(54, 162, 235, 0.2)',
                        <?php endforeach; ?>

                    ],
                    borderColor: [
                        <?php foreach($myEarns as $earn): ?>
                        'rgba(54, 162, 235, 1)',
                        <?php endforeach; ?>
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    myChart.canvas.parentNode.style.width = '80%';
</script>