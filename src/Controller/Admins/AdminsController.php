<?php
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
namespace App\Controller\Admins;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundExceptiofn;
use Cake\View\Exception\MissingTemplateException;
use Cake\Controller\Component\FlashComponent;
use Cake\Controller\Component\AuthComponent;
//use Cake\Controller\Component\ExportComponent;
use Cake\Controller\Component\UrlfriendlyComponent;
use Cake\View\Helper\FlashHelper;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use App\Controller\AppController;
//use App\Controller\Users\UsersController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\Model\Table\SitesettingsTable;
use App\Model\Table\OrdersTable;
use App\Model\Table\CommissionsTable;
use App\Model\Table\ForexratesTable;
use App\Model\Table\TaxesTable;
use App\Model\Table\CountriesTable;
use App\Model\Table\InvoicesTable;
use App\Model\Table\InvoiceordersTable;

use App\Model\Table\Order_itemsTable;
use App\Model\Table\ItemsTable;
use App\Model\Table\ShippingaddressesTable;
use App\Model\Table\CouponsTable;
use App\Model\Table\ItemfavsTable;
use App\Model\Table\ShopfavsTable;
use App\Model\Table\ShopsTable;
use App\Model\Table\CommentsTable;
use App\Model\Table\LogsTable;
use App\Model\Table\TempaddressesTable;
use App\Model\Table\ItemlistsTable;
use App\Model\Table\FollowersTable;
use App\Model\Table\StorefollowersTable;

use App\Model\Table\WantownitsTable;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\I18n\I18n;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AdminsController extends AppController
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
    public function addmember()
    {
       $this->viewBuilder()->setLayout('admin');

       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Users');
       global $setngs;
       $addmember   =   $this->Users->newEntity();
       if(!empty($this->request->data)){

           $username =  $this->request->data('username');
           // $phone_no = $this->request->data('phone_no');
           // $phone_no = preg_replace('/[^0-9]/','',$phone_no);
           $firstname = $this->request->data('firstname');
           $email = $this->request->data('email');
           $menulist = $this->request->data('menulist');

           $password = $this->request->data('password');

           $nmecounts = $this->Users->find()->where(['username'=>$username])->count(); 
           $emlcounts = $this->Users->find()->where(['email'=>$email])->count();
          // $phonecount = $this->Users->find()->where(['phone_no'=>$phone_no])->count();

           if($nmecounts > 0){
               $this->Flash->Error(__d('admin','username already exists'));
               $this->redirect($this->referer());
           }else if($emlcounts > 0){
               $this->Flash->Error(__d('admin','Email already exists'));
               $this->redirect($this->referer());
           }
           // else if($phonecount > 0){
           //     $this->Flash->Error(__d('admin','Phone number already exists'));
           //     $this->redirect($this->referer());
           // }
           else{
               $addmember->username = $username;
               $addmember->username_url = $username;
               $addmember->first_name = $firstname;
               $addmember->email = $email;
             //  $addmember->phone_no = $phone_no;
               $addmember->password = (new DefaultPasswordHasher)->hash($this->request->data('password'));
               if($this->request->data('usr_access')=='moderator')
               {
                   $addmember->user_level = $this->request->data('usr_access');
                   if($this->request->data('menulist')=="")
                   {
                       $admin_menu_default = "Home";
                       $admin_default = json_encode($admin_menu_default);
                       $addmember->admin_menus = $admin_default;
                   }
                   else
                       $addmember->admin_menus = $this->request->data('menulist');
               }
               else
                   $addmember->user_level = $this->request->data('usr_access');
               $addmember->activation = '1';

               $addmember->user_status = 'enable';
               $addmember->push_notifications = '{"somone_flw_push":"1",
               "somone_cmnts_push":"1","somone_mentions_push":"1","somone_likes_ur_item_push":"1",
               "frends_flw_push":0,"frends_cmnts_push":0}';
               $addmember->created_at = date('Y-m-d H:i:s');

               $this->Users->save($addmember);
               if($this->request->data['usr_access']=='normal')
               {
                   $this->Flash->success(__d('admin','User added successfully'));
                   $this->redirect('/manageuser/');

               }
               else
               {
                   $this->Flash->success(__d('admin','Moderator added successfully'));
                   $this->redirect('/managemoderator/');
               }
           }
       }else{
           $this->loadModel('Countries');
           $countries = $this->Countries->find('all');
           $this->set('countries',$countries);

       }
   }
   public function dashboard()
   {


     if(!$this->isauthenticated())
       $this->redirect('/');
   $this->viewBuilder()->setLayout('admin');

   $this->loadModel('News');
   $this->loadModel('Items');
   $this->loadModel('Orders');
   $this->loadModel('Shops');
   $this->loadModel('Payments');
   $this->loadModel('Users');
   $tdy = date("Y-m-d");

   $conn = ConnectionManager::get('default');
   $loguserlevel =$_SESSION['Auth']['Admin']['user_level'];
   $logadminmenus = $_SESSION['Auth']['Admin']['admin_menus'];

   /* Check for no of visits */
   $session = $this->request->session();

   if($session->check('visitcount'))
   {
       $visitcnt = $session->read('visitcount');
       $session->write('visitcount', $visitcnt+1);
   }
   else
   {
       $visitcnt = 1;
       $session->write('visitcount', $visitcnt);
   }

   $visitcount = $session->read('visitcount');
   $this->set('visitcount',$visitcount);
   /* Check for no of visits */

   $this->set('loguserlevel',$loguserlevel);
   $this->set('logadminmenus',$logadminmenus);

   $tiswk_strt = date("Y-m-d",strtotime("this week last sunday"));
   $tiswk_end = date("Y-m-d",strtotime("this week next saturday"));

   $tismnth_strt = date("Y-m-d",strtotime('first day of this month'));
   $tismnth_end = date("Y-m-t",strtotime('this month'));
   $userstatus = array('god' =>'god','moderator'=>'moderator','shop'=>'shop');
   $total_usrs = $this->Users->find()->where(['user_level NOT IN'=>$userstatus])->count();

   $enbleusrs = $this->Users->find()->where(['user_level NOT IN'=>$userstatus])->andWhere(['user_status'=>'enable'])->count();
   $today=date("Y-m-d h:m:s",time());

   $todayregister_user =  $this->Users->find()->where(['user_level NOT IN'=>$userstatus])->andWhere(['created_at >'=> $today])->count();
   $this->set('todayregister_user',$todayregister_user);
   $user_datas= $this->Users->find('all', array(
     'conditions' => array('Users.user_level NOT IN'=>$userstatus,'Users.user_status'=>'enable'),
     'order' => 'rand()',
     'limit' => 5,
 ));
   $delivered_orders = $this->Orders->find()->where(['status'=>'Delivered'])->toArray();

   $disable_sellers = $this->Shops->find()->where(['seller_status'=>0])->count();
   $this->set('disable_sellers',$disable_sellers);
   $enable_sellers = $this->Shops->find()->where(['seller_status'=>1])->count();
   $this->set('enable_sellers',$enable_sellers);


   $total_complete_payment1 = $conn->execute("SELECT SUM(payment.totalcost * f.price) as total FROM fc_orders as payment,fc_forexrates as f WHERE status = ' ' or status='Pending' and payment.currency=f.currency_code ;");
   $total_complete_payment=$total_complete_payment1 ->fetchAll('assoc');

   $total_admin_commission1 = $conn->execute("SELECT SUM(o.admin_commission * f.price) as total FROM fc_orders as o,fc_forexrates as f where o.currency=f.currency_code;");
   $total_admin_commission = $total_admin_commission1->fetchAll('assoc');
   $user_datas_payment = $this->Orders->find('all', array(
    'order' => 'DESC',
    'limit' => 5,
));
   $todaystart = date('Y-m-d 00:00:00');
   $todayend = date('Y-m-d 24:00:00');
   $todaystartdate = strtotime($todaystart);
   $todayenddate = strtotime($todayend);

   $today_new_orders_count=$this->Orders->find('all', array(
    'conditions' => array(

      'orderdate >=' =>  $todaystartdate,
      'orderdate <=' => $todayenddate,
      'status' => 'Processing'
  )))->count();
   $today_delivered_orders_count =$this->Orders->find('all', array(
    'conditions' => array(

      'orderdate >=' =>  $todaystartdate,
      'orderdate <=' => $todayenddate,
      'status' => 'Delivered'
  )))->count();
   $this->set('today_new_orders_count',$today_new_orders_count);
   $this->set('today_delivered_orders_count',$today_delivered_orders_count);
         $total_items = $this->Items->find()->all()->count();//'count');
         $disbleitems = $this->Items->find()->where(['status'=>'draft'])->count();
         $total_merchandize_value1 = $conn->execute("SELECT SUM(i.price * f.price) as total FROM fc_items as i,fc_forexrates as f WHERE i.currencyid=f.id");
         $total_merchandize_value = $total_merchandize_value1->fetchAll('assoc');

         $claimedOrders = $this->Orders->find()->where(['status'=>'claimed'])->count();
         $this->set('claimedOrders',$claimedOrders);
         $timeline = strtotime('-10 day');

         $status = array('Reply' => 'Reply','Initialized'=>'Initialized','Reopen' => 'Reopen','Responded'=>'Responded','Accepeted'=>'Accepeted' );
         $dispTable= TableRegistry::get('Disputes');
         $disp_data= $dispTable->find()
         ->where(['chatdate >'=>$timeline])
         ->andWhere(['newstatusup IN'=>$status])
         ->count();

         $this->set('disp_data',$disp_data);

         $this->set('total_merchandize_value',$total_merchandize_value[0]['total']);

         $this->set('total_usrs',$total_usrs);
         $this->set('enbleusrs',$enbleusrs);
         $this->set('user_datas',$user_datas);
         $this->set('user_datas_payment',$user_datas_payment);
         $this->set('total_complete_payment',$total_complete_payment[0]['total']);
         $this->set('total_admin_commission',$total_admin_commission[0]['total']);
         $this->set('total_items',$total_items);
         $this->set('disbleitems',$disbleitems);

     }

     public function login()
     {
       $this->viewBuilder()->setLayout('adminheader');
       if($this->isauthenticated()){
           $this->redirect('/dashboard');
       }
       $baseurl = Router::url('/');
       if ($this->request->is('post')) {
           $this->loadModel('Users');
           $usrlevel = array('moderator'=>'moderator','god'=>'god');

           $user = $this->Auth->identify();
           $getemailval = $this->request->data('email');
           $userdet = $this->Users->find()->where(['email'=>$getemailval,['user_status'=>'enable']])->andWhere(['activation'=>1,['user_level IN'=>$usrlevel]])->toArray();
           if ($user && count($userdet)!=0) {
               $this->Auth->setUser($user);
               return $this->redirect($this->Auth->redirectUrl());
           }


           $errormsg = __d('admin','Email id or Password is incorrect');
           $this->set('getemailval',$getemailval);
           $this->set('errmsg',$errormsg); 
       }
       $this->set('baseurl',$baseurl);
   }

   public function logout()
   {
       $session = $this->request->session();
       $session->destroy();
       return $this->redirect($this->Auth->logout());
   }

   public function isAuthorized($user)
   {
      return true;
  }

  public function pgsetup () 
  {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Sitesettings');

   if(!empty($this->request->data)){

       $type = $this->request->data('type');
       $paypalAdaptive['paymentMode'] = $this->request->data('paypal_payment_mode');
       $eid = $this->request->data('paypal_id');
       $paypalAdaptive = json_encode($paypalAdaptive);
       $this->Sitesettings->updateAll(array('payment_type' => "$type",'paypal_id' => "$eid",'paypaladaptive' => "$paypalAdaptive"), array('id' => '1'));


   }

   $paystatus = $this->Sitesettings->find('all');
   $paystatus = $paystatus->first();



   $paypalAdaptive = json_decode($paystatus->paypaladaptive,true);

   $this->set('paystatus',$paystatus);
   $this->set('paypalAdaptive',$paypalAdaptive);


}

public function stripesetup () {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Sitesettings');


   if(!empty($this->request->data)){

       $type = $this->request->data('type');
       $publishkey = $this->request->data('publish_key');
       $secretkey = $this->request->data('secret_key');

       $this->Sitesettings->updateAll(array('stripe_type' => "$type",'stripe_secret' => "$secretkey",'stripe_publish' => "$publishkey"), array('id' => '1'));
   }
   $paystatus = $this->Sitesettings->find('all');
   $paystatus = $paystatus->first();
   $this->set('paystatus',$paystatus);


}

public function commission () {
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Commissions');
   $this->loadModel('Forexrates');
   $this->loadModel('Shops');
   $defaultCurrencySymbol = $this->Forexrates->find('all')->where(['Forexrates.cstatus' => 'default'])->first();

   $commission   =   $this->Commissions->newEntity();

   if(!empty($this->request->data)){
       $min_range = $this->request->data('start_range');

       $max_range = $this->request->data('end_range');
       $amount = $this->request->data('commission_amount');
       if($min_range < $max_range){
           $commission->applyto = $this->request->data('applyto');

           $commission->type = $this->request->data('commission_type');
           $commission->amount = $this->request->data('commission_amount');
           $commission->min_value = $min_range;
           $commission->max_value = $max_range;

           $commission->commission_details = $this->request->data('commissionDetails');
           $commission->active = '1';
           $commission->cdate = time();

           $this->Commissions->save($commission);

           $logusername = 'Admin';
           $image['user']['image'] = 'usrimg.jpg';
           $image['user']['link'] = '';
           $loguserimage = json_encode($image);
           $seller_data = $this->Shops->find()->where(['seller_status'=>1])->all();
           foreach ($seller_data as $seller_datas) {
               $userids[] = $seller_datas['user_id'];

           }
           $notifymsg = __d('admin','Admin -___-updated a commission-___-');
           $messages = __d('user','Commision details:Min_value').$min_range.' '.__d('user','Max_value').':'.$max_range.'  '.__d('user','Amount').':'.$commission->amount;

           $logdetails = $this->addloglive('admin_commision',0,$userids,0,$notifymsg,$messages,$loguserimage);


           $userstable = TableRegistry::get('Users');
           $sellerdetails = $userstable->find()->where(['id IN'=>$userids])->all();
           $setngs = TableRegistry::get('sitesettings')->find('all')->first();
           foreach ($sellerdetails as $sellerdetail) {
               $email=$sellerdetail['email'];
               $aSubject=$setngs['site_name'].__d('admin','Commission Updation');
               $aBody='';
               $template='commission';
               $commidetail='Min_value'.$min_range.'<br>Max_value:'.$max_range.' <br>Amount:'.$commission->amount;
               $setdata=array('name'=>$sellerdetail['first_name'],'loguser'=>'Admin','commission'=>$commidetail,'setngs'=>$setngs);
               $this->sendmail($email,$aSubject,$aBody,$template,$setdata);
           }


           $this->Flash->Error(__d('admin','Commission details added successfully'));
           $this->redirect('/admin/viewcommission/');
       }
       else if($min_range == $max_range){
           $this->Flash->Error(__d('admin','Min range and max range can not be equal'));
           $this->redirect('/commission/');
       }
       else if($min_range > $max_range){
           $this->Flash->Error(__d('admin','Min range should be less than max range'));
           $this->redirect('/commission/');
       }

   }
   $this->set('defaultCurrencySymbol',$defaultCurrencySymbol);
}

public function viewcommission () {
 if(!$this->isauthenticated())
   $this->redirect('/');
$this->viewBuilder()->setLayout('admin');
$this->loadModel('Commissions');

$getcommivalue  = $this->Commissions->find()->where(['Commissions.id <>'=>0])->all();

$this->loadModel('Sitesettings');
$site_datas = $this->Sitesettings->get(1);
$sitetable = TableRegistry::get('Sitesettings')->query();

if(!empty($this->request->data)){
    $credit_percentage = $this->request->data('credit_percentage');
    $sitetable->update()->set(['credit_percentage' => $credit_percentage])->where(['id' => 1])->execute(); 
    $this->Flash->success(__d('admin','Saved successfully'));
    $this->redirect('/admin/viewcommission');
}

$this->set('site_datas',$site_datas);
$this->set('getcommivalue',$getcommivalue);
$this->set('pagecount',$pagecount);
}

public function featureditem ($itemid,$status) {

   $this->autoLayout = false;
   $this->autoRender = false;

   $this->loadModel('Items');
   $itemstable = TableRegistry::get('Items');
   $featureditemquery = $this->Items->query();
   $featureditemquery->update()
   ->set(['fc_items.featured' => $status])
   ->where(['fc_items.id' => $itemid])
   ->execute();

   if($status == 1)
   {
       $this->Flash->success(__d('admin','Marked as featured successfully'));
   }
   else
   {
       $this->Flash->success(__d('admin','Marked as unfeatured successfully'));
   }
}

public function activatecommission ($id = NULL)
{
 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Commissions');
$actvalue = explode('@', $id);
if($actvalue[0]=='act'){
   $this->Commissions->updateAll(array('active' => '0'), array('id' => $actvalue[1]));
}else{
   $this->Commissions->updateAll(array('active' => '1'), array('id' => $actvalue[1]));
}
$this->redirect('/admin/viewcommission/');

}

public function deletecommission ($id = NULL){
   $this->autoLayout = false;
   $this->autoRender = false;
   if(!$this->isauthenticated())
       $this->redirect('/');
   if ($id != Null) {
       $this->loadModel('Commissions');
       $this->Commissions->deleteAll(array('id' => $id), false);
   }
}

public function editcommission ($id =null) {
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Commissions');
   $this->loadModel('Forexrates');
   $this->loadModel('Shops');

   $defaultCurrencySymbol = $this->Forexrates->find('all')->where(['Forexrates.cstatus' => 'default'])->first();

         $getcommivalues = $this->Commissions->get($id); //get data using id

         if ($this->request->is(['post'])) {
           $min_range = $this->request->data('start_range');
           $max_range = $this->request->data('end_range');
           $amount = $this->request->data('commission_amount');

           $getcommivalues->amount = $this->request->data('commission_amount');
           $getcommivalues->min_value = $this->request->data('start_range');
           $getcommivalues->max_value = $this->request->data('end_range');
           $getcommivalues->commission_details = $this->request->data('commissionDetails');
           $getcommivalues->cdate = time();
           if( $this->Commissions->save($getcommivalues))
           {

               $logusername = 'Admin';
               $image['user']['image'] = 'usrimg.jpg';
               $image['user']['link'] = '';
               $loguserimage = json_encode($image);
               $seller_data = $this->Shops->find()->where(['seller_status'=>1])->all();
               foreach ($seller_data as $seller_datas) {
                   $userids[] = $seller_datas['user_id'];

               }
               $notifymsg = __d('admin','Admin -___-updated a commission-___-');
               $messages = __d('admin','Commision details:Min_value').$min_range.__d('admin',' Max_value:').$max_range.__d('admin',' Amount:').$amount;

               $logdetails = $this->addloglive('admin_commision',0,$userids,0,$notifymsg,$messages,$loguserimage);

               $userstable = TableRegistry::get('Users');
               $sellerdetails = $userstable->find()->where(['id IN'=>$userids])->all();
               $setngs = TableRegistry::get('sitesettings')->find('all')->first();
               foreach ($sellerdetails as $sellerdetail) {
                   $email=$sellerdetail['email'];
                   $aSubject=$setngs['site_name'].__d('admin',' - Commission Updation');
                   $aBody='';
                   $template='commission';
                   $commidetail=__d('admin','Min_value').$min_range.'<br>'.__d('admin','Max_value:').$max_range.' <br>'.__d('admin','Amount:').$amount;
                   $setdata=array('name'=>$sellerdetail['first_name'],'loguser'=>'Admin','commission'=>$commidetail,'setngs'=>$setngs);
                   $this->sendmail($email,$aSubject,$aBody,$template,$setdata);
               }

               $this->Flash->success(__d('admin',' - Commission saved successfully'));
               $this->redirect('/admin/viewcommission/');
           }
       }

       $getcommivalues = $this->Commissions->get($id);
       $this->set('getcommivalues',$getcommivalues);
       $this->set('defaultCurrencySymbol',$defaultCurrencySymbol);
   }

   public function taxrates()
   {
     if(!$this->isauthenticated())
       $this->redirect('/');
   $this->viewBuilder()->setLayout('admin');
   $this->loadModel('Taxes');
   $this->paginate = array('conditions'=>array('Taxes.id <>'=>0),'limit'=>10,'order'=>array('Taxes.id'=>'desc'));
   $taxrates = $this->paginate('Taxes');
   $pagecount = count($taxrates);
   $this->set('taxrates',$taxrates);
   $this->set('pagecount',$pagecount);
}

public function deletetax($id = NULL)
{

   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Taxes');

   $this->Taxes->deleteAll(array('id' => $id), false);
}

public function addtax()
{
   $this->viewBuilder()->setLayout('admin');
   $this->loadModel('Countries');
   $this->loadModel('Taxes');
   $taxrates   =   $this->Taxes->newEntity();
   $country_datas = $this->Countries->find('all',array('order'=>array('country'=>'asc')));

   $this->set('country_datas',$country_datas);
   if(!empty($this->request->data))
   {

       $country_name = $this->Countries->find('all')->where(['Countries.id'=> $this->request->data('countryid')])->first();
       $countryid = $this->request->data('countryid');

       $taxname = $this->request->data('taxname');

       $tax = $this->Taxes->find()->where(['countryid'=> $countryid])->andWhere(['taxname'=> $taxname])->first();


       $taxcount=count($tax);

       if($taxcount==0)
       {
           $taxrates->taxname = $this->request->data('taxname');
           $taxrates->countryid = $this->request->data('countryid');
           $taxrates->status = $this->request->data('Status');
           $taxrates->countryname= $country_name['country'];
           $taxrates->percentage=$this->request->data('percentage');
           $this->Taxes->Save($taxrates);
           $this->redirect('/admin/taxrates');
       }
       else
       {
           $this->Flash->Error(__d('admin','Tax name already exists'));
       }
   }
}

public function edittax($id=NULL)
{
   $this->viewBuilder()->setLayout('admin');
   $this->loadModel('Countries');
   $this->loadModel('Taxes');

   $country_datas = $this->Countries->find('all',array('order'=>array('country'=>'asc')));
   $tax_datas = $this->Taxes->get($id);
   $this->set('tax_datas',$tax_datas);
   $this->set('country_datas',$country_datas);
   if(!empty($this->request->data))
   {

       $country_name = $this->Countries->find('all')->where(['Countries.id'=> $this->request->data('countryid')])->first();
       $countryid = $this->request->data('countryid');

       $taxname = $this->request->data('taxname');

       $tax = $this->Taxes->find()->where(['countryid'=> $countryid])->andWhere(['taxname'=> $taxname,'id <>'=>$id])->first();


       $taxcount=count($tax);

       if($taxcount==0)
       {
           $tax_datas->taxname = $this->request->data('taxname');
           $tax_datas->countryid = $this->request->data('countryid');
           $tax_datas->status = $this->request->data('Status');
           $tax_datas->countryname= $country_name['country'];
           $tax_datas->percentage=$this->request->data('percentage');
           $tax_datas->status=$this->request->data('status');
           $this->Taxes->Save($tax_datas);
           $this->redirect('/admin/taxrates');
       }
       else
       {

           $this->Flash->set(__d('admin','Tax name already exists'), [
            'element' => 'success'
        ]);
       }
   }
}

public function invoice($retvalue = null) 
{

   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Invoiceorders');
   $usersTable = TableRegistry::get('Invoices');
   $invoiceorders = $usersTable->find()->select(['invoiceid', 'Invoiceorders.orderid' ])
   ->leftJoinWith('Invoiceorders')
   ->group(['Invoices.invoiceid'])
   ->autoFields(true);
   $this->set('invoiceorders',$invoiceorders);

}

public function invoicesearch($retvalue = null) 
{

 if(!($this->isauthenticated()))
   $this->redirect('/');

$sval = $_POST['sval'];

$this->loadModel('Invoices');
$this->loadModel('Invoiceorders');
$usersTable = TableRegistry::get('Invoices');
$invoiceorders = $usersTable->find()->select(['invoiceid', 'Invoiceorders.orderid' ])
->leftJoinWith('Invoiceorders')
->group(['Invoices.invoiceid'])
->autoFields(true)
->where(['Invoices.invoiceno LIKE' =>'%'.$sval.'%'])
->all();


$this->set('invoiceorders',$invoiceorders);

$this->set('sval',$sval);
}

public function invoiceview ($invoiceId) {
 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Invoices');
$this->loadModel('Orders');
$this->loadModel('Users');
$this->loadModel('Order_items');
$this->loadModel('Invoiceorders');
$this->loadModel('Items');
$this->loadModel('Shippingaddresses');
$this->loadModel('Coupons');


$invoiceModel = $this->Invoices->find()->where(['invoiceid'=>$invoiceId])->first();

$invoiceOrder = $this->Invoiceorders->find()->where(['invoiceid'=>$invoiceId])->first();
$orderId = $invoiceOrder['orderid'];

$orderModel = $this->Orders->find()->where(['orderid'=>$orderId])->first();

$orderItemModel = $this->Order_items->find()->where(['orderid'=>$orderId])->first();

$shippingid = $orderModel['shippingaddress'];

$shippingModel = $this->Shippingaddresses->find()->where(['shippingid' => $shippingid])->first();

$sellerId = $this->Items->find()->where(['id' => $orderItemModel['itemid']])->first();


$sellerId = $sellerId['user_id'];

$userModel = $this->Users->find()->where(['id' => $orderModel['userid']])->first();

$sellerModel =$this->Users->find()->where(['id'=>$sellerId])->first();

$coupon_id  = $orderModel['coupon_id'];

$tax = $orderModel['tax'];

$discount_amount  = $orderModel['discount_amount'];

$orderCurrency = $orderModel['currency'];

$this->loadModel('Forexrates');


$forexrateModel = $this->Forexrates->find()->where(['currency_code' => $orderCurrency])->first();

$currencySymbol = $forexrateModel['currency_symbol'];
$this->set('currencySymbol',$currencySymbol);


$getcouponvalue = $this->Coupons->find()->where(['id' => $coupon_id])->first();

$this->set('getcouponvalue',$getcouponvalue);


$this->set('getcouponvalue',$getcouponvalue);
$this->set('orderDetails',$orderModel);
$this->set('orderItemModel',$orderItemModel);
$this->set('orderCurrency',$orderCurrency);
$this->set('invoiceModel',$invoiceModel);
$this->set('userModel',$userModel);
$this->set('sellerModel',$sellerModel);
$this->set('shippingModel',$shippingModel);
$this->set('discount_amount',$discount_amount);
$this->set('tax',$tax);
}

public function manageuser()
{
 if(!($this->isauthenticated()))
   $this->redirect('/');
$this->loadModel('Users');
$this->viewBuilder()->setLayout('admin');

$allUsers = $this->Users->find('all', array('conditions'=>array('Users.user_level'=>'normal', 'Users.user_status'=>'enable'), 'order'=>array('id'=>'desc')));

$this->set('userdet',$allUsers);
}

public function nonapprovedmoderator($retvalue=null){
 if(!($this->isauthenticated()))
   $this->redirect('/');
$this->loadModel('User');
$this->viewBuilder()->setLayout('admin');
$srcs = '';
$retvalue = $this->passedArgs['serchkeywrd'];

if(!empty($retvalue)){

   $srcs = $retvalue;

   $this->paginate =  array('conditions'=>array('user_level'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'disable','OR'=>array('Users.username like'=>'%'.$srcs.'%','Users.email like'=>'%'.$srcs.'%')),'limit'=>10,'order'=>array('id'=>'desc'));
}else{

   $this->paginate =  array('conditions'=>array('user_level'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'disable'),'limit'=>5,'order'=>array('id'=>'desc'));
}

$userdet = $this->paginate('Users');
$pagecount = count($userdet);

$this->set('userdet',$userdet);
$this->set('pagecount',$pagecount);
$this->set('srcs',$srcs);

}

public function managemoderator($retvalue=null){
 if(!($this->isauthenticated()))
   $this->redirect('/');
$this->loadModel('Users');
$this->viewBuilder()->setLayout('admin');
$srcs = '';
$retvalue = $this->passedArgs['serchkeywrd'];

$userdet = $this->Users->find()->where(['user_level'=>'moderator'])->andWhere(['user_status'=>'enable'])->toArray();
$pagecount = count($userdet);

$this->set('userdet',$userdet);
$this->set('pagecount',$pagecount);
$this->set('srcs',$srcs);

}

public function searchcommission($minval,$maxval,$commamount)
{

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Commissions');

$this->paginate =  array('conditions'=>array('Commissions.amount LIKE'=>'%'.$commamount.'%','Commissions.min_value LIKE'=>'%'.$minval.'%','Commissions.max_value LIKE'=>'%'.$maxval.'%','Commissions.active'=>1));

$userdet = $this->paginate('Commissions');
$pagecount = count($userdet);

$this->set('pagecount',$pagecount);
}

public function searcheditcommission($minval,$maxval,$commamount,$commid){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Commissions');

$this->paginate =  array('conditions'=>array('Commissions.id <>'=>$commid,'Commissions.amount LIKE'=>'%'.$commamount.'%','Commissions.min_value LIKE'=>'%'.$minval.'%','Commissions.max_value LIKE'=>'%'.$maxval.'%','Commissions.active'=>1));

$userdet = $this->paginate('Commissions');
$pagecount = count($userdet);

$this->set('pagecount',$pagecount);
}


public function searchregisteredcategory($catid,$categoryname=null){

 if (isset($_POST['cat'])) {
   $cat = $_POST['cat'];
}else
{
   $cat = '';
}
if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Categories');

$this->paginate =  array('conditions'=>array('Categories.id <>'=>$catid,'Categories.category_name'=> $categoryname,'Categories.category_parent'=>$cat));

$userdet = $this->paginate('Categories');
$pagecount = count($userdet);

$this->set('pagecount',$pagecount);
}

public function searchactiveuser($email=null){

   $this->loadModel('Users');
   $usrlevel = array('moderator'=>'moderator','god'=>'god'); 
   $userdet = $this->Users->find()->where(['email'=>$email,['user_status'=>'enable']])->andWhere(['activation'=>1,['user_level IN'=>$usrlevel]])->all();
   $pagecount = count($userdet);
   $this->set('pagecount',$pagecount);
}

