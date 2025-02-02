<?php
include "common/dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 정보 공유 게시판</title>
    <!-- Font Awesome 5 라이브러리 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- 폰트스타일 -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&display=swap" rel="stylesheet">
    <!-- 스타일시트 -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/rmf.css?after">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.x.x.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- WYSIWYG 에디터 글쓰기 도구툴 -->
    <script src="https://cdn.tiny.cloud/1/m4a5mpnye99j5jfshscnjj5c64774k6xdwtow2qhgfhp5rr5/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
</head>

<body>
    <!-- 모달 -->
    <?php
    include "common/modal.php";


    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
    }

    $action = '';
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    }

    $isEditMode = false;

    if (isset($_POST['isEditMode'])) {
        $isEditMode = true;
    }

    if ($isEditMode) {
        $editing_post = $_POST['current_post'];
        $get_article = "select post_type_id, title, content from article where article_id = $editing_post";
        $result_article = mysqli_query($dbcon, $get_article);
        $row = mysqli_fetch_array($result_article);
        $title = $row['title'];
        $content = $row['content'];
        $category = $row['post_type_id'];
    }

    if ($action == 'form_submit') {
        $author = $_SESSION['user_id'];
        $title = $_POST["title"];
        $category = $_POST["category"];
        $content = $_POST["cont"];
        $post_time = date("Y-m-d H:i:s");

        // 파일 업로드 처리
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $target_dir = "uploads/"; // 파일이 저장될 디렉토리 경로
            $target_file = $target_dir . basename($_FILES["file"]["name"]); // 파일 경로와 파일명
    
            // 파일을 지정된 디렉토리로 이동
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                echo "파일 업로드 성공";

                // 파일 경로를 데이터베이스에 저장
                $sql = "INSERT INTO article (user_id, title, post_type_id, content, post_time, image_path) VALUES ('$author', '$title', '$category', '$content', '$post_time', '$target_file')";
                mysqli_query($dbcon, $sql);
                echo "데이터베이스에 파일 경로 저장 성공";
            } else {
                echo "파일 업로드 실패";

                // 파일 업로드가 실패했을 경우, 이미지 없이 글을 등록
                $sql = "INSERT INTO article (user_id, title, post_type_id, content, post_time) VALUES ('$author', '$title', '$category', '$content', '$post_time')";
                mysqli_query($dbcon, $sql);
            }
        } else {
            // 파일 업로드가 없는 경우, 이미지 없이 글을 등록
            $sql = "INSERT INTO article (user_id, title, post_type_id, content, post_time) VALUES ('$author', '$title', '$category', '$content', '$post_time')";
            mysqli_query($dbcon, $sql);
        }

        echo "<script>location.href='board.php'</script>";
    }

    if ($action == 'form_submit') {
        if ($isEditMode) { //수정모드일경우
            $category = $_POST["category"];
            $title = $_POST["title"];
            $content = $_POST["cont"];
            $edit_time = date("Y-m-d H:i:s");

            // 파일 업로드 처리
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $target_dir = "uploads/"; // 파일이 저장될 디렉토리 경로
                $target_file = $target_dir . basename($_FILES["file"]["name"]); // 파일 경로와 파일명
    
                // 파일을 지정된 디렉토리로 이동
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "파일 업로드 성공";

                    // 파일 경로를 데이터베이스에 저장
                    $sql = "UPDATE article SET post_type_id = '$category', title = '$title', content = '$content', post_edited = '$edit_time', image_path = '$target_file' WHERE article_id = $editing_post";
                    mysqli_query($dbcon, $sql);
                    echo "데이터베이스에 파일 경로 저장 성공";
                } else {
                    echo "파일 업로드 실패";
                }
            }

            echo "<script>location.href='post.php?post_no=$editing_post'</script>";
        } else { //작성했을 때
            $author = $_SESSION['user_id'];
            $title = $_POST["title"];
            $category = $_POST["category"];
            $content = $_POST["cont"];
            $post_time = date("Y-m-d H:i:s");

            // 파일 업로드 처리
            //글로벌 변수 HTTP 메서드 웹 브라우저가 서버에게 요청을 보낼 때 사용되는 방식
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $target_dir = "uploads/"; // 파일이 저장될 디렉토리 경로
                $target_file = $target_dir . basename($_FILES["file"]["name"]); // 파일 경로와 파일명
    
                // 파일을 지정된 디렉토리로 이동
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "파일 업로드 성공";

                    // 파일 경로를 데이터베이스에 저장
                    $sql = "INSERT INTO article (user_id, title, post_type_id, content, post_time, image_path) VALUES ('$author', '$title', '$category', '$content', '$post_time', '$target_file')";
                    mysqli_query($dbcon, $sql);
                    echo "데이터베이스에 파일 경로 저장 성공";
                } else {
                    echo "파일 업로드 실패";
                }
            }

            echo "<script>location.href='board.php'</script>";
        }
    }
    ?>
    <!-- 화면시작 -->
    <div class="all">
        <!-- 헤더 -->
        <?php
        include "common/header.php";
        ?>

        <div class="clear"></div>
        <main class="wrap" style="height: 690px;">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"
                onSubmit="return check();">
                <input type="hidden" name="action" value="form_submit">
                <?php
                if ($isEditMode) {
                    echo "<input type='hidden' name='isEditMode' value='1'>";
                    echo "<input type='hidden' name='current_post' value='$editing_post'>";
                }
                ?>
                <div class="board_wrap">
                    <div class="board_title1">
                        <strong
                            style="color: black; font-size: 29px; position: relative; font-family: 'Noto Sans KR', 'Montserrat', 'GmarketSans', 'sans-serif'">게시판
                            글쓰기</strong>
                        <select name="category"
                            style="padding:0px 5px; color: black; outline: none; border: 1px solid #424242; border-radius: 12px; height: 29px; position: absolute; top : 150px; margin-left: 17px; font-family: 'Noto Sans KR', 'Montserrat', 'GmarketSans', 'sans-serif'">
                            <option value="cat_1">팁과 노하우</option>
                            <option value="cat_2">협력</option>
                            <option value="cat_3">경쟁</option>
                            <option value="cat_4">카드 게임</option>
                            <option value="cat_5">경제</option>
                            <option value="cat_6">마피아</option>
                            <option value="cat_7">블러핑</option>
                            <option value="cat_8">추상 전략</option>
                            <option value="cat_9">방탈출</option>
                            <option value="cat_10">추리</option>
                            <select>
                    </div>
                    <div class="board_write_wrap1">
                        <div class="board_write1">
                            <div class="rmf_title">
                                <label for="rmf-title">제목</label>
                                <dl>
                                    <?php
                                    if (!$isEditMode) {
                                        $title = '';
                                    }
                                    echo "<dd><input id='title' name='title' type='text' placeholder='제목을 입력해주세요.' maxlength='30' value='$title'></dd>"
                                        ?>
                                </dl>
                                <script>
                                    // 글쓰기 툴
                                    tinymce.init({
                                        selector: '#mytextarea',
                                        language : 'ko_KR'
                                    });
                                </script>
                            </div>
                            <div class="cont">
                                <textarea id="mytextarea" name="cont" placeholder="내용을 입력해주세요.">
                                    <?php
                                    if ($isEditMode) {
                                        echo $content;
                                    }
                                    ?>
                                </textarea>
                            </div>
                            <br>
                            <div>
                                <input class="dd1" type="file" name="file">
                            </div>
                        </div>
                        <div class="bt_wrap1">
                            <input type="submit" class="on" value="등록">
                            <input type="button" value="취소" onclick="history.back();">
                        </div>
                    </div>
                </div>
            </form>
        </main>
        <script>
            function check() {
                if ($('#title').val() == '') {
                    alert("제목을 입력해주세요.");
                    return false;
                }
                return true;
            }
        </script>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>