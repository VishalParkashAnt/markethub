<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
   // $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
$routes->connect('/',['controller' => 'Users', 'action' => 'index','prefix' => 'users']);
$routes->connect('/users/users/home',['controller' => 'Users', 'action' => 'login', '_ext' => NULL]);
$routes->connect('/login',['controller' => 'Users', 'action' => 'login', '_ext' => NULL]);
$routes->connect('/users/login',['controller' => 'Users', 'action' => 'login', '_ext' => NULL]);

$routes->connect('/phonelogin',['controller' => 'Users', 'action' => 'phonelogin', '_ext' => NULL]);
$routes->connect('/users/phonelogin',['controller' => 'Users', 'action' => 'phonelogin', '_ext' => NULL]);
$routes->connect('/updatephone',['controller' => 'Users', 'action' => 'updatephone', '_ext' => NULL]);
$routes->connect('/users/updatephone',['controller' => 'Users', 'action' => 'updatephone', '_ext' => NULL]);

$routes->connect('/loginwithsocial/*',['controller' => 'Sociallogins', 'action' => 'loginwithfb','prefix' => 'sociallogins']);
//$routes->connect('/socialverify/*',['controller' => 'Auth', 'action' => 'login','plugin' => 'ADmad/SocialAuth']);
$routes->connect('/signup/*',['controller' => 'Users', 'action' => 'signup', '_ext' => NULL]);
//$routes->connect('/signup/*',['controller' => 'Users', 'action' => 'signup','prefix' => 'users']);
$routes->connect('/referrer/*',['controller' => 'Users', 'action' => 'signup','prefix' => 'users']);

$routes->connect('/sesss',['controller' => 'Users', 'action' => 'setbacknew','prefix' => 'users']);

$routes->connect('/verification/*',['controller' => 'Users', 'action' => 'verification','prefix' => 'users']);
$routes->connect('/verify/*',['controller' => 'Users', 'action' => 'verify','prefix' => 'users']);

$routes->connect('/forgotpassword',['controller' => 'Users', 'action' => 'forgotpassword','prefix' => 'users']);
$routes->connect('/setpassword/*',['controller' => 'Users', 'action' => 'setpassword','prefix' => 'users']);

$routes->connect('/social/*',['controller' => 'Users', 'action' => 'social','prefix' => 'users']);
$routes->connect('/socialRedirect/',['controller' => 'Users', 'action' => 'socialRedirect','prefix' => 'users']);
$routes->connect('/add',['controller' => 'Users', 'action' => 'add','prefix' => 'users']);
$routes->connect('/listing/*',['controller' => 'Items', 'action' => 'view','prefix' => 'items']);
$routes->connect('/adduserlist',['controller' => 'Items', 'action' => 'adduserlist','prefix' => 'items']);

$routes->connect('/getItemByCategoryView/*',['controller' => 'Items', 'action' => 'getItemByCategoryView','prefix' => 'items']);

//getanswerlists


$routes->connect('/totaladduserlist',['controller' => 'Items', 'action' => 'totaladduserlist','prefix' => 'items']);
$routes->connect('/sendmessage',['controller' => 'Items', 'action' => 'sendmessage','prefix' => 'items']);

//$routes->connect('/shop/browse',['controller' => 'Shops', 'action' => 'search','prefix' => 'users']);
$routes->connect('/people/*',['controller' => 'Users', 'action' => 'userprofiles','prefix' => 'users']);
$routes->connect('/getmoreprofile/*',['controller' => 'Users', 'action' => 'getmoreprofile','prefix' => 'users']);
$routes->connect('/getMorePosts/*',['controller' => 'Users', 'action' => 'getMorePosts','prefix' => 'users']);
$routes->connect('/loadmore',['controller' => 'Users', 'action' => 'loadMore','prefix' => 'users']);
$routes->connect('/shop/*',['controller' => 'Shops', 'action' => 'showByCategory','prefix' => 'shops']);
$routes->connect('/searchproduct',['controller' => 'Shops', 'action' => 'showByCategory','prefix' => 'shops']);

$routes->connect('/getItemByCategory/*',['controller' => 'Shops', 'action' => 'getItemByCategory','prefix' => 'shops']);
$routes->connect('/ajaxSearch',['controller' => 'Users', 'action' => 'ajaxSearch','prefix' => 'users']);
$routes->connect('/searches/*',['controller' => 'Users', 'action' => 'searches','prefix' => 'users']);

$routes->connect('/searchpeople/*',['controller' => 'Users', 'action' => 'searchpeople','prefix' => 'users']);
$routes->connect('/searchviewmore/*',['controller' => 'Users', 'action' => 'searchviewmore','prefix' 
	=> 'users']);

$routes->connect('/help/faq',['controller' => 'Helps', 'action' => 'faq','prefix' => 'helps']);
$routes->connect('/help/contact',['controller' => 'Helps', 'action' => 'contact','prefix' => 'helps']);

$routes->connect('/help/sesss',['controller' => 'Helps', 'action' => 'setbacknew','prefix' => 'helps']);

$routes->connect('/help/copyright',['controller' => 'Helps', 'action' => 'copyright','prefix' => 'helps']);
$routes->connect('/help/terms_sales',['controller' => 'Helps', 'action' => 'termsSales','prefix' => 'helps']);
$routes->connect('/help/terms_service',['controller' => 'Helps', 'action' => 'termsService','prefix' => 'helps']);
$routes->connect('/help/terms_condition',['controller' => 'Helps', 'action' => 'termsCondition','prefix' => 'helps']);
$routes->connect('/help/privacy',['controller' => 'Helps', 'action' => 'privacy','prefix' => 'helps']);
$routes->connect('/mobileapps/*',['controller' => 'Helps', 'action' => 'mobileapps','prefix' => 'helps']);
$routes->connect('/addto/*',['controller' => 'Helps', 'action' => 'addto','prefix' => 'helps']);
$routes->connect('/help/collections',['controller' => 'Helps', 'action' => 'collections','prefix' => 'helps']);
$routes->connect('/help/checkout',['controller' => 'Helps', 'action' => 'checkout','prefix' => 'helps']);
$routes->connect('/help/talk',['controller' => 'Helps', 'action' => 'talk','prefix' => 'helps']);
$routes->connect('/help/about',['controller' => 'Helps', 'action' => 'about','prefix' => 'helps']);
$routes->connect('/help/documentation',['controller' => 'Helps', 'action' => 'documentation','prefix' => 'helps']);
$routes->connect('/help/press',['controller' => 'Helps', 'action' => 'press','prefix' => 'helps']);
$routes->connect('/help/pricing',['controller' => 'Helps', 'action' => 'pricing','prefix' => 'helps']);

$routes->connect('/sitemaintenance/*',['controller' => 'Users', 'action' => 'sitemaintenance','prefix' => 'users']);

