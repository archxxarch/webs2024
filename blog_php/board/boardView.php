<?php
    include "../connect/connect.php";
    include "../connect/session.php";    
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Go!교복</title>
        <link rel="stylesheet" href="../assets/css/communityD.css">
    
        <link rel="stylesheet" href="../assets/css/common.css">
        <link rel="stylesheet" href="../assets/css/reset.css">
        <link rel="stylesheet" href="../assets/css/fonts.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@400;900&display=swap" rel="stylesheet">
        <style>
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .title {
            margin-right: 10px;
            font-weight: bold;
            font-size:25px;
        }

        .name {
            margin-right: 10px;
            font-size:15px;
        }
        .small-text {
            font-size: 12px; /* 원하는 글씨 크기로 조정 */
            margin-top: 2px;
            margin-left:2px;
            color: #94969b;
        }
        .icon1 {
            width: 16px;
            height: 16px;
        }
        .icon2 {
            width: 16px;
            height: 16px;
            margin-left: 8px;
        }
        .icon3 {
            width: 16px;
            height: 16px;
            margin-left: 8px;
        }
        </style>
    </head>
<body>
    <?php include "../include/header.php" ?>
        <!-- //header -->


    <main id="main">
        <div class="container view_inner">
            <div class="article">
            <?php
    $boardID = $_GET['boardID'];

    // 보드 뷰 + 1
    $sql = "UPDATE board SET boardView = boardView + 1 WHERE boardID = {$boardID}";
    $connect -> query($sql);

    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContents FROM board b JOIN blog_myMembers m ON(b.memberID = m.memberId) WHERE b.boardID = {$boardID}";
    $result = $connect -> query($sql);

    if($result){
        $info = $result -> fetch_array(MYSQLI_ASSOC);

        echo "<tr><th>제목</th><td>".$info['boardTitle']."</td></tr>";
        echo "<tr><th>등록자</th><td>".$info['youName']."</td></tr>";
        echo "<tr><th>등록일</th><td>".date('Y-m-d', $info['regTime'])."</td></tr>";
        echo "<tr><th>조회수</th><td>".$info['boardView']."</td></tr>";
    }


?>
            </div>

            <div class="content">
<?php
    $boardID = $_GET['boardID'];

    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContents FROM board b JOIN blog_myMembers m ON(b.memberID = m.memberId) WHERE b.boardID = {$boardID}";
    $result = $connect -> query($sql);

    if($result){
        $info = $result -> fetch_array(MYSQLI_ASSOC);

        echo "<tr><th>내용</th><td>".$info['boardContents']."</td></tr>";
    }


?>
                <!-- <div class="contents_image">
                    <img src="../assets/img/image153.png" alt="">
                </div> -->
            </div>
            
            <div class="comment_btn">
                <div class="cinfo">
                    <span class="like"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg> 좋아요</span>
                    <span class="cmt"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M168.2 384.9c-15-5.4-31.7-3.1-44.6 6.4c-8.2 6-22.3 14.8-39.4 22.7c5.6-14.7 9.9-31.3 11.3-49.4c1-12.9-3.3-25.7-11.8-35.5C60.4 302.8 48 272 48 240c0-79.5 83.3-160 208-160s208 80.5 208 160s-83.3 160-208 160c-31.6 0-61.3-5.5-87.8-15.1zM26.3 423.8c-1.6 2.7-3.3 5.4-5.1 8.1l-.3 .5c-1.6 2.3-3.2 4.6-4.8 6.9c-3.5 4.7-7.3 9.3-11.3 13.5c-4.6 4.6-5.9 11.4-3.4 17.4c2.5 6 8.3 9.9 14.8 9.9c5.1 0 10.2-.3 15.3-.8l.7-.1c4.4-.5 8.8-1.1 13.2-1.9c.8-.1 1.6-.3 2.4-.5c17.8-3.5 34.9-9.5 50.1-16.1c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9zM144 272a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm144-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm80 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg> 댓글</span>
                </div>
                <div class="contents_btn">
                    <a href="boardModify.php?boardID=<?=$_GET['boardID']?>" class="btn">수정하기</a>
                    <a href="boardRemove.php?boardID=<?=$_GET['boardID']?>" class="btn" onclick="return confirm('정말 삭제하시겠습니까?')">삭제하기</a>
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

        </div>
    </main>


    <footer id="footer">
        <p>Copyright 2023 Gogyobok</p>
    </footer>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/common.js"></script>
</body>
</html>
