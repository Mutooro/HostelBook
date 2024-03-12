<?php
    session_start();
    // include('../includes/dbconn.php');

    $dbuser = "root";
    $dbpass = "";
    $host = "localhost";
    $dbname = "hostelmsphp";
    
    try {
        // Create a PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        
        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        // Handle connection errors
        die("Connection failed: " . $e->getMessage());
    }
    include('../includes/check-login.php');
    check_login();

// Assuming you have established a PDO database connection already

if(isset($_POST['submit'])) {
    // Retrieve form data
    $roomno = $_POST['room'];
    $seater = $_POST['seater'];
    $feespm = $_POST['fpm'];
    $foodstatus = $_POST['foodstatus'];
    $stayfrom = $_POST['stayf'];
    $duration = $_POST['duration'];
    $course = $_POST['course'];
    $regno = $_POST['regno'];
    $firstName = $_POST['fname'];
    $middleName = $_POST['mname'];
    $lastName = $_POST['lname'];
    $gender = $_POST['gender'];
    $contactno = $_POST['contact'];
    $emailid = $_POST['email'];
    $egycontactno = $_POST['econtact'];
    $guardianName = $_POST['gname'];
    $guardianRelation = $_POST['grelation'];
    $guardianContactno = $_POST['gcontact'];
    $corresAddress = $_POST['address'];
    $corresCity = $_POST['city'];
    $corresPincode = $_POST['pincode'];

    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("INSERT INTO registration (roomno, seater, feespm, foodstatus, stayfrom, duration, course, regno, firstName, middleName, lastName, gender, contactno, emailid, egycontactno, guardianName, guardianRelation, guardianContactno, corresAddress, corresCity, corresPincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bindParam(1, $roomno);
        $stmt->bindParam(2, $seater);
        $stmt->bindParam(3, $feespm);
        $stmt->bindParam(4, $foodstatus);
        $stmt->bindParam(5, $stayfrom);
        $stmt->bindParam(6, $duration);
        $stmt->bindParam(7, $course);
        $stmt->bindParam(8, $regno);
        $stmt->bindParam(9, $firstName);
        $stmt->bindParam(10, $middleName);
        $stmt->bindParam(11, $lastName);
        $stmt->bindParam(12, $gender);
        $stmt->bindParam(13, $contactno);
        $stmt->bindParam(14, $emailid);
        $stmt->bindParam(15, $egycontactno);
        $stmt->bindParam(16, $guardianName);
        $stmt->bindParam(17, $guardianRelation);
        $stmt->bindParam(18, $guardianContactno);
        $stmt->bindParam(19, $corresAddress);
        $stmt->bindParam(20, $corresCity);
        $stmt->bindParam(21, $corresPincode);

        // Execute the statement
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->rowCount() > 0) {
            echo"<script>alert('Record added successfully!');
            window.location.href='book-hostel.php';
            </script>";
        } else {
            echo "Error inserting record.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close statement and connection
    unset($stmt);
    unset($pdo);
}
?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hostel Management System</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    <style>
    /* CSS to make input element ignore pointer events */
    #fpm, #seater{
        background-color: #f5f5f5; /* Light gray background */
        color: #666;
        pointer-events: none;
    }