public function searchcategoryname($categoryname=null)
{

 if (isset($_POST['cat'])) {
   $cat = $_POST['cat'];
}else
{
   $cat = '';
}

if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Categories');

$this->paginate =  array('conditions'=>array('Categories.category_name LIKE'=>'%'.$categoryname.'%','category_parent'=>$cat));

$userdet = $this->paginate('Categories');
$pagecount = count($userdet);
$this->set('pagecount',$pagecount);
}

public function searchcountryname($countryname=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Languages');

$this->paginate =  array('conditions'=>array('Languages.countryid'=>$countryname));

$userdet = $this->paginate('Languages');
$pagecount = count($userdet);
$this->set('pagecount',$pagecount);
}

public function searchregisteredemail($email=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Users');

$this->paginate =  array('conditions'=>array('Users.email LIKE'=>'%'.$email.'%'));

$userdet = $this->paginate('Users');
$pagecount = count($userdet);
$this->set('pagecount',$pagecount);
}

public function searchuserregisteredemail($userid,$email=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Users');

$this->paginate =  array('conditions'=>array('Users.id <>'=>$userid,'Users.email LIKE'=>'%'.$email.'%'));

$userdet = $this->paginate('Users');
$pagecount = count($userdet);
$this->set('pagecount',$pagecount);
}

public function searchregisteredusername($username=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Users');

$this->paginate =  array('conditions'=>array('Users.username LIKE'=>'%'.$username.'%'));

$userdet = $this->paginate('Users');
$pagecount = count($userdet);
$this->set('pagecount',$pagecount);
}

public function searchuser($retvalue=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Users');
$srcs = '';
if(!empty($retvalue)){
   $srcs = $retvalue;

   $this->paginate =  array('conditions'=>array('user_level <>'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'enable','OR'=>array('Users.username LIKE'=>'%'.$srcs.'%','Users.email LIKE'=>'%'.$srcs.'%')),'limit'=>10,'order'=>array('id'=>'desc'));
}else{

   $this->paginate =  array('conditions'=>array('user_level <>'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'enable'),'limit'=>10,'order'=>array('id'=>'desc'));
}

$userdet = $this->paginate('Users');
$pagecount = count($userdet);
$this->set('userdet',$userdet);
$this->set('pagecount',$pagecount);
$this->set('srcs',$srcs);
}

public function searchmoderator($retvalue=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Users');

$srcs = '';


if(!empty($retvalue)){
   $srcs = $retvalue;

   $this->paginate =  array('conditions'=>array('user_level'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'enable','OR'=>array('Users.username LIKE'=>'%'.$srcs.'%','Users.email LIKE'=>'%'.$srcs.'%')),'limit'=>10,'order'=>array('id'=>'desc'));
}else{

   $this->paginate =  array('conditions'=>array('user_level'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'enable'),'limit'=>10,'order'=>array('id'=>'desc'));
}

$userdet = $this->paginate('Users');
$pagecount = count($userdet);

$this->set('userdet',$userdet);
$this->set('pagecount',$pagecount);
$this->set('srcs',$srcs);
}

public function searchnonapprovedmoderator($retvalue=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Users');

$srcs = '';


if(!empty($retvalue)){
   $srcs = $retvalue;
   $this->paginate =  array('conditions'=>array('user_level'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'disable','OR'=>array('Users.username LIKE'=>'%'.$srcs.'%','Users.email LIKE'=>'%'.$srcs.'%')),'limit'=>10,'order'=>array('id'=>'desc'));
}else{

   $this->paginate =  array('conditions'=>array('user_level'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'disable'),'limit'=>10,'order'=>array('id'=>'desc'));
}

$userdet = $this->paginate('Users');
$pagecount = count($userdet);
$this->set('userdet',$userdet);
$this->set('pagecount',$pagecount);
$this->set('srcs',$srcs);
}

public function searchnonapproveduser($retvalue=null){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Users');

$srcs = '';


if(!empty($retvalue)){
   $srcs = $retvalue;

   $this->paginate =  array('conditions'=>array('user_level <>'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'disable','OR'=>array('Users.username LIKE'=>'%'.$srcs.'%','Users.email LIKE'=>'%'.$srcs.'%')),'limit'=>10,'order'=>array('id'=>'desc'));
}else{

   $this->paginate =  array('conditions'=>array('user_level <>'=>'moderator','Users.username <>'=>'Admin','Users.user_status'=>'disable'),'limit'=>10,'order'=>array('id'=>'desc'));
}

$userdet = $this->paginate('Users');

$pagecount = count($userdet);

$this->set('userdet',$userdet);
$this->set('pagecount',$pagecount);
$this->set('srcs',$srcs);

}

public function changeuserstatus ($userId,$status) {
 if(!$this->isauthenticated())
   $this->redirect('/');

$this->autoLayout = false;
$this->autoRender = false;

$prefix = $this->Users->tablePrefix;


$users = TableRegistry::get('Users');
$query = $users->query();


if ($status == 'enable') {
   $query->update()
   ->set(['user_status' => 'disable'])
   ->set(['activation' => 0])
   ->where(['id' => $userId])
   ->execute();
}else {
   $query->update()
   ->set(['user_status' => 'enable'])
   ->set(['activation' => 1])
   ->where(['id' => $userId])
   ->execute();

}

}

public function deleteuser($id = NULL)
{
   $this->autoLayout = false;
   $this->autoRender = false;
   if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Users');
   $this->loadModel('Items');
   $this->loadModel('Logs');
   $this->loadModel('Followers');
   $this->loadModel('Storefollowers');
   $this->loadModel('Shops');
   $this->loadModel('Shopfavs');
   $this->loadModel('Itemfavs');
   $this->loadModel('Comments');
   $this->loadModel('Itemlists');
   $this->loadModel('Tempaddresses');
   $this->loadModel('Wantownits');

   $this->autoLayout = false;
   $this->autoRender = false;
   if(!$this->isauthenticated())
       $this->redirect('/');
   if ($id != Null) {
       $this->loadModel('Users');
       $this->Users->deleteAll(array('Users.id' => $id), false);


       $this->Items->deleteAll(array('Items.user_id' => $id), false);
       $this->Logs->deleteAll(array('Logs.userid' => $id), false);
       $this->Followers->deleteAll(array('OR' => array('Followers.user_id'=>$id,
        'Followers.follow_user_id'=>$id)), false);
       $this->Storefollowers->deleteAll(array('OR' => array('Storefollowers.store_id'=>$id,
        'Storefollowers.follow_user_id'=>$id)), false);
       $this->Shops->deleteAll(array('Shops.user_id' => $id), false);
       $this->Shopfavs->deleteAll(array('Shopfavs.user_id' => $id), false);
       $this->Itemfavs->deleteAll(array('Itemfavs.user_id' => $id), false);
       $this->Comments->deleteAll(array('Comments.user_id' => $id), false);
       $this->Itemlists->deleteAll(array('Itemlists.user_id' => $id), false);
       $this->Tempaddresses->deleteAll(array('Tempaddresses.userid' => $id), false);
       $this->Wantownits->deleteAll(array('Wantownits.userid' => $id), false);
       $this->Flash->success('Deleted successfully');
   }
}

public function edituser($id = NULL)
{
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Users');
   $user_datas = $this->Users->get($id);

   $this->set('userid',$id);

   $admin_menus_list = $user_datas['admin_menus'];
   $this->set('user_datas',$user_datas);
   $this->set('admin_menus_list',$admin_menus_list);
   if(!empty($this->request->data))
   {
       $username =  $this->request->data('username');
       // $phone_no = $this->request->data('phone_no');
       // $phone_no = preg_replace('/[^0-9]/','',$phone_no);
       $firstname = $this->request->data('firstname');

       $email = $this->request->data('email');
       $menulist = $this->request->data('menulist');

       $password = $this->request->data('password');

       $user_datas->username = $username;
       $user_datas->first_name = $firstname;

       $user_datas->email = $email;
       // $phonecount = $this->Users->find()->where(['phone_no'=>$phone_no])->andWhere(['id !='=>$id])->count();
       // if($phonecount > 0){
       //     $this->Flash->Error(__d('admin','Phone number already exists'));
       //     $this->redirect($this->referer());
       // } else {
         // $user_datas->phone_no = $phone_no;
         if($this->request->data('usr_access')=='moderator')
         {
             $user_datas->user_level = $this->request->data('usr_access');

             if($this->request->data('menulist')=="")
             {
                 $admin_menu_default = "Home";
                 $admin_default = json_encode($admin_menu_default);
                 $user_datas->admin_menus = $admin_default;
             }
             else
                 $user_datas->admin_menus = $this->request->data('menulist');
         }
         else
             $user_datas->user_level = $this->request->data('usr_access');

           $this->Users->save($user_datas); // Save data

           if($this->request->data['usr_access']=='moderator'&& $user_datas['user_status']=='enable')
           {
             $this->Flash->success(__d('admin','Moderator saved successfully'));
             $this->redirect('/managemoderator/');
         }
         else if($this->request->data['usr_access']=='moderator'&& $user_datas['user_status']=='disable')
         {
             $this->Flash->success(__d('admin','Moderator saved successfully'));
             $this->redirect('/nonapprovedmoderator/');
         }
         else if($user_datas['user_status']=='enable' && $this->request->data['usr_access']=='normal')
         {
             $this->Flash->success(__d('admin','User saved successfully'));
             $this->redirect('/manageuser/');
         }
         else if($user_datas['user_status']=='disable')
         {
             $this->Flash->success(__d('admin','User saved successfully'));
             $this->redirect('/nonapproveduser/');
         }
         else
         {
             $this->Flash->success(__d('admin','User saved successfully'));
             $this->redirect('/inactiveuser/');
         }
      //}
   }
}


public function nonapproveduser($retvalue=null){
    if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Users');
   $this->viewBuilder()->setLayout('admin');


   $userdet = $this->Users->find('all', array('conditions'=>array('Users.user_level'=>'normal', 'Users.user_status'=>'disable'), 'order'=>array('id'=>'desc')));

   $pagecount = count($userdet);

   $this->set('userdet',$userdet);
   $this->set('pagecount',$pagecount);
   $this->set('srcs',$srcs);

}

function deleteinactiveuser($period=30, $retvalue=''){

 if(!($this->isauthenticated()))
   $this->redirect('/');

$this->autoLayout = false;
$this->autoRender = false;
$this->loadModel('Users');
$this->loadModel('Shops');

if (!isset($_POST['selectedusers'])){
   $period = $period * 24 * 60 * 60;
   $inactivePeriod = time() - $period;
   $inactivePeriod = date('Y-m-d H:i:s', $inactivePeriod);
   if(!empty($retvalue)){
       $srcs = $retvalue;
       $condition =  array('conditions'=>array('user_level <>'=>'god',
          'username like'=>$srcs.'%','activation'=>0,'created_at <'=>$inactivePeriod));
   }else{
       $condition =  array('conditions'=>array('user_level <>'=>'god','activation'=>0,
          'created_at <'=>$inactivePeriod));
   }
   $userModel = $this->Users->find('all',$condition);
   foreach ($userModel as $user){
       $userid[] = $user['id'];
   }

   $this->Users->deleteAll(['Users.id IN' => $userid], false);
   $this->Shops->deleteAll(['Shops.user_id IN' => $userid], false);

   $this->redirect('/inactiveuser');
}else{
   $this->Users->deleteAll(['Users.id IN' => $_POST['selectedusers']], false);
   $this->Shops->deleteAll(['Shops.user_id IN' => $_POST['selectedusers']], false);
}
}

public function addcoupon()
{
 if(!($this->isauthenticated()))
   $this->redirect('/');
$this->viewBuilder()->setLayout('admin');
$this->loadModel('Coupons');
$addcoupon   =   $this->Coupons->newEntity();
$coupon_use = $this->request->data('onetimeuse');
if(!empty($this->request->data)){
   $code = $this->request->data('couponcode');
   $getcouponval = $this->Coupons->findByCouponcode($code)->first();



   if(empty($getcouponval)){

       $merchant_id = $this->request->data('merchant_id');

       if($coupon_use=="on")
           $addcoupon->one_time_use = "yes";
       else
           $addcoupon->one_time_use = "no";

       $merchant_ids = json_encode($merchant_id);
       $addcoupon->couponcode = $this->request->data('couponcode');
       $addcoupon->coupontype = $this->request->data('coupontype');
       $addcoupon->validrange = $this->request->data('couponrange');
       $addcoupon->totalrange = $this->request->data('couponrange');
       $addcoupon->select_merchant = $this->request->data('select_merchant');
       $addcoupon->merchant_ids = $merchant_ids;
       $addcoupon->validfromdate =$this->request->data('fromdate');
       $addcoupon->validtodate =$this->request->data('enddate');
       $addcoupon->discount_amount = $this->request->data('amount');
       $addcoupon->cdate = time();

       $this->Coupons->save($addcoupon);
       $this->redirect('/admin/managecoupon/');

   }else{
       $this->Flash->error(__d('admin','Coupon Code Already Exists'));
       $this->redirect('/admin/addcoupon/');
   }
}else{
   $this->loadModel('Shops');
   $getmerchant_name = $this->Shops->find('all',array('conditions'=>array("not" => array ( "Shops.paypal_id" => '',"Shops.shop_name"=>NULL))));
   $this->set('getmerchant_name',$getmerchant_name);
}
}

public function editcoupon ($id = NULL, $couponcode = NULL) {

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->viewBuilder()->setLayout('admin');
$this->loadModel('Coupons');
$coupon_datas = $this->Coupons->get($id);
if(!empty($this->request->data)){

   $merchant_id = $this->request->data('merchant_id');
   $merchant_ids = json_encode($merchant_id);
   $coupon_datas->id=$id;
   $coupon_datas->couponcode=$couponcode;
   $coupon_datas->coupontype=$this->request->data('coupontype');
   $coupon_datas->totalrange=$this->request->data('couponrange');
   $coupon_datas->validrange=$this->request->data('couponrange');
   $coupon_datas->validfromdate=$this->request->data('fromdate');
   $coupon_datas->validtodate=$this->request->data('enddate');
   $coupon_datas->select_merchant = $this->request->data('select_merchant');
   $coupon_datas->merchant_ids = $merchant_ids;

   $coupon_datas->discount_amount = $this->request->data('amount');
   $coupon_datas->cdate = time();
   $this->Coupons->save($coupon_datas);
   $this->redirect('/admin/managecoupon/');

}else{
   $getcouponval = $this->Coupons->findById($id)->first();
   $this->set('getcouponval',$getcouponval);
   $this->loadModel('Shops');
   $getmerchant_name = $this->Shops->find('all',array('conditions'=>array("not" => array ( "Shops.paypal_id" => '',"Shops.shop_name"=>NULL))));
   $this->set('getmerchant_name',$getmerchant_name);
}

}

public function generatecoupons () {
   $seed_length = 8;
   $seed = md5(srand((double)microtime()*1000000) + (strtotime('now')))."ABCDEFGHIJKLMNOPQRSTUVWXYZ2345678923456789abcdefghijklmnopqrstuvwxyz23456789abcdefghijklmnopqrstuvwxyz";

   $str = '';
   srand((double)microtime()*1000000);
   for ($i=0;$i<$seed_length;$i++) {
       $str .= substr ($seed, rand() % 48, 1);
   }

   echo $str;die;
}

public function couponlog()
{
 if(!($this->isauthenticated()))
   $this->redirect('/');
$this->viewBuilder()->setLayout('admin');
$this->loadModel('Logcoupons');
$this->loadModel('Coupons');
$this->loadModel('Orders');
$this->loadModel('Users');
$this->paginate = array('conditions'=>array('Logcoupons.id <>'=>0),'limit'=>10,'order'=>array('Logcoupons.id'=>'desc'));
$getlogcouponval = $this->paginate('Logcoupons');
foreach($getlogcouponval as $getlogcoupon)
{
   $coupon_ids[] = $getlogcoupon['coupon_id'];
   $user_ids[] = $getlogcoupon['user_id'];
   $cdate[] = $getlogcoupon['cdate'];
}
$order_det = $this->Orders->find('all',array('conditions'=>array('Orders.coupon_id IN'=>$coupon_ids,'Orders.userid IN'=>$user_ids,'Orders.orderdate IN'=>$cdate)));
$this->set('order_det',$order_det);
$coupon_values = $this->Coupons->find('all',array('conditions'=>array('Coupons.id IN'=>$coupon_ids)));
$this->set('coupon_values',$coupon_values);

$user_details = $this->Users->find('all',array('conditions'=>array('Users.id IN'=>$user_ids)));

$this->set('user_details',$user_details);
$pagecount = count($getlogcouponval);

$this->set('getlogcouponval',$getlogcouponval);
$this->set('pagecount',$pagecount);
}

public function viewcoupon ($orderId) {
 if(!$this->isauthenticated())
   $this->redirect('/');
$this->layout = 'admin';
$this->loadModel('Invoices');
$this->loadModel('Orders');
$this->loadModel('Users');
$this->loadModel('Order_items');
$this->loadModel('Invoiceorders');
$this->loadModel('Items');
$this->loadModel('Shippingaddresses');
$this->loadModel('Coupons');


$orderModel = $this->Orders->findByOrderid($orderId)->first();

$orderItemModel = $this->Order_items->find()->where(['orderid'=>$orderId])->toArray();



$shippingid = $orderModel['shippingaddress'];
$shippingModel = $this->Shippingaddresses->findByShippingid($shippingid)->first();
$sellerId=$this->Items->find()->where(['id'=>$orderItemModel[0]['itemid']])->first();


$sellerId = $sellerId['user_id'];

$userModel = $this->Users->findById($orderModel['userid'])->first();

$sellerModel = $this->Users->findById($sellerId)->first();

$coupon_id  = $orderModel['coupon_id'];

$discount_amount  = $orderModel['discount_amount'];

$orderCurrency = $orderModel['currency'];

$getcouponvalue = $this->Coupons->findById($coupon_id)->first();
$this->set('getcouponvalue',$getcouponvalue);
$this->set('getcouponvalue',$getcouponvalue);
$this->set('orderDetails',$orderModel);
$this->set('orderItemModel',$orderItemModel);
$this->set('orderCurrency',$orderCurrency);

$this->set('userModel',$userModel);
$this->set('sellerModel',$sellerModel);
$this->set('shippingModel',$shippingModel);
$this->set('discount_amount',$discount_amount);
}

public function managecoupon () {
 if(!$this->isauthenticated())
   $this->redirect('/');
$this->viewBuilder()->setLayout('admin');
$this->loadModel('Coupons');
$this->paginate = array('conditions'=>array('Coupons.id <>'=>0),'limit'=>10,'order'=>array('Coupons.id'=>'desc'));
$getcouponval = $this->paginate('Coupons');
$pagecount = count($getcouponval);
$this->set('getcouponval',$getcouponval);
$this->set('pagecount',$pagecount);
}

public function deletecoupon(){

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Coupons');
$id = $_REQUEST['id'];
$this->Coupons->deleteAll(array('Coupons.id' => $id), false);
echo 0;
die;
}

public function giftcardlog () {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Users');
   $this->loadModel('Giftcards');
   $usersTable = TableRegistry::get('Giftcards');
   $giftcardlogval = $usersTable->find()->select(['user_id', 'Users.username' ])
   ->leftJoinWith('Users')
   ->group(['Giftcards.user_id'])
   ->autoFields(true)->all();
   $this->set('giftcardlogval',$giftcardlogval);
}

public function giftcard () {

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->loadModel('Sitesettings');
$this->viewBuilder()->setLayout('admin');

if(!empty($this->request->data)){

   $settings = $this->Sitesettings->find()->where(['id'=>1])->first();
   $giftcard = $settings['giftcard'];
   $getgiftcard = json_decode($giftcard,true);
   $imagename = $getgiftcard['image'];

   $fileName = $this->request->data('image');
   $uploadPath = 'media/items/thumb150/';

   if($fileName['tmp_name'] != "")
   {
        $appImageValues = getimagesize($fileName['tmp_name']); 
        $extensionarray = array('.jpg', '.png', '.jpeg');
        $imageSize = (trim($fileName['size']) / 1024) / 1024;
        $ext = strrchr(trim($fileName['name']), '.'); 

        if ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && $imageSize < 2 && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) { 

          $uploadFile = $uploadPath.$fileName['name'];
          move_uploaded_file($fileName['tmp_name'],$uploadFile);
          chmod($finalPath.$newname, 0777);   
          $giftcardd['image'] = $fileName['name'];
        } else {
          $giftcardd['image'] = $imagename; 
        }
   }
   else
   {
       $giftcardd['image'] = $imagename;
   }

   $giftcardd['title'] = trim($this->request->data('title'));
   $giftcardd['description'] = trim($this->request->data('description'));
   $giftcardd['amounts'] = trim($this->request->data('amounts'));
   $giftcardd['time'] = time();
   $giftcarde = json_encode($giftcardd);
   $this->Sitesettings->updateAll(array('giftcard' => "$giftcarde"), array('id' => '1'));
   $this->redirect('/giftcard/');
}else{
   $giftDetails = $this->Sitesettings->find()->first();
   $this->set('giftDetails',json_decode($giftDetails['giftcard'],true));
}
}

public function groupgifts()
{
 if(!$this->isauthenticated())
   $this->redirect('/');
$this->viewBuilder()->setLayout('admin');
$this->set('title_for_layout','Group Gift');
$this->loadModel('Groupgiftuserdetails');
$this->loadModel('Groupgiftpayamts');
$this->loadModel('Items');
$this->loadModel('Forexrates');
$groupgiftsTable = TableRegistry::get('Groupgiftuserdetails');

$gglistsData = $groupgiftsTable->find()->select(['item_id', 'Items.currencyid' ])
->leftJoinWith('Items')
    //->group(['Groupgiftuserdetails.item_id'])
->autoFields(true)
->order(['Groupgiftuserdetails.id' => 'DESC']);


foreach ($gglistsData as $gglistsDatas) {
   $currencyids[] = $gglistsDatas['_matchingData']['Items']['currencyid'];
}

$currencydata=$this->Forexrates->find('all',array('conditions'=>array('Forexrates.id IN'=>$currencyids)));
$this->set('gglistsData',$gglistsData);
$this->set('pagecount',$pagecount);
$this->set('currencydata',$currencydata);
}

function gifts($id=NULL,$currency_symbol=NULL) {

 if(!$this->isauthenticated())
   $this->redirect('/');
$this->viewBuilder()->setLayout('item');

$this->loadModel('Groupgiftuserdetails');
$this->loadModel('Groupgiftpayamts');
$this->loadModel('Countries');
$this->loadModel('Items');
$this->loadModel('Users');
$this->loadModel('Sitesettings');
global $siteChanges;
global $setngs;
$paidamt=0;

$items_list_data = $this->Groupgiftuserdetails->findById($id)->first();
$ggAmtDatas = $this->Groupgiftpayamts->find()->where(['Groupgiftpayamts.ggid'=>$id])->all();
foreach($ggAmtDatas as $ggAmtData){
   $paidamt = $paidamt+ $ggAmtData['amount'];
   $paidUserId[] = $ggAmtData['paiduser_id'];
}
if(empty($items_list_data)){
   $this->redirect('/');
}

$ItemId = $items_list_data['item_id'];
$userId = $items_list_data['user_id'];
$countryId = $items_list_data['country'];
$countrys_list_data = $this->Countries->findById($countryId)->first();
$item_datas = $this->Items->findById($ItemId)->first();
$createuserDetails = $this->Users->findById($userId)->first();
$setngs=$this->Sitesettings->find()->first();
$socialId = $setngs['social_id'];
$socialId = json_decode($socialId,true);
$fashionusers = TableRegistry::get('Fashionusers');
$fashionimages = $fashionusers->find('all')->where(['itemId'=>$item_datas['id']])->all();
$photosTable = TableRegistry::get('Photos');
$photos = $photosTable->find('all')->where(['item_id'=>$item_datas['id']])->all();

$this->set('fashionimages',$fashionimages);
$this->set('photos',$photos);
$this->set('item_datas',$item_datas);
$this->set('createuserDetails',$createuserDetails);
$this->set('items_list_data',$items_list_data);
$this->set('countrys_list_data',$countrys_list_data);
$this->set('paidamt',$paidamt);
$this->set('currencysymbol',$currency_symbol);
$this->set('setngs',$setngs);
$this->set('paidUserId',$paidUserId);
$this->set('ggAmtDatas',$ggAmtDatas);
$this->set('roundProf',$siteChanges['profile_image_view']);
$this->set('fbapp_id',$socialId['FB_ID']);
$this->set('fbtitle',SITE_NAME." Group Gift Share");
$this->set('fbdescription',"Contribution Request from your friend");
$this->set('fbtype',"photo");
$this->set('fburl',SITE_URL."gifts/".$items_list_data['id']);
$this->set('fbimage',$_SESSION['media_url'].'media/items/original/'.$item_datas['Photo'][0]['image_name']);

}

public function manageproblem()
{

   $this->viewBuilder()->setLayout('admin');
   global $loguser;
   if(!$this->isauthenticated())
       $this->redirect('/');


   $this->loadModel('Sitequeries');

   $subject_data = $this->Sitequeries->find()->where(['Sitequeries.type'=>'Dispute_Problem'])->first(); 
   $pagecount=count($subject_data);
   $this->set('subject_data',$subject_data);
   $this->set('pagecount',$pagecount);

}

function dispquestion($id = NULL){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Sitequeries');


   $this->loadModel('Sitequeries');
   $dispute   =   $this->Sitequeries->newEntity();
   if(!empty($this->request->data)){

       $disp_query = $this->request->data('plm');
       $sitequeriesModel = $this->Sitequeries->find()->where(['Sitequeries.type'=>'Dispute_Problem'])->first();
       $dispqueries = json_decode($sitequeriesModel['queries'], true);

       if(in_array($disp_query,$dispqueries)){
           $this->Flash->error(__d('admin','Dispute Problem Already Exists try another.'));
           $this->redirect('/dispquestion');
       } else {

         if (!empty($sitequeriesModel)){
           $queries = json_decode($sitequeriesModel['queries'], true);
           if ($id == NULL){

               $queries[] = $this->request->data('plm');
           }else{
               $queries[$id] = $this->request->data('plm');
           }
           $dispute->id = $sitequeriesModel['id'];
           $dispute->queries = json_encode($queries);
       }else{
           $queries[] = $this->request->data('plm');

           $dispute->type = 'Dispute_Problem';
           $dispute->queries = json_encode($queries);
       }
       $this->Sitequeries->save($dispute);

       $this->Flash->success(__d('admin','Dispute problem created'));
       $this->redirect('/manageproblem');
   }
}
if ($id != NULL){
   $sitequeriesModel = $this->Sitequeries->find()->where(['Sitequeries.type'=>'Dispute_Problem'])->first();

   $queries = json_decode($sitequeriesModel['queries'], true);

   $this->set('query',$queries[$id]);
}else{
   $this->set('query','');
}
$this->set('id',$id);


}

public function deletedispquestion($id) {

 if(!$this->isauthenticated())
   $this->redirect('/');

$this->loadModel('Sitequeries');
$sitequeriesModel = $this->Sitequeries->find()->where(['Sitequeries.type'=>'Dispute_Problem'])->first();
$dispute   =   $this->Sitequeries->newEntity();
$csqueries = array();
if (!empty($sitequeriesModel)){
   $queries = json_decode($sitequeriesModel['queries'], true);
   foreach ($queries as $qkey => $query){
     if ($id != $qkey){
       $csqueries[] = $query;
   }
}
$dispute->id = $sitequeriesModel['id'];
$dispute->queries = json_encode($csqueries);
$this->Sitequeries->save($dispute);
$this->Flash->success(__d('admin','Deleted Successfully'));
}else{
   $this->Flash->error(__d('admin','Subject Not Found'));
}
$this->redirect('/manageproblem');


}

function contactsellersubject(){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');


   $this->loadModel('Sitequeries');

   $subject_data = $this->Sitequeries->find()->where(['Sitequeries.type'=>'contact_seller'])->first();
   $this->set('subject_data',$subject_data);

}

function addsubject($id = NULL){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Sitequeries');


   $this->loadModel('Sitequeries');
   $consubject   =   $this->Sitequeries->newEntity();
   if(!empty($this->request->data)){

       $disp_query = $this->request->data('subject');
       $sitequeriesModel = $this->Sitequeries->find()->where(['Sitequeries.type'=>'contact_seller'])->first();
       $dispqueries = json_decode($sitequeriesModel['queries'], true);

       if(in_array($disp_query,$dispqueries)){
           $this->Flash->error(__d('admin','Subject Already Exists try another.'));
           $this->redirect('/addsubject');
       } else {

         if (!empty($sitequeriesModel)){
           $queries = json_decode($sitequeriesModel['queries'], true);
           if ($id == NULL){

               $queries[] = $this->request->data('subject');
           }else{
               $queries[$id] = $this->request->data('subject');
           }
           $consubject->id = $sitequeriesModel['id'];
           $consubject->queries = json_encode($queries);
       }else{
           $queries[] = $this->request->data('subject');

           $consubject->type = 'contact_seller';
           $consubject->queries = json_encode($queries);
       }
       $this->Sitequeries->save($consubject);

       $this->Flash->success(__d('admin','Subject created'));
       $this->redirect('/contactsellersubject');
   }
}
if ($id != NULL){
   $sitequeriesModel = $this->Sitequeries->find()->where(['Sitequeries.type'=>'contact_seller'])->first();

   $queries = json_decode($sitequeriesModel['queries'], true);

   $this->set('query',$queries[$id]);
}else{
   $this->set('query','');
}
$this->set('id',$id);


}

