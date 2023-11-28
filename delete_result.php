<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])=="") {
    header("Location: index.php"); 
} else {
    if (isset($_GET['stid'])) {
        $studentId = $_GET['stid'];

        // Delete student's results
        $deleteResult = $dbh->prepare("DELETE FROM tblresult WHERE StudentId = :studentId");
        $deleteResult->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $deleteResult->execute();

        // Delete student
        $deleteStudent = $dbh->prepare("DELETE FROM tblstudents WHERE StudentId = :studentId");
        $deleteStudent->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $deleteStudent->execute();

        if ($deleteStudent && $deleteResult) {
            $msg = "Student record along with results deleted successfully";
            header("Location: view-students-results.php?msg=$msg");
        } else {
            $error = "Error deleting student record";
            header("Location: view-students-results.php?error=$error");
        }
    }
}
?>
