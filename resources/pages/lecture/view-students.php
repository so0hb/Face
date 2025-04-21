<?php

$courseCode = isset($_GET['course']) ? $_GET['course'] : '';
$unitCode = isset($_GET['unit']) ? $_GET['unit'] : '';

$studentRows = fetchStudentRecordsFromDatabase($courseCode, $unitCode);

$coursename = "";
if (!empty($courseCode)) {
    $coursename_query = "SELECT name FROM tblcourse WHERE courseCode = '$courseCode'";
    $result = fetch($coursename_query);
    foreach ($result as $row) {

        $coursename = $row['name'];
    }
}
$unitname = "";
if (!empty($unitCode)) {
    $unitname_query = "SELECT name FROM tblunit WHERE unitCode = '$unitCode'";
    $result = fetch($unitname_query);
    foreach ($result as $row) {

        $unitname = $row['name'];
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="resources/images/logo/attnlg.png" rel="icon">
    <title>لوحة معلومات الدكتور</title>
    <link rel="stylesheet" href="resources/assets/css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
</head>



<body>
    <?php include 'includes/topbar.php'; ?>
    <section class="main">
        <?php include 'includes/sidebar.php'; ?>
        <div class="main--content">
            <form class="lecture-options" id="selectForm">
                <select required name="course" id="courseSelect" onChange="updateTable()">
                    <option value="" selected>اختيار التخصص</option>
                    <?php
                    $courseNames = getCourseNames();
                    foreach ($courseNames as $course) {
                        echo '<option value="' . $course["courseCode"] . '">' . $course["name"] . '</option>';
                    }
                    ?>
                </select>

                <select required name="unit" id="unitSelect" onChange="updateTable()">
                    <option value="" selected>اختيار المادة</option>
                    <?php
                    $unitNames = getUnitNames();
                    foreach ($unitNames as $unit) {
                        echo '<option value="' . $unit["unitCode"] . '">' . $unit["name"] . '</option>';
                    }
                    ?>
                </select>
            </form>


            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">قائمة الطلاب</h2>
                </div>
                <div class="table attendance-table" id="attendaceTable">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم التسجيل</th>
                                <th>الاسم الاول</th>
                                <th>الاسم الاخير</th>
                                <th>البريد الالكتروني</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $query = "SELECT * FROM tblstudents WHERE courseCode = '$courseCode'";

                            $result = fetch($query);
                            if ($result) {
                                foreach ($result as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['registrationNumber'] . "</td>";
                                    echo "<td>" . $row['firstName'] . "</td>";
                                    echo "<td>" . $row['lastName'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";

                                    echo "</tr>";
                                }

                                echo "</table>";
                            } else {
                            }
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        </div>
    </section>
    <div>
        <?php js_asset(["active_link", "min/js/filesaver", "min/js/xlsx"]) ?>
</body>


<script>
    function updateTable() {
        console.log("update noted");
        var courseSelect = document.getElementById("courseSelect");
        var unitSelect = document.getElementById("unitSelect");

        var selectedCourse = courseSelect.value;
        var selectedUnit = unitSelect.value;

        var url = "view-students";
        if (selectedCourse && selectedUnit) {
            url += "?course=" + encodeURIComponent(selectedCourse) + "&unit=" + encodeURIComponent(selectedUnit);
            window.location.href = url;
            console.log(url)
        }
    }
</script>

</html>