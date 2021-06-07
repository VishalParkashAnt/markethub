var $ = jQuery.noConflict();
var BaseURL=getBaseURL();
$(function(){
    $('div.lang-dd a').click(function(e)
    {
     	var lang=$(this).text().trim();
		Baseurl = getBaseURL();
		$.ajax({
		url: Baseurl+"setlanguageAdmin/",
		type: "post",
		data:{'language':lang},
		dataType: "html",
		success: function(responce){
			$("#languagecode").val(responce);
			window.location.reload();
		} ,

		});
    });
});

$(document).ready(function(){
	$('#commission_type').on('change', function() {
		var currency_sym = 	$('#commission_type').val();
		$('.currency_symbol').text(currency_sym);
	});

	$('#coupontype').on('change', function() {
		var currency_sym = 	$('#coupontype').val();
		if(currency_sym == 'fixed') {
		$('.currency_symbol').text('$');
		}
		else if(currency_sym == 'percent') {
		$('.currency_symbol').text('%');
		}
	});
$(document).on('keyup','#passw, #confirmpass', function() {
    var password = $('#passw').val();
    var confirmPwd = $('#confirmpass').val();
    var expass = $("#exispass").val();
    if (expass=="" || password=="" || confirmPwd=="") {
      $('#save_password').attr('disabled','disabled');
    }
	else if (password == confirmPwd) {
		$('#save_password').removeAttr('disabled','disabled');
	}else {
		//$('#save_password').attr('disabled','disabled');
	}
});


$(document).on('keyup','#gift_title', function() {
	var maxLen = 20;
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	//alert(maxLen);
	var gift_title = $('#gift_title').val();

	if ($.trim(gift_title).length >= maxLen) {
	//var msg = "You have reached your maximum limit of characters allowed";
	//alert(msg);
		document.getElementById('gift_title').value = $.trim(gift_title).substring(0, maxLen);

		$('#gift_titletext').css('color', 'red');
		$('#gift_titletext').text('You have reached above 20 characters');
		translator.lang(sessionlang);
		 $('#gift_titletext').show();
		setTimeout(function() {
			 $('#gift_titletext').fadeOut('slow');
		}, 5000);
           // document.getElementById('text_num').value = '0 characters left';
	return false;
	 }
	else{
		//document.getElementById('text_num').value = maxLen - $.trim(gift_title).length+' characters left';
		$('#gift_titletext').hide();
	}
});
$(document).on('keyup','#gift_desc', function() {
	var maxLen = 250;
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	//alert(maxLen);
	var gift_desc = $('#gift_desc').val();

	if ($.trim(gift_desc).length >= maxLen) {
	//var msg = "You have reached your maximum limit of characters allowed";
	//alert(msg);
		document.getElementById('gift_desc').value = $.trim(gift_desc).substring(0, maxLen);
		$('#gift_desctext').text('You have reached above 250 characters');
		translator.lang(sessionlang);
		$('#gift_desctext').css('color', 'red');
		$('#gift_desctext').show();
		setTimeout(function() {
			 $('#gift_desctext').fadeOut('slow');
	 	}, 5000);
           // document.getElementById('text_num').value = '0 characters left';
	return false;
	 }
	else{
		//document.getElementById('text_num').value = maxLen - $.trim(gift_title).length+' characters left';
		$('#gift_desctext').hide();
	}
});

	$('#generate_coupon').click(function(){
		alert('Welcome');
		var baseurl = getBaseURL()+'admins/admins/generatecoupons/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){
alert(responce); return false;
			          var respon = $.trim(responce)
			          $('#couponcodes').val(respon);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      }
			    });
		}
	});


	$('#select_merchant').bind('change keyup', function(){
		if($(this).val() == 0)
		{
			$('#invoice-popup-overlayss').hide();
			$('#invoice-popup-overlayss').css("opacity", "0");
		}
		else
		{
			$('#invoice-popup-overlayss').show();
			$('#invoice-popup-overlayss').css("opacity", "1");
		}



		$('#save_merchant').click(function(){
			$('#invoice-popup-overlayss').hide();
			$('#invoice-popup-overlayss').css("opacity", "0");

		});


	});


});

$('#amountss, #couponrange, #commission').live('keyup', function(e) {
    if (e.altKey) {
    e.preventDefault();
    } else {
    var key = e.keyCode;//alert(key);
 if (!((key == 8) || (key == 32) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) )) {
    var $th = $(this);
    $th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
    e.preventDefault();
}
 }
});


$('#start_range, #end_range, #currency_rate').live('keyup', function() {
    var $th = $(this);
    $th.val( $th.val().replace(/[^0-9.]/g, function(str) { return ''; } ) );
});

$('#Category_name ').live('keyup', function() {
    var $th = $(this);
    $th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
});



$('#minrange, #maxrange , #comision').live('keyup', function(e) {
   if (e.altKey) {
    e.preventDefault();
    } else {
    var key = e.keyCode;//alert(key);
 if (!((key == 8) || (key == 32) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) )) {
    var $th = $(this);
    $th.val( $th.val().replace(/[^0-9]/g, function(str) { return ''; } ) );
    e.preventDefault();
}
 }
});


$(' #color_name').live('keyup', function() {
    var $th = $(this);
    $th.val( $th.val().replace(/[^A-Za-z]/g, function(str) { return ''; } ) );
});

//Author:Saravana pandian Date:19.05.2014 Reason:Not allowing special characters
/*$('#price').live('keyup', function() {
    var $th = $(this);
    $th.val( $th.val().replace(/[^0-9.]/g, function(str) { return ''; } ) );
});*/

$('#price,#quantity,#shippingPrice').keydown(function (e) {
    var keyCode = e.which; // Capture the event

    //190 is the key code of decimal if you dont want decimals remove this condition keyCode != 190
    if (keyCode != 8 && keyCode != 9 && keyCode != 13 && keyCode != 37 && keyCode != 38 && keyCode != 39 && keyCode != 40 && keyCode != 46 && keyCode != 110 && keyCode != 190) {
        if (keyCode < 48) {
            e.preventDefault();
        } else if (keyCode > 57 && keyCode < 96) {
            e.preventDefault();
        } else if (keyCode > 105) {
            e.preventDefault();
        }
    }
});

$('#percentage').live('keyup', function(e) {
    if (e.altKey) {
    e.preventDefault();
    } else {
    var key = e.keyCode;//alert(key);
 if (!((key == 8) || (key == 32) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) )) {
    var $th = $(this);
    $th.val( $th.val().replace(/[^0-9.]/g, function(str) { return ''; } ) );
    e.preventDefault();
}
 }
});

$('#tags_Amt').live('keyup', function() {
    var $th = $(this);
    $th.val( $th.val().replace(/[^0-9.,]/g, function(str) { return ''; } ) );
});




