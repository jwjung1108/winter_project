function validateForm() {
    // 체크박스들을 선택
    var checkboxes = document.querySelectorAll('input[type="checkbox"][name="category[]"]');
    var isChecked = false;

    // 하나라도 체크되었는지 확인
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            isChecked = true;
        }
    });

    // 체크가 되지 않았을 때 경고창 출력 후 검색 취소
    if (!isChecked) {
        alert("하나 이상의 카테고리를 선택해주세요.");
        return false;
    }

    // 체크가 되었을 때 폼 제출
    return true;
}