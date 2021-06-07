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
namespace App\Controller\Helps;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Component\UrlfriendlyComponent;
use Cake\Controller\Component\FlashComponent;
use Cake\View\Helper\FlashHelper;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\Model\Table\LanguagesTable;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class HelpsController extends AppController
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
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function faq() {
        $this->set('title_for_layout','FAQ');

        $this->loadModel('Faqs');
        $faq = $this->Faqs->find('all');
      
           /* foreach($faq as $faq) {
                $main = $faq['faq_question'];
                $sub = $faq['faq_answer'];


            $this->set('main',$main);
            $this->set('sub',$sub);

            }*/
            $this->set('faq',$faq);
    }

    public function contact() {
        global $loguser;
        global $setngs;
        $this->loadModel('Users');
        $this->loadModel('Helps');
        $this->set('title_for_layout','Contact');
        $contact = $this->Helps->find('all');
            foreach($contact as $contacts) {
                $address = $contacts['contact'];
            }
        $this->set('contact',$address);

        $contactaddress = json_decode($address,true);

        if(!empty($this->request->data)){
            $name = $this->request->data['contact_name'];
            $email = $this->request->data['contact_email'];
            $useremail = $this->request->data['contact_email'];
            $topic = $this->request->data['topic'];
            $order = $this->request->data['contact_order'];
            $userAccount = $this->request->data['contact_user'];
            $message = $this->request->data['contact_message'];

            if($setngs['gmail_smtp'] == 'enable'){
                $this->Email->smtpOptions = array(
                    'port' => $setngs['smtp_port'],
                    'timeout' => '30',
                    'host' => 'ssl://smtp.gmail.com',
                    'username' => $setngs['noreply_email'],
                    'password' => $setngs['noreply_password']);

                $this->Email->delivery = 'smtp';
            }
            $this->Email->to = $contactaddress['emailid'];
            $this->Email->subject = __d('user',"Enquiry from a user");
            $this->Email->from = SITE_NAME."<".$setngs['noreply_email'].">";
            $this->Email->sendAs = "html";
            $this->Email->template = 'contact_mails';
            $this->set('name', $name);
            $this->set('userAccount', $userAccount);
            $this->set('topic', $topic);
            $this->set('order',$order);
            $this->set('message',$message);
            $this->set('email',$email);


            $sitesettings = TableRegistry::get('sitesettings');
            $setngs = $sitesettings->find()->first();

            $email=$contactaddress['emailid'];
            $aSubject=__d('user',"Enquiry from a user");
            $aBody='test';
            $template='contact_mails';
            $setdata=array('name'=>$name,'userAccount'=> $userAccount,'topic'=> $topic,'order'=>$order,'message'=>$message,'email'=>$useremail,'setngs'=>$setngs);
            $this->sendmail($email,$aSubject,$aBody,$template,$setdata);
            $this->Flash->success(__d('admin','Email has been sent successfully'));
        }
    }

    public function copyright(){
        $this->loadModel('Helps');
        $this->set('title_for_layout','Copyrights');
        $copyright = $this->Helps->find('all');
            foreach($copyright as $copyrights) {
                $main = $copyrights['main_copyright'];
                $sub = $copyrights['sub_copyright'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }

    }

    public function termsSales(){
        $this->set('title_for_layout','Terms Of Sale');
        $this->loadModel('Helps');
        $termsofsale = $this->Helps->find('all');
            foreach($termsofsale as $termsofsales) {
                $main = $termsofsales['main_termsofSale'];
                $sub = $termsofsales['sub_termsofSale'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }

    public function termsService(){

        $this->set('title_for_layout','Terms Of Service');
        $this->loadModel('HelpsController');
        $termsofservice = $this->Helps->find('all');
            foreach($termsofservice as $termsofservices) {
                $main = $termsofservices['main_termsofService'];
                $sub = $termsofservices['sub_termsofService'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }
    public function termsCondition(){
        $this->set('title_for_layout','Terms Of Merchant');
        $this->loadModel('Helps');
        $termsofmerchant = $this->Helps->find('all');
            foreach($termsofmerchant as $termsofmerchants) {
                $main = $termsofmerchants['main_termsofMerchant'];
                $sub = $termsofmerchants['sub_termsofMerchant'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }

    public function privacy(){
        $this->set('title_for_layout','Privacy');
        $this->loadModel('Helps');
        $privacy = $this->Helps->find('all');
            foreach($privacy as $privacy) {
                $main = $privacy['main_privacy'];
                $sub = $privacy['sub_privacy'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }

    public function about(){
        $this->set('title_for_layout','About');
        $this->loadModel('Helps');
        $about = $this->Helps->find('all');
            foreach($about as $aboutcontent) {
               $main =  htmlspecialchars_decode(stripslashes($aboutcontent['main_about']), ENT_QUOTES);
               $sub = htmlspecialchars_decode(stripslashes($aboutcontent['sub_about']), ENT_QUOTES);
              //  $main = $aboutcontent['main_about'];
               // $sub = $aboutcontent['sub_about'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }
    public function documentation(){
        $this->set('title_for_layout','Documentation');
        $this->loadModel('Helps');
        $documentation = $this->Helps->find('all');
            foreach($documentation as $documentationcontent) {
                $main = htmlspecialchars_decode(stripslashes($documentationcontent['main_documentation']), ENT_QUOTES);
                $sub = htmlspecialchars_decode(stripslashes($documentationcontent['sub_documentation']), ENT_QUOTES);

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }
    public function press(){
        $this->set('title_for_layout','Press');
        $this->loadModel('Helps');
        $press = $this->Helps->find('all');
            foreach($press as $presscontent) {
                $main = $presscontent['main_press'];
                $sub = $presscontent['sub_press'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }
    public function pricing(){
        $this->set('title_for_layout','Pricing');
        $this->loadModel('Helps');
        $pricing = $this->Helps->find('all');
            foreach($pricing as $pricingcontent) {
                $main = $pricingcontent['main_pricing'];
                $sub = $pricingcontent['sub_pricing'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }
    public function talk(){
        $this->set('title_for_layout','Talk');
        $this->loadModel('Helps');
        $talk = $this->Helps->find('all');
            foreach($talk as $talkcontent) {
                $main = $talkcontent['main_talk'];
                $sub = $talkcontent['sub_talk'];

            $this->set('main',$main);
            $this->set('sub',$sub);
            }
    }

    public function addto(){
        $this->set('title_for_layout','Add To');
    }
    public function mobileapps(){
        global $setngs;
        $this->set('title_for_layout','Mobile Apps');
        $this->loadModel('Mobilepages');
        $mobilepagestable = TableRegistry::get('Mobilepages');
        $mobile_datas = $mobilepagestable->find()->first();
        $this->set('mobile_datas',$mobile_datas);
    }

}
