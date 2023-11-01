<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $boardTitle = $_POST['boardTitle']; // 변수 이름 수정
    $boardContents = $_POST['boardContents'];
    $boardView = 1;
    $boardLike = 0;
    $regTime = time();
    $memberId = $_SESSION['memberId'];

    // 이미지
    $boardFile = $_FILES['boardFile'];
    $boardImgSize = $_FILES['boardFile']['size'];
    $boardImgType = $_FILES['boardFile']['type'];
    $boardImgName = $_FILES['boardFile']['name'];
    $boardImgTmp = $_FILES['boardFile']['tmp_name'];


    if($boardImgType){
        $fileTypeExtension = explode("/", $boardImgType);
        $fileType = $fileTypeExtension[0];  //image
        $fileExtension = $fileTypeExtension[1];  //jpeg

        // 이미지 타입 확인
        if($fileType === "image"){
            if($fileExtension === "jpg" || $fileExtension === "jpeg" || $fileExtension === "png" || $fileExtension === "gif" || $fileExtension === "webp"){
                $boardImgDir = "../assets/board/";
                $boardImgName = "Img_".time().rand(1, 99999)."."."{$fileExtension}";
                $sql = "INSERT INTO Community(memberId, boardTitle, boardContents, regTime, boardView, boardLike, boardImgFile, boardImgSize) VALUES('$memberId', '$boardTitle', '$boardContents', '$regTime', '$boardView', '$boardLike', '$boardImgName', '$boardImgSize')";
            } else {
            echo "<script>alert('지원하는 이미지 파일 형식이 아닙니다.')</script>";
            }
            echo "<script>alert('지원하는 이미지 파일입니다.')</script>";
        } else {
            echo "<script>alert('이미지 파일이 아닙니다.')</script>";
        }
    } else {
        echo "<script>alert('이미지 파일을 첨부하지 않았습니다.')</script>";
        $sql = "INSERT INTO Community(memberId, boardTitle, boardContents, regTime, boardView, boardLike, boardImgFile, boardImgSize) VALUES('$memberId', '$boardTitle', '$boardContents', '$regTime', '$boardView', '$boardLike', 'Img_default.jpg', '$boardImgSize')";
        echo "<script>window.location.href=cummunity.php';</script>";
    }

    // 이미지 사이즈 확인
    if($boardImgSize > 10000000){
        echo "<script>alert('이미지 파일 용량이 1MB를 초과합니다. 사이즈를 줄여주세요.')</script>";
    }
    $result = $connect -> query($sql);
    $result = move_uploaded_file($boardImgTmp, $boardImgDir.$boardImgName);
    if($result){
        echo "<script>alert('저장이 완료되었습니다.')</script>";
        echo "<script>window.location.href='cummunity.php';</script>";
    }



    
    // 원래
    if (!isset($_SESSION['memberId'])) {
        echo "<script>alert('로그인 후에 게시글을 작성할 수 있습니다.');</script>";
        echo "<script>window.history.back()</script>";
    } else {
        $boardTitle = $connect->real_escape_string($boardTitle);
        $boardContents = $connect->real_escape_string($boardContents);
    
        // 빈 게시글 번호 찾기
        $findGapSql = "SELECT (t1.boardId + 1) AS gap FROM Community t1 WHERE NOT EXISTS (SELECT 1 FROM Community t2 WHERE t2.boardId = t1.boardId + 1) ORDER BY t1.boardId LIMIT 1";
        $result = $connect->query($findGapSql);
        $row = $result->fetch_assoc();
        if ($row) {
            $nextBoardId = $row['gap'];
        } else {
            // 게시글 번호가 연속적일 경우
            $maxIdSql = "SELECT MAX(boardId) AS maxId FROM Community";
            $result2 = $connect->query($maxIdSql);
            $row2 = $result2->fetch_assoc();
            $nextBoardId = $row2['maxId'] + 1;
        }
    
        $sql = "INSERT INTO Community(boardId, memberId, boardTitle, boardContents, boardView, boardLike , regTime) VALUES('$nextBoardId', '$memberId', '$boardTitle', '$boardContents', '$boardView','$boardLike', '$regTime')"; // 테이블 이름 수정
        $connect->query($sql);
    
        echo "<script>alert('게시글이 성공적으로 작성되었습니다.');</script>";
        echo '<script>window.location.href = "cummunity.php";</script>';
        
    }
?>


<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $boardTitle = $_POST['boardTitle'];
    $boardContents = $_POST['boardContents'];
    $boardView = 1;
    $boardLike = 0;
    $regTime = time();
    $memberId = $_SESSION['memberId'];

    // 이미지 파일 업로드 처리
    $boardImgDir = "../assets/board/"; // 이미지 파일을 저장할 디렉토리 경로
    $boardImgName = ""; // 이미지 파일의 새로운 이름
    $boardImgSize = $_FILES['boardFile']['size'];
    $boardImgType = $_FILES['boardFile']['type'];

    // 이미지 파일 업로드 여부 확인
    if (!empty($_FILES['boardFile']['name'])) {
        $fileTypeExtension = explode("/", $boardImgType);
        $fileType = $fileTypeExtension[0];
        $fileExtension = $fileTypeExtension[1];

        // 이미지 타입 및 확장자 확인
        if ($fileType === "image" && ($fileExtension === "jpg" || $fileExtension === "jpeg" || $fileExtension === "png" || $fileExtension === "gif" || $fileExtension === "webp")) {
            $boardImgName = "Img_" . time() . rand(1, 99999) . "." . $fileExtension;

            // 파일 이동
            move_uploaded_file($_FILES['boardFile']['tmp_name'], $boardImgDir . $boardImgName);
        } else {
            echo "<script>alert('지원하는 이미지 파일 형식이 아닙니다.');</script>";
            echo "<script>window.history.back();</script>";
            exit;
        }
    }

    // 게시글 저장
    $boardTitle = $connect->real_escape_string($boardTitle);
    $boardContents = $connect->real_escape_string($boardContents);

    // 게시글 번호 찾기
    $findGapSql = "SELECT (t1.boardId + 1) AS gap FROM Community t1 WHERE NOT EXISTS (SELECT 1 FROM Community t2 WHERE t2.boardId = t1.boardId + 1) ORDER BY t1.boardId LIMIT 1";
    $result = $connect->query($findGapSql);
    $row = $result->fetch_assoc();
    if ($row) {
        $nextBoardId = $row['gap'];
    } else {
        // 게시글 번호가 연속적일 경우
        $maxIdSql = "SELECT MAX(boardId) AS maxId FROM Community";
        $result2 = $connect->query($maxIdSql);
        $row2 = $result2->fetch_assoc();
        $nextBoardId = $row2['maxId'] + 1;
    }

    // 게시글 저장
    if (!isset($_SESSION['memberId'])) {
        echo "<script>alert('로그인 후에 게시글을 작성할 수 있습니다.');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    } else {
        $sql = "INSERT INTO Community(boardId, memberId, boardTitle, boardContents, boardView, boardLike, regTime, boardImgFile, boardImgSize) VALUES('$nextBoardId', '$memberId', '$boardTitle', '$boardContents', '$boardView', '$boardLike', '$regTime', '$boardImgName', '$boardImgSize')";
        $connect->query($sql);

        echo "<script>alert('게시글이 성공적으로 작성되었습니다.');</script>";
        echo '<script>window.location.href = "cummunity.php";</script>';
    }
?>



</body>
</html>