$(document).ready(function(){
	if($('#commission_type').val() == '$') {
		$('.currency_symbol').text('$');
		}
		else if($('#commission_type').val() == '%') {
		$('.currency_symbol').text('%');
		}

	/*$('#usersrchSrch').keyup(function() {
		 var value1 = $('#usersrchSrch').val();
		 $.ajax({
				type: "post",		// Request method: post, get
				url: BaseURL+"admin/user/management/"+value1,	// URL to request
				dataType: "html",	// Expected response type
				success: function(response, status) {
//					alert(value1);
					$('#search_user1').html(response);
				},
			});

			return false;
		});
	*/



	$('#srchItms').click(function(){
		var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
		/*if(startddates>endDates){
			alert('End date must be greater');
			return false;
		}*/

		var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admin/searchitemkeyword/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){
			          //alert(responce);
			          $('#searchite').html(responce);
					  $('#searchite').find('input:checkbox').uniform();
			    	  $('#loading_img').hide();
			          invajax = 0;
			      }
			    });
		}
	});

	$('#srchnonItms').click(function(){
		var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
		/*if(startddates>endDates){
			alert('End date must be greater');
			return false;
		}*/

		var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admin/manage/searchnonapproveditems/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){
			          //alert(responce);
			          $('#searchite').html(responce);
					  $('#searchite').find('input:checkbox').uniform();
			    	  $('#loading_img').hide();
			          invajax = 0;
			      }
			    });
		}
	});

	$('#srchAffiliate').click(function(){
// function srchAffiliate(){
alert('rgg'); return false;
		var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
		/*if(startddates>endDates){
			alert('End date must be greater');
			return false;
		}*/

		var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admin/searchaffiliate/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){
			          //alert(responce);
			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      }
			    });
		}
	});

	$('#srchreport').click(function(){
		var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
		/*if(startddates>endDates){
			alert('End date must be greater');
			return false;
		}*/

		var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admin/searchreportitems/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){
			          //alert(responce);
			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      }
			    });
		}
	});

	$('#srchSeller').click(function(){
		var serchkeywrd = $('#serchkeywrd').val();
		if($.trim(serchkeywrd)=="")
		{
			$("#sellerr").show();
			setTimeout(function() {
				  $('#sellerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		else
		{
			var baseurl = getBaseURL()+'admin/searchsellerkeyword/';
			if (invajax == 0) {
				invajax = 1;
				$.ajax({
				      url: baseurl,
				      type: "post",
				      dataType: "html",
				      data : {'serchkeywrd': serchkeywrd},
				      beforeSend: function () {
				    	  $('#loading_img').show();
				      },
				      success: function(responce){
				          //alert(responce);
				          $('#userdata').html(responce);
				    	  $('#loading_img').hide();
				          invajax = 0;
				      }
				    });
			}
		}
	});

	$('#srchnonapproveSeller').click(function(){
		var serchkeywrd = $('#serchkeywrd').val();
		if($.trim(serchkeywrd)=="")
		{
			$("#nonsellerr").show();
			setTimeout(function() {
				  $('#nonsellerr').fadeOut('slow');
				}, 5000);
			return false;

		}
		else
		{
			var baseurl = getBaseURL()+'admin/searchnonapproveseller/';
			if (invajax == 0) {
				invajax = 1;
				$.ajax({
				      url: baseurl,
				      type: "post",
				      dataType: "html",
				      data : {'serchkeywrd': serchkeywrd},
				      beforeSend: function () {
				    	  $('#loading_img').show();
				      },
				      success: function(responce){
				          //alert(responce);
				          $('#userdata').html(responce);
				    	  $('#loading_img').hide();
				          invajax = 0;
				      }
				    });
			}
		}
	});



	var flashMessage = $('#flashMessage');
	flashMessage.load();
		setTimeout(function() {
		  $('#flashMessage').fadeOut('slow');
		}, 5000);


		//$('.dropdown-toggle').dropdown();
		$("#myTable").tablesorter();

	$('.appliform').blur(function(){
		// $(".vld_eml").hide();
		var val = $('#'+$(this).attr('id')).val();
		// alert(val);
		if(val != ''){
			$('#error_'+$(this).attr('id')).hide();
		}else{
			$('#error_'+$(this).attr('id')).show();
		}
		$('.'+$(this).attr('id')).hide();

		var name = $(this).attr('name');
		// alert(name);
		if(name=='data[appli][emailaddress]'){
			// alert('email');
			var emails = $(this).val();
			// alert(x);
			if(emails != ''){
				if(!isValidEmailAddress(emails)){
					alert("Enter valid email, otherwise the email not sent if needed");
				}
			}
		}
		/* var name = $(this).attr('name');
		if(name=='data[email]')
		{
		var x = $('#'+$(this).attr('id')).val();
		if(x!= /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
		{

		}

		} */
	});

	$('.appliform').focus(function(){
		var val = $(this).attr('id');
		$('.'+$(this).attr('id')).show();

	});
	$('.appliform').keyup(function(){
		var val = $('#'+$(this).attr('id')).val();
		if(val != ''){
			$('#error_'+$(this).attr('id')).hide();
		}else{
			$('#error_'+$(this).attr('id')).show();
		}
	});
	$('.appliform').click(function(){
		var val = $('#'+$(this).attr('id')).val();
		var str = $(this).attr('id');
		// alert(str);
		// var sid = str.slice(0,-1);
		var sid = str.replace(/\D/g,'');
		// sid = (str.split(""));
		// alert(val);
		// alert(sid);
		if(val != ''){
			// $('#error_'+sid[0]).hide();
			$('#error_'+sid).hide();
		}else{
			// $('#error_'+sid[0]).show();
			$('#error_'+sid).show();
		}
	});
	$('.appliform').change(function(){
		var val = $('#'+$(this).attr('id')).val();
		if(val != ''){
			$('#error_'+$(this).attr('id')).hide();
		}else{
			$('#error_'+$(this).attr('id')).show();
		}
	});
	$('.changepass').click(function(){
		var val = $(this).val();
		// alert(val);
		if(val == 'yes'){
			$('#editpassword').show();
			$('.pass1').show();
		}else if(val == 'no'){
			$('#editpassword').hide();
			$('.pass1').hide();
		}
	});
	/* Profile Edit Form */
	$('#profileform').submit(function(){
		var username = $('#edituser').val();
		var email = $('#editemail').val();
		var vals = $('.changepass:checked').val();
		var password = $('#editpassword').val();
		if(username == ''){
			alert('Please enter the Username');
			return false;
		}
		if(email == ''){
			alert('Please enter the Email');
			return false;
		}
		if(!(isValidEmailAddress(email))){
			alert('Enter The Valid Email');
			return false;
		}
		if(vals == 'yes'){
			if(password == ''){
				alert('Please enter the Password');
				return false;
			}
			if(password.length < 6){
				alert('Password should be greater that 5 digits');
				return false;
			}
		}
	});

	/* Login Form */

	/* Login Form */
	$('#loginform').submit(function(){
		var email = $('#user_email').val();
		var password = $('#user_pass').val();
		if(email == ''){
			alert('Please enter the Email');
			return false;
		}
		if(!(isValidEmailAddress(email))){
			alert('Enter The Valid Email');
			return false;
		}
		if(password == ''){
			alert('Please enter the Password');
			return false;
		}
	});

	/* User creation Form */
	$('#useraccount').submit(function(){
		var name = $('#name').val();
		var email = $('#emailid').val();
		var types = $('#types').val();
		if(name == ''){
			alert('Please enter the username');
			return false;
		}
		if(email == ''){
			alert('Please enter the Email');
			return false;
		}
		if(!(isValidEmailAddress(email))){
			alert('Enter The Valid Email');
			return false;
		}
		if(types == ''){
			alert('Please select user type');
			return false;
		}
	});


	/* Site setting creation form */
	$('#siteform').submit(function(){
		var name = $('#site_name').val();
		var tempowner = $('#site_title').val();
		var welcome_email = $('.welcome_email').val();
		var signup_active = $('.signup_active').val();
		var numofdays_update = $('#numofdays_update').val();


		if(name == ''){
			alert('Please enter the Site Name');
			return false;
		}
		if(tempowner == ''){
			alert('Please enter the Site Title');
			return false;
		}
		if(welcome_email == undefined){
			alert('Please select the Welcome email choice');
			return false;
		}
		if(signup_active == undefined){
			alert('Please select the Signup Active choice');
			return false;
		}
		if(numofdays_update == "0"){
			alert('Please Enter valid number of days to update order status');
			return false;
		}

	});

	$('#mediaform').submit(function(){

		var temptypes1 = $('#meta_key').val();
		var tempversion = $('#meta_desc').val();


		if(temptypes1 == ''){
			alert('Please select the Meta keyword');
			return false;
		}
		if(tempversion == ''){
			alert('Please select the Description');
			return false;
		}

	});


	/*$('#bannerform').submit(function(){
		var banner_name = $('#banner_name').val();
		var html_source = $('#html_source').val();
		var about_adv = $('#about_adv').val();
		var start_date = $('#startDate').val();
		var end_date = $('#endDate').val();
		var status = $('.status').val();

		if(banner_name == ''){
			$('#alert').show().html('Please enter the banner name');
			return false;
		}
		if(html_source == ''){
			$('#alert').show().html('Please enter the Html Source');
			return false;
		}
		if(about_adv == ''){
			$('#alert').show().html('Please enter the About Advertisement');
			return false;
		}
		if(start_date == ''){
			$('#alert').show().html('Please enter the Start Date');
			return false;
		}
		if(end_date == ''){
			$('#alert').show().html('Please enter the End Date');
			return false;
		}
		//alert(start_date);
		//alert(end_date);
		if(start_date > end_date){
			$('#alert').show().html('The start date can not be greater then the end date');
			return false;
		}
		if(start_date > end_date){
			$('#alert').show().html('The end date can not be less then the start date');
			return false;
		}
		if(status == undefined){
			$('#alert').show().html('Please Select the status');
			return false;
		}
	});
	*/

	/* news form */
	$('#newsform').submit(function(){
		var title = $('#title').val();
		var summary = $('#summary').val();
		var description = $('#description').val();
		var status = $('.status').val();

		if(title == ''){
			$('#alert').show().html('Please enter the News Title');
			return false;
		}
		if(summary == ''){
			$('#alert').show().html('Please enter the News Summary');
			return false;
		}
		if(description == ''){
			$('#alert').show().html('Please enter the News Description');
			return false;
		}
		if(status == undefined){
			$('#alert').show().html('Please Select the status');
			return false;
		}


	});

	$(".catchnge").change(function(){
		var mainsel = $("#mainsec").val();
		if(mainsel == ''){
			$(".show_hid").hide();
		}else{
			$(".show_hid").show();
		}
	});

		/* invoice popup */

	$('#btn_close, .inv-close').live ('click' ,function(){
		$('#invoice-popup-overlay').hide();
		$('#invoice-popup-overlay').css("opacity", "0");

	});

	$('#invoice-popup-overlay, .inv-close').live ('click',function(){
		$('#invoice-popup-overlay').show();
		$('#invoice-popup-overlay').css("opacity", "1");
	});

	$('#invoice-popup-overlay, .inv-close').live ('keyup',function(e){
		if (e.keyCode == 27)
		  {
		     $('#invoice-popup-overlay').hide();
		     $('#invoice-popup-overlay').css("opacity", "0");
		  }   // esc
		});
$("#invoice-popup-overlay, #btn_close").live ('click',function(){
		$('#invoice-popup-overlay').hide();
		$('#invoice-popup-overlay').css("opacity", "0");
window.close();
	});

	$('#invoice-popup-overlay').keydown(function(e) {
		if(e.keyCode == 27) {
		window.close();
		}
	});

	$("#cate_id").change(function(){
		var cate_id = $("#cate_id :selected").val();
		// alert(cate_id);
		var items="";
		if(cate_id != ''){
			 $.getJSON(BaseURL+"suprsubcategry?cate_id="+cate_id+"&suprsub=yes",function(data){
				// alert(data);
				// return false;
				items+="<option value=''>Select Category</option>";
				$.each(data,function(index,cate)
				{
				  items+="<option value='"+cate.ID+"'>"+cate.Name+"</option>";
				});
				$("#categ-container-2").removeClass('inactive');
				$("#categ-container-2 label").removeClass('invisible');
				$("#categ-selectbx-2").html(items);
			});
		}else{
			$("#categ-container-2").addClass('inactive');
			$("#categ-container-2 label").addClass('invisible');
			$("#categ-selectbx-2").html('');
		}
	});

	$("#categ-selectbx-2").change(function(){
		var cate_id = $("#categ-selectbx-2 :selected").val();
		// alert(cate_id);
		var items="";
		if(cate_id != ''){
			 $.getJSON(BaseURL+"suprsubcategry?cate_id="+cate_id+"&suprsub=no",function(data){
				// alert(data);
				// return false;
				items+="<option value=''>Select Category</option>";
				$.each(data,function(index,cate)
				{
				  items+="<option value='"+cate.ID+"'>"+cate.Name+"</option>";
				});
				$("#categ-container-3").removeClass('inactive');
				$("#categ-container-3 label").removeClass('invisible');
				$("#categ-selectbx-3").html(items);
			});
		}else{
			$("#categ-container-3").addClass('inactive');
			$("#categ-container-3 label").addClass('invisible');
			$("#categ-selectbx-3").html('');
		}
	});

	$("#processing-time-id").change(function(){
		var vals = $("#processing-time-id :selected").val();
		// alert(vals);
		if(vals == 'custom'){
			$("#processing-time-days").show();
		}else{
			$("#processing-time-days").hide();
		}
	});

	$("#selct_lctn_bxs").change(function(){
		var incrmt_val = $("#incrmt_val").val();
		incrmt_val++;
		$('.shippingcountryerror').hide();

		var lctn = $("#selct_lctn_bxs :selected").val();
		var lctn_name = $("#selct_lctn_bxs :selected").text();
		// alert(lctn);
		// alert(lctn_name);
		if ($('#shpng_div tbody tr').hasClass(lctn)){
			$('.shippingcountryerror').html("Country already exist");
			$('.shippingcountryerror').show();
			return;
		}else if (lctn == ''){
			return;
		}
		$(".input-group-close").removeClass('clsehide');
		var htms = '<tr class="new-shipping-location '+lctn+'">';
			htms += '<td id="'+lctn+'">';
				htms += '<div class="input-group-location">'+lctn_name+'</div>';
				htms += '<div class="regions-box"></div>';
			htms += '</td>';
			htms += '<td>';
				htms += '<div class="input-group input-group-price price-input primary-shipping-price">';
					htms += '$';
					htms += '<input type="text" value="" id="price" onkeydown="chknum(this,event);" maxlength="6" class="money text text-small input-small" name="country_shipping['+lctn+']['+incrmt_val+'][primary]">';
				htms += '</div>';
			htms += '</td>';
			htms += '<td class="input-group-close">';
				htms += '<div class="shippingClose input-group input-group-price price-input primary-shipping-price"><a class="remove" href="javascript:void(0)" id='+lctn+'><i class="icon-trash"></i></a></div>';
			htms += '</td>';
		htms += '</tr> ';



		$("#shpng_div tbody").prepend(htms);

		$("#incrmt_val").val(incrmt_val);
	});

	$(".input-group-close a").live('click',function(){
		//alert(this.id);
		$("."+this.id).remove();
		return false;
	});

});
var invajax = 0;
/* Add category Form */
function addform(){
	var html = '<label>Add Sub of Sub category</label><br /><input name="categoryname_2" id="Category_names" class="inputform" type="text" />';
	$("#forms").html(html);
	$('.deletfrm').show();
	$(".show_hid").hide();

}

function cat_img(id){

	if(id != ''){
	$.ajax({
	      url: BaseURL+"admin/add/category_image",
	      type: "post",
	      data : { 'catid': id},
	      dataType: "html",
	      success: function(response){ //alert(response);
	         if(response != ''){ //alert(response);
	         	$('#divview1').show();
	        	// $("#forms1").show();
	         	$("#forms").css('display','none');
	        	$("#divview1 #image_computer_100").val(response);
	        	$("#divview1 #show_url_100").attr('src',BaseURL+'media/items/thumb150/'+response);
	        	//$("#removeimg_100").show();
	        	 //$("#input_value").val('Change Photo');
	         } else {
	        	$("#divview1").hide();
	        	$("#forms").css('display','block')
	         }
			//$("#del_"+Id).remove();

			}

		});
	}
}

function removeimg(val){
	$('#image_computer_'+val).val('');
	$('#show_url_'+val).attr({src: "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"});
	$('#removeimg_'+val).hide();
	$('#frame_'+val).show();
}

function removeDynamicimgbefore(imgno){
	window.frames[0].stop();
	$('#frame_12').contents().find(".file-holder1").show();
	removeDynamicimg(imgno);
}
function removeDynamicimg(imgno){
	var selector = "#image_"+imgno;
	$(selector).remove();
	var img = $('#imageCount').val();
	$('#imageCount').val(img - 1);
}
function Price_range(){
	//alert('hai');
	$('.adminitemerror').html('');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	var price1 = $("#inputform1").val();
	var price2 = $("#inputform2").val();
	if($.trim(price1)=="")
	{
		$("#priceerr").show();
		$("#priceerr").removeAttr("data-trn-key");
		$("#priceerr").html("Enter price range from");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if($.trim(price2)=="")
	{
		$("#priceerr").show();
		$("#priceerr").removeAttr("data-trn-key");
		$("#priceerr").html("Enter price range to");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if(parseInt(price1) > parseInt(price2) || price1 == price2 || price1<=0 || price2<=0){
		$("#priceerr").show();
		$("#priceerr").removeAttr("data-trn-key");
		$("#priceerr").html("Give correct range");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if (isNaN(price1) || isNaN(price2)){
$("#priceerr").show();
$("#priceerr").removeAttr("data-trn-key");
		$("#priceerr").html("Give valid price");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
}

	else
		{
			$("#priceerr").html("");
			$("#priceerr").hide();
		return true;
		}
}

function editPrice_range(){
	//alert('hai');
	$('.adminitemerror').html('');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	var price1 = $(".inputform1").val();
	var price2 = $(".inputform2").val();
	if($.trim(price1)=="")
	{
		$("#priceerr").show();
		$("#priceerr").removeAttr("data-trn-key");
		$("#priceerr").html("Enter price range from");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if($.trim(price2)=="")
	{
		$("#priceerr").show();
		$("#priceerr").removeAttr("data-trn-key");
		$("#priceerr").html("Enter price range to");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if(parseInt(price1) > parseInt(price2) || price1==price2 || price1<=0 || price2<=0){
		$("#priceerr").show();
		$("#priceerr").removeAttr("data-trn-key");
		$("#priceerr").html("Give correct range");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
		{$("#priceerr").html("");
		$.ajax({
		      url: BaseURL+"admins/editprice/"+price1+"/"+price2,
		      type: "post",
		      dataType: "html",
		      success: function(){

				//$("#del_"+Id).remove();

				}

			});
		}
}

function commisionRange(){
	//alert('hai');
	$('.adminitemerror').html('');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	var price1 = $('#minrange').val();
	var price2 = $('#maxrange').val();
	var amount = $('#commission').val();
	var commtype = $("#commission_type").val();
	var commdetails = $("#commissionDetails").val();
	if (price1 == '' || price2 == ''){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Price range cannot be empty");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if (isNaN(price1) || isNaN(price2)){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Price range must be valid number");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(parseInt(price1) > parseInt(price2) || price1==price2 || price1<=0 || price2<=0){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give correct price range");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(price1.length>6 || price2.length>6){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give valid price range");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(amount == ''){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Commission amount cannot be empty");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}else if(amount >= 100 && commtype=="%"){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission percentage below 100");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
	else if(amount<=0)
	{
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission amount above 0");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(isNaN(amount))
{
$("#commerr").show();
$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission amount as number");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
}

	else if(amount > parseInt(price1) && commtype=="$"){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission amount below minrange");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
	else if(commdetails.length > 30){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Commission details should not exceed 30 characters");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
   else if(isCommissionAvailable(price1,price2,amount) >= 1)
   {
     	$("#commerr").show();
     	$("#commerr").removeAttr("data-trn-key");
		$('#commerr').text('Commission details already exists. Change price range and commission amount.');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#commerr').fadeOut('slow');
		}, 5000);
		return false;
   }
	else{
		$("#commerr").html("");
		return true;
	}
}

function editcommisionRange(commid){
	//alert('hai');
	$('.adminitemerror').html('');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	var price1 = $('#minrange').val();
	var price2 = $('#maxrange').val();
	var amount = $('#commission').val();
	var commtype = $("#commission_type").val();
	var commdetails = $("#commissionDetails").val();
	if (price1 == '' || price2 == ''){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Price range cannot be empty");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if (isNaN(price1) || isNaN(price2)){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Price range must be valid number");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(parseInt(price1) > parseInt(price2) || price1==price2 || price1<=0 || price2<=0){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give correct price range");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(price1.length>6 || price2.length>6){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give valid price range");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(amount == ''){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Commission amount cannot be empty");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}else if(amount >= 100 && commtype=="%"){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission percentage below 100");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
	else if(amount<=0)
	{
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission amount above 0");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
else if(isNaN(amount))
{
$("#commerr").show();
$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission amount as number");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
}

	else if(amount > parseInt(price1) && commtype=="$"){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Give commission amount below minrange");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
	else if(commdetails.length > 30){
		$("#commerr").show();
		$("#commerr").removeAttr("data-trn-key");
		$("#commerr").html("Commission details should not exceed 30 characters");
		translator.lang(sessionlang);
		setTimeout(function() {
			$('#commerr').fadeOut('slow');
		      }, 5000);
		return false;
	}
   else if(isEditCommissionAvailable(price1,price2,amount,commid) >= 1)
   {
     	$("#commerr").show();
     	$("#commerr").removeAttr("data-trn-key");
		$('#commerr').text('Commission details already exists. Change price range and commission amount.');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#commerr').fadeOut('slow');
		}, 5000);
		return false;
   }
	else{
		$("#commerr").html("");
		return true;
	}
}


function rlyadmsg(){

	var message=$('#message').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	if(message == ''){
		$("#doalert").show();
		$("#message").focus();
		$('#doalert').removeAttr('data-trn-key');
		$('#doalert').text('Enter the subject');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#doalert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(!isNaN(message)){
		$("#doalert").show();
		$("#message").focus();
		$('#doalert').removeAttr('data-trn-key');
		$('#doalert').text('Enter only characters for the subject');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#doalert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(message.length < 6){
		$("#doalert").show();
		$("#message").focus();
		$('#doalert').removeAttr('data-trn-key');
		$('#doalert').text('Subject should be atleast 6 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#doalert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(message.length > 30){
		$("#doalert").show();
		$("#message").focus();
		$('#doalert').removeAttr('data-trn-key');
		$('#doalert').text('Subject should not exceed 30 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#doalert').fadeOut('slow');
			}, 5000);
		return false;
	}
	$('#doalert').text('');
}

function validate(){
	$('.adminitemerror').html('');
	$('.form-error').html('');
	var img0  = $("#image_computer_0").val();
	var img1  = $("#image_computer_1").val();
	var img2  = $("#image_computer_2").val();
	var img3  = $("#image_computer_3").val();
	var skuid = $("#skuid").val();

	var imagecon = $("#imageCount").val();
	var delimgcon = $("#delimageCount").val();
	imgval = delimgcon - 1;
	imgname = $("#image_computer_"+imgval).val();
	var color_method = $("#detectmethod").val();
	var prmry_val  = $(".primary-shipping-price input").val();
	var check = 0;
	if($('#cate_id').val() == '') {
		$('.cat-error').html('Select Category');
		check = 1;
	}
	if($('#categ-selectbx-2').val() == '') {
		$('.subcat-error').html('Select Sub Category');
		check = 1;
	}
	if(imagecon==0 || imgname==""){
		$("#alert").show();
		$('#alert').text('Please add atleast one photo.');

		return false;
	}
	if($.trim($('.itemtitle').val()) == '') {
		$('.title-error').html('Item Title cannot be empty');
		check = 1;
	}
	if($.trim($('.itemtitle').val())<3) {
		$('.title-error').html('Item Title must be atleast 3 characters');
		check = 1;
	}
	if ($.trim(skuid)=='') {
		$("#skuiderr").show();
		$("#skuid").val("");
		$("#skuiderr").text("Please enter sku value");
		$("#skuid").keydown(function(){
			$("#skuiderr").hide();
		});
		check = 1;
	}
	if(color_method=='')
	{
		$('.color-error').html('Please select method for choosing color');
		check = 1;
	}
	if(color_method=='manual')
	{
		item_manual_color = $("#item_color_manual").val();
		if(item_manual_color==null)
		{
			$('.color-error').html('Please select colors');
			check = 1;
		}
	}
	if($.trim($('#description').val()) == '') {
		$('.description-error').html('Description cannot be empty');
		check = 1;
	}
	if($.trim($('#description').val())<10) {
		$('.description-error').html('Description must be atleast 10 characters');
		check = 1;
	}
	if($.trim($('#price').val()) == '') {
		$('.price-error').html('Item Price cannnot be empty');
		check = 1;
	}
	if($.trim($('#quantity').val()) == '') {
		$('.qty-error').html('Item Quantity cannnot be empty');
		check = 1;
	}
	if($('#processing-time-id').val() == '') {
		$('.proc-error').html('Select Processing Time');
		check = 1;
	}
	if($('#selct_lctn_bxs').val() == '') {
		$('.shipfrom-error').html('Select atleast one Ships from location');
		check = 1;
	}
	if(img0 == '' && img1 == '' && img2 == '' && img3 == ''){
		$('.photo-error').html('Please add atleast one photo');
		check = 1;
	}
	if($.trim(prmry_val) == ''){
		$('.ship-error').html('Please enter a shipping cost for at least one country or region');
		check = 1;
	}
	if (check == 1) {
		$('.form-error').html("please fill all the details");
		return false;
	}
	return true;
}
$(document).ready(function(){
	$("#skuid").blur(function(){
	var skuid = $("#skuid").val();
	var itemid = $("#itemid").val();
	var BaseURL=getBaseURL();
	if($.trim(skuid) != ""){
		$.ajax({
			type: "POST",
			url: BaseURL+'checkskuid',
			data: {"skuid":skuid,'itemid':itemid},

			/*beforeSend: function() {
			$(".submitbtn").attr("disabled", "disabled");
			},*/

			success: function(responce) {
				if($.trim(responce) == "exists"){
				$("#skuiderr").show();
				$("#skuid").val("");
				$("#skuiderr").text("SKU already exists");
				$("#skuid").keydown(function(){
					$("#skuiderr").hide();
				});
				return false;
				} else {
				return true;
				}
			}

			});
		}
	});
});

function paypalactive(){
    var normalid = $("#PaypalmodePaypalnormal");
    var normal = (normalid.attr("checked") != "undefined" && normalid.attr("checked") == "checked");
    if (normal) {
    	$("#paypal_api_userid").attr("disabled",true);
    	$("#paypal_api_password").prop('disabled', true);
    	$("#paypal_api_signature").prop('disabled', true);
    	$("#paypal_application_id").prop('disabled', true);
    }else {
    	$("#paypal_api_userid").removeAttr("disabled");
    	$("#paypal_api_password").prop('disabled', false);
    	$("#paypal_api_signature").removeAttr("disabled", "disabled");
    	$("#paypal_application_id").removeAttr("disabled", "disabled");
    }
}

function addformss(){
	var sub_cat_names = $("#Category_names").val();
	var html = '<label>Add Sub of Sub category</label><br /><input name="categoryname_2" value="'+sub_cat_names+'" id="Category_names" class="inputform" type="text" />';
	$("#forms").html(html);
	$('.deletfrm').show();
	$(".show_hid").hide();

}

/* Delete category Form */
function deleteform(){
	$("#forms").html('');

	$('.deletfrm').hide();

	var mainsel = $("#mainsec").val();
	if(mainsel == ''){
		$(".show_hid").hide();
	}else{
		$(".show_hid").show();
	}
}


/* user and user corressponding details delete  */
function deleteusrlists(uid,usrstatus){
	$baseurl = getBaseURL();

           switch(usrstatus)
			{
				case 'approveduser':
				  redirectlink =  $baseurl+"manageuser";
				  break;
				case 'nonapproveduser':
				  redirectlink =  $baseurl+"nonapproveduser";
				  break;
				case 'inactiveuser':
				  redirectlink =  $baseurl+"inactiveuser";
				  break;
				case 'approvedmoderator':
				  redirectlink =  $baseurl+"managemoderator";
				  break;
				case 'nonapprovedmoderator':
				  redirectlink =  $baseurl+"nonapprovedmoderator";
				  break;
				default:
				  redirectlink =  $baseurl;
				  break;
			}

	if (confirm("Are you sure you want to delete this User? ")) {

	$.ajax({
      url: $baseurl+"deleteuser/"+uid,
      type: "post",
      dataType: "html",
      success: function(){

		$("#del_"+uid).remove();
window.location.href = redirectlink;
      },
    });

	}
	return false;
}
/* Dispute Delete*/
function deletedisp(did){

	$baseurl = getBaseURL();

if(confirm("Are you sure want to delete this dispute?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/deletedisp/"+did,
      type: "post",
      dataType: "html",
      success: function(){

          $("#scatgys"+did).remove();

      },
    });
	}

	return false;
}





function deletecommision(Id) {
	$baseurl = getBaseURL();
	//$eleid = "#curr"+Id;

	if(confirm("Are you sure want to delete this commission?")) {
	$.ajax({
      url: $baseurl+"deletecommission/"+Id,
      type: "post",
      dataType: "html",
      success: function(){

		$("#del_"+Id).remove();
		$("#alertmsg").html("Commission details deleted successfully");
      },
    });
	}
}

/* banner delete */
function bannerdelete(id){
	// alert(id);

	if (confirm("Are you sure you want to delete this banner? ")) {
		$.post(BaseURL+'bannerdeletes', { "id": id},
			function(data) {
alert('deleted'); die;
				$("#del_"+id).remove();

			}
		);

	}
	return false;
}


function pricedelete(id){
	$baseurl = getBaseURL();

if(confirm("Are you sure want to delete this Price?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/deleteprice/"+id,
      type: "post",
      dataType: "html",
      success: function(){
          //$("#del_"+id).remove();
           var managepricetable = $('#managepricetable').DataTable();
          managepricetable.row($('#del_' + id)).remove().draw();

      },
    });
	}

	return false;
}

function deletecolor(id){
	$baseurl = getBaseURL();

if(confirm("Are you sure want to delete this Color?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/deletecolor/"+id,
      type: "post",
      dataType: "html",
      success: function(){
          //$("#del_"+id).remove();
           var managecolorstable = $('#managecolorstable').DataTable();
          managecolorstable.row($('#del_' + id)).remove().draw();

      },
    });
	}

	return false;
}

function deletecoupon(id){
var BaseURL=getBaseURL();
	//alert(id);
	if (confirm("Are you sure you want to delete this Coupon? ")) {
		$.post(BaseURL+'admins/admins/deletecoupon', { "id": id},
			function(data) {
				$("#del_"+id).remove();

			}
		);

	}
	return false;
}

/* News delete */
function newsdelete(id){
	// alert(id);
	if (confirm("Are you sure you want to delete this News? ")) {
		$.post(BaseURL+'newsdeletes', { "id": id},
			function(data) {
				$("#del_"+id).remove();

			}
		);

	}
	return false;
}

/* front end js */


function signform(){
	var data = $('#signupform').serialize();
	var firstname=$('#firstname').val();
	var lastname=$('#lastname').val();
	var email=$('#email').val();
	var signupGender = $('.genderradio:checked').val();
	var city=$('#regcity').val();
	var signupDay=$('#signupDobDay').val();
	var signupMonth=$('#signupDobMonth').val();
	var signupYear=$('#signupDobYear').val();
	var password=$('#password').val();
	var rpassword=$('#rpassword').val();
	// alert(signupGender);
	if(firstname == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor digitar primeiro nome');
		$("#alert").append(newdiv);
		return false;
	}
	if(lastname == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor digitar ultimo nome');
		$("#alert").append(newdiv);
		return false;
	}
	if(email == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor digitar e-mail');
		$("#alert").append(newdiv);
		return false;
	}
	if(!(isValidEmailAddress(email))){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Digite um e-mail válido');
		$("#alert").append(newdiv);
		return false;
	}
	if(!signupGender){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor selecionar o sexo');
		$("#alert").append(newdiv);
		return false;
	}
	if(city == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor digitar o cidade');
		$("#alert").append(newdiv);
		return false;
	}
	if(signupDay == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor escolher o dia');
		$("#alert").append(newdiv);
		return false;
	}
	if(signupMonth == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor escolher o mês');
		$("#alert").append(newdiv);
		return false;
	}
	if(signupYear == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor escolher o ano');
		$("#alert").append(newdiv);
		return false;
	}
	if(password == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Favor digitar sua senha');
		$("#alert").append(newdiv);
		return false;
	}
	if(password.length < 6){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Senha deve ter mais que 5 caracteres.');
		$("#alert").append(newdiv);
		return false;
	}
	if(rpassword == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Confirmação da senha não pode estar vazia!');
		$("#alert").append(newdiv);
		return false;
	}
	if(password != rpassword){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Senha e confirmação de senha não estão iguais!');
		$("#alert").append(newdiv);
		return false;
	}
	// $('.popupContact2').hide();
	//$(".app_event").css({"opacity" : "0.4"})
      //                  .fadeIn("slow");
	$('#signupform').submit();

}

function giftcard(){
	var gifttitle=$('#gift_title').val();
	var giftdesc=$('#gift_desc').val();
	var giftimage=$('#input-file-now-custom-1').val();
	var tagsAmt=$('#tags_Amt').val();
	var isImage=/(?:gif|jpg|jpeg|png|bmp|ico)$/;
	var numExp = /^[0-9.,]+$/;
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	if($.trim(gifttitle) == ''){
		$("#alert").show();
		$("#gift_title").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Enter the title');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(gifttitle).length < 3){
		$("#alert").show();
		$("#gift_title").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Title should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(gifttitle).length > 30){
		$("#alert").show();
		$("#gift_title").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Title should not exceed 30 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(giftdesc) == ''){
		$("#alert").show();
		$("#gift_desc").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Enter the description');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(giftdesc).length < 10){
		$("#alert").show();
		$("#gift_desc").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Description should be atleast 10 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(giftdesc).length > 500){
		$("#alert").show();
		$("#gift_desc").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Description should not exceed 500 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($('#giftimagewrap .dropify-preview').css('display') == 'none')
	{
		$("#alert").show();
		$("#input-file-now-custom-1").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Upload the image');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
	{
	 if($.trim(giftimage) != ''){
		if (!giftimage.match(isImage)) {
    	$("#alert").show();
		$("#input-file-now-custom-1").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Image file only allowed');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
     }
	}
   }
   	if($.trim(tagsAmt) == ''){
		$("#alert").show();
		$("#tags_Amt").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Enter the tags amount');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(!$.trim(tagsAmt).match(numExp)){
		$("#alert").show();
		$("#tags_Amt").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Please enter numbers only');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	$('#alert').html('');
}


function contactaddress(){
    var data = $('#contactaddress').serialize();
	var emailid=$('#emailid').val();
	var mobno=$('#mobno').val();
	var cntaddress=$('#cntaddress').val();
	var numExp = /^[0-9-+]+$/;
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
     if($.trim(emailid) == ''){
		$("#alert").show();
		$("#emailid").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Enter the e-mail');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

	if(!(isValidEmailAddress(emailid))){
		$("#alert").show();
		$("#emailid").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Enter the valid e-mail');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

    if($.trim(mobno) == ''){
		$("#alert").show();
		$("#mobno").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Enter the phone number');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

    if(!$.trim(mobno).match(numExp)){
		$("#alert").show();
		$("#mobno").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Please enter numbers only');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

   if($.trim(cntaddress) == ''){
		$("#alert").show();
		$("#cntaddress").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Please enter the contact address');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(cntaddress).length < 10){
		$("#alert").show();
		$("#cntaddress").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Contact address should be atleast 10 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(cntaddress).length > 100){
		$("#alert").show();
		$("#cntaddress").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Contact address should not exceed 100 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	$('#alert').html('');
}

function addcategoryform(){
	var data = $('#Categoryform').serialize();
	var maincatname=$('#mainsec').val();
	var categoryname=$('#categoryname').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	var image = $('#image_computer_0').val();
	var cat = $('#mainsec').val();
/*
if(maincatname == ''){
		$("#alert").show();
		$("#mainsec").focus();
		$('#alert').text('Select Main Category');
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
*/

   if($.trim(categoryname) == ''){
		$("#alert").show();
		$("#categoryname").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Please enter the category name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(categoryname).length < 3){
		$("#alert").show();
		$("#categoryname").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(categoryname).length > 25){
		$("#alert").show();
		$("#categoryname").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name should not exceed 25 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
  if(isCategoryNameAvailable(categoryname,cat) >= 1)
   {
     	$("#alert").show();
		$("#categoryname").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name already exists');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#alert').fadeOut('slow');
		}, 5000);
		return false;
   }
   if(cat==0){
   if (image == ''){
		$('.sliderimageerror').show();
		$('.sliderimageerror').html('Select a Image').css("color", "red");
		translator.lang(sessionlang);
				setTimeout(function() {
					  $('.sliderimageerror').fadeOut('slow');
					}, 5000);
		return false;
	}
}
   $('#alert').html('');
	//$('#adduserform1').submit();
}


function editcategoryform(){

	var data = $('#EditCategoryform').serialize();
	var maincatname=$('#mainsec').val();
	var categoryname=$('#category_name').val();
	var categoryname2=$('#Category_names').val();
	var catid=$('#secid').val();
	var subcatid=$('#subparid').val();
	var image = $('#image_computer_0').val();

	if(subcatid == 0)
	{
		subcatid = catid;
	}
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

/* if(maincatname == ''){
		$("#alert").show();
		$("#mainsec").focus();
		$('#alert').text('Select Main Category');
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
*/
	if($.trim(categoryname) == ''){
		$("#alert").show();
		$("#category_name").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Please enter the category name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(categoryname).length < 3){
		$("#alert").show();
		$("#category_name").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(categoryname).length > 25){
		$("#alert").show();
		$("#category_name").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name should not exceed 25 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if (image == ''){
		$('.sliderimageerror').show();
		$('.sliderimageerror').html('Select a Image').css("color", "red");
		translator.lang(sessionlang);
				setTimeout(function() {
					  $('.sliderimageerror').fadeOut('slow');
					}, 5000);
		return false;
	}
  if(isEditCategoryNameAvailable(subcatid,categoryname,maincatname) >= 1)
   {
     	$("#alert").show();
		$("#category_name").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name already exists');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#alert').fadeOut('slow');
		}, 5000);
		return false;
   }

   if(!$('#Category_names').is(':hidden')) {


	if($.trim(categoryname2) == '' ){
		$("#alert").show();
		$("#Category_names").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Please enter the category name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(categoryname2).length < 3){
		$("#alert").show();
		$("#Category_names").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(categoryname2).length > 25){
		$("#alert").show();
		$("#Category_names").focus();
		$('#alert').removeAttr('data-trn-key');
		$('#alert').text('Category name should not exceed 25 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

	   if(isEditCategoryNameAvailable(catid,categoryname2,maincatname) >= 1)
	   {
	     	$("#alert").show();
			$("#Category_names").focus();
			$('#alert').removeAttr('data-trn-key');
			$('#alert').text('Category 2 name already exists');
			translator.lang(sessionlang);
			setTimeout(function() {
			$('#alert').fadeOut('slow');
			}, 5000);
			return false;
	   }
	   if($.trim(categoryname) == $.trim(categoryname2))
	   {
	      	$("#alert").show();
			$("#Category_names").focus();
			$('#alert').removeAttr('data-trn-key');
			$('#alert').text('Category name cannot be the same as sub category name');
			translator.lang(sessionlang);
			setTimeout(function() {
			$('#alert').fadeOut('slow');
			}, 5000);
			return false;
	   }
	}
	$('#alert').html('');
	//$('#adduserform1').submit();
}

function addlanguageform(){
	var data = $('#languageform').serialize();
	var countryname=$('#countryname').val();
	var countrycode=$('#countrycode').val();
	var languagecode=$('#languagecodes').val();
	var languagename=$('#languagename').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

var alphaExp = /^[a-zA-Z]+$/;
var alphaNumExp = /^[0-9a-zA-Z]+$/;

if(countryname == ''){
		$("#langerr").show();
		$("#countryname").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Select Country');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}

if(isCountryAvailable(countryname) >= 1)
   {
     	$("#langerr").show();
		$("#countryname").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Country name already added');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#langerr').fadeOut('slow');
		}, 5000);
		return false;
   }

if(countrycode == ''){
		$("#langerr").show();
		$("#countrycode").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Select Currency code');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(languagecode) == ''){
		$("#langerr").show();
		$("#languagecode").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Enter the language code');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(languagecode).length < 2){
		$("#langerr").show();
		$("#languagecode").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Language code should be atleast 2 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(languagecode).length > 6){
		$("#langerr").show();
		$("#languagecode").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Language code should not exceed 6 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
   if(!$.trim(languagecode).match(alphaExp)){
		$("#langerr").show();
		$("#languagecode").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Enter alpabets for langauge code');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}

	if($.trim(languagename) == ''){
		$("#langerr").show();
		$("#languagename").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Enter the langauge name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(languagename).length < 3){
		$("#langerr").show();
		$("#languagename").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Langauge Name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(languagename).length > 15){
		$("#langerr").show();
		$("#languagename").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Langauge Name should not exceed 15 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
  if(!$.trim(languagename).match(alphaExp)){
		$("#langerr").show();
		$("#languagename").focus();
		$('#langerr').removeAttr('data-trn-key');
		$('#langerr').text('Enter alpabets for langauge name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#langerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	//$('#adduserform1').submit();
	$('#langerr').html('');
}


function adduserform(){
	var data = $('#adduserform1').serialize();
	var firstname=$('#firstname').val();
	var username=$('#username').val();
	var usr_access=$('#usr_access').val();
	var email=$('#email').val();
	var password=$('#password').val();
	var rpassword=$('#rpassword').val();
	var user_level = $("#usr_access").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
var alphaExp = /^[a-zA-Z]+$/;
var alphaNumExp = /^[0-9a-zA-Z]+$/;

	if($.trim(firstname) == ''){
		$("#alert").show();
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$("#firstname").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Enter the full name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(firstname).length < 3){
		$("#alert").show();
		$("#firstname").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(firstname).length > 30){
		$("#alert").show();
		$("#firstname").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Name should not exceed 30 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
if(!$.trim(firstname).match(alphaExp)){

		$("#alert").show();
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$("#firstname").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Enter the valid name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}


	if($.trim(username) == ''){
		$("#alert").show();
		$("#username").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the user name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(username).length < 3){
		$("#alert").show();
		$("#username").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('User Name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(username).length > 30){
		$("#alert").show();
		$("#username").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('User Name should not exceed 30 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
if(!$.trim(username).match(alphaNumExp)){

		$("#alert").show();
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$("#firstname").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Enter the valid User name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

	if(isUserNameAvailable(username) >= 1)
   {
     	$("#alert").show();
		$("#username").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('User Name already exists');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#alert').fadeOut('slow');
		}, 5000);
		return false;
   }

	if(email == ''){
		$("#alert").show();
		$("#email").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the e-mail');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(user_level == 'moderator'){
		valu = new Array();
		j = 0;
		$("[name='chkbox']").each(function(){
		checkd = $(this).attr("checked");
		if(checkd=="checked")
		{
			valu[j] = $(this).val();
			j++;
		}
		});
		/*if(valu=="")
		{
			$("#alert").show();
			var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
			$('#alert').text('Choose the menu lists');
			$("#alert").append(newdiv);
			return false;
		}*/
	}
	if(!(isValidEmailAddress(email))){
		$("#alert").show();
		$("#email").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the valid e-mail');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

   if(isEmailIdAvailable(email) >= 1)
   {
     	$("#alert").show();
		$("#email").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Email id already exists');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#alert').fadeOut('slow');
		}, 5000);
		return false;
   }

	if(password == ''){
		$("#alert").show();
		$("#password").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the password');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(password.length < 6){
		$("#alert").show();
		$("#password").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Password should be atleast 6 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(password.length > 12){
		$("#alert").show();
		$("#password").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Password should not exceed 12 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(rpassword == ''){
		$("#alert").show();
		$("#rpassword").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the Confirm password');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(password != rpassword){
		$("#alert").show();
		$("#rpassword").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Password does not match');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

if(usr_access == ''){
		$("#alert").show();
		$("#usr_access").focus();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Select user type');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	menulist = $("#menulist").val();
	if(user_level=="moderator")
	{
		if(menulist=="")
		{
			if(confirm("Are you sure want to create moderator without restriction"))
			{
				return true;
			}
			else
				return false;
		}
	}
	$("#alert").html("");
	//$('#adduserform1').submit();

}

function edituserform(){
	var data = $('#adduserform1').serialize();
	var userid=$('#userid').val();
	var firstname=$('#firstname').val();
	var username=$('#username').val();
	var usr_access=$('#usr_access').val();
	var email=$('#email').val();
	var password=$('#password').val();
	var rpassword=$('#rpassword').val();
	var user_level = $("#usr_access").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	//alert(firstname);
	if($.trim(firstname) == ''){
		$("#alert").show();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the full name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(firstname).length < 3){
		$("#alert").show();
		$("#firstname").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(username) == ''){
		$("#alert").show();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the user name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

	if(email == ''){
		$("#alert").show();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the e-mail');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(user_level == 'moderator'){
		valu = new Array();
		j = 0;
		$("[name='chkbox']").each(function(){
		checkd = $(this).attr("checked");
		if(checkd=="checked")
		{
			valu[j] = $(this).val();
			j++;
		}
		});
		/*if(valu=="")
		{
			$("#alert").show();
			var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
			$('#alert').text('Choose the menu lists');
			$("#alert").append(newdiv);
			return false;
		}*/
	}
	if(!(isValidEmailAddress(email))){
		$("#alert").show();
		$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the valid e-mail');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		return false;
	}

	if(isUserEmailIdAvailable(userid,email) >= 1)
   {
     	$("#alert").show();
		$("#email").focus();
		$("#alert").removeAttr('data-trn-key');
		$('#alert').text('Email id already exists');
		translator.lang(sessionlang);
		setTimeout(function() {
		$('#alert').fadeOut('slow');
		}, 5000);
		return false;
   }
 /*  else
   {
   	return true;
   }*/
	/*if(password == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the password');
		$("#alert").append(newdiv);
		return false;
	}
	if(password.length < 6){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Password Should be atleast 6 characters');
		$("#alert").append(newdiv);
		return false;
	}
	if(rpassword == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the Confirm password');
		$("#alert").append(newdiv);
		return false;
	}
	if(password != rpassword){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Password does not match');
		$("#alert").append(newdiv);
		return false;
	}*/
	//$('#adduserform1').submit();
$("#alert").html("");
}


function chngeadmindet(){
	var data = $('#adduserform1').serialize();
	var firstname=$('#firstname').val();
	var username=$('#username').val();
	var lastname=$('#lastname').val();
	var email=$('#email').val();
	var password=$('#password').val();
	var rpassword=$('#rpassword').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	//alert(firstname);
	if(firstname == ''){
		$("#alert").show();
		$('#alert').removeAttr('data-trn-key');
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the first name');
		translator.lang(sessionlang);
			setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		$("#alert").val("");
		$("#alert").focus();
		//$("#alert").append(newdiv);
		return false;
	}
	if(lastname == ''){
		$("#alert").show();
		$('#alert').removeAttr('data-trn-key');
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the last name');
		translator.lang(sessionlang);
			translator.lang(sessionlang);
			setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		$("#alert").val("");
		$("#alert").focus();
		return false;
	}
	if(username == ''){
		$("#alert").show();
		$('#alert').removeAttr('data-trn-key');
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the user name');
		translator.lang(sessionlang);
		translator.lang(sessionlang);
			setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		$("#alert").val("");
		$("#alert").focus();
		return false;
	}
	if(email == ''){
		$("#alert").show();
		$('#alert').removeAttr('data-trn-key');
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the e-mail');
		translator.lang(sessionlang);
		translator.lang(sessionlang);
			setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		$("#alert").val("");
		$("#alert").focus();
		return false;
	}
	if(!(isValidEmailAddress(email))){
		$("#alert").show();
		$('#alert').removeAttr('data-trn-key');
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the valid e-mail');
		translator.lang(sessionlang);
			translator.lang(sessionlang);
			setTimeout(function() {
			  $('#alert').fadeOut('slow');
			}, 5000);
		$("#alert").val("");
		$("#alert").focus();
		return false;
	}
	/*if(password == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the password');
		$("#alert").append(newdiv);
		return false;
	}
	if(password.length < 6){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Password Should be atleast 5 characters');
		$("#alert").append(newdiv);
		return false;
	}
	if(rpassword == ''){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Enter the Confirm password');
		$("#alert").append(newdiv);
		return false;
	}
	if(password != rpassword){
		$("#alert").show();
		var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('#alert').text('Password does not match');
		$("#alert").append(newdiv);
		return false;
	}*/
	$('#alert').html("");
	$('#adduserform1').submit();

}


function confirmExit()
{
	if (needToConfirm){
		return "If you have made any changes to the fields without clicking the Save button, your changes will be lost. Are you sure you want to exit this page?";
	}else{
		window.location = BaseURL+"fact-finds";
	}
}

function isValidEmailAddress(email) {
	var emailreg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return emailreg.test(email);
}

function getBaseURL(){
	var url = location.href;
	var baseURL = url.substring(0, url.indexOf('/', 14));
	if (baseURL.indexOf('http://localhost') != -1) {
		var url = location.href;
		var pathname = location.pathname;
		var index1 = url.indexOf(pathname);
		var index2 = url.indexOf("/", index1 + 1);
		var baseLocalUrl = url.substr(0, index2);
		return baseLocalUrl + "/";
	} else {

		return baseURL + "/fantacy5.0/fantacy/";
	}

}

function isCommissionAvailable(minval,maxval,commamount)
{
   var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchcommission/"+minval+"/"+maxval+"/"+commamount,
			dataType: "html",
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}

function isEditCommissionAvailable(minval,maxval,commamount,commid)
{
   var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searcheditcommission/"+minval+"/"+maxval+"/"+commamount+"/"+commid,
			dataType: "html",
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}

function isEditCategoryNameAvailable(catid,categoryname,cat)
{
	var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchregisteredcategory/"+catid+"/"+categoryname,
			dataType: "html",
			data:{'cat' : cat},
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}

function isCategoryNameAvailable(categoryname,cat)
{
	var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchcategoryname/"+categoryname,
			dataType: "html",
			data:{'cat' : cat},
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}

function isCountryAvailable(countryname)
{
	var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchcountryname/"+countryname,
			dataType: "html",
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}

function isEmailIdAvailable(email)
{
	var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchregisteredemail/"+email,
			dataType: "html",
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}

function isUserNameAvailable(username)
{
	var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchregisteredusername/"+username,
			dataType: "html",
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}

function isUserEmailIdAvailable(userid,email)
{
	var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchuserregisteredemail/"+userid+"/"+email,
			dataType: "html",
			async:false,
			success: function(response) {
				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}


function userActive(email)
{

	var BaseURL=getBaseURL();
	$.ajax({
			type: "post",
			url: BaseURL+"admins/admins/searchactiveuser/"+email,
			dataType: "html",
			async:false,
			success: function(response) {

				result = response;
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return result;
}
function search_moderator(){
var BaseURL=getBaseURL();
	 var value1 = $('#usersrchSrch').val();
	 if(value1.length>2 || value1.length == 0){
		 $.ajax({
			type: "post",		// Request method: post, get
			url: BaseURL+"admins/admins/searchmoderator/"+value1,	// URL to request
			dataType: "html",	// Expected response type
			success: function(response, status) {
				$('#userdata').html(response);

			},
		});
	 }

		return false;

}

function search_nonmoderator(){
var BaseURL=getBaseURL();
	 var value1 = $('#usersrchSrch').val();
	 if(value1.length>2 || value1.length == 0){
		 $.ajax({
			type: "post",		// Request method: post, get
			url: BaseURL+"admins/admins/searchnonapprovedmoderator/"+value1,	// URL to request
			dataType: "html",	// Expected response type
			success: function(response, status) {
				$('#userdata').html(response);

			},
		});
	 }

		return false;

}
function search_user_func(){
var BaseURL=getBaseURL();
	 var value1 = $('#nonusersrchSrch').val();

	 if(value1.length>2 || value1.length == 0){
		 $.ajax({
			type: "post",		// Request method: post, get
			url: BaseURL+"/admins/admins/searchnonapproveduser/"+value1,	// URL to request
			dataType: "html",	// Expected response type
			success: function(response, status) {

				$('#userdata').html(response);

			},
error:	function()
{
alert('error');}
		});
	 }

		return false;

}

function inactive_search_func(){
var BaseURL=getBaseURL();
	 var value1 = $('#usersrchSrch').val();

	 var timeperiod = $('.inactivedays').val();
	 if(value1.length > 2 || value1.length == 0 || timeperiod != oldperiod){
		 oldperiod = timeperiod;
		 $.ajax({
			type: "post",		// Request method: post, get
			url: BaseURL+"/admins/admins/searchinactiveuser/"+timeperiod+"/"+value1,	// URL to request

			dataType: "html",	// Expected response type
			success: function(response, status) {

				$('#userdata').html(response);

			},
			error:	function()
{
alert('error');},
		});
	 }

		return false;

}
function deleteinactiveusers(){
	var BaseURL=getBaseURL();

	 if($('.inactivecnt').val() > 0 && confirm("Are you sure want to delete "+$('.inactivecnt').val()+" user(s) ?")){



		 window.location = BaseURL+"deleteinactiveuser/";
	 }
}
function deleteinactiveselected() {
var BaseURL=getBaseURL();
	var names = [];
	$('input:checkbox.inactiveuser').each(function () {
		var sThisVal = (this.checked ? $(this).val() : "");
		if (sThisVal != ""){
			names.push(sThisVal);
		}
	});
	if(names=="")
	{
			$("#delerr").show();
			setTimeout(function() {
				  $('#delerr').fadeOut('slow');
				}, 5000);
	}
	else
	{
		if (names.length > 0 && confirm("Are you sure want to delete "+names.length+" user(s) ?")){

			$.ajax({
				type: "post",		// Request method: post, get
				url: BaseURL+"deleteinactiveuser/",	// URL to request
				data:{'selectedusers':names},
				dataType: "html",	// Expected response type

				success: function(response) {

					window.location = BaseURL+"inactiveuser/";
				},

			});
		}
		console.log(names);
	}
}
function changeItemStatus(itemId,state){
	$baseurl = getBaseURL();
	$eleid = "#status"+itemId;
	$rowid = "#item"+itemId;

		$.ajax({
	      url: $baseurl+"admins/admins/changeitemstatus/"+itemId+"/"+state,
	      type: "post",
	      dataType: "html",
		beforeSend: function(){
			$($rowid).hide();
		},
	      success: function(responce){

	          $($eleid).html(responce);

	      },
	    });
}


function changereportItemStatus(itemId,state){
	$baseurl = getBaseURL();
	$eleid = "#status"+itemId;
	$rowid = "#item"+itemId;

		$.ajax({
	      url: $baseurl+"/admins/admins/changereportitemstatus/"+itemId+"/"+state,
	      type: "post",
	      dataType: "html",
		beforeSend: function(){
			$($rowid).hide();
		},
	      success: function(responce){
	          //alert(responce);

	          $($eleid).html(responce);

	      },
	    });
}

function ignorereport(itemId){
	$baseurl = getBaseURL();
	$eleid = "#status"+itemId;
	$rowid = "#item"+itemId;
	//alert($eleid);
		$.ajax({
	      url: $baseurl+"/admins/admins/ignorereportitem/"+itemId,
	      type: "post",
	      dataType: "html",
		beforeSend: function(){
			$($rowid).hide();
		},
	      success: function(responce){
	          //alert(responce);

	          $($eleid).html(responce);

	      },
	    });
}

function changeCurrencyStatus(currId,status){

	$baseurl = getBaseURL();
	$eleid = "#status"+currId;
	$statid = ".inputform"+currId;
	//alert(status);
	if(status == "disable")
	{
		stat = "enable";
	}
	else if(status == "enable")
	{
		stat = "disable";
	}
	if(confirm("Are you sure want to "+stat+" this Item?")) {
	      $.ajax({
	      url: $baseurl+"/admins/admins/changecurrencystatus/"+currId+"/"+status,
	      type: "post",
	      dataType: "html",
		beforeSend: function(){
			$(".btn").attr("disabled",true);
		},
	      success:function(responce){
	    	  result = responce.split("***");
	    	  //alert(result[1]);
	         // alert(responce);
		/* $($eleid).html("");
		 $($eleid).html(result[0]);
	    	  if(result[1]=="enable")
	    		  $($statid).attr("disabled",true);
	    	  else if(result[1]=="disable")
	    		  $($statid).attr("disabled",false);
			  $(".btn").attr("disabled",false);*/
               window.location.reload() ;
	      },

	    });
	  }
	return false;
}



function markfeature(itemId){

	$baseurl = getBaseURL();
	var remember = document.getElementById('featured'+itemId);

	  if (remember.checked){
	    var status = 1;
	  }else{
	    var status = 0;
	  }

	  $.ajax({
	      url: $baseurl+"/admins/admins/featureditem/"+itemId+"/"+status,
	      type: "post",
	      dataType: "html",
	      success: function(response){
	          //alert(response);
	           redirectlink =  $baseurl+"approveditems";
	           window.location.href = redirectlink;
	      },
	       error: function(response){
	        //  alert(response);
	       }
	    });
}

function deleteItemAdmin(itemId) {
	//alert(itemId);

	$baseurl = getBaseURL();
	$eleid = "#item"+itemId;
	if(confirm("Are you sure want to delete this Item?")) {
	$.ajax({
      url: $baseurl+"/admins/admins/deleteitem/"+itemId,
      type: "post",
      dataType: "html",
      success: function(responce){
       //   alert(responce); return false;
    	 /* if (responce == 'false') {
    		  alert('Unable to process now');
    	  }else {*/
              $($eleid).remove();
              window.location.reload();
             // var approveditemstable = $('#approveditemstable').DataTable();
              //approveditemstable.row($('#item' + itemId)).remove().draw();
    	  //}
      },


    });
	}
}
function deletereportItem(itemId) {
	$baseurl = getBaseURL();
	$eleid = "#item"+itemId;
	if(confirm("Are you sure want to delete this Item?")) {
	$.ajax({
      url: $baseurl+"/admins/admins/deletereportitem/"+itemId,
      type: "post",
      dataType: "html",
      success: function(responce){
          alert(responce); return false;
    	  if (responce == 'false') {
    		  alert('Unable to process now');
    	  }else {
              $($eleid).remove();
    	  }
      },


    });
	}
}

     /* saravana pandian */

function deleteCurrency(id) {
	$baseurl = getBaseURL();

if(confirm("Are you sure want to delete this Currency?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/deletecurrency/"+id,
      type: "post",
      dataType: "html",
      success: function(){

          $("#del_"+id).remove();

      },
    });
	}



	return false;
}



function deleteCategory (catId) {

	$baseurl = getBaseURL();
	$eleid = "#catgy"+catId;
	$catid = "#catid"+catId;
	categ_id = $($catid).val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	/*if (categ_id) {
		$("#linkid"+catId).find("span").css("opacity","0.7");
		$("#linkid"+catId).css("cursor","default").click(false);
		$("#err"+catId).show();
		setTimeout(function() {
		$("#err"+catId).fadeOut('slow');
	      }, 5000);
	}
	else
	{*/
	//alert($eleid);
	if(confirm("Are you sure want to delete this Category?")) {
	$.ajax({
      url: $baseurl+"/admins/admins/deletecategory/"+catId,
      type: "post",
      dataType: "html",
      success: function(response){
    //alert(response);
		var resp = $.parseJSON(response);
    // alert(resp.status);

		if(resp.status == 'products')
		{
			respTxt =  'This category has products';
			$("#caterr").removeAttr('data-trn-key');
			$("#caterr").html(respTxt);
			translator.lang(sessionlang);
			$("#caterr").css("display","block");
			setTimeout(function() {
			  $("#caterr").fadeOut('slow');
			}, 5000);
		}
		else if(resp.status == 'categories')
		{
			 respTxt =  'This category has sub categories';
			 $("#caterr").removeAttr('data-trn-key');
			 $("#caterr").html(respTxt);
			 translator.lang(sessionlang);
			 $("#caterr").css("display","block");
			 setTimeout(function() {
			  $("#caterr").fadeOut('slow');
			}, 5000);
		}
		else if(resp.status == 'empty')
		{
			 respTxt =  'Category successfully removed';
			 $("#caterr").removeAttr('data-trn-key');
			 $("#caterr").html(respTxt);
			 translator.lang(sessionlang);
			 $("#caterr").css("display","block");
			 setTimeout(function() {
			  $("#caterr").fadeOut('slow');
			}, 5000);
			 $($eleid).remove();
		}

      },
      error: function(response){
         //alert(JSON.stringify(response));

      }
    });
	}
	$("#caterr").html('');
	//}
}

function changeSellerStatus_admin (userId, status) {
	$baseurl = getBaseURL();
	$eleid = "#status"+userId;
	$rowid = "#del_"+userId;

		switch(status)
			{
				case 0:
				  redirectlink =  $baseurl+"approvedseller";
				  sellerstatus = 'enable';
				  break;
				case 1:
				  redirectlink =  $baseurl+"nonapprovedseller";
				  sellerstatus = 'disable';
				  break;
				default:
				  redirectlink =  $baseurl;
				  break;
			}
	if (confirm("Are you sure you want to "+sellerstatus+" this seller?")) {
			$.ajax({
		      url: $baseurl+"/admins/admins/changesellerstatus/"+userId+"/"+status,
		      type: "post",
		      dataType: "html",
			beforeSend: function(){
				$($rowid).hide();
			},
		    success: function(responce){
			          $($eleid).html(responce);
			  	  $($rowid).hide();
			  	  window.location.href = redirectlink;
	    	    },
		    });
		}
	//	return false;
}

function changeSocialStatus(userId, status){
	$baseurl = getBaseURL();
	$eleid = "#social"+userId;
	//alert($eleid);
		$.ajax({
	      url: $baseurl+"admins/change_social_status/"+userId+"/"+status,
	      type: "post",
	      dataType: "html",
	      success: function(responce){
	          //alert(responce);
	          $($eleid).html(responce);
	      },
	    });
}

function sellersignupfrm(){
	var check = 0;
	var brandname = $('#brand_name').val();
	var phnno = $('#person_phone_number').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	var numExp = /^[0-9-+]+$/;

	if($('#brand_name').val() == '') {
		$('.brand_name-error').html('Brand Name Cannot be Empty');
		translator.lang(sessionlang);
		check = 1;
	}
	if($.trim(brandname).length < 3){
		$(".brand_name-error").show();
		$("#brand_name").focus();
		$('.brand_name-error').text('Brand name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.brand_name-error').fadeOut('slow');
			}, 5000);
		//return false;
		check = 1;
	}
	if($.trim(brandname).length > 15){
		$(".brand_name-error").show();
		$("#brand_name").focus();
		$('.brand_name-error').text('Brand name should not exceed 15 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.brand_name-error').fadeOut('slow');
			}, 5000);
		//return false;
		check = 1;
	}
	if($('#merchant_name').val() == '') {
		$(".merchant_name-error").show();
		$('.merchant_name-error').text('Merchant Name Cannot be Empty');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.merchant_name-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}
	if($('#stripeId').val() == '') {
		$(".stripeId-error").show();
		$('.stripeId-error').text('Paypal Id Cannot be Empty');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.stripeId-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}
	if($('#person_phone_number').val() == '') {
		$(".person_phone_number-error").show();
		$('.person_phone_number-error').text('Phone No. Cannot be Empty');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.person_phone_number-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}

    if(!$.trim(phnno).match(numExp)){
		$(".person_phone_number-error").show();
		//$("#person_phone_number").focus();
		$('.person_phone_number-error').text('Please enter numbers only');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.person_phone_number-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}
	if($('#officeaddress').val() == '') {
		$(".officeaddress-error").show();
		$('.officeaddress-error').text('office Address Cannot be Empty');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.officeaddress-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}
	if($('#mpowerid').val() == '') {
		$(".mpowerid-error").show();
		$('.mpowerid-error').text('Mpowerpayment Id Cannot be Empty');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.mpowerid-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}
	if($('#longid').val() == '') {
		$(".longid-error").show();
		$('.longid-error').text('Longitude Cannot be Empty');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.longid-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}
	if($('#latid').val() == '') {
		$(".latid-error").show();
		$('.latid-error').text('Lattitude Cannot be Empty');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.latid-error').fadeOut('slow');
			}, 5000);
		check = 1;
	}
	if (check == 1) {
		$('.form-error').html("please fill all the details");
		translator.lang(sessionlang);
		return false;
	}
	return true;
}

function changeUserStatus(userId, status, userLevel) {
	$baseurl = getBaseURL();

	$eleid = "#status"+userId;
	$rowid = "#del_"+userId;

	if(status=="enable")
	{
		switch(userLevel)
			{
				case 'normal':
				  userType = "user";
				  redirectlink =  $baseurl+"nonapproveduser";
				  break;
				case 'moderator':
				  userType = "moderator";
				  redirectlink =  $baseurl+"nonapprovedmoderator";
				  break;
				default:
				  userType = "shop";
				  redirectlink =  $baseurl+"inactiveuser";
				  break;
			}

		if (confirm("Are you sure you want to disable this "+userType+"?")) {
			$.ajax({
		      url: $baseurl+"changeuserstatus/"+userId+"/"+status,
		      type: "post",
		      dataType: "html",
			beforeSend: function(){
				$($rowid).hide();
			},
		    success: function(responce){
		          $($eleid).html(responce);
			  	  $($rowid).hide();
			  	  window.location.href = redirectlink;
	    	    },
		    });
		}
		return false;
	}
	else
	{
		switch(userLevel)
			{
				case 'normal':
				  userType = "user";
				  redirectlink =  $baseurl+"manageuser";
				  break;
				case 'moderator':
				  userType = "moderator";
				  redirectlink =  $baseurl+"managemoderator";
				  break;
				default:
				  userType = "shop";
				  redirectlink =  $baseurl+"inactiveuser";
				  break;
			}

		if (confirm("Are you sure you want to enable this "+userType+"?")) {
			$.ajax({
		      url: $baseurl+"changeuserstatus/"+userId+"/"+status,
		      type: "post",
		      dataType: "html",
		      success: function(responce){
		          $($eleid).html(responce);
		     	  $($rowid).hide();
			      window.location.href = redirectlink;
		      },
		    });
		}
		return false;
	}

}

function showInvoicePopupAdmin(id) {


	var baseurl = getBaseURL()+'invoiceview/'+id;
	var element = '.inv-loader-'+id;
	/*var popup = window.open('');
	$(popup.document).on('keydown', function(e) {
  	  if(e.keyCode == 27) {
  		 popup.close();
  	  }
    });*/
var invajax=0;
	if (invajax == 0) {
		invajax = 1;
		$.ajax({
		      url: baseurl,
		      type: "post",
		      dataType: "html",
		     // before: function(){
		    	// $(element).show();
		      //},
		      success: function(responce){

		    	// $(element).hide();
		    	  $('.moreactionlistmyord'+id).slideToggle();
		    		$('#invoice-popup-overlay15').show();
		    		$('#invoice-popup-overlay15').css("opacity", "1");
		          $('.invoice-popup').html(responce);

		          invajax = 0;

		      }
		    });
	}
}
function hideinvoice()
{
$('#invoice-popup-overlay15').hide();
		$('#invoice-popup-overlay15').css("opacity", "0");
}


/*
function checkout (itemids,merchid,shipamt) {
	$baseurl = getBaseURL();
	var addrid = '#address-cart'+merchid;
	var shippingid = $(addrid).val();
	$.ajax({
	      url: $baseurl+"checkout/",
	      type: "post",
	      data : { 'item_id': itemids,'shippingid': shippingid,'shipamt': shipamt},
	      dataType: "html",
	      success: function(responce){
	    	  $('#paypalfom').html(responce);
	    	  $('#paypal').submit();
	      }
	});
}*/


function checkouttomer (merchname,price,orderid) {
	$baseurl = getBaseURL();
	//alert(merchname);
	//alert(orderid);
	//var currencyid = '#currency'+orderid;
	var currency = $('#currency').val();
	$.ajax({
	      url: $baseurl+"paytomerchant/",
	      type: "post",
	      data : { 'merchname': merchname,'price': price,'orderid': orderid, 'currency': currency},
	      dataType: "html",
	      success: function(responce){
	    	  $('#paypalfom').html(responce);
	    	  $('#paypal').submit();
	      }
	});
}

function confirmtomer(merchname,price,orderid) {

	$baseurl = getBaseURL();
	var currencyid = '#currency'+orderid;
	var currency = $(currencyid).val();
	$.ajax({
	      url: $baseurl+"/admins/admins/confirmtomerchant/"+orderid,
	      type: "post",
	      data : { 'merchname': merchname,'price': price,'orderid': orderid, 'currency': currency},
	      dataType: "html",
	      success: function(responce){

	    	 if($.trim(responce) == 'success'){

			window.location = $baseurl+"approvedorders";
	    	 } else {
			window.location = $baseurl+"payment-cancelled";
			}
	      }
	});


}

function search_func(){
var BaseURL=getBaseURL();
	 var value1 = $('#usersrchSrch').val();
	 if(value1.length>2 || value1.length == 0){
	 $.ajax({
			type: "post",		// Request method: post, get
			url: BaseURL+"/admins/admins/searchuser/"+value1,	// URL to request
			dataType: "html",	// Expected response type
			success: function(response, status) {

				$('#userdata').html(response);

			},
		});
}

		return false;

}

function validateaddslider() {
	var image = $('#image_computer_0').val();
	var url = $('#sliderLink').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	//alert(image); alert(url);
	//var regexp = /^(ftp:\/\/|http:\/\/|https:\/\/)?(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!-\/]))?$/;
	//var regexp = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;
	var regexp = /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?/;

	$('.error').html("");

	if (image == ''){
		$('.sliderimageerror').show();
		$('.sliderimageerror').html('Select a Image').css("color", "red");
		translator.lang(sessionlang);
				setTimeout(function() {
					  $('.sliderimageerror').fadeOut('slow');
					}, 5000);
		return false;
	/*
		}else if (url == ''){
		$('.addurlerror').html("Enter a URL").css("color", "red");
		translator.lang(sessionlang);
		return false;
	*/
	}else if (url != "" && !regexp.test(url)){
		$('.addurlerror').html("Enter a valid URL").css("color", "red");
		translator.lang(sessionlang);
		return false;
	}else{
		return true;
	}
}

function validatelandingpage() {
	var slider = $('#sliders').val();
	var sliderheight = $('#sliderheight').val();
	var sliderbg = $('#sliderbg').val();
	var widget = $('#widgets').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	$('.error').html("");

	if (sliderheight == ''){
		$('.sliderheighterror').html('Enter slider height');
		translator.lang(sessionlang);
		return false;
	}else if (sliderbg == ""){
		$('.sliderbgerror').html("Enter slider background color");
		translator.lang(sessionlang);
		return false;
	}else if (slider == ""){
		$('.slidererror').html("Add atleast one slider");
		translator.lang(sessionlang);
		return false;
	}else if (widget == ""){
		$('.widgeterror').html("Select some widgets");
		translator.lang(sessionlang);
		return false;
	}else{
		return true;
	}
}

function sendpushnot(){
	var BaseURL=getBaseURL();
	var message = $('#message').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	$('.adminitemerror').html('');
	if (message == ''){
		$('.message-error').html('Enter a message to send');
		translator.lang(sessionlang);
		$("#message").keydown(function(){
			$(".message-error").html("");
		});
		return false;
	}else{
		$('.message-error').html('');
		 $.ajax({
			type: "post",		// Request method: post, get
			url: BaseURL+"/admins/admins/sendpushnot/",	// URL to request
			data: {'messages':message},
			dataType: "html",	// Expected response type
			beforeSend: function(){
				$('#pushnotloader').addClass('pushnotloader');
				$("#sendpush").attr("disabled",true);
			},
			success: function(response) {
				$('.message-error').html('');
				//alert(response)
			//	alert(JSON.stringify(response));
				$('#pushnotloader').removeClass('pushnotloader');
		        $(".message-success").show();
				$('.message-success').html(response);
				translator.lang(sessionlang);
				$('.message-error').html('');
				$('#message').val('');
				$("#sendpush").attr("disabled",false);
				setTimeout(function() {
					  $('.message-success').fadeOut('slow');
					}, 5000);
			},
			error: function(response) {
			    $(".message-success").show();
				$('.message-success').html(response);
				$('.message-error').html('');
				translator.lang(sessionlang);
				//alert(JSON.stringify(response));
			}
		});
	}
}


/*********** Add color validation for Admin ***********/
function addcolorform()
{
	color_name = $("#Color_name").val();
	rgbval1 = $("input[name=rgbval1]").val();
	rgbval2 = $("input[name=rgbval2]").val();
	rgbval3 = $("input[name=rgbval3]").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	if($.trim(color_name)=="")
	{
		$("#colorerr").show();
		$("#colorerr").removeAttr('data-trn-key');
		$("#colorerr").html("Enter color name");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#colorerr').fadeOut('slow');
			}, 5000);
		$("#Color_name").val("");
		$("#Color_name").focus();
		return false;
	}
	if($.trim(rgbval1)=="")
	{
		$("#colorerr").show();
		$("#colorerr").removeAttr('data-trn-key');
		$("#colorerr").html("Enter R value");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#colorerr').fadeOut('slow');
			}, 5000);
		$("input[name=rgbval1]").val("");
		$("input[name=rgbval1]").focus();
		return false;
	}
	if(isNaN(rgbval1))
	{
		$("#colorerr").show();
		$("#colorerr").removeAttr('data-trn-key');
		$("#colorerr").html("Enter valid R value");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#colorerr').fadeOut('slow');
			}, 5000);
		$("input[name=rgbval1]").val("");
		$("input[name=rgbval1]").focus();
		return false;
	}
	if($.trim(rgbval2)=="")
	{
		$("#colorerr").show();
		$("#colorerr").removeAttr('data-trn-key');
		$("#colorerr").html("Enter G value");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#colorerr').fadeOut('slow');
			}, 5000);
		$("input[name=rgbval2]").val("");
		$("input[name=rgbval2]").focus();
		return false;
	}
	if(isNaN(rgbval2))
	{
		$("#colorerr").show();
		$("#colorerr").removeAttr('data-trn-key');
		$("#colorerr").html("Enter valid G value");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#colorerr').fadeOut('slow');
			}, 5000);
		$("input[name=rgbval2]").val("");
		$("input[name=rgbval2]").focus();
		return false;
	}
	if($.trim(rgbval3)=="")
	{
		$("#colorerr").show();
		$("#colorerr").removeAttr('data-trn-key');
		$("#colorerr").html("Enter B value");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#colorerr').fadeOut('slow');
			}, 5000);
		$("input[name=rgbval3]").val("");
		$("input[name=rgbval3]").focus();
		return false;
	}
	if(isNaN(rgbval3))
	{
		$("#colorerr").show();
		$("#colorerr").removeAttr('data-trn-key');
		$("#colorerr").html("Enter valid B value");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#colorerr').fadeOut('slow');
			}, 5000);
		$("input[name=rgbval3]").val("");
		$("input[name=rgbval3]").focus();
		return false;
	}
$("#colorerr").html("");
}
/*********** Add color validation for Admin ***********/


function order_search()
{
	searchval = $("#ordersearchval").val();
	startdate = $("#sdate").val();
	enddate = $("#edate").val();

	$baseurl = getBaseURL();
	$.ajax({
	      url: $baseurl+"admin/merchant_payment_search/",
	      type: "post",
	      data : { 'sval':searchval,'stdate':startdate,'eddate':enddate},
	      dataType: "html",
	      success: function(responce){
			$("#userdata").html(responce);
	      }
	});
}

function ship_order_search()
{
	searchval = $("#ordersearchval").val();
	startdate = $("#sdate").val();
	enddate = $("#edate").val();

	$baseurl = getBaseURL();
	$.ajax({
	      url: $baseurl+"admin/merchant_payment_ship_search/",
	      type: "post",
	      data : { 'sval':searchval,'stdate':startdate,'eddate':enddate},
	      dataType: "html",
	      success: function(responce){
			$("#userdata").html(responce);
	      }
	});
}

function deliver_order_search()
{
	searchval = $("#ordersearchval").val();
	startdate = $("#sdate").val();
	enddate = $("#edate").val();

	$baseurl = getBaseURL();
	$.ajax({
	      url: $baseurl+"admin/merchant_payment_deliver_search/",
	      type: "post",
	      data : { 'sval':searchval,'stdate':startdate,'eddate':enddate},
	      dataType: "html",
	      success: function(responce){
			$("#userdata").html(responce);
	      }
	});
}

function paid_order_search()
{
	searchval = $("#ordersearchval").val();
	startdate = $("#sdate").val();
	enddate = $("#edate").val();

	$baseurl = getBaseURL();
	$.ajax({
	      url: $baseurl+"admin/merchant_payment_paid_search/",
	      type: "post",
	      data : { 'sval':searchval,'stdate':startdate,'eddate':enddate},
	      dataType: "html",
	      success: function(responce){
			$("#userdata").html(responce);
	      }
	});
}
function claim_order_search()
{
	searchval = $("#ordersearchval").val();
	startdate = $("#sdate").val();
	enddate = $("#edate").val();

	$baseurl = getBaseURL();
	$.ajax({
	      url: $baseurl+"admin/merchant_payment_claim_search/",
	      type: "post",
	      data : { 'sval':searchval,'stdate':startdate,'eddate':enddate},
	      dataType: "html",
	      success: function(responce){
			$("#userdata").html(responce);
	      }
	});
}
function return_order_search()
{
	searchval = $("#ordersearchval").val();
	startdate = $("#sdate").val();
	enddate = $("#edate").val();

	$baseurl = getBaseURL();
	$.ajax({
	      url: $baseurl+"admin/merchant_payment_return_search/",
	      type: "post",
	      data : { 'sval':searchval,'stdate':startdate,'eddate':enddate},
	      dataType: "html",
	      success: function(responce){
			$("#userdata").html(responce);
	      }
	});
}
function invoice_search()
{

	searchval = $("#invoicesval").val();

	if($.trim(searchval)=="")
	{
		$("#sererr").show();
		setTimeout(function() {
			  $('#sererr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
	{

		$baseurl = getBaseURL();
		$.ajax({
		      url: $baseurl+"invoicesearch/",
		      type: "post",
		      data : { 'sval':searchval},
		      dataType: "html",
		      success: function(responce){
				$("#userdata").html(responce);
		      }
		});
	}
}

function admin_menu_list()
{
	user_level = $("#usr_access").val();
	if(user_level=="moderator")
	{
	    $('#invoice-popup-overlay1').show();
		$('#invoice-popup-overlay1').css("opacity", "1");
	}
}

function menu_list()
{
	var translator = $('body').translate({t: dict});
	var sessionlang = $("#languagecode").val();
	valu = new Array();
	j = 0;
		$("[name='chkbox']").each(function(){
	//checkd = $(this).attr();
	if($(this).prop("checked")==true)
	{
		valu[j] = $(this).val();
		j++;
	}
	});
	values = JSON.stringify(valu);
	if(valu=="")
	{
		$(".trn").show();
		//$("#alert").removeAttr('data-trn-key');
		//var newdiv='<button class="close close_x" onclick="close_x();">x</button>';
		$('.trn').text('Please select menus');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('.trn').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
	{
		$("#menulist").val(values);
	    $('#invoice-popup-overlay1').hide();
		$('#invoice-popup-overlay1').css("opacity", "0");

	}
}
function closebraintree()
{
	 $('#invoice-popup-overlay1').hide();
}


function sendnewsletter()
{
	subject = $("#subject").val();
	message = $("#message").val();

	key = $("#nkey").val();
	username = $("#nusername").val();
	output = "JSON";
	$baseurl = "http://www.ymlp.com/api/Newsletter.Send";
		$.ajax({
	      url: $baseurl,
	      type: "GET",
	      crossDomain:true,
	      data : { 'Key':key,'Username':username,'TestMessage':'0','Subject':subject,'Text':message,'Output':output},
	      dataType: "jsonp",
	      contentType: "application/json",
	      beforeSend: function () {
		$('#loading_image').show();
	     },
	      success: function(responce){
		$('#loading_image').hide();
	    	  alert(responce.Output);
		$("#subject").val('');
		$("#message").val('');
	      }
	});

}


function addcontacts()
{
	var check = $( "input:checked" ).length;
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	if(check == 0){
		email = $( "#email option:selected" ).text();

	key = $("#nkey").val();
	username = $("#nusername").val();
		output = "JSON";
		$baseurl = "https://www.ymlp.com/api/Contacts.Add";

			      $.ajax({
				      url: $baseurl,
				      type: "GET",
				      crossDomain:true,
				      data : { 'Key':key,'Username':username,'Email':email,'GroupId':'1','Output':output},
				      dataType: "jsonp",
				      contentType: "application/json",
				       beforeSend: function () {
					$('#loading_image').show();
				      },
				      success: function(responce){
						$('#loading_image').hide();
		$("#addsucc").show();
		$("#addsucc").removeAttr('data-trn-key');
		$("#addsucc").html("Contacts added successfully");
		translator.lang(sessionlang);
			setTimeout(function() {
				  $('#addsucc').fadeOut('slow');
				}, 5000);
				      }
				});
	}
	else {
		var mailVal = $( "#count" ).val();
		var count;
		for(var i=0; i<mailVal; i++) {
			var mailid = '#check'+i;
			var email = $(mailid).val();

	key = $("#nkey").val();
	username = $("#nusername").val();
			output = "JSON";
			$baseurl = "https://www.ymlp.com/api/Contacts.Add";

				      $.ajax({
					      url: $baseurl,
					      type: "GET",
					      crossDomain:true,
					      data : { 'Key':key,'Username':username,'Email':email,'GroupId':'1','Output':output},
					      dataType: "jsonp",
					      contentType: "application/json",
						beforeSend: function () {
						$('#loading_image').show();
					      },
					      success: function(responce){
						  $('#loading_image').hide();
					    	  //alert();
						  count = 1;
					      }
					});
		}
		if (count==1) {
		$("#addsucc").show();
		$("#addsucc").removeAttr('data-trn-key');
		$("#addsucc").html("Contacts added successfully");
		translator.lang(sessionlang);
			setTimeout(function() {
				  $('#addsucc').fadeOut('slow');
				}, 5000);
		}

	}
$("#addsucc").html("");
}

function get_contacts_list()
{
	subject = $("#subject").val();
	message = $("#message").val();

	key = $("#nkey").val();
	username = $("#nusername").val();
	output = "JSON";
	$baseurl = "https://www.ymlp.com/api/Contacts.GetList";
		$.ajax({
	      url: $baseurl,
	      type: "GET",
	      crossDomain:true,
	      data : { 'Key':key,'Username':username,'GroupID':'1','Output':output},
	      dataType: "jsonp",
	      contentType: "application/json",
	      success: function(responce){
		    	 $baseurl = getBaseURL();
		    		$.ajax({
		    		      url: $baseurl+"/admins/admins/listcontacts",
		    		      type: "post",
		    		      data : { 'responce':responce},
		    		      dataType: "html",
		    		      success: function(datas){
		    		    	  $("#emailslist").html(datas);
		    		      }
		    		});
	    	 /* responce = responce.toSource();
	    	  responce = responce.replace('[','');
	    	  responce = responce.replace(']','');
	    	  resp = responce.split(",");
	    	  $("#emailslist").html("");
	    	 for(i=0;i<=resp.length;i++)
	    		 {
	    		 	$("#emailslist").append(resp[i]);
	    		 	$("#emailslist").append('<br />');
	    		 }*/

	      }
	});

}


function get_contacts_list_email()
{
	subject = $("#subject").val();
	message = $("#message").val();

	key = $("#nkey").val();
	username = $("#nusername").val();
	output = "JSON";
	$baseurl = "https://www.ymlp.com/api/Contacts.GetList";
		$.ajax({
	      url: $baseurl,
	      type: "GET",
	      crossDomain:true,
	      data : { 'Key':key,'Username':username,'GroupID':'1','Output':output},
	      dataType: "jsonp",
	      contentType: "application/json",
	      success: function(responce){
		    	 $baseurl = getBaseURL();
		    		$.ajax({
		    		      url: $baseurl+"admin/addcontactslist",
		    		      type: "post",
		    		      data : { 'responce':responce},
		    		      dataType: "html",
		    		      success: function(datas){
		    		    	  $("#listemail").html(datas);
		    		      }
		    		});
	    	 /* responce = responce.toSource();
	    	  responce = responce.replace('[','');
	    	  responce = responce.replace(']','');
	    	  resp = responce.split(",");
	    	  $("#emailslist").html("");
	    	 for(i=0;i<=resp.length;i++)
	    		 {
	    		 	$("#emailslist").append(resp[i]);
	    		 	$("#emailslist").append('<br />');
	    		 }*/

	      }
	});

}

function delete_contacts(email)
{

	key = $("#nkey").val();
	username = $("#nusername").val();
	output = "JSON";
	$baseurl = "https://www.ymlp.com/api/Contacts.Delete";

		      $.ajax({
			      url: $baseurl,
			      type: "GET",
			      crossDomain:true,
			      data : { 'Key':key,'Username':username,'Email':email,'GroupId':'1','Output':output},
			      dataType: "jsonp",
			      contentType: "application/json",
			       beforeSend: function () {
				$('#loading_image').show();
			      },
			      success: function(responce){
					$('#loading_image').hide();
			    	  	alert(responce.Output);
			    	  	//window.location.reload();
			      }
			});
}

function showrestriction()
{
	user_level = $("#usr_access").val();
	if(user_level=="moderator")
	{
	    $("#restrict").show();
	}
	else
		$("#restrict").hide();
}

function close_button1()
{
		$('#invoice-popup-overlay1').hide();
		$('#invoice-popup-overlay1').css("opacity", "0");
		$("input[type=checkbox]").each(function() {
			$(this).prop('checked', false);
			$(this).removeAttr("checked");
		});
}
function close_button()
{
		$('#invoice-popup-overlay1').hide();
		$('#invoice-popup-overlay1').css("opacity", "0");

}


function save_err_code()
{
	error_code = $("#err_content").val();
	$baseurl = getBaseURL();
	$.ajax({
	      url: $baseurl+"err404",
	      type: "post",
	      data : { 'errorcode':error_code},
	      dataType: "html",
	      success: function(responce){
		alert(responce);
		window.location.reload();
	      }
	});
}


function show_export()
{
		$('#invoice-popup-overlay1').show();
		$('#invoice-popup-overlay1').css("opacity", "1");
}
function filetypeerror()
{
	filename = $(".filename").html();
	filetype = filename.split(".");
	if(filetype[1]!="csv" && filetype[1]!="xls")
		{
			alert("Upload csv/xls file only");
			return false;
		}

}


function export_view()
{
		$('#invoice-popup-overlay').show();
		$('#invoice-popup-overlay').css("opacity", "1");
}

function detect_method()
{
	color_method = $("#detectmethod").val();
	if(color_method=="manual")
	{
		$("#manual_select").show();
	}
	else
	{
		$("#manual_select").hide();
	}
}


function addtaxform()
{
	countryval = $("#selct_lctn_bxs").val();
	taxname = $("#tax_name").val();
	taxperc = $("#percentage").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	if(countryval=="")
	{
		$("#taxerr").show();
		$("#taxerr").removeAttr('data-trn-key');
		$("#taxerr").html("Select Country");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#taxerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if($.trim(taxname)=="")
	{
		$("#taxerr").show();
		$("#taxerr").removeAttr('data-trn-key');
		$("#taxerr").html("Enter tax name");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#taxerr').fadeOut('slow');
			}, 5000);
		$("#tax_name").val("");
		$("#tax_name").focus();
		return false;
	}
	else if($.trim(taxperc)=="")
	{
		$("#taxerr").show();
		$("#taxerr").removeAttr('data-trn-key');
		$("#taxerr").html("Enter tax percentage");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#taxerr').fadeOut('slow');
			}, 5000);
		$("#percentage").val("");
		$("#percentage").focus();
		return false;
	}
	else if (taxperc<=0) {
		$("#taxerr").show();
		$("#taxerr").removeAttr('data-trn-key');
		$("#taxerr").html("Tax percentage must be greater than 0");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#taxerr').fadeOut('slow');
			}, 5000);
		$("#percentage").val("");
		$("#percentage").focus();
		return false;
	}
	else if(taxperc>100)
	{
		$("#taxerr").show();
		$("#taxerr").removeAttr('data-trn-key');
		$("#taxerr").html("Tax percentage must be less than or equal to 100");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#taxerr').fadeOut('slow');
			}, 5000);
		$("#percentage").val("");
		$("#percentage").focus();
		return false;
	}
else if(isNaN(taxperc))
{
	$("#taxerr").show();
		$("#taxerr").removeAttr('data-trn-key');
		$("#taxerr").html("Tax percentage must be in numbers");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#taxerr').fadeOut('slow');
			}, 5000);
		$("#percentage").val("");
		$("#percentage").focus();
		return false;
}
$("#taxerr").html("");
}

