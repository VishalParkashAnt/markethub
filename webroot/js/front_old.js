var $ = jQuery.noConflict();
//var BaseURL=getBaseURL();
var unfantid;
cartnoii = true;
pushnoii = true;
invajax = 0;
likestatusfeed = true;
var value;
var spaceCount = 0;
var sendmsgajax = 1;
var postdelete = new Array();
poststat = 1;
/********* NOTIFY ********/
$(document).ready(function () {
	setTimeout(function () {
		$(".notify-message").fadeOut('slow');
	}, 2000);
	setTimeout(function () {
		$(".payment-failure").fadeOut('slow');
	}, 5000);
	setTimeout(function () {
		$(".invaliduser").fadeOut('slow');
	}, 2000);
	$(".numbersonly").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
});
$(window).scroll(function () {
	if ($(this).scrollTop() > 300) {
		$('#backtotop').fadeIn();
	} else {
		$('#backtotop').fadeOut();
	}
});
function isNumberdot(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
		return false;
	}
	return true;
}
$(document).on('click', '#backtotop', function () {
	$('body,html').animate({
		scrollTop: 0
	}, 500, "linear");
});
$(function () {
	$('#fname').keydown(function (e) {
		var value = $("#fname").val();
		value = value.replace(/\s+/g, ' ');
		$("#fname").val(value);
	});
	$('#btn-doneid').click(function () {
		var BaseURL = getBaseURL();
		var id = unfantid;
		var data = $('.categorycls').serialize();
		$.post(BaseURL + 'totaladduserlist', {
			"alldata": data,
			"itemid": id
		},
		function (datas) {
			$('#popup_container').hide();
			$('#popup_container').css({
				"opacity": "0"
			});
			$("#add-to-list").modal('hide');
		}
		);
	});
	$('.btn-unfancy').click(function () {
		var BaseURL = getBaseURL();
		var id = unfantid;
		var likedbtncnt = $("#likedbtncnt").val();
		var likebtncnt = $("#likebtncnt").val();
		unfant = false;
		$.post(BaseURL + 'userUnlike', {
			"itemid": id
		},
		function (datas) {
			$(".like-counter").html(datas);
			$("input[type=checkbox]").removeAttr('checked');
			$(".like-icon").removeClass("fa-heart");
			$(".like-icon").addClass("fa-heart-o");
			$(".like-txt").html(likebtncnt);
			return false;
		}
		);
		$("#add-to-list").modal('hide');
	});
// 	$(document).on('click', "#facebooksharebtn", function () {
// //var link   = $(this).attr('href');
// var link = $('#discount_fb_share_url').html();
// var BaseURL = getBaseURL();
// var urlss = BaseURL + 'listing/' + link;
// var image = $('#fullimgtag').attr('src');
// var desc = $('#item-descript').val();
// var title = $('#fullimgtag').attr('title');
// var itemId = $('#listingid').val();
// var shopId = $('#merchantid').val();
// var appID = $("#default_fb_appid").val();
// var encry_urlss = encodeURIComponent(urlss);
// var redirect_url = BaseURL + 'sociallogin/' + itemId + '/' + shopId;
// console.log(appID);return false;
// newwindow = window.open('https://www.facebook.com/dialog/share?app_id=' + appID + '&display=popup&href=' + encry_urlss + '&redirect_uri=' + encry_urlss, 'name', 'height=600,width=600');

// $.ajax({
// 	url: BaseURL + 'sociallogin',
// 	type: 'post',
// 	data: {
// 		'itemId': itemId,
// 		'shopId': shopId
// 	},
// 	beforeSend: function () {
// 		$('#popup_container').show();
// 		$('#popup_container').css({
// 			"opacity": "1"
// 		});
// 		$(".loading-coupon").show();
// 		$('#facebook_coupon').show();
// 	},
// 	success: function (data) {
// //console.log(data);
// if (data != 'false') {
// 	$('#share-social').hide();
// 	$('#slideshow-box').hide();
// 	$('#popup_container').show();
// 	$('#popup_container').css({
// 		"opacity": "1"
// 	});
// 	$(".loading-coupon").hide();
// 	$('#new-couponcode').html('Your coupon code - <span class="red-txt">'+data+'</div>');
// 	$('#facebook_coupon').show();
// 	$('#facebooksharebtn').hide();
// }
// }
// });
// return false;
// });
	$(document).on('click', '#reportflag', function () {
		$("#reportflag").attr("disabled", "disabled");
		var baseurl = getBaseURL();
		var sessionlang = $("#languagecode").val();
		var loguserid = $("#loguserid").val();
		if (loguserid == 0) {
			window.location.href = baseurl + "login";
		} else {
			var itemid = $("#featureditemid").val();
			$.ajax({
				url: baseurl + 'reportitem',
				type: "GET",
				data: {
					'itemid': itemid,
					'userid': loguserid
				},
				success: function (responce) {
					$("#reportflag").removeAttr("disabled");
					var data = '<i class="fa fa-flag-o"></i><span class="trn" data-toggle="modal" data-target="#undoreport_order">Undo reporting</span>';
					$('.reportitem').html(data);
					$("#report_order").modal('hide');
					translator.lang(sessionlang);
				}
			});
		}
	});
	$(document).on('click', '#unreportflag', function () {
		$("#unreportflag").attr("disabled", "disabled");
		var baseurl = getBaseURL();
		var loguserid = $("#loguserid").val();
		if (loguserid == 0) {
			window.location.href = baseurl + "login";
		} else {
			var itemid = $("#featureditemid").val();
			var sessionlang = $("#languagecode").val();
			$.ajax({
				url: baseurl + 'undoreportitem',
				type: "GET",
				data: {
					'itemid': itemid,
					'userid': loguserid
				},
				success: function (responce) {
					$("#unreportflag").removeAttr("disabled");
					var data = '<i class="fa fa-flag-o"></i><span class="trn" data-toggle="modal" data-target="#report_order">Report Inappropriate</span>';
					$('.reportitem').html(data);
					$("#undoreport_order").modal('hide');
					translator.lang(sessionlang);
				}
			});
		}
	});
	$(document).on('change', '#queryaboutitem', function (e) {
		if ($(this).val() == 'others') {
			$('.cs-subject').slideDown('fast');
		} else {
			$('.cs-subject').slideUp('fast');
		}
	});
	$(document).on("click", '.usernamegroup', function () {
//alert('working111');
var currentUser = $(this).text();
//alert(currentUser);
//var currentclass = $(this).attr('class'); var classvalue = '.' +currentclass; var currentUserid = $(classvalue).val(); alert(currentUserid);
var accessClass = '.' + currentUser;
var accessClassemail = '.' + currentUser;
var currentUserid = $(accessClass).val();
var currentUseremail = $(accessClassemail).val();
//alert(currentUseremail);
var loading = ".shipchload";
var username = currentUser;
var usid = currentUserid;
//var cemail = currentUseremail;
var name = ".name";
var email = ".comment_msgemail";
var addr1 = ".address1";
var addr2 = ".address2";
var country = ".countrygg";
var state = ".stategg";
var city = ".citygg";
var zip = ".zipcodegg";
var phone = ".telephonegg";
var img = ".show_url";
var cimg = ".image_computer";
//alert(cemail);
var Baseurl = getBaseURL();
var baseurl = getBaseURL() + 'ajaxUsergroupgiftcard/' + '&name=' + usid + '&email=' + usid;
$.ajax({
	url: baseurl,
	type: 'post',
	data: {
		'currentUserid': currentUserid,
		'username': username
	},
	beforeSend: function () {
		$(loading).show();
	},
	success: function (data) {
// var cemails = data;
// alert( "Data Saved: " + data);
altimg = 'usrimg.jpg';
// var exa = document.getElementById(cemail).value;
// var emailslist = document.getElementById('data').innerHTML = '';
// alert(cemails);
var splitResult = data.split("#");
var userid = splitResult[0];
var username = splitResult[1];
var useremail = splitResult[2];
var address1 = splitResult[3];
var address2 = splitResult[4];
var country = splitResult[5];
var state = splitResult[6];
var city = splitResult[7];
var zip = splitResult[8];
var phone = splitResult[9];
var image_computer = splitResult[10];
var cid = splitResult[11];
// alert(userid);alert(username);alert(useremail);
$('#name').attr('value', username);
$("#comment_msgemail").val(useremail);
//$('#comment_msgemail').attr('value', useremail);
$('#address1').attr('value', address1);
$('#address2').attr('value', address2);
// $('#countrygg').attr('option', country);
$('#stategg').attr('value', state);
$('#citygg').attr('value', city);
$('#zipcodegg').attr('value', zip);
$('#telephonegg').attr('value', phone);
// $('#show_url').attr('value',image_computer);
if (image_computer != altimg) {
//$('#show_url').attr('src',Baseurl + "media/avatars/thumb70/"+image_computer);
pro_img = "url(" + Baseurl + "media/avatars/thumb70/" + image_computer + ")";
$('#show_url.gg-userimg').css('backgroundImage', pro_img);
//alert(pro_img);
} else {
//$('#show_url').attr('src',Baseurl + "media/avatars/thumb70/"+altimg);
pro_img = "url(" + Baseurl + "media/avatars/thumb150/" + altimg + ")";
$('#show_url.gg-userimg').css('backgroundImage', pro_img);
//alert(pro_img);
}
$('#image_computer').attr('value', image_computer);
// $('#countrygg').append($('<option>').text(value).attr('value', country));
//$('#countrygg option:selected').text(country);
//$("#countrygg").text(country);
cnt = 0;
for (i = 0; i < document.getElementById("countrygg").length; ++i) {
	if (document.getElementById("countrygg").options[i].value == cid) {
		cnt++;
	}
}
if (cnt != 1) {
	alert("Product can not be shipped");
	window.location.reload();
}
$("#countrygg option[value=" + cid + "]").attr('selected', 'selected');
//	$("#countrygg :selected").val(cid);
//$("#countrygg :selected").text(country);
//var option = $("<option></option>").text(country[0]).val(item[1]);
//  $("sub_item").append(option);
$(loading).hide();
//$('.'+autocompid).hide();
}
});
return false;
});
	$('#ggamt').keydown(function (e) {
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
	$('#list_createid').click(function () {
		var BaseURL = getBaseURL();
		var id = unfantid;
		var newlist_val = $("#new-create-list").val();
		if ($.trim(newlist_val) != "" && typeof (newlist_val != 'undefined')) {







			$.post(BaseURL + 'adduserlist', {
				"itemid": id,
				"newlist": newlist_val
			},
			function (datas) {
				datas = $.trim(datas);
				datas = datas.split('-_-');
				if (datas[1] != '' && typeof (datas[1] != 'undefined')) {
					if (datas[1] == 'exists') {
						$("#existslisterr").show();
						setTimeout(function () {
							$('#existslisterr').fadeOut('slow');
						}, 5000);
						return false;
					} else {
						var appval = '<div class="checkbox checkbox-primary padding-bottom15 edit_popup_border margin-bottom20"><input id="' + datas[0] + '" name="category_items[]" value="' + datas[1] + '" type="checkbox"><label for="' + datas[0] + '">' + datas[1] + '</label></div>';
						$(".appen_div").append(appval);
						document.getElementById('new-create-list').value = "";
						return false;
					}
				}
			}
			);
		} else {
			$("#listerr").show();
			setTimeout(function () {
				$('#listerr').fadeOut('slow');
			}, 5000);
			return false;
		}
	});
	$(document).on('click', '#gglistdone', function () {
		var lastestidgg = $('#lastestidgg').val();
		if (lastestidgg != "") {
			var baseurl = getBaseURL();
			baseurl += "gifts/" + lastestidgg;
			window.location = baseurl;
		}
	});
	$(document).on('keyup', '#bio', function () {
		var maxLen = 180;
//alert(maxLen);
var bio = $('#bio').val();
if ($.trim(bio).length >= maxLen) {
//var msg = "You have reached your maximum limit of characters allowed";
//alert(msg);
document.getElementById('bio').value = $.trim(bio).substring(0, maxLen);
$('#biodata_tex').css('color', 'red');
$('#biodata_tex').show();
$('#biodata_tex').text('You have reached your maximum limit of characters allowed');
$("#text_num").html("0");
var sessionlang = $("#languagecode").val();
var translator = $('body').translate({
	t: dict
});
translator.lang(sessionlang);
return false;
} else {
	$("#text_num").html(maxLen - $.trim(bio).length);
	$('#biodata_tex').hide();
}
});
	$(document).on('keyup', '#message', function () {
		var $th = $(this);
		$th.val($th.val().replace(/ +(?= )/g, function (str) {
			return '';
		}));
		var maxLen = 500;
		var message = $('#message').val();
		if ($.trim(message).length >= maxLen) {
			document.getElementById('message').value = $.trim(message).substring(0, maxLen);
//$('#messageErr').css('color', 'red');
$('#messageErr').show();
$('#messageErr').html('You have reached above 500 characters');
var sessionlang = $("#languagecode").val();
var translator = $('body').translate({
	t: dict
});
translator.lang(sessionlang);
setTimeout(function () {
	$('#messageErr').fadeOut('slow');
}, 5000);
// document.getElementById('text_num').value = '0 characters left';
return false;
} else {
//document.getElementById('text_num').value = maxLen - $.trim(gift_title).length+' characters left';
$('#messageErr').hide();
}
});
	$(document).on('keyup', '#mercntcmnd', function () {
		var $th = $(this);
		$th.val($th.val().replace(/ +(?= )/g, function (str) {
			return '';
		}));
		var maxLen = 500;
		var message = $('#mercntcmnd').val();
		if ($.trim(message).length >= maxLen) {
			document.getElementById('mercntcmnd').value = $.trim(message).substring(0, maxLen);
//$('#messageErr').css('color', 'red');
$('.postcommenterror').show();
$(".postcommenterror").removeAttr('data-trn-key');
$('.postcommenterror').html('You have reached above 500 characters');
var sessionlang = $("#languagecode").val();
var translator = $('body').translate({
	t: dict
});
translator.lang(sessionlang);
setTimeout(function () {
	$('.postcommenterror').fadeOut('slow');
}, 5000);
// document.getElementById('text_num').value = '0 characters left';
return false;
} else {
//document.getElementById('text_num').value = maxLen - $.trim(gift_title).length+' characters left';
$('.postcommenterror').hide();
}
});
	$('#username').keypress(function (e) {
		var regex = new RegExp("^[a-zA-Z0-9]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}
		e.preventDefault();
		return false;
	});
	$("#username").bind('paste', function (e) {
		setTimeout(function () {
			var $th = $("#username");
			$th.val($th.val().replace(/[`^~<>@!#\$\^%&*()+=\-_\[\]\\\';,\.\/\{\}\|\":<>\?,"']/g, function (str) {
				return '';
			}).replace(/\s/g, function (str) {
				return '';
			}));
		}, 100);
	});
	$("#fname").bind('paste', function () {
		setTimeout(function () {
//get the value of the input text
var data = $('#fname').val();
//replace the special characters to ''
var dataFull = data.replace(/[^a-zA-ZÀ-ÿ\u4e00-\u9eff ]/g, '');
dataFull = dataFull.replace(/\s\s+/g, ' ');
//set the new value of the input text without special characters
$('#fname').val(dataFull);
});
	});
});
function signform() {
	var check = 0;
	var sessionlang = $("#languagecode").val();
	var data = $('#signupform').serialize();
	var fullname = $('#fullname').val();
//var lastname=$('#lastname').val();
var username = $('#user_name').val();
var email = $('#email').val();
//var signupGender = $('.genderradio:checked').val();
var password = $('#password').val();
//var terms=$('#terms').val();
//var rpassword=$('#rpassword').val();
//alert(data);
if ($.trim(fullname) == '') {
	$("#alertName").show();
	$("#badmessage").hide();
	$('#alertName').text('Name is required');
//$('#fullname').focus()
$("#fullname").val("");
$('#fullname').keydown(function () {
	$('#alertName').hide();
});
check = 1;
return false;
} else if ($.trim(fullname).length < 3) {
	$("#alertName").show();
	$("#badmessage").hide();
	$('#alertName').text('Full name must be atleast 3 characters');
//$('#fullname').focus()
$('#fullname').keydown(function () {
	$('#alertName').hide();
});
check = 1;
return false;
} else if ($.trim(username) == '') {
	$("#alertUname").show();
	$("#badmessage").hide();
	$('#alertUname').text('Username is required');
//$('#username').focus()
$('#username').keydown(function () {
	$('#alertUname').hide();
});
check = 1;
return false;
} else if ($.trim(username).length < 3) {
	$("#alertUname").show();
	$("#badmessage").hide();
	$('#alertUname').text('Username must be atleast 3 characters');
	$('#username').val("");
	$('#username').keydown(function () {
		$('#alertUname').hide();
	});
	check = 1;
	return false;
} else if ($.trim(email) == '') {
	$("#alertEmail").show();
	$("#badmessage").hide();
	$('#alertEmail').text('Email is required');
	$('#email').val();
	$('#email').keydown(function () {
		$('#alertEmail').hide();
	});
	check = 1;
	return false;
} else if (!(isValidEmailAddress(email))) {
	$("#alertEmail").show();
	$("#badmessage").hide();
	$('#alertEmail').text('Enter a valid email');
	$('#email').val("");
	$('#email').keydown(function () {
		$('#alertEmail').hide();
	});
	check = 1;
	return false;
} else if (password == '') {
	$("#alertPass").show();
	$("#badmessage").hide();
	$('#alertPass').text('Password should not empty');
//$('#password').focus()
$('#password').keydown(function () {
	$('#alertPass').text('Password must be greater than 6 characters long');
});
check = 1;
return false;
} else if (password.length < 6) {
	$("#alertPass").show();
	$("#badmessage").hide();
	$('#alertPass').text('Password must be greater than 6 characters long');
//$('#password').focus()
$('#password').keydown(function () {
	$('#alertPass').hide();
});
check = 1;
return false;
}
var translator = $('body').translate({
	t: dict
});
translator.lang(sessionlang);
/*if(terms == ''){
$("#alert").show();
$('#alert').text('Please check the Terms and Conditions');
return false;
}*/
if (check == 1) {
	$("#signerr").html("Please fill all details");
	return false;
}
return true;
}
function validforgot() {
	var email = $('#email').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (email == '') {
		$("#alert_em").removeAttr("data-trn-key");
		$('#alert_em').text('Please Enter the Email');
		translator.lang(sessionlang);
		return false;
	} else if (!isValidEmail(email)) {
		$("#alert_em").removeAttr("data-trn-key");
		$('#alert_em').text('Please Enter a valid Email');
		translator.lang(sessionlang);
		return false;
	}
	$("#alert_em").html("");
	$("#alert_em").removeAttr("data-trn-key");
	return true;
}
function validpassword() {
	var newpassword = $('#newpassword').val();
	var confirm = $('#confirm').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (newpassword == '' || confirm == '') {
		$('.addshiperror').removeAttr("data-trn-key");
		$('.addshiperror').text('Please fill out the fields');
		translator.lang(sessionlang);
		return false;
	}
	if (newpassword.length < 6) {
		$('.addshiperror').removeAttr("data-trn-key");
		$('.addshiperror').text('Password should be greater than 5 digits');
		translator.lang(sessionlang);
		return false;
	}
	if (newpassword != confirm) {
		$('.addshiperror').removeAttr("data-trn-key");
		$('.addshiperror').text('Password is not match');
		translator.lang(sessionlang);
		return false;
	}
	$('.addshiperror').html("");
	return true;
}
function searchmsg() {
	var baseurl = getBaseURL() + 'searchmessage';
	var searchkey = $('#searchkey').val();
	$('#savesearchkey').val(searchkey);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (sendmsgajax == 1) {
		$('.message-error').hide();
		sendmsgajax = 0;
		$.ajax({
			url: baseurl,
			type: "post",
			dataType: "html",
			data: {
				'searchkey': searchkey
			},
			beforeSend: function () {
				$('.msgsearchload').show();
			},
			success: function (responce) {
				$('.msgsearchload').hide();
				if ($.trim(responce) == "false") {
					$('#myorderslist').hide();
					$('.message-error').html('Try with a different keyword');
					translator.lang(sessionlang);
					$('.message-error').show();
					$('.loadmorecomment').hide();
} else if (responce != 'false') { //alert("hi");
$('#myorderslist').html(responce);
$('#myorderslist').show();
$('.loadmorecomment').show();
}
//$('.noordercmnt').html("");
//$('#mercntcmnd').val("");
sendmsgajax = 1;
loadmorecmntcnt = 10;
loadmore = 1;
$('.loadmorecomment').html('Load more messages');
translator.lang(sessionlang);
}
});
	}
}
function show_comment() {
	$("#all").slideToggle('slow');
	$("#all").show();
	$("#show_all").hide();
	$("#hide_all").show();
}
function hided_comment() {
	$("#hide_all").hide();
	$("#show_all").show();
	$("#all").slideToggle('slow');
	$("#few").show();
}
function validaddship() {
	var name = $('#fullname').val();
	var nickName = $('#nick').val();
	var country = $('#countrys').val();
	var state = $('#state').val();
	var add1 = $('#add1').val();
	var city = $('#city').val();
	var zip = $('#zip').val();
	var phone = $('#phne').val();
	var numExp = /^[0-9+-]+$/;
	var check = 0;
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (name == '') {
		$("#alert_em").show();
		$("#badMessage").hide();
		$('#alert_em').text('Full name is required');
		$('#fullname').focus()
		$('#fullname').keydown(function () {
			$('#alert_em').hide();
		});
		check = 1;
	}
	if ($.trim(name).length < 3) {
		$("#alert_em").show();
		$("#badMessage").hide();
		$('#alert_em').text('Full name must be atleast 3 characters');
		$('#fullname').focus()
		$('#fullname').keydown(function () {
			$('#alert_em').hide();
		});
		check = 1;
	}
	if (nickName == '') {
		$("#alert_nick").show();
		$("#badMessage").hide();
		$('#alert_nick').text('Enter your nickname');
		$('#nick').focus()
		$('#nick').keydown(function () {
			$('#alert_nick').hide();
		})
		check = 1;
	}
	if ($.trim(nickName).length < 3) {
		$("#alert_nick").show();
		$("#badMessage").hide();
		$('#alert_nick').text('Nick name must be atleast 3 characters');
		$('#nick').focus()
		$('#nick').keydown(function () {
			$('#alert_nick').hide();
		})
		check = 1;
	}
	if (country == '') {
		$("#alert_country").show();
		$("#badMessage").hide();
		$('#alert_country').text('Enter your country');
		$('#countrys').focus()
		$('#countrys').change(function () {
			$('#alert_country').hide();
		})
		check = 1;
	}
	if (state == '') {
		$("#alert_state").show();
		$("#badMessage").hide();
		$('#alert_state').text('Enter your state');
		$('#state').focus()
		$('#state').keydown(function () {
			$('#alert_state').hide();
		})
		check = 1;
	}
	if ($.trim(state).length < 2) {
		$("#alert_state").show();
		$("#badMessage").hide();
		$('#alert_state').text('Enter atleast 2 characters for state');
		$('#state').focus()
		$('#state').keydown(function () {
			$('#alert_state').hide();
		})
		check = 1;
	}
	if (add1 == '') {
		$("#alert_add1").show();
		$("#badMessage").hide();
		$('#alert_add1').text('Enter your address');
		$('#add1').focus()
		$('#add1').keydown(function () {
			$('#alert_add1').hide();
		})
		check = 1;
	}
	if (add1.length < 3) {
		$("#alert_add1").show();
		$("#badMessage").hide();
		$('#alert_add1').text('Enter atleast 3 characters for address');
		$('#add1').focus()
		$('#add1').keydown(function () {
			$('#alert_add1').hide();
		})
		check = 1;
	}
	if (city == '') {
		$("#alert_city").show();
		$("#badMessage").hide();
		$('#alert_city').text('Enter your city');
		$('#city').focus()
		$('#city').keydown(function () {
			$('#alert_city').hide();
		})
		check = 1;
	}
	if ($.trim(city).length < 2) {
		$("#alert_city").show();
		$("#badMessage").hide();
		$('#alert_city').text('Enter atleast 2 characters for city');
		$('#city').focus()
		$('#city').keydown(function () {
			$('#alert_city').hide();
		})
		check = 1;
	}
	if (zip == '') {
		$("#alert_zip").show();
		$("#badMessage").hide();
		$('#alert_zip').text('Enter your area code');
		$('#zip').focus()
		$('#zip').keydown(function () {
			$('#alert_zip').hide();
		})
		check = 1;
	}
	if (phone == '') {
		$("#alert_ph").show();
		$("#badMessage").hide();
		$('#alert_ph').text('Enter your phone no');
		$('#phne').focus()
		$('#phne').keydown(function () {
			$('#alert_ph').hide();
		})
		check = 1;
	}
	if (!$.trim(phone).match(numExp)) {
		$("#alert_ph").show();
		$("#badMessage").hide();
		$('#alert_ph').text('Enter numbers only');
		$('#phne').focus()
		$('#phne').keydown(function () {
			$('#alert_ph').hide();
		})
		check = 1;
	}
	translator.lang(sessionlang);
	if (check == 1) {
		$("#alert").html("Please fill all details");
		return false;
	}
	return true;
}
function validsigninfrm() {
	var email = $('#email').val();
	var password = $('#password').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (email == '') {
		$("#alert_em").show();
		$("#badMessage").hide();
		$('#email').val("");
		$('#email').addClass('alert-input');
		$('#alert_em').removeAttr("data-trn-key");
		$('#alert_em').text('Please enter your email');
		translator.lang(sessionlang);
		$('#username').focus();
		return false;
	}
	if (!(isValidEmailAddress(email))) {
		$("#alert_em").show();
		$("#badMessage").hide();
		$('#email').val("");
		$('#email').addClass('alert-input');
		$('#alert_em').removeAttr("data-trn-key");
		$('#alert_em').text('Please enter valid email');
		translator.lang(sessionlang);
		$('#username').focus();
		return false;
	}
	if (password == '') {
		$("#alert_pass").show();
		$("#alert_em").hide();
		$("#badMessage").hide();
		$('#password').addClass('alert-input');
		$('#alert_pass').text('Please enter your password');
		translator.lang(sessionlang);
		$('#password').focus();
		return false;
	}
	$('#alert_em').html("");
	$("#alert_pass").html("");
}
// Remove the error alerts at login
$(document).ready(function () {
	$('#email, #password').keyup(function () {
		$('#alert_em').html("");
		$("#alert_pass").html("");
		$('#email').removeClass('alert-input');
		$('#password').removeClass('alert-input');
	});
});
function likestatus(logid) {
	likeval = $("#like" + logid).html();
	likecountval = $("#likecountval" + logid).val();
	var baseurl = getBaseURL();
//alert(likeval);
if (likestatusfeed) {
	likestatusfeed = false;
	$.ajax({
		url: baseurl + 'like_status',
		type: "post",
		data: {
			logid: logid,
			likeval: likeval
		},
		success: function (responce) {
			resp = responce.split(" ");
			$("#like" + logid).html(resp[0]);
			likeClass = $(".like-icon" + logid);
			if (likeClass.hasClass('fa-heart')) {
//alert('hi');
likeClass.removeClass('fa-heart').addClass('fa-heart-o');
likecountval = likecountval + 1;
$('#likecnt' + logid).html(likecountval);
$("#likecountval" + logid).val(likecountval);
$('.likebox').show();
} else {
	if (likeClass.hasClass('fa-heart-o')) {
	//alert('bye');
	likeClass.removeClass('fa-heart-o').addClass('fa-heart');
	likecountval = likecountval - 1;
	$('#likecnt' + logid).html(likecountval);
	$("#likecountval" + logid).val(likecountval);
	if (likecountval == 0) {
		$('.likebox').hide();
	}
}
}
/*if( $.trim(resp[0]) == 'Like'){
     $("#like"+logid).css("background", " '('+Baseurl+'/images/landingpage/heart-gray.png) no-repeat scroll 10px center / contain rgba(0, 0, 0, 0)' " );
 }
 if( resp[0] == 'Unlike'){
	 $("#like"+logid).css("background", " '('+Baseurl+'/images/landingpage/heart_red.png) no-repeat scroll 0px center / contain rgba(0, 0, 0, 0)' " );
	}*/
	$("#likecnt" + logid).html(resp[1]);
	likestatusfeed = true;
}
});
}
}
function feedcomment() {
//alert('ddre');
logid = $("#feedcommentid").val();
var commentss = $('#comment_msg').val();
commentss = $.trim(commentss);
var commid = $('#commid').val();
var userid = $('#userid').val();
var usernames = $('#usernames').val();
var userimges = $('#userimges').val();
if (userimges == "")
	userimges = "usrimg.jpg";
var baseurl = getBaseURL();
var profileFlag = "";
var profileFlag = $('#feed_roundProfileFlag').val();
var loguserid = $("#loguser_id").val();
commentss = strip(commentss);
if (loguserid == 0) {
	window.location.href = baseurl + "login";
	return false;
} else if ($.trim(commentss) == "") {
	$("#cmnterr").show();
	$("#comment_msg").val("");
	setTimeout(function () {
		$('#cmnterr').fadeOut('slow');
	}, 5000);
	return false;
} else {
	if (commentss != '') {
		comment_status = false;
//var str = $('#a').text();
var pattern = /@([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var commentsss = commentss + " ";
var atusers = '';
if (commentsss.match(pattern)) {
	var result = commentsss.match(pattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//var link = "<a href='"+baseurl+"people/"+result[i]+"'>"+result[i]+"</a>";
if (atusers == '') {
	atusers += desired;
} else {
	atusers += ',' + desired;
}
var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>@</span><a href='" + baseurl + "people/" + desired + "'>" + desired + "</a></span>";
var replacestr = '@' + desired;
//var replacestr = result[i];
commentsss = commentsss.replace(replacestr, link);
}
//console.log(commentsss);return;
//commentsss = commentss.replace(replacestr,link);
}
var hashPattern = /#([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var hashComment = commentsss;
var hashtags = '';
if (hashComment.match(hashPattern)) {
	var result = hashComment.match(hashPattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//if ($.inArray('desired', hashtag['newtags0']) > -1){
	if (hashtags == '') {
		hashtags += desired;
	} else {
		hashtags += ',' + desired;
	}
	var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>#</span><a href='" + baseurl + "hashtag/" + desired + "'>" + desired + "</a></span>";
	var replacestr = '#' + desired;
	hashComment = hashComment.replace(replacestr, link);
}
commentsss = hashComment;
//console.log('Hastags used: '+hashtags);
//console.log(hashComment);return;
//commentsss = commentss.replace(replacestr,link);
}
$.ajax({
	type: "POST",
	url: baseurl + 'addfeedcomments',
	data: {
		"userid": userid,
		"logid": logid,
		"commentss": commentsss,
		'hashtags': hashtags,
		"atusers": atusers
	},
	beforeSend: function () {
		$('.post-loading').show();
//$("#commentssave").attr("disabled", "disabled");
},
success: function (datas) {
	var radius = "border-radius:0%;";
	if (profileFlag == 1) {
		radius = "border-radius:50%;";
	}
	var appval = '<div class="comment-row row hor-padding status-cmnt comment  delecmt_' + datas + ' commentli" commid="' + datas + '" cuid="' + userid + '"><div class="live_feeds_logo1 padding_right0_rtl col-xs-3 col-lg-2 padding-right0 padding-left0 image_center_mobile"><div class="live_feeds_logo" style="background-image:url(' + baseurl + 'media/avatars/thumb70/' + userimges + ');background-repeat:no-repeat;"></div></div><div class="comment-section col-xs-9 col-lg-10 padding-right0 border_bottom_grey padding-bottom10"><div class="bold-font comment-name">' + usernames + '</div><div class="margin-top10 comment-txt regular-font font_size13">' + commentsss + '</div><div id="oritextvalafedit' + datas + '"></div><div class="comment-autocompleteN' + datas + '" style="display: none;left:43px;width:548px;"><ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0"></ul></div><div class="comment-edit-cnt c-reply col-lg-12 no-hor-padding margin-top10"><a class="comment-delete red-txt trn" href="javascript:void(0);" onclick = "return deletefeedcmnt(' + datas + ',' + logid + ')">Delete</a></div></div></div>';
	$("#ulcomments" + logid).prepend(appval);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
	$('#comment_msg').val("");
	$("#write-comment-modal").modal('hide');
	commentsss = "";
	comment_status = true;
	$('.post-loading').hide();
//$("#commentssave").removeAttr("disabled");
},
dataType: 'html'
});
}
}
}
function editfeedcmnt(id) {
//alert(id);
$("#oritext" + id).css('display', 'none');
$("#txt1" + id).css('display', 'inline');
$("#oritextvalafedit" + id).css('display', 'none');
var edithide = ".delecmt_" + id + " .c-reply";
$(edithide).hide();
}
function editfeedcmntsave(id) {
//alert(id);
var txt1val = $("#txt1val" + id).val() + " ";
//alert(txt1val);
baseurl = getBaseURL();
var logid = $("#loguser_id").val();
if (logid == 0) {
	window.location.href = baseurl + "login";
	return false;
} else if ($.trim(txt1val) == "") {
	$("#editcmnterr" + id).show();
	$("#txt1val" + id).val("");
	$("#txt1val" + id).keydown(function () {
		$("#editcmnterr" + id).hide();
	});
	return false;
} else if (id != '' && txt1val != '') {
	var pattern = /@([\S]*?)(?=\s)/g;
	if (txt1val.match(pattern)) {
		var result = txt1val.match(pattern);
		for (var i = 0; i < result.length; i++) {
			if (result[i].length > 1) {
				result[i] = result[i].substring(1, result[i].length);
				var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
			}
//alert(result[i]);
var link = "<a href='" + baseurl + "people/" + desired + "'>" + desired + "</a>";
var replacestr = desired;
//var link = "<a href='"+baseurl+"people/"+result[i]+"'>"+result[i]+"</a>";
//var replacestr = result[i];
txt1val = txt1val.replace(replacestr, link);
}
//txt1val = txt1val.replace(replacestr,link);
}
var hashPattern = /#([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var hashComment = txt1val;
var hashtags = '';
if (hashComment.match(hashPattern)) {
	var result = hashComment.match(hashPattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//if ($.inArray('desired', hashtag['newtags0']) > -1){
	if (hashtags == '') {
		hashtags += desired;
	} else {
		hashtags += ',' + desired;
	}
	var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>#</span><a href='" + baseurl + "hashtag/" + desired + "'>" + desired + "</a></span>";
	var replacestr = '#' + desired;
	hashComment = hashComment.replace(replacestr, link);
}
txt1val = hashComment;
//console.log('Hastags used: '+hashtags);
//console.log(hashComment);return;
//commentsss = commentss.replace(replacestr,link);
}
$.ajax({
	type: "POST",
	url: baseurl + 'editfeedcommentsave',
	data: {
		"cmtid": id,
		"cmntval": txt1val
	},
	beforeSend: function () {
		$(".btn-savecmd").attr("disabled", "disabled");
	},
	success: function (datas) {
		$("#oritextvalafedit" + id).css('display', 'inline');
		$("#oritext" + id).css('display', 'none');
		$("#txt1" + id).css('display', 'none');
		var cmtval = '<p  id="oritext' + id + '" style="margin-top:-10px;">' + datas + '</p>';
		$("#oritextvalafedit" + id).append(cmtval);
		$('#oritext' + id).remove();
		$(".btn-savecmd").removeAttr("disabled");
		var edithide = ".delecmt_" + id + " .c-reply";
		$(edithide).show();
	},
	dataType: 'html'
});
}
}
function share_feed(logid) {
	baseurl = getBaseURL();
	var loguserid = $("#loguser_id").val();
	if (loguserid == 0) {
		window.location.href = baseurl + "login";
		return false;
	}
	$.ajax({
		type: "POST",
		url: baseurl + 'sharefeed',
		data: {
			"logid": logid
		},
		dataType: 'html',
		success: function (datas) {
//alert("sdfsd");
window.location.reload();
},
});
	return false;
}
function showcomments(logid) {
	$(".commentarea" + logid).show();
	$("#write-comment-modal").modal('show');
	$("#feedcommentid").val(logid);
}
function list_liked_users(logid) {
	baseurl = getBaseURL();
	$.ajax({
		type: "POST",
		url: baseurl + 'listlikedusers',
		data: {
			"logid": logid
		},
		dataType: 'html',
		success: function (datas) {
			$('#popup_container').show();
			$('#popup_container').css({
				"opacity": "1"
			});
			$("#likeduserslist").show();
			$("#listusers").html(datas);
			$('#likeduserslist').css({
				"margin": "100px auto 0"
			});
		},
	});
}
function deletefeedcmnt(id, logid) {
	baseurl = getBaseURL();
	var eleid = ".delecmt_" + id;
	var itemid = $('#itemid').val();
//alert(eleid);
if (id != '') {
	$.post(baseurl + 'deletefeedcomments', {
		"addid": id,
		"logid": logid
	},
	function (datas) {
		$(eleid).remove();
		return false;
	}
	);
}
}
function indcall(event) {
	var srctext = $('.hover').text();
	if (srctext != '') {
		$('#search-query').val(srctext);
		var searchString = $('#search-query').val();
	} else {
		var searchString = $('#search-query').val();
	}
	if ($.trim(searchString) == '') {
		$("#searchbtn").attr('disabled', 'disabled');
	} else {
		var baseurl = getBaseURL();
/*$(document).ready(function(){
$("#thing").show();
});*/
window.location = baseurl + "searches/" + searchString;
}
}
function indexSearch(event) {
	var searchString = $('#search-query').val();
//var keycode = $('#search-query').keyCode;
var keycode = event.keyCode;
var spclChars = "!@#$%^&*()"; // specify special characters
for (var i = 0; i < searchString.length; i++) {
	if (spclChars.indexOf(searchString.charAt(i)) != -1) {
//alert ("Special characters are not allowed.");
document.getElementById("search-query").value = "";
return false;
}
}
var stringLength = searchString.length;
var baseurl = getBaseURL();
if ($.trim(searchString) == '') {
	$("#searchbtn").attr('disabled', 'disabled');
} else {
	$("#searchbtn").removeAttr('disabled');
}
if (keycode == 13) {
	indcall(event);
	return;
}
if (stringLength >= 1 && keycode != 40 && keycode != 38 && keycode != 37 && keycode != 39 && keycode != 13 && keycode != 27) {
	$.ajax({
		url: baseurl + 'ajaxSearch',
		type: "post",
		data: {
			searchStr: searchString
		},
		beforeSend: function () {
			$('.loading').show();
		},
		success: function (responce) {
			$('#usesrch').html('');
			$('.loading').hide();
			$('div.feed-search').show();
			var outli = eval(responce);
			if (outli['0'] == 'No Data') {
				$('#usesrch').hide();
			} else {
				$('#usesrch').show();
				$('#usesrch').html(outli['0']);
			}
			if (outli['1'] == 'No Data') {
				$("#usesrch").hide();
			} else {
				$("#usesrch").show();
				$("#usesrch").append('<hr />');
				$("#usesrch").append(outli['1']);
			}
			if (outli['0'] == 'No Data' && outli['1'] == 'No Data') {
				$('#usesrch').show();
				$('#usesrch').html('<div style="text-align:center;margin:15px;color:#000;" class="trn">Search string not found</div>');
				var sessionlang = $("#languagecode").val();
				var translator = $('body').translate({
					t: dict
				});
				translator.lang(sessionlang);
			}
		}
	});
} else if (keycode == 27 || stringLength == 0) {
	$('.feed-search').hide();
//$('.loading').show();
}
}
function indcallresp(event) {
	var srctext = $('.hover').text();
	if (srctext != '') {
		$('#search-queryresp').val(srctext);
		var searchString = $('#search-queryresp').val();
	} else {
		var searchString = $('#search-queryresp').val();
	}
	if ($.trim(searchString) == '') {
		$("#searchbtn").attr('disabled', 'disabled');
	} else {
		var baseurl = getBaseURL();
/*$(document).ready(function(){
$("#thing").show();
});*/
window.location = baseurl + "searches/" + searchString;
}
}
function indexSearchresp(event) {
	var searchString = $('#search-queryresp').val();
//var keycode = $('#search-query').keyCode;
var keycode = event.keyCode;
var stringLength = searchString.length;
var baseurl = getBaseURL();
if ($.trim(searchString) == '') {
	$("#searchbtn").attr('disabled', 'disabled');
} else {
	$("#searchbtn").removeAttr('disabled');
}
if (keycode == 13) {
	indcallresp(event);
	return;
}
if (stringLength >= 1 && keycode != 40 && keycode != 38 && keycode != 37 && keycode != 39 && keycode != 13 && keycode != 27) {
	$.ajax({
		url: baseurl + 'ajaxSearch',
		type: "post",
		data: {
			searchStr: searchString
		},
		beforeSend: function () {
			$('.loading').show();
		},
		success: function (responce) {
			$('#usesrchresp').html('');
			$('.loading').hide();
			$('div.feed-search').show();
			var outli = eval(responce);
			if (outli['0'] == 'No Data') {
				$('#usesrchresp').hide();
			} else {
				$('#usesrchresp').show();
				$('#usesrchresp').html(outli['0']);
			}
			if (outli['1'] == 'No Data') {
				$("#usesrchresp").hide();
			} else {
				$("#usesrchresp").show();
				$("#usesrchresp").append('<hr />');
				$("#usesrchresp").append(outli['1']);
			}
			if (outli['0'] == 'No Data' && outli['1'] == 'No Data') {
				$('#usesrchresp').show();
				$('#usesrchresp').html('<div style="text-align:center;margin:15px;color:#000;" class="trn">Search string not found</div>');
				var sessionlang = $("#languagecode").val();
				var translator = $('body').translate({
					t: dict
				});
				translator.lang(sessionlang);
			}
		}
	});
} else if (keycode == 27 || stringLength == 0) {
	$('.feed-search').hide();
//$('.loading').show();
}
}
function isValidEmailAddress(email) {
	var emailreg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return emailreg.test(email);
}
function isAlpha(e) {
	var specialKeys = new Array();
specialKeys.push(8); // Backspace
specialKeys.push(9); // Tab
specialKeys.push(46); // Delete
specialKeys.push(36); // Home
specialKeys.push(35); // End
specialKeys.push(37); // Left
specialKeys.push(39); // Right
specialKeys.push(27); // Space
var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
var ret = ((keyCode >= 65 && keyCode <= 90) || (keyCode == 32) ||
	(keyCode >= 97 && keyCode <= 122) || (specialKeys
		.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
return ret;
}
function remove() {
	var otxt = document.getElementById('fname');
	var val = otxt.value;
	for (i = 0; i < val.length; i++) {
		var code = val.charCodeAt(i);
		if (!(code >= 65 && code <= 91) && !(code >= 97 && code <= 121) && !(code >= 48 && code <= 57)) {
			otxt.value = "";
			return;
		}
	}
}
function getBaseURL() {
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
		return baseURL + "/";
	}
}
function getfollows(usrid) {
//alert(usrid);
var baseurl = getBaseURL();
//alert(usrid);
var logid = $("#gstid").val();
if (logid == 0) {
//alert("Please Login");
window.location = baseurl + "login";
return false;
} else {
	$("#foll" + usrid).hide();
	$("#unfoll" + usrid).hide();
	var cmtval = '<span id="unfoll' + usrid + '"><div class="btn user_unfollowers"><a href="javascript:void(0);" onclick="deletefollows(' + usrid + ')" class="trn">Unfollow</a></div></span>';
	$("#changebtn" + usrid).html(cmtval);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
// return false;
//$("#flw_"+usrid).text('waiting ...');
//alert(baseurl);
$.post(baseurl + 'addflw_usrs', {
	"usrid": usrid
},
function (datas) {
//alert(datas);
/*if(datas != 0){
alert("You already followed this user");
}*/
//var cmtval = '<p  id="oritext'+id+'">'+datas+'</p>';
//$("#oritextvalafedit"+id).append(cmtval);
//$(".foll"+usrid).text('Following... ');
return false;
}
);
}
}
function deletefollows(usrid) {
//alert(usrid);
var baseurl = getBaseURL();
//alert(baseurl);
var logid = $("#gstid").val();
if (logid == 0) {
//alert("Please Login");
window.location = baseurl + "login";
return false;
} else {
	$("#foll" + usrid).hide();
	$("#unfoll" + usrid).hide();
	var cmtval = '<span id="foll' + usrid + '"><div class="user_followers_butn btn"><a href="javascript:void(0);" onclick="getfollows(' + usrid + ')" class="trn">Follow</a></div></span>';
	$("#changebtn" + usrid).html(cmtval);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
// return false;
//$("#flw_"+usrid).text('waiting ...');
//alert(baseurl);
$.post(baseurl + 'delerteflw_usrs', {
	"usrid": usrid
},
function (datas) {
	$('.following' + usrid).remove();
//alert(datas);
//if(datas != 0){
//alert("You already followed this user");
//}
//$(".unfoll"+usrid).text('Follow ');
return false;
}
);
}
}
function getshopfollows(shopid) {
//alert(usrid);
var baseurl = getBaseURL();
//alert(usrid);
var logid = $("#gstid").val();

if (logid == 0) {
//alert("Please Login");
window.location = baseurl + "login";
return false;
} else {
	$("#folls" + shopid).hide();
	$("#unfolls" + shopid).hide();
	var cmtval = '<span id="unfolls' + shopid + '"><div class="btn user_unfollowers"><a href="javascript:void(0);" onclick="deleteshopfollows(' + shopid + ')" class="trn">Unfollow Store</a></div></span>';

	$("#changebtnn" + shopid).html(cmtval);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);

	$.post(baseurl + 'addflw_shops', {
		"shopid": shopid
	},
	function (datas) {

		return false;
	}
	);
}
}
function deleteshopfollows(shopid) {
//alert(usrid);
var baseurl = getBaseURL();
//alert(baseurl);
var logid = $("#gstid").val();
if (logid == 0) {
//alert("Please Login");
window.location = baseurl + "login";
return false;
} else {

	$("#folls" + shopid).hide();
	$("#unfolls" + shopid).hide();
	var cmtval = '<span id="folls' + shopid + '"><div class="user_followers_butn btn"><a href="javascript:void(0);" onclick="getshopfollows(' + shopid + ')" class="trn">Follow Store</a></div></span>';
	$("#changebtnn" + shopid).html(cmtval);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
	$.post(baseurl + 'deleteflw_shops', {
		"shopid": shopid
	},
	function (datas) {

		return false;
	}
	);
}
}
function show_lists(listid) {
	Baseurl = getBaseURL();
	$.ajax({
		url: Baseurl + "showlistproducts/",
		type: "post",
		data: {
			'listid': listid
		},
		dataType: "html",
		success: function (responce) {
			$("#listproducts").html(responce);
			$("#user_list").modal("show");
		},
	});
}
function change_text(id) {
	listname = $("#listname" + id).text();
	$("#listname" + id).html('<input value="' + listname + '" id= "list_name' + id + '" class="listbox popup-input" style="color:#000000;">');
	$("#buttonid" + id).hide();
	$("#savebtn" + id).show();
}
function save_list(listid) {
	listname = $("#list_name" + listid).val();
	if (listname == "") {
		$("#listerr" + listid).show();
		setTimeout(function () {
			$('#listerr' + listid).fadeOut('slow');
		}, 5000);
		return false;
	} else {
		Baseurl = getBaseURL();
		$.ajax({
			url: Baseurl + "savelistname/",
			type: "post",
			data: {
				'listid': listid,
				'listname': listname
			},
			dataType: "html",
			success: function (responce) {
				$("#listname" + listid).html(listname);
				$("#buttonid" + listid).show();
				$("#savebtn" + listid).hide();
			},
		});
	}
}
function chknum(field, e) {
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
function userchk() {
	fulname = $("#name").val();
	locationval = $("#location").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if ($.trim(fulname) == "") {
		$("#usererr").show();
		$("#usererr").removeAttr('data-trn-key');
		$("#usererr").html("Enter full name");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#usererr').fadeOut('slow');
		}, 5000);
		return false;
	}
//alert(location);
else if ($.trim(locationval) == "") {
//alert("enter loc");
$("#usererr").show();
$("#usererr").removeAttr('data-trn-key');
$("#usererr").html("Enter location");
translator.lang(sessionlang);
setTimeout(function () {
	$('#usererr').fadeOut('slow');
}, 5000);
return false;
}
$("#usererr").html("");
return true;
}
function deactiateac(id) {
	var BaseURL = getBaseURL();
	$(".reporttxt").removeAttr("data-trn-key");
	$(".reporttxt").html("Are you sure you want to deactivate your account?");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
	$("#cancel-order").modal('show');
//var x=window.confirm("Are you sure you want to deactivate your account?");
$(document).on('click', '.yes', function () {
	$.post(BaseURL + 'deactivateacc', {
		"userid": id
	},
	function (datas) {
		window.location.href = BaseURL;
	}
	);
});
}
function actiateac(id) {
	var BaseURL = getBaseURL();
	$(".reporttxt").removeAttr("data-trn-key");
	$(".reporttxt").html("Are you sure you want to activate back your account?");
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
	$("#cancel-order").modal('show');
	$(document).on('click', '.yes', function () {
		$.post(BaseURL + 'activateacc', {
			"userid": id
		},
		function (datas) {
			window.location.href = BaseURL;
		}
		);
	});
}
function passwordconfirm() {
	var data = $('#passchk').serialize();
	var password = $('#passw').val();
	var rpassword = $('#confirmpass').val();
	var expassword = $("#exispass").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
//alert(password);
//alert(data);
if (expassword == '') {
	$("#alert").show();
	$('#alert').removeAttr('data-trn-key');
	$('#alert').text('Existing password cannot be empty');
	translator.lang(sessionlang);
//$('#save_password').attr('disabled','disabled');
return false;
}
if (password == '') {
	$("#alert").show();
	$('#alert').removeAttr('data-trn-key');
	$('#alert').text('New password cannot be empty');
	translator.lang(sessionlang);
//$('#save_password').attr('disabled','disabled');
return false;
}
if (rpassword == '') {
	$("#alert").show();
	$('#alert').removeAttr('data-trn-key');
	$('#alert').text('Confirm password cannot be empty');
	translator.lang(sessionlang);
//$('#save_password').attr('disabled','disabled');
return false;
}
if (password.length < 6) {
	$("#alert").show();
	$('#alert').removeAttr('data-trn-key');
	$('#alert').text('Password must be greater than 6 characters long.');
	translator.lang(sessionlang);
	return false;
}
if (password != rpassword) {
	$("#alert").show();
	$('#alert').removeAttr('data-trn-key');
	$('#alert').text('Password and confirm password is not match');
	translator.lang(sessionlang);
// $('#passw').val("");
return false;
}
if (expassword == password) {
	$("#alert").show();
	$('#alert').removeAttr('data-trn-key');
	$('#alert').text('Existing and new password can not be same');
	translator.lang(sessionlang);
	return false;
}
$('#alert').html('');
}
function shippingEdit(id) {
	var baseurl = getBaseURL();
	baseurl += "addaddress/" + id;
	window.location = baseurl;
}
function shippingdefault(id) {
	var baseurl = getBaseURL();
	baseurl += "defaultshipping";
	var trid = ".default" + id;
	$.ajax({
		url: baseurl,
		type: "post",
		data: {
			shippingid: id
		},
		success: function () {
			window.location.reload();
/*	$(".dall").show();
    $(".defaultremove").show();
    $(".remove_"+id).hide();
    $(".slash_"+id).hide();
    $(trid).hide();*/
}
});
}
function shippingRemove(id) {
	var baseurl = getBaseURL();
	baseurl += "deleteshipping";
	var trid = ".shipping" + id;
	var loading = ".loading" + id;
	var remove = ".remove_" + id;
	$("#cancel-order").modal('show');
	$(document).on('click', '.yes', function () {
		$.ajax({
			url: baseurl,
			type: "post",
			data: {
				shippingid: id
			},
			beforeSend: function () {
				$(loading).show();
				$(remove).hide();
				$(".slash_" + id).hide();
			},
			success: function (responce) {
				$(loading).hide();
				$(trid).hide();
				$("#cancel-order").modal('hide');
			}
		});
	});
}
$(document).on('keyup', '#passw, #confirmpass', function () {
	var password = $('#passw').val();
	var confirmPwd = $('#confirmpass').val();
	var expass = $("#exispass").val();
	if (expass == "" || password == "" || confirmPwd == "") {
		$('#save_password').attr('disabled', 'disabled');
	} else if (password == confirmPwd) {
		$('#save_password').removeAttr('disabled', 'disabled');
	} else {
//$('#save_password').attr('disabled','disabled');
}
});
function postmessage(sender) {
	$('.postcommenterror').html('');
	var baseurl = getBaseURL() + 'replymessage';
	var message = $('#mercntcmnd').val();
	var csid = $('#hiddencsid').val();
	if ($.trim(message) == '') {
		$('#mercntcmnd').val("");
		$(".postcommenterror").show();
		$(".postcommenterror").removeAttr('data-trn-key');
		$('.postcommenterror').html('Message Cannot be empty');
		var sessionlang = $("#languagecode").val();
		var translator = $('body').translate({
			t: dict
		});
		translator.lang(sessionlang);
		return false;
	}
	var merchantId = $('#hiddenmerchantid').val();
	var buyerId = $('#hiddenbuyerid').val();
	var usrimg = $('#hiddenusrimg').val();
	var username = $('#hiddenusrname').val();
	var usrurl = $('#hiddenusrurl').val();
	var roundprofile = $('#hiddenroundprofile').val();
	if (sendmsgajax == 1) {
		sendmsgajax = 0;
		$.ajax({
			url: baseurl,
			type: "post",
			dataType: "html",
			data: {
				'csid': csid,
				'merchantId': merchantId,
				'buyerId': buyerId,
				'message': message,
				'username': username,
				'sender': sender,
				'usrimg': usrimg,
				'username': username,
				'usrurl': usrurl,
				'roundprofile': roundprofile
			},
			beforeSend: function () {
//$('.postcommentloader').show();
$('.sellerpostcomntbtn').css({
	'padding': '0 24px 0 10px'
});
},
success: function (responce) {
//$('.postcommentloader').hide();
$('.sellerpostcomntbtn').css({
	'padding': '0 15px'
});
$('#mercntcmnd').val('');
var currentData = $('.prvcmntcont').html();
//var combinedData = responce + currentData;
var combinedData = currentData + responce;
$('.prvcmntcont').html(combinedData);
//$('.noordercmnt').html("");
//$('#mercntcmnd').val("");
sendmsgajax = 1;
}
});
	}
}
function postorderbuyercomment() {
	var baseurl = getBaseURL() + 'postordercomment';
	var orderid = $('#hiddenorderid').val();
	var merchantid = $('#hiddenmerchantid').val();
	var buyerid = $('#hiddenbuyerid').val();
	var comment = $('#mercntcmnd').val();
	var usrimg = $('#hiddenusrimg').val();
	var usrname = $('#hiddenusrname').val();
	var usrurl = $('#hiddenusrurl').val();
	var postedby = "buyer";
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	$('.postcommenterror').html("");
	if ($.trim(comment) == '') {
		$('#mercntcmnd').val("");
		$(".postcommenterror").show();
		$(".postcommenterror").removeAttr("data-trn-key");
		$('.postcommenterror').html("Message Cannot be empty");
		translator.lang(sessionlang);
		return false;
	}
	if (invajax == 0) {
		invajax = 1;
		$.ajax({
			url: baseurl,
			type: "post",
			dataType: "html",
			data: {
				'orderid': orderid,
				'merchantid': merchantid,
				'buyerid': buyerid,
				'comment': comment,
				'usrimg': usrimg,
				'usrname': usrname,
				'usrurl': usrurl,
				'postedby': postedby
			},
			beforeSend: function () {
				$('.postcommentloader').show();
//$('.sellerpostcomntbtn').css({'padding':'0 24px 0 10px'});
},
success: function (responce) {
//alert(responce);
$('.postcommentloader').hide();
//$('.sellerpostcomntbtn').css({'padding':'0 15px'});
$('.noordercmnt').html("");
$('#noordermessage').remove();
//var previousmsg = $('.prvcmntcont').html();
//var currentmsg = responce + previousmsg;
//$('.prvcmntcont').html(currentmsg);
$('#mercntcmnd').val("");
invajax = 0;
}
});
	}
}
function loadpurchasedetails(oid) {
	var BaseURL = getBaseURL();
	window.location = BaseURL + 'buyerorderdetails/' + oid;
}
function cancel_cod_order(orderid) {
	var BaseURL = getBaseURL();
	markloader = ".cancel-loader-" + orderid;
	$.ajax({
		url: BaseURL + "cancel_cod_order",
		type: "post",
		data: {
			'orderid': orderid
		},
		beforeSend: function () {
/*if (markloader != ''){
$(markloader).show();
}*/
},
success: function (data) {
	if (markloader != '') {
		$(markloader).hide();
	}
	if ($.trim(data) == "success") {
//$("#order_"+orderid).hide();
window.location.reload();
}
}
});
}
function markprocess(oid, process) {
	var BaseURL = getBaseURL();
	var status = ".status" + oid;
	var curlist = "." + process + oid;
	var markloader = '';
	if (process == 'Processing') {
		markloader = ".process-loader-" + oid;
	} else if (process == 'Delivered') {
		markloader = ".buyerst-loader-" + oid;
	}
	if (process == 'Shipped') {
		window.location = BaseURL + 'markshipped/' + oid;
		return;
	} else if (process == 'Track') {
		window.location = BaseURL + 'trackingdetails/' + oid;
		return;
	} else if (process == 'ContactBuyer') {
		window.location = BaseURL + 'sellerconversation/' + oid;
		return;
	}
	$.ajax({
		url: BaseURL + "orderstatus",
		type: "post",
		data: {
			'orderid': oid,
			'chstatus': process
		},
		beforeSend: function () {
			if (markloader != '') {
				$(markloader).show();
			}
		},
		success: function () {
			if (markloader != '') {
				$(markloader).hide();
			}
			$(status).html(process);
//$('#ggpaypal').submit();
$(curlist).remove();
$('.moreactionlistmyord' + oid).slideToggle();
if (process == 'Delivered') {
	$('#status' + oid).html("Delivered");
	var add_content = '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-center no-hor-padding responsive-none"><a class="btn border_left_grey_shop font-color oder-option" href="javascript:void(0);" onclick="dispute('+oid+');">Create Disputes</a></div>';
	$('#statusbutton' + oid).append(add_content);
	$('.buyerstatusmarker' + oid).hide();
	$('#contactseller' + oid).hide();
	$('.claimmarker' + oid).hide();
	$(".returnmarker" + oid).show();
}
}
});
}
function markprocess_details(oid, process) {
	var BaseURL = getBaseURL();
	var status = ".status" + oid;
	var curlist = "." + process + oid;
	var markloader = '';
	if (process == 'Processing') {
		markloader = ".process-loader-" + oid;
	} else if (process == 'Delivered') {
		markloader = ".buyerst-loader-" + oid;
	}
	if (process == 'Shipped') {
		window.location = BaseURL + 'markshipped/' + oid;
		return;
	} else if (process == 'Track') {
		window.location = BaseURL + 'trackingdetails/' + oid;
		return;
	} else if (process == 'ContactBuyer') {
		window.location = BaseURL + 'sellerconversation/' + oid;
		return;
	}
	$.ajax({
		url: BaseURL + "orderstatus",
		type: "post",
		data: {
			'orderid': oid,
			'chstatus': process
		},
		beforeSend: function () {
			if (markloader != '') {
				$(markloader).show();
			}
		},
		success: function () {
				location.reload();
}
});
}
function markclaim(oid) {
	var BaseURL = getBaseURL();
	window.location = BaseURL + 'claimorder/' + oid;
}
function markreturn(oid) {
	var BaseURL = getBaseURL();
	window.location = BaseURL + 'returnorder/' + oid;
}
function claimorder(oid) {
	var BaseURL = getBaseURL();
	$.ajax({
		url: BaseURL + 'buyerclaimorder',
		type: "post",
		dataType: "html",
		data: {
			'orderid': oid
		},
		success: function (responce) {
			window.location.href = BaseURL + 'purchases';
		}
	});
}
function returnorder() {
	var BaseURL = getBaseURL();
	var shippingdate = $('#shipmentdate').val();
	var couriername = $('#couriername').val();
	var courierservice = $('#courierservice').val();
	var trackid = $('#trackingid').val();
	var notes = $('#notes').val();
	var reason = $('#reason').val();
	var orderid = $('#hiddenorderid').val();
	var id = $('#trackid').val();
	$('.error').html('');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (shippingdate == '') {
		$('.shipmentdateerror').show();
		$('.shipmentdateerror').html('Shipment Date cannot be empty');
		translator.lang(sessionlang);
		setTimeout(function () {
			$('.shipmentdateerror').html('');
		}, 5000);
		return false;
	} else if (couriername == '') {
		$('.couriernameerror').show();
		$('.couriernameerror').html('Courier Name cannot be empty');
		translator.lang(sessionlang);
		setTimeout(function () {
			$('.couriernameerror').html('');
		}, 5000);
		return false;
	} else if (trackid == '') {
		$('.trackingiderror').show();
		$('.trackingiderror').html('Tracking Id cannot be empty');
		translator.lang(sessionlang);
		setTimeout(function () {
			$('.trackingiderror').html('');
		}, 5000);
		return false;
	}
	$.ajax({
		url: BaseURL + "buyerreturnorder",
		type: "post",
		data: {
			'orderid': orderid,
			'shippingdate': shippingdate,
			'couriername': couriername,
			'trackid': trackid,
			'notes': notes,
			'courierservice': courierservice,
			'id': id,
			'reason': reason
		},
		beforeSend: function () {
			$('.updatetrackingloader').show();
		},
		success: function (responce) {
			$('.updatetrackingloader').hide();
			window.location = BaseURL + 'purchases';
		}
	});
	return true;
}
function contactseller(oid) {
	var BaseURL = getBaseURL();
	window.location = BaseURL + 'buyerconversation/' + oid;
}
function markshipped() {
	var BaseURL = getBaseURL();
	var orderid = $('#hiddenorderid').val();
	var buyeremail = $('#hiddenbuyeremail').val();
	var buyername = $('#hiddenbuyername').val();
	var subject = $('#emailsubject').val();
	var message = $('#emailmessage').val();
	$('.error').html('');
	if ($.trim(subject) == '') {
		$('.emailsubjecterror').html('Subject cannot be empty');
		return false;
	} else if ($.trim(message) == '') {
		$('.emailmessageerror').html('Message cannot be empty');
		return false;
	}
	$.ajax({
		url: BaseURL + "markshipped",
		type: "post",
		data: {
			'orderid': orderid,
			'buyeremail': buyeremail,
			'subject': subject,
			'message': message,
			'buyername': buyername,
		},
		beforeSend: function () {
			$('.markshipbtnloader').show();
		},
		success: function (responce) {
			$('.markshipbtnloader').hide();
			window.location = BaseURL + 'orders';
		}
	});
	return true;
}
function showselfie(itemid) {
	$("#itemid").val(itemid);
}
function savefashionfile() {
	var img = $("#image_computer").val();
//alert(img);
var baseurl = getBaseURL();
$('#imageerror').html('');
ItemId = $("#itemid").val();
if (img == "") {
	$('#imageerror').html('Please Upload Image');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
	setTimeout(function () {
		$('#imageerror').html('');
	}, 2000);
	return false;
}
$.ajax({
	type: 'POST',
	url: baseurl + 'update',
//data : { src : img	},
data: {
	'src': img,
	'ItemId': ItemId
},
beforeSend: function () {
	$('#loadingimgg').show();
	$("#save_profile_image").attr("disabled", true);
},
success: function (msg) {
	document.getElementById('fashionimg').src = baseurl + 'media/avatars/original/usrimg.jpg';
$('#loadingimgg').hide(); // location.reload();
$("#save_profile_image").attr("disabled", false);
$("#image_computer").val('');
$("#itemid").val("");
$("#add-selfies").modal('hide');
$('#imageerror').html('');
//location.reload();
}
});
}
function uploadfashionfile() {
	$("#imageerror").html("");
	var file = document.getElementById("uploadfashionfile").value;
	var fsize = ($('#uploadfashionfile')[0].files[0].size / 1024) / 1024;
	var ftype = $('#uploadfashionfile')[0].files[0].type;
	var file_data = $('#uploadfashionfile').prop('files')[0];
	var form_data = new FormData();
	form_data.append('file', file_data);
	if (fsize >= 2) {
		$("#imageerror").html("Image size upto 2 MB");
		setTimeout(function () {
			$('#imageerror').html('');
		}, 2000);
		return;
	}
	if (ftype != 'image/jpeg' && ftype != 'image/jpg' && ftype != 'image/png' && ftype != 'image/gif') {
		$("#imageerror").html("Please upload image files");
		setTimeout(function () {
			$('#imageerror').html('');
		}, 2000);
		return;
	}
//console.log(form_data);
var Baseurl = getBaseURL();
$.ajax({
url: Baseurl + 'fashionfileupload', // point to server-side PHP script
dataType: 'text', // what to expect back from the PHP script, if anything
cache: false,
contentType: false,
processData: false,
data: form_data,
type: 'post',
beforeSend: function () {
	$('#loadingimgg').show();
//$("#statusimg-load-ajax").show();
},
success: function (response) {
	$("#statusimg-load-ajax").hide();
	$("#statusimg-cont").removeClass("nodisply");
	$("#statusimg-cont").css('display', 'inline-block');
	$('#image_computer').val(response);
	$('#fashionimg').attr("src", Baseurl + 'media/avatars/original/' + response);
	$('#fashionimg').show();
	$('#loadingimgg').hide();
	$("#statussave").removeAttr('disabled');
	$('#statussave').attr('disabled', false);
	$('#statussave').removeClass('disabled');
//alert(response); // display response from the PHP script, if any
}
});
}
function dispute(oid) {
	$("#creat-dispute").modal('show');
	$("#disputeorderid").val(oid);
	$("#orderid").html(oid);
	var BaseURL = getBaseURL();
	$.ajax({
		url: BaseURL + "orderitemdetail",
		type: "post",
		data: {
			'orderid': oid
		},
		beforeSend: function () {
//$('.markshipbtnloader').show();
},
success: function (responce) {
	$("#itemlist").html(responce);
}
});
}
function disputesendform() {
	var data = $('#disputeform').serialize();
	var problem = $('#problem').val();
	var message = $('#message').val();
	var orderid = $("#disputeorderid").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (problem == '') {
		$("#alertName").show();
		$("#badmessage").hide();
		$('#alertName').text('Select Problem');
		translator.lang(sessionlang);
		$('#problem').focus()
		$('#problem').keydown(function () {
			$('#alertName').hide();
		});
		return false;
	}
	if ($.trim(message) == '') {
		$("#alertNamemsg").show();
		$("#badmessagemsg").hide();
		$('#message').val("");
		$('#alertNamemsg').text('Enter The Text Message');
		translator.lang(sessionlang);
		$('#message').focus()
		$('#message').keydown(function () {
			$('#alertNamemsg').hide();
		});
		return false;
	}
	var BaseURL = getBaseURL();
//$(".dispbtn").attr("disabled",true);
$.ajax({
	url: BaseURL + "userdispute",
	type: "post",
	data: {
		'orderid': orderid,
		'buyeremail': buyeremail,
		'orderstatus': orderstatus,
		'address': address,
		'buyername': buyername,
		'shippingdate': shippingdate,
		'couriername': couriername,
		'trackid': trackid,
		'notes': notes,
		'courierservice': courierservice,
		'id': id
	},
	beforeSend: function () {
		$('.updatetrackingloader').show();
	},
	success: function (responce) {
		$('.updatetrackingloader').hide();
		window.location = BaseURL + 'orders';
	}
});
return true;
}
function disputemsg(oid) {
	var BaseURL = getBaseURL();
	window.location = BaseURL + 'disputemessage/' + oid;
}
function addtracking() {
	var BaseURL = getBaseURL();
	var shippingdate = $('#shipmentdate').val();
	var couriername = $('#couriername').val();
	var courierservice = $('#courierservice').val();
	var trackid = $('#trackingid').val();
	var notes = $('#notes').val();
	var orderid = $('#hiddenorderid').val();
	var buyeremail = $('#hiddenbuyeremail').val();
	var buyername = $('#hiddenbuyername').val();
	var orderstatus = $('#hiddenorderstatus').val();
	var address = $('#hiddenbuyeraddress').val();
	var id = $('#trackid').val();
	$('.error').html('');
	if (shippingdate == '') {
		$('.shipmentdateerror').html('Shipment Date cannot be empty');
		return false;
	} else if (couriername == '') {
		$('.couriernameerror').html('Courier Name cannot be empty');
		return false;
	} else if (trackid == '') {
		$('.trackingiderror').html('Tracking Id cannot be empty');
		return false;
	}
	$.ajax({
		url: BaseURL + "updatetrackingdetails",
		type: "post",
		data: {
			'orderid': orderid,
			'buyeremail': buyeremail,
			'orderstatus': orderstatus,
			'address': address,
			'buyername': buyername,
			'shippingdate': shippingdate,
			'couriername': couriername,
			'trackid': trackid,
			'notes': notes,
			'courierservice': courierservice,
			'id': id
		},
		beforeSend: function () {
			$('.updatetrackingloader').show();
		},
		success: function (responce) {
			$('.updatetrackingloader').hide();
			window.location = BaseURL + 'orders';
		}
	});
	return true;
}
function hashtagfollow(usrid, listid) {
	var baseurl = getBaseURL();
	var hidetag = ".list" + listid;
//var buttontag = "#follow_btn"+usrid;
var logid = $("#gstid").val();
if (logid == 0) {
	window.location = baseurl + "login";
	return false;
} else {
	var followlist = $("#followuserlist").val();
	$.ajax({
		url: baseurl + 'livefeedsaddflw_usrs',
		type: 'POST',
		data: {
			"usrid": usrid,
			"followlist": followlist,
			"listid": listid
		},
		dataType: "json",
		beforeSend: function () {
//$(buttontag).attr('disabled','disabled');
},
success: function (responce) {
	$(hidetag).fadeOut('slow');
	var check = responce.toString();
	if (check != "false") {
		var out = eval(responce);
		followlist += ',' + out[1];
		$("#followuserlist").val(followlist);
//hidetag = ".whouser"+out[1];
setTimeout(function () {
	$(hidetag).html(out[0]);
	$(hidetag).fadeIn('slow');
}, 500);
} else {
	var el = $('.whouser' + usrid).filter(function () {
		return $(this).css('display') == 'none';
	});
	var hiddenli = el.length;
	if (hiddenli == 4) {
		$('.hashtagwhofollow-content').html(
			"<div class='whotofollowerror trn' style='display:none;'>" +
			"No more suggestions</div>");
		var sessionlang = $("#languagecode").val();
		var translator = $('body').translate({
			t: dict
		});
		translator.lang(sessionlang);
		setTimeout(function () {
			$('.whotofollowerror').fadeIn('slow');
		}, 500);
	}
}
}
});
}
}
function deletepost(postid) {
	if (typeof (postdelete[postid]) == 'undefined') {
		postdelete[postid] = 1;
		var feedselector = '.feed' + postid;
		var baseurl = getBaseURL() + 'deletestatus';
		$("#cancel-order").modal('show');
		$(document).on('click', '.no', function () {
			$("#cancel-order").modal('hide');
			postdelete.splice(postdelete.indexOf(postid), 1);
		});
		$(document).on('click', '.yes', function () {
			var commentVal = $(".status" + postid).html();
var hashPattern = /#([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var hashComment = commentVal + " ";
if (typeof (oldtags) == 'undefined') {
//console.log('Defining atuser array');
oldtags = new Array();
}
oldtags['status' + postid] = '';
if (hashComment.match(hashPattern)) {
	var result = hashComment.match(hashPattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//if ($.inArray('desired', hashtag['newtags0']) > -1){
	if (oldtags['status' + postid] == '') {
		oldtags['status' + postid] += desired;
	} else {
		oldtags['status' + postid] += ',' + desired;
	}
}
//console.log('old tags: '+oldtags['status'+postid]);
}
$.ajax({
	url: baseurl,
	type: "post",
	dataType: "html",
	data: {
		'postid': postid,
		"hashtags": oldtags['status' + postid]
	},
	beforeSend: function () {
//$('.postcommentloader').show();
$(feedselector).css({
	'opacity': '0.2'
});
},
success: function (responce) {
	$(feedselector).fadeOut('slow');
	$("#cancel-order").modal('hide');
},
failure: function () {
	postdelete.splice(postdelete.indexOf(postid), 1);
	$(feedselector).css({
		'opacity': '1'
	});
}
});
});
	} else {
//console.log('already a ajax running');
}
}
function uploadajaxfile() {
	$("#imageerr").html("");
	var file = document.getElementById("uploadajaxfile").value;
	var fsize = ($('#uploadajaxfile')[0].files[0].size / 1024) / 1024;
	var ftype = $('#uploadajaxfile')[0].files[0].type;
	var file_data = $('#uploadajaxfile').prop('files')[0];
	var form_data = new FormData();
	form_data.append('file', file_data);
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if (fsize >= 2) {
		$("#imageerr").removeAttr("data-trn-key");
		$("#imageerr").addClass("activity_heading");
		$("#imageerr").html("Image size upto 2 MB");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#imageerr').html('');
			$("#imageerr").removeClass("activity_heading");
		}, 2000);
		return;
	}
	if (ftype != 'image/jpeg' && ftype != 'image/jpg' && ftype != 'image/png' && ftype != 'image/gif') {
		$("#imageerr").removeAttr("data-trn-key");
		$("#imageerr").addClass("activity_heading");
		$("#imageerr").html("Please upload image files");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#imageerr').html('');
			$("#imageerr").removeClass("activity_heading");
		}, 2000);
		return;
	}
	$('#imageerr').html('');
//console.log(form_data);
var Baseurl = getBaseURL();
$.ajax({
url: Baseurl + 'statusfileupload', // point to server-side PHP script
dataType: 'text', // what to expect back from the PHP script, if anything
cache: false,
contentType: false,
processData: false,
data: form_data,
type: 'post',
beforeSend: function () {
	$('#statussave').attr('disabled', true);
	$('#statussave').html('Posting ...');
},
success: function (response) {
	$("#statusimg-load-ajax").hide();
	$("#statusimg-cont").removeClass("nodisply");
	$("#statusimg-cont").css('display', 'inline-block');
	$('#image_computer').val(response);
	$('#show_url').attr("src", Baseurl + 'media/status/original/' + response);
	$('#show_url').show();
	$("#statussave").removeAttr('disabled');
	$('#statussave').attr('disabled', false);
	$('#statussave').removeClass('disabled');
	$('#statussave').html('Post');
}
});
}
function removestatusimg(val) {
	var baseurl = getBaseURL();
	$('#image_computer').val('');
	$('#show_url').attr({
		src: baseurl + 'media/avatars/thumb150/usrimg.jpg'
	});
	$('#statusimg-cont').hide();
}
/*********************Post status start*******************************/
function poststatus() {
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	$("#statusimg-load").css('display', 'none');
	if (poststat == 1) {
		poststat = 0;
		var image = $('#image_computer').val();
		var postmessage = $('#status-textarea').val();
		if (image == '' && $.trim(postmessage) == '') {
			$('#status-textarea').val("");
			$('.statuspost-error').html('Write something or add a photo');
			translator.lang(sessionlang);
			$('#statusimg-load').hide();
			setTimeout(function () {
				$('.statuspost-error').html('');
				poststat = 1;
			}, 2000);
			return false;
		} else {
			var baseurl = getBaseURL();
var pattern = /@([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var commentsss = postmessage + " ";
var atusers = '';
if (commentsss.match(pattern)) {
	var result = commentsss.match(pattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
	if (atusers == '') {
		atusers += desired;
	} else {
		atusers += ',' + desired;
	}
	var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>@</span><a href='" + baseurl + "people/" + desired + "'>" + desired + "</a></span>";
	var replacestr = '@' + desired;
	commentsss = commentsss.replace(replacestr, link);
}
}
var hashPattern = /#([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var hashComment = commentsss;
var hashtags = '';
if (hashComment.match(hashPattern)) {
	var result = hashComment.match(hashPattern);
	for (var i = 0; i < result.length; i++) {
		if (result[i].length > 1) {
			result[i] = result[i].substring(1, result[i].length);
			var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
		}
		if (hashtags == '') {
			hashtags += desired;
		} else {
			hashtags += ',' + desired;
		}
		var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>#</span><a href='" + baseurl + "hashtag/" + desired + "'>" + desired + "</a></span>";
		var replacestr = '#' + desired;
		hashComment = hashComment.replace(replacestr, link);
	}
	commentsss = hashComment;
}
var baseurl = getBaseURL() + 'poststatus';
$.ajax({
	url: baseurl,
	type: "post",
	dataType: "html",
	data: {
		'image': image,
		'postmessage': commentsss,
		'hashtags': hashtags,
		"atusers": atusers
	},
	beforeSend: function () {
		$('.post-status-loader').show();
		$('#statussave').attr('disabled', true);
		$('#statussave').html('Posting ...');
	},
	success: function (responce) {

		$('.post-status-loader').hide();
		var oldData = $('.feeds-ol').html();
		var newData = responce + oldData;
		$('.feeds-ol').html(newData);
		$('#image_computer').val('');
		$('#status-textarea').val('');
		$("#show_url").css('display', 'none');
		$('#status-textarea').css({
			'height': ''
		});
		$('.statuspost-error').html('');
		$('#statusimg-cont').hide();
		$("#statusimg-cont").addClass("nodisply");
		$('#statussave').attr('disabled', false);
		$('#statussave').removeClass('disabled');
		$('#statussave').html('Post');
		poststat = 1;
		setTimeout(function () {
			$('.addedli').fadeIn();
			$('.stli').removeClass('addedli');
			poststat = 1;
		}, 1000);
	},
	failure: function () {
		$('.statuspost-error').html('Unable to post please try again');
		setTimeout(function () {
			$('.statuspost-error').html('');
			poststat = 1;
		}, 2000);
	}
});
return false;
}
}
}
/*** Group Gift ****/
function validggusersave() {
	var flag = 0;
	var check = 0;
	var recipient = $('#comment_msgemail').val();
	var name = $('#name').val();
	var address1 = $('#address1').val();
	var address2 = $('#address2').val();
	var country = $('#countrygg').val();
	var state = $('#stategg').val();
	var city = $('#citygg').val();
	var zipcode = $('#zipcodegg').val();
	var telephone = $('#telephonegg').val();
	var listingid = $('#listingid').val();

	var fullimgtag = $('.product-img').css('backgroundImage');
	var image = $('#image_computer').val();
	var sizestat = $("#sizeset").val();
	var lastestidgg = $('#lastestidgg').val();
	if (sizestat == 1) {
		var size = $("#size_opt").val();
		var qty = $("#qty_opt").val();
	} else {
		var qty = $("#qty_opt").val();
		var size = 'null';
	}
	if ($.trim(recipient).length < 3) {
		$('#recipient_name_err').show();
		$('#recipient_check_name_err').hide();
		$("#comment_msgemail").keydown(function () {
			$('#recipient_name_err').hide();
			$('#recipient_check_name_err').hide();
		});
		check = 1;
	}
	if ($.trim(name).length < 3) {
		$('#name_err').show();
		$("#name").keydown(function () {
			$('#name_err').hide();
		});
		check = 1;
	}
	if ($.trim(address1).length < 3) {

		$('#address1_err').show();
		$('#address1').keydown(function () {
			$('#address1_err').hide();
		});
		check = 1;
	}
	if (country == '') {

		$('#country_err').show();
		$('#countrygg').keydown(function () {
			$('#country_err').hide();
		});
		check = 1;
	}
	if ($.trim(state).length < 2) {

		$('#state_err').show();
		$('#stategg').keydown('input', function () {
			$('#state_err').hide();
		});
		check = 1;
	}
	if ($.trim(city).length < 2) {
		$('#city_err').show();
		$('#citygg').keydown('input', function () {
			$('#city_err').hide();
		});
		check = 1;
	}
	if (zipcode == '') {

		$('#zipcode_err').show();
		$('#zipcodegg').keydown('input', function () {
			$('#zipcode_err').hide();
		});
		check = 1;
	}
	if (telephone == '') {

		$('#telephone_err').show();
		$('#telephonegg').keydown('input', function () {
			$('#telephone_err').hide();
		});
		check = 1;
	}




	if (check == 1) {
		$("#finalerr").show();
		$("#finalerr").html("Please fill all details");
		return false;
	}

	var baseurl = getBaseURL() + 'ggusersave?flag=' + flag + '&country=' + country + '&item_id=' + listingid +
	'&size=' + size + '&qty=' + qty + '&zipcode=' + zipcode + '&recipient=' + recipient;
	$.ajax({
		url: baseurl,
		type: "GET",
		dataType: "text",
		success: function (responce) {
			if(responce == '/2')
			{
					$('#recipient_name_err').hide();
					$('#recipient_check_name_err').hide();
					$('#recipient_check_recipient_err').show();
					$("#comment_msgemail").keydown(function () {
						$('#recipient_name_err').hide();
						$('#recipient_check_name_err').hide();
						$('#recipient_check_recipient_err').hide();
					});
					return false;
			}
			if (responce == 'failed') {
				$("#recipient_check_name_err").show();
				return false;
			} else {
				var splitt = responce.split(",");
				$("#ggform1").hide();
				$("#ggform2").show();
				$("#recipient_check_name_err").hide();
				$("#ggtitle1").addClass("create_gift");
				$("#ggtitle1").removeClass("gift_menu_active");
				$("#ggtitle2").removeClass("create_group_gift");
				$("#ggtitle2").addClass("gift_menu_active");
				$("#ggtitle1").addClass("hide_mobile");
				$("#ggtitle2").removeClass("hide_mobile");
				$("#ggtitle3").addClass("hide_mobile");
				$(window).scrollTop(0);
				$('#totitemshipcost').attr('value', splitt[3]);
				$("#sales_tax_val").text(splitt[4]);
				$("#sales_tax_val1").text(splitt[4]);
				$('#totalscosts').text(splitt[3]);
				$('#totalscosts1').text(splitt[3]);
				$('#totalscosts2').text(splitt[2]);
				$('#itemprice').text(roundToTwo(splitt[2] / qty));
				$('#totalscosts3').text(splitt[2]);
				$('#shipscosts').text(splitt[1]);
				$('#shipscosts1').text(splitt[1]);
				if (sizestat == 1) {
					$('#gg_update_size').text(size);
				}
				$('#gg_update_qty').text(qty);
				$('#recepietName').attr('value', name);
				$('#recepietcity').attr('value', city);

			}
		}
	});
	return false;
}
function roundToTwo(num) {
	return +(Math.round(num + "e+2") + "e-2");
}
function ajaxuserautocgroupemail(event, val, commndid, autocompid) {
	var searchString = $('#' + commndid).val();
	var baseurl = getBaseURL();
	var loguserid = $("#loguserid").val();
	if (loguserid == 0) {
		window.location.href = baseurl + "login";
		return false;
	}
	var iChars = "@";
//for (var i = 0; i < searchString.length; i++) {
// if (iChars.indexOf(searchString.charAt(i)) != -1) {
// var splitted = searchString.split('@');
// var splittedLength = splitted.length;
// var splitLast = splittedLength - 1;
//var beforeString = splitted[0];
//for (var s = 1; s < splitLast; s++){
//	beforeString += "@"+splitted[s];
//}
//var splittedstr = splitted[splitLast];
//var splittedstrbef = searchString;
keycode = event.keyCode;
if (keycode != 40 && keycode != 38 && keycode != 37 && keycode != 39 && keycode != 13 && keycode != 27 && keycode != 9) {
	$.ajax({
		url: baseurl + 'ajaxUserAutogroupgift',
		type: "post",
		data: {
			searchStr: searchString
		},
		success: function (responce) {
			var outli = eval(responce);
			if (outli['0'] == 'No Data') {
				$('.' + autocompid + ' .usersearchgroupemail').hide();
//alert( "Data Saved: " + responce);
} else {
	$('.usersearchgroupemail').show();
	$('.' + autocompid).show();
	$('.' + autocompid + ' .usersearchgroupemail').html(outli['0']);
//var l = 0;
$('.popup').click(function (e) {
	if (!$(e.target).closest('.' + autocompid).length) {
		$('.' + autocompid).hide();
	}
});
$('.' + autocompid + ' .usersearchgroupemail li').click(function () {
	//className = $(this).text();
	//var exa = document.getElementById(commndid).value = searchString + '@'+className+' ';
	if ($('#comment_msgemail').val() != '') {
		$('#recipient_name_err').hide();
	}
	if ($('#name').val() != '') {
		$('#name_err').hide();
	}
	if ($('#address1').val() != '') {
		$('#address1_err').hide();
	}
	if ($('#countrygg').val() != '') {
		$('#country_err').hide();
	}
	if ($('#stategg').val() != '') {
		$('#state_err').hide();
	}
	if ($('#citygg').val() != '') {
		$('#city_err').hide();
	}
	if ($('#zipcodegg').val() != '') {
		$('#zipcode_err').hide();
	}
	if ($('#telephonegg').val() != '') {
		$('#telephone_err').hide();
	}
	$('.' + autocompid).hide();
	//$('#'+commndid).focus();
	//alert(exa);
});
}
}
});
}
//}
// }
}
function show_gg_form1() {
	$("#ggform2").hide();
	$("#ggform1").show();
	$("#ggtitle2").addClass("create_gift");
	$("#ggtitle2").removeClass("gift_menu_active");
	$("#ggtitle1").removeClass("create_gift");
	$("#ggtitle1").addClass("gift_menu_active");
	$("#ggtitle1").removeClass("hide_mobile");
	$("#ggtitle2").addClass("hide_mobile");
	$("#ggtitle3").addClass("hide_mobile");
}
function show_gg_form2() {
	$("#ggform3").hide();
	$("#ggform2").show();
	$("#ggtitle3").addClass("create_gift");
	$("#ggtitle3").removeClass("gift_menu_active");
	$("#ggtitle2").removeClass("create_gift");
	$("#ggtitle2").addClass("gift_menu_active");
	$("#ggtitle1").addClass("hide_mobile");
	$("#ggtitle2").removeClass("hide_mobile");
	$("#ggtitle3").addClass("hide_mobile");
}
function createggift() {
	var flag = 1;
	var check = 0;
	var BaseURL = getBaseURL();
	var title = $('#ggift-title').val();
	var descr = $('#ggift-description').val();
	var notes = $('#ggift-note').val();
	var lastestidgg = $('#lastestidgg').val();
	var fullimgtag = $('#fullimgtag').val();
	var totitemshipcost = $('#totitemshipcost').val();
	var recepietName = $('#recepietName').val();
	var recepietcity = $('#recepietcity').val();
	var quantity = $("#qty_opt").val();
	var size = $("#size_opt").val();
	if ($.trim(title).length < 3) {
//alert('Enter the Recipient name');
$('#title_err').css('display', 'block');
$('#ggift-title').keydown(function () {
	$('#title_err').hide();
});
check = 1;
}
if ($.trim(descr).length < 10) {
//alert('Enter the Recipient name');
$('#description_err').css('display', 'block');
$('#ggift-description').keydown(function () {
	$('#description_err').hide();
});
check = 1;
}
if (check == 1) {
	$("#final2err").hmtl("Please fill all details");
	return false;
}
var recipient = $('#comment_msgemail').val();
var name = $('#name').val();
var address1 = $('#address1').val();
var address2 = $('#address2').val();
var country = $('#countrygg').val();
var state = $('#stategg').val();
var city = $('#citygg').val();
var zipcode = $('#zipcodegg').val();
var telephone = $('#telephonegg').val();
var listingid = $('#listingid').val();
var fullimgtag = $('#fullimgtag').val();
var image = $('#image_computer').val();
var sizestat = $("#sizeset").val();
var lastestidgg = $('#lastestidgg').val();
if (sizestat == 1) {
	var size = $("#size_opt").val();
	var qty = $("#qty_opt").val();
} else {
	var qty = $("#qty_opt").val();
	var size = 'null';
}
var baseurl = getBaseURL() + 'ggusersave?recipient=' + recipient + '&name=' + name +
'&address1=' + address1 + '&address2=' + address2 + '&country=' + country + '&state=' + state +
'&city=' + city + '&zipcode=' + zipcode + '&telephone=' + telephone + '&item_id=' + listingid +
'&image=' + image + '&size=' + size + '&qty=' + qty + '&lastestidgg=' + lastestidgg + '&flag=' + flag;
$.ajax({
	url: baseurl,
	type: "GET",
	async: false,
	dataType: "text",
	success: function (responce) {
		var splitt = responce.split(",");
		$('#lastestidgg').attr('value', splitt[0]);
		$('#totitemshipcost').attr('value', splitt[3]);
		$("#sales_tax_val").text(splitt[4]);
		$("#sales_tax_val1").text(splitt[4]);
		$('#totalscosts').text(splitt[3]);
		$('#totalscosts1').text(splitt[3]);
		$('#totalscosts2').text(splitt[2]);
		$('#totalscosts3').text(splitt[2]);
		$('#shipscosts').text(splitt[1]);
		$('#shipscosts1').text(splitt[1]);
		$('#recepietName').attr('value', name);
		$('#recepietcity').attr('value', city);
		var lastestidgg = splitt[0];
		var baseurl = getBaseURL() + 'groupgiftreason?quantity=' + quantity + '&size=' + size + '&title=' + title + '&description=' + descr + '&notes=' + notes + '&lastestidgg=' + lastestidgg;
		$.ajax({
			url: baseurl,
			type: "GET",
			dataType: "text",
			success: function (responce) {
				$("#ggform2").hide();
				$("#ggform1").hide();
				$("#ggform3").show();
				$("#ggtitle3").removeClass("create_gift");
				$("#ggtitle3").addClass("gift_menu_active");
				$("#ggtitle2").removeClass("gift_menu_active");
				$("#ggtitle2").addClass("create_gift");
				$("#ggtitle1").addClass("hide_mobile");
				$("#ggtitle2").addClass("hide_mobile");
				$("#ggtitle3").removeClass("hide_mobile");
				$('.summary').css("opacity", "0");
				$('.summary').show();
				setTimeout(function () {
					$('.summary').css({
						"opacity": "1",
						"transition": "all 0.4s ease-in-out 0s"
					});
				}, 30)
//$('#listingitemids1').attr('src', $('#fullimgtag').prop('src'));
$('#Usergifttitle').text(title);
$('#Usergiftdescription').text(descr);
$('#UsergiftNamee').text(recepietName);
$('#Usergiftcity').text(recepietcity);
var urlss = BaseURL + 'gifts/' + lastestidgg;
var meta_image = $("#fullimgtag").val();
var appID = $("#default_fb_appid").val();
var desc = $("#default_site_desc").val();
var title = $.trim($('.gift_heading').html());
$('#meta_title').attr('content', title);
$('#meta_image').attr('content', meta_image);
$('#meta_description').attr('content', desc);
encry_urlss = encodeURIComponent(urlss);
//$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?s=100&p[title]='+encry_title+'&p[url]='+encry_urlss);
//$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?u='+encry_urlss+'&t='+encry_title);
$('.facebook').attr('href', 'https://www.facebook.com/dialog/share?app_id=' + appID + '&display=popup&href=' + encry_urlss);
$('.twitter').attr('href', 'http://twitter.com/?status=' + encry_urlss);
$('.google').attr('href', 'http://plus.google.com/share?url=' + encry_urlss);
$('.linkedin').attr('href', 'http://www.linkedin.com/cws/share?url=' + encry_urlss + '&title=' + encry_title);
$('.stumbleupon').attr('href', 'http://www.stumbleupon.com/submit?url=' + encry_urlss + '&title=' + encry_title);
$('.tumblr').attr('href', 'http://www.tumblr.com/share/link?url=' + encry_urlss + '&name=' + encry_title);
var notes = $('#ggift-note').val('');
}
});
	}
});
}
function shownoti() {
	var BaseURL = getBaseURL();
	var loguserid = $('#logguserid').val();
//var loadingimg = $('.loading').val();
if (pushnoii) {
	pushnoii = false;
//alert(loguserid);
$.ajax({
	url: BaseURL + "getpushajax/",
	type: "post",
	data: {
		'loginuserid': loguserid
	},
	dataType: "html",
	beforeSend: function () {
		$('.loading').show();
//$(button).attr("disabled", "disabled");
},
success: function (responce) {
//alert(responce);
$('#noticnt').hide();
//$(".feed-notification").show();
$('#pushappend').html(responce);
}
});
}
}
function showcarthov() {
	var BaseURL = getBaseURL();
	if (cartnoii) {
		cartnoii = false;
		$.ajax({
			url: BaseURL + "cartmousehover/",
			type: "post",
//data : { 'loginuserid': loguserid},
dataType: "html",
beforeSend: function () {
//$('#loading_imgcart').show();
},
success: function (responce) {
//alert(responce);
//$('#loading_imgcart').hide();
$('#cartmousehoverval').html(responce);
}
});
	}
}
function show_contactseller() {
	var BaseURL = getBaseURL();
	var loguserid = $("#loguserid").val();
	if (loguserid == 0) {
		window.location.href = BaseURL + "login";
		return false;
	} else {
		$("#contact-seller-modal").modal('show');
	}
}
function show_writecomment() {
	var BaseURL = getBaseURL();
	var loguserid = $("#loguserid").val();
	if (loguserid == 0) {
		window.location.href = BaseURL + "login";
		return false;
	} else {
		$("#write-comment-modal").modal('show');
	}
}
function itemcounew(id) {
	$("#listerr").hide();
	var addusrlist = true;
	unfantid = id;
	var BaseURL = getBaseURL();
//alert(id);
//var imgselector = '.getimgurl'+id;
var likedbtncnt = $("#likedbtncnt").val();
var likebtncnt = $("#likebtncnt").val();
var liketxt = $(".like-txt" + id).html();
//alert(likedbtncnt);
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
}
var imgselectorattr = $("#img_id" + id).val();
//alert(imgselectorattr);
//alert($('#img_id'+id).find('img:first').attr('src'));
//$("#selectimgs").attr("src",$(imgselector).attr('src'));
//$("#selectimgs").css({"background":"rgba(0, 0, 0, 0) url('"+imgselectorattr+"') no-repeat scroll center center/contain"});
$("#selectimgs").attr("src", imgselectorattr);
//console.log("List Item id"+id);
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
} else if (liketxt == likebtncnt) {
	$.post(BaseURL + 'userlike', {
		"itemid": id
	},
	function (datas) {
		datas = datas.split('-_-');
		datass = eval(datas[1]);
//$("input[type=checkbox]").removeAttr('checked');
for (var i = 0; i < datass.length; i++) {
	if (datass[i]['listcheck'] == '1') {
		$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', true);
	} else {
		$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', false);
	}
}
$(".like-counter").html(datas[0]);
$(".like-icon" + id).removeClass("fa-heart-o");
$(".like-icon" + id).addClass("fa-heart");
//$('.like-icon'+id).attr("src",BaseURL+"images/icons/liked-w.png");
//alert(likedbtncnt);
$(".like-txt" + id).html(likedbtncnt);
return false;
}
);
} else {
	unfant = false;
	$.post(BaseURL + 'userUnlike', {
		"itemid": id
	},
	function (datas) {
		$(".like-counter").html(datas);
		$("input[type=checkbox]").removeAttr('checked');
		$(".like-icon" + id).removeClass("fa-heart");
		$(".like-icon" + id).addClass("fa-heart-o");
//alert(likebtncnt);
//$('.like-icon'+id).attr("src",BaseURL+"images/icons/heart_icon.png");
$(".like-txt" + id).html(likebtncnt);
return false;
}
);
}
}
function itemcou(id) {
	$("#listerr").hide();
	var addusrlist = true;
	unfantid = id;
	var BaseURL = getBaseURL();
	var likedbtncnt = $("#likedbtncnt").val();
	var likebtncnt = $("#likebtncnt").val();
	var liketxt = $(".like-txt" + id).html();
	/* latest fixes 4.1 */
	var loguserid = $("#loguserid").val();
	if (loguserid == 0) {
		window.location.href = BaseURL + "login";
		return false;
	}
	var imgselectorattr = $("#img_id" + id).val();
	$("#selectimgs").attr("src", imgselectorattr);
	if (loguserid == 0) {
		window.location.href = BaseURL + "login";
		return false;
	} else if (liketxt == likebtncnt) {
		$.post(BaseURL + 'userlike', {
			"itemid": id
		},
		function (datas) {
			datas = datas.split('-_-');
			datass = eval(datas[1]);
			for (var i = 0; i < datass.length; i++) {
				if (datass[i]['listcheck'] == '1') {
					$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', true);
				} else {
					$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', false);
				}
			}
			$(".like-counter").html(datas[0]);
			$('.like-icon' + id).attr("src", BaseURL + "images/icons/liked-w.png");
			$(".like-txt" + id).html(likedbtncnt);
			return false;
		}
		);
	} else {
		unfant = false;
		$.post(BaseURL + 'userUnlike', {
			"itemid": id
		},
		function (datas) {
			$(".like-counter").html(datas);
			$("input[type=checkbox]").removeAttr('checked');
			$('.like-icon' + id).attr("src", BaseURL + "images/icons/heart_icon.png");
			$(".like-txt" + id).html(likebtncnt);
			return false;
		}
		);
	}
}
function itemcou1(id) {
	$("#listerr").hide();
	var addusrlist = true;
	unfantid = id;
	var BaseURL = getBaseURL();
//alert(id);
//var imgselector = '.getimgurl'+id;
var likedbtncnt = $("#likedbtncnt").val();
var likebtncnt = $("#likebtncnt").val();
var liketxt = $("#like-txt" + id).html();
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
}
var imgselectorattr = $("#img_id" + id).val();
//alert(imgselectorattr);
//alert($('#img_id'+id).find('img:first').attr('src'));
//$("#selectimgs").attr("src",$(imgselector).attr('src'));
//$("#selectimgs").css({"background":"rgba(0, 0, 0, 0) url('"+imgselectorattr+"') no-repeat scroll center center/contain"});
$("#selectimgs").attr("src", imgselectorattr);
//console.log("List Item id"+id);
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
} else if (liketxt == likebtncnt) {
	$.post(BaseURL + 'userlike', {
		"itemid": id
	},
	function (datas) {
		datas = datas.split('-_-');
		datass = eval(datas[1]);
//$("input[type=checkbox]").removeAttr('checked');
for (var i = 0; i < datass.length; i++) {
	if (datass[i]['listcheck'] == '1') {
		$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', true);
	} else {
		$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', false);
	}
}
$(".like-counter").html(datas[0]);
/*$("#like-icon"+id).removeClass("fa-heart-o");
$("#like-icon"+id).addClass("fa-heart");*/
$('.like-icon' + id).attr("src", BaseURL + "images/icons/liked-w.png");
$("#like-txt" + id).html(likedbtncnt);
return false;
}
);
} else {
	unfant = false;
	$.post(BaseURL + 'userUnlike', {
		"itemid": id
	},
	function (datas) {
		$(".like-counter").html(datas);
		$("input[type=checkbox]").removeAttr('checked');
/*$("#like-icon"+id).removeClass("fa-heart");
$("#like-icon"+id).addClass("fa-heart-o");*/
$('.like-icon' + id).attr("src", BaseURL + "images/icons/heart_icon.png");
$("#like-txt" + id).html(likebtncnt);
return false;
}
);
}
}
function itemcoulist(id) {
	$("#listerr").hide();
	var addusrlist = true;
	unfantid = id;
	var BaseURL = getBaseURL();
//alert(id);
//var imgselector = '.getimgurl'+id;
var likedbtncnt = $("#likedbtncnt").val();
var likebtncnt = $("#likebtncnt").val();
var liketxt = $(".like-txt" + id).html();
//alert(likedbtncnt);
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
} else {
	$("#add-to-list").modal('show');
}
var imgselectorattr = $("#img_id" + id).val();
//alert(imgselectorattr);
//alert($('#img_id'+id).find('img:first').attr('src'));
//$("#selectimgs").attr("src",$(imgselector).attr('src'));
//$("#selectimgs").css({"background":"rgba(0, 0, 0, 0) url('"+imgselectorattr+"') no-repeat scroll center center/contain"});
$("#selectimgs").attr("src", imgselectorattr);
//console.log("List Item id"+id);
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
} else {
	$.post(BaseURL + 'userlike', {
		"itemid": id
	},
	function (datas) {
		datas = datas.split('-_-');
		datass = eval(datas[1]);
//$("input[type=checkbox]").removeAttr('checked');
for (var i = 0; i < datass.length; i++) {
	if (datass[i]['listcheck'] == '1') {
		$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', true);
	} else {
		$("input[type=checkbox][value='" + datass[i]['listname'] + "']").prop('checked', false);
	}
}
$(".like-counter").html(datas[0]);
$(".like-icon" + id).removeClass("fa-heart-o");
$(".like-icon" + id).addClass("fa-heart");
$(".like-txt" + id).html(likedbtncnt);
return false;
}
);
}
/*else
{
unfant = false;
$.post(BaseURL+'userUnlike', {"itemid":id},
function(datas) {
$(".like-counter").html(datas);
$("input[type=checkbox]").removeAttr('checked');
$(".like-icon"+id).removeClass("fa-heart");
$(".like-icon"+id).addClass("fa-heart-o");
$(".like-txt"+id).html(likebtncnt);
return false;
}
);
}*/
}
function sendmessage(sender) {
	$('.cs-error').html('');
	$('.cs-error').hide();
	var baseurl = getBaseURL() + 'sendmessage';
	var query = $('#queryaboutitem').val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	var subject = query;
	if (query == '') {
		$('.cs-error').removeAttr('data-trn-key');
		$('.cs-error').html('Select your query');
		translator.lang(sessionlang);
		$('.cs-error').show();
		return false;
	} else if (query == 'others') {
		subject = $('#subject').val();
		if (subject == '') {
			$('.cs-error').removeAttr('data-trn-key');
			$('.cs-error').html('Subject Cannot be Empty');
			translator.lang(sessionlang);
			$('.cs-error').show();
			return false;
		}
	}
	var message = $('#message').val();
	var itemId = $('#itemid').val();
	var buyerId = $('#userid').val();
	var merchantId = $('#merchantid').val();
	var itemName = $('#itemname').val();
	var username = $('#usernames').val();
	var sellername = $('#merchantname').val();
	if ($.trim(message) == '') {
		$('.cs-error').removeAttr('data-trn-key');
		$('.cs-error').html('Message Cannot be Empty');
		translator.lang(sessionlang);
		$('.cs-error').show();
		return false;
	}
	$('.cs-error').html('');
	if (sendmsgajax == 1) {
		sendmsgajax = 0;
		$.ajax({
			url: baseurl,
			type: "post",
			dataType: "html",
			data: {
				'itemId': itemId,
				'merchantId': merchantId,
				'buyerId': buyerId,
				'subject': subject,
				'message': message,
				'itemName': itemName,
				'username': username,
				'sellername': sellername,
				'sender': sender
			},
			beforeSend: function () {
//$('.sendmessageloader').show();
},
success: function (responce) {
	$('.sendmessageloader').hide();
	var out = eval(responce);
	if (out[0] == 'success') {
		$('.cs-success').show();
		$('.contactsellerli').html(out[1]);
	}
	$("#contact-seller-modal").modal('hide');
	sendmsgajax = 1;
}
});
	}
}
function ratingClick(value) {
	$('.current-rate').html(value);
	$('#rateval').val(value);
	rating = value;
}
/************* Rating & review ************/
function review(sellerid, userid) {
	var BaseURL = getBaseURL();
	review_content = $("#review").val();
	content_len = review_content.length;
	rating_val = $("#rateval").val();
	load_count = $("#loadcount").val();

	orderid = $("#ordername").val();
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	review_title = $("#review_title").val();
	if (orderid == "" || orderid == null || orderid == '0') {
		$("#raterr").removeAttr('data-trn-key');
		$("#raterr").show();
		$("#raterr").html("Please select order id");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#raterr').fadeOut('slow');
		}, 5000);
	} else if (rating_val == "" || rating_val == 0) {
		$("#raterr").removeAttr('data-trn-key');
		$("#raterr").show();
		$("#raterr").html("Please select rating");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#raterr').fadeOut('slow');
		}, 5000);
	} else if ($.trim(review_title) == "") {
		$("#raterr").removeAttr('data-trn-key');
		$("#raterr").show();
		$("#raterr").html("Enter review title");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#raterr').fadeOut('slow');
		}, 5000);
	} else if ($.trim(review_content) == "") {
		$("#raterr").removeAttr('data-trn-key');
		$("#raterr").show();
		$("#raterr").html("Enter review");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#raterr').fadeOut('slow');
		}, 5000);
	} else if (content_len < 200) {
		$("#raterr").removeAttr('data-trn-key');
		$("#raterr").show();
		$("#raterr").html("Enter minimum 200 characters for review");
		translator.lang(sessionlang);
		setTimeout(function () {
			$('#raterr').fadeOut('slow');
		}, 5000);
	} else {
		$("#raterr").html('');
		$.ajax({
			type: "POST",
			url: BaseURL + 'rating',
			data: {
				"order_id": orderid,
				"user_id": userid,
				"seller_id": sellerid,
				"rate_val": rating_val,
				"review_tit": review_title,
				"review_cont": review_content,
				"loadcount": load_count
			},
			beforeSend: function () {
				$("#reviewsubmit").attr("disabled", true);
			},
			success: function (data) {
				$("#seller-review-modal").modal('hide');
/*$("#disp").html(data);
$("#loadcount").val("2");*/
window.location.reload();
}
});
	}
}
function show_fashion_image(fashionid, fashionimage) {
	var BaseURL = getBaseURL();
	fashion_image = BaseURL + 'media/avatars/original/' + fashionimage;
//alert(fashion_image);
fashionuserimage = $("#fashionuserimage" + fashionid).val();
fashionusername = $("#fashionusername" + fashionid).val();
$("#fashionimage").attr("src", fashion_image);
$("#fashionuserimage").css("background-image", "url(" + BaseURL + 'media/avatars/thumb70/' + fashionuserimage + ")");
$("#fashionusername").html(fashionusername);
}
function isValidEmail(email) {
	var emailreg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return emailreg.test(email);
}
function ajaxuserautoc(event, val, commndid, autocompid, commndvar) {
/*if (searchReq.readyState == 4 || searchReq.readyState == 0) {
var str = escape(document.getElementById('txtSearch').value);
searchReq.open("GET", 'searchSuggest.php?search=' + str, true);
searchReq.onreadystatechange = handleSearchSuggest;
searchReq.send(null);
}*/
//var nn = document.getElementById('comment_msg').value;
var searchString = $('#' + commndid).val();
//var stringLength = searchString.length;
//alert(commndid);
var baseurl = getBaseURL();
var keycode = event.keyCode;
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = baseurl + "login";
	return false;
}
if (typeof (atuser) == 'undefined') {
//console.log('Defining atuser array');
atuser = new Array();
}
if (typeof (hashtag) == 'undefined') {
//console.log('Defining hashtag array');
hashtag = new Array();
hashtag[commndvar] = 0;
//hashtag['newtags'+commndvar] = '';
//hashtag['oldtags'+commndvar] = '';
}
var lastChar = searchString.slice(-1);
firstchar = searchString.substring(0, 1);
if (firstchar != '@') {
//atuser[commndvar] = 0;
}
if (firstchar != '#') {
//hashtag[commndvar] = 0;
}
if (lastChar == '@') {
	atuser[commndvar] = 1;
	hashtag[commndvar] = 0;
//console.log('@ character'+atuser[commndvar]);
} else if (lastChar == '#') {
	hashtag[commndvar] = 1;
	atuser[commndvar] = 0;
//console.log('# character'+hashtag[commndvar]);
} else if (lastChar.match(/[^a-zA-Z0-9_-]/g)) {
	atuser[commndvar] = 0;
	hashtag[commndvar] = 0;
/*console.log('Current Hashtag: '+currentHash);
if (currentHash != ''){
hashtag['newtags'+commndvar] += currentHash+',';
}
currentHash = '';
console.log('New Hashtag array: '+hashtag['newtags'+commndvar]);*/
//console.log('special or space character # '+hashtag[commndvar]+" @ "+atuser[commndvar]);
}
/*else{
if (currentHash != ''){
var checkhashtag = currentHash.split(' ');
if (checkhashtag.length > 1){
currentHash = '';
hashtag[commndvar] = 0;
}
}
}*/
//console.log(event.keyCode);
// validate the email and website
else if (searchString != '') {
	var splitted = searchString.split(' ');
	var splittedLength = splitted.length;
	for (j = 0; j < splittedLength; j++) {
		var string = splitted[j];
	}
	var showString = searchString.split(string);
	if (isValidEmail(string)) {
		$('#comment_msg').val(showString);
		var splitLast = $('#comment_msg').val();
		var splitLastStr = splitLast.substr(0, splitLast.length - 1);
		$('#comment_msg').val(splitLastStr);
		$("#Error-alert").show();
		$('#Error-alert').text('Email Address are not Allowed');
		$("#Error-alert").fadeOut(5000);
	}
}
var iChars = "@";
// for (var i = 0; i < searchString.length; i++) {
// 	console.log(searchString.charAt(i));
//    if (iChars.indexOf(searchString.charAt(i)) != -1) {
	if (typeof (atuser) != 'undefined' && atuser[commndvar] == 1) {
		var splitted = searchString.split('@');
		var splittedLength = splitted.length;
		var splitLast = splittedLength - 1;
//console.log(splitted);
var beforeString = splitted[0];
for (var s = 1; s < splitLast; s++) {
	beforeString += "@" + splitted[s];
}
var splittedstr = splitted[splitLast];
var splittedstrbef = beforeString;
if (keycode === 40) { //Down arrow
	$('.' + autocompid + ' .usersearch li').next().focus();
}
// else if (keycode === 38) { //Up arrow
// 	$('.'+autocompid+' .usersearch li').next().focus();
//}
if (keycode == 27) {
	$('.' + autocompid + '.usersearch').hide();
	$('.' + autocompid).hide();
}
//  alert(splittedstrbef);
if (keycode != 40 && keycode != 38 && keycode != 37 && keycode != 39 && keycode != 13 && keycode != 27) {
	$.ajax({
		url: baseurl + 'ajaxUserAuto',
		type: "post",
		data: {
			searchStr: splittedstr
		},
		success: function (responce) {
			obj = "";
			var outli = eval(responce);
			if (outli['0'] == 'No Data') {
				$('.' + autocompid + ' .usersearch').hide();
				$('.' + autocompid).hide();
			} else {
				$(".usersearch").show();
				$('.' + autocompid).show();
				obj = JSON.parse(responce);
				$("#" + commndid)
		// don't navigate away from the field on tab when selecting an item
		.bind("keydown", function (event) {
			if (event.keyCode === $.ui.keyCode.TAB &&
				$(this).autocomplete("instance").menu.active) {
				event.preventDefault();
		}
	})
		.autocomplete({
			minLength: 0,
			source: function (request, response) {
				// delegate back to autocomplete, but extract the last term
				response($.ui.autocomplete.filter(
					obj, extractLast(request.term)));
			},
			//    source:projects,
			focus: function () {
				// prevent value inserted on focus
				return false;
			},
			select: function (event, ui) {
				var terms = split(this.value);
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push(ui.item.value);
				// add placeholder to get the comma-and-space at the end
				terms.push("");
				this.value = terms.join(" ");
				var selected_label = ui.item.label;
				var selected_value = ui.item.value;
				return false;
			}
		});
	//$('.'+autocompid+' .usersearch').html(outli['0']);
	//var l = 0;
	$('.' + autocompid + ' .usersearch li').click(function () {
		className = $(this).text();
		document.getElementById(commndid).value = splittedstrbef + '@' + className + ' ';
		$('.' + autocompid).hide();
		$('#' + commndid).focus();
		atuser[commndvar] = 0;
		//l++;
	});
}
}
});
}
} else if (typeof (hashtag) != 'undefined' && hashtag[commndvar] == 1) {
	var splitted = searchString.split('#');
	var splittedLength = splitted.length;
	var splitLast = splittedLength - 1;
//console.log(splitted);
var beforeString = splitted[0];
for (var s = 1; s < splitLast; s++) {
	beforeString += "#" + splitted[s];
}
var splittedstr = splitted[splitLast];
//currentHash = splittedstr;
var splittedstrbef = beforeString;
//  alert(splittedstrbef);
$.ajax({
	url: baseurl + 'ajaxHashAuto',
	type: "post",
	data: {
		searchStr: splittedstr
	},
	success: function (responce) {
		var outli = eval(responce);
		if (outli['0'] == 'No Data') {
			$('.' + autocompid + ' .usersearch').hide();
			$('.' + autocompid).hide();
		} else {
			$('.usersearch').show();
			$('.' + autocompid).show();
			obj = JSON.parse(responce);
			$("#" + commndid)
	// don't navigate away from the field on tab when selecting an item
	.bind("keydown", function (event) {
		if (event.keyCode === $.ui.keyCode.TAB &&
			$(this).autocomplete("instance").menu.active) {
			event.preventDefault();
	}
})
	.autocomplete({
		minLength: 0,
		source: function (request, response) {
			// delegate back to autocomplete, but extract the last term
			response($.ui.autocomplete.filter(
				obj, extractLast(request.term)));
		},
		//    source:projects,
		focus: function () {
			// prevent value inserted on focus
			return false;
		},
		select: function (event, ui) {
			var terms = split(this.value);
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push(ui.item.value);
			// add placeholder to get the comma-and-space at the end
			terms.push("");
			this.value = terms.join(" ");
			var selected_label = ui.item.label;
			var selected_value = ui.item.value;
			return false;
		}
	});
//$('.'+autocompid+' .usersearch').html(outli['0']);
//var l = 0;
$('.' + autocompid + ' .usersearch li').click(function () {
	className = $(this).text();
	document.getElementById(commndid).value = splittedstrbef + '#' + className + ' ';
	$('.' + autocompid).hide();
	$('#' + commndid).focus();
	hashtag[commndvar] = 0;
	//currentHash = '';
});
}
}
});
}
//}
}
function split(val) {
	return val.split(/ \s*/);
}
function extractLast(term) {
	return split(term).pop();
}
function strip(html) {
	var tmp = document.createElement("DIV");
	tmp.innerHTML = html;
	return tmp.textContent || tmp.innerText;
}
function cmntsubmit() {
	var commentss = $('#comment_msg').val();
	commentss = $.trim(commentss);
	var commid = $('#commid').val();
	var itemid = $('#itemid').val();
	var userid = $('#userid').val();
	var usernames = $('#usernames').val();
	var userimges = $('#userimges').val();
	var baseurl = getBaseURL();
	var comment_status;
	var logid = $("#loguser_id").val();
	commentss = strip(commentss);
	if (logid == 0) {
		window.location.href = baseurl + "login";
		return false;
	} else if ($.trim(commentss) == "") {
		$("#cmnterr").show();
		$("#comment_msg").val("");
		setTimeout(function () {
			$('#cmnterr').fadeOut('slow');
		}, 5000);
		return false;
	} else {
		if (commentss != '') {
			comment_status = false;
//var str = $('#a').text();
var pattern = /@([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var commentsss = commentss + " ";
var atusers = '';
if (commentsss.match(pattern)) {
	var result = commentsss.match(pattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//var link = "<a href='"+baseurl+"people/"+result[i]+"'>"+result[i]+"</a>";
if (atusers == '') {
	atusers += desired;
} else {
	atusers += ',' + desired;
}
var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>@</span><a href='" + baseurl + "people/" + desired + "'>" + desired + "</a></span>";
var replacestr = '@' + desired;
//var replacestr = result[i];
commentsss = commentsss.replace(replacestr, link);
}
//console.log(commentsss);return;
//commentsss = commentss.replace(replacestr,link);
}
var hashPattern = /#([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var hashComment = commentsss;
var hashtags = '';
if (hashComment.match(hashPattern)) {
	var result = hashComment.match(hashPattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//if ($.inArray('desired', hashtag['newtags0']) > -1){
	if (hashtags == '') {
		hashtags += desired;
	} else {
		hashtags += ',' + desired;
	}
	var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>#</span><a href='" + baseurl + "hashtag/" + desired + "'>" + desired + "</a></span>";
	var replacestr = '#' + desired;
	hashComment = hashComment.replace(replacestr, link);
}
commentsss = hashComment;
//console.log('Hastags used: '+hashtags);
//console.log(hashComment);return;
//commentsss = commentss.replace(replacestr,link);
}
$.ajax({
	type: "POST",
	url: baseurl + 'addcomments',
	data: {
		"userid": userid,
		"itemid": itemid,
		"commentss": commentsss,
		'hashtags': hashtags,
		"atusers": atusers
	},
	beforeSend: function () {
		$('.post-loading').show();
		$("#commentssave").attr("disabled", "disabled");
	},
	success: function (datas) {
		window.location.reload();
/*var radius = "";
var appval = '<div class="comment-row col-xs-12 col-sm-12 comment delecmt_'+datas+'" cuid="'+userid+'" commid="'+datas+'"><div class="sold-by-prof-pic-cnt col-xs-2 col-lg-1 padding-right0"><a href="'+baseurl+'people/'+usernames+'" class="url"><div class="sold-by-prof-pic" style="background:url('+baseurl+'media/avatars/thumb70/'+userimges+')"></div></a></div><div class="comment-section col-xs-10 col-lg-11 padding-right0"><a href="'+baseurl+'people/'+usernames+'" class="url"><div class="bold-font txt-uppercase comment-name">'+usernames+'</div></a><div class="c-text form-control-2 comment-input-box no-padding col-lg-11 col-md-12" id="txt1'+datas+'" style="display:none;"><textarea  class="comment_textarea col-lg-12 col-md-12 form-control" rows="2" id="txt1val'+datas+'" maxlength="180" onkeyup="ajaxuserautocedit(event,this.value, '+datas+',\'comment-autocompleteN'+datas+'\',\'0\');">'+commentss+'</textarea></div><div id="comment-button'+datas+'" class="edit-comment-button comment-button col-lg-12 col-md-12" style="display: none;"><button class="btn filled-btn follow-btn primary-color-bg pull-right trn" onclick = "show_editcmnt('+datas+')" >Save comment</button></div><div  class="col-lg-2 col-md-12 btn-blue-right" id="editcmnterr'+datas+'" style="font-size:13px;color:red;font-weight:bold;display:none;float:right;">Please enter comment</div><div class="margin-top10 comment-txt" id="oritext'+datas+'">'+commentsss+'</div><div id="oritextvalafedit'+datas+'"></div><div class="comment-autocomplete comment-autocompleteN'+datas+' col-lg-11 no-padding" style="display: none;left: 87px; top: 115px;"><ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0" role="menu"></ul></div><div class="comment-edit-cnt c-reply col-lg-12 no-hor-padding margin-top10"><a class="comment-edit trn" href="javascript:void(0);" onclick = "return show_editcmnt('+datas+')">Edit</a><a class="comment-delete red-txt trn" href="javascript:void(0);" onclick = "return deletecmnt('+datas+')">Delete</a></div></div></div>';
	$("#sa").append(appval);
var sessionlang = $("#languagecode").val();
var translator = $('body').translate({t: dict});
translator.lang(sessionlang);
	document.getElementById('comment_msg').value = "";
	commentsss = "";
	comment_status = true;
	$('.post-loading').hide();
	$("#commentssave").removeAttr("disabled");
	$("#write-comment-modal").modal('hide');*/
},
dataType: 'html'
});
}
}
}
function ajaxuserautocedit(event, val, commndid, autocompid, commndvar) {
/*if (searchReq.readyState == 4 || searchReq.readyState == 0) {
var str = escape(document.getElementById('txtSearch').value);
searchReq.open("GET", 'searchSuggest.php?search=' + str, true);
searchReq.onreadystatechange = handleSearchSuggest;
searchReq.send(null);
}*/
//var nn = document.getElementById('comment_msg').value;
var searchString = $('#txt1val' + commndid).val();
//var stringLength = searchString.length;
//alert(commndid);
var baseurl = getBaseURL();
var keycode = event.keyCode;
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = baseurl + "login";
	return false;
}
if (typeof (atuser) == 'undefined') {
//console.log('Defining atuser array');
atuser = new Array();
}
if (typeof (hashtag) == 'undefined') {
//console.log('Defining hashtag array');
hashtag = new Array();
hashtag[commndvar] = 0;
//hashtag['newtags'+commndvar] = '';
//hashtag['oldtags'+commndvar] = '';
}
var lastChar = searchString.slice(-1);
if (lastChar == '@') {
	atuser[commndvar] = 1;
	hashtag[commndvar] = 0;
//console.log('@ character'+atuser[commndvar]);
} else if (lastChar == '#') {
	hashtag[commndvar] = 1;
	atuser[commndvar] = 0;
//console.log('# character'+hashtag[commndvar]);
} else if (lastChar.match(/[^a-zA-Z0-9_-]/g)) {
	atuser[commndvar] = 0;
	hashtag[commndvar] = 0;
/*console.log('Current Hashtag: '+currentHash);
if (currentHash != ''){
hashtag['newtags'+commndvar] += currentHash+',';
}
currentHash = '';
console.log('New Hashtag array: '+hashtag['newtags'+commndvar]);*/
//console.log('special or space character # '+hashtag[commndvar]+" @ "+atuser[commndvar]);
}
/*else{
if (currentHash != ''){
var checkhashtag = currentHash.split(' ');
if (checkhashtag.length > 1){
currentHash = '';
hashtag[commndvar] = 0;
}
}
}*/
//console.log(event.keyCode);
// validate the email and website
else if (searchString != '') {
	var splitted = searchString.split(' ');
	var splittedLength = splitted.length;
	for (j = 0; j < splittedLength; j++) {
		var string = splitted[j];
	}
	var showString = searchString.split(string);
	if (isValidEmail(string)) {
		$('#comment_msg').val(showString);
		var splitLast = $('#comment_msg').val();
		var splitLastStr = splitLast.substr(0, splitLast.length - 1);
		$('#comment_msg').val(splitLastStr);
		$("#Error-alert").show();
		$('#Error-alert').text('Email Address are not Allowed');
		$("#Error-alert").fadeOut(5000);
	} else if (isValidWeb(string)) {
		$('#comment_msg').val(showString);
		var splitLast = $('#comment_msg').val();
		var splitLastStr = splitLast.substr(0, splitLast.length - 1);
		$('#comment_msg').val(splitLastStr);
		$("#Error-alert").show();
		$('#Error-alert').text('Web Address are not Allowed');
		$("#Error-alert").fadeOut(5000);
	} else if (isValidWebsite(string)) {
		$('#comment_msg').val(showString);
		var splitLast = $('#comment_msg').val();
		var splitLastStr = splitLast.substr(0, splitLast.length - 1);
		$('#comment_msg').val(splitLastStr);
		$("#Error-alert").show();
		$('#Error-alert').text('Web Address are not Allowed');
		$("#Error-alert").fadeOut(5000);
	}
}
var iChars = "@";
// for (var i = 0; i < searchString.length; i++) {
// 	console.log(searchString.charAt(i));
//    if (iChars.indexOf(searchString.charAt(i)) != -1) {
	if (typeof (atuser) != 'undefined' && atuser[commndvar] == 1) {
		var splitted = searchString.split('@');
		var splittedLength = splitted.length;
		var splitLast = splittedLength - 1;
//console.log(splitted);
var beforeString = splitted[0];
for (var s = 1; s < splitLast; s++) {
	beforeString += "@" + splitted[s];
}
var splittedstr = splitted[splitLast];
var splittedstrbef = beforeString;
if (keycode === 40) { //Down arrow
	$('.' + autocompid + ' .usersearch li').next().focus();
} else if (keycode === 38) { //Up arrow
	$('.' + autocompid + ' .usersearch li').next().focus();
}
if (keycode == 27)
	$(".usersearch").hide();
//  alert(splittedstrbef);
if (keycode != 40 && keycode != 38 && keycode != 37 && keycode != 39 && keycode != 13 && keycode != 27) {
	$.ajax({
		url: baseurl + 'ajaxUserAuto',
		type: "post",
		data: {
			searchStr: splittedstr
		},
		success: function (responce) {
			var outli = eval(responce);
			if (outli['0'] == 'No Data') {
				$('.' + autocompid + ' .usersearch').hide();
			} else {
				$(".usersearch").show();
				$('.' + autocompid).show();
				$('.' + autocompid + ' .usersearch').html(outli['0']);
	//$('.'+autocompid+' .usersearch').listview("refresh");
	//var l = 0;
	$('.' + autocompid + ' .usersearch li').click(function () {
		className = $(this).text();
		document.getElementById("txt1val" + commndid).value = splittedstrbef + '@' + className + ' ';
		$('.' + autocompid).hide();
		$('#txt1val' + commndid).focus();
		atuser[commndvar] = 0;
		//l++;
	});
}
}
});
}
} else if (typeof (hashtag) != 'undefined' && hashtag[commndvar] == 1) {
	var splitted = searchString.split('#');
	var splittedLength = splitted.length;
	var splitLast = splittedLength - 1;
//console.log(splitted);
var beforeString = splitted[0];
for (var s = 1; s < splitLast; s++) {
	beforeString += "#" + splitted[s];
}
var splittedstr = splitted[splitLast];
//currentHash = splittedstr;
var splittedstrbef = beforeString;
//  alert(splittedstrbef);
$.ajax({
	url: baseurl + 'ajaxHashAuto',
	type: "post",
	data: {
		searchStr: splittedstr
	},
	success: function (responce) {
		var outli = eval(responce);
		if (outli['0'] == 'No Data') {
			$('.' + autocompid + ' .usersearch').hide();
		} else {
			$('.usersearch').show();
			$('.usersearch').css('display', 'block');
			$('.' + autocompid).show();
			$('.' + autocompid + ' .usersearch').html(outli['0']);
//var l = 0;
$('.' + autocompid + ' .usersearch li').click(function () {
	className = $(this).text();
	document.getElementById("txt1val" + commndid).value = splittedstrbef + '#' + className + ' ';
	$('.' + autocompid).hide();
	$('#txt1val' + commndid).focus();
	hashtag[commndvar] = 0;
	//currentHash = '';
});
}
}
});
}
//}
}
function show_editcmnt(commentid) {
	$("#edit-comment-modal").modal('show');
	$("#commentid").val(commentid);
	commentss = $("#txt1val" + commentid).val();
/*var a=decodeHtmlEntity(commentss);
alert(a);*/
$("#txt1val").val(commentss);
}
function ajaxuserautocedits(event, val, commndid, autocompid, commndvar) {
/*if (searchReq.readyState == 4 || searchReq.readyState == 0) {
var str = escape(document.getElementById('txtSearch').value);
searchReq.open("GET", 'searchSuggest.php?search=' + str, true);
searchReq.onreadystatechange = handleSearchSuggest;
searchReq.send(null);
}*/
//var nn = document.getElementById('comment_msg').value;
var searchString = $('#' + commndid).val();
//var stringLength = searchString.length;
//alert(commndid);
var baseurl = getBaseURL();
var keycode = event.keyCode;
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = baseurl + "login";
	return false;
}
if (typeof (atuser) == 'undefined') {
//console.log('Defining atuser array');
atuser = new Array();
}
if (typeof (hashtag) == 'undefined') {
//console.log('Defining hashtag array');
hashtag = new Array();
hashtag[commndvar] = 0;
//hashtag['newtags'+commndvar] = '';
//hashtag['oldtags'+commndvar] = '';
}
var lastChar = searchString.slice(-1);
firstchar = searchString.substring(0, 1);
if (firstchar != '@') {
//atuser[commndvar] = 0;
}
if (firstchar != '#') {
//hashtag[commndvar] = 0;
}
if (lastChar == '@') {
	atuser[commndvar] = 1;
	hashtag[commndvar] = 0;
//console.log('@ character'+atuser[commndvar]);
} else if (lastChar == '#') {
	hashtag[commndvar] = 1;
	atuser[commndvar] = 0;
//console.log('# character'+hashtag[commndvar]);
} else if (lastChar.match(/[^a-zA-Z0-9_-]/g)) {
	atuser[commndvar] = 0;
	hashtag[commndvar] = 0;
/*console.log('Current Hashtag: '+currentHash);
if (currentHash != ''){
hashtag['newtags'+commndvar] += currentHash+',';
}
currentHash = '';
console.log('New Hashtag array: '+hashtag['newtags'+commndvar]);*/
//console.log('special or space character # '+hashtag[commndvar]+" @ "+atuser[commndvar]);
}
/*else{
if (currentHash != ''){
var checkhashtag = currentHash.split(' ');
if (checkhashtag.length > 1){
currentHash = '';
hashtag[commndvar] = 0;
}
}
}*/
//console.log(event.keyCode);
// validate the email and website
else if (searchString != '') {
	var splitted = searchString.split(' ');
	var splittedLength = splitted.length;
	for (j = 0; j < splittedLength; j++) {
		var string = splitted[j];
	}
	var showString = searchString.split(string);
	if (isValidEmail(string)) {
		$('#comment_msg').val(showString);
		var splitLast = $('#comment_msg').val();
		var splitLastStr = splitLast.substr(0, splitLast.length - 1);
		$('#comment_msg').val(splitLastStr);
		$("#Error-alert").show();
		$('#Error-alert').text('Email Address are not Allowed');
		$("#Error-alert").fadeOut(5000);
	}
}
var iChars = "@";
// for (var i = 0; i < searchString.length; i++) {
// 	console.log(searchString.charAt(i));
//    if (iChars.indexOf(searchString.charAt(i)) != -1) {
	if (typeof (atuser) != 'undefined' && atuser[commndvar] == 1) {
		var splitted = searchString.split('@');
		var splittedLength = splitted.length;
		var splitLast = splittedLength - 1;
//console.log(splitted);
var beforeString = splitted[0];
for (var s = 1; s < splitLast; s++) {
	beforeString += "@" + splitted[s];
}
var splittedstr = splitted[splitLast];
var splittedstrbef = beforeString;
if (keycode === 40) { //Down arrow
	$('.' + autocompid + ' .usersearch li').next().focus();
}
// else if (keycode === 38) { //Up arrow
// 	$('.'+autocompid+' .usersearch li').next().focus();
//}
if (keycode == 27) {
	$('.' + autocompid + '.usersearch').hide();
	$('.' + autocompid).hide();
}
//  alert(splittedstrbef);
if (keycode != 40 && keycode != 38 && keycode != 37 && keycode != 39 && keycode != 13 && keycode != 27) {
	$.ajax({
		url: baseurl + 'ajaxUserAuto',
		type: "post",
		data: {
			searchStr: splittedstr
		},
		success: function (responce) {
			obj = "";
			var outli = eval(responce);
			if (outli['0'] == 'No Data') {
				$('.' + autocompid + ' .usersearch').hide();
				$('.' + autocompid).hide();
			} else {
				$(".usersearch").show();
				$('.' + autocompid).show();
				obj = JSON.parse(responce);
				$("#" + commndid)
		// don't navigate away from the field on tab when selecting an item
		.bind("keydown", function (event) {
			if (event.keyCode === $.ui.keyCode.TAB &&
				$(this).autocomplete("instance").menu.active) {
				event.preventDefault();
		}
	})
		.autocomplete({
			minLength: 0,
			source: function (request, response) {
				// delegate back to autocomplete, but extract the last term
				response($.ui.autocomplete.filter(
					obj, extractLast(request.term)));
			},
			//    source:projects,
			focus: function () {
				// prevent value inserted on focus
				return false;
			},
			select: function (event, ui) {
				var terms = split(this.value);
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push(ui.item.value);
				// add placeholder to get the comma-and-space at the end
				terms.push("");
				this.value = terms.join(" ");
				var selected_label = ui.item.label;
				var selected_value = ui.item.value;
				return false;
			}
		});
	//$('.'+autocompid+' .usersearch').html(outli['0']);
	//var l = 0;
	$('.' + autocompid + ' .usersearch li').click(function () {
		className = $(this).text();
		document.getElementById(commndid).value = splittedstrbef + '@' + className + ' ';
		$('.' + autocompid).hide();
		$('#' + commndid).focus();
		atuser[commndvar] = 0;
		//l++;
	});
}
}
});
}
} else if (typeof (hashtag) != 'undefined' && hashtag[commndvar] == 1) {
	var splitted = searchString.split('#');
	var splittedLength = splitted.length;
	var splitLast = splittedLength - 1;
//console.log(splitted);
var beforeString = splitted[0];
for (var s = 1; s < splitLast; s++) {
	beforeString += "#" + splitted[s];
}
var splittedstr = splitted[splitLast];
//currentHash = splittedstr;
var splittedstrbef = beforeString;
//  alert(splittedstrbef);
$.ajax({
	url: baseurl + 'ajaxHashAuto',
	type: "post",
	data: {
		searchStr: splittedstr
	},
	success: function (responce) {
		var outli = eval(responce);
		if (outli['0'] == 'No Data') {
			$('.' + autocompid + ' .usersearch').hide();
			$('.' + autocompid).hide();
		} else {
			$('.usersearch').show();
			$('.' + autocompid).show();
			obj = JSON.parse(responce);
			$("#" + commndid)
	// don't navigate away from the field on tab when selecting an item
	.bind("keydown", function (event) {
		if (event.keyCode === $.ui.keyCode.TAB &&
			$(this).autocomplete("instance").menu.active) {
			event.preventDefault();
	}
})
	.autocomplete({
		minLength: 0,
		source: function (request, response) {
			// delegate back to autocomplete, but extract the last term
			response($.ui.autocomplete.filter(
				obj, extractLast(request.term)));
		},
		//    source:projects,
		focus: function () {
			// prevent value inserted on focus
			return false;
		},
		select: function (event, ui) {
			var terms = split(this.value);
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push(ui.item.value);
			// add placeholder to get the comma-and-space at the end
			terms.push("");
			this.value = terms.join(" ");
			var selected_label = ui.item.label;
			var selected_value = ui.item.value;
			return false;
		}
	});
//$('.'+autocompid+' .usersearch').html(outli['0']);
//var l = 0;
$('.' + autocompid + ' .usersearch li').click(function () {
	className = $(this).text();
	document.getElementById(commndid).value = splittedstrbef + '#' + className + ' ';
	$('.' + autocompid).hide();
	$('#' + commndid).focus();
	hashtag[commndvar] = 0;
	//currentHash = '';
});
}
}
});
}
//}
}
function isValidWeb(web) {
	var webreg = /\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i;
	return webreg.test(web);
}
function isValidWebsite(web) {
	var webreg = /^([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return webreg.test(web);
}
function editcmnt(id) {
//alert(id);
$("#oritext" + id).css('display', 'none');
$("#txt1" + id).css('display', 'inline');
$("#comment-button" + id).css('display', 'block');
$("#oritextvalafedit" + id).css('display', 'none');
var edithide = " .c-reply";
$(edithide).hide();
}
function editcmntsave(id) {
//alert(id);
var txt1val = $("#txt1val" + id).val() + " ";
//alert(txt1val);
baseurl = getBaseURL();
var logid = $("#loguser_id").val();
if (logid == 0) {
	window.location.href = baseurl + "login";
	return false;
} else if ($.trim(txt1val) == "") {
	$("#editcmnterr" + id).show();
	$("#txt1val" + id).val("");
	$("#txt1val" + id).keydown(function () {
		$("#editcmnterr" + id).hide();
	});
	return false;
} else if (id != '' && txt1val != '') {
	var pattern = /@([\S]*?)(?=\s)/g;
	if (txt1val.match(pattern)) {
		var result = txt1val.match(pattern);
		for (var i = 0; i < result.length; i++) {
			if (result[i].length > 1) {
				result[i] = result[i].substring(1, result[i].length);
				var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
			}
//alert(result[i]);
var link = "<a href='" + baseurl + "people/" + desired + "'>" + desired + "</a>";
var replacestr = desired;
//var link = "<a href='"+baseurl+"people/"+result[i]+"'>"+result[i]+"</a>";
//var replacestr = result[i];
txt1val = txt1val.replace(replacestr, link);
}
//txt1val = txt1val.replace(replacestr,link);
}
var hashPattern = /#([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var hashComment = txt1val;
var hashtags = '';
if (hashComment.match(hashPattern)) {
	var result = hashComment.match(hashPattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//if ($.inArray('desired', hashtag['newtags0']) > -1){
	if (hashtags == '') {
		hashtags += desired;
	} else {
		hashtags += ',' + desired;
	}
	var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>#</span><a href='" + baseurl + "hashtag/" + desired + "'>" + desired + "</a></span>";
	var replacestr = '#' + desired;
	hashComment = hashComment.replace(replacestr, link);
}
txt1val = hashComment;
//console.log('Hastags used: '+hashtags);
//console.log(hashComment);return;
//commentsss = commentss.replace(replacestr,link);
}
$.ajax({
	type: "POST",
	url: baseurl + 'editcommentsave',
	data: {
		"cmtid": id,
		"cmntval": txt1val
	},
	beforeSend: function () {
		$(".btn-savecmd").attr("disabled", "disabled");
	},
	success: function (datas) {
		$("#oritextvalafedit" + id).css('display', 'inline');
		$("#oritext" + id).css('display', 'none');
		$("#txt1" + id).css('display', 'none');
		$("#comment-button" + id).css('display', 'none');
		var cmtval = '<div class="margin-top10 comment-txt" id="oritext' + id + '">' + datas + '</p>';
		$("#oritextvalafedit" + id).append(cmtval);
		$('#oritext' + id).remove();
		$(".btn-savecmd").removeAttr("disabled");
		var edithide = ".delecmt_" + id + " .c-reply";
		$(edithide).show();
	},
	dataType: 'html'
});
}
}
function editcmntssave() {
//alert(id);
var txt1val = $("#txt1val").val() + " ";
id = $("#commentid").val();
//alert(txt1val);
baseurl = getBaseURL();
var logid = $("#loguser_id").val();
if (logid == 0) {
	window.location.href = baseurl + "login";
	return false;
} else if ($.trim(txt1val) == "") {
	$("#editcmnterr").show();
	$("#txt1val").val("");
	$("#txt1val").keydown(function () {
		$("#editcmnterr").hide();
	});
	return false;
} else if (id != '' && txt1val != '') {
	var pattern = /@([\S]*?)(?=\s)/g;
	if (txt1val.match(pattern)) {
		var result = txt1val.match(pattern);
		for (var i = 0; i < result.length; i++) {
			if (result[i].length > 1) {
				result[i] = result[i].substring(1, result[i].length);
				var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
			}
//alert(result[i]);
var link = "<a href='" + baseurl + "people/" + desired + "'>" + desired + "</a>";
var replacestr = desired;
//var link = "<a href='"+baseurl+"people/"+result[i]+"'>"+result[i]+"</a>";
//var replacestr = result[i];
txt1val = txt1val.replace(replacestr, link);
}
//txt1val = txt1val.replace(replacestr,link);
}
var hashPattern = /#([\S]*?)(?=\s)/g; ///@([\S]*?)(?=\s)/g;
var hashComment = txt1val;
var hashtags = '';
if (hashComment.match(hashPattern)) {
	var result = hashComment.match(hashPattern);
//console.log(result);
for (var i = 0; i < result.length; i++) {
	if (result[i].length > 1) {
		result[i] = result[i].substring(1, result[i].length);
		var desired = result[i].replace(/[^a-zA-Z0-9_-]/g, '');
	}
//if ($.inArray('desired', hashtag['newtags0']) > -1){
	if (hashtags == '') {
		hashtags += desired;
	} else {
		hashtags += ',' + desired;
	}
	var link = "<span class='cmt-tag' style='display:inline-block;'><span class='hashatcolor'>#</span><a href='" + baseurl + "hashtag/" + desired + "'>" + desired + "</a></span>";
	var replacestr = '#' + desired;
	hashComment = hashComment.replace(replacestr, link);
}
txt1val = hashComment;
//console.log('Hastags used: '+hashtags);
//console.log(hashComment);return;
//commentsss = commentss.replace(replacestr,link);
}
$.ajax({
	type: "POST",
	url: baseurl + 'editcommentsave',
	data: {
		"cmtid": id,
		"cmntval": txt1val
	},
	beforeSend: function () {
		$(".btn-savecmd").attr("disabled", "disabled");
	},
	success: function (datas) {
		$("#edit-comment-modal").modal('hide');
		$("#oritextvalafedit" + id).css('display', 'inline');
		$("#oritext" + id).css('display', 'none');
		$("#txt1" + id).css('display', 'none');
		$("#txt1val" + id).val(datas);
		$("#comment-button" + id).css('display', 'none');
		var cmtval = '<div class="margin-top10 comment-txt" id="oritext' + id + '">' + datas + '</p>';
		$("#oritextvalafedit" + id).append(cmtval);
		$('#oritext' + id).remove();
		$(".btn-savecmd").removeAttr("disabled");
		var edithide = ".delecmt_" + id + " .c-reply";
		$(edithide).show();
	},
	dataType: 'html'
});
}
}
function deletecmnt(id) {
	baseurl = getBaseURL();
	var eleid = ".delecmt_" + id;
	var itemid = $('#itemid').val();
//alert(eleid);
if (id != '') {
	$.post(baseurl + 'deletecomments', {
		"addid": id,
		"itemid": itemid
	},
	function (datas) {
		$(eleid).remove();
		return false;
	}
	);
}
}
//Find People search
function searchvalchk() {
	searchval = $("#sval").val();
	if ($.trim(searchval) == "") {
		$("#sererr").show();
		setTimeout(function () {
			$('#sererr').fadeOut('slow');
		}, 5000);
		return false;
	}
}
//Find People follow
function getpeoplefollows(usrid) {
	var Baseurl = getBaseURL();
	var logid = $("#loguserid").val();
	if (logid == 0) {
//alert("Please Login");
window.location = Baseurl + "login";
return false;
} else {
	$("#follow_" + usrid).replaceWith('<div class="btn user_unfollowers" id="follow_' + usrid + '" onclick="deletepeoplefollows(' + usrid + ')"><a class="trn">UnFollow</a></div>');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
	$.post(Baseurl + 'addflw_usrs', {
		"usrid": usrid
	},
	function (datas) {
		return false;
	});
}
}
//Find People unfollow
function deletepeoplefollows(usrid) {
	var Baseurl = getBaseURL();
	$("#follow_" + usrid).replaceWith('<div class="btn user_followers_butn" id="follow_' + usrid + '" onclick="getpeoplefollows(' + usrid + ')"><a class="trn">Follow</a></div>');
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	translator.lang(sessionlang);
	$.post(Baseurl + 'delerteflw_usrs', {
		"usrid": usrid
	},
	function (datas) {
		return false;
	});
}
/** Create Gift card page **/
function giftcardchk() {
	var giftval = $('#gift_amount').val();
	var recipName = $('#gift_recipient').val();
	var message = $('#gift_message').val();
	var check = 0;
	if ($.trim(giftval) == '') {
		$('#gifterr').show();
		$("#gift-value").change(function () {
			$('#gifterr').hide();
		});
		check = 1;
	}
	if ($.trim(recipName) == '') {
		$('#recipNameErr').show();
		$('#recipName').val("");
		$("#recipName").keydown(function () {
			$('#recipNameErr').hide();
		});
		check = 1;
	}
/*if(!(isValidEmail(recipName))){
$('#recipNameErr').hide();
$('#recipNameErrv').show();
$("#recipName").keydown(function(){
$('#recipNameErrv').hide();
});
check = 1;
}*/
if ($.trim(message) == '') {
	$('#messageErr').show();
	$('#message').val("");
	$("#message").keydown(function () {
		$('#messageErr').hide();
	});
	check = 1;
}
if (check == 1) {
	$("#alert").html("Please fill all details");
	return false;
}
return true;
}
/* APPLY COUNPON IN CART */
function checksellercoupon(itemId, count, userId, shopId) {
	var coupon_value = $('#couponcode').val();
	var cartshipping = $("#address-cart").val();
	if (coupon_value == '' || coupon_value == '0') {
		$('.coupon_error').show();
		$('#couponcode').val('');
		$('#couponcode').focus();
		setTimeout(function () {
			$('.coupon_error').fadeOut();
		}, 3000);
		return false;
	} else {
		var baseurlforcoupon = getBaseURL() + "updatecart";
		var baseurl = getBaseURL() + 'checksellercouponcode?coupon_value=' + coupon_value;
		if (couajax == 0) {
			couajax = 1;
			$.ajax({
				url: baseurl,
				type: "POST",
				dataType: "html",
				data: {
					'userid': userId,
					'shopid': shopId,
					'itemuserid': count,
					'itemid': itemId
				},
				success: function (responce) {
					if (responce == 0) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsnotvalid').show();
						setTimeout(function () {
							$('.couponsnotvalid').fadeOut();
						}, 3000);
					}
					if (responce == 1) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsExpired').show();
						setTimeout(function () {
							$('.couponsExpired').fadeOut();
						}, 3000);
					}
					if (responce == 3) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsntvalidsmer').show();
						setTimeout(function () {
							$('.couponsntvalidsmer').fadeOut();
						}, 3000);
					}
					if (responce == 5) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsntvalidsmer').show();
						setTimeout(function () {
							$('.couponsntvalidsmer').fadeOut();
						}, 3000);
					}
					var splitt = responce.split(" ");
					if (splitt[0] == 2 || splitt[0] == 4 || splitt[0] == 6) {
						$('#coupon_idhide').val(splitt[1]);
						$.ajax({
							url: baseurlforcoupon,
							type: "post",
							data: {
								coupon_id: splitt[1],
								shippingid: cartshipping
							},
							success: function (responce) {
								$('#shopcart').html(responce);
							}
						});
					}
					couajax = 0;
				}
			});
		}
	}
}
/* APPLY COUNPON IN COD */
function checksellercouponcod(itemId, count, userId, shopId) {
	var coupon_value = $('#couponcode').val();
	var cartshipping = $("#address-cart").val();
	var qnty = parseInt($('#buynowqty').html());
	if (coupon_value == '' || coupon_value == '0') {
		$('.coupon_error').show();
		$('#couponcode').val('');
		$('#couponcode').focus();
		setTimeout(function () {
			$('.coupon_error').fadeOut();
		}, 3000);
		return false;
	} else {
		var baseurlforcoupon = getBaseURL() + "updatecartcod";
		var baseurl = getBaseURL() + 'checksellercouponcode?coupon_value=' + coupon_value;
		if (couajax == 0) {
			couajax = 1;
			$.ajax({
				url: baseurl,
				type: "POST",
				dataType: "html",
				data: {
					'userid': userId,
					'shopid': shopId,
					'itemuserid': count,
					'itemid': itemId
				},
				success: function (responce) {
					if (responce == 0) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsnotvalid').show();
						setTimeout(function () {
							$('.couponsnotvalid').fadeOut();
						}, 3000);
					}
					if (responce == 1) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsExpired').show();
						setTimeout(function () {
							$('.couponsExpired').fadeOut();
						}, 3000);
					}
					if (responce == 3) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsntvalidsmer').show();
						setTimeout(function () {
							$('.couponsntvalidsmer').fadeOut();
						}, 3000);
					}
					if (responce == 5) {
						$('#couponcode').val('');
						$('#couponcode').focus();
						$('.couponsntvalidsmer').show();
						setTimeout(function () {
							$('.couponsntvalidsmer').fadeOut();
						}, 3000);
					}
					var splitt = responce.split(" ");
					if (splitt[0] == 2 || splitt[0] == 4 || splitt[0] == 6) {
						$('#coupon_idhide').val(splitt[1]);
						$.ajax({
							url: baseurlforcoupon,
							type: "post",
							data: {
								coupon_id: splitt[1],
								shippingid: cartshipping,
								'qnty': qnty
							},
							success: function (responce) {
								$('#shopcart').html(responce);
							}
						});
					}
					couajax = 0;
				}
			});
		}
	}
}
/** CHANGE QUANTITY IN CART **/
function selectChange(itemId, userId, shopId, id, size, maxqty, action) {
	var baseurl = getBaseURL();
	var cartshipping = $("#address-cart").val();
	var qntyid = '.qnty' + itemId;
	var qntyerror = '.quantity_error' + itemId;
	var qnty = parseInt($(qntyid).html());
	var newqnty = parseInt(qnty) + 1;
	if (action == 'sub') {
		newqnty = parseInt(qnty) - 1;
	}
	var maxqty = parseInt(maxqty);
	var unitprice_value = '.unitprice' + itemId;
	var unitprice = $(unitprice_value).val();
	var couponnId = $('#coupon_idhide').val();
	if (couponnId != '') {
		couponId = couponnId;
	} else {
		couponId = '';
	}
	var giftId = $('#giftcard_idhide').val();
	if (giftId != '') {
		giftId = giftId;
	} else {
		giftId = '';
	}
	var creditamt = $('#availablee_creditsamt').val();
	if (creditamt != '') {
		creditamt = creditamt;
	} else {
		creditamt = '';
	}
	if (isNaN(newqnty) || newqnty == '0') {
		return false;
	} else if (newqnty > maxqty) {
		$(qntyerror).fadeIn();
		setTimeout(function () {
			$(qntyerror).fadeOut();
		}, 2000);
	} else {
		if (action == 'sub') {
			qnty = parseInt(qnty) - 1;
		} else {
			qnty = parseInt(qnty) + 1;
		}
		$.ajax({
			url: baseurl + "deletecartitem",
			type: "post",
			dataType: "html",
			data: {
				'itemId': itemId,
				'userId': userId,
				'shopId': shopId,
				'qnty': qnty,
				'coupon_id': couponId,
				'size': size,
				'unitprice': unitprice,
				shippingid: cartshipping,
				'giftcard_id': giftId,
				'creditamt': creditamt
			},
			success: function (responce) {
				$('#shopcart').html(responce);
				$(qntyid).html(qnty);
			}
		});
	}
}
/** CHANGE QUANTITY IN COD **/
function selectChangecod(itemId, userId, shopId, id, size, maxqty, action) {
	var baseurl = getBaseURL();
	var cartshipping = $("#address-cart").val();
	var qntyid = '.qnty' + itemId;
	var qntyerror = '.quantity_error' + itemId;
	var qnty = parseInt($(qntyid).html());
	var newqnty = parseInt(qnty) + 1;
	if (action == 'sub') {
		newqnty = parseInt(qnty) - 1;
	}
	var maxqty = parseInt(maxqty);
	var unitprice_value = '.unitprice' + itemId;
	var unitprice = $(unitprice_value).val();
	var couponnId = $('#coupon_idhide').val();
	if (couponnId != '') {
		couponId = couponnId;
	} else {
		couponId = '';
	}
	var giftId = $('#giftcard_idhide').val();
	if (giftId != '') {
		giftId = giftId;
	} else {
		giftId = '';
	}
	var creditamt = $('#availablee_creditsamt').val();
	if (creditamt != '') {
		creditamt = creditamt;
	} else {
		creditamt = '';
	}
	if (isNaN(newqnty) || newqnty == '0') {
		return false;
	} else if (newqnty > maxqty) {
		$(qntyerror).fadeIn();
		setTimeout(function () {
			$(qntyerror).fadeOut();
		}, 2000);
	} else {
		if (action == 'sub') {
			qnty = parseInt(qnty) - 1;
		} else {
			qnty = parseInt(qnty) + 1;
		}
		$.ajax({
			url: baseurl + "updatecartcod",
			type: "post",
			dataType: "html",
			data: {
				'itemId': itemId,
				'userId': userId,
				'shopId': shopId,
				'qnty': qnty,
				'coupon_id': couponId,
				'size': size,
				'unitprice': unitprice,
				shippingid: cartshipping,
				'giftcard_id': giftId,
				'creditamt': creditamt
			},
			success: function (responce) {
				$('#shopcart').html(responce);
				$(qntyid).html(qnty);
			}
		});
	}
}
/* REMOVE ITEM IN CART */
function removecart(itemId, userId, shopId, id) {
	var baseurl = getBaseURL();
	var couponId = '';
	var giftId = '';
	var creditamt = 0;
	var cartshipping = $("#address-cart").val();
	var x = window.confirm("Are you sure to remove the item?");
	if (x) {
		var eleid = "#shop";
		var qnty = 0;
		/* COUPONS */
		var couponnId = $('#coupon_idhide').val();
		if (couponnId != '') {
			couponId = couponnId;
		}
		/* GIFTCARD */
		var giftId = $('#giftcard_idhide').val();
		if (giftId != '') {
			giftId = giftId;
		}
		/* CREDIT AMOUNT */
		var creditamt = $('#availablee_creditsamt').val();
		if (creditamt != '') {
			creditamt = creditamt;
		}
		$.ajax({
			url: baseurl + "deletecartitem",
			type: "post",
			data: {
				'itemId': itemId,
				'userId': userId,
				'shopId': shopId,
				'qnty': qnty,
				shippingid: cartshipping,
				'coupon_id': couponId,
				'giftcard_id': giftId,
				'creditamt': creditamt
			},
			dataType: "html",
			success: function (responce) {
/*if(responce!=0)
{
$('#shopcart').html(responce);
$('.deleteCart').show();
setTimeout(function(){$('.deleteCart').fadeOut();}, 2000);
return false;
}
else
{
window.location.reload();
}*/
window.location.reload();
}
});
	} else {
		return false;
	}
}
//Check giftcard validity
function Checkgiftcard() {
	var cartshipping = $("#address-cart").val();
	var giftcard_value = $('#giftcode').val().trim();
	if (giftcard_value == '' || giftcard_value == '0') {
		$('#giftcodesemp').show();
		$('#giftcode').val('');
		$('#giftcode').focus();
		setTimeout(function () {
			$('#giftcodesemp').fadeOut();
		}, 3000);
		return false;
	} else {
		var baseurl = getBaseURL() + 'checkgiftcardcode?gfcode_value=' + giftcard_value;
		var baseurlforgiftcard = getBaseURL() + "updatecart";
		if (couajax == 0) {
			couajax = 1;
			$.ajax({
				url: baseurl,
				type: "get",
				dataType: "html",
				success: function (responce) {
					if (responce == 0) {
						$('#giftcode').val('');
						$('#giftcode').focus();
						$('#giftcodesnotvalid').show();
						setTimeout(function () {
							$('#giftcodesnotvalid').fadeOut();
						}, 3000);
					} else if (responce == 2) {
						$('#giftcode').val('');
						$('#giftcode').focus();
						$("#giftcodesemp").show();
						setTimeout(function () {
							$('#giftcodesemp').fadeOut();
						}, 3000);
					} else {
						var vv = responce;
						var splitt = vv.split('*|*');
						if (splitt[0] == 1) {
							$('#giftcard_idhide').val(splitt[1]);
							$.ajax({
								url: baseurlforgiftcard,
								type: "post",
								data: {
									giftcard_id: splitt[1],
									shippingid: cartshipping
								},
								success: function (responce) {
									$('#shopcart').html(responce);
								}
							});
						}
					}
					couajax = 0;
				}
			});
		}
	}
}
/** CHECK GIFTCARD VALID OR NOT */
function Checkgiftcardcod() {
	var cartshipping = $("#address-cart").val();
	var giftcard_value = $('#giftcode').val().trim();
	var qnty = parseInt($("#buynowqty").html());
	if (giftcard_value == '' || giftcard_value == '0') {
		$('#giftcodesemp').show();
		$('#giftcode').val('');
		$('#giftcode').focus();
		setTimeout(function () {
			$('#giftcodesemp').fadeOut();
		}, 3000);
		return false;
	} else {
		var baseurl = getBaseURL() + 'checkgiftcardcode?gfcode_value=' + giftcard_value;
		var baseurlforgiftcard = getBaseURL() + "updatecartcod";
		if (couajax == 0) {
			couajax = 1;
			$.ajax({
				url: baseurl,
				type: "get",
				dataType: "html",
				success: function (responce) {
					if (responce == 0) {
						$('#giftcode').val('');
						$('#giftcode').focus();
						$('#giftcodesnotvalid').show();
						setTimeout(function () {
							$('#giftcodesnotvalid').fadeOut();
						}, 3000);
					} else if (responce == 2) {
						$('#giftcode').val('');
						$('#giftcode').focus();
						$("#giftcodesemp").show();
						setTimeout(function () {
							$('#giftcodesemp').fadeOut();
						}, 3000);
					} else {
						var vv = responce;
						var splitt = vv.split('*|*');
						if (splitt[0] == 1) {
							$('#giftcard_idhide').val(splitt[1]);
							$.ajax({
								url: baseurlforgiftcard,
								type: "post",
								data: {
									giftcard_id: splitt[1],
									shippingid: cartshipping,
									qnty: qnty
								},
								success: function (responce) {
									$('#shopcart').html(responce);
								}
							});
						}
					}
					couajax = 0;
				}
			});
		}
	}
}
/** ADD TO CART **/
function cart_show() {
	var baseurl = getBaseURL();
	$('.size_error').hide();
	$('.qty_error').hide();
	var logid = $("#loggeduserid").val();
	var sizeavail = $("#sizeavail").val();
	if (logid == 0) {
		window.location = baseurl + "login";
		return false;
	} else {
		Baseurl = getBaseURL();
		quantity = $('#qty-counter').val();
		listing_id = $('#listing_id').val();
		size_opt = $('#size_opt').val();
		if ((size_opt == "" || size_opt == null) && (sizeavail == '1')) {
			$('#size_opt').focus();
			$('.size_error').show();
			return false;
		}
		if ((quantity == "" || quantity == null) && (sizeavail == '1')) {
			$('#qty-counter').focus();
			$('.qty_error').show();
			return false;
		}
		if ((quantity == "" || quantity == null) && (sizeavail == '0')) {
			$('#qty-counter').focus();
			$('.qty_error').show();
			return false;
		}
		itemuserid = $('#itemuserid').val();
		shipping_method_id = $('#shipping_method_id').val();
		$.ajax({
			url: Baseurl + "pays/",
			type: "post",
			data: {
				'quantity': quantity,
				'listing_id': listing_id,
				'size_opt': size_opt,
				'itemuserid': itemuserid,
				'shipping_method_id': shipping_method_id
			},
			dataType: "html",
			success: function (responce) {
				if (responce == 1) {
					window.location = Baseurl + "cart/";
				} else {
					window.location = Baseurl;
				}
			},
		});
	}
}
/* BUYNOW PRODUCT */
function buynow_show() {
	Baseurl = getBaseURL();
	$('.size_error').hide();
	$('.qty_error').hide();
	var logid = $("#loggeduserid").val();
	var sizeavail = $("#sizeavail").val();
	if (logid == 0) {
		window.location = baseurl + "login";
		return false;
	} else {
		var quantity = $('#qty-counter').val();
		var size_opt = $('#size_opt').val();
		var itemid = $('#itm_id').val();
		if ((size_opt == "" || size_opt == null) && (sizeavail == '1')) {
			$('#size_opt').focus();
			$('.size_error').show();
			return false;
		}
		if ((quantity == "" || quantity == null) && (sizeavail == '1')) {
			$('#qty-counter').focus();
			$('.qty_error').show();
			return false;
		}
		if ((quantity == "" || quantity == null) && (sizeavail == '0')) {
			$('#qty-counter').focus();
			$('.qty_error').show();
			return false;
		}
		$.ajax({
			dataType: "html",
			type: "POST",
			evalScripts: true,
			url: Baseurl + "paycod/",
			data: {
				'itm_qty': quantity,
				'itm_size': size_opt,
				'itm_id': itemid
			},
			success: function (responce) {
				window.location.href = Baseurl + "cod/" + responce;
				return false;
			}
		});
		return true;
	}
}
function creategroupgift() {
	$('.size_error').hide();
	$('.qty_error').hide();
	var logid = $("#loggeduserid").val();
	var sizeavail = $("#sizeavail").val();
	if (logid == 0) {
		window.location = baseurl + "login";
		return false;
	} else {
		Baseurl = getBaseURL();
		var size = $('#size_opt').val();
		var qty = $('#qty-counter').val();
		if ((size == "" || size == null) && (sizeavail == '1')) {
			$('#size_opt').focus();
			$('.size_error').show();
			return false;
		}
		if ((qty == "" || qty == null) && (sizeavail == '1')) {
			$('#qty-counter').focus();
			$('.qty_error').show();
			return false;
		}
		if ((qty == "" || qty == null) && (sizeavail == '0')) {
			$('#qty-counter').focus();
			$('.qty_error').show();
			return false;
		}
		Baseurl = getBaseURL();
		var itemid = $('#itm_id').val();
		var ggurl = btoa(itemid + '-_-' + size + '-_-' + qty);
		window.location = Baseurl + 'create_group_gift/' + ggurl;
	}
}
/** AUTOCOMPLETE USERNAMES **/
function autocompleteusername() {
	var Baseurl = getBaseURL();
	var searchString = $('#gift_recipient').val();
	if (searchString != "" || searchString != null) {
		$.ajax({
			url: Baseurl + "autocompleteusernames/",
			type: "post",
			data: {
				'searchStr': searchString
			},
			dataType: "html",
			success: function (responce) {
				var parsedJson = $.parseJSON(responce);
				$("#gift_recipient").autocomplete({
					source: parsedJson
				}).autocomplete("widget").addClass("dropdown-menu padding-bottom0 padding-top0 addposition").data("ui-autocomplete")._renderItem = function (ul, item) {
					return $("<li></li>")
					.data("item.autocomplete", item)
					.append("<a>" + item.label + "</a>")
					.appendTo(ul);
				};;
			},
		});
	}
}
/** CHANGE DEFAULT LANGUAGE  **/
$(document).ready(function () {
	$('ul.lang-dd li').click(function (e) {
		var lang = $(this).text().trim();
		var language = $(".selectlang" + lang).val();
		Baseurl = getBaseURL();
		$.ajax({
			url: Baseurl + "setlanguage/",
			type: "post",
			data: {
				'language': language
			},
			dataType: "html",
			success: function (responce) {
				//console.log(responce);
				$("#languagecode").val(responce);
				window.location.reload();
			},
		});
	});
	$('ul.langdd li').click(function (e) {
		var lang = $(this).text().trim();
		Baseurl = getBaseURL();
		$.ajax({
			url: Baseurl + "setlanguage/",
			type: "post",
			data: {
				'language': lang
			},
			dataType: "html",
			success: function (responce) {
				$("#languagecode").val(responce);
				window.location.reload();
			},
		});
	});
});
//Notifications Follow
function notificationsfollow(usrid, listid) {
	var baseurl = getBaseURL();
	var hidetag = ".list" + listid;
//var buttontag = "#follow_btn"+usrid;
var logid = $("#gstid").val();
if (logid == 0) {
	window.location = baseurl + "login";
	return false;
} else {
	var followlist = $("#followuserlist").val();
	$.ajax({
		url: baseurl + 'addflwUsrs',
		type: 'POST',
		data: {
			"usrid": usrid,
			"followlist": followlist,
			"listid": listid
		},
		dataType: "json",
		beforeSend: function () {
//$(buttontag).attr('disabled','disabled');
},
success: function (responce) {
//$(hidetag).fadeOut('slow');
var check = responce.toString();
if (check != "false") {
	var out = eval(responce);
	followlist += ',' + out[1];
	$("#followuserlist").val(followlist);
//hidetag = ".whouser"+out[1];
setTimeout(function () {
	$(hidetag).html(out[0]);
	$(hidetag).fadeIn('slow');
}, 500);
} else {
	var el = $('.whouser' + usrid).filter(function () {
		return $(this).css('display') == 'none';
	});
	var hiddenli = el.length;
	if (hiddenli == 4) {
		$('.hashtagwhofollow-content').html(
			"<div class='whotofollowerror trn' style='display:none;'>" +
			"No more suggestions</div>");
		var sessionlang = $("#languagecode").val();
		var translator = $('body').translate({
			t: dict
		});
		translator.lang(sessionlang);
		setTimeout(function () {
			$('.whotofollowerror').fadeIn('slow');
		}, 500);
	}
}
}
});
}
}
function share_post(id) {
	var BaseURL = getBaseURL();
//alert(id);
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
} else {
	$("#share-modal").modal('show');
}
var title = $('#figcaption_titles' + id).attr("figcaption_title");
var title_url = $('#figcaption_title_url' + id).html();
$("#figcaption_title_popup").text(title);
var username_p = $('#price_vals' + id).attr("price_val");
$("#username_popup").text(username_p);
var usernames = $('#user_n' + id).attr("usernameval");
$("#usernames_popup").text(usernames);
var fav_counts = $('#fav_count' + id).attr("fav_counts");
$("#fav_countsvv").text(fav_counts);
var itemurl = btoa(id + "_" + Math.random(1, 9999));
var urlss = BaseURL + 'listing/' + itemurl;
//	var shareImg =  $("#img_"+id).attr('src');
var shareImg = $("#img_" + id).html();
//alert(urlss);
$("#share_img").attr("src", shareImg);
$("#share_title").html(title);
$("#share_username").html(usernames);
$("#share_price").html(username_p);
encry_urlss = encodeURIComponent(urlss);
encry_title = encodeURIComponent(title);
encry_image = encodeURIComponent(shareImg);
//alert(encry_urlss);
$('#metaurl').attr('content', urlss);
$('#metaimage').attr('content', shareImg);
$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?u=' + encry_image + '&t=' + encry_title);
//$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?s=100&p[title]='+encry_title+'&p[url]='+encry_urlss+'&p[images][0]='+encry_image);
//$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?u='+encry_urlss+'&t='+encry_title);
//$('.facebook').attr('href', urlss);
$('.twitter').attr('href', 'http://twitter.com/?status=' + encry_urlss);
$('.google').attr('href', 'http://plus.google.com/share?url=' + encry_urlss);
$('.linkedin').attr('href', 'http://www.linkedin.com/cws/share?url=' + encry_urlss + '&title=' + encry_title);
$('.stumbleupon').attr('href', 'http://www.stumbleupon.com/submit?url=' + encry_urlss + '&title=' + encry_title);
$('.tumblr').attr('href', 'http://www.tumblr.com/share/link?url=' + encry_urlss + '&name=' + encry_title);
}
//CHANGE QUANTITY AND SIZES
function itemlistingloadqty(id) {
	$baseurl = getBaseURL();
	$('.size_error').hide();
	$('.qty_error').hide();
	var size = $('#size_opt').val();
	if (size != "" && size != null) {
		$.ajax({
			url: $baseurl + "getsizeqty",
			type: "post",
			dataType: "html",
			data: {
				'id': id,
				'size': size
			},
			beforeSend: function () {
				$('.sizeqtyloader').show();
			},
			success: function (responce) {
				var out = eval(responce);
//QUANTITY DROPDOWN
//alert(out[1]);
$('.sizeqtyloader').hide();
$('#qty-counter').html(out[0]);
$('.sizeqtydiv .out').html('1');
$('.sizeqtydiv').show();
//PRICE CHANGES
if (out[4] == "deal") {
	$('.price-strike').html(out[1]);
	$('.deal-price').html(out[3]);
} else {
	$('.prod-cost').html(out[1]);
}
}
});
	}
}
function share_posts(id) {
	var BaseURL = getBaseURL();
//alert(id);
var loguserid = $("#loguserid").val();
if (loguserid == 0) {
	window.location.href = BaseURL + "login";
	return false;
}
var title = $('#figcaption_titles' + id).attr("figcaption_title");
var title_url = $('#figcaption_title_url' + id).html();
$("#figcaption_title_popup").text(title);
var username_p = $('#price_vals' + id).attr("price_val");
$("#username_popup").text(username_p);
var usernames = $('#user_n' + id).attr("usernameval");
$("#usernames_popup").text(usernames);
var fav_counts = $('#fav_count' + id).attr("fav_counts");
$("#fav_countsvv").text(fav_counts);
var itemurl = btoa(id + "_" + Math.random(1, 9999));
var urlss = BaseURL + 'listing/' + itemurl;
var shareImg = $("#img_" + id).html();
$("#share_img").attr("src", shareImg);
$("#share_title").html(title);
$("#share_username").html(usernames);
$("#share_price").html(username_p);
//alert(urlss);
encry_urlss = encodeURIComponent(urlss);
encry_title = encodeURIComponent(title);
encry_image = encodeURIComponent(shareImg);
var appID = $("#default_fb_appid").val();
//alert(encry_urlss);
$('#metaurl').attr('content', urlss);
$('#metaimage').attr('content', shareImg);
//console.log('http://www.facebook.com/sharer.php?url=' + encry_urlss + '&t=' + encry_title);
$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?u=' + encry_urlss + '&t=' + encry_title);
//$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?s=100&p[title]='+encry_title+'&p[url]='+encry_urlss+'&p[images][0]='+encry_image);
//$('.facebook').attr('href', 'http://www.facebook.com/sharer.php?u='+encry_urlss+'&t='+encry_title);
//$('.facebook').attr('href', urlss);
$('.twitter').attr('href', 'http://twitter.com/?status=' + encry_urlss);
$('.google').attr('href', 'http://plus.google.com/share?url=' + encry_urlss);
$('.linkedin').attr('href', 'http://www.linkedin.com/cws/share?url=' + encry_urlss + '&title=' + encry_title);
$('.stumbleupon').attr('href', 'http://www.stumbleupon.com/submit?url=' + encry_urlss + '&title=' + encry_title);
$('.tumblr').attr('href', 'http://www.tumblr.com/share/link?url=' + encry_urlss + '&name=' + encry_title);
}
function helpcontact() {
	var check = 0;
	var sessionlang = $("#languagecode").val();
	var translator = $('body').translate({
		t: dict
	});
	if ($('#contact_name').val() == '') {
		$('#nameerr').html("Please Enter the Name");
		translator.lang(sessionlang);
		$('#nameerr').show();
		$('#contact_name').keydown(function () {
			$('#nameerr').hide();
		});
		check = 1;
	}
	if ($('#contact_email').val() == '') {
		$('#emailerr').html("Please Enter the Email");
		translator.lang(sessionlang);
		$('#emailerr').show();
		$('#contact_email').keydown(function () {
			$('#emailerr').hide();
		});
		check = 1;
	}
	if (!isValidEmail($('#contact_email').val())) {
		$('#emailerr').html("Please Enter Valid Email");
		translator.lang(sessionlang);
		$('#emailerr').show();
		$('#contact_email').keydown(function () {
			$('#emailerr').hide();
		});
		check = 1;
	}
	if ($('.order').val() != '' && $('.order').val().length < 8) {
		$('#ordererr').html("Please Enter 8 digit order no.");
		translator.lang(sessionlang);
		$('#ordererr').show();
		$('.order').keydown(function () {
			$('#ordererr').hide();
		});
		check = 1;
	}
	if ($('.user').val() == '') {
		$('#usererr').html("Please Enter the Username");
		translator.lang(sessionlang);
		$('#usererr').show();
		$('.user').keydown(function () {
			$('#usererr').hide();
		});
		check = 1;
	}
	if ($('.description').val() == '') {
		$('#descriptionerr').html("Please Enter the Description");
		translator.lang(sessionlang);
		$('#descriptionerr').show();
		$('.description').keydown(function () {
			$('#descriptionerr').hide();
		});
		check = 1;
	}
	if (check == 1) {
		$(".contact-error").html("Please fill all details");
		translator.lang(sessionlang);
		$(".contact-error").show();
		return false;
	}
	return true;
}
function removeusrimg(val) {
	var baseurl = getBaseURL();
	$('#image_computer').val('');
	$('#show_url').attr({
		src: baseurl + 'media/avatars/thumb70/usrimg.jpg'
	});
	$('#removeimg').hide();
}
/* QUANTITY & SIZE CHANGE*/
$(document).on('change', '#qty-counter', function (e) {
	$('.size_error').hide();
	$('.qty_error').hide();
});
/** CHANGE ADDRESS IN CART **/
function cartshipping() {
	var cartshipping = $("#address-cart").val();
	var couponnId = $('#coupon_idhide').val();
	if (couponnId != '') {
		couponnId = couponnId;
	} else {
		couponnId = '';
	}
	var giftId = $('#giftcard_idhide').val();
	if (giftId != '') {
		giftId = giftId;
	} else {
		giftId = '';
	}
	var creditamt = $('#availablee_creditsamt').val();
	if (creditamt != '') {
		creditamt = creditamt;
	} else {
		creditamt = '';
	}
	$.ajax({
		url: getBaseURL() + "updatecart",
		type: "post",
		data: {
			shippingid: cartshipping,
			coupon_id: couponnId,
			'giftcard_id': giftId,
			'creditamt': creditamt
		},
		success: function (responce) {
			$("#shopcart").html(responce);
		}
	});
}
/** CHANGE ADDRESS IN COD **/
function cartshippingcod() {
	var cartshipping = $("#address-cart").val();
	var couponnId = $('#coupon_idhide').val();
	var qnty = parseInt($('#buynowqty').html());
	if (couponnId != '') {
		couponnId = couponnId;
	} else {
		couponnId = '';
	}
	var giftId = $('#giftcard_idhide').val();
	if (giftId != '') {
		giftId = giftId;
	} else {
		giftId = '';
	}
	var creditamt = $('#availablee_creditsamt').val();
	if (creditamt != '') {
		creditamt = creditamt;
	} else {
		creditamt = '';
	}
	$.ajax({
		url: getBaseURL() + "updatecartcod",
		type: "post",
		data: {
			shippingid: cartshipping,
			coupon_id: couponnId,
			'giftcard_id': giftId,
			'qnty': qnty,
			'creditamt': creditamt
		},
		success: function (responce) {
			$("#shopcart").html(responce);
		}
	});
}
/** REMOVE COUPON && GIFTCARD **/
function removeoffers() {
	var cartshipping = $("#address-cart").val();
	var couponnId = '';
	var giftId = '';
	var creditamt = '';
	$.ajax({
		url: getBaseURL() + "updatecart",
		type: "post",
		data: {
			shippingid: cartshipping,
			coupon_id: couponnId,
			'giftcard_id': giftId,
			'creditamt': creditamt
		},
		success: function (responce) {
			$("#shopcart").html(responce);
		}
	});
}
function removecodoffers() {
	var cartshipping = $("#address-cart").val();
	var couponnId = $('#coupon_idhide').val();
	var qnty = parseInt($('#buynowqty').html());
	var couponnId = '';
	var giftId = '';
	var creditamt = '';
	$.ajax({
		url: getBaseURL() + "updatecartcod",
		type: "post",
		data: {
			shippingid: cartshipping,
			coupon_id: couponnId,
			'giftcard_id': giftId,
			'qnty': qnty,
			'creditamt': creditamt
		},
		success: function (responce) {
			$("#shopcart").html(responce);
		}
	});
}
function cancelsubform() {
	$("#cancelform").submit();
	return true;
}
function resolvesubform() {
	$("#resolveform").submit();
	return true;
}
function make_cod_order() {
	baseurl = getBaseURL();
	var shipping_addre = $("#shipping_addre").val();
	var shippingid = $('#address-cart').val();
	var currency = $('#currencode').val();
	var currentTime = $('#currentTime').val();
	var captcha = $("#securitycode").val();
	var giftcardAmount = $("#giftcardAmount").val();
	var totalamount = $("#totalamount").val();
	if (shipping_addre == 0) {
		$("#shiperr").show();
		$("#shiperr").html("Please add the shipping address");
		setTimeout(function () {
			$('#shiperr').fadeOut('slow');
		}, 5000);
		return false;
	}
	$.ajax({
		url: baseurl + "codcartcheckout/",
		type: "post",
		data: $('#paymentbraintreeform').serialize() + '&shippingId=' + shippingid + '&currency=' + currency + '&currentTime=' + currentTime + '&captcha=' + captcha + '&giftcardAmount=' + giftcardAmount + '&totalamount=' + totalamount,
		dataType: "html",
		beforeSend: function () {
			$("#codload").show();
			if (captcha != '') {
				$(".codconfirm").attr('disabled', 'disabled');
			}
		},
		success: function (responce) {
			//console.log(responce);return false;
			$("#codload").hide();
			if ($.trim(responce) != 'error') {
				window.location.href = baseurl + "/payment-successful/";
			} else {
				$(".codconfirm").removeAttr('disabled');
				$("#captcherr").show();
				setTimeout(function () {
					$('#captcherr').fadeOut();
				}, 5000);
			}
		}
	});
}
function make_cod_buynoworder() {
	var qnty = parseInt($('#buynowqty').html());
	$('#buynow_qty').val(qnty);
	var size = $('#buynowsize').html();
	$('#buynow_size').val(size);
	baseurl = getBaseURL();
	var shipping_addre = $("#shipping_addre").val();
	var shippingid = $('#address-cart').val();
	var currency = $('#currencode').val();
	var currentTime = $('#currentTime').val();
	var captcha = $("#securitycode").val();
	var giftcardAmount = $("#giftcardAmount").val();
	var totalamount = $("#totalamount").val();
	var buynow = 1;
	if (shipping_addre == 0) {
		$("#shiperror").show();
		$("#shiperror").html("Please add the shipping address");
		setTimeout(function () {
			$('#shiperr').fadeOut('slow');
		}, 5000);
		return false;
	}
	$.ajax({
		url: baseurl + "codbuynowcheckout/",
		type: "post",
		data: $('#paymentbraintreeform').serialize() + '&shippingId=' + shippingid + '&currency=' + currency + '&currentTime=' + currentTime + '&captcha=' + captcha + '&buynow_qty=' + qnty + '&buynow_size=' + size + '&buynow=' + buynow + '&giftcardAmount=' + giftcardAmount + '&totalamount=' + totalamount,
		dataType: "html",
		beforeSend: function () {
			$("#codload").show();
			if (captcha != '') {
				$(".codconfirm").attr('disabled', 'disabled');
			}
		},
		success: function (responce) {

			$("#codload").hide();
			if ($.trim(responce) != 'error') {
				window.location.href = baseurl + "/payment-successful/";
			} else {
				$(".codconfirm").removeAttr('disabled');
				$("#captcherr").show();
				setTimeout(function () {
					$('#captcherr').fadeOut();
				}, 5000);
			}
		}
	});
}
function checkusercreditamntchek() {
	var userentercreditamt = parseFloat($('#userentercreditamt').val());
	var userbalance = parseFloat($('#available_balance').val());
	var totalamount = parseFloat($('#totalamount').val()) / 100;
	if (isNaN(userentercreditamt)) {
		$('#userentercreditamt').val('');
		$('#userentercreditamt').focus();
		$('#crediterr').fadeIn();
		setTimeout(function () {
			$('#crediterr').fadeOut();
		}, 2000);
		return false;
	} else {
		if (userbalance >= userentercreditamt) {
			if (userentercreditamt > totalamount) {
				$('#totalamtexceed').fadeIn();
				$('#userentercreditamt').val('');
				$('#userentercreditamt').focus();
				setTimeout(function () {
					$('#totalamtexceed').fadeOut();
				}, 2000);
				return false;
			}
			var cartshipping = $("#address-cart").val();
			/* UPDATE CREDIT AMOUNT */
			var creditamt = userentercreditamt;
			if (creditamt != '') {
				creditamt = creditamt;
			} else {
				creditamt = '';
			}
			$.ajax({
				url: getBaseURL() + "updatecart",
				type: "post",
				data: {
					shippingid: cartshipping,
					'creditamt': creditamt
				},
				success: function (responce) {
					$("#shopcart").html(responce);
					$('#availablee_creditsamt').val(creditamt);
				}
			});
		} else {
			$('#creditamtexceed').fadeIn();
			$('#userentercreditamt').val('');
			$('#userentercreditamt').focus();
			setTimeout(function () {
				$('#creditamtexceed').fadeOut();
			}, 2000);
			return false;
		}
	}
}
function checkusercreditamntcod() {
	var userentercreditamt = parseFloat($('#userentercreditamt').val());
	var userbalance = parseFloat($('#available_balance').val());
	var qnty = parseInt($("#buynowqty").html());
	var totalamount = parseFloat($('#totalamount').val()) / 100;
	if (isNaN(userentercreditamt)) {
		$('#userentercreditamt').val('');
		$('#userentercreditamt').focus();
		$('#crediterr').fadeIn();
		setTimeout(function () {
			$('#crediterr').fadeOut();
		}, 2000);
		return false;
	} else {
		if (userbalance >= userentercreditamt) {
			if (userentercreditamt > totalamount) {
				$('#totalamtexceed').fadeIn();
				$('#userentercreditamt').val('');
				$('#userentercreditamt').focus();
				setTimeout(function () {
					$('#totalamtexceed').fadeOut();
				}, 2000);
				return false;
			}
			var cartshipping = $("#address-cart").val();
			/* UPDATE CREDIT AMOUNT */
			var creditamt = userentercreditamt;
			if (creditamt != '') {
				creditamt = creditamt;
			} else {
				creditamt = '';
			}
			$.ajax({
				url: getBaseURL() + "updatecartcod",
				type: "post",
				data: {
					shippingid: cartshipping,
					'creditamt': creditamt,
					'qnty': qnty
				},
				success: function (responce) {
					$("#shopcart").html(responce);
					$('#availablee_creditsamt').val(creditamt);
				}
			});
		} else {
			$('#creditamtexceed').fadeIn();
			$('#userentercreditamt').val('');
			$('#userentercreditamt').focus();
			setTimeout(function () {
				$('#creditamtexceed').fadeOut();
			}, 2000);
			return false;
		}
	}
}
function socialsharef() {
	var short_urls = $("#short_urls").val();
	var meta_image = $("#default_site_logo").val();
	var appID = $("#default_fb_appid").val();
	var title = 'Join with me';
	$('#meta_title').attr('content', title);
	$('#meta_image').attr('content', meta_image);
	encry_urlss = encodeURIComponent(short_urls);
//newwindow=window.open('http://www.facebook.com/sharer.php?s=100&p[title]='+encry_title+'&p[url]='+encry_urlss,'name','height=600,width=600');
//newwindow=window.open('http://www.facebook.com/sharer.php?u='+encry_urlss,'name','height=600,width=600');
newwindow = window.open('https://www.facebook.com/dialog/share?app_id=' + appID + '&display=popup&href=' + encry_urlss, 'name', 'height=600,width=600');
//https://www.facebook.com/dialog/share?app_id=245308646001038&display=popup&href=http%3A%2F%2Ffantacyscript.com%2Fbeta
}
function socialsharetwt() {
	var short_urls = $("#short_urls").val();
	var title = 'Join with me';
	encry_urlss = encodeURIComponent(short_urls);
	encry_title = encodeURIComponent(title);
	newwindow = window.open('http://twitter.com/share?text=' + encry_title + '&url=' + encry_urlss, 'name', 'height=600,width=600');
}
function socialshareg() {
	var short_urls = $("#short_urls").val();
	var title = 'Join with me';
	encry_urlss = encodeURIComponent(short_urls);
	encry_title = encodeURIComponent(title);
	newwindow = window.open('http://plus.google.com/share?url=' + encry_urlss, 'name', 'height=600,width=600');
}
function socialsharel() {
	var short_urls = $("#short_urls").val();
	var title = 'Join with me';
	encry_urlss = encodeURIComponent(short_urls);
	encry_title = encodeURIComponent(title);
	newwindow = window.open('http://www.linkedin.com/cws/share?url=' + encry_urlss + '&title=' + encry_title, 'name', 'height=600,width=600');
}
function socialsharetum() {
	var short_urls = $("#short_urls").val();
	var title = 'Join with me';
	encry_urlss = encodeURIComponent(short_urls);
	encry_title = encodeURIComponent(title);
	newwindow = window.open('http://www.tumblr.com/share/link?url=' + encry_urlss + '&name=' + encry_title, 'name', 'height=600,width=600');
}
$(this).click(function (event) {
	var target = 'feed-search';
	if (event.target.id != target && event.target.id != 'search-query') {
		$('div.feed-search').hide();
	}
});
