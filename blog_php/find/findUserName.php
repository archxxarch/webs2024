<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go!교복</title>
    
    <link rel="stylesheet" href="../assets/css/login.css">

    <!-- CSS -->
    <?php include "../include/head.php" ?>
    <style>
        .join__form form { 
            display: flex;
        }
        .joinEnd__inner p em {
            font-weight: 500;
            color: #000;
        }
        .joinEnd__inner > p {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    <!-- //header -->


    <main id="main" role="main">

        <section class="joinEnd__inner join__inner container">
            
            <img class="ico_join" src="../assets/img/check.png" alt="check">

            <h2>아이디 찾기 결과</h2>
<?php
    $foundUsername = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 사용자로부터 입력 받은 연락처와 이름
        $youPhone = $_POST["youPhone"];
        $youName = $_POST["youName"];

        // 데이터베이스 연결 및 쿼리 실행
        include "../connect/connect.php"; // 데이터베이스 연결 파일
        $sql = "SELECT youId FROM myMembers WHERE youPhone = '$youPhone' AND youName = '$youName'";
        $result = $connect->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $foundUsername = $row["youId"];
            }
        }

        // 데이터베이스 연결 종료
        $connect->close();
    }
?>
            <p>😎 아이디를 찾았습니다: <em><?php echo $foundUsername; ?></em></p>
            <div class="join__form">
                <form action="#" name="#" method="post">
                    <a href="../login/login.php" class="joinEnd__btn__style1">로그인</a>
                    <a href="../main/main.php" class="joinEnd__btn__style2">메인으로</a>
                </form>
            </div>
        </section>
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->
</body>
</html>