function deletetax(tid)
{$baseurl = getBaseURL();


	if (confirm("Are you sure you want to delete this tax? ")) {
		$.ajax({
      url: $baseurl+"deletetax/"+tid,
      type: "post",
      dataType: "html",
      success: function(){

		$("#del_"+tid).remove();

      },
    });
	}
}






function validate_commission()
{
	perc = $("#credit_percentage").val();

	if($.trim(perc)=="" || perc==0){
		$("#siteerrormsg").show();
		$("#credit_percentage").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$("#siteerrormsg").html("Credit Amount Should be Valid");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
		}

	if(!$.trim(perc).match(numExp)){
		$("#siteerrormsg").show();
		$("#credit_percentage").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Please enter numbers only for commission percentage');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}
$('#siteerrormsg').html("");
}
function validate_site()
{
	site_name = $("#site_name").val();
	site_title = $("#site_title").val();
	unlike_btn_cmnt = $("#unlike_btn").val();
	//perc = $("#credit_percentage").val();
	signup_credit = $("#signup_credit").val();
	checkin_credit = $("#checkin_credit").val();
	order_count = $("#order_count").val();
	checkin_count = $("#checkin_count").val();
	credit_amount = $("#credit_amount").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	//like_btn_logo = $("#image_computer_like").val();

	var numExp = /^[0-9.]+$/;
	var isImage=/(?:gif|jpg|jpeg|png|bmp|ico)$/;

   if($.trim(site_name) == ''){
		$("#siteerrormsg").show();
		$("#site_name").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Enter the site name');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(site_name).length < 3){
		$("#siteerrormsg").show();
		$("#site_name").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Site name should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(site_name).length > 30){
		$("#siteerrormsg").show();
		$("#site_name").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Site name should not exceed 30 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(site_title) == ''){
		$("#siteerrormsg").show();
		$("#site_title").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Enter the site title');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(site_title).length < 3){
		$("#siteerrormsg").show();
		$("#site_title").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Site title should be atleast 3 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(site_title).length > 30){
		$("#siteerrormsg").show();
		$("#site_title").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Site title should not exceed 30 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}
		if($.trim(unlike_btn_cmnt)==""){
			$("#unlike_val").show();
			setTimeout(function() {
				  $('#unlike_val').fadeOut('slow');
				}, 5000);
			return false;
		}

	// if($.trim(perc)=="" || perc==0){
	// 	$("#siteerrormsg").show();
	// 	$("#credit_percentage").focus();
	// 	$("#credit_amount").removeAttr('data-trn-key');
	// 	$("#siteerrormsg").html("Credit Amount Should be Valid");
	// 	translator.lang(sessionlang);
	// 	setTimeout(function() {
	// 		  $('#siteerrormsg').fadeOut('slow');
	// 		}, 5000);
	// 	return false;
	// 	}

	// if(!$.trim(perc).match(numExp)){
	// 	$("#siteerrormsg").show();
	// 	$("#credit_percentage").focus();
	// 	$("#credit_amount").removeAttr('data-trn-key');
	// 	$('#siteerrormsg').text('Please enter numbers only for commission percentage');
	// 	translator.lang(sessionlang);
	// 	setTimeout(function() {
	// 		  $('#siteerrormsg').fadeOut('slow');
	// 		}, 5000);
	// 	return false;
	// }
	if(!$.trim(credit_amount).match(numExp)){
		$("#siteerrormsg").show();
		$("#credit_amount").focus();
		$("#credit_amount").removeAttr('data-trn-key');
		$('#siteerrormsg').text('Please enter numbers only for user credit amount');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#siteerrormsg').fadeOut('slow');
			}, 5000);
		return false;
	}


