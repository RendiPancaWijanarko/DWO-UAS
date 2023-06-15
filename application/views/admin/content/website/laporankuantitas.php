<?php if ($action == 'view' || empty($action)) { ?>
    <div class="page">
        <div class="page-title blue">
            <h3><?php echo $breadcrumb; ?></h3>
            <p>Informasi terkait <?php echo $breadcrumb; ?></p>
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
                            <div id="drilldownContainer" style="min-width: 310px; height: 400px; margin: 0 auto; display: none;"></div>
                            <button id="backButton" style="display: none;">Back</button>
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

        // Query untuk mendapatkan data kuantitas pesanan per tahun
        $query = "SELECT YEAR(OrderDate) AS OrderYear, SUM(OrderQty) AS TotalOrderQty FROM sales_sales GROUP BY OrderYear ORDER BY OrderYear ASC";
        $result = $conn->query($query);

        $years = array();
        $orderQtys = array();
        while ($row = $result->fetch_assoc()) {
            $year = $row['OrderYear'];
            $orderQty = $row['TotalOrderQty'];

            $years[] = $year;
            $orderQtys[] = $orderQty;
        }

        // Query untuk mendapatkan data kuantitas pesanan per bulan per tahun
        $queryDrilldown = "SELECT YEAR(OrderDate) AS OrderYear, MONTH(OrderDate) AS OrderMonth, SUM(OrderQty) AS TotalOrderQty FROM sales_sales GROUP BY OrderYear, OrderMonth ORDER BY OrderYear ASC, OrderMonth ASC";
        $resultDrilldown = $conn->query($queryDrilldown);

        $drilldownData = array();
        while ($rowDrilldown = $resultDrilldown->fetch_assoc()) {
            $yearDrilldown = $rowDrilldown['OrderYear'];
            $monthDrilldown = $rowDrilldown['OrderMonth'];
            $orderQtyDrilldown = $rowDrilldown['TotalOrderQty'];

            if (!isset($drilldownData[$yearDrilldown])) {
                $drilldownData[$yearDrilldown] = array();
            }

            $drilldownData[$yearDrilldown][] = array($monthDrilldown, $orderQtyDrilldown);
        }

        $conn->close();
        ?>

        // Membuat grafik garis menggunakan Highcharts
        document.addEventListener("DOMContentLoaded", function() {
            var chart = Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Tren Perubahan Kuantitas Pesanan per Tahun'
                },
                xAxis: {
                    title: {
                        text: 'Tahun'
                    },
                    categories: [
                        <?php
                        foreach ($years as $year) {
                            echo "'" . $year . "', ";
                        }
                        ?>
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Total Kuantitas Pesanan'
                    }
                },
                series: [{
                    name: 'Total Kuantitas Pesanan',
                    data: [
                        <?php
                        foreach ($orderQtys as $orderQty) {
                            echo $orderQty . ", ";
                        }
                        ?>
                    ],
                    events: {
                        click: function(event) {
                            var selectedYear = event.point.category;
                            var drilldownData = <?php echo json_encode($drilldownData); ?>;
                            showDrilldown(selectedYear, drilldownData);
                        }
                    }
                }],
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                }
            });

            function showDrilldown(selectedYear, drilldownData) {
                var drilldownSeries = [];
                var drilldownCategories = [];
                var selectedYearData = drilldownData[selectedYear];

                for (var i = 0; i < selectedYearData.length; i++) {
                    var month = selectedYearData[i][0];
                    var orderQty = selectedYearData[i][1];

                    drilldownCategories.push(month);
                    drilldownSeries.push(orderQty);
                }

                var drilldownChart = Highcharts.chart('drilldownContainer', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Tren Perubahan Kuantitas Pesanan per Bulan'
                    },
                    xAxis: {
                        title: {
                            text: 'Bulan'
                        },
                        categories: drilldownCategories
                    },
                    yAxis: {
                        title: {
                            text: 'Total Kuantitas Pesanan'
                        }
                    },
                    series: [{
                        name: 'Total Kuantitas Pesanan',
                        data: drilldownSeries
                    }],
                    plotOptions: {
                        column: {
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}'
                            }
                        }
                    }
                });

                document.getElementById('container').style.display = 'none';
                document.getElementById('drilldownContainer').style.display = 'block';
                document.getElementById('backButton').style.display = 'block';

                document.getElementById('backButton').addEventListener('click', function() {
                    document.getElementById('container').style.display = 'block';
                    document.getElementById('drilldownContainer').style.display = 'none';
                    document.getElementById('backButton').style.display = 'none';
                });
            }
        });
    </script>
<?php } ?>