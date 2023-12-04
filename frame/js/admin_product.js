function validateForm() {
    var checkboxes = document.getElementsByName('genre[]');
    var checked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            break;
        }
    }

    if (!checked) {
        alert('ジャンルを選択してください。');
        return false;
    }

    return true;
}