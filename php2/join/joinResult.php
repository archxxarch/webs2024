<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $youId = mysqli_real_escape_string($connect, $_POST['youId']);
    $youName = mysqli_real_escape_string($connect, $_POST['youName']);
    $youEmail = mysqli_real_escape_string($connect, $_POST['youEmail']);
    $youPass = mysqli_real_escape_string($connect, $_POST['youPass']);
    $youAddress2 = mysqli_real_escape_string($connect, $_POST['youAddress2']);
    $youAddress3 = mysqli_real_escape_string($connect, $_POST['youAddress3']);
    $youAddress = $youAddress2 . ' ' . $youAddress3;
    $youPhone = mysqli_real_escape_string($connect, $_POST['youPhone']);
    $youRegTime = time();

    $sql = "INSERT INTO blog_myMembers(youId, youName, youEmail, youPass, youAddress, youPhone, youRegTime) VALUES('$youId', '$youName', '$youEmail', '$youPass', '$youAddress', '$youPhone', '$youRegTime')";

    $connect -> query($sql);

    // 데이터베이스 연결 닫기
    mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="ko"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 블로그 만들기</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="gray">
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main" role="main">
        <div class="intro__inner bmStyle container">
            <div class="intro__img">
                <img srcset="../assets/img/intro02.jpg 1x, ../assets/img/intro02@2x.jpg 2x, ../assets/img/intro02@3x.jpg 3x"  alt="소개 이미지">
            </div>
            <div class="intro__text">
                성공의 비결은 어떤 일이든 그 분야에서 1인자가 되려는 데에 있다. -엔드류 카네기
            </div>
        </div>
        
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->
</body>
</html>