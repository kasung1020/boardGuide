<?php
session_start();

// 로그인 상태 유지를 위한 쿠키가 존재하고 그리고 사용자 세션이 설정되지 않은 경우
if (isset($_COOKIE['staylogin']) && !isset($_SESSION['user_id'])) {
    $token = $_COOKIE['staylogin'];
    // 유효 기간이 지나지 않은 토큰을 확인하여 사용자 ID를 세션에 저장
    $query = "SELECT `user_id`, `token_expiry` FROM `member` WHERE `user_token` = '$token' AND `token_expiry` > NOW()";
    $result = mysqli_query($dbcon, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
    }
}

?>

<!-- 모달 -->
<div id="menuModal" class="modal">
    <div id="sitemap_body">
        <h3 class="sitemap_title">BDGUIDE</h3>
        <ul class="deps1">
            <li>
                <a class="toggle" href="javascript:void(0);">게임 찾기</a>
                <ul class="deps2" style="display: none;">
                    <li><a class="on" href="game_all_rank.php">게임 인기순위</a></li>
                    <li><a href="gametop3.php">게임추천 TOP3<img src="img/crown.png" class="crown_img3" alt="no"></a>
                    </li>
                    <li><a href="newgame.php">신규 보드게임</a></li>
                </ul>
            </li>
            <li class="no-toggle">
                <a href="board.php">정보 공유 게시판</a>
            </li>
            <li>
                <a class="toggle" href="javascript:void(0);">도움말</a>
                <ul class="deps2" style="display: none;">
                    <li><a class="on" href="faq.php">자주 묻는 질문</a></li>
                    <li><a href="notice.php">공지사항</a></li>
                    <li><a href="contact_us.php">문의 하기</a></li>
                </ul>
            </li>
            <!-- 만약 세션아이디로 userid를 받아온다면 / 끝에 : 는 endif를 쓰기 위해 있음 -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <a href="mypage.php">마이페이지</a>
                    <ul class="deps2" style="display: none;">
                        <li><a href="mypage.php">내 정보</a></li>
                        <li><a class="userquit_modal_bottom" href="#" onclick="return false;">회원탈퇴</a></li>
                    </ul>
                </li>
                <!-- endif는 if 조건문을 종료하기 위함  -->
            <?php endif; ?>
        </ul>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="sitemap_bottom">
                <a class="login_modal_bottom" href="#" onclick="return false;">로그인</a>
                <a class="sign_up_modal_bottom" href="#" onclick="return false;">회원가입</a>
            </div>
        <?php else: ?>
            <div class="sitemap_bottom">
                <a class="login_modal_bottom" onclick="location.href='./user/logout.php'">로그아웃</a>
                <a class="sign_up_modal_bottom" href="mypage.php"">마이페이지</a>
            </div>
        <?php endif; ?>
        <button class="sitemap_modal_close" onclick="return false;">
            <i class='fa-solid fa-xmark' style='color: white'></i>
        </button>
    </div>
</div>
<!-- 회원가입 모달 -->
<div id="signUpModal" class="modal">
    <div class="modal_content in_fixed_btn on">
        <button class="modal_close_signup">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 class="modal_title">회원가입</h2>
        <h3 class="modal_step">1 / 2 단계</h3>
        <div id="signUpForm">
            <label for="username">아이디<span class="input-hint">4 ~ 20 자 이내로 사용 가능합니다.</span></label>
            <input type="text" id="username" name="username" required><br>
            <span id="usernameError" class="signUperror"></span>
            <label for="nickname">닉네임</label>
            <input type="text" id="nickname" name="nickname" required><br>
            <span id="nicknameError" class="signUperror"></span>
            <label for="password">비밀번호<span class="input-hint">8~16 영문 대/소문자, 숫자를 사용 가능합니다.</span></label>
            <input type="password" id="password" name="password" required><br>
            <span id="passwordError" class="signUperror"></span>
            <label for="password-confirm">비밀번호 확인</label>
            <input type="password" id="password-confirm" name="password_confirm" required><br>
            <span id="confirmError" class="signUperror">비밀번호가 일치하지 않습니다.</span>
            <label for="email">이메일</label>
            <input type="email" id="email" name="email" required><br>
            <span id="emailError" class="signUperror"></span>
            <button type="button" id="nextBtn">다음</button>
        </div>
        <p class="modal_note">가입하면 <a class="modal_link" href="terms_of_use.php" target="_blank">서비스 이용약관</a> 및
            <a class="modal_link" href="terms_of_use.php" target="_blank">개인 정보 보호 정책</a>에 동의하는 것입니다.
        </p>
        <p class="modal_note">이미 계정이 있나요? <a class="modal_link" href="#">로그인</a></p>
    </div>
