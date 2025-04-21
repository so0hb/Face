<?php


if (isset($_POST["addCourse"])) {
    $courseName = htmlspecialchars(trim($_POST["courseName"])); // Escape and trim whitespace
    $courseCode = htmlspecialchars(trim($_POST["courseCode"]));
    $facultyID = filter_var($_POST["faculty"], FILTER_VALIDATE_INT);
    $dateRegistered = date("Y-m-d");

    if ($courseName && $courseCode && $facultyID) {
        $query = $pdo->prepare("SELECT * FROM tblcourse WHERE courseCode = :courseCode");
        $query->bindParam(':courseCode', $courseCode);
        $query->execute();

        if ($query->rowCount() > 0) {
            $_SESSION['message'] = "التخصص موجود بالفعل";
        } else {
            $query = $pdo->prepare("INSERT INTO tblcourse (name, courseCode, facultyID, dateCreated) 
                                     VALUES (:name, :courseCode, :facultyID, :dateCreated)");
            $query->bindParam(':name', $courseName);
            $query->bindParam(':courseCode', $courseCode);
            $query->bindParam(':facultyID', $facultyID);
            $query->bindParam(':dateCreated', $dateRegistered);
            $query->execute();

            $_SESSION['message'] = "تم إدخال التخصص بنجاح";
        }
    } else {
        $_SESSION['message'] = "إدخال غير صالح لتخصص";
    }
}

if (isset($_POST["addUnit"])) {
    $unitName = htmlspecialchars(trim($_POST["unitName"]));
    $unitCode = htmlspecialchars(trim($_POST["unitCode"]));
    $courseID = filter_var($_POST["course"], FILTER_VALIDATE_INT);
    $dateRegistered = date("Y-m-d");

    if ($unitName && $unitCode && $courseID) {
        $query = $pdo->prepare("SELECT * FROM tblunit WHERE unitCode = :unitCode");
        $query->bindParam(':unitCode', $unitCode);
        $query->execute();

        if ($query->rowCount() > 0) {
            $_SESSION['message'] = "المادة موجودة بالفعل";
        } else {
            $query = $pdo->prepare("INSERT INTO tblunit (name, unitCode, courseID, dateCreated) 
                                     VALUES (:name, :unitCode, :courseID, :dateCreated)");
            $query->bindParam(':name', $unitName);
            $query->bindParam(':unitCode', $unitCode);
            $query->bindParam(':courseID', $courseID);
            $query->bindParam(':dateCreated', $dateRegistered);
            $query->execute();

            $_SESSION['message'] = "تم إدخال المواد بنجاح";
        }
    } else {
        $_SESSION['message'] = "إدخال غير صالح للمادة";
    }
}

if (isset($_POST["addFaculty"])) {
    $facultyName = htmlspecialchars(trim($_POST["facultyName"]));
    $facultyCode = htmlspecialchars(trim($_POST["facultyCode"]));
    $dateRegistered = date("Y-m-d");

    if ($facultyName && $facultyCode) {
        $query = $pdo->prepare("SELECT * FROM tblfaculty WHERE facultyCode = :facultyCode");
        $query->bindParam(':facultyCode', $facultyCode);
        $query->execute();

        if ($query->rowCount() > 0) {
            $_SESSION['message'] = "هيئة التدريس موجودة بالفعل";
        } else {
            $query = $pdo->prepare("INSERT INTO tblfaculty (facultyName, facultyCode, dateRegistered) 
                                     VALUES (:facultyName, :facultyCode, :dateRegistered)");
            $query->bindParam(':facultyName', $facultyName);
            $query->bindParam(':facultyCode', $facultyCode);
            $query->bindParam(':dateRegistered', $dateRegistered);
            $query->execute();

            $_SESSION['message'] = "تم إدراج الكلية بنجاح";
        }
    } else {
        $_SESSION['message'] = "إدخال غير صالح لأعضاء هيئة التدريس";
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
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="resources/assets/css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/topbar.php' ?>
    <section class="main">
        <?php include 'includes/sidebar.php'; ?>
        <div class="main--content">
            <div id="overlay"></div>
            <div class="overview">
                <div class="title">
                    <h2 class="section--title">ملخص</h2>
                    <select name="date" id="date" class="dropdown">
                        <option value="today">اليوم</option>
                        <option value="lastweek">الاسبوع الماضي</option>
                        <option value="lastmonth">الشهر الماضي</option>
                        <option value="lastyear">السنة الماضية</option>
                        <option value="alltime">كل الأوقات</option>
                    </select>
                </div>
                <div class="cards">
                    <div id="addCourse" class="card card-1">

                        <div class="card--data">
                            <div class="card--content">
                                <button class="add"><i class="ri-add-line"></i>إضافة التخصص</button>
                                <h1><?php total_rows('tblcourse') ?> التخصص</h1>
                            </div>
                            <i class="ri-user-2-line card--icon--lg"></i>
                        </div>

                    </div>
                    <div class="card card-1" id="addUnit">

                        <div class="card--data">
                            <div class="card--content">
                                <button class="add"><i class="ri-add-line"></i>إضافة المواد</button>
                                <h1><?php total_rows('tblunit') ?> المواد</h1>
                            </div>
                            <i class="ri-file-text-line card--icon--lg"></i>
                        </div>

                    </div>

                    <div class="card card-1" id="addFaculty">

                        <div class="card--data">
                            <div class="card--content">
                                <button class="add"><i class="ri-add-line"></i>إضافة الكلية</button>
                                <h1><?php total_rows("tblfaculty") ?> الكلية </h1>
                            </div>
                            <i class="ri-user-line card--icon--lg"></i>
                        </div>

                    </div>
                </div>
            </div>

            <?php showMessage() ?>
            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">التخصص</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الكلية</th>
                                <th>إجمالي الوحدات</th>
                                <th>إجمالي الطلاب</th>
                                <th>تاريخ الإنشاء</th>
                                <th>فعل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT 
                        c.name AS course_name,
                        c.facultyID AS faculty,
                        f.facultyName AS faculty_name,
                        c.Id AS Id,
                        COUNT(u.Id) AS total_units,
                        COUNT(DISTINCT s.Id) AS total_students,
                        c.dateCreated AS date_created
                        FROM tblcourse c
                        LEFT JOIN tblunit u ON c.Id = u.courseID
                        LEFT JOIN tblstudents s ON c.courseCode = s.courseCode
                        LEFT JOIN tblfaculty f on c.facultyID=f.Id
                        GROUP BY c.Id";

                            $result = fetch($sql);

                            if ($result) {
                                foreach ($result as $row) {
                                    echo "<tr id='rowcourse{$row["Id"]}'>";
                                    echo "<td>" . $row["course_name"] . "</td>";
                                    echo "<td>" . $row["faculty_name"] . "</td>";
                                    echo "<td>" . $row["total_units"] . "</td>";
                                    echo "<td>" . $row["total_students"] . "</td>";
                                    echo "<td>" . $row["date_created"] . "</td>";
                                    echo "<td><span><i class='ri-delete-bin-line delete'data-id='{$row["Id"]}' data-name='course'></i></span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">المواد</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>كود المادة</th>
                                <th>الاسم</th>
                                <th>التخصص</th>
                                <th>إجمالي الطلاب</th>
                                <th>تاريخ الإنشاء</th>
                                <th>فعل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT 
                            c.name AS course_name,
                            u.unitCode AS unit_code,
                            u.name AS unit_name, u.Id as Id,
                            u.dateCreated AS date_created,
                            COUNT(s.Id) AS total_students
                            FROM tblunit u
                            LEFT JOIN tblcourse c ON u.courseID = c.Id
                            LEFT JOIN tblstudents s ON c.courseCode = s.courseCode
                            GROUP BY u.Id";
                            $result = fetch($sql);
                            if ($result) {
                                foreach ($result as $row) {
                                    echo "<tr id='rowunit{$row["Id"]}' >";
                                    echo "<td>" . $row["unit_code"] . "</td>";
                                    echo "<td>" . $row["unit_name"] . "</td>";
                                    echo "<td>" . $row["course_name"] . "</td>";
                                    echo "<td>" . $row["total_students"] . "</td>";
                                    echo "<td>" . $row["date_created"] . "</td>";
                                    echo "<td><span><i class='ri-delete-bin-line delete' data-id='{$row["Id"]}' data-name='unit'></i></span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="table-container">
                <div class="title">
                    <h2 class="section--title">الكلية</h2>
                </div>
                </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>كود الكلية</th>
                                <th>الاسم</th>
                                <th>إجمالي التخصصات</th>
                                <th>إجمالي الطلاب</th>
                                <th>إجمالي الدكاترة</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT 
                           f.facultyName AS faculty_name,
                           f.facultyCode AS faculty_code,
                           f.Id as Id,
                           f.dateRegistered AS date_created,
                           COUNT(DISTINCT c.Id) AS total_courses,
                           COUNT(DISTINCT s.Id) AS total_students,
                           COUNT(DISTINCT l.Id) AS total_lectures
                       FROM tblfaculty f
                       LEFT JOIN tblcourse c ON f.Id = c.facultyID
                       LEFT JOIN tblstudents s ON f.facultyCode = s.faculty
                       LEFT JOIN tbllecture l ON f.facultyCode = l.facultyCode
                       GROUP BY f.Id";

                            $result = fetch($sql);
                            if ($result) {
                                foreach ($result as $row) {
                                    echo "<tr id='rowfaculty{$row["Id"]}'>";
                                    echo "<td>" . $row["faculty_code"] . "</td>";
                                    echo "<td>" . $row["faculty_name"] . "</td>";
                                    echo "<td>" . $row["total_courses"] . "</td>";
                                    echo "<td>" . $row["total_students"] . "</td>";
                                    echo "<td>" . $row["total_lectures"] . "</td>";
                                    echo "<td>" . $row["date_created"] . "</td>";
                                    echo "<td><span><i class='ri-delete-bin-line delete' data-id='{$row["Id"]}' data-name='faculty'></i></span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <div class="formDiv" id="addCourseForm" style="display:none; ">

            <form method="POST" action="" name="addCourse" enctype="multipart/form-data">
                <div style="display:flex; justify-content:space-around;">
                    <div class="form-title">
                        <p>إضافة التخصصات</p>
                    </div>
                    <div>
                        <span class="close">&times;</span>
                    </div>
                </div>

                <input type="text" name="courseName" placeholder="اسم التخصص" required>
                <input type="text" name="courseCode" placeholder="كود التخصص" required>


                <select required name="faculty">
                    <option value="" selected>إضافة الكليات</option>
                    <?php
                    $facultyNames = getFacultyNames();
                    foreach ($facultyNames as $faculty) {
                        echo '<option value="' . $faculty["Id"] . '">' . $faculty["facultyName"] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" class="submit" value="حفظ الكلية" name="addCourse">
            </form>
        </div>

        <div class="formDiv" id="addUnitForm" style="display:none; ">
            <form method="POST" action="" name="addUnit" enctype="multipart/form-data">
                <div style="display:flex; justify-content:space-around;">
                    <div class="form-title">
                        <p>إضافة المواد</p>
                    </div>
                    <div>
                        <span class="close">&times;</span>
                    </div>
                </div>

                <input type="text" name="unitName" placeholder="اسم المادة" required>
                <input type="text" name="unitCode" placeholder="كود المادة" required>

                <select required name="lecture">
                    <option value="" selected>تعين دكتور</option>
                    <?php
                    $lectureNames = getLectureNames();
                    foreach ($lectureNames as $lecture) {
                        echo '<option value="' . $lecture["Id"] . '">' . $lecture["firstName"] . ' ' . $lecture["lastName"]  .  '</option>';
                    }
                    ?>
                </select>
                <select required name="course">
                    <option value="" selected>إضافة التخصصات</option>
                    <?php
                    $courseNames = getCourseNames();
                    foreach ($courseNames as $course) {
                        echo '<option value="' . $course["Id"] . '">' . $course["name"] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" class="submit" value="حفظ المادة" name="addUnit">
            </form>
        </div>

        <div class="formDiv" id="addFacultyForm" style="display:none; ">
            <form method="POST" action="" name="addFaculty" enctype="multipart/form-data">
                <div style="display:flex; justify-content:space-around;">
                    <div class="form-title">
                        <p>إضافة الكليات</p>
                    </div>
                    <div>
                        <span class="close">&times;</span>
                    </div>
                </div>
                <input type="text" name="facultyName" placeholder="اسم الكلية" required>
                <input type="text" name="facultyCode" placeholder="كود الكلية" required>
                <input type="submit" class="submit" value="حفظ الكلية" name="addFaculty">
            </form>
        </div>



    </section>

    <?php js_asset(["delete_request", "addCourse", "active_link"]) ?>
</body>

</html>