<?php

namespace App\Controller;

/**
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


use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;
use Cake\Mailer\Email;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
$config = Router::url('/',true);

define('SITE_URL',$config);


define('WEBROOT_PATH', SITE_URL . "webroot/");

class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
      $this->loadComponent('Flash');
      $this->loadComponent('Urlfriendly');
      $this->loadComponent('Currency');
      $this->loadComponent('Cookie', ['expires' => '1 day']);
      
      parent::initialize();
      if($this->request->params['prefix'] == 'admins'){

       $this->loadComponent('Auth',

        ['authorize'=> 'Controller',
        'authError'    => '',
        'authenticate' => [
        'Form' => [
        'fields' => [
        'username' => 'email',
        'password' => 'password'
        ]
        ]
        ],
        'loginAction' => [
        'controller' => 'Admins',
        'action' => 'login'

        ],

        'loginRedirect' => [
        'controller' => 'Admins',
        'action' => 'dashboard'
        ],
        'logoutRedirect' => [
        'controller' => 'Admins',
        'action' => 'login'
        ],
        'storage' => [
        'className' => 'Session',
        'key' => 'Auth.Admin',
        ],
            'unauthorizedRedirect' => $this->referer() // If unauthorized, return them to page they were just on
            ]);
   }
   else if($this->request->params['prefix'] == 'merchant'){

       $this->loadComponent('Auth',

        ['authorize'=> 'Controller',
        'authError'    => '',
        'authenticate' => [
        'Form' => [
        'fields' => [
        'username' => 'email',
        'password' => 'password'
        ]
        ]
        ],
        'loginAction' => [
        'controller' => 'Merchant',
        'action' => 'login'

        ],

        'loginRedirect' => [
        'controller' => 'Merchant',
        'action' => 'dashboard'
        ],
        'logoutRedirect' => [
        'controller' => 'Merchant',
        'action' => 'login'
        ],
        'storage' => [
        'className' => 'Session',
        'key' => 'Auth.Merchant',
        ],
            'unauthorizedRedirect' => $this->referer() // If unauthorized, return them to page they were just on
            ]);
   }else {

    $this->loadComponent('Auth',

        ['authorize'=> 'Controller',
        'authError'    => '',
        'authenticate' => [
        'Form' => [
        'fields' => [
        'username' => 'email',
        ]
        ]
        ],
        'loginAction' => [
        'controller' => 'Users',
        'action' => 'login'

        ],

        'loginRedirect' => [
        'controller' => 'Users',
        'action' => 'home'
        ],
        'logoutRedirect' => [
        'controller' => 'Users',
        'action' => 'login'
        ],
        'storage' => [
        'className' => 'Session',
        'key' => 'Auth.User',
        ],
            'unauthorizedRedirect' => $this->referer() // If unauthorized, return them to page they were just on
            ]);
}
        // Allow the display action so our pages controller
        // continues to work.
$this->Auth->allow(['index']);
$this->loadComponent('RequestHandler');
 //  $this->Flash->render('fdf');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event)
    {

        $this->Auth->allow(['index', 'login','admin','loginwith','sociallogin','socialRedirect','signup','search','userprofiles','getmoreprofile','view','showlistproducts','storeprofiles','customhome','allstores','getmorestores','showByCategory','searchactiveuser','forgotpassword','setpassword','sitemaintenance', 'checknewusername', 'checknewuseremail','conversion','merchanthomepage','loginwithfb','loadmore']);
        global $loguser;

        //if(isset($this->Cookie->read('User')))
        $cookieval = $this->Cookie->read('User');
        $merchantcookieval = $this->Cookie->read('Merchant');

        if(count($cookieval)>0)
        {
            $this->Cookie->delete('Merchant');
            $this->request->data['email'] = $cookieval['email'];
            $this->request->data['password'] = base64_decode($cookieval['pass']);
            $user = $this->Auth->identify();
            $this->Auth->setUser($user);

        }

        if(count($merchantcookieval)>0)
        {
            $this->Cookie->delete('User');
            $this->request->data['email'] = $merchantcookieval['email'];
            $this->request->data['password'] = base64_decode($merchantcookieval['pass']);
            $user1 = $this->Auth->identify();
            $this->Auth->setUser($user1);

        }
        $loguser = $this->Auth->user();
        $this->set('loguser',$loguser);
        $this->loadModel('Sitesettings');

        $this->loadModel('Prices');
        $this->loadModel('Forexrates');
        $setngs = $this->Sitesettings->find()->toArray();
        $this->set('setngs',$setngs);
        // CONTACT SELLERS
        $this->loadModel('Contactsellers');

        $currencycomponent = $this->Currency;
        $this->set('currencycomponent',$currencycomponent);

        global $loguser;
        global $mobilepages;
        global $googlecode;

        

        $googlecodetable = TableRegistry::get('Googlecodes');
        $googlecode = $googlecodetable->find()->where(['id'=>'1'])->first();
        $this->set('googlecode',$googlecode);

        $mobilepagestable = TableRegistry::get('Mobilepages');

        $mobilepages = $mobilepagestable->find()->where(['id'=>'1'])->first();
        $loguser = $this->Auth->user();
        $userid = $loguser['id'];
        $this->set('loguser',$loguser);
        $this->set('mobilepages',$mobilepages);

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id'=>1])->first();
        $this->set('setngs',$setngs);

        /** LANGUAGES **/
        $languagetable = TableRegistry::get('Languages');
        $languages = $languagetable->find()->all()->toArray();
        $this->set('languages',$languages);
        if($_SESSION['languagecode']!=""){
            I18n::locale($_SESSION['languagecode']);
        }

        $userstable = TableRegistry::get('Users');
        $userDetails = $userstable->find('all')->where(['id'=>$userid])->first();
        $this->set('userDetails',$userDetails);
        $this->set('userDetailss',$userDetails);

        $this->loadModel('Categories');
        $categoriestable = TableRegistry::get('Categories');
        $prnt_cat_data = $categoriestable->find()->where(['category_parent'=>0])->where(['category_sub_parent'=>0])->all();
        $this->set('prnt_cat_data',$prnt_cat_data);

        $this->loadModel('Giftcards');
        $this->loadModel('Carts');
        $this->loadModel('Items');

        //print_r($_SESSION);

        $giftcarduseradded = $this->Giftcards->find('all',array('conditions'=>array('Giftcards.user_id'=>$userid,'Giftcards.status'=>'Pending'),'order'=>'Giftcards.id DESC'));

        if(!empty($giftcarduseradded)){
            $giftcarditemDetails = json_decode($setngs['giftcard'],true);
            //echo "<pre>";print_r($giftcarduseradded);die;
            $this->set('giftcarditemDetails',$giftcarditemDetails);
            $this->set('giftcarduseradded',$giftcarduseradded);
            $this->set('countgiftcarduseradded',count($giftcarduseradded));
        }

        $_SESSION['site_url'] = SITE_URL;
        $_SESSION['media_url'] = SITE_URL;
        if (!empty($setngs[0]['media_url'])) {
            $_SESSION['media_host_name'] = $setngs[0]['media_server_hostname'];
            $_SESSION['media_url'] = $setngs[0]['media_url'];
            $_SESSION['media_server_username'] = $setngs[0]['media_server_username'];
            $_SESSION['media_server_password'] = $setngs[0]['media_server_password'];
        }

        $this->loadModel('Managemodules');
        $managemoduleModel = $this->Managemodules->find()->first();
        $this->set('managemoduleModel',$managemoduleModel);



        $action = $this->request->param('action');
        $user_level = $userDetails->user_level;

       /* if ($this->params['controller'] != 'api') {
            $this->_setLanguage();
        }*/
        if ($action != 'sitemaintenance' && $action != 'login'){
            if (!$this->isauthenticated() || $user_level != 'god'){
                //echo $action;die;
                if ($managemoduleModel->site_maintenance_mode == 'yes'){
                    $this->redirect('/sitemaintenance');
                }
            }
        }
         //echo "<pre>"; print_r($user);
        //user auto login 
        if(!empty($loguser))
        {
           $checkuseractive = TableRegistry::get('Users')->find('all')->where(['Users.id'=>$loguser['id']])->andwhere(['Users.user_status'=>'enable'])->count();


           if ($action != 'login' && $action != 'logout' && $checkuseractive=='0'){
               $_SESSION['loginError']='Your account has been disabled please contact our support';
               $this->redirect('/logout');

           }

       }
       
        //User auto login

        // OPEN CART SECTION
       if(!empty($userid) && ($userid != 1)){
        $carts = $this->Carts->find('all',array('conditions'=>array('user_id'=>$userid,'payment_status'=>'progress')))->order(['id DESC'])->all();
        $itemstable= TableRegistry::get('Items');
        $photostable= TableRegistry::get('Photos');
        $totalitem_count=0;
        if(count($carts) >0){
           foreach($carts as $key=>$crt){
            $item_datas_count = $itemstable->find()->where(['Items.id'=>$crt['item_id']])->where(['Items.status'=>'publish'])
            ->count();
            if($item_datas_count >0)
            {
                $item_datas = $itemstable->find()->where(['Items.id'=>$crt['item_id']])->where(['Items.status'=>'publish'])
                ->first();
                $item_photos = $photostable->find()->where(['item_id'=>$crt['item_id']])->first();
                $defaultcart[$key]['cartid'] = $crt['id'];
                $defaultcart[$key]['itemid'] = $item_datas['id'];
                $defaultcart[$key]['item_title_url'] = $item_datas['item_title_url'];
                $defaultcart[$key]['name'] = $item_datas['item_title'];
                $defaultcart[$key]['qty'] = $crt['quantity'];
                $defaultcart[$key]['size'] = $crt['size_options'];
                $defaultcart[$key]['price'] = $item_datas['price'];
                $defaultcart[$key]['image'] = $item_photos['image_name'];
                if($defaultcart[$key]['size']!=""){
                    $product_store=json_decode($item_datas['size_options'],true);
                    $product_price=$product_store['price'][$defaultcart[$key]['size']];
                    if($product_price!=""){
                        $defaultcart[$key]['price'] = $product_price;
                    }
                }
                $total_count++;
            }}
            $defaultcart_total_itms = $total_count;
        }
        $this->set('defaultcart',$defaultcart);
        $this->set('defaultcart_total_itms',$defaultcart_total_itms);
        unset($_SESSION['total_itms']);
        $_SESSION['total_itms']=$defaultcart_total_itms;
    }


    if($this->request->params['prefix'] == 'admins')
    {
       $this->Auth->allow(['searchactiveuser']);
   }

   $this->Auth->allow(['beforeFilter','index', 'login','admin','loginwith','social','socialRedirect','signup','search','userprofiles','getmoreprofile','verification','getMorePosts','view','adduserlist','reportitem','undoreportitem','sendmessage','changecurrency','totaladduserlist','customviewmore','getviewmore','showlistproducts','storeprofiles','getmorestoreprofiles','customhome','allstores','getmorestores','showByCategory','getItemByCategory','ajaxUserAuto','ajaxHashAuto','addcomments','editcommentsave','deletecomments','getsizeqty','faq','contact','copyright','termsSales','termsService','termsCondition','privacy','mobileapps','addto','about','documentation','press','pricing','talk','collections','checkout','captcha','ajaxSearch','searches','setlanguage','sociallogin','allcategories','customviewmorestore']);
   if (empty($this->request->params['prefix']) || $this->request->params['prefix'] == 'items')
   {
    $this->Auth->allow();
    }
   if (empty($this->request->params['prefix']) || $this->request->params['prefix'] == 'api')
   {
    $this->Auth->allow();
    }

    if (empty($this->request->params['prefix']) || $this->request->params['prefix'] == 'Merchantapi')
   {
    $this->Auth->allow();
    }

