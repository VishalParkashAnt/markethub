<?php 
$menu_list = json_decode($admin_menus_list,true);
//echo '<button id="btn_closes" onclick="menu_list()" class="btn btn-danger inv-close" style="width: 90px; margin: 14px 6px 0px; font-size: 11px;float:right;">Back</button>';
	echo '<div style="width:49% !important;float:left;">';
	if(in_array('Home',$menu_list) && in_array('User Management',$menu_list) && in_array('Add User',$menu_list) && in_array('Manage User',$menu_list) && in_array('Manage Moderator',$menu_list) && in_array('Payment',$menu_list) && in_array('Braintree Setting',$menu_list) && in_array('Orders',$menu_list) && in_array('Commission Setup',$menu_list) && in_array('Invoices',$menu_list) && in_array('Tax Rates',$menu_list)  && in_array('Gift Card',$menu_list) && in_array('Add Gift Card',$menu_list) && in_array('Logs',$menu_list)  && in_array('Group Gift',$menu_list) && in_array('Manage Group gifts',$menu_list) && in_array('Store Preferences',$menu_list) && in_array('Manage Categories',$menu_list) && in_array('Manage Nonapproved Items',$menu_list) && in_array('Manage Approved Items',$menu_list) && in_array('Manage Prices',$menu_list) && in_array('Manage Colors',$menu_list) && in_array('Manage Currency',$menu_list) && in_array('Manage Sellers',$menu_list) && in_array('Disputes',$menu_list) && in_array('User Options',$menu_list)  && in_array('Manage Dispute',$menu_list)  && in_array('Messages',$menu_list)&& in_array('Manage Seller Chat',$menu_list) && in_array('Manage Subject',$menu_list) && in_array('Site Management',$menu_list) && in_array('Media Management',$menu_list) && in_array('Email Management',$menu_list) && in_array('Manage Languages',$menu_list) && in_array('Manage Landing Page',$menu_list) && in_array('Mobile Apps Settings',$menu_list) && in_array('Social Settings',$menu_list) && in_array('Social Page Settings',$menu_list) && in_array('News Letter',$menu_list) && in_array('Send Newsletter',$menu_list) && in_array('Get Contacts List',$menu_list) && in_array('Manage Newsletter',$menu_list) && in_array('General Settings',$menu_list) && in_array('Manage Modules',$menu_list) && in_array('Google Analytics',$menu_list) && in_array('Banner Settings',$menu_list) && in_array('Banners',$menu_list) && in_array('Error Page',$menu_list) && in_array('404 page',$menu_list) && in_array('Footer Pages',$menu_list) && in_array('About',$menu_list) && in_array('Documentaation',$menu_list) && in_array('Press',$menu_list) && in_array('Pricing',$menu_list) && in_array('Talk',$menu_list) && in_array('Faq',$menu_list) && in_array('Contact',$menu_list) && in_array('Terms of Sale',$menu_list) && in_array('Terms of Service',$menu_list) && in_array('Privacy Policy',$menu_list) && in_array('Terms and Conditions',$menu_list) && in_array('Copyright Policy',$menu_list))
        echo '<input type="checkbox" checked="checked" value="all" onclick="select_all_mod()" id="sel_all">Select All';
    else

    	echo '<input type="checkbox" value="all" onclick="select_all_mod()" id="sel_all">'.__d('admin','Select All');
		echo '<h3>'.__d('admin','Dashboard').'</h3>';
		if(in_array('Home',$menu_list) || $menu_list=="Home")
		echo '<input type="checkbox" class="home" onclick="all_mod(this)" checked="checked" value="Home" name="chkbox">'.__d('admin','Home');
		else
		echo '<input type="checkbox" class="home" onclick="all_mod(this)" value="Home" name="chkbox">'.__d('admin','Home');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="user">'.__d('admin','User Management').'</h3>';
		if(in_array('Add User',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Add User" class="userchk" name="chkbox">'.__d('admin','Add User');
		else
		echo '<input type="checkbox" value="Add User" name="chkbox" class="userchk">'.__d('admin','Add User');
		echo '<br />';
		if(in_array('Manage User',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage User" name="chkbox" class="userchk">'.__d('admin','Manage User');
		else
		echo '<input type="checkbox" value="Manage User" name="chkbox" class="userchk">'.__d('admin','Manage User');
		echo '<br />';
		if(in_array('Manage Moderator',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Moderator" name="chkbox" class="userchk">'.__d('admin','Manage Moderator');
		else
		echo '<input type="checkbox" value="Manage Moderator" name="chkbox" class="userchk">'.__d('admin','Manage Moderator');
		echo '<br />';

		if(in_array('Manage Sellers',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Sellers" name="chkbox" class="userchk">'.__d('admin','Manage Sellers');
		else
		echo '<input type="checkbox" value="Manage Sellers" name="chkbox" class="userchk">'.__d('admin','Manage Sellers');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="pay">'.__d('admin','Payment').'</h3>';
		if(in_array('Braintree Setting',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Braintree Setting" name="chkbox" class="paychk">'.__d('admin','Braintree Setting');
		else
		echo '<input type="checkbox" value="Braintree Setting" name="chkbox" class="paychk">'.__d('admin','Braintree Setting');
		echo '<br />';
		if(in_array('Orders',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Orders" name="chkbox" class="paychk">'.__d('admin','Orders');
		else
		echo '<input type="checkbox" value="Orders" name="chkbox" class="paychk">'.__d('admin','Orders');
		echo '<br />';
		if(in_array('Commission Setup',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Commission Setup" name="chkbox" class="paychk">'.__d('admin','Commission Setup');
		else
		echo '<input type="checkbox" value="Commission Setup" name="chkbox" class="paychk">'.__d('admin','Commission Setup');
		echo '<br />';
		if(in_array('Invoices',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Invoices" name="chkbox" class="paychk">'.__d('admin','Invoices');
		else
		echo '<input type="checkbox" value="Invoices" name="chkbox" class="paychk">'.__d('admin','Invoices');
		echo '<br />';
		if(in_array('Tax Rates',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Tax Rates" name="chkbox" class="paychk">'.__d('admin','Tax Rates');
		else
		echo '<input type="checkbox" value="Tax Rates" name="chkbox" class="paychk">'.__d('admin','Tax Rates');
		echo '<br />';
		/*echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="coupon">'.__d('admin','Coupons').'</h3>';
		if(in_array('Add Coupon',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Add Coupon" name="chkbox" class="couponchk">'.__d('admin','Add Coupon');
		else
		echo '<input type="checkbox" value="Add Coupon" name="chkbox" class="couponchk">'.__d('admin','Add Coupon');
		echo '<br />';
		if(in_array('Manage Coupon',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Coupon" name="chkbox" class="couponchk">'.__d('admin','Manage Coupon');
		else
		echo '<input type="checkbox" value="Manage Coupon" name="chkbox" class="couponchk">'.__d('admin','Manage Coupon');
		echo '<br />';
		if(in_array('Logs Coupon',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Logs Coupon" name="chkbox" class="couponchk">'.__d('admin','Logs Coupon');
		else
		echo '<input type="checkbox" value="Logs Coupon" name="chkbox" class="couponchk">'.__d('admin','Logs Coupon');
		echo '<br />';*/
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="gift">'.__d('admin','Gift Card').'</h3>';
		if(in_array('Add Gift Card',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Add Gift Card" name="chkbox" class="giftchk">'.__d('admin','Add Gift Card');
		else
		echo '<input type="checkbox" value="Add Gift Card" name="chkbox" class="giftchk">'.__d('admin','Add Gift Card');
		echo '<br />';
		if(in_array('Logs',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Logs" name="chkbox" class="giftchk">'.__d('admin','Logs');
		else
		echo '<input type="checkbox" value="Logs" name="chkbox" class="giftchk">'.__d('admin','Logs');
		echo '<br />';
			echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="groupgift">'.__d('admin','Group Gifts').'</h3>';
		if(in_array('Manage Group gifts',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Group gifts" name="chkbox" class="groupgiftchk">'.__d('admin','Manage Group gifts');
		else
		echo '<input type="checkbox" value="Manage Group gifts" name="chkbox" class="groupgiftchk">'.__d('admin','Manage Group gifts');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="store">'.__d('admin','Store Preferences').'</h3>';
		if(in_array('Manage Categories',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Categories" name="chkbox" class="storechk">'.__d('admin','Manage Categories');
		else
		echo '<input type="checkbox" value="Manage Categories" name="chkbox" class="storechk">'.__d('admin','Manage Categories');
		echo '<br />';
		if(in_array('Manage Nonapproved Items',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Nonapproved Items" name="chkbox" class="storechk">'.__d('admin','Manage Nonapproved Items');
		else
		echo '<input type="checkbox" value="Manage Nonapproved Items" name="chkbox" class="storechk">'.__d('admin','Manage Nonapproved Items');
		echo '<br />';
		if(in_array('Manage Approved Items',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Approved Items" name="chkbox" class="storechk">Manage Approved Items';
		else
		echo '<input type="checkbox" value="Manage Approved Items" name="chkbox" class="storechk">Manage Approved Items';
		echo '<br />';
		if(in_array('Manage Reported Items',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Reported Items" name="chkbox" class="storechk">'.__d('admin','Manage Reported Items');
		else
		echo '<input type="checkbox" value="Manage Reported Items" name="chkbox" class="storechk">'.__d('admin','Manage Reported Items');
		echo '<br />';
		if(in_array('Manage Prices',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Prices" name="chkbox" class="storechk">'.__d('admin','Manage Prices');
		else
		echo '<input type="checkbox" value="Manage Prices" name="chkbox" class="storechk">'.__d('admin','Manage Prices');
		echo '<br />';
		if(in_array('Manage Colors',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Colors" name="chkbox" class="storechk">'.__d('admin','Manage Colors');
		else
		echo '<input type="checkbox" value="Manage Colors" name="chkbox" class="storechk">'.__d('admin','Manage Colors');
		echo '<br />';
		if(in_array('Manage Currency',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Currency" name="chkbox" class="storechk">'.__d('admin','Manage Currency');
		else
		echo '<input type="checkbox" value="Manage Currency" name="chkbox" class="storechk">'.__d('admin','Manage Currency');
		echo '<br />';
		
		

		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="disp">'.__d('admin','Disputes').'</h3>';
		if(in_array('User Options',$menu_list))
		echo '<input type="checkbox" checked="checked" value="User Options" name="chkbox" class="dispchk">'.__d('admin','User Options');
		else
		echo '<input type="checkbox" value="User Options" name="chkbox" class="dispchk">'.__d('admin','User Options');
		echo '<br />';
		if(in_array('Manage Dispute',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Dispute" name="chkbox" class="dispchk">'.__d('admin','Manage Dispute');
		else
		echo '<input type="checkbox" value="Manage Dispute" name="chkbox" class="dispchk">'.__d('admin','Manage Dispute');
		echo '<br />';
		
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="msg">'.__d('admin','Messages').'</h3>';
		if(in_array('Manage Seller Chat',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Seller Chat" name="chkbox" class="msgchk">'.__d('admin','Manage Seller Chat');
		else
		echo '<input type="checkbox" value="Manage Seller Chat" name="chkbox" class="msgchk">'.__d('admin','Manage Seller Chat');
		echo '<br />';

		if(in_array('Manage Subject',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Subject" name="chkbox" class="msgchk">'.__d('admin','Manage Subject');
		else
		echo '<input type="checkbox" value="Manage Subject" name="chkbox" class="msgchk">'.__d('admin','Manage Subject');
		echo '<br />';
		echo '<br />';
		echo '<br />';echo '<br />';echo '<br />';echo '<br />';echo '<br />';
	echo '</div>';
	
		echo '<div style="width:49% !important;float:right;">';
		echo '<h3><input type="checkbox" onclick="check_all(this)" name="chkmodules" class="site">'.__d('admin','Site Management').'</h3>';
		if(in_array('Site Management',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Site Management" name="chkmodules" value="" class="sitechk">'.__d('admin','Site Management');
		else
		echo '<input type="checkbox" value="Site Management" name="chkbox" class="sitechk">'.__d('admin','Site Management');
		echo '<br />';
		if(in_array('Media Management',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Media Management" name="chkbox" class="sitechk">'.__d('admin','Media Management');
		else
		echo '<input type="checkbox" value="Media Management" name="chkbox" class="sitechk">'.__d('admin','Media Management');
		echo '<br />';
		if(in_array('Email Management',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Email Management" name="chkbox" class="sitechk">'.__d('admin','Email Management');
		else
		echo '<input type="checkbox" value="Email Management" name="chkbox" class="sitechk">'.__d('admin','Email Management');
		echo '<br />';
		if(in_array('Manage Languages',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Languages" name="chkbox" class="sitechk">Manage Languages';
		else
		echo '<input type="checkbox" value="Manage Languages" name="chkbox" class="sitechk">Manage Languages';
		echo '<br />';
		if(in_array('Manage Landing Page',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Landing Page" name="chkbox" class="sitechk">Manage Landing Page';
		else
		echo '<input type="checkbox" value="Manage Landing Page" name="chkbox" class="sitechk">Manage Landing Page';
		echo '<br />';
		if(in_array('Mobile Apps Settings',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Mobile Apps Settings" name="chkbox" class="sitechk">'.__d('admin','Mobile Apps Settings');
		else
		echo '<input type="checkbox" value="Mobile Apps Settings" name="chkbox" class="sitechk">'.__d('admin','Mobile Apps Settings');
		echo '<br />';
		if(in_array('Social Settings',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Social Settings" name="chkbox" class="sitechk">'.__d('admin','Social Settings');
		else
		echo '<input type="checkbox" value="Social Settings" name="chkbox" class="sitechk">'.__d('admin','Social Settings');
		echo '<br />';
		if(in_array('Social Page Settings',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Social Page Settings" name="chkbox" class="sitechk">'.__d('admin','Social Page Settings');
		else
		echo '<input type="checkbox" value="Social Page Settings" name="chkbox" class="sitechk">'.__d('admin','Social Page Settings');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="news">'.__d('admin','Newsletter').'</h3>';
		
		if(in_array('Send Newsletter',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Send Newsletter" name="chkbox" class="newschk">'.__d('admin','Send Newsletter');
		else
		echo '<input type="checkbox" value="Send Newsletter" name="chkbox" class="newschk">'.__d('admin','Send Newsletter');
		echo '<br />';
		if(in_array('Get Contacts List',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Get Contacts List" name="chkbox" class="newschk">'.__d('admin','Get Contacts List');
		else
		echo '<input type="checkbox" value="Get Contacts List" name="chkbox" class="newschk">'.__d('admin','Get Contacts List');
		echo '<br />';
		if(in_array('Manage Newsletter',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Newsletter" name="chkbox" class="newschk">'.__d('admin','Manage Newsletter');
		else
		echo '<input type="checkbox" value="Manage Newsletter" name="chkbox" class="newschk">'.__d('admin','Manage Newsletter');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="gen">'.__d('admin','General Settings').'</h3>';
		if(in_array('Manage Modules',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Modules" name="chkbox" class="genchk">'.__d('admin','Manage Modules');
		else
		echo '<input type="checkbox" value="Manage Modules" name="chkbox" class="genchk">'.__d('admin','Manage Modules');
		echo '<br />';
		if(in_array('Google Analytics',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Google Analytics" name="chkbox" class="genchk">'.__d('admin','Google Analytics');
		else
		echo '<input type="checkbox" value="Google Analytics" name="chkbox" class="genchk">'.__d('admin','Google Analytics');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="ban">'.__d('admin','Banner Settings').'</h3>';
		if(in_array('Manage Banner',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Banner" name="chkbox" class="banchk">'.__d('admin','Banners');
		else
		echo '<input type="checkbox" value="Manage Banner" name="chkbox" class="banchk">'.__d('admin','Banners');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="error">'.__d('admin','Error Pages').'</h3>';
		if(in_array('404 page',$menu_list))
		echo '<input type="checkbox" checked="checked" value="404 page" name="chkbox" class="errorchk">'.__d('admin','404 page');
		else
		echo '<input type="checkbox" value="404 page" name="chkbox" class="errorchk">'.__d('admin','404 page');
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="footerpage">'.__d('admin','Footer Pages').'</h3>';
		if(in_array('About',$menu_list))
		echo '<input type="checkbox" checked="checked" value="About" name="chkbox" class="footerpagechk">'.__d('admin','About');
		else
		echo '<input type="checkbox" value="About" name="chkbox" class="footerpagechk">'.__d('admin','About');
		echo '<br />';
		if(in_array('Documentation',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Documentation" name="chkbox" class="footerpagechk">'.__d('admin','Documentation');
		else
		echo '<input type="checkbox" value="Documentation" name="chkbox" class="footerpagechk">'.__d('admin','Documentation');
		echo '<br />';
		if(in_array('Press',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Press" name="chkbox" class="footerpagechk">'.__d('admin','Press');
		else
		echo '<input type="checkbox" value="Press" name="chkbox" class="footerpagechk">'.__d('admin','Press');
		echo '<br />';
	if(in_array('Pricing',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Pricing" name="chkbox" class="footerpagechk">'.__d('admin','Pricing');
		else
		echo '<input type="checkbox" value="Pricing" name="chkbox" class="footerpagechk">'.__d('admin','Pricing');
		echo '<br />';
		if(in_array('Talk',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Talk" name="chkbox" class="footerpagechk">'.__d('admin','Talk');
		else
		echo '<input type="checkbox" value="Talk" name="chkbox" class="footerpagechk">'.__d('admin','Talk');
		echo '<br />';
	
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="help">'.__d('admin','Help Pages').'</h3>';
		if(in_array('Faq',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Faq" name="chkbox" class="helpchk">'.__d('admin','Faq');
		else
		echo '<input type="checkbox" value="Faq" name="chkbox" class="helpchk">'.__d('admin','Faq');
		echo '<br />';
		if(in_array('Contact',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Contact" name="chkbox" class="helpchk">'.__d('admin','Contact');
		else
		echo '<input type="checkbox" value="Contact" name="chkbox" class="helpchk">'.__d('admin','Contact');
		echo '<br />';
		if(in_array('Terms of Sale',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Terms of Sale" name="chkbox" class="helpchk">'.__d('admin','Terms of Sale');
		else
		echo '<input type="checkbox" value="Terms of Sale" name="chkbox" class="helpchk">'.__d('admin','Terms of Sale');
		echo '<br />';
		if(in_array('Terms of Service',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Terms of Service" name="chkbox" class="helpchk">'.__d('admin','Terms of Service');
		else
		echo '<input type="checkbox" value="Terms of Service" name="chkbox" class="helpchk">'.__d('admin','Terms of Service');
		echo '<br />';
		if(in_array('Privacy Policy',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Privacy Policy" name="chkbox" class="helpchk">'.__d('admin','Privacy Policy');
		else
		echo '<input type="checkbox" value="Privacy Policy" name="chkbox" class="helpchk">'.__d('admin','Privacy Policy');
		echo '<br />';
		if(in_array('Terms and Conditions',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Terms and Conditions" name="chkbox" class="helpchk">'.__d('admin','Terms and Conditions');
		else
		echo '<input type="checkbox" value="Terms and Conditions" name="chkbox" class="helpchk">'.__d('admin','Terms and Conditions');
		echo '<br />';
		if(in_array('Copyright Policy',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Copyright Policy" name="chkbox" class="helpchk">'.__d('admin','Copyright Policy');
		else
		echo '<input type="checkbox" value="Copyright Policy" name="chkbox" class="helpchk">'.__d('admin','Copyright Policy');
		echo '<br />';
	echo '</div>';
	echo '<div style="width:30%;float:right;margin-top:70px;position:relative;left:50px;">';
		echo '<input type="button" value="'.__d('admin','Save').'" onclick="menu_list()" class="btn btn-info">';
			if($menu_list=="")
	{
		echo '<input type="button" value="'.__d('admin','Cancel').'" onclick="close_button1()" class="btn btn-danger">';
	}
	else
	{
		echo '<input type="button" value="'.__d('admin','Cancel').'" onclick="close_button()" class="btn btn-danger">';
	}
	echo "<div id='alert' style='color: red; font-size: 13px;' class='trn'></div>";
	echo '</div>';

?>