</div>
<!-- 선택사항 모달 -->
<script>
    $(function () {
        var username;
        var password;
        var nickname;
        var email;

        $("#nextBtn").click(function () {
            username = $("#username").val();
            password = $("#password").val();
            nickname = $("#nickname").val();
            email = $("#email").val();
        });

        $("#completeSignUpBtn").click(function () {
            $("input[type=hidden][name=name]").val(username);
            $("input[type=hidden][name=nickname]").val(nickname);
            $("input[type=hidden][name=password]").val(password);
            $("input[type=hidden][name=email]").val(email);
            var user_settings = "";
            var preference = $(".button-group button.active").get();
            $.each(preference, function (index, item) {
                user_settings = user_settings + preference[index].innerHTML + " ";
            });
            $("input[type=hidden][name=user_settings]").val(user_settings);
        });

        $("#laterSignUpBtn").click(function () {
            $("input[type=hidden][name=name]").val(username);
            $("input[type=hidden][name=nickname]").val(nickname);
            $("input[type=hidden][name=password]").val(password);
            $("input[type=hidden][name=email]").val(email);
            var user_settings = "";
            $("input[type=hidden][name=user_settings]").val(user_settings);
        });
    });
</script>
<div id="preferenceModal" class="modal">
    <div class="modal_content">
        <!-- 모달 상단: 제목 및 닫기 버튼 -->
        <span class="modal_close_signup">&times;</span>
        <h2 class="modal_title">회원가입</h2>
        <h3 class="modal_step">2 / 2 단계</h3>
        <p>원하는 테마를 선택해주세요. (중복 선택 가능)</p>
        <form id="preferenceForm" action="./user/register.php" method="post">
            <input type="hidden" id="name" name="name" value="">
            <input type="hidden" id="nickname" name="nickname" value="">
            <input type="hidden" id="password" name="password" value="">
            <input type="hidden" id="email" name="email" value="">
            <input type="hidden" id="user_settings" name="user_settings" value="">
            <div class="button-group">
                <button type="button" data-value="건설">건설</button>
                <button type="button" data-value="경제">경제</button>
                <button type="button" data-value="공포">공포</button>
                <button type="button" data-value="미스터리">미스터리</button>
                <button type="button" data-value="블러핑">블러핑</button>
                <button type="button" data-value="숫자">숫자</button>
                <button type="button" data-value="자원">자원</button>
                <button type="button" data-value="전략">전략</button>
                <button type="button" data-value="추리">추리</button>
                <button type="button" data-value="카드">카드</button>
                <button type="button" data-value="카드게임">카드게임</button>
                <button type="button" data-value="탐험">탐험</button>
                <button type="button" data-value="파티게임">파티게임</button>
                <button type="button" data-value="판타지">판타지</button>
                <button type="button" data-value="협동">협동</button>
                <button type="button" data-value="협력">협력</button>
                <button type="button" data-value="호러">호러</button>
            </div>
            <button type="submit" id="completeSignUpBtn">완료</button>
            <button type="submit" id="laterSignUpBtn">나중에 선택하기</button>
        </form>
        <!-- 하단에 추가적인 정보나 링크 -->
        <p class="modal_note">선택은 나중에 변경하실 수 있습니다.</p>
    </div>
</div>
<!-- 로그인 모달 -->
<div id="loginModal" class="modal">
    <div class="modal_content in_fixed_btn on">
        <button class="modal_close_login">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="login_logo">
            <img src="img/bdguide.png" alt="로고 이미지" onclick="return false;">
        </div>
        <form id="loginForm" method="post" action="./user/login.php">
            <label for="loginUsername">아이디</label>
            <input type="text" placeholder="아이디" id="loginUsername" name="username" required><br>
            <span id="loginUsernameError" class="loginError">아이디를 입력해주세요.</span>
            <label for="loginPassword">비밀번호</label>
            <input type="password" placeholder="비밀번호" id="loginPassword" name="password" required><br>
            <span id="loginPasswordError" class="loginError">비밀번호를 입력해주세요.</span>
            <!-- 로그인 상태 유지 -->
            <input type="checkbox" id="stayLoggedIn" name="stayLoggedIn" style="width: 14px; height: 14px;">
            <label for="stayLoggedIn">로그인 상태 유지</label><br>
            <button type="button" id="loginBtn">로그인</button>
        </form>
        <p class="find_credentials" style="text-align: center;">
            <a class="modal_link" href="#" style="font-size: 14px;">아이디 찾기</a> | <a class="modal_link" href="#"
                style="font-size: 14px;">비밀번호 찾기</a>
        </p>
        <p class="modal_note" style="text-align: center; font-size: 14px;">아직 계정이 없나요? <a class="modal_link" href="#"
                style="font-size: 14px;">회원가입</a></p>
    </div>
