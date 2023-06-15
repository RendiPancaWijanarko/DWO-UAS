<style>
    .small-box h3 {
        font-size: 27px;
    }
</style>

<div class="page">
    <div class="page-title blue">
        <h3>
            <?php echo $breadcrumb; ?>
        </h3>

    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded-0">
                    <div class="panel-heading rounded-0">
                        <h3 class="panel-title">Selamat Datang di Dashboard Data Warehouse AdventureWorks!</h3>
                    </div>
                    <div class="panel-body container-fluid">
                        <div class="blockquote gray">
                            <h3>Welcome,&nbsp;
                                <?php echo $admin->admin_nama; ?>!
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
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

                                $sql = "SELECT SUM(TotalProfit) AS Total FROM fakta_sales";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // output data of the total row
                                    $row = $result->fetch_assoc();
                                    $totalProfit = number_format($row["Total"], 2); // Format total profit dengan 2 angka di belakang koma
                                    echo "<h3>$totalProfit</h3>";
                                } else {
                                    echo "0 results";
                                }
                                $conn->close();
                                ?>
                                <p>Total Profit</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money"></i>
                            </div>
                            <a href="<?php echo base_url(); ?>website/laporanprofit" class="small-box-footer">
                                Lihat Rincian Profit
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">
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

                                $sql = "SELECT COUNT(ProductID) AS TotalProduk FROM produk_produk";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // output data of the total row
                                    $row = $result->fetch_assoc();
                                    $totalProduk = number_format($row["TotalProduk"]);
                                    echo "<h3>" . $totalProduk . "</h3>";
                                } else {
                                    echo "0 results";
                                }
                                $conn->close();
                                ?>
                                <p>Total Jenis Produk</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-archive"></i>
                            </div>
                            <a href="<?php echo base_url(); ?>website/laporanproduk" class="small-box-footer">
                                Lihat Rincian Jenis Produk
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-xs-6">
                        <div class="small-box bg-warning">
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

                            // Query to retrieve Total Kuantitas Pesanan from sales_sales table
                            $query = "SELECT SUM(OrderQTY) AS TotalKuantitasPesanan FROM sales_sales";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $totalKuantitasPesanan = number_format($row["TotalKuantitasPesanan"]);
                            } else {
                                $totalKuantitasPesanan = 0;
                            }

                            $conn->close();
                            ?>
                            <div class="inner">
                                <h3>
                                    <?php echo $totalKuantitasPesanan; ?>
                                </h3>
                                <p>Total Kuantitas Pesanan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-truck"></i>
                            </div>
                            <a href="<?php echo base_url(); ?>website/laporanterlaris" class="small-box-footer">
                                Lihat Rincian Kuantitas Pesanan
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-xs-6">
                        <div class="small-box bg-aqua">
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

                            // Query to retrieve unique Total Pelanggan from customer_sales table
                            $query = "SELECT COUNT(DISTINCT CustomerID) AS TotalPelanggan FROM customer_sales";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $totalPelanggan = number_format($row["TotalPelanggan"]);
                            } else {
                                $totalPelanggan = 0;
                            }

                            $conn->close();
                            ?>
                            <div class="inner">
                                <h3>
                                    <?php echo $totalPelanggan; ?>
                                </h3>
                                <p>Total Pelanggan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="<?php echo base_url(); ?>website/laporanpelanggan" class="small-box-footer">
                                Lihat Rincian Pelanggan
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>