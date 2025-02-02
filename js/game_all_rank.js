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

    // 필터 검색 창 열기 닫기
    $('.filter_name').click(function () {
        // 'data-group' 속성이 존재하는 경우
        if ($(this).data('group')) {
            const group = $(this).data('group');
            $(`.filter[data-group="${group}"]`).slideToggle();
        } else {
            // 'data-group' 속성이 없는 경우
            $(this).next('.filter').slideToggle();
        }
        // 화살표 아이콘을 위/아래로 토글합니다.
        const icon = $(this).find('i.fas');
        if (icon.hasClass('fa-angle-down')) {
            icon.removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            icon.removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });

    // 인원수 박스 설정
    document.getElementById("personCount").addEventListener("change", function () {
        const value = this.value;
        if (value >= 1 && value <= 6) {
        } else {
            alert("1~6 사이의 값을 입력해주세요.");
            this.value = "";
        }
    });

    // 난이도 클릭 시 radio 값 변경

    const $searchButton = $('.apply');

    const $filter = $(".filter_panel_card");
    const $players = $(".filter_panel_card input#personCount");
    const $keyword = $(".filter_panel_card input#gameTitle");

    function isThemeSelected() {
        return $('.filter_panel_card input[type="checkbox"]:checked').length > 0;
    }

    // 폼 입력값에 따라 검색 버튼의 상태를 갱신하는 함수
    function updateSearchButtonState() {
        var isActive = false;
        if ($players.val() != "" || $keyword.val() != "" || isThemeSelected()) {
            isActive = true;
        } else {
            isActive = false;
        }

        const $difficulty_button = $('.filter_panel_card input:radio[name="difficulty"]:checked');
        $.each($difficulty_button, function (index, value) {
            isActive = true;
        });

        if (isActive) {
            $searchButton.addClass('active').removeClass('no_click');
        } else {
            $searchButton.removeClass('active').addClass('no_click');
        }
    }

    // 필터의 값이 바뀔 때마다 검색 버튼의 상태를 갱신
    $filter.on('input', updateSearchButtonState);

    // 체크박스의 상태 변경에 따라 검색 버튼 상태 업데이트
    $('.filter_panel_card input[type="checkbox"]').on('change', updateSearchButtonState);

    // 검색 박스 아무것도 등록 안했을때 못 누르게 하는 함수
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.no_click').forEach(function (element) {
            element.addEventListener('click', function (event) {
                event.preventDefault();
            });
        });
    });

    // 체크박스에서 선택된 테마를 배열로 출력 'apply' 버튼 클릭 이벤트
    $('.apply').on('click', function () {
        let selectedThemes = [];
        // 선택된 체크박스의 값을 배열에 추가
        $('input[type="checkbox"][name="theme"]:checked').each(function () {
            selectedThemes.push($(this).val());
        });
        // 선택된 테마 배열 출력
        console.log(selectedThemes);
    });
});