public function deletesubject($id) {
 if(!$this->isauthenticated())
   $this->redirect('/');

$this->loadModel('Sitequeries');
$sitequeriesModel = $this->Sitequeries->find()->where(['Sitequeries.type'=>'contact_seller'])->first();
$consubject   =   $this->Sitequeries->newEntity();
$csqueries = array();
if (!empty($sitequeriesModel)){
   $queries = json_decode($sitequeriesModel['queries'], true);
   foreach ($queries as $qkey => $query){
     if ($id != $qkey){
       $csqueries[] = $query;
   }
}
$consubject->id = $sitequeriesModel['id'];
$consubject->queries = json_encode($csqueries);
$this->Sitequeries->save($consubject);
$this->Flash->success(__d('admin','Deleted Successfully'));
}else{
   $this->Flash->error('Subject Not Found');
}
$this->redirect('/contactsellersubject');


}
public function contacteditem(){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');


   $this->loadModel('Contactsellers');
   $item_datas = $this->Contactsellers->find('all', [
      'fields' => [
          'id' => 'Contactsellers.id',
          'itemname' => 'itemname',
          'itemid' => 'itemid',
          'sellername' => 'sellername',
          'count_itemid' => 'COUNT(Contactsellers.itemid)'
      ],
      'group' => ['Contactsellers.itemid'],
      'order'=>array('lastmodified'=>'desc'),
  ]);
   $this->set('item_datas', $item_datas);

   $pagecount = count($item_datas);



   $this->set('item_datas',$item_datas);
   $this->set('pagecount',$pagecount);
}

function itemconversation($itemid){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Contactsellers');

   $contactsellerModel = $this->Contactsellers->find()->where(['Contactsellers.itemid'=>$itemid])->all();
   $pagecount =count($contactsellerModel);
   $this->set('contactsellerModel',$contactsellerModel);
   $this->set('pagecount',$pagecount);
}

function itemuserconversation($csid,$itemid){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');


   $this->loadModel('Contactsellermsgs');
   $this->loadModel('Contactsellers');

         $contactsellerModel = $this->Contactsellers->find()->where(['id' => $csid])->toArray();//Byid($csid);
         $csmessageModel = $this->Contactsellermsgs->find()->where(['contactsellerid' => $csid])->order(['id' => 'DESC'])->toArray();
         $this->set('csid',$csid);
         $this->set('itemid',$itemid);
         $this->set('csmessageModel',$csmessageModel);
         $this->set('contactsellerModel',$contactsellerModel);
     }
     public function deletecsconversation($csid, $itemid){
         if(!$this->isauthenticated())
           $this->redirect('/');
       $this->autoLayout = false;
       $this->autoRender = false;

       $this->loadModel('Contactsellers');
       $this->loadModel('Contactsellermsgs');
       $this->Contactsellers->deleteAll(array('Contactsellers.id' => $csid), false);
       $this->Contactsellermsgs->deleteAll(array('Contactsellermsgs.contactsellerid' => $csid), false);
       $this->Flash->success(__d('admin','Conversation Deleted'));
       $this->redirect('/contacteditem');
   }
   public function viewcategory(){
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');

       $this->loadModel('Categories');

         $main_catdata = $this->Categories->find()->all();//'all',array('recursive'=>'-1'));


         $super_sub_catdata = $this->Categories->find()->where(['category_name <> '=>''])->order(['id'=>'DESC'])->all();//paginate('Categories');//print_r($super_sub_catdata);
         $pagecount = count($super_sub_catdata);



         $this->set('main_catdata',$main_catdata);
         $this->set('super_sub_catdata',$super_sub_catdata);
         $this->set('pagecount',$pagecount);
     }

     function deletecategory($catId = null) {
       $this->autoLayout = false;
       $this->autoRender = false;

       $this->loadModel('Categories');
       $this->loadModel('Items');

       $getcatitemdata = $this->Items->find()
       ->where([
        'OR' => [
            ['Items.category_id'=> $catId],
            ['Items.super_catid'=> $catId],
            ['Items.sub_catid'=> $catId]
        ]
    ])->count();


       if($getcatitemdata > 0)
       {
           $resval = 'products';
       }
       else
       {
           $subcatdata = $this->Categories->find()
           ->where([
              'OR' => [
                ['Categories.category_parent'=> $catId],
                ['Categories.category_sub_parent'=> $catId]
            ]
        ])->count();

           if($subcatdata > 0)
           {
               $resval = 'categories';
           }
           else
           {
               $resval = 'empty';
               $this->Categories->deleteAll(array('Categories.id' => $catId), false);
           }

       }

       $resp['status'] = $resval;
       echo json_encode($resp);
   }
   public function createcategory()
   {
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Categories');
   }


   public function mediasetting(){
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Sitesettings');

       if(!empty($this->request->data)){


           $id = '1';
           $media_url = $this->request->data('media_url');
           $media_server_hostname = $this->request->data('media_server_hostname');
           $media_server_username = $this->request->data('media_server_username');
           $media_server_password = $this->request->data('media_server_password');
           $this->Sitesettings->updateAll(array('media_url' => "$media_url",'media_server_hostname' => "$media_server_hostname",'media_server_username' => "$media_server_username",'media_server_password' => "$media_server_password"), array('id' => '1'));




           $this->Flash->success(__d('admin','saved successfully'));
           $this->redirect('/mediasetting');
       }

       $site_datas = $this->Sitesettings->find('all');
       $site_datas = $site_datas->first();

       $this->set('site_datas',$site_datas);
   }

   public function mailsetting(){
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Sitesettings');

       if(!empty($this->request->data)){


           $notification_email=$this->request->data('notification_email');
           $support_email=$this->request->data('support_email');
           $noreply_name=$this->request->data('noreply_name');
           $noreply_host=$this->request->data('noreply_host');
           $noreply_email=$this->request->data('noreply_email');
           $noreply_password=$this->request->data('noreply_password');
           $gmail_smtp=$this->request->data('gmail_smtp');
           $smtp_port=$this->request->data('smtp_port');
           $this->Sitesettings->updateAll(array('notification_email' => "$notification_email",'support_email' => "$support_email",'noreply_name' => "$noreply_name",'noreply_host' => "$noreply_host",'noreply_email' => "$noreply_email",'noreply_password' => "$noreply_password",'gmail_smtp' => "$gmail_smtp",'smtp_port' => "$smtp_port"), array('id' => '1'));



           $this->Flash->success(__d('admin','saved successfully'));
           $this->redirect('/mailsetting');
       }

       $site_datas = $this->Sitesettings->find('all');
       $site_datas = $site_datas->first();

       $this->set('site_datas',$site_datas);
   }
   public function managelanguage()
   {
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Languages');
       $this->loadModel('Countries');
       $this->loadModel('Shops');


       $usersTable = TableRegistry::get('Languages');
       $language_datas = $usersTable->find()->select(['countryid', 'Countries.country' ])
       ->leftJoinWith('Countries')
       ->group(['Languages.countryid'])
       ->autoFields(true);

       $this->set('language_datas',$language_datas);

       $shop_datas = $this->Shops->find('all',array('recursive'=>'-1'));
       foreach($shop_datas as $shops)
       {
           $shop_currency_code[] = $shops['currency'];
       }
       $this->set('shop_currency_code',$shop_currency_code);

   }

   function deletelanguage($lid=NULL)
   {
       $this->autoLayout = false;
       $this->autoRender = false;
       $this->loadModel('Languages');

       $this->Languages->deleteAll(array('Language.id' => $lid), false);

   }

   public function addlanguage()
   {

       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Countries');
       $this->loadModel('Languages');
       $this->loadModel('Forexrates');
         $country_datas = $this->Countries->find()->all();//'all',array('order'=>array('country'=>'asc')));
         $this->set('country_datas',$country_datas);
         $addlanguage   =   $this->Languages->newEntity();
         if(!empty($this->request->data))
         {
           $currencycode = $this->request->data('countrycode');
         $forexrate = $this->Forexrates->find()->where(['Forexrates.currency_code' => $currencycode])->all();//count',array('conditions'=>array('currency_code'=>$currencycode)));
         $cnt=count($forexrate);
         if($cnt<=0)
         {
           $this->Flash->error(__d('admin','Currency rate not available for this currency. Please add the currency rate for this currency'));
           $this->redirect('/managelanguage');
       }
       else
       {
           $addlanguage->countryid = $this->request->data('countryid');
           $addlanguage->countrycode = $this->request->data('countrycode');
           $addlanguage->languagecode = $this->request->data('languagecode');
           $addlanguage->languagename = $this->request->data('languagename');


           $this->Languages->save($addlanguage);
           $this->redirect('/managelanguage');
       }
   }
}
public function mobilesetting()
{
   $languageJson = file_get_contents(SITE_URL.'language_settings.json');
   $_SESSION['language_settings'] = json_decode($languageJson, true);

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Mobilepages');
   $mobileSettings =   $this->Mobilepages->find()->first();
   
   $androidurl = $mobileSettings['androidlink'];
   $iosurl = $mobileSettings['ioslink'];
   $this->set('androidurl',$androidurl);
   $this->set('iosurl',$iosurl);
   if(!empty($this->request->data)){
       $androidappurl = $this->request->data('android_app_url');
       $iosappurl = $this->request->data('ios_app_url');
       $mobileSettings->androidlink = $androidappurl;
       $mobileSettings->ioslink = $iosappurl;
       //$mobileSettings->id = 1;

       //   print_r("expression");exit;

       if($this->Mobilepages->save($mobileSettings))
       {

           $this->Flash->success(__d('admin','saved successfully'));
           $this->redirect('/mobilesetting');
       }
       else
           $this->Flash->error(__d('admin','error'));
   }

}
function socialsetting()
{
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Sitesettings');

   if(!empty($this->request->data)){
       $socialId['FB_ID'] = $this->request->data('FB_ID');
       $socialId['FB_SECRET'] = $this->request->data('FB_SECRET');
       $socialId['TWITTER_ID'] = $this->request->data('TWITTER_ID');
       $socialId['TWITTER_SECRET'] = $this->request->data('TWITTER_SECRET');
       $socialId['GOOGLE_ID'] = $this->request->data('GOOGLE_ID');
       $socialId['GOOGLE_SECRET'] = $this->request->data('GOOGLE_SECRET');
       $socialId['GMAIL_CLIENT_ID'] = $this->request->data('GMAIL_CLIENT_ID');
       $socialId['GMAIL_CLIENT_SECRET'] = $this->request->data('GMAIL_CLIENT_SECRET');
       $socialId = json_encode($socialId);


       $this->Sitesettings->updateAll(array('social_id' => "$socialId"), array('id' => '1'));

       $this->Flash->success(__d('admin','saved successfully'));
       $this->redirect('/socialsetting');
   }

   $site_datas = $this->Sitesettings->find('all');
   $site_datas = $site_datas->first();
         $socialId = $site_datas['social_id']; //print_r($socialId);
         $socialId = json_decode($socialId,true);

         $this->set('socialId',$socialId);

     }
     function socialpagesetting()
     {
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Sitesettings');

       if(!empty($this->request->data)){
           $socialLink['instagram_link'] = $this->request->data('instagram_link');
           $socialLink['facebook_link'] = $this->request->data('facebook_link');
           $socialLink['twitter_link'] = $this->request->data('twitter_link');
           $socialLink = json_encode($socialLink);

           $this->Sitesettings->updateAll(array('social_page' => "$socialLink"), array('id' => '1'));

           $this->Flash->success(__d('admin','saved successfully'));
           $this->redirect('/socialpagesetting');
       }
       $site_datas = $this->Sitesettings->find('all');
       $site_datas = $site_datas->first();
       $socialLink = $site_datas['social_page'];
       $socialLink = json_decode($socialLink,true);

       $this->set('socialLink',$socialLink);

   }
   public function addfaq(){


       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Faqs');
       $faq = $this->Faqs->newEntity();
       if(!empty($this->request->data)){

           $faq->faq_question = $this->request->data('faq_question');
           $faq->faq_answer = $this->request->data('faq_answer');


           $this->Faqs->save($faq);
           $this->redirect('/managefaq/');
       }
   }
   public function managefaq() {
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Faqs');
       $this->paginate = array('conditions'=>array('Faqs.id <>'=>0),'limit'=>10,'order'=>array('Faqs.id'=>'desc'));
       $getcolorval = $this->paginate('Faqs');
       $pagecount = count($getcolorval);

       $this->set('getcolorval',$getcolorval);
       $this->set('pagecount',$pagecount);
   }
   public function editfaq ($id = NULL) {

       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Faqs');
       $getcolorval = $this->Faqs->get($id);
       $this->set('getcolorval',$getcolorval);
       if(!empty($this->request->data)){
           $getcolorval->faq_question = $this->request->data('faq_question');
           $getcolorval->faq_answer = $this->request->data('faq_answer');


           $this->Faqs->save($getcolorval);
           $this->redirect('/managefaq/');
       }

   }
   function deletefaq($fid=NULL)
   {
       $this->autoLayout = false;
       $this->autoRender = false;
       $this->loadModel('Faqs');

       $this->Faqs->deleteAll(array('Faqs.id' => $fid), false);

   }

   public function sendpushnot(){
       $messages = $_POST['messages'];
       $this->autoLayout = false;
       $this->autoRender = false;
       $logusername = 'Admin';
       $image['user']['image'] = 'usrimg.jpg';
       $image['user']['link'] = '';
       $loguserimage = json_encode($image);
       $userids = array('0');
       $notifymsg = __d('admin','Admin -___-posted a news-___-');
       $userstable = TableRegistry::get('Users');
       $sellerdetails = $userstable->find()->where(['user_status'=>'enable'])->all();
       $setngs = TableRegistry::get('sitesettings')->find('all')->first();
       foreach ($sellerdetails as $sellerdetail) {
           $email[] = $sellerdetail['email'];
           $aSubject=$setngs['site_name'].__d('admin',' - Message from Admin');
           $aBody='';
           $template='adminmessage';

           $setdata=array('name'=>$sellerdetail['first_name'],'loguser'=>'Admin','message'=>$messages,'setngs'=>$setngs);
       }
       $usremail = implode(',', $email);
       if($this->isauthenticated()){
           $this->loadModel('Userdevices');
           $userdevicestable = TableRegistry::get('Userdevices');
           $userddett = $userdevicestable->find()->all();
           foreach ($userddett as $userd) {
             unset($pushMessage); 
             $pushMessage = array();
             $deviceTToken = $userd->deviceToken;
             $badge = $userd->badge;
             $badge +=1;
             $querys = $userdevicestable->query();
             $querys->update()
             ->set(['badge' => $badge])
             ->where(['deviceToken' => $deviceTToken])
             ->execute();
             if(isset($deviceTToken)){
               $pushMessage['type'] = 'admin_message';
               $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userd['user_id']])->first();
               I18n::locale($user_detail['languagecode']);
               $pushMessage['message'] = __d('user',"posted a news:").$messages;
               $this->pushnot($deviceTToken,json_encode($pushMessage),$badge);
           }
       }

       $userdevicestable = TableRegistry::get('Userdevices');
       $userddett = $userdevicestable->find()->group('user_id')->all();
       $logusernameurl = $user_detail['username_url'];
       $logusername = $user_detail['first_name'];
       $userImg = 'usrimg.jpg';
       $image['user']['image'] = $userImg;
       $image['user']['link'] = "";
       $loguserimage = json_encode($image);
       $notify_to=$userd['user_id'];
       $notifymsg =  __d('user',"posted a news:");
       $logdetails = $this->addloglive('admin',0,0,0,$notifymsg,$messages,$loguserimage);
       echo 'Successfully Sent';
   }
}

public function sitesetting(){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');


   $this->loadModel('Sitesettings');
   $site_datas = $this->Sitesettings->get(1);


   if(!empty($this->request->data)){




       $site_datas->site_logo = $this->request->data('site_logo');
       $site_datas->site_dark_logo = $this->request->data('site_dark_logo');

       $site_datas->admin_logo = $this->request->data('site_logo');
       $site_datas->site_logo_icon = $this->request->data('site_logo_icon');
       $site_datas->favicon_image = $this->request->data('favicon_image');
       $site_datas->user_default_image = $this->request->data('user_default_image');



       $credit_amount = $this->request->data('credit_amount');

       $siteChanges['credit_amount'] = $credit_amount;
       $siteChanges = json_encode($siteChanges);
       $site_datas->site_changes = $siteChanges;

       if(empty($this->request->data['site_logo'])){
           $site_datas->site_logo = 'logo.png';
       }
       if(empty($this->request->data['site_dark_logo'])){
           $site_datas->site_dark_logo = 'darklogo.png';
       }

       if(empty($this->request->data['site_logo_icon'])){
           $site_datas->site_logo_icon = 'logo_icon.png';
       }
       if(empty($this->request->data['favicon_image'])){
           $site_datas->favicon_image = 'favicon.ico';
       }
       if(empty($this->request->data['user_default_image'])){
           $site_datas->user_default_image = 'usrimg.jpg';
       }

       $site_datas->site_name = $this->request->data('site_name');
       $site_datas->site_title = $this->request->data('site_title');
       $site_datas->welcome_email =$this->request->data('welcome_email');
       $site_datas->signup_active =$this->request->data('signup_active');
       $site_datas->cod =$this->request->data('cod');
       $site_datas->like_btn_cmnt =$this->request->data('like_btn_cmnt');
       $site_datas->liked_btn_cmnt =$this->request->data('liked_btn_cmnt');
       $site_datas->unlike_btn_cmnt =$this->request->data('unlike_btn_cmnt');
       $site_datas->footer_active =$this->request->data('footer_active');
       $site_datas->meta_key = $this->request->data('meta_key');
       $site_datas->meta_desc = $this->request->data('meta_desc');
       $site_datas->footer_left = $this->request->data('footer_left');
       $site_datas->footer_right = $this->request->data('footer_right');

         //$site_datas->credit_percentage = $this->request->data('credit_percentage');


       $this->Sitesettings->save($site_datas);

       $this->Flash->success(__d('admin','Saved successfully'));
       $this->redirect('/sitesetting');
   }
   $site_datas = $this->Sitesettings->find()->first();

   $this->loadModel('Countries');
   $country_datas = $this->Countries->find('all',array('order'=>array('country'=>'asc')));
   $this->set('country_datas',$country_datas);
   $siteChanges = $site_datas['site_changes'];
   $siteChanges = json_decode($siteChanges,true);

   $this->set('site_datas',$site_datas);
   $this->set('siteChanges',$siteChanges);
}
public function managemodules(){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');


   $this->loadModel('Managemodules');
   $modeule_datas = $this->Managemodules->find()->toArray();

   $this->set('modeule_datas',$modeule_datas[0]);
   if(count($modeule_datas)==0)
   {
     if(!empty($this->request->data)){
       $modeule_datas =$this->Managemodules->newEntity();
       $modeule_datas->id=1;
       $modeule_datas->display_banner = $this->request->data('display_banner');
       $modeule_datas->site_maintenance_mode = $this->request->data('site_maintenance_mode');
       $modeule_datas->maintenance_text = $this->request->data('maintenance_text');
       $this->Managemodules->save($modeule_datas);
       $this->Flash->success(__d('admin','Saved successfully'));
       $this->redirect('/managemodules');
   }

}else
{


 if(!empty($this->request->data)){
   $display_banner = $this->request->data('display_banner');
   $site_maintenance_mode = $this->request->data('site_maintenance_mode');
   $maintenance_text = $this->request->data('maintenance_text');
   $this->Managemodules->updateAll(array('display_banner' => "$display_banner",'site_maintenance_mode' => "$site_maintenance_mode",'maintenance_text' => "$maintenance_text"), array('id' => '1'));

   $this->Flash->success(__d('admin','Saved successfully'));
   $this->redirect('/managemodules');
}
}


}


public function googlecode(){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Googlecodes');
   $google_datas = $this->Googlecodes->find()->toArray();

   $this->set('google_datas',$google_datas[0]);

   if(count($google_datas)==0)
   {
     if(!empty($this->request->data)){
       $google_datas =$this->Googlecodes->newEntity();
       $google_datas->id=1;
       $google_datas->google_code=$this->request->data('google_code');
       $google_datas->status =  $this->request->data('status');
       $this->Googlecodes->save($google_datas);
       $this->Flash->success(__d('admin','Saved successfully'));
       $this->redirect('/googlecode');
   }

}else
{

 if(!empty($this->request->data)){

   $google_code = $this->request->data('google_code');
   $status = $this->request->data('status');

   $this->Googlecodes->updateAll(array('google_code' => "$google_code",'status' => "$status"), array('id' => '1'));
   $this->Flash->success(__d('admin','Saved successfully'));
   $this->redirect('/googlecode');

}
}


}


public function addnews()
{
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Users');
   $this->loadModel('Sitesettings');
   $setngs = $this->Sitesettings->find()->toArray();
   $this->set('setngs',$setngs);

   $responce_val = $_POST['responce'];
   $this->set('responce_val',$responce_val);
   foreach($responce_val as $responces)
   {
       $responce_email[] = $responces['EMAIL'];
   }
   $this->set('responce_email',$responce_email);
   $user_datas = $this->Users->find('all',array('conditions'=>array('Users.email'=>$responce_email)));
   $this->set('user_datas',$user_datas);
   $users = $this->Users->find('all',array('conditions'=>array('Users.activation'=>'1','Users.id <>' => '1')));
   $count = count($users);
   $this->set('count',$count);
   $this->set('users',$users);


}
public function about() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_about'];
   $sub = $sale[0]['sub_about'];


   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_about' => "$main" , 'sub_about' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/about');
   }


}

public function documentation() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_documentation'];
   $sub = $sale[0]['sub_documentation'];
   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_documentation' => "$main" , 'sub_documentation' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/documentation');
   }


}

public function press() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_press'];
   $sub = $sale[0]['sub_press'];


   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_press' => "$main" , 'sub_press' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/press');
   }


}

public function pricing() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_pricing'];
   $sub = $sale[0]['sub_pricing'];
   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_pricing' => "$main" , 'sub_pricing' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/pricing');
   }


}

public function talk() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_talk'];
   $sub = $sale[0]['sub_talk'];

   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_talk' => "$main" , 'sub_talk' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/talk');
   }


}

public function faq() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_faq'];


   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];

       $main = $main;


       $this->Helps->updateAll(array('main_faq' => "$main"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/faq');
   }


}

public function contactaddress() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['contact'];


   $contact_json = json_decode($main);
   $cemailid =                 $contact_json->emailid;
   $cmobno   =                 $contact_json->mobileno;
   $ccntaddress =              $contact_json->contactaddress;

   $this->set('main',$main);
   $this->set('cemailid',$cemailid);
   $this->set('cmobno',$cmobno);
   $this->set('ccntaddress',$ccntaddress);

   if(!empty($this->request->data)) {

       $emailid = $this->request->data['emailid'];
       $mobno   = $this->request->data['mobno'];
       $cntaddress = $this->request->data['cntaddress'];
       $contactjson = array(
           'emailid' => $emailid,
           'mobileno' => $mobno,
           'contactaddress' => $cntaddress
       );

       $enccontactjson = json_encode($contactjson);


       $this->Helps->updateAll(array('contact' => "$enccontactjson"), array('id' => '1'));

       $this->Flash->success(__d('admin','Contact details updated successfully'));
       $this->redirect('/contactaddress');
   }


}

public function termsofsale() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_termsofSale'];
   $sub = $sale[0]['sub_termsofSale'];


   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_termsofSale' => "$main" , 'sub_termsofSale' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/termsofsale');
   }


}
public function termsofservice() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_termsofService'];
   $sub = $sale[0]['sub_termsofService'];

   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_termsofService' => "$main" , 'sub_termsofService' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/termsofservice');
   }


}

public function privacypolicy() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_privacy'];
   $sub = $sale[0]['sub_privacy'];

   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_privacy' => "$main" , 'sub_privacy' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/privacypolicy');
   }


}

public function copyrightpolicy() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_copyright'];
   $sub = $sale[0]['sub_copyright'];

   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_copyright' => "$main" , 'sub_copyright' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/copyrightpolicy');
   }


}

public function termsandcondition() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();
   $main = $sale[0]['main_termsofMerchant'];
   $sub = $sale[0]['sub_termsofMerchant'];


   $this->set('sub',$sub);
   $this->set('main',$main);
   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];
       $sub = $this->request->data['sub'];

       $main = $main;
       $sub = $sub;

       $this->Helps->updateAll(array('main_termsofMerchant' => "$main" , 'sub_termsofMerchant' => "$sub"), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/termsandcondition');
   }


}



public function addbanner(){
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Banners');
   $banner_data = $this->Banners->newEntity();

   if(!empty($this->request->data))
   {
    for($i=1;$i<=5;$i++)

    {
       $banner_type = $this->request->data('banner_type'.$i);

         $banners = $this->Banners->find()->where(['Banners.banner_type' => $banner_type])->all();//all', array('conditions'=>array('Banners.banner_type'=>'giftcard')));
         $banner_count = count($banners);
         if($banner_count>0) {

           $type = $this->request->data('banner_type'.$i);
           $name = $this->request->data('banner_name'.$i);
           $source = $this->request->data('html_source'.$i);
           $status = $this->request->data('status'.$i);


           $this->Banners->updateAll(array('banner_name' => "$name",'html_source' => "$source",'status' => "$status"), array('banner_type' => $type));

       } else {


           $banner_data->banner_name= $this->request->data('banner_name'.$i);
           echo $banner_data->banner_name;
           $banner_data->html_source= $this->request->data('banner_source'.$i);
           $banner_data->banner_type= $this->request->data('banner_type'.$i);
           $banner_data->banner_status= $this->request->data('banner_status'.$i);


       }
       $this->Banners->save($banner_data);


          //}
   }
   $this->Flash->success(__d('admin','Banner saved successfully'));
   $this->redirect('/addbanner');
}
         $giftcard = $this->Banners->find()->where(['Banners.banner_type' => 'giftcard'])->all();//all', array('conditions'=>array('Banners.banner_type'=>'giftcard')));

         foreach($giftcard as $gift) {
           $name = $gift['banner_name'];

           $source = $gift['html_source'];
           $status = $gift['status'];
           $this->set('giftName',$name);
           $this->set('giftSource',$source);
           $this->set('giftStatus',$status);
       }
       $product = $this->Banners->find()->where(['Banners.banner_type' => 'product'])->all();
       foreach($product as $product) {
           $name = $product['banner_name'];
           $source = $product['html_source'];
           $status = $product['status'];
           $this->set('productName',$name);
           $this->set('productSource',$source);
           $this->set('productStatus',$status);
       }
       $shop = $this->Banners->find()->where(['Banners.banner_type' => 'shop'])->all();
       foreach($shop as $shop) {
           $name = $shop['banner_name'];
           $source = $shop['html_source'];
           $status = $shop['status'];

           $this->set('shopName',$name);
           $this->set('shopSource',$source);
           $this->set('shopStatus',$status);
       }
       $find = $this->Banners->find()->where(['Banners.banner_type' => 'findfriends'])->all();
       foreach($find as $find) {
           $name = $find['banner_name'];
           $source = $find['html_source'];
           $status = $find['status'];
           $this->set('findName',$name);
           $this->set('findSource',$source);
           $this->set('findStatus',$status);
       }
       $invite = $this->Banners->find()->where(['Banners.banner_type' => 'invitefriends'])->all();
       foreach($invite as $invite) {
           $name = $invite['banner_name'];
           $source = $invite['html_source'];
           $status = $invite['status'];
           $this->set('inviteName',$name);
           $this->set('inviteSource',$source);
           $this->set('inviteStatus',$status);
       }
   }

   public function managerecipients()
   {
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');

       $this->loadModel('Recipients');
       $recipient_datas = $this->Recipients->find('all',array('order'=>array('id'=>'desc')));

       $pagecount = count($recipient_datas);
       $this->set('recipient_datas',$recipient_datas);
       $this->set('pagecount',$pagecount);
   }
   public function addrecipient()
   {
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Recipients');
       $recipient_datas=$this->Recipients->newEntity();
       if(!empty($this->request->data))
       {
           $recipientname = $this->request->data('recipient_name');
           $recip_data = $this->Recipients->find()->where(['recipient_name'=>$recipientname])->all();
           if(count($recip_data) > 0){
               $this->Flash->error(__d('admin','Recipient name Already Exists try another.'));
               $this->redirect('/addrecipient');
           } else {
               $recipient_datas->status = $this->request->data('Status');
               $recipient_datas->recipient_name = $this->request->data('recipient_name');
               $this->Recipients->save($recipient_datas);

           }

           $this->Redirect('/managerecipients');
       }

   }
   function editrecipient($id=NULL)
   {
       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Recipients');
       $recipient_data = $this->Recipients->findById($id)->toArray();
       $this->set('recipient_data',$recipient_data[0]);
       if(!empty($this->request->data))
       {
           $recipient_data = $this->Recipients->get($id);
           $recipientname = $this->request->data('recipient_name');
           $recip_data = $this->Recipients->find()->where(['recipient_name'=>$recipientname])->andWhere(['id <>'=> $id])->all();
           if(count($recip_data) > 0){
               $this->Flash->error(__d('admin','Recipient name Already Exists try another.'));
               $this->redirect('/editrecipient/'.$id);
           } else {
               $recipient_data->status = $this->request->data('Status');
               $recipient_data->recipient_name = $this->request->data('recipient_name');
               $this->Recipients->save($recipient_data);
               $this->redirect('/managerecipients');

           }
       }

   }

   function deleterecipient($tid=NULL)
   {
       $this->autoLayout = false;
       $this->autoRender = false;
       $this->loadModel('Recipients');

       $this->Recipients->deleteAll(array('Recipients.id' => $tid), false);

   }
   public function managecolors () {

       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Colors');

       $getcolorval = $this->Colors->find('all',array('order'=>array('id'=>'desc')));

       $pagecount = count($getcolorval);
       $this->set('getcolorval',$getcolorval);

   }
   public function addcolor () {

       $this->viewBuilder()->setLayout('admin');
       if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Colors');
       $color_data=$this->Colors->newEntity();
       if(!empty($this->request->data)){
           $rgbval1 = $this->request->data['rgbval1'];
           $rgbval2 = $this->request->data['rgbval2'];
           $rgbval3 = $this->request->data['rgbval3'];

           $rgbval = $rgbval1.','.$rgbval2.','.$rgbval3;

           $color_data->color_name = $this->request->data('colorname');
           $color_data->rgb = $rgbval;




           $rgb = array($rgbval);
           $hex = $this->rgb2hex($rgb);
           $color_data->color_hex =$hex;
           $color_data->cdate = time();

           $this->Colors->save($color_data);
           $this->redirect('/managecolors/');
       }

   }

   function rgb2hex($rgb) {
       $rgbv = explode(',',$rgb[0]);
       $hex = "#";
       $hex .= str_pad(dechex($rgbv[0]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgbv[1]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgbv[2]), 2, "0", STR_PAD_LEFT);
      return $hex; // returns the hex value including the number sign (#)
  }
  public function editcolor ($id = NULL) {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Colors');
   $getcolorval = $this->Colors->get($id);
   $this->set('getcolorval',$getcolorval);
   if(!empty($this->request->data)){
       $rgbval1 = $this->request->data['rgbval1'];
       $rgbval2 = $this->request->data['rgbval2'];
       $rgbval3 = $this->request->data['rgbval3'];

       $rgbval = $rgbval1.','.$rgbval2.','.$rgbval3;

       $getcolorval->color_name = $this->request->data('colorname');
       $getcolorval->rgb = $rgbval;




       $rgb = array($rgbval);
       $hex = $this->rgb2hex($rgb);
       $getcolorval->color_hex =$hex;
       $getcolorval->cdate = time();

       $this->Colors->save($getcolorval);
       $this->redirect('/managecolors/');
   }

}

