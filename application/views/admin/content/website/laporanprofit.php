<!-- ================================================== VIEW ================================================== -->
<?php if ($action == 'view' || empty($action)) { ?>
    <div class="page">
        <div class="page-title blue">
            <h3><?php echo $breadcrumb; ?></h3>
            <p>Informasi terkait <?php echo $breadcrumb; ?> berdasarkan territory</p>
        </div>
        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel rounded-0">
                        <div class="panel-heading">
                            <h5 class="panel-title">View Data: <?php echo $breadcrumb; ?></h5>
                        </div>
                        <!-- ========== Flashdata ========== -->
                        <?php if ($this->session->flashdata('success')) : ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-check sign"></i>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php elseif ($this->session->flashdata('warning')) : ?>
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-check sign"></i>
                                <?php echo $this->session->flashdata('warning'); ?>
                            </div>
                        <?php elseif ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-warning sign"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        <!-- ========== End Flashdata ========== -->
                        <div class="panel-body container-fluid table-detail">
                            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dwo_uas";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query untuk mendapatkan rincian profit berdasarkan daerah dengan join tabel location_sales
        $query = "SELECT DISTINCT ls.`Name`, fs.TerritoryID, SUM(fs.TotalProfit) AS TotalProfit FROM fakta_sales fs
                    JOIN location_sales ls ON fs.TerritoryID = ls.TerritoryID
                    GROUP BY fs.TerritoryID";
        $result = $conn->query($query);

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $name = $row['Name'];
            $territoryID = $row['TerritoryID'];
            $totalProfit = $row['TotalProfit'];

            $data[] = array(
                'name' => $name,
                'y' => (float)$totalProfit
            );
        }

        $conn->close();
        ?>

        // Fungsi untuk memformat angka menjadi format mata uang
        function formatCurrency(amount) {
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'decimal'
            });
            return formatter.format(amount);
        }

        // Membuat grafik pie menggunakan Highcharts
        document.addEventListener("DOMContentLoaded", function() {
            var chart = Highcharts.chart('container', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Rincian Profit Berdasarkan Daerah'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Profit',
                    data: <?php echo json_encode($data); ?>,
                }]
            });
        });
    </script>
<?php } ?>