<?php
include "../connect/connect.php";
include "../connect/session.php";

if (isset($_POST["boardId"])) {
    $boardId = $_POST["boardId"];
    
    // 좋아요 수 업데이트 SQL 실행
    $sql = "UPDATE Community SET boardLike = boardLike + 1 WHERE boardId = $boardId";
    $result = $connect->query($sql);
    
    if ($result) {
        // 업데이트된 좋아요 수를 반환
        $newLikeCount = getNewLikeCount($boardId);
        echo json_encode(["success" => true, "likeCount" => $newLikeCount]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false]);
}

function getNewLikeCount($boardId) {
    global $connect;
    
    $sql = "SELECT boardLike FROM Community WHERE boardId = $boardId";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    return $row["boardLike"];
}
?>