</div>

<!-- 아이디,비밀번호 찾기 -->
<div id="idFindModal" class="modal">
    <div class="modal_content in_fixed_btn on">
        <span class="modal_close_signup">&times;</span>
        <div class="login_logo">
            <img src="img/bdguide.png" alt="로고 이미지">
        </div>
        <!-- 탭 메뉴 시작 -->
        <div class="tab_list_wrap">
            <ul class="tabs ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
                role="tablist">
                <li class="tab_item ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active"
                    role="tab" tabindex="0" aria-controls="tabContentFindId" aria-labelledby="ui-id-3"
                    aria-selected="true" aria-expanded="true">
                    <a href="#tabContentFindId" class="tab_link ui-tabs-anchor" role="presentation" tabindex="-1"
                        id="ui-id-3">
                        <span class="tab_text">아이디 찾기</span>
                    </a>
                </li>
                <li class="tab_item ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab" tabindex="-1"
                    aria-controls="tabContentFindPw" aria-labelledby="ui-id-4" aria-selected="false"
                    aria-expanded="false">
                    <a href="#tabContentFindPw" class="tab_link ui-tabs-anchor" role="presentation" tabindex="-1"
                        id="ui-id-4">
                        <span class="tab_text">비밀번호 찾기</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- 탭 메뉴 끝 -->
        <!-- 아이디 찾기 탭 컨텐츠 시작 -->
        <script>
            //아이디 찾기 버튼 클릭시 
            $(document).ready(function () {
                $('#idFindBtn').on('click', function () {
                    var email = $('#findEmail').val();
                    if (email) {
                        $.ajax({
                            url: './user/findId.php',
                            type: 'post',
                            dataType: 'json',  // 응답을 JSON으로 파싱
                            data: { email: email },
                            success: function (response) {
                                if (response.status === 'success') {
                                    $('#findid').show();
                                    $('#idFindModal').hide();
                                    $('.findidname').text(response.user_id);
                                } else {
                                    alert('이메일에 해당하는 아이디가 없습니다.');
                                }
                            }
                        });
                    } else {
                        alert('이메일을 입력해주세요.');
                    }
                });
            });
        </script>
        <!-- 아이디 찾기 탭 -->
        <div id="tabContentFindId">
            <form id="idFindForm" method="post">
                <label for="findEmail">이메일</label>
                <input type="email" placeholder="가입한 이메일을 입력해주세요" id="findEmail" name="email" required><br>
                <span id="findEmailError" class="idFindError">이메일을 입력해주세요.</span>
                <button type="button" id="idFindBtn">아이디 찾기</button>
            </form>
        </div>
        <!-- 아이디 찾기 탭 컨텐츠 끝 -->
        
        <!-- 비밀번호 찾기 탭 컨텐츠 시작 -->
        <div id="tabContentFindPw">
            <form id="pwFindForm" action="./user/findpw.php" method="post">
                <label for="findId">아이디</label>
                <input type="text" placeholder="가입한 아이디를 입력해주세요" id="findId" name="id" required><br>
                <span id="findIdError" class="pwFindError">아이디를 입력해주세요.</span>
                <label for="findEmailPw">이메일</label>
                <input type="email" placeholder="가입한 이메일을 입력해주세요" id="findEmailPw" name="email" required><br>
                <span id="findEmailPwError" class="pwFindError">이메일을 입력해주세요.</span>
                <button type="submit" id="pwFindBtn">비밀번호 재설정 이메일 보내기</button>
            </form>
        </div>
        <!-- 비밀번호 찾기 탭 컨텐츠 끝 -->
        <p class="modal_note" style="text-align: center; font-size: 14px;">아직 계정이 없나요? <a class="modal_link" href="#"
                style="font-size: 14px;">회원가입</a></p>
    </div>
</div>

<!-- 아이디 찾기 결과 창 -->
<div id="findid" class="modal">
    <div class="modal_content in_fixed_btn on">
        <span class="modal_close_signup">&times;</span>
        <div class="login_logo">
            <img src="img/bdguide.png" alt="로고 이미지">
        </div>
        <!-- 탭 메뉴 시작 -->
        <div class="findid_label">
            <h1>아이디를 확인해 주세요.</h1>
        </div>
        <!-- 탭 메뉴 끝 -->
        <div class="findid_result_box">
            <i class="fa-solid fa-check"></i>
            <p class="findidname"></p>
        </div>
        <!-- 아이디 찾기 탭 컨텐츠 시작 -->
        <div id="tabFindId">
            <form id="FindidForm" method="post">
                <button type="button" id="FindidBack">돌아가기</button>
                <button type="button" id="FindidGo">로그인</button>
            </form>
        </div>
    </div>