function deletecolor($id=NULL)
{
   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Colors');

   $this->Colors->deleteAll(array('Colors.id' => $id), false);

}
public function manageprice () {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Prices');
   $this->loadModel('Forexrates');

   $getpriceval = $this->Prices->find()->where(['id <>'=>0])->all();
   $pagecount = count($getpriceval);
   $forexrateModel = $this->Forexrates->find()->where(['cstatus'=>'default'])->first();
   $this->set('getpriceval',$getpriceval);
   $this->set('pagecount',$pagecount);

   $this->set('default_currency_symbol',$forexrateModel['currency_symbol']);
}


public function addprice() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Prices');
   $price_data= $this->Prices->newEntity();
   if(!empty($this->request->data)){

       $price1 = $this->request->data('from');
       $price2 = $this->request->data('to');

       if($price1 < $price2){

           $addpricequery = $this->Prices->query();
           $addpricequery->insert(['fc_prices.from', 'fc_prices.to', 'fc_prices.cdate'])
           ->values([
              'fc_prices.from' => $price1,
              'fc_prices.to' => $price2,
              'fc_prices.cdate' => time()
          ])
           ->execute();

           $this->redirect('/manageprice/');
       }
       else{
           $this->redirect('/addprice/');
       }
   }

}



function editprice($id=NULL)
{
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Prices');
   $price_data = $this->Prices->findById($id)->toArray();
   $this->set('price_data',$price_data[0]);
   if(!empty($this->request->data))
   {
       $price_data = $this->Prices->get($id);

       $price1 = $this->request->data('from');
       $price2 = $this->request->data('to');
       $editpricequery = $this->Prices->query();
       $editpricequery->update()
       ->set(['fc_prices.from' => $price1,'fc_prices.to' => $price2,'fc_prices.cdate' => time()])
       ->where(['fc_prices.id' => $id])
       ->execute();

       $this->redirect('/manageprice/');
   }

}

function deleteprice($id=NULL)
{
   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Prices');

   $this->Prices->deleteAll(array('Prices.id' => $id), false);

}
public function managecurrency () {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Forexrates');


   $getcurrencyval = $this->Forexrates->find()->all();
   $pagecount = count($getcurrencyval);
   $this->set('getcurrencyval',$getcurrencyval);
   $this->set('pagecount',$pagecount);


}


function changecurrencystatus ($currId,$status) {
   $this->viewBuilder()->enableAutoLayout();
   $this->autoRender = false;
   $this->loadModel('Forexrates');

   if ($status == 'disable') {

       $this->Forexrates->updateAll(array('cstatus' => "enable"), array('id' => $currId));


       $result = "<button class='btn btn-warning' onclick='changeCurrencyStatus(".$currId.",\"enable\");'>".__d("admin","Disable")."</button>";
   }else {

       $this->Forexrates->updateAll(array('cstatus' => "disable"), array('id' => $currId));
       $result = "<button class='btn btn-success' onclick='changeCurrencyStatus(".$currId.",\"disable\");'>".__d("admin","Enable")."</button>";
   }

   echo $result."***".$status;

}


function deletecurrency($id=NULL)
{
   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Forexrates');

   $this->Forexrates->deleteAll(array('Forexrates.id' => $id), false);

}
function editcurrency($id=NULL)
{
   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Forexrates');
   $currency_data = $this->Forexrates->findById($id)->toArray();
   $this->set('currency_data',$currency_data[0]);
   if(!empty($this->request->data))
   {
       $currency_data = $this->Forexrates->get($id);

       $currency_data->price = $this->request->data('price');


       $this->Forexrates->save($currency_data);
       $this->redirect('/managecurrency/');


   }

}

public function addcurrency () {


   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Forexrates');

   if(!empty($this->request->data)){
       $currencydata=$this->Forexrates->find()->all();
       $tot=count($currencydata);

       $currency_code = $this->request->data('currency_code');

       $currency=$this->Forexrates->find()->where(['currency_code'=> $currency_code])->all();

       $count = count($currency);
       $currency_data= $this->Forexrates->newEntity();
       if($count == 0) {

           $currency_data->currency_code =$currency_code;
           $currency_data->currency_name = $_SESSION['currency_name'];
           $currency_data->currency_symbol = $_SESSION['currency_symbl'];
           $currency_data ->price = $this->request->data('Rate');
           if($tot>0)
               $currency_data ->cstatus = $this->request->data('Status');
           else
               $currency_data ->cstatus ='default';

           $this->Forexrates->save($currency_data);
           $this->redirect('/managecurrency/');
       }
       else{
           $this->Flash->error(__d('admin','Currency already exists'));
           $this->redirect('/addcurrency/');

       }

   }

}


function currency_code($currency) {

   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Forexrates');
   $currency_name = array('AED' => 'United Arab Emirates Dirham','ALL' => 'Albanian Lek','AMD' => 'Armenian Dram','AOA' => 'Angolan Kwanza','ARS' => 'Argentine Peso','AUD' => 'Australian Dollar','AWG' => 'Aruban Florin','AZN' => 'Azerbaijani Manat','BAM' => 'Bosnia and Herzegovina Convertible Mark','BBD' => 'Barbadian Dollar','BDT' => 'Bangladeshi Taka','BGN' => 'Bulgarian Lev','BHD' => 'Bahraini Dinar','BIF' => 'Burundian Franc*','BMD' => 'Bermudian Dollar','BND' => 'Brunei Dollar','BOB' => 'Bolivian Boliviano','BRL' => 'Brazilian Real','BSD' => 'Bahamian Dollar','BWP' => 'Botswana Pula','BYN' => 'Belarusian Ruble','BZD' => 'Belize Dollar', 'CAD' => 'Canadian Dollar','CHF' => 'Swiss Franc','CLP' => 'Chilean Peso','CNY' => 'Chinese Renminbi Yuan','COP' => 'Colombian Peso','CRC' => 'Costa Rican Colón','CUP' => 'Cuban Peso','CVE' => 'Cape Verdean Escudo', 'CZK' => 'Czech Koruna', 'DJF' => 'Djiboutian Franc*','DKK' => 'Danish Krone','DOP' => 'Dominican Peso','DZD' => 'Algerian Dinar','EGP' => 'Egyptian Pound','ERN' => 'Eritrean Nakfa','ETB' => 'Ethiopian Birr', 'EUR' => 'Euro','FJD' => 'Fijian Dollar','FKP' => 'Falkland Pound','GBP' => 'British Pound','GEL' => 'Georgian Lari','GHS' => 'Ghanaian Cedi','GIP' => 'Gibraltar Pound','GMD' => 'Gambian Dalasi','GNF' => 'Guinean Franc*','GTQ' => 'Guatemalan Quetzal','GYD' => 'Guyanese Dollar', 'HKD' => 'Hong Kong Dollar','HNL'=>'Honduran Lempira','HRK'=>'Croatian Kuna','HTG'=>'Haitian Gourde', 'HUF' => 'Hungarian Forint','IDR'=>'Indonesian Rupiah', 'ILS' => 'Israeli New Sheqel','INR'=>'Indian Rupee','IRR'=>'Iranian Rial','ISK'=>'Icelandic Króna','JMD'=>'Jamaican Dollar', 'JPY' => 'Japanese Yen','KES'=>'Kenyan Shilling','KGS'=>'Kyrgyzstani Som','KHR'=>'Cambodian Riel','KMF'=>'Comorian Franc*','KRW'=>'South Korean Won*','KYD'=>'Cayman Islands Dollar','KZT'=>'Kazakhstani Tenge','LAK'=>'Lao Kip*','LBP'=>'Lebanese Lira','LKR'=>'Sri Lankan Rupee','LRD'=>'Liberian Dollar','LSL'=>'Lesotho Loti','MAD'=>'Moroccan Dirham','MDL'=>'Moldovan Leu','MKD'=>'Macedonian Denar','MMK'=>'Myanmar Kyat','MNT'=>'Mongolian Tögrög','MOP'=>'Macanese Pataca','MUR'=>'Mauritian Rupee','MVR'=>'Maldivian Rufiyaa','MWK'=>'Malawian Kwacha','MXN'=>'Mexican Peso', 'MYR' => 'Malaysian Ringgit', 'NOK' => 'Norwegian Krone', 'NZD' => 'New Zealand Dollar', 'PHP' => 'Philippine Peso', 'PLN' => 'Polish Zloty', 'GBP' => 'Pound Sterling', 'RUB' => 'Russian Ruble', 'SGD' => 'Singapore Dollar', 'SEK' => 'Swedish Krona', 'CHF' => 'Swiss Franc', 'TWD' => 'Taiwan New Dollar', 'THB' => 'Thai Baht', 'TRY' => 'Turkish Lira', 'USD' => 'U.S. Dollar');

   $currency_symbol = array('AED' => 'د.إ','ALL' => 'L','AMD'=>'Դ','AOA'=>'Kz','ARS'=>'$','AUD' => '$','AWG'=>'ƒ','AZN'=>'ман','BAM'=>'КМ','BBD'=>'$','BDT'=>'৳','BGN'=>'лв','BHD'=>'ب.د','BIF'=>'₣','BMD'=>'$','BND'=>'$','BOB'=>'Bs.','BRL' => 'R$','BSD'=>'$','BWP'=>'P','BYN'=>'Br','BZD'=>'$', 'CAD' => '$', 'CHF'=>'₣','CLP'=>'$','CNY'=>'¥','COP'=>'$','CRC'=>'₡','CUP'=>'$','CVE'=>'$','CZK' => ' Kč','DJF'=>'₣', 'DKK' => 'kr.','DOP' => '$','DZD'  => 'د.ج','EGP' => '£','ERN'  =>'Nfk','ETB'=>'ብር', 'EUR' => '€','FJD' => '$','FKP' => '£','GBP' => '£','GEL' => 'ლ','GHS' => '₵','GIP' => '£','GMD' => 'D','GNF' => '₣','GTQ' => 'Q','GYD' => '$', 'HKD' => '$','HNL'=>'L','HRK'=>'Kn','HTG'=>'G','HUF' => 'Ft', 'IDR'=>'Rp','ILS' => '₪','INR'=>'₨','IRR'=>'﷼','ISK'=>'Kr','JMD'=>'$',  'JPY' => '¥','KES'=>'Sh','KGS'=>'som','KHR'=>'៛','KMF'=>'francs','KRW'=>'₩','KYD'=>'$','KZT'=>'〒','LAK'=>'₭','LBP'=>'ل.ل','LKR'=>'Rs','LRD'=>'$','LSL'=>'L','MAD'=>'د.م.','MDL'=>'L','MKD'=>'ден','MMK'=>'K','MNT'=>'₮','MOP'=>'P','MUR'=>'₨','MVR'=>'  ރ.','MWK'=>'MK','MXN'=>'Mex$',  'MYR' => 'RM', 'NOK' => 'kr', 'NZD' => '$', 'PHP' => '₱', 'PLN' => 'zÅ‚', 'GBP' => '£', 'RUB' => 'руб', 'SGD' => 'S$', 'SEK' => 'kr', 'CHF' => 'SFr.', 'TWD' => '$', 'THB' => '฿', 'TRY' => 'TL', 'USD' => '$');

   $_SESSION['currency_name'] = $currency_name[''.$currency.''];

   $_SESSION['currency_symbl'] =  $currency_symbol[''.$currency.''];

}
public function nonapprovedseller()
{
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Shops');
   $this->loadModel('Users');
   $usersTable = TableRegistry::get('Shops');
   $sellerModel = $usersTable->find()->select(['user_id', 'Users.first_name' ])
   ->where(['seller_status' => 0])
   ->leftJoinWith('Users')
   ->group(['Shops.user_id'])
   ->autoFields(true);
   $this->set('sellerModel',$sellerModel);


}

public function changesellerstatus ($shopId,$status) {
    if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Shops');
   $this->loadModel('Users');
   $this->loadModel('Sitesettings');

   global $setngs;
   global $loguser;

   $setngs = $this->Sitesettings->find()->where(['id'=>1])->toArray();

   if ($status == 1) {

       $this->Shops->updateAll(array('seller_status' => 0), array('id' => $shopId));



   }else {
       $this->Shops->updateAll(array('seller_status' => 1), array('id' => $shopId));

         $shop_user = $this->Shops->find()->where(['id' => $shopId])->toArray();//all',array('conditions'=>array('Shop.id'=>$shopId)));
         $user_id = $shop_user[0]['user_id'];

         $email_address = $this->Users->find()->where(['id'=> $user_id])->toArray();//"all",array("conditions"=>array('User.id'=>$user_id)));
         $emailaddress = $email_address[0]['email'];

     }
 }

 public function sellerinfo ($sellerId=null)
 {

   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   




   $this->loadModel('Shops');
   $this->loadModel('Users');
   $this->loadModel('Countries');
   $this->loadModel('Categories');

   $loguser = $this->Users->find()->where(['id'=>$sellerId])->first(); 
   $this->set('loguser',$loguser);

   $cat_datas = $this->Categories->find()->where(['category_parent' => '0', 'category_sub_parent' => '0'])->all();
   $this->set('cat_datas',$cat_datas);

   $countrylist = $this->Countries->find()->all();
   $this->set('countrylist',$countrylist);

   $editsetting = $this->Users->findById($sellerId)->contain(['Shops'])->first();

   $this->set('editsetting',$editsetting);
   $this->set('sellerid',$sellerId);


}



public function editseller ($sellerId=null){
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Shops');
   $shopModel = $this->Shops->findById($sellerId)->toArray();

   $this->set('shopModel',$shopModel[0]);
   $this->set('sellerid',$sellerId);
   if(!empty($this->request->data)){
       $shop_datas = $this->Shops->get($sellerId);
       $shop_datas->id= $sellerId;
       $shop_datas->shop_name = $this->request->data('brand_name');
       $shop_datas->merchant_name = $this->request->data('merchant_name');
       $shop_datas->seller_status = $this->request->data('status');
       if($this->request->data('seller_status')==2)
       {
           $shop_datas->seller_status=1;
       }
       $shop_datas->braintree_id = $this->request->data('braintree_id');
       $shop_datas->phone_no = $this->request->data('person_phone_number');
       $shop_datas->shop_address = $this->request->data('officeaddress');
       $shop_datas ->shop_latitude = $this->request->data('bankaccountno');
       $shop_datas->shop_longitude= $this->request->data('mpowerid');


       $this->Shops->save($shop_datas);
       $this->Flash->success(__d('admin','Successfully edited.'));
       if($shop_datas->seller_status==0)

           $this->redirect('/nonapprovedseller');
       else
           $this->redirect('/approvedseller');
   }
}

public function braintreeSettings($flag = null)
{

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Sitesettings');
   $this->loadModel('Forexrates');


   if(!empty($this->request->data)){

    if($flag == 1) {
       $paycurrency= $this->request->data('currency_code');
       $site_datas = $this->Sitesettings->find('all')->first();
       $sitepaystatus = $site_datas['braintree_setting'];
       $sitepaystatus = json_decode($sitepaystatus,true);

       if (array_key_exists($paycurrency, $sitepaystatus)) {
          unset($sitepaystatus[$paycurrency]);
          $paystatus['merchant_account_id'] = $this->request->data('merchant_account_id');
          $paystatus = json_encode(array_merge($sitepaystatus,array($paycurrency=>$paystatus)));
      } else {
       $paystatus['merchant_account_id'] = $this->request->data('merchant_account_id');

       if($sitepaystatus=='')
           $paystatus = json_encode(array($paycurrency=>$paystatus));  
       else
           $paystatus = json_encode(array_merge($sitepaystatus,array($paycurrency=>$paystatus)));  
   }

   $this->Sitesettings->updateAll(array('braintree_setting' => "$paystatus"), array('id' => '1'));
   $this->Flash->success(__d('admin','saved successfully'));
   $this->redirect('/braintree_settings');
} elseif ($flag == 2) {
   $merchantstatus['type'] = $this->request->data('type');

   $merchantstatus['merchant_id'] = $this->request->data('merchant_id');
   $merchantstatus['public_key'] = $this->request->data('public_key');
   $merchantstatus['private_key'] = $this->request->data('private_key');
   $merchantstatus = json_encode($merchantstatus);

   $this->Sitesettings->updateAll(array('merchantid_setting' => "$merchantstatus"), array('id' => '1'));
   $this->Flash->success(__d('admin','saved successfully'));
   $this->redirect('/braintree_settings');
} else {
   $this->Flash->error(__d('admin','error'));
   $this->redirect('/braintree_settings');
}
}
$site_datas = $this->Sitesettings->find('all');
$site_datas = $site_datas->first();
$merchant_id_setting = $site_datas['merchantid_setting'];
$merchant_id_setting = json_decode($merchant_id_setting,true);

$forexrates_datas = $this->Forexrates->find()->where(['cstatus' => 'default'])->first();
if(count($forexrates_datas) > 0) {
   $braintree_setting = json_decode($site_datas['braintree_setting'],true);
   $braintree_setting = $braintree_setting[$forexrates_datas['currency_code']]['merchant_account_id'];
}
else
   $braintree_setting = "";

$this->set('braintree_setting_code',$forexrates_datas['currency_code']);
$this->set('braintree_setting_data',$braintree_setting);
$this->set('paystatus',$merchant_id_setting);


}

public function approvedseller()
{
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Shops');
   $this->loadModel('Users');
   $usersTable = TableRegistry::get('Shops');
   $sellerModel = $usersTable->find()->select(['user_id', 'Users.first_name' ])
   ->where(['seller_status' => 1])
   ->leftJoinWith('Users')
   ->group(['Shops.user_id'])
   ->autoFields(true);
   $this->set('sellerModel',$sellerModel);


}
public function neworders () {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Users');
   $this->loadModel('Orders');
   $this->loadModel('Commissions');

   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $usersTable = TableRegistry::get('Orders');
   $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
    ->where(['status <> '=> 'Shipped',['status <> '=>'Delivered',['status <> '=>'Paid']]])//conditions'=>array('NOT' => array('Orders.status' => array('Shipped','Delivered','Paid')))
    ->leftJoinWith('Users')
    ->group(['Orders.orderid'])
    ->autoFields(true)
    ->order(['Orders.orderid'=>'DESC']);

    $commiDetails = $this->Commissions->find('all',array('conditions'=>array('Commissions.active'=>'1')));
    if(!empty($getpayval)){
        foreach($getpayval as $key=>$pay){
           $orderIddd= $pay['orderid'];

           $order_totalcost_ognl[$orderIddd] = $pay['totalcost'];
           $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];


           foreach($commiDetails as $commi){
               $min_val = $commi['min_value'];
               $max_val =  $commi['max_value'];
               if($totcostreduceShip >= $min_val && $totcostreduceShip <= $max_val){
                if($commi['Commission']['type'] == '%'){
                   $dis = (floatval($totcostreduceShip)/100)*$commi['amount'];
                   $order_totalcost[$orderIddd] = $totcostreduceShip - $dis;
               }else{
                   $order_totalcost[$orderIddd] = $totcostreduceShip-$commi['amount'];
               }
           }
       }
   }
}

//echo '<pre>'; print_r($getpayval->all()); die;

$this->set('getitemuser',$getpayval);


}


public function viewneworder ($orderId = NULL) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');

         $orderModel = $this->Orders->find()->where(['orderid'=> $orderId])->first();//Byorderid($orderId)->first();
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();

         $invoiceorders = $this->Invoiceorders->find()->where(['orderId'=>$orderId])->first();//first',array('conditions'=>array('Invoiceorders.orderId'=>$orderId)));
         $invoiceid = $invoiceorders['invoiceid'];
         $invoices = $this->Invoices->find()->where(['invoiceid'=> $invoiceid])->first();//first',array('conditions'=>array('Invoices.invoiceid'=>$invoiceid)));
         $paymentmethod = $invoices['paymentmethod'];
         $this->set('paymentmethod',$paymentmethod);

         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shippingid])->first();//findByshippingid($shippingid)->first();

         $sellerId = $this->Items->find()->where(['id' => $orderItemModel[0]['itemid']])->first();//first',array('conditions'=>array('Item.id'=>$orderItemModel[0]['Order_items']['itemid'])));
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=> $orderModel['userid']])->first();//Byid($orderModel['userid']);
         $sellerModel = $this->Users->find()->where(['id'=> $sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();//first',array('conditions'=>array(
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);

         $tax = $orderModel['tax'];

         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);

         $admin_commission  = $orderModel['admin_commission'];

         $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderId])->where(['status' => 'purchased'])->first();
        $this->set('shareproducts',$shareproducts);

         $this->set('admin_commission',$admin_commission);
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


     public function deliveredorders () {
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Users');
       $this->loadModel('Orders');
       $this->loadModel('Order_items');
       $this->loadModel('Commissions');

       $usersTable = TableRegistry::get('Orders');
       $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
    ->where(['status' => 'Delivered'])//conditions'=>array('NOT' => array('Orders.status' => array('Shipped','Delivered','Paid')))
    ->leftJoinWith('Users')
    ->group(['Orders.orderid'])
    ->autoFields(true)
    ->order(['status_date'=>'DESC']);




         $commiDetails = $this->Commissions->find()->where(['active'=>1])->all();//all',array('conditions'=>array('Commission.active'=>'1')));

         if(!empty($getpayval)){
            foreach($getpayval as $key=>$pay){
               $orderIddd= $pay['orderid'];
         $orderitemModel = $this->Order_items->find()->where(['orderid'=> $orderIddd])->all();//all',array('conditions'=>array('orderid'=>$orderIddd)));
         $couponAmount  = 0;
         foreach ($orderitemModel as $orderItems){
            if($orderItems['discountType'] != 'Giftcard Discount')
            {
               $couponAmount += $orderItems['discountAmount'];
           }else{
               $couponAmount += $orderItems['giftamount'];
           }
       }

       $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderIddd])->where(['status' => 'purchased'])->first();
        

       $ordermerchant_id[] = $pay['merchant_id'];
       $order_status[$orderIddd] = $pay['status'];
       $order_total[$orderIddd] = $pay['totalcost'] + $pay['totalCostshipp'] + $pay['tax'];
       $order_discountamount[$orderIddd] = $couponAmount;
       $order_totalcost_ognl[$orderIddd] =  $pay['totalcost'] + $pay['totalCostshipp'] + $pay['tax']-$couponAmount;
       $order_totalcostShipping_ognl[$orderIddd] = $pay['totalCostshipp'];
       $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];

       if($pay['deliverytype'] == 'credit' || $pay['deliverytype'] == 'giftcard') {
        $order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['totalCostshipp'] + $pay['tax'] - $pay['admin_commission'] - $shareproducts['share_amount'];
      } else {
        $order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['totalCostshipp'] + $pay['tax'] - $pay['admin_commission'] - $shareproducts['share_amount'] - $couponAmount;
      }
       
       $order_currency[$orderIddd] = $pay['currency'];


       $usernames1 = $this->Users->findById($pay['merchant_id'])->toArray();
       $usernames[$pay['merchant_id']] = $usernames1[0]['username_url'];
   }
}
;

$this->set('getitemuser',$getpayval);
$this->set('order_status',$order_status);
$this->set('order_total',$order_total);
$this->set('order_discountamount',$order_discountamount);
$this->set('order_totalcost',$order_totalcost);
$this->set('order_currency',$order_currency);
$this->set('order_totalcost_ognl',$order_totalcost_ognl);
$this->set('order_totalcostShipping_ognl',$order_totalcostShipping_ognl);
$this->set('usernames',$usernames);

}


public function viewdeliveredorder ($orderId) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Shops');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');

         $orderModel = $this->Orders->find()->where(['orderid'=>$orderId])->first();//Byorderid($orderId);
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();


         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=>$shippingid])->first();

         $sellerId = $this->Items->find()->where(['id'=> $orderItemModel[0]['itemid']])->first();//first',array('conditions'=>array('Item.id'=>$orderItemModel[0]['Order_items']['itemid'])));
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=> $orderModel['userid']])->first();
         $sellerModel = $this->Users->find()->where(['id'=> $sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);
         $admin_commission  = $orderModel['admin_commission'];
         $tax = $orderModel['tax'];

         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);

        $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderId])->where(['status' => 'purchased'])->first();
        $this->set('shareproducts',$shareproducts);

         $this->set('getcouponvalue',$getcouponvalue);
         $this->set('orderDetails',$orderModel);
         $this->set('orderItemModel',$orderItemModel);
         $this->set('orderCurrency',$orderCurrency);
         $this->set('admin_commission',$admin_commission);
         $this->set('userModel',$userModel);
         $this->set('sellerModel',$sellerModel);
         $this->set('shippingModel',$shippingModel);
         $this->set('discount_amount',$discount_amount);
         $this->set('tax',$tax);
     }

     public function confirmtomerchant($orderid = NULL)
     {
       $this->autoLayout = false;
       $this->autoRender = false;
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Orders');
       $statusDate = time();

       if( $this->Orders->updateAll(array('status' => "Paid",'status_date' => "$statusDate"), array('orderid' => $orderid)))
       {
        echo __d('admin','success');
    }
    else
    {
        echo __d('admin','error');
    }

}



public function approvedorders () {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Users');
   $this->loadModel('Orders');
   $this->loadModel('Order_items');
   $this->loadModel('Commissions');

   $usersTable = TableRegistry::get('Orders');
   $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
    ->where(['status' => 'Paid'])//conditions'=>array('NOT' => array('Orders.status' => array('Shipped','Delivered','Paid')))
    ->leftJoinWith('Users')
    ->group(['Orders.orderid'])
    ->autoFields(true)
    ->order(['status_date'=>'DESC']);




         $commiDetails = $this->Commissions->find()->where(['active'=>1])->all();//all',array('conditions'=>array('Commission.active'=>'1')));

         if(!empty($getpayval)){
            foreach($getpayval as $key=>$pay){
               $orderIddd= $pay['orderid'];
         $orderitemModel = $this->Order_items->find()->where(['orderid'=> $orderIddd])->all();//all',array('conditions'=>array('orderid'=>$orderIddd)));
         $couponAmount  = 0;
         foreach ($orderitemModel as $orderItems){
            if($orderItems['discountType']=='Coupon Discount')
               $couponAmount += $orderItems['discountAmount'];
       }

        $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderIddd])->where(['status' => 'paid'])->first();
        

       $ordermerchant_id[] = $pay['merchant_id'];
       $order_status[$orderIddd] = $pay['status'];
       $order_total[$orderIddd] = $pay['totalcost']+ $pay['tax'];
       $order_discountamount[$orderIddd] = $couponAmount;
       $order_totalcost_ognl[$orderIddd] = $pay['totalcost'] + $pay['totalCostshipp'] + $pay['tax']-$couponAmount - $pay['admin_commission'] - $shareproducts['share_amount'];
       $order_totalcostShipping_ognl[$orderIddd] = $pay['totalCostshipp'];
       $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];

       $order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['tax'] - $pay['admin_commission']-$couponAmount;
       $order_currency[$orderIddd] = $pay['currency'];


       $usernames1 = $this->Users->findById($pay['merchant_id'])->toArray();
       $usernames[$pay['merchant_id']] = $usernames1[0]['username_url'];
   }
}


