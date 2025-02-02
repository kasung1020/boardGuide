// 메뉴판 열기
$(".menu>li").mouseover(function () {
    $(this).children(".submenu").stop().slideDown();
})

// 메뉴판 닫기
$(".menu>li").mouseleave(function () {
    $(this).children(".submenu").stop().slideUp();
})

// 메인 홈페이지 이미지슬라이드 넘어가는 함수
$(document).ready(function () {
    var num = 1;
    var images = $(".slide>img");

    function slide() {
        images.eq(num).css('opacity', 0);
        num = (num + 1) % images.length;
        images.eq(num).css('opacity', 1);
    }

    setInterval(slide, 3000); // 3초마다 이미지 전환
});

// 카드광고
$(document).ready(function () {
    // 카드 광고 사라지게 하기 & 카드 광고 X 표시가 5초 후에 생김
    $('.close-all').click(function () {
        $(this).closest('#ads').hide();
    });

    setTimeout(function () {
        $(".close-all").css("opacity", "1");
    }, 5000);

    // 광고 카드 자동 변경 기능
    let displayedAds = [];
    const totalAds = $('.flip').length;
    let autoChangeInterval;

    function shuffleAds() {
        let array = Array.from({ length: totalAds }, (_, i) => i);
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    function initializeAds() {
        let shuffledIndices = shuffleAds();
        $('.flip').hide();
        for (let i = 0; i < 5; i++) {
            $('.flip').eq(shuffledIndices[i]).show();
            displayedAds.push(shuffledIndices[i]);
        }
    }

    function changeAllAds() {
        let shuffledIndices = shuffleAds();
        for (let i = 0; i < displayedAds.length; i++) {
            $('.flip').eq(displayedAds[i]).hide();
        }
        displayedAds = [];
        for (let i = 0; i < 5; i++) {
            $('.flip').eq(shuffledIndices[i]).show();
            displayedAds.push(shuffledIndices[i]);
        }
    }

    function startAutoChange() {
        autoChangeInterval = setInterval(changeAllAds, 5000);
    }

    function stopAutoChange() {
        clearInterval(autoChangeInterval);
    }

    $(".flip").hover(function () {
        var element = $(this);
        element.find('.ads_card').css('transform', 'rotateY(180deg)');
        stopAutoChange();
    }, function () {
        var element = $(this);
        setTimeout(function () {
            element.find('.ads_card').css('transform', '');
        }, 3000);
        startAutoChange();
    });

    initializeAds();
    startAutoChange();
});

// 사이트맵 메뉴바 + - 눌렀을때 아래로 내려가게 함
$(document).ready(function () {
    $("#sitemap_body .deps1 > li:not(.no-toggle) > a").click(function (e) {
        e.preventDefault(); // 기본 링크 동작을 방지합니다.
        var li = $(this).parent();
        li.toggleClass('on');
        $(this).siblings('.deps2').slideToggle();

        // 클래스를 토글하여 + 와 - 를 바꿉니다.
        if (li.hasClass('on')) {
            $(this).css('content', '-');
        } else {
            $(this).css('content', '+');
        }
    });
});

$(document).ready(function () {
    // 아이디찾기 모달에서 회원가입 링크를 클릭했을 때의 이벤트 핸들러
    $('#idFindModal .modal_link').click(function (e) {
        e.preventDefault();
        $('#idFindModal').hide(); // 아이디찾기 모달을 닫습니다.
        $('#signUpModal').show(); // 회원가입 모달을 엽니다.
    });

    // 모달에서 X 버튼을 클릭시 
    $(".modal_close_signup").click(function () {
        $(this).closest('.modal').hide();

        // 에러 메시지 초기화
        $('#usernameError, #passwordError, #confirmError,#emailError,#nicknameError').text('').hide();

        // 입력 필드 초기화 그리고 val() 함수를 사용하여 입력 필드의 값을 빈 문자열로 설정함
        $('#signUpForm input[type="text"], #signUpForm input[type="password"], #signUpForm input[type="email"]').val('');

        // 에러 메시지 초기화
        $('#loginUsernameError, #loginPasswordError').text('').hide();
    
        // 입력 필드 초기화 그리고 val() 함수를 사용하여 입력 필드의 값을 빈 문자열로 설정함
        $('#loginForm input[type="text"], #loginForm input[type="password"]').val('');

        // 체크박스 초기화
        $('#signUpForm input[type="checkbox"], #loginForm input[type="checkbox"]').prop('checked', false);

        // 회원탈퇴 필드 초기화
        $('#passwordCheckForm input[type="password"]').val('');

        // 회원탈퇴 에러 메시지 초기화
        $('findPasswordError').text('').hide();
    });

    // 모달에서 X 버튼을 클릭시 
    $(".modal_close_login").click(function () {

        // 에러 메시지 초기화
        $('#usernameError, #passwordError, #confirmError').text('').hide();

        // 입력 필드 초기화 그리고 val() 함수를 사용하여 입력 필드의 값을 빈 문자열로 설정함
        $('#signUpForm input[type="text"], #signUpForm input[type="password"], #signUpForm input[type="email"]').val('');
    
        // 에러 메시지 초기화
        $('#loginUsernameError, #loginPasswordError').text('').hide();
    
        // 입력 필드 초기화 그리고 val() 함수를 사용하여 입력 필드의 값을 빈 문자열로 설정함
        $('#loginForm input[type="text"], #loginForm input[type="password"]').val('');

        $('#signUpForm input[type="checkbox"], #loginForm input[type="checkbox"]').prop('checked', false);
    });

    // 회원가입 모달에서 '로그인' 링크 클릭
    $('#signUpModal .modal_link[href="#"]').click(function (e) {
        e.preventDefault();
        $("#signUpModal").hide();
        $("#loginModal").show();
    });

    // 로그인 모달에서 '아이디 찾기' 링크 클릭 이벤트
    $('.find_credentials .modal_link').eq(0).click(function (e) {
        e.preventDefault();
        $('#loginModal').hide();
        $('#idFindModal').show();
        $('#idFindForm input').val('');
    });

    // 로그인 모달에서 '비밀번호 찾기' 링크 클릭 이벤트
    $('.find_credentials .modal_link').eq(1).click(function (e) {
        e.preventDefault();
        $('#loginModal').hide();
        $('#idFindModal').show(); // 이 부분은 비밀번호 찾기 모달의 ID를 적어주세요.
        $('#idFindForm input').val('');
    });

    // 로그인 모달에서 '회원가입' 링크 클릭 이벤트
    $('#loginModal .modal_link:contains("회원가입")').click(function (e) {
        e.preventDefault();
        $('#loginModal').hide(); // 로그인 모달을 닫습니다.
        $('#signUpModal').show(); // 회원가입 모달을 엽니다.
    });

    // 선택사항 모달 관련 이벤트
    $('.modal_close_signup').click(function () {
        $('#preferenceModal').hide();
    });
    $('#laterSignUpBtn').click(function () {
        $('#preferenceModal').hide();
    });
    $(".button-group button").click(function () {
        $(this).toggleClass("active");
    });

    // 메뉴바 관련 이벤트
    $(".btn-menu").click(function () {
        $("#menuModal").show();
    });

    $(".sitemap_modal_close, .modal_close_login, .modal_close_signup").click(function () {
        $(this).closest('.modal').hide();
    });

    $("#openSignupModal").click(function () {
        $("#signUpModal").show();
    });

    $(".login-btn").click(function () {
        $("#loginModal").show();
    });

    $('.login_modal_bottom').click(function () {
        $('#menuModal').hide();
        $('#loginModal').show();
    });

    $('.sign_up_modal_bottom').click(function () {
        $('#menuModal').hide();
        $('#signUpModal').show();
    });

    $('.userquit_modal_bottom').click(function () {
        $('#menuModal').hide();
        $('#userquit').show();
    });

    //아이디 찾기 모달 버튼 연결

    // '돌아가기' 버튼 클릭 이벤트
    $('#FindidBack').click(function () {
        $('#findid').hide();
        $('#idFindModal').show();
        $('#idFindForm input').val('');
    });

    // '로그인' 버튼 클릭 이벤트
    $('#FindidGo').click(function () {
        $('#findid').hide();
        $('#loginModal').show();
    });
});

// 회원가입 유효성 확인
document.getElementById('nextBtn').addEventListener('click', async function () {
    const username = document.getElementById('username').value;
    const nickname = document.getElementById('nickname').value;
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password-confirm').value;
    const email = document.getElementById('email').value;

    let isValid = true;

    // 아이디 확인
    if (username.length < 4 || username.length > 20) {
        document.getElementById('usernameError').textContent = '4 ~ 20 자 이내만 사용해야합니다.';
        document.getElementById('usernameError').style.display = 'block';
        isValid = false;
    } else {
        // 서버에 요청하여 username의 중복 상태를 확인
        const response = await fetch(`./user/check-username.php?username=${username}`);
        // const response = await fetch(`/api/check-username?username=${username}`);
        const data = await response.json();
        if (data.isDuplicate) {
            document.getElementById('usernameError').textContent = '이미 사용 중인 아이디입니다.';
            document.getElementById('usernameError').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('usernameError').style.display = 'none';
        }
    }

    // 닉네임 널 값 확인
    if (!nickname) {
        document.getElementById('nicknameError').textContent = '닉네임을 입력해주세요.';
        document.getElementById('nicknameError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('nicknameError').style.display = 'none';
    }

    // Password validation (특수문자 필수 X 하게 만들었음)
    const passwordRegex = /^(?=.*[a-z])(?=.*\d)[A-Za-z\d@$!%*?&#]{8,16}$/;

    if (!passwordRegex.test(password)) {
        document.getElementById('passwordError').textContent = '8 ~ 16자의 영문 대/소문자, 숫자를 사용해야합니다.';
        document.getElementById('passwordError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('passwordError').style.display = 'none';
    }

    // Password confirm validation
    if (password !== passwordConfirm) {
        document.getElementById('confirmError').textContent = '비밀번호가 일치하지 않습니다.';
        document.getElementById('confirmError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('confirmError').style.display = 'none';
    }

    // 이메일 널 값 확인
    if (!email) {
        document.getElementById('emailError').textContent = '이메일을 입력해주세요.';
        document.getElementById('emailError').style.display = 'block';
        isValid = false;
    } else {
        const emailResponse = await fetch(`./user/check-username.php?useremail=${email}`);
        const emailData = await emailResponse.json();
        if (emailData.isDuplicate) {
            document.getElementById('emailError').textContent = '이미 사용 중인 이메일입니다.';
            document.getElementById('emailError').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('emailError').style.display = 'none';
        }
    }

    // 유효성 검사 통과 시
    if (isValid) {
        document.getElementById('signUpModal').style.display = 'none';
        document.getElementById('preferenceModal').style.display = 'block';
    }
});

// 로그인 유효성 확인
document.getElementById('loginBtn').addEventListener('click', function () {
    const username = document.getElementById('loginUsername').value;
    const password = document.getElementById('loginPassword').value;

    let isValid = true;

    // Username validation
    if (username.length === 0) {
        document.getElementById('loginUsernameError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('loginUsernameError').style.display = 'none';
    }

    // Password validation
    if (password.length === 0) {
        document.getElementById('loginPasswordError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('loginPasswordError').style.display = 'none';
    }

    if (isValid) {
        document.getElementById('loginForm').submit();
    }
});

// 검색창에 글자 적을시 placeholder 와 돋보기 아이콘이 사라지게 하는 함수
$(document).ready(function () {
    // 검색창에 입력값이 있을 경우 숨김 처리
    $('.search_box input').on('input', function () {
        const inputValue = $(this).val();
        if (inputValue && inputValue.trim() !== "") {
            // 입력값이 있을 경우 아이콘과 placeholder를 숨김
            $(this).siblings('.search_btn').find('.fas.fa-search').hide();
            $(this).attr('placeholder', '');
            $(this).addClass('text-input');
        } else {
            // 입력값이 없을 경우 아이콘과 placeholder를 다시 표시
            $(this).siblings('.search_btn').find('.fas.fa-search').show();
            $(this).attr('placeholder', '검색...');
            $(this).removeClass('text-input');
        }
    });
});

// 아이디 찾기 , 비밀번호 찾기 선택할수 있게 해줌
$(document).ready(function () {
    // 탭 메뉴의 각 아이템을 클릭했을 때의 동작을 정의합니다.
    $(".tab_item").click(function () {
        // 모든 탭 컨텐츠를 숨깁니다.
        $("#tabContentFindId, #tabContentFindPw").hide();

        // 모든 탭 아이템의 활성화 상태를 제거합니다.
        $(".tab_item").removeClass("ui-tabs-active");

        // 클릭된 탭 아이템만 활성화 상태로 만듭니다.
        $(this).addClass("ui-tabs-active");

        // 클릭된 탭 아이템에 연결된 탭 컨텐츠만 표시합니다.
        $($(this).find("a").attr("href")).show();

        // 링크의 기본 동작을 방지하여 페이지가 새로고침되는 것을 막습니다.
        return false;
    });
});