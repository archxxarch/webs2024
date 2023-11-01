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

            <h2>비밀번호 찾기 결과</h2>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 사용자로부터 입력 받은 아이디와 연락처
        $youId = $_POST["youId"];
        $youPhone = $_POST["youPhone"];

        // 데이터베이스 연결 및 쿼리 실행
        include "../connect/connect.php"; // 데이터베이스 연결 파일
        $sql = "SELECT youPass FROM myMembers WHERE youId = '$youId' AND youPhone = '$youPhone'";
        $result = $connect->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $foundPassword = $row["youPass"];
                // 비밀번호 중간 일부를 가려주기
                $length = strlen($foundPassword);
                $visibleCharacters = 4; // 표시할 글자 수 (예: 4)
                $hiddenCharacters = $length - $visibleCharacters;
                $startVisible = 1; // 시작 글자
                $endVisible = $startVisible + $visibleCharacters - 1;
                $maskedPassword = substr($foundPassword, 0, $startVisible) .
                                str_repeat('*', $hiddenCharacters) .
                                substr($foundPassword, $endVisible);
            } else {
                echo "일치하는 정보를 찾을 수 없습니다. 다시 확인해주세요.";
            }
        } else {
            echo "쿼리 실행 오류: " . $connect->error;
        }

        // 데이터베이스 연결 종료
        $connect->close();
    }
?>
            <p>😎 비밀번호를 찾았습니다: <em><?php echo $maskedPassword; ?></em></p>
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