$routes->connect('/logout',['controller' => 'Users', 'action' => 'logout','prefix' => 'users']);
$routes->connect('/addflw_usrs',['controller' => 'Users', 'action' => 'addflw_usrs','prefix' => 'users']);
$routes->connect('/livefeedsaddflw_usrs',['controller' => 'Users', 'action' => 'livefeedsaddflw_usrs','prefix' => 'users']);
$routes->connect('/delerteflw_usrs',['controller' => 'Users', 'action' => 'delerteflw_usrs','prefix' => 'users']);
$routes->connect('/addflw_shops',['controller' => 'Users', 'action' => 'addflw_shops','prefix' => 'users']);
$routes->connect('/deleteflw_shops',['controller' => 'Users', 'action' => 'deleteflw_shops','prefix' => 'users']);
$routes->connect('/showlistproducts',['controller' => 'Users', 'action' => 'showlistproducts','prefix' => 'users']);
$routes->connect('/savelistname',['controller' => 'Users', 'action' => 'savelistname','prefix' => 'users']);
$routes->connect('/profile',['controller' => 'Users', 'action' => 'profile','prefix' => 'users']);
$routes->connect('/password',['controller' => 'Users', 'action' => 'password','prefix' => 'users']);
$routes->connect('/notifications',['controller' => 'Users', 'action' => 'notifications','prefix' => 'users']);
$routes->connect('/deactivateacc',['controller' => 'Users', 'action' => 'deactivateacc','prefix' => 'users']);
$routes->connect('/activateacc',['controller' => 'Users', 'action' => 'activateacc','prefix' => 'users']);
$routes->connect('/address',['controller' => 'Users', 'action' => 'shipping','prefix' => 'users']);
$routes->connect('/hashtag/*',['controller' => 'Users', 'action' => 'hashtag','prefix' => 'users']);
$routes->connect('/addaddress/*',['controller' => 'Users', 'action' => 'addshipping','prefix' => 'users']);
$routes->connect('/defaultshipping',['controller' => 'Users', 'action' => 'defaultshipping','prefix' => 'users']);
$routes->connect('/deleteshipping',['controller' => 'Users', 'action' => 'deleteshipping','prefix' => 'users']);
$routes->connect('/credits',['controller' => 'Users', 'action' => 'credits','prefix' => 'users']);
$routes->connect('/referrals',['controller' => 'Users', 'action' => 'referrals','prefix' => 'users']);
$routes->connect('/gift_cards/*',['controller' => 'Users', 'action' => 'gift_cards','prefix' => 'users']);
$routes->connect('/stores/*',['controller' => 'Users', 'action' => 'storeprofiles','prefix' => 'users']);
$routes->connect('/getmorestoreprofiles/*',['controller' => 'Users', 'action' => 'getmorestoreprofiles','prefix' => 'users']);
$routes->connect('/messages',['controller' => 'Users', 'action' => 'messages','prefix' => 'users']);
$routes->connect('/searchmessage/*',['controller' => 'Users', 'action' => 'searchmsg','prefix' => 'users']);
$routes->connect('/getmoremessage',['controller' => 'Users', 'action' => 'getmoremessage','prefix' => 'users']);
$routes->connect('/viewmessage/*',['controller' => 'Users', 'action' => 'viewmessage','prefix' => 'users']);
$routes->connect('/replymessage',['controller' => 'Users', 'action' => 'replymessage','prefix' => 'users']);
$routes->connect('/getmoreviewmessage',['controller' => 'Users', 'action' => 'getmoreviewmessage','prefix' => 'users']);
$routes->connect('/purchases',['controller' => 'Users', 'action' => 'purchaseditem','prefix' => 'users']);
$routes->connect('/buyerorderdetails/*',['controller' => 'Users', 'action' => 'buyerorderdetails','prefix' => 'users']);
$routes->connect('/additemReviews',['controller' => 'Users', 'action' => 'additemReviews','prefix' => 'users']);
$routes->connect('/cancel_cod_order',['controller' => 'Users', 'action' => 'cancel_cod_order','prefix' => 'users']);
$routes->connect('/markshipped/*',['controller' => 'Users', 'action' => 'markshipped','prefix' => 'users']);
$routes->connect('/trackingdetails/*',['controller' => 'Users', 'action' => 'trackingdetails','prefix' => 'users']);
$routes->connect('/sellerconversation/*',['controller' => 'Users', 'action' => 'sellerconversation','prefix' => 'users']);
$routes->connect('/buyerconversation/*',['controller' => 'Users', 'action' => 'buyerconversation','prefix' => 'users']);
$routes->connect('/postordercomment/*',['controller' => 'Users', 'action' => 'postordercomment','prefix' => 'users']);
$routes->connect('/getmorecomment/*',['controller' => 'Users', 'action' => 'getmorecomment','prefix' => 'users']);
$routes->connect('/getrecentcmnt/*',['controller' => 'Users', 'action' => 'getrecentcmnt','prefix' => 'users']);
$routes->connect('/getbuyercmnt/*',['controller' => 'Users', 'action' => 'getbuyercmnt','prefix' => 'users']);
$routes->connect('/getmorecommentbuyer/*',['controller' => 'Users', 'action' => 'getmorecommentbuyer','prefix' => 'users']);

$routes->connect('/orderstatus/*',['controller' => 'Users', 'action' => 'orderstatus','prefix' => 'users']);
$routes->connect('/returnorder/*',['controller' => 'Users', 'action' => 'returnorder','prefix' => 'users']);
$routes->connect('/claimorder/*',['controller' => 'Users', 'action' => 'claimorder','prefix' => 'users']);
$routes->connect('/buyerreturnorder/*',['controller' => 'Users', 'action' => 'buyerreturnorder','prefix' => 'users']);
$routes->connect('/buyerclaimorder/*',['controller' => 'Users', 'action' => 'buyerclaimorder','prefix' => 'users']);

$routes->connect('/customhome',['controller' => 'Users', 'action' => 'customhome','prefix' => 'users']);
$routes->connect('/allcategories',['controller' => 'Users', 'action' => 'allcategories','prefix' => 'users']);
$routes->connect('/getmorecategories',['controller' => 'Users', 'action' => 'getmorecategories','prefix' => 'users']);
$routes->connect('/getmorecommentviewpurchase',['controller' => 'Users', 'action' => 'getmorecommentviewpurchase','prefix' => 'users']);
$routes->connect('/userdispute/*',['controller' => 'Users', 'action' => 'dispute','prefix' => 'users']);
$routes->connect('/dispute/*',['controller' => 'Users', 'action' => 'disputepro','prefix' => 'users']);
$routes->connect('/disputemessage/*',['controller' => 'Users', 'action' => 'disputemessage','prefix' => 'users']);
$routes->connect('/allstores',['controller' => 'Users', 'action' => 'allstores','prefix' => 'users']);
$routes->connect('/getmorestores',['controller' => 'Users', 'action' => 'getmorestores','prefix' => 'users']);
$routes->connect('/livefeeds',['controller' => 'Users', 'action' => 'livefeeds','prefix' => 'users']);
$routes->connect('/deletestatus/*',['controller' => 'Users', 'action' => 'deletestatus','prefix' => 'users']);
$routes->connect('/statusfileupload',['controller' => 'Users', 'action' => 'statusfileupload','prefix' => 'users']);
$routes->connect('/fashionfileupload',['controller' => 'Users', 'action' => 'fashionfileupload','prefix' => 'users']);
$routes->connect('/update',['controller' => 'Users', 'action' => 'update','prefix' => 'users']);
$routes->connect('/poststatus',['controller' => 'Users', 'action' => 'poststatus','prefix' => 'users']);
$routes->connect('/orderitemdetail',['controller' => 'Users', 'action' => 'orderitemdetail','prefix' => 'users']);
$routes->connect('/getmorepeoplesearch',['controller' => 'Users', 'action' => 'getmorepeoplesearch','prefix' => 'users']);


