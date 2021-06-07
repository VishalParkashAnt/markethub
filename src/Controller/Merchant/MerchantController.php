<?php
/** DEVELOPER : AK-ASATH
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\Merchant;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Component\UrlfriendlyComponent;
use Cake\Controller\Component\ColorCompareComponent;
use Cake\View\Helper\FlashHelper;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\I18n\I18n;

//use App\Model\Table\LanguagesTable;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class MerchantController extends AppController
{

        /**
         * Displays a view
         *
         * @param string ...$path Path segments.
         * @return void|\Cake\Network\Response
         * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
         * @throws \Cake\Network\Exception\NotFoundException When the view file could not
         *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.

        */
        public function initialize()
        {
            parent::initialize();

            //INTIALIZATION AND DECLARATION
            global $setngs, $loguser, $session, $siteChanges;
            $config = Router::url('/',true);
            define('MERCHANT_URL',$config."merchant");
            define('WEBROOTPATH',WWW_ROOT);

            //LOAD MODELS
            $this->loadModel('Sitesettings');
            $this->loadModel('Forexrates');
            $this->loadModel('Contactsellers');
            $this->loadModel('Users');
            $this->loadModel('Logs');

            //LOAD COMPONENTS
            $this->loadComponent('Urlfriendly');
            $this->loadComponent('ColorCompare');
            $this->loadComponent('Cookie', ['expires' => '1 day']);

            //DATA FETCH PROCESS
            $setngs = $this->Sitesettings->find()->first();
            $loguser = $this->Auth->user();
            $session = $this->request->session();

            $userLogData = $this->Users->find()->where(['id'=>$loguser['id']])->first();

            $type = array('follow','review','groupgift','admin','dispute','orderstatus','ordermessage','itemapprove','chatmessage','invite','credit','cartnotification','admin_commision');
            $recentlogs = $this->Logs->find()->where(['notifyto IN'=>array($loguser['id'],0), 'type IN'=>$type])->limit(5)->order(['cdate' => 'DESC'])->all();

            $this->set('recentlogs',$recentlogs);
            $this->set('userLogData',$userLogData);

            //SESSION PROCESS
            $messageCount = $this->Contactsellers->find()->where(['merchantid' => $loguser['id'], 'sellerread' => 1])->orwhere(['buyerid' => $loguser['id'], 'buyerread' => 1])->count();

            if (empty($_SESSION['currency_value'])){
                $forexrateModel = $this->Forexrates->find()->where(['cstatus'=>'default'])->first();

                $_SESSION['currency_symbol'] = $forexrateModel['currency_symbol'];
                $_SESSION['currency_value'] = $forexrateModel['price'];
                $_SESSION['currency_code'] = $forexrateModel['currency_code'];
                $_SESSION['default_currency_code'] = $forexrateModel['currency_code'];
                $_SESSION['default_currency_symbol'] = $forexrateModel['currency_symbol'];
            }
            $_SESSION['userMessageCount'] = $messageCount;
            $_SESSION['site_url'] = SITE_URL;
            $_SESSION['media_url'] = SITE_URL;

            if (!empty($setngs['media_url'])) {
                $_SESSION['media_host_name'] = $setngs['media_server_hostname'];
                $_SESSION['media_url'] = $setngs['media_url'];
                $_SESSION['media_server_username'] = $setngs['media_server_username'];
                $_SESSION['media_server_password'] = $setngs['media_server_password'];
            }
            //DATA SET
            $siteChanges = $setngs['site_changes'];
            $siteChanges = json_decode($siteChanges,true);
        }

        public function beforeFilter(Event $event)
        {
            parent::beforeFilter($event);
        }

        public function isauthorized()
        {
            $user =  $this->Auth->user();

            if ($user['user_level'] == 'god' || $user['user_level'] == 'moderator')
                return false;
            else
                return true;

        }


        public function index()
        {
            $this->viewBuilder()->setLayout('merchantlanding');
            $this->set('title_for_landing','Landing');
            if($this->isauthenticated()){
                    $this->redirect(['action' => 'dashboard']);
            }            
        }

        public function login()
        {
            $this->viewBuilder()->setLayout('merchant');
            $this->set('title_for_layout','Login');
            if($this->isauthenticated()){
                    $this->redirect(['action' => 'dashboard']);
            }
            if ($this->request->is('post')) {
                $email = trim($this->request->data['email']);
                $remember = trim($this->request->data['remember']);
                $password = trim($this->request->data['password']);

                $userdata = $this->Users->findByEmail($email)->first();

                if(count($userdata) > 0 && $userdata['user_status'] == "enable" && $userdata['user_level'] == "shop") {
                    $this->loadModel('Shops');
                    $shopdata = $this->Shops->findByUser_id($userdata['id'])->first();

                    if(count($shopdata) > 0 && $shopdata['seller_status'] == 1) {

                        if($remember == "1") {
                            $this->Cookie->delete('Merchant');
                            $cookie['email'] = $email;
                            $cookie['pass'] = base64_encode($password);
                            $this->Cookie->write('Merchant',$cookie,true,'+2 weeks');
                            $merchantcookieval = $this->Cookie->read('Merchant');
                        }

                        $user = $this->Auth->identify();
                        if ($user) {
                            $this->Auth->setUser($user);
                            $this->Flashmessage('success', 'Welcome '.$user['first_name']);
                            return $this->redirect($this->Auth->redirectUrl());
                        } else {
                        $this->Flashmessage('error', 'Try again');
                        }
                    } else if(count($shopdata) > 0 && $shopdata['seller_status']=='0') {
                    $this->Flashmessage('error', 'Please wait for admin approval', 'login');
                    $this->redirect('/merchant');
                    } else {
                        $this->Flashmessage('error', 'Email id or password is incorrect');
                    }
                } else {
                    $this->Flashmessage('error', 'Email id or password is incorrect');
                }
            }

        }

        public function logout()
        {
            $this->Cookie->delete('Merchant');
            $this->Flashmessage('success', 'Thanks, Welcome Back');
            return $this->redirect($this->Auth->logout());

        }

        public function Flashmessage($status = NULL, $message = NULL, $url = NULL)
        {
            if($status == 'success' && !empty($message)){
                $this->Flash->success(__d('merchant',$message));
            }else if ($status == 'error' && !empty($message)) {
                $this->Flash->error(__d('merchant',$message));
            }
            if(!empty($url))
                $this->redirect('/merchant/'.$url);

            return true;
        }

        public function signup()
        {
            $this->viewBuilder()->setLayout('merchant');
            $this->set('title_for_layout','Signup');

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Languages');
            $this->loadModel('Categories');
            $this->loadModel('Countries');
            $this->loadModel('Forexrates');
            $this->loadModel('Users');

            // AUTHENTICATION
            if($this->isauthenticated()){
                    $this->redirect(['action' => 'dashboard']);
            }

            //DATA FETCH PROCESS
            $language_datas=$this->Languages->find('all')->contain(['Countries']);
            $cat_datas = $this->Categories->find()->where(['category_parent'=> '0'])->andWhere(['category_sub_parent'=> '0'])->all();
            $countrylist = $this->Countries->find('all');

            //DATAS-TO-VIEW
            $this->set('language_datas',$language_datas);
            $this->set('cat_datas',$cat_datas);
            $this->set('countrylist',$countrylist);

            //DECLARATION & INITIALIZATION
            global $setngs, $session;
            $postalcodes = ''; $postal_code = ''; $prodcategory=''; $userid='';

            //POST-ACTION
            if($this->request->is('post')) {
                $articlesTable = TableRegistry::get('Users');

                $articleModel = $articlesTable->newEntity($this->request->getData(),['validate' => true]);

                if ($articleModel->errors()==false)
                {
                    //POST VALUES
                    $firstname = trim($this->request->data['firstname']);
                    $lastname = trim($this->request->data['lastname']);
                    $email = trim($this->request->data['email']);
                    $username = trim($this->request->data['username']);
                    $password = trim($this->request->data['password']);
                    $storeurl = trim($this->request->data['storeurl']);
                    $phonecountry = trim($this->request->data['storephonecode']);
                    $phonearea = trim($this->request->data['storephonearea']);
                    $phoneno = trim($this->request->data['storephoneno']);
                    $braintreeid = trim($this->request->data['braintreeid']);
                    $merchantid = trim($this->request->data['merchantid']);
                    $braintreepublickey = trim($this->request->data['braintreepublickey']);
                    $braintreeprivatekey = trim($this->request->data['braintreeprivatekey']);
                    $countryid = trim($this->request->data['countryid']);
                    if(empty($countryid))
                        $countryid = 0;
                    $freeamt = trim($this->request->data['freeamt']);
                    if(empty($freeamt))
                        $freeamt = 0;
                    $pricefree = trim($this->request->data['pricefree']);
                    $postalfree = trim($this->request->data['postalfree']);
                    $postal_codes = array_unique($this->request->data['postalcodes']);
                    $address1 = trim($this->request->data['address1']);
                    $address2 = trim($this->request->data['address2']);
                    $city = trim($this->request->data['city']);
                    $stateprovince = trim($this->request->data['statprov']);
                    $country = trim($this->request->data['country']);
                    $zipcode = trim($this->request->data['zipcode']);
                    $latitude = trim($this->request->data['latitude']);
                    $longitude = trim($this->request->data['longitude']);
                    $agree = trim($this->request->data['agree']);
                    $postal_code = array();
                    if(!empty($postal_codes))
                    {
                        foreach($postal_codes as $key => $postcodes)
                        {
                            if(!empty($postcodes))
                            {
                                $postal_code[] = $postcodes;
                            }
                        }
                        $postalcodes = json_encode($postal_code);
                    }

                    $languages = $this->Languages->find()->where(['countryid'=> $countryid])->first();
                    if(empty($languages['countrycode']))
                        $currency = "";
                    else
                        $currency = $languages['countrycode'];

                    $forexrate = $this->Forexrates->find()->where(['currency_code'=> $currency])->first();
                    if(empty($forexrate['currency_symbol']))
                        $currencysymbol = "";
                    else
                        $currencysymbol = $forexrate['currency_symbol'];

                    $addressarr = array($address1,$address2,$city,$stateprovince,$country,$zipcode);
                    $busiaddress = implode('~',$addressarr);

                    $phonenumbers = array($phonecountry,$phonearea,$phoneno);
                    $phoneadd = implode('-',$phonenumbers);

                //  $category = json_encode($prodcategory);

                    $nmecounts = $this->Users->find()->where(['username'=>$username])->count();
                    $emlcounts = $this->Users->find()->where(['email'=>$email])->count();
                    $useraccount = $this->Users->find()->where(['email'=>$email])->first();

                    if($useraccount['user_level'] == 'normal') {
                        $this->loadModel('Shops');    // Shop Model Loaded
                        $storeurlcount = $this->Shops->find()->where(['shop_name_url'=>$storeurl])->count();
                        if($storeurlcount > 0){
                            $this->Flashmessage('error', 'Store name already exists');
                        }
                        else
                        {
                            //Update User Data from 'normal' to 'shop'
                            $article = $articlesTable->get($useraccount['id']);
                            $article->username= $username;
                            $article->username_url = $urlname = $this->Urlfriendly->utils_makeUrlFriendly($username);
                            $article->first_name = $firstname;
                            $article->last_name = $lastname;
                            $article->email = $emailaddress = $email;
                            $article->user_level = 'shop';
                            $article->activation = '1';
                            $userResult = $articlesTable->save($article);
                            if(!empty($userResult))
                            {
                            $userid = $useraccount->id;
                            $shopexist = $this->Shops->find()->where(['user_id'=>$userid])->first();
                            $shopsTable = TableRegistry::get('Shops');
                            if(count($shopexist > 0)) {
                                $shoparticle = $shopsTable->get($shopexist['id']);
                            } else {
                                $shoparticle = $shopsTable->newEntity();
                            }
                                $shoparticle->user_id = $userid;
                                $shoparticle->shop_name = $storeurl;
                                $shoparticle->shop_name_url = $this->Urlfriendly->utils_makeUrlFriendly($storeurl);
                                $shoparticle->merchant_name = $username;
                                $shoparticle->seller_status = 0;
                                $shoparticle->phone_no = $phoneadd;
                                $shoparticle->shop_address = $busiaddress;
                                if(isset($braintreeid))
                                    $shoparticle->braintree_id = $braintreeid;
                                if(isset($braintreepublickey))
                                    $shoparticle->braintree_publickey = $braintreepublickey;
                                if(isset($braintreeprivatekey))
                                    $shoparticle->braintree_privatekey = $braintreeprivatekey;
                                if(isset($merchantid))
                                    $shoparticle->merchant_id = $merchantid;
                                $shoparticle->braintree_type = "sandbox";
                                $shoparticle->paytype = "braintree";
                                $shoparticle->country_id = $countryid;
                                $shoparticle->currency = $currency;
                                $shoparticle->currencysymbol = $currencysymbol;
                                $shoparticle->pricefree = $pricefree;
                                $shoparticle->postalfree = $postalfree;
                                $shoparticle->shop_latitude = $latitude;
                                $shoparticle->shop_longitude = $longitude;
                                if(!empty($freeamt))
                                    $shoparticle->freeamt = $freeamt;
                                else
                                    $shoparticle->freeamt = 0;
                                if(!empty($postal_code))
                                    $shoparticle->postalcodes = $postalcodes;
                                else
                                    $shoparticle->postalcodes = '';

                                $shopResult = $shopsTable->save($shoparticle);
                                if(!empty($shopResult)){
                                    $this->Flashmessage('success', 'Your account has been created, Please Wait for admin approval', 'login');
                                }
                                else{
                                    $this->Flashmessage('error','Try again');
                                }
                            }
                            else{
                                $this->Flashmessage('error', 'Try again');
                            }
                        }
                    }
                    else if($nmecounts > 0 && $emlcounts > 0){
                        $this->Flashmessage('error', 'Username and Email already exists');
                    }else if($nmecounts > 0){
                        $this->Flashmessage('error', 'Username already exists');
                    }else if($emlcounts > 0){
                        $this->Flashmessage('error', 'Email already exists');
                    } else {
                        $article = $articlesTable->newEntity();
                        $article->username= $username;
                        $article->username_url = $urlname = $this->Urlfriendly->utils_makeUrlFriendly($username);
                        $article->first_name = $firstname;
                        $article->last_name = $lastname;
                        $article->email = $emailaddress = $email;
                        $article->password = (new DefaultPasswordHasher)->hash($password);
                        $article->user_level = 'shop';

                        if ($setngs['signup_active'] == 'no') {
                            $article->activation = '1';
                            $article->user_status = 'enable';
                        } else {
                            $article->activation = '1';
                            $article->user_status = 'enable';
                        }
                        $article->created_at = date('Y-m-d H:i:s');
                        $refer_key = $article->refer_key = $this->Urlfriendly->get_uniquecode(8);
                        $userResult = $articlesTable->save($article);

                        if(!empty($userResult)){
                            $this->loadModel('Shops');    // Shop Model Loaded
                            $storeurlcount = $this->Shops->find()->where(['shop_name_url'=>$storeurl])->count();
                            if($storeurlcount > 0){
                                $this->Flashmessage('error', 'Store name already exists');
                                // Type Redirect if needed
                            } else {
                                $userid = $userResult->id;
                                $shopsTable = TableRegistry::get('Shops');
                                $shoparticle = $shopsTable->newEntity();

                                $shoparticle->user_id = $userid;
                                $shoparticle->shop_name = $storeurl;
                                $shoparticle->shop_name_url = $this->Urlfriendly->utils_makeUrlFriendly($storeurl);
                                $shoparticle->merchant_name = $username;
                                $shoparticle->seller_status = 0;
                                $shoparticle->phone_no = $phoneadd;
                                $shoparticle->shop_address = $busiaddress;
                                if(isset($braintreeid))
                                    $shoparticle->braintree_id = $braintreeid;
                                if(isset($braintreepublickey))
                                    $shoparticle->braintree_publickey = $braintreepublickey;
                                if(isset($braintreeprivatekey))
                                    $shoparticle->braintree_privatekey = $braintreeprivatekey;
                                if(isset($merchantid))
                                    $shoparticle->merchant_id = $merchantid;

                                $shoparticle->braintree_type = "sandbox";
                                $shoparticle->paytype = "braintree";
                                $shoparticle->country_id = $countryid;
                                $shoparticle->currency = $currency;
                                $shoparticle->currencysymbol = $currencysymbol;
                                $shoparticle->pricefree = $pricefree;
                                $shoparticle->postalfree = $postalfree;
                                $shoparticle->shop_latitude = $latitude;
                                $shoparticle->shop_longitude = $longitude;
                                if(!empty($freeamt))
                                    $shoparticle->freeamt = $freeamt;
                                else
                                    $shoparticle->freeamt = 0;
                                if(!empty($postal_code))
                                    $shoparticle->postalcodes = $postalcodes;
                                else
                                    $shoparticle->postalcodes = '';

                                $shopResult = $shopsTable->save($shoparticle);
                                if(!empty($shopResult)){
                                    $this->Flashmessage('success', 'Your account has been created, Please Wait for admin approval', 'login');
                                } else {
                                    $this->Flashmessage('error', 'Try again');
                                }
                            }
                        } else {
                            $this->Flashmessage('error', 'Try again');
                        }
                    }
                }
                else
                {
                    $this->Flashmessage('error', 'Try again', 'signup');
                }
            } else {
                //Clear session variables
            }
        }

        public function dashboard()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Dashboard');

            // AUTHENTICATION
            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Items');
            $this->loadModel('Orders');
            $this->loadModel('Shops');

            //DECLARATION & INITIALIZATION
            $tdy = date("Y-m-d");
            $ordercurrency = array();
            global $loguser;

            //DATA FETCH PROCESS
            $loguserlevel = $loguser['user_level'];
            $logadminmenus = $loguser['admin_menus'];
            $userid = $loguser['id'];

            $logshop = $this->Shops->find()->where(['user_id'=>$userid])->first();

            $currencysymbol = $logshop['currencysymbol'];
            $sellercurrency = $logshop['currency'];
            $abandoncart = $logshop['abandon_cart'];

            $this->set('loguserlevel',$loguserlevel);
            $this->set('logadminmenus',$logadminmenus);
            $this->set('currencysymbol',$currencysymbol);
            $this->set('abandoncart',$abandoncart);

            $tiswk_strt = date("Y-m-d",strtotime("this week last sunday"));
            $tiswk_end = date("Y-m-d",strtotime("this week next saturday"));

            $tismnth_strt = date("Y-m-d",strtotime('first day of this month'));
            $tismnth_end = date("Y-m-t",strtotime('this month'));

            $tdyjned = $this->Users->find()->where(['user_level IS NOT'=>'shop', 'created_at' => $tdy])->count();

            $week_usrs = $this->Users->find()->where(['user_level <>'=>'shop', 'created_at >='=>$tiswk_strt, 'created_at <='=>$tiswk_end])->count();

            $mnth_usrs = $this->Users->find()->where(['user_level <>'=>'shop', 'created_at >='=>$tismnth_strt, 'created_at <='=>$tismnth_end])->count();

            $user_datas = $this->Users->find()->where(['user_level <>'=>'shop'])->limit(5)->order('RAND()')->all();

            $disable_sellers = $this->Shops->find()->where(['seller_status'=>'0'])->count();
            $this->set('disable_sellers',$disable_sellers);

            $allOrderCost=$this->Orders->find()->where(['merchant_id' => $userid])->all();
            $total_complete_payment=0;
            $total_admin_commission=0;

            foreach ($allOrderCost as $key => $value) {
                # code...
                $orderPrice=$value->totalcost;
                $orderCurrency=$value->currency;

                $orderAdminComission=$value->admin_commission;

                $buyerCurrencyvalue = $this->Forexrates->find()->where(['currency_code'=>$orderCurrency])->first();
                $buyerCurrPrice=$buyerCurrencyvalue->price;

                $sellerCurrencyvalue = $this->Forexrates->find()->where(['currency_code'=>$sellercurrency])->first();
                $sellerCurrPrice=$sellerCurrencyvalue->price;

                $price=$this->Currency->conversion($buyerCurrPrice,$sellerCurrPrice,$orderPrice);
                $total_complete_payment+=$price;

                $adminCommisionPrice=$this->Currency->conversion($buyerCurrPrice,$sellerCurrPrice,$orderAdminComission);
                $total_admin_commission+=$adminCommisionPrice;  
            }  
        
            $total_revenue = $total_complete_payment - $total_admin_commission;

            $totOrderDelivered = $this->Orders->find()->where(['merchant_id'=>$userid])->andWhere(['status'=>'Delivered'])->toArray();
    
            $total_order_delivery=0;
            
            foreach ($totOrderDelivered as $key => $totOrderDelivers) {
                # code...
                $orderPrice=$totOrderDelivers->totalcost;
                $orderCurrency=$totOrderDelivers->currency;

                

                $buyerCurrencyvalue = $this->Forexrates->find()->where(['currency_code'=>$orderCurrency])->first();
                $buyerCurrPrice=$buyerCurrencyvalue->price;

                $sellerCurrencyvalue = $this->Forexrates->find()->where(['currency_code'=>$sellercurrency])->first();
                $sellerCurrPrice=$sellerCurrencyvalue->price;

                $price=$this->Currency->conversion($buyerCurrPrice,$sellerCurrPrice,$orderPrice);
            
                $total_order_delivery+=$price;
            }
        
            $totOrderPaid = $this->Orders->find()->where(['merchant_id'=>$userid])->andWhere(['status'=>'Paid'])->toArray();
            
            $total_order_paid=0;
            foreach ($totOrderPaid as $key => $totOrderPaided) {
                # code...
                $orderPrice=$totOrderPaided->totalcost;
                $orderCurrency=$totOrderPaided->currency;

                $buyerCurrencyvalue = $this->Forexrates->find()->where(['currency_code'=>$orderCurrency])->first();
                $buyerCurrPrice=$buyerCurrencyvalue->price;

                $sellerCurrencyvalue = $this->Forexrates->find()->where(['currency_code'=>$sellercurrency])->first();
                $sellerCurrPrice=$sellerCurrencyvalue->price;

                $price=$this->Currency->conversion($buyerCurrPrice,$sellerCurrPrice,$orderPrice);
                $total_order_paid+=$price;
            }
            /* new changes */
            $user_datas_payment = $this->Orders->find()->limit(5)->order(['orderid' => 'DESC'])->all();

            $todaystart = date('Y-m-d 00:00:00');
            $todayend = date('Y-m-d 24:00:00');
            $todaystartdate = strtotime($todaystart);
            $todayenddate = strtotime($todayend);

            $today_new_orders_count = $this->Orders->find()->where(['merchant_id'=>$userid, function ($exp, $q) use ($todaystartdate, $todayenddate){ return $exp->between('orderdate', $todaystartdate, $todayenddate); }])->andwhere(['status'=>'Pending'])->count();

            $today_delivered_orders_count = $this->Orders->find()->where(['merchant_id'=>$userid, function ($exp, $q) use ($todaystartdate, $todayenddate){ return $exp->between('orderdate', $todaystartdate, $todayenddate); }, 'status'=>'Delivered'])->count();

            $this->set('today_new_orders_count',$today_new_orders_count);
            $this->set('today_delivered_orders_count',$today_delivered_orders_count);

            $orderdetails = $this->Orders->find()->where(['merchant_id' => $userid, 'status IN'=>array('Shipped','Processing')])->limit(10)->all();

            foreach($orderdetails as $orders)
            {
                $orderid = $orders['orderid'];
                $currency_code = $orders['currency'];
                $forexrate = $this->Forexrates->find()->where(['currency_code'=> $currency_code])->first();
                $ordercurrency[$orderid] = $forexrate['currency_symbol'];
            }

            $this->set('orderdetails',$orderdetails);
            $this->set('ordercurrency',$ordercurrency);

            $total_items = $this->Items->find()->where(['Items.user_id'=>$userid])->count();

            $enbleitems = $this->Items->find()->where(['status' => 'publish', 'Items.user_id'=>$userid])->count();

            $disbleitems = $this->Items->find()->where(['status' => 'draft', 'Items.user_id'=>$userid])->count();

            $tdyadded_items = $this->Items->find()->where(['Items.created_on'=> $tdy])->count();

            $week_items = $this->Items->find()->where(['Items.created_on >=' => $tiswk_strt, 'Items.created_on <='=>$tiswk_end])->count();

            $mnth_items = $this->Items->find()->where(['Items.created_on >=' => $tismnth_strt, 'Items.created_on <=' => $tismnth_end])->count();

            $fetch_merchant_items = $this->Items->find()->where(['user_id' => $userid])->all();

            foreach($fetch_merchant_items as $items)
            {
                if($items['size_options']!="") {
                $size_option = json_decode($items['size_options'], true);
                foreach($size_option['size'] as $key=>$val) {
                    if($size_option['unit'][$key] > 0)
                        $item_values += $size_option['price'][$key];
                }
                } else {
                if($items['quantity'] > 0)
                    $item_values += $items['price'];
                }   
            }


            $this->set('total_merchandize_value',$item_values);
            $this->set('tdyjned',$tdyjned);
            $this->set('week_usrs',$week_usrs);
            $this->set('mnth_usrs',$mnth_usrs);
            $this->set('user_datas',$user_datas);
            $this->set('user_datas_payment',$user_datas_payment);
            $this->set('total_revenue',$total_revenue);

            $this->set('total_order_paid',$total_order_paid);
            $this->set('total_order_delivery',$total_order_delivery);
            $this->set('total_complete_payment',$total_complete_payment);
            $this->set('total_admin_commission',$total_admin_commission);
            $this->set('total_items',$total_items);
            $this->set('tdyadded_items',$tdyadded_items);
            $this->set('enableitems',$enbleitems);
            $this->set('disbleitems',$disbleitems);
            $this->set('week_items',$week_items);
            $this->set('mnth_items',$mnth_items);
        }

        public function messages()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Messages');

            // AUTHENTICATION
            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Contactsellers');
            $this->loadModel('Users');

            //DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $messageModel = array();
            $messageUnread = array();

            //DATA FETCH PROCESS
            $contactsellersModel = $this->Contactsellers->find()->where(['merchantid' => $userid])->orwhere(['buyerid' => $userid])->order(['lastmodified' => 'DESC'])->limit(10)->all();

            //DATA SET PROCESS
            foreach ($contactsellersModel as $cskey => $contactsellers){
                $modelid = $contactsellers->id;
                $sellerid = $contactsellers->merchantid;
                $buyerid = $contactsellers->buyerid;

                $sellerData = $this->Users->findById($sellerid)->first();
                $buyerData = $this->Users->findById($buyerid)->first();

                $messageModel[$cskey]['csid'] = $modelid;
                $messageModel[$cskey]['subject'] = $contactsellers->subject;
                $messageModel[$cskey]['item'] = $contactsellers->itemname;
                $messageModel[$cskey]['itemurl'] = $this->Urlfriendly->utils_makeUrlFriendly($contactsellers->itemname);
                $messageModel[$cskey]['itemid'] = $contactsellers->itemid;

                if ($contactsellers['lastsent'] == 'buyer'){
                    $messageModel[$cskey]['from'] = $buyerData->first_name;
                    $messageModel[$cskey]['to'] = $sellerData->first_name;
                }else{
                    $messageModel[$cskey]['from'] = $sellerData->first_name;
                    $messageModel[$cskey]['to'] = $buyerData->first_name;
                }

                if ($buyerid == $userid && $contactsellers->buyerread == '1'){
                    $messageModel[$cskey]['unread'] = 1;
                    $messageUnread[] = $cskey;
                }elseif ($contactsellers->sellerread == '1' && $sellerid == $userid){
                    $messageModel[$cskey]['unread'] = 1;
                    $messageUnread[] = $cskey;
                }else{
                    $messageModel[$cskey]['unread'] = 0;
                }

            }

            //DATAS-TO-VIEW
            $this->set('first_name',$first_name);
            $this->set('messageModel',$messageModel);
            $this->set('messageUnread',$messageUnread);
            $this->set('counts',count($messageModel));
        }

        public function news()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','News');

            // AUTHENTICATION
            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Logs');
            $this->loadModel('Users');

            //DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];

            //DATA PROCESS
            $postmessage = $this->Logs->find()->where(['userid' => $userid, 'type' => 'sellermessage', 'notifyto' => 0])->order(['id' => 'DESC'])->all();
    
            //DATAS-TO-VIEW
            $this->set('postmessage',$postmessage);
        }

        public function paymentsettings()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Payment Settings');

            //AUTHENTICATION
            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Shops');
            $this->loadModel('Countries');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];
            $country_datas = array();

            // DATA FETCH PROCESS
            $shop_datas = $this->Shops->find()->where(['user_id'=>$userid])->first();

            if(!empty($shop_datas['country_id']) && $shop_datas['country_id'] > 0 ) {
                $country_datas = $this->Countries->find()->where(['id'=>$shop_datas['country_id']])->first();
            }

            //DATA TO VIEW
            $this->set('shop_datas',$shop_datas);
            $this->set('country_datas',$country_datas);

            //POST
            if($this->request->is('post')) {
                $shopsTable = TableRegistry::get('Shops');
                $shopsModel = $shopsTable->newEntity($this->request->getData(),['validate' => true]);
                if($shopsModel->errors()==false)
                {
                    $shopsarticle = $shopsTable->get($shop_datas['id']);

                    $shopsarticle->braintree_id = $this->request->data['braintreeid'];
                    $shopsarticle->braintree_publickey = $this->request->data['publickey'];
                    $shopsarticle->braintree_privatekey = $this->request->data['privatekey'];
                      $shopsarticle->merchant_id = $this->request->data['merchantid'];
                    $shopsarticle->braintree_type = "sandbox";
                    $shopsarticle->paytype = "braintree";
                    $shopsResult = $shopsTable->save($shopsarticle);

                    if(!empty($shopsResult)) {
                        $message = "Payment settings Updated successfully";
                        $this->Flashmessage('success', $message, 'paymentsettings');
                    } else {
                        $this->Flashmessage('error', 'Try again', 'paymentsettings');
                    }
                }
                else
                    $this->Flashmessage('error', 'Try again', 'paymentsettings');

            }

        }

        public function paymenthistory($sdate = NULL , $edate = NULL)
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Payment History');

            //AUTHENTICATION
            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }
            if($sdate > $edate)
            $this->Flashmessage('error', 'Error in search date','paymenthistory');

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Users');
            $this->loadModel('Orders');
            $this->loadModel('Invoices');
            $this->loadModel('Invoiceorders');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];
            $payment = array();

            // DATA FETCH PROCESS
            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $order_datas = $this->Orders->find()->where(['merchant_id'=>$userid, 'status'=> 'Paid'])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $order_datas = $this->Orders->find()->where(['merchant_id'=>$userid, 'status'=>'Paid'])->all();
            }
            $userdatas = $this->Users->findById($userid)->contain(['Shops'])->first();

            $sellerpaytype= strtolower($userdatas['shop']['paytype']);
            if($sellerpaytype == 'braintree')
                $paymentmethod = "Braintree";
            else
                $paymentmethod = "";

            // DATA SET PROCESS
            foreach($order_datas as $key => $orders)
            {
                $orderid = $orders['orderid'];
                $payment['Orders'][$key]['orderid'] = $orderid;
                $payment['Orders'][$key]['Date'] = date('m/d/Y',$orders['orderdate']);
                $payment['Orders'][$key]['totalcost'] = $orders['totalcost'] - $orders['admin_commission'];

                $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=>$orderid])->first();
                $invoiceid = $invoiceorders['invoiceid'];

                $invoice_datas = $this->Invoices->find()->where(['Invoiceid'=>$invoiceid])->first();
                $payment['Orders'][$key]['transactionid'] = $invoice_datas['paypaltransactionid'];
                $payment['Orders'][$key]['paymentmethod'] = $invoice_datas['paymentmethod'];
                $payment['Orders'][$key]['status'] = $invoice_datas['invoicestatus'];
            }
            //DATA TO VIEW
            $this->set('payment',$payment);

        }


        public function cartdetails()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Manage Cart Details');

            global $loguser;
            $everyday = date('Y-m-d H:i:s', strtotime('-2 minutes'));

            $this->loadModel('Items');
            $this->loadModel('Carts');
            $this->loadModel('Shops');
            $this->loadModel('Users');

            $cartdetail = array();
            $cartUser = array();
            $username = array();

            $cartUsers = $this->Carts->find()->hydrate(false)->join([
                'table' => 'fc_items',
                'alias' => 'a',
                'type' => 'LEFT',
                'conditions' => 'Carts.item_id = a.id'
            ])->autoFields(true)->where(['a.user_id' => $loguser['id'], 'payment_status'=>'progress', 'created_at <='=>$everyday])->order(['Carts.id' => 'DESC'])->group('Carts.user_id')->toArray();

            $i = 0;
            if(count($cartUsers)>0)
            {
                foreach($cartUsers as $cart)
                {
                    $userid = $cart['user_id'];
                    $itemid = $cart['item_id'];

                    $cartUser = $this->Carts->find()->hydrate(false)->join([
                        'table' => 'fc_items',
                        'alias' => 'd',
                        'type' => 'left',
                        'conditions'=> 'Carts.item_id = d.id'
                    ])->autoFields(true)->where(['d.user_id' => $loguser['id'], 'payment_status'=>'progress', 'Carts.user_id'=>$userid, 'created_at <='=>$everyday])->order(['Carts.id' => 'DESC'])->toArray();
                    if(count($cartUser)>0)
                    {
                        foreach($cartUser as $cartitems)
                        {
                            $userdata = $this->Users->findById($userid)->toArray();
                            $username[$userid]['username'] = $userdata[0]['username'];
                            $username[$userid]['email'] = $userdata[0]['email'];
                            $itemdata = $this->Items->find()->where(['id'=>$itemid])->first();
                            $cartdetail[$userid][$i]['itemid'] = $itemid;
                            $cartdetail[$userid][$i]['itemname'] = $itemdata['item_title'];
                            $cartdetail[$userid][$i]['quantity'] = $cartitems['quantity'];
                            $cartdetail[$userid][$i]['createdat'] = $cartitems['created_at'];
                            $i++;
                        }
                    }
                }
            }
            //DATA TO VIEW
            $this->set('cartdetail',$cartdetail);
            $this->set('cartUser',$cartUser);
            $this->set('cartUsers',$cartUsers);
            $this->set('username',$username);
        }

        public function addcartcoupon($id = NULL)
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Add Cart Coupon');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];
            $couponval = "";

            // DATA FETCH PROCESS
            $seller_coupon = $this->Sellercoupons->find()->where(['id'=>$id])->first();

            //POST
            if($this->request->is('post')) {
                if(empty($id))
                {
                    $code = trim($this->request->data['code']);
                    $couponval = $this->Sellercoupons->find()->where(['couponcode' => $code])->first();
                }

                if(empty($couponval))
                {
                    $couponsTable = TableRegistry::get('Sellercoupons');
                    $couponcode = $seller_coupon['couponcode'];
                    if(!empty($couponcode)) {
                        $coupondatas = $this->Sellercoupons->find()->where(['couponcode'=>$couponcode])->first();
                        $couponarticle = $couponsTable->get($coupondatas['id']);
                        $couponarticle->couponcode = $couponcode;
                    } else {
                        $couponarticle = $couponsTable->newEntity();
                        $couponarticle->couponcode = trim($this->request->data['code']);
                    }

                    $couponarticle->type = "cart";
                    $couponarticle->sourceid = '0';
                    $couponarticle->sellerid = $userid;
                    $couponarticle->couponpercentage = $this->request->data['amount'];
                    $couponarticle->totalrange = $this->request->data['range'];
                    $couponarticle->remainrange = $this->request->data['range'];
                    $couponarticle->validfrom = $this->request->data['fromdate'];
                    $couponarticle->validto = $this->request->data['enddate'];

                    $couponResult = $couponsTable->save($couponarticle);
                    if(!empty($couponResult)) {
                        if(!empty($id))
                            $message = "Coupon updated successfully";
                        else
                            $message = "Coupon added successfully";
                        $this->Flashmessage('success', $message, 'cartcoupons');
                        //cartcoupons
                    } else {
                        $redirect = "cartcoupons/".$id;
                        if(!empty($id))
                            $this->Flashmessage('error', 'Try again',$redirect);
                        else
                            $this->Flashmessage('error', 'Try again','addcartcoupon');
                    }
                }
                else
                    $this->Flashmessage('error', 'Coupon Code Already Exists');
            }

            //DATA TO VIEW
            $this->set('sellercoupon',$seller_coupon);
            $this->set('id',$id);

        }

        public function generatecoupons()
        {
            $generatevalue = $this->Urlfriendly->get_uniquecode('8');
            echo $generatevalue;
            $this->autoRender = false ;
        }
        public function itemcoupons()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Item Coupons');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];

            // DATA FETCH PROCESS
            $seller_coupon = $this->Sellercoupons->find()->contain(['Items'])->where(['Sellercoupons.type'=>'item','Sellercoupons.sellerid'=>$userid])->order(['Sellercoupons.id' => 'DESC'])->all();

            //DATA TO VIEW
            $this->set('getcouponval',$seller_coupon);
        }

        public function deletecoupon()
        {
            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');
            $id = $_REQUEST['id'];

            if(!empty($id))
            {
                $entity = $this->Sellercoupons->get($id);
                $result = $this->Sellercoupons->delete($entity);
            }
            echo 0;
            die;
        }

        public function additemcoupon($id)
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Add Item Coupon');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');
            $this->loadModel('Items');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];
            $couponval = "";

            // DATA FETCH PROCESS
            $useritems = $this->Items->find()->where(['id'=>$id, 'user_id'=>$userid])->all();

            if(count($useritems) <= 0) {
                $this->Flashmessage('error',"No Item Found");
                $this->redirect('/merchant/itemcoupons');
            }

            $seller_coupon = $this->Sellercoupons->find()->where(['sourceid'=>$id, 'type' => 'item'])->first();

            //POST
            if($this->request->is('post')) {
                if(empty($id))
                {
                    $code = trim($this->request->data['code']);
                    $couponval = $this->Sellercoupons->find()->where(['couponcode' => $code])->first();
                }

                if(empty($couponval))
                {
                    $couponsTable = TableRegistry::get('Sellercoupons');
                    $couponcode = $seller_coupon['couponcode'];
                    if(!empty($couponcode)) {
                        $coupondatas = $this->Sellercoupons->find()->where(['couponcode'=>$couponcode])->first();
                        $couponarticle = $couponsTable->get($coupondatas['id']);
                        $couponarticle->couponcode = $couponcode;
                    } else {
                        $couponarticle = $couponsTable->newEntity();
                        $couponarticle->couponcode = trim($this->request->data['code']);
                    }

                    $couponarticle->type = "item";
                    $couponarticle->sourceid = $id;
                    $couponarticle->sellerid = $userid;
                    $couponarticle->couponpercentage = $this->request->data['amount'];
                    $couponarticle->totalrange = $this->request->data['range'];
                    $couponarticle->remainrange = $this->request->data['range'];
                    $couponarticle->validfrom = $this->request->data['fromdate'];
                    $couponarticle->validto = $this->request->data['enddate'];

                    $couponResult = $couponsTable->save($couponarticle);
                    if(!empty($couponResult)) {
                        if(!empty($id))
                            $message = "Coupon updated successfully";
                        else
                            $message = "Coupon added successfully";
                        $this->Flashmessage('success', $message, 'itemcoupons');
                        //cartcoupons
                    } else {
                        $redirect = "itemcoupons/".$id;
                        if(!empty($id))
                            $this->Flashmessage('error', 'Try again',$redirect);
                        else
                            $this->Flashmessage('error', 'Try again','addcartcoupon');
                    }
                }
                else
                    $this->Flashmessage('error', 'Coupon Code Already Exists');
            }

            //DATA TO VIEW
            $this->set('sellercoupon',$seller_coupon);
            $this->set('id',$id);
        }

        public function cartcoupons()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Cart Coupons');
            $this->set('menu_highlight','couponactive');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];

            // DATA FETCH PROCESS
            $seller_coupon = $this->Sellercoupons->find()->where(['type'=>'cart','sellerid'=>$userid])->order(['id' => 'DESC'])->all();

            //DATA TO VIEW
            $this->set('getcouponval',$seller_coupon);
        }

        public function categorycoupons()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Category Coupons');
            $this->set('menu_highlight','couponactive');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];
            $todaydate=date('m/d/Y');

            // DATA FETCH PROCESS
            $seller_coupon = $this->Sellercoupons->find()->contain(['Categories'])->where(['type'=>'category','sellerid'=>$userid])->order(['Sellercoupons.id' => 'DESC'])->all();

            //DATA TO VIEW
            $this->set('getcouponval',$seller_coupon);

        }

        public function addcategorycoupon()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Add Category Coupon');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');
            $this->loadModel('Items');
            $this->loadModel('Categories');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];
            $categ_datas = array();

            // DATA FETCH PROCESS
            $item_datas = $this->Items->find()->where(['user_id'=>$userid])->all();

            if(count($item_datas) <= 0) {
                $this->Flashmessage('error', 'Please add products to generate category coupon');
                $this->redirect('/merchant/addproducts');
            } else {
            foreach($item_datas as $items)
            {
                $categids[] = $items['category_id'];
            }
            $categ_datas = $this->Categories->find()->where(['id IN'=>$categids])->all();
            }
            
            //POST
            if($this->request->is('post')) {
                $sourceid = trim($this->request->data['sourceid']);
                $type = "category";
                $couponcode = trim($this->request->data['code']);
                $todaydate = date('m/d/Y');

                $coupondata = $this->Sellercoupons->find()->where(['sourceid'=>$sourceid])->andWhere(['type'=>$type])->andWhere(['sellerid'=>$userid])->andWhere(['validto >=' => $todaydate])->all();

            //   print_r($coupondata);exit;

                $couponcodedata = $this->Sellercoupons->find()->where(['couponcode'=>$couponcode])->all();



                if(count($coupondata) > 0)
                {
                    $this->Flashmessage('error', 'Coupon already added to this category','addcategorycoupon');
                } else if(count($couponcodedata) > 0) {
                    $this->Flashmessage('error', 'Coupon code already exists','addcategorycoupon');
                } else {

                    $couponsTable = TableRegistry::get('Sellercoupons');

                    $couponarticle = $couponsTable->newEntity();

                    $couponarticle->couponcode = trim($this->request->data['code']);
                    $couponarticle->type = "category";
                    $couponarticle->sourceid = trim($this->request->data['sourceid']);
                    $couponarticle->sellerid = $userid;
                    $couponarticle->couponpercentage = trim($this->request->data['amount']);
                    $couponarticle->totalrange = trim($this->request->data['range']);

                    $couponarticle->remainrange = trim($this->request->data['range']);

                    $couponarticle->validfrom = trim($this->request->data['fromdate']);
                    $couponarticle->validto = trim($this->request->data['enddate']);

                    $couponResult = $couponsTable->save($couponarticle);

                    if(!empty($couponResult)) {
                        $this->Flashmessage('success', 'Coupon added to this category','categorycoupons');
                    } else {
                        $this->Flashmessage('error', 'Try again', 'addcategorycoupon');
                    }
                }
            }
            //DATA TO VIEW
            $this->set('categ_datas',$categ_datas);

        }

        public function editcategorycoupon($id)
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Add Category Coupon');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Sellercoupons');
            $this->loadModel('Items');
            $this->loadModel('Categories');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];

            // DATA FETCH PROCESS
            $item_datas = $this->Items->find()->where(['user_id'=>$userid])->all();

            foreach($item_datas as $items)
            {
                $categids[] = $items['category_id'];
            }
            $categ_datas=$this->Categories->find()->where(['id IN'=>$categids])->all();

            $coupons = $this->Sellercoupons->find()->where(['id'=>$id])->first();

            //POST
            if($this->request->is('post')) {
                $categid = trim($this->request->data['sourceid']);

                $coupondata = $this->Sellercoupons->find()->where(['sourceid'=>$categid,'id IS NOT'=>$id,'sellerid'=>$userid])->all();

                if(empty($coupondata))
                {
                    $this->Flashmessage('error', 'Coupon already added to this category','categorycoupons');
                }
                else
                {
                    $couponsTable = TableRegistry::get('Sellercoupons');

                    $couponarticle = $couponsTable->get($id);

                    $couponarticle->couponcode = $coupons['couponcode'];
                    $couponarticle->type = "category";
                    $couponarticle->sourceid = trim($this->request->data['sourceid']);
                    $couponarticle->sellerid = $userid;
                    $couponarticle->couponpercentage = trim($this->request->data['amount']);
                    $couponarticle->totalrange = trim($this->request->data['range']);

                    $couponarticle->remainrange = trim($this->request->data['range']);

                    $couponarticle->validfrom = trim($this->request->data['fromdate']);
                    $couponarticle->validto = trim($this->request->data['enddate']);

                    $couponResult = $couponsTable->save($couponarticle);

                    if(!empty($couponResult)) {
                        $this->Flashmessage('success', 'Coupon updated to this category','categorycoupons');
                    } else {
                        $this->Flashmessage('error', 'Try again', 'categorycoupons');
                    }
                }

            }
            //DATA TO VIEW
            $this->set('categ_datas',$categ_datas);
            $this->set('sellercoupon',$coupons);
            $this->set('id',$id);
        }

        public function addnews()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Add Category Coupon');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }
        }

        public function getcontacts()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Newsletter');

            if(!$this->isauthenticated()) {
                    $this->redirect(['action' => 'login']);
            }

            global $loguser;
            $userid = $loguser['id'];
            $this->loadModel('Shops');
            $shop_datas = $this->Shops->find()->where(['Shops.user_id'=>$userid])->first();

            $apiKey = trim($shop_datas['news_key']);

            if(empty($apiKey)) {
                $this->Flashmessage('error',"Please Add Mail Chimp API Key");
                $this->redirect('/merchant/managenewsletter');
            }

            $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists';

            // send a HTTP POST request with curl
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $res = json_decode($result, true);

            $this->set('shop_datas',$shop_datas);
            $this->set('result',$res['lists']);
        }

        public function listcontacts()
        {
            if(!$this->isauthenticated()) {
                    $this->redirect(['action' => 'login']);
            }

            global $loguser;
            $userid = $loguser['id'];
            $this->loadModel('Shops');
            $shop_datas = $this->Shops->find()->where(['Shops.user_id'=>$userid])->first();

            $apiKey = trim($shop_datas['news_key']);
            $listID = $_POST['Listid'];

            $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members';

            // send a HTTP POST request with curl
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $res = json_decode($result, true);
            $this->set('result',$res['members']);

        }

        public function managenewsletter()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Newsletter');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            global $loguser;
            $userid = $loguser['id'];
            $this->loadModel('Shops');

            if($this->request->is('post')) {
                $newskey = trim($this->request->data['apikey']);

                $shopsTable = TableRegistry::get('Shops');
                $query = $shopsTable->query();
                $query->update()->set(['news_key' => $newskey])->where(['user_id'=>$userid])->execute();

                $this->Flashmessage('success', "Newsletter Key saved successfully");
                $this->redirect('/merchant/managenewsletter');
            }

            $shop_datas = $this->Shops->find()->where(['Shops.user_id'=>$userid])->first();
            $this->set('shop_datas',$shop_datas);

        }

        public function newsletter()
        {
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Newsletter');

            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Shops');

            // DECLARATION & INITIALIZATION
            global $loguser;
            $userid = $loguser['id'];

            // DATA FETCH PROCESS
            $shop_datas = $this->Shops->find()->where(['user_id'=>$userid])->first();

            $apiKey = trim($shop_datas['news_key']);

            if(empty($apiKey)) {
                $this->Flashmessage('error',"Please Add Mail Chimp API Key");
                $this->redirect('/merchant/managenewsletter');
            }

            if($this->request->is('post')) {
                $list_id = trim($this->request->data['listname']);
                $subject = trim($this->request->data['subject']);
                $messages = trim($this->request->data['message']);

                $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
                $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members';

                // send a HTTP POST request with curl
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $res = json_decode($result, true);
                if(count($res['members']) > 0)
                {
                $campaign_id = $this->isa_create_mailchimp_campaign($list_id, $subject);

                if($campaign_id) {
                    // Set the content for this campaign
                    $template_content = json_encode([
                    'plain_text' => 'welcome baby ',
                    'html'      => '<div style="color:red; text-align:center;">WELCOME TO HITASOFT, MADURAI</div><div style="margin-top:20px; text-align:center;">'.$messages.'</div>'
                    ]);

                    $set_campaign_content = $this->isa_set_mail_campaign_content($campaign_id, $template_content);

                    if(!empty($set_campaign_content)) {
                        $send_campaign = $this->isa_mailchimp_api_request( "campaigns/$campaign_id/actions/send", 'POST' );

                        if (empty($send_campaign)) {
                            $this->Flashmessage('success', "Newsletter Send Successfully");
                            $this->redirect('/merchant/newsletter');
                        } else {
                            $this->Flashmessage('error', "Try again");
                            $this->redirect('/merchant/newsletter');
                        }
                    } else {
                        $this->Flashmessage('error', "Try again");
                        $this->redirect('/merchant/newsletter');
                    }
                } else {
                    $this->Flashmessage('error',"Try again");
                    $this->redirect('/merchant/newsletter');
                }
                } else {
                $this->Flashmessage('error',"Please add members to the list");
                $this->redirect('/merchant/newsletter');
                }

            }

            $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists';

            // send a HTTP POST request with curl
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $res = json_decode($result, true);

            // DATA TO VIEW
            $this->set('shop_datas',$shop_datas);
            $this->set('result',$res['lists']);
    }

    public function isa_mailchimp_api_request( $endpoint, $type = 'POST', $body = '' ) {

        $this->autoRender = false;
        if(!$this->isauthenticated()) {
                    $this->redirect(['action' => 'login']);
        }

        // INITIALIZE DATABASE MODELS HERE.
        $this->loadModel('Shops');

        // DECLARATION & INITIALIZATION
        global $loguser;
        $userid = $loguser['id'];

        // DATA FETCH PROCESS
        $shop_datas = $this->Shops->find()->where(['user_id'=>$userid])->first();

        $apiKey = trim($shop_datas['news_key']);

        $core_api_endpoint = 'https://<dc>.api.mailchimp.com/3.0/';
        list(, $datacenter) = explode( '-', $apiKey );
        $core_api_endpoint = str_replace( '<dc>', $datacenter, $core_api_endpoint );

        $url = $core_api_endpoint . $endpoint;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response = json_decode($result, true);

        return $response;
    }

    public function isa_create_mailchimp_campaign( $list_id, $subject ) {
        $this->autoRender = false;
        if(!$this->isauthenticated()) {
                    $this->redirect(['action' => 'login']);
        }

        // DECLARATION & INITIALIZATION
        global $loguser;
        $userid = $loguser['id'];

        // DATA FETCH PROCESS

        $reply_to   = $loguser['email'];
        $from_name  = $loguser['username'];
        $campaign_id = '';

        $body = json_encode([
            'recipients'    => array('list_id' => $list_id),
            'type'          => 'regular',
            'settings'      => array('subject_line' => $subject,
                                    'preview_text' => 'Welcome',
                                    'reply_to'      => $reply_to,
                                    'from_name'     => $from_name
                                    )
        ]);

        $create_campaign = $this->isa_mailchimp_api_request( 'campaigns', 'POST', $body );

        if ( $create_campaign ) {
            if ( ! empty( $create_campaign['id'] ) && isset( $create_campaign['status'] ) && 'save' == $create_campaign['status'] ) {
                // The campaign id:
                $campaign_id = $create_campaign['id'];
            }
        }

        return $campaign_id ? $campaign_id : false;

    }

    public function isa_set_mail_campaign_content($campaign_id, $template_content) {
        $this->autoRender = false;
        if(!$this->isauthenticated()) {
                    $this->redirect(['action' => 'login']);
        }
        $set_content = '';
        $set_campaign_content = $this->isa_mailchimp_api_request( "campaigns/$campaign_id/content", 'PUT', $template_content );

        if ( $set_campaign_content ) {
            if ( ! empty( $set_campaign_content['html'] ) ) {
                $set_content = true;
            }
        }
        return $set_content ? true : false;
    }

        public function sellerpost()
        {
            if(!$this->isauthenticated()){
                    $this->redirect(['action' => 'login']);
            }

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Followers');
            $this->loadModel('Storefollowers');
            $this->loadModel('Logs');
            $this->loadModel('Shops');

            // DECLARATION & INITIALIZATION
            global $loguser, $setngs;
            $logusrid = $loguser['id'];
            $logusername = $loguser['username'];

            $userModel = $this->Shops->find()->where(['user_id' => $logusrid])->first();

            if($this->request->is('post')) {
                $messagess = trim($this->request->data['message']);

                if(!empty($messagess)) {
                $flwrscnt = $this->Followers->sellerflwrscnt($logusrid);
                if(!empty($flwrscnt)){
                    foreach($flwrscnt as $flwss){
                        $flwrusrids[$flwss['follow_user_id']] = $flwss['follow_user_id'];
                    }
                }
                $storeflwrscnt = $this->Storefollowers->sellerflwrscnt($userModel['id']);

                $storeflwrusrids = array();
                if(!empty($storeflwrscnt)){
                    foreach($storeflwrscnt as $storeflwss){
                        $storeflwrusrids[$storeflwss['follow_user_id']] = $storeflwss['follow_user_id'];
                    }
                }
                if(empty($flwrusrids)) {
                    $flwrusrids = array();
                }
                if(empty($storeflwrusrids)) {
                    $storeflwrusrids = array();
                }

                $flwssuserids = array_merge($storeflwrusrids, $flwrusrids);
                $flwssuserids = array_unique($flwssuserids);

                if (!empty($flwssuserids)) {

                    $logusername = $loguser['username'];
                    $logfirstname = $loguser['first_name'];
                    $logusernameurl = $loguser['username_url'];
                    $userImg = $loguser['profile_image'];
                    if (empty($userImg)){
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL."people/".$logusernameurl;
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logfirstname."</a>";
                    $notifymsg = "Seller -___-".$loguserlink."-___- posted a news";
                    $logdetails = $this->addlog('sellermessage',$logusrid,0,0,$notifymsg,$messagess,$loguserimage);

                    $this->loadModel('Userdevices');
                    $userdevicetable = TableRegistry::get('Userdevices');
                    $query = $userdevicetable->query();
                    foreach($flwssuserids as $flwww) {
                        $logdetails = $this->addlog('sellermessage',$logusrid,$flwww,0,$notifymsg,$messagess,$loguserimage);
                        $userddetts = $this->Userdevices->findAllByUser_id($flwww)->all();
                        if(count($userddetts) > 0) {
                            foreach($userddetts as $userdet) {
                                $deviceTToken = $userdet['deviceToken'];
                                $badge = $userdet['badge'];
                                $badge +=1;

                                $query->update()->set(['badge' => $badge])->where(['deviceToken'=>$deviceTToken])->execute();

                                if(isset($deviceTToken)) {
                                $pushMessage['type'] = 'seller_news';
                                $pushMessage['store_id'] = $userModel['id'];
                                $pushMessage['store_name'] = $userModel['shop_name'];
                                $pushMessage['store_image'] = $userModel['shop_image'];

                                $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userdet['user_id']])->first();
                                I18n::locale($user_detail['languagecode']);

                                $pushMessage['message'] = __d('merchant','Updated the News')." : ".$messagess;
                                $messages = json_encode($pushMessage);
                                $this->pushnot($deviceTToken,$messages,$badge);
                                }
                            }
                        }
                        $usersid = $this->Users->findById($flwww)->first();
                        if(count($usersid) > 0) {
                            $email=$usersid['email'];
                            $aSubject=$setngs['site_name']." – ".__d('merchant','News updated by')." ".$logusername;
                            $aBody='';
                            $template='merchantnews';

                            $setdata=array('user'=>$usersid, 'seller'=>$logusername, 'message'=>$messagess, 'setngs'=> $setngs);
                            $mailcheck = $this->sendmail($email,$aSubject,$aBody,$template,$setdata);
                        }
                    }
                    $this->Flashmessage('success', "News sent to followers Successfully");

                } else {
                    $this->Flashmessage('error', "No followers Found");
                }
                }
            }
            $this->redirect("/merchant/news");
        }

        public function addloglive($type=NULL,$userId=NULL,$notifyTo=NULL,$sourceId=NULL,$notifymsg=NULL,$message=NULL,$image=NULL,$itemid=0)
        {
            $this->loadModel('Logs');
            $this->loadModel('Users');

            $logsTable = TableRegistry::get('Logs');
            $logsarticle = $logsTable->newEntity();

            $logsarticle->type = $type;
            $logsarticle->userid = $userId;
            $logsarticle->notifyto = 0;
            if (!is_array($notifyTo)){
                $logsarticle->notifyto = $notifyTo;
            }
            $logsarticle->sourceid = $sourceId;
            $logsarticle->itemid = $itemid;
            $logsarticle->notifymessage = $notifymsg;
            $logsarticle->message = $message;
            $logsarticle->image = $image;
            $logsarticle->cdate = time();
            $logsResult = $logsTable->save($logsarticle);

            if(!empty($logsResult)) {
                $userstable = TableRegistry::get('Users');
                $query = $userstable->query();
                $query->update()->set($query->newExpr('unread_livefeed_cnt = unread_livefeed_cnt + 1'))->where(['id IN'=>$notifyTo])
                        ->execute();
            }

        }

        public function addlog($type=NULL,$userId=NULL,$notifyTo=NULL,$sourceId=NULL,$notifymsg=NULL,$message=NULL,$image=NULL,$itemid=0)
        {
            $this->loadModel('Logs');
            $this->loadModel('Users');

            $logsTable = TableRegistry::get('Logs');
            $logsarticle = $logsTable->newEntity();

            $logsarticle->type = $type;
            $logsarticle->userid = $userId;
            $logsarticle->notifyto = 0;
            if (!is_array($notifyTo)){
                $logsarticle->notifyto = $notifyTo;
            }
            $logsarticle->sourceid = $sourceId;
            $logsarticle->itemid = $itemid;
            $logsarticle->notifymessage = $notifymsg;
            $logsarticle->message = $message;
            $logsarticle->image = $image;
            $logsarticle->cdate = time();
            $logsResult = $logsTable->save($logsarticle);

            if(!empty($logsResult)) {
                $userstable = TableRegistry::get('Users');
                $query = $userstable->query();
                $query->update()->set($query->newExpr('unread_notify_cnt = unread_notify_cnt + 1'))->where(['id IN'=>$notifyTo])
                        ->execute();
            }
        }

        public function selleritemview($id=null,$nme=null)
        {
            $this->viewBuilder()->setLayout('merchant');
            $this->set('title_for_default','default');

            if(!empty($nme)) {
                $this->Urlfriendly->utils_makeUrlFriendly($nme);
                $this->set('title_for_layout',ucwords($nme));
            } else {
                $this->set('title_for_layout','Item View');
            }
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

            // INITIALIZE DATABASE MODELS HERE.
            $this->loadModel('Items');
            $this->loadModel('Comments');
            $this->loadModel('Countries');
            $this->loadModel('Shippingaddresses');
            $this->loadModel('Users');
            $this->loadModel('Categories');
            $this->loadModel('Itemlists');
            $this->loadModel('Photos');
            $this->loadModel('Itemfavs');
            $this->loadModel('Followers');
            $this->loadModel('Wantownits');
            $this->loadModel('Fashionusers');

            // DECLARATION & INITIALIZATION
            global $loguser, $setngs, $siteChanges;
            $userid = $loguser['id'];

            $followcnt = $this->Followers->sellerfollowcnt($userid);
            if(!empty($followcnt)){
                foreach($followcnt as $flcnt){
                    $flwngusrids[] = $flcnt['user_id'];
                }
            }

            $this->set('followcnt',$followcnt);

            $prnt_cat_data = $this->Categories->find()->where(['category_parent'=> 0, 'category_sub_parent'=> 0])->all();

            $items_list_data = $this->Itemlists->find()->where(['user_id' => $userid, 'user_create_list'=>'1'])->all();

            if(empty($id)){
                $this->Flashmessage('error', 'Your url is not valid', 'dashboard');
            }

            $item_datas = $this->Items->find()->contain(['Photos', 'Itemfavs', 'Users', 'Shops'])->where(['Items.id'=>$id])->first();

            if(empty($item_datas)){
                $this->Flashmessage('error', 'The item you are searching is not found', 'dashboard');
            }

            $wantOwnModel = $this->Wantownits->find()->where(['userid'=>$userid, 'itemid'=>$id, 'type'=>'want'])->count();
            $wantIt = 0;
            $ownIt = 0;
            if ($wantOwnModel > 0)
                $wantIt = 1;
            $wantOwnModel = $this->Wantownits->find()->where(['userid'=>$userid, 'itemid'=>$id, 'type'=>'own'])->count();
            if ($wantOwnModel > 0)
                $ownIt = 1;
            $this->set('wantIt',$wantIt);
            $this->set('ownIt',$ownIt);

            $current_page_userid = $item_datas['user_id'];

            $item_all = $this->Items->find()->contain(['Users'])->where(['Items.user_id'=>$current_page_userid])->order(['Items.id' => 'DESC'])->limit(10)->toArray();
            $item_forexrate = $this->Forexrates->find()->where(['id' => $item_datas['currencyid']])->first();
            $this->set('item_currency_code',$item_forexrate['currency_code']);
            $this->set('item_currency_sym',$item_forexrate['currency_symbol']);

            if(isset($userid)){
                $usershipping = $this->Users->findById($userid)->first();
                $usershippingid = $usershipping['defaultshipping'];

                $cntry_code = $this->Shippingaddresses->findByShippingid($usershippingid)->first();
                $cntry_code = $cntry_code['countrycode'];
            }else{
                $cntry_code = '';
                $usershipping = '';
            }

            $commentss_item = $this->Comments->find()->where(['item_id'=>$id])->order(['id'=>'DESC'])->group('id')->all();

            $itemusr = array();
            $people_details = array();
            $allitemdatta = array();

            $itemfavs = $this->Itemfavs->find()->where(['item_id'=>$id])->all();

            foreach ($itemfavs as $i => $row)
            {
                $itemusr[]=$row['user_id'];
            }

            if(!empty($itemusr))
            {
                $people_details =  $this->Users->find()->where(['user_level <>'=>'god', 'activation <>'=>'0','Users.id IN'=>$itemusr])->order(['Users.id'=>'desc'])->contain(['Itemfavs'])->all();

                foreach($people_details as $ppl_dtl){
                    $user_id = $ppl_dtl['id'];
                    $ppl_dtda = array();
                    foreach($ppl_dtl['itemfavs'] as $favkey => $ppl_dt){
                        $ppl_dtda[] = $ppl_dt['item_id'];
                    }
                    $pho_datas = $this->Items->find()->where(['id IN'=>$ppl_dtda])->order(['id'=>'desc'])->contain(['Photos'])->all();
                    foreach($pho_datas as $key=>$ppl_dt1){
                        $itemIdses= $ppl_dt1['id'];
                        $itemnames = $ppl_dt1['item_title'];
                        $itemnamesUrl = $ppl_dt1['item_title_url'];
                        $photimgName = $ppl_dt1['photos'][0]['image_name'];
                        if ($key < 10){
                            $allitemdatta[$user_id][$key]['Itemidd'] = $itemIdses;
                            $allitemdatta[$user_id][$key]['item_title'] = $itemnames;
                            $allitemdatta[$user_id][$key]['item_title_url'] = $itemnamesUrl;
                            $allitemdatta[$user_id][$key]['image_name'] = $photimgName;
                        }else {
                            break;
                        }
                    }
                }
            }
            $FashionuserDet = array();
            $FashionuserDet =  $this->Fashionusers->find()->where(['itemId'=>$id,'status'=>'Yes'])->order(['id'=>'DESC'])->all();
            $this->set('FashionuserDet',$FashionuserDet);

            $this->set('allitemdatta',$allitemdatta);
            $this->set('people_details',$people_details);

            $this->set('item_all',$item_all);
            $this->set('item_datas',$item_datas);
            $this->set('loguser',$loguser);
            $this->set('userid',$userid);
            $this->set('cntry_code',$cntry_code);
            $this->set('commentss_item',$commentss_item);

            $this->set('usershipping',$usershipping);
            $this->set('prnt_cat_data',$prnt_cat_data);
            $this->set('items_list_data',$items_list_data);
            $this->set('roundProf',$siteChanges['profile_image_view']);
            $this->set('setngs',$setngs);

        }



        public function viewmessage($id){
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Messages');

            $userid = $loguser['id'];

            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);

            $this->loadModel('Contactsellers');
            $this->loadModel('Contactsellermsgs');
            $this->loadModel('Users');

            $contactsellerModel = $this->Contactsellers->findById($id)->first();

            if(empty($contactsellerModel)){
                $this->Flashmessage('error', 'No Conversation Found');
                $this->redirect('/merchant/messages');
            }

            if($userid != $contactsellerModel['merchantid'] && $userid != $contactsellerModel['buyerid'])
            {
                $this->Flashmessage('error', 'Try again');
                $this->redirect('/merchant/messages');
            }

            $csmessageModel = $this->Contactsellermsgs->find()->where(['contactsellerid'=>$id])->order(['id' =>'DESC'])->limit(6)->all();

            $ContactsellersTable = TableRegistry::get('Contactsellers');
            $csarticle = $ContactsellersTable->get($id);

            if ($contactsellerModel['buyerid'] == $userid){
                $buyerModel = $this->Users->findById($contactsellerModel['merchantid'])->first();
                $merchantModel = $this->Users->findById($contactsellerModel['buyerid']);
                $currentUser = "buyer";
                if ($contactsellerModel['buyerread'] == 1){
                    $_SESSION['userMessageCount'] = $_SESSION['userMessageCount'] - 1;
                }

                $csarticle->buyerread = 0;
            }else{
                $buyerModel = $this->Users->findById($contactsellerModel['buyerid'])->first();
                $merchantModel = $this->Users->findById($contactsellerModel['merchantid'])->first();
                $currentUser = "seller";
                if ($contactsellerModel['sellerread'] == 1){
                    $_SESSION['userMessageCount'] = $_SESSION['userMessageCount'] - 1;
                }

                $csarticle->sellerread = 0;
            }

            $ContactsellersTable->save($csarticle);

            $itemDetails['item'] = $contactsellerModel['itemname'];
            $itemDetails['itemurl'] = $this->Urlfriendly->utils_makeUrlFriendly($contactsellerModel['itemname']);
            $itemDetails['itemid'] = $contactsellerModel['itemid'];

            $this->set('roundProf',$siteChanges['profile_image_view']);
            $this->set('contactsellerModel',$contactsellerModel);
            $this->set('csmessageModel',$csmessageModel);
            $this->set('buyerModel',$buyerModel);
            $this->set('merchantModel',$merchantModel);
            $this->set('itemDetails',$itemDetails);
            $this->set('currentUser',$currentUser);
        }

        public function getmoreviewmessage(){
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

            global $setngs;
            global $siteChanges;
            global $loguser;

            $userid = $loguser['id'];
            $this->loadModel('Contactsellers');
            $this->loadModel('Contactsellermsgs');
            $this->loadModel('Users');

            $offset = $_POST['offset'];
            $currentUser = $_POST['contact'];
            $csid = $_POST['csid'];

            $contactsellerModel = $this->Contactsellers->findById($csid)->first();

            $csmessageModel = $this->Contactsellermsgs->find()->where(['contactsellerid'=>$csid])->order(['id' => 'DESC'])->limit(5)->page($offset);

            if ($contactsellerModel['buyerid'] == $userid){
                $buyerModel = $this->Users->findById($contactsellerModel['merchantid'])->first();
                $merchantModel = $this->Users->findById($contactsellerModel['buyerid'])->first();
            }else{
                $buyerModel = $this->Users->findById($contactsellerModel['buyerid'])->first();
                $merchantModel = $this->Users->findById($contactsellerModel['merchantid'])->first();
            }

            $this->set('roundProf',$siteChanges['profile_image_view']);
            $this->set('contactsellerModel',$contactsellerModel);
            $this->set('csmessageModel',$csmessageModel);
            $this->set('buyerModel',$buyerModel);
            $this->set('merchantModel',$merchantModel);
            $this->set('currentUser',$currentUser);
        }

        public function getmorecomment() {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

            global $loguser;
            global $siteChanges;
            global $setngs;

            $this->loadModel('Ordercomments');
            $this->loadModel('Orders');
            $this->loadModel('Users');

            $userid = $loguser['id'];
            $offset = trim($_POST['offset']);
            $orderid = trim($_POST['orderid']);
            $contacter = trim($_POST['contact']);

            $orderModel = $this->Orders->findByOrderid($orderid)->first();

            $ordercommentsModel = $this->Ordercomments->find()->where(['orderid'=>$orderid])->order(['id' => 'DESC'])->limit(5)->page($offset);

            if (!empty($ordercommentsModel)){
                $buyerid = $orderModel['userid'];
                $merchantid = $orderModel['merchant_id'];
                $buyerModel = $this->Users->findById($buyerid)->first();
                $merchantModel = $this->Users->findById($merchantid)->first();

                if ($contacter == 'seller'){
                    $this->set('buyerModel',$buyerModel);
                    $this->set('merchantModel',$merchantModel);
                }else{
                    $this->set('buyerModel',$merchantModel);
                    $this->set('merchantModel',$buyerModel);
                }
                $this->set('contacter',$contacter);
                $this->set('roundProf',$siteChanges['profile_image_view']);
            }
            $this->set('ordercommentsModel',$ordercommentsModel);
            $this->set('latestcount','0');
        }

        public function trackingdetails($orderid){
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Tracking Details');

            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);

            $this->loadModel('Orders');
            $this->loadModel('Shippingaddresses');
            $this->loadModel('Trackingdetails');
            $this->loadModel('Users');

            $orderModel = $this->Orders->findByOrderid($orderid)->first();

            if($loguser['id']!=$orderModel['merchant_id'])
            {
                $this->Flashmessage('error', 'Try again');
                $this->redirect('/merchant/dashboard');
            }
            if($orderModel['status']=='Delivered')
            {
                $this->Flashmessage('error', 'Product was already delivered');
                $this->redirect('/merchant/neworders');
            }
            $userid = $orderModel['userid'];
            $userModel = $this->Users->findById($userid)->first();
            $userEmail = $userModel['email'];
            $shipppingId = $orderModel['shippingaddress'];
            $shippingModel = $this->Shippingaddresses->findByShippingid($shipppingId)->first();
            $trackingModel = $this->Trackingdetails->findByOrderid($orderid)->first();

            $this->set('orderModel', $orderModel);
            $this->set('userModel',$userModel);
            $this->set('shippingModel',$shippingModel);
            $this->set('trackingModel',$trackingModel);
        }

        public function replymessage(){
            $this->autoRender = false;
            $this->loadModel('Contactsellers');
            $this->loadModel('Contactsellermsgs');
            $this->loadModel('Users');
            $this->loadModel('Shops');
            $this->loadModel('Userdevices');
            global $setngs;
            global $loguser;

            $csId = $_POST['csid'];
            $merchantId = $_POST['merchantId'];
            $buyerId = $_POST['buyerId'];
            $sender = $_POST['sender'];
            $message = $_POST['message'];
            $username = $_POST['username'];
            $usrurl = $_POST['usrurl'];
            $usrimg = $_POST['usrimg'];
            $roundProfile = $_POST['roundprofile'];
            $timenow = time();


            $ContactsellersTable = TableRegistry::get('Contactsellers');
            $csarticle = $ContactsellersTable->get($csId);

            $csarticle->lastsent = $sender;

            if ($sender == 'buyer'){
                $csarticle->sellerread = 1;
            }else{
                $csarticle->buyerread = 1;
            }

            $csarticle->lastmodified = time();
            $ContactsellersTable->save($csarticle);

            $ContactsellermsgTable = TableRegistry::get('Contactsellermsgs');
            $csmarticle = $ContactsellermsgTable->newEntity();

            $csmarticle->contactsellerid = $csId;
            $csmarticle->message = $message;
            $csmarticle->sentby = $sender;
            $csmarticle->createdat = $timenow;
            $ContactsellermsgTable->save($csmarticle);

            echo '<div class="cmntcontnr" style="margin: 0 0 10px;">
            <div class="usrimg">
            <a href="'.SITE_URL.'people/'.$usrurl.'" class="url">';
            if(!empty($usrimg)){
                echo '<img src="'.SITE_URL.'media/avatars/thumb70/'.$usrimg.'" alt="" class="photo" style="'.$roundProfile.'">';
            }else{
                echo '<img src="'.SITE_URL.'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
            }

            echo '</a>
            </div>
            <div class="cmntdetails">
            <p class="usrname">
            <a href="'.SITE_URL.'people/'.$usrurl.'" class="url">';
            echo $username;
            echo '</a>
            </p>
            <p class="cmntdate">'.date('d,M Y',$timenow).'</p>
            <p class="comment">'.$message.'</p>
            </div>
            </div>';

            $email_address = $this->Users->find()->where(['id'=>$buyerId])->first();
            $emailaddress = $email_address['email'];
            $name = $email_address['first_name'];
            $this->set('name', $name);
            $this->set('email', $emailaddress);
            $username = $loguser['first_name'];
            $this->set('username',$username);
            $this->set('sender',$sender);
            $this->set('message',$message);
            $this->set('access_url',SITE_URL."merchant/login");

            /* Push Notifications */
            $userModel = $this->Shops->find()->where(['user_id' => $merchantId])->first();
            $userddetts = $this->Userdevices->findAllByUser_id($buyerId)->all();
            $query = $this->Userdevices->query();
            if (count($userddetts) > 0) {
                foreach ($userddetts as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge += 1;
                    $query->update()->set(['badge' => $badge])->where(['deviceToken' => $deviceTToken])->execute();
                    if (isset($deviceTToken)) {
                        $pushMessage['type'] = 'seller_message';
                        $pushMessage['store_id'] = $userModel['id'];
                        $pushMessage['store_name'] = $userModel['shop_name'];
                        $pushMessage['store_image'] = $userModel['shop_image'];
                        $user_detail = TableRegistry::get('Users')->find()->where(['id' => $userdet['user_id']])->first();
                        I18n::locale($user_detail['languagecode']);
                        $pushMessage['message'] = $userModel['shop_name'];
                        $pushMessage['message'] .= __d('merchant', ' send a message');
                        $messages = json_encode($pushMessage);
                        $this->pushnot($deviceTToken, $messages, $badge);
                    }
                }
            }
        }

        public function fulfillorders($sdate = NULL , $edate = NULL)
        {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);
            if($sdate > $edate)
            $this->Flashmessage('error', 'Error in search date','fulfillorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('userid',$userid);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');
            $this->loadModel('Invoiceorders');
            $this->loadModel('Invoices');

            $forexrateModel = $this->Forexrates->find()->all();

            $currencySymbol = array();

            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <' => $timeline, 'status'=>'Pending'])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate >'=> $timeline,'status NOT IN'=>array('Delivered','Shipped','Processing')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate >'=> $timeline,'status'=>'Pending'])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];
                $orderDetails[$key]['deliverytype'] = $orders['deliverytype'];

                $buyerModel = $this->Users->findById($orders['userid'])->first();
                $orderDetails[$key]['buyer'] = $buyerModel['username'];

                $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=>$orderid])->first();
                $invoiceid = $invoiceorders['invoiceid'];

                $invoices = $this->Invoices->find()->where(['invoiceid'=>$invoiceid])->first();

                $paymentmethod = $invoices['paymentmethod'];
                $orderDetails[$key]['paymentmethod'] = $paymentmethod;

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];

                    $itemModel = $this->Items->findById($orderitems[$orderid][$orderkey]['itemid'])->first();

                    $orderDetails[$key]['orderitems'][$itemkey]['ean'] = $itemModel['skuid'];


                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);

        }

        public function fulfilloldorders($sdate = NULL , $edate = NULL)
        {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);
            if($sdate > $edate)
            $this->Flashmessage('error', 'Error in search date','fulfilloldorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('userid',$userid);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');
            $this->loadModel('Invoiceorders');
            $this->loadModel('Invoices');

            $forexrateModel = $this->Forexrates->find()->all();

            $currencySymbol = array();

            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <'=> $timeline,'status NOT IN'=>array('Delivered','Shipped','Processing')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate <'=> $timeline,'status'=>'Pending'])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];
                $orderDetails[$key]['deliverytype'] = $orders['deliverytype'];

                $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=>$orderid])->first();
                $invoiceid = $invoiceorders['invoiceid'];

                $invoices = $this->Invoices->find()->where(['invoiceid'=>$invoiceid])->first();

                $paymentmethod = $invoices['paymentmethod'];
                $orderDetails[$key]['paymentmethod'] = $paymentmethod;

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);

        }

        public function actionrequired($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            if($sdate > $edate)
            $this->Flashmessage('error', 'Error in search date','neworders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status IN'=>array('Processing','Shipped')])->order(['status_date' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate >'=> $timeline,'status NOT IN'=>array('Pending','Delivered')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['status_date'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate >'=> $timeline,'status IN'=>array('Processing','Shipped')])->order(['status_date'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);

        }

        public function actionoldorders($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','actionoldorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);
            $this->set('userid',$userid);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status IN'=>array('Processing','Shipped')])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <'=> $timeline,'status NOT IN'=>array('Pending','Delivered')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate <'=> $timeline,'status IN'=>array('Processing','Shipped')])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);
            $this->set('sdate',$sdate);
            $this->set('edate',$edate);

        }

        public function history($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','historyorders');

            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <' => $timeline, 'status IN'=>array('Delivered','Paid')])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate >'=> $timeline,'status NOT IN'=>array('Pending','Shipped', 'Processing')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
            $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate >'=> $timeline,'status IN'=>array('Delivered','Paid')])->order(['orderid'=>'desc'])->all();
            }
            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);

        }

        public function claimed($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','claimedorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status'=>'Claimed'])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate >'=> $timeline,'status'=>'Claimed'])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate >'=> $timeline,'status'=>'Claimed'])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);
        }

        public function claimedoldorders($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','claimedoldorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status'=>'Claimed'])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <'=> $timeline,'status'=>'Claimed'])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate <'=> $timeline,'status'=>'Claimed'])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);
        }

        public function returned ($sdate = NULL , $edate = NULL){
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','returnedorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status'=>'Returned'])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate >'=> $timeline,'status'=>'Returned'])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate >'=> $timeline,'status'=>'Returned'])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);
        }

        public function returnedoldorders ($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','returnedoldorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status'=>'Returned'])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <'=> $timeline,'status'=>'Returned'])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate <'=> $timeline,'status'=>'Returned'])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);
        }

        public function cancelled ($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','cancelledorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status IN'=>array('Cancelled','Refunded')])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate >'=> $timeline,'status IN'=>array('Cancelled','Refunded')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate >'=> $timeline,'status IN'=>array('Cancelled','Refunded')])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);
        }

        public function cancelledoldorders ($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','cancelledoldorders');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            $oldordersModel = $this->Orders->find()->where(['merchant_id' => $userid, 'orderdate <' => $timeline, 'status IN'=>array('Cancelled','Refunded')])->order(['orderid' => 'desc'])->all();

            $oldordercount = count($oldordersModel);
            $this->set('oldordercount',$oldordercount);

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <'=> $timeline,'status IN'=>array('Cancelled','Refunded')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            } else {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid,'orderdate <'=> $timeline,'status IN'=>array('Cancelled','Refunded')])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);
        }

        public function historyoldmyorders($sdate = NULL , $edate = NULL) {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','historyoldorders');

            global $loguser;

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $itemModel = array();

            $this->loadModel('Orders');
            $this->loadModel('OrderItems');
            $this->loadModel('Items');
            $this->loadModel('Forexrates');

            $forexrateModel = $this->Forexrates->find()->all();
            $currencySymbol = array();
            foreach($forexrateModel as $forexrate){
                $cCode = $forexrate['currency_code'];
                $cSymbol = $forexrate['currency_symbol'];
                $currencySymbol[$cCode] = $cSymbol;
            }

            $timeline = strtotime('-1 month');

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <'=> $timeline,'status NOT IN'=>array('Pending','Shipped', 'Processing')])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('orderdate', $sdate, $edate); })->order(['orderid'=>'desc'])->all();
            }
            else
            {   $ordersModel = $this->Orders->find()->where(['merchant_id'=>$userid, 'orderdate <'=> $timeline,'status IN'=>array('Delivered','Paid')])->order(['orderid'=>'desc'])->all();
            }

            $orderid = array();
            foreach ($ordersModel as $value) {
                $orderid[] = $value['orderid'];
            }

            if(count($orderid) > 0) {
                $orderitemModel = $this->OrderItems->find()->where(['orderid IN'=>$orderid])->all();

                $itemid = array();

                foreach ($orderitemModel as $value) {
                    $orid = $value['orderid'];
                    if (!isset($oritmkey[$orid])){
                        $oritmkey[$orid] = 0;
                    }
                    $itemid[] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemid'] = $value['itemid'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                    $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                    $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                    $oritmkey[$orid]++;
                }
            }
            $orderDetails = array();
            foreach ($ordersModel as $key => $orders){
                $orderid = $orders['orderid'];
                $orderCurny = $orders['currency'];
                $orderDetails[$key]['orderid'] = $orders['orderid'];
                $orderDetails[$key]['price'] = $orders['totalcost'];
                $orderDetails[$key]['saledate'] = $orders['orderdate'];
                $orderDetails[$key]['status'] = $orders['status'];

                $this->loadModel('Ordercomments');

                $ordercomments = $this->Ordercomments->find()->where(['orderid'=>$orderid])->all();
                $orderDetails[$key]['commentcount'] = count($ordercomments);

                $itemkey = 0;

                foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                    $orderDetails[$key]['orderitems'][$itemkey]['itemid'] = $orderitems[$orderid][$orderkey]['itemid'];
                    $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                    $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                    $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                    $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                    $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                    $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                    $itemkey++;
                }
            }
            $this->set('orderDetails',$orderDetails);

        }


        public function viewinvoice ($orderId) {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            $this->loadModel('Invoices');
            $this->loadModel('Orders');
            $this->loadModel('Users');
            $this->loadModel('OrderItems');
            $this->loadModel('Invoiceorders');
            $this->loadModel('Items');
            $this->loadModel('Shippingaddresses');
            $this->loadModel('Coupons');
            $this->set('title_for_layout','View Invoice');

            $invoiceOrder = $this->Invoiceorders->findByOrderid($orderId)->first();

            $invoiceId = trim($invoiceOrder['invoiceid']);

            $invoiceModel = $this->Invoices->findByInvoiceid($invoiceId)->first();

            $orderModel = $this->Orders->findByOrderid($orderId)->first();

            $orderItemModel = $this->OrderItems->findAllByOrderid($orderId)->toArray();

            $shippingid = $orderModel['shippingaddress'];
            $shippingModel = $this->Shippingaddresses->findByShippingid($shippingid)->first();

            $sellerId = $this->Items->find()->where(['Items.id'=>$orderItemModel[0]['itemid']])->first();

            $sellerId = $sellerId['user_id'];

            $userModel = $this->Users->findById($orderModel['userid'])->first();

            $sellerModel = $this->Users->findById($sellerId)->first();

            $coupon_id  = $orderModel['coupon_id'];

            $discount_amount  = $orderModel['discount_amount'];

            $currencyCode = $orderModel['currency'];

            $this->loadModel('Forexrates');
            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

            $currencySymbol = $forexrateModel['currency_symbol'];

            $this->set('currencySymbol',$currencySymbol);

            $tax = $orderModel['tax'];

            $getcouponvalue = $this->Coupons->findById($coupon_id)->first();
            $this->set('getcouponvalue',$getcouponvalue);

            $this->set('getcouponvalue',$getcouponvalue);
            $this->set('orderDetails',$orderModel);
            $this->set('orderItemModel',$orderItemModel);
            $this->set('invoiceModel',$invoiceModel);
            $this->set('userModel',$userModel);
            $this->set('sellerModel',$sellerModel);
            $this->set('shippingModel',$shippingModel);
            $this->set('discount_amount',$discount_amount);
            $this->set('currencyCode',$currencyCode);
            $this->set('tax',$tax);
        }

        public function sellerconversation($orderid){
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);


            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Conversation');

            global $loguser;
            global $siteChanges;
            global $setngs;

            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);
            $this->set('loguser',$loguser);

            $this->loadModel('Orders');
            $this->loadModel('Shippingaddresses');
            $this->loadModel('Ordercomments');
            $this->loadModel('Users');

            $orderModel = $this->Orders->findByOrderid($orderid)->first();

            $ordercommentsModel = $this->Ordercomments->find()->where(['orderid'=>$orderid])->order(['id' =>'DESC'])->limit(6)->all();

            $buyerid = $orderModel['userid'];
            $merchantid = $orderModel['merchant_id'];

            if($loguser['id']!= $merchantid)
            {
                $this->Flashmessage('success', 'Try again','dashboard');
            }

            $buyerModel = $this->Users->findById($buyerid)->first();
            $buyerName = $buyerModel['first_name'];
            $merchantModel = $this->Users->findById($merchantid)->first();

            $this->set('orderModel', $orderModel);
            $this->set('buyerModel',$buyerModel);
            $this->set('merchantModel',$merchantModel);
            $this->set('ordercommentsModel',$ordercommentsModel);
            $this->set('buyerName',$buyerName);
            $this->set('roundProf',$siteChanges['profile_image_view']);

        }

        public function postordercomment(){
            if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

            $this->autoRender = false;

            global $loguser;
            global $siteChanges;
            global $setngs;

            $this->loadModel('Ordercomments');
            $userid = $loguser['id'];
            $username = $loguser['username'];

            $OrdercommentsTable = TableRegistry::get('Ordercomments');
            $csarticle = $OrdercommentsTable->newEntity();

            $csarticle->orderid = trim($_POST['orderid']);
            $csarticle->merchantid = trim($_POST['merchantid']);
            $csarticle->buyerid = trim($_POST['buyerid']);
            $csarticle->comment = trim($_POST['comment']);
            $csarticle->createddate = time();
            $csarticle->commentedby = trim($_POST['postedby']);
            $OrdercommentsTable->save($csarticle);

            $orderid = trim($_POST['orderid']);
            $roundProfile = trim($_POST['roundProfile']);

            $logusernameurl = $loguser['username_url'];
            $logusername = $loguser['first_name'];
            $userImg = $loguser['profile_image'];

            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);
            $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";

            if (trim($_POST['merchantid']) == $userid){
                $logusrid = trim($_POST['merchantid']);
                $userid = trim($_POST['buyerid']);
                $orderLink = '<a href="'.SITE_URL.'buyerconversation/'.$orderid.'">'.$orderid.'</a>';
                $notifymsg = 'Seller-___- '.$loguserlink.' -___-sent a message-___- #'.$orderLink;
                $messages = 'Seller '.$logusername.' sent a message: '.$_POST['comment'];
            }else{
                $logusrid = trim($_POST['buyerid']);
                $userid = trim($_POST['merchantid']);
                $orderLink = '<a href="'.SITE_URL.'sellerconversation/'.$orderid.'">'.$orderid.'</a>';
                $notifymsg = 'Buyer-___- '.$loguserlink.' -___-sent a message-___- #'.$orderLink;
                $messages = 'Buyer '.$logusername.' sent a message: '.$_POST['comment'];
            }

            $logdetails = $this->addlog('ordermessage',$logusrid,$userid,$orderid,$notifymsg,$_POST['comment'],$loguserimage);
            echo '<div class="cmntcontnr" style="margin: 0 0 10px;">
            <div class="usrimg" style="float:left;">
            <a href="'.SITE_URL.'people/'.trim($_POST['usrurl']).'" class="url">';
            if(!empty(trim($_POST['usrimg']))) {
                echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/'.trim($_POST['usrimg']).'" alt="" class="photo" style="'.$roundProfile.'">';
            }else{
                echo '<img src="'.$_SESSION['site_url'].'media/avatars/thumb70/usrimg.jpg" alt="" class="photo" style="'.$roundProfile.'">';
            }

            echo '</a>';
            echo '</div>
            <div class="cmntdetails">
            <p class="usrname">
            <a href="'.SITE_URL.'people/'.trim($_POST['usrurl']).'" class="url">';
            echo $_POST['usrname'];
            echo '</a>
            </p>
            <p class="cmntdate">'.date('d,M Y',time()).'</p>
            <p class="comment">'.trim($_POST['comment']).'</p>
            </div>
            </div>';

            if(trim($_POST['postedby']) == "buyer")
                $emailId = $_POST['merchantid'];
            else if(trim($_POST['postedby']) == "seller")
                $emailId = $_POST['buyerid'];
            $email_address = $this->Users->find()->where(['Users.id'=>$emailId])->first();
            $emailaddress = $email_address['email'];
            $name = $email_address['username'];

            $this->set('name', $email_address['first_name']);
            $this->set('email', $emailaddress);
            $this->set('username',$loguser['first_name']);
            $this->set('message',trim($_POST['comment']));
            $this->set('access_url',SITE_URL."login");
        }

        public function markpaid ($orderId) {
            if(!$this->isauthenticated())
            $this->redirect(['action' => 'login']);

            $this->autoRender = false;
            $this->loadModel('Orders');
            $this->loadModel('Users');
            $this->loadModel('OrderItems');
            $this->loadModel('Forexrates');

            $statusDate = time();

            $orderdata = $this->Orders->findByOrderid($orderId)->first();

            $user_datas = $this->Users->findById($orderdata['userid'])->first();

            $orderItemDetail = $this->OrderItems->findByOrderid($orderId)->first();

            $userid = $user_datas['id'];
            $orderCurrency = $orderdata['currency'];
            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $orderCurrency])->first();
            $forexRate = $forexrateModel['price'];

            if(!empty($orderdata) && ($orderdata['status']=="" || $orderdata['status']=="Pending"))
            {
                $orderstable = TableRegistry::get('Orders');
                $query = $orderstable->query();
                $query->update()->set(['status' => 'Paid', 'status_date' => $statusDate])->where(['orderid'=>$orderid])->execute();

            /*** Update the credit amount after while share the product***/

                $itemTotal = $orderItemDetail['itemprice'] * $forexRate;
                $shareData = json_decode($user_datas['share_status'], true);
                $creditPoints = $user_datas['credit_points'];
                $shareNewData = array();
                $UsersTable = TableRegistry::get('Users');
                foreach ($shareData as $shareKey => $shareVal){

                    if( array_key_exists($orderId,$shareVal) ){

                        if ($shareVal[$orderId] == '1'){
                            $usersarticle = $UsersTable->get($userid);
                            $usersarticle->credit_points = $creditPoints + $shareVal['amount'];
                            $UsersTable->save(usersarticle);
                        }else{
                            $shareVal['amount'] = $itemTotal;
                            $shareNewData[] = $shareVal;
                        }

                    } else{

                        $shareNewData[] = $shareVal;

                    }
                }
                $userarticle = $UsersTable->get($userid);
                $userarticle->share_status = json_encode($shareNewData);
                $UsersTable->save(userarticle);
                echo "success";
            } else {
                echo "fail";
            }
        }

    public function orderstatus() {
        if(!$this->isauthenticated())
        $this->redirect(['action' => 'login']);

        $this->autoRender = false;
        $orderid = trim($_POST['orderid']);
        $status = trim($_POST['chstatus']);

        $this->loadModel('Orders');
        $this->loadModel('Shippingaddresses');
        $this->loadModel('OrderItems');
        $this->loadModel('Forexrates');
        $this->loadModel('Users');

        global $setngs;
        global $loguser;
        $orderDatas = array();

        if(!empty($orderid)) {
            $orderDatas = $this->Orders->find()->where(['orderid'=>$orderid, 'merchant_id'=>$loguser['id']])->first();
        }
        if(count($orderDatas) <= 0 || empty($orderid)) {
            $this->Flashmessage('error', 'Try again');
            echo "false";
        } else {
            $statusDate = time();
            $deliverDate = time();

            $orderModel = $this->Orders->findByOrderid($orderid)->first();
            $orderitemModel = $this->OrderItems->find()->where(['orderid'=>$orderid])->all();

            $orderCurrency = $orderModel['Currency'];
            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $orderCurrency])->first();
            $forexRate = $forexrateModel['price'];

            $itemmailids = array();$itemname = array();
            $totquantity = array();$custmrsizeopt = array(); $itemPrice = 0;

            foreach ($orderitemModel as $value) {
                $itemmailids[] = $value['itemid'];
                $itemname[] = $value['itemname'];
                if (!empty($value['item_size'])) {
                    $custmrsizeopt[] = $value['item_size'];
                }else{
                    $custmrsizeopt[] = '0';
                }
                $totquantity[] = $value['itemquantity'];
                $itemPrice += $orderItemDetail['itemprice'] * $forexRate;
            }
            $usershipping_addr = $this->Shippingaddresses->findByShippingid($orderModel['shippingaddress'])->first();

            $user_name = $this->Users->find()->where(['id'=>$orderModel['merchant_id']])->first();
            $username = $user_name['username'];
            $emailaddress = $user_name['email'];

           // print_r($emailaddress);exit;

            $buyer_name = $this->Users->find()->where(['id'=>$orderModel['userid']])->first();
            $buyername = $buyer_name['username'];
            $buyerurl = $buyer_name['username_url'];

            $orderstable = TableRegistry::get('Orders');
            $query = $orderstable->query();

            if($status == 'Delivered') {
                $query->update()->set(['status' => $status, 'status_date' => $statusDate, 'deliver_date' => $deliverDate, 'deliver_update' => $statusDate])->where(['orderid'=>$orderid])->execute();

                /*** Update the credit amount after while share the product***/
                if($orderModel['deliverytype'] == 'door') {
                    $shareData = json_decode($buyer_name['share_status'], true);
                    $creditPoints = $buyer_name['credit_points'];
                    $userid = $buyer_name['id'];

                    $shareNewData = array();
                    $UsersTable = TableRegistry::get('Users');
                    foreach ($shareData as $shareKey => $shareVal){
                        if( array_key_exists($orderId,$shareVal) ){

                            if ($shareVal[$orderId] == '1'){
                                $usersarticle = $UsersTable->get($userid);
                                $usersarticle->credit_points = $creditPoints + $shareVal['amount'];
                                $UsersTable->save(usersarticle);
                            } else {
                            }
                        } else {
                            $shareNewData[] = $shareVal;
                        }
                    }
                    $userarticle = $UsersTable->get($userid);
                    $userarticle->share_status = json_encode($shareNewData);
                    $UsersTable->save(userarticle);
                }
                $template='merchantdeliveredmail';
            } else {
                $query->update()->set(['status' => $status, 'status_date' => $statusDate])->where(['orderid'=>$orderid])->execute();
                $template='merchantprocessingmail';
                $emailaddress = $buyer_name['email'];
            }

            $aSubject=$setngs['site_name']." – ".__d('merchant','Your Order')." #".$orderid." - ".__d('merchant','shipment was')." ".__d('merchant',$status);
            $aBody='';
            $setdata=array('orderid'=>$orderid, 'username'=>$username, 'orderdate'=>$orderModel['orderdate'], 'setngs'=> $setngs, 'itemname'=>$itemname, 'tot_quantity'=>$totquantity, 'sizeopt'=>$custmrsizeopt, 'usershipping_addr'=> $usershipping_addr, 'totalcost'=> $orderModel['totalcost'], 'currencyCode'=> $orderModel['currency'], 'buyername'=> $buyername, 'buyerurl'=>$buyerurl, 'access_url'=>SITE_URL."login");

            $mailcheck = $this->sendmail($emailaddress,$aSubject,$aBody,$template,$setdata);

            $logusernameurl = $loguser['username_url'];
            $logusername = $loguser['first_name'];
            $userImg = $loguser['profile_image'];
            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);

            if ($status == 'Delivered'){
                $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";
                $logusrid = $orderModel['userid'];
                $userid = $orderModel['merchant_id'];
                $notifymsg = 'Your order has been received by the buyer-___- '.$loguserlink;
            } else {
                $logusrid = $orderModel['merchant_id'];
                $userid = $orderModel['userid'];
                $orderLink = '<a href="'.SITE_URL.'buyerorderdetails/'.$orderid.'">'.$orderid.'</a>';
                $notifymsg = 'Your order has been marked as processing-___- #'.$orderLink;
            }

            $logdetails = $this->addlog('orderstatus',$logusrid,$userid,$orderid,$notifymsg,NULL,$loguserimage);

            $this->loadModel('Userdevices');
            $userdevicetable = TableRegistry::get('Userdevices');
            $query = $userdevicetable->query();

            $userddett = $this->Userdevices->find()->where(['user_id'=>$userid])->all();
            if(count($userddett) > 0) {
                foreach($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge +=1;

                    $query->update()->set(['badge' => $badge])->where(['deviceToken'=>$deviceTToken])->execute();

                    if(isset($deviceTToken)) {
                        $pushMessage['type'] = "orderstatus";
                        $pushMessage['user_image'] = $userImg;
                        $pushMessage['order_id'] = $orderid;

                        $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userdet['user_id']])->first();
                        I18n::locale($user_detail['languagecode']);

                        $pushMessage['message'] = __d('merchant','Your Order')." #".$orderid." ".__d('merchant','has been marked as')." ".__d('merchant',$status);
                        $messages = json_encode($pushMessage);
                        $this->pushnot($deviceTToken,$messages,$badge);
                    }
                }
            }
        }
    }

    public function updatetrackingdetails() {
        if(!$this->isauthenticated())
            $this->redirect(['action' => 'login']);

        $this->autoRender = false;

        global $loguser;
        global $siteChanges;
        global $setngs;
        $userid = $loguser['id'];

        $this->loadModel('Orders');
        $this->loadModel('Shippingaddresses');
        $this->loadModel('Trackingdetails');
        $this->loadModel('OrderItems');

        $orderid = trim($_POST['orderid']);
        $orderDatas = array();

        if(!empty($orderid)) {
            $orderDatas = $this->Orders->find()->where(['orderid'=>$orderid, 'merchant_id'=>$userid])->first();
        }

        if(count($orderDatas) <= 0 || empty($orderid)) {
            $this->Flashmessage('error', 'Try again');
            echo "false";
        } else if($orderDatas['status']=='Delivered') {
            $this->Flashmessage('error', 'Product was already delivered');
            echo "false";
        } else {
            $buyeremail = trim($_POST['buyeremail']);
            $subject = "Tracking Order Details";
            $message = "Your tracking order details for the listed item as below";
            $tid = trim($_POST['id']);

            $TrackingdetailsTable = TableRegistry::get('Trackingdetails');
            if ($tid != 0 && $tid != ""){
                $trackarticle = $TrackingdetailsTable->get($tid);
                $subject = "Updated Tracking Order Details";
                $message = "Your updated tracking order details for the listed item as below";
            } else {
                $trackarticle = $TrackingdetailsTable->newEntity();
            }

            $trackarticle->orderid = $orderid;
            $trackarticle->status = trim($_POST['orderstatus']);
            $trackarticle->merchantid = $userid;
            $trackarticle->buyername = trim($_POST['buyername']);
            $trackarticle->buyeraddress = trim($_POST['address']);
            $trackarticle->shippingdate = strtotime(trim($_POST['shippingdate']));
            $trackarticle->couriername = trim($_POST['couriername']);
            $trackarticle->courierservice = trim($_POST['courierservice']);
            $trackarticle->trackingid = trim($_POST['trackid']);
            $trackarticle->notes = trim($_POST['notes']);

            $TrackingdetailsTable->save($trackarticle);

            $orderModel = $this->Orders->find()->where(['orderid'=>$orderid])->first();
            $orderitemModel = $this->OrderItems->find()->where(['orderid'=>$orderid])->all();

            $itemmailids = array();  $itemname = array();
            $totquantity = array();  $custmrsizeopt = array();

            foreach ($orderitemModel as $value) {
                $itemmailids[] = $value['itemid'];
                $itemname[] = $value['itemname'];
                if (!empty($value['item_size'])) {
                    $custmrsizeopt[] = $value['item_size'];
                }else{
                    $custmrsizeopt[] = '0';
                }
                $totquantity[] = $value['itemquantity'];
            }

            $usershipping_addr = $this->Shippingaddresses->findByShippingid($orderModel['shippingaddress'])->first();

            // Email
            $aSubject=$setngs['site_name']." – ".__d('merchant','Shipping details for Order')." #".$orderid;
            $aBody='';
            $template='merchanttrackdetailsmail';
            $setdata=array('message'=>$message, 'shippingdate'=>trim($_POST['shippingdate']), 'trackingid'=>trim($_POST['trackid']), 'courierservice'=>trim($_POST['courierservice']), 'couriername'=>trim($_POST['couriername']), 'notes'=>trim($_POST['notes']), 'orderId'=>$orderid, 'orderdate'=>$orderModel['orderdate'], 'setngs'=> $setngs, 'itemname'=>$itemname, 'tot_quantity'=>$totquantity, 'sizeopt'=>$custmrsizeopt, 'usershipping_addr'=> $usershipping_addr, 'totalcost'=> $orderModel['totalcost'], 'currencyCode'=> $orderModel['currency'], 'custom'=>trim($_POST['buyername']));
            $mailcheck = $this->sendmail($buyeremail,$aSubject,$aBody,$template,$setdata);

            //Notify
            $logusernameurl = $loguser['username_url'];
            $logusername = $loguser['first_name'];
            $userImg = $loguser['profile_image'];
            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);
            $logusrid = $orderModel['merchant_id'];
            $userid = $orderModel['userid'];
            $orderLink = '<a href="'.SITE_URL.'buyerorderdetails/'.$orderid.'">'.$orderid.'</a>';
            $notifymsg = 'Your order has been updated with Tracking details-___- #'.$orderLink;

            $logdetails = $this->addlog('orderstatus',$logusrid,$userid,$orderid,$notifymsg,NULL,$loguserimage);

            //Push Notify
            $this->loadModel('Userdevices');
            $userdevicetable = TableRegistry::get('Userdevices');
            $query = $userdevicetable->query();

            $userddett = $this->Userdevices->find()->where(['user_id'=>$userid])->all();
            if(count($userddett) > 0) {
                foreach($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge +=1;

                    $query->update()->set(['badge' => $badge])->where(['deviceToken'=>$deviceTToken])->execute();
                    if(isset($deviceTToken)) {
                        $pushMessage['type'] = "orderstatus";
                        $pushMessage['user_image'] = $userImg;
                        $pushMessage['order_id'] = $orderid;

                        $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userdet['user_id']])->first();
                        I18n::locale($user_detail['languagecode']);

                        $pushMessage['message'] = __d('merchant','Your Order').' : #'.$orderid.' '.__d('merchant','has been updated with Tracking details');
                        $messages = json_encode($pushMessage);
                        $this->pushnot($deviceTToken,$messages,$badge);
                    }
                }
            }
            $statusDate = time();
            $orderstable = TableRegistry::get('Orders');
            $query = $orderstable->query();
            $query->update()->set(['status' => 'Shipped', 'status_date' => $statusDate])->where(['orderid'=>$orderid])->execute();
            $this->Flashmessage('success', 'Tracking details added successfully');
            echo "true";
        }
    }

        public function markshipped($orderid = NULL) {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);

            global $loguser;
            global $siteChanges;
            global $setngs;

            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name',$first_name);

            $this->loadModel('Orders');
            $this->loadModel('Users');

            $orderModel = $this->Orders->findByOrderid($orderid)->first();

            if($orderModel['status']=='Delivered')
            {
                $this->Flashmessage('error', 'Product was already delivered','dashboard');
            }
            if (!isset($_POST['orderid'])) {
                $this->viewBuilder()->setLayout('merchanthome');
                $this->set('title_for_layout','Mark Shipped');

                $this->loadModel('Orders');
                $this->loadModel('Shippingaddresses');

                if(empty($orderid)) {
                $this->Flashmessage('error', 'No order found');
                    $this->redirect('/merchant/neworders');
                }
                $orderDatas = $this->Orders->find()->where(['orderid'=>$orderid, 'merchant_id'=>$userid, 'status'=>'Processing'])->first();
                if(count($orderDatas) <= 0) {
                $this->Flashmessage('error', 'No order found');
                $this->redirect('/merchant/neworders');
                }

                $orderModel = $this->Orders->findByOrderid($orderid)->first();
                $userid = $orderModel['userid'];
                $userModel = $this->Users->findById($userid)->first();
                $userEmail = $userModel['email'];
                $shipppingId = $orderModel['shippingaddress'];
                $shippingModel = $this->Shippingaddresses->findByShippingid($shipppingId)->first();
                $this->set('orderModel', $orderModel);
                $this->set('userModel',$userModel);
                $this->set('shippingModel',$shippingModel);
            } else {
                $this->autoRender = false;
                $this->loadModel('Orders');
                $this->loadModel('OrderItems');
                $this->loadModel('Shippingaddresses');

                $orderid = trim($_POST['orderid']);
                $buyeremail = trim($_POST['buyeremail']);
                $subject = trim($_POST['subject']);
                $message = trim($_POST['message']);
                $usernameforcust = trim($_POST['buyername']);

                $deliver_date = time();

                $orderModel = $this->Orders->find()->where(['orderid'=>$orderid,  'status'=>'Processing'])->first();

                if($loguser['id']!=$orderModel['merchant_id'])
                {
                    $this->Flashmessage('error', 'Try again');
                    echo "false";
                } else {
                $orderitemModel = $this->OrderItems->find()->where(['orderid'=>$orderid])->all();

                $itemmailids = array();$itemname = array();
                $totquantity = array();$custmrsizeopt = array();

                foreach ($orderitemModel as $value) {
                    $itemmailids[] = $value['itemid'];
                    $itemname[] = $value['itemname'];
                    if (!empty($value['item_size'])) {
                        $custmrsizeopt[] = $value['item_size'];
                    }else{
                        $custmrsizeopt[] = '0';
                    }
                    $totquantity[] = $value['itemquantity'];
                }
                $statusDate = time();

                $orderstable = TableRegistry::get('Orders');
                $query = $orderstable->query();
                $query->update()->set(['status' => 'Shipped', 'status_date' => $statusDate, 'deliver_date' => $deliver_date])->where(['orderid'=>$orderid])->execute();

                $usershipping_addr = $this->Shippingaddresses->findByShippingid($orderModel['shippingaddress'])->first();
                $userModel = $this->Users->findById($orderModel['userid'])->first();

                //Email
                $aSubject=$setngs['site_name']." – ".__d('merchant','Shipping initiated for order')." #".$orderid;
                $aBody='';
                $template='markedshipped';
                $setdata=array('orderId'=>$orderid, 'custom'=>$userModel['first_name'], 'orderdate'=>$orderModel['orderdate'], 'setngs'=> $setngs, 'itemname'=>$itemname, 'tot_quantity'=>$totquantity, 'sizeopt'=>$custmrsizeopt, 'usershipping_addr'=> $usershipping_addr, 'totalcost'=> $orderModel['totalcost'], 'currencyCode'=> $orderModel['currency'], 'subject'=>$subject, 'message'=>$message);
                $mailcheck = $this->sendmail($buyeremail,$aSubject,$aBody,$template,$setdata);

                //notify
                $logusernameurl = $loguser['username_url'];
                $logusername = $loguser['first_name'];
                $userImg = $loguser['profile_image'];
                if (empty($userImg)){
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL."people/".$logusernameurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";

                $logusrid = $orderModel['merchant_id'];
                $userid = $orderModel['userid'];
                $orderLink = '<a href="'.SITE_URL.'buyerorderdetails/'.$orderid.'">'.$orderid.'</a>';
                $notifymsg = 'Your order has been marked as shipped-___- #'.$orderLink;

                $logdetails = $this->addlog('orderstatus',$logusrid,$userid,$orderid,$notifymsg,NULL,$loguserimage);

                //push notify
                $this->loadModel('Userdevices');
                $userdevicetable = TableRegistry::get('Userdevices');
                $query = $userdevicetable->query();

                $userddett = $this->Userdevices->find()->where(['user_id'=>$userid])->all();
                if(count($userddett) > 0) {
                    foreach($userddett as $userdet){
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge +=1;

                        $query->update()->set(['badge' => $badge])->where(['deviceToken'=>$deviceTToken])->execute();

                        if(isset($deviceTToken)) {
                        $pushMessage['type'] = "orderstatus";
                        $pushMessage['user_image'] = $userImg;
                        $pushMessage['order_id'] = $orderid;

                        $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userdet['user_id']])->first();
                        I18n::locale($user_detail['languagecode']);

                        $pushMessage['message'] = __d('merchant','Your Order').' : #'.$orderid.' '.__d('merchant','has been marked as Shipped');
                        $messages = json_encode($pushMessage);
                        $this->pushnot($deviceTToken,$messages,$badge);
                        }
                    }
                }
                $this->Flashmessage('success', 'Order initiated for shipping successfully');
                echo "true";
                }
            }
        }

        public function viewreturn($orderId) {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','View Return');

            $this->loadModel('Invoices');
            $this->loadModel('Orders');
            $this->loadModel('Users');
            $this->loadModel('OrderItems');
            $this->loadModel('Invoiceorders');
            $this->loadModel('Items');
            $this->loadModel('Shippingaddresses');
            $this->loadModel('Coupons');
            $this->loadModel('Trackingdetails');

            $orderModel = $this->Orders->findByOrderid($orderId)->first();
            $orderItemModel = $this->OrderItems->findAllByOrderid($orderId)->toArray();
            $shippingid = $orderModel['shippingaddress'];
            $shippingModel = $this->Shippingaddresses->findByShippingid($shippingid)->first();
            $trackingModel = $this->Trackingdetails->findByOrderid($orderId)->first();
            $this->set('trackingModel',$trackingModel);

            $sellerId = $this->Items->find()->where(['id'=>$orderItemModel[0]['itemid']])->first();
            $sellerId = $sellerId['user_id'];

            $userModel = $this->Users->findById($orderModel['userid'])->first();
            $sellerModel = $this->Users->findById($sellerId)->first();
            $coupon_id  = $orderModel['coupon_id'];
            $discount_amount  = $orderModel['discount_amount'];
            $orderCurrency = $orderModel['currency'];
            $this->loadModel('Forexrates');
            $forexrateModel = $this->Forexrates->find()->where(['currency_code'=>$orderCurrency])->first();
            $currencySymbol = $forexrateModel['currency_symbol'];
            $this->set('currencySymbol',$currencySymbol);
            $tax = $orderModel['tax'];
            $getcouponvalue = $this->Coupons->findById($coupon_id)->first();
            $this->set('getcouponvalue',$getcouponvalue);

            $this->set('orderDetails',$orderModel);
            $this->set('orderItemModel',$orderItemModel);
            $this->set('orderCurrency',$orderCurrency);
            $this->set('userModel',$userModel);
            $this->set('sellerModel',$sellerModel);
            $this->set('shippingModel',$shippingModel);
            $this->set('discount_amount',$discount_amount);
            $this->set('tax',$tax);
        }

        public function checkskuid() {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            $this->autoRender = false;

            $this->loadModel('Items');
            $skuid = trim($_POST['skuid']);
            $userid = trim($_POST['userid']);

            $itemcount = $this->Items->find()->where(['Items.user_id'=>$userid, 'Items.skuid'=>$skuid])->count();
            if($itemcount>0)
            {
                echo "exists";
            }
        }

        public function checknewusername() {
            $this->autoRender = false;
            $usernameurl = trim($_POST['username']);        
            $username = $this->Urlfriendly->utils_makeUrlFriendly($usernameurl);
            $usercount = $this->Users->find()->where(['Users.username'=>$username])->count();
            if($usercount>0) {
                echo "exists";
            } 
        }

        public function checknewuseremail() {
            $this->autoRender = false;
            $email = trim($_POST['email']);        
            $emailcount = $this->Users->find()->where(['Users.email'=>$email])->count();
            if($emailcount > 0) {
                echo "exists";
            } 
        }

    public function createitem($additemid = NULL)
    {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','Add');

            global $loguser;
            global $setngs;

            $this->loadModel('Shops');
            $this->loadModel('Items');
            $userid = $loguser['id'];

            if(!empty($additemid)) {
                $itemModel = $this->Items->findById($additemid)->contain(['Users'])->first();
                if($loguser['id'] != $itemModel['user']['id'] && $itemModel['status']!='things')
                {
                    $this->Flashmessage('error', 'Try again');
                    $this->redirect('/merchant/dashboard');
                }
            }

            $user_status_val = $this->Users->find()->where(['id'=>$userid])->first();
            $user_status = $user_status_val['user_status'];

            if($user_status=="disable") {
                $this->Flashmessage('error', 'Your account has been disabled please contact our support');
                $this->redirect($this->Auth->logout());
            }

            $this->loadModel('Colors');
            $this->loadModel('Languages');
            $this->loadModel('Countries');

            $color_datas = $this->Colors->find()->all();
            $this->set('color_datas',$color_datas);
            $this->set('loguser',$loguser);

            $loguserdata = $this->Users->find()->where(['Users.id'=>$userid])->contain(['Shops'])->first();
            $sellercurrency = $loguserdata['shop']['currency'];
            $sellercurrencysymbol = $loguserdata['shop']['currencysymbol'];
            $sellercountry_id = $loguserdata['shop']['country_id'];
            $this->set('sellercurrencysymbol',$sellercurrencysymbol);
            $this->set('sellercurrency',$sellercurrency);

            $languages = $this->Languages->find()->where(['countryid' => $sellercountry_id])->first();
            $sellercountryid = $languages['countryid'];
            $sellercountrydata = $this->Countries->find()->where(['id' => $sellercountryid])->first();
            $sellercountry = $sellercountrydata['country'];
            $this->set('sellercountry',$sellercountry);
            $this->set('sellercountryid',$sellercountryid);

            $forexrates = $this->Forexrates->find()->where(['currency_code' => $sellercurrency])->first();
            $sellercurrencyid = $forexrates['id'];
            $this->set('sellercurrencyid',$sellercurrencyid);

            if($loguserdata['shop']['seller_status'] != 0) {
                $this->loadModel('Categories');
                $this->loadModel('Recipients');

                $cat_datas = $this->Categories->find()->where(['category_parent' => 0, 'category_sub_parent' => 0])->all();
                $country_datas = $this->Countries->find()->order(['country' => 'ASC'])->all();

                $rcpnt_datas = $this->Recipients->find()->where(['status'=>'enable'])->order(['recipient_name' => 'ASC'])->all();

                $default_country = $this->Countries->findById($setngs['default_ship_country'])->first();

                $country = $default_country['country'];
                $cntry_code = $default_country['code'];

                foreach($country_datas as $cntry){
                    $cntrynme[$cntry['code']] = $cntry['country'];
                    $cntryid[$cntry['code']] = $cntry['id'];
                }

                $findfromitem = $this->Items->find()->where(['Items.id'=>$additemid])->first();

                $this->loadModel('Commissions');

                $commisionrate=$this->Commissions->find()->where(['active' => '1'])->all();

                $this->set('commisionrate',$commisionrate);
                $this->set('findfromitem',$findfromitem);
                $this->set('cat_datas',$cat_datas);
                $this->set('country_datas',$country_datas);
                $this->set('cntry_code',$cntry_code);
                $this->set('country',$country);
                $this->set('cntrynme',$cntrynme);
                $this->set('cntryid',$cntryid);
                $this->set('rcpnt_datas',$rcpnt_datas);
                $this->set('setngs',$setngs);
            } else if($loguserdata['shop']['paypal_id'] == '') {
            } else {
                $this->Flashmessage('error', 'Waiting for admin approval');
                $this->redirect('/merchant/dashboard');
            }
    }

        public function suprsubcategry(){
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);

            $this->autoRender = false;
            $this->loadModel('Categories');

            $cateid = $_REQUEST['cate_id'];
            $suprsub = $_REQUEST['suprsub'];

            $catsdata = "";
            $cats_arr = array();

            if($suprsub == 'yes') {
                $catsdata = $this->Categories->find()->where(['category_parent'=>$cateid, 'category_sub_parent'=>0])->toArray();
                //print_r($catsdata); die;
            } else {
                $catsdata = $this->Categories->find()->where(['category_sub_parent'=>$cateid])->toArray();
            }
            if(!empty($catsdata)){
                foreach($catsdata as $cts){
                    
                    $cats_arr[] = array('ID'=>$cts->id,'Name'=>$cts->category_name);
                }
                echo json_encode($cats_arr);
            }else{
                echo "0";
            }
            die;
    }

    public function saveitems($addedtheitemid = NULL)
    {
        if(!$this->isauthenticated())
            $this->redirect(['action' => 'login']);

        $this->autoRender = false ;

        $this->loadModel('Shops');
        $this->loadModel('Shipings');
        $this->loadModel('Photos');
        $this->loadModel('Categories');
        $this->loadModel('Items');

        global $loguser, $setngs;
        $size = ""; $unit = "";
        $userid = $loguser['id'];
        $total_quantity = 0;

        if(isset($addedtheitemid)) {
            $findfromitem = $this->Items->find()->where(['Items.id'=>$addedtheitemid])->contain(['Photos'])->first();

            $imgName = $_SESSION['site_url'].'media/items/original/'.$findfromitem['photos'][0]['image_name'];
            $result = $this->ColorCompare->compare(5, $imgName);

            $shpcnt = $this->Shops->find()->where(['user_id'=>$userid])->toArray();

            if(!empty($shpcnt)) {
                $shop_id = $shpcnt[0]['id'];
            }else{
                $shopsTable = TableRegistry::get('Shops');
                $shoparticle = $shopsTable->newEntity();
                $shoparticle->user_id = $userid;
                $shopResult = $shopsTable->save($shoparticle);
                $shop_id = $shopResult->id;
            }

            $itemsTable = TableRegistry::get('Items');
            $itemsarticle = $itemsTable->newEntity();

            $itemsarticle->user_id = $userid;
            $itemsarticle->shop_id = $shop_id;
            $title = $itemsarticle->item_title = trim($this->request->data['item_title']);
            $itemsarticle->item_title_url = $this->Urlfriendly->utils_makeUrlFriendly($title);
            $itemsarticle->item_description = trim($this->request->data['item_description']);
            $itemsarticle->videourrl = trim($this->request->data['item_videourrl']);
            $sizeavail = trim($this->request->data['sizeavail']);

            if($sizeavail == "no") {
                $itemsarticle->price = trim($this->request->data['item_price']);
                $itemsarticle->size_options = NULL;
                $total_quantity = trim($this->request->data['item_quantity']);
                if($total_quantity != '0' && $total_quantity != "")
                    $itemsarticle->quantity = trim($this->request->data['item_quantity']);
                else
                    $itemsarticle->quantity = 0;

            } else if($sizeavail == "yes") {
                $total_price = NULL;
                if(isset($this->request->data['size']) && isset($this->request->data['unit']) ) {
                    $size = $this->request->data['size'];
                    $unit = $this->request->data['unit'];
                    $prices = $this->request->data['prices'];
                }
                $propsize = trim($this->request->data['listing']['property']);
                $propunit = trim($this->request->data['listing']['size']);
                $propprice = trim($this->request->data['price']);

                if($size != '' && $unit != '') {
                    $sizeOption['size'] = $size;
                    $sizeOption['unit'] = $unit;
                    $sizeOption['price'] = $prices;

                    foreach($sizeOption['unit'] as $key => $val) {
                        $total_quantity+= $val;
                    }
                    $inr = 0;
                    foreach($sizeOption['price'] as $key => $value) {
                        if($inr == 0)
                            $total_price+= $value;
                        ++$inr;
                    }
                    $output = json_encode($sizeOption);
                    $sizeOption = $itemsarticle->size_options = $output;
                }
                else if($propsize!='' && $propunit!='' && $propprice!='')
                {
                    $sizeOption['size'][$propsize] = $propsize;
                    $sizeOption['unit'][$propsize] = $propunit;
                    $sizeOption['price'][$propsize] = $propprice;
                    foreach($sizeOption['unit'] as $key => $val)
                    {
                    $total_quantity+= $val;
                    }
                    $inr = 0;
                    foreach($sizeOption['price'] as $key => $value) {
                        if($inr == 0)
                            $total_price+= $value;
                        ++$inr;
                    }
                    $output = json_encode($sizeOption);

                    $sizeOption = $itemsarticle->size_options = $output;
                }
                $itemsarticle->quantity = $total_quantity;
                $itemsarticle->price = $total_price;
            } else {
                $itemsarticle->quantity = 0;
                $itemsarticle->price = NULL;
                $itemsarticle->size_options = NULL;
            }

            $itemsarticle->affiliate_commission = $this->request->data['affiliate_commission'];
            $itemsarticle->category_id = $this->request->data['category_id'];

            if(!empty($this->request->data['supersubcat']))
                $itemsarticle->super_catid = $this->request->data['supersubcat'];
            if(!empty($this->request->data['subcat']))
                $itemsarticle->sub_catid = $this->request->data['subcat'];

            $processing_time_id = $itemsarticle->processing_time = trim($this->request->data['processing_time_id']);

            if($processing_time_id == 'custom'){
                $itemsarticle->processing_min = $this->request->data['processing_min'];
                $itemsarticle->processing_max = $this->request->data['processing_max'];
                $itemsarticle->processing_option = $this->request->data['processing_time_units'];
            }

            $itemsarticle->created_on = date("Y-m-d H:i:s");
            $itemsarticle->status = 'draft';
            $itemsarticle->item_color = json_encode($result);
            $itemsarticle->cod = 'no';

            if (isset($this->request->data['cod']))
                $itemsarticle->cod = trim($this->request->data['cod']);

            $itemsarticle->share_coupon = trim($this->request->data['shareCoupon']);

            if (!empty($this->request->data['share_discountAmnt']))
                $itemsarticle->share_discountAmount = trim($this->request->data['share_discountAmnt']);
            else
                $itemsarticle->share_discountAmount = 0;

            $itemsResult = $itemsTable->save($itemsarticle);
            $last_id = $itemsResult->id;

            $cat_id_shop= trim($this->request->data['category_id']);
            $shop_det = $this->Shops->find()->where(['user_id'=>$userid])->first();
            $cat_shop = $shop_det['shop_category'];

            $shopsUpdateTable = TableRegistry::get('Shops');
            $query = $shopsUpdateTable->query();
            if(empty($cat_shop)){
                $cat_id = $cat_id_shop;
                $query->update()->set(['shop_category' => $cat_id])->where(['user_id'=>$userid])->execute();
            } else {
                $cat_val = json_decode($cat_shop);
                if(!in_array($cat_id_shop,$cat_val)){
                $cat_dats = array_push($cat_val, $cat_id_shop);
                $cat_id_val = json_encode($cat_val);
                $query->update()->set(['shop_category' => $cat_id_val])->where(['user_id'=>$userid])->execute();
                } else {
                $query->update()->set(['shop_category' => $cat_shop])->where(['user_id'=>$userid])->execute();
                }
            }

            if(!empty($findfromitem['photos'][0]['image_name'])){
                $photosTable = TableRegistry::get('Photos');
                $photosarticle = $photosTable->newEntity();
                $photosarticle->item_id = $last_id;
                $photosarticle->image_name = $findfromitem['photos'][0]['image_name'];
                $photosarticle->created_on = date("Y-m-d H:i:s");
                $photosTable->save($photosarticle);
            }

            $count = 0;
            if(count($this->request->data['data']['image'])>1) {
                for($i=1;$i<count($this->request->data['data']['image']);$i++) {
                $my_file = WEBROOTPATH.'media/temp/thumb350/'.$this->request->data['data']['image'][$i];
                $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
                $data = fread($handle,filesize($my_file));
                $my_file1 = WEBROOTPATH.'media/items/thumb350/'.$this->request->data['data']['image'][$i];
                $handle1 = fopen($my_file1, 'w') or die('Cannot open file:  '.$my_file1);
                fwrite($handle1, $data);

                $my_file2 = WEBROOTPATH.'media/temp/thumb150/'.$this->request->data['data']['image'][$i];
                $handle2 = fopen($my_file2, 'r') or die('Cannot open file:  '.$my_file2);
                $data2 = fread($handle2,filesize($my_file2));
                $my_file3 = WEBROOTPATH.'media/items/thumb150/'.$this->request->data['data']['image'][$i];
                $handle3 = fopen($my_file3, 'w') or die('Cannot open file:  '.$my_file3);
                fwrite($handle3, $data2);

                $my_file4 = WEBROOTPATH.'media/temp/thumb70/'.$this->request->data['data']['image'][$i];
                $handle4 = fopen($my_file4, 'r') or die('Cannot open file:  '.$my_file4);
                $data4 = fread($handle4,filesize($my_file4));
                $my_file5 = WEBROOTPATH.'media/items/thumb70/'.$this->request->data['data']['image'][$i];
                $handle5 = fopen($my_file5, 'w') or die('Cannot open file:  '.$my_file5);
                fwrite($handle5, $data4);

                $my_file6 = WEBROOTPATH.'media/temp/original/'.$this->request->data['data']['image'][$i];
                $handle6 = fopen($my_file6, 'r') or die('Cannot open file:  '.$my_file6);
                $data6 = fread($handle6,filesize($my_file6));
                $my_file7 = WEBROOTPATH.'media/items/original/'.$this->request->data['data']['image'][$i];
                $handle7 = fopen($my_file7, 'w') or die('Cannot open file:  '.$my_file7);
                fwrite($handle7, $data6);

                if(!empty($this->request->data['data']['image'][$i])) {
                    $photosTable = TableRegistry::get('Photos');
                    $photosarticle = $photosTable->newEntity();
                    $photosarticle->item_id = $last_id;
                    $photosarticle->image_name = $this->request->data['data']['image'][$i];
                    $photosarticle->created_on = date("Y-m-d H:i:s");
                    $photosTable->save($photosarticle);

                }
                }
            }

            if(!empty($_REQUEST['country_shipping'])){
                foreach($_REQUEST['country_shipping'] as $kys=>$shpngcntry){
                foreach($shpngcntry as $shps){
                    $shipingsTable = TableRegistry::get('Shipings');
                    $shipingsarticle = $shipingsTable->newEntity();
                    $shipingsarticle->item_id = $last_id;
                    $shipingsarticle->country_id = $kys;
                    $shipingsarticle->primary_cost = $shps['primary'];
                    $shipingsarticle->created_on = date("Y-m-d H:i:s");
                    $shipingsTable->save($shipingsarticle);
                }
                }
            }
            if(trim($_REQUEST['everywhere_shipping'][1]['primary'])!="") {
                $shipingsTable = TableRegistry::get('Shipings');
                $shipingsarticle = $shipingsTable->newEntity();
                $shipingsarticle->item_id = $last_id;
                $shipingsarticle->country_id = 0;
                $shipingsarticle->primary_cost = trim($_REQUEST['everywhere_shipping'][1]['primary']);
                $shipingsarticle->created_on = date("Y-m-d H:i:s");
                $shipingsTable->save($shipingsarticle);
            }
            $this->Flashmessage('success', "Item added successfully, waiting for admin approval");
            $this->redirect('/merchant/editproducts');
        }
        // New Item Updation for shop

        for($i=0;$i<1;$i++) {
            if(!empty($this->request->data['data']['image'][$i])){
                $imgName = $_SESSION['site_url'].'media/temp/original/'.$this->request->data['data']['image'][$i];
                $result = $this->ColorCompare->compare(5, $imgName);
            }
        }

        $shpcnt = $this->Shops->find()->where(['user_id'=>$userid])->toArray();

        if(!empty($shpcnt)) {
            $shop_id = $shpcnt[0]['id'];
        }else{
            $shopsTable = TableRegistry::get('Shops');
            $shoparticle = $shopsTable->newEntity();
            $shoparticle->user_id = $userid;
            $shopResult = $shopsTable->save($shoparticle);
            $shop_id = $shopResult->id;
        }

        $itemsTable = TableRegistry::get('Items');
        $itemsarticle = $itemsTable->newEntity();

        $itemsarticle->user_id = $userid;
        $itemsarticle->shop_id = $shop_id;
        $title = $itemsarticle->item_title = trim($this->request->data['item_title']);
        $itemsarticle->skuid = trim($this->request->data['item_skuid']);
        $itemsarticle->item_title_url = $this->Urlfriendly->utils_makeUrlFriendly($title);
        $itemsarticle->item_description = trim($this->request->data['item_description']);
        $itemsarticle->videourrl = trim($this->request->data['item_videourrl']);

        /*
        if($this->request->data['deal'] == 'yes') {
            $discount = trim($this->request->data['discount']);
            $dealdate = date('Y-m-d',strtotime(trim($this->request->data['dealstart'])));

            $itemsarticle->dailydeal = $this->request->data['deal'];
            $itemsarticle->discount = $discount;
            $itemsarticle->dealdate = $dealdate;
        } else {
            $itemsarticle->dailydeal = $this->request->data['deal'];
        }*/



        if($this->request->data['deal'] == 'daily') {
                //echo 'daily'; die;

                $discount = trim($this->request->data['discount']);
                $dealdate = date('Y-m-d',strtotime(trim($this->request->data['dealstart'])));
                $itemsarticle->dailydeal = $this->request->data['dealstart'];
                $itemsarticle->discount = $discount;
                $itemsarticle->discount_type = 'daily';
                $itemsarticle->dealdate = $dealdate;
            }elseif($this->request->data['deal'] == 'regular'){

                //echo 'regular'; die;
                //$itemsarticle->dailydeal = $this->request->data['deal'];
                $discount = trim($this->request->data['regular_discount']);
                $itemsarticle->discount_type = 'regular';
                //echo 'i'; die;
                $itemsarticle->discount = $discount;
            }elseif($this->request->data['deal'] == 'no'){
                //echo 'no'; die;

                $itemsarticle->discount_type = 'no';
            }

        $sizeavail = trim($this->request->data['sizeavail']);

            if($sizeavail == "no") {
                $itemsarticle->price = trim($this->request->data['item_price']);
                $itemsarticle->size_options = NULL;
                $total_quantity = trim($this->request->data['item_quantity']);
                if($total_quantity != '0' && $total_quantity != "")
                    $itemsarticle->quantity = trim($this->request->data['item_quantity']);
                else
                    $itemsarticle->quantity = 0;

            } else if($sizeavail == "yes") {
                $total_price = NULL;
                if(isset($this->request->data['size']) && isset($this->request->data['unit']) ) {
                    $size = $this->request->data['size'];
                    $unit = $this->request->data['unit'];
                    $prices = $this->request->data['prices'];
                }
                $propsize = trim($this->request->data['listing']['property']);
                $propunit = trim($this->request->data['listing']['size']);
                $propprice = trim($this->request->data['price']);

                if($size != '' && $unit != '') {
                    $sizeOption['size'] = $size;
                    $sizeOption['unit'] = $unit;
                    $sizeOption['price'] = $prices;

                    foreach($sizeOption['unit'] as $key => $val) {
                        $total_quantity+= $val;
                    }
                    $inr = 0;
                    foreach($sizeOption['price'] as $key => $value) {
                        if($inr == 0)
                            $total_price+= $value;
                        ++$inr;
                    }
                    $output = json_encode($sizeOption);
                    $sizeOption = $itemsarticle->size_options = $output;
                }
                else if($propsize!='' && $propunit!='' && $propprice!='')
                {
                    $sizeOption['size'][$propsize] = $propsize;
                    $sizeOption['unit'][$propsize] = $propunit;
                    foreach($sizeOption['unit'] as $key => $val)
                    {
                    $total_quantity+= $val;
                    }
                    $sizeOption['price'][$propsize] = $propprice;
                    $inr = 0;
                    foreach($sizeOption['price'] as $key => $value) {
                        if($inr == 0)
                            $total_price+= $value;
                        ++$inr;
                    }
                    $output = json_encode($sizeOption);

                    $sizeOption = $itemsarticle->size_options = $output;
                }
                $itemsarticle->quantity = $total_quantity;
                $itemsarticle->price = $total_price;
            } else {
                $itemsarticle->quantity = 0;
                $itemsarticle->price = NULL;
                $itemsarticle->size_options = NULL;
            }

        $itemsarticle->category_id = $this->request->data['category_id'];
        $itemsarticle->affiliate_commission = $this->request->data['affiliate_commission'];

        if(!empty($this->request->data['supersubcat']))
            $itemsarticle->super_catid = $this->request->data['supersubcat'];
        if(!empty($this->request->data['subcat']))
            $itemsarticle->sub_catid = $this->request->data['subcat'];

        if(!empty($this->request->data['data']['Item']['currencyid']))
            $itemsarticle->currencyid = $this->request->data['data']['Item']['currencyid'];
        if(!empty($this->request->data['data']['Item']['countryid']))
            $itemsarticle->countryid = $this->request->data['data']['Item']['countryid'];

        $processing_time_id = $itemsarticle->processing_time = trim($this->request->data['processing_time_id']);

        if($processing_time_id == 'custom'){
            $itemsarticle->processing_min = $this->request->data['processing_min'];
            $itemsarticle->processing_max = $this->request->data['processing_max'];
            $itemsarticle->processing_option = $this->request->data['processing_time_units'];
        }


        $categoryid = $this->request->data['category_id'];
        $catcount = $this->Categories->find()->where(['id'=>$categoryid])->first();
        $count = $catcount['count_itemcat'];

        $catTable = TableRegistry::get('Categories');
        $catarticle = $catTable->get($categoryid);
        $count = $count+1;
        $catarticle->count_itemcat = $count;
        $catTable->save($catarticle);

        if(trim($this->request->data['colormethod']) == "auto") {
            $result = json_encode($result);
            $itemsarticle->item_color = $result;
            $itemsarticle->item_color_method = '0';
        } else if(trim($this->request->data['colormethod']) == "manual") {
            $result = json_encode($this->request->data['itemcolor']);
            $itemsarticle->item_color = $result;
            $itemsarticle->item_color_method = '1';
        } else {
            $result = json_encode($result);
            $itemsarticle->item_color = $result;
            $itemsarticle->item_color_method = '0';
        }

        $itemsarticle->created_on = date("Y-m-d H:i:s");
        $itemsarticle->status = 'draft';
        $itemsarticle->cod = 'no';

        if (isset($this->request->data['cod']))
            $itemsarticle->cod = trim($this->request->data['cod']);

        $itemsarticle->share_coupon = trim($this->request->data['shareCoupon']);

        if (!empty($this->request->data['share_discountAmnt']))
            $itemsarticle->share_discountAmount = trim($this->request->data['share_discountAmnt']);
        else
            $itemsarticle->share_discountAmount = 0;

        $itemsResult = $itemsTable->save($itemsarticle);
        $last_id = $itemsResult->id;

        foreach($this->request->data['data']['image'] as $imageKey => $imageName){
            $my_file = WEBROOTPATH.'media/temp/thumb350/'.$imageName;
            $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
            $data = fread($handle,filesize($my_file));
            $my_file1 = WEBROOTPATH.'media/items/thumb350/'.$imageName;
            $handle1 = fopen($my_file1, 'w') or die('Cannot open file:  '.$my_file1);
            fwrite($handle1, $data);

            $my_file2 = WEBROOTPATH.'media/temp/thumb150/'.$imageName;
            $handle2 = fopen($my_file2, 'r') or die('Cannot open file:  '.$my_file2);
            $data2 = fread($handle2,filesize($my_file2));
            $my_file3 = WEBROOTPATH.'media/items/thumb150/'.$imageName;
            $handle3 = fopen($my_file3, 'w') or die('Cannot open file:  '.$my_file3);
            fwrite($handle3, $data2);

            $my_file4 = WEBROOTPATH.'media/temp/thumb70/'.$imageName;
            $handle4 = fopen($my_file4, 'r') or die('Cannot open file:  '.$my_file4);
            $data4 = fread($handle4,filesize($my_file4));
            $my_file5 = WEBROOTPATH.'media/items/thumb70/'.$imageName;
            $handle5 = fopen($my_file5, 'w') or die('Cannot open file:  '.$my_file5);
            fwrite($handle5, $data4);

            $my_file6 = WEBROOTPATH.'media/temp/original/'.$imageName;
            $handle6 = fopen($my_file6, 'r') or die('Cannot open file:  '.$my_file6);
            $data6 = fread($handle6,filesize($my_file6));
            $my_file7 = WEBROOTPATH.'media/items/original/'.$imageName;
            $handle7 = fopen($my_file7, 'w') or die('Cannot open file:  '.$my_file7);
            fwrite($handle7, $data6);

            if(!empty($imageName)){
                $photosTable = TableRegistry::get('Photos');
                $photosarticle = $photosTable->newEntity();
                $photosarticle->item_id = $last_id;
                $photosarticle->image_name = $imageName;
                $photosarticle->created_on = date("Y-m-d H:i:s");
                $photosTable->save($photosarticle);
            }
        }

        if(!empty($_REQUEST['country_shipping'])){
            foreach($_REQUEST['country_shipping'] as $kys=>$shpngcntry){
                foreach($shpngcntry as $shps){
                $shipingsTable = TableRegistry::get('Shipings');
                $shipingsarticle = $shipingsTable->newEntity();
                $shipingsarticle->item_id = $last_id;
                $shipingsarticle->country_id = $kys;
                $shipingsarticle->primary_cost = $shps['primary'];
                $shipingsarticle->created_on = date("Y-m-d H:i:s");
                $shipingsTable->save($shipingsarticle);
                }
            }
        }
        if(trim($_REQUEST['everywhere_shipping'][1]['primary'])!="") {
            $shipingsTable = TableRegistry::get('Shipings');
            $shipingsarticle = $shipingsTable->newEntity();
            $shipingsarticle->item_id = $last_id;
            $shipingsarticle->country_id = 0;
            $shipingsarticle->primary_cost = trim($_REQUEST['everywhere_shipping'][1]['primary']);
            $shipingsarticle->created_on = date("Y-m-d H:i:s");
            $shipingsTable->save($shipingsarticle);
        }

        //email process

        $emailaddress = $setngs['notification_email'];
        $item_name = $this->Items->find()->where(['Items.id'=>$last_id])->first();
        $itemname = $item_name['item_title'];
        $quantity = $item_name['quantity'];
        $itemprice = $item_name['price'];
        $sizeoptions = $item_name['size_options'];
        $username = $loguser['username'];

        if($setngs['gmail_smtp'] == 'enable'){
            // Email Pending
        }

        $this->set('username', $username);
        $this->set('email', $emailaddress);
        $this->set('itemname',$itemname);
        $this->set('quantity',$quantity);
        $this->set('itemprice',$itemprice);
        $this->set('sizeoptions',$sizeoptions);
        $this->set('access_url',SITE_URL."merchant/login");

        $this->Flashmessage('success', "Item added successfully, waiting for admin approval");
        $this->redirect('/merchant/editproducts');
    }

    public function updateproducts($sdate = NULL ,$edate = NULL)
    {
        if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','My Sales');

        if($sdate > $edate)
                $this->Flashmessage('error', 'Error in search date','editproducts');

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->loadModel('Items');
        $userid = $loguser['id'];
        $item_datas = "";

        if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
        {
            $sdate = date("Y-m-d H:i:s", $sdate);
            $edate =  date("Y-m-d H:i:s", $edate);

            $item_datas = $this->Items->find()->where(['Items.user_id'=>$userid])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('Items.created_on', $sdate, $edate); })->order(['Items.id'=>'desc'])->all();
        } else {
            $item_datas =  $this->Items->find()->where(['Items.user_id'=>$userid])->order(['modified_on' => 'DESC'])->toArray();
        }

        $this->set('item_datas',$item_datas);
        $this->set('sdate',$sdate);
        $this->set('edate',$edate);
    }

    public function editselleritem($id){
        if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Edit Item');

        global $setngs;
        global $loguser;
        $size = ""; $unit = "";
        $total_quantity = 0;

        $userid = $loguser['id'];

        $this->loadModel('Items');
        $this->loadModel('Categories');
        $this->loadModel('Countries');
        $this->loadModel('Recipients');
        $this->loadModel('Photos');
        $this->loadModel('Languages');
        $this->loadModel('Colors');
        $this->loadModel('Commissions');

        $color_datas = $this->Colors->find()->all();
        $this->set('color_datas',$color_datas);
        $this->set('loguser',$loguser);

        $commisionrate = $this->Commissions->find()->where(['active' => '1'])->all();
        $this->set('commisionrate',$commisionrate);

        $loguserdata = $this->Users->find()->where(['Users.id'=>$userid])->contain(['Shops'])->first();
        $sellercurrency = $loguserdata['shop']['currency'];
        $sellercurrencysymbol = $loguserdata['shop']['currencysymbol'];
        $sellercountry_id = $loguserdata['shop']['country_id'];
        $this->set('sellercurrencysymbol',$sellercurrencysymbol);
        $this->set('sellercurrency',$sellercurrency);

        $languages = $this->Languages->find()->where(['countryid' => $sellercountry_id])->first();
        $sellercountryid = $languages['countryid'];
        $sellercountrydata = $this->Countries->find()->where(['id' => $sellercountryid])->first();
        $sellercountry = $sellercountrydata['country'];
        $this->set('sellercountry',$sellercountry);
        $this->set('sellercountryid',$sellercountryid);

        if(!empty($id)) {
            $itemModel = $this->Items->findById($id)->contain(['Users'])->first();
            if($loguser['id'] != $itemModel['user']['id'])
            {
                $this->Flashmessage('error', 'Try again');
                $this->redirect('/merchant/dashboard');
            }
        } else {
            $this->Flashmessage('error', 'Try again');
            $this->redirect('/merchant/editproducts');
        }

        $itemModel = $this->Items->findById($id)->contain(['Users', 'Photos'])->first();
        if(empty($itemModel)) {
            $this->Flashmessage('error', 'Try again');
            $this->redirect('/merchant/editproducts');
        }

        if ($this->request->is('post')) {
            $this->loadModel('Shops');

            for($i=0;$i<1;$i++) {
                if(!empty($this->request->data['data']['image'][$i])){
                $imgName = $_SESSION['site_url'].'media/temp/original/'.$this->request->data['data']['image'][$i];
                $result = $this->ColorCompare->compare(5, $imgName);
                }
            }

            $itemsTable = TableRegistry::get('Items');
            $itemsarticle = $itemsTable->get($id);

            $itemsarticle->user_id = $itemModel['user_id'];
            $itemsarticle->shop_id = $itemModel['shop_id'];

            $title = $itemsarticle->item_title = trim($this->request->data['item_title']);
            $itemsarticle->skuid = trim($this->request->data['item_skuid']);
            $itemsarticle->item_title_url = $this->Urlfriendly->utils_makeUrlFriendly($title);
            $itemsarticle->item_description = trim($this->request->data['item_description']);
            $itemsarticle->recipient = NULL;
            $itemsarticle->videourrl = trim($this->request->data['item_videourrl']);

            if($this->request->data['deal'] == 'daily') {
                $discount = trim($this->request->data['discount']);
                $dealdate = date('Y-m-d',strtotime(trim($this->request->data['dealstart'])));
                $itemsarticle->dailydeal = $this->request->data['dealstart'];
                $itemsarticle->discount = $discount;
                $itemsarticle->discount_type = 'daily';
                $itemsarticle->dealdate = $dealdate;
            } elseif($this->request->data['deal'] == 'regular'){
                //$itemsarticle->dailydeal = $this->request->data['deal'];
                $discount = trim($this->request->data['regular_discount']);
                $itemsarticle->discount_type = 'regular';
                //echo 'i'; die;
                $itemsarticle->discount = $discount;
            }elseif($this->request->data['deal'] == 'no'){
                $itemsarticle->discount_type = 'no';
            }

            $sizeavail = trim($this->request->data['sizeavail']);

            if($sizeavail == "no") {
                $itemsarticle->price = trim($this->request->data['item_price']);
                $itemsarticle->size_options = NULL;
                $total_quantity = trim($this->request->data['item_quantity']);
                if($total_quantity != '0' && $total_quantity != "")
                    $itemsarticle->quantity = trim($this->request->data['item_quantity']);
                else
                    $itemsarticle->quantity = 0;

            } else if($sizeavail == "yes") {
                $total_price = NULL;
                if(isset($this->request->data['size']) && isset($this->request->data['unit']) ) {
                    $size = $this->request->data['size'];
                    $unit = $this->request->data['unit'];
                    $prices = $this->request->data['prices'];
                }
                $propsize = trim($this->request->data['listing']['property']);
                $propunit = trim($this->request->data['listing']['size']);
                $propprice = trim($this->request->data['price']);

                if($size != '' && $unit != '') {
                    $sizeOption['size'] = $size;
                    $sizeOption['unit'] = $unit;
                    $sizeOption['price'] = $prices;

                    foreach($sizeOption['unit'] as $key => $val) {
                        $total_quantity+= $val;
                    }
                    $inr = 0;
                    foreach($sizeOption['price'] as $key => $value) {
                        if($inr == 0)
                            $total_price+= $value;
                        ++$inr;
                    }
                    $output = json_encode($sizeOption);
                    $sizeOption = $itemsarticle->size_options = $output;
                }
                else if($propsize!='' && $propunit!='' && $propprice!='')
                {
                    $sizeOption['size'][$propsize] = $propsize;
                    $sizeOption['unit'][$propsize] = $propunit;
                    $sizeOption['price'][$propsize] = $propprice;
                    foreach($sizeOption['unit'] as $key => $val)
                    {
                    $total_quantity+= $val;
                    }
                    $inr = 0;
                    foreach($sizeOption['price'] as $key => $value) {
                        if($inr == 0)
                            $total_price+= $value;
                        ++$inr;
                    }
                    $output = json_encode($sizeOption);
                    $sizeOption = $itemsarticle->size_options = $output;
                }
                $itemsarticle->quantity = $total_quantity;
                $itemsarticle->price = $total_price;
            } else {
                $itemsarticle->quantity = 0;
                $itemsarticle->price = NULL;
                $itemsarticle->size_options = NULL;
            }

            $itemsarticle->affiliate_commission = $this->request->data['affiliate_commission'];
            $itemsarticle->category_id = $this->request->data['category_id'];

            if(!empty($this->request->data['supersubcat']))
                $itemsarticle->super_catid = $this->request->data['supersubcat'];
            if(!empty($this->request->data['subcat']))
                $itemsarticle->sub_catid = $this->request->data['subcat'];


            $processing_time_id = $itemsarticle->processing_time = trim($this->request->data['processing_time_id']);

            if($processing_time_id == 'custom'){
                $itemsarticle->processing_min = $this->request->data['processing_min'];
                $itemsarticle->processing_max = $this->request->data['processing_max'];
                $itemsarticle->processing_option = $this->request->data['processing_time_units'];
            }


            $categoryid = $this->request->data['category_id'];
            $itemcategoryid = $itemModel['category_id'];

            $catcount = $this->Categories->find()->where(['id'=>$itemcategoryid])->first();
            $itemcatcount = $catcount['count_itemcat'];

            $catcount1 = $this->Categories->find()->where(['id'=>$categoryid])->first();
            $count = $catcount1['count_itemcat'];

            $catTable = TableRegistry::get('Categories');
            $catarticle = $catTable->get($itemcategoryid);
            $itemcatcount = $itemcatcount-1;
            $catarticle->count_itemcat = $itemcatcount;
            $catTable->save($catarticle);

            $catsarticle = $catTable->get($categoryid);
            $count = $count+1;
            $catsarticle->count_itemcat = $count;
            $catTable->save($catsarticle);

            if(trim($this->request->data['colormethod']) == "auto") {
                $result = json_encode($result);
                $itemsarticle->item_color = $result;
                $itemsarticle->item_color_method = '0';
            } else if(trim($this->request->data['colormethod']) == "manual") {
                $result = json_encode($this->request->data['itemcolor']);
                $itemsarticle->item_color = $result;
                $itemsarticle->item_color_method = '1';
            } else {
                $result = json_encode($result);
                $itemsarticle->item_color = $result;
                $itemsarticle->item_color_method = '0';
            }

            $itemsarticle->modified_on = date("Y-m-d H:i:s");
            $itemsarticle->status = 'draft';
            $itemsarticle->cod = 'no';

            if (isset($this->request->data['cod']))
                $itemsarticle->cod = trim($this->request->data['cod']);

            $itemsarticle->share_coupon = trim($this->request->data['shareCoupon']);

            if (!empty($this->request->data['share_discountAmnt']))
                $itemsarticle->share_discountAmount = trim($this->request->data['share_discountAmnt']);
            else
                $itemsarticle->share_discountAmount = 0;

            $itemsResult = $itemsTable->save($itemsarticle);
            $last_id = $id;

            // IMAGE UPDATION
            $count = 0;
            $photosTable = TableRegistry::get('Photos');

            foreach ($itemModel['photos'] as $photo){
                if(!empty($this->request->data['data']['image'][$count])){
                $imageName = $photo['image_name'];
                if ($imageName == $this->request->data['data']['image'][$count]){
                    $count += 1;
                }else {
                    $photosarticle = $photosTable->get($photo['id']);
                    $photosarticle->image_name = $this->request->data['data']['image'][$count];
                    $photosarticle->created_on = date("Y-m-d H:i:s");
                    $photosTable->save($photosarticle);
                    $count += 1;
                }
                } elseif($this->request->data['data']['image'][$count] == ""){
                $query = $photosTable->query();
                $query->delete()
                    ->where(['id' => $photo['id']])
                    ->execute();
                $count += 1;
                }
            }

            for($i=$count;$i<count($this->request->data['data']['image']);$i++){
                if(!empty($this->request->data['data']['image'][$i])){
                $photosarticle = $photosTable->newEntity();
                $photosarticle->item_id = $last_id;
                $photosarticle->image_name=$this->request->data['data']['image'][$i];
                $photosarticle->created_on = date("Y-m-d H:i:s");
                $photosTable->save($photosarticle);
                }
            }


            $this->loadModel('Shipings');

            if(!empty($_REQUEST['country_shipping'])){
                foreach($_REQUEST['country_shipping'] as $kys=>$shpngcntry){
                foreach($shpngcntry as $shps){

                    $shipModel = $this->Shipings->find()->where(['Shipings.country_id' => $kys,'Shipings.item_id' => $last_id])->first();
                    $primaryCost = $shps['primary'];

                    $shipingsTable = TableRegistry::get('Shipings');
                    if (empty($shipModel) && $primaryCost != '') {
                        $shipingsarticle = $shipingsTable->newEntity();
                        $shipingsarticle->item_id = $last_id;
                        $shipingsarticle->country_id = $kys;
                        $shipingsarticle->primary_cost = $shps['primary'];
                        $shipingsarticle->created_on = date("Y-m-d H:i:s");
                        $shipingsTable->save($shipingsarticle);
                        $updatedCountryId[] = $kys;
                    } elseif($shipModel['country_id']!=0 && $primaryCost != '') {
                        if ($shps['primary'] != $shipModel['primary_cost']){
                            $shipingsarticle = $shipingsTable->get($shipModel['id']);
                            $shipingsarticle->primary_cost = $shps['primary'];
                            $shipingsarticle->created_on = date("Y-m-d H:i:s");
                            $shipingsTable->save($shipingsarticle);
                        }
                        $updatedCountryId[] = $kys;
                    }
                }
                }
            }

            if(trim($_REQUEST['everywhere_shipping'][1]['primary'])!="") {
                $primaryCost = $_REQUEST['everywhere_shipping'][1]['primary'];
                $shipModel = $this->Shipings->find()->where(['Shipings.country_id'=>'0','Shipings.item_id'=>$last_id])->first();
                $shipingsTable = TableRegistry::get('Shipings');
                if(empty($shipModel) && $primaryCost != ''){
                $shipingsarticle = $shipingsTable->newEntity();
                $shipingsarticle->item_id = $last_id;
                $shipingsarticle->country_id = 0;
                $shipingsarticle->primary_cost = trim($_REQUEST['everywhere_shipping'][1]['primary']);
                $shipingsarticle->created_on = date("Y-m-d H:i:s");
                $shipingsTable->save($shipingsarticle);
                $updatedCountryId[] = 0;
                } else {
                $newCost = $_REQUEST['everywhere_shipping'][1]['primary'];
                $oldCost = $shipModel['primary_cost'];
                if ($newCost != $oldCost && $primaryCost != ''){
                    $shipingsarticle = $shipingsTable->get($shipModel['id']);
                    $shipingsarticle->country_id = 0;
                    $shipingsarticle->primary_cost = $newCost;
                    $shipingsarticle->created_on = date("Y-m-d H:i:s");
                    $shipingsTable->save($shipingsarticle);
                }
                $updatedCountryId[] = 0;
                }
            }
            
            if (count($updatedCountryId) > 0) {
                $shipModel = $this->Shipings->find()->where(['Shipings.item_id'=>$last_id, 'Shipings.country_id NOT IN' => $updatedCountryId])->all();

                if(!empty($shipModel)){
                $shipingstable = TableRegistry::get('Shipings');
                foreach($shipModel as $ship){
                    $query = $shipingstable->query();
                    $query->delete()
                        ->where(['id' => $ship['id']])
                        ->execute();
                }
                }
            }

            //email process

            $emailaddress = $setngs['notification_email'];
            $item_name = $this->Items->find()->where(['Items.id'=>$last_id])->first();
            $itemname = $item_name['item_title'];
            $quantity = $item_name['quantity'];
            $itemprice = $item_name['price'];
            $sizeoptions = $item_name['size_options'];
            $username = $loguser['username'];

            if($setngs['gmail_smtp'] == 'enable'){
                // Email Pending
            }
            $this->redirect('/merchant/editproducts');
        }


        $itemModel = $this->Items->findById($id)->contain(['Shipings'=> [
            'sort' => ['Shipings.country_id' => 'DESC']], 'Photos'])->first();

        $cat_datas = $this->Categories->find()->where(['category_parent'=>0, 'category_sub_parent'=>0])->all();

        $superSub_data = $this->Categories->find()->where(['category_parent'=>$itemModel['category_id'],'category_sub_parent'=>0])->toArray();

        $Sub_data = $this->Categories->find()->where(['category_parent'=>$itemModel['category_id'],'category_sub_parent'=>$itemModel['super_catid']])->toArray();

        $rcpnt_datas = $this->Recipients->find()->where(['status'=>'enable'])->order(['recipient_name' => 'ASC'])->all();

        $shipingId = array();
        $countryName = array();
        $cntryid = "";

        foreach ($itemModel['shipings'] as $ship){
            $shipingId[]  = $ship['country_id'];
            $cntryid = $ship['country_id'];
        }
        $countries = $this->Countries->find()->all();
        if(count($shipingId)>0)
        {
            $CountryModel = $this->Countries->find()->where(['id IN'=>$shipingId])->all();

            foreach($CountryModel as $country){
                $countryName[$country['id']] = $country['country'];
            }
        }

        $this->set('item',$itemModel);
        $this->set('cat_datas',$cat_datas);
        $this->set('superSub_datas',$superSub_data);
        $this->set('Sub_datas',$Sub_data);
        $this->set('rcpnt_datas',$rcpnt_datas);
        $this->set('countryName',$countryName);
        $this->set('cntry',$countries);
        $this->set('cntryid',$cntryid);
        $this->set('itemId',$id);
        $this->set('setngs',$setngs);
    }

    public function userphotoupload() {

        if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
        $this->viewBuilder()->setLayout('merchanthome');
    
        $this->set('title_for_layout','My Sales');
        global $loguser;
        $userid = $loguser['id'];

        $first_name = $loguser['first_name'];
        $this->set('first_name',$first_name);
        $this->set('loguser', $loguser);

        $itemModel = array();
        $fashionModel = array();

        $this->loadModel('Orders');
        $this->loadModel('OrderItems');
        $this->loadModel('Items');
        $this->loadModel('Forexrates');

        $itemcreateduserid = $this->Items->find()->where(['Items.user_id'=>$userid])->order(['Items.id'=>'DESC'])->all();
        if(count($itemcreateduserid) > 0) {
            foreach($itemcreateduserid as $itemuserids){
                $itemUserids[] = $itemuserids['id'];
            }

            $this->loadModel('Fashionusers');

            $fashionModel = $this->Fashionusers->find()->where(['Fashionusers.itemId IN'=>$itemUserids])->contain(['Users', 'Items'])->order(['Fashionusers.id'=>'desc'])->all();
        }

        $this->set('fashionuser',$fashionModel);

    }

    public function deletefaq($id=NULL)
    {

        $this->loadModel('Productfaq');
        $productfaqtable = TableRegistry::get('Productfaq');
        $query = $productfaqtable->query();
        $query->delete()->where(['id' => $id])->execute(); 
        echo "true";  
        die;
    }

    public function deleteitemfashion($id = NULL) {
        $this->autoRender = false;
        global $loguser;

        $this->loadModel('Fashionusers');
        $this->loadModel('Items');
        $fusersTable = TableRegistry::get('Fashionusers');

        $fashionModel = $this->Fashionusers->findById($id)->first();
        if(count($fashionModel) > 0 && !empty(trim($id))) {
            $itemModel = $this->Items->findById($fashionModel['itemId'])->first();
            if(count($itemModel) > 0 && ($itemModel['user_id'] == $loguser['id'])) {
                $fashionbuyer =  $this->Fashionusers->find()->where(['id'=>$id])->first();
                $result = $fusersTable->delete($fusersTable->get($id));
                if(!empty(trim($result)) && trim($result)==1) {
                $this->loadModel('Logs');
                $logsdata =$this->Logs->find()->where(['itemid'=>$fashionbuyer['itemId'], 'sourceid'=>$id, 'type'=>'fashionimage'])->first();
                if(count($logsdata) > 0) {
                    $logstable = TableRegistry::get('Logs');
                    $query = $logstable->query();
                    $query->delete()->where(['id' => $logsdata['id']])->execute();
                }
                echo "true";
                $this->Flashmessage('success', "Product selfie deleted successfully");
                } else
                echo "false";
            }else
            echo "false";
        } else
        echo "false";
    }

    public function updatephotofashion() {
        $this->autoRender = FALSE;

        $value = trim($_POST['value']);
        $id = trim($_POST['id']);

        global $loguser;

        $this->loadModel('Fashionusers');
        $this->loadModel('Items');

        $fusersTable = TableRegistry::get('Fashionusers');
        $fuserarticle = $fusersTable->get($id);
        if($value == '1') {
            $fuserarticle->status = 'Yes';
            $fashionnotify_msg = "accepted";
            $this->Flashmessage('success', "Product selfie accepted successfully");
        } else {
            $fuserarticle->status = 'No';
            $fashionnotify_msg = "declined";
            $this->Flashmessage('success', "Product selfie declined successfully");
        }
        $Result = $fusersTable->save($fuserarticle);
        $fashionbuyer =  $this->Fashionusers->find()->where(['id'=>$id])->first();
        if($value == '1') {
            $sellername = $loguser['username'];

            if(count($fashionbuyer) > 0) {
                //email
                $buyer = $this->Users->findById($fashionbuyer['user_id'])->first();
                $items = $this->Items->findById($fashionbuyer['itemId'])->first();
                $aSubject = $sellername." – ".__d('merchant','Seller accepted your selfie on product')." ".$items['item_title'];
                $aBody='';
                $template='merchantselfies';

                $setdata=array('name'=>$buyer['username'], 'seller'=>$sellername, 'fashionbuyer'=>$fashionbuyer, 'setngs'=> $setngs, 'items'=> $items);

                $mailcheck = $this->sendmail($buyer['email'],$aSubject,$aBody,$template,$setdata);

                //livefeeds
                $logusername = $loguser['username'];
                $logusrid = $loguser['id'];
                $buyerid = $buyer['id'];
                $sellerImg = $loguser['profile_image'];
                $logusernameurl = $loguser['username_url'];
                if (empty($userImg)){
                $sellerImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL."people/".$logusernameurl;
                $loguserimage = json_encode($image);
                $notifymsg = $sellername." -___- ".$fashionnotify_msg." your selfie on product -___- ".$items['item_title'];
                $logdetails = $this->addloglive('fashionimage',$logusrid,$buyerid,$id,$notifymsg,'',$loguserimage,$fashionbuyer['itemId']);
            }
        } else {
            $this->loadModel('Logs');
            $logsdata =$this->Logs->find()->where(['itemid'=>$fashionbuyer['itemId'], 'sourceid'=>$id, 'type'=>'fashionimage'])->first();
            if(count($logsdata) > 0) {
                $logstable = TableRegistry::get('Logs');
                $query = $logstable->query();
                $query->delete()->where(['id' => $logsdata['id']])->execute();
            }
        }
        if(!empty($Result))
            echo $Result;
        else
            echo "false";
    }


    public function settings() {

        if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Merchant');

        $this->loadModel('Shops');
        $this->loadModel('Users');
        $this->loadModel('Countries');
        $this->loadModel('Categories');

        global $loguser;
        $sellerId = $loguser['id'];
        $this->set('loguser',$loguser);

        $cat_datas = $this->Categories->find()->where(['category_parent' => '0', 'category_sub_parent' => '0'])->all();
        $this->set('cat_datas',$cat_datas);

        $countrylist = $this->Countries->find()->all();
        $this->set('countrylist',$countrylist);

        if($this->request->is('post')) {
            $editsetting = $this->Users->findById($sellerId)->contain(['Shops'])->first();
            $shopid = $editsetting['shop']['id'];

            $username = $loguser['username'];
            $email = $loguser['email'];
            $companyname = $editsetting['shop']['shop_name'];
            $shopdesc = $this->request->data['storedescription'];
            $phoneno = $this->request->data['storephoneno'];
            $phonearea = $this->request->data['storephonearea'];
            $phonecountry = $this->request->data['storephonecode'];
            $storeurl = $editsetting['shop']['shop_name_url'];
            $location = $this->request->data['location'];
            $state = $this->request->data['state'];
            $wifi = $this->request->data['wifi'];
            $address1 = $this->request->data['address1'];
            $address2 = $this->request->data['address2'];
            $city = $this->request->data['city'];
            $stateprovince = $this->request->data['statprov'];
            $country  = $this->request->data['country'];
            $zipcode = $this->request->data['zipcode'];

            if(!empty(trim($this->request->data['shop_image'])))
                $shop_image = trim($this->request->data['shop_image']);
            if(!empty(trim($this->request->data['shop_banner'])))
                $shop_banner = $this->request->data['shop_banner'];
            if(!empty(trim($this->request->data['profile_image'])))
                $profile_image = $this->request->data['profile_image'];

            $latitude  =  $this->request->data['latitude'];
            $longitude = $this->request->data['longitude'];
            $addressarr = array($address1,$address2,$city,$stateprovince,$country,$zipcode);
            $busiaddress = implode('~',$addressarr);

            $phonenumbers = array($phonecountry,$phonearea,$phoneno);
            $phoneadd = implode('-',$phonenumbers);

            $pickup = $this->request->data['pickup'];
            $pricefree = $this->request->data['pricefree'];
            $freeamt = $this->request->data['freeamt'];
            $postalfree = $this->request->data['postalfree'];
            $postal_codes = array_unique($this->request->data['postalcodes']);

            $postal_code = array();
            foreach($postal_codes as $key => $postcodes)
            {
                if(trim($postcodes)!="")
                {
                $postal_code[] = $postcodes;
                }
            }
            $postalcodes = json_encode($postal_code);
            $inventory = array($location,$state);
            $inventoryloc = implode(',',$inventory);

            $articlesTable = TableRegistry::get('Users');
            $article = $articlesTable->get($sellerId);

            $article->first_name = $this->request->data['firstname'];
            $article->last_name = $this->request->data['lastname'];
            $article->username = $username;

            $article->email = $email;
            $article->profile_image = $profile_image;

            $userResult = $articlesTable->save($article);

            if(!empty($userResult))
            {
                $shopsTable = TableRegistry::get('Shops');
                $shoparticle = $shopsTable->get($shopid);

                $shoparticle->id = $shopid;
                $shoparticle->shop_name = $companyname;
                $shoparticle->shop_name_url = trim($storeurl);
                $shoparticle->merchant_name = $username;
                $shoparticle->seller_status = 1;
                $shoparticle->phone_no = $phoneadd;
                $shoparticle->shop_address = $busiaddress;
                $shoparticle->store_platform = "";

                if(isset($merchantid))
                $shoparticle->braintree_id = $merchantid;
                if(isset($publickey))
                $shoparticle->braintree_publickey = $publickey;
                if(isset($privatekey))
                $shoparticle->braintree_privatekey = $privatekey;

                $shoparticle->wifi = $wifi;
                $shoparticle->qqid = $qqid;
                $shoparticle->product_category = "";
                $shoparticle->inventory_loc = $inventoryloc;
                $shoparticle->shop_image = $shop_image;
                $shoparticle->shop_banner = $shop_banner;
                $shoparticle->shop_latitude = $latitude;
                $shoparticle->shop_longitude = $longitude;
                $shoparticle->shop_description = $shopdesc;
                $shoparticle->pickup = $pickup;
                $shoparticle->pricefree = $pricefree;
                $shoparticle->postalfree = $postalfree;
                if(trim($freeamt)!="" && trim($pricefree)=="yes" && trim($freeamt)!="0")
                $shoparticle->freeamt = $freeamt;
                else
                $shoparticle->freeamt = 0;

                if(!empty($postal_code) && trim($postalfree)=="yes")
                $shoparticle->postalcodes = $postalcodes;
                else
                $shoparticle->postalcodes = "";

                $shopsTable->save($shoparticle);

                $this->Flashmessage('success', "Seller Information updated successfully");
                $this->redirect('/merchant/sellerinformation');
            } else {
                $this->Flashmessage('error', "Try again");
                $this->redirect('/merchant/sellerinformation');
            }

        } else {
            $editsetting = $this->Users->findById($sellerId)->contain(['Shops'])->first();
            $this->set('editsetting',$editsetting);
            $this->set('sellerid',$sellerId);
        }
    }

    public function changesellerstatus($shopId = NULL, $status = NULL) {
        $this->autoRender = false;
        $this->loadModel('Shops');
        $this->loadModel('Items');

        global $setngs;
        global $loguser;
        $result = "1";

        if($status!="")
        {
            $shopstable = TableRegistry::get('Shops');
            $shopsquery = $shopstable->query();
            $itemstable = TableRegistry::get('Items');
            $itemsquery = $itemstable->query();

            if ($status == 'enable') {
                $shopsquery->update()->set(['seller_status' => '0'])->where(['id'=>$shopId])->execute();
                 echo '1';


                // $result = '<a class="btn btn-success disable_link" onclick="changeSellerStatus('.$shopId.',\'disable\')">Enable Store</a>';

                // $itemsquery->update()->set(['status' => 'draft'])->where(['shop_id'=>$shopId])->execute();
            } else {
                $shopsquery->update()->set(['seller_status' => '1'])->where(['id'=>$shopId])->execute();
                echo "0";


                // $result = '<a class="btn btn-danger disable_link" onclick="changeSellerStatus('.$shopId.',\'enable\')">Disable Store</a>';

                // $itemsquery->update()->set(['status' => 'publish'])->where(['shop_id'=>$shopId])->execute();
            }
        }
       // echo $result;
    }

    public function disputepro(){
        if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Disputes');

        global $loguser;
        global $siteChanges;
        global $setngs;

        $userid = $loguser['id'];
        $firstname= $loguser['first_name'];

        $_SESSION['first_name'] = $firstname;

        $this->loadModel('Dispcons');
        $this->loadModel('Disputes');
        $this->loadModel('Items');

        $disputesArticles = TableRegistry::get('Disputes');

        if(isset($_REQUEST['buyer'])) {

            $msgel = $disputesArticles->find()
            ->where(['userid' => $userid])
            ->orwhere(['selid' => $userid])
            ->andwhere(function ($exp, $q) {
                return $exp->in('newstatusup', ['Reply', 'Initialized', 'Responded', 'Accepeted', 'Reopen']);
            })->order(['disid'=>'DESC']);

            foreach ($msgel as $key => $msg) {
                $usedisid = $messagesel[$key]['userid'] = $msg['userid'];

                $messagesel[$key]['uorderstatus'] = $msg['uorderstatus'];
                $messagesel[$key]['uorderplm'] = $msg['uorderplm'];

                $selid = $messagesel[$key]['selid'] = $msg['selid'];
                $uor = $messagesel[$key]['uorderid'] = $msg['uorderid'];

                $messagesel[$key]['uordermsg'] = $msg['uordermsg'];
                $messagesel[$key]['orderdatedisp'] = $msg['orderdatedisp'];

                $disiddispcon = $messagesel[$key]['disid'] = $msg['disid'];
                $itemdet = $messagesel[$key]['itemdetail'] = $msg['itemdetail'];

                $messagesel[$key]['totprice'] = $msg['totprice'];
                $messagesel[$key]['sname'] = $msg['sname'];
                $messagesel[$key]['uname'] = $msg['uname'];
                $messagesel[$key]['newstatus'] = $msg['newstatus'];
                $messagesel[$key]['newstatusup'] = $msg['newstatusup'];
                $messagesel[$key]['money'] = $msg['money'];

                $username = $this->Users->findById($selid)->first();

                $u = $messagesel[$key]['username_url'] = $username['username_url'];

                $sellername = $this->Users->findById($usedisid)->first();

                $s = $messageseles[$key]['username_url'] = $sellername['username_url'];

                $this->loadModel('Orders');
                $uorcurre = $this->Orders->findByOrderid($uor)->first();

                $currencyCode = $messageseles[$key]['username_url'] = $uorcurre['currency'];

                $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

                $currencySymbol = $forexrateModel['currency_symbol'];
                $this->set('currencySymbol',$currencySymbol);
                $this->set('currencyCode', $currencyCode);
            }

            $msgelcou= count($msgel);
            $this->set('msgelcou',$msgelcou);
            $this->set('messagesel',$messagesel);
            $this->set('msgel',$msgel);

            $msgelcouss = $disputesArticles->find()
            ->where(['userid' => $userid])
            ->orwhere(['selid' => $userid])
            ->andwhere(function ($exp, $q) {
                return $exp->in('newstatusup', ['Cancel', 'Resolved', 'Closed', 'Processing']);
            })->order(['disid'=>'DESC']);

            $tocousel= count($msgelcouss);
            $this->set('tocousel',$tocousel);
            $this->set('username',$username);

        }
        if(isset($_REQUEST['seller'])) {

            $this->set('menu_highlight','disputeactive');
            $msbuyer = $disputesArticles->find()
            ->where(['userid' => $userid])
            ->orwhere(['selid' => $userid])
            ->andwhere(function ($exp, $q) {
                return $exp->in('newstatusup', ['Cancel', 'Resolved', 'Closed', 'Processing']);
            })->order(['disid'=>'DESC']);

            foreach ($msbuyer as $key => $msg) {
                $messagebuyer[$key]['selid'] = $msg['selid'];

                $messagebuyer[$key]['uorderstatus'] = $msg['uorderstatus'];
                $messagebuyer[$key]['uorderplm'] = $msg['uorderplm'];

                $user = $messagebuyer[$key]['userid'] = $msg['userid'];
                $uor = $messagebuyer[$key]['uorderid'] = $msg['uorderid'];

                $messagebuyer[$key]['uordermsg'] = $msg['uordermsg'];
                $messagebuyer[$key]['orderdatedisp'] = $msg['orderdatedisp'];

                $messagebuyer[$key]['newstatus'] = $msg['newstatus'];
                $messagebuyer[$key]['newstatusup'] = $msg['newstatusup'];
                $messagebuyer[$key]['itemdetail'] = $msg['itemdetail'];
                $messagebuyer[$key]['disid'] = $msg['disid'];

                $messagebuyer[$key]['totprice'] = $msg['totprice'];
                $messagebuyer[$key]['sname'] = $msg['sname'];
                $messagebuyer[$key]['uname'] = $msg['uname'];
                $messagebuyer[$key]['money'] = $msg['money'];

                $username = $this->Users->findById($user)->first();

                $messagebuyer[$key]['username_url'] = $username['username_url'];

                $this->loadModel('Orders');
                $uorcurre = $this->Orders->findByOrderid($uor)->first();

                $currencyCode = $messageseles[$key]['username_url'] = $uorcurre['currency'];

                $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

                $currencySymbol = $forexrateModel['currency_symbol'];
                $this->set('currencySymbol',$currencySymbol);
                $this->set('currencyCode', $currencyCode);
            }

            $msgelcou= count($msgel);
            $this->set('msgelcou',$msgelcou);
            $this->set('messagebuyer',$messagebuyer);
            $this->set('msbuyer',$msbuyer);

            $msgelcouss = $disputesArticles->find()
            ->where(['userid' => $userid])
            ->orwhere(['selid' => $userid])
            ->andwhere(function ($exp, $q) {
                return $exp->in('newstatusup', ['Reply', 'Initialized', 'Responded', 'Accepeted', 'Reopen']);
            })->order(['disid'=>'DESC']);

            $tocousel= count($msgelcouss);
            $this->set('tocousel',$tocousel);
            $this->set('username',$username);
        }
        $this->set('loguser', $loguser);
    }

    public function getmorecommentview() {
        if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->loadModel('Disputes');

        $userid = $loguser['id'];

        $offset = $_POST['offset'];
        $order_id = $_POST['order_id'];
        $contacter = $_POST['contact'];
        $dcount = $_POST['dcount'];

        $disputesArticles = TableRegistry::get('Disputes');
        $messagedisp = $disputesArticles->find()
        ->where(['userid' => $userid])
        ->orwhere(['selid' => $userid])
        ->andwhere(function ($exp, $q) {
            return $exp->in('newstatusup', ['Reply', 'Initialized', 'Responded']);
        })->order(['disid'=>'DESC'])->limit(10)->page($offset);

        foreach ($messagedisp as $key => $msg) {
            $usedisid = $messagesel[$key]['userid'] = $msg['userid'];
            $messagesel[$key]['uorderstatus'] = $msg['uorderstatus'];
            $messagesel[$key]['uorderplm'] = $msg['uorderplm'];
            $selid = $messagesel[$key]['selid'] = $msg['selid'];
            $uor = $messagesel[$key]['uorderid'] = $msg['uorderid'];
            $messagesel[$key]['uordermsg'] = $msg['uordermsg'];
            $disiddispcon = $messagesel[$key]['disid'] = $msg['disid'];
            $itemdet = $messagesel[$key]['itemdetail'] = $msg['itemdetail'];
            $messagesel[$key]['totprice'] = $msg['totprice'];
            $messagesel[$key]['sname'] = $msg['sname'];
            $messagesel[$key]['uname'] = $msg['uname'];
            $messagesel[$key]['newstatus'] = $msg['newstatus'];
            $messagesel[$key]['newstatusup'] = $msg['newstatusup'];
            $messagesel[$key]['money'] = $msg['money'];

            $username = $this->Users->findById($selid)->first();
            $u=$messagesel[$key]['username_url'] = $username['username_url'];

            $sellername = $this->Users->findById($usedisid)->first();
            $s=$messageseles[$key]['username_url'] = $sellername['username_url'];

            $this->loadModel('Orders');
            $uorcurre = $this->Orders->findByOrderid($uor)->first();
            $currencyCode = $messageseles[$key]['username_url'] = $uorcurre['currency'];

            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

            $currencySymbol = $forexrateModel['currency_symbol'];
            $this->set('currencySymbol',$currencySymbol);
            $this->set('currencyCode', $currencyCode);
        }
        $this->set('messagesel',$messagesel);
        $this->set('latestcount','0');
        $this->set('order_id',$order_id);
        $this->set('userid',$userid);
        $this->set('dcount',$dcount);
        $this->set('loguser',$loguser);

    }

    public function getmorecommentviewseller() {
        if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->loadModel('Disputes');

        $userid = $loguser['id'];

        $offset = $_POST['offset'];
        $order_id = $_POST['order_id'];
        $contacter = $_POST['contact'];
        $dcount = $_POST['dcount'];

        $disputesArticles = TableRegistry::get('Disputes');
        $messagebuy = $disputesArticles->find()
        ->where(['userid' => $userid])
        ->orwhere(['selid' => $userid])
        ->andwhere(function ($exp, $q) {
            return $exp->in('newstatusup', ['Cancel', 'Closed', 'Accepted', 'Processing']);
        })->order(['disid'=>'DESC'])->limit(10)->page($offset);

        foreach ($messagebuy as $key => $msgbuyer){
            $messagebuyer[$key]['selid'] = $msgbuyer['selid'];
            $messagebuyer[$key]['uorderstatus'] = $msgbuyer['uorderstatus'];
            $messagebuyer[$key]['uorderplm'] = $msgbuyer['uorderplm'];
            $user = $messagebuyer[$key]['userid'] = $msgbuyer['userid'];
            $uor = $messagebuyer[$key]['uorderid'] = $msgbuyer['uorderid'];
            $messagebuyer[$key]['uordermsg'] = $msgbuyer['uordermsg'];
            $messagebuyer[$key]['newstatus'] = $msgbuyer['newstatus'];
            $messagebuyer[$key]['newstatusup'] = $msgbuyer['newstatusup'];
            $messagebuyer[$key]['itemdetail'] = $msgbuyer['itemdetail'];
            $messagebuyer[$key]['disid'] = $msgbuyer['disid'];
            $messagebuyer[$key]['totprice'] = $msgbuyer['totprice'];
            $messagebuyer[$key]['sname'] = $msgbuyer['sname'];
            $messagebuyer[$key]['uname'] = $msgbuyer['uname'];
            $messagebuyer[$key]['money'] = $msgbuyer['money'];

            $username = $this->Users->findById($user)->first();
            $messagebuyer[$key]['username_url'] = $username['username_url'];

            $this->loadModel('Orders');
            $uorcurre = $this->Orders->findByOrderid($uor)->first();
            $currencyCode= $messageseles[$key]['username_url'] = $uorcurre['currency'];

            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

            $currencySymbol = $forexrateModel['currency_symbol'];
            $this->set('currencySymbol',$currencySymbol);
            $this->set('currencyCode', $currencyCode);
        }

        $this->set('messagebuyer',$messagebuyer);
        $this->set('latestcount','0');
        $this->set('order_id',$order_id);
        $this->set('userid',$userid);
        $this->set('dcount',$dcount);
        $this->set('loguser',$loguser);
    }

    public function getrecentdispallbuyer(){
        if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->loadModel('Disputes');

        $userid = $loguser['id'];

        $currentcont = $_POST['currentcont'];
        $order_id = $_POST['order_id'];
        $contacter = $_POST['contact'];

        $disputesArticles = TableRegistry::get('Disputes');
        $msgel = $disputesArticles->find()
        ->where(['userid' => $userid])
        ->orwhere(['selid' => $userid])
        ->andwhere(function ($exp, $q) {
            return $exp->in('newstatusup', ['Reply', 'Initialized', 'Responded']);
        })->order(['disid'=>'DESC']);

        foreach ($msgel as $key => $msg) {
            $usedisid = $messagesel[$key]['userid'] = $msg['userid'];
            $messagesel[$key]['uorderstatus'] = $msg['uorderstatus'];
            $messagesel[$key]['uorderplm'] = $msg['uorderplm'];
            $selid = $messagesel[$key]['selid'] = $msg['selid'];
            $uor = $messagesel[$key]['uorderid'] = $msg['uorderid'];
            $messagesel[$key]['uordermsg'] = $msg['uordermsg'];
            $disiddispcon = $messagesel[$key]['disid'] = $msg['disid'];
            $itemdet = $messagesel[$key]['itemdetail'] = $msg['itemdetail'];
            $messagesel[$key]['totprice'] = $msg['totprice'];
            $messagesel[$key]['sname'] = $msg['sname'];
            $messagesel[$key]['uname'] = $msg['uname'];
            $messagesel[$key]['newstatus'] = $msg['newstatus'];
            $messagesel[$key]['newstatusup'] = $msg['newstatusup'];
            $messagesel[$key]['money'] = $msg['money'];

            $username = $this->Users->findById($selid)->first();
            $u = $messagesel[$key]['username_url'] = $username['username_url'];

            $sellername = $this->Users->findById($usedisid)->first();
            $s = $messageseles[$key]['username_url'] = $sellername['username_url'];

            $this->loadModel('Orders');
            $uorcurre = $this->Orders->findByOrderid($uor)->first();
            $currencyCode = $messageseles[$key]['username_url'] =$uorcurre['currency'];

            $forexrateModel = $this->Forexrates->find()->where(['currency_code'=>$currencyCode])->first();
            $currencySymbol = $forexrateModel['currency_symbol'];
            $this->set('currencySymbol',$currencySymbol);
            $this->set('currencyCode', $currencyCode);
        }

        if (!empty($messagesel)){
            $latestcount = $currentcont + count($messagesel);
        }

        $this->set('msgel',$msgel);
        $this->set('messagesel',$messagesel);
        $this->set('latestcount','0');
        $this->set('userid',$userid);
        $this->set('loguser',$loguser);
        $this->set('username',$username);
        $this->render('getmorecommentview');

    }

    public function getrecentdispallseller() {
        if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->loadModel('Disputes');

        $userid = $loguser['id'];

        $currentcont = $_POST['currentcont'];
        $order_id = $_POST['order_id'];
        $contacter = $_POST['contact'];

        $disputesArticles = TableRegistry::get('Disputes');
        $messagebuy = $disputesArticles->find()
        ->where(['userid' => $userid])
        ->orwhere(['selid' => $userid])
        ->andwhere(function ($exp, $q) {
            return $exp->in('newstatusup', ['Cancel', 'Closed', 'Accepted', 'Processing']);
        })->order(['disid'=>'DESC']);

        foreach ($messagebuy as $key => $msgbuyer){
            $messagebuyer[$key]['selid'] = $msgbuyer['selid'];
            $messagebuyer[$key]['uorderstatus'] = $msgbuyer['uorderstatus'];
            $messagebuyer[$key]['uorderplm'] = $msgbuyer['uorderplm'];
            $user = $messagebuyer[$key]['userid'] = $msgbuyer['userid'];
            $uor = $messagebuyer[$key]['uorderid'] = $msgbuyer['uorderid'];
            $messagebuyer[$key]['uordermsg'] = $msgbuyer['uordermsg'];
            $messagebuyer[$key]['newstatus'] = $msgbuyer['newstatus'];
            $messagebuyer[$key]['newstatusup'] = $msgbuyer['newstatusup'];
            $messagebuyer[$key]['itemdetail'] = $msgbuyer['itemdetail'];
            $messagebuyer[$key]['disid'] = $msgbuyer['disid'];
            $messagebuyer[$key]['totprice'] = $msgbuyer['totprice'];
            $messagebuyer[$key]['sname'] = $msgbuyer['sname'];
            $messagebuyer[$key]['uname'] = $msgbuyer['uname'];
            $messagebuyer[$key]['money'] = $msgbuyer['money'];

            $username = $this->Users->findById($user)->first();
            $messagebuyer[$key]['username_url'] = $username['username_url'];

            $this->loadModel('Orders');
            $uorcurre = $this->Orders->findByOrderid($uor)->first();
            $currencyCode= $messageseles[$key]['username_url'] = $uorcurre['currency'];

            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

            $currencySymbol = $forexrateModel['currency_symbol'];
            $this->set('currencySymbol',$currencySymbol);
            $this->set('currencyCode', $currencyCode);
        }

        $this->set('messagebuy',$messagebuy);
        $this->set('messagebuyer',$messagebuyer);
        $this->set('latestcount','0');
        $this->set('userid',$userid);
        $this->set('loguser',$loguser);
        $this->set('username',$username);
        $this->render('getmorecommentviewseller');
    }

    public function forgotpassword() {
        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Forgot Password');
        $this->autoRender = false;

        global $loguser;
        global $siteChanges;
        global $setngs;

        if ($this->request->is('post')) {
            $email = trim($this->request->data['forgotemail']);

            $usr_datas = $this->Users->findByEmail($email)->contain(['Shops'])->first();

            if(count($usr_datas) > 0) {
                if($usr_datas['shop']['seller_status'] == 1) {

                $name = $usr_datas['first_name'];
                $reg_email = $usr_datas['email'];
                $use_id = $usr_datas['id'];

                if(!empty($reg_email)) {

                    $email=$reg_email;
                    $aSubject=$setngs['site_name']." – ".__d('merchant','Your new password has arrived');
                    $aBody='';
                    $template='merchantpasswordreset';
                    $emailid = base64_encode($reg_email);
                    $time = time();

                    $usersTable = TableRegistry::get('Users');
                    $usersarticle = $usersTable->get($use_id);
                    $usersarticle->verify_pass = $time;

                    if($usersTable->save($usersarticle)) {

                        $setdata=array('name'=>$name,'reg_email'=>$reg_email,'setngs'=> $setngs,'access_url'=>MERCHANT_URL."/setpassword/".$emailid."~".$time);
                        $mailcheck = $this->sendmail($email,$aSubject,$aBody,$template,$setdata);

                        if($mailcheck == "true")
                            $this->Flashmessage('success', "Password sent, Check your email immediately");
                        else
                            $this->Flashmessage('error', "Mail Sending failed, Contact Admin");

                        $this->redirect('/merchant/login');
                    } else {
                        $this->Flashmessage('error', "Try again");
                        $this->redirect('/merchant/login');
                    }

                }
                } else {
                $this->Flashmessage('error', "Please Give Valid Merchant account");
                $this->redirect('/merchant/login');

                }
            } else {
                $this->Flashmessage('error', "Email id is not found, Please register to our site");
                $this->redirect('/merchant/login');
            }
        } else {
                $this->Flashmessage('error', "Try again");
                $this->redirect('/merchant/login');
        }
    }

    public function disputemessage($orderid) {

        if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Merchant');

        global $loguser;
        global $siteChanges;
        global $setngs;
        $orderid;

        $userid = $loguser['id'];
        $firstname= $loguser['first_name'];

        $_SESSION['first_name'] = $firstname;
        $log = $loguser['id'];
        $login = $_SESSION['id'] = $log;

        $this->loadModel('Dispcons');
        $this->loadModel('Disputes');
        $this->loadModel('OrderItems');
        $this->loadModel('Ordercomments');
        $this->loadModel('Orders');


        $orderModel = $this->Orders->findByOrderid($orderid)->first();
        $ordercommentsModel = $this->Ordercomments->find()->where(['orderid'=>$orderid])->order(['id' => 'DESC'])->toArray();

        $buyerid = $orderModel['userid'];
        $merchantid = $orderModel['merchant_id'];

        if($userid != $buyerid)
        {
            $this->Flashmessage('error', "Try again");
            $this->redirect('/merchant/dashboard');
        }

        $orderitemmodel = $this->OrderItems->findAllByOrderid($orderid)->toArray();
        $msgelcou = $this->Dispcons->findAllByOrder_id($orderid)->count();
        $this->set('msgelcou', $msgelcou);
        $this->set('orderitemmodel', $orderitemmodel);

        $orderdet = $this->Disputes->findByUorderid($orderid)->first();
        $dispid=$orderdet['disid'];
        $buyerModel = $this->Users->findById($login)->first();

        $buyerName = $buyerModel['first_name'];
        $merchantModel = $this->Users->findById($merchantid)->first();
        $sellerName = $merchantModel['first_name'];
        $selleremail= $merchantModel['email'];

        $msgel = $this->Dispcons->find()->where(['order_id'=>$orderid, 'user_id' => $userid])->order(['dcid' => 'desc'])->all();

        foreach ($msgel as $key => $msg) {
            $messagedisp[$key]['user_id'] = $msg['user_id'];
            $messagedisp[$key]['commented_by'] = $msg['commented_by'];
            $messagedisp[$key]['date'] = $msg['date'];
            $messagedisp[$key]['msid'] = $msg['msid'];
            $uor = $messagedisp[$key]['order_id'] = $msg['order_id'];
            $messagedisp[$key]['message'] = $msg['message'];
            $messagedisp[$key]['dispid'] = $msg['dispid'];
            $messagedisp[$key]['newstatus'] = $msg['newstatus'];
            $messagedisp[$key]['imagedisputes'] = $msg['imagedisputes'];

            $uorcurre = $this->Orders->findByOrderid($uor)->first();
            $currencyCode=$messageseles[$key]['username_url'] = $uorcurre['currency'];

            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

            $currencySymbol = $forexrateModel['currency_symbol'];
            $this->set('currencySymbol',$currencySymbol);
            $this->set('currencyCode', $currencyCode);
        }
        $this->set('messagedisp',$messagedisp);
        $this->set('orderdet',$orderdet);
        $this->set('buyerModel',$buyerModel);
        $this->set('orderModel',$orderModel);
        $this->set('merchantModel',$merchantModel);
        $this->set('firstname',$firstname);
        $this->set('roundProf',$siteChanges['profile_image_view']);


        if(isset($_REQUEST['buyconver'])) {

            $dispconsTable = TableRegistry::get('Dispcons');
            $disputesTable = TableRegistry::get('Disputes');
            $dispconsarticle = $dispconsTable->newEntity();

            $cuids = $dispconsarticle->user_id = $userid;
            $gor = $dispconsarticle->order_id = $orderid;
            $gmsss = $dispconsarticle->message = trim($this->request->data['msg']);
            $merid = $dispconsarticle->msid = $orderdet['selid'];
            $liid = $dispconsarticle->dispid = $orderdet['disid'];
            $da = $dispconsarticle->date = time();
            $nei = "Buyer";
            $cre = $dispconsarticle->commented_by = $nei;

            if(!empty($this->request->data['data']['Dispute']['upload']['name']))
            {
                $fileimg = $this->request->data['data']['Dispute']['upload'];
                /*
                $ext = substr(strtolower(strrchr($fileimg['name'], '.')), 1);
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');

                if(in_array($ext, $arr_ext))
                {
                move_uploaded_file($fileimg['tmp_name'], WEBROOTPATH."/disputeimage/". $fileimg['name']);
                }
                */
                 $appImageValues = getimagesize($fileimg['tmp_name']); 
                $extensionarray = array('.jpg', '.png', '.jpeg'); 
                $imageSize = (trim($fileimg['size']) / 1024) / 1024;
                $ext = strrchr(trim($fileimg['name']), '.');

                if ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && $imageSize < 2 && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) { 
                    move_uploaded_file($fileimg['tmp_name'], WEBROOTPATH."/disputeimage/". $fileimg['name']); 
                } else { 
                    $dispconsarticle->imagedisputes = ""; 
                }
            }

            if($fileimg['name'] == ''){
                $dispconsarticle->imagedisputes = "";
            } else {
                $imgs = $dispconsarticle->imagedisputes = $fileimg['name'];
            }

            $rly = 'Reply';
            $dispconsarticle->newdispstatus = $rly;

            $curstatus = $this->Disputes->findByUorderid($orderid)->first();
            $cursta = $curstatus['newstatusup'];
            $query = $disputesTable->query();

            if($curstatus['resolvestatus']!='Resolved' && $curstatus['newstatusup']!='Cancel'  && $curstatus['newstatusup']!='Processing' && $curstatus['newstatusup']!='Closed' ) {
                $dispconsTable->save($dispconsarticle);
                $resp='Responded';

                $query->update()->set(['newstatusup' => $resp])->where(['uorderid'=>$orderid])->execute();
            } else {
                $this->Flashmessage('success', "Dispute Status Changed");
                $this->redirect('/merchant/disputemessage/'.$orderid);
            }

            $resp='Responded';
            $chtim=time();
            $query->update()->set(['newstatusup' => $resp, 'chatdate' => $chtim])->where(['uorderid'=>$orderid])->execute();

            $userModel = $this->Users->findById($loguser['id'])->first();

            //push notification
            $logusername = $userModel['username'];
            $logusernameurl = $userModel['username_url'];
            $userImg = $userModel['profile_image'];

            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }

            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);
            $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";
            $disputelink = "<a href='".SITE_URL."disputeBuyer/".$gor."'>".$gor."</a>";
            $notifymsg = $loguserlink." -___- Buyer Replied For the Dispute -___- #".$disputelink;

            $logdetails = $this->addlog('dispute', $userid, $merchantid, $dispid, $notifymsg, $gmsss, $loguserimage);

        

            $this->set('UserId', $cuids);
            $this->set('OrderId', $gor);
            $this->set('Message',$gmsss);
            $this->set('liid',$liid);
            $this->set('sellername',$sellerName);
            $this->set('buyerName',$buyerName);
            $this->set('setngs',$setngs);

            $this->redirect('/merchant/disputemessage/'.$orderid);
        }

        if(isset($_REQUEST['cancel'])) {
            $resp='Cancel';

            $disputesTable = TableRegistry::get('Disputes');
            $query = $disputesTable->query();
            $query->update()->set(['newstatusup' => $resp])->where(['uorderid'=>$orderid])->execute();

            $userModel = $this->Users->findById($loguser['id'])->first();
            //push notification
            $logusername = $userModel['username'];
            $logusernameurl = $userModel['username_url'];

            $userImg = $userModel['profile_image'];
            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;

            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);
            $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";
            $disputelink = "<a href='".SITE_URL."disputeBuyer/".$orderid."'>".$orderid."</a>";
            $notifymsg = $loguserlink."-___- Buyer Cancelled the Dispute -___-#".$disputelink;
            $gmsss='Cancel Disputes';

            $logdetails = $this->addlog('dispute',$userid,$merchantid,$dispid,$notifymsg,$gmsss,$loguserimage);

            $this->redirect('/merchant/disputemessage/'.$orderid);

        }

        if(isset($_REQUEST['resolve'])) {
            $resp='Resolved';

            $disputesTable = TableRegistry::get('Disputes');
            $query = $disputesTable->query();
            $query->update()->set(['newstatusup' => $resp])->where(['uorderid'=>$orderid])->execute();

            $userModel = $this->Users->findById($loguser['id']);

            //push notification
            $logusername = $userModel['username'];
            $logusernameurl = $userModel['username_url'];
            $userImg = $userModel['profile_image'];
            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);
            $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";
            $disputelink = "<a href='".SITE_URL."disputeBuyer/".$orderid."'>".$orderid."</a>";
            $notifymsg = $loguserlink."-___- Buyer Resolved the Dispute -___- #".$disputelink;
            $gmsss='Cancel Disputes';

            $logdetails = $this->addlog('dispute',$userid,$merchantid,$dispid,$notifymsg,$gmsss,$loguserimage);

            $dispute_details = $this->Disputes->findByUorderid($orderid)->first();
            $buyeremail = $dispute_details['uemail'];
            $selleremail = $dispute_details['semail'];
            $sellerName = $dispute_details['sname'];
            $buyerName = $dispute_details['uname'];
            $liid = $dispute_details['disid'];

            $this->set('UserId', $cuids);
            $this->set('orderid', $orderid);
            $this->set('Message',$gmsss);
            $this->set('setngs',$setngs);
            $this->set('liid',$liid);
            $this->set('buyerName',$buyerName);
            $this->set('sellerName',$sellerName);
            $this->redirect('/merchant/disputemessage/'.$orderid);
        }
    }

    public function disputesellermsg($orderid) {
        if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Merchant');

        global $loguser;
        global $siteChanges;
        global $setngs;

        $userid = $loguser['id'];
        $firstname= $loguser['first_name'];

        $_SESSION['first_name'] = $firstname;
        $log = $loguser['id'];
        $login = $_SESSION['id'] = $log;

        $this->loadModel('Dispcons');
        $this->loadModel('Disputes');
        $this->loadModel('OrderItems');
        $this->loadModel('Ordercomments');
        $this->loadModel('Orders');

        $orderModel = $this->Orders->findByOrderid($orderid)->first();
        $ordercommentsModel = $this->Ordercomments->find()->where(['orderid'=>$orderid])->order(['id' => 'DESC'])->toArray();

        $buyerid = $orderModel['userid'];
        $merchantid = $orderModel['merchant_id'];

        if($userid != $merchantid) {
            $this->Flashmessage('error', "Try again");
            $this->redirect('/merchant/dashboard');
        }

        $buyerModel = $this->Users->findById($buyerid)->first();

        $buyeremail = $buyerModel['email'];
        $merchantModel = $this->Users->findById($merchantid)->first();
        $sellerName = $merchantModel['first_name'];
        $selleremail = $merchantModel['email'];
        $buyerefirstname = $buyerModel['first_name'];
        $buyerusername = $buyerModel['username'];

        $orderdet = $this->Disputes->findByUorderid($orderid)->first();
        $umer = $orderdet['user_id'];
        $msgelcou = $this->Dispcons->findAllByOrder_id($orderid)->count();
        $this->set('msgelcou', $msgelcou);

        $msgel = $this->Dispcons->find()->where(['order_id'=>$orderid, 'msid'=>$userid])->order(['dcid' => 'desc'])->all();

        $orderitemmodel = $this->OrderItems->findAllByOrderid($orderid)->toArray();
        $this->set('orderitemmodel', $orderitemmodel);

        foreach ($msgel as $key => $msg){

            $messagedisp[$key]['message'] = $msg['message'];
            $messagedisp[$key]['date'] = $msg['date'];
            $messagedisp[$key]['commented_by'] = $msg['commented_by'];
            $dispid = $messagedisp[$key]['dispid'] = $msg['dispid'];
            $uor = $messagedisp[$key]['order_id'] = $msg['order_id'];
            $messagedisp[$key]['newdispstatus'] = $msg['newdispstatus'];
            $messagedisp[$key]['imagedisputes'] = $msg['imagedisputes'];

            $uorcurre = $this->Orders->findByOrderid($uor)->first();
            $currencyCode =$messageseles[$key]['username_url'] = $uorcurre['currency'];

            $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencyCode])->first();

            $currencySymbol = $forexrateModel['currency_symbol'];
            $this->set('currencySymbol',$currencySymbol);
            $this->set('currencyCode', $currencyCode);
        }
        $this->set('messagedisp',$messagedisp);
        $this->set('orderdet',$orderdet);
        $this->set('buyerModel',$buyerModel);
        $this->set('merchantModel',$merchantModel);
        $this->set('roundProf',$siteChanges['profile_image_view']);

        if(isset($_REQUEST['selconver'])) {

            $dispconsTable = TableRegistry::get('Dispcons');
            $disputesTable = TableRegistry::get('Disputes');
            $dispconsarticle = $dispconsTable->newEntity();

            $orderdet = $this->Disputes->findByUorderid($orderid)->first();
            $msgel = $this->Dispcons->find()->where(['order_id'=>$orderid])->first();

            $cuids = $dispconsarticle->user_id = $msgel['user_id'];
            $gor = $dispconsarticle->order_id = $orderid;
            $gmsss = $dispconsarticle->message = trim($this->request->data['msg']);
            $merid = $dispconsarticle->msid = $orderdet['selid'];
            $liid = $dispconsarticle->dispid = $orderdet['disid'];
            $da = $dispconsarticle->date = time();
            $nei = "Seller";

            $cre = $dispconsarticle->commented_by = $nei;

            if(!empty($this->request->data['data']['Dispute']['upload']['name']))
            {
                $fileimg = $this->request->data['data']['Dispute']['upload'];
                /*
                $ext = substr(strtolower(strrchr($fileimg['name'], '.')), 1);
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');

                if(in_array($ext, $arr_ext))
                {
                move_uploaded_file($fileimg['tmp_name'], WEBROOTPATH."/disputeimage/". $fileimg['name']);
                }
                */
                $appImageValues = getimagesize($fileimg['tmp_name']); 
                $extensionarray = array('.jpg', '.png', '.jpeg'); 
                $imageSize = (trim($fileimg['size']) / 1024) / 1024;
                $ext = strrchr(trim($fileimg['name']), '.');

                if ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && $imageSize < 2 && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) { 
                    move_uploaded_file($fileimg['tmp_name'], WEBROOTPATH."/disputeimage/". $fileimg['name']);      
                } else { 
                    $dispconsarticle->imagedisputes = ""; 
                }
            }

            if($fileimg['name'] == ''){
                $dispconsarticle->imagedisputes = "";
            } else {
                $imgs = $dispconsarticle->imagedisputes = $fileimg['name'];
            }

            $rly = 'Reply';
            $dispconsarticle->newdispstatus = $rly;

            $curstatus = $this->Disputes->findByUorderid($orderid)->first();
            $cursta = $curstatus['newstatusup'];
            $query = $disputesTable->query();

            if($curstatus['resolvestatus']!='Resolved' && $curstatus['newstatusup']!='Cancel'  && $curstatus['newstatusup']!='Processing' && $curstatus['newstatusup']!='Closed' ) {
                $dispconsTable->save($dispconsarticle);
                $query->update()->set(['newstatusup' => $rly])->where(['uorderid'=>$orderid])->execute();
            } else {
                $this->Flashmessage('success', "Dispute Status Changed");
                $this->redirect('/merchant/disputeBuyer/'.$orderid);
            }

            $chtim=time();
            $query->update()->set(['newstatusup' => $rly, 'chatdate' => $chtim])->where(['uorderid'=>$orderid])->execute();

            $userModel = $this->Users->findById($loguser['id'])->first();

            //push notification
            $logusername = $userModel['username'];
            $logusernameurl = $userModel['username_url'];
            $userImg = $userModel['profile_image'];

            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }

            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);
            $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";
            $disputelink = "<a href='".SITE_URL."disputemessage/".$gor."'>".$gor."</a>";
            $notifymsg = $loguserlink." -___- Seller Replied For the Dispute -___- #".$disputelink;
            $logdetails = $this->addlog('dispute',$userid,$buyerid,$dispid,$notifymsg,$gmsss,$loguserimage);

            $this->set('UserId', $cuids);
            $this->set('OrderId', $gor);
            $this->set('Message',$gmsss);
            $this->set('setngs',$setngs);
            $this->set('liid',$liid);
            $this->set('buyerefirstname',$buyerefirstname);
            $this->set('sellerName',$sellerName);

            $this->redirect('/merchant/disputeBuyer/'.$orderid);
        }

        if(isset($_REQUEST['accept'])){
            $resp='Accepeted';

            $disputesTable = TableRegistry::get('Disputes');
            $query = $disputesTable->query();
            $query->update()->set(['newstatusup' => $resp, 'newstatus' => $resp])->where(['uorderid'=>$orderid])->execute();

            $gor = $orderid;

            $userModel = $this->Users->findById($loguser['id'])->first();

            //push notification
            $logusername = $userModel['username'];
            $logusernameurl = $userModel['username_url'];

            $userImg = $userModel['profile_image'];
            if (empty($userImg)){
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL."people/".$logusernameurl;
            $loguserimage = json_encode($image);
            $loguserlink = "<a href='".SITE_URL."people/".$logusernameurl."'>".$logusername."</a>";
            $disputelink = "<a href='".SITE_URL."disputemessage/".$gor."'>".$gor."</a>";
            $notifymsg = $loguserlink." -___- Seller Accepted the Dispute -___- #".$disputelink;

            $logdetails = $this->addlog('dispute',$userid,$buyerid,$dispid,$notifymsg,$gmsss,$loguserimage);

            //email
            $aSubject = $logusername." - ".__d('merchant','Seller accepted the dispute')." ".$gor;
            $aBody='';
            $template='merchantdisputeaccept';

            $setdata=array('name'=>$buyerusername, 'seller'=>$logusername, 'orderid'=>$gor, 'setngs'=> $setngs);
            $mailcheck = $this->sendmail($buyeremail,$aSubject,$aBody,$template,$setdata);

            //push notify
            $this->loadModel('Userdevices');
            $userdevicetable = TableRegistry::get('Userdevices');
            $shopstable = TableRegistry::get('Shops');
            $shopdata = $shopstable->find()->where(['user_id'=>$loguser['id']])->first();
            $query = $userdevicetable->query();
            $userddetts = $this->Userdevices->findAllByUser_id($buyerid)->all();
            if(count($userddetts) > 0) {
                foreach($userddetts as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge +=1;

                    $query->update()->set(['badge' => $badge])->where(['deviceToken'=>$deviceTToken])->execute();

                    if(isset($deviceTToken)) {
                        $pushMessage['type'] = "dispute_accept";
                        $pushMessage['store_image'] = $shopdata['shop_image'];
                        $pushMessage['dispute_id'] = $gor;
                        $pushMessage['message'] = $logusername." - ".__d('merchant','Seller accepted the dispute')." ".$gor;
                        $messages = json_encode($pushMessage);
                        $this->pushnot($deviceTToken,$messages,$badge);
                }
                }
            }
            $this->redirect('/merchant/disputeBuyer/'.$orderid);
        }
    }

    public function getmorecommentbuyer() {
        if(!$this->isauthenticated())
                    $this->redirect(['action' => 'login']);

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->loadModel('Dispcons');
        $this->loadModel('Orders');

        $userid = $loguser['id'];

        $offset = $_POST['offset'];
        $order_id = $_POST['order_id'];
        $contacter = $_POST['contact'];

        $orderModel = $this->Orders->findByOrderid($order_id)->first();

        $messagedisp = $this->Dispcons->find()->where(['order_id'=>$order_id, 'user_id' => $userid])->order(['dcid' => 'DESC'])->limit(5)->page($offset);

        if (!empty($messagedisp)) {
            $latestcount = $currentcont + count($messagedisp);
            $buyerid = $orderModel['userid'];
            $merchantid = $orderModel['merchant_id'];

            $buyerModel = $this->Users->findById($buyerid)->first();
            $merchantModel = $this->Users->findById($merchantid)->first();

            if($contacter == 'Seller'){
                $this->set('buyerModel',$buyerModel);
                $this->set('merchantModel',$merchantModel);
            }else{
                $this->set('buyerModel',$merchantModel);
                $this->set('merchantModel',$buyerModel);
            }
            $this->set('contacter',$contacter);
            $this->set('roundProf',$siteChanges['profile_image_view']);
        }
        $this->set('messagedisp',$messagedisp);
        $this->set('latestcount','0');
        $this->render('getbuyercmnt');
    }

    public function getmorecommentseller() {
        if(!$this->isauthenticated())
            $this->redirect(['action' => 'login']);

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->loadModel('Dispcons');
        $this->loadModel('Orders');

        $userid = $loguser['id'];
        $offset = $_POST['offset'];
        $order_id = $_POST['order_id'];
        $contacter = $_POST['contact'];

            $orderModel = $this->Orders->findByOrderid($order_id)->first();
            $messagedisp = $this->Dispcons->find()->where(['order_id'=>$order_id, 'msid'=>$userid])->order(['dcid' => 'DESC'])->limit(5)->page($offset);

            if (!empty($messagedisp)){
                $latestcount = $currentcont + count($messagedisp);
                $buyerid = $orderModel['userid'];
                $merchantid = $orderModel['merchant_id'];
                $buyerModel = $this->Users->findById($buyerid)->first();
                $merchantModel = $this->Users->findById($merchantid)->first();

                if ($contacter == 'Seller'){
                $this->set('buyerModel',$buyerModel);
                $this->set('merchantModel',$merchantModel);
                }else{
                $this->set('buyerModel',$merchantModel);
                $this->set('merchantModel',$buyerModel);
                }

                $this->set('contacter',$contacter);
                $this->set('roundProf',$siteChanges['profile_image_view']);
            }
            $this->set('messagedisp',$messagedisp);
            $this->set('latestcount','0');
            $this->render('getsellercmnt');
    }

    public function deleteitem($itemId = null)
    {
        if(!$this->isauthenticated())
            $this->redirect(['action' => 'login']);

        global $setngs;
        global $siteChanges;
        global $loguser;

        $this->autoRender = false;
        $this->loadModel('Photos');
        $this->loadModel('Shipings');
        $this->loadModel('Itemfavs');
        $this->loadModel('Comments');
        $this->loadModel('Logs');
        $this->loadModel('Shops');
        $this->loadModel('Contactsellers');
        $this->loadModel('Contactsellermsgs');
        $this->loadModel('Wantownits');
        $this->loadModel('Carts');
        $this->loadModel('Items');

        if($itemId != null) {
            $fileName = $this->Photos->find()->where(['item_id'=>$itemId])->all();

            if(count($fileName) > 0)
            {
                $original = true; $thumb70 = true;
                $thumb150 = true; $thumb350 = true;

                if ($_SESSION['site_url'] == SITE_URL) {
                foreach ($fileName as $name) {
                    $fname = $name['image_name'];
                    if ($original == true && $thumb70 == true && $thumb150 == true && $thumb350 == true ) {
                        $original = unlink(WEBROOTPATH.'media/items/original/'.$fname);
                        $thumb70 = unlink(WEBROOTPATH.'media/items/thumb70/'.$fname);
                        $thumb150 = unlink(WEBROOTPATH.'media/items/thumb150/'.$fname);
                        $thumb350 = unlink(WEBROOTPATH.'media/items/thumb350/'.$fname);
                    } else {
                        echo 'false';
                        return;
                    }
                }
                } else {
                foreach ($fileName as $name) {
                    $fname = $name['image_name'];
                    if ($original == true && $thumb70 == true && $thumb150 == true && $thumb350 == true ) {
                        $original = unlink(WEBROOTPATH.'media/items/original/'.$fname);
                        $thumb70 = unlink(WEBROOTPATH.'media/items/thumb70/'.$fname);
                        $thumb150 = unlink(WEBROOTPATH.'media/items/thumb150/'.$fname);
                        $thumb350 = unlink(WEBROOTPATH.'media/items/thumb350/'.$fname);
                    } else {
                        echo 'false';
                        return;
                    }
                }
                }
            }

            $item_user = array();

            $item_user =$this->Items->find()->where(['Items.id'=>$itemId])->first();

            $user_id = $item_user['user_id'];
            $item_title = $item_user['item_title'];
            $item_url = $item_user['item_title_url'];

            if(count($item_user) > 0) {
                $Itemdata = $this->Items->get($itemId);
                $this->Items->delete($Itemdata);
            }
            $item_carts =$this->Carts->find()->where(['item_id'=>$itemId])->first();

            if(count($item_carts) > 0) {
                $cartstable = TableRegistry::get('Carts');
                $query = $cartstable->query();
                $query->delete()->where(['item_id' => $itemId])->execute();
            }
            $item_Logs =$this->Logs->find()->where(['itemid'=>$itemId])->first();
            $logstable = TableRegistry::get('Logs');

            if(count($item_Logs) > 0) {
                $query = $logstable->query();
                $query->delete()->where(['itemid' => $itemId])->execute();
            }
            $item_Logs =$this->Logs->find()->where(['sourceid'=>$itemId])->first();
            if(count($item_Logs) > 0) {
                $query = $logstable->query();
                $query->delete()->where(['sourceid' => $itemId])->execute();
            }
            $item_Photos =$this->Photos->find()->where(['item_id'=>$itemId])->first();
            if(count($item_Photos) > 0) {
                $photostable = TableRegistry::get('Photos');
                $query = $photostable->query();
                $query->delete()->where(['item_id' => $itemId])->execute();
            }
            $item_Shipings =$this->Shipings->find()->where(['item_id'=>$itemId])->first();
            if(count($item_Shipings) > 0) {
                $shipingstable = TableRegistry::get('Shipings');
                $query = $shipingstable->query();
                $query->delete()->where(['item_id' => $itemId])->execute();
            }
            $item_Itemfavs =$this->Itemfavs->find()->where(['item_id'=>$itemId])->first();
            if(count($item_Itemfavs) > 0) {
                $itemfavstable = TableRegistry::get('Itemfavs');
                $query = $itemfavstable->query();
                $query->delete()->where(['item_id' => $itemId])->execute();
            }
            $item_Comments =$this->Comments->find()->where(['item_id'=>$itemId])->first();
            if(count($item_Comments) > 0) {
                $commentstable = TableRegistry::get('Comments');
                $query = $commentstable->query();
                $query->delete()->where(['item_id' => $itemId])->execute();
            }
            $item_Logs =$this->Logs->find()->where(['notification_id'=>$itemId])->first();
            if(count($item_Logs) > 0) {
                $query = $logstable->query();
                $query->delete()->where(['notification_id' => $itemId])->execute();
            }
            $item_Wantownits =$this->Wantownits->find()->where(['itemid'=>$itemId])->first();
            if(count($item_Wantownits) > 0) {
                $wantownitstable = TableRegistry::get('Wantownits');
                $query = $wantownitstable->query();
                $query->delete()->where(['itemid' => $itemId])->execute();
            }

            $itemcount = $this->Items->find()->where(['Items.user_id'=>$user_id ,'Items.status'=>'publish'])->count();

            $shopsTable = TableRegistry::get('Shops');
            $query = $shopsTable->query();
            $query->update()->set(['item_count' => $itemcount])->where(['user_id'=>$user_id])->execute();


            $contactsellerModel = $this->Contactsellers->find()->where(['itemid' =>
                $itemId])->all();

            $cstable = TableRegistry::get('Contactsellers');
            $csquery = $cstable->query();

            $csmtable = TableRegistry::get('Contactsellermsgs');
            $csmquery = $csmtable->query();

            if(count($contactsellerModel) > 0) {
                foreach ($contactsellerModel as $contactseller) {
                $csid = $contactseller['id'];
                $item_Contactsellers =$this->Contactsellers->find()->where(['id'=>$csid])->first();
                if(count($item_Contactsellers) > 0)
                    $csquery->delete()->where(['id' => $csid])->execute();

                $item_Contactsellermsgs =$this->Contactsellermsgs->find()->where(['contactsellerid'=>$csid])->first();
                if(count($item_Contactsellermsgs) > 0)
                $csmquery->delete()->where(['contactsellerid' => $csid])->execute();
                }
            }
            $email_address = $this->Users->find()->where(['id'=>$user_id])->first();

            $emailaddress = $email_address['email'];

            $this->set('email', $emailaddress);
            $this->set('username',$email_address['first_name']);
            $this->set('item_title',$item_title);
            $this->set('item_url',$item_url);
            $this->set('itemId',$itemId);
            $this->set('access_url',SITE_URL."merchant/login");

            echo 'true';
        }
    }

    public function changepassword()
    {
        if(!$this->isauthenticated())
            $this->redirect(['action' => 'login']);

        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Merchant');

        global $setngs;
        global $siteChanges;
        global $loguser;

        $user = $this->Users->get($this->Auth->user('id'));

        if(!empty($this->request->data()))
        {
            $user = $this->Users->patchEntity($user, $this->request->getData(),['validate' => 'password']);
            if($user->errors()==false)
            {
                //POST VALUES
                $password = trim($this->request->data['newpassword']);
                $cpassword = trim($this->request->data['cpassword']);

                if($password != $cpassword) {
                $this->Flashmessage('error', "Try again");
                $this->redirect('/merchant/changepassword');
                }

                $usersTable = TableRegistry::get('Users');
                $usersarticle = $usersTable->get($loguser['id']);
                $usersarticle->password = (new DefaultPasswordHasher)->hash($password);

                if($usersTable->save($usersarticle)) {
                $this->Flashmessage('success', "Your password has been changed successfully");
                    $this->redirect('/merchant/dashboard');
                } else {
                $this->Flashmessage('error', "Try again");
                }
            } else {
                $this->Flashmessage('error', "Incorrect old password");
                $this->redirect('/merchant/changepassword');
            }
        }
        $this->set('user',$user);
    }

    public function setpassword($userid = NULL)
    {
        $this->viewBuilder()->setLayout('merchant');
        $this->set('title_for_password','default');

        $email = ""; $veri_code = "";
        global $setngs;

        if($userid != "") {
            $userval = explode("~", $userid);
            $email = trim(base64_decode($userval[0]));
            $veri_code = trim($userval[1]);
            $_SESSION['email_verify'] = $email;
            $_SESSION['emailcode_verify'] = $veri_code;
            $expiry_time = strtotime('+1 day', $veri_code);
            $current_time = time();

            $userstable = TableRegistry::get('Users');
            $userpassdetails = $userstable->find()->where(['email'=>$email, 'verify_pass'=>$veri_code])->first();

            if($email=="" || $veri_code=="") {
                $this->Flashmessage('error', "Not Authorized to Access");
                $this->redirect('/merchant/login');
            } else if(count($userpassdetails) <= 0) {
                $this->Flashmessage('error', "Invalid URL Link");
                $this->redirect('/merchant/login');
            } else if($expiry_time <= $current_time) {
                $this->Flashmessage('error', "Password Reset link expired, Try again");
                $this->redirect('/merchant/login');
            }
        }

        if(!empty($this->request->data()))
        {
            $user = $this->Users->newEntity($this->request->getData(),['validate' => 'setpassword']);
            if($user->errors()==false)
            {
                $verify_email = trim($this->request->data['email']);
                $verify_code = trim($this->request->data['verify_pass']);
                $password = trim($this->request->data['newpassword']);
                $cpassword = trim($this->request->data['cpassword']);
                $email_verify = trim($_SESSION['email_verify']);
                $emailcode_verify = trim($_SESSION['emailcode_verify']);

                if($verify_email == "" || $verify_code == "") {
                $this->Flashmessage('error', "Try again");
                $this->redirect('/merchant/login');
                } else if($email_verify != $verify_email || $emailcode_verify != $verify_code) {
                $this->Flashmessage('error', "Try again");
                $this->redirect('/merchant/login');
                } else {
                $usersTable = TableRegistry::get('Users');
                $userdetails = $usersTable->find()->where(['email'=>$verify_email, 'verify_pass'=>$verify_code])->first();
                if(count(trim($userdetails) > 0)) {
                    $usersarticle = $usersTable->get($userdetails['id']);
                    $usersarticle->password = (new DefaultPasswordHasher)->hash($password);
                    if($usersTable->save($usersarticle)) {
                        $this->Flashmessage('success', "New Password Generated, please login to continue");
                        $_SESSION['email_verify'] = "";
                        $_SESSION['emailcode_verify'] = "";
                        $this->redirect('/merchant/login');
                    } else {
                        $this->Flashmessage('error', "Try again");
                    }
                } else {
                    $this->Flashmessage('error', "Try again");
                    $this->redirect('/merchant/login');
                }
                }
            } else {
                $this->Flashmessage('error', "Try again");
                $this->redirect('/merchant/login');
            }
        }
        $this->set('email',$email);
        $this->set('veri_pass',$veri_code);
    }

    public function resetnotify() {
        $this->autoRender = false;
        if(!$this->isauthenticated()) {
            $this->redirect(['action' => 'login']);
        }

        // DECLARATION & INITIALIZATION
        global $loguser;
        $userid = $loguser['id'];

        if(!empty($userid) && $userid > 0) {
            $usersTable = TableRegistry::get('Users');
            $query = $usersTable->query();
            $notifydata = $usersTable->find()->where(['id'=>$loguser['id']])->first();
            $query->update()->set(['unread_notify_cnt' => 0])->where(['id'=>$userid])->execute();
            echo trim($notifydata['unread_notify_cnt']);
        } else {
            echo "false";
        }
    }

    public function notifications()
    {
        if(!$this->isauthenticated())
            $this->redirect(['action' => 'login']);

        $this->viewBuilder()->setLayout('merchanthome');
        $this->set('title_for_layout','Merchant');

        global $setngs;
        global $loguser;

        $this->loadModel('Logs');

        $type = array('follow','review','groupgift','admin','dispute','orderstatus','ordermessage','itemapprove','chatmessage','invite','credit','cartnotification', 'admin_commision');

        $logmessage = $this->Logs->find()->where(['Logs.notifyto IN'=>array($loguser['id'],0), 'Logs.type IN'=>$type])->order(['cdate' => 'DESC'])->toArray();

        $this->set('logmessage',$logmessage);
    }

    public function language($language = NULL)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        if($language != '') {
            $lang_details=TableRegistry::get('Languages')->find()->where(['languagename'=>$language])->first();
            if(!empty($lang_details)) {
                unset($_SESSION['languagecode']);
                unset($_SESSION['languagename']);
                $_SESSION['languagecode']=$lang_details['languagecode'];
                $_SESSION['languagename']=$lang_details['languagename'];
            }
        }
        $this->redirect($this->referer());
    }

    public function checkcarthours() {
        $this->autoRender = false;

        global $loguser;
        global $siteChanges;
        global $setngs;

        $curtime = date('Y-m-d H:i:s', strtotime('-24 hours'));
        $this->loadModel('Items');
        $this->loadModel('Carts');
        $this->loadModel('Userdevices');

        $cartUser = $this->Carts->find()->where(['payment_status' => 'progress', 'created_at <=' => $curtime,'emailsentstatus' =>0 ])->all();

        if(count($cartUser) > 0) {
            foreach($cartUser as $User) {
                $usrids[] = $User['user_id'];
            }
            $usrids = array_unique($usrids);
            foreach($usrids as $uid) {
                $cartitms = $this->Carts->find()->where(['user_id' => $uid, 'payment_status' => 'progress', 'created_at <=' => $curtime, 'emailsentstatus' => 0])->all();

                foreach($cartitms as $carts) {
                $itemIds[$uid][] = $carts['item_id'];
                $cartquantity[$uid][$carts['item_id']] = $carts['quantity'];
                }
            
                $userModelemail = $this->Users->find()->where(['id' => $uid])->first();
                if(!empty($userModelemail)) {

                $itm_datas = $this->Items->find()->where(['id IN'=>$itemIds[$uid],'status'=>'publish', 'quantity >'=>0])->all();

                if(count($itm_datas) > 0) {
                    $image['user']['image'] = 'usrimg.jpg';
                    $image['user']['link'] = '';
                    $loguserimage = json_encode($image);
                    $notifymsg = "You forgot to checkout item(s)";
                    $messages = " ";
                    $logdetails = $this->addlog('cartnotification',0,$uid,0,$notifymsg,$messages,$loguserimage);

                    if(!empty($userModelemail['email'])) {
                        $email=$userModelemail['email'];
                        $aSubject = __d('merchant','Thanks for visiting us at')." ".$setngs['site_name'];
                        $aBody='';
                        $template='cartnotification';
                        $setdata=array('userid'=>$uid, 'itemdatas'=>$itm_datas, 'cartquantity'=>$cartquantity, 'custom'=> $userModelemail['username'], 'access_url'=> SITE_URL."cart", 'setngs'=>$setngs);
                        $mailcheck = $this->sendmail($email,$aSubject,$aBody,$template,$setdata);
                    }
                    $cartsTable = TableRegistry::get('Carts');
                    $query = $cartsTable->query();
                    $query->update()->set(['emailsentstatus' => 1])->where(['user_id' => $uid,'item_id IN' => $itemIds[$uid]])->execute();
                    
                    $userdevicetable = TableRegistry::get('Userdevices');
                    $query = $userdevicetable->query();
                    $userddetts = $this->Userdevices->findAllByUser_id($uid)->all();
                    if(count($userddetts) > 0) {
                        foreach($userddetts as $userdet) {
                            $deviceTToken = $userdet['deviceToken'];
                            $badge = $userdet['badge'];
                            $badge +=1;

                            $query->update()->set(['badge' => $badge])->where(['deviceToken'=>$deviceTToken])->execute();

                            if(isset($deviceTToken)) {
                            $pushMessage['type'] = 'cartnotification';
                            $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userdet['user_id']])->first();
                            I18n::locale($user_detail['languagecode']);

                            $pushMessage['message'] = __d('merchant','You forgot to checkout item(s)');
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken,$messages,$badge);
                            }
                        }
                    }  
                }
                }
            }
        }
        }

        public function demopro($sdate = NULL ,$edate = NULL)
        {
            //echo 'test'; die;
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);
            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Sales');

            if($sdate > $edate)
                    $this->Flashmessage('error', 'Error in search date','demopro');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->loadModel('Items');
            $userid = $loguser['id'];
            $item_datas = "";

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $sdate = date("Y-m-d H:i:s", $sdate);
                $edate =  date("Y-m-d H:i:s", $edate);

                $item_datas = $this->Items->find()->where(['Items.user_id'=>$userid])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('Items.created_on', $sdate, $edate); })->order(['Items.id'=>'desc'])->all();
            } else {
                $item_datas =  $this->Items->find()->where(['Items.user_id'=>$userid])->order(['modified_on' => 'DESC'])->toArray();
            }

            //print_r(expression)

            $this->set('item_datas',$item_datas);
            $this->set('sdate',$sdate);
            $this->set('edate',$edate);
        }


        public function productsfaq($sdate = NULL ,$edate = NULL)
        {
            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Product faq');

            if($sdate > $edate)
                    $this->Flashmessage('error', 'Error in search date','editproducts');

            global $setngs;
            global $siteChanges;
            global $loguser;

            $this->loadModel('Productfaq');
            $productfaqTable = TableRegistry::get('Productfaq');

            //$sdate = '06/15/2020';
            //$edate = '06/15/2020';

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                $sdate = date("Y-m-d H:i:s", $sdate);
                $edate =  date("Y-m-d H:i:s", $edate);

                $faq_datas = $this->productsfaq->find()->where(['type'=>'question','seller_answer'=>'0','Productfaq.seller_id'=>$loguser['id']])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('Productfaq.created_on', $sdate, $edate); })->order(['Productfaq.id'=>'desc'])->all();

                
            } else {

                $faq_datas =  $this->Productfaq->find()->where(['type'=>'question','seller_answer'=>'0','seller_id'=>$loguser['id']])->order(['id' => 'DESC'])->toArray();
            }

            

        //echo $sdate; die;
            /*
        $item_datas = $this->Productfaq->find()->where(['type'=>'question','seller_answer'=>'0','Productfaq.seller_id'=>$loguser['id']])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('Productfaq.created_on', $sdate, $edate); })->order(['Productfaq.id'=>'desc'])->all();

        echo '<pre>'; print_r($item_datas); die;
        */

            $this->set('faq_datas',$faq_datas);
            $this->set('sdate',$sdate);
            $this->set('edate',$edate);
        }

        public function answeredproductsfaq()
        {

            if(!$this->isauthenticated())
                $this->redirect(['action' => 'login']);

            $this->viewBuilder()->setLayout('merchanthome');
            $this->set('title_for_layout','My Product faq');

            if($sdate > $edate)
                    $this->Flashmessage('error', 'Error in search date','editproducts');

            global $setngs;
            global $siteChanges;
            global $loguser;



            $this->loadModel('Productfaq');
            $productfaqTable = TableRegistry::get('Productfaq');

            if(($sdate != NULL && $edate != NULL) && ($sdate != 0 && $edate != 0))
            {
                //echo 'test'; die;
                $sdate = date("Y-m-d H:i:s", $sdate);
                $edate =  date("Y-m-d H:i:s", $edate);

                $faq_datas = $this->productsfaq->find()->where(['Productfaq.seller_id'=>$loguser['id'],'type'=>'question','seller_answer'=>'1'])->andwhere(function ($exp, $q) use ($sdate, $edate){ return $exp->between('Productfaq.created_on', $sdate, $edate); })->order(['Productfaq.id'=>'desc'])->all();
            } else {

                $faq_datas =  $this->Productfaq->find()->where(['type'=>'question',
                    'seller_answer'=>'1',
                    'seller_id'=>$loguser['id']])->order(['id' => 'DESC'])->toArray();
            }


            $this->set('faq_datas',$faq_datas);
            $this->set('sdate',$sdate);
            $this->set('edate',$edate);
        }

        function itempopup(){
            $question_id = trim($_POST['question_id']);
            $this->loadModel('Productfaq');
            $this->loadModel('Items');
            $get_faq_data =  $this->Productfaq->find()->where(['id'=>$question_id])->first();

            $item_datas = $this->Items->find()->contain(['Photos'])->where(['Items.id'=>$get_faq_data->item_id])->first();

            $item_image = SITE_URL.'/media/items/original/'.$item_datas->photos[0]->image_name;
            $itemid = base64_encode($item_datas->id . "_" . rand(1, 9999));
            $product_url = SITE_URL . 'listing/' . $itemid;
            
            $fav = '<div><img src="'.$item_image.'" width="50" height="50" /></div>
            <div class="item_title"><a href="'.$product_url.'">'.$item_datas->item_title.'</div><input type="hidden" name="question_id" value="'.$question_id.'" /><input type="hidden" name="item_id" value="'.$item_datas->id.'" /><input type="hidden" name="seller_id" value="'.$item_datas->user_id.'" />';
            echo trim($fav); die;
            //return $fav; 
        }

        public function submitanswer()
        {
            $this->loadModel('Productfaq');
            if($_POST['content'] == '' || !isset($_POST['content']))
            {
                $this->Flashmessage('error', 'content is empty');
                $this->redirect('/merchant/merchant/productsfaq');
                //die;
            }else{
                
                $productfaqTable = TableRegistry::get('Productfaq');
                $faqModel = $productfaqTable->newEntity();
                $faqModel->item_id = trim($_POST['item_id']);
                $faqModel->seller_id = trim($_POST['seller_id']);
                $faqModel->user_id = trim($_POST['user_id']);
                $faqModel->content = nl2br($_POST['content']);
                $faqModel->type = 'answer';
                $faqModel->parent_id = trim($_POST['question_id']);
                $faqResult = $productfaqTable->save($faqModel);

                

                $ansCount =  $this->Productfaq->find()->where(['parent_id'=>$_POST['question_id']])->count();

                
                $conditions = array('id'=>$_POST['question_id']);
                $fields = array('answer_count'=>$ansCount+1,'seller_answer'=>'1');
                $ss = $productfaqTable->updateAll($fields, $conditions);
                $this->redirect(['action' => 'productsfaq']);
            }
        }
}
