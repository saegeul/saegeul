<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1&appId=161679290564837";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="span9">
    <div>
        <h1><?=$document->title;?> </h1>

        <div>
            <?=$document->content;?> 
        </div>
    </div>

    <div>
        <div class="fb-comments" data-href="http://example.com" data-num-posts="3" data-width="600"></div>
    </div>
</div>
<div class="span3">

</div>
