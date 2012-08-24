<?php
$this->load->helper('url'); 
?>
<script src="<?=base_url()?>modules/document/views/js/tiny_mce/tiny_mce.js"> </script>
<script>
    tinyMCE.init({
        mode:'textareas',
        theme:'simple'
    }); 
</script>

<div>
    <textarea id="sample" name="sample" style="width:100%;" rows="15" cols="15"> </textarea>
</div>

</body>
</html>
