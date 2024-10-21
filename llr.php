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
                <h3 class="tittle">Learner's License Registration</h3>
                <div class="student-grids">
                    <div class="col-md-3 student-grid">
                        <?php
                            $conn = mysqli_connect("localhost", "root", "", "dbms_p1");
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            if (isset($_GET['aad']) && isset($_GET['passwd'])) {
                                $aad = $_GET['aad'];
                                $passwd = $_GET['passwd'];

                                // Prepare statement to fetch citizen data
                                $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, dob FROM citizen WHERE aadhar = ?");
                                $stmt->bind_param("s", $aad);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<p><br><br><br>";
                                        echo "<p><b>&emsp; &emsp; Aadhar number: " . $aad . "<br>";
                                        echo "<p>&emsp; &emsp; Name: " . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "<br>";
                                        echo "<p>&emsp; &emsp; Date of birth: " . $row["dob"] . "<br>";
                                        $dob = $row["dob"];
                                    }

                                    // Calculate age
                                    $age = floor((time() - strtotime($dob)) / 31556926);
                                    if ($age < 18) {
                                        echo ("<SCRIPT LANGUAGE='JavaScript'>
                                                window.alert('Not eligible')
                                                window.location.href='home.html'
                                                </SCRIPT>");
                                    }
                                } else {
                                    echo "0 results";
                                }
                                $stmt->close();
                            } else {
                                echo "Missing required parameters.";
                                exit();
                            }
                        ?>
                    </div>

                    <div class="col-md-3 student-grid">
                        <!-- Form to submit vehicle categories -->
                        <form method="post" action="llr_entry.php">
                            <input name="aad" type="hidden" value="<?php echo $_GET["aad"]; ?>">
                            <input name="passwd" type="hidden" value="<?php echo $_GET["passwd"]; ?>">
                            <p>&emsp;&emsp;&emsp;Select category of vehicle:</p>
                            <p>&emsp;&emsp;&emsp;&emsp; &emsp; &emsp;<input name="q1[]" type="checkbox" value="LMV">LMV</p>
                            <p>&emsp;&emsp;&emsp;&emsp; &emsp; &emsp;<input name="q1[]" type="checkbox" value="MCWG">MCWG</p>
                            <p>&emsp;&emsp;&emsp;&emsp; &emsp; &emsp;<input name="q1[]" type="checkbox" value="MCWoG">MCWoG</p>
                            <p>&emsp;&emsp;&emsp;&emsp; &emsp; &emsp;<input name="q1[]" type="checkbox" value="HPMV">HPMV</p>
                            <p>&emsp;&emsp;&emsp;&emsp; &emsp; &emsp;<input name="q1[]" type="checkbox" value="HGMV">HGMV</p>
                            <br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <div class="col-md-3 student-grid">
                        <img src="images/llr1.jpg" class="img-responsive">
                    </div>
                    <div class="col-md-3 student-grid">
                        <img src="images/llr2.jpg" class="img-responsive">
                    </div>
                    <div class="clearfix"></div>
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
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!--footer-->
    
    <!---copy--->
    <div class="copy-section">
        <div class="container">
            <div class
