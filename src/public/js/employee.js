function empdelete() {
    ret=confirm("本当に削除しますか？");
    if(ret==true){
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'POST',
              url: "employeesManagementDelete", // url: は読み込むURLを表す
              datatype: "json",
              data: {
                // valueをセット
                "delete" : $('#delete_id').val()
              }
            });
            alert($('#delete_id').val());
            location.href = 'http://localhost:8080/employeesManagement';
    }else{
        alert("2");
    }
}
function prtdelete() {
  ret=confirm("本当に削除しますか？");
  if(ret==true){
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "parttimerManagementDelete", // url: は読み込むURLを表す
            datatype: "json",
            data: {
              // valueをセット
              "delete" : $('#delete_id').val()
            }
          });
          alert($('#delete_id').val());
          location.href = 'http://localhost:8080/employeesManagement';
  }else{
      alert("2");
  }
}


