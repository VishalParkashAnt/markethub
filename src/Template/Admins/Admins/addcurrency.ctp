<?php
use Cake\Routing\Router;
?>


  <body class="">
  <!--<![endif]-->

<div class="content">
<?php
$baseurl = Router::url('/');
?>

			<div class="content">
 	<div class="row page-titles">
        <div class="col-md-12 col-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo __d('admin', 'Currency'); ?></h3>

 <div class="page page-titles p-b-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>dashboard"><?php echo __d('admin', 'Home'); ?></a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo $baseurl; ?>managecurrency"><?php echo __d('admin', 'Currency'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo __d('admin', 'Add Currency'); ?></li>
                                    </ol>
                                </div>


         </div>
    </div>


<?php
	echo "<div class='containerdiv'>";


		echo $this->Form->Create('Forexrate',array('url'=>array('controller'=>'Admins','action'=>'addcurrency'),'id'=>'Categoryform','onsubmit'=>'return check_currency();'));
		?>

		<div class="row">
         <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo __d('admin', 'Add Currency'); ?></h4>
                 </div>
                 <div class="card-block">
                    <div class="form-body">
                         <div class="form-group row">
                        <div class="col-md-6">
                        	<?php

			echo $this->Form->input('Currency Code',array('options' => array('' => __d('admin', 'Select Currency'),'AED'=>'AED','ALL' => 'ALL','AMD' => 'AMD','AOA'=>'AOA','ARS'=>'ARS','AUD' => 'AUD','AWG'=>'AWG','AZN'=>'AZN','BAM'=>'BAM','BBD'=>'BBD','BDT'=>'BDT','BGN'=>'BGN','BHD'=>'BHD','BIF'=>'BIF','BMD'=>'BMD','BND'=>'BND','BOB'=>'BOB','BRL' => 'BRL','BSD'=>'BSD','BWP'=>'BWP','BYN'=>'BYN','BZD'=>'BZD','CAD' => 'CAD','CHF'=>'CHF','CLP'=>'CLP','CNY'=>'CNY','COP'=>'COP','CRC'=>'CRC','CUP'=>'CUP','CVE'=>'CVE', 'CZK' => 'CZK','DJF'=>'DJF','DKK' => 'DKK','DOP'=>'DOP','DZD'=>'DZD','EGP'=>'EGP','ERN'=>'ERN','ETB'=>'ETB', 'EUR' => 'EUR','FJD'=>'FJD','FKP'=>'FKP','GBP'=>'GBP','GEL'=>'GEL','GHS'=>'GHS','GIP'=>'GIP','GMD'=>'GMD','GNF'=>'GNF','GTQ'=>'GTQ','GYD'=>'GYD','HKD' => 'HKD','HNL'=>'HNL','HRK'=>'HRK','HTG'=>'HTG', 'HUF' => 'HUF','IDR'=>'IDR', 'ILS' => 'ILS','INR'=>'INR','IRR'=>'IRR','ISK'=>'ISK','JMD'=>'JMD', 'JPY' => 'JPY','KES'=>'KES','KGS'=>'KGS','KHR'=>'KHR','KMF'=>'KMF','KRW'=>'KRW','KYD'=>'KYD','KZT'=>'KZT','LAK'=>'LAK','LBP'=>'LBP','LKR'=>'LKR','LRD'=>'LRD','LSL'=>'LSL','MAD'=>'MAD','MDL'=>'MDL','MKD'=>'MKD','MMK'=>'MMK','MNT'=>'MNT','MOP'=>'MOP','MUR'=>'MUR','MVR'=>'MVR','MWK'=>'MWK','MXN'=>'MXN', 'MYR' => 'MYR','NAD'=>'NAD','NGN'=>'NGN','NIO'=>'NIO','NOK' => 'NOK','NPR'=>'NPR', 'NZD' => 'NZD', 'PHP' => 'PHP', 'PLN' => 'PLN', 'GBP' => 'GBP', 'RUB' => 'RUB', 'SGD' => 'SGD', 'SEK' => 'SEK',  'TWD' => 'TWD', 'THB' => 'THB', 'TRY' => 'TRY', 'USD' => 'USD' ), 'id' => 'currency_code','name' => 'currency_code' ,'class'=> 'form-control','onchange' => 'addcurrencyCode();'));

			//echo $this->Form->input('Currency Name',array('options' => array('Australian Dollar' => 'Australian Dollar', 'Brazilian Real' => 'Brazilian Real', 'Canadian Dollar' => 'Canadian Dollar', 'Czech Koruna' => 'Czech Koruna', 'Danish Krone' => 'Danish Krone', 'Euro' => 'Euro', 'Hong Kong Dollar' => 'Hong Kong Dollar', 'Hungarian Forint' => 'Hungarian Forint', 'Israeli New Sheqel' => 'Israeli New Sheqel', 'Japanese Yen' => 'Japanese Yen', 'Malaysian Ringgit' => 'Malaysian Ringgit', 'Mexican Peso' => 'Mexican Peso', 'Norwegian Krone' => 'Norwegian Krone', 'New Zealand Dollar' => 'New Zealand Dollar', 'Philippine Peso' => 'Philippine Peso', 'Polish Zloty' => 'Polish Zloty', 'Pound Sterling' => 'Pound Sterling', 'Russian Ruble' => 'Russian Ruble', 'Singapore Dollar' => 'Singapore Dollar', 'Swedish Krona' => 'Swedish Krona', 'Swiss Franc' => 'Swiss Franc', 'Taiwan New Dollar' => 'Taiwan New Dollar', 'Thai Baht' => 'Thai Baht', 'Turkish Lira' => 'Turkish Lira', 'U.S. Dollar' => 'U.S. Dollar' ), 'value' => ''.$_SESSION['curr'].'', 'type' => 'hidden'));

			//echo $this->Form->input('Currency Name', array('value' => ''.$currency_name['USD'].''));
			//echo $this->Form->input('Currency Symbol', array('options' => array('$' => '$', 'R$' => 'R$', 'C$' => 'C$', 'KÄ�' => 'KÄ�', 'kr.' => 'kr.', 'â‚¬' => 'â‚¬', 'HK$' => 'HK$', 'Ft' => 'Ft', 'â‚ª' => 'â‚ª',  'Â£' => 'Â£', 'RM' => 'RM', 'Mex$' => 'Mex$', 'kr' => 'kr', 'â‚±' => 'â‚±', 'zÅ‚' => 'zÅ‚', 'Ñ€ÑƒÐ±' => 'Ñ€ÑƒÐ±', 'CHF' => 'CHF', 'NT$' => 'NT$', 'à¸¿' => 'à¸¿', 'ã‚‚' => 'ã‚‚', 'Â¥' => 'Â¥'  ), 'value' => ''.$_SESSION['cur'].'', 'type' => 'hidden'));

		echo '</div></div> <div class="form-group row">
                        <div class="col-md-6">';

			echo $this->Form->input('Rate',array('label'=>__d('admin', 'Rate (Equivalent '.$_SESSION['default_currency_code'].')'), 'type'=>'text','maxlength'=>'20','id'=>'currency_rate','class'=>'form-control'));
			echo '</div></div> <div class="form-group row">
                        <div class="col-md-6">';

			echo $this->Form->input('Status',array('options' => array('enable' => __d('admin', 'Enable'), 'disable' => __d('admin', 'Disable')),'class'=> 'form-control'));
			echo '</div></div>';
			?>
			<?php
			echo $this->Form->submit(__d('admin', 'Save'),array('div'=>false,'class'=>'btn btn-info reg_btn'));
			echo '<div id="currerr" style="font-size:13px;color:red;" class="trn"></div>';
			echo $this->Form->end();
	echo "</div>";
?>


</div>

</div>

</div>
</div>

</div>

</div>
</div>

</div>

</div>

<style>

.show_hid{
	display:none;
}
</style>
