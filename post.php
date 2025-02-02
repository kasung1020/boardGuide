<?php
include "common/dbconnect.php";

$post_id = null;
$notice_id = null;
$isNotice = false;
$return = "board.php";

if (isset($_GET['post_no'])) {
    $post_id = $_GET['post_no'];
} else if (isset($_GET['notice_no'])) {
    $notice_id = $_GET['notice_no'];
}

if (isset($_POST['current_post'])) {
    $post_id = $_POST['current_post'];
}

$action = '';
$target_post = '';
if (isset($_POST['action'])) {
    $target_post = $_POST['target_post'];
    $comment_author = $_POST['author'];
    $action = $_POST['action'];
}

if ($action == 'form_submit') {
    $comment = $_POST['comment'];
    $comment_date = date("Y-m-d H:i:s");
    $write_comment = "insert into article_comments(article, writer, content, writed_date) values ($target_post, '$comment_author', '$comment', '$comment_date')";
    mysqli_query($dbcon, $write_comment);
    echo "<script>window.location.href = './post.php?post_no=$target_post';</script>";
}

if ($post_id != null) {
    $get_article = "select c.post_type, a.title, a.content, a.user_id, m.username, a.post_time, a.image_path from article a, member m, article_category c where article_id = $post_id and a.user_id = m.user_id and a.post_type_id = c.post_type_id ";
    $result_article = mysqli_query($dbcon, $get_article);
    $row = mysqli_fetch_array($result_article);
    $title = $row['title'];
    $content = $row['content'];
    $post_date = $row['post_time'];
    $category = $row['post_type'];
    $author_id = $row['user_id'];
    $author = $row['username'];
    if (!empty($row['image_path'])) {
        $content .= '<img src="' . $row['image_path'] . '">';
    }
} else if ($notice_id != null) {
    $isNotice = true;
    $get_notice = "select * from notice where notice_id = $notice_id";
    $result_notice = mysqli_query($dbcon, $get_notice);
    $row = mysqli_fetch_array($result_notice);
    $title = $row['title'];
    $content = $row['content'];
    $post_date = $row['post_time'];
    $category = "공지";
    $author = "관리자";
    $author_id = "";
} else {
    echo "<script>alert('잘못된 접근입니다.'); window.location.href = './board.php';</script>";
}

if ($isNotice) {
    $return = "notice.php";
}

$comments_order = "desc";
if (isset($_POST['comments_order'])) {
    $comments_order = $_POST['comments_order'];
}
$get_comments = "select c.comment_id, c.writer, m.username, c.content, c.writed_date from article a, member m, article_comments c where c.article = a.article_id and a.article_id = $post_id and c.writer = m.user_id order by writed_date $comments_order";
$result_comments = mysqli_query($dbcon, $get_comments);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>BDGuide :
        <?= $title ?>
    </title>
    <!-- Font Awesome 5 라이브러리 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- 폰트스타일 -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&display=swap" rel="stylesheet">
    <!-- 스타일시트 -->
    <link rel="stylesheet" href="css/view.css?after">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/modal.css">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.x.x.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/post.js" defer="defer" type="text/javascript"></script>
</head>

