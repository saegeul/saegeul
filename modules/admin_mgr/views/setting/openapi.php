<div class="_content">
<div class="well">
    <form action="" method="post" >
        <input type="text" name="provider"/>
        <input type="text" name="api_key" />
        <input type="text" name="secret_key" /> 
    </form>
</div>

<table class="table table-stripped">
    <thead>
        <th>#</th>
        <th>Provider</th>
        <th>API KEY</th>
        <th>SECRET KEY</th>
        <th>OAuth Token </th>
        <th>OAuth Secret Token </th>
        <th>인증 </th>
    </thead>
    <tbody>
        
        <?php foreach($api_key_list as $key => $_api_info):?>
        <tr> 
            <td><?php echo $_api_info->openapi_id; ?> </td>
            <td><?php echo $_api_info->provider; ?> </td>
            <td><?php echo $_api_info->api_key; ?> </td>
            <td><?php echo $_api_info->secret_key; ?> </td>
            <td><?php echo $_api_info->oauth_toekn; ?> </td>
            <td><?php echo $_api_info->oauth_secret_token; ?> </td>
            <td><a>인증</a></td>
        </tr> 
        <?php endforeach ;?>
    </tbody> 
</table>
</div>