$routes->connect('/getmorefeeds/*',['controller' => 'Users', 'action' => 'getmorefeeds','prefix' => 'users']);
$routes->connect('/create_group_gift/*',['controller' => 'Users', 'action' => 'create_group_gift','prefix' => 'users']);
$routes->connect('/ajaxUserAutogroupgift',['controller' => 'Users', 'action' => 'ajaxUserAutogroupgift','prefix' => 'users']);
$routes->connect('/ajaxUsergroupgiftcard/*',['controller' => 'Users', 'action' => 'ajaxUsergroupgiftcard','prefix' => 'users']);
$routes->connect('/ggusersave/*',['controller' => 'Users', 'action' => 'ggusersave','prefix' => 'users']);
$routes->connect('/checkuser/*',['controller' => 'Users', 'action' => 'checkuser','prefix' => 'users']);
$routes->connect('/groupgiftreason/*',['controller' => 'Users', 'action' => 'groupgiftreason','prefix' => 'users']);
$routes->connect('/gifts/*',['controller' => 'Users', 'action' => 'gifts','prefix' => 'users']);
$routes->connect('/groupgifts',['controller' => 'Users', 'action' => 'groupgifts','prefix' => 'users']);
$routes->connect('/group_gift_lists/*',['controller' => 'Users', 'action' => 'gglists','prefix' => 'users']);
$routes->connect('/shop/*',['controller' => 'Shops', 'action' => 'showByCategory','prefix' => 'shops']);
$routes->connect('/getItemByCategory/*',['controller' => 'Shops', 'action' => 'getItemByCategory','prefix' => 'shops']);
$routes->connect('/viewmore/*',['controller' => 'Users', 'action' => 'customviewmore','prefix' => 'users']);
$routes->connect('/viewmorestores/*',['controller' => 'Users', 'action' => 'customviewmorestore','prefix' => 'users']);
$routes->connect('/getviewmore/*',['controller' => 'Users', 'action' => 'getviewmore','prefix' => 'users']);
$routes->connect('/getviewmore/*',['controller' => 'Users', 'action' => 'getviewmore','prefix' => 'users']);
$routes->connect('/getpushajax/*',['controller' => 'Users', 'action' => 'getpushajax','prefix' => 'users']);
$routes->connect('/cartmousehover',['controller' => 'Users', 'action' => 'cartmousehover','prefix' => 'users']);
$routes->connect('/userlike/*',['controller' => 'Users', 'action' => 'userlike','prefix' => 'users']);
$routes->connect('/userUnlike/*',['controller' => 'Users', 'action' => 'userUnlike','prefix' => 'users']);
$routes->connect('/rating',['controller' => 'Users', 'action' => 'rating','prefix' => 'users']);
$routes->connect('/reportitem/*',['controller' => 'Items', 'action' => 'reportitem','prefix' => 'items']);
$routes->connect('/undoreportitem/*',['controller' => 'Items', 'action' => 'undoreportitem','prefix' => 'items']);
$routes->connect('/ajaxHashAuto/*',['controller' => 'Items', 'action' => 'ajaxHashAuto','prefix' => 'items']);
$routes->connect('/ajaxUserAuto/*',['controller' => 'Items', 'action' => 'ajaxUserAuto','prefix' => 'items']);
$routes->connect('/getfacebookcoupon/*',['controller' => 'Items', 'action' => 'getfacebookcoupon','prefix' => 'items']);

$routes->connect('/sociallogin/*',['controller' => 'Items', 'action' => 'sociallogin','prefix' => 'items']);


$routes->connect('/addcomments/*',['controller' => 'Items', 'action' => 'addcomments','prefix' => 'items']);
$routes->connect('/editcommentsave/*',['controller' => 'Items', 'action' => 'editcommentsave','prefix' => 'items']);
$routes->connect('/deletecomments/*',['controller' => 'Items', 'action' => 'deletecomments','prefix' => 'items']);


$routes->connect('/senddata',['controller' => 'Items', 'action' => 'addfaqdata','prefix' => 'items']);
$routes->connect('/getanswers',['controller' => 'Items', 'action' => 'getanswerlists','prefix' => 'items']);
$routes->connect('/viewallfaq/*',['controller' => 'Items', 'action' => 'viewallfaq','prefix' => 'items']);
$routes->connect('/viewallreviews/*',['controller' => 'Items', 'action' => 'viewallreviews','prefix' => 'items']);

$routes->connect('/allreviews/*',['controller' => 'Items', 'action' => 'viewallreviews','prefix' => 'items']);

// $routes->connect('/additemReviews',['controller' => 'Items', 'action' => 'additemReviews','prefix' => 'items']);
$routes->connect('/affiliateproducts/*',['controller' => 'Users', 'action' => 'affiliateproducts','prefix' => 'users']);
$routes->connect('/getitembycommission/*',['controller' => 'Users', 'action' => 'getitembycommission','prefix' => 'users']);



//new lines added
$routes->connect('/creategiftcard/*',['controller' => 'Users', 'action' => 'create_giftcard','prefix' => 'users']);
$routes->connect('/search/people/*',['controller' => 'Users', 'action' => 'peoplesearch','prefix' => 'users']);
$routes->connect('/invite_friends/*',['controller' => 'Users', 'action' => 'invite_friends','prefix' => 'users']);
$routes->connect('/sendinviteemailref/*',['controller' => 'Users', 'action' => 'sendinviteemailref','prefix' => 'users']);
$routes->connect('/push_notifications/*',['controller' => 'Users', 'action' => 'pushnotifications','prefix' => 'users']);
$routes->connect('/notificationsfollow/*',['controller' => 'Users', 'action' => 'notificationsfollow','prefix' => 'users']);
$routes->connect('/addflwUsrs/*',['controller' => 'Users', 'action' => 'addflwUsrs','prefix' => 'users']);
$routes->connect('/groupgiftsoldout/*',['controller' => 'Paypals', 'action' => 'groupgiftsoldout','prefix' => 'users']);
$routes->connect('/groupgiftupdate/*',['controller' => 'Paypals', 'action' => 'groupgiftupdate','prefix' => 'users']);
$routes->connect('/getsizeqty',['controller' => 'Items', 'action' => 'getsizeqty','prefix' => 'items']);
//Paypals Controller
$routes->connect('/cart/*',['controller' => 'Paypals', 'action' => 'pay','prefix' => 'users']);
$routes->connect('/conversion/*',['controller' => 'Paypals', 'action' => 'conversion','prefix' => 'users']);
$routes->connect('/updatecart/*',['controller' => 'Paypals', 'action' => 'updatecart','prefix' => 'users']);
$routes->connect('/updatecartcod/*',['controller' => 'Paypals', 'action' => 'updatecartcod','prefix' => 'users']);
$routes->connect('/deletecartcod/*',['controller' => 'Paypals', 'action' => 'deletecartcod','prefix' => 'users']);
$routes->connect('/deletecartitem/*',['controller' => 'Paypals', 'action' => 'deletecartitem','prefix' => 'users']);
$routes->connect('/checkgiftcardcode/*',['controller' => 'Paypals', 'action' => 'checkgiftcardcode','prefix' => 'users']);
$routes->connect('/checksellercouponcode/*',['controller' => 'Paypals', 'action' => 'checksellercouponcode','prefix' => 'users']);
$routes->connect('/braintree/checkouttoken/*',['controller' => 'Paypals', 'action' => 'braintree_checkouttoken','prefix' => 'users']);
$routes->connect('/payment-cancelled/*',['controller' => 'Paypals','action' => 'paymentcancel','prefix' => 'users']);
$routes->connect('/paycod/*',['controller' => 'Paypals','action' => 'paycod','prefix' => 'users']);
$routes->connect('/cod/*',['controller' => 'Paypals','action' => 'cod','prefix' => 'users']);
$routes->connect('/pays/*',['controller' => 'Paypals','action' => 'paycart','prefix' => 'users']);
$routes->connect('/braintree/checkout/*',['controller' => 'Paypals','action' => 'braintreecheckout','prefix' => 'users']);
$routes->connect('/checkoutgiftcard/*',['controller' => 'Paypals','action' => 'checkoutgiftcard','prefix' => 'users']);
$routes->connect('/autocompleteusernames/*',['controller' => 'Users','action' => 'autocompleteusernames','prefix' => 'users']);
$routes->connect('/paypal/giftcardipnIpn/*',['controller' => 'Paypals','action' => 'giftcardipnIpn','prefix' => 'users']);
$routes->connect('/checkoutgroupgift/*',['controller' => 'Paypals','action' => 'checkoutgroupgift','prefix' => 'users']);
$routes->connect('/braintree/checkouttokengroupgift/*',['controller' => 'Paypals','action' => 'braintreecheckouttokengroupgift','prefix' => 'users']);
$routes->connect('/braintree/groupgift/*',['controller' => 'Paypals','action' => 'braintreegroupgift','prefix' => 'users']);
/** GIFTCARD **/
$routes->connect('/braintree/giftcard/*',['controller' => 'Paypals','action' => 'braintreegiftcard','prefix' => 'users']);
$routes->connect('/braintree/checkouttokengift/*',['controller' => 'Paypals','action' => 'braintreecheckouttokengift','prefix' => 'users']);
$routes->connect('/payment-successful/*',['controller' => 'Paypals','action' => 'paymentsuccess','prefix' => 'users']);
$routes->connect('/codcartcheckout/*',['controller' => 'Paypals','action' => 'codcartcheckout','prefix' => 'users']);
$routes->connect('/codbuynowcheckout/*',['controller' => 'Paypals','action' => 'codbuynowcheckout','prefix' => 'users']);
/*SET LANGUAGE **/
$routes->connect('/setlanguage/*',['controller' => 'Users','action' => 'setlanguage','prefix' => 'users']);
/*SEND MAIL **/
$routes->connect('/sendmail/*',['controller' => 'Users','action' => 'sendmail','prefix' => 'users']);