if (!isset($_SESSION['language_settings'])){
    $languageJson = file_get_contents(SITE_URL.'language_settings.json');
    $_SESSION['language_settings'] = json_decode($languageJson, true);
    $defaultLanguage = $_SESSION['language_settings']['settings']['default'];
            //Configure::write('Config.language', $defaultLanguage);
}else{
            //Configure::write('Config.language', $_SESSION['language_settings']['settings']['default']);
}


        /*if (!isset($_SESSION['currency_value'])){
            $forexrateModel = $this->Forexrates->find()->where(['cstatus'=>'default'])->first();

            $_SESSION['currency_symbol'] = $forexrateModel['currency_symbol'];
            $_SESSION['currency_value'] = $forexrateModel['price'];
            $_SESSION['currency_code'] = $forexrateModel['currency_code'];
            $_SESSION['default_currency_code'] = $forexrateModel['currency_code'];
            $_SESSION['default_currency_symbol'] = $forexrateModel['currency_symbol'];

        }*/
        $forexratestable = TableRegistry::get('Forexrates');
        $forexrateModel = $forexratestable->find()->where(['cstatus'=>'default'])->first();

        $_SESSION['default_currency_code'] = $forexrateModel['currency_code'];
        $_SESSION['default_currency_symbol'] = $forexrateModel['currency_symbol'];
        $_SESSION['default_currency_value'] = $forexrateModel['price'];

        if($_SESSION['currency_symbol'] == "" && $_SESSION['currency_value'] == "" && $_SESSION['currency_code'] == "")
        {
            $_SESSION['currency_symbol'] = $forexrateModel['currency_symbol'];
            $_SESSION['currency_value'] = $forexrateModel['price'];
            $_SESSION['currency_code'] = $forexrateModel['currency_code'];
        }

        // NOTIFICATIONS COUNT
        $notifyCount = $userDetails['unread_notify_cnt'];


        // MESSAGES COUNT
        $messageCount = $this->Contactsellers->find()->where(['merchantid' => $userid,['sellerread' => 1]])->orWhere(['buyerid' => $userid,['buyerread' => 1]])->count();
        $msgCount = $messageCount;
        //}

        $this->set(compact('notifyCount','msgCount'));
       /*  if($this->request->prefix){
            $this->Auth->config('storage',  [
                'key'=>'Auth.'.$this->request->prefix,
                'className'=>'Session'
            ]);
        }*/
        $helpstable = TableRegistry::get('Helps');
        $helpdata = $helpstable->find()->where(['id'=>1])->first();
        $this->set('helpdata',$helpdata);



        return parent::beforeFilter($event);
    }

    function isauthenticated(){
      $user =  $this->Auth->user();
      if(!empty($user))
        return true;
    else
        return false;
}

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
            ) {
            $this->set('_serialize', true);
    }
}


