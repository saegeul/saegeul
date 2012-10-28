<div class="span9">
    <ul class="sg_document_list">
        <?php foreach($document_list as $key => $document):?> 
        <li> 
            <h6 class="title"><a><?php echo $document->title; ?> </a></h6>
            <div class="metainfo">
                <span>&nbsp;<?php echo $document->reg_date;?></span>

                &nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp;by <?php echo $document->username;?></span>
            </div>
            <p class="description"> 
                <a><?php echo $document->description; ?></a>
            </p>
        </li>
        <?php endforeach;?>
    </ul>

    <div>

    </div>
</div>
