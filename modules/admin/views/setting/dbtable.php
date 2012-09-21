<div class="span9" style="margin-top:30px;"> 
    <table class="table table-condensed table-hover table-striped">
        <thead>
            <tr> 
                <th>테이블이름</th>
                <th>스키마위치</th>
                <th>설치여부</th>
                <th>재설치</th>
                <th>삭제</th>
            </tr> 
        </thead>
        <tbody>
        <?php foreach($schema_list as $key => $schema): ?>
        <tr <?php if(!$schema['is_exists']):?> class="error" <?php else:?>class="success"  <?php endif;?>   
            table_path="<?=$schema['path']?>" table_name="<?=$schema['table']?>"
        > 
            <td><?=$schema['table']?></td>
            <td><?=$schema['path']?> </td>
            <td> <?php if(!$schema['is_exists']):?> X <?php endif;?></td>
            <td><a class="btn btn-warning btn-small refresh_table_btn">재설치</a> </td>
            <td><a class="btn btn-danger btn-small delete_table_btn">삭제 </a>  </td>
        </tr>
        <?php endforeach ;?> 
        </tbody>
    </table>
</div>

<script>
$(function(){
    $('.refresh_table_btn').click(function(){
        if(confirm('선택된 테이블의 데이타는 모두 삭제되고, 다시 설치 됩니다.')){
            var $tr = $(this).parents('tr') ;
            var table_name = $tr.attr('table_name') ;
            var table_path = $tr.attr('table_path') ;
            $.ajax({
                url : 'refreshTable',
                type : 'post',
                data : {
                    table_name : table_name, 
                    table_path : table_path
                },
                success: function(){ 
                    location.href = location.href ; 
                }
            }); 

        }
    }); 

    $('.delete_table_btn').click(function(){
        if(confirm('선택된 테이블의 데이타는 모두 삭제됩니다.')){
            var $tr = $(this).parents('tr') ;
            var table_name = $tr.attr('table_name') ;
            var table_path = $tr.attr('table_path') ; 

            $.ajax({
                url : 'deleteTable',
                type : 'post',
                data : {
                    table_name : table_name, 
                    table_path : table_path
                },
                success: function(){ 
                    location.href = location.href ; 
                }
            });
        }
    }); 
}) ; 
</script>