/** SEND MAILS **/
public function sendmail($to=null,$subject=null,$msg=null,$template=null,$setdata=null)
{
        //$this->autoLayout = false;
        //$this->autoRender = false;
    $sitesettings = TableRegistry::get('Sitesettings')->find()->where(['id'=>1])->first();
    if($sitesettings['gmail_smtp']=='enable'){
        //** EMAIL SETTIGNGS ** /
        Email::dropTransport('gmail');
        Email::configTransport('gmail', [
            'host' => $sitesettings['noreply_host'],
            'port' => $sitesettings['smtp_port'],
            'username' => $sitesettings['noreply_email'],
            'password' => $sitesettings['noreply_password'],
            'className' => 'Smtp',
            'tls' => true
            ]);
        $email = new Email();
        $email->transport('gmail');
        $email
        ->to($to)
        ->emailFormat('html')
        ->viewVars($setdata)
        ->template($template)
        ->from('Support@fantacy.com')
        ->subject($subject)
        ->send();
        return true;
    }
    else{
        return false;
    }
}

/** PUSH NOTIICATIONS */
public function pushnot($deviceToken=NULL,$message=NULL,$badge=NULL){
    $userdevicestable = TableRegistry::get('Userdevices');
    $userddett = $userdevicestable->find()->where(['deviceToken'=>$deviceToken])->first();
    $userddettcount = $userdevicestable->find()->where(['deviceToken'=>$deviceToken])->count();
    if($userddettcount>0)
    {
        if($userddett['type'] == 0){
            $this->sendios_push_notification($deviceToken, $message);
        }
        else{
            $this->send_push_notification($deviceToken, $message);
        }
    }

}