<body>
    <!-- 모달 -->
    <?php
    include "common/modal.php";

    if (!$isNotice) {
        $watched = 0;
        if (isset($_SESSION['user_id'])) {
            $check_watched = "select * from article_watched where article_id = $post_id and watched_user = '$_SESSION[user_id]'";
            $result_watched = mysqli_query($dbcon, $check_watched);
            $result_count = mysqli_num_rows($result_watched);
            if ($result_count == 0) {
                $add_watched = "insert into article_watched(article_id, watched_user) values ($post_id, '$_SESSION[user_id]')";
                $exec_add = mysqli_query($dbcon, $add_watched);
            }
        } else {
            $check_watched = "select * from article_watched where article_id = $post_id and watched_ip = '$_SERVER[REMOTE_ADDR]'";
            $result_watched = mysqli_query($dbcon, $check_watched);
            $result_count = mysqli_num_rows($result_watched);
            if ($result_count == 0) {
                $add_watched = "insert into article_watched(article_id, watched_ip) values ($post_id, '$_SERVER[REMOTE_ADDR]')";
                $exec_add = mysqli_query($dbcon, $add_watched);
            }
        }

        $get_views = "select * from article_watched where article_id = $post_id";
        $result_views = mysqli_query($dbcon, $get_views);

        if ($result_views && mysqli_num_rows($result_views)) {
            $watched = mysqli_num_rows($result_views);
        }

        $liked = 0;

        $get_liked = "select * from article_liked where article_id = $post_id";
        $result_liked = mysqli_query($dbcon, $get_liked);

        if ($result_liked && mysqli_num_rows($result_liked)) {
            $liked = mysqli_num_rows($result_liked);
        }
    }
    ?>
    <!-- 상단 로고 및 로그인 -->
    <div class="all">
        <!-- 헤더 -->
        <?php
        include "common/header.php";
        ?>
        <div class="clear"></div>

        <!-- 로그인 여부에 따라 클래스를 추가 -->
        <div class="post-container">
            <div class="post-header">
                <h1 class="post-title">
                    <?= $title ?>
                </h1>
                <div class="post-info">
                    <div class="post-author">
                        글쓴이:
                        <?= $author ?>
                    </div>
                </div>
                <div class=<?= !$isNotice ? 'post_watched_date' : 'post_watched_date_notice' ?>>
                    <?php
                    if (!$isNotice) {
                        echo "<div class='post-likes'>
                            조회 : <span id='view-count'>$watched</span>
                            추천 : <span id='recommend-count' style=margin-right:0px;>$liked</span>
                        </div>";
                    }
                    ?>
                    <div class="post-date">
                        <?= $post_date ?>
                    </div>
                </div>
            </div>
            <div class="cooperation-box" style="margin-top: -5px;">
                <?= $category ?>
            </div>
            <div class="post-content">
                <?= $content ?>
            </div>
            <br><br>

            <div class="post-area2">
                <?php
                echo "<a class='btn_dark_write1' href=$return>목록</a>";

                $isMyArticle = false;

                if (isset($_SESSION['user_id'])) {
                    if ($_SESSION['isAdmin'] || $_SESSION['user_id'] == $author_id) {
                        $isMyArticle = true;
                    }
                }

                if ($isMyArticle) {
                    $edit = "./rmf.php";
                    if ($isNotice) {
                        $edit = "./noticermf.php";
                    }

                    echo "<form action='$edit' method='post' class='btn_dark_write2''>
                    <input type='hidden' name='isEditMode' value='1'>";
                    if ($isNotice) {
                        echo "<input type='hidden' name='isNotice' value='1'>";
                        echo "<input type='hidden' name='current_post' value=$notice_id>";
                    } else {
                        echo "<input type='hidden' name='current_post' value=$post_id>";
                    }
                    echo "<button type='submit' style='background-color: #333; color: #fff; font-size: 14px; font-family: Noto Sans KR, Montserrat, GmarketSans, sans-serif'>수정</button>
                    </form>";

                    echo "<form action='./board/delete_post.php' method='post' class='btn_dark_write8' onsubmit='return delete_confirm();'>";
                    if ($isNotice) {
                        echo "<input type='hidden' name='isNotice' value='1'>";
                        echo "<input type='hidden' name='current_post' value=$notice_id>";
                    } else {
                        echo "<input type='hidden' name='current_post' value=$post_id>";
                    }
                    echo "<button type='submit' style='background-color: #e55c5c; color: #fff; font-size: 14px; font-family: Noto Sans KR, Montserrat, GmarketSans, sans-serif'>삭제</button>
                    </form>";
                }
                ?>
            </div>
            <br>

            <?php
            if (!$isNotice) {
                if (isset($_SESSION['user_id'])) {
                    echo "<form action='./board/liked.php' method='post'>
                    <input type='hidden' name='target_post' value=$post_id>
                    <button type='submit' class='recommend-button1' onclick='recommendPost()' name='like'>
                    <span class='recommend-icon1'>
                        <img src='img/good.png' alt='Good' style='width: 45px; height: 45px;'>
                    </span>
                    </button>
                    </form>";
                }
                echo "<form action=$_SERVER[PHP_SELF] method='post' class='comments'>
                <h2 class='d1'>댓글
                        <input type='hidden' name='current_post' value=$post_id>
                        <select name='comments_order' onChange='this.form.submit()' style='border: 1px solid #424242; border-radius: 10px; height: 25px; color: black; font-size: 16px;'>
                            <option value='desc' " . ($comments_order == "desc" ? "selected" : "") . ">최신순</option>" .
                    "<option value='asc' " . ($comments_order == "asc" ? "selected" : "") . ">등록순</option>
                        </select>
                    <div style='float: right;'>
                        <a class='btn_dark_write3' onclick=location.reload();>
                            <img src='img/1313.png' alt='새로고침' style='width: 25px; height: 25px;'>
                        </a>
                    </form>";
                if (isset($_SESSION['user_id'])) {
                    echo "<form action='./board/report.php' method='post' style='float: right; margin-left: 6px'>
                        <input type='hidden' name='report_content' value='post'>
                        <input type='hidden' name='content_id' value=$post_id>
                        <button type='submit' class='btn_dark_write3' onclick='return report_confirm();'>
                            <img src='img/15156.png' alt='신고하기' style='width: 25px; height: 25px;'>
                        </button>
                        </form>";
                }
                echo "</h2>";

                while ($row = mysqli_fetch_array($result_comments)) {
                    $writed_date = date("Y-m-d", strtotime($row['writed_date']));
                    echo "<div class='comment'>
                    <div class='comment-author'>$row[username]
                        <div class='comment-date'>$writed_date";
                    // 댓글 신고
                    if (isset($_SESSION['user_id'])) {
                        echo "<form action='./board/report.php' method='post' style='margin-left: 10px; float: right'>
                            <input type='hidden' name='report_content' value='comment'>
                            <input type='hidden' name='content_id' value=$row[comment_id]>
                            <button type='submit' class='btn_dark_write4' onclick='return report_confirm();' style='background-color: #ffffff'>
                            <img src='img/15156.png' alt='신고하기' style='width: 15px; height: 15px; background-color: #ffffff'>
                            </button>
                            </form>";
                    }
                    echo "</div>";
                    if (isset($_SESSION['user_id'])) {
                        if ($_SESSION['isAdmin'] || $_SESSION['user_id'] == $row['writer']) {
                            echo "<form action='./board/delete_comment.php' method='post' onsubmit='return delete_confirm();'>
                                <input type='hidden' name='comment_id' value=$row[comment_id]>
                                <button type='submit' onclick='return confirm('삭제하시겠습니까?');' class='modal_close_login_01' style='font-size: 29px;'>
                                <span class='modal_close_signup'>&times;</span>
                                </button>
                                </form>";
                        }
                    }
                    echo "</div>
                    <p class='comment-text'>$row[content]</p>
                </div>";
                }
                if (isset($_SESSION['user_id'])) {
                    echo
                        "<div class='comment_wrap'>
                    <div class='regi_box'>
                        <form action=$_SERVER[PHP_SELF] method='post' name='commentFrm' id='commentFrm0' onSubmit='return check();'>
                            <input type='hidden' name='action' value='form_submit'>
                            <input type='hidden' name='target_post' value=$post_id>
                            <input type='hidden' name='author' value=$_SESSION[user_id]>
                            <div class='text_overflow'>
                                <textarea id='comment0' name='comment' onclick='regCommentChk();' maxlength='600'
                                    placeholder='댓글을 입력해주세요. (0/400)'></textarea>
                                <div id='regi_count'></div>
                            </div>
                            <button type='submit' onclick='regComment(0);'>등록하기</button>
                        </form>
                    </div>
                </div>";
                }
            }
            ?>
        </div>
        <script>
            function check() {
                if ($('#comment0').val() == '') {
                    alert("내용을 입력해주세요.");
                    return false;
                }
                return true;
            }

            function delete_confirm() {
                if (confirm("삭제하시겠습니까?")) {
                    return true;
                } else {
                    return false;
                }
            }

            function report_confirm() {
                if (confirm("신고하시겠습니까?")) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
        <div class="clear"></div>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>