$routes->connect('/home',['controller' => 'Users', 'action' => 'home','prefix' => 'users']);
$routes->connect('/changecurrency/*',['controller' => 'Users', 'action' => 'changecurrency','prefix' => 'users']);
$routes->connect('/Stephen@2020',['controller' => 'Admins', 'action' => 'login','prefix' => 'admins']);
$routes->connect('/adminlogout',['controller' => 'Admins', 'action' => 'logout','prefix' => 'admins']);
$routes->connect('/adminadd',['controller' => 'Admins', 'action' => 'add','prefix' => 'admins']);
$routes->connect('/admindashboard',['controller' => 'Admins', 'action' => 'admindashboard','prefix' => 'admins']);
$routes->connect('/admin/pgsetup',['controller' => 'Admins', 'action' => 'pgsetup','prefix' => 'admins']);
$routes->connect('/addmember',['controller' => 'Admins', 'action' => 'addmember','prefix' => 'admins']);
$routes->connect('/giftrefundamount',['controller' => 'Admins', 'action' => 'giftrefundamount','prefix' => 'admins']);
$routes->connect('/getcategoryData',['controller' => 'Admins', 'action' => 'getcategoryData','prefix' => 'admins']);
$routes->connect('/dispcurrentstatus',['controller' => 'Admins', 'action' => 'dispcurrentstatus','prefix' => 'admins']);

$routes->connect('/admin/stripesetup',['controller' => 'Admins', 'action' => 'stripesetup','prefix' => 'admins']);
$routes->connect('/merchantpayment',['controller' => 'Admins', 'action' => 'merchantpayment','prefix' => 'admins']);
$routes->connect('/admin/commission',['controller' => 'Admins', 'action' => 'commission','prefix' => 'admins']);
$routes->connect('/admin/viewcommission',['controller' => 'Admins', 'action' => 'viewcommission','prefix' => 'admins']);
$routes->connect('/activatecommission/*',['controller' => 'Admins', 'action' => 'activatecommission','prefix' => 'admins']);
$routes->connect('/editcommission/*',['controller' => 'Admins', 'action' => 'editcommission','prefix' => 'admins']);
$routes->connect('/deletecommission/*',['controller' => 'Admins', 'action' => 'deletecommission','prefix' => 'admins']);
$routes->connect('/admin/taxrates',['controller' => 'Admins', 'action' => 'taxrates','prefix' => 'admins']);
$routes->connect('/deletetax/*',['controller' => 'Admins', 'action' => 'deletetax','prefix' => 'admins']);
$routes->connect('/addtax/*',['controller' => 'Admins', 'action' => 'addtax','prefix' => 'admins']);
$routes->connect('/edittax/*',['controller' => 'Admins', 'action' => 'edittax','prefix' => 'admins']);
$routes->connect('/admin/invoice/*',['controller' => 'Admins', 'action' => 'invoice','prefix' => 'admins']);
$routes->connect('/invoicesearch/*',['controller' => 'Admins', 'action' => 'invoicesearch','prefix' => 'admins']);
$routes->connect('/invoiceview/*',['controller' => 'Admins', 'action' => 'invoiceview','prefix' => 'admins']);
$routes->connect('/manageuser/*',['controller' => 'Admins', 'action' => 'manageuser','prefix' => 'admins']);
//$routes->connect('/searchuser/*',['controller' => 'Admins', 'action' => 'searchuser','prefix' => 'Admins']);
$routes->connect('/changeuserstatus/*',['controller' => 'Admins', 'action' => 'changeuserstatus','prefix' => 'admins']);
$routes->connect('/deleteuser/*',['controller' => 'Admins', 'action' => 'deleteuser','prefix' => 'admins']);
$routes->connect('/edituser/*',['controller' => 'Admins', 'action' => 'edituser','prefix' => 'admins']);
$routes->connect('/nonapproveduser/*',['controller' => 'Admins', 'action' => 'nonapproveduser','prefix' => 'admins']);
$routes->connect('/deleteinactiveuser/*',['controller' => 'Admins', 'action' => 'deleteinactiveuser','prefix' => 'admins']);