$this->set('getitemuser',$getpayval);
$this->set('order_status',$order_status);
$this->set('order_total',$order_total);
$this->set('order_discountamount',$order_discountamount);
$this->set('order_totalcost',$order_totalcost);
$this->set('order_currency',$order_currency);
$this->set('order_totalcost_ognl',$order_totalcost_ognl);
$this->set('order_totalcostShipping_ognl',$order_totalcostShipping_ognl);
$this->set('usernames',$usernames);
      //$this->set('tot',$tot);
}
public function viewapprovedorder ($orderId) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');

         $orderModel = $this->Orders->find()->where(['orderid'=> $orderId])->first();//Byorderid($orderId);
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();//AllByorderid($orderId);

         $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=> $orderId])->first();//first',array('conditions'=>array('Invoiceorders.orderId'=>$orderId)));
         $invoiceid = $invoiceorders['invoiceid'];
         $invoices = $this->Invoices->find()->where(['invoiceid'=> $invoiceid])->first();//first',array('conditions'=>array('Invoices.invoiceid'=>$invoiceid)));
         $paymentmethod = $invoices['paymentmethod'];
         $this->set('paymentmethod',$paymentmethod);

         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shippingid])->first();//Byshippingid($shippingid);

         $sellerId = $this->Items->find()->where(['id'=> $orderItemModel[0]['itemid']])->first();//first',array('conditions'=>array('Item.id'=>$orderItemModel[0]['Order_items']['itemid'])));
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=>$orderModel['userid']])->first();
         $sellerModel = $this->Users->find()->where(['id'=>$sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);
         $admin_commission  = $orderModel['admin_commission'];
         $tax = $orderModel['tax'];

         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);

          $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderId])->where(['status' => 'paid'])->first();
        $this->set('shareproducts',$shareproducts);

         $this->set('getcouponvalue',$getcouponvalue);
         $this->set('orderDetails',$orderModel);
         $this->set('orderItemModel',$orderItemModel);
         $this->set('orderCurrency',$orderCurrency);
         $this->set('admin_commission',$admin_commission);
         $this->set('userModel',$userModel);
         $this->set('sellerModel',$sellerModel);
         $this->set('shippingModel',$shippingModel);
         $this->set('discount_amount',$discount_amount);
         $this->set('tax',$tax);
     }

     public function refundedorders()
     {
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Users');
       $this->loadModel('Orders');
       $this->loadModel('Order_items');
       $this->loadModel('Commissions');

       $usersTable = TableRegistry::get('Orders');
       $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
       ->where(['status' => 'Refunded'])
       ->leftJoinWith('Users')
       ->group(['Orders.orderid'])
       ->autoFields(true)
       ->order(['refunded_date'=>'DESC']);

         $commiDetails = $this->Commissions->find()->where(['active'=>1])->all();//

         if(!empty($getpayval)){
            foreach($getpayval as $key=>$pay){
               $orderIddd= $pay['orderid'];
         $orderitemModel = $this->Order_items->find()->where(['orderid'=> $orderIddd])->all();//all',array('conditions'=>array('orderid'=>$orderIddd)));
         $couponAmount  = 0;
         foreach ($orderitemModel as $orderItems){
            if($orderItems['discountType']=="Coupon Discount")
               $couponAmount += $orderItems['discountAmount'];
       }

       $ordermerchant_id[] = $pay['merchant_id'];
       $order_status[$orderIddd] = $pay['status'];
       $order_total[$orderIddd] = $pay['totalcost']+ $pay['tax'];
       $order_discountamount[$orderIddd] = $couponAmount;
       $order_totalcost_ognl[$orderIddd] = $pay['totalcost'];
       $order_totalcostShipping_ognl[$orderIddd] = $pay['totalCostshipp'];
       $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];

       $order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['tax'] + $pay['totalCostshipp'] -$couponAmount;
       $order_currency[$orderIddd] = $pay['currency'];


       $usernames1 = $this->Users->findById($pay['merchant_id'])->toArray();
       $usernames[$pay['merchant_id']] = $usernames1[0]['username_url'];
   }
}

$this->set('getitemuser',$getpayval);
$this->set('order_status',$order_status);
$this->set('order_total',$order_total);
$this->set('order_discountamount',$order_discountamount);
$this->set('order_totalcost',$order_totalcost);
$this->set('order_currency',$order_currency);
$this->set('order_totalcost_ognl',$order_totalcost_ognl);
$this->set('order_totalcostShipping_ognl',$order_totalcostShipping_ognl);
$this->set('usernames',$usernames);
}

public function viewrefundedorder ($orderId) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');

         $orderModel = $this->Orders->find()->where(['orderid'=> $orderId])->first();//Byorderid($orderId);
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();//AllByorderid($orderId);

         $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=> $orderId])->first();//first',array('conditions'=>array('Invoiceorders.orderId'=>$orderId)));
         $invoiceid = $invoiceorders['invoiceid'];
         $invoices = $this->Invoices->find()->where(['invoiceid'=> $invoiceid])->first();//first',array('conditions'=>array('Invoices.invoiceid'=>$invoiceid)));
         $paymentmethod = $invoices['paymentmethod'];
         $this->set('paymentmethod',$paymentmethod);

         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shippingid])->first();//Byshippingid($shippingid);

         $sellerId = $this->Items->find()->where(['id'=> $orderItemModel[0]['itemid']])->first();//first',array('conditions'=>array('Item.id'=>$orderItemModel[0]['Order_items']['itemid'])));
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=>$orderModel['userid']])->first();
         $sellerModel = $this->Users->find()->where(['id'=>$sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);

         $tax = $orderModel['tax'];

         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);

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

     public function cancelledorders()
     {
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Users');
       $this->loadModel('Orders');
       $this->loadModel('Order_items');
       $this->loadModel('Commissions');

       $usersTable = TableRegistry::get('Orders');
       $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
       ->where(['status' => 'Cancelled'])
       ->leftJoinWith('Users')
       ->group(['Orders.orderid'])
       ->autoFields(true)
       ->order(['orderid'=>'DESC']);
         $commiDetails = $this->Commissions->find()->where(['active'=>1])->all();//

         if(!empty($getpayval)){
            foreach($getpayval as $key=>$pay){
               $orderIddd= $pay['orderid'];
         $orderitemModel = $this->Order_items->find()->where(['orderid'=> $orderIddd])->all();//all',array('conditions'=>array('orderid'=>$orderIddd)));
         $couponAmount  = 0;
         foreach ($orderitemModel as $orderItems){
            if($orderItems['discountType']=='Coupon Discount')
               $couponAmount += $orderItems['discountAmount'];
       }

       $ordermerchant_id[] = $pay['merchant_id'];
       $order_status[$orderIddd] = $pay['status'];
       $order_total[$orderIddd] = $pay['totalcost']+ $pay['tax'];
       $order_discountamount[$orderIddd] = $couponAmount;
       $order_totalcost_ognl[$orderIddd] = $pay['totalcost'];
       $order_delivery_type[$orderIddd] = $pay['deliverytype'];
       $order_totalcostShipping_ognl[$orderIddd] = $pay['totalCostshipp'];
       $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];

       $order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['totalCostshipp'] + $pay['tax'] -$couponAmount;
       $order_currency[$orderIddd] = $pay['currency'];


       $usernames1 = $this->Users->findById($pay['merchant_id'])->toArray();
       $usernames[$pay['merchant_id']] = $usernames1[0]['username_url'];
   }
}

$this->set('getitemuser',$getpayval);
$this->set('order_status',$order_status);
$this->set('order_total',$order_total);
$this->set('order_discountamount',$order_discountamount);
$this->set('order_totalcost',$order_totalcost);
$this->set('order_delivery_type',$order_delivery_type);
$this->set('order_currency',$order_currency);
$this->set('order_totalcost_ognl',$order_totalcost_ognl);
$this->set('order_totalcostShipping_ognl',$order_totalcostShipping_ognl);
$this->set('usernames',$usernames);
}

public function viewcancelledorder ($orderId) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');

         $orderModel = $this->Orders->find()->where(['orderid'=> $orderId])->first();//Byorderid($orderId);
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();//AllByorderid($orderId);

         $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=> $orderId])->first();//first',array('conditions'=>array('Invoiceorders.orderId'=>$orderId)));
         $invoiceid = $invoiceorders['invoiceid'];
         $invoices = $this->Invoices->find()->where(['invoiceid'=> $invoiceid])->first();//first',array('conditions'=>array('Invoices.invoiceid'=>$invoiceid)));
         $paymentmethod = $invoices['paymentmethod'];
         $this->set('paymentmethod',$paymentmethod);

         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shippingid])->first();//Byshippingid($shippingid);

         $sellerId = $this->Items->find()->where(['id'=> $orderItemModel[0]['itemid']])->first();//first',array('conditions'=>array('Item.id'=>$orderItemModel[0]['Order_items']['itemid'])));
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=>$orderModel['userid']])->first();
         $sellerModel = $this->Users->find()->where(['id'=>$sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);

         $tax = $orderModel['tax'];

         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);

      //echo $discount_amount;die;

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
     public function shippedorders()
     {
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Users');
       $this->loadModel('Orders');
       $this->loadModel('Order_items');
       $this->loadModel('Commissions');

       $usersTable = TableRegistry::get('Orders');
       $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
    ->where(['status' => 'Shipped'])//conditions'=>array('NOT' => array('Orders.status' => array('Shipped','Delivered','Paid')))
    ->leftJoinWith('Users')
    ->group(['Orders.orderid'])
    ->autoFields(true)
    ->order(['status_date'=>'DESC']);




         $commiDetails = $this->Commissions->find()->where(['active'=>1])->all();//all',array('conditions'=>array('Commission.active'=>'1')));

         if(!empty($getpayval)){
            foreach($getpayval as $key=>$pay){
               $orderIddd= $pay['orderid'];
         $orderitemModel = $this->Order_items->find()->where(['orderid'=> $orderIddd])->all();//all',array('conditions'=>array('orderid'=>$orderIddd)));
         $couponAmount  = 0;
         foreach ($orderitemModel as $orderItems){
           $couponAmount += $orderItems['discountAmount'];
       }


        $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderIddd])->where(['status' => 'purchased'])->first();
        

       $ordermerchant_id[] = $pay['merchant_id'];
       $order_status[$orderIddd] = $pay['status'];
       $order_total[$orderIddd] = $pay['totalcost']+ $pay['tax'];
       $order_discountamount[$orderIddd] = $couponAmount;
       $order_totalcost_ognl[$orderIddd] = $pay['totalcost']  - $pay['admin_commission'] - $shareproducts['share_amount'];
       $order_totalcostShipping_ognl[$orderIddd] = $pay['totalCostshipp'];
       $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];

       //$order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['tax'] - $pay['admin_commission']-$couponAmount;
       $order_totalcost[$orderIddd] = $pay['totalcost'] - $pay['admin_commission'];
       $order_currency[$orderIddd] = $pay['currency'];


       $usernames1 = $this->Users->findById($pay['merchant_id'])->toArray();
       $usernames[$pay['merchant_id']] = $usernames1[0]['username_url'];
   }
}


$this->set('getitemuser',$getpayval);
$this->set('order_status',$order_status);
$this->set('order_total',$order_total);
$this->set('order_discountamount',$order_discountamount);
$this->set('order_totalcost',$order_totalcost);
$this->set('order_currency',$order_currency);
$this->set('order_totalcost_ognl',$order_totalcost_ognl);
$this->set('order_totalcostShipping_ognl',$order_totalcostShipping_ognl);
$this->set('usernames',$usernames);
      //$this->set('tot',$tot);
}

public function viewshippedorder($orderId) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');

   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');

         $orderModel = $this->Orders->find()->where(['orderid'=> $orderId])->first();//Byorderid($orderId);
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();//AllByorderid($orderId);

         $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=> $orderId])->first();//first',array('conditions'=>array('Invoiceorders.orderId'=>$orderId)));
         $invoiceid = $invoiceorders['invoiceid'];
         $invoices = $this->Invoices->find()->where(['invoiceid'=> $invoiceid])->first();//first',array('conditions'=>array('Invoices.invoiceid'=>$invoiceid)));
         $paymentmethod = $invoices['paymentmethod'];
         $this->set('paymentmethod',$paymentmethod);

         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shippingid])->first();//Byshippingid($shippingid);

         $sellerId = $this->Items->find()->where(['id'=> $orderItemModel[0]['itemid']])->first();//first',array('conditions'=>array('Item.id'=>$orderItemModel[0]['Order_items']['itemid'])));
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=>$orderModel['userid']])->first();
         $sellerModel = $this->Users->find()->where(['id'=>$sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);

         $tax = $orderModel['tax'];
         $admin_commission  = $orderModel['admin_commission'];
         $this->set('admin_commission',$admin_commission);
         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);

         $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderId])->where(['status' => 'purchased'])->first();
        $this->set('shareproducts',$shareproducts);

      //echo $discount_amount;die;

         $this->set('getcouponvalue',$getcouponvalue);
         $this->set('orderDetails',$orderModel);
         $this->set('orderItemModel',$orderItemModel);
         $this->set('orderCurrency',$orderCurrency);

         $this->set('userModel',$userModel);
         $this->set('sellerModel',$sellerModel);
         $this->set('shippingModel',$shippingModel);
         $this->set('discount_amount',$discount_amount);
         $this->set('tax',$tax);
         //die;
     }


     public function returnedorders()
     {
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Users');
       $this->loadModel('Orders');
       $this->loadModel('Order_items');
       $this->loadModel('Commissions');

       $usersTable = TableRegistry::get('Orders');
       $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
    ->where(['status' => 'Returned'])//conditions'=>array('NOT' => array('Orders.status' => array('Shipped','Delivered','Paid')))
    ->leftJoinWith('Users')
    ->group(['Orders.orderid'])
    ->autoFields(true);




         $commiDetails = $this->Commissions->find()->where(['active'=>1])->all();//all',array('conditions'=>array('Commission.active'=>'1')));

         if(!empty($getpayval)){
            foreach($getpayval as $key=>$pay){
               $orderIddd= $pay['orderid'];
         $orderitemModel = $this->Order_items->find()->where(['orderid'=> $orderIddd])->all();//all',array('conditions'=>array('orderid'=>$orderIddd)));
         $couponAmount  = 0;
         foreach ($orderitemModel as $orderItems){
           $couponAmount += $orderItems['discountAmount'];
       }

       $ordermerchant_id[] = $pay['merchant_id'];
       $order_status[$orderIddd] = $pay['status'];
       $order_total[$orderIddd] = $pay['totalcost']+ $pay['tax'];
       $order_discountamount[$orderIddd] = $couponAmount;
       $order_totalcost_ognl[$orderIddd] = $pay['totalcost'];
       $order_totalcostShipping_ognl[$orderIddd] = $pay['totalCostshipp'];
       $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];

       $order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['tax'] - $pay['admin_commission']-$couponAmount;
       $order_currency[$orderIddd] = $pay['currency'];


       $usernames1 = $this->Users->findById($pay['merchant_id'])->toArray();
       $usernames[$pay['merchant_id']] = $usernames1[0]['username_url'];
   }
}


$this->set('getitemuser',$getpayval);
$this->set('order_status',$order_status);
$this->set('order_total',$order_total);
$this->set('order_discountamount',$order_discountamount);
$this->set('order_totalcost',$order_totalcost);
$this->set('order_currency',$order_currency);
$this->set('order_totalcost_ognl',$order_totalcost_ognl);
$this->set('order_totalcostShipping_ognl',$order_totalcostShipping_ognl);
$this->set('usernames',$usernames);
}

public function viewreturnedorder($orderId) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');
   $this->loadModel('Trackdetails');


   $trackingModel = $this->Trackdetails->find()->where(['orderid'=> $orderId])->first();
   $this->set('trackingModel',$trackingModel);


         $orderModel = $this->Orders->find()->where(['orderid'=> $orderId])->first();//Byorderid($orderId);
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();//AllByorderid($orderId);

         $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=> $orderId])->first();
         $invoiceid = $invoiceorders['invoiceid'];
         $invoices = $this->Invoices->find()->where(['invoiceid'=> $invoiceid])->first();
         $paymentmethod = $invoices['paymentmethod'];
         $this->set('paymentmethod',$paymentmethod);

         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shippingid])->first();

         $sellerId = $this->Items->find()->where(['id'=> $orderItemModel[0]['itemid']])->first();
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=>$orderModel['userid']])->first();
         $sellerModel = $this->Users->find()->where(['id'=>$sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);

         $tax = $orderModel['tax'];

         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);


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



     function refundamount($oid,$type)
     {

       $this->autoRender = false;
       $this->loadModel('Orders');
       $this->loadModel('Users');
       $this->loadModel('Forexrates');
       $this->loadModel('Order_items');
       $this->loadModel('Shippingaddresses');
       $this->loadModel('Invoiceorders');
       $this->loadModel('Invoices');
       $this->loadModel('Sellercoupons');

       $orderid= $oid;

       $this->Orders->updateAll(array('status'=>'Refunded'),array('orderid'=>$orderid));
       $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=> $orderid])->first();
       $invoiceid = $invoiceorders['invoiceid'];
       $this->Invoices->updateAll(array('invoicestatus'=>'Refunded'),array('invoiceid'=>$invoiceid));

       $orderitemModel = $this->Order_items->find()->where(['orderid'=>$orderid])->all();
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

       $orderModel = $this->Orders->find()->where(['orderid'=>$orderid])->first();
       $sellercouponModel = $this->Sellercoupons->find()->where(['id'=>$orderModel['coupon_id']])->first();
       $remainRange = $sellercouponModel['remainrange']+1;
       $this->Sellercoupons->updateAll(array('remainrange'=>$remainRange),array('id'=>$orderModel['coupon_id']));

       $userid = $orderModel['userid'];
       $merchantid = $orderModel['merchant_id'];


       if($orderModel['tax'] == ""){
           $orderModel['tax'] = 0;
       }
       $coupon_amount=0;
       $orderitemModel = $this->Order_items->find()->where(['orderid'=>$orderModel['orderid']])->andWhere(['discountType'=>'Coupon Discount'])->all();
       foreach ($orderitemModel as $orderitemModels) {
        if($orderitemModels['discountType']=='Coupon Discount')

           $coupon_amount +=$orderitemModels['discountAmount'];
   }

   $today = time();
   $totalamt = $orderModel['totalcost'] + $orderModel['totalCostshipp'] + $orderModel['tax'] - $coupon_amount;

   $userid = $orderModel['userid'];
   $currencycode = $orderModel['currency'];
         $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencycode])->first();//',array('conditions'=>array('currency_code' => $currencycode)));
         $currencysymbol = $forexrateModel['currency_symbol'];
         $forexRate = $forexrateModel['price'];
         $userModel = $this->Users->find()->where(['id'=>$userid])->first();//first',array('conditions'=>array('User.id'=>$userid)));
         $credit_amt = $userModel['credit_total'];
         $totalreturnamt = $credit_amt + round(($totalamt / $forexRate),2);
         if($orderModel['deliverytype']!="cod"){

           $this->Users->updateAll(array('credit_total'=>$totalreturnamt),array('id'=>$userid));
           $refund_update = $this->Orders->find()->where(['orderid'=>$orderid])->first();
           $refund_update->refunded_amount = $totalamt;
           $refund_update->refunded_date = $today;
           $this->Orders->save($refund_update);
       }

       $buyeremail = $userModel['email'];

       $sellerdatas =   $userModel = $this->Users->find()->where(['id'=>$merchantid])->first();
       $selleremail = $sellerdatas['email'];

       $usershipping_addr = $this->Shippingaddresses->find()->where(['shippingid'=>$orderModel['shippingaddress']])->first();

       $logusername = 'Admin';
       $image['user']['image'] = 'usrimg.jpg';
       $image['user']['link'] = '';
       $loguserimage = json_encode($image);

       $notifymsg = __d('user',"Your account has been credited for the refund of the order")."-___-"."#".$orderid;
       $messages = __d('user',"Your account has been credited for the refund of the order")."-___-"."#".$orderid.' - '.$currencysymbol.$totalamt;

       if($type == 1)
       {
           $logdetails = $this->addlog('admin',0,$userid,$orderid,$notifymsg,$messages,$loguserimage);
           $userstable = TableRegistry::get('Users');
           $sellerdetails = $userstable->find()->where(['id'=>$userid])->first();
           $setngs = TableRegistry::get('sitesettings')->find('all')->first();

           $email=$sellerdetails['email'];
           $aSubject=$setngs['site_name'].__d('admin',' - Your Order Is Refunded ').'#'.$orderid;
           $aBody='';
           $template='refund';

           $setdata=array('name'=>$sellerdetail['first_name'],'setngs'=>$setngs,'itemname'=>$itemname,'tot_quantity'=>$totquantity,'sizeopt'=>$custmrsizeopt,'orderId'=>$orderid,'orderdate'=>$orderModel['orderdate'],'usershipping_addr'=>$usershipping_addr,'totalcost'=>$totalamt,'currencyCode'=>$currencysymbol);
           $this->sendmail($email,$aSubject,$aBody,$template,$setdata);

           if($this->isauthenticated()){
               $this->loadModel('Userdevices');
                //Push notification to buyer
               $devicestable = TableRegistry::get('Userdevices');
               $buyernotfiy = $devicestable->find()->where(['user_id'=>$userid])->first();

               $deviceTToken = $buyernotfiy->deviceToken;
               $deviceid = $buyernotfiy->deviceId;
               $userdeviceid = $buyernotfiy->id;
               $badge = $buyernotfiy->badge;
               $badge +=1;


               $this->Userdevices->updateAll(array('badge' =>$badge), array('deviceToken' => $deviceTToken), array('id' => $userdeviceid));

               if(isset($deviceTToken)){
                   $pushMessage['type'] = "admin_refund";
                   $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userid])->first();
                   I18n::locale($user_detail['languagecode']);
                   $pushMessage['message'] = __d('admin','Your account has been credited ').$currencysymbol.$totalamt.__d('admin',' by for refund of')." #".$orderid ;
                   $messages = json_encode($pushMessage);
                   $this->pushnot($deviceTToken,$messages,$badge);
               }
           }

       }
   }



   public function claimedorders()
   {
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Users');
       $this->loadModel('Orders');
       $this->loadModel('Order_items');
       $this->loadModel('Commissions');

       $usersTable = TableRegistry::get('Orders');
       $getpayval = $usersTable->find()->select(['merchant_id', 'Users.username' ])
       ->where(['status' => 'Claimed'])
       ->leftJoinWith('Users')
       ->group(['Orders.orderid'])
       ->autoFields(true)
       ->order(['status_date'=>'DESC']);




         $commiDetails = $this->Commissions->find()->where(['active'=>1])->all();//all',array('conditions'=>array('Commission.active'=>'1')));

         if(!empty($getpayval)){
            foreach($getpayval as $key=>$pay){
               $orderIddd= $pay['orderid'];
         $orderitemModel = $this->Order_items->find()->where(['orderid'=> $orderIddd])->all();//all',array('conditions'=>array('orderid'=>$orderIddd)));
         $couponAmount  = 0;
         foreach ($orderitemModel as $orderItems){
           $couponAmount += $orderItems['discountAmount'];
       }

       $ordermerchant_id[] = $pay['merchant_id'];
       $order_status[$orderIddd] = $pay['status'];
       $order_total[$orderIddd] = $pay['totalcost']+ $pay['tax']+$pay['totalCostshipp'];
       $order_discountamount[$orderIddd] = $couponAmount;
       $order_totalcost_ognl[$orderIddd] = $pay['totalcost'];
       $order_totalcostShipping_ognl[$orderIddd] = $pay['totalCostshipp'];
       $totcostreduceShip = $pay['totalcost'] - $pay['totalCostshipp'];

       $order_totalcost[$orderIddd] = $pay['totalcost'] + $pay['tax'] + $pay['totalCostshipp'] - $pay['admin_commission']-$couponAmount;
       $order_currency[$orderIddd] = $pay['currency'];


       $usernames1 = $this->Users->findById($pay['merchant_id'])->toArray();
       $usernames[$pay['merchant_id']] = $usernames1[0]['username_url'];
   }
}


$this->set('getitemuser',$getpayval);
$this->set('order_status',$order_status);
$this->set('order_total',$order_total);
$this->set('order_discountamount',$order_discountamount);
$this->set('order_totalcost',$order_totalcost);
$this->set('order_currency',$order_currency);
$this->set('order_totalcost_ognl',$order_totalcost_ognl);
$this->set('order_totalcostShipping_ognl',$order_totalcostShipping_ognl);
$this->set('usernames',$usernames);
}


public function viewclaimedorder($orderId) {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Invoices');
   $this->loadModel('Orders');
   $this->loadModel('Users');
   $this->loadModel('Order_items');
   $this->loadModel('Invoiceorders');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Coupons');
   $this->loadModel('Trackdetails');


   $trackingModel = $this->Trackdetails->find()->where(['orderid'=> $orderId])->first();
   $this->set('trackingModel',$trackingModel);


         $orderModel = $this->Orders->find()->where(['orderid'=> $orderId])->first();//Byorderid($orderId);
         $orderItemModel = $this->Order_items->find()->where(['orderid'=> $orderId])->toArray();//AllByorderid($orderId);

         $invoiceorders = $this->Invoiceorders->find()->where(['orderid'=> $orderId])->first();//first',array('conditions'=>array('Invoiceorders.orderId'=>$orderId)));
         $invoiceid = $invoiceorders['invoiceid'];
         $invoices = $this->Invoices->find()->where(['invoiceid'=> $invoiceid])->first();//first',array('conditions'=>array('Invoices.invoiceid'=>$invoiceid)));
         $paymentmethod = $invoices['paymentmethod'];
         $this->set('paymentmethod',$paymentmethod);

         $shippingid = $orderModel['shippingaddress'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shippingid])->first();//Byshippingid($shippingid);

         $sellerId = $this->Items->find()->where(['id'=> $orderItemModel[0]['itemid']])->first();//first',array('conditions'=>array('Item.id'=>$orderItemModel[0]['Order_items']['itemid'])));
         $sellerId = $sellerId['user_id'];

         $userModel = $this->Users->find()->where(['id'=>$orderModel['userid']])->first();
         $sellerModel = $this->Users->find()->where(['id'=>$sellerId])->first();

         $coupon_id  = $orderModel['coupon_id'];

         $discount_amount  = $orderModel['discount_amount'];

         $orderCurrency = $orderModel['currency'];

         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=> $orderCurrency])->first();
         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('currencySymbol',$currencySymbol);

         $tax = $orderModel['tax'];

         $getcouponvalue = $this->Coupons->find()->where(['id'=> $coupon_id])->first();
         $this->set('getcouponvalue',$getcouponvalue);

      //echo $discount_amount;die;

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


     function solveorder($oid = NULL)
     {
       $this->autoLayout = false;
       $this->autoRender = false;
       $this->loadModel('Orders');


       $this->Orders->updateAll(array('status'=>"Shipped"),array('orderid'=>$oid));
   }

   function adminCheckoutBraintree ()
   {

      include_once( WWW_ROOT . 'braintree/lib/Braintree.php' );

      $this->autoRender = false;
      global $loguser;
      global $user_level;
      global $setngs;
      global $paypalAdaptive;
      $siteChanges = $setngs['site_changes'];
      $siteChanges = json_decode($siteChanges,true);

      $totalprice = $_POST['totalPrice'];
      $currency = $_POST['currency'];
      $username = $_POST['username'];
      $orderid = $_POST['orderid'];

      $this->loadModel('Orders');
      $this->loadModel('Order_items');
      $this->loadModel('Users');$this->loadModel('Shippingaddresses');

      $this->loadModel('Forexrates');
      $sitesettingstable = TableRegistry::get('Sitesettings');
      $setngs = $sitesettingstable->find()->where(['id'=>1])->first();

      $orderstable = TableRegistry::get('Orders');
      $userstable = TableRegistry::get('Users');
      $shopstable = TableRegistry::get('Shops');
      $orderModel = $orderstable->find()->where(['orderid'=>$orderid])->first();
      //echo "<pre>"; print_r($orderModel); die;
      $sellerId = $orderModel['merchant_id'];
      $sellerModel = $userstable->find()->where(['Users.id'=>$sellerId])->first();
      $forexrateModel = $this->Forexrates->find()->where(['currency_code'=>$orderModel['currency']])->first();
      $currencysymbol = $forexrateModel['currency_symbol'];
       $shopModel = $shopstable->find()->where(['user_id'=>$sellerId])->first();

   $params = array(
     "testmode" => $shopModel['braintree_type'],
     "merchantid" => $shopModel['merchant_id'],
     "publickey" =>   $shopModel['braintree_publickey'],
     "privatekey" => $shopModel['braintree_privatekey'],
 );

   if ($params['testmode'] == "sandbox"){
    \Braintree_Configuration::environment('sandbox');
}
else{
    \Braintree_Configuration::environment('production');
}


\Braintree_Configuration::merchantId($params["merchantid"]);
\Braintree_Configuration::publicKey($params["publickey"]);
\Braintree_Configuration::privateKey($params["privatekey"]);


        //$price = $_POST['totalPrice'];
$firstname = $_POST['card_name'];
$card_number = $_POST['card_number'];
$cvv         = $_POST['cvv'];
$month        = $_POST['expiry_month'];
$year         = $_POST['expiry_year'];
$expirationDate =$month.'/'.$year;

$result = \Braintree_Transaction::sale([
  'amount' => $totalprice,
  'merchantAccountId' => $shopModel['braintree_id'],
  'creditCard' => [
      'number' => $card_number,
      'cardholderName' => $firstname,
      'expirationDate' => $expirationDate,
      'cvv' => $cvv
  ],
  'options' => [
    'submitForSettlement' => True,

]
]);
$statusDate = time();
//print_r($result);exit;
if ($result->success == '1') {

   $seller_txnid = $result->transaction->id;
   $orderquery = $orderstable->query();
   $orderquery->update()
   ->set(['status'=>"Paid"])
   ->set(['status_date'=>$statusDate])
   ->set(['seller_txnid'=>$seller_txnid])
   ->where(['orderid'=>$orderid])
   ->execute();



   /* * Update the Affiliate Product Share commission save to Sharing person * */
            $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['order_id' => $orderid])->where(['status' => 'purchased'])->all();
            if(!empty($shareproducts)){
                foreach($shareproducts as $sharepdt) {
                    $sharepdtid = $sharepdt['item_id'];
                    //if(in_array($sharepdtid, $itemmailids)) {

                 $itemModel = TableRegistry::get('Items')->find()->where(['id' => $sharepdtid])->first();
                 
                 $orderitemModel = TableRegistry::get('Order_items')->find('all')->where(['orderid' => $orderid])->first();
                 // $ordersize = $orderitemModel->item_size;
                 //    if ($ordersize != "" && $ordersize != 0) {
                 //         $product_store = json_decode($itemModel['size_options'], true);

                         
                 //     if(in_array($ordersize,$product_store['size']))
                 //     {
                 //          $itemprice = $product_store['price'][$ordersize];
                           
                 //     }
                 //    } else {
                 //        $itemprice = $itemModel->price;
                 //    }

                    $itemprice = $orderitemModel->itemprice; //quantity based price
                    $affiliatecommission = $itemModel->affiliate_commission;
                    $commission_amount =  $itemprice * $affiliatecommission / 100;

                    $sharedquery = TableRegistry::get('Shareproducts')->query();
                    $shareduserquery = TableRegistry::get('Users')->query();
                    $sharedquery->update()->set(['status' => 'paid'])
                    ->where(['order_id' => $orderid])->where(['item_id' => $sharepdtid])->where(['status' => 'purchased'])->execute();

                    $usercredit_amt = TableRegistry::get('Users')->find()->where(['id' => $sharepdt['sender_id']])->first();
                    $total_credited_amount = $usercredit_amt['credit_total'];
                    $total_credited_amount = $total_credited_amount + $commission_amount;

                    $shareduserquery->update()->set(['credit_total' => $total_credited_amount])
                    ->where(['id' => $sharepdt['sender_id']])->execute();
                  //  }
                }
            }
            /* * End Update the Affiliate Product Share commission save to Sharing person * */

   $orderitemModel = $this->Order_items->find()->where(['orderid'=>$orderid])->all();
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

         $orderModel = $this->Orders->find()->where(['orderid'=>$orderid])->first();//',array('conditions'=>array('Orders.orderid'=>$orderid)));

         $userid = $orderModel['userid'];
         $merchantid = $orderModel['merchant_id'];


         if($orderModel['tax'] == ""){
           $orderModel['tax'] = 0;
       }
       $totalamt = $orderModel['totalcost'] + $orderModel['tax'];

       $userid = $orderModel['userid'];
       $currencycode = $orderModel['currency'];
         $forexrateModel = $this->Forexrates->find()->where(['currency_code' => $currencycode])->first();//',array('conditions'=>array('currency_code' => $currencycode)));
         $currencysymbol = $forexrateModel['currency_symbol'];
         $forexRate = $forexrateModel['price'];
         $userModel = $this->Users->find()->where(['id'=>$userid])->first();//first',array('conditions'=>array('User.id'=>$userid)));


         $userModel = $this->Users->find()->where(['id'=>$userid])->first();
         $buyeremail = $userModel['email'];

         $sellerdatas =   $this->Users->find()->where(['id'=>$merchantid])->first();
         $selleremail = $sellerdatas['email'];

         $usershipping_addr = $this->Shippingaddresses->find()->where(['shippingid'=>$orderModel['shippingaddress']])->first();


         $logusername = 'Admin';
         $image['user']['image'] = 'usrimg.jpg';
         $image['user']['link'] = '';
         $loguserimage = json_encode($image);
         $setngs = TableRegistry::get('sitesettings')->find('all')->first();
         $notifymsg = __d('user',"Your account has been credited for the order")."-___-"."#".$orderid.' - '.$currencysymbol.$totalprice;
         $messages = __d('user',"Your account has been credited for the order")."-___-"."#".$orderid.' - '.$currencysymbol.$totalprice;

         $logdetails = $this->addloglive('admin',0,$merchantid,$orderid,$notifymsg,$messages,$loguserimage);

         $userstable = TableRegistry::get('Users');
         $sellerdetails = $userstable->find()->where(['id'=>$merchantid])->first();
         $setngs = TableRegistry::get('sitesettings')->find('all')->first();

         $email=$sellerdatas['email'];
         $aSubject=$setngs['site_name'].__d('admin',' - Your Order Is Approved').'#'.$orderid;
         $aBody='';
         $template='confirm';

         $setdata=array('name'=>$sellerdatas['first_name'],'setngs'=>$setngs,'itemname'=>$itemname,'tot_quantity'=>$totquantity,'sizeopt'=>$custmrsizeopt,'orderid'=>$orderid,'orderId'=>$orderid,'orderdate'=>$orderModel['orderdate'],'usershipping_addr'=>$usershipping_addr,'totalcost'=>$orderModel['totalcost'],'currencyCode'=>$currencysymbol,'buyername'=>$userModel['first_name']);
         $this->sendmail($email,$aSubject,$aBody,$template,$setdata);



   // if($this->isauthorized()){
         $this->loadModel('Userdevices');
        //Push notification to seller
         $devicestable = TableRegistry::get('Userdevices');
         $sellernotify = $devicestable->find()->where(['user_id'=>$merchantid])->first();

         $deviceTToken = $sellernotify->deviceToken;
         $deviceid = $sellernotify->deviceId;
         $userdeviceid = $sellernotify->id;
         $badge = $sellernotify->badge;
         $badge +=1;

         $messages = __d('admin','Your account has been credited').$currencysymbol.$totalprice." by ".$setngs['site_name']." of #".$orderid ;

         $this->Userdevices->updateAll(array('badge' =>$badge), array('deviceToken' => $deviceTToken), array('id' => $userdeviceid));

         if(isset($deviceTToken)){
         }
    // }

         $this->redirect('/approvedorders');

     }
     else
     {
       $this->Flash->error($result->message);
       $this->redirect('/deliveredorders');
   }

}


