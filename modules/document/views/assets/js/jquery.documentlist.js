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
            $('<div>휴지통으로 이동하시겠습니까?</div>').dialog({
                resizable: false,
                height:150,
                modal: true,
                buttons: {
                    "recycle bin": function() {
                        location.href="trash/?doc_id=" + $doc_id+"&is_trash=1" ;
                        $( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });

	});
	$(".delete_btn").click(function() {
	    var $doc_id = $(this).attr('value');
            $('<div>삭제하시겠습니까?</div>').dialog({
                resizable: false,
                height:150,
                modal: true,
                buttons: {
                    "delete": function() {
                        location.href="delete/?doc_id=" + $doc_id ;
                        $( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });

	});
	$(".restore_btn").click(function() {
	    var $doc_id = $(this).attr('value');
            $('<div>복구하시겠습니까?</div>').dialog({
                resizable: false,
                height:150,
                modal: true,
                buttons: {
                    "restore": function() {
                        location.href="trash/?doc_id=" + $doc_id+"&is_trash=0" ;
                        $( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });

	});

});