</style>

    <script>
    function getSeater(val) {
        $.ajax({
        type: "POST",
        url: "get-seater.php",
        data:'roomid='+val,
        success: function(data){
        //alert(data);
        $('#seater').val(data);
        }
        });

        $.ajax({
        type: "POST",
        url: "get-seater.php",
        data:'rid='+val,
        success: function(data){
        //alert(data);
        $('#fpm').val(data);
        }
        });
    }
    </script>
    
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        
        <header class="topbar" data-navbarbg="skin6">
            <?php include '../includes/student-navigation.php'?>
        </header>
        
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include '../includes/student-sidebar.php'?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        
        <div class="page-wrapper">
            
            
            <div class="container-fluid">
                
                <form method="POST">
                
                <?php
                    $uid=$_SESSION['login'];
                    $stmt=$mysqli->prepare("SELECT emailid FROM registration WHERE emailid=? ");
                    $stmt->bind_param('s',$uid);
                    $stmt->execute();
                    $stmt -> bind_result($email);
                    $rs=$stmt->fetch();
                    $stmt->close();

                    if($rs){ ?>
                    <div class="alert alert-primary alert-dismissible bg-danger text-white border-0 fade show"
                        role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                                <strong>Info: </strong> You have already booked a hostel!
                    </div>
                    <?php }
                    else{
						echo "";
					}			
				?>	


                <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Hostel Bookings</h4>
                    </div>

                
                <div class="row">


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Room Number</h4>
                                    <div class="form-group mb-4">
                                        <select class="custom-select mr-sm-2" name="room" id="room" onChange="getSeater(this.value);" onBlur="checkAvailability()" required id="inlineFormCustomSelect">
                                            <option selected>Select...</option>
                                            <?php $query ="SELECT * FROM rooms";
                                            $stmt2 = $mysqli->prepare($query);
                                            $stmt2->execute();
                                            $res=$stmt2->get_result();
                                            while($row=$res->fetch_object())
                                            {
                                            ?>
                                            <option value="<?php echo $row->room_no;?>"> <?php echo $row->room_no;?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="room-availability-status" style="font-size:12px;"></span>
                                    </div>
                              
                            </div>
                        </div>
                    </div>

                
 
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Start Date</h4>
                                    <div class="form-group">
                                        <input type="date" name="stayf" id="stayf" class="form-control" required>
                                    </div>
                                
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Seater</h4>
                                    <div class="form-group">
                                        <input type="text" id="seater" name="seater" placeholder="Enter Seater No." required class="form-control">
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Duration</h4>
                                    <div class="form-group mb-4">
                                        <select class="custom-select mr-sm-2" id="duration" name="duration">
                                            <option selected>Choose...</option>
                                            <option value="1">One Month</option>
                                            <option value="2">Two Month</option>
                                            <option value="3">Three Month</option>
                                            <option value="4">Four Month</option>
                                            <option value="5">Five Month</option>
                                            <option value="6">Six Month</option>
                                            <option value="7">Seven Month</option>
                                            <option value="8">Eight Month</option>
                                            <option value="9">Nine Month</option>
                                            <option value="10">Ten Month</option>
                                            <option value="11">Eleven Month</option>
                                            <option value="12">Twelve Month</option>
                                        </select>
                                    </div>
                              
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                        <div class="card-body">
                                <h4 class="card-title">Food Status</h4>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" value="1" name="foodstatus"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1">Required <code>Extra Ush150,000 Per Month</code></label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" value="0" name="foodstatus"
                                        class="custom-control-input" checked>
                                    <label class="custom-control-label" for="customRadio2">Not Required</label>
                                </div>
                                
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Fees Per Month</h4>
                                    <div class="form-group">
                                        <input type="text" name="fpm" id="fpm" placeholder="Your total fees" class="form-control" >
                                    </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Amount</h4>
                                    <div class="form-group">
                                        <input type="text" name="ta"  id="ta" placeholder="Total Amount here.." required class="form-control">
                                    </div>
                            </div>
                        </div>
                    </div>
                  
                
                </div>

                <h4 class="card-title mt-5">Student's Personal Information</h4>

                <div class="row">

                <?php	
                $aid=$_SESSION['id'];
                    $ret="select * from userregistration where id=?";
                        $stmt= $mysqli->prepare($ret) ;
                    $stmt->bind_param('i',$aid);
                    $stmt->execute();
                    $res=$stmt->get_result();

                    while($row=$res->fetch_object())
                    {
                        ?>
                
                    <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Registration Number</h4>
                                        <div class="form-group">
                                            <input type="text" name="regno" id="regno" value="<?php echo $row->regNo;?>" class="form-control" readonly>
                                        </div>
                                </div>
                            </div>
                        </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">First Name</h4>
                                    <div class="form-group">
                                        <input type="text" name="fname" id="fname" value="<?php echo $row->firstName;?>" class="form-control" readonly>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Last Name</h4>
                                    <div class="form-group">
                                        <input type="text" name="mname" id="mname" value="<?php echo $row->middleName;?>" class="form-control" readonly>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Deparment</h4>
                                    <div class="form-group">
                                        <input type="text" name="lname" id="lname" value="<?php echo $row->lastName;?>" class="form-control" readonly>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Email</h4>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" value="<?php echo $row->email;?>" class="form-control" readonly>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Gender</h4>
                                    <div class="form-group">
                                        <input type="text" name="gender" id="gender" value="<?php echo $row->gender;?>" class="form-control" readonly>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Contact Number</h4>
                                    <div class="form-group">
                                        <input type="number" name="contact" id="contact" value="<?php echo $row->contactNo;?>" class="form-control" readonly>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <?php }?>

                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Emergency Contact Number</h4>
                                    <div class="form-group">
                                        <input type="number" name="econtact" id="econtact" class="form-control" required>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Preferred Course</h4>
                                    <div class="form-group mb-4">
                                        <select class="custom-select mr-sm-2" id="course" name="course">
                                            <option selected>Please Select...</option>
                                            <?php $query ="SELECT * FROM courses";
                                                $stmt2 = $mysqli->prepare($query);
                                                $stmt2->execute();
                                                $res=$stmt2->get_result();
                                                while($row=$res->fetch_object())
                                                {
                                            ?>
                                            <option value="<?php echo $row->course_fn;?>"><?php echo $row->course_fn;?>&nbsp;&nbsp;(<?php echo $row->course_sn;?>)</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                              
                            </div>
                        </div>
                    </div>
                              
                </div>

                <h4 class="card-title mt-5">Guardian's Information</h4>

                    <div class="row">
                    
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Guardian Name</h4>
                                        <div class="form-group">
                                            <input type="text" name="gname" id="gname" class="form-control" placeholder="Enter Guardian's Name" required>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Relation</h4>
                                        <div class="form-group">
                                            <input type="text" name="grelation" id="grelation" required class="form-control" placeholder="Student's Relation with Guardian">
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Contact Number</h4>
                                        <div class="form-group">
                                            <input type="text" name="gcontact" id="gcontact" required class="form-control" placeholder="Enter Guardian's Contact No.">
                                        </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>

                    <h4 class="card-title mt-5">Current Address Information</h4>

                    <div class="row">
                    
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Address</h4>
                                        <div class="form-group">
                                            <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" required>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">City</h4>
                                        <div class="form-group">
                                            <input type="text" name="city" id="city" class="form-control" placeholder="Enter City Name" required>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Postal Code</h4>
                                        <div class="form-group">
                                            <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter Postal Code" required>
                                        </div>
                                </div>
                            </div>
                        </div>

                    
                    </div>


                    <h4 class="card-title mt-5">Permanent Address Information</h4>


                    <div class="row">
                    
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle"><code>Ignore this CHECK BOX if you have different permanent address</code> </h6>
                                    <fieldset class="checkbox">
                                        <label>
                                            <input type="checkbox" value="1" name="adcheck"> My permanent address is same as above!
                                        </label>
                                    </fieldset>
                                   
                                </div>
                            </div>
                        </div>
                        
                    
                    </div>

                    
                    <h5 class="card-title mt-5">Please fill up the form "ONLY IF" you've different permanent address!</h5>


                    <div class="row">

                    
                    <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Address</h4>
                                        <div class="form-group">
                                            <input type="text" name="paddress" id="paddress" class="form-control" placeholder="Enter Address" required>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">City</h4>
                                        <div class="form-group">
                                            <input type="text" name="pcity" id="pcity" class="form-control" placeholder="Enter City Name" required>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Postal Code</h4>
                                        <div class="form-group">
                                            <input type="text" name="ppincode" id="ppincode" class="form-control" placeholder="Enter Postal Code" required>
                                        </div>
                                </div>
                            </div>
                        </div>
                    
                    
                    </div>


                    <div class="form-actions">
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-dark">Reset</button>
                        </div>
                    </div>

                
                </form>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include '../includes/footer.php' ?>
            
        </div>
    
    </div>
   
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>


</body>

<!-- Custom Ft. Script Lines -->
<script type="text/javascript">
	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#paddress').val( $('#address').val() );
                $('#pcity').val( $('#city').val() );
                $('#ppincode').val( $('#pincode').val() );
            } 
            
        });
    });
    </script>
    
    <script>
        function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
        url: "check-availability.php",
        data:'roomno='+$("#room").val(),
        type: "POST",
        success:function(data){
            $("#room-availability-status").html(data);
            $("#loaderIcon").hide();
        },
            error:function (){}
            });
        }
    </script>


    <script type="text/javascript">

    $(document).ready(function() {
        $('#duration').keyup(function(){
            var fetch_dbid = $(this).val();
            $.ajax({
            type:'POST',
            url :"ins-amt.php?action=userid",
            data :{userinfo:fetch_dbid},
            success:function(data){
            $('.result').val(data);
            }
            });
            

    })});
    </script>

</html>