<?php
$menu_list = json_decode($admin_menus_list,true);
//echo $menu_list;
//echo '<button id="btn_closes" onclick="menu_list()" class="btn btn-danger inv-close" style="width: 90px; margin: 14px 6px 0px; font-size: 11px;float:right;">Back</button>';
	echo '<div style="width:49% !important;float:left;">';
	if(in_array('Home',$menu_list) && in_array('Add User',$menu_list) && in_array('Manage User',$menu_list) && in_array('Manage Moderator',$menu_list) && in_array('Payment Gateway',$menu_list) && in_array('Orders',$menu_list) && in_array('Commission Setup',$menu_list) && in_array('Invoices',$menu_list) && in_array('Tax Rates',$menu_list) && in_array('Add Coupon',$menu_list) && in_array('Manage Coupon',$menu_list) && in_array('Logs Coupon',$menu_list) && in_array('Add Gift Card',$menu_list) && in_array('Logs',$menu_list) && in_array('Manage Category',$menu_list) && in_array('Manage Items',$menu_list)  && in_array('Manage Prices',$menu_list) && in_array('Manage Colors',$menu_list) && in_array('Manage Currency',$menu_list) && in_array('Manage Sellers',$menu_list) && in_array('Manage Group Gifts',$menu_list) && in_array('User Options',$menu_list) && in_array('Manage Dispute',$menu_list) && in_array('Manage Seller Chat',$menu_list) && in_array('Manage Subjects',$menu_list) && in_array('Site Management',$menu_list) && in_array('Media Management',$menu_list) && in_array('Email Management',$menu_list) && in_array('Manage Landing Page',$menu_list) && in_array('Mobile Apps Settings',$menu_list) && in_array('Social Settings',$menu_list) && in_array('Add Contacts',$menu_list) && in_array('Send Newsletter',$menu_list) && in_array('Get Contacts List',$menu_list) && in_array('Manage Newsletter',$menu_list) && in_array('Manage Modules',$menu_list) && in_array('Google Analytics',$menu_list) && in_array('Manage Banner',$menu_list) && in_array('404 page',$menu_list) && in_array('Faq',$menu_list) && in_array('Contact',$menu_list) && in_array('Terms of Sale',$menu_list) && in_array('Terms of Service',$menu_list) && in_array('Privacy Policy',$menu_list) && in_array('Terms and Conditions',$menu_list) && in_array('Copyright Policy',$menu_list))
        echo '<input type="checkbox" checked="checked" value="all" onclick="select_all_mod()" id="sel_all">Select All';
    else

    	echo '<input type="checkbox" value="all" onclick="select_all_mod()" id="sel_all">Select All';
		echo '<h3>'.__d('admin','Dashboard').'</h3>';
		if(in_array('Home',$menu_list) || $menu_list=="Home")
		echo '<input type="checkbox" class="home" onclick="all_mod(this)" checked="checked" value="Home" name="chkbox">Home';
		else
		echo '<input type="checkbox" class="home" onclick="all_mod(this)" value="Home" name="chkbox">Home';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="user">User Management</h3>';
		if(in_array('Add User',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Add User" class="userchk" name="chkbox">Add User';
		else
		echo '<input type="checkbox" value="Add User" name="chkbox" class="userchk">Add User';
		echo '<br />';
		if(in_array('Manage User',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage User" name="chkbox" class="userchk">Manage User';
		else
		echo '<input type="checkbox" value="Manage User" name="chkbox" class="userchk">Manage User';
		echo '<br />';
		if(in_array('Manage Moderator',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Moderator" name="chkbox" class="userchk">Manage Moderator';
		else
		echo '<input type="checkbox" value="Manage Moderator" name="chkbox" class="userchk">Manage Moderator';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="pay">Payment</h3>';
		if(in_array('Payment Gateway',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Payment Gateway" name="chkbox" class="paychk">Payment Gateway';
		else
		echo '<input type="checkbox" value="Payment Gateway" name="chkbox" class="paychk">Payment Gateway';
		echo '<br />';
		if(in_array('Orders',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Orders" name="chkbox" class="paychk">Orders';
		else
		echo '<input type="checkbox" value="Orders" name="chkbox" class="paychk">Orders';
		echo '<br />';
		if(in_array('Commission Setup',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Commission Setup" name="chkbox" class="paychk">Commission Setup';
		else
		echo '<input type="checkbox" value="Commission Setup" name="chkbox" class="paychk">Commission Setup';
		echo '<br />';
		if(in_array('Invoices',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Invoices" name="chkbox" class="paychk">Invoices';
		else
		echo '<input type="checkbox" value="Invoices" name="chkbox" class="paychk">Invoices';
		echo '<br />';
		if(in_array('Tax Rates',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Tax Rates" name="chkbox" class="paychk">Tax Rates';
		else
		echo '<input type="checkbox" value="Tax Rates" name="chkbox" class="paychk">Tax Rates';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="coupon">Coupons</h3>';
		if(in_array('Add Coupon',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Add Coupon" name="chkbox" class="couponchk">Add Coupon';
		else
		echo '<input type="checkbox" value="Add Coupon" name="chkbox" class="couponchk">Add Coupon';
		echo '<br />';
		if(in_array('Manage Coupon',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Coupon" name="chkbox" class="couponchk">Manage Coupon';
		else
		echo '<input type="checkbox" value="Manage Coupon" name="chkbox" class="couponchk">Manage Coupon';
		echo '<br />';
		if(in_array('Logs Coupon',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Logs Coupon" name="chkbox" class="couponchk">Logs Coupon';
		else
		echo '<input type="checkbox" value="Logs Coupon" name="chkbox" class="couponchk">Logs Coupon';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="gift">Gift Card</h3>';
		if(in_array('Add Gift Card',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Add Gift Card" name="chkbox" class="giftchk">Add Gift Card';
		else
		echo '<input type="checkbox" value="Add Gift Card" name="chkbox" class="giftchk">Add Gift Card';
		echo '<br />';
		if(in_array('Logs',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Logs" name="chkbox" class="giftchk">Logs';
		else
		echo '<input type="checkbox" value="Logs" name="chkbox" class="giftchk">Logs';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="store">Store Preferences</h3>';
		if(in_array('Manage Category',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Category" name="chkbox" class="storechk">Manage Category';
		else
		echo '<input type="checkbox" value="Manage Category" name="chkbox" class="storechk">Manage Category';
		echo '<br />';
		if(in_array('Manage Items',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Items" name="chkbox" class="storechk">Manage Items';
		else
		echo '<input type="checkbox" value="Manage Items" name="chkbox" class="storechk">Manage Items';
		echo '<br />';
	/*	if(in_array('Manage Shared Items',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Shared Items" name="chkbox" class="storechk">Manage Shared Items';
		else
		echo '<input type="checkbox" value="Manage Shared Items" name="chkbox" class="storechk">Manage Shared Items';
		echo '<br />';*/
		if(in_array('Manage Reported Items',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Reported Items" name="chkbox" class="storechk">Manage Reported Items';
		else
		echo '<input type="checkbox" value="Manage Reported Items" name="chkbox" class="storechk">Manage Reported Items';
		echo '<br />';
		if(in_array('Manage Prices',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Prices" name="chkbox" class="storechk">Manage Prices';
		else
		echo '<input type="checkbox" value="Manage Prices" name="chkbox" class="storechk">Manage Prices';
		echo '<br />';
		if(in_array('Manage Colors',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Colors" name="chkbox" class="storechk">Manage Colors';
		else
		echo '<input type="checkbox" value="Manage Colors" name="chkbox" class="storechk">Manage Colors';
		echo '<br />';
		if(in_array('Manage Currency',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Currency" name="chkbox" class="storechk">Manage Currency';
		else
		echo '<input type="checkbox" value="Manage Currency" name="chkbox" class="storechk">Manage Currency';
		echo '<br />';
		if(in_array('Manage Sellers',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Sellers" name="chkbox" class="storechk">Manage Sellers';
		else
		echo '<input type="checkbox" value="Manage Sellers" name="chkbox" class="storechk">Manage Sellers';
		echo '<br />';
		if(in_array('Manage Group Gifts',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Group Gifts" name="chkbox" class="storechk">Manage Group Gifts';
		else
		echo '<input type="checkbox" value="Manage Group Gifts" name="chkbox" class="storechk">Manage Group Gifts';
		echo '<br />';
		if(in_array('Manage Recipients',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Recipients" name="chkbox" class="storechk">Manage Recipients';
		else
		echo '<input type="checkbox" value="Manage Recipients" name="chkbox" class="storechk">Manage Recipients';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="disp">Disputes</h3>';
		if(in_array('User Options',$menu_list))
		echo '<input type="checkbox" checked="checked" value="User Options" name="chkbox" class="dispchk">User Options';
		else
		echo '<input type="checkbox" value="User Options" name="chkbox" class="dispchk">User Options';
		echo '<br />';
		if(in_array('Manage Dispute',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Dispute" name="chkbox" class="dispchk">Manage Dispute';
		else
		echo '<input type="checkbox" value="Manage Dispute" name="chkbox" class="dispchk">Manage Dispute';
		echo '<br />';
		echo '<br />';
		echo '<br />';echo '<br />';echo '<br />';echo '<br />';echo '<br />';
	echo '</div>';
	echo '<div style="width:49% !important;float:right;">';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="msg">Messages</h3>';
		if(in_array('Manage Seller Chat',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Seller Chat" name="chkbox" class="msgchk">Manage Seller Chat';
		else
		echo '<input type="checkbox" value="Manage Seller Chat" name="chkbox" class="msgchk">Manage Seller Chat';
		echo '<br />';
		if(in_array('Manage Subjects',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Subjects" name="chkbox" class="msgchk">Manage Subjects';
		else
		echo '<input type="checkbox" value="Manage Subjects" name="chkbox" class="msgchk">Manage Subjects';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" name="chkmodules" class="site">Site Management</h3>';
		if(in_array('Site Management',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Site Management" name="chkmodules" value="" class="sitechk">Site Management';
		else
		echo '<input type="checkbox" value="Site Management" name="chkbox" class="sitechk">Site Management';
		echo '<br />';
		if(in_array('Media Management',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Media Management" name="chkbox" class="sitechk">Media Management';
		else
		echo '<input type="checkbox" value="Media Management" name="chkbox" class="sitechk">Media Management';
		echo '<br />';
		if(in_array('Email Management',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Email Management" name="chkbox" class="sitechk">Email Management';
		else
		echo '<input type="checkbox" value="Email Management" name="chkbox" class="sitechk">Email Management';
		echo '<br />';
		/*if(in_array('Manage Landing Page',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Landing Page" name="chkbox" class="sitechk">Manage Landing Page';
		else
		echo '<input type="checkbox" value="Manage Landing Page" name="chkbox" class="sitechk">Manage Landing Page';
		echo '<br />';*/
		if(in_array('Mobile Apps Settings',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Mobile Apps Settings" name="chkbox" class="sitechk">Mobile Apps Settings';
		else
		echo '<input type="checkbox" value="Mobile Apps Settings" name="chkbox" class="sitechk">Mobile Apps Settings';
		echo '<br />';
		if(in_array('Social Settings',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Social Settings" name="chkbox" class="sitechk">Social Settings';
		else
		echo '<input type="checkbox" value="Social Settings" name="chkbox" class="sitechk">Social Settings';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="news">Newsletter</h3>';
		if(in_array('Add Contacts',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Add Contacts" name="chkbox" class="newschk">Add Contacts';
		else
		echo '<input type="checkbox" value="Add Contacts" name="chkbox" class="newschk">Add Contacts';
		echo '<br />';
		if(in_array('Send Newsletter',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Send Newsletter" name="chkbox" class="newschk">Send Newsletter';
		else
		echo '<input type="checkbox" value="Send Newsletter" name="chkbox" class="newschk">Send Newsletter';
		echo '<br />';
		if(in_array('Get Contacts List',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Get Contacts List" name="chkbox" class="newschk">Get Contacts List';
		else
		echo '<input type="checkbox" value="Get Contacts List" name="chkbox" class="newschk">Get Contacts List';
		echo '<br />';
		if(in_array('Manage Newsletter',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Newsletter" name="chkbox" class="newschk">Manage Newsletter';
		else
		echo '<input type="checkbox" value="Manage Newsletter" name="chkbox" class="newschk">Manage Newsletter';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="gen">General Settings</h3>';
		if(in_array('Manage Modules',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Modules" name="chkbox" class="genchk">Manage Modules';
		else
		echo '<input type="checkbox" value="Manage Modules" name="chkbox" class="genchk">Manage Modules';
		echo '<br />';
		if(in_array('Google Analytics',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Google Analytics" name="chkbox" class="genchk">Google Analytics';
		else
		echo '<input type="checkbox" value="Google Analytics" name="chkbox" class="genchk">Google Analytics';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="ban">Banner Settings</h3>';
		if(in_array('Manage Banner',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Manage Banner" name="chkbox" class="banchk">Banners';
		else
		echo '<input type="checkbox" value="Manage Banner" name="chkbox" class="banchk">Banners';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="error">Error Pages</h3>';
		if(in_array('404 page',$menu_list))
		echo '<input type="checkbox" checked="checked" value="404 page" name="chkbox" class="errorchk">404 page';
		else
		echo '<input type="checkbox" value="404 page" name="chkbox" class="errorchk">404 page';
		echo '<br />';
		echo '<h3><input type="checkbox" onclick="check_all(this)" value="" name="chkmodules" class="help">Help Pages</h3>';
		if(in_array('Faq',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Faq" name="chkbox" class="helpchk">Faq';
		else
		echo '<input type="checkbox" value="Faq" name="chkbox" class="helpchk">Faq';
		echo '<br />';
		if(in_array('Contact',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Contact" name="chkbox" class="helpchk">Contact';
		else
		echo '<input type="checkbox" value="Contact" name="chkbox" class="helpchk">Contact';
		echo '<br />';
		if(in_array('Terms of Sale',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Terms of Sale" name="chkbox" class="helpchk">Terms of Sale';
		else
		echo '<input type="checkbox" value="Terms of Sale" name="chkbox" class="helpchk">Terms of Sale';
		echo '<br />';
		if(in_array('Terms of Service',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Terms of Service" name="chkbox" class="helpchk">Terms of Service';
		else
		echo '<input type="checkbox" value="Terms of Service" name="chkbox" class="helpchk">Terms of Service';
		echo '<br />';
		if(in_array('Privacy Policy',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Privacy Policy" name="chkbox" class="helpchk">Privacy Policy';
		else
		echo '<input type="checkbox" value="Privacy Policy" name="chkbox" class="helpchk">Privacy Policy';
		echo '<br />';
		if(in_array('Terms and Conditions',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Terms and Conditions" name="chkbox" class="helpchk">Terms and Conditions';
		else
		echo '<input type="checkbox" value="Terms and Conditions" name="chkbox" class="helpchk">Terms and Conditions';
		echo '<br />';
		if(in_array('Copyright Policy',$menu_list))
		echo '<input type="checkbox" checked="checked" value="Copyright Policy" name="chkbox" class="helpchk">Copyright Policy';
		else
		echo '<input type="checkbox" value="Copyright Policy" name="chkbox" class="helpchk">Copyright Policy';
		echo '<br />';
	echo '</div>';
	echo '<div style="width:30%;float:right;margin-top:70px;position:relative;left:50px;">';
		echo '<input type="button" value="'.__d('admin','Save').'" onclick="menu_list()" class="btn btn-info">';
		echo '<input type="button" value="'.__d('admin','Cancel').'" onclick="close_button()" class="btn btn-danger">';
	echo '</div>';
?>
