<?php
include "common/dbconnect.php";

// 전체 게시글 수 가져오기
$get_all_notice = "select * from notice";
$result_all_notice = mysqli_query($dbcon, $get_all_notice);
$total_notice = mysqli_num_rows($result_all_notice);

// 페이지 수 계산
$notice_per_page = 10;
$pages = ceil($total_notice / $notice_per_page);

// 현재 페이지
$current_page = 1;
if (isset($_GET["page"])) {
    $current_page = $_GET['page'];
}

// 검색 결과
$search_type = "";
$keyword = "";
$search_query = "";
if (isset($_GET["search_type"]) && isset($_GET["keyword"])) {
    $search_type = $_GET["search_type"];
    $keyword = $_GET["keyword"];
    if ($search_type != '') {
        if ($search_type == 1) {
            $search_query = "where title like '%" . $keyword . "%' ";
        }
    }
}

// 공지사항 가져오기
$get_notice = "select * from notice " . $search_query . "order by notice_id desc limit " . (($current_page - 1) * $notice_per_page) . ", " . $notice_per_page;
$result_notice = mysqli_query($dbcon, $get_notice);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 공지사항</title>
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
    <link rel="stylesheet" href="css/board.css">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.x.x.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <!-- 모달 -->
    <?php
    include "common/modal.php";
    ?>
    <!-- 화면시작 -->
    <div class="all">
        <!-- 헤더 -->
        <?php
        include "common/header.php";
        ?>

        <div class="clear"></div>

        <main id="notice">
            <table>
                <tr>
                    <td class="article_title" colspan="4" height="70px" style="border-bottom: 1px solid #000;">
                        <div align="right">
                            <a href="#" class="newtitle" target="_self"
                                style="color:#20124d; font-weight: bold; text-decoration: none; float: left;">공지사항</a>
                            <?php
                                if (isset($_SESSION['user_id']) && $_SESSION['isAdmin']) {
                                    echo "<a href='noticermf.php' class='top_buttons' width='20px' height='30px'>글쓰기</a>";
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr align="center">
                    <td class="wt">번호</td>
                    <td class="wt">제목</td>
                    <td class="wt">글쓴이</td>
                    <td class="wt2">등록일</td>
                </tr>

                <!-- 글 가져오는 부분 -->
                <?php
                //공지
                while ($row = mysqli_fetch_array($result_notice)) {
                    $post_date = date("Y-m-d", strtotime($row['post_time']));
                    echo "<tr>
                    <td class='article'> $row[notice_id] </td>
                    <td class='article_title'><a href='post.php?notice_no=$row[notice_id]'> $row[title] </a></td>
                    <td class='article'> 관리자 </td>
                    <td class='article'> $post_date </td>
                    </tr>";
                }
                echo "</table>
                <form class='pages' align='center' style='margin-top: 10px;' action=$_SERVER[PHP_SELF] method='get'>"; ?>
                    <li>
                        <?php
                        // 이전 페이지 링크
                        // 현재 페이지가 1보다 크면 이전 페이지 링크 활성화
                        if ($current_page > 1) {
                            $prev_page = $current_page - 1;
                            $filter_params['page'] = $prev_page;
                            $prev_query_string = http_build_query($filter_params);
                            echo "<a href='?" . $prev_query_string . "' class='pre-btn' title='이전 페이지로 이동합니다'>이전</a>";
                        }
                        ?>
                    </li>
                    <?php
                    for ($i = 1; $i <= $pages; $i++) {
                        $args = "";
                        if ($current_page == $i) {
                            $args = "class='on'";
                        }
                        echo "<li><a href='?page=$i' " . $args . ">$i</a></li>";
                    }
                    ?>
                    <li>
                        <?php
                        // 다음 페이지 링크
                        // 현재 페이지가 마지막 페이지보다 작으면 다음 페이지 링크 활성화
                        if ($current_page < $pages) {
                            $next_page = $current_page + 1;
                            $filter_params['page'] = $next_page;
                            $next_query_string = http_build_query($filter_params);
                            echo "<a href='?" . $next_query_string . "' class='next-btn' title='다음 페이지로 이동합니다'>다음 <i class='fas fa-angle-right'></i></a>";
                        }
                        ?>
                    </li>
                </form>
                <?php 
                // DB 연결 종료
                mysqli_close($dbcon);
                ?>
            <br>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                <table class="search" style="border: 1px solid #888888">
                    <tr>
                        <td>
                            <select name="search_type">
                                <option value="1">제목+내용</option>
                            </select>
                        </td>
                        <td>
                            <input name="keyword" type="text"
                                style="border-left: 1px solid #888888; border-right: 1px solid #888888">
                        </td>
                        <td>
                            <button type="submit" class="search_btn">
                                <i class="fas fa-search"></i>
                                <span class="sr-only">검색</span>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </main>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>