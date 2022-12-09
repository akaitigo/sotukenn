function DeleteCheck() {
    ret=confirm('本当に削除しますか？');
    if(ret==true){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            type: 'POST',
            url: "/noticeManagementDelete", // url: は読み込むURLを表す
            datatype: "json",
            data: {
              // valueをセット
              "deleteid": $('#deleteid').val(),
            }
        });
        location.href = 'http://localhost:8080/noticeManagement';
    }else{
        console.log('キャンセル');
    }
}