<?php 

class Mo_API_Authentication_Usage{

	public static function mo_api_authentication_usage_page()
	{
		$mo_api_check;

		if(!get_option('miniorange_api_authentication_ctr'))
		{
			$mo_api_check=0;
		}
		else{
			$mo_api_check=base64_decode(get_option('miniorange_api_authentication_ctr'));
		}
	?>	
		<div id="mo_api_authentication_support_layout" class="mo_api_authentication_support_layout">
	
        <h1>Monthly Authentications Usage Summary</h1>
        <br>
        <strong><h2 style="color: #616975">* The Total Used Authentications Counter increments on each successful API authentication.</h2></strong>
        <strong><h2 style="color: #616975">* To enjoy unlimited authentications and other features <a href="admin.php?page=mo_api_authentication_settings&tab=licensing"_blank">click here</a>.</h2></strong>
        <div class="mo_usage_container"> 
            <div id="mo_st-box"> 
     			<img style="float:center;margin-left: 95px;margin-top: 40px;" src="<?php echo dirname( plugin_dir_url( __FILE__ ) );?>/images/authentication.png" width="40"height="40";>
     			<center>
     				<h3 style="font-family:Century Gothic;font-size: 20px;color: grey">Total Available</h3><h3 style="font-family:Century Gothic;font-size: 20px;color: grey;margin-top: 0px;">Authentications</h3>
     				<hr>
     				<h1 style="font-size: 45px;font-family:Century Gothic;color: #0A4988">100</h1>
     			</center>

            </div> 
              
            <div id="mo_nd-box"> 
                <img style="float:center;margin-left: 95px;margin-top: 40px;" src="<?php echo dirname( plugin_dir_url( __FILE__ ) );?>/images/login.png" width="40"height="40";>
     			<center>
     				<h3 style="font-family:Century Gothic;font-size: 20px;color: grey">Total Used</h3><h3 style="font-family:Century Gothic;font-size: 20px;color: grey">Authentications</h3>
     				<hr>
     				<h1 style="font-size: 45px;font-family:Century Gothic;color: #D3220D"><?php echo $mo_api_check; ?></h1>
     			</center>
            </div> 
              
            <div id="mo_rd-box"> 
                <img style="float:center;margin-left: 95px;margin-top: 40px;" src="<?php echo dirname( plugin_dir_url( __FILE__ ) );?>/images/forgot.png" width="40"height="40";>
     			<center>
     				<h3 style="font-family:Century Gothic;font-size: 20px;color: grey">Total Left</h3><h3 style="font-family:Century Gothic;font-size: 20px;color: grey">Authentications</h3>
     				<hr>
     				<h1 style="font-size: 45px;font-family:Century Gothic;color: #0A8849"><?php echo (100-$mo_api_check) ?></h1>
     			</center>
            </div> 
        </div> 
		</div>

	<?php }

} ?>