/* Send Android Push notifications */
public function send_push_notification($registatoin_ids, $message) {

    $url = 'https://fcm.googleapis.com/fcm/send';
    $sitesettings = TableRegistry::get('Sitesettings')->find()->where(['id'=>1])->first();
    $registatoin_ids = array($registatoin_ids);
    $messageToBeSent = array();
    $messageToBeSent['data']['message'] = json_decode($message, true);
    $fields = array(
        'registration_ids' => $registatoin_ids,
        'data' => $messageToBeSent,
        );
    $id = 1;
    $headers = array(
        'Authorization: key='.$sitesettings['google_api'],
        'Content-Type: application/json'
        );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch );
    if ($result === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
    } else {
        //var_dump($result);
    }
    curl_close( $ch );
}


/* Send IOS Push notifications */
public function sendios_push_notification($registatoin_ids, $message) {
    $url = 'https://fcm.googleapis.com/fcm/send';
    $sitesettings = TableRegistry::get('Sitesettings')->find()->where(['id'=>1])->first();
    $registatoin_ids = array($registatoin_ids);
    $decodeiosmessage = json_decode($message, true);
    $iosmessage=$decodeiosmessage['user_name'].' '.$decodeiosmessage['message'];
    $fcmMsg = array(
        'body' => $iosmessage,
        );

    $fields = array(
        'registration_ids' => $registatoin_ids,
        'priority' => 'high',
        'notification' => $fcmMsg
        );

    $headers = array(
        'Authorization: key='.$sitesettings['google_api'],
        'Content-Type: application/json'
        );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch );
    if ($result === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
    } else {
        //var_dump($result);
    }
    curl_close( $ch );
}

public function autologout()
{
    $this->Cookie->delete('User');
    return $this->redirect($this->Auth->logout());

}
}