$('#siteerrormsg').html("");






}

/*function delete_affiliate() {
var BaseURL=getBaseURL();

              var result = [];
  	      var count = 0;
     /*  $("input[name*='seldel[]']").filter(':checked').each(function (e) {
          result = result + $(this).val() + ",";
	  count++;
       });


       if (result=="") {
			$("#delerr").show();
			$("#delerr").html("Select items");
			setTimeout(function() {
				  $('#delerr').fadeOut('slow');
				}, 5000);
       }
       else
       {*/
	/*if (confirm("Are you sure you want to delete these " +count+ " items? ")) {
	 $.ajax({
		type: "post",		// Request method: post, get
		url: BaseURL+"/admins/admins/deleteaffiliateitems/",	// URL to request
		data: {'result':result},
		dataType: "html",	// Expected response type

		success: function(response) { alert(responce); return false;
			$("#delerr").show();
			$("#delerr").html("Deleted Successfully");
			setTimeout(function() {
				  $('#delerr').fadeOut('slow');
				}, 5000);
                        window.location.reload();
		},
		error: function()
{
alert('error');},
	});
       }
   // }
    //return false;
}*/

function delete_items() {
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
              var result = "";
	      var count = 0;
       $("input[name*='seldel[]']").filter(':checked').each(function (e) {
          result = result + $(this).val() + ",";
	  count++;

       });


       if (result=="") {
			$("#delerr").show();
			$("#delerr").html("Select items");
			setTimeout(function() {
				  $('#delerr').fadeOut('slow');
				}, 5000);
       }
       else
       {

	if (confirm("Are you sure you want delete these " +count+ " items? ")) {
	 $.ajax({
		type: "post",		// Request method: post, get
		url: BaseURL+"admin/delete_sales_items",	// URL to request
		data: {'result':result},
		dataType: "html",	// Expected response type

		success: function(response) { //alert(response);
			$("#delerr").show();
			$("#delerr").html("Deleted Successfully");
			translator.lang(sessionlang);
			setTimeout(function() {
				  $('#delerr').fadeOut('slow');
				}, 5000);
                        //alert(response);
                        window.location.reload();
		}
	});
       }
    }
    return false;
}
function checknum(org)
{
	org.value = org.value.replace(/[^0-9\.]/g,'');
}

