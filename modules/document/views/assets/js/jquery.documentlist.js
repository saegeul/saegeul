$(document).ready(function (e) {

    $(".search_btn").click(function() {
        document.search_form.submit();
    });
    $("#save_btn").click(function() {

        DOC.paper.offEditor() ; 

        alert($('#document_body').html()); 

    });
    $(".modify_btn").click(function() {
        alert($(this).attr("value"));
        //    var $doc_id = $(this).attr('value');
        //    location.href="modify_document/?doc_id=" + $doc_id ;
    });


    $(".trash_btn").click(function() {
        var $doc_id = $(this).attr('value');
        $('#recycleModal').modal('show');
        $('#recycleModal').find('#recycle').click(function() {
            location.href="trash/?doc_id=" + $doc_id+"&is_trash=1" ;
            $('#recycleModal').modal('hide');
        });
    });


    $(".delete_btn").click(function() {
        var $doc_id = $(this).attr('value');
        $('#deleteModal').modal('show');
        $('#deleteModal').find('#recycle').click(function() {
            location.href="delete/?doc_id=" + $doc_id ;
            $('#deleteModal').modal('hide');
        });

    });
    $(".restore_btn").click(function() {
        var $doc_id = $(this).attr('value');
        $('#restoreModal').modal('show');
        $('#restoreModal').find('#recycle').click(function() {
            location.href="trash/?doc_id=" + $doc_id+"&is_trash=0" ;
            $('#restoreModal').modal('hide');
        });
    });
    
    $(".documentClick").click(function() {
    	var row = $(this).parent().parent().get(0);
    	var doc_id = $(row.cells[0]).html();
    	$.ajax({
			type : "GET",
			url : "/saegeul/admin/document/countHit",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "doc_id=" + doc_id,
			error : function() {
			},
			success : function(data) {
				location.href="/saegeul/blog/read/" + doc_id;
			}
		});
    });
});