//$routes->connect('/searchnonapproveduser/*',['controller' => 'Admins', 'action' => 'searchnonapproveduser','prefix' => 'Admins']);
//$routes->connect('/searchinactiveuser/*',['controller' => 'Admins', 'action' => 'searchinactiveuser','prefix' => 'Admins']);
$routes->connect('/managemoderator/*',['controller' => 'Admins', 'action' => 'managemoderator','prefix' => 'admins']);
$routes->connect('/nonapprovedmoderator/*',['controller' => 'Admins', 'action' => 'nonapprovedmoderator','prefix' => 'admins']);
//$routes->connect('/addcoupon/*',['controller' => 'Admins', 'action' => 'addcoupon','prefix' => 'Admins']);
$routes->connect('/admin/couponlog/*',['controller' => 'Admins', 'action' => 'couponlog','prefix' => 'admins']);
$routes->connect('/viewcoupon/*',['controller' => 'Admins', 'action' => 'viewcoupon','prefix' => 'admins']);
$routes->connect('/admin/managecoupon/*',['controller' => 'Admins', 'action' => 'managecoupon','prefix' => 'admins']);
$routes->connect('/editcoupon/*',['controller' => 'Admins', 'action' => 'editcoupon','prefix' => 'admins']);
$routes->connect('/admin/addcoupon/*',['controller' => 'Admins', 'action' => 'addcoupon','prefix' => 'admins']);
$routes->connect('/giftcardlog/*',['controller' => 'Admins', 'action' => 'giftcardlog','prefix' => 'admins']);
$routes->connect('/giftcard/*',['controller' => 'Admins', 'action' => 'giftcard','prefix' => 'admins']);
$routes->connect('/groupgift/*',['controller' => 'Admins', 'action' => 'groupgifts','prefix' => 'admins']);
$routes->connect('/admin/featuredcat',['controller' => 'Admins', 'action' => 'featuredcat','prefix' => 'admins']);

$routes->connect('/manageproblem/*',['controller' => 'Admins', 'action' => 'manageproblem','prefix' => 'admins']);
$routes->connect('/dispquestion/*',['controller' => 'Admins', 'action' => 'dispquestion','prefix' => 'admins']);
$routes->connect('/deletedispquestion/*',['controller' => 'Admins', 'action' => 'deletedispquestion','prefix' => 'admins']);
$routes->connect('/contactsellersubject/*',['controller' => 'Admins', 'action' => 'contactsellersubject','prefix' => 'admins']);
$routes->connect('/addsubject/*',['controller' => 'Admins', 'action' => 'addsubject','prefix' => 'admins']);
$routes->connect('/deletesubject/*',['controller' => 'Admins', 'action' => 'deletesubject','prefix' => 'admins']);
$routes->connect('/contacteditem/*',['controller' => 'Admins', 'action' => 'contacteditem','prefix' => 'admins']);
$routes->connect('/itemconversation/*',['controller' => 'Admins', 'action' => 'itemconversation','prefix' => 'admins']);
$routes->connect('/itemuserconversation/*',['controller' => 'Admins', 'action' => 'itemuserconversation','prefix' => 'admins']);
$routes->connect('/deletecsconversation/*',['controller' => 'Admins', 'action' => 'deletecsconversation','prefix' => 'admins']);
$routes->connect('/adminitemview/*',['controller' => 'Admins', 'action' => 'adminitemview','prefix' => 'admins']);

$routes->connect('/viewcategory/*',['controller' => 'Admins', 'action' => 'viewcategory','prefix' => 'admins']);
$routes->connect('/createcategory/*',['controller' => 'Admins', 'action' => 'createcategory','prefix' => 'admins']);
$routes->connect('/mediasetting/*',['controller' => 'Admins', 'action' => 'mediasetting','prefix' => 'admins']);
$routes->connect('/mailsetting/*',['controller' => 'Admins', 'action' => 'mailsetting','prefix' => 'admins']);
$routes->connect('/managelanguage/*',['controller' => 'Admins', 'action' => 'managelanguage','prefix' => 'admins']);
$routes->connect('/addlanguage/*',['controller' => 'Admins', 'action' => 'addlanguage','prefix' => 'admins']);
$routes->connect('/mobilesetting/*',['controller' => 'Admins', 'action' => 'mobilesetting','prefix' => 'admins']);
$routes->connect('/socialsetting/*',['controller' => 'Admins', 'action' => 'socialsetting','prefix' => 'admins']);
$routes->connect('/socialpagesetting/*',['controller' => 'Admins', 'action' => 'socialpagesetting','prefix' => 'admins']);
$routes->connect('/addfaq/*',['controller' => 'Admins', 'action' => 'addfaq','prefix' => 'admins']);
$routes->connect('/managefaq/*',['controller' => 'Admins', 'action' => 'managefaq','prefix' => 'admins']);
$routes->connect('/editfaq/*',['controller' => 'Admins', 'action' => 'editfaq','prefix' => 'admins']);
$routes->connect('/sitesetting/*',['controller' => 'Admins', 'action' => 'sitesetting','prefix' => 'admins']);
$routes->connect('/managemodules/*',['controller' => 'Admins', 'action' => 'managemodules','prefix' => 'admins']);
$routes->connect('/googlecode/*',['controller' => 'Admins', 'action' => 'googlecode','prefix' => 'admins']);
$routes->connect('/about/*',['controller' => 'Admins', 'action' => 'about','prefix' => 'admins']);
$routes->connect('/documentation/*',['controller' => 'Admins', 'action' => 'documentation','prefix' => 'admins']);
$routes->connect('/press/*',['controller' => 'Admins', 'action' => 'press','prefix' => 'admins']);
$routes->connect('/pricing/*',['controller' => 'Admins', 'action' => 'pricing','prefix' => 'admins']);
$routes->connect('/talk/*',['controller' => 'Admins', 'action' => 'talk','prefix' => 'admins']);
$routes->connect('/faq/*',['controller' => 'Admins', 'action' => 'faq','prefix' => 'admins']);
$routes->connect('/contactaddress/*',['controller' => 'Admins', 'action' => 'contactaddress','prefix' => 'admins']);
$routes->connect('/termsofsale/*',['controller' => 'Admins', 'action' => 'termsofsale','prefix' => 'admins']);
$routes->connect('/termsofservice/*',['controller' => 'Admins', 'action' => 'termsofservice','prefix' => 'admins']);
$routes->connect('/privacypolicy/*',['controller' => 'Admins', 'action' => 'privacypolicy','prefix' => 'admins']);
$routes->connect('/termsandcondition/*',['controller' => 'Admins', 'action' => 'termsandcondition','prefix' => 'admins']);
$routes->connect('/copyrightpolicy/*',['controller' => 'Admins', 'action' => 'copyrightpolicy','prefix' => 'admins']);
$routes->connect('/addbanner/*',['controller' => 'Admins', 'action' => 'addbanner','prefix' => 'admins']);
$routes->connect('/neworders/*',['controller' => 'Admins', 'action' => 'neworders','prefix' => 'admins']);
$routes->connect('/managecolors/*',['controller' => 'Admins', 'action' => 'managecolors','prefix' => 'admins']);
$routes->connect('/addcolor/*',['controller' => 'Admins', 'action' => 'addcolor','prefix' => 'admins']);
$routes->connect('/editcolor/*',['controller' => 'Admins', 'action' => 'editcolor','prefix' => 'admins']);
$routes->connect('/manageprice/*',['controller' => 'Admins', 'action' => 'manageprice','prefix' => 'admins']);
$routes->connect('/addprice/*',['controller' => 'Admins', 'action' => 'addprice','prefix' => 'admins']);
$routes->connect('/editprice/*',['controller' => 'Admins', 'action' => 'editprice','prefix' => 'admins']);
$routes->connect('/managecurrency/*',['controller' => 'Admins', 'action' => 'managecurrency','prefix' => 'admins']);
$routes->connect('/managecurrency/*',['controller' => 'Admins', 'action' => 'managecurrency','prefix' => 'admins']);
$routes->connect('/editcurrency/*',['controller' => 'Admins', 'action' => 'editcurrency','prefix' => 'admins']);
$routes->connect('/addcurrency/*',['controller' => 'Admins', 'action' => 'addcurrency','prefix' => 'admins']);
$routes->connect('/nonapprovedseller/*',['controller' => 'Admins', 'action' => 'nonapprovedseller','prefix' => 'admins']);
$routes->connect('/editseller/*',['controller' => 'Admins', 'action' => 'editseller','prefix' => 'admins']);
$routes->connect('/braintree_settings/*',['controller' => 'Admins', 'action' => 'braintree_settings','prefix' => 'admins']);
$routes->connect('/approvedseller/*',['controller' => 'Admins', 'action' => 'approvedseller','prefix' => 'admins']);
$routes->connect('/inactivedisp/*',['controller' => 'Admins', 'action' => 'inactivedisp','prefix' => 'admins']);
$routes->connect('/deliveredorders/*',['controller' => 'Admins', 'action' => 'deliveredorders','prefix' => 'admins']);
$routes->connect('/viewneworder/*',['controller' => 'Admins', 'action' => 'viewneworder','prefix' => 'admins']);
$routes->connect('/viewdeliveredorder/*',['controller' => 'Admins', 'action' => 'viewdeliveredorder','prefix' => 'admins']);
$routes->connect('/approvedorders/*',['controller' => 'Admins', 'action' => 'approvedorders','prefix' => 'admins']);
$routes->connect('/viewapprovedorder/*',['controller' => 'Admins', 'action' => 'viewapprovedorder','prefix' => 'admins']);
$routes->connect('/braintree/admin_checkout_braintree/*',['controller' => 'Admins', 'action' => 'admin_checkout_braintree','prefix' => 'admins']);

