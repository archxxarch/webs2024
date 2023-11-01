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
include "../connect/sessionCheck.php";

if (isset($_GET['boardId'])) {
    $boardId = $_GET['boardId'];

    // 게시글을 삭제하기 전에 해당 게시글의 번호를 얻습니다.
    $sql = "SELECT boardId FROM Community WHERE boardId = {$boardId}";
    $result = $connect->query($sql);

    if ($result && $result->num_rows > 0) {
        $info = $result->fetch_array(MYSQLI_ASSOC);
        $boardIdToDelete = $info['boardId'];

        // 게시글을 삭제한 후, 해당 게시글보다 큰 번호의 게시글들의 번호를 하나씩 감소시킵니다.
        $sql = "UPDATE Community SET boardId = boardId - 1 WHERE boardId > {$boardIdToDelete}";
        $connect->query($sql);

        // 게시글을 삭제합니다.
        $sql = "DELETE FROM Community WHERE boardId = {$boardIdToDelete}";
        $connect->query($sql);

        echo "<script>alert('게시글이 삭제되었습니다.');</script>";
    } else {
        echo "<script>alert('게시글을 찾을 수 없습니다.');</script>";
    }
} else {
    echo "<script>alert('잘못된 요청입니다.');</script>";
}
?>
<script>
    location.href = "cummunity.php";
</script>
</body>
</html>