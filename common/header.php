        <div id="header_login_box">
            <!-- 로그인, 회원가입 버튼 -->
            <div id="login_headerbox">
                <div class="auth-buttons">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <button class="login-btn">로그인</button>
                        <button class="signup-btn" id="openSignupModal">회원가입</button>
                        <button class="login-btn" style="display: none;">로그아웃</button>
                    <?php else: ?>
                        <button class="login-btn" style="display: none;">로그인</button>
                        <button class="login-btn" onclick="location.href='./user/logout.php'">로그아웃</button>
                        <button class="mypage-btn"><a href="mypage.php">마이페이지</a></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <header class="wrap">
            <div id="header_div" class="wrap">
                <!-- 메뉴바 -->
                <button type="button" class="btn-menu">
                    <!-- Font Awesome 아이콘으로 변경 -->
                    <i class="fas fa-bars"></i>
                    <span class="sr-only">Toggle Sidebar</span>
                </button>
                <!-- 로고 -->
                <div class="logo">
                    <a href="index.php">
                        <img src="img/bdguide.png" alt="로고 이미지">
                    </a>
                </div>
                <!-- 카테고리 시작 -->
                <div class="menu_header_div">
                    <ul class="menu">
                        <li class="menu__item">
                            <a href="game_all_rank.php" class="menu__link">
                                <span class="menu__title">
                                    <span class="menu__first-word" data-hover="게임">
                                        게임
                                    </span>
                                    <span class="menu__second-word" data-hover="찾기">
                                        찾기
                                    </span>
                                </span>
                                <!-- Font Awesome 꺽쇠 아이콘 추가 -->
                                <i class="fas fa-angle-down">
                                </i>
                            </a>
                            <ul class="submenu">
                                <li><a href="game_all_rank.php">게임 인기순위</a></li>
                                <li><a href="gametop3.php">게임 추천 TOP 3<img src="img/crown.png" class="crown_img"
                                            alt="no"></a></li>
                                <li><a href="newgame.php">신규 보드게임</a></li>
                            </ul>
                        </li>
                        <li class="menu__item">
                            <a href="board.php" class="menu__link">
                                <span class="menu__title">
                                    <span class="menu__first-word" data-hover="정보 공유">
                                        정보 공유
                                    </span>
                                    <span class="menu__second-word" data-hover="게시판">
                                        게시판
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li id="menu_item_support">
                            <a href="faq.php" id="support_tag_right">도움말
                                <i class="fas fa-angle-down" id="angle-right"></i>
                            </a>
                            <ul class="submenu" id="submenu_support">
                                <li><a href="faq.php">자주 묻는 질문</a></li>
                                <li><a href="notice.php">공지사항</a></li>
                                <li><a href="contact_us.php">문의 하기</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- 검색창 -->
                <div class="search_box">
                    <input type="text" placeholder="검색...">
                    <button class="search_btn" onclick="searchProc(); return false;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </header>