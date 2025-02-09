<!DOCTYPE html>
<html>
<head>
    <title>RTO TamilNadu</title>
    <!--css-->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/ken-burns.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/animate.min.css" type="text/css" media="all" />
    <!--css-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="RTO WEB TEMPLATE" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!--js-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--js-->
    <!--webfonts-->
    <link href='//fonts.googleapis.com/css?family=Cagliostro' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <!--webfonts-->
</head>
<body>
    <!--header-->
    <div class="header">
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!---Brand and toggle get grouped for better mobile display--->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-brand">
                            <h1><a href="index.html">RTO <span>TamilNadu</span></a></h1>
                        </div>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <nav class="link-effect-2" id="link-effect-2">
                            <ul class="nav navbar-nav">
                                <li><a href="home.html"><span data-hover="Home">Home</span></a></li>
                                <li><a href="click_llr.php"><span data-hover="LLR">LLR</span></a></li>
                                <li><a href="click_registration.php"><span data-hover="Registration">Registration</span></a></li>
                                <li><a href="click_dl.php"><span data-hover="DL">DL</span></a></li>
                                <li><a href="complaint.php"><span data-hover="Complaint">Complaint</span></a></li>
                                <li><a href="gallery.html"><span data-hover="Gallery">Gallery</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!--header-->

    <div class="content">
        <!--student-->
        <div class="student-w3ls">
            <div class="container">
                <h3 class="tittle">Vehicle Registration</h3>
                <div class="student-grids">
                    <div class="col-md-3 student-grid">
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "dbms_p1");

                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        if (isset($_POST['submit'])) {
                            $q1 = implode(',', $_POST['q1']);
                            $aad = $_POST['aad'];
                            $passwd = $_POST['passwd'];
                            $model = $_POST['model'];
                            $company = $_POST['company'];

                            // Get the last registration details
                            $sql = "SELECT rdate, r_id FROM reg ORDER BY r_id DESC LIMIT 1";
                            $result = $conn->query($sql);
                            $row = mysqli_fetch_row($result);

                            if ($row) {
                                $last_rdate = $row[0] ?? '';  // Use null-coalescing to prevent undefined warnings
                                $last_rid = $row[1] ?? '';
                            } else {
                                $last_rdate = '';
                                $last_rid = '';
                            }

                            // Fetch citizen data
                            $sql5 = "SELECT first_name, middle_name, last_name, mail_id FROM citizen WHERE aadhar='$aad'";
                            $result5 = $conn->query($sql5);
                            $row5 = mysqli_fetch_row($result5);

                            if ($row5) {
                                $name = $row5[0] . " " . $row5[1] . " " . $row5[2];
                                $mail_id = $row5[3];
                            } else {
                                echo "<script>alert('No citizen found with this Aadhar.');</script>";
                                exit();
                            }

                            // Fetch address and RTO details
                            $sql2 = "SELECT city FROM address WHERE aadhar='$aad'";
                            $result2 = $conn->query($sql2);
                            $row2 = mysqli_fetch_row($result2);
                            $city = $row2[0] ?? '';

                            $sql3 = "SELECT rto_address FROM offices WHERE district='$city'";
                            $result3 = $conn->query($sql3);
                            $row3 = mysqli_fetch_row($result3);
                            $rto_address = $row3[0] ?? '';

                            // Generate verification date
                            $d = date("Y-m-d", strtotime("+1 week"));
                            $dayofweek = date('w', strtotime($d));
                            if ($dayofweek == 'Sunday') {
                                $d = date("Y-m-d", strtotime("+1 day"));
                            }

                            // Insert new registration record without r_id (auto-incremented by MySQL)
                            $sql = "INSERT INTO reg (aadhar, name, cov, model, company, rdate, passwd, mail_id) 
                                    VALUES ('$aad', '$name', '$q1', '$model', '$company', '$d', '$passwd', '$mail_id')";

                            if (mysqli_query($conn, $sql)) {
                                echo "<script>window.alert('Record created successfully')</script>";
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                        }
                        ?>
                    </div>

                    <div class="col-md-10">
                        <table border="1" cellpadding="10" cellspacing="5" align="center">
                            <tr>
                                <td align="center" colspan="2"><b>VERIFICATION DETAILS</b></td>
                            </tr>
                            <tr>
                                <td>Verification Date</td>
                                <td><?php echo $d ?></td>
                            </tr>
                            <tr>
                                <td>Verification Venue</td>
                                <td><?php echo "  " . $rto_address ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>
                                        Please be at 10:00 am on the given date and venue.<br>
                                        Bring Aadhar card, 2 passport size photographs, DOB proof, Address Proof, and the vehicle to be registered.<br>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p align="center"><a href="home.html"><h2 align="center">Exit</h2></a></p>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--student-->
    </div>

    <!--footer-->
    <div class="footer-w3">
        <div class="container">
            <div class="footer-grids">
                <div class="col-md-8 footer-grid">
                    <h4>About Us</h4>
                    <p>Organisation of the Indian government responsible for maintaining a database of drivers and a database of vehicles for Karnataka.<span>
                        It issues driving licences, organises collection of vehicle excise duty and sells personalised registrations.
                        It also is responsible to inspect vehicle's insurance and clear the pollution test.</span></p>
                </div>
                <div class="col-md-4 footer-grid">
                    <h4>Information</h4>
                    <ul>
                        <li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>Chennai</li>
              		    <li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>044 2567 8843</li>
             		    <li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:karnataka@rto.com"> tamilnadu@rto.com</a></li>
              			<li><i class="glyphicon glyphicon-time" aria-hidden="true"></i>Mon-Sat 10:00 hr to 17:00 hr</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--footer-->
</body>
</html>
