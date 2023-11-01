<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go!교복</title>
    
    <link rel="stylesheet" href="../assets/css/modify.css">

    <!-- CSS -->
    <?php include "../include/head.php" ?>
    <style>
        .file p {
            text-align: left;
            font-size: 14px;
            font-weight: 100;
            margin-bottom: 33px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>

    <main id="main" role="main">
        <section class="board__inner container">
            <h2>수다방 글 수정하기</h2>
            <p>😊 여기서 게시글 수정해주세요!</p>
            <div class="board__form">
            <form action="boardModifySave.php?boardId=<?= $_GET['boardId']?>" name="boardModifySave.php" method="post">
<?php
    $boardId = $_GET['boardId'];

    $sql = "SELECT * FROM Community WHERE boardId = {$boardId}";
    $result = $connect -> query($sql);

    if($result){// 보드 아이디를 불러와 해당 테이블의 제목 내용을 보여준다.
        $info = $result -> fetch_array(MYSQLI_ASSOC);

        echo "<div style='display:none'><label for='boardId'>번호</label><input type='text' id='boardId' name='boardId' class='input__style' value='".$info['boardId']."'></div>";
        echo "<div><label for='boardTitle'></label><input type='text' id='boardTitle' name='boardTitle' class='input__style' value='".$info['boardTitle']."'></div>";
        echo "<div><label for='boardContents'></label><textarea id='boardContents' name='boardContents' rows='20' class='input__style'>".$info['boardContents']."</textarea></div>";
    }
?>
                    <div class="file">
                        <label for="boardFile" class="blind"></label>
                        <input type="file" id="boardFile" name="boardFile" accept=".jpg, .jpeg, .png, .gif, .webp" class='input__style'>
                        <p>* jpg, gif, png, webp 파일만 넣을 수 있습니다. 이미지 용량은 1MB를 넘길 수 없습니다.</p>
                    </div>
                        
<?php
    $boardId = $_GET['boardId'];

    $sql = "SELECT * FROM Community WHERE boardId = {$boardId}";
    $result = $connect -> query($sql);

    if($result){// 보드 아이디를 불러와 해당 테이블의 제목 내용을 보여준다.
        $info = $result -> fetch_array(MYSQLI_ASSOC);
        echo "<div class='mt50'><label for='boardPass'></label><input type='password' id='boardPass' name='boardPass' class='input__style' autocomplete='off' placeholder='비밀번호를 입력해주세요' required></div>";
    }
?>
                        
                        <div class="board__btns">
                            <button type="update" class="btn__style3 update-button" onclick="confirmAndUpdate()">수정</button>
                        </div>
                </form>
            </div>
        </section>
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->
    
</body>
</html>