$routes->connect('/shippedorders/*',['controller' => 'Admins', 'action' => 'shippedorders','prefix' => 'admins']);
$routes->connect('/viewshippedorder/*',['controller' => 'Admins', 'action' => 'viewshippedorder','prefix' => 'admins']);
$routes->connect('/returnedorders/*',['controller' => 'Admins', 'action' => 'returnedorders','prefix' => 'admins']);
$routes->connect('/viewreturnedorder/*',['controller' => 'Admins', 'action' => 'viewreturnedorder','prefix' => 'admins']);
$routes->connect('/claimedorders/*',['controller' => 'Admins', 'action' => 'claimedorders','prefix' => 'admins']);
$routes->connect('/viewclaimedorder/*',['controller' => 'Admins', 'action' => 'viewclaimedorder','prefix' => 'admins']);
$routes->connect('/merchantpaymentexport/*',['controller' => 'Admins', 'action' => 'merchantpaymentexport','prefix' => 'admins']);
$routes->connect('/addcategory/*',['controller' => 'Admins', 'action' => 'addcategory','prefix' => 'admins']);
$routes->connect('/editcategory/*',['controller' => 'Admins', 'action' => 'editcategory','prefix' => 'admins']);
$routes->connect('/shareditems/*',['controller' => 'Admins', 'action' => 'shareditems','prefix' => 'admins']);
$routes->connect('/reportitems/*',['controller' => 'Admins', 'action' => 'reportitems','prefix' => 'admins']);
$routes->connect('/nonapproveditems/*',['controller' => 'Admins', 'action' => 'nonapproveditems','prefix' => 'admins']);
$routes->connect('/approveditems/*',['controller' => 'Admins', 'action' => 'approveditems','prefix' => 'admins']);
$routes->connect('/processingdisp/*',['controller' => 'Admins', 'action' => 'processingdisp','prefix' => 'admins']);
$routes->connect('/closeddisp/*',['controller' => 'Admins', 'action' => 'closeddisp','prefix' => 'admins']);
$routes->connect('/canceldisp/*',['controller' => 'Admins', 'action' => 'canceldisp','prefix' => 'admins']);
$routes->connect('/resolveddisp/*',['controller' => 'Admins', 'action' => 'resolveddisp','prefix' => 'admins']);

$routes->connect('/activedisp/*',['controller' => 'Admins', 'action' => 'activedisp','prefix' => 'admins']);
$routes->connect('/viewdisp/*',['controller' => 'Admins', 'action' => 'viewdisp','prefix' => 'admins']);
$routes->connect('/addnews/*',['controller' => 'Admins', 'action' => 'addnews','prefix' => 'admins']);
$routes->connect('/getcontacts/*',['controller' => 'Admins', 'action' => 'getcontacts','prefix' => 'admins']);
$routes->connect('/addadminsettings/*',['controller' => 'Admins', 'action' => 'addadminsettings','prefix' => 'admins']);
$routes->connect('/edititem/*',['controller' => 'Admins', 'action' => 'edititem','prefix' => 'admins']);
$routes->connect('/adminsetting/*',['controller' => 'Admins', 'action' => 'adminsetting','prefix' => 'admins']);
$routes->connect('/adminitemview/*',['controller' => 'Admins', 'action' => 'adminitemview','prefix' => 'admins']);
$routes->connect('/dashboard/*',['controller' => 'Admins', 'action' => 'dashboard','prefix' => 'admins']);
$routes->connect('/gifts/*',['controller' => 'Admins', 'action' => 'gifts','prefix' => 'admins']);
$routes->connect('/mailfunc/',['controller' => 'Admins', 'action' => 'mailfunc','prefix' => 'admins']);
$routes->connect('/404page/',['controller' => 'Admins', 'action' => 'errorpage','prefix' => 'admins']);
$routes->connect('/refundedorders/',['controller' => 'Admins', 'action' => 'refundedorders','prefix' => 'admins']);
$routes->connect('/viewrefundedorder/*',['controller' => 'Admins', 'action' => 'viewrefundedorder','prefix' => 'admins']);
$routes->connect('/cancelledorders/',['controller' => 'Admins', 'action' => 'cancelledorders','prefix' => 'admins']);
$routes->connect('/viewcancelledorder/*',['controller' => 'Admins', 'action' => 'viewcancelledorder','prefix' => 'admins']);

$routes->connect('/managenewsletter/*',['controller' => 'Admins', 'action' => 'managenewsletter','prefix' => 'admins']);
$routes->connect('/listcontacts/*',['controller' => 'Admins', 'action' => 'listcontacts','prefix' => 'admins']);
$routes->connect('/newsletter/*',['controller' => 'Admins', 'action' => 'newsletter','prefix' => 'admins']);

$routes->connect('/landingpage/', array('controller' => 'Admins', 'action' => 'landingpage','prefix' => 'admins'));
$routes->connect('/addslider', array('controller' => 'Admins', 'action' => 'addslider','prefix' => 'admins'));
$routes->connect('/editslider/*', array('controller' => 'Admins', 'action' => 'editslider','prefix' => 'admins'));
$routes->connect('/deleteslider/*', array('controller' => 'Admins', 'action' => 'deleteslider','prefix' => 'admins'));
$routes->connect('/giftdetail/*',['controller' => 'Admins', 'action' => 'giftdetail','prefix' => 'admins']);
$routes->connect('/sellerinfo/*',['controller' => 'Admins', 'action' => 'sellerinfo','prefix' => 'admins']);
$routes->connect('/reordercomponents', array('controller' => 'Admins', 'action' => 'reordercomponents','prefix' => 'admins'));


