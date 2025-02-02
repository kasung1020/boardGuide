<?php
include "common/dbconnect.php";

// 파일 업로드 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/"; // 파일이 저장될 디렉토리 경로
    $target_file = $target_dir . basename($_FILES["file"]["name"]); // 파일 경로와 파일명

    // 파일을 지정된 디렉토리로 이동
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "파일 업로드 성공";

        // 파일 경로를 데이터베이스에 저장
        $sql = "INSERT INTO images (image_path) VALUES ('$target_file')";
        if ($conn->query($sql) === TRUE) {
            echo "데이터베이스에 파일 경로 저장 성공";
        } else {
            echo "데이터베이스에 파일 경로 저장 실패: " . $conn->error;
        }
    } else {
        echo "파일 업로드 실패";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="업로드">
    </form>
</body>
</html>
