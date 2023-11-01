<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    if (isset($_GET['page'])) {
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

    $searchKeyword = $_GET['searchKeyword'];
    $searchOption = $_GET['searchOption'];

    $searchKeyword = $connect->real_escape_string(trim($searchKeyword));
    $searchOption = $connect->real_escape_string(trim($searchOption));

    $sql = "SELECT b.boardId, b.boardTitle, b.boardContents, m.youName, b.regTime, b.boardView, b.boardLike FROM Community b JOIN myMembers m ON(b.memberId = m.memberId) ";

    switch ($searchOption) {
        case "title":
            $sql .= "WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardId DESC";
            break;
        case "content":
            $sql .= "WHERE b.boardContents LIKE '%{$searchKeyword}%' ORDER BY boardId DESC";
            break;
        case "name":
            $sql .= "WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardId DESC";
            break;
    }

    

    $result = $connect -> query($sql);

    $totalCount = $result -> num_rows;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go!교복</title>
    
    <link rel="stylesheet" href="../assets/css/cummunity.css">

    <!-- CSS -->
    <?php include "../include/head.php" ?>

</head>
<body>
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    
    <main id="main">
        <div class="intro__inner community_inner">
            <div class="intro__text">
                <h2>수다방</h2>
                <p>
                    🥳 교복 커뮤니티에 오신걸 환영합니다!
                </p>
            </div>
        </div>
        <section class="board__inner container">
            <div class="board__search">
                <div class="left">
                    * 총 <em><?=$totalCount?></em>건의 게시물이 검색 되었습니다.
                </div>
                <!-- <div class="right board__select">
                    <form action="boardSearch.php" name="boardSearch" method="get">
                        <fieldset>
                            <input type="search" name="searchKeyword" id="searchKeyword" placeholder="검색어를 입력하세요!" required>
                            <select name="searchOption" id="searchOption">
                                <option value="title">제목</option>
                                <option value="content">내용</option>
                                <option value="name">등록자</option>
                            </select>
                            <button type="submit" class="btn__style3 white">검색</button>
                            <a href="boardWrite.php" class="btn__style3">글쓰기</a>
                        </fieldset>
                    </form>
                </div> -->
            </div>
            <div class="board__table">
                <table>
                    <colgroup>
                        <col style="width: 5%;">
                        <col>
                        <col style="width: 10%;">
                        <col style="width: 15%;">
                        <col style="width: 7%;">
                        <col style="width: 7%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>View</th>
                            <th>Like</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    $viewNum = 10;
    $viewLimit = ($viewNum * $page) - $viewNum;

    $sql .= " LIMIT {$viewLimit}, {$viewNum}";
    $result = $connect -> query($sql);

    if($result){
        $count = $result -> num_rows;

        if($count > 0){
            for($i=0; $i<$count; $i++){
                $info = $result -> fetch_array(MYSQLI_ASSOC);

                echo "<tr>";
                echo "<td>".$info['boardId']."</td>";
                echo "<td><a href='communityView.php?boardId={$info['boardId']}'>".$info['boardTitle']."</a></td>";
                echo "<td>".$info['youName']."</td>";
                echo "<td>".date('Y-m-d', $info['regTime'])."</td>";
                echo "<td>".$info['boardView']."</td>";
                echo "<td>".$info['boardLike']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>게시글이 없습니다.</td></tr>";
        }
    } else {
        echo "관리자에게 문의해주세요!!";
    }
?>                           
                    </tbody>
                </table>
            </div>
            <div class="board__pages">
                <ul>
<?php
    // 총 페이지 갯수
    $boardTotalCount = ceil($boardTotalCount/$viewNum);

    // 1 2 3 4 5 6 [7] 8 9 10 11 12 13
    $pageView = 5;
    $startPage = $page - $pageView;
    $endPage = $page + $pageView;

    // 처음 페이지 초기화 / 마지막 페이지 초기화
    if($startPage < 1) $startPage = 1;
    if($endPage >= $boardTotalCount) $endPage = $boardTotalCount;

   // 처음으로/이전
    if ($page != 1) {
        $prevPage = $page - 1;
        echo "<li class='first'><a href='cummunitySearch.php?page=1&searchKeyword={$searchKeyword}&searchOption={$searchOption}'><svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><style>svg{fill:#303030}</style><path d='M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L301.3 256 438.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z'/></svg></a></li>";
        echo "<li class='prev'><a href='cummunitySearch.php?page={$prevPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'><svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 320 512'><style>svg{fill:#303030}</style><path d='M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z'/></svg></a></li>";
    }

    // 페이지
    for ($i = $startPage; $i <= $endPage; $i++) {
        $active = "";
        if ($i == $page) $active = "active";

        echo "<li class='{$active}'><a href='cummunitySearch.php?page={$i}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>${i}</a></li>";
    }

    // 마지막으로/다음
    if ($page != $boardTotalCount) {
        $nextPage = $page + 1;
        echo "<li class='next'><a href='cummunitySearch.php?page={$nextPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'><svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 320 512'><style>svg{fill:#303030}</style><path d='M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z'/></svg></a></li>";
        echo "<li class='last'><a href='cummunitySearch.php?page={$boardTotalCount}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'><svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><style>svg{fill:#303030}</style><path d='M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0-45.3s32.8 12.5 45.3 0z'/></svg></a></li>";
    }
?>
            </div>
        </section>
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->
</body>
</html>