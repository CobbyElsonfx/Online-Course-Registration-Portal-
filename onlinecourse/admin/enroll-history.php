<?php
session_start();
include('includes/config.php');
error_reporting(1);

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Enroll History</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <link href="../assets/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <div class="studensPortalHeader">
            <h1 class="studentPortal">Enroll History</h1>
        </div>
        <?php if ($_SESSION['alogin'] != "") {
            include('includes/menubar.php');
        }
        ?>
        <div class="content-wrapper ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Enroll History </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Enroll History
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name </th>
                                                <th>Student Reg no </th>
                                                <th>Course Name </th>
                                                <th>Session </th>
                                                <th>Semester</th>
                                                <th>Enrollment Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = mysqli_query($con, "select courseenrolls.id as enrollId, courseenrolls.course as cid, course.courseName as courname,session.session as session,programme.program as progr,courseenrolls.enrollDate as edate ,semester.semester as sem,students.surname as sname,students.firstname as fname ,students.StudentRegno as sregno from courseenrolls join course on course.id=courseenrolls.course join session on session.id=courseenrolls.session join Programme on programme.id=courseenrolls.programme  join semester on semester.id=courseenrolls.semester join students on students.StudentRegno=courseenrolls.studentRegno ");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $cnt; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['sname'] . ' ' . $row['fname']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['sregno']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['courname']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['progr']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['sem']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlentities($row['edate']); ?>
                                                    </td>
                                                    <td>
                                                        <a href="print.php?id=<?php echo $row['cid'] ?>" target="_blank">
                                                            <button class="btn btn-primary"><i class="fa fa-print"></i>
                                                                Print</button>
                                                        </a>
                                                        <a href="enroll-history.php?del=<?php echo $row['enrollId'] ?>"
                                                            onClick="return confirm('Are you sure you want to delete?')">
                                                            <button class="btn btn-danger"><i class="fa fa-trash"></i>
                                                                Delete</button>
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
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_GET['del'])) {
            $enrollId = $_GET['del'];
            $deleteQuery = mysqli_query($con, "DELETE FROM courseenrolls WHERE id = '$enrollId'");
            if ($deleteQuery) {
                echo '<script>alert("Enrollment record deleted successfully!")</script>';
                echo '<script>window.location.href="enroll-history.php"</script>';
            } else {
                echo '<script>alert("Error: Unable to delete enrollment record.")</script>';
            }
        }
        ?>
        <?php include('includes/footer.php'); ?>
        <script src="../assets/js/jquery-1.11.1.js"></script>
        <script src="../assets/js/bootstrap.js"></script>
    </body>

    </html>
<?php } ?>
