
function successMessage() {
    Swal.fire({
        title: " Saved", text: "Save",
        type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1
    });
    $("#addModal").modal('hide');
}

    function errorMessage(data){

    Swal.fire({title:" error",text:data.message,
        type:"error",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
    console.log('error', data);

}

    function warningMessage(data) {
    Swal.fire({
        title: " ", text: data.message,
        type: "warning", confirmButtonClass: "btn btn-primary", buttonsStyling: !1
    });
}

    function deleteMessage(data) {

    Swal.fire({
        title:"Deleted",text:data.message,
        type:"error",confirmButtonClass:"btn btn-primary",buttonsStyling:!1
    });
    }

    function resetButton() {
        // $("#addBtn").html('save');
        $("#addBtn").attr('disabled',false);
    }



//files
    function showFile(the_div, asset_url,data){
        the_div.html('');
        var file_path = data.path;
        var basic_list_group = "";

        basic_list_group += "  <div class=\"card draggable\">\n" +
            "                         <div class=\"card-header\">\n" +
            "                                <h4 class=\"card-title\">\n" +

            // "                                    <input type=\"hidden\" name=\"offer_image\" value='" + requisition_file + "'>\n" +

            "                                              <p class=\"m-0\">\n" +
            "                                                      <img  id='" + file_path + "' src='" + asset_url + "/" + file_path + "' width=\"120\" height=\"120\">\n" +
            "                                              </p>\n" +
            "\n" +
            "                                </h4>\n" +
            "                          </div>\n" +
            "                    <div class=\"card-content\">\n" +
            "                                               <div class=\"card-body\">\n" +
            "<button data-img='" + file_path + "' data-id='" + data.id + "' class='btn btn-danger deleteImg' >  <i class='fa fa-trash'></i> </button>" +
            "\n" +
            "                                                </div>\n" +
            "                     </div>\n" +
            "                  </div>";

        the_div.html(basic_list_group);
    }

    //
    function storeFile(url) {
        $.ajax({

            data: $('#addFilesForm').serialize(),

            url: url,

            type: "POST",

            dataType: 'json',
            timeout: 4000,
            success: function (data) {
                if (data.status == 200) {
                    $("#addFilesBtn").html('save');
                    $("#addFilesBtn").attr('disabled',false);
                    $('#addFilesForm').trigger("reset");

                    successMessage();

                } else {
                    warningMessage(data);
                    // $("#addFilesBtn").html('save');
                    $("#addFilesBtn").attr('disabled',false);
                }
            },
            error: function (data) {
                // $("#addFilesBtn").html('save');
                $("#addFilesBtn").attr('disabled',false);
                errorMessage(data);

                $("#filesForm").modal('hide');
            }
        });
    }


        function addNewRow(url,table) {

            $.ajax({

                data: $('#addForm').serialize(),

                url: url,

                type: "POST",

                dataType: 'json',
                timeout:4000,
                success: function (data) {
                    if(data.status==200) {
                        resetButton();

                        $('#addForm').trigger("reset");

                        successMessage();
                        table.draw(false);

                    } else{
                        warningMessage(data);
                        resetButton();

                    }
                },

                error: function (data) {

                    errorMessage(data);
                    resetButton();
                    $("#addModal").modal('hide');

                }

            });
        }

        function deleteRow(url,table,token) {

            var co = confirm("are you ready to delete it!");
            if (!co) {
                return;
            }

            $.ajax({

                type: "DELETE",

                url: url  ,

                data:{
                    '_token': token
                },

                success: function (data) {
                    deleteMessage(data);
                    table.draw(false);

                },

                error: function (data) {
                    errorMessage(data);
                }

            });
        }






