function DeleteCheck() {
    if (confirm('本当に削除しますか？') == true) {
        return true;
    } else {
        return false;
    }
}

function registerCheck() {
    if (confirm('登録してもいいですか？') == true) {
        return true;
    } else {
        return false;
    }
}