public function merchantpaymentexport () {
   $this->viewBuilder()->enableAutoLayout();
   $this->autoRender = false;
   $this->loadModel('Users');
   $this->loadModel('Coupons');
   $this->loadModel('Shippingaddresses');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   if($this->request->is('post')){

       $this->loadModel('Orders');
       $sdate=strtotime($this->request->data('start'));
       $edate=strtotime($this->request->data('end'));

       $order_status = $this->request->data('status');

       if($order_status=="" || $order_status=="Pending" || $order_status=="Processing")
       {

        if($order_status=="")
           $order_status = "Pending";
       if(!empty($sdate) && !empty($edate))
       {
           $startdate = date('Y-m-d 24:00:00',$sdate);
           $enddate = date('Y-m-d 24:00:00',$edate);
           $startdate = strtotime($startdate);
           $enddate = strtotime($enddate);
           if($sdate==$edate)
           {
               $startdate = date('Y-m-d 00:00:00',$sdate);
               $enddate = date('Y-m-d 24:00:00',$edate);
               $startdate = strtotime($startdate);
               $enddate = strtotime($enddate);
           }

           if($order_status=="Pending"){

               $data = $this->Orders->find()->where(['status'=>$order_status,['status'=>'']])->andWhere(['orderdate BETWEEN ? AND ?' =>array($startdate,$enddate)])->toArray();
               echo "<pre>"; print_r($data); die;}
               else{

                   $data = $this->Orders->find()->where([array('conditions' => array('Orders.status' => $order_status ,'Orders.orderdate BETWEEN ? AND ?' =>array($startdate,$enddate)))])->toArray();
                   echo "<pre>"; print_r($data); die;}
               }
               else
               {
                if($order_status=="Pending")

                    $data = $this->Orders->find()->where(['status'=>$order_status,['status'=>'']])->toArray();

                else
                   $data = $this->Orders->find()->where(['status'=>$order_status])->toArray();
           }
       }
       else if($order_status=="Shipped" || $order_status=="Delivered" || $order_status=="Returned" || $order_status=="Claimed" || $order_status=="Paid")
       {
        if(!empty($sdate) && !empty($edate))
        {
           $startdate = date('Y-m-d 24:00:00',$sdate);
           $enddate = date('Y-m-d 24:00:00',$edate);
           $startdate = strtotime($startdate);
           $enddate = strtotime($enddate);

           $data = $this->Orders->find()->where(['status'=>$order_status])->andWhere(['orderdate BETWEEN ? AND ?' =>array($startdate,$enddate)])->toArray();
       }
       else
       {
           $data = $this->Orders->find()->where(['status'=>$order_status])->toArray();
       }
   }
   $i = 0;
   foreach($data as $datas)
   {
       $data[$i]['orderdate'] = date('Y-m-d',$datas['orderdate']);
       if($datas['status_date']!="" && $datas['status_date']!='0')
           $data[$i]['status_date'] = date('Y-m-d',$datas['status_date']);
       else
           $data[$i]['status_date'] = $datas['status_date'];
       if($datas['deliver_date']!="" && $datas['deliver_date']!='0')
           $data[$i]['deliver_date'] = date('Y-m-d',$datas['deliver_date']);
       else
           $data[$i]['deliver_date'] = $datas['deliver_date'];

       $orderuserid = $datas['userid'];
         $orderusermodel = $this->Users->find()->where(['id'=> $orderuserid])->first();//ById($orderuserid);
         $orderusername = $orderusermodel['username'];

         $ordermerchantid = $datas['merchant_id'];
         $ordermerchantmodel = $this->Users->find()->where(['id'=> $ordermerchantid])->first();
         $ordermerchantname = $ordermerchantmodel['username'];

         $ordershipid = $datas['shippingaddress'];
         $ordershipaddr = $this->Shippingaddresses->find()->where(['shippingid'=> $ordershipid])->first();
         $shipaddr = $ordershipaddr['nickname'].','.$ordershipaddr['name'].','.
         $ordershipaddr['address1'].','.$ordershipaddr['address2'].','.
         $ordershipaddr['city'].','.$ordershipaddr['state'].','.
         $ordershipaddr['country'].','.$ordershipaddr['zipcode'].','.
         $ordershipaddr['phone'];

         $couponid = $datas['coupon_id'];
         $coupondata = $this->Coupons->find()->where(['id'=> $couponid])->first();
         $couponcode = $coupondata['couponcode'];

         $export[$i]['Orderid'] = $datas['orderid'];
         $export[$i]['Buyer'] = $orderusername;
         $export[$i]['Seller'] = $ordermerchantname;
         $export[$i]['Totalcost'] = $datas['totalcost'];
         $export[$i]['Totalshippcost'] = $datas['totalCostshipp'];
         $export[$i]['Orderdate'] = date('Y-m-d',$datas['orderdate']);
         if($datas['status']=="Paid")
         {
           $export[$i]['TransactionId'] = $datas['seller_txnid'];
       }
       $export[$i]['Shippingaddress'] = $shipaddr;
       if($couponcode=="")
           $export[$i]['Couponcode'] = "NIL";
       else
           $export[$i]['Couponcode'] = $couponcode;
       if($datas['discount_amount']=="")
           $export[$i]['Discountamount'] = "NIL";
       else
           $export[$i]['Discountamount'] = $datas['discount_amount'];
       $export[$i]['Currency'] = $datas['currency'];
       $export[$i]['Admincommission'] = $datas['admin_commission'];
       if($datas['status']=="")
           $export[$i]['Status'] = "Pending";
       else
           $export[$i]['Status'] = $datas['status'];
       if($datas['Orders']['status_date']!="" && $datas['status_date']!='0')
           $export[$i]['Statusdate'] = date('Y-m-d',$datas['status_date']);
       else
           $export[$i]['Statusdate'] = $datas['status_date'];
       if($datas['deliver_date']!="" && $datas['deliver_date']!='0')
           $export[$i]['Deliverdate'] = date('Y-m-d',$datas['deliver_date']);
       else if($datas['deliver_date']=="" || $datas['deliver_date']=='0')
           $export[$i]['Deliverdate'] = "NIL";
       else
           $export[$i]['Deliverdate'] = $datas['deliver_date'];

       $i++;
   }
    if(!empty($export))// && $sdate!="" && $edate!="")
    $this->Export->exportCsv($export, 'orders.csv');
    else
    {
       $this->Flash->error(__d('admin','No Orders Found'));
       $this->redirect('/admin/merchant_payment');
   }
}
}



public function addcategory(){


   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Categories');
   $category_datas= $this->Categories->newEntity();
   if(!empty($this->request->data)){
       $categoryname = $this->request->data('categoryname');
       $categoryname2 = $this->request->data('categoryname_2');
       $categortype = $this->request->data('categories');
       if(empty($this->request->data('categories'))){
           $cats_data = $this->Categories->find()->where(['category_name'=>trim($categoryname)])->andWhere(['category_parent'=>0])->all();
       }else{
           $mainCatId = $this->request->data('categories');


           $cats_data = $this->Categories->find()->where(['category_name'=>trim($categoryname)])->andWhere(['category_parent'=>$mainCatId])->all();
       }
       if(trim($categoryname) == ''){
           $this->Flash->error(__d('admin','Please Enter Category Name'));
           $this->redirect('/addcategory');
       }
       if(count($cats_data) > 0){
           $this->Flash->error(__d('admin','Category name Already Exists try another.'));
           $this->redirect('/addcategory');
       }else{
       
           $category_datas->category_name= $this->request->data('categoryname');
          // $category_datas->category_image=$this->request->data('categoryImage');
          $category_datas->category_webimage=$this->request->data('category_webimage');
          $category_datas->category_webicon=$this->request->data('category_webicon');
           $category_datas->category_urlname = $this->Urlfriendly->utils_makeUrlFriendly($categoryname);
           if(empty($this->request->data('categories'))){
               $category_datas->category_parent=0;
           }else{
               $category_datas->category_parent = $this->request->data('categories');
           }

           $category_datas->created_by = $_SESSION['Auth']['Admin']['id'];
           $category_datas->created_at = date('Y-m-d H:i:s');
           $this->Categories->save($category_datas);
           $ids = $category_datas->id;

           if(!empty($this->request->data('categoryname_2'))){
            if(trim($categoryname2) == ''){
               $this->Flash->error(__d('admin','Please Enter Sub Category Name'));
               $this->redirect('/addcategory');
           }

           $catnme =  $category_datas->category_name = $this->request->data('categoryname_2');
           $category_datas->category_urlname = $this->Urlfriendly->utils_makeUrlFriendly($categoryname2);

           $category_datas->category_parent = $this->request->data('categories');
           $category_datas->category_sub_parent = $ids;

           $category_datas->created_by = $_SESSION['Auth']['Admin']['id'];

           $category_datas->created_at = date('Y-m-d H:i:s');
          // echo"<pre>";print_r($category_datas);die;
           $this->Category->save($category_datas);
       }
   }
   $this->Flash->success(__d('admin','Successfully added'));
   $this->redirect('/viewcategory');
}else{
         $mainsec = $this->Categories->find()->where(['category_parent'=>0])->all();//all',array('conditions'=>array('category_parent'=>0)));
         $this->set('mainsec',$mainsec);
     }
 }
 public function editcategory($id = null){
  //echo"<pre>";print_r($_POST);die;
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Categories');
   $mainsunprnts = array();
   $category_datas= $this->Categories->newEntity();
   $split = explode('~',$id);

   $mainsec_prnts = $this->Categories->find()->where(['category_parent'=>0])->andWhere(['category_sub_parent'=>0])->all();

   $mainsec = $this->Categories->find()->where(['id' => $split[0]])->andWhere(['category_urlname'=> $split[1]])->toArray();
   if(empty($mainsec)){
       // echo "here<pre>".print_r($mainsec);die;
       $this->Flash->error(__d('admin','No Category found for this url'));
       $this->redirect('/viewcategory');
   }

   if(!empty($mainsec)){
       $ctgry_subprnt = $mainsec[0]['category_sub_parent'];
       $mainsunprnts = $this->Categories->find()->where(['id'=>$ctgry_subprnt])->toArray();
   }
   $this->set('mainsec',$mainsec);
   $this->set('mainsec_prnts',$mainsec_prnts);
   $this->set('mainsunprnts',$mainsunprnts);

   if(!empty($this->request->data)){
       $categexist = $this->Categories->find()->where(['category_parent'=>0])->andWhere(['category_name'=>trim($this->request->data('categoryname'))])->all();

       if(count($categexist)<=0)
       {
            //echo "stupid<pre>".print_r($categexist);die;
           $this->Flash->error(__d('admin','No Category found for this url'));
           $this->redirect('/viewcategory');
       }

       $cats_data = $cats_sub_data = 0;
       if($this->request->data('disabled') == 'no'){
           $categoryname = $this->request->data('categoryname');
           $cats_data1 = $this->Categories->find()->where(['category_name'=>trim($categoryname)])->andWhere(['category_parent'=>$this->request->data('categories')])->all();
           $cats_data = count($cats_data1);
       }
       if(!empty($this->request->data('categoryname_2'))){
           $cat_sub_par_id = $this->request->data('subparid');
           if ($cat_sub_par_id == 0){

               $cats_sub_data = $this->Categories->find()->where(['category_name'=>$this->request->data('categoryname_2'),'category_sub_parent'=>$this->request->data('secid')])->andWhere(['category_parent'=>$this->request->data('categories')])->all();
           }else{

               $cats_sub_data = $this->Categories->find()->where(['category_name'=>$this->request->data('categoryname_2'),'category_sub_parent'=>$this->request->data('subparid') ])->andWhere(['category_parent'=>$this->request->data('categories')])->all();

           }
       }

       if($this->request->data('disabled') == 'no' && $cats_data == 0){

           $category_datas->id=$this->request->data('secid');
           $category_datas->category_name=$this->request->data('categoryname');
           $category_datas->category_webimage=$this->request->data('category_webimage');
           $category_datas->category_webicon=$this->request->data('category_webicon');

           if(empty($this->request->data('categories'))){
               $category_datas->category_parent=0;
           }else{
               $category_datas->category_parent=$this->request->data('categories');
           }

           $category_datas->created_by = $_SESSION['Auth']['Admin']['id'];

           $category_datas->created_at = date('Y-m-d H:i:s');

           $category_datas->category_urlname = $this->Urlfriendly->utils_makeUrlFriendly($this->request->data('categoryname'));
           $this->Categories->save($category_datas);
           $ids = $this->request->data('secid');
       }else{
           $ids = $mainsec[0]['category_sub_parent'];
       }
       if(!empty($this->request->data('categoryname_2'))){

        if($this->request->data('disabled') == 'yes'){
           $category_datas->id = $this->request->data('secid');
       }else{
           $category_datas->id = '';
       }
       $category_datas->category_name = $this->request->data('categoryname_2');
       $category_datas->category_parent =$this->request->data('categories');

       if ($cat_sub_par_id == 0){
           $category_datas->category_sub_parent = $this->request->data('secid');
       }else{
           $category_datas->category_sub_parent = $this->request->data('subparid');
       }

       $category_datas->created_by = $_SESSION['Auth']['Admin']['id'];

       $category_datas->created_at = date('Y-m-d H:i:s');
       $category_datas->category_urlname = $this->Urlfriendly->utils_makeUrlFriendly($this->request->data('categoryname_2'));
       $this->Categories->save($category_datas);
   }

        // die;
   $this->Flash->success(__d('admin','Successfully Updated'));
   $this->redirect('/viewcategory');
}
$this->set('id',$id);
$category_detail = $this->Categories->find()->where(['id'=>$id])->first();
$categoryImage = $category_detail['category_image'];
$category_webicon = $category_detail['category_webicon'];
$category_webimage = $category_detail['category_webimage'];

$this->set('category_webicon',$category_webicon);
$this->set('category_webimage',$category_webimage);

// $this->set('sliderImage',$categoryImage);
}


public function shareditems(){
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');

   $this->loadModel('Items');
   $item_datas = $this->Items->find()->where(['status' => 'things'])->order(['modified_on' => 'DESC'])->all();
   $this->set('item_datas',$item_datas);
   $this->set('pagecount',$pagecount);
}

public function deleteitem ($itemId = null) {

   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Photos');
   $this->loadModel('Shipings');
   $this->loadModel('Itemfavs');
   $this->loadModel('Comments');
   $this->loadModel('Logs');
   $this->loadModel('Users');
   $this->loadModel('Shops');
   $this->loadModel('Contactsellers');
   $this->loadModel('Contactsellermsgs');
   $this->loadModel('Wantownits');
   $this->loadModel('Carts');
   $this->loadModel('Items');
   $setngs = $this->Sitesettings->find()->toArray();
   $this->set('setngs',$setngs);

   $_SESSION['site_url'] = SITE_URL;
   $_SESSION['media_url'] = SITE_URL;
   if (!empty($setngs[0]['media_url'])) {
       $_SESSION['media_host_name'] = $setngs[0]['media_server_hostname'];
       $_SESSION['media_url'] = $setngs[0]['media_url'];
       $_SESSION['media_server_username'] = $setngs[0]['media_server_username'];
       $_SESSION['media_server_password'] = $setngs[0]['media_server_password'];
   }


   if($itemId != null) {
         $fileName = $this->Photos->find()->where(['item_id'=> $itemId])->all();//all',array('conditions'=>array('item_id'=>$itemId)));

         $original = true;$thumb70 = true;$thumb150 = true;$thumb350 = true;
         if ($_SESSION['media_url'] == SITE_URL) {
          foreach ($fileName as $name) {
           $fname = $name['image_name'];
           if ($original == true && $thumb70 == true && $thumb150 == true && $thumb350 == true ) {
               $original = unlink(WWW_ROOT.'media/items/original/'.$fname);
               $thumb70 = unlink(WWW_ROOT.'media/items/thumb70/'.$fname);
               $thumb150 = unlink(WWW_ROOT.'media/items/thumb150/'.$fname);
               $thumb350 = unlink(WWW_ROOT.'media/items/thumb350/'.$fname);
           } else {
               echo 'false';

           }
       }
   }else {
      foreach ($fileName as $name) {
       $fname = $name['image_name'];
       if ($original == true && $thumb70 == true && $thumb150 == true && $thumb350 == true ) {
           $original = unlink(WWW_ROOT.'media/items/original/'.$fname);
           $thumb70 = unlink(WWW_ROOT.'media/items/thumb70/'.$fname);
           $thumb150 = unlink(WWW_ROOT.'media/items/thumb150/'.$fname);
           $thumb350 = unlink(WWW_ROOT.'media/items/thumb350/'.$fname);
       } else {
          echo 'false';

      }
  }
}



         $item_user = $this->Items->find()->where(['id'=> $itemId])->toArray();//all',array('conditions'=>array('Item.id'=>$itemId)));
         $user_id = $item_user[0]['user_id'];
         $item_title = $item_user[0]['item_title'];
         $item_url = $item_user[0]['item_title_url'];

         $this->Items->deleteAll(array('Items.id' => $itemId), false);
         $this->Carts->deleteAll(array('Carts.item_id' => $itemId), false);
         $this->Logs->deleteAll(array('Logs.itemid' => $itemId), false);
         $this->Logs->deleteAll(array('Logs.sourceid' => $itemId), false);
         $this->Photos->deleteAll(array('Photos.item_id' => $itemId), false);
         $this->Shipings->deleteAll(array('Shipings.item_id' => $itemId), false);
         $this->Itemfavs->deleteAll(array('item_id' => $itemId), false);
         $this->Comments->deleteAll(array('item_id' => $itemId), false);
         $this->Logs->deleteAll(array('Logs.notification_id' => $itemId), false);

         $this->Wantownits->deleteAll(array('Wantownits.itemid' => $itemId),false);
         $itemcount = $this->Items->find()->where(['user_id'=> $user_id])->andWhere(['status'=>'publish'])->count();
         $this->Shops->updateAll(array('item_count' => "$itemcount'"), array('user_id' => $userId));

         $contactsellerModel = $this->Contactsellers->find()->where(['itemid'=> $itemId])->all();
         foreach ($contactsellerModel as $contactseller){
           $csid = $contactseller['id'];
           $this->Contactsellers->deleteAll(array('Contactsellers.id' => $csid),false);
           $this->Contactsellermsgs->deleteAll(array('Contactsellermsgs.contactsellerid' => $csid),false);
       }
   }
}

public function searchaffiliate () {
    if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Items');


   $startdate =$_POST['startdate'];
   $enddate = $_POST['enddate'];

   if(!empty($startdate) && !empty($enddate)){
       $startdate = date("Y-m-d", strtotime($startdate));
       $enddate =  date("Y-m-d", strtotime($enddate));


       $itemDetss=$this->Items->find('all', array(
        'conditions' => array(

            'created_on >=' => $startdate,
            'created_on <=' => $enddate . ' 23:59:59',
            'status' => 'things'
        )));

   }else{
       $itemDetss = $this->Items->find()->where(['status' => 'things'])->order(['id' => 'DESC'])->all();
   }

   $this->set('item_datas',$itemDetss);
}


function deleteaffiliateitems($items = NULL){

    if(!($this->isauthenticated()))
       $this->redirect('/');

   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Items');
   $this->loadModel('Photos');
   $this->loadModel('Shipings');
   $this->loadModel('Itemfavs');
   $this->loadModel('Comments');
   $this->loadModel('Logs');
   $this->loadModel('Users');
   $this->loadModel('Shops');
   $this->loadModel('Contactsellers');
   $this->loadModel('Contactsellermsgs');
   $this->loadModel('Wantownits');
   $this->loadModel('Carts');
//$i=0; $i

   $itemsarray = explode(',', $items);

   $this->Items->deleteAll(['id IN' => $itemsarray], false);


   $this->Carts->deleteAll(['item_id IN' => $itemsarray], false);
   $this->Logs->deleteAll(['itemid IN ' => $itemsarray], false);
   $this->Logs->deleteAll(['sourceid IN' => $itemsarray], false);
   $this->Photos->deleteAll(['item_id IN'=> $itemsarray], false);
   $this->Itemfavs->deleteAll(['item_id IN' => $itemsarray], false);
   $this->Comments->deleteAll(['item_id IN'=> $itemsarray], false);
   $this->Logs->deleteAll(['notification_id IN'=> $itemsarray], false);

   $this->Wantownits->deleteAll(['itemid IN'=> $itemsarray], false);

         $contactsellerModel = $this->Contactsellers->find()->where(['itemid IN'=> $itemsarray])->all();//all',array('conditions'=>array('itemid'=>
            //$itemId)));
         foreach ($contactsellerModel as $contactseller){
           $csid = $contactseller['id'];
           $this->Contactsellers->deleteAll(array('Contactsellers.id' => $csid),false);
           $this->Contactsellermsgs->deleteAll(array('Contactsellermsgs.contactsellerid' => $csid),false);
       }

       $userModel = $this->Items->find()->where(['id IN'=>$itemsarray])->all();
       foreach ($userModel as $users){
           $userId = $users['user_id'];

         $itemcount = $this->Items->find()->where(['Items.user_id'=> $userId])->andWhere(['Items.status'=> 'publish'])->count();//count',array('conditions'=>array('Item.user_id'=>$userId,'Item.status'=>'publish')));
         $this->Shops->updateAll(array('item_count' =>$itemcount), array('user_id' => $userId));
     }


 }


 public function reportitems()
 {
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');

   $this->loadModel('Items');
   $item_datas = $this->Items->find()->where(['report_flag <>'=>''])->order(['id' => 'DESC'])->all();
   $this->set('item_datas',$item_datas);
   $this->set('pagecount',$pagecount);
}

function ignorereportitem($itemId)
{
   $this->viewBuilder()->enableAutoLayout();
   $this->autoRender = false;

   $this->loadModel('Items');
   if(!($this->isauthenticated()))
       $this->redirect('/');

   $this->Items->updateAll(array('status' => "publish",'report_flag' => " "), array('id' => $itemId));

}

function changereportitemstatus($itemId)
{
   $this->viewBuilder()->enableAutoLayout();
   $this->autoRender = false;
   $this->loadModel('Shops');
   $this->loadModel('Items');
   if(!($this->isauthenticated()))
       $this->redirect('/');

   $this->Items->updateAll(array('status' => "draft",'report_flag' => " "), array('id' => $itemId));


   $userModel = $this->Items->find()->where(['id'=>$itemId])->toArray();
   $userId = $userModel[0]['user_id'];

         $itemcount = $this->Items->find()->where(['Items.user_id'=> $userId])->andWhere(['Items.status'=> 'publish'])->count();//count',array('conditions'=>array('Item.user_id'=>$userId,'Item.status'=>'publish')));
         $this->Shops->updateAll(array('item_count' =>$itemcount), array('user_id' => $userId));


     }



     public function searchreport () {
        if(!$this->isauthenticated())
           $this->redirect('/');
       $this->loadModel('Items');


       $startdate =$_POST['startdate'];
       $enddate = $_POST['enddate'];

       if(!empty($startdate) && !empty($enddate)){
           $startdate = date("Y-m-d", strtotime($startdate));
           $enddate =  date("Y-m-d", strtotime($enddate));


           $itemDetss=$this->Items->find('all', array(
            'conditions' => array(

                'created_on >=' => $startdate,
                'created_on <=' => $enddate . ' 23:59:59',
                'report_flag <>' => ""
            )));

       }else{
           $itemDetss = $this->Items->find()->where(['report_flag <>' => ""])->order(['id' => 'DESC'])->all();
       }

       $this->set('item_datas',$itemDetss);


   }

   public function nonapproveditems(){
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');

       $this->loadModel('Items');
       $this->loadModel('Users');

       $itemsTable = TableRegistry::get('Items');
       $item_datas=$itemsTable->find('all')
       ->contain(['Users'])
       ->where(['Items.status' => 'draft'])
       ->order(['Items.modified_on' => 'DESC']);

       $this->set('item_datas',$item_datas);
       $this->set('pagecount',$pagecount);
   }



   public function srchnonapproveditems () {
    if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Items');


   $startdate =$_POST['startdate'];
   $enddate = $_POST['enddate'];

   if(!empty($startdate) && !empty($enddate)){
       $startdate = date("Y-m-d", strtotime($startdate));
       $enddate =  date("Y-m-d", strtotime($enddate));


       $itemDetss=$this->Items->find('all', array(
        'conditions' => array(

            'created_on >=' => $startdate,
            'created_on <=' => $enddate . ' 23:59:59',
            'status' => 'draft'
        )));

   }else{
       $itemDetss = $this->Items->find()->where(['status' => 'draft'])->order(['id' => 'DESC'])->all();
   }


   $this->set('item_datas',$itemDetss);

}



