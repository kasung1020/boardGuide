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
    <script src="https://cdn.tiny.cloud/1/m4a5mpnye99j5jfshscnjj5c64774k6xdwtow2qhgfhp5rr5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>  
    <!-- 모달 -->
    <?php
    include "common/modal.php";

    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
    }

    // 'action' POST 변수가 설정되어 있는지 확인, 그 값을 $action 변수에 할당
    $action = '';
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    }

    // 'isEditMode' POST 변수가 설정되어 있는지 확인, 그 값을 $isEditMode 변수에 할당
    $isEditMode = false;
    if (isset($_POST['isEditMode'])) {
        $isEditMode = true;
    }
    
    // 만약 편집 모드라면, 현재 편집 중인 게시글의 제목과 내용을 데베에서 가져오기
    if ($isEditMode) {
        $editing_post = $_POST['current_post'];
        $get_notice = "select title, content from notice where notice_id = $editing_post";
        $result_notice = mysqli_query($dbcon, $get_notice);
        $row = mysqli_fetch_array($result_notice);
        $title = $row['title'];
        $content = $row['content'];
    }

    // 'action' POST 변수의 값이 'form_submit'인 경우, 게시글을 편집하거나 새 게시글을 작성합니다.
    if ($action == 'form_submit') {
        if ($isEditMode) {
            // 편집 모드인 경우 제목과 내용을 업데이트
            $title = $_POST["title"];
            $content = $_POST["cont"];

            $sql = "update notice set title = '$title', content = '$content' where notice_id = $editing_post";
            mysqli_query($dbcon, $sql);
            echo "<script>location.href='post.php?notice_no=$editing_post'</script>";
        } else {
            $author = $_SESSION['user_id'];
            $title = $_POST["title"];
            $content = $_POST["cont"];
            $post_time = date("Y-m-d H:i:s");
    
            $sql = "insert into notice(notice_id, title, content, post_time) ";
            $sql = $sql . "values('$author', '$title', '$content', '$post_time')";
            mysqli_query($dbcon, $sql);
            echo "<script>location.href='notice.php'</script>";
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return check();">
                <input type="hidden" name="action" value="form_submit">
                <?php
                if ($isEditMode) {
                    echo "<input type='hidden' name='isEditMode' value='1'>";
                    echo "<input type='hidden' name='current_post' value='$editing_post'>";
                }
                ?>
                <div class="board_wrap">
                    <div class="board_title1">
                        <strong style="color: black; font-size: 29px; position: relative; font-family: 'Noto Sans KR', 'Montserrat', 'GmarketSans', 'sans-serif'">공지사항 쓰기</strong>
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
                                <input class="dd1" type="file"
                                    style="color: black; width:1170px; margin: 0px 15px;"></input>
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
                if ($('#title').val()=='') {
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