$routes->connect('/like_status/*',['controller' => 'users', 'action' => 'like_status','prefix' => 'users']);
$routes->connect('/addfeedcomments/*',['controller' => 'users', 'action' => 'addfeedcomments','prefix' => 'users']);
$routes->connect('/editfeedcommentsave/*',['controller' => 'users', 'action' => 'editfeedcommentsave','prefix' => 'users']);
$routes->connect('/deletefeedcomments/*',['controller' => 'users', 'action' => 'deletefeedcomments','prefix' => 'users']);
$routes->connect('/sharefeed/*',['controller' => 'users', 'action' => 'sharefeed','prefix' => 'users']);
$routes->connect('/listlikedusers/*',['controller' => 'users', 'action' => 'listlikedusers','prefix' => 'users']);
$routes->connect('/loadmorefeedcomments/*',['controller' => 'users', 'action' => 'loadmorefeedcomments','prefix' => 'users']);


//Merchant
//$routes->connect('/merchant',['controller' => 'Merchant', 'action' => 'index','prefix' => 'merchant']);
$routes->connect('/merchant/dashboard',['controller' => 'Merchant', 'action' => 'dashboard','prefix' => 'merchant']);
$routes->connect('/merchant/login',['controller' => 'Merchant', 'action' => 'login','prefix' => 'merchant']);
$routes->connect('/merchant/logout',['controller' => 'Merchant', 'action' => 'logout','prefix' => 'merchant']);
$routes->connect('/merchant/signup',['controller' => 'Merchant', 'action' => 'signup','prefix' => 'merchant']);
$routes->connect('/merchant/messages',['controller' => 'Merchant', 'action' => 'messages','prefix' => 'merchant']);
$routes->connect('/merchant/news',['controller' => 'Merchant', 'action' => 'news','prefix' => 'merchant']);
$routes->connect('/merchant/addcartcoupon/*',['controller' => 'Merchant', 'action' => 'addcartcoupon','prefix' => 'merchant']);
$routes->connect('/merchant/cartdetails',['controller' => 'Merchant', 'action' => 'cartdetails','prefix' => 'merchant']);
$routes->connect('/merchant/paymentsettings',['controller' => 'Merchant', 'action' => 'paymentsettings','prefix' => 'merchant']);
$routes->connect('/merchant/paymenthistory/*',['controller' => 'Merchant', 'action' => 'paymenthistory','prefix' => 'merchant']);
$routes->connect('/merchant/generatecoupons/*',['controller' => 'Merchant', 'action' => 'generatecoupons','prefix' => 'merchant']);

$routes->connect('/merchant/itempopup',['controller' => 'Merchant', 'action' => 'itempopup','prefix' => 'merchant']);
$routes->connect('/merchant/submitanswer',['controller' => 'Merchant', 'action' => 'submitanswer','prefix' => 'merchant']);
$routes->connect('/merchant/answeredproductsfaq',['controller' => 'Merchant', 'action' => 'answeredproductsfaq','prefix' => 'merchant']);
$routes->connect('/merchant/productsfaq/*',['controller' => 'Merchant', 'action' => 'productsfaq','prefix' => 'merchant']);



$routes->connect('/merchant/addcategorycoupon/*',['controller' => 'Merchant', 'action' => 'addcategorycoupon','prefix' => 'merchant']);
$routes->connect('/merchant/editcategorycoupon/*',['controller' => 'Merchant', 'action' => 'editcategorycoupon','prefix' => 'merchant']);
$routes->connect('/merchant/itemcoupons',['controller' => 'Merchant', 'action' => 'itemcoupons','prefix' => 'merchant']);
$routes->connect('/merchant/cartcoupons',['controller' => 'Merchant', 'action' => 'cartcoupons','prefix' => 'merchant']);
$routes->connect('/merchant/categorycoupons',['controller' => 'Merchant', 'action' => 'categorycoupons','prefix' => 'merchant']);
$routes->connect('/merchant/deletecoupon/*',['controller' => 'Merchant', 'action' => 'deletecoupon','prefix' => 'merchant']);
$routes->connect('/merchant/additemcoupon/*',['controller' => 'Merchant', 'action' => 'additemcoupon','prefix' => 'merchant']);

$routes->connect('/merchant/addnews/*',['controller' => 'Merchant', 'action' => 'addnews','prefix' => 'merchant']);
$routes->connect('/merchant/newsletter/*',['controller' => 'Merchant', 'action' => 'newsletter','prefix' => 'merchant']);
$routes->connect('/merchant/get_contacts/*',['controller' => 'Merchant', 'action' => 'get_contacts','prefix' => 'merchant']);
$routes->connect('/merchant/managenewsletter/*',['controller' => 'Merchant', 'action' => 'managenewsletter','prefix' => 'merchant']);
$routes->connect('/merchant/sellerpost',['controller' => 'Merchant', 'action' => 'sellerpost','prefix' => 'merchant']);
$routes->connect('/merchant/selleritemview/*',['controller' => 'Merchant', 'action' => 'selleritemview','prefix' => 'merchant']);
$routes->connect('/merchant/viewmessage/*',['controller' => 'Merchant', 'action' => 'viewmessage','prefix' => 'merchant']);
$routes->connect('/merchant/getmoreviewmessage/*',['controller' => 'Merchant', 'action' => 'getmoreviewmessage','prefix' => 'merchant']);
$routes->connect('/merchant/replymessage/*',['controller' => 'Merchant', 'action' => 'replymessage','prefix' => 'merchant']);
$routes->connect('/merchant/fulfillorders/*',['controller' => 'Merchant', 'action' => 'fulfillorders','prefix' => 'merchant']);
$routes->connect('/merchant/fulfilloldorders/*',['controller' => 'Merchant', 'action' => 'fulfilloldorders','prefix' => 'merchant']);

//$routes->connect('/merchant/actionrequired/*',['controller' => 'Merchant', 'action' => 'actionrequired','prefix' => 'merchant']);
$routes->connect('/merchant/actionoldorders/*',['controller' => 'Merchant', 'action' => 'actionoldorders','prefix' => 'merchant']);

$routes->connect('/merchant/neworders/*',['controller' => 'Merchant', 'action' => 'actionrequired','prefix' => 'merchant']);


$routes->connect('/merchant/historyorders/*',['controller' => 'Merchant', 'action' => 'history','prefix' => 'merchant']);
$routes->connect('/merchant/historyoldorders/*',['controller' => 'Merchant', 'action' => 'historyoldmyorders','prefix' => 'merchant']);

$routes->connect('/merchant/claimedorders/*',['controller' => 'Merchant', 'action' => 'claimed','prefix' => 'merchant']);
$routes->connect('/merchant/claimedoldorders/*',['controller' => 'Merchant', 'action' => 'claimedoldorders','prefix' => 'merchant']);

$routes->connect('/merchant/returnedorders/*',['controller' => 'Merchant', 'action' => 'returned','prefix' => 'merchant']);
$routes->connect('/merchant/returnedoldorders/*',['controller' => 'Merchant', 'action' => 'returnedoldorders','prefix' => 'merchant']);

$routes->connect('/merchant/cancelledorders/*',['controller' => 'Merchant', 'action' => 'cancelled','prefix' => 'merchant']);
$routes->connect('/merchant/cancelledoldorders/*',['controller' => 'Merchant', 'action' => 'cancelledoldorders','prefix' => 'merchant']);

