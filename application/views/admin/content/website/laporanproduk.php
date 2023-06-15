<!-- ================================================== VIEW ================================================== -->
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

        // Query untuk mendapatkan rincian jumlah produk berdasarkan kategori
        $query = "SELECT SubcategoryName, COUNT(*) AS JumlahProduk FROM produk_produk GROUP BY SubcategoryName";
        $result = $conn->query($query);

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $subcategoryName = $row['SubcategoryName'];
            $jumlahProduk = $row['JumlahProduk'];

            $data[] = array(
                'name' => $subcategoryName,
                'y' => $jumlahProduk
            );
        }

        $conn->close();
        ?>

        // Membuat grafik bar menggunakan Highcharts
        document.addEventListener("DOMContentLoaded", function() {
            var chart = Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Rincian Jumlah Produk Berdasarkan Kategori'
                },
                xAxis: {
                    categories: [
                        <?php
                        foreach ($data as $item) {
                            echo "'" . $item['name'] . "', ";
                        }
                        ?>
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Produk'
                    }
                },
                series: [{
                    name: 'Jumlah Produk',
                    data: [
                        <?php
                        foreach ($data as $item) {
                            echo $item['y'] . ", ";
                        }
                        ?>
                    ]

                }]
            });
        });
    </script>
<?php } ?>