function check_currency()
{
	currencycode = $("#currency_code").val();
	currencyrate = $("#currency_rate").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	if(currencycode=="")
	{
		$("#currerr").show();
		$("#currerr").removeAttr('data-trn-key');
		$("#currerr").html("Select currency code");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#currerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if($.trim(currencyrate)=="")
	{
		$("#currerr").show();
		$("#currerr").removeAttr('data-trn-key');
		$("#currerr").html("Enter currency rate");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#currerr').fadeOut('slow');
			}, 5000);
		$("#currency_rate").val("");
		$("#currency_rate").focus();
		return false;
	}
	else if(isNaN(currencyrate))
	{
		$("#currerr").show();
		$("#currerr").removeAttr('data-trn-key');
		$("#currerr").html("Enter only numbers for currency rate");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#currerr').fadeOut('slow');
			}, 5000);
		$("#currency_rate").val("");
		$("#currency_rate").focus();
		return false;
	}
	else if($.trim(currencyrate)<=0)
	{
		$("#currerr").show();
		$("#currerr").removeAttr('data-trn-key');
		$("#currerr").html("Enter valid currency rate");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#currerr').fadeOut('slow');
			}, 5000);
		$("#currency_rate").val("");
		$("#currency_rate").focus();
		return false;
	}
	$("#currerr").html("");
}

