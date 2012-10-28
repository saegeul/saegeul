<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1&appId=<?=$facebook_info->appId?>";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="">
    <div>
        <h1 style="text-align:center;"><?=$document->title;?> </h1>

        <div>
            <?=$document->content;?> 
        </div>
    </div>

    <div style="text-align:center;">
        <div>
            <div class="fb-comments" data-href="<?=base_url()?>blog/read/<?=$document->doc_id?>" data-num-posts="<?=$facebook_info->comment_count?>" data-width="700"></div>
        </div>
    </div>
</div> 