function changeitemstatus ($itemId,$status) {


   $this->viewBuilder()->enableAutoLayout();
   $this->autoRender = false;
   if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Shops');
   $this->loadModel('Items');
   $this->loadModel('Users');
   $this->loadModel('Follower');
   $this->loadModel('Storefollowers');


   $logusrid = 1;

   $this->Items->updateAll(array('status' => "draft",'report_flag' => " "), array('id' => $itemId));



         $userModel = $this->Items->find()->where(['id'=>$itemId])->first();//Byid($itemId);
         $userId = $userModel['user_id'];
         if ($status == 'publish') {
           $this->Items->updateAll(array('status' => "draft",'report_flag' => " "), array('id' => $itemId));

           $result = "<button class='btn btn-success' style='font-size:11px;width:60px;' onclick='changeItemStatus(".$itemId.",\"draft\");'>Publish</button>";

         $item_user = $this->Items->find()->where(['id'=>$itemId])->toArray();//all',array('conditions'=>array('Item.id'=>$itemId)));
         $user_id = $item_user[0]['user_id'];
         $item_title = $item_user[0]['item_title'];
         $item_url = $item_user[0]['item_title_url'];



     }else {
       $this->Items->updateAll(array('status' => "publish"), array('id' => $itemId));
       $result = "<button class='btn btn-warning' style='font-size:11px;width:60px;' onclick='changeItemStatus(".$itemId.",\"publish\");'>Draft</button>";


       $itemstable = TableRegistry::get('Items');
       $userstable = TableRegistry::get('Users');
       $userModel = $itemstable->find()->contain('Users')->contain('Photos')->where(['Items.id'=>$itemId])->first();
       $notifyto = $userModel['user_id'];

       $itemname = $userModel['item_title'];
       $item_url = base64_encode($itemId."_".rand(1,9999));
       $productlink = "<a href='".SITE_URL."listing/".$item_url."'>".$itemname."</a>";
       $logusername = 'Admin';
       $image['user']['image'] = 'usrimg.jpg';
       $image['user']['link'] = '';
       $image['item']['image'] = $userModel['photos'][0]['image_name'];
       $image['item']['link'] = SITE_URL."listing/".$item_url;
       $loguserimage = json_encode($image);
       $userids = array('0');
       $notifymsg = __d('admin', 'Your product has been approved-___-').$productlink;
       $messages = __d('admin', 'Your product').$itemname.__d('admin', ' has been approved for sale');
       $logdetails = $this->addlog('admin',0,$notifyto,$itemId,$notifymsg,NULL,$loguserimage);

       $userdevicestable = TableRegistry::get('Userdevices');
       $shopstable = TableRegistry::get('Shops');
       $shopdata = $shopstable->find()->where(['user_id'=>$userModel['user_id']])->first();
       $userddett = $userdevicestable->find('all')->where(['user_id'=>$userModel['user_id']])->all();
       foreach($userddett as $userdet){
           $deviceTToken = $userdet['deviceToken'];
           $badge = $userdet['badge'];
           $badge +=1;

           $querys = $userdevicestable->query();
           $querys->update()
           ->set(['badge' => $badge])
           ->where(['deviceToken' => $deviceTToken])
           ->execute();

           if(isset($deviceTToken)){
               $pushMessage['type'] = 'admin';
               $pushMessage['store_id'] = $shopdata['id'];
               $pushMessage['store_name'] = $shopdata['shop_name'];
               $pushMessage['store_image'] = $shopdata['shop_image'];
               $pushMessage['item_id'] = $userModel['id'];
               $pushMessage['item_name'] = $userModel['item_title'];
               $pushMessage['item_image'] = $userModel['photos'][0]['image_name'];
               $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$userModel['user_id']])->first();
               I18n::locale($user_detail['languagecode']);
               $pushMessage['message'] = __d('admin', 'Your product has been approved');
               $messages=json_encode($pushMessage);
               $this->pushnot($deviceTToken,$messages,$badge);
           }
       }


       $followerstable = TableRegistry::get('Followers');
       $flwrscnt = $followerstable->flwrscnt($logusrid);
       $flwrusrids = array();
       if(!empty($flwrscnt)){
          foreach($flwrscnt as $flwss){
           $flwrusrids[$flwss['follow_user_id']] = $flwss['follow_user_id'];
       }
   }

   $storefollowerstable = TableRegistry::get('Storefollowers');
   $storeflwrscnt = $storefollowerstable->flwrscnt($userModel['shop_id']);
   $storeflwrusrids = array();
   if(!empty($storeflwrscnt)){
      foreach($storeflwrscnt as $storeflwss){
       $storeflwrusrids[$storeflwss['follow_user_id']] = $storeflwss['follow_user_id'];
   }
}

$flwssuserids = array_merge($storeflwrusrids, $flwrusrids);


$logusername = $userModel['user']['username'];
$logfirstname = $userModel['user']['first_name'];
//$logusernameurl = $userModel['user']['username_url'];

if($userModel['user']['user_level'] == 'shop')
{
  $shopData = $this->Shops->find()->where(['user_id'=>$userModel['user']['id']])->first();
  $logusernameurl = SITE_URL.'stores/'.$shopData->shop_name_url;
}elseif($userModel['user']['user_level'] == 'normal'){
  $logusernameurl = SITE_URL.'people/'.$userModel['user']['username_url'];  
}



$userImg = $userModel['user']['profile_image'];
if (empty($userImg)){
   $userImg = 'usrimg.jpg';
}
$logimage['user']['image'] = $userImg;

$logimage['user']['link'] = SITE_URL."people/".$logusernameurl;
$logimage['item']['image'] = $userModel['photos'][0]['image_name'];
$logimage['item']['link'] = SITE_URL."listing/".$item_url;
$logimages = json_encode($logimage);
$loguserlink = "<a href='".$logusernameurl."'>".$logfirstname."</a>";
$productlink = "<a href='".SITE_URL."listing/".$item_url."'>".$itemname."</a>";
$notifymsg = $loguserlink." -___-added a product-___- ".$productlink;
$logdetails = $this->addloglive('additem',$userId,$flwssuserids,$itemId,$notifymsg,NULL,$logimages,$itemId);



$item_user = $itemstable->find()->where(['id'=>$itemId])->first();
$user_id = $item_user['user_id'];
$item_title = $item_user['item_title'];

$item_url = base64_encode($itemId."_".rand(1,9999));

$email_address = $userstable->find()->where(['id'=>$user_id])->first();
$emailaddress = $email_address['email'];

$sitesettings = TableRegistry::get('sitesettings');
$setngs = $sitesettings->find()->first();

$email=$emailaddress;
$aSubject=$setngs['site_name'].__d('admin', ' – Your product ')."#".$itemId.__d('admin', ' was approved by ').$setngs['site_name'];
$template='productapproved';

$setdata=array('name'=>'kannan','email'=>$emailaddress,'username'=>$email_address['first_name'],'item_title'=>$item_title,'item_url'=>$item_url,'itemId'=>$itemId,'access_url'=>SITE_URL.'login','setngs'=>$setngs);
$this->sendmail($email,$aSubject,'',$template,$setdata);

}

         $itemcount = $this->Items->find()->where(['Items.user_id'=> $userId])->andWhere(['Items.status'=> 'publish'])->count();//count',array('conditions'=>array('Item.user_id'=>$userId,'Item.status'=>'publish')));
         $this->Shops->updateAll(array('item_count' =>$itemcount), array('user_id' => $userId));

         echo $result;
     }

     public function approveditems(){
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');

       $this->loadModel('Items');
       $this->loadModel('Users');



       $itemsTable = TableRegistry::get('Items');
       $item_datas=$itemsTable->find('all')
       ->contain(['Users'])
       ->where(['Items.status' => 'publish'])
       ->order(['Items.modified_on' => 'DESC']);

       $this->set('item_datas',$item_datas);
       $this->set('pagecount',$pagecount);
   }

   public function srchapproveditems() {
    if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Items');


   $startdate =$_POST['startdate'];
   $enddate = $_POST['enddate'];

   if(!empty($startdate) && !empty($enddate)){
       $startdate = date("Y-m-d", strtotime($startdate));
       $enddate =  date("Y-m-d", strtotime($enddate));


       $itemDetss=$this->Items->find('all', array(
        'conditions' => array(

            'created_on >=' => $startdate,
            'created_on <=' => $enddate . ' 23:59:59',
            'status' => 'publish'
        )));

   }else{
       $itemDetss = $this->Items->find()->where(['status' => 'publish'])->order(['id' => 'DESC'])->all();
   }

   $this->set('item_datas',$itemDetss);


}


public function inactivedisp(){


   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Disputes');

   $this->loadModel('Orders');
   $timeline = strtotime('-10 day');


   $status = array('Reply' => 'Reply','Initialized'=>'Initialized','Reopen' => 'Reopen','Responded'=>'Responded','Accepeted'=>'Accepeted' );
   $dispTable= TableRegistry::get('Disputes');
   $disp_data= $dispTable->find()->select(['uorderid','Orders.status'])
   ->leftJoinWith('Orders')
   ->group(['Disputes.uorderid'])
   ->autoFields(true)
   ->where(['chatdate <'=>$timeline])
   ->andWhere(['newstatusup IN'=>$status])
   ->all();

   $this->set('order_data',$disp_data);
}

public function processingdisp(){


   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Disputes');

   $this->loadModel('Orders');


   $dispTable= TableRegistry::get('Disputes');
   $disp_data= $dispTable->find()->select(['uorderid','Orders.status'])
   ->leftJoinWith('Orders')
   ->group(['Disputes.uorderid'])
   ->autoFields(true)
   ->where(['disid <>'=>0])
   ->andWhere(['newstatusup'=>'Processing'])
   ->all();



   $this->set('order_data',$disp_data);



}

public function closeddisp(){


   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Disputes');

   $this->loadModel('Orders');



   $dispTable= TableRegistry::get('Disputes');
   $disp_data= $dispTable->find()->select(['uorderid','Orders.status'])
   ->leftJoinWith('Orders')
   ->group(['Disputes.uorderid'])
   ->autoFields(true)
   ->where(['disid <>'=>0])
   ->andWhere(['newstatusup'=>'Closed'])
   ->all();



   $this->set('order_data',$disp_data);



}
public function resolveddisp(){


   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Disputes');

   $this->loadModel('Orders');

   $dispTable= TableRegistry::get('Disputes');
   $disp_data= $dispTable->find()->select(['uorderid','Orders.status'])
   ->leftJoinWith('Orders')
   ->group(['Disputes.uorderid'])
   ->autoFields(true)
   ->where(['disid <>'=>0])
   ->andWhere(['newstatusup'=>'Resolved'])
   ->all();

   $this->set('order_data',$disp_data);



}
public function canceldisp(){


   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Disputes');

   $this->loadModel('Orders');


   $dispTable= TableRegistry::get('Disputes');
   $disp_data= $dispTable->find()->select(['uorderid','Orders.status'])
   ->leftJoinWith('Orders')
   ->group(['Disputes.uorderid'])
   ->autoFields(true)
   ->where(['disid <>'=>0])
   ->andWhere(['newstatusup'=>'Cancel'])
   ->all();




   $this->set('order_data',$disp_data);



}
public function activedisp(){


   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $this->loadModel('Disputes');

   $this->loadModel('Orders');
   $timeline = strtotime('-10 day');


   $status = array('Reply' => 'Reply','Initialized'=>'Initialized','Reopen' => 'Reopen','Responded'=>'Responded','Accepeted'=>'Accepeted' );
   $dispTable= TableRegistry::get('Disputes');
   $disp_data= $dispTable->find()->select(['uorderid','Orders.status'])
   ->leftJoinWith('Orders')
   ->group(['Disputes.uorderid'])
   ->autoFields(true)
   ->where(['chatdate >'=>$timeline])
   ->andWhere(['newstatusup IN'=>$status])
   ->all();

   $this->set('order_data',$disp_data);

}

public function dispstatus($uoid,$resolvestatus){

    if(!$this->isauthenticated())
       $this->redirect('/');

   $this->viewBuilder()->enableAutoLayout();
   $this->autoRender = false;
   $this->loadModel('Orders');

   $this->Orders->updateAll(array('status' =>$resolvestatus), array('orderid' => $uoid));

}

public function dispcurrentstatus($disid,$statuscurrent){
    if(isset($_POST['disid']))
    {
       $disid = $_POST['disid'];
   }
   if(isset($_POST['statuscurrent']))
   {
       $statuscurrent = $_POST['statuscurrent'];
   }
   if(!$this->isauthenticated())
       $this->redirect('/');

   $this->viewBuilder()->enableAutoLayout();
   $this->autoRender = false;
   $this->loadModel('Disputes');


   $this->Disputes->updateAll(array('newstatusup' =>$statuscurrent), array('disid' => $disid));
   if($statuscurrent=="Reopen")
       $this->Disputes->updateAll(array('newstatus' =>$statuscurrent), array('disid' => $disid));


}

function deletedisp($did=NULL)
{
   $this->autoLayout = false;
   $this->autoRender = false;
   $this->loadModel('Disputes');
   $this->loadModel('Dispcons');
   $this->Disputes->deleteAll(array('Disputes.disid' => $did), false);
   $this->Dispcons->deleteAll(array('Dispcons.dispid' => $did), false);
}


public function viewdisp($disid){
    if(!$this->isauthenticated())
       $this->redirect('/');
   $this->viewBuilder()->setLayout('admin');
   $this->loadModel('Orders');
   $this->loadModel('Order_items');
   $this->loadModel('Items');
   $this->loadModel('Shippingaddresses');
   $this->loadModel('Disputes');
   $this->loadModel('Users');
   $this->loadModel('Dispcons');
   $this->loadModel('Ordercomments');


         $disp = $this->Disputes->find()->where(['disid'=>$disid])->first();//Bydisid($disid);
         $orid= $disp['uorderid'];
         $usie= $disp['userid'];
         $deid= $disp['disid'];

         $newstatusup= $disp['newstatusup'];

         $ordercommentsModel = $this->Ordercomments->find('all',array('conditions'=>array('orderid'=>$orid),'order'=>'id DESC'));


         $orderModel = $this->Orders->find()->where(['orderid'=>$orid])->first();//Byorderid($orid);
         $buyerid = $orderModel['userid'];
         $merchantid = $orderModel['merchant_id'];

         $userModel = $this->Users->find()->where(['id'=> $usie])->first();//Byid($userid);
         $merchantModel = $this->Users->find()->where(['id'=> $merchantid])->first();
         $userEmail = $userModel['email'];
         $shipppingId = $orderModel['shippingaddress'];
         $currencyCode = $orderModel['currency'];
         $shippingModel = $this->Shippingaddresses->find()->where(['shippingid'=> $shipppingId])->first();//Byshippingid($shipppingId);


         $buyerModel =  $this->Users->find()->where(['id'=> $usie])->first();

         $sellerName = $merchantModel['first_name'];
         $selleremail = $merchantModel['email'];
         $buyeremail = $buyerModel['email'];

         $sellername = $merchantModel['first_name'];
         $buyername = $buyerModel['first_name'];
         $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=>$currencyCode])->first();//first',array('conditions'=>array(

         $currencySymbol = $forexrateModel['currency_symbol'];
         $this->set('orderModel', $orderModel);
         $this->set('userModel',$userModel);
         $this->set('merchantModel',$merchantModel);
         $this->set('shippingModel',$shippingModel);
         $this->set('disp',$disp);
         $this->set('disid',$disid);
         $this->set('buyerModel',$buyerModel);
         $this->set('roundProf','round');

         $this->set('currencySymbol',$currencySymbol);
         $this->set('currencyCode', $currencyCode);


         $itemDetss = $this->Items->find()->where(['status' => 'publish'])->order(['id' => 'DESC'])->all();

         $msgel = $this->Dispcons->find()->where(['dispid'=>$disid])->order(['dcid' => 'DESC'])->all();
         foreach ($msgel as $key => $msg){

           $message[$key]['user_id'] = $msg['user_id'];
           $message[$key]['commented_by'] = $msg['commented_by'];
           $message[$key]['date'] = $msg['date'];

           $message[$key]['order_id'] = $msg['order_id'];
           $message[$key]['message'] = $msg['message'];

       }

       $pllm =$this->Dispcons->find()->where(['order_id'=>$orid])->order(['dcid' => 'DESC'])->all();
       foreach ($pllm as $key => $msgas){

           $messagedisp[$key]['user_id'] = $msgas['user_id'];
           $messagedisp[$key]['commented_by'] = $msgas['commented_by'];
           $messagedisp[$key]['date'] = $msgas['date'];

           $messagedisp[$key]['order_id'] = $msgas['order_id'];
           $messagedisp[$key]['message'] = $msgas['message'];
           $messagedisp[$key]['imagedisputes'] = $msgas['imagedisputes'];

       }
       $this->set('messagedisp',$messagedisp);
       if (!empty($this->request->data())){
           $dispcon_data   =   $this->Dispcons->newEntity();
           $dispcon_data->message=$this->request->data('msg');
           $dispcon_data->date=time();

           $nei="Admin";
           $dispcon_data->commented_by= $nei;
           $dispcon_data->user_id = $usie;
           $dispcon_data->order_id = $orid;
           $dispcon_data->dispid = $disid;
           $dispcon_data->msid = $merchantid;

         $curstatus = $this->Disputes->find()->where(['uorderid'=>$orid])->first();//Byuorderid($orid);
         $cursta= $curstatus['newstatusup'];


         if($curstatus['resolvestatus']!='Resolved' && $curstatus['newstatusup']!='Cancel' && $curstatus['newstatusup']!='Accepted'  && $curstatus['newstatusup']!='Processing' && $curstatus['newstatusup']!='Closed' ) {
           $this->Dispcons->save( $dispcon_data);


      //Send email to the buyer
           $userstable = TableRegistry::get('Users');
           $sellerdetails = $userstable->find()->where(['id'=>$usie])->first();


           $setngs = TableRegistry::get('sitesettings')->find('all')->first();

           $email=$sellerdetails['email'];
           $aSubject=$setngs['site_name'].__d('admin', ' - Replied for the Dispute').' #'.$disid;
           $aBody='';
           $template='replytobuyer';

           $setdata=array('name'=>$sellerdetails['first_name'],'setngs'=>$setngs,'disid'=>$disid,'gmsss'=>$dispcon_data->message);
           $this->sendmail($email,$aSubject,$aBody,$template,$setdata);

       //Send email to the merchant
           $userstable = TableRegistry::get('Users');
           $sellerdetails = $userstable->find()->where(['id'=>$merchantid])->first();
           $setngs = TableRegistry::get('sitesettings')->find('all')->first();

           $email=$sellerdetails['email'];
           $aSubject=$setngs['site_name'].__d('admin', ' - Replied for the Dispute').'#'.$disid;
           $aBody='';
           $template='replytobuyer';

           $setdata=array('name'=>$sellerdetails['first_name'],'setngs'=>$setngs,'disid'=>$disid,'gmsss'=>$dispcon_data->message);
           $this->sendmail($email,$aSubject,$aBody,$template,$setdata);

       //Add reply to buyer in log table
           $logusername = 'Admin';
           $image['user']['image'] = 'usrimg.jpg';
           $image['user']['link'] = '';
           $loguserimage = json_encode($image);

      // $userids = array('0');
           $notifymsg = $setngs['site_name'].__d('admin', '-___-replied for the dispute-___-')."# ".$disid ;
         $messages = $dispcon_data->message;//ision details:Min_value'.$min_range.' Max_value:'.$max_range.'  Amount:'.$commission->amount;


         $logdetails = $this->addlog('admin',0,$usie,$disid,$notifymsg,$messages,$loguserimage);

      //Add reply to seller in log table
         $logusername = 'Admin';
         $image['user']['image'] = 'usrimg.jpg';
         $image['user']['link'] = '';
         $loguserimage = json_encode($image);

         $notifymsg = $setngs['site_name'].__d('admin', '-___-replied for the dispute-___-')."# ".$disid ;
         $messages = $dispcon_data->message;//ision details:Min_value'.$min_range.' Max_value:'.$max_range.'  Amount:'.$commission->amount;

         $logdetails = $this->addlog('admin',0,$merchantid,$disid,$notifymsg,$messages,$loguserimage);

         if($this->isauthenticated()){

           $this->loadModel('Userdevices');
//Push notification to buyer
           $devicestable = TableRegistry::get('Userdevices');
           $buyernotfiy = $devicestable->find()->where(['user_id'=>$usie])->first();

           $deviceTToken = $buyernotfiy->deviceToken;
           $deviceid = $buyernotfiy->deviceId;
           $userdeviceid = $buyernotfiy->id;
           $badge = $buyernotfiy->badge;
           $badge +=1;
           $messages = $dispcon_data->message;


           $querys = $devicestable->query();
           $querys->update()
           ->set(['badge' => $badge])
           ->where(['deviceToken' => $deviceTToken])
           ->where(['id'=>$userdeviceid])
           ->execute();


           if(isset($deviceTToken)){
               $pushMessage['type'] = 'admin_dispute';
               $pushMessage['dispute_id'] = $disid;
               $pushMessage['message'] = $dispcon_data->message;
               $messages=json_encode($pushMessage);
               $this->pushnot($deviceTToken,$messages,$badge);
           }
//Push notification to seller
           $sellernotify = $devicestable->find()->where(['user_id'=>$merchantid])->first();
           $deviceTToken = $sellernotify->deviceToken;
           $deviceid = $sellernotify->deviceId;
           $userdeviceid = $sellernotify->id;
           $badge = $sellernotify->badge;
           $badge +=1;
           $messages = $dispcon_data->message;

           $this->Userdevices->updateAll(array('badge' =>$badge), array('deviceToken' => $deviceTToken), array('id' => $userdeviceid));

           if(isset($deviceTToken)){
           }
       }

       $this->Flash->success(__d('admin', 'Reply Send To Users.'));
       $this->redirect('/viewdisp/'.$disid);


   }else{
       $this->Flash->success(__d('admin', 'Dispute Status Changed'));
       $this->redirect('/viewdisp/'.$disid);
   }


}

}





public function admindashboard(){
    if(!$this->isauthenticated())
       $this->redirect('/');
   $this->viewBuilder()->setLayout('admin');

   $this->loadModel('News');
   $this->loadModel('Items');
   $this->loadModel('Orders');
   $this->loadModel('Shops');
   $this->loadModel('Payments');
   $this->loadModel('Users');
   $tdy = date("Y-m-d");

   $conn = ConnectionManager::get('default');


   $loguserlevel =$_SESSION['Auth']['Admin']['user_level'];

   $logadminmenus = $_SESSION['Auth']['Admin']['admin_menus'];

   $this->set('loguserlevel',$loguserlevel);
   $this->set('logadminmenus',$logadminmenus);

   $tiswk_strt = date("Y-m-d",strtotime("this week last sunday"));
   $tiswk_end = date("Y-m-d",strtotime("this week next saturday"));

   $tismnth_strt = date("Y-m-d",strtotime('first day of this month'));
   $tismnth_end = date("Y-m-t",strtotime('this month'));
   $userstatus = array('god' =>'god','moderator'=>'moderator');
   $total_usrs = $this->Users->find()->where(['user_level NOT IN'=>$userstatus])->count();

   $enbleusrs = $this->Users->find()->where(['user_level NOT IN'=>$userstatus])->andWhere(['user_status'=>'enable'])->count();

   $user_datas= $this->Users->find('all', array(
     'conditions' => array('Users.user_level <>' => 'god'),
     'order' => 'rand()',
     'limit' => 5,
 ));

   $disable_sellers = $this->Shops->find()->where(['seller_status'=>0])->count();
   $this->set('disable_sellers',$disable_sellers);

   $total_complete_payment1 = $conn->execute("SELECT SUM(payment.totalcost * f.price) as total FROM fc_orders as payment,fc_forexrates as f WHERE status = ' ' or status='Pending' and payment.currency=f.currency_code ;");
   $total_complete_payment=$total_complete_payment1 ->fetchAll('assoc');

   $total_admin_commission1 = $conn->execute("SELECT SUM(o.admin_commission * f.price) as total FROM fc_orders as o,fc_forexrates as f where o.currency=f.currency_code;");
   $total_admin_commission = $total_admin_commission1->fetchAll('assoc');
   $user_datas_payment = $this->Orders->find('all', array(
    'order' => 'DESC',
    'limit' => 5,
));
   $todaystart = date('Y-m-d 00:00:00');
   $todayend = date('Y-m-d 24:00:00');
   $todaystartdate = strtotime($todaystart);
   $todayenddate = strtotime($todayend);

   $today_new_orders_count=$this->Orders->find('all', array(
    'conditions' => array(

        'orderdate >=' =>    $todaystartdate,
        'orderdate <=' => $todayenddate,
        'status' => 'Processing'
    )))->count();
   $today_delivered_orders_count =$this->Orders->find('all', array(
    'conditions' => array(

        'orderdate >=' =>    $todaystartdate,
        'orderdate <=' => $todayenddate,
        'status' => 'Delivered'
    )))->count();
   $this->set('today_new_orders_count',$today_new_orders_count);
   $this->set('today_delivered_orders_count',$today_delivered_orders_count);
         $total_items = $this->Items->find()->count();//'count');
         $disbleitems = $this->Items->find()->where(['status'=>'draft'])->count();//',array('conditions'=>array('status'=>'draft')));
         $total_merchandize_value1 = $conn->execute("SELECT SUM(i.price * f.price) as total FROM fc_items as i,fc_forexrates as f WHERE i.currencyid=f.id");
         $total_merchandize_value = $total_merchandize_value1->fetchAll('assoc');

         $this->set('total_merchandize_value',$total_merchandize_value[0]['total']);

         $this->set('total_usrs',$total_usrs);
         $this->set('enbleusrs',$enbleusrs);

         $this->set('user_datas',$user_datas);
         $this->set('user_datas_payment',$user_datas_payment);


         $this->set('total_complete_payment',$total_complete_payment[0]['total']);
         $this->set('total_admin_commission',$total_admin_commission[0]['total']);
         $this->set('total_items',$total_items);

         $this->set('disbleitems',$disbleitems);

     }




     public function adminsetting(){
       $this->viewBuilder()->setLayout('admin');
       if(!($this->isauthenticated()))
           $this->redirect('/');
       $this->loadModel('Users');


       $auserid = $_SESSION['Auth']['Admin']['id'];
       if(!empty($this->request->data)){
           $firstname = $this->request->data('firstname');
           $lastname = $this->request->data('lastname');
           $email = $this->request->data('email');
           $password = $this->request->data('password');


           $emlcounts = $this->Users->find()->where(['email'=>$email])->andWhere(['id <>'=>$auserid])->count();

           $user_data = $this->Users->find()->where(['id'=> $auserid])->first();
           $admin_menus = $user_data['admin_menus'];
           if($emlcounts > 0){

               $this->Flash->success(__d('admin', 'Email already exists'));
               $this->redirect($this->referer());

           }else{

               $user_data->id = $auserid;
               $name=$user_data->username = $user_data['username'];
               $user_data->first_name = $firstname;
               $user_data->last_name = $lastname;
               $emailaddress = $user_data->email = $email;
               if($password != ""){
                   $user_data->password = (new DefaultPasswordHasher)->hash($password);}
                   $user_data->activation = '1';
                   $user_data->user_status = 'enable';
                   $user_data->admin_menus = $admin_menus;
                   $user_data->created_at = date('Y-m-d H:i:s');
                   $this->Users->save($user_data);


                   $this->Flash->success(__d('admin', 'The changes are updated ...'));
                   $this->redirect($this->referer());

               }
           }else{
               $this->loadModel('User');
         $userDett = $this->Users->find()->where(['id'=> $auserid])->first();//ById($auserid);

         $this->set('userDett',$userDett);

     }
 }

 public function addlog($type=NULL,$userId=NULL,$notifyTo=NULL,$sourceId=NULL,$notifymsg=NULL,$message=NULL,$image=NULL,$itemid=0){
   $this->loadModel('Log');
   $this->loadModel('User');

   $userstable = TableRegistry::get('Users');
   $logstable = TableRegistry::get('Logs');
   $logs = $logstable->newEntity();
   $logs->type = $type;
   $logs->userid = $userId;
   $logs->notifyto = 0;
   if(!is_array($notifyTo))
       $logs->notifyto = $notifyTo;
   $logs->sourceid = $sourceId;

   $logs->itemid = $itemid;
   $logs->notifymessage = $notifymsg;
   $logs->message = $message;
   $logs->image = $image;
   $logs->cdate = time();

   $logstable->save($logs);
   $query = $userstable->query();
   if(count($notifyTo)>0)
   {

    if($type=="additem"){
       $user_notification_count = array('unread_livefeed_cnt = unread_livefeed_cnt + 1');
   }
   else{
       $user_notification_count = array('unread_notify_cnt = unread_notify_cnt + 1');
   }

   $query->update()->set($query->newExpr($user_notification_count))->where(['id IN'=>$notifyTo])
   ->execute();
}

}

public function addloglive($type=NULL,$userId=NULL,$notifyTo=NULL,$sourceId=NULL,$notifymsg=NULL,$message=NULL,$image=NULL,$itemid=0){

   $this->loadModel('Log');
   $this->loadModel('User');

   $userstable = TableRegistry::get('Users');
   $logstable = TableRegistry::get('Logs');
   $logs = $logstable->newEntity();
   $logs->type = $type;
   $logs->userid = $userId;
   $logs->notifyto = 0;
   if(!is_array($notifyTo))
       $logs->notifyto = $notifyTo;
   $logs->sourceid = $sourceId;

   $logs->itemid = $itemid;
   $logs->notifymessage = $notifymsg;
   $logs->message = $message;
   $logs->image = $image;
   $logs->cdate = time();

   $logstable->save($logs);

   $query = $userstable->query();
   if(count($notifyTo)>0)
   {

       $query->update()->set($query->newExpr('unread_notify_cnt = unread_notify_cnt + 1'))->where(['id IN'=>$notifyTo])
       ->execute();
   }


}

public function adminitemview($id)
{

   $this->viewBuilder()->setLayout('item');
   if(!($this->isauthenticated()))
       $this->redirect('/');
   $items = TableRegistry::get('Items');
   $shops = TableRegistry::get('Shops');
   $item_datas = $items->find('all')->contain(['Photos'])->contain(['Shops'])->where(['Items.id'=>$id])->first();
   $UsersTable = TableRegistry::get('Users');
   $users = $UsersTable->find('all')->where(['id'=>$item_datas['user_id']])->first();
   $fashionusers = TableRegistry::get('Fashionusers');
   $fashionimages = $fashionusers->find('all')->where(['itemId'=>$item_datas['id']])->all();
   $photosTable = TableRegistry::get('Photos');
   $photos = $photosTable->find('all')->where(['item_id'=>$item_datas['id']])->all();

        //Buyer Comments
   $commentsTable = TableRegistry::get('Comments');
   $comments = $commentsTable->find('all')->where(['item_id'=>$id])->all();

   $this->set('item_datas',$item_datas);
   $this->set('users',$users);
   $this->set('fashionimages',$fashionimages);
   $this->set('photos',$photos);

   $this->set('comments',$comments);
}