function reset_password()
{
	email = $("#email").val();
    if (confirm("Are you want to reset password? ")) {

$.ajax({
	type: "post",		// Request method: post, get
	url: BaseURL+"admins/reset_password",	// URL to request
	data: {'email':email},
	dataType: "html",	// Expected response type
    beforeSend: function () {
  	  $('#loading_img').show();
    },
	success: function(response) { //alert(response);
                  //alert(response);
		$('#loading_img').hide();
		if($.trim(response)=="success")
		{
			$("#alertmsg").show();
			$("#alertmsg").html("Password reset successfully");
		}
		else if($.trim(response)=="error")
		{
			$("#alertmsg").show();
			$("#alertmsg").html("Email id not found");
		}
                 // window.location.reload();

		setTimeout(function() {
			  $('#alertmsg').fadeOut('slow');
			}, 5000);

	}
});
}
    return false;
}


function import_show()
{
$('#invoice-popup-overlay11').show();
$('#invoice-popup-overlay11').css("opacity", "1");
$("#file").val("");
$(".filename").html("");
}
function seller_info_show()
{

filenames = $("#file").val();
var filenames = filenames.replace(/^.*\\/, "");
	if (filenames=="") {
		$("#uperr").show();
		setTimeout(function() {
			  $('#uperr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
	{

	 $.ajax({
		type: "post",		// Request method: post, get
		url: BaseURL+"admin/seller_info",	// URL to request
		data: {'filenames':filenames},
		dataType: "json",	// Expected response type

		success: function(response) {

        if ($.trim(response)=="error") {
        		$("#uperr").show();
        		setTimeout(function() {
        			  $('#uperr').fadeOut('slow');
        			}, 5000);
			}
			else
			{
				$('#invoice-popup-overlay11').hide();
				$('#invoice-popup-overlay11').css("opacity", "0");
				$('#invoice-popup-overlay12').show();
				$('#invoice-popup-overlay12').css("opacity", "1");
				username = response[0];
				username_url = BaseURL+'people/'+response[1];
				userimage = BaseURL+'media/avatars/thumb70/'+response[2];
				$("#uname").html('<a href="'+username_url+'">'+username+'</a>');
				$("#uimg").html('<img src="'+userimage+'">');

			}
                        //window.location.reload();
		}
	});
	}
}
function final_upload_show()
{
$('#invoice-popup-overlay11').hide();
$('#invoice-popup-overlay11').css("opacity", "0");
$('#invoice-popup-overlay13').show();
$('#invoice-popup-overlay13').css("opacity", "1");
filenames = $("#file").val();
var filenames = filenames.replace(/^.*\\/, "");
	 $.ajax({
		type: "post",		// Request method: post, get
		url: BaseURL+"admin/item_upload",	// URL to request
		data: {'filenames':filenames},
		dataType: "html",	// Expected response type
		beforeSend: function () {
		    $('#load_img').show();
			$("#comp").hide();
			$("#load").show();
		},
		success: function(response) {
			$('#load_img').hide();
			$("#comp").show();
			$("#comp").html(response);
			$("#load").hide();
			$("#upok").attr("disabled",false);
			//alert(response);

		},
		error: function(response) {
			$('#load_img').hide();
			$("#comp").show();
			$("#comp").html("<span style='color:red;'>File upload error. Give the values in the correct format</span>");
			$("#load").hide();
			$("#upok").attr("disabled",false);
			//alert(response);

		}
	});
}

function show_step1()
{
	//$('#invoice-popup-overlay12').hide();
	//$('#invoice-popup-overlay12').css("opacity", "0");
	$('#invoice-popup-overlay11').show();
	$('#invoice-popup-overlay11').css("opacity", "1");
}

function close_popup()
{
$('#invoice-popup-overlay13').hide();
$('#invoice-popup-overlay13').css("opacity", "0");
window.location.reload();
}

$(document).ready(function() {
$( '#form1' )
  .change( function( e ) {
	filenames = $("#file").val();
	var filenames = filenames.replace(/^.*\\/, "");
	$("#upcomplete").hide();
	if (filenames=="") {

		$("#uperr").show();
		setTimeout(function() {
			  $('#uperr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
	{
    $.ajax( {
      url: BaseURL+"admin/import_seller_detail",
      type: 'POST',
      data: new FormData( this ),
      processData: false,
      contentType: false,
      		beforeSend: function () {
		    $('#loadimg').show();
		},
		success: function(response) {
			$('#loadimg').hide();
			$("#upcomplete").show();
			$("#upnext").attr("disabled",false);

			if ($.trim(response)=="error") {
				$("#upcomplete").hide();
				$("#upnext").attr("disabled",true);
				$("#uperr").show();
				setTimeout(function() {
					  $('#uperr').fadeOut('slow');
					}, 5000);
				return false;
			}
		}
    } );
	}
    e.preventDefault();
  } );
});

function all_mod(org)
{
		var checkedChild = $("input[type=checkbox][name='chkmodules']:checked").length;
        var numberOfChild = $("input[type=checkbox][name='chkmodules']").length;
        if (checkedChild == numberOfChild){
        	 var ischecked = $(".home").prop("checked");
        	// alert(ischecked)
        	if(ischecked==true)
        	{
 				$("#sel_all").prop('checked', true);
        	}

          }
}

function check_all(org)
{
	chkd = $(org).prop("checked");
	clsname = $(org).attr("class");

	if (chkd==true) {

		$("."+clsname+"chk").attr("checked","true");
		$("."+clsname+"chk").prop('checked', true);
		/*$("#sel_all").prop('checked',true);*/

		var checkedChild = $("input[type=checkbox][name='chkmodules']:checked").length;
        var numberOfChild = $("input[type=checkbox][name='chkmodules']").length;
        if (checkedChild == numberOfChild){
        	 var ischecked = $(".home").prop("checked");
        	// alert(ischecked)
        	if(ischecked==true)
        	{
 				$("#sel_all").prop('checked', true);
        	}

          }
	}
	else
	{
		$("."+clsname+"chk").removeAttr("checked");
		$("."+clsname+"chk").prop('checked', false);
		$("#sel_all").prop('checked',false);

	}
}

/************** Size option add ******************/

function sizeAdd() {
	var property = $('#size_property').val();
	prop = property.replace(/ /g,"-");
	var unit = $('#size_units').val();
	var price = $('#size_price').val();
	if(property=='' && unit=='' && price==''){
		$("#sizeerr").show();
		$('#sizeerr').text('Give Property and Units');
		setTimeout(function() {
			  $('#sizeerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if (property.length > 15){
		alert("property size must be within 15 characters");
		return false;
	}
	if (unit<=0 || isNaN(unit)) {
		$("#sizeerr").show();
		$('#sizeerr').text('Please enter valid unit for the item');
		setTimeout(function() {
			  $('#sizeerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if(price<=0 || isNaN(price))
	{
		$("#sizeerr").show();
		$('#sizeerr').text('Please enter valid price for the item');
		setTimeout(function() {
			  $('#sizeerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(property != '' && unit != '' && price!='')
	{
		existsize = $("#sizeOption").find("#tot"+property).html();
		if(existsize!=null)
		{
			$("#sizeerr").show();
			$('#sizeerr').text('Size already exists');
			setTimeout(function() {
				  $('#sizeerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		else
		{

			var htms = '<div style="height:auto;overflow:hidden;" id="tot'+property+'"><dp class="'+property+'">';
			htms += 'Property: '
			htms += '<input readonly type="text" class="inputform" id="sizePro" name="size['+property+']" value="'+property+'"/>';
			htms += '</dp> ';
			htms += '<dn class="'+unit+'">';
			htms += 'Units: '
			htms += '<input readonly type="text" class="inputform" onkeydown="chknum(this,event);" maxlength="3" id="size_units'+unit+'" name="unit['+property+']" value="'+unit+'" />';
			htms += '</dn> ';
			htms += '<dm class="'+property+'">';
			htms += 'Price: '
			htms += '<input readonly type="text" class="inputform" onkeydown="chknum(this,event);" maxlength="6" id="size_price'+price+'" name="price['+property+']" value="'+price+'" />';
			htms += '</dm>';
			htms += '<a style="margin-left:-25px;"  class="remove" href="javascript:void(0)" id="'+property+'"><span  class="glyphicons bin"> </span><br /></a></div>';

			$("#sizeOption").prepend(htms);
			$('#size_property').val('');
			$('#size_units').val('');
			$('#size_price').val('');

			$("#"+property).live('click',function(){
				//alert(this.id);
				//$("."+property).remove();
				//$("."+unit).remove();
				//$("."+price).remove();
				//$("#"+property).remove();
				$("#tot"+property).remove();
				return false;
			});
		}

	}


}


function removesizeoption(id)
{
	$(".size"+id).remove();
	$(".unit"+id).remove();
	$(".price"+id).remove();
	$("#remove"+id).remove();
}


function chknum(field,e)
{
    var val = field.value;
    var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
    var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
    if (re.test(val)) {
        //do something here

    } else {
        val = re1.exec(val);
        if (val) {
            field.value = val[0];
        } else {
            field.value = "";
        }
    }
}

function paypalchk()
{
	paypalid = $("#paypal_id").val();
	if($.trim(paypalid)=="")
		{
			$("#erralrt").show();
			$("#erralrt").html("Enter paypal id");
			setTimeout(function() {
				  $('#erralrt').fadeOut('slow');
				}, 5000);
			return false;
		}
	else if(!(isValidEmailAddress(paypalid))){
		$("#erralrt").show();
		$("#erralrt").html("Enter valid paypal id");
		setTimeout(function() {
			  $('#erralrt').fadeOut('slow');
			}, 5000);
		return false;
	}
}

function stripechk()
{
	var secret = $("#stripe_secret").val();

	var publish = $("#stripe_publish").val();
	var splitSecret = secret.split('_');
	var splitPublish = publish.split('_');

	if($.trim(publish)=="")
	{
		$("#erralrt").show();
		$("#erralrt").html("Enter Stripe Publishable Key");
		setTimeout(function() {
			  $('#erralrt').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(secret)=="")
	{
		$("#erralrt").show();
		$("#erralrt").html("Enter Stripe Secret Key");
		setTimeout(function() {
			  $('#erralrt').fadeOut('slow');
			}, 5000);
		return false;
	}


}

function bt_account_update() {
	var c_code = $("#currency_code").val();
	var ma_id = $("#merchant_account_id").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	if($.trim(c_code)=="")
	{
		$("#accounterr_alrt").show();
		$("#accounterr_alrt").removeAttr('data-trn-key');
		$("#accounterr_alrt").html("Select currency code");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#accounterr_alrt').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(ma_id)=="")
	{
		$("#accounterr_alrt").show();
		$("#accounterr_alrt").removeAttr('data-trn-key');
		$("#accounterr_alrt").html("Enter the valid account id");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#accounterr_alrt').fadeOut('slow');
			}, 5000);
		return false;
	}
}

function select_all_mod()
{

	chk = $("#sel_all").prop("checked");

	if (chk==true) {

	$("input[type=checkbox]").each(function() {
		    $(this).prop('checked', true);
			$(this).attr("checked","true");
		});
		//code
	}
	else
	{
		$("input[type=checkbox]").each(function() {
			$(this).prop('checked', false);
			$(this).removeAttr("checked");
		});
	}
}

function validate_news()
{
	news_key = $("#nkey").val();
	news_username = $("#uname").val();
	if($.trim(news_key)=="")
	{
		$("#newserr").show();
		$("#newserr").html("Enter YMLP key value");
		setTimeout(function() {
			  $('#newserr').fadeOut('slow');
			}, 5000);
		return false;
	}
	else if($.trim(news_username)=="")
	{
		$("#newserr").show();
		$("#newserr").html("Enter YMLP username");
		setTimeout(function() {
			  $('#newserr').fadeOut('slow');
			}, 5000);
		return false;
	}
}

function passwordconfirm(){
	var data = $('#passchk').serialize();
	var password=$('#passw').val();
	var rpassword=$('#confirmpass').val();
	var expassword = $("#exispass").val();
	//alert(password);
	//alert(data);
	if(expassword==password)
		{
		$("#alert").show();

		$('#alert').text('Existing and new password can not be same');
		$('#save_password').attr('disabled','disabled');
		 $('#passw').val("");
		 $('#confirmpass').val("");
		 $("#exispass").val("");
		return false;
		}

	if(password == ''){
		$("#alert").show();

		$('#alert').text('password is not empty');
		$('#save_password').attr('disabled','disabled');
		 $('#passw').val("");
		 $('#confirmpass').val("");
		 $("#exispass").val("");

		return false;
	}
	if(password.length < 6){
		$("#alert").show();

		$('#alert').text('Password must be greater than 5 characters long.');
		$('#save_password').attr('disabled','disabled');
		 $('#passw').val("");
		 $('#confirmpass').val("");
		 $("#exispass").val("");
		return false;
	}
	if(rpassword == ''){
		$("#alert").show();

		$('#alert').text('Confirm password is not empty!');
		$('#save_password').attr('disabled','disabled');
		 $('#passw').val("");
		 $('#confirmpass').val("");
		 $("#exispass").val("");

		return false;
	}
	if(password != rpassword){
		$("#alert").show();

		$('#alert').text('Password and confrim password is not match');
		$('#save_password').attr('disabled','disabled');
		 $('#passw').val("");
		 $('#confirmpass').val("");
		 $("#exispass").val("");
		return false;
	}

}

function deleterecipient(tid)
{

$baseurl = getBaseURL();

if(confirm("Are you sure want to delete this Recipient?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/deleterecipient/"+tid,
      type: "post",
      dataType: "html",
      success: function(){

          $("#del_"+tid).remove();

      },
    });
	}

	return false;
}
function check_recipient()
{
	recipname = $("#recipient_name").val();
	if($.trim(recipname)=="")
		{
		$("#reciperr").show();
		$("#reciperr").html("Enter Recipient Name");
		setTimeout(function() {
			  $('#reciperr').fadeOut('slow');
			}, 5000);
		return false;
		}
		else if(!isNaN(recipname))
		{
		$("#reciperr").show();
		$("#reciperr").html("Enter only characters for  Recipient Name");
		setTimeout(function() {
			  $('#reciperr').fadeOut('slow');
			}, 5000);
		return false;
		}
}


function deletelanguage(lid){
	//alert(BaseURL+'deleteusrdetls');

	$baseurl = getBaseURL();

if(confirm("Are you sure want to delete this Language?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/deletelanguage/"+lid,
      type: "post",
      dataType: "html",
      success: function(){

         // $("#del_"+lid).remove();
         var managelanguagetable = $('#managelanguagetable').DataTable();
          managelanguagetable.row($('#del_' + lid)).remove().draw();
      },
    });
	}



	return false;
}

function refundorderamount(text,oid)
{
	if (text == 1) {
		var co_text = "Are you sure want to refund this Order?";
	}
	if (text == 2) {
		var co_text = "Are you sure want to confirm this Order?";
	}

	$baseurl = getBaseURL();
	if(confirm(co_text)) {

		$.ajax({
			url: $baseurl+"/admins/admins/refundamount/"+oid+"/"+text,
			type: "post",
			dataType: "html",
			success: function(responce){

				$("#del_"+oid).remove();
				window.location = $baseurl+"refundedorders/";
			},
			error : function()
			{
      	//alert('error'); return false;
      }
  	});
	}



}





function solveorder(oid)
{

	$baseurl = getBaseURL();

if(confirm("Are you sure want to solve this Order?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/solveorder/"+oid,
      type: "post",
      dataType: "html",
      success: function(){

          $("#del_"+oid).remove();

      },
    });
	}



	return false;
}
function deletefaq(fid){
$baseurl = getBaseURL();

if(confirm("Are you sure want to delete this FAQ?")) {

	$.ajax({
      url: $baseurl+"/admins/admins/deletefaq/"+fid,
      type: "post",
      dataType: "html",
      success: function(){
         // $("#del_"+fid).remove();
           var faqtable = $('#faqtable').DataTable();
          faqtable.row($('#del_' + fid)).remove().draw();

      },
    });
	}



	return false;
}
function addfaqform(){
	var question = $('#faq_question').val();
	var answer = $('#faq_answer').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	if($.trim(answer) == '' && $.trim(question) == ''){
		$('#faqrerr').removeAttr('data-trn-key');
		$('#faqrerr').html('Please fill all the fields');
		translator.lang(sessionlang);
		$("#faqrerr").show();
		 setTimeout(function(){
			   $('#faqrerr').fadeOut();
			}, 5000);
		 return false;
	}
	if($.trim(question) == ''){
		$('#faqrerr').removeAttr('data-trn-key');
		$('#faqrerr').html('Please enter the question');
		translator.lang(sessionlang);
		$("#faqrerr").show();
		$("#faq_question").keydown(function(){
			$("#faqrerr").hide();
		});
		return false;
	}
	if($.trim(question).length < 10){
		$("#faqrerr").show();
		$("#faq_question").focus();
		$('#faqrerr').removeAttr('data-trn-key');
		$('#faqrerr').text('FAQ Question should be atleast 10 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#faqrerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(question).length > 50){
		$("#faqrerr").show();
		$("#faq_question").focus();
		$('#faqrerr').removeAttr('data-trn-key');
		$('#faqrerr').text('FAQ Question should not exceed 50 characters');
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#faqrerr').fadeOut('slow');
			}, 5000);
		return false;
	}
	if($.trim(answer) == ''){
		$('#faqrerr').removeAttr('data-trn-key');
		$('#faqrerr').html('Please enter the answer');
		translator.lang(sessionlang);
		$("#faqrerr").show();
		$("#faq_answer").keydown(function(){
			$("#faqrerr").hide();
		});
		return false;
	}

$('#faqrerr').html('');
}
function generatecoupon()
{

		var baseurl = getBaseURL()+'admins/admins/generatecoupons/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){

			          var respon = $.trim(responce)
			          $('#couponcodes').val(respon);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      },
			error: function (){ alert('error'); }
			    });
		}
}
function couponform()
{


var couponcodes = $('#couponcodes').val();

		var couponrange = $('#couponrange').val();
		var coupontype = $('.coupontype').val();
		var amountss = $('#amountss').val();

		sdate = $("#deal-start").val();
		edate = $("#deal-end").val();
		//da = $.mydatepicker.formatDate('yy/mm/dd', new Date()); alert(da); return false;
		//today = Date.parse(da);
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){
    dd='0'+dd;
}
if(mm<10){
    mm='0'+mm;
}
var da = mm+'/'+dd+'/'+yyyy;
today = Date.parse(da);
		sd = Date.parse(sdate);
		ed = Date.parse(edate);


		if(couponcodes == ''){
			$("#couponerr").show();
			$("#couponerr").html("Please enter the Coupon code");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(couponrange == ''){
			$("#couponerr").show();
			$("#couponerr").html("Please enter the Coupon Usage Count");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(isNaN(couponrange))
		{
		$("#couponerr").show();
			$("#couponerr").html("Please enter the valid Coupon Usage Count");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}

		if(couponrange == 0){
			$("#couponerr").show();
			$("#couponerr").html("Please enter the Correct Coupon Usage Count");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(coupontype == ''){
			$("#couponerr").show();
			$("#couponerr").html("Please enter the Coupon Type");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(sdate=='')
		{
			$("#couponerr").show();
			$("#couponerr").html("Please enter start date");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(edate=='')
		{
			$("#couponerr").show();
			$("#couponerr").html("Please enter end date");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(today>sd)
		{
			$("#couponerr").show();
			$("#couponerr").html("Please select starting date above today date");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(sd>ed)
		{
			$("#couponerr").show();
			$("#couponerr").html("Please select end date above the starting date");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(amountss == ''){
			$("#couponerr").show();
			$("#couponerr").html("Please enter the discount Amount");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(isNaN(amountss))
		{
			$("#couponerr").show();
			$("#couponerr").html("Please enter valid the Discount Amount");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(amountss == 0){
			$("#couponerr").show();
			$("#couponerr").html("Please Give Correct Discount Amount");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		if(amountss >= 100){
			$("#couponerr").show();
			$("#couponerr").html("Please Give Discount Amount in Below 100");
			setTimeout(function() {
				  $('#couponerr').fadeOut('slow');
				}, 5000);
			return false;
		}
		}




function validsigninfrm() {

	var email=$('#email').val();
	var password=$('#password').val();

	if(email == ''){
		$("#alert_em").show();
		$("#badMessage").hide();
		$('#alert_em').text('Email is required');
		$('#email').focus(function() {
			$('#alert_em').hide();
		});
		/*$('#email').keydown(function() {
			$('#alert_em').hide();
		});*/
		return false;
	}
	if(!(isValidEmailAddress(email))){
		$("#alert_em").show();
		$("#badMessage").hide();
		$('#email').val("");
		$('#alert_em').text('Enter a valid email');
		$('#email').focus(function() {
			$('#alert_em').hide();
		});
		return false;
	}

	//alert(isUserActive(email));

	/*if((isUserActive(email) == 0)){
		$("#alert_em").show();
		$("#badMessage").hide();
		$('#email').val("");
		$('#alert_em').text('This user is not active or dont have access');
		$('#email').focus(function() {
			$('#alert_em').hide();
		});
		return false;
	}*/
	if(password == ''){
		$("#alert_pass").show();
		$("#alert_em").hide();
		$("#badMessage").hide();
		$('#alert_pass').text('Password is required');
		$('#password').focus(function() {
			$('#alert_pass').hide();
		});
		/*$('#password').keydown(function() {
			$('#alert_pass').hide();
		});*/
		return false;
	}


}
function isUserActive(email)
{
	var BaseURL=getBaseURL();

	$.ajax({
			type: "post",
			url: BaseURL+"/admins/admins/searchactiveuser/"+email,
			dataType: "html",
			async:false,

			success: function(response) {

				result = response;
				alert(result);
			},
			error: function() {
             alert("There was an error. Try again please!");
     	   }
		});
	return 2;
}
function mailform()
{
var notification_email = $('#notification_email').val();
		var support_email = $('#support_email').val();
		var noreply_name = $('#noreply_name').val();
		var noreply_email = $('#noreply_email').val();
		var smtp_port = $('#smtp_port').val();

		if(notification_email == ''){
			alert('Please select the e-mail for notifications');
			return false;
		}
		if(support_email == ''){
			alert('Please select the support email');
			return false;
		}
		if(!(isValidEmailAddress(notification_email))){
			alert('Enter The Valid notification email');
			return false;
		}
		if(!(isValidEmailAddress(support_email))){
			alert('Enter The Valid support email');
			return false;
		}
		if(noreply_name == ''){
			alert('Please enter the no-reply name');
			return false;
		}
		if(noreply_email == ''){
			alert('Please enter the no-reply email');
			return false;
		}
		if(!(isValidEmailAddress(noreply_email))){
			alert('Enter The Valid no-reply email');
			return false;
		}
		if(isNaN(smtp_port)){
			alert('Enter The Valid port no');
			return false;
		}
}


function Price(){
	//alert('hai');
	$('.adminitemerror').html('');
	var price1 = $("#inputform1").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	if($.trim(price1)=="")
	{
		$("#priceerr").show();
		$("#priceerr").removeAttr('data-trn-key');
		$("#priceerr").html("Enter Rate");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}
else if($.trim(price1)<=0)
	{
		$("#priceerr").show();
		$("#priceerr").removeAttr('data-trn-key');
		$("#priceerr").html("Give valid rate");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
	}

	else if (isNaN(price1)){
$("#priceerr").show();
$("#priceerr").removeAttr('data-trn-key');
		$("#priceerr").html("Give valid rate");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#priceerr').fadeOut('slow');
			}, 5000);
		return false;
}
else
{
	$("#priceerr").html("");
return true;
}
}
function srchAffiliate()
{

var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
		/*if(startddates>endDates){
			alert('End date must be greater');
			return false;
		}*/

		var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admins/admins/searchaffiliate/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){

			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      },
error:function(){  alert('error'); },
			    });
		}
}


function delete_affiliate() {
var BaseURL=getBaseURL();
	var items = [];

	$('input:checkbox.shareditem').each(function () {
		var sThisVal = (this.checked ? $(this).val() : "");
		if (sThisVal != ""){
			items.push(sThisVal);
		}
	});
	if(items=="")
	{
			$("#delerr").show();
			setTimeout(function() {
				  $('#delerr').fadeOut('slow');
				}, 5000);
	}
	else
	{

		if (items.length > 0 && confirm("Are you sure want to delete "+items.length+" item(s) ?")){

			$.ajax({
				type: "post",		// Request method: post, get
				url: BaseURL+"/admins/admins/deleteaffiliateitems/"+items,	// URL to request
				//data:{'result':items},
				dataType: "html",	// Expected response type

				success: function(response) {

					window.location = BaseURL+"shareditems/";
				},

			});
		}
		console.log(items);
	}
}


function srchReport()
{

var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
		/*if(startddates>endDates){
			alert('End date must be greater');
			return false;
		}*/

		var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admins/admins/searchreport/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){

			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      },
error:function(){  alert('error'); },
			    });
		}
}


function delete_report() {
var BaseURL=getBaseURL();
	var items = [];

	$('input:checkbox.shareditem').each(function () {
		var sThisVal = (this.checked ? $(this).val() : "");
		if (sThisVal != ""){
			items.push(sThisVal);
		}
	});
	if(items=="")
	{
			$("#delerr").show();
			setTimeout(function() {
				  $('#delerr').fadeOut('slow');
				}, 5000);
	}
	else
	{

		if (items.length > 0 && confirm("Are you sure want to delete "+items.length+" item(s) ?")){

			$.ajax({
				type: "post",		// Request method: post, get
				url: BaseURL+"/admins/admins/deleteaffiliateitems/"+items,	// URL to request
				//data:{'result':items},
				dataType: "html",	// Expected response type

				success: function(response) {

					window.location = BaseURL+"reportitems/";
				},

			});
		}
		console.log(items);
	}
}

function srchnonapproveditems()
{

        var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	if(startddates =="")
	{
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("Select start date");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(endDates =="")
	{
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("Select end date");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(startddates>endDates){
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("End date must be greater");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	$("#errmsg").html("");

		//var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admins/admins/srchnonapproveditems/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates},
			      //data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){

			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      },
error:function(){  alert('error'); },
			    });
		}
}

function delete_nonapproveditem() {
var BaseURL=getBaseURL();
	var items = [];
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	$("#errmsg").html("");
	$('input:checkbox.shareditem').each(function () {
		var sThisVal = (this.checked ? $(this).val() : "");
		if (sThisVal != ""){
			items.push(sThisVal);
		}
	});
	if(items=="")
	{
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("Please select the items to delete");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
	{$("#errmsg").html("");

		if (items.length > 0 && confirm("Are you sure want to delete "+items.length+" item(s) ?")){

			$.ajax({
				type: "post",		// Request method: post, get
				url: BaseURL+"/admins/admins/deleteaffiliateitems/"+items,	// URL to request
				//data:{'result':items},
				dataType: "html",	// Expected response type

				success: function(response) {

					window.location = BaseURL+"nonapproveditems/";
				},

			});
		}
		console.log(items);
	}
}

function resetnonapproveditems()
{
	$('#deal-start').val("");
	$('#deal-end').val("");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	$('#deal-start').datepicker('setDate', null);
	$('#deal-end').datepicker('setDate', null);

	   var startddates = $('#deal-start').val();
       var endDates = $('#deal-end').val();

	if(startddates>endDates){
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("End date must be greater");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
$("#errmsg").html("");
		var baseurl = getBaseURL()+'admins/admins/srchnonapproveditems/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates},
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){

			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      },
error:function(){  alert('error'); },
			    });
		}

}

function resetapproveditems()
{
	$('#deal-start').val("");
	$('#deal-end').val("");

	$('#deal-start').datepicker('setDate', null);
	$('#deal-end').datepicker('setDate', null);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	    var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();

	if(startddates>endDates){
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("End date must be greater");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
$("#errmsg").html("");
		var baseurl = getBaseURL()+'admins/admins/srchapproveditems/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates},
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){

			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      },
error:function(){  alert('error'); },
			    });
		}
}


function srchapproveditems()
{

var startddates = $('#deal-start').val();
		var endDates = $('#deal-end').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
   if(startddates =="")
	{
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("Select start date");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	if(endDates =="")
	{
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("Select end date");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}

	if(startddates>endDates){
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("End date must be greater");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
$("#errmsg").html("");
		/*if(startddates>endDates){
			alert('End date must be greater');
			return false;
		}*/

		//var serchkeywrd = $('#serchkeywrd').val();
		var baseurl = getBaseURL()+'admins/admins/srchapproveditems/';
		if (invajax == 0) {
			invajax = 1;
			$.ajax({
			      url: baseurl,
			      type: "post",
			      dataType: "html",
			      data : { 'startdate': startddates,'enddate': endDates},
			      //data : { 'startdate': startddates,'enddate': endDates,'serchkeywrd': serchkeywrd},
			      //data: "startdate:"+startddates+"enddate:"+endDates+"serchkeywrd:"+serchkeywrd,
			      beforeSend: function () {
			    	  $('#loading_img').show();
			      },
			      success: function(responce){

			          $('#searchite').html(responce);
			    	  $('#loading_img').hide();
			          invajax = 0;
			      },
error:function(){  alert('error'); },
			    });
		}
}

function delete_approveditem() {
var BaseURL=getBaseURL();
	var items = [];
		var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});

	$('input:checkbox.shareditem').each(function () {
		var sThisVal = (this.checked ? $(this).val() : "");
		if (sThisVal != ""){
			items.push(sThisVal);
		}
	});

	if(items=="")
	{
		$("#errmsg").show();
		$("#errmsg").removeAttr('data-trn-key');
		$("#errmsg").html("Please select the items to delete");
		translator.lang(sessionlang);
		setTimeout(function() {
			  $('#errmsg').fadeOut('slow');
			}, 5000);
		return false;
	}
	else
	{
		$("#errmsg").html("");
		if (items.length > 0 && confirm("Are you sure want to delete "+items.length+" item(s) ?")){

			$.ajax({
				type: "post",		// Request method: post, get
				url: BaseURL+"/admins/admins/deleteaffiliateitems/"+items,	// URL to request
				//data:{'result':items},
				dataType: "html",	// Expected response type

				success: function(response) {

					window.location = BaseURL+"approveditems/";
				},

			});
		}
		console.log(items);
	}
}


function disputestatus(uoid,resolvestatus){
	$baseurl = getBaseURL();
	if (confirm("Are you sure you want to Change this Dispute? ")) {

	var selector = '.resolvestatus'+uoid;
	var status = '.status'+uoid;
	var resolvestatus = $(selector).val();

	//var uoid = $('#uoid :selected').val();
	//var status = $(select).val();
	//alert(selector);alert(status);alert(resolvestatus);
	$(status).html(resolvestatus);


	$.ajax({
	      url:$baseurl+"/admins/admins/dispstatus/"+uoid+"/"+resolvestatus,
	      type: "post",
		  dataType: "html",



	});
	return true;
	}return false;
}

function disputestatuscurrent(disid,statuscurrent){
	//alert(disid);
	$baseurl = getBaseURL();
	if (confirm("Are you sure you want to Change this Dispute? ")) {

	var selector = '.statuscurrent'+disid;
	var status = '.status'+disid;
	var statuscurrent = $(selector).val();
	//var uoid = $('#uoid :selected').val();
	//var status = $(select).val();
	//alert(selector);
	//alert(status);
	//alert(statuscurrent);



	$.ajax({
	    url:$baseurl+"/admins/admins/dispcurrentstatus/"+disid+"/"+statuscurrent,
	      type: "post",
		  dataType: "html",

	      success:function(result){
	    	  $("#scatgys"+disid).remove();

	        }

	});
	return true;
	}return false;
}


function validateaddurl() {

	var androidurl = $('#androidLink').val();
	var iosurl = $('#iosLink').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({t: dict});
	//alert(image); alert(url);
	//var regexp = /^(ftp:\/\/|http:\/\/|https:\/\/)?(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!-\/]))?$/;
	//var regexp = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;

	$('.error').html("");

	if (androidurl == ''){
		$('.addurlerror').removeAttr('data-trn-key');
		$('.addurlerror').html("Enter Android App Url").css("color", "red");
		translator.lang(sessionlang);
		return false;
	}else if (iosurl == ''){
		$('.addurlerror').removeAttr('data-trn-key');
		$('.addurlerror').html("Enter IOS App Url").css("color", "red");
		translator.lang(sessionlang);
		return false;
	}else{
		$('.addurlerror').html("");
		return true;
	}
}

 function addcurrencyCode()
    {

        var currencyCode = $('#currency_code').val();
        var BaseURL =  getBaseURL();

         $.ajax({
            type: "post",       // Request method: post, get
            url: BaseURL+"/admins/admins/currency_code/"+currencyCode,   // URL to request
            dataType: "html",   // Expected response type

            success: function(response) {



                 var braintree_settings = JSON.parse(response);
                 if(braintree_settings){
                // $("#merchant_id").val(braintree_settings['merchant_id']);
                  $("#merchant_account_id").val(braintree_settings['merchant_account_id']);
              //  $("#braintree_public").val(braintree_settings['public_key']);
              //  $("#braintree_private").val(braintree_settings['private_key']);



                }
                else{

                    $("#merchant_account_id").val("");
               // $("#braintree_public").val("");
                //$("#braintree_private").val("");
            }
           //  var myJSON = JSON.stringify(response);
            // alert(myJSON);
            },
            error: function (argument) {
                alert('fdf');
            }
        });
    }


    function currencyCode()
    {

        var currencyCode = $('#currency_code').val();
        var BaseURL =  getBaseURL();

         $.ajax({
            type: "post",       // Request method: post, get
            url: BaseURL+"/admins/admins/Braintreecurrencycode/"+currencyCode,   // URL to request
            dataType: "html",   // Expected response type

            success: function(response) {



                 var braintree_settings = JSON.parse(response);
                 if(braintree_settings){
                // $("#merchant_id").val(braintree_settings['merchant_id']);
                  $("#merchant_account_id").val(braintree_settings['merchant_account_id']);
              //  $("#braintree_public").val(braintree_settings['public_key']);
              //  $("#braintree_private").val(braintree_settings['private_key']);



                }
                else{

                    $("#merchant_account_id").val("");
               // $("#braintree_public").val("");
                //$("#braintree_private").val("");
            }
           //  var myJSON = JSON.stringify(response);
            // alert(myJSON);
            },
            error: function (argument) {
                alert('fdf');
            }
        });
    }

    function mediavalidate() {
    	var media_url = $("#media_url").val();
    	var media_server_hostname = $("#media_server_hostname").val();
    	var media_server_username = $("#media_server_username").val();
    	var media_server_password = $("#media_server_password").val();
    	var flag = 0;
    	var err_msg;
		var sessionlang = $("#languagecode").val();
		var translator = $('body').translate({t: dict});

		if($.trim(media_url)=="" || !validateURL(media_url))
		{
			err_msg = "Enter a valid URL";	flag = 1;
		} else if($.trim(media_server_hostname)=="") {
			err_msg = "Enter host name";	flag = 1;
		} else if($.trim(media_server_username)=="") {
			err_msg = "Enter user name";	flag = 1;
		} else if($.trim(media_server_password)=="") {
			err_msg = "Enter the password";	flag = 1;
		}

		if(flag == 1){
			$("#mediaerr_alrt").show();
			$("#mediaerr_alrt").removeAttr('data-trn-key');
			$("#mediaerr_alrt").html(err_msg);
			translator.lang(sessionlang);
			setTimeout(function() {
				  $('#mediaerr_alrt').fadeOut('slow');
				}, 2500);
			return false;
		}
    }

    function validateURL(textval) {
	  	var urlregex = new RegExp( "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
	  	return urlregex.test(textval);
	}
