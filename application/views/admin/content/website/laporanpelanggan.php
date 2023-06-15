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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detailsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Rincian Daerah Pelanggan</h4>
                </div>
                <div class="modal-body">
                    <table id="detailsTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Daerah Pelanggan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        // Query untuk mendapatkan data jumlah pelanggan berdasarkan tipe pelanggan (tanpa data yang berulang)
        $query = "SELECT DISTINCT CustomerType, COUNT(DISTINCT CustomerID) AS TotalCustomers FROM customer_sales GROUP BY CustomerType";
        $result = $conn->query($query);

        $customerTypes = array();
        $totalCustomers = array();
        while ($row = $result->fetch_assoc()) {
            $customerType = $row['CustomerType'];
            $totalCustomer = $row['TotalCustomers'];

            $customerTypes[] = $customerType;
            $totalCustomers[] = $totalCustomer;
        }

        $conn->close();
        ?>

        // Membuat grafik batang menggunakan Highcharts
        document.addEventListener("DOMContentLoaded", function() {
            var chart = Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Jumlah Pelanggan Berdasarkan Tipe'
                },
                xAxis: {
                    categories: [
                        <?php
                        foreach ($customerTypes as $customerType) {
                            echo "'" . $customerType . "', ";
                        }
                        ?>
                    ],
                    title: {
                        text: 'Tipe Pelanggan'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Pelanggan'
                    }
                },
                series: [{
                    name: 'Jumlah Pelanggan',
                    data: [
                        <?php
                        foreach ($totalCustomers as $totalCustomer) {
                            echo $totalCustomer . ", ";
                        }
                        ?>
                    ]
                }],
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        },
                        events: {
                            click: function(e) {
                                var category = e.point.category;
                                var tableBody = $('#detailsTable tbody');
                                tableBody.empty();
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

                                // Query untuk mendapatkan data rincian daerah pelanggan berdasarkan kategori
                                $query = "SELECT location_sales.Name FROM location_sales JOIN customer_sales ON location_sales.TerritoryID = customer_sales.TerritoryID WHERE customer_sales.CustomerType = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $category);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $name = $row['Name'];
                                    echo "tableBody.append('<tr><td>" . $name . "</td></tr>');";
                                }

                                $conn->close();
                                ?>
                                $('#detailsModal').modal('show');
                            }
                        }
                    }
                }

            });
        });
    </script>
<?php } ?>