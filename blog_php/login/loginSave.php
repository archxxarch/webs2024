
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go!교복</title>
    
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .joinEnd__inner form {
            display: flex;
        }
        .joinEnd__inner p {
            font-size: 1.5rem;
            margin-top: 7rem;
        }
    </style>

    <!-- CSS -->
    <?php include "../include/head.php" ?>

</head>
<body>
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    <!-- //header -->


    <main id="main" role="main">

        <section class="joinEnd__inner join__inner container">
            <img class="ico_join" src="../assets/img/check.png" alt="check">
            <p>아이디 또는 비밀번호가 틀렸습니다. 다시 한번 확인해주세요!</p>
            <div class="join__form">
                <form action="#" name="#" method="post">
                    <a href="../login/login.php" class="joinEnd__btn__style1">로그인</a>
                    <a href="../main/main.php" class="joinEnd__btn__style2">메인으로</a>
                </form>
            </div>
        </section>

        <!-- <section class="join__inner container">
            <h2>로그인</h2>
            <p>🥳 로그인하고 Go교복!의 다양한 컨텐츠를 경험하세요!</p>
            <div class="join__form">
                <form action="#" name="#" method="post">
                    <div class="check_input">
                        <label for="youID" class="required">아이디</label>
                        <input type="text" id="youID" name="youID" class="input__style" placeholder="아이디를 입력해주세요." required>
                    </div>
                    <div class="check_input">
                        <label for="youPass" class="required">비밀번호</label>
                        <input type="password" id="youPass" name="youPass" class="input__style" placeholder="비밀번호를 입력해주세요." required>
                    </div>

                    <div class="join__login">
                        <p>계정이 없으신가요? </p>
                        <a href="join.php">회원가입</a>
                    </div>

                    <button type="submit" class="btn__style mt100">로그인</button>
                </form>
            </div>
        </section> -->

<?php
        include "../connect/connect.php";
        include "../connect/session.php";

        $youId = $_POST['youId'];
        $youPass = $_POST['youPass'];

        // echo $youEmail, $youPass;

        // 메시지 출력  
        function msg($alert){
            echo "<p>$alert</p>";
        }

        // 데이터 조회
        // members 데이터 중에 이메일/비밀번호
        $sql ="SELECT memberId, youEmail, youName, youPass FROM blog_myMembers WHERE youId = '$youId' AND youPass = '$youPass'";
        $result = $connect -> query($sql);

        if($result){
            $count = $result -> num_rows;

            if($count == 0) {
                // msg("아이디 또는 비밀번호가 틀렸습니다. 다시 한번 확인해주세요!");
            } else {
                $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);

                // echo"<pre>";
                // var_dump($memberInfo);
                // echo"</pre>";

                // 로그인 성공 --> 세션 생성
                $_SESSION['memberId'] = $memberInfo['memberId'];
                $_SESSION['youId'] = $memberInfo['youId'];
                $_SESSION['youName'] = $memberInfo['youName'];
                
                Header("location: ../main/main.php");
            }
        }
?>
    </main>

    <?php include "../include/footer.php" ?>
    <!-- //footer -->


</body>
</html>