public function managenewsletter()
{
   $this->viewBuilder()->setLayout('admin');
   if(!($this->isauthenticated()))
       $this->redirect('/');

   $userid = 1;


   if($this->request->is('post')) {
       $newskey = trim($this->request->data['apikey']);

       $settingsTable = TableRegistry::get('Sitesettings');
       $query = $settingsTable->query();
       $query->update()->set(['news_key' => $newskey])->where(['id'=>$userid])->execute();

       $this->Flash->success(__d('admin', 'Newsletter Keys saved successfully'));
       $this->redirect('/managenewsletter');
   }

   $settings_datas = $this->Sitesettings->find()->where(['Sitesettings.id'=>$userid])->first();
   $this->set('settings_datas',$settings_datas);

}


public function getcontacts()
{
   $this->viewBuilder()->setLayout('admin');


   if(!($this->isauthenticated()))
       $this->redirect('/');



   $userid = 1;
   $this->loadModel('Sitesettings');
   $settings_datas = $this->Sitesettings->find()->where(['Sitesettings.id'=>$userid])->first();

   $apiKey = trim($settings_datas['news_key']);

   if(empty($apiKey)) {
       $this->Flash->error(__d('admin', 'Please Add Mail Chimp API Key'));
       $this->redirect('/managenewsletter');
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

   $this->set('settings_datas',$settings_datas);
   $this->set('result',$res['lists']);
}


public function listcontacts()
{
    if(!($this->isauthenticated()))
       $this->redirect('/');
   $userid = 1;
   $this->loadModel('Sitesettings');
   $settings_datas = $this->Sitesettings->find()->where(['Sitesettings.id'=>$userid])->first();
   $apiKey = trim($settings_datas['news_key']);
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


public function newsletter()
{
   $this->viewBuilder()->setLayout('admin');
   $this->set('title_for_layout','Newsletter');

   if(!($this->isauthenticated()))
       $this->redirect('/');



   $userid = 1;
   $this->loadModel('Sitesettings');
   $settings_datas = $this->Sitesettings->find()->where(['Sitesettings.id'=>$userid])->first();


        // DATA FETCH PROCESS

   $apiKey = trim($settings_datas['news_key']);

   if(empty($apiKey)) {
       $this->Flash->error(__d('admin','WELCOME TO HITASOFT, MADURAI'));
       $this->redirect('/managenewsletter');
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
                  'html'      => '<div style="color:red; text-align:center;">'.__d('admin','WELCOME TO HITASOFT, MADURAI').'</div><div style="margin-top:20px; text-align:center;">'.$messages.'</div>'
              ]);

               $set_campaign_content = $this->isa_set_mail_campaign_content($campaign_id, $template_content);

               if(!empty($set_campaign_content)) {

                   $send_campaign = $this->isa_mailchimp_api_request( "campaigns/$campaign_id/actions/send", 'POST' );

                   if (empty($send_campaign)) {
                       $this->Flash->success(__d('admin','Newsletter Send Successfully'));
                       $this->redirect('/newsletter');
                   } else {
                       $this->Flash->error(__d('admin','Newsletter Failed, Try Again !'));
                       $this->redirect('/newsletter');
                   }
               } else {
                   $this->Flash->error(__d('admin','Newsletter Info Error, Try Again !'));
                   $this->redirect('/newsletter');
               }
           } else {
               $this->Flash->error(__d('admin','Newsletter Campaign Error, Try Again !'));
               $this->redirect('/newsletter');
           }
       } else {
           $this->Flash->error(__d('admin','Please add members to the list'));
           $this->redirect('/newsletter');
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
   $this->set('settings_datas',$settings_datas);
   $this->set('result',$res['lists']);
}

public function isa_mailchimp_api_request( $endpoint, $type = 'POST', $body = '' ) {

   $this->autoRender = false;
   if(!$this->isauthenticated()) {
       $this->redirect('/');
   }

      // INITIALIZE DATABASE MODELS HERE.
   $userid = 1;
   $this->loadModel('Sitesettings');
   $settings_datas = $this->Sitesettings->find()->where(['Sitesettings.id'=>$userid])->first();


        // DATA FETCH PROCESS

   $apiKey = trim($settings_datas['news_key']);

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
       $this->redirect('/');
   }

      // INITIALIZE DATABASE MODELS HERE.
   $userid = 1;
   $this->loadModel('Sitesettings');
   $this->loadModel('Users');
   $settings_datas = $this->Sitesettings->find()->where(['Sitesettings.id'=>$userid])->first();


        // DATA FETCH PROCESS

   $apiKey = trim($settings_datas['news_key']);
      // DATA FETCH PROCESS
   $loguser = $this->Users->find()->where(['id'=>1])->first();
   $reply_to   = $loguser['email'];
   $from_name  = $loguser['username'];
   $campaign_id = '';

   $body = json_encode([
    'recipients'    => array('list_id' => $list_id),
    'type'          => 'regular',
    'settings'      => array('subject_line' => $subject,
       'preview_text' => __d('admin','Welcome'),
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
       $this->redirect('/');
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



function landingpage() {
    global $loguser;
    $this->viewBuilder()->setLayout('admin');
    // if(!$this->isauthorized())
    //      $this->redirect('/');

    $this->loadModel('Homepagesettings');
    $this->loadModel('Categories');

    $this->set('title_for_layout','Manage Landing Page');

    $homepagesettings = $this->Homepagesettings->find()->first();

    $slider_datas = $this->Homepagesettings->get($homepagesettings->id);

    

   $categoriesData = $this->Categories->find()->select(['id','category_name'])->where(['category_name <> '=>'','category_parent'=>'0'])->order(['id'=>'DESC'])->all();

    if(!empty($this->request->data)){
      //echo '<pre>'; print_r($_POST['slider']); die;
       $sliderproperty = $homepagesettings->properties;
       $sliderproperty = json_decode($sliderproperty,true);
       $layout =  $this->request->data('Layout');
       $widgets =  $this->request->data('widgets');
       $sliders = $this->request->data('sliders');
       $widget_settings = json_encode($this->request->data('slider'));
       $category_id = $this->request->data('categories'); 
       $sliderproperty['sliderheight'] = $this->request->data('sliderHeight');
       $sliderproperty['sliderbg'] = $this->request->data('sliderBg');
       $sliderproperty = json_encode($sliderproperty);
       if ($sliders <= 0){
           $this->Flash->success(__d('admin','Select atleast one slider Image'));
       }
       else
       {
           $this->Flash->success(__d('admin','Saved Successfully'));
       }

       $slider_datas->layout = $layout;
       $slider_datas->widgets = $widgets;
       $slider_datas->properties = $sliderproperty;
       $slider_datas->widget_settings = $widget_settings;
       $slider_datas->categories = $category_id;

       if (!empty($homepagesettings)){
           $slider_datas->id = $homepagesettings->id;
       }

       $this->Homepagesettings->save($slider_datas);

       $this->redirect('/landingpage');
   }

   $this->set('homepagesettings',$homepagesettings);
   $this->set('categories',$categoriesData);
}


function deleteslider($id){
    global $loguser;
    if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Homepagesettings');

   $homepageModel = $this->Homepagesettings->find()->first();
   $sliders = array();
   $newsliders = array();

   $sliders = json_decode($homepageModel->slider, true);

   if (!empty($homepageModel)){
       $id -= 1;
       $newcount = 0;
       foreach($sliders as $key=>$slider){

        if ($key != $id){
           $newsliders[$newcount]['image'] = $slider['image'];
           $newsliders[$newcount]['link'] = $slider['link'];
           $newsliders[$newcount]['mode'] = $slider['mode'];
           $newcount++;
       }
   }

   unlink(WWW_ROOT.'images/slider/'.$sliders[$id]['image']);


   $sliderData = json_encode($newsliders);
   $slider_datas = $this->Homepagesettings->get($homepageModel->id);

   $slider_datas->slider = $sliderData;
   $this->Homepagesettings->save($slider_datas);
   $this->redirect('/landingpage');
}

}


function addslider($id = NULL){

    global $loguser;
    $this->viewBuilder()->setLayout('admin');

    if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Homepagesettings');

   $homepageModel = $this->Homepagesettings->find()->first();

   $this->loadModel('Categories');
   $this->loadModel('Items');

   $categoriesData = $this->Categories->find()->select(['id','category_name'])->where(['category_name <> '=>'','category_parent'=>'0'])->order(['id'=>'DESC'])->all();
   $itemData = $this->Items->find()->select(['id','item_title'])->where(['item_title <> '=>'','status'=>'publish'])->order(['id'=>'DESC'])->all();

   $sliderImage = '';$sliders = '';
   $sliderLink = '';$sliderEffect = 'fade';
   $pagetitle = __d('admin','Add Slider');
   $sliders = array();
   $slidercount = 0;
   if (!empty($homepageModel->slider)) {
       $sliders = json_decode($homepageModel->slider, true);
       $slidercount = count($sliders);
   }

   if (!empty($homepageModel) && $id != NULL){
       $id -= 1;
       $sliderImage = $sliders[$id]['image'];
       $sliderLink = $sliders[$id]['link'];
       $sliderEffect = $sliders[$id]['mode'];
       $pagetitle = __d('admin','Edit Slider');

   }
   else
   {
       $pagetitle = __d('admin','Add Slider');
   }


   if(!empty($this->request->data)){

    if($this->request->data('editid') != ''){
       echo $slidercount = $this->request->data('editid');
   }

   if($this->request->data('slider_Type') == '')
   {
      //$this->Flash->success(__d('admin','type cant be empty'));
      //$this->redirect('/addslider');
   }

   if($this->request->data('slider_Type') != '' && 
    $this->request->data('slider_Type') == 'categories'
    )
   {
      $url = '';
      if(isset($_POST['categories']))
      {
        $getCategory = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['categories']])->first();
        $url.= $getCategory['category_urlname'];
        $cateId = $getCategory['id'];
      }else{
        $this->Flash->success(__d('admin','type cant be empty'));
        $this->redirect('/addslider');
        //die;
      }

      if(isset($_POST['subcategory']))
      {
        $getsubCategory = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['subcategory'],'category_sub_parent'=>'0'])->first();
        $url.= '/'.$getsubCategory['category_urlname'];
        $subcateId = $getsubCategory['id'];
      }

      if(isset($_POST['supercategory']))
      {
          $getsupercategory = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['supercategory']])->first();
          $url.= '/'.$getsupercategory['category_urlname'];
          $supercateId = $getsupercategory['id'];
      }

      
      $category = (isset($cateId)) ? $cateId : '';
      $subcategory = (isset($subcateId)) ? $subcateId : '';
      $supercategory = (isset($supercateId)) ? $supercateId : '';

      $getCategorydata = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['categories']])->first();
      //$getUrl = Router::url('/',true).'/shop/'.$getCategorydata->category_urlname;
      $getUrl = Router::url('/',true).'/shop/'.$url;
      $getId = $getCategorydata->id;
   }elseif($this->request->data('slider_Type') != '' && 
      $this->request->data('slider_Type') == 'item'
    ){
      $getItemdata = $this->Items->find()->select(['id','item_title_url'])->where(['id'=>$_POST['item']])->first();
      $product_url = base64_encode($getItemdata->id."_".rand(1,9999));
      $getUrl = Router::url('/',true).'/listing/'.$product_url;
      $getId = $getItemdata->id;
   }elseif($this->request->data('slider_Type') != '' && 
      $this->request->data('slider_Type') == 'link'
    ){
      $getUrl = $_POST['sliderurl'];
   }elseif($this->request->data('slider_Type') == '')
   {
      $this->Flash->success(__d('admin','type cant be empty'));
      $this->redirect('/addslider');
      //die;
   }

   $sliders[$slidercount]['image'] = $this->request->data('sliderImage');
   $sliders[$slidercount]['link'] = $getUrl;
   $sliders[$slidercount]['type'] = $_POST['slider_Type'];

   if($_POST['slider_Type'] == 'categories'){
      $sliders[$slidercount]['category'] = $category;
      $sliders[$slidercount]['subcategory'] = $subcategory;
      $sliders[$slidercount]['supercategory'] = $supercategory;
   }

   if($_POST['slider_display_on'] == '')
   {
      $this->Flash->success(__d('admin','Slider display cannot be empty'));
      $this->redirect('/addslider');
      //die;
   }

   if(($_POST['slider_Type'] != '' && 
    $_POST['slider_display_on'] != '' ) &&
    (
    ($_POST['slider_Type'] == 'categories' && !empty($_POST['categories'])) ||
    ($_POST['slider_Type'] == 'item' && !empty($_POST['item'])) ||
    ($_POST['slider_Type'] == 'link' && !empty($_POST['sliderurl']))
    )
    )
   {
      $sliders[$slidercount]['content_id'] = $getId;
     $sliders[$slidercount]['mode'] = $this->request->data('slider_display_on');


     $sliderData = json_encode($sliders);



     $slider_datas = $this->Homepagesettings->get($homepageModel->id);

     $slider_datas->slider = $sliderData;

     if (!empty($homepageModel)){
         $slider_datas->id = $homepageModel->id;
         $slider_datas->layout = $homepageModel->layout;
         $slider_datas->widgets = $homepageModel->widgets;
     }
     $this->Homepagesettings->save($slider_datas);

     $this->Flash->success(__d('admin','Saved Successfully'));
     $this->redirect('/landingpage');
   }else{
     $this->Flash->success(__d('admin','Please fill all mandatory fields'));
     $this->redirect('/addslider');
   }
   
   
}

$this->set('title_for_layout',$pagetitle);

$this->set('categoriesData',$categoriesData);
$this->set('itemData',$itemData);

$this->set('sliderImage',$sliderImage);
$this->set('sliderLink',$sliderLink);
$this->set('sliderEffect',$sliderEffect);
$this->set('pagetitle',$pagetitle);
$this->set('editid',$id);
$this->set('homepageModel',$homepageModel);
}


function editslider($id = NULL){

    global $loguser;
    $this->viewBuilder()->setLayout('admin');

    if(!$this->isauthenticated())
       $this->redirect('/');

   $this->loadModel('Homepagesettings');

   $homepageModel = $this->Homepagesettings->find()->first();

   $sliderImage = '';$sliders = '';
   $sliderLink = '';$sliderEffect = 'fade';
   $pagetitle = __d('admin','Add Slider');
   $sliders = array();
   $slidercount = 0;
   if (!empty($homepageModel->slider)) {
       $sliders = json_decode($homepageModel->slider, true);
       $slidercount = count($sliders);
   }

   if (!empty($homepageModel) && $id != NULL){

       $id -= 1;
       $sliderImage = $sliders[$id]['image'];
       $sliderLink = $sliders[$id]['link'];
       $slidertype = (!isset($sliders[$id]['type'])) ? 'link' : $sliders[$id]['type'];
       if($sliders[$id]['type'] == 'categories')
       {

        $slider_contentid = array(
                  'category'=>$sliders[$id]['category'],
                  'subcategory'=>$sliders[$id]['subcategory'],
                  'supercategory'=>$sliders[$id]['supercategory']
                  );

       }else{
        $slider_contentid = $sliders[$id]['content_id']; 
       }
       
       $sliderEffect = $sliders[$id]['mode'];
       $pagetitle = __d('admin','Edit Slider');
   }


   if(!empty($this->request->data)){

    if($this->request->data('editid') != ''){
       $slidercount = $this->request->data('editid');
   }

   if($this->request->data('slider_Type') == '')
   {
      $this->Flash->success(__d('admin','type cant be empty'));
      $this->redirect('/addslider');
   }


   if($this->request->data('slider_Type') != '' && 
    $this->request->data('slider_Type') == 'categories'
    )
   {
      $url = '';
      if(isset($_POST['categories']))
      {
        $getCategory = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['categories']])->first();
        $url.= $getCategory['category_urlname'];
        $cateId = $getCategory['id'];
      }

      if(isset($_POST['subcategory']))
      {
        $getsubCategory = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['subcategory'],'category_sub_parent'=>'0'])->first();
        $url.= '/'.$getsubCategory['category_urlname'];
        $subcateId = $getsubCategory['id'];
      }

      if(isset($_POST['supercategory']))
      {
          $getsupercategory = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['supercategory']])->first();
          $url.= '/'.$getsupercategory['category_urlname'];
          $supercateId = $getsupercategory['id'];
      }

      
      $category = (isset($cateId)) ? $cateId : '';
      $subcategory = (isset($subcateId)) ? $subcateId : '';
      $supercategory = (isset($supercateId)) ? $supercateId : '';

      $getCategorydata = $this->Categories->find()->select(['id','category_urlname'])->where(['id'=>$_POST['categories']])->first();
      //$getUrl = Router::url('/',true).'/shop/'.$getCategorydata->category_urlname;
      $getUrl = Router::url('/',true).'/shop/'.$url;
      $getId = $getCategorydata->id;
   }elseif($this->request->data('slider_Type') != '' && 
      $this->request->data('slider_Type') == 'item'
    ){

      
      $getItemdata = $this->Items->find()->select(['id','item_title_url'])->where(['id'=>$_POST['item']])->first();
      $product_url = base64_encode($getItemdata->id."_".rand(1,9999));
      $getUrl = Router::url('/',true).'/listing/'.$product_url;
      $getId = $getItemdata->id;
   }else{
      $getUrl = trim($_POST['sliderurl']);
   }
   $sliders[$slidercount]['image'] = $this->request->data('sliderImage');
   $sliders[$slidercount]['link'] = $getUrl;
   $sliders[$slidercount]['type'] = $_POST['slider_Type'];

   if($_POST['slider_Type'] == 'categories'){
      $sliders[$slidercount]['category'] = $category;
      $sliders[$slidercount]['subcategory'] = $subcategory;
      $sliders[$slidercount]['supercategory'] = $supercategory;
   }

   $sliders[$slidercount]['content_id'] = $getId;
   $sliders[$slidercount]['mode'] = $this->request->data('slider_display_on');

   //print_r(json_encode($sliders)); die;
   $sliderData = json_encode($sliders);
   $slider_datas = $this->Homepagesettings->get($homepageModel->id);

   $slider_datas->slider = $sliderData;

   if (!empty($homepageModel)){
       $slider_datas->id = $homepageModel->id;
       $slider_datas->layout = $homepageModel->layout;
       $slider_datas->widgets = $homepageModel->widgets;
   }

   if($this->request->data('slider_Type') != '')
   {
      if($this->request->data('slider_Type') == 'item' && $this->request->data('item') == ''){
        $this->Flash->success(__d('admin','item cant be empty'));
        $this->redirect('/landingpage');
      }else{
        $this->Homepagesettings->save($slider_datas);
        $this->Flash->success(__d('admin','Saved Successfully'));  
      }
      
    }
   

   
   $this->redirect('/landingpage');
}

$this->loadModel('Categories');
$this->loadModel('Items');
$categoriesData = $this->Categories->find()->select(['id','category_name'])->where(['category_name <> '=>'','category_parent'=>'0'])->order(['id'=>'DESC'])->all();
$itemData = $this->Items->find()->select(['id','item_title'])->where(['item_title <> '=>'','status'=>'publish'])->order(['id'=>'DESC'])->all();


//echo '<pre>'; print_r($subcategoriesData); 
$subcategoriesData = $this->Categories->find()->select(['id','category_name'])->where(['category_parent'=>$slider_contentid['category'],'category_sub_parent'=>'0'])->order(['id'=>'DESC'])->all();

$supercategoriesData = $this->Categories->find()->select(['id','category_name'])->where(['category_sub_parent'=>$slider_contentid['subcategory']])->order(['id'=>'DESC'])->all();


$this->set('categoriesData',$categoriesData);
$this->set('subcategoriesData',$subcategoriesData);
$this->set('supercategoriesData',$supercategoriesData);

$this->set('itemData',$itemData);

$this->set('title_for_layout',$pagetitle);
$this->set('sliderImage',$sliderImage);
$this->set('sliderLink',$sliderLink);
$this->set('sliderEffect',$sliderEffect);
$this->set('slidertype',$slidertype);
$this->set('slider_contentid',$slider_contentid);
$this->set('pagetitle',$pagetitle);
$this->set('editid',$id);
$this->set('homepageModel',$homepageModel);
}

public function errorpage() {

   $this->viewBuilder()->setLayout('admin');
   if(!$this->isauthenticated())
       $this->redirect('/');
   $this->loadModel('Helps');

   $sale = $this->Helps->find()->toArray();

   $main = $sale[0]['err_code'];

   $this->set('main',$main);

   if(!empty($this->request->data)) {
       $main = $this->request->data['main'];


       $main = $main;

       $this->Helps->updateAll(array('err_code' => "$main" ), array('id' => '1'));

       $this->Flash->success(__d('admin','updated Successfully'));
       $this->redirect('/404page');
   }


}


public function giftdetail($id=NULL)
{
   $this->viewBuilder()->setLayout('item');
   $groupgiftuserdetailstable = TableRegistry::get('Groupgiftuserdetails');
   $groupgiftpayamtstable = TableRegistry::get('Groupgiftpayamts');
   $countriestable = TableRegistry::get('Countries');
   $itemstable = TableRegistry::get('Items');
   $userstable = TableRegistry::get('Users');

   global $loguser;

   if (!isset($loguser) || empty($loguser)){
       $this->set('currentUser', 0);
   }else{
       $this->set('currentUser', $loguser['id']);
   }
   $items_list_data = $groupgiftuserdetailstable->find()->where(['id'=>$id])->first();

   $refundbutton = $groupgiftpayamtstable->find()->where(['ggid'=>$id,'status is' => null])->all();

   
   $ggAmtDatas = $groupgiftpayamtstable->find()->contain('Users')->where(['ggid'=>$id])->order(['cdate'=>'DESC'])->all();
   foreach($ggAmtDatas as $ggAmtData){
       $paidamt += $ggAmtData['amount'];
       $paidUserId[] = $ggAmtData['paiduser_id'];
   }
   if(empty($items_list_data)){
       $this->redirect('/');
   }
   $ItemId = $items_list_data['item_id'];
   $userId = $items_list_data['user_id'];
   $countryId = $items_list_data['country'];

   $countrys_list_data = $countriestable->find()->where(['id'=>$countryId])->first();

   $item_datas = $itemstable->find()->contain('Photos')->contain('Forexrates')->where(['Items.id'=>$ItemId])->first();

   $createuserDetails = $userstable->find()->where(['id'=>$userId])->first();

   $sitesettingstable = TableRegistry::get('Sitesettings');
   $setngs = $sitesettingstable->find()->where(['id'=>1])->first();
   $socialId = $setngs['social_id'];
         $socialId = json_decode($socialId,true); //print_r($socialId);die;

         $this->set('item_datas',$item_datas);
         $this->set('refundbutton',$refundbutton);
         $this->set('createuserDetails',$createuserDetails);
         $this->set('items_list_data',$items_list_data);
         $this->set('countrys_list_data',$countrys_list_data);
         $this->set('paidamt',$paidamt);
         $this->set('paidUserId',$paidUserId);
         $this->set('ggAmtDatas',$ggAmtDatas);
         $this->set('setngs',$setngs);
         $this->set('loguser',$loguser);
         $this->set('roundProf',$siteChanges['profile_image_view']);
         $this->set('fbapp_id',$socialId['FB_ID']);
         $this->set('fbtitle',SITE_NAME." Group Gift Share");
         $this->set('fbdescription',"Contribution Request from your friend");
         $this->set('fbtype',"photo");
         $this->set('fburl',SITE_URL."gifts/".$items_list_data['Groupgiftuserdetail']['id']);
         $this->set('fbimage',$_SESSION['media_url'].'media/items/original/'.$item_datas['Photo'][0]['image_name']);
     }
     public function Setlanguages()
     {
       $this->autoLayout = false;
       $this->autoRender = false;
       if(isset($_POST['language']) && $_POST['language']!=''){
           $lang_count=TableRegistry::get('Languages')->find()->where(['languagename'=>$_POST['language']])->count();
           if($lang_count>0){
               $lang_details=TableRegistry::get('Languages')->find()->where(['languagename'=>$_POST['language']])->first();
               unset($_SESSION['languagecode']);
               unset($_SESSION['languagename']);
               $_SESSION['languagecode']=$lang_details['languagecode'];
               $_SESSION['languagename']=$lang_details['languagename'];
               echo $_SESSION['languagecode'];

           }
       }

   }
   public function Braintreecurrencycode($currencycode)
   {

       $this->loadModel('Sitesettings');

       $paycurrency= $currencycode;
       $site_datas = $this->Sitesettings->find('all')->first();
       $sitepaystatus = $site_datas['braintree_setting'];
       $sitepaystatus = json_decode($sitepaystatus,true);



       if (array_key_exists($paycurrency, $sitepaystatus))
       {
          foreach ($sitepaystatus as $key => $value) {
            if($key == $paycurrency)
            {
               $data = array(

                   "merchant_account_id"  => $value['merchant_account_id']

               );
           }
       }
   }
   echo json_encode($data); die;

}

public function giftrefundamount()
{
           //POSTED VALUES
   $ggId = $_POST['gid'];
   $currency = $_POST['currency'];
   $Groupgiftpayamts = TableRegistry::get('Groupgiftpayamts');
   $groupgiftsTable = TableRegistry::get('Groupgiftuserdetails')->query();
   $ggitemDetails = $Groupgiftpayamts->find('all')->where(['ggId' => $ggId])->all();

   $this->loadModel('Forexrates');
         $forexrateModel = $this->Forexrates->find()->where(['currency_code'=>$currency])->first();//first',array('conditions'=>array(

         $currencySymbol = $forexrateModel['currency_symbol'];


         foreach ($ggitemDetails as $giftuser) {
           $userdata = TableRegistry::get('Users')->query();
           $giftquery = TableRegistry::get('Groupgiftpayamts')->query();
           $userDetails = TableRegistry::get('Users')->find()->where(['id' => $giftuser['paiduser_id']])->first();

           $total = $userDetails->credit_total + $giftuser['amount'];

           $userdata->update()->set(['credit_total' => $total])->where(['id' => $giftuser['paiduser_id']])->execute();       

           $giftquery->update()->set(['status' => 'refunded'])->where(['id' => $giftuser['id']])->execute();

           $logusername = 'Admin';
           $image['user']['image'] = 'usrimg.jpg';
           $image['user']['link'] = '';
           $loguserimage = json_encode($image);

           $notifymsg = __d('user',"Your account has been credited for the refund of the Group gift")."-___-"."#".$ggId;
           $messages = __d('user',"Your account has been credited for the refund of the Group gift")."-___-"."#".$ggId.' - '.$currencySymbol.$giftuser['amount'];

           $logdetails = $this->addlog('admin',0,$giftuser['paiduser_id'],$ggId,$notifymsg,$messages,$loguserimage);

           if($this->isauthenticated()){
               $this->loadModel('Userdevices');
       //Push notification to buyer
               $devicestable = TableRegistry::get('Userdevices');
               $buyernotfiy = $devicestable->find()->where(['user_id'=>$giftuser['paiduser_id']])->first();

               $deviceTToken = $buyernotfiy->deviceToken;
               $deviceid = $buyernotfiy->deviceId;
               $userdeviceid = $buyernotfiy->id;
               $badge = $buyernotfiy->badge;
               $badge +=1;


               $this->Userdevices->updateAll(array('badge' =>$badge), array('deviceToken' => $deviceTToken), array('id' => $userdeviceid));

               if(isset($deviceTToken)){
                   $pushMessage['type'] = "admin_refund";
                   $user_detail = TableRegistry::get('Users')->find()->where(['id'=>$giftuser['paiduser_id']])->first();
                   I18n::locale($user_detail['languagecode']);
                   $pushMessage['message'] = __d('admin','Your account has been credited').$currencysymbol.$giftuser['amount'].__d('admin',' by for refund of group gift')." #".$ggId ;
                   $messages = json_encode($pushMessage);
                   $this->pushnot($deviceTToken,$messages,$badge);
               }
           }
       }

       $groupgiftsTable->update()->set(['status' => 'Refunded'])->where(['id' => $ggId])->execute();
       exit;
   }

   public function getcategoryData()
   {
      $categories = TableRegistry::get('Categories');
      if($_POST['type'] == 'subcategory')
      {
        $label = 'Subcategory';
        $categoriesData = $categories->find()->where([
          'category_parent'=>$_POST['category_id'],
          'category_sub_parent'=>'0'])->all();
        $onchangeEvent = 'slidersupercategory();';
      }elseif($_POST['type'] == 'supercategory'){
        $label = 'Supercategory';
        $categoriesData = $categories->find()->where(['category_sub_parent'=>$_POST['category_id']])->all();
        $onchangeEvent = '';
      }
      //If subcategory not found
      if(empty($categoriesData))
        die;

      $html = '';
      if(count($categoriesData) > 0)
      {
            $html.= '<div class="col-md-6">
                <div class="form-group">
                  <div class="input select">
                  <label for="slidertype">'.$label.'</label>
                  <select name="'.$_POST['type'].'" id="'.$_POST['type'].'" class="form-control slidereffect" onchange="'.$onchangeEvent.'">
                    <option value="">Select '.$label.'</option>';
            foreach($categoriesData as $key=>$eachCategory)
            {
              if(isset($_POST['loadcategory']) && $_POST['loadcategory'] != '')
              {
                $subcate = ($eachCategory["id"] == $_POST['loadcategory']) ? 'selected="selected"' : '';
              }else{
                $subcate = '';
              }
              $html.='<option value="'.$eachCategory["id"].'" '.$subcate.'>'.$eachCategory["category_name"].'</option>';
            }
            $html.='</select>
                    </div>
                  </div>
                  </div>';
      }
      echo $html; die;
   }

   public function featuredcat ($catid,$status) {

   $this->autoLayout = false;
   $this->autoRender = false;

   $this->loadModel('Categories');
   $categorytable = TableRegistry::get('Categories');
    $featuredcount = $this->Categories->find()->where(['featured'=>1])->count();
    if($status==1 && $featuredcount>=6){
      $this->Flash->success(__d('admin','Only 6 categories allowed as featured!'));
    }
   else{
      $featuredcatquery = $this->Categories->query();
   $featuredcatquery->update()
   ->set(['fc_categories.featured' => $status])
   ->where(['fc_categories.id' => $catid])
   ->execute();

     if($status == 1)
     {
         $this->Flash->success(__d('admin','Marked as featured successfully'));
     }
     else
     {
         $this->Flash->success(__d('admin','Marked as unfeatured successfully'));
     }
   }
  

   
}




} //E O class