</div>
<!-- <div id="findpasswordemail" class="modal">
    <div class="modal_content in_fixed_btn on">
        <span class="modal_close_signup">&times;</span>
        <div class="login_logo">
            <img src="img/bdguide.png" alt="로고 이미지">
        </div>
        <div class="findpassword_label">
            <h1>kasung1020 사용자님의 비밀번호 변경</h1>
        </div>
        </script>
        <form id="newfindpasswordForm" method="post">
            <label for="newfindpassword">새 비밀번호</label>
            <input type="password" id="newfindpassword" name="newpassword" required><br>
            <span id="passwordError" class="signUperror">8 ~ 16자의 영문 대/소문자, 숫자를 사용해주세요.</span>
            <label for="newfindpassword-confirm">새 비밀번호 확인</label>
            <input type="password" id="newfindpassword-confirm" name="newpassword-confirm" required><br>
            <span id="confirmError" class="signUperror">비밀번호가 일치하지 않습니다.</span>
            <button type="submit" id="pwFindBtn">비밀번호 변경</button>
        </form>
    </div>
</div> -->
<div id="userquit" class="modal">
    <div class="modal_content in_fixed_btn on">
        <span class="modal_close_signup">&times;</span>
        <div class="login_logo">
            <img src="img/bdguide.png" alt="로고 이미지">
        </div>
        <div class="tab_list_wrap2">
            <h1>회원탈퇴</h1>
        </div>
        <script>
            $(document).ready(function () {
                //확인 버튼을 눌렀을때 폼 제출 이벤트 처리
                $('#passwordCheckForm').on('submit', function (e) {
                    e.preventDefault(); // 폼 기본 제출 동작 방지

                    var formData = {
                        password: $('#findPassword').val() // input의 값을 가져와서 password 키에 할당
                    };
                    $.ajax({
                        url: './user/check-password.php',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        success: function (response) {
                            if (response.isCorrect) {
                                $('#userquit').hide();
                                $('#userquit5').show();
                            } else {
                                $('#findPasswordError').show();
                            }
                        }
                    });
                });

                $('.modal_close_signup').on('click', function () {
                    // 가장 가까운 모달 창 닫기
                    $(this).closest('.modal').hide();
                });
            });
        </script>
        <div id="tabContentFindId">
            <form id="passwordCheckForm" action="./user/check-password.php" method="post">
                <label for="findPassword" style="font-size: 12px;">개인정보 보호를 위해 비밀번호를 입력해주세요</label>
                <input type="password" id="findPassword" name="password" required><br>
                <span id="findPasswordError" class="passwordFindError">다시한번 더 입력해주세요.</span>
                <button type="submit" id="passwordCheckBtn">확인</button>
            </form>
        </div>
    </div>
</div>
<div id="userquit5" class="modal">
    <div class="modal_content in_fixed_btn on">
        <span class="modal_close_signup">&times;</span>
        <div class="login_logo">
            <img src="img/bdguide.png" alt="로고 이미지">
        </div>
        <div class="tab_list_wrap2">
            <h1>회원탈퇴</h1>
        </div>
        <script>
            $(document).ready(function () {
                // 확인 버튼 클릭 이벤트
                $('#FindpasswordGo').on('click', function () {
                    $.ajax({
                        url: './user/deactivate-account.php', // 회원 탈퇴를 처리할 PHP 파일 경로
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('회원 탈퇴가 완료되었습니다.');
                                window.location.href = './index.php'; // 혹은 로그인 페이지로 리디렉션
                            } else {
                                alert('오류가 발생했습니다. 다시 시도해주세요.');
                            }
                        },
                        error: function () {
                            alert('네트워크 오류가 발생했습니다. 다시 시도해주세요.');
                        }
                    });
                });

                // 취소 버튼 클릭 이벤트
                $('#FindpasswordBack').on('click', function () {
                    $('#userquit5').hide(); // 최종결정 모달창 닫기
                });
            });
        </script>
        <div id="tabContentFindId">
            <form id="passwordFindForm" method="post">
                <div class="confirmation-message">
                    <label for="findEmail" class="confirmation-label">정말 탈퇴하시겠습니까?</label>
                    <p style="font-size: 14px; color: #000; margin-bottom: 10px;">탈퇴 후에는 일정 기간 동안 같은 회원정보로는</p>
                    <p style="font-size: 14px; color: #000;">재가입이 불가능합니다</p>
                </div>
                <div class="button-group2">
                    <button type="button" id="FindpasswordGo">확인</button>
                    <button type="button" id="FindpasswordBack">취소</button>
                </div>
            </form>
        </div>
    </div>
</div>