$routes->connect('/merchant/viewinvoice/*',['controller' => 'Merchant', 'action' => 'viewinvoice','prefix' => 'merchant']);
$routes->connect('/merchant/sellerconversation/*',['controller' => 'Merchant', 'action' => 'sellerconversation','prefix' => 'merchant']);
$routes->connect('/merchant/trackingdetails/*',['controller' => 'Merchant', 'action' => 'trackingdetails','prefix' => 'merchant']);
$routes->connect('/merchant/markshipped/*',['controller' => 'Merchant', 'action' => 'markshipped','prefix' => 'merchant']);
$routes->connect('/merchant/postordercomment/*',['controller' => 'Merchant', 'action' => 'postordercomment','prefix' => 'merchant']);
$routes->connect('/merchant/getmorecomment/*',['controller' => 'Merchant', 'action' => 'getmorecomment','prefix' => 'merchant']);
$routes->connect('/merchant/getrecentcmnt/*',['controller' => 'Merchant', 'action' => 'getrecentcmnt','prefix' => 'merchant']);
$routes->connect('/merchant/updatetrackingdetails/*',['controller' => 'Merchant', 'action' => 'updatetrackingdetails','prefix' => 'merchant']);
$routes->connect('/merchant/markpaid/*',['controller' => 'Merchant', 'action' => 'markpaid','prefix' => 'merchant']);
$routes->connect('/merchant/orderstatus/*',['controller' => 'Merchant', 'action' => 'orderstatus','prefix' => 'merchant']);
$routes->connect('/merchant/viewreturn/*',['controller' => 'Merchant', 'action' => 'viewreturn','prefix' => 'merchant']);
$routes->connect('/merchant/addproducts/*',['controller' => 'Merchant', 'action' => 'createitem','prefix' => 'merchant']);
$routes->connect('/merchant/saveitems/*',['controller' => 'Merchant', 'action' => 'saveitems','prefix' => 'merchant']);
$routes->connect('/merchant/suprsubcategry/*',['controller' => 'Merchant', 'action' => 'suprsubcategry','prefix' => 'merchant']);
$routes->connect('/merchant/checkskuid/*',['controller' => 'Merchant', 'action' => 'checkskuid','prefix' => 'merchant']);

$routes->connect('/merchant/editproducts/*',['controller' => 'Merchant', 'action' => 'updateproducts','prefix' => 'merchant']);

$routes->connect('/merchant/updateproducts/*',['controller' => 'Merchant', 'action' => 'updateproducts','prefix' => 'merchant']);

$routes->connect('/merchant/demopro/*',['controller' => 'Merchant', 'action' => 'demopro','prefix' => 'merchant']);

$routes->connect('/merchant/editselleritem/*',['controller' => 'Merchant', 'action' => 'editselleritem','prefix' => 'merchant']);
$routes->connect('/merchant/sellerinformation/*',['controller' => 'Merchant', 'action' => 'settings','prefix' => 'merchant']);
$routes->connect('/merchant/fashionuserimage/*',['controller' => 'Merchant', 'action' => 'userphotoupload','prefix' => 'merchant']);
$routes->connect('/merchant/deleteitemfashion/*',['controller' => 'Merchant', 'action' => 'deleteitemfashion','prefix' => 'merchant']);
$routes->connect('/merchant/updatephotofashion/*',['controller' => 'Merchant', 'action' => 'updatephotofashion','prefix' => 'merchant']);
$routes->connect('/merchant/changesellerstatus/*',['controller' => 'Merchant', 'action' => 'changesellerstatus','prefix' => 'merchant']);
$routes->connect('/merchant/disputes/*',['controller' => 'Merchant', 'action' => 'disputepro','prefix' => 'merchant']);
$routes->connect('/merchant/getmorecommentview/*',['controller' => 'Merchant', 'action' => 'getmorecommentview','prefix' => 'merchant']);
$routes->connect('/merchant/getmorecommentviewseller/*',['controller' => 'Merchant', 'action' => 'getmorecommentviewseller','prefix' => 'merchant']);
$routes->connect('/merchant/getrecentdispallbuyer/*',['controller' => 'Merchant', 'action' => 'getrecentdispallbuyer','prefix' => 'merchant']);
$routes->connect('/merchant/getrecentdispallseller/*',['controller' => 'Merchant', 'action' => 'getrecentdispallseller','prefix' => 'merchant']);
$routes->connect('/merchant/forgotpassword/*',['controller' => 'Merchant', 'action' => 'forgotpassword','prefix' => 'merchant']);
$routes->connect('/merchant/disputemessage/*',['controller' => 'Merchant', 'action' => 'disputemessage','prefix' => 'merchant']);
$routes->connect('/merchant/disputeBuyer/*',['controller' => 'Merchant', 'action' => 'disputesellermsg','prefix' => 'merchant']);
$routes->connect('/merchant/getmorecommentbuyer/*',['controller' => 'Merchant', 'action' => 'getmorecommentbuyer','prefix' => 'merchant']);
$routes->connect('/merchant/getmorecommentseller/*',['controller' => 'Merchant', 'action' => 'getmorecommentseller','prefix' => 'merchant']);
$routes->connect('/merchant/deleteitem/*',['controller' => 'Merchant', 'action' => 'deleteitem','prefix' => 'merchant']);
$routes->connect('/merchant/deletefaq/*',['controller' => 'Merchant', 'action' => 'deletefaq','prefix' => 'merchant']);
$routes->connect('/merchant/changepassword/*',['controller' => 'Merchant', 'action' => 'changepassword','prefix' => 'merchant']);
$routes->connect('/merchant/getcontacts/*',['controller' => 'Merchant', 'action' => 'getcontacts','prefix' => 'merchant']);
$routes->connect('/merchant/listcontacts/*',['controller' => 'Merchant', 'action' => 'listcontacts','prefix' => 'merchant']);
$routes->connect('/merchant/setpassword/*',['controller' => 'Merchant', 'action' => 'setpassword','prefix' => 'merchant']);
$routes->connect('/merchant/resetnotify/*',['controller' => 'Merchant', 'action' => 'resetnotify','prefix' => 'merchant']);
$routes->connect('/merchant/notifications/*',['controller' => 'Merchant', 'action' => 'notifications','prefix' => 'merchant']);
$routes->connect('/merchant/language/*',['controller' => 'Merchant', 'action' => 'language','prefix' => 'merchant']);
$routes->connect('/merchant/checkcartitem/*',['controller' => 'Merchant', 'action' => 'checkcarthours','prefix' => 'merchant']);
$routes->connect('/merchant/checkcarteveryday/*',['controller' => 'Merchant', 'action' => 'checkcartdays','prefix' => 'merchant']);
$routes->connect('/merchant/checknewusername',['controller' => 'Merchant', 'action' => 'checknewusername','prefix' => 'merchant']);
$routes->connect('/merchant/checknewuseremail',['controller' => 'Merchant', 'action' => 'checknewuseremail','prefix' => 'merchant']);



$routes->connect('/add_data',['controller' => 'Itemsfaq', 'action' => 'sendfaqdata','prefix' => 'itemsfaq']);













$routes->connect('/setlanguageAdmin/*',['controller' => 'Admins','action' => 'setlanguages','prefix' => 'admins']);


$routes->connect('/merchant/*',['controller' => 'Merchant', 'action' => 'login','prefix' => 'merchant']);
    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

     Router::prefix('Admins',function($routes){
        $routes->fallbacks('InflectedRoute');
    });
    Router::prefix('Merchant',function($routes){
        $routes->fallbacks('InflectedRoute');
    });
     Router::prefix('Users',function($routes){
        $routes->fallbacks('InflectedRoute');
    });
/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
