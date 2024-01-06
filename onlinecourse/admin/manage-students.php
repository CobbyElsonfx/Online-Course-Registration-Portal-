<?php
session_start();
include('includes/config.php');

error_reporting(1);

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Code for Promotion
    // Code for Deletion
    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from students where studentRegno = '" . $_GET['id'] . "'");
        echo '<script>alert("Student Record Deleted Successfully !!")</script>';
        echo '<script>window.location.href=manage-students.php</script>';
    }

    // Code for Password Reset
    if (isset($_GET['pass'])) {
        // Function to generate a random password
        function generateRandomPassword($length = 8)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $password = '';
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $password;
        }

        // Generate a random password
        $randomPassword = generateRandomPassword();

        $newpass = md5($randomPassword);
        mysqli_query($con, "update students set password='$newpass' where studentRegno = '" . $_GET['id'] . "'");
        echo '<script>alert("Password Reset. New Password is ' . $randomPassword . '")</script>';
        echo '<script>window.location.href=manage-students.php</script>';
    }



}


?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <!-- Add the DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="../assets/css/admin_side_nav.css" rel="stylesheet" />
    <title>Admin | Manage Students</title>

</head>

<body>

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <?php if ($_SESSION['alogin'] != "") {
            include('includes/menubar.php');
        }
        ?>

        <!-- Page Content Holder -->
        <div id="content">

            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid ">

                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                    </div>
                </div>
            </nav>

            <div>
                <font color="red" align="center">
                    <?php echo htmlentities($_SESSION['delmsg']); ?>
                    <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                </font>
                <div class=" row">
                    <!--    Bordered Table  -->
                    <div class="mt-5 ">
                        <div class="panel-body card">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reg No </th>
                                            <th>Student Name </th>
                                            <th>Level </th>
                                            <th>Reg Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($con, "select * from students");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $cnt; ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row['studentRegno']); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row['surname'] . " " . $row['firstname'] . " " . $row['otherName']); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row['level']) ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row['creationdate']); ?>
                                                </td>
                                                <td>
                                                    <a
                                                        href="edit-student-profile.php?id=<?php echo $row['studentRegno'] ?>">
                                                        <button class="btn btn-primary"><i class="fa fa-edit "></i>
                                                            Edit</button>
                                                    </a>
                                                    <a href="manage-students.php?id=<?php echo $row['studentRegno'] ?>&del=delete"
                                                        onClick="return confirm('Are you sure you want to delete?')">
                                                        <button class="btn btn-primary">Delete</button>
                                                    </a>
                                                    <a href="manage-students.php?id=<?php echo $row['studentRegno'] ?>&pass=update"
                                                        onClick="return confirm('Are you sure you want to reset password?')">
                                                        <button type="submit" name="submit" id="submit"
                                                            class="btn btn-xs mt-1 btn-default">Reset Password</button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--  End  Bordered Table  -->
                    <div style="margin-top:5rem;">
                        <h2 class="text-center text-danger mt-4 mb-4 fw-bolder ">Danger Zone</h2>

                    </div>

                    <?php


                    // Reopen the database connection before batch processing
                    include 'progression.php';
                    include 'reverse-progression.php';
                    if (isset($_POST['batchProgression'])) {
                        $promotionCriteria = 12; // Promote after 12 months
                        $promotionLimit = 4; // Promote for up to 4 years
                    
                        // Set a limit for the number of records to process in each iteration
                        $limit = 100;

                        // Calculate the number of iterations required
                        $totalStudents = mysqli_query($con, "SELECT COUNT(*) as total FROM students WHERE level <= 400");
                        $totalStudents = mysqli_fetch_assoc($totalStudents)['total'];
                        $iterations = ceil($totalStudents / $limit);

                        for ($i = 0; $i < $iterations; $i++) {
                            // Calculate the offset for each iteration
                            $offset = $i * $limit;

                            // Perform batch progression for a limited number of students
                            $sql = mysqli_query($con, "SELECT * FROM students WHERE level <= 400 LIMIT $limit OFFSET $offset");
                            while ($row = mysqli_fetch_array($sql)) {
                                handleProgression($row['studentRegno'], $row['enrollmentDate'], $row['level'], $promotionCriteria, $promotionLimit, $con);
                            }
                        }

                        echo "Batch progression completed.";
                    }

                    // Include your progression functions and database connection
                    
                    // Check if the form is submitted for batch reversal
                    if (isset($_POST['batchReversal'])) {
                        // Set a limit for the number of records to process in each iteration
                        $limit = 100;

                        // Calculate the number of iterations required
                        $totalStudents = mysqli_query($con, "SELECT COUNT(*) as total FROM students WHERE level <= 400");
                        $totalStudents = mysqli_fetch_assoc($totalStudents)['total'];
                        $iterations = ceil($totalStudents / $limit);

                        for ($i = 0; $i < $iterations; $i++) {
                            // Calculate the offset for each iteration
                            $offset = $i * $limit;

                            // Perform batch reversal for a limited number of students
                            $sql = mysqli_query($con, "SELECT * FROM students WHERE level <= 400 LIMIT $limit OFFSET $offset");
                            while ($row = mysqli_fetch_array($sql)) {
                                reverseProgression($row['studentRegno'], $con);
                            }
                        }

                        echo "Batch reversal completed.";
                    }
                    ?>


                    <div class="card text-dark bg-transparent mb-3 mx-auto" style="max-width: 100%;">
                        <div class="card-header bg-danger">Warning</div>
                        <div class="card-body row">
                            <div class="col-8">
                                <h5 class="card-title fw-bolder">Batch Progression</h5>
                                <p class="card-text fw-bold">Clicking the "Batch Progression" button will perform
                                    progression for eligible students. This action may take some time to complete.
                                    Please ensure you have considered the implications before proceeding.</p>
                                <p class="fw-bolder card-text">Note: THIS MUST BE DONE AT THE VERY BEGINNING OF EVERY
                                    YEAR</p>
                            </div>
                            <div class="col-4">
                                <div
                                    class=" mt-3 border-2  border-danger mx-auto red d-flex align-items-center justify-content-center">
                                    <form method="post">
                                        <button class="btn btn-danger bg-danger shadow-lg text-uppercase fs-6  p-5"
                                            id="batchProgression" class="p-5" type="submit"
                                            name="batchProgression">Batch
                                            Progression</button>
                                    </form>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="card text-dark bg-transparent mb-3 mx-auto" style="max-width: 100%;">
                        <div class="card-header bg-danger">Warning</div>
                        <div class="card-body row">
                            <div class="col-8">
                                <h5 class="card-title fw-bolder">Reversal</h5>
                                <p class="card-text fw-bold">Clicking the "Reverse Progression" button will perform a
                                    reversal for eligible students. This action may take some time to complete. Please
                                    ensure you have considered the implications before proceeding.</p>
                            </div>
                            <div class="col-4">
                                <div
                                    class=" mt-3 border-2  border-danger mx-auto red d-flex align-items-center justify-content-center">
                                    <form method="post">
                                        <button class="btn btn-danger bg-danger shadow-lg text-uppercase fs-6  p-5"
                                            id="batchReversal" class="p-5" type="submit" name="batchReversal">
                                            Reverse Progression</button>
                                    </form>
                                </div>
                            </div>



                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <script>
        // DataTable initialization script
        $(document).ready(function () {
            $('.table').DataTable();
        });
    </script>
</body>

</html>

<?php ?>