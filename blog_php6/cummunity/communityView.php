<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    if(isset($_SESSION['memberId'])){
        $memberId = $_SESSION['memberId'];
    } else {
        $memberId = 0;
    }

    if(isset($_GET['boardId'])){
        $boardId = $_GET['boardId'];
    } else {
        Header("Location: cummunity.php");
    }

    // 블로그 정보 가져오기 
    $boardSql = "SELECT * FROM Community WHERE boardId = '$boardId'";
    $boardResult = $connect -> query($boardSql);
    $info = $boardResult -> fetch_array(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go!교복</title>
    
    <link rel="stylesheet" href="../assets/css/communityD.css">
    <style>
        #likeCount {
            font-size: 1.5rem;
            margin-top: 5px;
            font-weight: 300;
            color: #1976DE;
        }
    </style>

    <!-- CSS -->
    <?php include "../include/head.php" ?>

</head>
<body>
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    

    <main id="main">
        <div class="container view_inner">
            <div class="article">
<?php
    $boardId = $_GET['boardId'];

    // 뷰 + 1
    $sql = "UPDATE Community SET boardView = boardView + 1 WHERE boardId = {$boardId}";  
    $connect -> query($sql);

    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContents FROM Community b JOIN myMembers m ON(b.memberId = m.memberId) WHERE b.boardId = {$boardId}";
    $result = $connect -> query($sql);

    if ($result) {
        $info = $result->fetch_array(MYSQLI_ASSOC);
        
        echo '<h2>' . $info['boardTitle'] . '</h2>';
    
        echo '<div class="name">' . $info['youName'] . '</div>';
    
        echo '<div class="hinfo">'; // icon1 = 작성날짜, icon2 = 조회수 , icon3 = 댓글
        echo '<span class="dat"><img src="../assets/img/clock.svg" alt="Clock Icon">' . date('Y-m-d', $info['regTime']) . '</span>';
        echo '<span class="pv"><img src="../assets/img/read1.svg" alt="Read Icon">' . $info['boardView'] . '</span>';
        echo '<span class="cmt"><img src="../assets/img/chat.svg" alt="Read Icon">' . $info['comment'] . '</span>';
        echo '</div>';
    }
?>
            </div>

            <div class="content">
            <img src="../assets/board/<?=$info['boardImgFile']?>" >
            <!-- alt="<?=$info['boardTitle']?>" -->
            <!-- <?=$info['boardContents']?> -->
<?php
    $boardId = $_GET['boardId'];

    // 보도 뷰 + 1
    $sql = "UPDATE Community SET boardView = boardView + 1 WHERE boardId = {$boardId}";
    $connect -> query($sql);

    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContents FROM Community b JOIN myMembers m ON(b.memberId = m.memberId) WHERE b.boardId = {$boardId}";
    $result = $connect -> query($sql);

    if($result){
        $info = $result -> fetch_array(MYSQLI_ASSOC);

        echo '<p>' .$info['boardContents']. '</p>';
        // echo '<div class="contents_image"><img src='$info['boardImgFile']'></div>';
    }
?>
                
            </div>
            <div class="comment_btn">
                <div class="cinfo">
                    <span id="likeButton" class="like" data-boardid="<?= $boardId ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg> 좋아요</span> 
                    <!-- 좋아요 수를 표시할 부분 -->
                    <span id="likeCount"><?= $info['boardLike'] ?></span>

                </div>
                <div class="contents_btn">
                <?php
                $boardId = $_GET['boardId'];
                $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContents, b.memberId FROM Community b JOIN myMembers m ON(b.memberId = m.memberId) WHERE b.boardId = {$boardId}";
                // 사용자가 로그인했는지 확인
                if (isset($_SESSION['memberId'])) {
                    $currentUserId = $_SESSION['memberId'];

                    // 현재 사용자와 게시글 작성자를 비교하여 삭제하기 버튼을 표시할지 결정
                    $result = $connect->query($sql);
                    $info = $result->fetch_array(MYSQLI_ASSOC);
                    $boardAuthorId = $info['memberId'];

                    if ($currentUserId == $boardAuthorId) {
                        echo "<a href='boardModify.php?boardId=$boardId' class='btn'>수정하기</a>";
                        echo "<a href='boardRemove.php?boardId=$boardId' class='btn' onclick=\"return confirm('정말 삭제하시겠습니까?')\">삭제하기</a>";
                    }
                }
                ?>
                    <!-- <a href="boardModify.php?boardId=<?=$_GET['boardId']?>" class="btn">수정하기</a>
                    <a href="boardRemove.php?boardId=<?=$_GET['boardId']?>" class="btn" onclick="return confirm('정말 삭제하시겠습니까?')">삭제하기</a> -->
                    <a href="cummunity.php" class="btn listView_btn">목록보기</a>
                </div>
            </div>


            <div class="comments">
                <h3>댓글</h3>
                <div class="write"></div>
                <div id="" class="comment_area">
                    <p class="name"></p>
                    <div class="cmt_txt">
                        <label for="cmtTxt"></label>
                        <div class="input_container">
                            <input type="text" id="cmtTxt" name="cmtTxt" placeholder="댓글을 남겨주세요!" >
                            <button><img src="../assets/img/right.svg" alt="Clock Icon"></button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- <div class="comment-container">
                <p class="name">capitaljs***</p>
                <p class="cmt_txt">안녕하세요</p>
                <div class="comment_info">
                    <span class="date"><img src="../assets/img/clock.svg" alt="Clock Icon"> 2023.11.25</span>
                    <span class="like"><img src="../assets/img/thumbs.svg" alt="Clock Icon"> 좋아요</span>
                    <span class="cmt"><img src="../assets/img/chat.svg" alt="Clock Icon"> 730</span>
                </div>
            </div> -->

        </div>
    </main>



    <?php include "../include/footer.php" ?>
    <!-- //footer -->

    <script>
    document.getElementById("likeButton").addEventListener("click", function() {
        // 게시물 ID와 현재 좋아요 수 가져오기
        const boardId = this.getAttribute("data-boardid");
        const likeCountElement = document.getElementById("likeCount");
        let currentLikeCount = parseInt(likeCountElement.textContent);

        // AJAX 요청 보내기
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "updateLike.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                // 좋아요 수 업데이트
                if (response.success) {
                    currentLikeCount = response.likeCount;
                    likeCountElement.textContent = currentLikeCount;
                } else {
                    alert("좋아요 업데이트에 실패했습니다.");
                }
            }
        };
        xhr.send("boardId=" + boardId);
    });
    </script>

</body>
</html>