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
namespace App\Controller\Users;

use Cake\Auth\DefaultPasswordHasher;
use App\Model\Table\UsersTable;
use App\Model\Table\ShopTable;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;

class UsersController extends AppController
{
    public $components = array('Urlfriendly');
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
        $this->loadComponent('Captcha', ['field' => 'securitycode']);
        $this->loadComponent('Cookie', ['expires' => '1 day']);

    }

    public function captcha()
    {
        $this->autoRender = false;
        $this->viewBuilder()->layout('ajax');
        $this->Captcha->create();
    }

    public function index()
    {

        $sitesettings = TableRegistry::get('sitesettings');
        $setngs = $sitesettings->find()->first();
        $this->set('setngs', $setngs);
        if ($setngs['affiliate_enb'] == 'enable') {
            $itemStatus['Items.status <>'] = 'draft';
        } else {
            $itemStatus['Items.status'] = 'publish';
        }
        
        $this->loadModel('Homepagesettings');
        $homepageModel = $this->Homepagesettings->find()->first();
        global $loguser;
       // echo "loguser=<pre>";print_r($loguser);die;
        $userid = $loguser['id'];

        $itemfavtable = TableRegistry::get('Itemfavs');
        $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $this->set('setngs', $setngs);
        if (count($itemfavmodel) > 0) {
            foreach ($itemfavmodel as $itms) {
                $itmid[] = $itms->item_id;
            }


            $this->set('likeditemid', $itmid);


        }
       // echo $homepageModel['layout'];
        if ($homepageModel['layout'] == 'default') {

        // Today deals
            $date = date('d');
            $month = date('m');
            $year = date('Y');
            $today = $year . '-' . $month . '-' . $date;
            $itemsTable = TableRegistry::get('Items');
            $dailydeals = $itemsTable->find('all')->contain(['Photos'])->contain(['Shops'])->contain('Forexrates')->where(['Items.discount_type' => 'daily'])->where(['Items.dealdate' => $today])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->limit('20')->all();
            $popular_products = $itemsTable->find('all')->contain('Forexrates')->contain(['Photos'])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count' => 'DESC'])->limit('20')->all();
            $new_products = $itemsTable->find('all')->contain('Forexrates')->contain(['Photos'])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id' => 'DESC'])->limit('20')->all();
            $featured = $itemsTable->find('all')->contain('Forexrates')->contain(['Photos'])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->where(['Items.featured' => '1'])->order(['Items.id' => 'DESC'])->limit('20')->all();

            $this->set('dailydeals', $dailydeals);
            $this->set('popular_products', $popular_products);
            $this->set('recentlyaddedModel', $new_products);
            $this->set('featured', $featured);
            $this->render('index');
        } else {

            $homepagesettingstable = TableRegistry::get('Homepagesettings');
            $homepageModel = $homepagesettingstable->find('all')->first();
            $this->set('homepageModel', $homepageModel);
            $widgets = explode('(,)', $homepageModel['widgets']);
            $this->set('widgets', $widgets);
           // print_r($widgets);die;

            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            $siteChanges = $setngs['site_changes'];
            $siteChanges = json_decode($siteChanges, true);

            global $loguser;
            $this->set('profileImgStyle', $siteChanges['profile_image_view']);
            $userid = $loguser['id'];
            $user_level = $loguser['user_level'];
            $this->set('username', $username);
            if ($user_level == 'god' || $user_level == "moderator") {
                $this->redirect('/admin/');
            }
            $categoriestable = TableRegistry::get('Categories');
            
             $featuredcat=$categoriestable->find()->where(['featured'=>1])->all();
            $this->set('featuredcat', $featuredcat);
              // echo"<pre>";print_r($featuredcat);die;
            $itemstable = TableRegistry::get('Items');
            $itemfavstable = TableRegistry::get('Itemfavs');
            $itemliststable = TableRegistry::get('Itemlists');
            $shopstable = TableRegistry::get('Shops');
            $followerstable = TableRegistry::get('Followers');

            if ($setngs['affiliate_enb'] == 'enable') {
                $itemStatus['Items.status <>'] = 'draft';
            } else {
                $itemStatus['Items.status'] = 'publish';
            }
            if (isset($_SESSION['forexid'])) {
                $itemStatus['Items.countryid'] = $_SESSION['forexid'];
            }
            
            $itemCount = 8;

            //Recently added product
            //$recentlyaddedModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where([$itemStatus])->order(['Items.id DESC'])->limit($itemCount)->all();

            //$this->set('recentlyaddedModel', $recentlyaddedModel);
            $recentlyaddedModel = $this->recentProducts();
            list($recentlyaddedModel1, $recentlyaddedModel2) = array_chunk($recentlyaddedModel, ceil(count($recentlyaddedModel) / 2));
            $this->set('recentlyaddedModel1',$recentlyaddedModel1);
              $this->set('recentlyaddedModel2',$recentlyaddedModel2);

            $discountproducts=$this->discountProducts(6);
             $this->set('discountproducts',$discountproducts);

            // echo 'array1=<pre>'; print_r($array1); 
            //   echo 'array2=<pre>'; print_r($array2);
            // die;

            $commentstable = TableRegistry::get('Comments');
            $this->loadModel('Comments');
            $this->loadModel('Items');
            $query = $commentstable->find();
            $comments_datas = $commentstable->find()->select(['item_id', 'comment_count' => $query->func()->count('comments')])->order(['comment_count DESC'])->group(['Comments.item_id'])->all();
            foreach ($comments_datas as $comments) {
                $item_ids[] = $comments['item_id'];
            }
            if (!empty($item_ids)) {
                $mostcommentedModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->where(['Items.id IN' => $item_ids])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.comment_count DESC'])->limit($itemCount)->all();
            } else
            $mostcommentedModel = "";
            $this->set('mostcommentedModel', $mostcommentedModel);

            // Most popular product
            //$mostpopularModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where([$itemStatus])->order(['Items.fav_count DESC'])->limit($itemCount)->all();

            //$this->set('mostpopularModel', $mostpopularModel);
            $mostpopularModel = $this->popularProducts();
            $this->set('mostpopularModel', $mostpopularModel);

            // Today deals
            $date = date('d');
            $month = date('m');
            $year = date('Y');
            $today = $year . '-' . $month . '-' . $date;

            $todaydeal = $itemstable->find('all')->contain('Photos')->contain(['Shops'])->contain('Forexrates')->where(['Items.discount_type' => 'daily'])->where(['Items.dealdate' => $today])->where(['Items.status' => 'publish'])->order(['Items.id DESC'])->limit('8')->all();
             $itemreviews = TableRegistry::get('Itemreviews');
              foreach ($todaydeal as $key => $value) {
               // echo "id=".$value['id'];
            $itemreviewsmodel = $itemreviews->find('all')->where(['itemid' => $value['id']])->all();
            $reviewscount[]=count($itemreviewsmodel);

              }

            $this->set('todaydeal', $todaydeal);
              $this->set('reviewscount', $reviewscount);
            $shopsdet = $shopstable->find('all')->contain('Users')
            ->where(['Users.user_level' => 'shop'])
            ->where(['store_enable' => 'enable'])
            ->where(['item_count >' => '0'])
            ->where(['seller_status' => '1'])
            ->where(function ($exp, $q) {
                return $exp->notEq('Shops.user_id', '$userid');
            })->order(['Shops.follow_count DESC'])->all();


            $topshoparr = array();
            $skey = 0;
            foreach ($shopsdet as $shopdata) {
                $topshoparr[$skey]['username_url'] = $shopdata['profile_image'];
                $topshoparr[$skey]['username'] = $shopdata['username'];
                $topshoparr[$skey]['username_url_ori'] = $shopdata['username_url'];
                $topshoparr[$skey]['item_count'] = $shopdata['item_count'];
                $topshoparr[$skey]['shopid'] = $shopdata['user_id'];
                $topshoparr[$skey]['shopurl'] = $shopdata['shop_name_url'];
                $topshoparr[$skey]['shopname'] = $shopdata['shop_name'];
                $topshoparr[$skey]['shop_image'] = $shopdata['shop_image'];


                $userid = $shopdata['User']['id'];
                $topshoparr[$skey]['itemModel'] = $itemstable->find('all')->where(['Items.user_id' => $userid])
                ->where(function ($exp, $q) {
                    return $exp->notEq('Items.status', 'draft');
                })->order(['Items.fav_count DESC', 'Items.id DESC'])->limit('5')->all();

                $itemcount = $itemstable->find('all')->where(['Items.user_id' => $userid])
                ->where(function ($exp, $q) {
                    return $exp->notEq('Items.status', 'draft');
                })->order(['Items.fav_count DESC', 'Items.id DESC'])->all();

                $topshoparr[$skey]['item_count'] = count($itemcount);
                $this->set('itemcount', $itemcount);
                $skey += 1;
            }
            $this->set('shopsdet', $topshoparr);
            $this->set('discount_items',$this->discountProducts());

            $categoryProducts = $this->categoryProducts($homepageModel->categories);
            $topRated = $this->topRatedproducts(2);
            $suggestedItems = $this->suggestedItems($loguser['id']);
            $topStores = $this->popularStores(3);
             $this->set('topStores',$topStores);
               $this->set('topRated',$topRated);
           // echo '<pre>'; print_r($topRated); die;

            // Featured Items

            //$featuredModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where([$itemStatus])->where(['Items.featured' => '1'])->order(['Items.id DESC'])->limit($itemCount)->all();

            $featuredModel = $this->featuredProducts();

            $categoriestable = TableRegistry::get('Categories');
            $colorstable = TableRegistry::get('Colors');
            $pricestable = TableRegistry::get('Prices');
            $this->loadModel('Colors');
            $this->loadModel('Prices');
            $this->loadModel('Categories');
            $parent_categories = $categoriestable->find()->where(['category_parent'=>0])->where(['category_sub_parent'=>0])->all();
            foreach ($parent_categories as $parent_cat) {
                $parentcatid = $parent_cat['id'];
                $subcategories = $categoriestable->find()->where(['category_parent'=>$parentcatid])->where(['category_sub_parent'=>0])->all();
                foreach ($subcategories as $subkey => $sub_cat) {
                    $subcatid = $sub_cat['id'];
                    $sub_categories[$parentcatid][$subkey]['categoryid'] = $sub_cat['id'];
                    $sub_categories[$parentcatid][$subkey]['category_name'] = $sub_cat['category_name'];
                    $sub_categories[$parentcatid][$subkey]['category_urlname'] = $sub_cat['category_urlname'];
                    $supercategories = $categoriestable->find()->where(['category_parent'=>$parentcatid])->where(['category_sub_parent'=>$subcatid])->all();
                    foreach ($supercategories as $superkey => $super_cat) {
                        $supercatid = $super_cat['id'];
                            $super_categories[$parentcatid][$subcatid][$superkey]['categoryid'] = $super_cat['id'];
                        $super_categories[$parentcatid][$subcatid][$superkey]['category_name'] = $super_cat['category_name'];
                        $super_categories[$parentcatid][$subcatid][$superkey]['category_urlname'] = $super_cat['category_urlname'];
                    }
                }

            }
            $price_val = $this->Prices->find('all');
            $color_val = $this->Colors->find('all');   

            $itemstable = TableRegistry::get('Items');
            $this->loadModel('Items');
            $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish'])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('18')->all();
            $this->set('item',$itemByCategory);

            $this->set('parent_categories',$parent_categories);
            $this->set('sub_categories',$sub_categories);
            $this->set('super_categories',$super_categories);
            $this->set('color_val',$color_val);
            $this->set('price_val',$price_val);

            $this->set('featuredModel', $featuredModel);
            $this->set('suggestedModel', $suggestedItems);
            $this->set('topratedModel',$topRated);
            $this->set('categoryModel',$categoryProducts);
            $this->set('topstoreModel', $topStores);
            $this->render('customhome');
        }
    }

    function featuredProducts()
    {

        $this->loadModel('Items');
        $this->loadModel('Followers');
        $favitems_ids = array();
        $items_data = array();
        $offset=0;
        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            $limit = 20;
        }
        if (isset($_POST['offset'])) {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'featured' => 1,
                    'status' => 'publish'
                    
                ),
                'limit' => $limit,
                'offset' => $_POST['offset'],
                'order'=>'Items.id DESC'
            ))->contain('Forexrates')->where(['Items.affiliate_commission IS NULL']);

        } else {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'featured' => 1,
                    'status' => 'publish'
                    // 'affiliate_commission' => ''
                ),
                'limit' => $limit,
                'order'=>'Items.id DESC'
            ))->contain('Forexrates')->where(['Items.affiliate_commission IS NULL']);
        }


        if (empty($items_data)) {
            echo '{"status":"false","message":"No data found"}';
            die;
        } else {
            $resultArray = $this->convertJsonHome($items_data, $favitems_ids, $_POST['user_id']);
          //  echo"Alohomora<pre>";print_r($resultArray);die;
            return $resultArray;
            
        }
    }


    function getMorePosts()
    {
        $this->autoRender = false;
        $this->loadModel('Item');
        $itemstable = TableRegistry::get('Items');
        $startIndex = $_GET['startIndex'];
        $page = ($startIndex / 20) + 1;
        $offset = $_GET['offset'];
        $followingId = explode(',', $_GET['followid']);
        global $username;
        global $user_level;
        global $loguser;
        global $setngs;
        global $siteChanges;

        $roundProf = "";
        if ($siteChanges['profile_image_view'] == "round") {
            $roundProf = "border-radius:40px;";
        }
        $userid = $loguser['id'];

        $sitesettings = TableRegistry::get('sitesettings');
        $setngs = $sitesettings->find()->first();
        if ($setngs['affiliate_enb'] == 'enable') {
            $itemStatus['Items.status <>'] = 'draft';
        } else {
            $itemStatus['Items.status'] = 'publish';
        }
        
        $date = date('d');
        $month = date('m');
        $year = date('Y');
        $today = $year . '-' . $month . '-' . $date;
        $itemsTable = TableRegistry::get('Items');
        if ($_GET['loadmoretab'] == 'dailydealspdt') {
            $items_data = $itemsTable->find('all')->contain(['Photos'])->contain('Forexrates')->where(['Items.dailydeal' => 'yes'])->where(['Items.dealdate' => $today])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->limit($offset)->page($page)->all();
        } else if ($_GET['loadmoretab'] == 'popularpdt') {
            $items_data = $itemsTable->find('all')->contain('Forexrates')->contain(['Photos'])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count' => 'DESC'])->limit($offset)->page($page)->all();
        } else if ($_GET['loadmoretab'] == 'arrivalpdt') {
            $items_data = $itemsTable->find('all')->contain('Forexrates')->contain(['Photos'])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id' => 'DESC'])->limit($offset)->page($page)->all();
        } else if ($_GET['loadmoretab'] == 'featured') {
            $items_data = $itemsTable->find('all')->contain('Forexrates')->contain(['Photos'])->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->where(['Items.featured' => '1'])->order(['Items.id' => 'DESC'])->limit($offset)->page($page)->all();
        }

        if (count($items_data) != 0) {
            foreach ($items_data as $key => $itms) {
                $itemid = base64_encode($itms->id . "_" . rand(1, 9999));

                $item_title = $itms['item_title'];
                $item_title_url = $itms['item_title_url'];
                $item_price = $itms['price'];
                $favorte_count = $itms['fav_count'];
                $username = $itms['user']['username'];
                $currencysymbol = $itms['forexrate']['currency_symbol'];
                $items_image = $itms['photos'][0]['image_name'];

                $sizeoptions = json_decode($itms['size_options'], true);
                foreach ($sizeoptions['price'] as $key => $value) {
                    $price[] = $value;
                }
                if (count($sizeoptions) > 0)
                    $itemprice = $price[0];
                else
                    $itemprice = $itms['price'];
                $currencycomponent = $this->Currency;
                $user_currency_price = $currencycomponent->conversion($itms['forexrate']['price'], $_SESSION['currency_value'], $itemprice);

                echo '<span id="figcaption_titles' . $itms['id'] . '" figcaption_title ="' . $item_title . '" ></span>';
                echo '<span class="figcaption" id="figcaption_title_url' . $itms['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
                echo '<span id="price_vals' . $itms['id'] . '" price_val="' . $_SESSION['currency_symbol'] . $user_currency_price . '" ></span>';
                echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $itms['id'] . '" usernameval ="' . $username . '"></a>';
                echo '<span id="img_' . $itms['id'] . '" class="nodisply">' . SITE_URL . 'media/items/original/' . $items_image . '</span>';
                echo '<span class="fav_count" id="fav_count' . $itms['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';


                $item_image = $itms['photos'][0]['image_name'];
                if ($item_image == "") {
                    $itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
                } else {
                    $itemimage = WWW_ROOT . 'media/items/original/' . $item_image;
                    if (file_exists($itemimage)) {
                        $itemimage = SITE_URL . 'media/items/original/' . $item_image;
                    } else {
                        $itemimage = SITE_URL . 'media/items/original/usrimg.jpg';
                    }
                }

                echo '<div class="item">
                <div class="grid cs-style-3 no-hor-padding">
                <div class="image-grid col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                <div><figure class="animate-box bounceIn animated">
                <a href="' . SITE_URL . 'listing/' . $itemid . '" class="img-hover fh5co-board-img">
                <img class="img-responsive" src="' . $itemimage . '" alt="img">

                </a>
                <div class="hover-visible">
                <span class="hover-icon-cnt like_hover" href="javascript:void(0)" onclick="itemcou(' . $itms['id'] . ')">
                <i class="fa fa-heart-o like-icon' . $itms['id'] . '"></i>
                <span class="like-txt' . $itms['id'] . ' nodisply">' . $setngs['like_btn_cmnt'] . '</span>
                </span>
                <span class="hover-icon-cnt share_hover cur" onclick="share_posts(' . $itms['id'] . ')" href="javascript:void(0)" data-toggle="modal" data-target="#share-modal"><img src="' . SITE_URL . 'images/icons/share_icon.png"></span>
                </div>
                </figure></div>
                <div class="rate_section bold-font col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                <div class="product_name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                <a href="">' . $itms->item_title . '</a></div>
                <div class="price col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                ';
                if (isset($_SESSION['currency_code']))
                    echo $_SESSION['currency_symbol'] . $user_currency_price;
                else
                    echo $itms['forexrate']['currency_symbol'] . $itemprice;
                echo '
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>';
                echo '~|~';

            }
        } else {
            echo 'false';
        }

    }

    public function forgotpassword()
    {
        $this->set('title_for_layout', 'Forgot Password ');
        global $setngs;
        global $loguser;
        if (!empty($loguser['id'])) {
            $this->redirect('/');
        }

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

        if (!empty($this->request->data)) {
            $email = $this->request->data['email'];

            $userstable = TableRegistry::get('Users');
            $usr_datas = $userstable->find()->where(['email' => $email])->first();
            if (count($usr_datas) > 0) {


                $name = $usr_datas['first_name'];
                $reg_email = $usr_datas['email'];
                $use_id = $usr_datas['id'];
                $uniquecode_pass = $this->Urlfriendly->get_uniquecode(6);

                if (!empty($reg_email)) {
                    if ($usr_datas['user_status'] == 'enable' && $usr_datas['activation'] == 1) {


                        $email = $reg_email;
                        $aSubject = $setngs['site_name'] . " – " . __d('user', 'Your new password has arrived');
                        $aBody = '';
                        $template = 'passwordreset';
                        $emailid = base64_encode($reg_email);
                        $time = time();
                        $setdata = array('name' => $name, 'reg_email' => $reg_email, 'uniquecode_pass' => $uniquecode_pass, 'access_url' => SITE_URL . "setpassword/" . $emailid . "~" . $time);
                        $this->sendmail($email, $aSubject, $aBody, $template, $setdata);


                        if ($setngs['gmail_smtp'] == 'enable') {
                            $this->Email->smtpOptions = array(
                                'port' => $setngs['smtp_port'],
                                'timeout' => '30',
                                'host' => 'ssl://smtp.gmail.com',
                                'username' => $setngs['noreply_email'],
                                'password' => $setngs['noreply_password']
                            );

                            $this->Email->delivery = 'smtp';
                        }
                        $this->Email->to = $reg_email;
                        $this->Email->subject = SITE_NAME . " – Your new password has arrived";
                        $this->Email->from = SITE_NAME . "<" . $setngs['noreply_email'] . ">";
                        $this->Email->sendAs = "html";
                        $this->Email->template = 'passwordreset';
                        $this->set('reg_email', $reg_email);
                        $this->set('name', $name);
                        $this->set('uniquecode_pass', $uniquecode_pass);
                        $emailid = base64_encode($reg_email);
                        $time = time();
                        $this->set('access_url', SITE_URL . "setpassword/" . $emailid . "~" . $time);
                        $this->Flash->error(__d('user', 'Please Check your email immediately.'));
                        $this->redirect('/');

                    } else {
                        $this->Flash->error(__d('user', 'Please Activate your account.'));
                        $this->redirect($this->referer());

                    }
                }

            } else {
                $this->Flash->error(__d('user', 'Email id is not found Please register to our site.'));

                $this->redirect($this->referer());
            }
        }
    }

    public function setpassword($userid = null)
    {
        $this->set('title_for_layout', 'Set Password ');
        $userval = explode("~", $userid);
        global $setngs;

        $email = base64_decode($userval[0]);
        $veri_code = $userval[1];

        $this->loadModel('User');

        $userstable = TableRegistry::get('Users');
        if (count($this->request->data) > 0) {
            $email = $this->request->data['email'];
            $veri_code = $this->request->data['verify_pass'];

            $userdatas = $userstable->find()->where(['email' => $email])->first();

            $this->request->data['User']['id'] = $userdatas['id'];
            $password = $this->request->data['newpassword'];
            $userdatas->password = (new DefaultPasswordHasher)->hash($password);
            $userdatas->verify_pass = $veri_code;
            $userstable->save($userdatas);
            $this->Flash->success(__d('user', 'Your new password was generated successfully.'));
            $this->redirect('/login');
        } else {
            $userdetails = $userstable->find()->where(['email' => $email])->where(['verify_pass' => $veri_code])->first();
            if (count($userdetails) > 0) {
                $this->Flash->error(__d('user', 'Access Denied.'));
                $this->redirect('/login');
            }
        }
        $this->set('email', $email);
        $this->set('veri_pass', $veri_code);

    }

    public function customhome()
    {
        $homepagesettingstable = TableRegistry::get('Homepagesettings');
        $homepageModel = $homepagesettingstable->find('all')->first();
        $this->set('homepageModel', $homepageModel);

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $siteChanges = $setngs['site_changes'];
        $siteChanges = json_decode($siteChanges, true);

        global $loguser;
        $this->set('profileImgStyle', $siteChanges['profile_image_view']);
        $userid = $loguser['id'];
        $user_level = $loguser['user_level'];
        $this->set('username', $username);
        if ($user_level == 'god' || $user_level == "moderator") {
            $this->redirect('/admin/');
        }
        $categoriestable = TableRegistry::get('Categories');
        $itemstable = TableRegistry::get('Items');
        $itemfavtable = TableRegistry::get('Itemfavs');
        $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();
        print_r($itemfavmodel);
        die;
        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $this->set('setngs', $setngs);
        if (count($itemfavmodel) > 0) {
            foreach ($itemfavmodel as $itms) {
                $itmid[] = $itms->item_id;
            }

            $this->set('likeditemid', $itmid);


        }
        $itemliststable = TableRegistry::get('Itemlists');
        $shopstable = TableRegistry::get('Shops');
        $followerstable = TableRegistry::get('Followers');


        if ($setngs['affiliate_enb'] == 'enable') {
            $itemStatus['Items.status <>'] = 'draft';
        } else {
            $itemStatus['Items.status'] = 'publish';
        }
        if (isset($_SESSION['forexid'])) {
            $itemStatus['Items.countryid'] = $_SESSION['forexid'];
        }
        $itemCount = 8;

            //Recently added product
        $recentlyaddedModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where([$itemStatus])->order(['Items.id DESC'])->limit($itemCount)->all();

        $this->set('recentlyaddedModel', $recentlyaddedModel);

            // Most popular product
        $mostpopularModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where([$itemStatus])->order(['Items.fav_count DESC'])->limit($itemCount)->all();

        $this->set('mostpopularModel', $mostpopularModel);

            // Today deals
        $date = date('d');
        $month = date('m');
        $year = date('Y');
        $today = $year . '-' . $month . '-' . $date;
        $todaydeal = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where(['Items.dailydeal' => 'yes'])->where(['Items.dealdate' => $today])->where(['Items.status' => 'publish'])->limit('8')->all();

        $this->set('todaydeal', $todaydeal);


        $shopsdet = $shopstable->find('all')->contain('Users')
        ->where(['Users.user_level' => 'shop'])
        ->where(['store_enable' => 'enable'])
        ->where(['item_count >' => '0'])
        ->where(['seller_status' => '1'])
        ->where(function ($exp, $q) {
            return $exp->notEq('Shops.user_id', '$userid');
        })->order(['item_count DESC', 'Shops.follow_count DESC'])->all();


        $topshoparr = array();
        $skey = 0;
        foreach ($shopsdet as $shopdata) {
            $topshoparr[$skey]['username_url'] = $shopdata['profile_image'];
            $topshoparr[$skey]['username'] = $shopdata['username'];
            $topshoparr[$skey]['username_url_ori'] = $shopdata['username_url'];
            $topshoparr[$skey]['item_count'] = $shopdata['item_count'];
            $topshoparr[$skey]['shopid'] = $shopdata['user_id'];
            $topshoparr[$skey]['shopurl'] = $shopdata['shop_name_url'];
            $topshoparr[$skey]['shopname'] = $shopdata['shop_name'];
            $topshoparr[$skey]['shop_image'] = $shopdata['shop_image'];


            $userid = $shopdata['User']['id'];
            $topshoparr[$skey]['itemModel'] = $itemstable->find('all')->where(['Items.user_id' => $userid])
            ->where(function ($exp, $q) {
                return $exp->notEq('Items.status', 'draft');
            })->order(['Items.fav_count DESC', 'Items.id DESC'])->limit('5')->all();

            $itemcount = $itemstable->find('all')->where(['Items.user_id' => $userid])
            ->where(function ($exp, $q) {
                return $exp->notEq('Items.status', 'draft');
            })->order(['Items.fav_count DESC', 'Items.id DESC'])->all();

            $topshoparr[$skey]['item_count'] = count($itemcount);
            $this->set('itemcount', $itemcount);
            $skey += 1;
        }
        $this->set('shopsdet', $topshoparr);

            // Featured Items

        $featuredModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where([$itemStatus])->where(['Items.featured' => '1'])->order(['Items.id DESC'])->limit($itemCount)->all();

        $this->set('featuredModel', $featuredModel);
    }
    public function customviewmore($viewMoreType)
    {
        global $loguser;
        $userid = $loguser['id'];
        $this->loadModel('Categories');
        $this->loadModel('Items');
        $this->loadModel('Itemfavs');
        $this->loadModel('Itemlists');

        $itemstable = TableRegistry::get('Items');



        $userid = $loguser['id'];

        $itemfavtable = TableRegistry::get('Itemfavs');
        $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $this->set('setngs', $setngs);
        if (count($itemfavmodel) > 0) {
            foreach ($itemfavmodel as $itms) {
                $itmid[] = $itms->item_id;
            }

            $this->set('likeditemid', $itmid);


        }

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

        if ($setngs == 'enable') {
            $itemStatus['Items.status <>'] = 'draft';
        } else {
            $itemStatus['Items.status'] = 'publish';
        }
        $itemStatus['Shops.seller_status'] = 1;
        $itemStatus['Users.user_status'] = 'enable';


        $this->loadModel('Homepagesettings');
        $homepageModel = $this->Homepagesettings->find()->first();


        switch ($viewMoreType) {
            case 'recent':
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('20')->all();

            $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->count();
            $this->set('pagetitle', 'Recently Added');
            break;
            case 'dailydeals':
            $date = date('d');
            $month = date('m');
            $year = date('Y');
            $today = $year . '-' . $month . '-' . $date;
            $itemModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where(['Items.discount_type' => 'daily'])->where(['Items.dealdate' => $today])->where(['Items.affiliate_commission IS NULL'])->where(['Items.status' => 'publish'])->limit('20')->all();

            $countitemModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where(['Items.dailydeal' => 'yes'])->where(['Items.dealdate' => $today])->where(['Items.affiliate_commission IS NULL'])->where(['Items.status' => 'publish'])->count();
            $this->set('pagetitle', 'Daily Deals');
            break;
            case 'popular':
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count DESC'])->limit('20')->all();
            $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count DESC'])->count();
            $this->set('pagetitle', 'Most Popular');
            break;
            case 'discountproducts';
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus,'discount_type '=>'regular'])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('20')->all();
            $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count DESC'])->count();
            $this->set('pagetitle', 'Most Popular');
            break;
            case 'categories';
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus,'category_id'=>$homepageModel->categories])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count DESC'])->limit('20')->all();
            $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count DESC'])->count();
            $this->set('pagetitle', 'Categories');
            break;
            case 'toprated';
            $itemModel = $this->topRatedproducts_viewmore();
            $countitemModel = count($itemModel);
            $this->set('pagetitle', 'Top rated products');
            break;
            case 'suggesteditem';
            $itemModel = $this->suggestitem_viewmore();
            $countitemModel = count($itemModel);
            $this->set('pagetitle', 'Suggested Items');
            break;
            //$this->topRatedproducts();
            //suggestitem_viewmore
            case 'mostcommented':
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.comment_count DESC'])->limit('20')->all();
            $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.comment_count DESC'])->count();
            $this->set('pagetitle', 'Most Commented');
            break;
            case 'featured':
            $itemStatus['Items.featured'] = '1';
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('20')->all();
            $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->count();
            break;
            case 'topratedstores':
            $itemModel = $this->popularStores();
            $countitemModel = count($itemModel);
            break;

            //popularStores
        }

        //echo '<pre>'; print_r($itemModel); die;
        $prnt_cat_data = $this->Categories->find('all', array('conditions' => array('category_parent' => 0, 'category_sub_parent' => 0)));

        $items_list_data = $this->Itemlists->find('all', array('conditions' => array('user_id' => $userid, 'user_create_list' => '1')));

        $this->set('prnt_cat_data', $prnt_cat_data);
        $this->set('items_data', $itemModel);
        $this->set('countitemModel', $countitemModel);
        $this->set('userid', $userid);
        $this->set('loguser', $loguser);
        $this->set('items_list_data', $items_list_data);
        $this->set('setngs', $setngs);
        $this->set('viewType', $viewMoreType);
    }


    function customviewmorestore($value='')
    {
        $this->loadModel('Shops');
        $this->loadModel('Storefollowers');
        $this->loadModel('Sitesettings');

        //echo 'tes'; die;
        $userId = $_POST['user_id'];

        $offset = 0;
        $limit = 30;
        if (isset($_POST['offset'])) {
            $offset = $_POST['offset'];
        }
        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        }
        $setngs = $this->Sitesettings->find()->toArray();
        if (SITE_URL == $setngs[0]['media_url']) {
            $img_path = $setngs[0]['media_url'];
        } else {
            $img_path = $setngs[0]['media_url'];
        }

        if (isset($_POST['offset'])) {
            $shopsdet = $this->Shops->find('all', array(
                'conditions' => array('seller_status' => 1, 'item_count >' => '0', 'store_enable' => 'enable'),
                'limit' => $limit,
                'offset' => $_POST['offset'],
                'order' => 'follow_count DESC',
            ));

        } else {
            $shopsdet = $this->Shops->find('all', array(
                'conditions' => array('seller_status' => 1, 'item_count >' => '0', 'store_enable' => 'enable'),
                'limit' => $limit,
                'order' => 'follow_count DESC',
            ));
        }



        foreach ($shopsdet as $key => $shops) {

            $profileimage = $shops['shop_image'];
            if (empty($profileimage)) {
                $profileimage = "usrimg.jpg";
            }
            $storeid = $shops['id'];

            $followers = $this->Storefollowers->find()->where(['store_id' => $storeid])->all();//all',array('conditions'=>array('Storefollower.store_id'=>$storeid)));
            $flwrusrids = array();
            foreach ($followers as $follower) {
                $flwrusrids[] = $follower['follow_user_id'];
            }
            $resultarray[$key]['store_id'] = $shops['id'];
            $resultarray[$key]['shop_name_url'] = $shops['shop_name_url'];
            $resultarray[$key]['store_name'] = $shops['shop_name'];
            $resultarray[$key]['wifi'] = $shops['wifi'];
            $resultarray[$key]['merchant_name'] = $shops['merchant_name'];

            if (in_array($userId, $flwrusrids)) {
                $resultarray[$key]['status'] = 'unfollow';
            } else {
                $resultarray[$key]['status'] = 'follow';
            }
            $resultarray[$key]['image'] = $img_path . 'media/avatars/thumb150/' . $profileimage;
        }

        $this->set('popularstores',$resultarray);
        
        //die;
    }

    function getviewmore()
    {
        global $username;
        global $user_level;
        global $loguser;
        global $setngs;
        global $siteChanges;
        $startIndex = $_GET['startIndex'];
        $offset = $_GET['offset'];
        $viewMoreType = $_GET['viewmoretype'];
        $page = ($startIndex / 20) + 1;

        $roundProf = "";
        if ($siteChanges['profile_image_view'] == "round") {
            $roundProf = "border-radius:40px;";
        }
        $userid = $loguser['id'];


        $itemfavtable = TableRegistry::get('Itemfavs');
        $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $this->set('setngs', $setngs);
        if (count($itemfavmodel) > 0) {
            foreach ($itemfavmodel as $itms) {
                $itmid[] = $itms->item_id;
            }

            $this->set('likeditemid', $itmid);


        }

        if ($setngs[0]['Sitesetting']['affiliate_enb'] == 'enable') {
            $itemStatus['Items.status <>'] = 'draft';
        } else {
            $itemStatus['Items.status'] = 'publish';
        }

        $itemstable = TableRegistry::get('Items');
        switch ($viewMoreType) {
            case 'recent':
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('20')->page($page)->all();
            $this->set('pagetitle', 'Recently Added');
            break;
            case 'dailydeals':
            $date = date('d');
            $month = date('m');
            $year = date('Y');
            $today = $year . '-' . $month . '-' . $date;
            $itemModel = $itemstable->find('all')->contain('Photos')->contain('Forexrates')->where(['Items.dailydeal' => 'yes'])->where(['Items.dealdate' => $today])->where(['Items.status' => 'publish'])->where(['Items.affiliate_commission IS NULL'])->limit('20')->page($page)->all();
            $this->set('pagetitle', 'Daily Deals');
            break;
            case 'popular':
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count DESC'])->limit('20')->page($page)->all();
            $this->set('pagetitle', 'Most Popular');
            break;
            case 'mostcommented':
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.comment_count DESC'])->limit('20')->page($page)->all();
            $this->set('pagetitle', 'Most Commented');
            break;
            case 'featured':
            $itemStatus['Items.featured'] = '1';
            $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('20')->page($page)->all();

        }
        $this->set('items_data', $itemModel);
        $this->set('roundProf', $roundProf);



    }


    function getviewmorestore()
    {
        $this->loadModel('Shops');
        $this->loadModel('Storefollowers');
        $this->loadModel('Sitesettings');
        $userId = $_POST['user_id'];

        global $username;
        global $user_level;
        global $loguser;
        global $setngs;
        global $siteChanges;
        $startIndex = $_GET['startIndex'];
        $offset = $_GET['offset'];
        $viewMoreType = $_GET['viewmoretype'];
        $page = ($startIndex / 20) + 1;

         $setngs = $this->Sitesettings->find()->toArray();
        if (SITE_URL == $setngs[0]['media_url']) {
            $img_path = $setngs[0]['media_url'];
        } else {
            $img_path = $setngs[0]['media_url'];
        }

        if (isset($_POST['offset'])) {
            $shopsdet = $this->Shops->find('all', array(
                'conditions' => array('seller_status' => 1, 'item_count >' => '0', 'store_enable' => 'enable'),
                'limit' => $offset,
                'offset' => $startIndex,
                'order' => 'follow_count DESC',
            ));

        } else {
            $shopsdet = $this->Shops->find('all', array(
                'conditions' => array('seller_status' => 1, 'item_count >' => '0', 'store_enable' => 'enable'),
                'limit' => $offset,
                'offset' => $startIndex,
                'order' => 'follow_count DESC',
            ));
        }



        foreach ($shopsdet as $key => $shops) {

            $profileimage = $shops['shop_image'];
            if (empty($profileimage)) {
                $profileimage = "usrimg.jpg";
            }
            $storeid = $shops['id'];

            $followers = $this->Storefollowers->find()->where(['store_id' => $storeid])->all();//all',array('conditions'=>array('Storefollower.store_id'=>$storeid)));
            $flwrusrids = array();
            foreach ($followers as $follower) {
                $flwrusrids[] = $follower['follow_user_id'];
            }
            $resultarray[$key]['store_id'] = $shops['id'];
            $resultarray[$key]['shop_name_url'] = $shops['shop_name_url'];
            $resultarray[$key]['store_name'] = $shops['shop_name'];
            $resultarray[$key]['wifi'] = $shops['wifi'];
            $resultarray[$key]['merchant_name'] = $shops['merchant_name'];

            if (in_array($userId, $flwrusrids)) {
                $resultarray[$key]['status'] = 'unfollow';
            } else {
                $resultarray[$key]['status'] = 'follow';
            }
            $resultarray[$key]['image'] = $img_path . 'media/avatars/thumb150/' . $profileimage;
        }

        $this->set('popularstores',$resultarray);
    }


    public function login()
    {
        if ($this->isauthenticated()) {
            $this->redirect('/');
        }
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);

            if ($user->errors()) {
                $error_msg = [];
                foreach ($user->errors() as $errors) {
                    if (is_array($errors)) {
                        foreach ($errors as $error) {
                            $error_msg[] = $error;
                        }
                    } else {
                        $error_msg[] = $errors;
                    }
                }

                if (!empty($error_msg)) {
                    $this->Flash->error(__d('user', "Please fix the following error(s):") . implode("\n \r", $error_msg));
                }
            } else {

                $user = $this->Auth->identify();


                if (empty($user)) {
                    $getemailval = $this->request->data('email');
                    $this->set('getemailval', $getemailval);
                    $_SESSION['loginError'] = 'Invalid username or password, try again';
                } else if ($user['user_level'] != 'normal') {
                            $_SESSION['ismerchant'] = 1;// to show merchant login popup if user is merchant

                            return $this->redirect('/login');
                        } else if ($user['activation'] == 0) {
                            $this->Flash->error(__d('user', 'Please activate your account by the email sent to you'));
                            return $this->redirect('/');
                        } else if ($user['user_status'] == 'disable' && $user['checkdisabled'] == '0') {
                            $this->Flash->error(__d('user', 'Your account has been disabled please contact our support'));
                            return $this->redirect('/');
                        } else if ($user['user_status'] == 'disable' && $user['checkdisabled'] == '1') {
                            if ($user) {

                                $this->Auth->setUser($user);

                                $this->Cookie->delete('User');
                                if ($this->request->data['remember'] == "1") {
                                    $this->Cookie->delete('User');
                                    $cookie['email'] = $this->request->data['email'];
                                    $cookie['pass'] = base64_encode($this->request->data['password']);
                                    $this->Cookie->write('User', $cookie, true, '+2 weeks');
                                    $cookieval = $this->Cookie->read('User');
                                }

                                return $this->redirect('/');
                            }
                        } else if ($user['user_level'] == 'normal' && $user['user_status'] == 'enable' && $user['activation'] == '1') {
                            if ($user) {
                                $this->Auth->setUser($user);

                                $this->Cookie->delete('User');
                                if ($this->request->data['remember'] == "1") {
                                    $this->Cookie->delete('User');
                                    $cookie['email'] = $this->request->data['email'];
                                    $cookie['pass'] = base64_encode($this->request->data['password']);
                                    $this->Cookie->write('User', $cookie, true, '+2 weeks');
                                    $cookieval = $this->Cookie->read('User');
                                }
                                
                                $last_login = date('Y-m-d H:i:s');
                                $emailid = base64_encode($user['email']);
                                $refer_key = $user['refer_key'];
                                if (strtotime($user['last_login']) == "") {

                                    return $this->redirect('/verification/' . $emailid . "~" . $refer_key);
                                } else {
                                    $this->Users->updateAll(array('last_login' => $last_login), array('id' => $user['id']));

                                    return $this->redirect('/');
                                }
                            }
                        }

                    }
                }
            }

            public function signup($referrer = null)
            {
                global $setngs;
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                $this->set('setngs', $setngs);

                $username = "";
                $firstname = "";
                $email = "";
                $userstable = TableRegistry::get('Users');

                if (!empty($_GET['referrer'])) {
                    $reffername = $_GET['referrer'];
                    $usr_datas = $userstable->find()->where(['username' => $reffername])->first();
                    $refferrer_user_id = $usr_datas['id'];
                }
                if (!empty($referrer)) {
                    $reffername = $referrer;
                    $usr_datas = $userstable->find()->where(['username' => $reffername])->first();
                    $refferrer_user_id = $usr_datas['id'];
                }
                $this->set('referrer', $referrer);
                if ($this->isauthenticated()) {
                    $this->redirect('/');
                }
                if (!empty($this->request->data)) {

                    $captcha1 = $this->request->data['securitycode'];
                    $getc = $this->Captcha->getCode('securitycode');

                    $username = $_SESSION['username'] = $this->request->data['data']['signup']['username'];
                    $firstname = $_SESSION['firstname'] = $this->request->data['data']['signup']['firstname'];
                    $phone = $this->request->data['data']['signup']['phone'];
                    $email = $_SESSION['email'] = $this->request->data['data']['signup']['email'];
                    $password = $_SESSION['password'] = $this->request->data['data']['signup']['password'];
                    $nmecounts = $userstable->find()->where(['username' => $username])->count();
                    $emlcounts = $userstable->find()->where(['email' => $email])->count();

                    if (!empty($referrer)) {
                        $this->set('refferrer_user_id', $refferrer_user_id);
                    }
                    if (!empty($_GET['referrer'])) {
                        $this->set('refferrer_user_id', $refferrer_user_id);
                    }

                    if ($nmecounts > 0 && $emlcounts > 0) {
                        $user_name = $username;
                        $this->set('user_name', $user_name);
                        $username = $_SESSION['username'] = $this->request->data['data']['signup']['username'];
                        $firstname = $_SESSION['firstname'] = $this->request->data['data']['signup']['firstname'];
                        $email = $_SESSION['email'] = $this->request->data['data']['signup']['email'];
                        $this->set('username', $username);
                        $this->set('firstname', $firstname);
                        $this->set('email', $email);
                        $this->Flash->error(__d('user', 'username and email already exists'));
                    } else if ($nmecounts > 0) {
                        $username = $_SESSION['username'] = $this->request->data['data']['signup']['username'];
                        $firstname = $_SESSION['firstname'] = $this->request->data['data']['signup']['firstname'];
                        $email = $_SESSION['email'] = $this->request->data['data']['signup']['email'];
                        $this->set('username', $username);
                        $this->set('firstname', $firstname);
                        $this->set('email', $email);
                        $this->Flash->error(__d('user', 'username already exists'));
                    } else if ($emlcounts > 0) {
                        $username = $_SESSION['username'] = $this->request->data['data']['signup']['username'];
                        $firstname = $_SESSION['firstname'] = $this->request->data['data']['signup']['firstname'];
                        $email = $_SESSION['email'] = $this->request->data['data']['signup']['email'];
                        $this->set('username', $username);
                        $this->set('firstname', $firstname);
                        $this->set('email', $email);
                        $this->Flash->error(__d('user', 'Email already exists'));
                    } else if ($getc != $captcha1) {
                        $username = $_SESSION['username'] = $this->request->data['data']['signup']['username'];
                        $firstname = $_SESSION['firstname'] = $this->request->data['data']['signup']['firstname'];
                        $email = $_SESSION['email'] = $this->request->data['data']['signup']['email'];
                        $this->set('username', $username);
                        $this->set('firstname', $firstname);
                        $this->set('email', $email);
                        $this->Flash->error(__d('user', "Captcha code Invalid"));
                    } else {
                        $userdatas = $userstable->newEntity();
                        $name = $userdatas->username = $username;
                        $urlname = $userdatas->username_url = $this->Urlfriendly->utils_makeUrlFriendly($username);
                        $userdatas->first_name = $firstname;
                        $userdatas->phone = $phone;
                        $emailaddress = $userdatas->email = $this->request->data['data']['signup']['email'];
                        $userdatas->password = (new DefaultPasswordHasher)->hash($this->request->data['data']['signup']['password']);

                        if (!empty($this->request->data['refferid'])) {
                            $reff_id['reffid'] = $this->request->data['refferid'];
                            $reff_id['first'] = 'first';

                            $json_ref_id = json_encode($reff_id);
                        } else {
                            $json_ref_id = 0;
                        }

                        $reffer_id = $userdatas->referrer_id = $json_ref_id;
                        $userdatas->user_level = 'normal';

                        if ($setngs['signup_active'] == 'no') {
                            $userdatas->activation = '1';
                            $userdatas->user_status = 'enable';
                            $userdatas->credit_points = $setngs['signup_credit'];
                        } else {
                            $userdatas->user_status = 'disable';
                        }
                        $userdatas->push_notifications = '{"somone_flw_push":"1",
                        "somone_cmnts_push":"1","somone_mentions_push":"1","somone_likes_ur_item_push":"1",
                        "frends_flw_push":1,"frends_cmnts_push":1}';
                        $userdatas->created_at = date('Y-m-d H:i:s');
                        $uniquecode = $this->Urlfriendly->get_uniquecode(8);
                        $refer_key = $userdatas->refer_key = $uniquecode;
                        $userresult = $userstable->save($userdatas);
                        $userid = $userresult->id;

                        $this->loadModel('Shops');
                        $shopstable = TableRegistry::get('Shops');
                        $shopdatas = $shopstable->newEntity();
                        $shopdatas->user_id = $userid;
                        $shopdatas->seller_status = 2;
                        $shopstable->save($shopdatas);

                        $this->loadModel('Userinvites');
                        $userinvitestable = TableRegistry::get('Userinvites');
                        $userinvite = $userinvitestable->find()->where(['invited_email' => $emailaddress])->first();

                        if (empty($userinvite) && !empty($reffer_id)) {
                            $userinvitedatas = $userinvitestable->newEntity();
                            $userinvitedatas->user_id = $reff_id['reffid'];
                            $userinvitedatas->invited_email = $emailaddress;
                            $userinvitedatas->status = 'Joined';
                            $userinvitedatas->invited_date = time();
                            $userinvitedatas->cdate = time();
                            $userinvitestable->save($userinvitedatas);

                        }

                        if (!empty($reffer_id)) {
                            $this->Userinvites->updateAll(array('status' => "Joined"), array('Userinvites.invited_email' => $emailaddress, 'Userinvites.user_id' => $reff_id['reffid']));

                            $logusername = $firstname;
                            $logusernameurl = $urlname;
                            $image['user']['image'] = "usrimg.jpg";
                            $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                            $loguserimage = json_encode($image);
                            $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                            $notifymsg = $loguserlink . " -___-accepted your invitation";
                            $messages = $loguserlink . " accepted your invitation and joined " . $setngs['site_name'] . ". You can follow " . $logusername . " by visiting the profile";
                            $logdetails = $this->addlog('invite', $userid, $reff_id['reffid'], 0, $notifymsg, $messages, $loguserimage);

                            if (!empty($this->request->data['refferid'])) {
                                if (trim($usr_datas['profile_image']) == "")
                                    $userImg = "usrimg.jpg";
                                else
                                    $userImg = $usr_datas['profile_image'];

                                $image['user']['image'] = $userImg;
                                $image['user']['link'] = SITE_URL . "people/" . $usr_datas['username_url'];
                                $loguserimage = json_encode($image);

                                $loguserlink = "<a href='" . SITE_URL . "people/" . $usr_datas['username_url'] . "'>" . $usr_datas['username'] . "</a>";
                                $notifymsg = $loguserlink . " -___- Your account has credited for referral bonus";
                                $messages = "Your account has credited for referral bonus with " . $_SESSION['default_currency_symbol'] . $setngs['signup_credit'];
                            }
                        }

                        if ($setngs['signup_active'] == 'yes') {
                            $emailid = base64_encode($emailaddress);
                            $pass = base64_encode($password);
                            $email = $emailaddress;
                            $aSubject = $setngs['site_name'] . "  " . __d('user', "Welcome, please verify your new account");
                            $aBody = '';
                            $template = 'userlogin';
                            $setdata = array('name' => $firstname, 'urlname' => $urlname, 'email' => $emailaddress, 'siteurl' => SITE_URL, 'setngs' => $setngs, 'access_url' => SITE_URL . "verification/" . $emailid . "~" . $refer_key . "~" . $pass);

                            $this->sendmail($email, $aSubject, $aBody, $template, $setdata);

                            if ($setngs['gmail_smtp'] == 'enable') {
                                $this->Email->smtpOptions = array(
                                    'port' => $setngs['smtp_port'],
                                    'timeout' => '30',
                                    'host' => 'ssl://smtp.gmail.com',
                                    'username' => $setngs['noreply_email'],
                                    'password' => $setngs['noreply_password']
                                );

                                $this->Email->delivery = 'smtp';
                            }
                            $this->Email->to = $emailaddress;
                            $this->Email->subject = $setngs['site_name'] . "  Welcome, please verify your new account";
                            $this->Email->from = SITE_NAME . "<" . $setngs['noreply_email'] . ">";
                            $this->Email->sendAs = "html";
                            $this->Email->template = 'userlogin';
                            $this->set('name', $firstname);
                            $this->set('urlname', $urlname);
                            $this->set('email', $emailaddress);
                            $this->set('siteurl', SITE_URL);
                            $this->set('setngs', $setngs);
                            $emailid = base64_encode($emailaddress);
                            $pass = base64_encode($password);
                            $this->set('access_url', SITE_URL . "verification/" . $emailid . "~" . $refer_key . "~" . $pass);

                            $this->Flash->success(__d('user', 'An email was sent to your mail box, please activate your account and login.'));
                            $this->redirect('/');
                        } else {
                            $this->Flash->success(__d('user', 'Your account has been created, please login to your account'));
                            $this->redirect('/login');
                        }

                    }
                } else {
                    $_SESSION['username'] = '';
                    $_SESSION['firstname'] = '';
                    $_SESSION['email'] = '';
                    $_SESSION['password'] = '';
                    $this->set('siteurl', SITE_URL);
                    $this->set('site_na', $setngs['site_name']);
                    if (!empty($referrer)) {
                        $this->set('refferrer_user_id', $refferrer_user_id);
                    }
                    if (!empty($_GET['referrer'])) {
                        $this->set('refferrer_user_id', $refferrer_user_id);
                    }
                    $this->set('username', $username);
                    $this->set('firstname', $firstname);
                    $this->set('email', $email);

                }

            }
            public function verify($id = null)
            {
                $id = $_GET['id'];
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();


                $userstable = TableRegistry::get('Users');
                $itemstable = TableRegistry::get('Items');
                $usersquery = $userstable->query();
                $usersquery->update()
                ->set(['activation' => '1'])
                ->set(['user_status' => 'enable'])
                ->where(['id' => $id])
                ->execute();
                $this->Auth->setUser($userdetails);

                $this->loadModel('Item');
                $this->loadModel('Category');


                $itemvalforfant = $itemstable->find()->contain('Users')->contain('Forexrates')->contain('Photos')->where(['Items.status' => 'publish'])->limit(20)->order(['Items.id DESC'])->all();


                $followerstable = TableRegistry::get('Followers');
                $followcnt = $followerstable->find()->where(['follow_user_id' => $loguser['id']])->all();
                $this->set('followcnt', $followcnt);
                foreach ($followcnt as $flcnt) {
                    $flwrcntid[] = $flcnt['user_id'];

                }
                $userlevels = array('god', 'moderator');
                $followpeople = $userstable->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(function ($exp) use ($username_val, $id) {
                    return $exp
                    ->notEq('Users.activation', 0)
                    ->notEq('Users.id', $id);
                })->limit(20)->order(['Users.id' => 'DESC'])->all();
                $this->set('followpeople', $followpeople);
                $this->set('itemvalforfant', $itemvalforfant);
                $this->set('userid', $id);
                $this->set('setngs', $setngs);

            }

            public function verification($userid = null)
            {
                $this->set('title_for_layout', 'Welcome ');
                $userval = explode("~", $userid);
                global $setngs;
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                $email = base64_decode($userval[0]);
                $veri_code = $userval[1];
                $userstable = TableRegistry::get('Users');
                $itemstable = TableRegistry::get('Items');
                $userdetails = $userstable->find()->where(['email' => $email])->where(['refer_key' => $veri_code])->first();


                //echo $userdetails->last_login; die;

                if(!empty($userdetails->last_login) && $userdetails->last_login != '0000-00-00 00:00:00')
                {
                    $last_logintime = $userdetails->last_login->format('Y-m-d');
                }else{
                    $last_logintime = '';
                }
                


                //echo '<pre>'; print_r($userdetails); die;
                if (count($userdetails) > 0) {
                    $id = $userdetails['id'];
                    $active = $userdetails['activation'];


                    $last_login = ($last_logintime != '') ? strtotime($last_logintime) : '';

                    //echo $active; die;

                    if($active != 1 || ($active == 1 && $last_login == '')){
                        $now=time();

                        //echo 'last login'.$last_login; die;

                        if($last_login==""){
                            $usersquery = $userstable->query();
                            $usersquery->update()
                            ->set(['activation'=>'2'])
                            ->set(['user_status'=>'enable'])
                            ->set(['last_login'=>$now])
                            ->where(['id'=>$id])
                            ->execute();
                            $this->Auth->setUser($userdetails);

                            return $this->redirect('/verification/'.$userid);
                        }
                        else
                        {
                            //echo 'update query'; die;
                            $usersquery = $userstable->query();
                            $usersquery->update()
                            ->set(['activation'=>'1'])
                            ->set(['user_status'=>'enable'])
                            ->set(['last_login'=>$now])
                            ->where(['id'=>$id])
                            ->execute();
                        }
                        $this->Auth->setUser($userdetails);

                        $this->loadModel('Item');
                        $this->loadModel('Category');


                        $itemvalforfant = $itemstable->find()->contain('Users')->contain('Forexrates')->contain('Photos')->where(['Items.status' => 'publish'])->limit(20)->order(['Items.id DESC'])->all();


                        $followerstable = TableRegistry::get('Followers');
                        $followcnt = $followerstable->find()->where(['follow_user_id' => $loguser['id']])->all();
                        $this->set('followcnt', $followcnt);
                        foreach ($followcnt as $flcnt) {
                            $flwrcntid[] = $flcnt['user_id'];

                        }
                        $userlevels = array('god', 'moderator');
                        $followpeople = $userstable->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(function ($exp) use ($username_val, $id) {
                            return $exp
                            ->notEq('Users.activation', 0)
                            ->notEq('Users.id', $id);
                        })->limit(20)->order(['Users.id' => 'DESC'])->all();
                        $this->set('followpeople', $followpeople);
                        $shopstable = TableRegistry::get('Shops');
                        $followstore = $shopstable->find('all')->contain('Users')
                        ->where(['Users.user_level' => 'shop'])
                        ->where(['store_enable' => 'enable'])
                        ->where(['item_count >' => '0'])
                        ->where(['seller_status' => '1'])
                        ->where(['store_enable' => 'enable'])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Shops.user_id', '$userid');
                        })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit('20')->all();
                        $this->set('followstore', $followstore);

                        $this->set('itemvalforfant', $itemvalforfant);
                        $this->set('userid', $userid);
                        $this->set('setngs', $setngs);
                        $welcome_email = $setngs['welcome_email'];
                        if ($welcome_email == "yes") {
                            $emailaddress = $email;

                            $emails = $emailaddress;
                            $aSubjects = $setngs['site_name'] . " – " . __d('user', 'Congratulations, your new account is ready');
                            $aBodys = '';
                            $templates = 'welcomeemail';
                            $setdatas = array('email' => $emailaddress, 'username' => $userdetails['first_name'], 'setngs' => $setngs);
                            $this->sendmail($emails, $aSubjects, $aBodys, $templates, $setdatas);


                        }
                    } else if ($active == 1 && $last_login == "") {
                        $this->Flash->success(__d('user', 'Your account was already Verified'));
                        $this->redirect('/login');
                    }
                } else {
                    $this->Flash->success(__d('user', 'You are not authenticated.Please signup'));
                    $this->redirect('/');
                }
            }

            public function social($provider)
            {

                echo $this->Form->postLink(
                    'Login with Facebook',
                    [
                        'plugin' => 'ADmad/SocialAuth',
                        'controller' => 'Auth',
                        'action' => 'login',
                        'provider' => 'facebook',
                        '?' => ['redirect' => $this->request->getQuery('redirect')]
                    ]
                );
                die;
                require_once(ROOT . DS . 'webroot' . DS . 'hybridauth' . DS . 'Hybrid' . DS . 'Auth.php');

                $config = require_once(ROOT . DS . 'webroot' . DS . 'hybridauth' . DS . 'config.php');
                /* Initiate Hybrid_Auth Function*/
                $hybridauth = new \Hybrid_Auth($config);
                $authProvider = $hybridauth->authenticate($provider);
                $user_profile = $authProvider->getUserProfile();

                /*Modify here as per you needs. This is for demo */
                if ($user_profile && isset($user_profile->identifier)) {
                    echo "<b>Name</b> :" . $user_profile->displayName . "<br>";
                    echo "<b>Profile URL</b> :" . $user_profile->profileURL . "<br>";
                    echo "<b>Image</b> :" . $user_profile->photoURL . "<br> ";
                    echo "<img src='" . $user_profile->photoURL . "'/><br>";
                    echo "<b>Email</b> :" . $user_profile->email . "<br>";
                    echo "<br> <a href='logout.php'>Logout</a>";
                }
                exit;

                /*Example Demo For FB authorize Action*/
        #Facebook authorize
                if ($this->request->params['pass'][0] == 'Facebook') {
                    if ($user_profile && isset($user_profile->identifier)) {
                        $this->authorize_facebook($user_profile);
                    }
                }
            }

            public function socialRedirect()
            {
                $this->layout = false;
                $this->autoRender = false;
                require_once(ROOT . DS . 'vendor' . DS . 'hybridauth' . DS . 'hybridauth' . DS . 'hybridauth' . DS . 'config.php');
                require_once(ROOT . DS . 'vendor' . DS . 'hybridauth' . DS . 'hybridauth' . DS . 'hybridauth' . DS . 'Hybrid' . DS . 'Auth.php');
                require_once(ROOT . DS . 'vendor' . DS . 'hybridauth' . DS . 'hybridauth' . DS . 'hybridauth' . DS . 'Hybrid' . DS . 'Endpoint.php');
                $hybridauth = new \Hybrid_Auth($config);
                \Hybrid_Endpoint::process();
            }


            public function authorize_facebook($user_profile)
            {

                $provider = "Facebook";
                $provider_uid = $user_profile->identifier;

                $userExist = $this->Users->find('all')->where(['Users.provider' => $provider, 'Users.provider_uid' => $user_profile->identifier])->first();


                if ((isset($userExist)) && ($userExist)) {

                    $session = $this->request->session();
                    $session->delete('auth_sess_var');
                    $session->destroy();
                    $this->Auth->setUser($userExist->toArray());
                    $session->write('auth_sess_var', $userExist);
                    return $this->redirect($this->Auth->redirectUrl());
                } else {

                    /* Create new user entity */
                    $user = $this->Users->newEntity();
                    $tmp_hash = md5(rand(0, 1000));
                    $tmp_id = time();

                    /* Save individual data */
                    $user->tmp_id = $tmp_id;
                    $user->firstname = (!empty($user_profile->firstName)) ? $user_profile->firstName : "";
                    $user->lastname = (!empty($user_profile->lastName)) ? $user_profile->lastName : "";
                    $user->username = (!empty($user_profile->lastName) && !empty($user_profile->lastName)) ? strtolower($user_profile->firstName) . "." . strtolower($user_profile->lastName) : "";
                    $user->avatar = (!empty($user_profile->photoURL)) ? $user_profile->photoURL : "";
                    $user->role = "public";
                    $user->provider = $provider;
                    $user->provider_uid = $user_profile->identifier;
                    $user->gender = !empty($user_profile->gender) ? (($user_profile->gender == 'male') ? 'm' : 'f') : "";
                    $user->provider_email = !empty($user_profile->email) ? $user_profile->email : "";
                    $user->password = $user_profile->identifier;
                    $user->confirm_password = $user_profile->identifier;
                    $user->tmp_hash = $tmp_hash;
                    $user->isverified = (!empty($user_profile->emailVerified)) ? 1 : 0;
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    $this->Users->save($user);

                    $userDetails = $this->Users->find('all')->where(['Users.provider' => $provider, 'Users.provider_uid' => $user_profile->identifier])->first();

                    /* Destroy previous session before setting new Session */
                    $session = $this->request->session();
                    $session->delete('auth_sess_var');
                    $session->destroy();

                    /* Set user */
                    $this->Auth->setUser($userDetails->toArray());
                    $session->write('auth_sess_var', $userDetails);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }

            public function logout()
            {
                $this->Cookie->delete('User');
                $this->Auth->logout();
                return $this->redirect('/login');

            }
            public function home()
            {
                $user_array = array(
                    $this->Auth->user('email'),
                    $this->Auth->user('id')
                );
                $this->set('user', $user_array);
            }
            public function add()
            {

                $user = $this->Users->newEntity();

                if ($this->request->is("post")) {

                    $username = $this->request->data('email');
                    $password = (new DefaultPasswordHasher)->hash($this->request->data('password'));
                    $user->email = $username;
                    $user->password = $password;

                    if ($this->Users->save($user)) {
                        $this->Flash->success(__d('user', 'User has been saved.'));
                        return $this->redirect(['controller' => 'users', 'action' => 'login']);
                    }

                    if ($user->errors()) {
                        $error_msg = [];
                        foreach ($user->errors() as $errors) {
                            if (is_array($errors)) {
                                foreach ($errors as $error) {
                                    $error_msg[] = $error;
                                }
                            } else {
                                $error_msg[] = $errors;
                            }
                        }

                        if (!empty($error_msg)) {
                            $this->Flash->error(
                                __d('user', "Please fix the following error(s):") . implode("\n \r", $error_msg)
                            );
                        }
                    }
                }
                $this->set(compact("user"));
            }

            public function isAuthorized($user)
            {
                return true;
            }

            public function ajaxSearch()
            {
                $this->autoRender = false;
                $this->loadModel('Items');
                $this->loadModel('Users');
                $searchWord = $_POST['searchStr'];
                $prefix = $this->Item->tablePrefix;
                $userContent = '';
                $userstable = TableRegistry::get('Users');
                $userDetails = $userstable->find()->where(['username LIKE' => '%' . $searchWord . '%'])
                ->where(function ($exp, $q) {
                    return $exp->notEq('activation', '0')
                    ->notEq('user_level', 'god')
                    ->notEq('user_level', 'shop')
                    ->notEq('user_level', 'moderator');
                })->limit('5')->all();
                if (count($userDetails) > 0) {
                    foreach ($userDetails as $key => $userData) {
                        $usernameurl = $userData['username_url'];
                        $usernam = $userData['username'];
                        $url = SITE_URL . 'people/' . $usernameurl;
                        $userr = explode(strtolower($searchWord), strtolower($usernam), 2);
                        if ($userContent == '') {
                            $userContent = "<li><a href='" . $url . "'>" . $userr[0] . "<b>" . $searchWord . "</b>" . $userr[1] . "</a></li>";
                        } else {
                            $userContent = $userContent . "<li><a href='" . $url . "'>" . $userr[0] . "<b>" . $searchWord . "</b>" . $userr[1] . "</a></li>";
                        }
                    }
                } else {
                    $userContent = "No Data";
                }
                $itemContent = "";
                $itemstable = TableRegistry::get('Items');
                $itemDetails = $itemstable->find()->where(['item_title LIKE' => '%' . $searchWord . '%'])
                ->where(function ($exp, $q) {
                    return $exp->notEq('status', 'draft');
                })->where(['Items.affiliate_commission IS NULL'])->limit('5')->all();
                if (count($itemDetails) > 0) {
                    foreach ($itemDetails as $key => $itemData) {
                        $itemnameurl = $itemData['item_title_url'];
                        $itemnam = $itemData['item_title'];
                        $itid = $itemData['id'];
                        $item_url = base64_encode($itid . "_" . rand(1, 9999));
                        $url = SITE_URL . 'listing/' . $item_url;
                        $itemm = explode(strtolower($searchWord), strtolower($itemnam), 2);
                        if ($itemContent == '') {
                            $itemContent = "<li><a href='" . $url . "'>" . $itemm[0] . "<b>" . $searchWord . "</b>" . $itemm[1] . "</a></li>";
                        } else {
                            $itemContent = $itemContent . "<li><a href='" . $url . "'>" . $itemm[0] . "<b>" . $searchWord . "</b>" . $itemm[1] . "</a></li>";
                        }
                    }
                } else {
                    $itemContent = "No Data";
                }

                $json = array();
                $json[] = $userContent;
                $json[] = $itemContent;
                echo json_encode($json);

            }

            public function searches($searchWord = null)
            {
                $this->loadModel('Items');
                $this->loadModel('Users');
                $this->loadModel('Itemfavs');
                $this->loadModel('Photos');
                $this->loadModel('Followers');
                $this->loadModel('Itemlists');
                $prefix = $this->Item->tablePrefix;
                global $setngs;
                global $siteChanges;
                global $loguser;
                $userid = $loguser['id'];
                $photostable = TableRegistry::get('Photos');

                $this->set('title_for_layout', 'Search');

                $userstable = TableRegistry::get('Users');
                $userDetails = $userstable->find()->where(['username LIKE' => '%' . $searchWord . '%'])
                ->where(function ($exp, $q) {
                    return $exp->notEq('activation', '0')
                    ->notEq('user_level', 'god')
                    ->notEq('user_level', 'moderator')
                    ->notEq('user_level', 'shop');
                })->limit('20')->all();
                
                $itemstable = TableRegistry::get('Items');
                $itemDetails = $itemstable->find()->contain('Photos')->contain('Users')->contain('Forexrates')->where(['item_title LIKE' => '%' . $searchWord . '%'])->where(['Items.affiliate_commission IS NULL'])
                ->where(function ($exp, $q) {
                    return $exp->notEq('status', 'draft');
                })->limit('20')->all();

                foreach ($userDetails as $ppl_dtl) {
                    foreach ($ppl_dtl['Itemfav'] as $ppl_dt) {
                        $ppl_dtda = $ppl_dt['item_id'];
                        $pho_datass[$ppl_dtda] = $photosTable->find('all')->where(['item_id' => $ppl_dtda])->all();
                    }
                }

                $followcnt = $userstable->find()->where(['username_url' => $name])->first();
                $followerstable = TableRegistry::get('Followers');
                $followcnt = $followerstable->followcnt($loguser['id']);
                $followcnt;
                $this->set('followcnt', $followcnt);
                if (!empty($followcnt)) {
                    foreach ($followcnt as $flcnt) {
                        $flwngusrids[] = $flcnt['user_id'];
                    }
                }
                if (isset($pho_datas)) {
                    $this->set('pho_datas', $pho_datas);
                }
                $this->set('userid', $loguser['id']);
                $this->set('searchWord', $searchWord);
                $this->set('itemDetails', $itemDetails);
                $this->set('userDetails', $userDetails);
                $this->set('itemlistDetails', $itemlistDetails);
                $this->set('prefix', $prefix);
                $this->set('followcnt', $followcnt);
                $this->set('roundProf', $siteChanges['profile_image_view']);

            }

            public function searchpeople($searchWord=null) {

                $this->loadModel('Users');
                $this->loadModel('Followers');
                global $setngs;
                global $siteChanges;
                global $loguser;
                $userid = $loguser['id'];
                $this->set('title_for_layout','Search');
                $userstable = TableRegistry::get('Users');
                $startIndex = $_GET['startIndex'];
                $offset = ($startIndex / 20) + 1;
                $searchWord= $_GET['searchString'];
                $userDetails = $userstable->find()->where(['username LIKE'=>'%'.$searchWord.'%'])
                ->where(function ($exp, $q) {
                    return $exp->notEq('activation','0')
                    ->notEq('user_level','god')
                    ->notEq('user_level','moderator')
                    ->notEq('user_level','shop');
                })->limit($startIndex)->page($offset)->all();

                $followcnt = $userstable->find()->where(['username_url'=>$name])->first();
                $followerstable = TableRegistry::get('Followers');
                $followcnt = $followerstable->followcnt($loguser['id']);
                $this->set('followcnt',$followcnt);
                if(!empty($followcnt)){
                    foreach($followcnt as $flcnt){
                        $flwngusrids[] = $flcnt['user_id'];
                    }
                }
                $this->set('userid',$loguser['id']);
                $this->set('searchWord',$searchWord);
                $this->set('userDetails',$userDetails);
                $this->set('followcnt',$followcnt);
                $this->set('roundProf',$siteChanges['profile_image_view']);

            }


            public function searchviewmore() {
                $this->loadModel('Items');
                $this->loadModel('Users');
                $this->loadModel('Itemfavs');
                $this->loadModel('Photos');
                $this->loadModel('Followers');
                $this->loadModel('Itemlists');
                $prefix = $this->Item->tablePrefix;
                global $setngs;
                global $siteChanges;
                global $loguser;
                $userid = $loguser['id'];
                $photostable = TableRegistry::get('Photos');
                $this->set('title_for_layout','Search');
                $userstable = TableRegistry::get('Users');

                $startIndex = $_GET['startIndex'];
                $offset = ($startIndex / 20) + 1;
                $searchWord= $_GET['searchString'];

                $userDetails = $userstable->find()->where(['username LIKE'=>'%'.$searchWord.'%'])
                ->where(function ($exp, $q) {
                    return $exp->notEq('activation','0')
                    ->notEq('user_level','god')
                    ->notEq('user_level','moderator')
                    ->notEq('user_level','shop');
                })->limit($startIndex)->page($offset)->all();

                $itemstable = TableRegistry::get('Items');

                $itemDetails = $itemstable->find()->contain('Photos')->contain('Users')->contain('Forexrates')->where(['item_title LIKE'=>'%'.$searchWord.'%'])
                ->where(function ($exp, $q) {
                    return $exp->notEq('status','draft');
                })->order(['created_on'=>'DESC'])->limit($startIndex)->page($offset)->all();

               /* foreach($userDetails as $ppl_dtl){
                    foreach($ppl_dtl['Itemfav'] as $ppl_dt){
                        $ppl_dtda = $ppl_dt['item_id'];
                        $pho_datass[$ppl_dtda] = $photosTable->find('all')->where(['item_id'=>$ppl_dtda])->all();
                    }
                }*/

                $followcnt = $userstable->find()->where(['username_url'=>$name])->first();
                $followerstable = TableRegistry::get('Followers');
                $followcnt = $followerstable->followcnt($loguser['id']);
                $followcnt ;
                $this->set('followcnt',$followcnt);
                if(!empty($followcnt)){
                    foreach($followcnt as $flcnt){
                        $flwngusrids[] = $flcnt['user_id'];
                    }
                }
                if(isset($pho_datas)){
                    $this->set('pho_datas',$pho_datas);
                }
                $this->set('userid',$loguser['id']);
                $this->set('searchWord',$searchWord);
                $this->set('itemDetails',$itemDetails);
                $this->set('userDetails',$userDetails);
                $this->set('itemlistDetails',$itemlistDetails);
                $this->set('prefix',$prefix);
                $this->set('followcnt',$followcnt);
                $this->set('roundProf',$siteChanges['profile_image_view']);
            }


            public function userprofiles($username)
            {
                global $loguser;
                $userid = $loguser['id'];
                $_SESSION['username_urls'] = $username;
                $this->set('loguser', $loguser);
                $UsersTable = TableRegistry::get('Users');
                $userdetail = $UsersTable->find('all')->contain('Shops')->where(['username_url' => $username])->first();
                if (empty($userdetail)) {
                    $this->Flash->error(__d('user', 'User does not exists'));
                    return $this->redirect($_SERVER['HTTP_REFERER']);
                }
                $current_page_userid = $userdetail->id;
                $this->set('userdetail', $userdetail);
                $itemsTable = TableRegistry::get('Items');
                $photosTable = TableRegistry::get('Photos');
                $itemfavtable = TableRegistry::get('Itemfavs');
                $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $current_page_userid])->limit('15')->all();
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                $this->set('setngs', $setngs);
                if (count($itemfavmodel) > 0) {
                    foreach ($itemfavmodel as $itms) {
                        $itmid[] = $itms->item_id;
                    }
                    if (count($itmid) > 0) {
                        $itematas = $itemsTable->find('all')->contain('Forexrates')->contain('Itemfavs')->contain('Users')->contain(['Photos'])->where(['Items.id IN' => $itmid,'Items.status' => 'publish'])->all();
                        $itemfavcount = $itemsTable->find('all')->contain(['Photos'])->where(['Items.id IN' => $itmid,'Items.status' => 'publish'])->count();
                    } else {
                        $itematas = [];
                        $itemfavcount = 0;
                    }
                    $this->set('itematas', $itematas);
                    $this->set('itemfavcount', $itemfavcount);
                }
                if (isset($_REQUEST['lists'])) {
                    $itemlistsTable = TableRegistry::get('Itemlists');
                    $itemListsAll = $itemlistsTable->find('all')->where(['user_id' => $current_page_userid])->order(['created_on' => 'DESC'])->limit('15')->all();
                    $itemListsCount = $itemlistsTable->find('all')->where(['user_id' => $current_page_userid])->order(['created_on' => 'DESC'])->count();
                    $list_items = array();
                    foreach ($itemListsAll as $key => $itemLists) {
                        $list_itemides = json_decode($itemLists['list_item_id'], true);

                        for ($i = 0; $i < count($list_itemides); $i++) {
                            if (isset($list_itemides[$i]) && !in_array($list_itemides[$i], $list_items)) {
                                $list_items[] = $list_itemides[$i];
                            }
                        }
                    }
                    if (count($list_items) > 0) {
                        $itemdatasall = $itemsTable->find('all')->contain(['Photos'])->where(['Items.id IN' => $list_items])->all();
                    } else {
                        $itemdatasall = array();
                    }
                    $itemdatasallcount = count($itemdatasall);
                    $this->set('itemdatasall', $itemdatasall);
                    $this->set('itemdatasallcount', $itemdatasallcount);
                    $this->set('itemListsAll', $itemListsAll);
                    $this->set('itemListsCount', $itemListsCount);
                }
                $itemlistsTable = TableRegistry::get('Itemlists');
                $itemListsCount = $itemlistsTable->find('all')->where(['user_id' => $current_page_userid])->order(['created_on' => 'DESC'])->count();
                $this->set('itemListsCount', $itemListsCount);


                $followerstable = TableRegistry::get('Followers');
                $flwrs_cnt = $followerstable->flwrscnt($current_page_userid);
                $follow_cnt = $followerstable->followcnt($userid);
                $flwrscnt = $followerstable->flwrscnt($current_page_userid);
                $followcnt = $followerstable->followcnt($current_page_userid);
                $flwrs = $followerstable->flwrscntlimit($current_page_userid, 1, 15);
                $flwrs = $followerstable->flwrscntlimit($current_page_userid, 1, 15);
                $follow = $followerstable->followcntlimit($current_page_userid, 1, 15);
                $followerscnt = $followerstable->followcnt($loguser['id']);
                $flwrusrids = array();
                $totl_flwrs = 0;

                if (!empty($flwrscnt)) {
                    foreach ($flwrscnt as $flws) {
                        $totl_flwrs = $totl_flwrs + $flws['totl_flwrscnt'];
                    }

                }
                if (!empty($flwrs)) {
                    foreach ($flwrs as $flws) {
                        $flwrusrids[$flws['follow_user_id']] = $flws['follow_user_id'];

                    }
                    foreach ($flwrscnt as $flwss) {
                        $flwrcntusrids[$flwss['follow_user_id']] = $flwss['follow_user_id'];
                    }

                }
                $this->set('flwrusrids', $flwrusrids);

                if (!empty($follow)) {
                    foreach ($follow as $flcnt) {
                        $flwngusrids[] = $flcnt['user_id'];
                    }
                    foreach ($followcnt as $flcntt) {
                        $flwngcntusrids[] = $flcntt['user_id'];
                    }
                }

                $userlevels = array('god', 'moderator');
                if (count($flwrcntusrids) > 0) {
                    $followerCount = $UsersTable->find('all')->where(['id IN' => $flwrcntusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                        return $exp->notEq('activation', '0');
                    })->all();
                    if (count($flwngcntusrids) > 0) {
                        $followCount = $UsersTable->find('all')->where(['id IN' => $flwngcntusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                    } else {
                        $followCount = "";
                    }
                    $this->set('followerCount', $followerCount);
                    $this->set('followCount', $followCount);
                }
                $this->set('totl_flwrs', $totl_flwrs);
                $this->set('followcnt', $follow_cnt);
                $this->set('flwrscnt', $flwrs_cnt);
                $this->set('followerscnt', $followerscnt);
                $this->set('userid', $userid);

                if (isset($_REQUEST['followers'])) {

                    if (count($flwrusrids) > 0) {
                        $people_details = $UsersTable->find('all')->contain('Itemfavs')->where(['id IN' => $flwrusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                    }
                    foreach ($people_details as $ppl_dtl) {
                        foreach ($ppl_dtl['itemfavs'] as $ppl_dt) {
                            $ppl_dtda = $ppl_dt['item_id'];
                            $pho_datass[$ppl_dtda] = $photosTable->find('all')->where(['item_id' => $ppl_dtda])->all();
                        }
                    }
                    if (!empty($pho_datass)) {
                        $this->set('pho_datass', $pho_datass);
                    }
                    $this->set('people_details', $people_details);
                } else {
                    if (count($flwrusrids) > 0) {
                        $people_details = $UsersTable->find('all')->contain('Itemfavs')->where(['id IN' => $flwrusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                        $this->set('people_details', $people_details);
                    }
                }

                if (isset($_REQUEST['followings'])) {
                    if (count($flwngusrids) > 0) {
                        $people_details_for_following = $UsersTable->find('all')->contain('Itemfavs')->where(['id IN' => $flwngusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                        foreach ($people_details_for_following as $ppl_dtl) {
                            foreach ($ppl_dtl['itemfavs'] as $ppl_dt) {
                                $ppl_dtda = $ppl_dt['item_id'];
                                $pho_datass_for_following[$ppl_dtda] = $photosTable->find('all')->where(['item_id' => $ppl_dtda])->all();
                            }
                        }
                        if (!empty($pho_datass_for_following)) {
                            $this->set('pho_datass_for_following', $pho_datass_for_following);
                        }
                        $this->set('people_details_for_following', $people_details_for_following);
                    }
                } else {
                    if (count($flwngusrids) > 0) {
                        $people_details_for_following = $UsersTable->find('all')->contain('Itemfavs')->where(['id IN' => $flwngusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                        $this->set('people_details_for_following', $people_details_for_following);
                    }
                }

                if (isset($_REQUEST['stores'])) {
                    $storefollowerstable = TableRegistry::get('Storefollowers');
                    $followers = $storefollowerstable->find('all')->where(['follow_user_id' => $current_page_userid])->all();
                    foreach ($followers as $follower) {
                        $sflwrusrids[] = $follower['store_id'];

                    }

                    $shopstable = TableRegistry::get('Shops');
                    $itemstable = TableRegistry::get('Items');
                    if (isset($userid))
                        $userid = $userid;
                    else
                        $userid = '0';
                    if (count($sflwrusrids) > 0) {
                        $shopsdet = $shopstable->find('all')->contain('Users')
                        ->where(['Users.user_level' => 'shop'])
                        ->where(['Shops.id IN' => $sflwrusrids])
                        ->where(['item_count >' => '0'])
                        ->where(['seller_status' => '1'])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Shops.user_id', '$userid');
                        })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit('15')->all();


                        $storeCount = $shopstable->find('all')->contain('Users')
                        ->where(['Users.user_level' => 'shop'])
                        ->where(['Shops.id IN' => $sflwrusrids])
                        ->where(['item_count >' => '0'])
                        ->where(['seller_status' => '1'])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Shops.user_id', '$userid');

                        })->order(['item_count DESC', 'Shops.follow_count DESC'])->count();
                        if ($storeCount == "")
                            $storeCount = 0;

                        $this->set('storeCount', $storeCount);
                    }
                    $topshoparr = array();
                    $skey = 0;
                    foreach ($shopsdet as $shopdata) {
                        $topshoparr[$skey]['shop_name'] = $shopdata['shop_name'];
                        $topshoparr[$skey]['shop_image'] = $shopdata['shop_image'];
                        $topshoparr[$skey]['shop_banner'] = $shopdata['shop_banner'];
                        $topshoparr[$skey]['merchant_name'] = $shopdata['merchant_name'];
                        $topshoparr[$skey]['shop_name_url'] = $shopdata['shop_name_url'];
                        $topshoparr[$skey]['item_count'] = $shopdata['item_count'];
                        $topshoparr[$skey]['user_id'] = $shopdata['user_id'];
                        $topshoparr[$skey]['id'] = $shopdata['id'];
                        $topshoparr[$skey]['follow_count'] = $shopdata['follow_count'];
                        if (isset($loguser['id']))
                            $followcnt = $storefollowerstable->followcnt($loguser['id']);
                        else
                            $followcnt = [];
                        $this->set('followcnt', $followcnt);
                        $topshoparr[$skey]['follow_shop'] = $flwrscnt;
                        $userid = $shopdata['User']['id'];
                        $topshoparr[$skey]['itemModel'] = $itemstable->find('all')->where(['Items.user_id' => $userid])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Items.status', 'draft');
                        })->order(['Items.fav_count DESC', 'Items.id DESC'])->all();
                        $topshoparr[$skey]['itemcount'] = $itemstable->find('all')->where(['Items.user_id' => $userid])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Items.status', 'draft');
                        })->order(['Items.fav_count DESC', 'Items.id DESC'])->count();
                        $skey += 1;
                    }
                    $this->set('followcnt', $followcnt);
                    $this->set('shopsdet', $topshoparr);

                } else {
                    $storefollowerstable = TableRegistry::get('Storefollowers');
                    $followers = $storefollowerstable->find('all')->where(['follow_user_id' => $current_page_userid])->all();
                    foreach ($followers as $follower) {
                        $sflwrusridss[] = $follower['store_id'];

                    }
                    if (isset($userid))
                        $userid = $userid;
                    else
                        $userid = '0';
                    $shopstable = TableRegistry::get('Shops');
                    if (count($sflwrusridss) > 0) {
                        $shopsdetail = $shopstable->find('all')->contain('Users')
                        ->where(['Users.user_level' => 'shop'])
                        ->where(['Shops.id IN' => $sflwrusridss])
                        ->where(['item_count >' => '0'])
                        ->where(['seller_status' => '1'])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Shops.user_id', '$userid');

                        })->order(['item_count DESC', 'Shops.follow_count DESC'])->all();

                        $storeCount = count($shopsdetail);
                        if ($storeCount == "")
                            $storeCount = 0;
                    }
                    $this->set('storeCount', $storeCount);
                }
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();


                $this->set('setngs', $setngs);
                $this->set('startIndex', 15);
            }

            function getmoreprofile()
            {
                global $loguser;
                global $siteChanges;
                global $setngs;
                $userid = $loguser['id'];


                $this->loadModel('Item');
                $this->loadModel('Photo');
                $this->loadModel('Itemfav');
                $this->loadModel('Itemlist');
                $this->loadModel('Follower');
                $this->loadModel('Wantownit');
                $this->loadModel('Storefollower');
                $this->loadModel('Log');

                $itemstable = TableRegistry::get('Items');
                $userstable = TableRegistry::get('Users');
                $shopstable = TableRegistry::get('Shops');
                $photostable = TableRegistry::get('Photos');
                $itemfavstable = TableRegistry::get('Itemfavs');
                $itemliststable = TableRegistry::get('Itemlists');
                $followerstable = TableRegistry::get('Followers');
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $logstable = TableRegistry::get('Logs');

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();


                $this->set('setngs', $setngs);
                $offset = $_GET['startIndex'];
                $page = ($offet / 15) + 1;
                $limit = $_GET['offset'];
                $tab = $_GET['tab'];
                $userlevels = array('god', 'moderator');
                $usr_datas = $userstable->find()->where(['username_url' => $_SESSION['username_urls']])->first();
                $current_page_userid = $usr_datas['id'];

                if ($tab == 'fantacy') {
                    $favitemModel = $itemfavstable->find()->where(['user_id' => $usr_datas['id']])->limit($limit)->offset($offset)->order(['id ASC'])->all();
                    $itematas = array();
                    if (!empty($favitemModel)) {
                        foreach ($favitemModel as $itms) {
                            $itmid[] = $itms['item_id'];
                        }
                        if (count($itmid) > 0)
                            $itematas = $itemstable->find('all')->contain('Forexrates')->contain('Itemfavs')->contain('Users')->contain(['Photos'])->where(['Items.id IN' => $itmid])->all();
                        else
                            $itematas = "";
                    }
                    $this->set('itematas', $itematas);
                } elseif ($tab == 'lists') {
                    $itemListsAll = $itemliststable->find()->where(['user_id' => $usr_datas['id']])->limit($limit)->offset($offset)->all();


                    $list_items = array();
                    foreach ($itemListsAll as $key => $itemLists) {
                        $list_itemides = json_decode($itemLists['list_item_id'], true);
                        for ($i = 0; $i < 8; $i++) {
                            if (isset($list_itemides[$i]) && !in_array($list_itemides[$i], $list_items)) {
                                $list_items[] = $list_itemides[$i];
                            }
                        }
                    }

                    if (count($list_items) > 0)
                        $itemdatasall = $itemstable->find()->contain('Photos')->where(['Items.id IN' => $list_items])->order(['Items.id DESC'])->limit($limit)->page($page)->all();
                    else
                        $itemdatasall = "";

                    $this->set('itemdatasall', $itemdatasall);
                    $this->set('itemListsAll', $itemListsAll);
                } elseif ($tab == 'followers') {
                    $flwrs = $followerstable->flwrscntlimit($usr_datas['User']['id'], $page, $limit);
                    if (!empty($flwrs)) {
                        foreach ($flwrs as $flws) {
                            $flwrusrids[$flws['follow_user_id']] = $flws['follow_user_id'];
                        }

                    }
                    if (count($flwrusrids) > 0) {
                        $people_details = $userstable->find('all')->contain('Itemfavs')->where(['id IN' => $flwrusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                    } else
                    $people_details = "";
                    foreach ($people_details as $ppl_dtl) {
                        foreach ($ppl_dtl['itemfavs'] as $ppl_dt) {
                            $ppl_dtda = $ppl_dt['item_id'];
                            $pho_datass[$ppl_dtda] = $photostable->find('all')->where(['item_id' => $ppl_dtda])->all();
                        }
                    }
                    if (!empty($pho_datass)) {
                        $this->set('pho_datass', $pho_datass);
                    }
                    $followcnt = $followerstable->followcnt($userid);
                    $this->set('followcnt', $followcnt);
                    $this->set('people_details', $people_details);
                } elseif ($tab == 'followings') {
                    $follow = $followerstable->followcntlimit($usr_datas['User']['id'], $page, $limit);
                    if (!empty($follow)) {
                        foreach ($follow as $flcnt) {
                            $flwngusrids[] = $flcnt['user_id'];
                        }
                    }
                    if (count($flwngusrids) > 0) {
                        $people_details_for_following = $userstable->find('all')->contain('Itemfavs')->where(['id IN' => $flwngusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                    } else
                    $people_details_for_following = "";
                    foreach ($people_details_for_following as $ppl_dtl) {
                        foreach ($ppl_dtl['itemfavs'] as $ppl_dt) {
                            $ppl_dtda = $ppl_dt['item_id'];
                            $pho_datass_for_following[$ppl_dtda] = $photostable->find('all')->where(['item_id' => $ppl_dtda])->all();
                        }
                    }
                    if (!empty($pho_datass_for_following)) {
                        $this->set('pho_datass_for_following', $pho_datass_for_following);
                    }
                    $followcnt = $followerstable->followcnt($userid);
                    $this->set('followcnt', $followcnt);
                    $this->set('people_details_for_following', $people_details_for_following);
                } elseif ($tab == 'stores') {

                    $followers = $storefollowerstable->find('all')->where(['follow_user_id' => $current_page_userid])->all();
                    foreach ($followers as $follower) {
                        $sflwrusrids[] = $follower['store_id'];
                    }
                    $shopsdet = $shopstable->find('all')->contain('Users')
                    ->where(['Users.user_level' => 'shop'])
                    ->where(['Shops.id IN' => $sflwrusrids])
                    ->where(['item_count >' => '0'])
                    ->where(['seller_status' => '1'])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('Shops.paypal_id', '')
                        ->notEq('Shops.user_id', '$userid');
                    })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit($limit)->page($page)->all();
                    $topshoparr = array();
                    foreach ($shopsdet as $shopdata) {
                        $topshoparr[$skey]['shop_name'] = $shopdata['shop_name'];
                        $topshoparr[$skey]['shop_image'] = $shopdata['shop_image'];
                        $topshoparr[$skey]['merchant_name'] = $shopdata['merchant_name'];
                        $topshoparr[$skey]['shop_name_url'] = $shopdata['shop_name_url'];
                        $topshoparr[$skey]['item_count'] = $shopdata['item_count'];
                        $topshoparr[$skey]['user_id'] = $shopdata['user_id'];
                        $topshoparr[$skey]['id'] = $shopdata['id'];
                        $topshoparr[$skey]['follow_count'] = $shopdata['follow_count'];
                        $followcnt = $storefollowerstable->followcnt($loguser['id']);
                        $this->set('followcnt', $followcnt);
                        $topshoparr[$skey]['follow_shop'] = $flwrscnt;
                        $userid = $shopdata['user']['id'];
                        $topshoparr[$skey]['itemModel'] = $itemstable->find('all')->where(['Items.user_id' => $userid])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Items.status', 'draft');
                        })->order(['Items.fav_count DESC', 'Items.id DESC'])->limit('10')->all();

                        $topshoparr[$skey]['itemcount'] = $itemstable->find('all')->where(['Items.user_id' => $userid])
                        ->where(function ($exp, $q) {
                            return $exp->notEq('Items.status', 'draft');
                        })->order(['Items.fav_count DESC', 'Items.id DESC'])->count();
                        $skey += 1;
                    }
                    $this->set('followcnt', $followcnt);
                    $this->set('shopsdet', $topshoparr);
                }

                $this->set('tab', $tab);
                $this->set('userid', $loguser['id']);
                $this->set('usr_datas', $usr_datas);
            }


            /* add Follow users */
            public function livefeedsaddflwUsrs()
            {
                global $loguser;
                $logusrid = $loguser['id'];
                $logusername = $loguser['username'];
                $logfirstname = $loguser['first_name'];
                $userid = $_REQUEST['usrid'];

                $followerstable = TableRegistry::get('Followers');
                $flwalrdy = $followerstable->find('all')->where(['user_id' => $userid])->where(['follow_user_id' => $logusrid])->count();
                $userlevels = array('god', 'moderator');

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $userstable = TableRegistry::get('Users');
                $usrdetails = $userstable->find('all')->where(['Users.id' => $userid])->first();
                $usrflwrs = $usrdetails['follow_count'];

                if ($flwalrdy > 0) {
                    echo "error";
                } else {
                    if ($userid != $logusrid) {
                        $followersTable = TableRegistry::get('Followers');
                        $Followers = $followersTable->newEntity();
                        $Followers->user_id = $userid;
                        $Followers->follow_user_id = $logusrid;
                        $result = $followersTable->save($Followers);

                        $followId = $result->id;

                        $flwrscnt = $followersTable->flwrscnt($userid);
                        $totl_flwrs = 0;
                        if (!empty($flwrscnt)) {
                            foreach ($flwrscnt as $flws) {
                                $totl_flwrs = $totl_flwrs + $flws['totl_flwrscnt'];
                            }
                            $totl_flwrs -= 2;
                        }
                        $totalflwrs = $usrflwrs + 1;
                        $query = $userstable->query();
                        $query->update()
                        ->set(['follow_count' => "'$totalflwrs'"])
                        ->where(['Users.id' => $userid])
                        ->execute();


                        $notificationSettings = json_decode($usrdetails['push_notifications'], true);
                        if ($notificationSettings['somone_flw_push'] == 1) {
                            $logusernameurl = $loguser['username_url'];
                            $userDesc = $loguser['about'];
                            $userImg = $loguser['profile_image'];
                            if (empty($userImg)) {
                                $userImg = 'usrimg.jpg';
                            }
                            $image['user']['image'] = $userImg;
                            $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                            $loguserimage = json_encode($image);
                            $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                            $notifymsg = $loguserlink . " -___-is now following you";
                            $logdetails = $this->addlog('follow', $logusrid, $userid, $followId, $notifymsg, $userDesc, $loguserimage);
                        }

                        $userdevicestable = TableRegistry::get('Userdevices');
                        $userddett = $userdevicestable->find('all')->where(['user_id' => $userid])->all();
                        foreach ($userddett as $userdet) {
                            $deviceTToken = $userdet['deviceToken'];
                            $badge = $userdet['badge'];
                            $badge += 1;


                            $querys = $userdevicestable->query();
                            $querys->update()
                            ->set(['badge' => "'$badge'"])
                            ->where(['deviceToken' => $deviceTToken])
                            ->execute();
                            $userImg = $loguser['profile_image'];
                            if (empty($userImg)) {
                                $userImg = 'usrimg.jpg';
                            }
                            if (isset($deviceTToken)) {
                                $pushMessage['type'] = 'follow';
                                $pushMessage['user_id'] = $loguser['id'];
                                $pushMessage['user_name'] = $loguser['username'];
                                $pushMessage['user_image'] = $userImg;
                                $user_detail = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                                I18n::locale($user_detail['languagecode']);
                                $pushMessage['message'] = __d('user', 'is now following you');
                                $messages = json_encode($pushMessage);
                                $this->pushnot($deviceTToken, $messages, $badge);
                            }
                        }

                        $user_email = $userstable->find('all')->where(['Users.id' => $userid])->first();
                        $emailaddress = $user_email['email'];
                        $name = $user_email['first_name'];
                        $follow_status = $user_email['someone_follow'];
                        $username_url = $loguser['username_url'];
                        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                        if ($follow_status == 1) {

                            if ($setngs['gmail_smtp'] == 'enable') {
                                $this->Email->smtpOptions = array(
                                    'port' => $setngs['smtp_port'],
                                    'timeout' => '30',
                                    'host' => 'ssl://smtp.gmail.com',
                                    'username' => $setngs['noreply_email'],
                                    'password' => $setngs['noreply_password']
                                );

                                $this->Email->delivery = 'smtp';
                            }
                            $this->Email->to = $emailaddress;
                            $this->Email->subject = $setngs['site_name'] . " - " . $loguser['first_name'] . " Following you on " . $setngs['site_name'];
                            $this->Email->from = SITE_NAME . "<" . $setngs['noreply_email'] . ">";
                            $this->Email->sendAs = "html";
                            $this->Email->template = 'followmail';
                            $this->set('name', $name);
                            $this->set('username_url', $username_url);
                            $this->set('email', $emailaddress);
                            $this->set('username', $loguser['first_name']);
                            $this->set('access_url', SITE_URL . "login");
                        }
                        if (isset($_POST['followlist'])) {
                            $listId = $_POST['listid'];
                            $roundProfile = "";
                            if ($siteChanges['profile_image_view'] == 'round') {
                                $roundProfile = "border-radius:150px;";
                            }
                            $followlist = explode(",", $_POST['followlist']);
                            $followerstable = TableRegistry::get('Followers');
                            $followcnt = $followerstable->followcnt($loguser['id']);
                            if (!empty($followcnt)) {
                                foreach ($followcnt as $flcnt) {
                                    $followlist[] = $flcnt['user_id'];
                                }
                            }
                            $followlist[] = $logusrid;
                            $people = $userstable->find('all')->where(['id NOT IN' => $followlist])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                                return $exp->notEq('activation', '0');
                            })->order(['Users.id' => 'ASC'])->first();
                            $message = "";
                            if (!empty($people)) {
                                if ($people['profile_image'] == "")
                                    $prof_img = "usrimg.jpg";
                                else
                                    $prof_img = $people['profile_image'];
                                $message .= '<div class="col-xs-12 col-sm-1 col-md-2 col-lg-2">
                                <a href="' . SITE_URL . 'people/' . $people['username_url'] . '">
                                <div class="follow_logo1">
                                <img class="live_feeds_logo" src="' . SITE_URL . 'media/avatars/thumb70/' . $prof_img . '" />
                                </div>
                                </a>
                                </div>

                                <div class="col-xs-12 col-sm-11 col-md-10 col-lg-10">
                                <a href="' . SITE_URL . 'people/' . $people['username_url'] . '">
                                <div class="regular-font inlined-display word_break gradient_bg1">
                                <span class="followname_cap">' . strtolower($people['first_name']) . ' ' . strtolower($people['last_name']) . '</span>
                                </div>
                                </a>
                                <div class="btn to_add_friend pull-right padding_follow_btn"><a href="javascript:void(0);" onclick="hashtagfollow(' . $people['id'] . ',' . $listId . ')" class=""><div class="add_friend padding_follow_btn"></div></a></div>
                                <a href="' . SITE_URL . 'people/' . $people['username_url'] . '">
                                <p class="time_text extra_text_hide">@' . $people['username_url'] . '</p>
                                </a>
                                </div>
                                </div>';
                                $output[] = $message;
                                $output[] = $people["id"];
                                echo json_encode($output);
                            } else {
                                echo "false";
                            }
                        } else {
                            echo 0;
                        }
                    } else {
                        $this->Flash->error(__d('user', 'You cannot follow yourself'));
                        $this->redirect('/');
                    }
                }
                die;
            }

            /* add Follow users */
            public function addflwUsrs()
            {
                global $loguser;
                $logusrid = $loguser['id'];
                $logusername = $loguser['username'];
                $logfirstname = $loguser['first_name'];
                $userid = $_REQUEST['usrid'];

                $followerstable = TableRegistry::get('Followers');
                $flwalrdy = $followerstable->find('all')->where(['user_id' => $userid])->where(['follow_user_id' => $logusrid])->count();
                $userlevels = array('god', 'moderator');

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $userstable = TableRegistry::get('Users');
                $usrdetails = $userstable->find('all')->where(['Users.id' => $userid])->first();
                $loggedusrdetails = $userstable->find('all')->where(['Users.id' => $logusrid])->first();
                $usrflwrs = $usrdetails['follow_count'];

                if ($flwalrdy > 0) {
                    echo "error";
                } else {
                    if ($userid != $logusrid) {
                        $followersTable = TableRegistry::get('Followers');
                        $Followers = $followersTable->newEntity();
                        $Followers->user_id = $userid;
                        $Followers->follow_user_id = $logusrid;
                        $result = $followersTable->save($Followers);

                        $followId = $result->id;

                        $flwrscnt = $followersTable->flwrscnt($userid);
                        $totl_flwrs = 0;
                        if (!empty($flwrscnt)) {
                            foreach ($flwrscnt as $flws) {
                                $totl_flwrs = $totl_flwrs + $flws['totl_flwrscnt'];
                            }
                            $totl_flwrs -= 2;
                        }
                        $totalflwrs = $usrflwrs + 1;
                        $query = $userstable->query();
                        $query->update()
                        ->set(['follow_count' => "'$totalflwrs'"])
                        ->where(['Users.id' => $userid])
                        ->execute();


                        $notificationSettings = json_decode($usrdetails['push_notifications'], true);
                        if ($notificationSettings['somone_flw_push'] == 1) {
                            $logusernameurl = $loguser['username_url'];
                            $userDesc = $loguser['about'];
                            $userImg = $loguser['profile_image'];
                            if (empty($userImg)) {
                                $userImg = 'usrimg.jpg';
                            }
                            $image['user']['image'] = $userImg;
                            $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                            $loguserimage = json_encode($image);
                            $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                            $notifymsg = $loguserlink . " -___-is now following you";
                            $logdetails = $this->addlog('follow', $logusrid, $userid, $followId, $notifymsg, $userDesc, $loguserimage);
                        }

                        $userdevicestable = TableRegistry::get('Userdevices');
                        $userddett = $userdevicestable->find('all')->where(['user_id' => $userid])->all();
                        foreach ($userddett as $userdet) {
                            $deviceTToken = $userdet['deviceToken'];
                            $badge = $userdet['badge'];
                            $badge += 1;


                            $querys = $userdevicestable->query();
                            $querys->update()
                            ->set(['badge' => $badge])
                            ->where(['deviceToken' => $deviceTToken])
                            ->execute();

                            if (isset($deviceTToken)) {
                                $pushMessage['type'] = 'follow';
                                $pushMessage['user_id'] = $logusrid;
                                $pushMessage['user_name'] = $loggedusrdetails['username'];
                                $pushMessage['user_image'] = $userImg;
                                $user_detail = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                                I18n::locale($user_detail['languagecode']);
                                $pushMessage['message'] = __d('user', 'is now following you');
                                $messages = json_encode($pushMessage);
                                $this->pushnot($deviceTToken, $messages, $badge);
                            }
                        }

                        $user_email = $userstable->find('all')->where(['Users.id' => $userid])->first();
                        $emailaddress = $user_email['email'];
                        $name = $user_email['first_name'];
                        $follow_status = $user_email['someone_follow'];
                        $username_url = $loguser['username_url'];
                        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                        if ($follow_status == 1) {


                            $email = $emailaddress;
                            $aSubject = $setngs['site_name'] . " - " . $loguser['first_name'] . " " . __d('user', 'Following you on') . " " . $setngs['site_name'];
                            $template = 'followmail';
                            $setdata = array('name' => $name, 'username_url' => $username_url, 'email' => $email_address, 'username' => $loguser['first_name'], 'access_url' => SITE_URL . 'login', 'setngs' => $setngs);
                            $this->sendmail($emailaddress, $aSubject, '', $template, $setdata);

                            
                        }
                        if (isset($_POST['followlist'])) {
                            $listId = $_POST['listid'];
                            $roundProfile = "";
                            if ($siteChanges['profile_image_view'] == 'round') {
                                $roundProfile = "border-radius:150px;";
                            }
                            $followlist = explode(",", $_POST['followlist']);
                            $followerstable = TableRegistry::get('Followers');
                            $followcnt = $followerstable->followcnt($loguser['id']);
                            if (!empty($followcnt)) {
                                foreach ($followcnt as $flcnt) {
                                    $followlist[] = $flcnt['user_id'];
                                }
                            }
                            $followlist[] = $logusrid;
                            $people = $userstable->find('all')->where(['id NOT IN' => $followlist])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                                return $exp->notEq('activation', '0');
                            })->order(['Users.id' => 'ASC'])->first();
                            if (!empty($people)) {
                                $message .= "<div class='whotofollow'>";
                                $message .= " <a href='" . SITE_URL . "people/" . $people["username_url"] . "' title='" . $people["username"] . "'>";
                                $message .= "<div class='whotofollow-img'>";
                                $imgname = $_SESSION['media_url'] . "media/avatars/thumb70/" . $people["profile_image"];
                                $imgsze = getimagesize($imgname);
                                if (!empty($people["profile_image"]) && !empty($imgsze)) {
                                    $message .= "<img style='margin-right: 2px;$roundProfile' src='" . $_SESSION['media_url'] . "media/avatars/thumb70/" . $people["profile_image"] . "' />";
                                } else {
                                    $message .= "<img src='" . $_SESSION['media_url'] . "media/avatars/thumb70/usrimg.jpg' style='" . $roundProfile . "' />";
                                }
                                $message .= "</div>";
                                $message .= "<div class='whotofollow-info'>";

                                $message .= "<p class='user'>" . $people["User"]["first_name"] . ' ' . $people["last_name"] . "</p>
                                <p class='username'>@" . $people["username_url"] . '</p>';
                                $message .= "</div>";
                                $message .= "</a>";
                                $message .= "<div class='whotofollow-btn'>";
                                $message .= "<span class='follow'   id='foll" . $people['id'] . "'>";
                                $message .= '<button type="button" id="follow_btn' . $people['id'] . '"
                                class="btnblu" onclick="hashtagfollow(' . $people['id'] . ',' . $listId . ')">';
                                $message .= '<span class="foll' . $people['id'] . '" >';
                                $message .= __('Follow');
                                $message .= '</span>';
                                $message .= '</button>';
                                $message .= "</span>";
                                $message .= "</div>";
                                $message .= '</div>';
                                $output[] = $message;
                                $output[] = $people["id"];
                                echo json_encode($output);
                            } else {
                                echo "false";
                            }
                        } else {
                            echo 0;
                        }
                    } else {
                        $this->Flash->error(__d('user', 'You cannot follow yourself'));
                        $this->redirect('/');
                    }
                }
                die;
            }

            function delerteflwUsrs()
            {
                global $loguser;
                $logusrid = $loguser['id'];
                $userid = $_REQUEST['usrid'];
                $userstable = TableRegistry::get('Users');
                $followerstable = TableRegistry::get('Followers');
                $shopstable = TableRegistry::get('Shops');
                $logstable = TableRegistry::get('Logs');
                $this->loadModel('Follower');
                $this->loadModel('Shop');
                $this->loadModel('Log');
                $flwalrdy = $followerstable->find()->where(['user_id' => $userid])->where(['follow_user_id' => $logusrid])->count();

                $usrdetails = $userstable->find()->where(['Users.id' => $userid])->first();
                $usrflwrs = $usrdetails['follow_count'];

                if ($flwalrdy > 0) {
                    $followquery = $followerstable->query();
                    $followquery->delete()
                    ->where(['user_id' => $userid])
                    ->where(['follow_user_id' => $logusrid])
                    ->execute();
                    $logquery = $logstable->query();
                    $logquery->delete()
                    ->where(['userid' => $logusrid])
                    ->where(['notifyto' => $userid])
                    ->execute();
                    $flwrscnt = $followerstable->flwrscnt($userid);
                    $totl_flwrs = 0;
                    if (!empty($flwrscnt)) {
                        foreach ($flwrscnt as $flws) {
                            $totl_flwrs = $totl_flwrs + $flws['totl_flwrscnt'];
                        }
                        $totl_flwrs -= 2;
                    }
                    $query = $userstable->query();
                    $query->update()
                    ->set(['follow_count' => "'$totalflwrs'"])
                    ->where(['Users.id' => $userid])
                    ->execute();


                    echo 0;
                } else {
                    echo "error";
                }
                die;
            }

            /************* Shop followers ****************/

            function addflwShops()
            {
                global $loguser;
                $logusrid = $loguser['id'];
                $logusername = $loguser['username'];
                $shopid = $_REQUEST['shopid'];
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $shopstable = TableRegistry::get('Shops');
                $itemstable = TableRegistry::get('Items');
                $userstable = TableRegistry::get('Users');
                $userdevicestable = TableRegistry::get('Userdevices');
                $userlevels = array('god', 'moderator');

                $flwalrdy = $storefollowerstable->find('all')->where(['store_id' => $shopid])->where(['follow_user_id' => $logusrid])->count();

                $usrdetails = $shopstable->find('all')->where(['Shops.id' => $shopid])->first();

                $userid = $usrdetails['user_id'];
                $userdetail = $userstable->find('all')->where(['Users.id' => $userid])->first();
                $shopflwrs = $usrdetails['follow_count'];

                if ($flwalrdy > 0) {
                    echo "error";
                } else {
                    if ($userid != $logusrid) {
                        $storefollowersTable = TableRegistry::get('Storefollowers');
                        $storefollowers = $storefollowersTable->newEntity();
                        $storefollowers->store_id = $shopid;
                        $storefollowers->follow_user_id = $logusrid;
                        $result = $storefollowersTable->save($storefollowers);

                        $followId = $result->id;

                        $flwrscnt = $storefollowersTable->flwrscnt($shopid);

                        $totl_flwrs = 0;
                        if (!empty($flwrscnt)) {
                            foreach ($flwrscnt as $flws) {
                                $totl_flwrs = $totl_flwrs + $flws['totl_flwrscnt'];
                            }
                        }

                        $totalflwrs = $shopflwrs + 1;

                        $query = $shopstable->query();
                        $query->update()
                        ->set(['follow_count' => "'$totalflwrs'"])
                        ->where(['user_id' => $userid])
                        ->execute();


                        $notificationSettings = json_decode($userdetail['push_notifications'], true);

                        if ($notificationSettings['somone_flw_push'] == 1) {
                            $logusernameurl = $loguser['username_url'];
                            $logfirstname = $loguser['first_name'];
                            $userDesc = $loguser['about'];
                            $userImg = $loguser['profile_image'];
                            if (empty($userImg)) {
                                $userImg = 'usrimg.jpg';
                            }
                            $image['user']['image'] = $loguser['profile_image'];
                            $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                            $loguserimage = json_encode($image);
                            $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                            $notifymsg = $loguserlink . " -___-is now following your Store";
                            $logdetails = $this->addlog('follow', $logusrid, $userid, $followId, $notifymsg, $userDesc, $loguserimage);
                        }

                        $sitesettings = TableRegistry::get('sitesettings');
                        $setngs = $sitesettings->find()->first();
                        $email = $userdetail['email'];
                        $aSubject = $setngs['site_name'] . " - " . $loguser['first_name'] . " " . __d('user', 'Following your store on') . " " . $setngs['site_name'];
                        $name = $userdetail['first_name'];
                        $username_url = $loguser['username_url'];
                        $template = 'storefollowmail';
                        $setdata = array('name' => $name, 'username_url' => $username_url, 'email' => $email, 'username' => $loguser['first_name'], 'setngs' => $setngs);
                        $this->sendmail($email, $aSubject, '', $template, $setdata);


                        $userdevicestable = TableRegistry::get('Userdevices');
                        $userddett = $userdevicestable->find('all')->where(['user_id' => $userid])->all();
                        foreach ($userddett as $userdet) {
                            $deviceTToken = $userdet['deviceToken'];
                            $badge = $userdet['badge'];
                            $badge += 1;

                            $querys = $userdevicestable->query();
                            $querys->update()
                            ->set(['badge' => "'$badge'"])
                            ->where(['deviceToken' => $deviceTToken])
                            ->execute();
                            $userImg = $loguser['profile_image'];
                            if (empty($userImg)) {
                                $userImg = 'usrimg.jpg';
                            }
                            if (isset($deviceTToken)) {
                                $pushMessage['type'] = 'follow';
                                $pushMessage['user_id'] = $loguser['id'];
                                $pushMessage['user_name'] = $loguser['username'];
                                $pushMessage['user_image'] = $userImg;
                                $user_detail = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                                I18n::locale($user_detail['languagecode']);
                                $pushMessage['message'] = __d('user', 'is now following your Store');
                                $messages = json_encode($pushMessage);
                            }
                        }
                        if (isset($_POST['followlist'])) {
                            $listId = $_POST['listid'];
                            $roundProfile = "";
                            if ($siteChanges['profile_image_view'] == 'round') {
                                $roundProfile = "border-radius:150px;";
                            }
                            $followlist = explode(",", $_POST['followlist']);
                            $followcnt = $storefollowerstable->followcnt($loguser['id']);
                            if (!empty($followcnt)) {
                                foreach ($followcnt as $flcnt) {
                                    $followlist[] = $flcnt['user_id'];
                                }
                            }
                            $followlist[] = $logusrid;

                            $people = $userstable->find('all')->where(['id NOT IN' => $followlist])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                                return $exp->notEq('activation', '0');
                            })->first();
                            $peopleItem = $itemstable->find('all')->contain(['Photos'])->where(['Items.user_id' => $people['id']])->order(['Items.id DESC'])->all();

                            if (!empty($people)) {
                                $message .= "<div class='whotofollow'>";
                                $message .= " <a href='" . SITE_URL . "people/" . $people["username_url"] . "' title='" . $people["username"] . "'>";
                                $message .= "<div class='whotofollow-img'>";
                                if (!empty($people["profile_image"])) {
                                    $message .= "<img style='margin-right: 2px;$roundProfile' src='" . $_SESSION['media_url'] . "media/avatars/thumb70/" . $people["profile_image"] . "' />";
                                } else {
                                    $message .= "<img src='" . $_SESSION['media_url'] . "media/avatars/thumb70/usrimg.jpg' style='" . $roundProfile . "' />";
                                }
                                $message .= "</div>";
                                $message .= "<div class='whotofollow-info'>";
                                $message .= "<p class='users'>" . $people["username"] . "</p>
                                <p class='username'>@" . $people["username_url"] . '</p>';
                                $message .= "</div>";
                                $message .= "</a>";
                                $message .= "<div class='whotofollow-btn'>";
                                $message .= "<span class='follow'   id='foll" . $people['id'] . "'>";
                                $message .= '<button type="button" id="follow_btn' . $people['id'] . '"
                                class="btnblu" onclick="hashtagfollow(' . $people['id'] . ',' . $listId . ')">';
                                $message .= '<span class="foll' . $people['id'] . '" >';
                                $message .= __('Follow');
                                $message .= '</span>';
                                $message .= '</button>';
                                $message .= "</span>";
                                $message .= "</div>";
                                $message .= '</div>';
                                $message .= '<div class="follow-people-item">';
                                if (!empty($peopleItem)) {
                                    $message .= "<div class='follow-user-items'>";
                                    $message .= "<ul>";
                                    foreach ($peopleItem as $followItem) {
                                        $message .= "<li>";
                                        $message .= "<a href='" . SITE_URL . "listing/" . $followItem['id'] .
                                        "/" . $followItem['item_title_url'] . "' title='" .
                                        $followItem['item_title'] . "'>";
                                        $message .= "<div style='background-image:url(\"" . $_SESSION['media_url'] .
                                        'media/items/original/' . $followItem['photos'][0]['image_name'] .
                                        "\");'></div>";
                                        $message .= "</a>";
                                        $message .= "</li>";
                                    }
                                    $message .= "</ul>";
                                    $message .= "</div>";
                                }
                                $message .= '</div>';
                                $output[] = $message;
                                $output[] = $people["id"];
                                echo json_encode($output);
                            } else {
                                echo "false";
                            }
                        } else {
                            echo 0;
                        }
                    } else {
                        $this->Flash->error(__d('user', 'You cannot follow yourself'));
                        $this->redirect('/');
                    }
                }
                die;
            }


            function deleteflwShops()
            {
                global $loguser;
                $logusrid = $loguser['id'];
                $shopid = $_REQUEST['shopid'];
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $shopstable = TableRegistry::get('Shops');
                $flwalrdy = $storefollowerstable->find('all')->where(['store_id' => $shopid])->where(['follow_user_id' => $logusrid])->count();
                $usrdetails = $shopstable->find('all')->where(['Shops.id' => $shopid])->first();
                $userid = $usrdetails['user_id'];
                $shopflwrs = $usrdetails['follow_count'];

                if ($flwalrdy > 0) {

                    $storefollowquery = $storefollowerstable->query();
                    $storefollowquery->delete()
                    ->where(['store_id' => $shopid])
                    ->where(['follow_user_id' => $logusrid])
                    ->execute();

                    $flwrscnt = $storefollowerstable->flwrscnt($shopid);
                    $totl_flwrs = 0;
                    if (!empty($flwrscnt)) {
                        foreach ($flwrscnt as $flws) {
                            $totl_flwrs = $totl_flwrs + $flws['totl_flwrscnt'];
                        }
                    }
                    if ($shopflwrs > 0) {
                        $totalflwrs = $shopflwrs - 1;
                    } else {
                        $totalflwrs = 0;
                    }
                    $query = $shopstable->query();
                    $query->update()
                    ->set(['follow_count' => "'$totalflwrs'"])
                    ->where(['user_id' => $userid])
                    ->execute();


                    echo 0;
                } else {
                    echo "error";
                }
                die;
            }

            public function addlog($type = null, $userId = null, $notifyTo = null, $sourceId = null, $notifymsg = null, $message = null, $image = null, $itemid = 0)
            {
                $this->loadModel('Log');
                $this->loadModel('User');

                $userstable = TableRegistry::get('Users');
                $logstable = TableRegistry::get('Logs');
                $logs = $logstable->newEntity();
                $logs->type = $type;
                $logs->userid = $userId;
                $logs->notifyto = 0;
                if (!is_array($notifyTo))
                    $logs->notifyto = $notifyTo;
                $logs->sourceid = $sourceId;

                $logs->itemid = $itemid;
                $logs->notifymessage = $notifymsg;
                $logs->message = $message;
                $logs->image = $image;
                $logs->cdate = time();

                $logstable->save($logs);
                $userdata = $userstable->find()->where(['Users.id' => $notifyTo])->first();
                $unread_notify_cnt = $userdata['unread_notify_cnt'] + 1;
                $query = $userstable->query();
                $query->update()
                ->set(['unread_notify_cnt' => $unread_notify_cnt])
                ->where(['Users.id' => $notifyTo])
                ->execute();
            }

            public function addloglive($type = null, $userId = null, $notifyTo = null, $sourceId = null, $notifymsg = null, $message = null, $image = null, $itemid = 0)
            {
                $this->loadModel('Log');
                $this->loadModel('User');

                $userstable = TableRegistry::get('Users');
                $logstable = TableRegistry::get('Logs');
                $logs = $logstable->newEntity();
                $logs->type = $type;
                $logs->userid = $userId;
                $logs->notifyto = 0;
                if (!is_array($notifyTo))
                    $logs->notifyto = $notifyTo;
                $logs->sourceid = $sourceId;

                $logs->itemid = $itemid;
                $logs->notifymessage = $notifymsg;
                $logs->message = $message;
                $logs->image = $image;
                $logs->cdate = time();

                $logstable->save($logs);

                $query = $userstable->query();
                if (!empty($notifyto)) {
                    $query->update()->set($query->newExpr('unread_livefeed_cnt = unread_livefeed_cnt + 1'))->where(['id IN' => $notifyTo])
                    ->execute();
                }
            }

            public function showlistproducts()
            {
                global $loguser;
                $listid = $_REQUEST['listid'];
                $userid = $loguser['id'];
                $itemlistsTable = TableRegistry::get('Itemlists');
                $itemsTable = TableRegistry::get('Items');
                $itemListsAll = $itemlistsTable->find('all')->where(['id' => $listid])->first();
                $list_itemides = json_decode($itemListsAll['list_item_id'], true);
                if (count($list_itemides) > 0)
                    $itemdatasall = $itemsTable->find('all')->contain(['Photos'])->contain(['Forexrates'])->where(['Items.id IN' => $list_itemides])->all();
                else
                    $itemdatasall = array();

                $itemliststable = TableRegistry::get('Itemlists');
                $this->loadModel('Categories');
                $items_list_data = $itemliststable->find()->where(['user_id' => $userid])->where(['user_create_list' => '1'])->all();
                $prnt_cat_data = $this->Categories->find('all', array('recursive' => '-1', 'conditions' => array('category_parent' => 0, 'category_sub_parent' => 0)));
                $this->set('items_list_data', $items_list_data);
                $this->set('prnt_cat_data', $prnt_cat_data);
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                $this->set('setngs', $setngs);
                $this->set('listid', $listid);
                $this->set('userid', $userid);
                $this->set('itemListsAll', $itemListsAll);
                $this->set('itemdatasall', $itemdatasall);
            }

            public function savelistname()
            {
                $this->autoRender = false;
                $listid = $_POST['listid'];
                $listname = $_POST['listname'];
                $itemlistsTable = TableRegistry::get('Itemlists');
                $query = $itemlistsTable->query();
                $query->update()
                ->set(['lists' => "$listname"])
                ->where(['Itemlists.id' => $listid])
                ->execute();
            }

            public function profile()
            {
                global $loguser;
                $b_year = $_POST['setting-birthday-year'];
                $b_month = $_POST['setting-birthday-month'];
                $b_day = $_POST['setting-birthday-day'];
                $birthday_date = $b_year . '-' . $b_month . '-' . $b_day;
                $userstable = TableRegistry::get('Users');
                if (isset($_POST) && count($_POST) > 0) {
                    $user = $userstable->get($loguser['id']);
                    $user->first_name = $_POST['setting-fullname'];
                    $user->website = $_POST['website'];
                    $user->city = $_POST['city'];
                    $user->age_between = $_POST['agebtwen'];
                    $user->birthday = $birthday_date;
                    $user->about = $_POST['setting-bio'];
                    $user->gender = $_POST['gender'];
                    if (!empty(trim($this->request->data['profile_image'])))
                        $profile_image = $this->request->data['profile_image'];
                    $user->profile_image = $profile_image;
                    if ($userstable->save($user))
                        echo '';
                    else
                        echo '';
                }
                $usr_datas = $userstable->find('all')->where(['Users.id' => $loguser['id']])->first();
                $this->set('usr_datas', $usr_datas);
                $this->set('loguser', $loguser);
            }

            public function deactivateacc()
            {
                global $setngs;
                $this->autoRender = false;
                $userstable = TableRegistry::get('Users');
                $userid = $_POST['userid'];
                $user = $userstable->get($userid);
                $user->user_status = 'disable';
                $userstable->save($user);
                $user->checkdisabled = '1';
                $session = $this->request->session();
                $session->destroy();
                $this->Auth->logout();

            }

            public function activateacc()
            {
                global $setngs;
                $userstable = TableRegistry::get('Users');
                $userid = $_POST['userid'];
                $user = $userstable->get($userid);
                $user->user_status = 'enable';
                $user->checkdisabled = '0';
                $userstable->save($user);
                $session = $this->request->session();
                $session->destroy();
                return $this->redirect($this->Auth->logout());

            }

            public function password()
            {

                global $loguser;
                $userstable = TableRegistry::get('Users');
                $usr_datas = $userstable->find('all')->where(['Users.id' => $loguser['id']])->first();
                if (isset($_POST) && count($_POST) > 0) {
                    $exispassword = (new DefaultPasswordHasher)->hash($_POST['epassword']);
                    $password = $_POST['password'];
                    $apass = (new DefaultPasswordHasher)->hash($password);
                    $verify = (new DefaultPasswordHasher)->check($_POST['epassword'], $usr_datas['password']);

                    if ($_POST['epassword'] == "xxx_xxx" && $usr_datas['login_type'] != 'normal' && $usr_datas['password'] == "")
                        $verify = 1;

                    if ($verify == 1) {
                        $user = $userstable->get($loguser['id']);
                        $user->password = $apass;
                        $userstable->save($user);
                        $this->Flash->success(__d('user', 'Password updated successfully'));
                    } else {
                        $this->Flash->success(__d('user', 'Existing password is incorrect'));
                    }
                }

                $this->set('usr_datas', $usr_datas);
            }

            public function notifications()
            {
                global $loguser;
                $userstable = TableRegistry::get('Users');
                $usr_datas = $userstable->find('all')->where(['Users.id' => $loguser['id']])->first();
                $this->set('usr_datas', $usr_datas);

                if (isset($_POST) && count($_POST) > 0) {

                    $news_abt = $_POST['news_abt'];
                    $somone_flw = $_POST['somone_flw'];
                    $somone_cmnts = $_POST['somone_cmnts'];
                    $things_featured = $_POST['things_featured'];

                    $notification = array();
                    $notification['somone_flw_push'] = $_POST['somone_flw_push'];
                    $notification['somone_cmnts_push'] = $_POST['somone_cmnts_push'];
                    $notification['somone_mentions_push'] = $_POST['somone_mentions_push'];
                    $notification['somone_likes_ur_item_push'] = $_POST['somone_likes_ur_item_push'];
                    $notification['frends_flw_push'] = $_POST['frends_flw_push'];
                    $notification['frends_cmnts_push'] = $_POST['frends_cmnts_push'];

                    $notification = json_encode($notification);
                    $notification = str_replace("null", "0", $notification);
                    $notification = str_replace("NULL", "1", $notification);

                    $user = $userstable->get($loguser['id']);
                    $user->push_notifications = $notification;


                    if ($news_abt == 'NULL') {
                        $user->subs = '1';
                    } else {
                        $user->subs = '0';
                    }
                    if ($somone_flw == 'NULL') {
                        $user->someone_follow = '1';
                    } else {
                        $user->someone_follow = '0';
                    }

                    if ($somone_cmnts == 'NULL') {
                        $user->someone_cmnt_ur_things = '1';
                    } else {;
                        $user->someone_cmnt_ur_things = '0';
                    }

                    if ($things_featured == 'NULL') {
                        $user->your_thing_featured = '1';
                    } else {;
                        $user->your_thing_featured = '0';
                    }

                    $userstable->save($user);


                    $this->redirect('/notifications/');
                }


                $this->set('usr_datas', $usr_datas);
            }

            function addshipping($id = null)
            {
                if (empty($this->request->data)) {
                    $_SESSION['referurl'] = $this->request->referer();
                }
                $tempaddrtable = TableRegistry::get('Tempaddresses');
                $countrytable = TableRegistry::get('Countries');
                $userstable = TableRegistry::get('Users');
                
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }
                global $loguser;
                $userid = $loguser['id'];
                $first_name = $loguser['first_name'];
                $usrr_datas = $userstable->find('all')->where(['id' => $loguser['id']])->first();

                $this->set('first_name', $first_name);
                if ($id != null) {
                    $usr_datas = $tempaddrtable->find('all')->where(['shippingid' => $id])->first();
                    if ($usrr_datas['defaultshipping'] == $id) {
                        $sta = 0;
                    }else
                    {
                        $sta = 1;
                    }
                    $this->set('sta', $sta);
                    $this->set('usr_datas', $usr_datas);
                    if ($userid != $usr_datas['userid']) {
                        $this->Flash->error(__d('user', 'Sorry ! No such record was found'));
                        $this->redirect('/');
                    }
                }

                if (isset($_POST) && count($_POST) > 0) {
                    $ship_datas = $tempaddrtable->find('all')->where(['userid' => $userid])->all();
                    $countrycode = $_POST['country'];
                    $countryModel = $countrytable->find('all')->where(['id' => $countrycode])->first();
                    $countryname = $countryModel['country'];
                    if ($_POST['shippingId'] != 0) {
                        $tempaddress = $tempaddrtable->find('all')->where(['shippingid' => $_POST['shippingId']])->first();
                    } else {
                        $tempaddress = $tempaddrtable->newEntity();
                        
                    }
                    $tempaddress->userid = $userid;
                    $tempaddress->name = $_POST['fullname'];
                    $tempaddress->nickname = $_POST['nickname'];
                    $tempaddress->country = $countryname;
                    $tempaddress->state = $_POST['state'];
                    $tempaddress->address1 = $_POST['address1'];
                    $tempaddress->address2 = $_POST['address2'];
                    $tempaddress->city = $_POST['city'];
                    $tempaddress->zipcode = $_POST['zipcode'];
                    $tempaddress->phone = $_POST['phone'];
                    $tempaddress->countrycode = $countrycode;
                    $result = $tempaddrtable->save($tempaddress);
                    $shippingid = $result->shippingid;
                    if (count($ship_datas) == 0) {
                        $user = $userstable->get($userid);
                        $user->defaultshipping = $shippingid;
                        $userstable->save($user);
                    }
                    if (isset($_POST['setdefault'])) {
                        $user = $userstable->get($userid);
                        $user->defaultshipping = $shippingid;
                        $userstable->save($user);
                    }

                    $carturl = $_SESSION['redirectcart'];
                    $codurl = $_SESSION['redirectcod'];
                    $referurl = $_SESSION['referurl'];
                    $this->Flash->success(__d('user', 'Address has been saved successfully.'));
                    if (($carturl == $referurl)) {
                        unset($_SESSION['redirectcart']);
                        $this->redirect('/cart');
                    } elseif ($codurl == $referurl) {
                        unset($_SESSION['redirectcod']);
                        $this->redirect('/cod/' . $_SESSION['buynow_product']);
                    } else {
                        $this->redirect('/address');
                    }

                }
                $countrylist = $countrytable->find('all');
                $this->set('carturl', $carturl);
                $this->set('referrerurl', $referrerurl);
                $this->set('countrylist', $countrylist);
            }

            function shipping()
            {
                $tempaddrtable = TableRegistry::get('Tempaddresses');
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }
                global $loguser;
                $userid = $loguser['id'];

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);

                $usersTable = TableRegistry::get('Users');
                $usershipdefault = $usersTable->get($userid);
                $usershipdefault = $usershipdefault['defaultshipping'];

                $shippingModel = $tempaddrtable->find('all')->where(['userid' => $userid])->all();



                $this->set('shippingModel', $shippingModel);
                $this->set('usershipping', $usershipdefault);
            }

            function defaultshipping()
            {
                $this->autoRender = false;
                $shipid = $_POST['shippingid'];
                global $loguser;
                $userid = $loguser['id'];

                $userstable = TableRegistry::get('Users');
                $user = $userstable->get($userid);
                $user->defaultshipping = $shipid;
                $userstable->save($user);
            }

            function deleteshipping()
            {
                $this->autoRender = false;
                global $loguser;
                $userid = $loguser['id'];
                $tempaddrtable = TableRegistry::get('Tempaddresses');
                $shipid = $_POST['shippingid'];

                $userstable = TableRegistry::get('Users');
                $usershipdefault = $userstable->get($userid);
                $usershipdefault = $usershipdefault['defaultshipping'];
                if ($usershipdefault == $shipid) {
                    $query = $userstable->query();
                    $query->update()
                    ->set(['defaultshipping' => '0'])
                    ->where(['Users.id' => $userid])
                    ->execute();
                }
                $tempquery = $tempaddrtable->query();
                $tempquery->delete()
                ->where(['shippingid' => $shipid])
                ->execute();
            }

            public function credits()
            {
                global $loguser;
                $userid = $loguser['id'];
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);

                    //$itemModel = array();
                $this->loadModel('Userinvitecredit');
                $this->loadModel('User');
                $this->loadModel('Orders');
                $this->loadModel('Groupgiftpayamts');
                $this->loadModel('Shareproducts');

                $credittable = TableRegistry::get('Userinvitecredits');
                $userstable = TableRegistry::get('Users');
                $refundorders = $this->Orders->find()->where(['userid' => $userid])->andwhere(['refunded_amount >' => 0])->all();
                $giftrefund = $this->Groupgiftpayamts->find()->where(['paiduser_id' => $userid,'status' => 'refunded'])->all();
                $this->set('refundorders', $refundorders);
                $query = $credittable->find();
                $invite_credits = $credittable->find('all')->where(['invited_friend' => $userid])->select(['total' => $query->func()->sum('credit_amount')])->first();
                $creditamt_user = $credittable->find('all')->contain('Users')->where(['invited_friend' => $userid])->order(['Userinvitecredits.id DESC'])->all();
                $available_bal = $userstable->get($userid);

                $shareproductstable = TableRegistry::get('Shareproducts');
                $shareproducts =  $shareproductstable->find()->contain('Items')->where(['sender_id' => $userid])->where(['Shareproducts.status' => 'paid'])->all();
                $this->set('shareitem_purchases', $shareproducts);

                $this->set('invite_credits', $invite_credits['total']);
                $this->set('giftrefund', $giftrefund);
                $this->set('creditamt_user', $creditamt_user);
                $this->set('available_bal', round($available_bal['credit_total'], 2));
            }

            public function referrals()
            {
                global $loguser;
                $userid = $loguser['id'];

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }
                    //$itemModel = array();
                $userinvitetable = TableRegistry::get('Userinvites');
                $invited_friend = $userinvitetable->find('all')->where(['user_id' => $userid])->order(['id DESC'])->all();
                $invitedCount = $userinvitetable->find('all')->where(['user_id' => $userid])->count();
                $joinedCount = $userinvitetable->find('all')->where(['user_id' => $userid])->where(['status' => 'Joined'])->count();
                $this->set('invited_friend', $invited_friend);
                $this->set('invitCount', $invitedCount);
                $this->set('joinedCount', $joinedCount);
            }

            public function giftCards()
            {
                global $loguser;
                $userid = $loguser['id'];

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);

                $email = $loguser['email'];
                $username = $loguser['username'];
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }
                $giftcardstable = TableRegistry::get('Giftcards');

                $giftcarddets = $giftcardstable->find('all')->contain('Users')->where(['Giftcards.user_id' => $userid])->where(['Giftcards.status' => 'Paid'])->order(['Giftcards.id DESC'])->all();
                $giftcarddets_recv = $giftcardstable->find('all')->contain('Users')->where(['Giftcards.reciptent_email' => $email])->where(['Giftcards.status' => 'Paid'])->order(['Giftcards.id DESC'])->all();




                $this->set('giftcarddets', $giftcarddets);
                $this->set('giftcarddets_recv', $giftcarddets_recv);
            }

            public function storeprofiles($name = null, $usrstates = null, $pagev = null)
            {

                global $loguser;

                $this->loadModel('Items');
                $userid = $loguser['id'];
                $_SESSION['username_urls'] = $name;
                $sitesettings = TableRegistry::get('sitesettings');
                $setngs = $sitesettings->find()->first();

                $itemstable = TableRegistry::get('Items');
                $photostable = TableRegistry::get('Photos');
                $itemfavstable = TableRegistry::get('Itemfavs');
                $itemliststable = TableRegistry::get('Itemlists');
                $categoriestable = TableRegistry::get('Categories');
                $logstable = TableRegistry::get('Logs');
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $shopstable = TableRegistry::get('Shops');
                $userstable = TableRegistry::get('Users');
                $followerstable = TableRegistry::get('Followers');

                $shopdetl = $shopstable->find('all')->where(['shop_name_url' => $name])->first();
                $id = $shopdetl['user_id'];
                if (empty($shopdetl)) {
                    $this->redirect($this->referer());
                }
                $_SESSION['user_id'] = $id;
                if (empty($name) && empty($id)) {
                    $this->redirect($this->referer());
                }

                $followcnt = $storefollowerstable->followcnt($loguser['id']);
                $this->set('followcnt', $followcnt);

                $userdtl = $userstable->find('all')->where(['Users.id' => $id])->first();
                $shopsdet = $shopstable->find('all')->where(['seller_status' => 1])->where(['user_id' => $id])->first();
                $this->set('userdtl', $userdtl);
                if (empty($shopsdet)) {
                    $this->redirect('/people/' . $userdtl['username']);
                }
                $shopid = $shopsdet['id'];
                $shop_user_id = $shopsdet['user_id'];
                $this->set('shopsdet', $shopsdet);
                $flwrscnt = $followerstable->find('all')->where(['user_id' => $id])->where(['follow_user_id' => $userid])->count();
                $this->set('follow_shop', $flwrscnt);

                $follow_user_count = $followerstable->find('all')->where(['follow_user_id' => $loguser['id']])->all();
                $this->set('follow_user_count', $follow_user_count);

                $this->set('userid', $userid);



                $prnt_cat_data = $categoriestable->find('all')->where(['category_parent' => 0])->where(['category_sub_parent' => 0])->all();


                $items_list_data = $itemliststable->find('all')->where(['user_id' => $userid])->where(['user_create_list' => 1])->all();

                $this->set('prnt_cat_data', $prnt_cat_data);
                $this->set('items_list_data', $items_list_data);
                $this->set('setngs', $setngs);
                $usr_datas = $userstable->get($id);
                $current_page_userid = $usr_datas['id'];
                $current_page_userlevel = $usr_datas['user_level'];
                $this->set('name', $name);
                $this->set('current_page_userlevel', $current_page_userlevel);
                $shopdatas = $itematas = $pho_datas = array();
                $userlevels = array('god', 'moderator');

                if (count($_GET) == 0) {
                    $item_details = $itemstable->find('all')->contain('Users')->contain('Shops')->contain('Forexrates')->contain('Photos')->where(['Items.user_id' => $id])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('Items.status', 'draft');
                    })->order(['Items.id DESC'])->all();
                    $this->set('item_details', $item_details);
                }

                if (isset($_GET['news'])) {
                    $postmessage = $logstable->find('all')->where(['Logs.userid' => $id])->where(['Logs.type' => 'sellermessage'])->where(['Logs.notifyto' => 0])->order(['Logs.id DESC'])->all();
                    $this->set('postmessage', $postmessage);


                }

                if (isset($_REQUEST['followers'])) {
                    $followers = $storefollowerstable->find('all')->where(['Storefollowers.store_id' => $shopid])->all();
                    foreach ($followers as $follower) {
                        $flwrusrids[] = $follower['follow_user_id'];

                    }
                    if (count($flwrusrids) > 0) {
                        $people_details = $userstable->find('all')->contain('Itemfavs')->where(['Users.id IN' => $flwrusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                            return $exp->notEq('activation', '0');
                        })->all();
                    } else {
                        $people_details = "";
                    }

                    foreach ($people_details as $ppl_dtl) {
                        foreach ($ppl_dtl['itemfavs'] as $ppl_dt) {
                            $ppl_dtda = $ppl_dt['item_id'];
                            $pho_datass[$ppl_dtda] = $photostable->find('all')->where(['item_id' => $ppl_dtda])->all();
                        }
                    }
                    if (!empty($pho_datass)) {
                        $this->set('pho_datass', $pho_datass);
                    }
                    $this->set('people_details', $people_details);

                } else {
                }


                /************ Ratings & Reviews *******/

                $orderstable = TableRegistry::get('Orders');
                $reviewstable = TableRegistry::get('Reviews');
                $itemreviewstable = TableRegistry::get('Itemreviews');
                $usrid = $loguser['id'];
                $sellerid = $usr_datas['id'];


                $order_datas = $orderstable->find('all')->where(['Orders.userid' => $usrid])->where(['Orders.merchant_id' => $sellerid])->where(function ($exp, $q) {
                    return $exp->notEq('reviews', '1');
                })->all();
                $order_count = count($order_datas);
                $query = $orderstable->find();
                $order_date = $orderstable->find('all')->where(['Orders.userid' => $usrid])->where(['Orders.merchant_id' => $sellerid])->select(['maxorderdate' => $query->func()->max('orderdate')])->first();


                $rateval_data = $itemreviewstable->find('all')->where(['seller_id' => $sellerid])->all();
                $count = count($rateval_data);



                $reviews_added = $itemreviewstable->find('all')->contain('Users')->where(['seller_id' => $sellerid])->all();

                $review_arr = array();
                foreach($reviews_added as $key=>$val)
                {
                    $itemData = $this->Items->find('all')->where(['id'=>$val->itemid])->first();
                    $review_arr[$key] = $val;
                    $review_arr[$key]['item'] = $itemData;
                }

                //echo '<pre>'; print_r($review_arr); die;

                $shop_details = $shopstable->find('all')->where(['user_id' => $sellerid])->all();

                $shop_description = $userstable->find('all')->where(['Users.id' => $sellerid])->all();
                $this->set('shop_description', $shop_description);
                $this->set('shop_details', $shop_details);

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                $userid = $loguser['id'];

                $itemfavtable = TableRegistry::get('Itemfavs');
                $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();


                $this->set('setngs', $setngs);

                $followdet = $storefollowerstable->find('all')->where(['store_id' => $shopid])->all();

                if (count($itemfavmodel) > 0) {
                    foreach ($itemfavmodel as $itms) {
                        $itmid[] = $itms->item_id;
                    }

                    $this->set('likeditemid', $itmid);


                }
                $followcntshop = count($followdet);

                $this->set('followcntshop', $followcntshop);

                //echo '<pre>'; print_r($reviews_added); die;

                $this->set('reviews_added', $review_arr);
                $this->set('rateval_data', $rateval_data);
                $this->set('order_count', $order_count);
                $this->set("usr_datas", $usr_datas);
                $this->set('review_count', $count);
                $this->set('order_datas', $order_datas);
                $this->set('loguser', $loguser);
                $this->set('order_date', $order_date['maxorderdate']);
                /************ Ratings & Reviews *******/
                $this->set('startIndex', 15);
                $this->set('tab', $tab);
                $this->set('metavalue', 'storeprofile');
            }

            function getmorestoreprofiles()
            {
                $this->autoLayout = false;

                global $loguser;
                global $siteChanges;
                global $setngs;
                $userid = $loguser['id'];

                $userstable = TableRegistry::get('Users');
                $itemstable = TableRegistry::get('Items');
                $itemfavstable = TableRegistry::get('Itemfavs');
                $photostable = TableRegistry::get('Photos');
                $itemlists = TableRegistry::get('Itemlists');
                $shopstable = TableRegistry::get('Shops');
                $followerstable = TableRegistry::get('Followers');
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $reviewstable = TableRegistry::get('Reviews');
                $logstable = TableRegistry::get('Logs');



                $usr_datas = $userstable->find()->where(['id' => $_SESSION['user_id']])->first();
                $this->set('usr_datas', $usr_datas);
                $this->set('userid', $userid);
                $id = $usr_datas['id'];

                $offset = ($_GET['startIndex'] / 15) + 1;
                $limit = $_GET['offset'];
                $tab = $_GET['tab'];

                $shopsdet = $shopstable->find()->where(['seller_status' => '1'])->where(['user_id' => $id])->first();
                $shopid = $shopsdet['id'];
                $shop_user_id = $shopsdet['user_id'];
                $this->set('shopsdet', $shopsdet);
                $flwrscnt = $followerstable->find()->where(['user_id' => $id])->where(['follow_user_id' => $userid])->count();
                $this->set('follow_shop', $flwrscnt);

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();


                $this->set('setngs', $setngs);
                $usr_datas = $userstable->find()->where(['username_url' => $name])->first();
                $current_page_userid = $usr_datas['id'];
                $current_page_userlevel = $usr_datas['user_level'];
                $this->set('name', $name);
                $this->set('current_page_userlevel', $current_page_userlevel);
                $shopdatas = $itematas = $pho_datas = array();
                $this->loadModel('Follower');
                $flwrscnt = $followerstable->flwrscnt($usr_datas['id']);
                $followcnt = $followerstable->followcnt($usr_datas['id']);
                $flwrs = $followerstable->flwrscntlimit($usr_datas['id'], 1, 15);
                $follow = $followerstable->followcntlimit($usr_datas['id'], 1, 15);
                $flwrusrids = array();
                $totl_flwrs = 0;

                if ($tab == 'added') {
                    $query = $itemstable->query();
                    $item_details = $itemstable->find('all')->contain('Users')->contain('Shops')->contain('Forexrates')->contain('Photos')->where(['Items.user_id' => $id])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('Items.status', 'draft');
                    })->order(['Items.id DESC'])->limit($limit)->page($offset)->all();
                    $this->set('item_details', $item_details);
                }
                if ($tab == 'news') {
                    $postmessage = $logstable->find('all')->where(['Logs.userid' => $userid])->where(['Logs.type' => 'sellermessage'])->order(['Logs.id DESC'])->limit($limit)->page($offset)->all();
                    $this->set('postmessage', $postmessage);
                }
                if ($tab == 'reviews') {
                    $orderstable = TableRegistry::get('Orders');
                    $reviewstable = TableRegistry::get('Reviews');
                    $usrid = $loguser['id'];
                    $sellerid = $usr_datas['id'];


                    $order_datas = $orderstable->find('all')->where(['Orders.userid' => $usrid])->where(['Orders.merchant_id' => $sellerid])->where(function ($exp, $q) {
                        return $exp->notEq('reviews', '1');
                    })->all();
                    $order_count = count($order_datas);
                    $query = $orderstable->find();
                    $order_date = $orderstable->find('all')->where(['Orders.userid' => $usrid])->where(['Orders.merchant_id' => $sellerid])->select(['maxorderdate' => $query->func()->max('orderdate')])->first();


                    $rateval_data = $reviewstable->find('all')->where(['sellerid' => $sellerid])->all();
                    $count = count($rateval_data);

                    $reviews_added = $reviewstable->find('all')->contain('Users')->where(['sellerid' => $sellerid])->all();

                    $reviews_added = $reviewstable->find('all')->contain('Users')->where(['sellerid' => $sellerid])->all();

                    $this->set('reviews_added', $reviews_added);
                    $this->set('rateval_data', $rateval_data);
                    $this->set('order_count', $order_count);

                    $this->set('review_count', $count);
                    $this->set('order_datas', $order_datas);
                    $this->set('order_date', $order_date['maxorderdate']);
                }

                if ($tab == 'followers') {
                    $followers = $storefollowerstable->find()->where(['store_id' => $shopid])->limit($limit)->page($offset)->all();
                    foreach ($followers as $follower) {
                        $flwrusrids[] = $follower['follow_user_id'];

                    }
                    $userlevels = array('god', 'moderator');
                    $people_details = $userstable->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(['Users.id IN' => $flwrusrids])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('activation', '0');
                    })->all();

                    foreach ($people_details as $ppl_dtl) {
                        foreach ($ppl_dtl['itemfavs'] as $ppl_dt) {
                            $ppl_dtda = $ppl_dt['item_id'];
                            $pho_datass[$ppl_dtda] = $photostable->find('all')->where(['item_id' => $ppl_dtda])->all();
                        }
                    }
                    if (!empty($pho_datass)) {
                        $this->set('pho_datass', $pho_datass);
                    }
                    $followcnt = $storefollowerstable->followcnt($loguser['id']);
                    $this->set('followcnt', $followcnt);
                    $this->set('people_details', $people_details);
                }
                $this->set('tab', $tab);
                $this->set("usr_datas", $usr_datas);

            }

            public function fashionfileupload()
            {
                $this->autoRender = false;
                global $loguser;
                $userid = $loguser['id'];
                if (0 < $_FILES['file']['error']) {
                    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
                }
                $ftmp = $_FILES['file']['tmp_name'];
                $oname = $_FILES['file']['name'];
                $fname = $_FILES['file']['name'];
                $fsize = $_FILES['file']['size'];
                $ftype = $_FILES['file']['type'];

                /*
                $ext = strrchr($oname, '.');
                $user_image_path = "media/avatars/";
                $newname = time() . '_' . $userid . $ext;
                $newimage = $user_image_path . $newname;
                $finalPath = $user_image_path . "original/";
                $result = move_uploaded_file($ftmp, $finalPath . $newname);
                echo $newname;
                */
                 $appImageValues = getimagesize($ftmp);  
                    $extensionarray = array('.jpg', '.png', '.jpeg');
                    $imageSize = (trim($fsize) / 1024) / 1024;
                    $ext = strrchr(trim($oname), '.');  

                    if (trim($_POST['shareMap']) == "Sh@^*M@#" || ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && $imageSize < 2 && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png"))) {   

                        $user_image_path = "media/avatars/";
                        $newname = time() . '_' . $userid . $ext;
                        $newimage = $user_image_path . $newname;
                        $finalPath = $user_image_path . "original/";
                        $result = move_uploaded_file($ftmp, $finalPath . $newname);
                        echo $newname;
                    } else { 
                        echo 'Error: Please upload only jpg, jpeg and png images <br>';
                    }
            }

            function update()
            {
                $this->autoRender = false;
                global $loguser;
                global $setngs;
                if (!empty($this->request->data)) {
                    $this->loadModel('Fashionusers');
                    $this->loadModel('Items');
                    $this->loadModel('Users');
                    $itemstable = TableRegistry::get('Items');
                    $userstable = TableRegistry::get('Users');
                    $loguid = $loguser['id'];
                    $fashionuserstable = TableRegistry::get('Fashionusers');
                    $fashionusers = $fashionuserstable->newEntity();
                    $fashionusers->user_id = $loguser['id'];
                    $imgupfa = $fashionusers->userimage = $this->request->data['src'];
                    $itid = $fashionusers->itemId = $this->request->data['ItemId'];
                    $itemdet = $itemstable->find()->where(['id' => $itid])->first();
                    $emi = $itemstable->find()->where(['id' => $itid])->first();
                    $usid = $itemdet['user_id'];
                    $itemname = $itemdet['item_title_url'];

                    $buyid = $userstable->find()->where(['id' => $usid])->first();
                    $buyerid = $buyid['email'];
                    $buyername = $buyid['first_name'];
                    $buyerurl = $buyid['username_url'];
                    $selid = $userstable->find()->where(['id' => $loguid])->first();
                    $sellerid = $selid['email'];
                    $sellername = $selid['first_name'];


                    $this->set('buyerid', $buyerid);
                    $this->set('sellerid', $sellerid);
                    $this->set('buyername', $buyername);
                    $this->set('sellername', $sellername);
                    $this->set('imgupfa', $imgupfa);
                    $this->set('itid', $itid);
                    $this->set('itemname', $itemname);
                    $this->set('buyerurl', $buyerurl);

                    if ($loguid == $usid) {
                        $fashionusers->status = 'yes';
                    }

                    $fashionusers->cdate = time();
                    if ($this->request->data['src'] != 'usrimg.jpg' && $this->request->data['src'] != '') {
                        $result = $fashionuserstable->save($fashionusers);

                        $sitesettingstable = TableRegistry::get('Sitesettings');
                        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                        $email = $buyerid;
                        $aSubject = $setngs['site_name'] . " – " . __d('user', "There is a fashion uploaded on your product");
                        $aBody = '';
                        $template = 'uploadfashionnew';
                        $setdata = array('buyerid' => $buyerid, 'sellerid' => $sellerid, 'buyername' => $buyername, 'buyerurl' => $buyerurl, 'sellername' => $sellername, 'imgupfa' => $imgupfa, 'setngs' => $setngs);
                        $this->sendmail($email, $aSubject, $aBody, $template, $setdata);

                        $logusername = $loguser['username'];
                        $userid = $loguser['id'];
                        $notifyto = $buyid['id'];
                        $logusernameurl = $loguser['username_url'];
                        $itemname = $itemdet['item_title'];
                        $itemid = $itemdet['id'];
                        $itemurl = $itemdet['item_title_url'];
                        $liked = $setngs['liked_btn_cmnt'];
                        $userImg = $loguser['profile_image'];
                        if (empty($userImg)) {
                            $userImg = 'usrimg.jpg';
                        }
                        $image['user']['image'] = $userImg;
                        $item_url = base64_encode($itemid . "_" . rand(1, 9999));
                        $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                        $image['item']['image'] = $userdatasall['photos'][0]['image_name'];
                        $image['item']['link'] = SITE_URL . "listing/" . $item_url;
                        $loguserimage = json_encode($image);
                        $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                        $productlink = "<a href='" . SITE_URL . "listing/" . $item_url . "'>" . $itemname . "</a>";
                        $notifymsg = $loguserlink . " -___-uploaded fashion image on your product-___- " . $productlink;
                        $logdetails = $this->addloglive('fashionimage', $userid, $notifyto, 0, $notifymsg, '', $loguserimage);

                    }
                }
            }

            function orderitemdetail()
            {
                $this->autoRender = false;
                $orderid = $_POST['orderid'];
                $orderitemstable = TableRegistry::get('OrderItems');
                $orderitems = $orderitemstable->find()->where(['orderid' => $orderid])->all();
                foreach ($orderitems as $key => $items) {
                    echo '<div class="border_top_grey padding-bottom5 col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
                    <div class="checkbox checkbox-primary margin-top15 margin-bottom0">
                    <input id="checkbox' . $items['itemid'] . '" value="' . $items['itemid'] . '" type="checkbox" name="data[Dispute][itemdetail][]">
                    <label style="word-break:break:all;" for="checkbox' . $items['itemid'] . '">' . $items['itemname'] . '</label>
                    </div>
                    </div>';
                }
            }

            function dispute()
            {
                $this->autoRender = false;
                $this->set('title_for_layout', 'Settings');
                global $loguser;
                global $setngs;
                $userid = $loguser['id'];
                $userstable = TableRegistry::get('Users');
                $usr_datas = $userstable->find()->where(['id' => $loguser['id']])->first();
                $emailaddress = $loguser['email'];

                $_SESSION['first_name'] = $loguser['first_name'];
                $this->loadModel('Orders');
                $this->loadModel('Order_items');
                $this->loadModel('Items');
                $this->loadModel('Users');
                $this->loadModel('Disputes');
                $this->loadModel('Dispcons');
                $this->loadModel('Sitequeries');
                $this->loadModel('Countries');
                $this->loadModel('Shippingaddresses');
                $this->loadModel('Shipings');

                $orderstable = TableRegistry::get('Orders');
                $orderitemstable = TableRegistry::get('OrderItems');
                $itemstable = TableRegistry::get('Items');
                $userstable = TableRegistry::get('Users');
                $disputestable = TableRegistry::get('Disputes');
                $dispconstable = TableRegistry::get('Dispcons');
                $sitequeriestable = TableRegistry::get('Sitequeries');
                $countriestable = TableRegistry::get('Countries');
                $shippaddrtable = TableRegistry::get('Shippingaddresses');
                $shipingstable = TableRegistry::get('Shipings');
                $subject_data = $sitequeriestable->find()->where(['type' => 'Dispute_Problem'])->first();
                $this->set('subject_data', $subject_data);

                if (count($_POST) > 0) {
                    $orderid = $_POST['data']['Dispute']['orderid'];
                    $or = $orderid;
                    $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                    $merchantid = $orderModel['merchant_id'];
                    $resol = $orderModel['status'];
                    $total = $orderModel['totalcost'];
                    $ordate = $orderModel['orderdate'];
                    $userModel = $userstable->find()->where(['id' => $userid])->first();
                    $merchantModel = $userstable->find()->where(['id' => $merchantid])->first();
                    $userEmail = $userModel['email'];
                    $merEmail = $merchantModel['email'];
                    $buyName = $userModel['first_name'];

                    $userName = $userModel['first_name'] . ' ' . $userModel['last_name'];
                    $merName = $merchantModel['first_name'] . ' ' . $merchantModel['last_name'];
                    $merurlname = $userModel['username_url'];
                    $orderlist = $orderitemstable->find()->where(['orderid' => $orderid])->first();
                    $oname = $orderlist['itemname'];
                    $buyer_url = $userModel['username_url'];
                    $seller_url = $merchantModel['username_url'];
                    $disputedatas = $disputestable->newEntity();
                    $disputedatas->userid = $userid;
                    $uids = $disputedatas->userid = $userid;
                    $sids = $disputedatas->selid = $merchantid;
                    $or = $disputedatas->uorderid = $orderid;
                    $una = $disputedatas->uname = $userName;
                    $uema = $disputedatas->uemail = $userEmail;
                    $sna = $disputedatas->sname = $merName;
                    $sema = $disputedatas->semail = $merEmail;
                    $plm = $disputedatas->uorderplm = $_POST['data']['Dispute']['plm'];
                    $msg = $disputedatas->uordermsg = $_POST['data']['Dispute']['msg'];
                    $ms = $disputedatas->chatdate = time();

                    $col = $_POST['data']['Dispute']['itemdetail'];

                    $ful = json_encode($col);
                    $diin = $_POST['data']['Dispute']['itemdetail'] = $ful;
                    $itenmaedet = json_decode($diin, true);
                    $i = 0;
                    foreach ($itenmaedet as $key => $tiemamou) {
                        $userModel = $itemstable->find()->where(['id' => $tiemamou])->first();
                        $ipr[] = $userModel['price'];
                        $orderitemdetails = $orderitemstable->find()->where(['itemid' => $tiemamou])->where(['orderid' => $orderid])->first();
                        $pr = $orderitemdetails['itemunitprice'];
                        $qu = $orderitemdetails['itemquantity']; //echo "tot";
                        $tot = $orderitemdetails['itemunitprice'] * $orderitemdetails['itemquantity'];
                        $sipp = $orderitemdetails['shippingprice'];
                        $si += $sipp;
                        $quanpri += $tot;
                        $orderitemdetails['shippingprice'];
                        $amo = $si + $quanpri;
                        $useraddr = $orderstable->find()->where(['orderid' => $orderid])->first();
                        $addrs = $useraddr['shippingaddress'];

                        $address = $shippaddrtable->find()->where(['shippingid' => $addrs])->first();
                        $cou = $address['country'];

                        $coun = $countriestable->find()->where(['country' => $cou])->first();
                        $cou = $coun['id'];

                        $shipprice = $shipingstable->find()->where(['item_id' => $tiemamou])->where(['country_id' => $cou])->all();
                        foreach ($shipprice as $ship) {
                            $shipri = $ship['primary_cost'];
                            $sprice += $shipri;
                        }
                    }
                    $toshippedprice = $quanpri + $sprice;
                    $disputedatas->money = $merurlname;
                    if ($_POST['data']['Dispute']['types'] == 'Order') {
                        $disputedatas->totprice = $total;
                    } else {
                        $orname = $disputedatas->totprice = $amo;
                    }
                    $nefirst = "Initialized";
                    $newstatus = $disputedatas->newstatus = $nefirst;
                    $disputedatas->newstatusup = $nefirst;
                    if ($oname == '') {
                        $disputedatas->uorderstatus = "";
                    } else {
                        $orname = $disputedatas->uorderstatus = $oname;
                    }
                    if ($ful == 'null') {
                        $disputedatas->uorderstatus = "null";

                    } else {
                        $disputedatas->uorderstatus = $ful;
                    }
                    if ($ful == 'null') {
                        $disputedatas->orderitem = 'Order';
                        $disputedatas->totprice = $total;
                    } else {
                        $disputedatas->orderitem = 'Item';
                        $orname = $disputedatas->totprice = $amo;
                    }


                    $oda = $disputedatas->orderdatedisp = $ordate;
                    $neia = 'Buyer';
                    $cre = $neia;
                    $resolved = 'Pending';
                    $cre = $disputedatas->resolvestatus = $resol;

                    $disputeresult = $disputestable->save($disputedatas);
                    $dis = $disputeresult->disid;

                    $disputequery = $disputestable->query();
                    $disputequery->update()
                    ->set(['created' => 'Buyer'])
                    ->where(['disid' => $dis])
                    ->execute();


                    $dispconsdatas = $dispconstable->newEntity();
                    $cuids = $dispconsdatas->user_id = $userid;
                    $gli = $dispconsdatas->dispid = $dis;
                    $gor = $dispconsdatas->order_id = $or;
                    $gms = $dispconsdatas->message = $msg;
                    $merid = $dispconsdatas->msid = $sids;
                    $da = $dispconsdatas->date = time();
                    $nei = "Buyer";
                    $cre = $dispconsdatas->commented_by = $nei;


                    $dispconsdatas->itemdetail = $diin;
                    $nefirst = "Initialized";
                    $newstatus = $dispconsdatas->newdispstatus = $nefirst;
                    $dispconstable->save($dispconsdatas);


                    $userModel = $userstable->find()->where(['id' => $loguser['id']])->first();
                    $logusername = $userModel['username'];
                    $logfirstname = $userModel['first_name'];
                    $logusernameurl = $userModel['username_url'];
                    $usrImg = $userModel['profile_image'];
                    if (empty($usrImg))
                        $usrImg = "usrimg.jpg";
                    $image['user']['image'] = $usrImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                    $disputelink = "<a href='" . SITE_URL . "merchant/disputeBuyer/" . $or . "'>" . $or . "</a>";
                    $notifymsg = $loguserlink . " -___-created a dispute on your order : -___-" . $disputelink;
                    $logdetails = $this->addlog('dispute', $userid, $merchantid, $dis, $notifymsg, $gms, $loguserimage);

                        //push notification message

                    $this->loadModel('Userdevices');
                    $logusername = $userName;
                    $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $merchantid)));
                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge += 1;
                        $this->Userdevices->updateAll(array('badge' => "'$badge'"), array('deviceToken' => $deviceTToken));
                        if (isset($deviceTToken)) {
                            $messages = $logusername . " created a dispute on your order " . $gor;
                        }
                    }



                    if ($setngs[0]['Sitesetting']['gmail_smtp'] == 'enable') {
                        $this->Email->smtpOptions = array(
                            'port' => $setngs[0]['Sitesetting']['smtp_port'],
                            'timeout' => '30',
                            'host' => 'ssl://smtp.gmail.com',
                            'username' => $setngs[0]['Sitesetting']['noreply_email'],
                            'password' => $setngs[0]['Sitesetting']['noreply_password']
                        );

                        $this->Email->delivery = 'smtp';
                    }
                    $this->Email->to = $merEmail;
                    $this->Email->subject = $setngs[0]['Sitesetting']['site_name'] . " – Dispute initiated on your order #" . $gor;
                    $this->Email->from = SITE_NAME . "<" . $setngs[0]['Sitesetting']['noreply_email'] . ">";
                    $this->Email->sendAs = "html";
                    $this->Email->template = 'dispute';
                    $this->set('UserId', $userid);
                    $this->set('merName', $merName);
                    $this->set('buyName', $buyName);
                    $this->set('OrderId', $or);
                    $this->set('Problem', $plm);
                    $this->set('Message', $ms);
                    $this->set('setngs', $setngs);
                    $this->set('gli', $gli);
                    $this->set('buyer_url', $buyer_url);
                    $this->set('seller_url', $seller_url);
                    $emailid = base64_encode($merEmail);

                    $sitesettingstable = TableRegistry::get('Sitesettings');
                    $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                    $email = $merEmail;
                    $aSubject = $setngs['site_name'] . " – " . __d('user', 'Dispute initiated on your order') . " #" . $gor;
                    $aBody = '';
                    $template = 'dispute';
                    $setdata = array('UserId' => $userid, 'merName' => $merName, 'buyName' => $buyName, 'OrderId' => $or, 'Problem' => $plm, 'Message' => $ms, 'setngs' => $setngs, 'gli' => $gli, 'buyer_url' => $buyer_url, 'seller_url' => $seller_url);
                    $this->sendmail($email, $aSubject, $aBody, $template, $setdata);


                    if ($setngs[0]['Sitesetting']['gmail_smtp'] == 'enable') {
                        $this->Email->smtpOptions = array(
                            'port' => $setngs[0]['Sitesetting']['smtp_port'],
                            'timeout' => '30',
                            'host' => 'ssl://smtp.gmail.com',
                            'username' => $setngs[0]['Sitesetting']['noreply_email'],
                            'password' => $setngs[0]['Sitesetting']['noreply_password']
                        );

                        $this->Email->delivery = 'smtp';
                    }
                    $this->Email->to = $userEmail;
                    $this->Email->subject = $setngs[0]['Sitesetting']['site_name'] . " – Dispute initiated for your order #" . $gor;
                    $this->Email->from = SITE_NAME . "<" . $setngs[0]['Sitesetting']['noreply_email'] . ">";;
                    $this->Email->sendAs = "html";
                    $this->Email->template = 'buyerdispute';
                    $this->set('UserId', $userid);
                    $this->set('OrderId', $or);
                    $this->set('Problem', $plm);
                    $this->set('Message', $ms);
                    $this->set('setngs', $setngs);
                    $this->set('merName', $merName);
                    $this->set('buyName', $buyName);
                    $this->set('buyer_url', $buyer_url);
                    $this->set('seller_url', $seller_url);
                    $this->set('gli', $gli);
                    $emailid = base64_encode($userEmail);
                    $email1 = $userEmail;
                    $aSubject1 = $setngs['site_name'] . " – " . __d('user', 'Dispute initiated for your order') . " #" . $gor;
                    $aBody1 = '';
                    $template1 = 'buyerdispute';
                    $setdata1 = array('UserId' => $userid, 'merName' => $merName, 'buyName' => $buyName, 'OrderId' => $or, 'Problem' => $plm, 'Message' => $ms, 'setngs' => $setngs, 'gli' => $gli, 'buyer_url' => $buyer_url, 'seller_url' => $seller_url, 'gli' => $gli);
                    $this->sendmail($email1, $aSubject1, $aBody1, $template1, $setdata1);

                    $this->Flash->success(__d('user', 'Dispute Created'));
                    $this->redirect(SITE_URL . 'dispute/' . $loguser['username_url'] . '?buyer');
                }


            }


            function searchmsg()
            {
                if (!$this->isauthenticated())
                    $this->redirect('/');

                global $setngs;
                global $loguser;
                $this->autoRender = false;
                $userid = $loguser['id'];
                $this->loadModel('Contactsellers');
                $this->loadModel('Contactsellermsgs');
                $this->loadModel('Users');
                $searchKey = $_POST['searchkey'];
                $userstable = TableRegistry::get('Users');

                $contactsellerModels = $this->Contactsellers->find('all', array(
                    'fields' => array('id'),
                    'conditions' => array('OR' => array(array('merchantid' => $userid), array('buyerid' =>
                        $userid))), 'order' => 'lastmodified DESC'
                ));
                foreach ($contactsellerModels as $contactseller) {
                    $searchId[] = $contactseller['id'];
                }
                $contactsellerstable = TableRegistry::get('Contactsellers');
                $query = $contactsellerstable->query();
                $contactsellerModel = $query->find('all')
                ->where(['id IN' => $searchId])
                ->where(['OR' => [
                    'subject LIKE' => $searchKey . '%',
                    'itemname LIKE' => $searchKey . "%",
                    'buyername LIKE' => $searchKey . "%",
                    'sellername LIKE' => $searchKey . "%"
                ]])
                ->order(['lastmodified DESC'])->limit('10')->all();

                $messageModel = array();
                $messageUnread = array();
                foreach ($contactsellerModel as $cskey => $contactseller) {
                    $csId = $contactseller['id'];
                    $sellerId = $contactseller['merchantid'];
                    $buyerId = $contactseller['buyerid'];
                    $sellerModel = $userstable->find()->where(['id' => $sellerId])->first();
                    $buyerModel = $userstable->find()->where(['id' => $buyerId])->first();

                    $messageModel[$cskey]['csid'] = $csId;
                    $messageModel[$cskey]['subject'] = $contactseller['subject'];
                    $messageModel[$cskey]['item'] = $contactseller['itemname'];
                    $messageModel[$cskey]['itemurl'] = $contactseller['itemname'];
                    $messageModel[$cskey]['itemid'] = $contactseller['itemid'];
                    if ($contactseller['lastsent'] == 'buyer') {
                        $messageModel[$cskey]['from'] = $buyerModel['first_name'];
                        $messageModel[$cskey]['profile_image'] = $buyerModel['profile_image'];
                        $messageModel[$cskey]['to'] = $sellerModel['first_name'];
                    } else {
                        $messageModel[$cskey]['from'] = $sellerModel['first_name'];
                        $messageModel[$cskey]['profile_image'] = $buyerModel['profile_image'];
                        $messageModel[$cskey]['to'] = $buyerModel['first_name'];
                    }

                    if ($buyerId == $userid && $contactseller['buyerread'] == '1') {
                        $messageModel[$cskey]['unread'] = 1;
                        $messageUnread[] = $cskey;
                    } elseif ($contactseller['sellerread'] == '1' && $sellerId == $userid) {
                        $messageModel[$cskey]['unread'] = 1;
                        $messageUnread[] = $cskey;
                    } else {
                        $messageModel[$cskey]['unread'] = 0;
                    }
                }
                $offset = 0;
                $this->set('offset', $offset);
                $this->set('messageModel', $messageModel);
                $this->set('messageUnread', $messageUnread);
                $this->render('getmoremessage');
            }

            function messages()
            {
                if (!$this->isauthenticated())
                    $this->redirect('/');

                global $loguser;
                $userid = $loguser['id'];

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);


                $contactsellerstable = TableRegistry::get('Contactsellers');
                $contactsellermsgstable = TableRegistry::get('Contactsellermsgs');
                $userstable = TableRegistry::get('Users');
                $itemstable = TableRegistry::get('Items');

                $oldordersModel = $itemstable->find('all')->where(['Items.user_id' => $userid])->all();
                $oldordercount = count($oldordersModel);
                $this->set('oldordercount', $oldordercount);

                $contactsellerModel = $contactsellerstable->find('all')
                ->where(['OR' => [
                    'merchantid' => $userid,
                    'buyerid' => $userid
                ]])
                ->order(['lastmodified DESC'])->limit('10')->all();
                $messageModel = array();
                $messageUnread = array();
                foreach ($contactsellerModel as $cskey => $contactseller) {
                    $csId = $contactseller['id'];
                    $sellerId = $contactseller['merchantid'];
                    $buyerId = $contactseller['buyerid'];
                    $sellerModel = $userstable->get($sellerId);
                    $buyerModel = $userstable->get($buyerId);

                    $messageModel[$cskey]['csid'] = $csId;
                    $messageModel[$cskey]['subject'] = $contactseller['subject'];
                    $messageModel[$cskey]['item'] = $contactseller['itemname'];
                    $messageModel[$cskey]['itemurl'] = $contactseller['itemname'];
                    $messageModel[$cskey]['itemid'] = $contactseller['itemid'];
                    if ($contactseller['lastsent'] == 'buyer') {
                        $messageModel[$cskey]['from'] = $buyerModel['first_name'];
                        $messageModel[$cskey]['profile_image'] = $buyerModel['profile_image'];
                        $messageModel[$cskey]['to'] = $sellerModel['first_name'];
                    } else {
                        $messageModel[$cskey]['from'] = $sellerModel['first_name'];
                        $messageModel[$cskey]['profile_image'] = $buyerModel['profile_image'];
                        $messageModel[$cskey]['to'] = $buyerModel['first_name'];
                    }

                    if ($buyerId == $userid && $contactseller['buyerread'] == '1') {
                        $messageModel[$cskey]['unread'] = 1;
                        $messageUnread[] = $cskey;
                    } elseif ($contactseller['sellerread'] == '1' && $sellerId == $userid) {
                        $messageModel[$cskey]['unread'] = 1;
                        $messageUnread[] = $cskey;
                    } else {
                        $messageModel[$cskey]['unread'] = 0;
                    }
                }
                $count = count($messageModel);

                $this->set('messageModel', $messageModel);
                $this->set('messageUnread', $messageUnread);
                $this->set('counts', $count);
            }

            function getmoremessage()
            {
                global $loguser;
                $userid = $loguser['id'];
                $offset = ($_POST['offset'] / 10) + 1;
                $searchKey = $_POST['searchkey'];
                $contactsellerstable = TableRegistry::get('Contactsellers');
                $contactsellermsgstable = TableRegistry::get('Contactsellermsgs');
                $userstable = TableRegistry::get('Users');
                $itemstabele = TableRegistry::get('Items');

                if ($searchKey == '') {
                    $contactsellerModel = $contactsellerstable->find('all')
                    ->where(['OR' => [
                        'merchantid' => $userid,
                        'buyerid' => $userid
                    ]])
                    ->order(['lastmodified DESC'])->limit('10')->page($offset)->all();
                } else {
                    $contactsellerModel = $contactsellerstable->find('all')
                    ->where(['OR' => [
                        'merchantid' => $userid,
                        'buyerid' => $userid
                    ]])
                    ->where(['OR' => [
                        'subject LIKE' => $searchkey . '%',
                        'itemname LIKE' => $searchKey . "%",
                        'buyername LIKE' => $searchKey . "%",
                        'sellername LIKE' => $searchKey . "%"
                    ]])
                    ->order(['lastmodified DESC'])->limit('10')->page($offset)->all();
                }

                $messageModel = array();
                $messageUnread = array();
                foreach ($contactsellerModel as $cskey => $contactseller) {
                    $csId = $contactseller['id'];
                    $sellerId = $contactseller['merchantid'];
                    $buyerId = $contactseller['buyerid'];
                    $sellerModel = $userstable->get($sellerId);
                    $buyerModel = $userstable->get($buyerId);

                    $messageModel[$cskey]['csid'] = $csId;
                    $messageModel[$cskey]['subject'] = $contactseller['subject'];
                    $messageModel[$cskey]['item'] = $contactseller['itemname'];
                    $messageModel[$cskey]['itemurl'] = $contactseller['itemname'];
                    $messageModel[$cskey]['itemid'] = $contactseller['itemid'];
                    if ($contactseller['lastsent'] == 'buyer') {
                        $messageModel[$cskey]['from'] = $buyerModel['first_name'];
                        $messageModel[$cskey]['profile_image'] = $buyerModel['profile_image'];
                        $messageModel[$cskey]['to'] = $sellerModel['first_name'];
                    } else {
                        $messageModel[$cskey]['from'] = $sellerModel['first_name'];
                        $messageModel[$cskey]['profile_image'] = $buyerModel['profile_image'];
                        $messageModel[$cskey]['to'] = $buyerModel['first_name'];
                    }

                    if ($buyerId == $userid && $contactseller['buyerread'] == '1') {
                        $messageModel[$cskey]['unread'] = 1;
                        $messageUnread[] = $cskey;
                    } elseif ($contactseller['sellerread'] == '1' && $sellerId == $userid) {
                        $messageModel[$cskey]['unread'] = 1;
                        $messageUnread[] = $cskey;
                    } else {
                        $messageModel[$cskey]['unread'] = 0;
                    }
                }
                $this->set('offset', $offset);
                $this->set('messageModel', $messageModel);
                $this->set('messageUnread', $messageUnread);
            }

            function viewmessage($id)
            {
                if (!$this->isauthenticated())
                    $this->redirect('/');

                global $loguser;
                $userid = $loguser['id'];

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);

                $contactsellerstable = TableRegistry::get('Contactsellers');
                $contactsellermsgstable = TableRegistry::get('Contactsellermsgs');
                $userstable = TableRegistry::get('Users');
                $itemstabele = TableRegistry::get('Items');

                $contactsellerModel = $contactsellerstable->get($id);
                if (empty($contactsellerModel)) {
                    $this->Flash->error(__d('user', 'No Conversation Found'));
                    $this->redirect('/messages/');
                }

                if ($userid != $contactsellerModel['merchantid'] && $userid != $contactsellerModel['buyerid']) {
                    $this->Flash->error(__d('user', 'Sorry ! No such record was Found'));
                    $this->redirect('/');
                }

                $csmessageModel = $contactsellermsgstable->find('all')->where(['contactsellerid' => $id])->order(['id ASC'])->all();
                $contactseller_model = $contactsellerstable->get($id);

                if ($contactsellerModel['buyerid'] == $userid) {
                    $buyerModel = $userstable->get($contactsellerModel['merchantid']);
                    $merchantModel = $userstable->get($contactsellerModel['buyerid']);
                    $currentUser = "buyer";
                    if ($contactsellerModel['buyerread'] == 1) {
                        $_SESSION['userMessageCount'] = $_SESSION['userMessageCount'] - 1;
                    }

                    $contactseller_model->buyerread = 0;
                } else {
                    $buyerModel = $userstable->get($contactsellerModel['buyerid']);
                    $merchantModel = $userstable->get($contactsellerModel['merchantid']);
                    $currentUser = "seller";
                    if ($contactsellerModel['sellerread'] == 1) {
                        $_SESSION['userMessageCount'] = $_SESSION['userMessageCount'] - 1;
                    }

                    $contactseller_model->sellerread = 0;
                }
                $contactsellerstable->save($contactseller_model);

                $itemDetails['item'] = $contactsellerModel['itemname'];
                $itemDetails['itemurl'] = $contactsellerModel['itemname'];
                $itemDetails['itemid'] = $contactsellerModel['itemid'];

                $this->set('roundProf', $siteChanges['profile_image_view']);
                $this->set('contactsellerModel', $contactsellerModel);
                $this->set('csmessageModel', $csmessageModel);
                $this->set('buyerModel', $buyerModel);
                $this->set('merchantModel', $merchantModel);
                $this->set('itemDetails', $itemDetails);
                $this->set('currentUser', $currentUser);
            }

            function getmoreviewmessage()
            {
                global $loguser;
                $userid = $loguser['id'];
                $contactsellerstable = TableRegistry::get('Contactsellers');
                $contactsellermsgstable = TableRegistry::get('Contactsellermsgs');
                $userstable = TableRegistry::get('Users');
                $itemstabele = TableRegistry::get('Items');

                $offset = ($_POST['offset'] / 5) + 1;
                $currentUser = $_POST['contact'];
                $csid = $_POST['csid'];

                $contactsellerModel = $contactsellerstable->get($csid);
                $csmessageModel = $contactsellermsgstable->find('all')->where(['contactsellerid' => $csid])->order(['id ASC'])->page($offset)->all();;
                if ($contactsellerModel['buyerid'] == $userid) {
                    $buyerModel = $userstable->get($contactsellerModel['merchantid']);
                    $merchantModel = $userstable->get($contactsellerModel['buyerid']);
                } else {
                    $buyerModel = $userstable->get($contactsellerModel['buyerid']);
                    $merchantModel = $userstable->get($contactsellerModel['merchantid']);
                }

                $this->set('roundProf', $siteChanges['profile_image_view']);
                $this->set('contactsellerModel', $contactsellerModel);
                $this->set('csmessageModel', $csmessageModel);
                $this->set('buyerModel', $buyerModel);
                $this->set('merchantModel', $merchantModel);
                $this->set('currentUser', $currentUser);
            }

            function replymessage()
            {
                $this->autoRender = false;
                $contactsellerstable = TableRegistry::get('Contactsellers');
                $contactsellermsgstable = TableRegistry::get('Contactsellermsgs');
                $userstable = TableRegistry::get('Users');
                $itemstabele = TableRegistry::get('Items');
                global $loguser;

                $csId = $_POST['csid'];
                $merchantId = $_POST['merchantId'];
                $buyerId = $_POST['buyerId'];
                $sender = $_POST['sender'];
                $message = $_POST['message'];
                $username = $_POST['username'];
                $usrurl = $_POST['usrurl'];
                $usrimg = $_POST['usrimg'];
                if ($usrimg == "")
                    $usrimg = "usrimg.jpg";
                $roundProfile = $_POST['roundprofile'];
                $timenow = time();

                $contactseller = $contactsellerstable->get($csId);

                $contactseller->lastsent = $sender;
                if ($sender == 'buyer') {
                    $contactseller->sellerread = 1;
                } else {
                    $contactseller->buyerread = 1;
                }
                $contactseller->lastmodified = time();
                $contactsellerstable->save($contactseller);

                $contactsellermsg = $contactsellermsgstable->newEntity();
                $contactsellermsg->contactsellerid = $csId;
                $contactsellermsg->message = $message;
                $contactsellermsg->sentby = $sender;
                $contactsellermsg->createdat = $timenow;
                $contactsellermsgstable->save($contactsellermsg);


                echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top20 padding-bottom20 hor-padding negotian-by-info clearfix">
                <div class="negotaio-image">
                <div class="messag-img">
                <div class="clint-img admin-img" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $usrimg . ');background-repeat:no-repeat;"></div>
                </div>
                </div>
                <div class="negotation-details margin-both15">
                <div class="bold-font margin-top0 margin-bottom10 ">' . $username . '</div>
                <p class="font-color">' . date('d,M Y', $timenow) . '</p>
                <p class="font-color foldtxt">' . $message . '</p>
                </div>
                </div>';


                $email_address = $userstable->get($buyerId);
                $emailaddress = $email_address['email'];
                $name = $email_address['first_name'];
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                $email = $emailaddress;
                $aSubject = $setngs['site_name'] . " – " . __d('user', 'You have got a message');
                $aBody = '';
                $template = 'contactseller';
                $setdata = array('name' => $name, 'email' => $emailaddress, 'username' => $username, 'message' => $message, 'access_url' => SITE_URL . 'login', 'setngs' => $setngs, 'sender' => $sender);
                $this->sendmail($email, $aSubject, $aBody, $template, $setdata);

                if ($setngs['gmail_smtp'] == 'enable') {
                    $this->Email->smtpOptions = array(
                        'port' => $setngs['smtp_port'],
                        'timeout' => '30',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => $setngs['noreply_email'],
                        'password' => $setngs['noreply_password']
                    );

                    $this->Email->delivery = 'smtp';
                }
                $this->Email->to = $emailaddress;
                $this->Email->subject = $setngs['site_name'] . " – You have got a message";
                $this->Email->from = SITE_NAME . "<" . $setngs['noreply_email'] . ">";
                $this->Email->sendAs = "html";
                $this->Email->template = 'contactseller';
                $this->set('name', $name);
                $this->set('urlname', $urlname);
                $this->set('email', $emailaddress);
                $username = $loguser['first_name'];
                $this->set('username', $username);
                $this->set('sender', $sender);
                $this->set('message', $message);
                $this->set('access_url', SITE_URL . "login");

            }

            function sendmessage()
            {
                $this->autoLayout = false;
                $this->autoRender = false;
                $this->loadModel('User');
                $this->loadModel('Contactseller');
                $this->loadModel('Contactsellermsg');
                $this->loadModel('Photo');

                global $setngs;
                global $loguser;
                $itemId = $_POST['itemId'];
                $merchantId = $_POST['merchantId'];
                $buyerId = $_POST['buyerId'];
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                $itemName = $_POST['itemName'];
                $username = $_POST['username'];
                $sellername = $_POST['sellername'];
                $sender = $_POST['sender'];
                $timenow = time();

                $this->request->data['Contactseller']['itemid'] = $itemId;
                $this->request->data['Contactseller']['merchantid'] = $merchantId;
                $this->request->data['Contactseller']['buyerid'] = $buyerId;
                $this->request->data['Contactseller']['subject'] = $subject;
                $this->request->data['Contactseller']['itemname'] = $itemName;
                $this->request->data['Contactseller']['buyername'] = $username;
                $this->request->data['Contactseller']['sellername'] = $sellername;
                $this->request->data['Contactseller']['lastsent'] = $sender;
                if ($sender == 'buyer') {
                    $this->request->data['Contactseller']['sellerread'] = 1;
                    $this->request->data['Contactseller']['buyerread'] = 0;
                } else {
                    $this->request->data['Contactseller']['sellerread'] = 0;
                    $this->request->data['Contactseller']['buyerread'] = 1;
                }
                $this->request->data['Contactseller']['lastmodified'] = $timenow;
                $this->Contactseller->save($this->request->data);

                $lastInserId = $this->Contactseller->getLastInsertID();

                $this->request->data['Contactsellermsg']['contactsellerid'] = $lastInserId;
                $this->request->data['Contactsellermsg']['message'] = $message;
                $this->request->data['Contactsellermsg']['sentby'] = $sender;
                $this->request->data['Contactsellermsg']['createdat'] = $timenow;
                $this->Contactsellermsg->save($this->request->data);

                $photostable = TableRegistry::get('Photos');
                $itemImage = $photostable->find()->where(['item_id' => $itemId])->first();
                $logusername = $loguser['username'];
                $logfirstname = $loguser['first_name'];
                $logusernameurl = $loguser['username_url'];
                $itemname = $itemName;
                $itemurl = base64_encode($itemId . "_" . rand(1, 9999));
                $userImg = $loguser['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $image['item']['image'] = $itemImage['image_name'];
                $image['item']['link'] = SITE_URL . "listing/" . $itemurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                $productlink = "<a href='" . SITE_URL . "listing/" . $itemurl . "'>" . $itemname . "</a>";
                $notifymsg = $loguserlink . " -___-sent a query on your product: -___- " . $productlink;
                $logdetails = $this->addlog('chatmessage', $buyerId, $merchantId, $lastInserId, $notifymsg, $message, $loguserimage, $itemId);


                $result[] = 'success';
                $result[] = '<a href="' . SITE_URL . 'viewmessage/' . $lastInserId . '"><i class="glyphicons comments"></i>Contact Seller</a>';

                echo json_encode($result);

                $userstable = TableRegistry::get('Items');
                $email_address = $userstable->find()->where(['id' => $merchantId])->first();
                $emailaddress = $email_address['email'];
                $name = $email_address['first_name'];
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();


                if ($setngs[0]['Sitesetting']['gmail_smtp'] == 'enable') {
                    $this->Email->smtpOptions = array(
                        'port' => $setngs[0]['Sitesetting']['smtp_port'],
                        'timeout' => '30',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => $setngs[0]['Sitesetting']['noreply_email'],
                        'password' => $setngs[0]['Sitesetting']['noreply_password']
                    );

                    $this->Email->delivery = 'smtp';
                }
                $this->Email->to = $emailaddress;
                $this->Email->subject = $setngs[0]['Sitesetting']['site_name'] . " – You have got a message";
                $this->Email->from = SITE_NAME . "<" . $setngs[0]['Sitesetting']['noreply_email'] . ">";
                $this->Email->sendAs = "html";
                $this->Email->template = 'contactseller';
                $this->set('name', $name);
                $this->set('urlname', $urlname);
                $this->set('email', $emailaddress);
                $this->set('username', $username);
                $this->set('message', $message);
                $this->set('access_url', SITE_URL . "login");

                $this->Email->send();


            }

            public function purchaseditem()
            {
                global $loguser;
                $userid = $loguser['id'];
                $this->set('loguser', $loguser);

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);

                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }
                $itemModel = array();

                $orderstable = TableRegistry::get('Orders');
                $orderitemstable = TableRegistry::get('OrderItems');
                $itemstable = TableRegistry::get('Items');
                $forexratestable = TableRegistry::get('Forexrates');
                $disputestable = TableRegistry::get('Disputes');
                $invoicestable = TableRegistry::get('Invoices');
                $invoiceorderstable = TableRegistry::get('Invoiceorders');
                $trackingdetailstable = TableRegistry::get('Trackingdetails');
                $userstable = TableRegistry::get('Users');
                $forexrateModel = $forexratestable->find('all');
                $currencySymbol = array();
                foreach ($forexrateModel as $forexrate) {
                    $cCode = $forexrate['currency_code'];
                    $cSymbol = $forexrate['currency_symbol'];
                    $currencySymbol[$cCode] = $cSymbol;
                }

                $ordersModel = $orderstable->find('all')->where(['userid' => $userid])->order(['orderid DESC'])->all();
                $orderid = array();
                foreach ($ordersModel as $value) {
                    $orderid[] = $value['orderid'];
                }
                if (count($orderid) > 0)
                    $userordersModel = $disputestable->find('all')->where(['uorderid IN' => $orderid])->all();
                else
                    $userordersModel = "";
                $userorderid = array();
                foreach ($userordersModel as $value) {
                    $userorderid[] = $value['orderid'];
                }
                if (count($orderid) > 0)
                    $disp_data = $disputestable->find('all')->where(['uorderid IN' => $orderid])->all();
                else
                    $disp_data = "";

                $this->set('disp_data', $disp_data);
                foreach ($disp_data as $key => $temp) {
                    $disid = $temp['disid'];
                    $uid = $temp['userid'];
                    $uoid = $temp['uorderid'];

                }
                $short_list_array = explode(',', $uoid);
                $shortlist = $disputestable->find('all')->where(['Disputes.uorderid IN' => $short_list_array])->all();


                $this->set('shortlist', $shortlist);
                $this->set('short_list_array', $short_list_array);

                if (count($orderid) > 0) {
                    $orderitemModel = $orderitemstable->find('all')->where(['orderid IN' => $orderid])->all();
                    //$itemreviewTable = TableRegistry::get('Itemreviews');
                    $itemid = array();
                    
                    foreach ($orderitemModel as $value) {

                        



                        $orid = $value['orderid'];
                        $item_id = $value['itemid'];
                        $itm_detail = $itemstable->find('all')->contain('Photos')->where(['id' => $item_id])->first();
                        if (!isset($oritmkey[$orid])) {
                            $oritmkey[$orid] = 0;
                        }
                        $item_image = $itm_detail['photos'][0]['image_name'];
                        if ($item_image == "")
                            $item_image = "usrimg.jpg";
                        $checkimgage = WWW_ROOT . 'media/items/thumb350/' . $item_image;
                        if (file_exists($checkimgage))
                            $item_image = SITE_URL . 'media/items/thumb350/' . $itm_detail['photos'][0]['image_name'];
                        else
                            $item_image = SITE_URL . 'media/avatars/thumb70/usrimg.jpg';
                        $itemid[] = $value['itemid'];
                        $orderitems[$orid][$oritmkey[$orid]]['businessday'] = $itm_detail['processing_time'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemimage'] = $item_image;
                        $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                        $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                        $orderitems[$orid][$oritmkey[$orid]]['shippingprice'] = $value['shippingprice'];
                        $orderitems[$orid][$oritmkey[$orid]]['discountAmount'] = $value['discountAmount'];
                        $orderitems[$orid][$oritmkey[$orid]]['tax'] = $value['tax'];
                        $oritmkey[$orid]++;
                    }
                }
                $orderDetails = array();
                $itemreviewTable = TableRegistry::get('Itemreviews');

                foreach ($ordersModel as $key => $orders) {

                    $checkReviews = $itemreviewTable->find('all')->where(['orderid' => $orders['orderid']])->first();

                    $orderid = $orders['orderid'];
                    $orderCurny = $orders['currency'];
                    $orderDetails[$key]['orderid'] = $orders['orderid'];
                    $orderDetails[$key]['review_status'] = (!empty($checkReviews)) ? '1' : '0';
                    $orderDetails[$key]['price'] = $orders['totalcost'];
                    $orderDetails[$key]['shipping_price'] = $orders['totalCostshipp'];
                    $orderDetails[$key]['saledate'] = $orders['orderdate'];
                    $orderDetails[$key]['status'] = $orders['status'];
                    $orderDetails[$key]['deliverytype'] = $orders['deliverytype'];
                    $orderDetails[$key]['deliver_update'] = $orders['deliver_update'];

                    $sellerdetail = $userstable->find('all')->where(['Users.id' => $orders['merchant_id']])->first();
                    $orderDetails[$key]['sellername'] = $sellerdetail['first_name'];

                    $ordercommentstable = TableRegistry::get('Ordercomments');
                    $ordercomments = $ordercommentstable->find('all')->where(['Ordercomments.orderid' => $orderid])->all();
                    $orderDetails[$key]['commentcount'] = count($ordercomments);
                    $trackingModel = $trackingdetailstable->find('all')->where(['orderid' => $orderid])->all();
                    $orderDetails[$key]['trackingdetails'] = count($trackingModel);

                    $invoice_orders = $invoiceorderstable->find('all')->where(['Invoiceorders.orderid' => $orderid])->first();
                    $invoiceid = $invoice_orders['invoiceid'];

                    $invoice_datas = $invoicestable->find('all')->where(['invoiceid' => $invoiceid])->first();
                    $orderDetails[$key]['paymentmethod'] = $invoice_datas['paymentmethod'];

                    $itemkey = 0;
                    foreach ($orderitems[$orderid] as $orderkey => $orderitem) {

                        //echo '<pre>'; print_r($orderitem); die;

                        $itemTotal = $orderitems[$orderid][$orderkey]['itemtotal'];
                        
                        $ship = $orderitems[$orderid][$orderkey]['shippingprice'];
                        
                        $discount = $orderitems[$orderid][$orderkey]['discountAmount'];
                        
                        $tax = $orderitems[$orderid][$orderkey]['tax'];

                        $grup_price = $itemTotal+$ship-$discount+$grup_price;
                        //die;
                        //echo '<pre>'; print_r($orderitems[$orderid]); die;
                            //$itemTable = $itemArray[$orderitem];
                        $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                        $orderDetails[$key]['orderitems'][$itemkey]['itemimage'] = $orderitems[$orderid][$orderkey]['itemimage'];
                        $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                        $orderDetails[$key]['orderitems'][$itemkey]['price'] =  $itemTotal;
                        $orderDetails[$key]['orderitems'][$itemkey]['shippingprice'] = $orderitems[$orderid][$orderkey]['shippingprice'];
                        $orderDetails[$key]['orderitems'][$itemkey]['discount_amount'] = $orderitems[$orderid][$orderkey]['discountAmount'];
                        $orderDetails[$key]['orderitems'][$itemkey]['tax'] = $orderitems[$orderid][$orderkey]['tax'];
                        $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                        $orderDetails[$key]['orderitems'][$itemkey]['businessday'] = $orderitems[$orderid][$orderkey]['businessday'];
                        $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                        $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                        $itemkey++;

                    }

                }
                //echo '<pre>'; print_r($orderDetails); die;
                $sitequeriestable = TableRegistry::get('Sitequeries');
                $subject_data = $sitequeriestable->find()->where(['type' => 'Dispute_Problem'])->first();
                $this->set('subject_data', $subject_data);
                $this->set('orderDetails', $orderDetails);
                $this->set('nmecounts', $nmecounts);

            }


            function buyerconversation($orderid)
            {
                global $loguser;
                global $siteChanges;
                global $setngs;
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }

                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);

                $this->set('title_for_layout', 'Conversation');
                $this->loadModel('Orders');
                $this->loadModel('Shippingaddresses');
                $this->loadModel('Ordercomments');

                $orderstable = TableRegistry::get('Orders');
                $shipaddresstable = TableRegistry::get('Shippingaddresses');
                $ordercommentstable = TableRegistry::get('Ordercomments');
                $userstable = TableRegistry::get('Users');

                $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                $ordercommentsModel = $ordercommentstable->find()->where(['orderid' => $orderid])->order(['id ASC'])->all();
                $buyerid = $orderModel['userid'];

                if ($loguser['id'] != $buyerid) {
                    $this->Flash->error(__d('user', 'Sorry ! No such record was found'));
                    $this->redirect('/');
                }

                $merchantid = $orderModel['merchant_id'];
                $buyerModel = $userstable->find()->where(['id' => $buyerid])->first();
                $merchantModel = $userstable->find()->where(['id' => $merchantid])->first();
                $sellerName = $merchantModel['first_name'];

                $this->set('orderModel', $orderModel);
                $this->set('buyerModel', $buyerModel);
                $this->set('merchantModel', $merchantModel);
                $this->set('ordercommentsModel', $ordercommentsModel);
                $this->set('sellerName', $sellerName);
            }

            public function buyerorderdetails($orderid)
            {
                global $loguser;
                $userid = $loguser['id'];
                $first_name = $loguser['first_name'];
                $this->set('first_name', $first_name);
                $this->loadModel('Itemreviews');

                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }
                $orderstable = TableRegistry::get('Orders');
                $orderitemstable = TableRegistry::get('OrderItems');
                $itemstable = TableRegistry::get('Items');
                $shipaddresstable = TableRegistry::get('Shippingaddresses');
                $trackingdetailstable = TableRegistry::get('Trackingdetails');
                $photostable = TableRegistry::get('Photos');
                $forexratestable = TableRegistry::get('Forexrates');
                $invoiceorderstable = TableRegistry::get('Invoiceorders');
                $invoicestable = TableRegistry::get('Invoices');
                $userstable = TableRegistry::get('Users');
                $disputestable = TableRegistry::get('Disputes');
                $sitequeriestable = TableRegistry::get('Sitequeries');

                $subject_data = $sitequeriestable->find()->where(['type' => 'Dispute_Problem'])->first();
                $this->set('subject_data', $subject_data);
                $orderModel = $orderstable->find('all')->where(['orderid' => $orderid])->first();
                $invoiceorders = $invoiceorderstable->find('all')->where(['Invoiceorders.orderId' => $orderid])->first();
                $invoiceid = $invoiceorders['invoiceid'];
                $invoices = $invoicestable->find('all')->where(['Invoices.invoiceid' => $invoiceid])->first();
                $paymentmethod = $orderModel['deliverytype'];
                $this->set('paymentmethod', $paymentmethod);

                $disp_data = $disputestable->find('all')->where(['uorderid' => $orderid])->first();
                $this->set('disp_data', $disp_data);

                $merchantid = $orderModel['merchant_id'];
                $userModel = $userstable->get($userid);
                $merchantModel = $userstable->get($merchantid);
                $userEmail = $userModel['email'];
                $shipppingId = $orderModel['shippingaddress'];
                $currencyCode = $orderModel['currency'];
                $shippingModel = $shipaddresstable->find('all')->where(['shippingid' => $shipppingId])->first();
                $trackingModel = $trackingdetailstable->find('all')->where(['orderid' => $orderid])->first();
                $orderitemModel = $orderitemstable->find('all')->where(['orderid' => $orderid])->all();

                $forexrateModel = $forexratestable->find('all')->where(['currency_code' => $currencyCode])->first();
                $currencySymbol = $forexrateModel['currency_symbol'];
                $itemModel = array();
                $estimated_duration = 'days';
                $estimated_delivery_days = 0;
                $delivered_on = 1;

                //echo '<pre>'; print_r($orderitemModel); die;
                foreach ($orderitemModel as $okey => $orderitem) {

                    //print_r($orderitem); die;

                    $itemstable = TableRegistry::get('Items');
                    $itemreviewTable = TableRegistry::get('Itemreviews');

                    $orderResults = $itemreviewTable->find('all')->where(['orderid' => $orderitem->orderid,'itemid'=>$orderitem['itemid']])->first();

                    

                    $reviewArr = array();
                    if(!empty($orderResults))
                    {
                        $reviewArr['rating'] = $orderResults->ratings;
                        $reviewArr['reviews'] = $orderResults->reviews;
                    }
                    
                    $getAvgrat = $this->getAverage($orderitem['itemid']); 

                    $itemModle[$okey]['itemid'] = $orderitem['itemid'];
                    $itemModle[$okey]['review'] = (empty($orderResults)) ? '' : $orderResults->id ;
                    $itemModle[$okey]['review_data'] = $reviewArr;
                    $itemModle[$okey]['avg_rating'] = $getAvgrat;
                    $itemModle[$okey]['itemname'] = $orderitem['itemname'];
                    $itemModle[$okey]['itemsize'] = $orderitem['item_size'];
                    $itemModle[$okey]['itemprice'] = $orderitem['itemprice'];
                    $itemModle[$okey]['itemquantity'] = $orderitem['itemquantity'];
                    $itemModle[$okey]['shippingprice'] = $orderitem['shippingprice'];
                    $itemModle[$okey]['itemunitprice'] = $orderitem['itemunitprice'];
                    $itemModle[$okey]['discountAmount'] = $orderitem['discountAmount'];
                    $itemModle[$okey]['discountType'] = $orderitem['discountType'];
                    $itemModle[$okey]['discountId'] = $orderitem['discountId'];
                    $itemModle[$okey]['tax'] = $orderitem['tax'];
                    if ($orderitem['giftamount'] != '') {
                        $itemModle[$okey]['giftamount'] = $orderitem['giftamount'];
                    }
                    else
                    {
                        $itemModle[$okey]['giftamount'] = 0;
                    }
                    
                    $itemid = $orderitem['itemid'];
                    $itm_detail = $itemstable->find('all')->where(['Items.id' => $itemid])->first();
                    $itemModle[$okey]['businessday'] = $itm_detail['processing_time'];
                    $photoModel = $photostable->find('all')->where(['Photos.item_id' => $itemid])->first();
                    $itemModle[$okey]['itemimage'] = $photoModel['image_name'];
                    $itemurlname = $itemid;
                    $itemid = base64_encode($itemid . "_" . rand(1, 9999));
                    $itemModle[$okey]['itemurl'] = 'listing/' . $itemid;
                    $deliverydetails = $this->Items->find()->where(['id' => $orderitem['itemid']])->first();
                    /* Expected Delivery Date */
                    $businessdays = $deliverydetails['processing_time'];
                    $business = str_split($businessdays);
                    if ($estimated_duration == 'days' && $business[1] == "d") {
                        if ($business[0] > $estimated_delivery_days) {
                            $estimated_delivery_days = $business[0];
                        }
                    } else {
                        $estimated_duration = 'weeks';
                        if ($business[0] > $estimated_delivery_days) {
                            $estimated_delivery_days = $business[0];
                        }
                    }
                    $delivered_on = $estimated_delivery_days;
                }

                $ordered_date = date('Y-m-d', $orderModel['orderdate']);
                if ($estimated_duration == 'days') {
                    $expected_at = date("Y-m-d", strtotime($ordered_date . ' + ' . $delivered_on . ' day'));
                } else {
                    $weekTodays = $delivered_on * 7;
                    $expected_at = date("Y-m-d", strtotime($ordered_date . ' + ' . $weekTodays . ' day'));
                }

                //echo '<pre>'; print_r($orderModel); die;
                
            

                $this->set('ordered_at', $ordered_date);
                $this->set('expected_at', $expected_at);
                $this->set('orderModel', $orderModel);
                $this->set('orderitemModel', $orderitemModel);
                $this->set('userModel', $userModel);
                $this->set('merchantModel', $merchantModel);
                $this->set('shippingModel', $shippingModel);
                $this->set('trackingModel', $trackingModel);
                $this->set('itemModle', $itemModle);
                $this->set('currencyCode', $currencyCode);
                $this->set('currencySymbol', $currencySymbol);
            }


            function additemReviews()
    {

     
        $this->loadModel('Itemreviews');
        
        $userstable = TableRegistry::get('Users');
        $itemstable = TableRegistry::get('Items');
        $itemreviewTable = TableRegistry::get('Itemreviews');
        global $loguser;
        $user_id = $loguser['id'];
       // echo "userid=".$user_id;
       // $user_id = $_POST['user_id'];
        $item_id = $_POST['item_id'];
        $order_id = $_POST['order_id'];
        //$reviewtitle = $_POST['review_title'];
        $reviews = trim($_POST['review']);
        //$reviews = preg_replace("/[\n\r]/","&#13;&#10;",$_POST['review']);
        //$stringWithPs = str_replace("<br /><br />", "</p>\n<p>", $reviews);
        //$reviews = $stringWithPs;
        //$reviews = preg_replace("/[\r\n]/","<p>",$_POST['review']);

        //secho $reviews; die;
        $rating = $_POST['rating'];
       
        $this->loadModel('Items');

        if(isset($_POST['review_id']) && $_POST['review_id'] != '')
        {
               $itemData = $this->Items->find()->where(['id' => $item_id])->first();

            $this->Itemreviews->updateAll(array('reviews' => $reviews,'ratings'=>$rating), array('id' => $_POST['review_id']));

            //Item ratings.
            $getAvg = $this->getAverage($item_id);
           // echo "getAvg".$getAvg['rating'];die;
            //Seller ratings.
            $getsellerAvg = $this->getsellerAverage($itemData->user_id);
            // echo "getsellerAvg".$getsellerAvg;die;
            
            $querys = $itemstable->query();
                    $querys->update()
                    ->set(['avg_rating' => $getAvg])
                    ->where(['id' => $item_id])
                    ->execute();

                    
            $querys = $userstable->query();
                    $querys->update()
                    ->set(['seller_ratings' => $getsellerAvg['rating']])
                    ->where(['id' => $itemData->user_id])
                    ->execute();

           // echo '{"status":"true","message":"Successfully updated."}';
            echo json_encode(array('status'=>'true','message'=>'successfully added')); die;

           
        }



        $itemData = $this->Items->find()->where(['id' => $item_id])->first();

        
        $itemreview = $itemreviewTable->newEntity();
        $itemreview->userid = $user_id;
        $itemreview->itemid = $item_id;
        $itemreview->orderid = $order_id;
        $itemreview->seller_id = $itemData->user_id;
        $itemreview->reviews = $reviews;
        $itemreview->ratings = $rating;
        $result = $itemreviewTable->save($itemreview);

        $getAvg = $this->getAverage($item_id);

        
        $querys = $itemstable->query();
                $querys->update()
                ->set(['avg_rating' => $getAvg])
                ->where(['id' => $item_id])
                ->execute();

        $querys = $userstable->query();
                    $querys->update()
                    ->set(['seller_ratings' => $getsellerAvg['rating']])
                    ->where(['id' => $itemData->user_id])
                    ->execute();
        
        if(isset($result))
        {
            echo json_encode(array('status'=>'true','message'=>'successfully added')); die;
        }else{
            echo json_encode(array('status'=>'false','message'=>'something went wrong')); die;
        }
        
        
    }

    function getsellerAverage($value='')
    {
        $this->loadModel('Itemreviews');
        $itemreviewTable = TableRegistry::get('Itemreviews');
        $reviews = $this->Itemreviews->find('all', array(
                'conditions' => array(
                    'seller_id' => $value
                ),
                'order' => 'id DESC'
            ))->all();
        
        $max = 0;
        $n = count($reviews); // get the count of comments 
        foreach ($reviews as $rate => $count) { // iterate through array

            $max = $max+$count->ratings;
        }
        $Rating = ($n != 0) ? $max / $n : 0;
        return array('reviews'=>$n, 'rating'=>round($Rating,1));
    }



            public function cancelCodOrder()
            {
                //echo 'hi order cancelled'; die;
                $this->autoRender = false;
                global $loguser;
                $orderstable = TableRegistry::get('Orders');
                $orderitemstable = TableRegistry::get('OrderItems');
                $invoicestable = TableRegistry::get('Invoices');
                $invoiceorderstable = TableRegistry::get('Invoiceorders');
                $itemstable = TableRegistry::get('Items');
                $userstable = TableRegistry::get('Users');


                $orderid = $_POST['orderid'];

                $orders = $orderstable->find('all')->where(['orderid' => $orderid])->first();
                $order_status = $orders['status'];

                if ($order_status == "" || $order_status == "Pending" || $order_status == "Processing") {

                    $order_datas = $orderitemstable->find('all')->where(['orderid' => $orderid])->all();

                    foreach ($order_datas as $orderdata) {
                        $itemid = $orderdata['itemid'];
                        $itemsize = $orderdata['item_size'];
                        $itemquantity = $orderdata['itemquantity'];

                        $item_datas = $itemstable->find('all')->where(['Items.id' => $itemid])->first();
                        $size_option = $item_datas['size_options'];
                        $sizes = json_decode($size_option, true);

                        $items = $itemstable->get($itemid);
                        if (!empty($sizes)) {
                            $sizes['unit'][$itemsize] = $sizes['unit'][$itemsize] + $itemquantity;
                            $sizeoptions = json_encode($sizes);
                        }

                        $updated_qnty = $item_datas['quantity'] + $itemquantity;


                        $items->size_options = $sizeoptions;
                        $items->quantity = $updated_qnty;
                        $itemstable->save($items);
                    }



                    $ordersquery = $orderstable->query();
                    $ordersquery->update()
                    ->set(['status' => 'Cancelled'])
                    ->where(['orderid' => $orderid])
                    ->execute();

                    echo "success";

                    $logusernameurl = $loguser['username_url'];
                    $logusername = $loguser['first_name'];
                    $userImg = $loguser['profile_image'];
                    if (empty($userImg)) {
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $loguserimage = json_encode($image);

                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                    $orderidLink = '<a href="' . SITE_URL . 'merchant/cancelledorders/">'.$orderid.'</a>';
                    $logusrid = $orders['userid'];
                    $userid = $orders['merchant_id'];
                    $notifymsg = 'Your order has been cancelled by the buyer-___- ' . $loguserlink .', Order Id : '.$orderidLink;
                    $logdetails = $this->addlog('orderstatus', $logusrid, $userid, $orderid, $notifymsg, null, $loguserimage);

                    $sellerdetail = $userstable->find()->where(['id' => $userid])->first();

                    $sitesettingstable = TableRegistry::get('Sitesettings');
                    $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                    $email = $sellerdetail['email'];
                    $name = $sellerdetail['first_name'];
                    $aSubject = $setngs['site_name'] . ' - ' . __d('user', 'Your order has been cancelled by the buyer');
                    $aBody = '';
                    $template = 'cancelorder';
                    $setdata = array('name' => $name, 'logusername' => $logusername, 'orderid' => $orderid);
                    $this->sendmail($email, $aSubject, $aBody, $template, $setdata);



                    $this->loadModel('Userdevices');
                    $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $userid)));
                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge += 1;
                        $this->Userdevice->updateAll(array('badge' => "'$badge'"), array('deviceToken' => $deviceTToken));
                        if (isset($deviceTToken)) {
                            $messages = 'Your orderid: ' . $orderid . ' has been cancelled';
                        }
                    }

                } else {
                    echo "fail";
                }

            }

            function getrecentcmnt()
            {
                $this->autoLayout = false;
                global $loguser;
                global $siteChanges;
                global $setngs;
                $this->loadModel('Ordercomments');
                $this->loadModel('Orders');
                $currentcont = $_POST['currentcont'];
                $orderid = $_POST['orderid'];
                $contacter = $_POST['contact'];

                $orderstable = TableRegistry::get('Orders');
                $ordercommentstable = TableRegistry::get('Ordercomments');
                $userstable = TableRegistry::get('Users');
                $orderModel = $orderstable->find()->where(['orderId' => $orderid])->first();


                $ordercommentsModel = $this->Ordercomments->find('all', array(
                    'conditions' => array(
                        'orderid' => $orderid
                    ),
                    'limit' => '40',
                    'offset' => $currentcont,
                    'order' => array('Ordercomments.id' => 'ASC'),
                ))->toArray();
                if (!empty($ordercommentsModel)) {
                    $latestcount = $currentcont + count($ordercommentsModel);
                    $buyerid = $orderModel['userid'];
                    $merchantid = $orderModel['merchant_id'];
                    $buyerModel = $userstable->find()->where(['id' => $buyerid])->first();
                    $merchantModel = $userstable->find()->where(['id' => $merchantid])->first();

                    if ($contacter == 'seller') {
                        $this->set('buyerModel', $merchantModel);
                        $this->set('merchantModel', $buyerModel);
                    } else {
                        $this->set('buyerModel', $buyerModel);
                        $this->set('merchantModel', $merchantModel);
                    }
                    $this->set('contacter', $contacter);
                }
                $this->set('ordercommentsModel', $ordercommentsModel);
                $this->set('latestcount', $latestcount);
            }

            function getmorecomment()
            {
                $this->autoLayout = false;
                $this->autoRender = false;
                global $loguser;
                global $siteChanges;
                global $setngs;
                $this->loadModel('Ordercomments');
                $this->loadModel('Orders');
                $userid = $loguser['id'];
                $offset = $_POST['offset'];
                $orderid = $_POST['orderid'];
                $contacter = $_POST['contact'];

                $orderstable = TableRegistry::get('Orders');
                $ordercommentstable = TableRegistry::get('Ordercomments');
                $userstable = TableRegistry::get('Users');

                $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                $ordercommentsModel = $this->Ordercomments->find(
                    'all',
                    array(
                        'conditions' => array('orderid' => $orderid), 'order' => 'id DESC', 'offset' => $offset,
                        'limit' => '5'
                    )
                );

                $ordercommentsModel = $this->Ordercomments->find('all', array(
                    'conditions' => array(
                        'orderid' => $orderid
                    ),
                    'limit' => '5',
                    'offset' => $offset,
                    'order' => 'id DESC',
                ))->toArray();
                if (!empty($ordercommentsModel)) {
                    $latestcount = $currentcont + count($ordercommentsModel);
                    $buyerid = $orderModel['userid'];
                    $merchantid = $orderModel['merchant_id'];
                    $buyerModel = $userstable->find()->where(['id' => $buyerid])->first();
                    $merchantModel = $userstable->find()->where(['id' => $merchantid])->first();

                    if ($contacter == 'seller') {
                        $this->set('buyerModel', $merchantModel);
                        $this->set('merchantModel', $buyerModel);
                    } else {
                        $this->set('buyerModel', $buyerModel);
                        $this->set('merchantModel', $merchantModel);
                    }
                    $this->set('contacter', $contacter);
                }
                $this->set('ordercommentsModel', $ordercommentsModel);
                $this->set('latestcount', '0');
                $this->render('getrecentcmnt');
            }

            function postordercomment()
            {
                $this->autoRender = false;
                global $loguser;
                global $siteChanges;
                global $setngs;


                $this->loadModel('Ordercomments');
                $ordercommentstable = TableRegistry::get('Ordercomments');
                $userstable = TableRegistry::get('Users');
                $userid = $loguser['id'];
                $username = $loguser['username'];
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }

                $ordercomments = $ordercommentstable->newEntity();
                $ordercomments->orderid = $_POST['orderid'];
                $ordercomments->merchantid = $_POST['merchantid'];
                $ordercomments->buyerid = $_POST['buyerid'];
                $ordercomments->comment = $_POST['comment'];
                $ordercomments->createddate = time();
                $ordercomments->commentedby = $_POST['postedby'];
                $ordercommentstable->save($ordercomments);

                $orderid = $_POST['orderid'];
                $logusernameurl = $loguser['username_url'];
                $logusername = $loguser['first_name'];
                $userImg = $loguser['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                if ($_POST['merchantid'] == $userid) {
                    $logusrid = $_POST['merchantid'];
                    $userid = $_POST['buyerid'];
                    $orderLink = '<a href="' . SITE_URL . 'buyerconversation/' . $orderid . '">view</a>';
                    $notifymsg = 'Seller-___- ' . $loguserlink . ' -___-sent a message-___- ' . $orderLink;
                    $messages = 'Seller ' . $logusername . ' sent a message: ' . $_POST['comment'];
                } else {
                    $logusrid = $_POST['buyerid'];
                    $userid = $_POST['merchantid'];
                    $orderLink = '<a href="' . SITE_URL . 'merchant/sellerconversation/' . $orderid . '">view</a>';
                    $notifymsg = 'Buyer-___- ' . $loguserlink . ' -___-sent a message-___- ' . $orderLink;
                    $messages = 'Buyer ' . $logusername . ' sent a message: ' . $_POST['comment'];
                }

                $logdetails = $this->addlog('ordermessage', $logusrid, $userid, $orderid, $notifymsg, $_POST['comment'], $loguserimage);
                $this->loadModel('Userdevices');
                $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $userid)));
                foreach ($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge += 1;
                    $this->Userdevices->updateAll(array('badge' => "'$badge'"), array('deviceToken' => $deviceTToken));
                    if (isset($deviceTToken)) {
                    }
                }
                if (!empty($_POST['usrimg'])) {
                    $usrimg = $_POST['usrimg'];
                } else {
                    $usrimg = "usrimg.jpg";
                }
                echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 border_bottom_grey padding-top20 padding-bottom20 hor-padding negotian-by-info clearfix">
                <div class="negotaio-image">
                <div class="messag-img">
                <a href="' . SITE_URL . 'people/' . $_POST['usrurl'] . '">
                <div class="clint-img admin-img" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $usrimg . ');background-repeat:no-repeat;"></div>
                </a>
                </div>
                </div>
                <div class="negotation-details margin-both15">
                <a href="' . SITE_URL . 'people/' . $_POST['usrurl'] . '">
                <div class="bold-font margin-top0 margin-bottom10 ">' . $_POST['usrname'] . '</div>
                </a>
                <p class="font-color">' . date('d,M Y', time()) . '</p>
                <p class="font-color">' . $_POST['comment'] . '</p>
                </div>
                </div>';


                if ($_POST['postedby'] == "buyer")
                    $emailId = $_POST['merchantid'];
                else if ($_POST['postedby'] == "seller")
                    $emailId = $_POST['buyerid'];
                $email_address = $userstable->find()->where(['id' => $emailId])->first();
                $emailaddress = $email_address['email'];
                $name = $email_address['username'];

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                $email = $emailaddress;
                $aSubject = $setngs['site_name'] . " " . __d('user', 'You have got a message');
                $aBody = '';
                $template = 'contactseller';
                $setdata = array('name' => $email_address['first_name'], 'email' => $emailaddress, 'username' => $loguser['first_name'], 'sender' => $sender, 'message' => $_POST['comment'], 'setngs' => $setngs);
                $this->sendmail($email, $aSubject, $aBody, $template, $setdata);


            }

            public function getmorecommentviewpurchase()
            {
                global $loguser;
                $itemModel = array();

                $orderstable = TableRegistry::get('Orders');
                $orderitemstable = TableRegistry::get('OrderItems');
                $ordercommentstable = TableRegistry::get('Ordercomments');
                $itemstable = TableRegistry::get('Items');
                $forexratestable = TableRegistry::get('Forexrates');
                $disputestable = TableRegistry::get('Disputes');
                $invoicestable = TableRegistry::get('Invoices');
                $invoiceorderstable = TableRegistry::get('Invoiceorders');
                $trackingdetailstable = TableRegistry::get('Trackingdetails');

                $userid = $loguser['id'];
                $offset = ($_POST['offset'] / 10) + 1;
                $order_id = $_POST['order_id'];
                $contacter = $_POST['contact'];

                $forexrateModel = $forexratestable->find('all');
                $currencySymbol = array();
                foreach ($forexrateModel as $forexrate) {
                    $cCode = $forexrate['currency_code'];
                    $cSymbol = $forexrate['currency_symbol'];
                    $currencySymbol[$cCode] = $cSymbol;
                }

                $userordersModel = $disputestable->find('all')->where(['uorderid' => $orderid])->all();

                $userorderid = array();
                foreach ($userordersModel as $value) {
                    $userorderid[] = $value['orderid'];
                }


                $disp_data = $disputestable->find('all')->where(['uorderid' => $orderid]);

                $this->set('disp_data', $disp_data);
                foreach ($disp_data as $key => $temp) {
                    $disid = $temp['disid'];
                    $uid = $temp['userid'];
                    $uoid = $temp['uorderid'];

                }
                $short_list_array = explode(',', $uoid);
                $shortlist = $disputestable->find('all')->where(['Disputes.uorderid IN' => $short_list_array])->all();

                $this->set('shortlist', $shortlist);
                $this->set('short_list_array', $short_list_array);

                $ordersModel = $orderstable->find('all')->where(['userid' => $userid])->order(['orderid DESC'])->limit('10')->page($offset)->all();

                $orderid = array();
                foreach ($ordersModel as $value) {
                    $orderid[] = $value['orderid'];
                }
                if (count($orderid) > 0) {
                    $orderitemModel = $orderitemstable->find('all')->where(['orderid IN' => $orderid])->all();

                    $itemid = array();
                    foreach ($orderitemModel as $value) {
                        $orid = $value['orderid'];
                        $item_id = $value['itemid'];
                        $itm_detail = $itemstable->find('all')->contain('Photos')->where(['Items.id' => $item_id])->first();

                        if (!isset($oritmkey[$orid])) {
                            $oritmkey[$orid] = 0;
                        }

                        $item_image = $itm_detail['photos'][0]['image_name'];
                        if ($item_image == "")
                            $item_image = "usrimg.jpg";
                        $checkimgage = WWW_ROOT . 'media/items/thumb350/' . $item_image;
                        if (file_exists($checkimgage))
                            $item_image = SITE_URL . 'media/items/thumb350/' . $itm_detail['photos'][0]['image_name'];
                        else
                            $item_image = SITE_URL . 'media/avatars/thumb70/usrimg.jpg';

                        $itemid[] = $value['itemid'];
                        $orderitems[$orid][$oritmkey[$orid]]['businessday'] = $itm_detail['processing_time'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemname'] = $value['itemname'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemimage'] = $item_image;
                        $orderitems[$orid][$oritmkey[$orid]]['itemtotal'] = $value['itemprice'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemsunitprice'] = $value['itemunitprice'];
                        $orderitems[$orid][$oritmkey[$orid]]['itemssize'] = $value['item_size'];
                        $orderitems[$orid][$oritmkey[$orid]]['quantity'] = $value['itemquantity'];
                        $oritmkey[$orid]++;
                    }

                }


                $orderDetails = array();
                foreach ($ordersModel as $key => $orders) {
                    $orderid = $orders['orderid'];
                    $orderCurny = $orders['currency'];
                    $orderDetails[$key]['orderid'] = $orders['orderid'];
                    $orderDetails[$key]['price'] = $orders['totalcost'];
                    $orderDetails[$key]['saledate'] = $orders['orderdate'];
                    $orderDetails[$key]['status'] = $orders['status'];
                    $orderDetails[$key]['deliverytype'] = $orders['deliverytype'];
                    $orderDetails[$key]['deliver_update'] = $orders['deliver_update'];

                    $ordercomments = $ordercommentstable->find('all')->where(['orderid' => $orderid])->all();
                    $orderDetails[$key]['commentcount'] = count($ordercomments);
                    $trackingModel = $trackingdetailstable->find('all')->where(['orderid' => $orderid])->first();
                    $orderDetails[$key]['trackingdetails'] = count($trackingModel);

                    $invoice_orders = $invoiceorderstable->find('all')->where(['orderid' => $orderid])->first();
                    $invoiceid = $invoice_orders['invoiceid'];

                    $invoice_datas = $invoicestable->find('all')->where(['invoiceid' => $invoiceid])->first();
                    $orderDetails[$key]['paymentmethod'] = $invoice_datas['paymentmethod'];

                    $itemkey = 0;
                    foreach ($orderitems[$orderid] as $orderkey => $orderitem) {
                        $orderDetails[$key]['orderitems'][$itemkey]['itemname'] = $orderitems[$orderid][$orderkey]['itemname'];
                        $orderDetails[$key]['orderitems'][$itemkey]['itemimage'] = $orderitems[$orderid][$orderkey]['itemimage'];
                        $orderDetails[$key]['orderitems'][$itemkey]['quantity'] = $orderitems[$orderid][$orderkey]['quantity'];
                        $orderDetails[$key]['orderitems'][$itemkey]['price'] = $orderitems[$orderid][$orderkey]['itemtotal'];
                        $orderDetails[$key]['orderitems'][$itemkey]['unitprice'] = $orderitems[$orderid][$orderkey]['itemsunitprice'];
                        $orderDetails[$key]['orderitems'][$itemkey]['businessday'] = $orderitems[$orderid][$orderkey]['businessday'];
                        $orderDetails[$key]['orderitems'][$itemkey]['size'] = $orderitems[$orderid][$orderkey]['itemssize'];
                        $orderDetails[$key]['orderitems'][$itemkey]['cSymbol'] = $currencySymbol[$orderCurny];
                        $itemkey++;
                    }
                }


                $this->set('orderDetails', $orderDetails);
                $this->set('nmecounts', $nmecounts);
                $this->set('latestcount', $latestcount);
                $this->set('order_id', $order_id);
                $this->set('userid', $userid);
            }

            function orderstatus()
            {
                $this->autoRender = false;
                $orderid = $_POST['orderid'];
                $status = $_POST['chstatus'];

                $this->loadModel('Orders');
                $this->loadModel('Shippingaddresses');
                $this->loadModel('Order_items');
                $this->loadModel('Forexrates');

                $orderstable = TableRegistry::get('Orders');
                $shippaddrtable = TableRegistry::get('Shippingaddresses');
                $orderitemstable = TableRegistry::get('OrderItems');
                $forexratestable = TableRegistry::get('Forexrates');
                $itemstable = TableRegistry::get('Items');
                $userstable = TableRegistry::get('Users');

                global $loguser;
                $this->loadModel('User');
                $statusDate = time();
                $deliverDate = time();
                $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                $orderModl = $orderstable->find()->where(['orderid' => $orderid])->first();
                $orderitemModel = $orderitemstable->find()->where(['orderid' => $orderid])->first();

                $orderCurrency = $orderModl['Currency'];
                $forexrateModel = $forexratestable->find()->where(['currency_code' => $orderCurrency])->first();
                $forexRate = $forexrateModel['price'];

                $itemmailids = array();
                $itemname = array();
                $totquantity = array();
                $custmrsizeopt = array();
                $itemPrice = 0;
                foreach ($orderitemModel as $value) {
                    $itemmailids[] = $value['itemid'];
                    $itemname[] = $value['itemname'];
                    if (!empty($value['item_size'])) {
                        $custmrsizeopt[] = $value['item_size'];
                    } else {
                        $custmrsizeopt[] = '0';
                    }
                    $totquantity[] = $value['itemquantity'];
                    $itemPrice += $orderItemDetail['itemprice'] * $forexRate;

                }
                $usershipping_addr = $shippaddrtable->find()->where(['shippingid' => $orderModl['shippingaddress']])->first();
                if ($status == 'Delivered') {

                    $ordersquery = $orderstable->query();
                    $ordersquery->update()
                    ->set(['status' => $status])
                    ->set(['status_date' => $statusDate])
                    ->set(['deliver_date' => $deliverDate])
                    ->set(['deliver_update' => $statusDate])
                    ->where(['orderid' => $orderid])
                    ->execute();


                    $user_name = $userstable->find()->where(['id' => $orderModel['merchant_id']])->first();
                    $username = $user_name['username'];
                    $emailaddress = $user_name['email'];

                    $buyer_name = $userstable->find()->where(['id' => $orderModel['userid']])->first();
                    $buyername = $buyer_name['username'];
                    $buyerurl = $buyer_name['username_url'];


                    /*** Update the credit amount after while share the product***/

                    if ($orderModel['deliverytype'] == 'door') {


                        $shareData = json_decode($buyer_name['share_status'], true);
                        $creditPoints = $buyer_name['credit_points'];
                        $userid = $buyer_name['id'];
                        $shareNewData = array(); //echo $orderid;
                        foreach ($shareData as $shareKey => $shareVal) {

                            if (array_key_exists($orderid, $shareVal)) {

                                if ($shareVal[$orderid] == '1') {
                                    $creditpoints = $creditPoints + $shareVal['amount'];
                                    $query = $userstable->query();
                                    $query->update()
                                    ->set(['credit_points' => $creditpoints])
                                    ->where(['Users.id' => $userid])
                                    ->execute();

                                } else {
                                }

                            } else {

                                $shareNewData[] = $shareVal;

                            }
                        } //print_r($shareNewData); echo "<br>";

                        $query = $userstable->query();
                        $query->update()
                        ->set(['share_status' => json_encode($shareNewData)])
                        ->where(['Users.id' => $userid])
                        ->execute();

                        $userDet = $userstable->find()->where(['id' => $userid])->first();

                    }

                    $sitesettingstable = TableRegistry::get('Sitesettings');
                    $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                    $email = $emailaddress;
                    $aSubject = $setngs['site_name'] . " – " . __d('user', 'Your order') . " #" . $orderid . " " . __d('user', "shipment was delivered");
                    $aBody = '';
                    $template = 'deliveredmail';
                    $setdata = array(
                        'name' => $name, 'email' => $emailaddress, 'username' => $username, 'orderid' => $orderid,
                        'buyername' => $buyername, 'buyerurl' => $buyerurl, 'itemname' => $itemname, 'tot_quantity' => $totquantity, 'sizeopt' => $custmrsizeopt, 'access_url' => SITE_URL . "login", 'orderdate' => $orderModl['orderdate'], 'usershipping_addr' => $usershipping_addr, 'totalcost' => $orderModl['totalcost'], 'currencyCode' => $orderModl['currency'], 'setngs' => $setngs, 'loguser' => $loguser
                    );
                    $this->sendmail($email, $aSubject, $aBody, $template, $setdata);

                } else {
                    $this->Orders->updateAll(array('status' => "'$status'", 'status_date' => "'$statusDate'"), array('orderid' => $orderid));
                }
                $logusernameurl = $loguser['username_url'];
                $logusername = $loguser['first_name'];
                $userImg = $loguser['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $loguserimage = json_encode($image);
                if ($status == 'Delivered') {
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                    $logusrid = $orderModel['userid'];
                    $userid = $orderModel['merchant_id'];
                    $notifymsg = 'Your order has been received by the buyer-___- ' . $loguserlink;
                } else {
                    $logusrid = $orderModel['merchant_id'];
                    $userid = $orderModel['userid'];
                    $orderLink = '<a href="' . SITE_URL . 'buyerorderdetails/' . $orderid . '">view order: ' . $orderid . '</a>';
                    $notifymsg = 'Your order has been marked as processing-___- ' . $orderLink;
                }

                $logdetails = $this->addlog('orderstatus', $logusrid, $userid, $orderid, $notifymsg, null, $loguserimage);
                $this->loadModel('Userdevices');
                $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $userid)));
                foreach ($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge += 1;
                    $this->Userdevice->updateAll(array('badge' => "'$badge'"), array('deviceToken' => $deviceTToken));
                    if (isset($deviceTToken)) {
                        $messages = 'Your orderid: ' . $orderid . ' has been marked as ' . $status;
                    }
                }

            }

            function claimorder($orderid)
            {
                $this->loadModel('Trackingdetails');
                $this->loadModel('Orders');
                $this->loadModel('User');
                global $loguser;

                $trackingdetailstable = TableRegistry::get('Trackingdetails');
                $orderstable = TableRegistry::get('Orders');
                $userstable = TableRegistry::get('Users');
                $trackingModel = $trackingdetailstable->find()->where(['orderid' => $orderid])->first();
                $this->set('trackingModel', $trackingModel);

                $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                $userid = $orderModel['userid'];
                if ($loguser['id'] != $orderModel['userid']) {
                    $this->Flash->error(__d('user', 'Sorry ! No such record was found'));
                    $this->redirect('/');
                }

                $userModel = $userstable->find()->where(['id' => $userid])->first();
                $this->set('orderModel', $orderModel);
                $this->set('userModel', $userModel);
            }

            function buyerclaimorder()
            {
                $this->autoRender = false;
                $this->loadModel('Orders');
                $orderid = $_POST['orderid'];
                global $loguser;

                $orderstable = TableRegistry::get('Orders');
                $userstable = TableRegistry::get('Users');
                $ordersquery = $orderstable->query();
                $ordersquery->update()
                ->set(['status' => 'Claimed'])
                ->where(['orderid' => $orderid])
                ->execute();

                $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                $logusernameurl = $loguser['username_url'];
                $logusername = $loguser['first_name'];
                $userImg = $loguser['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                $orderidLink = '<a href="' . SITE_URL . 'merchant/claimedorders/">'.$orderid.'</a>';
                $logusrid = $orderModel['userid'];
                $userid = $orderModel['merchant_id'];
                $notifymsg = 'Your order has been claimed by the buyer-___- ' . $loguserlink.', Order id : '.$orderidLink;

                $logdetails = $this->addlog('orderstatus', $logusrid, $userid, $orderid, $notifymsg, null, $loguserimage);

                $sellerdetail = $userstable->find()->where(['id' => $userid])->first();

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                $email = $sellerdetail['email'];
                $name = $sellerdetail['first_name'];
                $aSubject = $setngs['site_name'] . ' - ' . __d('user', 'Your order has been claimed by the buyer');
                $aBody = '';
                $template = 'claimorder';
                $setdata = array('name' => $name, 'logusername' => $logusername, 'orderid' => $orderid);
                $this->sendmail($email, $aSubject, $aBody, $template, $setdata);
            }

            function returnorder($orderid)
            {
                $this->loadModel('Orders');
                $this->loadModel('Users');
                $this->loadModel('Trackdetails');
                global $loguser;

                $orderstable = TableRegistry::get('Orders');
                $userstable = TableRegistry::get('Users');
                $trackdetailstable = TableRegistry::get('Trackdetails');
                $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                $userid = $orderModel['userid'];
                if ($loguser['id'] != $orderModel['userid']) {
                    $this->Flash->error(__d('user', 'Sorry ! No such record was found'));
                    $this->redirect('/');
                }
                $trackingModel = $trackdetailstable->find()->where(['orderid' => $orderid])->first();
                $this->set('trackingModel', $trackingModel);

                $userModel = $userstable->find()->where(['id' => $userid])->first();
                $this->set('orderModel', $orderModel);
                $this->set('userModel', $userModel);
            }

            function buyerreturnorder()
            {
                $this->autoRender = false;
                $this->loadModel('Trackdetails');
                $this->loadModel('Orders');
                $this->loadModel('User');


                $orderid = $_POST['orderid'];
                $shippingdate = $_POST['shippingdate'];
                $couriername = $_POST['couriername'];
                $courierservice = $_POST['courierservice'];
                $trackid = $_POST['trackid'];
                $id = $_POST['id'];
                $shippingdate = $_POST['shippingdate'];
                $notes = $_POST['notes'];
                $reason = $_POST['reason'];

                $trackdetailstable = TableRegistry::get('Trackdetails');
                $orderstable = TableRegistry::get('Orders');
                if ($id != 0) {
                    $trackdetails = $trackdetailstable->get($id);
                } else {
                    $trackdetails = $trackdetailstable->newEntity();
                }

                $trackdetails->orderid = $orderid;
                $trackdetails->shippingdate = strtotime($shippingdate);
                $trackdetails->couriername = $couriername;
                $trackdetails->courierservice = $courierservice;
                $trackdetails->trackingid = $trackid;
                $trackdetails->notes = $notes;
                $trackdetails->reason = $reason;
                $trackdetailstable->save($trackdetails);

                $ordersquery = $orderstable->query();
                $ordersquery->update()
                ->set(['status' => 'Returned'])
                ->where(['orderid' => $orderid])
                ->execute();

            }

            function markshipped($orderid = null)
            {
                global $loguser;
                global $siteChanges;
                global $setngs;
                $userid = $loguser[0]['User']['id'];
                $first_name = $loguser[0]['User']['first_name'];
                $this->set('first_name', $first_name);
                $this->loadModel('Orders');
                $orderModel = $this->Orders->findByorderid($orderid);

                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }
                if ($orderModel['Orders']['status'] == 'Delivered') {
                    $this->Flash->error(__d('user', 'Product was already delivered'));
                    $this->redirect('/orders');
                }
                if (!isset($_POST['orderid'])) {
                    $this->layout = 'frontlayout';
                    $this->set('title_for_layout', 'Mark Shipped');
                    $this->loadModel('Orders');
                    $this->loadModel('Shippingaddresses');
                    $orderModel = $this->Orders->findByorderid($orderid);
                    $userid = $orderModel['Orders']['userid'];
                    $userModel = $this->User->findByid($userid);
                    $userEmail = $userModel['User']['email'];
                    $shipppingId = $orderModel['Orders']['shippingaddress'];
                    $shippingModel = $this->Shippingaddresses->findByshippingid($shipppingId);

                    $this->set('orderModel', $orderModel);
                    $this->set('userModel', $userModel);
                    $this->set('shippingModel', $shippingModel);
                } else {
                    $this->layout = 'ajax';
                    $this->set('title_for_layout', 'Mark Shipped');
                    $this->loadModel('Orders');
                    $this->loadModel('Order_items');
                    $this->loadModel('Shippingaddresses');
                    $orderid = $_POST['orderid'];
                    $buyeremail = $_POST['buyeremail'];
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];
                    $usernameforcust = $_POST['buyername'];
                    echo $deliver_date = time();
                    $orderModel = $this->Orders->find('first', array('conditions' => array('orderid' => $orderid)));
                    echo $orderModel['Orders']['merchant_id'];
                    if ($loguser[0]['User']['id'] != $orderModel['Orders']['merchant_id']) {
                        $this->Flash->error(__d('user', 'Sorry ! No such record was found'));
                        $this->redirect('/');
                    }

                    $orderitemModel = $this->Order_items->find('all', array('conditions' => array('orderid' => $orderid)));
                    $itemmailids = array();
                    $itemname = array();
                    $totquantity = array();
                    $custmrsizeopt = array();
                    foreach ($orderitemModel as $value) {
                        $itemmailids[] = $value['Order_items']['itemid'];
                        $itemname[] = $value['Order_items']['itemname'];
                        if (!empty($value['Order_items']['item_size'])) {
                            $custmrsizeopt[] = $value['Order_items']['item_size'];
                        } else {
                            $custmrsizeopt[] = '0';
                        }
                        $totquantity[] = $value['Order_items']['itemquantity'];
                    }
                    $statusDate = time();
                    $this->Orders->updateAll(array('status' => "'Shipped'", 'status_date' => "'$statusDate'"), array('orderid' => $orderid));
                    $usershipping_addr = $this->Shippingaddresses->findByShippingid($orderModel['Orders']['shippingaddress']);
                    $userModel = $this->User->findByid($orderModel['Orders']['userid']);

                    if ($setngs[0]['Sitesetting']['gmail_smtp'] == 'enable') {
                        $this->Email->smtpOptions = array(
                            'port' => $setngs[0]['Sitesetting']['smtp_port'],
                            'timeout' => '30',
                            'host' => 'ssl://smtp.gmail.com',
                            'username' => $setngs[0]['Sitesetting']['noreply_email'],
                            'password' => $setngs[0]['Sitesetting']['noreply_password']
                        );

                        $this->Email->delivery = 'smtp';
                    }
                    $this->Email->to = $buyeremail;
                    $this->Email->subject = SITE_NAME . " – Shipping initiated for order #$orderid";//$subject;
                    $this->Email->from = SITE_NAME . "<" . $setngs[0]['Sitesetting']['noreply_email'] . ">";
                    $this->Email->sendAs = "html";
                    $this->Email->template = 'markedshipped';
                    $this->set('custom', $userModel['User']['first_name']);
                    $this->set('message', $message);
                    $this->set('loguser', $loguser);
                    $this->set('itemname', $itemname);
                    $this->set('itemid', $itemmailids);
                    $this->set('tot_quantity', $totquantity);
                    $this->set('sizeopt', $custmrsizeopt);
                    $this->set('orderId', $orderid);
                    $this->set('orderdate', $orderModel['Orders']['orderdate']);
                    $this->set('usershipping_addr', $usershipping_addr);
                    $this->set('totalcost', $orderModel['Orders']['totalcost']);
                    $this->set('currencyCode', $orderModel['Orders']['currency']);
                    $this->Email->send();

                    echo $statusDate = time();
                    $this->Orders->updateAll(array('status' => "'Shipped'", 'status_date' => "'$statusDate'", 'deliver_date' => "'$deliver_date'"), array('orderid' => $orderid));

                    $logusernameurl = $loguser[0]['User']['username_url'];
                    $userImg = $loguser[0]['User']['profile_image'];
                    if (empty($userImg)) {
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";

                    $logusrid = $orderModel['Orders']['merchant_id'];
                    $userid = $orderModel['Orders']['userid'];
                    $orderLink = '<a href="' . SITE_URL . 'buyerorderdetails/' . $orderid . '">view order: ' . $orderid . '</a>';
                    $notifymsg = 'Your order has been marked as shipped-___- ' . $orderLink;

                    $logdetails = $this->addlog('orderstatus', $logusrid, $userid, $orderid, $notifymsg, null, $loguserimage);

                    $this->loadModel('Userdevice');
                    $userddett = $this->Userdevice->find('all', array('conditions' => array('user_id' => $userid)));
                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['Userdevice']['deviceToken'];
                        $badge = $userdet['Userdevice']['badge'];
                        $badge += 1;
                        $this->Userdevice->updateAll(array('badge' => "'$badge'"), array('deviceToken' => $deviceTToken));
                        if (isset($deviceTToken)) {
                            $messages = 'Your orderid: ' . $orderid . ' has been marked as Shipped';
                        }
                    }

                    $this->redirect('/orders');
                }
            }

            function trackingdetails($orderid)
            {
                $this->layout = 'frontlayout';
                $this->set('title_for_layout', 'Tracking Details');
                global $loguser;
                global $siteChanges;
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }

                $first_name = $loguser[0]['User']['first_name'];
                $this->set('first_name', $first_name);

                $this->loadModel('Orders');
                $this->loadModel('Shippingaddresses');
                $this->loadModel('Trackingdetails');
                $orderModel = $this->Orders->findByorderid($orderid);
                $userid = $orderModel['Orders']['userid'];
                if ($loguser[0]['User']['id'] != $orderModel['Orders']['merchant_id']) {
                    $this->Flash->error(__d('user', 'Sorry ! No such record was found'));
                    $this->redirect('/');
                }
                if ($orderModel['Orders']['status'] == 'Delivered') {
                    $this->Flash->error(__d('user', 'Product was already delivered'));
                    $this->redirect('/orders');
                }
                $userModel = $this->User->findByid($userid);
                $userEmail = $userModel['User']['email'];
                $shipppingId = $orderModel['Orders']['shippingaddress'];
                $shippingModel = $this->Shippingaddresses->findByshippingid($shipppingId);
                $trackingModel = $this->Trackingdetails->findByorderid($orderid);

                $this->set('orderModel', $orderModel);
                $this->set('userModel', $userModel);
                $this->set('shippingModel', $shippingModel);
                $this->set('trackingModel', $trackingModel);
            }

            function sellerconversation($orderid)
            {
                global $loguser;
                global $siteChanges;
                global $setngs;
                if (!$this->isauthenticated()) {
                    $this->redirect('/');
                }

                $first_name = $loguser[0]['User']['first_name'];
                $this->set('first_name', $first_name);

                $this->layout = 'frontlayout';
                $this->set('title_for_layout', 'Conversation');
                $this->loadModel('Orders');
                $this->loadModel('Shippingaddresses');
                $this->loadModel('Ordercomments');

                $orderModel = $this->Orders->findByorderid($orderid);
                $ordercommentsModel = $this->Ordercomments->find('all', array('conditions' => array('orderid' => $orderid), 'order' => 'id DESC'));
                $buyerid = $orderModel['Orders']['userid'];
                $merchantid = $orderModel['Orders']['merchant_id'];

                if ($loguser[0]['User']['id'] != $merchantid) {
                    $this->Flash->error(__d('user', 'Sorry ! No such record was found'));
                    $this->redirect('/');
                }

                $buyerModel = $this->User->findByid($buyerid);
                $buyerName = $buyerModel['User']['first_name'];
                $merchantModel = $this->User->findByid($merchantid);

                $this->set('orderModel', $orderModel);
                $this->set('buyerModel', $buyerModel);
                $this->set('merchantModel', $merchantModel);
                $this->set('ordercommentsModel', $ordercommentsModel);
                $this->set('buyerName', $buyerName);
                $this->set('roundProf', $siteChanges['profile_image_view']);
            }

            public function disputepro()
            {

                global $loguser;
                $userid = $loguser['id'];
                $firstname = $loguser['first_name'];
                $_SESSION['first_name'] = $firstname;

                $dispconstable = TableRegistry::get('Dispcons');
                $disputestable = TableRegistry::get('Disputes');
                $userstable = TableRegistry::get('Users');
                $itemstable = TableRegistry::get('Items');
                $orderstable = TableRegistry::get('Orders');
                $forexratestable = TableRegistry::get('Forexrates');


                $this->loadModel('Disputes');


                if (isset($_REQUEST['buyer'])) {

                    $msgel = $this->Disputes->find('all', array('conditions' => array('OR' => array(
                        array('userid' => $userid), array('selid' => $userid)
                    ), array('AND' => array('OR' => array('newstatusup' => 'Reply', 'OR' => array('newstatusup' => 'Initialized', 'OR' => array('newstatusup' => 'Responded', 'OR' => array('newstatusup' => 'Accepeted', 'OR' => array('newstatusup' => 'Reopen')))))))), 'order' => array('disid' => 'desc')));
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
                        $messagesel[$key]['money'] = $msg['money'];

                        $username = $userstable->find()->where(['id' => $selid])->first();
                        $u = $messagesel[$key]['username_url'] = $username['username_url'];

                        $sellername = $userstable->find()->where(['id' => $usedisid])->first();
                        $s = $messageseles[$key]['username_url'] = $sellername['username_url'];

                        $uorcurre = $orderstable->find()->where(['orderid' => $uor])->first();
                        $messagesel[$key]['currencyCode'] = $messageseles[$key]['username_url'] = $uorcurre['currency'];

                        $forexrateModel = $forexratestable->find()->where(['currency_code' => $currencyCode])->first();
                        $messagesel[$key]['currencySymbol'] = $forexrateModel['currency_symbol'];
                    }

                    $msgelsscou = $this->Disputes->query("SELECT * FROM fc_disputes WHERE userid = '$userid'  and newstatusup ='Initialized' or userid = '$userid'  and newstatusup ='Reopen' or userid = '$userid'  and newstatusup ='Accepeted' or userid = '$userid'  and newstatusup ='Responded' or userid = '$userid'  and newstatusup ='Reply' or selid ='$userid' and newstatusup ='Initialized' or selid ='$userid' and newstatusup ='Responded' or selid ='$userid' and newstatusup ='Reply' or selid ='$userid' and newstatusup ='Accepeted' or selid = '$userid'  and newstatusup ='Reopen' ");

                    $msgelsscou = $disputestable->find()
                    ->where(['userid' => $userid])
                    ->orwhere(['selid' => $userid])
                    ->andwhere(function ($exp, $q) {
                        return $exp->in('newstatusup', ['Initialized', 'Reopen', 'Accepeted', 'Responded', 'Reply']);
                    })->order(['disid' => 'DESC'])->count();

                    $msgelcou = $msgelsscou;

                    $this->set('msgelcou', $msgelcou);
                    $this->set('messagesel', $messagesel);
                    $this->set('messageseles', $messageseles);
                    $this->set('msgel', $msgel);

                    $msgelcouss = $this->Disputes->query("SELECT * FROM fc_disputes WHERE  userid = '$userid'  and newstatusup ='Cancel' or userid = '$userid'  and newstatusup ='Resolved' or userid = '$userid'  and newstatusup ='Closed' or userid = '$userid'  and newstatusup ='Processing' or selid ='$userid' and newstatusup ='Cancel' or selid ='$userid' and newstatusup ='Closed' or selid ='$userid' and newstatusup ='Processing' or selid ='$userid' and newstatusup ='Resolved'");

                    $msgelcouss = $disputestable->find()
                    ->where(['userid' => $userid])
                    ->orwhere(['selid' => $userid])
                    ->andwhere(function ($exp, $q) {
                        return $exp->in('newstatusup', ['Cancel', 'Resolved', 'Closed', 'Processing']);
                    })->order(['disid' => 'DESC'])->count();

                    $tocousel = $msgelcouss;

                    $this->set('tocousel', $tocousel);
                    $this->set('username', $username);
                }

                if (isset($_REQUEST['seller'])) {
                    $userid = $loguser['id'];

                    $msbuyer = $this->Disputes->find('all', array('conditions' => array('OR' => array(
                        array('userid' => $userid), array('selid' => $userid)
                    ), array('AND' => array('OR' => array('newstatusup' => 'Cancel', 'OR' => array('newstatusup' => 'Closed', 'OR' => array('newstatusup' => 'Processing', 'OR' => array('newstatusup' => 'Resolved'))))))), 'order' => array('disid' => 'desc')));


                    foreach ($msbuyer as $key => $msgbuyer) {
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
                        $username = $userstable->find()->where(['id' => $user])->first();
                        $messagebuyer[$key]['username_url'] = $username['username_url'];

                        $this->loadModel('Orders');
                        $uorcurre = $orderstable->find()->where(['orderid' => $uor])->first();
                        $messagebuyer[$key]['currencyCode'] = $messageseles[$key]['username_url'] = $uorcurre['currency'];

                        $this->loadModel('Forexrate');
                        $forexrateModel = $forexratestable->find()->where(['currency_code' => $currencyCode])->first();
                        $messagebuyer[$key]['currencySymbol'] = $forexrateModel['currency_symbol'];
                    }
                    $this->set('messagebuyer', $messagebuyer);
                    $msgelsscou = $this->Disputes->query("SELECT * FROM fc_disputes WHERE userid = '$userid'  and newstatusup ='Initialized'  or userid = '$userid'  and newstatusup ='Reopen'  or userid = '$userid'  and newstatusup ='Accepeted' or userid = '$userid'  and newstatusup ='Responded' or userid = '$userid'  and newstatusup ='Reply' or selid ='$userid' and newstatusup ='Initialized' or selid ='$userid' and newstatusup ='Responded' or selid ='$userid' and newstatusup ='Reply' or selid ='$userid' and newstatusup ='Accepeted' or selid = '$userid'  and newstatusup ='Reopen' ");

                    $msgelsscou = $disputestable->find()
                    ->where(['userid' => $userid])
                    ->orwhere(['selid' => $userid])
                    ->andwhere(function ($exp, $q) {
                        return $exp->in('newstatusup', ['Initialized', 'Reopen', 'Accepeted', 'Responded', 'Reply']);
                    })->order(['disid' => 'DESC'])->count();

                    $msgelcou = $msgelsscou;

                    $msgelcouss = $this->Disputes->query("SELECT * FROM fc_disputes WHERE userid = '$userid'  and newstatusup ='Cancel' or userid = '$userid'  and newstatusup ='Resolved' or userid = '$userid'  and newstatusup ='Closed' or userid = '$userid'  and newstatusup ='Processing' or selid ='$userid' and newstatusup ='Cancel' or selid ='$userid' and newstatusup ='Closed' or selid ='$userid' and newstatusup ='Processing' or selid ='$userid' and newstatusup ='Resolved' ");

                    $msgelcouss = $disputestable->find()
                    ->where(['userid' => $userid])
                    ->orwhere(['selid' => $userid])
                    ->andwhere(function ($exp, $q) {
                        return $exp->in('newstatusup', ['Cancel', 'Resolved', 'Closed', 'Processing']);
                    })->order(['disid' => 'DESC'])->count();

                    $tocousel = $msgelcouss;

                    $this->set('tocousel', $tocousel);
                    $this->set('msgelcousell', $msgelcousell);
                    $this->set('msgelcou', $msgelcou);
                    $this->set('messagesel', $messagesel);
                    $this->set('messageseles', $messageseles);
                }
            }


            public function disputemessage($orderid)
            {
                global $loguser;
                global $setngs;
                $siteChanges = $setngs['site_changes'];
                $siteChanges = json_decode($siteChanges, true);
                $userid = $loguser['id'];
                $firstname = $loguser['first_name'];
                $_SESSION['first_name'] = $firstname;
                $log = $loguser['id'];
                $login = $_SESSION['id'] = $log;
                $login;
                $userid;
                $this->loadModel('Dispcons');
                $this->loadModel('Disputes');
                $this->loadModel('Users');
                $this->loadModel('Order_items');
                $orderid;
                $this->loadModel('Order_items');
                $this->loadModel('Ordercomments');
                $this->loadModel('Orders');

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

                $orderstable = TableRegistry::get('Orders');
                $dispconstable = TableRegistry::get('Dispcons');
                $disputestable = TableRegistry::get('Disputes');
                $userstable = TableRegistry::get('Users');
                $forexratestable = TableRegistry::get('Forexrates');
                $orderitemstable = TableRegistry::get('OrderItems');
                $ordercommentstable = TableRegistry::get('Ordercomments');
                $orderModel = $orderstable->find()->where(['orderid' => $orderid])->first();
                $ordercommentsModel = $ordercommentstable->find()->where(['orderid' => $orderid])->order(['id DESC'])->all();
                $buyerid = $orderModel['userid'];
                $merchantid = $orderModel['merchant_id'];
                if ($userid != $buyerid) {
                    $this->redirect('/');
                }


                $orderitemmodel = $orderitemstable->find()->where(['orderid' => $orderid])->all();
                $msgelcou = $dispconstable->find()->where(['order_id' => $orderid])->count();
                $this->set('msgelcou', $msgelcou);
                $this->set('orderitemmodel', $orderitemmodel);

                $orderitemmodel = $orderitemstable->find()->where(['orderid' => $orderid])->all();


                $msgelcou = $dispconstable->find()->where(['order_id' => $orderid])->count();
                $this->set('msgelcou', $msgelcou);
                $this->set('orderitemmodel', $orderitemmodel);
                $orderdet = $disputestable->find()->where(['uorderid' => $orderid])->first();
                $dispid = $orderdet['disid'];
                $buyerModel = $userstable->find()->where(['id' => $login])->first();
                $adminModel = $userstable->find()->where(['id' => 1])->first();
                $buyerName = $buyerModel['first_name'];
                $merchantModel = $userstable->find()->where(['id' => $merchantid])->first();
                $sellerName = $merchantModel['first_name'];
                $selleremail = $merchantModel['email'];
                $msgel = $dispconstable->find()->where(['order_id' => $orderid])->where(['user_id' => $userid])->order(['dcid ASC'])->all();

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





                    $this->loadModel('Orders');
                    $uorcurre = $orderstable->find()->where(['orderid' => $uor])->first();
                    $currencyCode = $messageseles[$key]['username_url'] = $uorcurre['currency'];

                    $this->loadModel('Forexrates');
                    $forexrateModel = $forexratestable->find()->where(['currency_code' => $currencyCode])->first();
                    $currencySymbol = $forexrateModel['currency_symbol'];
                    $this->set('currencySymbol', $currencySymbol);
                    $this->set('currencyCode', $currencyCode);
                }
                $this->set('messagedisp', $messagedisp);
                $this->set('orderdet', $orderdet);
                $this->set('buyerModel', $buyerModel);
                $this->set('adminModel', $adminModel);
                $this->set('orderModel', $orderModel);
                $this->set('merchantModel', $merchantModel);
                $this->set('firstname', $firstname);
                $this->set('roundProf', $siteChanges['profile_image_view']);
                if (isset($_REQUEST['buyconver'])) {
                    $dispconstable = TableRegistry::get('Dispcons');
                    $dispcons = $dispconstable->newEntity();
                    $cuids = $dispcons->user_id = $userid;
                    $gli = $dispcons->dispid = $dis;
                    $gor = $dispcons->order_id = $orderid;
                    $gmsss = $dispcons->message = $this->request->data['data']['Dispute']['msg'];
                    $merid = $dispcons->msid = $orderdet['selid'];
                    $liid = $dispcons->dispid = $orderdet['disid'];
                    $da = $dispcons->date = time();
                    $nei = "Buyer";
                    $cre = $dispcons->commented_by = $nei;

                    //echo '<pre>'; print_r($_FILES); die;

                    if (!empty($this->request->data['data']['Dispute']['upload']['name'])) {
                        $fileimg = $this->request->data['data']['Dispute']['upload'];
                        /*
                        $ext = substr(strtolower(strrchr($fileimg['name'], '.')), 1);
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');

                        //echo $ext;
                        //print_r($arr_ext);
                        //die;
                        if (in_array($ext, $arr_ext)) {

                            //echo '<pre>'; print_r($fileimg); die;

                            move_uploaded_file($fileimg['tmp_name'], WWW_ROOT . "/disputeimage/" . date('ymdhis').$fileimg['name']);


                        }
                        */
                         $appImageValues = getimagesize($fileimg['tmp_name']);  
                        $extensionarray = array('.jpg', '.png', '.jpeg'); 
                        $imageSize = (trim($fileimg['size']) / 1024) / 1024;
                        $ext = strrchr(trim($fileimg['name']), '.');

                        if ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && $imageSize < 2 && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png")) { 
                            move_uploaded_file($fileimg['tmp_name'], WWW_ROOT."/disputeimage/". date('ymdhis').$fileimg['name']); 
                        } else { 
                            $dispcons->imagedisputes = "";  
                        }
                    }

                    if ($fileimg['name'] == '') {
                        $dispcons->imagedisputes = "";
                    } else {
                        $imgs = $dispcons->imagedisputes = date('ymdhis').$fileimg['name'];
                    }
                    $rly = 'Reply';
                    $dispcons->newdispstatus = $rly;


                    $curstatus = $disputestable->find()->where(['uorderid' => $orderid])->first();
                    $cursta = $curstatus['newstatusup'];


                    if ($curstatus['resolvestatus'] != 'Resolved' && $curstatus['newstatusup'] != 'Cancel' && $curstatus['newstatusup'] != 'Processing' && $curstatus['newstatusup'] != 'Closed') {
                        $dispconstable->save($dispcons);

                        $resp = 'Responded';
                        $disputequery = $disputestable->query();
                        $disputequery->update()
                        ->set(['newstatusup' => $resp])
                        ->where(['uorderid' => $orderid])
                        ->execute();
                    } else {
                        $this->redirect('/disputemessage/' . $orderid);
                    }

                    $resp = 'Responded';
                    $chtim = time();
                    $disputequery = $disputestable->query();
                    $disputequery->update()
                    ->set(['newstatusup' => $resp])
                    ->set(['chatdate' => $chtim])
                    ->where(['uorderid' => $orderid])
                    ->execute();

                    $userModel = $userstable->find()->where(['id' => $loguser['id']])->first();
        //push notification
                    $logusername = $userModel['username'];
                    $logusernameurl = $userModel['username_url'];
                    $userImg = $userModel['profile_image'];
                    if (empty($userImg)) {
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                    $disputelink = "<a href='" . SITE_URL . "merchant/disputeBuyer/" . $gor . "'>" . $gor . "</a>";
                    $notifymsg = $loguserlink . " -___-Buyer Replied For the Dispute : -___-" . $disputelink;
                    $logdetails = $this->addlog('dispute', $userid, $merchantid, $dispid, $notifymsg, $gmsss, $loguserimage);

                    if ($setngs['gmail_smtp'] == 'enable') {
                        $this->Email->smtpOptions = array(
                            'port' => $setngs[0]['Sitesetting']['smtp_port'],
                            'timeout' => '30',
                            'host' => 'ssl://smtp.gmail.com',
                            'username' => $setngs['noreply_email'],
                            'password' => $setngs['noreply_password']
                        );

                        $this->Email->delivery = 'smtp';
                    }
                    $this->Email->to = $selleremail;
                    $this->Email->subject = $setngs['site_name'] . " There is a response on the dispute #" . $liid;
                    $this->Email->from = SITE_NAME . "<" . $setngs['noreply_email'] . ">";
                    $this->Email->sendAs = "html";
                    $this->Email->template = 'disputerlyseller';
                    $this->set('UserId', $cuids);
                    $this->set('OrderId', $gor);
                    $this->set('Message', $gmsss);
                    $this->set('liid', $liid);
                    $this->set('sellername', $sellerName);
                    $this->set('buyerName', $buyerName);
                    $this->set('setngs', $setngs);
                    $emailid = base64_encode($merEmail);

                    $email = $selleremail;
                    $aSubject = $setngs['site_name'] . " " . __d('user', "There is a response on the dispute") . " #" . $liid;
                    $aBody = '';
                    $template = 'disputerlyseller';
                    $setdata = array('UserId' => $cuids, 'OrderId' => $gor, 'Message' => $gmsss, 'liid' => $liid, 'sellername' => $sellerName, 'buyerName' => $buyerName, 'setngs' => $setngs);
                    $this->sendmail($email, $aSubject, $aBody, $template, $setdata);


                    $this->redirect('/disputemessage/' . $orderid);



                }
                if (isset($_REQUEST['cancel'])) {
                    $resp = 'Cancel';

                    $disputequery = $disputestable->query();
                    $disputequery->update()
                    ->set(['newstatusup' => $resp])
                    ->where(['uorderid' => $orderid])
                    ->execute();


                    $this->loadModel('Users');
                    $userModel = $userstable->find()->where(['id' => $loguser['id']])->first();
                //push notification
                    $logusername = $userModel['username'];
                    $logusernameurl = $userModel['username_url'];

                    $userImg = $userModel['profile_image'];
                    if (empty($userImg)) {
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;

                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                    $disputelink = "<a href='" . SITE_URL . "merchant/disputeBuyer/" . $orderid . "'>" . $orderid . "</a>";
                    $notifymsg = $loguserlink . " -___-Buyer Cancelled the Dispute : -___- " . $disputelink;
                    $gmsss = 'Cancel Disputes';

                    $logdetails = $this->addlog('dispute', $userid, $merchantid, $dispid, $notifymsg, $gmsss, $loguserimage);
                    $this->redirect('/disputemessage/' . $orderid);


                }

                if (isset($_REQUEST['resolve'])) {
                    $resp = 'Resolved';

                    $disputequery = $disputestable->query();
                    $disputequery->update()
                    ->set(['newstatusup' => $resp])
                    ->where(['uorderid' => $orderid])
                    ->execute();




                    $this->loadModel('Users');
                    $userModel = $userstable->find()->where(['id' => $loguser['id']])->first();
                //push notification
                    $logusername = $userModel['username'];
                    $logusernameurl = $userModel['username_url'];
                    $userImg = $userModel['profile_image'];
                    if (empty($userImg)) {
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                    $disputelink = "<a href='" . SITE_URL . "merchant/disputeBuyer/" . $orderid . "'>" . $orderid . "</a>";
                    $notifymsg = $loguserlink . " -___-Buyer Resolved the Dispute : -___-" . $disputelink;
                    $gmsss = 'Cancel Disputes';

                    $logdetails = $this->addlog('dispute', $userid, $merchantid, $dispid, $notifymsg, $gmsss, $loguserimage);


                    $dispute_details = $disputestable->find()->where(['uorderid' => $orderid])->first();
                    $buyeremail = $dispute_details['uemail'];
                    $selleremail = $dispute_details['semail'];
                    $sellerName = $dispute_details['sname'];
                    $buyerName = $dispute_details['uname'];
                    $liid = $dispute_details['disid'];

                    if ($setngs['gmail_smtp'] == 'enable') {
                        $this->Email->smtpOptions = array(
                            'port' => $setngs[0]['Sitesetting']['smtp_port'],
                            'timeout' => '30',
                            'host' => 'ssl://smtp.gmail.com',
                            'username' => $setngs['noreply_email'],
                            'password' => $setngs['noreply_password']
                        );

                        $this->Email->delivery = 'smtp';
                    }
                    $this->Email->to = $selleremail;
                    $this->Email->subject = $setngs['site_name'] . ": Dispute Resolved : id #" . $liid;
                    $this->Email->from = SITE_NAME . "<" . $setngs['noreply_email'] . ">";
                    $this->Email->sendAs = "html";
                    $this->Email->template = 'disputeresolve';
                    $this->set('UserId', $cuids);
                    $this->set('orderid', $orderid);
                    $this->set('Message', $gmsss);
                    $this->set('setngs', $setngs);
                    $this->set('liid', $liid);
                    $this->set('buyerName', $buyerName);
                    $this->set('sellerName', $sellerName);
                    $emailid = base64_encode($merEmail);

                    $email1 = $selleremail;
                    $aSubject1 = $setngs['site_name'] . ": " . __d('user', 'Dispute Resolved') . " : id #" . $liid;
                    $aBody1 = '';
                    $template1 = 'disputeresolve';
                    $setdata1 = array('UserId' => $cuids, 'orderid' => $orderid, 'Message' => $gmsss, 'liid' => $liid, 'sellerName' => $sellerName, 'buyerName' => $buyerName, 'setngs' => $setngs);
                    $this->sendmail($email1, $aSubject1, $aBody1, $template1, $setdata1);

                    $this->redirect('/disputemessage/' . $orderid);

                }

            }

            /* dispute message load more function */

            function getbuyercmnt()
            {
                global $loguser;
                global $siteChanges;
                global $setngs;
                $this->loadModel('Dispcons');
                $this->loadModel('Orders');

                $dispconstable = TableRegistry::get('Dispcons');
                $orderstable = TableRegistry::get('Orders');
                $userstable = TableRegistry::get('Users');
                $currentcont = $_POST['currentcont'];
                $order_id = $_POST['order_id'];
                $contacter = $_POST['contact'];


                $orderModel = $orderstable->find()->where(['orderid' => $order_id])->first();
                $messagedisp = $this->Dispcons->find('all', array('conditions' => array('order_id' => $order_id), 'offset' => $currentcont, 'limit' => '40'));

                $messagedisp = $this->Dispcons->find('all', array(
                    'conditions' => array(
                        'order_id' => $order_id
                    ),
                    'limit' => '40',
                    'offset' => $currentcont,
                    'order' => 'dcid DESC',
                ))->toArray();

                if (!empty($messagedisp)) {
                    $latestcount = $currentcont + count($messagedisp);
                    $buyerid = $orderModel['userid'];
                    $merchantid = $orderModel['merchant_id'];
                    $buyerModel = $userstable->find()->where(['id' => $buyerid])->first();
                    $merchantModel = $userstable->find()->where(['id' => $merchantid])->first();

                    if ($contacter == 'Seller') {
                        $this->set('buyerModel', $merchantModel);
                        $this->set('merchantModel', $buyerModel);
                    } else {
                        $this->set('buyerModel', $buyerModel);
                        $this->set('merchantModel', $merchantModel);
                    }
                    $this->set('contacter', $contacter);
                    $this->set('roundProf', $siteChanges['profile_image_view']);
                }
                $this->set('messagedisp', $messagedisp);
                $this->set('latestcount', $latestcount);
            }

            function getmorecommentbuyer()
            {
                $this->autoRender = false;
                global $loguser;
                global $siteChanges;
                global $setngs;
                $this->loadModel('Dispcons');
                $this->loadModel('Orders');

                $dispconstable = TableRegistry::get('Dispcons');
                $orderstable = TableRegistry::get('Orders');
                $userstable = TableRegistry::get('Users');

                $userid = $loguser['id'];
                $offset = $_POST['offset'];
                $offset = $offset - 5; //new
                $order_id = $_POST['order_id'];
                $contacter = $_POST['contact'];

                $orderModel = $orderstable->find()->where(['orderid' => $order_id])->first();
                $messagedisp = $this->Dispcons->find('all', array('conditions' => array('order_id' => $order_id), 'order' => 'dcid ASC', 'offset' => $offset, 'limit' => '5'));

                $messagedisp = $this->Dispcons->find('all', array(
                    'conditions' => array(
                        'order_id' => $order_id
                    ),
                    'limit' => '5',
                    'offset' => $offset,
                    'order' => 'dcid ASC',
                ))->toArray();

                if (!empty($messagedisp)) {
                    $latestcount = $currentcont + count($messagedisp);
                    $buyerid = $orderModel['userid'];
                    $merchantid = $orderModel['merchant_id'];
                    $buyerModel = $userstable->find()->where(['id' => $buyerid])->first();
                    $merchantModel = $userstable->find()->where(['id' => $merchantid])->first();
                    if ($contacter == 'Seller') {
                        $this->set('buyerModel', $merchantModel);
                        $this->set('merchantModel', $buyerModel);
                    } else {
                        $this->set('buyerModel', $buyerModel);
                        $this->set('merchantModel', $merchantModel);
                    }
                    $this->set('contacter', $contacter);
                    $this->set('roundProf', $siteChanges['profile_image_view']);
                }
                $this->set('messagedisp', $messagedisp);
                $this->set('latestcount', '0');
                $this->render('getbuyercmnt');
            }


            public function allstores()
            {
                $shippriceliststable = TableRegistry::get('Shippricelists');
                $countriestable = TableRegistry::get('Countries');
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $shopstable = TableRegistry::get('Shops');
                $itemstable = TableRegistry::get('Items');
                $followerstable = TableRegistry::get('Followers');

                $shopname = $_REQUEST['shopname'];
                global $loguser;
                $userid = $loguser['id'];
                $this->set('userid', $userid);
                $_SESSION['shopname'] = $shopname;
                if (!empty($shopname)) {
                    $shopsdet = $shopstable->find('all')->contain('Users')
                    ->where(['Users.user_level' => 'shop'])
                    ->where(['store_enable' => 'enable'])
                    ->where(['item_count >' => '0'])
                    ->where(['seller_status' => '1'])
                    ->where(['shop_name LIKE' => '%' . $shopname . '%'])
                    ->where(['store_enable' => 'enable'])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('Shops.user_id', '$userid');
                    })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit('10')->all();
                } else {
                    $shopsdet = $shopstable->find('all')->contain('Users')
                    ->where(['Users.user_level' => 'shop'])
                    ->where(['store_enable' => 'enable'])
                    ->where(['item_count >' => '0'])
                    ->where(['seller_status' => '1'])
                    ->where(['store_enable' => 'enable'])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('Shops.user_id', '$userid');
                    })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit('10')->all();
                }

                $topshoparr = array();
                $skey = 0;
                foreach ($shopsdet as $shopdata) {

                    $shopid = $shopdata['id'];
                    $itemcounts = $itemstable->find('all')->where(['Items.status' => 'publish'])->where(['Items.shop_id' => $shopid])->count();
                    $topshoparr[$skey]['shop_name'] = $shopdata['shop_name'];
                    $topshoparr[$skey]['shop_image'] = $shopdata['shop_image'];
                    $topshoparr[$skey]['shop_banner'] = $shopdata['shop_banner'];
                    $topshoparr[$skey]['merchant_name'] = $shopdata['merchant_name'];
                    $topshoparr[$skey]['shop_name_url'] = $shopdata['shop_name_url'];
                    $topshoparr[$skey]['item_count'] = $shopdata['item_count'];
                    $topshoparr[$skey]['user_id'] = $shopdata['user_id'];
                    $topshoparr[$skey]['id'] = $shopdata['id'];
                    $topshoparr[$skey]['wifi'] = $shopdata['wifi'];
                    $topshoparr[$skey]['follow_count'] = $shopdata['follow_count'];
                    $followcnt = $storefollowerstable->followcnt($loguser['id']);
                    $this->set('followcnt', $followcnt);
                    $topshoparr[$skey]['follow_shop'] = $flwrscnt;
                    $userid = $shopdata['user']['id'];

                    $skey += 1;
                }
                $this->set('followcnt', $followcnt);
                $this->set('shopsdet', $topshoparr);
            }

            public function getmorestores()
            {
                $shippriceliststable = TableRegistry::get('Shippricelists');
                $countriestable = TableRegistry::get('Countries');
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $shopstable = TableRegistry::get('Shops');
                $itemstable = TableRegistry::get('Items');
                $followerstable = TableRegistry::get('Followers');

                $offset = ($_POST['offset'] / 10) + 1;

                global $loguser;
                $userid = $loguser['id'];
                $this->set('userid', $userid);
                $storename = $_SESSION['shopname'];
                if (!empty($storename)) {
                    $shopsdet = $shopstable->find('all')->contain('Users')
                    ->where(['Users.user_level' => 'shop'])
                    ->where(['store_enable' => 'enable'])
                    ->where(['item_count >' => '0'])
                    ->where(['seller_status' => '1'])
                    ->where(['merchant_name LIKE' => '%' . $storename . '%'])
                    ->where(['store_enable' => 'enable'])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('Shops.user_id', '$userid');
                    })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit('10')->page($offset)->all();
                } else {
                    $shopsdet = $shopstable->find('all')->contain('Users')
                    ->where(['Users.user_level' => 'shop'])
                    ->where(['store_enable' => 'enable'])
                    ->where(['item_count >' => '0'])
                    ->where(['seller_status' => '1'])
                    ->where(['store_enable' => 'enable'])
                    ->where(function ($exp, $q) {
                        return $exp->notEq('Shops.user_id', '$userid');
                    })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit('10')->page($offset)->all();
                }
                $topshoparr = array();
                foreach ($shopsdet as $shopdata) {
                    $shopid = $shopdata['id'];
                    $itemcounts = $itemstable->find('all')->where(['Items.status' => 'publish'])->where(['Items.shop_id' => $shopid])->count();

                    $topshoparr[$skey]['shop_name'] = $shopdata['shop_name'];
                    $topshoparr[$skey]['shop_image'] = $shopdata['shop_image'];
                    $topshoparr[$skey]['shop_banner'] = $shopdata['shop_banner'];
                    $topshoparr[$skey]['merchant_name'] = $shopdata['merchant_name'];
                    $topshoparr[$skey]['shop_name_url'] = $shopdata['shop_name_url'];
                    $topshoparr[$skey]['item_count'] = $shopdata['item_count'];
                    $topshoparr[$skey]['user_id'] = $shopdata['user_id'];
                    $topshoparr[$skey]['id'] = $shopdata['id'];
                    $topshoparr[$skey]['wifi'] = $shopdata['wifi'];
                    $topshoparr[$skey]['follow_count'] = $shopdata['follow_count'];
                    $followcnt = $storefollowerstable->followcnt($loguser['id']);
                    $this->set('followcnt', $followcnt);
                    $topshoparr[$skey]['follow_shop'] = $flwrscnt;
                    $userid = $shopdata['user']['id'];

                    $skey += 1;
                        // /}
                }
                $this->set('followcnt', $followcnt);
                $this->set('shopsdet', $topshoparr);
            }

            public function livefeeds()
            {
                global $loguser;
                $userid = $loguser['id'];

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                $siteChanges = $setngs['site_changes'];
                $siteChanges = json_decode($siteChanges, true);

                $roundProf = "";
                if ($siteChanges['profile_image_view'] == "round") {
                    $roundProfile = "border-radius:50%;";
                } else {
                    $roundProfile = "border-radius:0 !important;";
                }
                $this->set('roundProf', $siteChanges['profile_image_view']);

                $itemstable = TableRegistry::get('Items');
                $commentstable = TableRegistry::get('Comments');
                $itemsfavstable = TableRegistry::get('Itemfavs');
                $followerstable = TableRegistry::get('Followers');
                $logstable = TableRegistry::get('Logs');
                $userstable = TableRegistry::get('Users');
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $shopstable = TableRegistry::get('Shops');
                $itemfavstable = TableRegistry::get('Itemfavs');
                $itemfavid = array();
                $userModel = $userstable->get($userid);


                $this->loadModel('Likedusers');
                $this->loadModel('Feedcomments');
                $liked_users = $this->Likedusers->find('all', array('conditions' => array('Likedusers.userid' => $userid)));
                foreach ($liked_users as $lusers) {
                    $logids[] = $lusers['statusid'];
                }
                $this->set('logids', $logids);
                $feedcommentstable = TableRegistry::get('Feedcomments');

                $feedcomments = $this->Feedcomments->find('all', array('group' => array('Feedcomments.statusid'), 'order' => 'Feedcomments.id desc'));
                foreach ($feedcomments as $fcomments) {
                    $logid = $fcomments['statusid'];
                    $statusids = $logid;
                    $feedcommentcount[$logid] = $feedcommentstable->find()->where(['statusid IN' => $statusids])->count();

                    $this->set('feedcommentcount', $feedcommentcount);
                    $comment_datas = $feedcommentstable->find()->contain('Users')->where(['statusid IN' => $statusids])
                    ->order(['Feedcomments.id DESC'])->limit(2)->all();
                    $i = 1;
                    foreach ($comment_datas as $comment) {
                        $commentid = $comment['id'];
                        $logid = $comment['statusid'];
                        $comments['Feedcomments'][$logid]['comments'][] = $comment['comments'];
                        $comments['Feedcomments'][$logid]['userid'][] = $comment['userid'];
                        $comments['Feedcomments'][$logid]['id'][] = $comment['id'];
                        $comments['Feedcomments'][$logid]['username'][] = $comment['user']['username'];
                        $comments['Feedcomments'][$logid]['username_url'][] = $comment['user']['username_url'];
                        $comments['Feedcomments'][$logid]['profile_image'][] = $comment['user']['profile_image'];
                        $i++;
                    }
                }

                $this->set('feedcomments', $comments);

                $query = $userstable->query();
                $query->update()
                ->set(['unread_livefeed_cnt' => "'0'"])
                ->where(['Users.id' => $userid])
                ->execute();

                $followcnt = $followerstable->followcnt($loguser['id']);
                if (!empty($followcnt)) {
                    foreach ($followcnt as $flcnt) {
                        $flwngusrids[] = $flcnt['user_id'];
                    }

                    $flwngusrids[] = $userid;
                } else {
                    $flwngusrids = $userid;
                }
                $userlevels = array('god', 'moderator');
                $people_details = $userstable->find('all')->where(['id NOT IN' => $flwngusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                    return $exp->notEq('activation', '0');
                })->order(['Users.id DESC'])->limit(5);


                $flwrscnt = $followerstable->find('all')->where(['follow_user_id' => $userid])->all();

                foreach ($flwrscnt as $flwr) {
                    $flwruserid[] = $flwr['user_id'];
                }
                $storeflwrscnt = $storefollowerstable->find('all')->where(['follow_user_id' => $userid])->all();
                foreach ($storeflwrscnt as $storeflwr) {
                    $flwshopid = $storeflwr['store_id'];
                    $shopModel = $shopstable->find('all')->where(['id' => $flwshopid])->first();
                    $storeflwruserid[] = $shopModel['user_id'];
                }
                if (empty($flwruserid)) {
                    $flwruserid = array();
                }
                if (empty($storeflwruserid)) {
                    $storeflwruserid = array();
                }
                $flwruserid = array_merge($storeflwruserid, $flwruserid);

                $notificationSettings = json_decode($userModel['push_notifications'], true);
                if ($notificationSettings['somone_cmnts_push'] == 1) {
                    $itemfav = $itemfavstable->find('all')->where(['user_id' => $userid])->all();
                    foreach ($itemfav as $fav) {
                        $itemfavid[] = $fav['item_id'];
                    }
                }
                $followType = 'additem';
                if ($notificationSettings['frends_cmnts_push'] == 0) {
                    $followType = array();
                    $followType[] = 'additem';
                    $followType[] = 'comment';
                }
                $addedItems = array();
                if ($notificationSettings['frends_flw_push'] == 1) {
                    $addedItems['userid IN'] = $flwruserid;
                    $addedItems['type'] = 'additem';
                }
                $typeAs[] = 'follow';
                $typeAs[] = 'review';
                $typeAs[] = 'groupgift';
                $typeAs[] = 'sellermessage';
                $typeAs[] = 'admin';
                $typeAs[] = 'dispute';
                $typeAs[] = 'orderstatus';
                $typeAs[] = 'ordermessage';
                $typeAs[] = 'itemapprove';
                $typeAs[] = 'chatmessage';
                $typeAs[] = 'invite';
                $typeAs[] = 'credit';
                $typeConditions['type NOT IN'] = $typeAs;
                if (!empty($flwruserid) && !empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)->order(['id DESC'])->limit(15)->all();

                } elseif (!empty($flwruserid)) {
                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)->order(['id DESC'])->limit(15)->all();


                } elseif (!empty($itemfavid)) {
                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['notifyto' => $userid],
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)->order(['id DESC'])->limit(15)->all();

                } else {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['notifyto' => $userid],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)->order(['id DESC'])->limit(15)->all();

                }


                $userDetails = $loguser;//$this->User->find('first',array('conditions' =>array('User.id' =>$userid)));
                $decoded_value = json_decode($userDetails['push_notifications']);

                $recentactivityType = array('comment', 'orderstatus', 'status', 'sellermessage');
                $recentactivity = $logstable->find('all')->where(['userid' => $userid])->where(['type IN' => $recentactivityType])->order(['id DESC'])->limit('5')->all();

                $userDetails = array();
                foreach ($recentactivity as $activity) {
                    $activityType = $activity['type'];
                    if ($activityType == 'follow') {
                        $followId = $activity['userid'];
                        $userDetails[$followId] = $userstable->get($followId);
                    }
                }

                $query = $userstable->query();
                $query->update()
                ->set(['unread_livefeed_cnt' => "'0'"])
                ->where(['Users.id' => $userid])
                ->execute();

                foreach ($userlogd as $logduser) {

                    //echo '<pre>'; print_r($userlogd); die;

                    $user_id = $logduser['userid'];
                    $logid = $logduser['id'];
                    $user_name1 = $userstable->find()->where(['id' => $user_id])->first();
                    $username1[$logid][$user_id]['username'] = $user_name1['username'];
                    $username1[$logid][$user_id]['username_url'] = $user_name1['username_url'];

                    $shareduserid = $logduser['shareduserid'];
                    $user_name2 = $userstable->find()->where(['id' => $shareduserid])->first();
                    $username2[$logid][$shareduserid]['username'] = $user_name2['username'];
                    $username2[$logid][$shareduserid]['username_url'] = $user_name2['username_url'];

                    $this->set('username1', $username1);
                    $this->set('username2', $username2);
                }

                $this->set('decoded_value', $decoded_value);
                $this->set('userid', $userid);
                $this->set('loguserdetails', $userlogd);
                $this->set('recentactivity', $recentactivity);
                $this->set('people_details', $people_details);
                $this->set('userDetails', $userDetails);
                $this->set('fantacy', $setngs[0]['Sitesetting']['liked_btn_cmnt']);
            }

            function likeStatus()
            {
                $this->autoRender = false;
                $this->loadModel('Likedusers');
                $this->loadModel('Logs');
                $logid = $_POST['logid'];
                global $loguser;
                $userid = $loguser['id'];
                $likeval = $_POST['likeval'];

                $likeduserstable = TableRegistry::get('Likedusers');

                $logstable = TableRegistry::get('Logs');
                $log_datas = $logstable->find()->where(['id' => $logid])->first();

                $logImage = json_decode($log_datas['image'], true);
                $count = $log_datas['likecount'];
                if ($likeval == "Like") {
                    $count = $count + 1;

                    $query = $logstable->query();
                    $query->update()
                    ->set(['likecount' => $count])
                    ->where(['id' => $logid])
                    ->execute();


                    $likedusers = $likeduserstable->newEntity();
                    $likedusers->userid = $userid;
                    $likedusers->statusid = $logid;
                    $likeduserstable->save($likedusers);
                    echo "Unlike" . " " . $count;

                    $notifyto = $log_datas['userid'];
                    $userstable = TableRegistry::get('Users');
                    $users = $userstable->find()->where(['id' => $notifyto])->first();
                    $notificationSettings = json_decode($users['push_notifications'], true);

                    $logusername = $loguser['username'];
                    $logfirstname = $loguser['first_name'];
                    $logusernameurl = $loguser['username_url'];
                    $itemname = $userdatasall['item_title'];
                    $item_url = base64_encode($itemid . "_" . rand(1, 9999));
                    $itemurl = $userdatasall['item_title_url'];
                    $liked = $setngs['liked_btn_cmnt'];
                    $userImg = $loguser['profile_image'];
                    if (empty($userImg)) {
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $image['item']['image'] = $userdatasall['photos'][0]['image_name'];
                    $image['item']['link'] = SITE_URL . "listing/" . $item_url;

                    $image['status']['image'] = $logImage['status']['image'];
                    $image['status']['message'] = $log_datas['message'];
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                    $productlink = "<a href='" . SITE_URL . "listing/" . $itemid . "/" . $itemurl . "'>" . $itemname . "</a>";
                    $notifymsg = $loguserlink . "  -___-liked your status-___- ";
                    if ($notifyto != $userid) {
                        $logdetails = $this->addloglive('favorite', $userid, $notifyto, $logid, $notifymsg, null, $loguserimage);

                        $userdevicestable = TableRegistry::get('Userdevices');
                        $userddett = $userdevicestable->find('all')->where(['user_id' => $notifyto])->all();

                        foreach ($userddett as $userdet) {
                            $deviceTToken = $userdet['deviceToken'];
                            $badge = $userdet['badge'];
                            $badge += 1;


                            $querys = $userdevicestable->query();
                            $querys->update()
                            ->set(['badge' => $badge])
                            ->where(['deviceToken' => $deviceTToken])
                            ->execute();

                            if (isset($deviceTToken)) {
                                $pushMessage['type'] = 'like_status';
                                $pushMessage['user_id'] = $loguser['id'];
                                $pushMessage['feed_id'] = $logid;
                                $pushMessage['user_name'] = $loguser['username'];
                                $pushMessage['user_image'] = $userImg;
                                $user_detail = TableRegistry::get('Users')->find()->where(['id' => $notifyto])->first();
                                I18n::locale($user_detail['languagecode']);
                                $pushMessage['message'] = __d('user', "liked your status");
                                $messages = json_encode($pushMessage);
                                $this->pushnot($deviceTToken, $messages, $badge);
                            }
                        }
                    }


                } else if ($likeval == "Unlike") {
                    $count = $count - 1;
                    $query = $logstable->query();
                    $query->update()
                    ->set(['likecount' => $count])
                    ->where(['id' => $logid])
                    ->execute();

                    $this->Likedusers->deleteAll(array('Likedusers.userid' => $userid, 'Likedusers.statusid' => $logid), false);
                    echo "Like" . " " . $count;
                }
            }

            function addfeedcomments()
            {
                global $loguser;
                global $setngs;
                $logusername = $loguser['username'];
                $this->autoRender = false;
                $this->loadModel('Feedcomments');
                $this->loadModel('Logs');



                $userid = $loguser['id'];
                $logid = $_REQUEST['logid'];
                $commentss = $_REQUEST['commentss'];
                $usedHashtags = $_REQUEST['hashtags'];
                $mentionedUsers = $_REQUEST['atusers'];
                $oldHashtags = array();
                $hashtagstable = TableRegistry::get('Hashtags');
                $feedcommentstable = TableRegistry::get('Feedcomments');
                $userstable = TableRegistry::get('Users');
                $logstable = TableRegistry::get('Logs');
                $logModel = $logstable->find()->where(['id' => $logid])->first();
                $logImage = json_decode($logModel['image'], true);

                $logImage = json_decode($logModel['image'], true);

                if ($usedHashtags != '') {
                    $hashTags = explode(',', $usedHashtags);
                    $hashtagsModel = $hashtagstable->find()->where(['hashtag IN' => $hashTags])->all();
                    if (!empty($hashtagsModel)) {
                        foreach ($hashtagsModel as $hashtags) {
                            $id = $hashtags['id'];
                            $count = $hashtags['usedcount'] + 1;

                            $query = $hashtagstable->query();
                            $query->update()
                            ->set(['usedcount' => $count])
                            ->where(['id' => $id])
                            ->execute();

                            $oldHashtags[] = $hashtags['hashtag'];
                        }
                    }
                    foreach ($hashTags as $hashtag) {
                        if (!in_array($hashtag, $oldHashtags)) {
                            $hash_tags = $hashtagstable->newEntity();
                            $hash_tags->hashtag = $hashtag;
                            $hash_tags->usedcount = 1;
                            $hashtagstable->save($hash_tags);
                        }
                    }
                }

                $feedcomments = $feedcommentstable->newEntity();
                $feedcomments->userid = $userid;
                $feedcomments->statusid = $logid;
                $feedcomments->comments = $commentss;
                $feed_comments = $feedcommentstable->save($feedcomments);
                $comment_id = $feed_comments->id;

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                if ($mentionedUsers != "") {
                    $mentionedUsers = explode(",", $mentionedUsers);
                    foreach ($mentionedUsers as $musers) {
                        $userModel = $userstable->find()->where(['username' => $musers])->first();
                        $unread_notify_cnt = $userModel['unread_livefeed_cnt'] + 1;
                        $query = $userstable->query();
                        $query->update()
                        ->set(['unread_livefeed_cnt' => $unread_notify_cnt])
                        ->where(['username' => $musers])
                        ->execute();

                        $notificationSettings = json_decode($userModel['push_notifications'], true);
                        $notifyto = $userModel['id'];
                        if ($notificationSettings['somone_mentions_push'] == 1 && $userid != $notifyto) {
                            $logusername = $loguser['username'];
                            $logfirstname = $loguser['first_name'];
                            $logusernameurl = $loguser['username_url'];
                            $liked = $setngs['liked_btn_cmnt'];
                            $userImg = $loguser['profile_image'];
                            if (empty($userImg)) {
                                $userImg = 'usrimg.jpg';
                            }
                            $image['user']['image'] = $userImg;
                            $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                            $image['status']['image'] = $logImage['status']['image'];
                            $image['status']['message'] = $logModel['message'];
                            $loguserimage = json_encode($image);
                            $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                            $loglink = "<a href='" . SITE_URL . "livefeed/" . $logid . "'>" . $logid . "</a>";
                            $notifymsg = $loguserlink . " -___-mentioned you in a livefeed status comment on : ";
                            $logdetails = $this->addloglive('mentioned', $userid, $notifyto, $comment_id, $notifymsg, $commentss, $loguserimage);

                            $userdevicestable = TableRegistry::get('Userdevices');
                            $userddett = $userdevicestable->find('all')->where(['user_id' => $notifyto])->all();

                            foreach ($userddett as $userdet) {
                                $deviceTToken = $userdet['deviceToken'];
                                $badge = $userdet['badge'];
                                $badge += 1;


                                $querys = $userdevicestable->query();
                                $querys->update()
                                ->set(['badge' => $badge])
                                ->where(['deviceToken' => $deviceTToken])
                                ->execute();

                                if (isset($deviceTToken)) {
                                    $pushMessage['type'] = 'mention_status_comment';
                                    $pushMessage['user_id'] = $loguser['id'];
                                    $pushMessage['feed_id'] = $comment_id;
                                    $pushMessage['user_name'] = $loguser['username'];
                                    $pushMessage['user_image'] = $userImg;
                                    $user_detail = TableRegistry::get('Users')->find()->where(['id' => $notifyto])->first();
                                    I18n::locale($user_detail['languagecode']);
                                    $pushMessage['message'] = __d('user', "mentioned you in a livefeed comment");
                                    $messages = json_encode($pushMessage);
                                    $this->pushnot($deviceTToken, $messages, $badge);
                                }
                            }


                        }
                    }
                }





                $log_datas = $logstable->find()->where(['id' => $logid])->first();
                $counts = $log_datas['commentcount'];
                $counts = $counts + 1;

                $logquery = $logstable->query();
                $logquery->update()
                ->set(['commentcount' => $counts])
                ->where(['id' => $logid])
                ->execute();


                echo $comment_id;

                $notifyto = $log_datas['userid'];
                $userstable = TableRegistry::get('Users');
                $users = $userstable->find()->where(['id' => $notifyto])->first();
                $notifycounts = $users['unread_livefeed_cnt'] + 1;

                $userquery = $userstable->query();
                $userquery->update()
                ->set(['unread_livefeed_cnt' => $notifycounts])
                ->where(['id' => $notifyto])
                ->execute();
                $notificationSettings = json_decode($users['push_notifications'], true);

                $logusername = $loguser['username'];
                $logfirstname = $loguser['first_name'];
                $logusernameurl = $loguser['username_url'];
                $itemname = $userdatasall['item_title'];
                $item_url = base64_encode($itemid . "_" . rand(1, 9999));
                $itemurl = $userdatasall['item_title_url'];
                $liked = $setngs['liked_btn_cmnt'];
                $userImg = $loguser['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $image['item']['image'] = $userdatasall['photos'][0]['image_name'];
                $image['item']['link'] = SITE_URL . "listing/" . $item_url;
                $image['status']['image'] = $logImage['status']['image'];
                $image['status']['message'] = $logModel['message'];
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                $productlink = "<a href='" . SITE_URL . "listing/" . $itemid . "/" . $itemurl . "'>" . $itemname . "</a>";
                $notifymsg = $loguserlink . "  -___-commented on your status-___- ";
                if ($notifyto != $userid) {
                    $logdetails = $this->addloglive('favorite', $userid, $notifyto, $logid, $notifymsg, null, $loguserimage);

                    $userdevicestable = TableRegistry::get('Userdevices');
                    $userddett = $userdevicestable->find('all')->where(['user_id' => $notifyto])->all();

                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge += 1;


                        $querys = $userdevicestable->query();
                        $querys->update()
                        ->set(['badge' => $badge])
                        ->where(['deviceToken' => $deviceTToken])
                        ->execute();

                        if (isset($deviceTToken)) {
                            $pushMessage['type'] = 'comment_status';
                            $pushMessage['user_id'] = $loguser['id'];
                            $pushMessage['feed_id'] = $logid;
                            $pushMessage['user_name'] = $loguser['username'];
                            $pushMessage['user_image'] = $userImg;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $notifyto])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "commented on your status");
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }
                }

            }

            function editfeedcommentsave()
            {
                $this->loadModel('Feedcomments');
                $cmtid = $_REQUEST['cmtid'];
                $cmntval = $_REQUEST['cmntval'];
                    //echo  $cmntval;
                $this->request->data['Feedcomments']['id'] = $cmtid;
                echo $this->request->data['Feedcomments']['comments'] = $cmntval;
                $this->Feedcomments->save($this->request->data);
                die;
            }

            function deletefeedcomments()
            {
                $this->autoRender = false;
                $cmtid = $_REQUEST['addid'];
                $logid = $_REQUEST['logid'];
                $this->loadModel('Feedcomments');
                $this->loadModel('Logs');

                $feedcommentstable = TableRegistry::get('Feedcomments');
                $logstable = TableRegistry::get('Logs');

                $commentquery = $feedcommentstable->query();
                $commentquery->delete()
                ->where(['id' => $cmtid])
                ->execute();


                $log_datas = $logstable->find()->where(['id' => $logid])->first();
                $counts = $counts - 1;

                $query = $logstable->query();
                $query->update()
                ->set(['commentcount' => $counts])
                ->where(['id' => $logid])
                ->execute();

            }

            function sharefeed()
            {
                $this->autoRender = false;
                $logid = $_REQUEST['logid'];
                $this->loadModel('Logs');
                global $loguser;
                $userid = $loguser['id'];

                $logstable = TableRegistry::get('Logs');
                $log_data = $logstable->find()->where(['Logs.id' => $logid])->first();
                $this->set('log_data', $log_data);
                $logImage = json_decode($log_data['image'], true);
                $loguserid = $log_data['userid'];
                $sourceid = $log_data['sourceid'];
                $notifymessage = $log_data['notifymessage'];
                $message = $log_data['message'];
                $image = $log_data['image'];
                $shared = $log_data['shared'];
                $shareduserid = $log_data['shareduserid'];

                $logs = $logstable->newEntity();
                $logs->type = 'status';
                $logs->userid = $userid;
                $logs->sourceid = $sourceid;
                $logs->itemid = '0';
                $logs->notifyto = '0';
                $logs->notifymessage = $notifymessage;
                $logs->notification_id = '0';
                $logs->message = $message;
                $logs->image = $image;
                $logs->cdate = time();

                $notifyto = $log_data['userid'];
                $userstable = TableRegistry::get('Users');
                $users = $userstable->find()->contain('Shops')->where(['Users.id' => $notifyto])->first();

                $logusername = $loguser['username'];
                $logfirstname = $loguser['first_name'];
                $logusernameurl = $loguser['username_url'];

                $log_image['status']['image'] = $logImage['status']['image'];
                $log_image['status']['message'] = $log_data['message'];
                $loguserimage = json_encode($log_image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                $notifymsg = $loguserlink . "  -___-shared your status-___- ";
                if ($notifyto != $userid) {
                    $logdetails = $this->addloglive('favorite', $userid, $notifyto, $logid, $notifymsg, null, $loguserimage);
                }

                $notifymsg1 = $loguserlink . "  -___-shared the status-___- " . $logid;
                $logdetails1 = $this->addloglive('favorite', $userid, 0, $logid, $notifymsg1, null, 0);

                $followerstable = TableRegistry::get('Followers');
                $storefollowerstable = TableRegistry::get('Storefollowers');
                $flwrscnt = $followerstable->flwrscnt($userid);
                $flwrusrids = array();
                if (!empty($flwrscnt)) {
                    foreach ($flwrscnt as $flwss) {
                        $flwrusrids[$flwss['follow_user_id']] = $flwss['follow_user_id'];
                    }
                }

                $storeflwrscnt = $storefollowerstable->flwrscnt($users['shop']['id']);
                $storeflwrusrids = array();
                if (!empty($storeflwrscnt)) {
                    foreach ($storeflwrscnt as $storeflwss) {
                        $storeflwrusrids[$storeflwss['follow_user_id']] = $storeflwss['follow_user_id'];
                    }
                }
                $flwssuserids = array_merge($storeflwrusrids, $flwrusrids);
                foreach ($flwssuserids as $flwww) {
                    $useriddd = $flwww;
                    $userdevicestable = TableRegistry::get('Userdevices');
                    $userddett = $userdevicestable->find('all')->where(['user_id' => $useriddd])->all();
                    if (!empty($userddett)) {
                        foreach ($userddett as $userdet) {
                            $deviceTToken = $userdet['deviceToken'];
                            $badge = $userdet['badge'];
                            $badge += 1;


                            $querys = $userdevicestable->query();
                            $querys->update()
                            ->set(['badge' => $badge])
                            ->where(['deviceToken' => $deviceTToken])
                            ->execute();
                            if (isset($deviceTToken)) {
                                $pushMessage['type'] = 'share_status';
                                $pushMessage['user_id'] = $loguser['id'];
                                $pushMessage['feed_id'] = $logid;
                                $pushMessage['user_name'] = $loguser['username'];
                                $pushMessage['user_image'] = $userImg;
                                $user_detail = TableRegistry::get('Users')->find()->where(['id' => $useriddd])->first();
                                I18n::locale($user_detail['languagecode']);
                                $pushMessage['message'] = __d('user', "shared the status");
                                $messages = json_encode($pushMessage);
                                $this->pushnot($deviceTToken, $messages, $badge);
                            }
                        }
                    }
                }


                $userdevicestable = TableRegistry::get('Userdevices');
                $userddett = $userdevicestable->find('all')->where(['user_id' => $notifyto])->all();

                foreach ($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge += 1;


                    $querys = $userdevicestable->query();
                    $querys->update()
                    ->set(['badge' => $badge])
                    ->where(['deviceToken' => $deviceTToken])
                    ->execute();

                    if (isset($deviceTToken)) {
                        $pushMessage['type'] = 'share_status';
                        $pushMessage['user_id'] = $loguser['id'];
                        $pushMessage['feed_id'] = $logid;
                        $pushMessage['user_name'] = $loguser['username'];
                        $pushMessage['user_image'] = $userImg;
                        $user_detail = TableRegistry::get('Users')->find()->where(['id' => $notifyto])->first();
                        I18n::locale($user_detail['languagecode']);
                        $pushMessage['message'] = __d('user', "shared your status");
                        $messages = json_encode($pushMessage);
                        $this->pushnot($deviceTToken, $messages, $badge);
                    }
                }


                if (isset($shared) && $shared != '0') {
                    $alreadysharedlog = $logstable->find()->where(['userid' => $userid])->where(['shared' => $shared])->where(['shareduserid' => $shareduserid])->count();
                    if ($alreadysharedlog > 0)
                        $logs->shareagain = "1";
                    $logs->shared = $shared;
                    $logs->shareduserid = $shareduserid;
                } else {
                    $alreadyshared = $logstable->find()->where(['userid' => $userid])->where(['shared' => $logid])->where(['shareduserid' => $loguserid])->count();
                    if ($alreadyshared > 0)
                        $logs->shareagain = "1";
                    $logs->shared = $logid;
                    $logs->shareduserid = $loguserid;
                }
                $logstable->save($logs);



            }

            function listlikedusers()
            {
                $logid = $_POST['logid'];
                $this->loadModel('Likedusers');
                $this->loadModel('Follower');
                $this->autoLayout = false;
                $this->autoRender = false;
                global $loguser;
                $userid = $loguser[0]['User']['id'];

                global $siteChanges;

                $roundProf = "";
                if ($siteChanges['profile_image_view'] == "round") {
                    $roundProfile = "border-radius:50%;";
                } else {
                    $roundProfile = "border-radius:0 !important;";
                }

                $likedusers = $this->Likedusers->find('all', array('conditions' => array('Likedusers.statusid' => $logid)));
                if (!empty($likedusers)) {
                    echo '<ul>';
                    foreach ($likedusers as $people) {

                        echo "<li class='whouser" . $people["User"]["id"] . " list" . $key . "' style='height:auto;overflow:hidden;padding-bottom:15px;'>";
                        echo "<div class='whotofollow'>";
                        echo " <a class='col-lg-8 no-padding' href='" . SITE_URL . "people/" . $people["User"]["username_url"] . "' title='" . $people["User"]["username"] . "'>";
                        echo "<div class='whotofollow-img col-lg-4 no-padding'>";
                        if (!empty($people["User"]["profile_image"])) {
                            echo "<img style='width: 70px;$roundProfile' src='" . $_SESSION['media_url'] . "media/avatars/thumb70/" . $people["User"]["profile_image"] . "' />";
                        } else {
                            echo "<img src='" . $_SESSION['media_url'] . "media/avatars/thumb70/usrimg.jpg' style='width: 70px;" . $roundProfile . "' />";
                        }
                        echo "</div>";
                        echo "<div class='whotofollow-info col-lg-8'>";
                        echo "<p class='user' style='line-height:15px;margin-top:20px;'>" . $people["User"]["username"] . "</p>";
                        echo "</div>";
                        echo "</a>";
                        echo "<div class='whotofollow-btns'>";
                        $followcnt = $this->Follower->followcnt($loguser[0]['User']['id']);
                        $this->set('followcnt', $followcnt);
                        foreach ($followcnt as $flcnt) {
                            $flwrcntid[] = $flcnt['Follower']['user_id'];
                        }
                        if ($userid != $people['User']['id']) {
                            if (isset($flwrcntid) && in_array($people['User']['id'], $flwrcntid)) {
                                $flw = false;
                            } else {
                                $flw = true;
                            }


                            if ($flw) {
                                ?>
                                <span class='follow' id='foll<?php echo $ppls['User']['id']; ?>'>
                                    <div class="follow-tab col-lg-3 col-md-3 profilImgName">
                                        <a class="btn-blue col-lg-12 col-md-12 follow-btn" id="follow_btn<?php echo $ppls['User']['id']; ?>" onclick="getfollows('<?php echo $ppls['User']['id']; ?>')" style="margin: 0;"><?php echo __("Follow"); ?></a>
                                    </div>
                                </span>
                                <?php

                            } else {
                                ?>
                                <span class='follow' id='unfoll<?php echo $ppls['User']['id']; ?>'>
                                    <div class="follow-tab col-lg-3 col-md-3 profilImgName">
                                        <a class="btn-green col-lg-12 col-md-12 follow-btn" id="unfollow_btn<?php echo $ppls['User']['id']; ?>" onclick="deletefollows('<?php echo $ppls['User']['id']; ?>')" style="margin: 0;"><?php echo __("Following"); ?></a>
                                    </div>
                                </span>
                                <?php

                            }
                            echo '<span id="mainchangebtn' . $people['User']['id'] . '" ></span>';
                        }
                        echo "</div>";
                        echo '</div>';
                        echo "</li>";
                    }
                    echo '</ul>';
                } else {
                    echo '<div style="text-align:center;">Be the first one to like this</div>';
                }
            }

            function loadmorefeedcomments()
            {
                $this->loadModel('Feedcomments');
                $this->autoLayout = false;
                $this->autoRender = false;
                $logid = $_POST['logid'];
                $offset = ($_POST['offset'] / 2) + 1;
                global $loguser;
                $userid = $loguser['id'];

                global $siteChanges;
                $roundProf = "";

                $feedcommentstable = TableRegistry::get('Feedcomments');

                $sitesettings = TableRegistry::get('sitesettings')->find('all')->first();
                $siteChanges = json_decode($sitesettings->site_changes, true);

                if ($siteChanges['profile_image_view'] == "round") {
                    $roundProfile = "border-radius:50%;";
                } else {
                    $roundProfile = "border-radius:0 !important;";
                }
                $this->set('roundProf', $siteChanges['profile_image_view']);


                $comment_datas = $feedcommentstable->find()->where(['statusid' => $logid])->order(['Feedcomments.id DESC'])->limit(2)->page($offset)->all();
                $i = 1;
                foreach ($comment_datas as $comment) {
                    $commentid = $comment['id'];
                    $logid = $comment['statusid'];
                    $comments['Feedcomments'][$logid]['comments'][] = $comment['comments'];
                    $comments['Feedcomments'][$logid]['userid'][] = $comment['userid'];
                    $comments['Feedcomments'][$logid]['id'][] = $comment['id'];
                    $comments['Feedcomments'][$logid]['username'][] = $comment['user']['username'];
                    $comments['Feedcomments'][$logid]['username_url'][] = $comment['user']['username_url'];
                    $comments['Feedcomments'][$logid]['profile_image'][] = $comment['user']['profile_image'];
                    $i++;
                }
                foreach ($comments as $fcomment) {
                    for ($i = 0; $i < count($fcomment[$logid]['comments']); $i++) {
                        $commentusername = $fcomment[$logid]['username'][$i];
                        $commentusernameurl = $fcomment[$logid]['username_url'][$i];
                        $comments = $fcomment[$logid]['comments'][$i];
                        $commentid = $fcomment[$logid]['id'][$i];
                        $commentuserid = $fcomment[$logid]['userid'][$i];
                        $profileimage = $fcomment[$logid]['profile_image'][$i];
                        $pattern = '/<a[^<>]*?[^<>]*?>(.*?)<\/a>/';
                        $atuserPattern = '/<span[^<>]*?[^<>]*?>(.@?)<\/span>/';
                        $hashPattern = '/<span[^<>]*?[^<>]*?>(.*#)<\/span>/';

                        echo '<div class="comment-row row hor-padding status-cmnt comment delecmt_' . $commentid . ' commentli" commid="' . $commentid . '">

                        <div class="live_feeds_logo1 padding_right0_rtl col-xs-3 col-lg-2 padding-right0 padding-left0 image_center_mobile">

                        <div class="live_feeds_logo" style="background-image:url(' . SITE_URL . 'media/avatars/thumb70/' . $profileimage . ');background-repeat:no-repeat;"></div>

                        </div>
                        <div class="comment-section col-xs-9 col-lg-10 padding-right0 border_bottom_grey padding-bottom10">
                        <div class="bold-font comment-name">' . $commentusername . '</div>

                        <div class="margin-top10 comment-txt regular-font font_size13">
                        ' . $comments . '
                        </div>

                        <div id="oritextvalafedit' . $commentid . '"></div>
                        <div class="comment-autocompleteN' . $commentid . '" style="display: none;left:43px;width:548px;">
                        <ul class="usersearch dropdown-menu minwidth_33 padding-bottom0 padding-top0">
                        </ul>
                        </div>';

                        if ($commentuserid == $userid) {
                            echo '<div class="comment-edit-cnt c-reply col-lg-12 no-hor-padding margin-top10">

                            <a class="comment-delete red-txt" href="javascript:void(0);" onclick = "return deletefeedcmnt(' . $commentid . ',' . $logId . ')">';
                            echo __d('user', 'Delete');
                            echo '</a>
                            </div>';
                        }

                        echo '</div>
                        </div>';
                    }
                }
            }

            public function deletestatus()
            {
                global $loguser;
                $logusername = $loguser['username'];
                $logusrid = $loguser['id'];
                $this->autoRender = false;

                $logstable = TableRegistry::get('Logs');
                $followerstable = TableRegistry::get('Followers');
                $userstable = TableRegistry::get('Users');
                $commentstable = TableRegistry::get('Comments');
                $hashtagstable = TableRegistry::get('Hashtags');

                $logId = $_POST['postid'];


                $itemid = $_REQUEST['itemid'];
                if (!empty($_REQUEST['hashtags'])) {
                    $hashtags = explode(',', $_REQUEST['hashtags']);
                    $deletedTags = $hashtagstable->find('all')->where(['hashtag IN' => $hashtags])->all();

                    foreach ($deletedTags as $deleted) {
                        $id = $deleted['id'];
                        $count = $deleted['usedcount'] - 1;
                        $query = $hashtagstable->query();
                        $query->update()
                        ->set(['usedcount' => "'$count'"])
                        ->where(['id' => $id])
                        ->execute();

                    }
                }

                $flwrscnt = $followerstable->flwrscnt($logusrid);
                $flwrusrids = array();
                if (!empty($flwrscnt)) {
                    foreach ($flwrscnt as $flwss) {
                        $flwrusrids[$flwss['follow_user_id']] = $flwss['follow_user_id'];
                    }
                }

                $logModel = $logstable->find('all')->where(['id' => $logId])->first();
                $logimage = json_decode($logModel['image'], true);
                if (isset($logimage['status'])) {
                    unlink(WEBROOT_PATH . 'media/status/original/' . $logimage['status']['image']);
                    unlink(WEBROOT_PATH . 'media/status/thumb70/' . $logimage['status']['image']);
                    unlink(WEBROOT_PATH . 'media/status/thumb150/' . $logimage['status']['image']);
                    unlink(WEBROOT_PATH . 'media/status/thumb350/' . $logimage['status']['image']);
                }
                $commentId = $logModel['sourceid'];

                $commentquery = $commentstable->query();
                $commentquery->delete()
                ->where(['id' => $commentId])
                ->execute();

                $logquery = $logstable->query();
                $logquery->delete()
                ->where(['id' => $logId])
                ->execute();
            }

            public function statusfileupload()
            {
                $this->autoRender = false;
                global $loguser;
                $userid = $loguser['id'];
                if (0 < $_FILES['file']['error']) {
                    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
                }
                $ftmp = $_FILES['file']['tmp_name'];
                $oname = $_FILES['file']['name'];
                $fname = $_FILES['file']['name'];
                $fsize = $_FILES['file']['size'];
                $ftype = $_FILES['file']['type'];
                /*
                $ext = strrchr($oname, '.');
                $user_image_path = "media/status/";
                $newname = time() . '_' . $userid . $ext;
                $newimage = $user_image_path . $newname;
                $finalPath = $user_image_path . "original/";
                $result = move_uploaded_file($ftmp, $finalPath . $newname);
            echo $newname;//echo "<pre>";print_r($_FILES);
            */
                $appImageValues = getimagesize($ftmp); 
                $extensionarray = array('.jpg', '.png', '.jpeg');
                $imageSize = (trim($fsize) / 1024) / 1024;
                $ext = strrchr(trim($oname), '.');   

                if (trim($_POST['shareMap']) == "Sh@^*M@#" || ($appImageValues[0] > 0 && $appImageValues[1] > 0 && count($appImageValues) >= 6 && in_array($ext, $extensionarray) && $imageSize < 2 && (end($appImageValues) == "image/jpeg" || end($appImageValues) == "image/png"))) {   

                    $user_image_path = "media/status/";
                    $newname = time() . '_' . $userid . $ext;
                    $newimage = $user_image_path . $newname;
                    $finalPath = $user_image_path . "original/";
                    $result = move_uploaded_file($ftmp, $finalPath . $newname);
                    echo $newname;
                } else {  
                    echo 'Error: Please upload only jpg, jpeg and png images <br>';
                }
        }

        public function poststatus()
        {
            global $loguser;
            $logusername = $loguser['username'];
            $logusrid = $loguser['id'];
            $this->autoRender = false;

            $logstable = TableRegistry::get('Logs');
            $followerstable = TableRegistry::get('Followers');
            $hashtagstable = TableRegistry::get('Hashtags');
            $commentstable = TableRegistry::get('Comments');
            $storefollowerstable = TableRegistry::get('Storefollowers');
            $userstable = TableRegistry::get('Users');

            $usedHashtags = $_REQUEST['hashtags'];
            $oldHashtags = array();

            if ($usedHashtags != '') {
                $hashTags = explode(',', $usedHashtags);
                $hashtagsModel = $hashtagstable->find('all')->where(['hashtag IN' => $hashTags])->all();

                if (!empty($hashtagsModel)) {
                    foreach ($hashtagsModel as $hashtags) {
                        $id = $hashtags['id'];
                        $count = $hashtags['usedcount'] + 1;
                        $query = $hashtagstable->query();
                        $query->update()
                        ->set(['usedcount' => "'$count'"])
                        ->where(['id' => $id])
                        ->execute();

                        $oldHashtags[] = $hashtags['hashtag'];
                    }
                }
                foreach ($hashTags as $hashtag) {
                    if (!in_array($hashtag, $oldHashtags)) {
                        $hashTags = $hashtagstable->newEntity();
                        $hashTags->hashtag = $hashtag;
                        $hashTags->usedcount = 1;
                        $hashtagstable->save($hashTags);
                    }
                }
            }

            $statusimage = $_REQUEST['image'];
            $postmessage = $_REQUEST['postmessage'];

            $logusers = $userstable->find('all')->where(['id' => $logusrid])->first();

            $commentsdatas = $commentstable->newEntity();
            $commentsdatas->user_id = $logusrid;
            $commentsdatas->item_id = "-1";
            $commentsdatas->comments = $postmessage;
            $commentsdatas->created_on = date("Y-m-d H:i:s");
            $result = $commentstable->save($commentsdatas);


            $comment_id = $result->id;
            $logusernameurl = $loguser['username_url'];
            $logfirstname = $loguser['first_name'];
            $userImg = $logusers['profile_image'];
            if (empty($userImg)) {
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
            if ($statusimage != '') {
                $image['status']['image'] = $statusimage;
                $image['status']['link'] = '';
            }
            $loguserimage = json_encode($image);



            $flwrscnt = $followerstable->flwrscnt($logusrid);
            $flwrusrids = array();
            if (!empty($flwrscnt)) {
                foreach ($flwrscnt as $flwss) {
                    $flwrusrids[$flwss['follow_user_id']] = $flwss['follow_user_id'];
                }
            }



            $storeflwrscnt = $storefollowerstable->flwrscnt($userModel['shop_id']);
            $storeflwrusrids = array();
            if (!empty($storeflwrscnt)) {
                foreach ($storeflwrscnt as $storeflwss) {
                    $storeflwrusrids[$storeflwss['follow_user_id']] = $storeflwss['follow_user_id'];
                }
            }

            $flwssuserids = array_merge($storeflwrusrids, $flwrusrids);

            $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
            $notifymsg = $loguserlink . " -___-posted a status";
            $logdetails = $this->addloglive('status', $logusrid, $flwssuserids, $comment_id, $notifymsg, $postmessage, $loguserimage);

            $userlogd = $logstable->find('all')->where(['userid' => $logusrid])
            ->where(['type' => 'status'])->order(['id DESC'])->limit(1)->all();



            foreach ($flwssuserids as $flwww) {
                $useriddd = $flwww;


                $userdata = $userstable->find()->where(['id' => $useriddd])->first();
                $unread_notify_cnt = $userdata['unread_livefeed_cnt'] + 1;
                $query = $userstable->query();
                $query->update()
                ->set(['unread_livefeed_cnt' => $unread_notify_cnt])
                ->where(['id' => $useriddd])
                ->execute();


                $userdevicestable = TableRegistry::get('Userdevices');
                $userddett = $userdevicestable->find('all')->where(['user_id' => $useriddd])->all();
                if (!empty($userddett)) {
                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge += 1;


                        $querys = $userdevicestable->query();
                        $querys->update()
                        ->set(['badge' => $badge])
                        ->where(['deviceToken' => $deviceTToken])
                        ->execute();
                        if (isset($deviceTToken)) {
                            $pushMessage['type'] = 'post_status';
                            $pushMessage['user_id'] = $loguser['id'];
                            $pushMessage['feed_id'] = $comment_id;
                            $pushMessage['user_name'] = $loguser['username'];
                            $pushMessage['user_image'] = $userImg;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $useriddd])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "posted a status");
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }
                }
            }



            $mentionedUsers = $_REQUEST['atusers'];

            if ($mentionedUsers != "") {
                $mentionedUsers = explode(",", $mentionedUsers);
                foreach ($mentionedUsers as $musers) {
                    $userModel = $userstable->find()->where(['username' => $musers])->first();
                    $unread_notify_cnt = $userModel['unread_livefeed_cnt'] + 1;
                    $query = $userstable->query();
                    $query->update()
                    ->set(['unread_livefeed_cnt' => $unread_notify_cnt])
                    ->where(['username' => $musers])
                    ->execute();

                    $notificationSettings = json_decode($userModel['push_notifications'], true);
                    $notifyto = $userModel['id'];
                    if ($notificationSettings['somone_mentions_push'] == 1 && $userid != $notifyto) {
                        $logusername = $loguser['username'];
                        $logfirstname = $loguser['first_name'];
                        $logusernameurl = $loguser['username_url'];
                        $liked = $setngs['liked_btn_cmnt'];
                        $userImg = $loguser['profile_image'];
                        if (empty($userImg)) {
                            $userImg = 'usrimg.jpg';
                        }
                        $image['user']['image'] = $userImg;
                        $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                        $loguserimage = json_encode($image);
                        $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                        $notifymsg = $loguserlink . " -___-mentioned you in a livefeed status";
                        $logdetails = $this->addloglive('mentioned', $logusrid, $notifyto, $comment_id, $notifymsg, $postmessage, $loguserimage);

                        $userdevicestable = TableRegistry::get('Userdevices');
                        $userddett = $userdevicestable->find('all')->where(['user_id' => $notifyto])->all();

                        foreach ($userddett as $userdet) {
                            $deviceTToken = $userdet['deviceToken'];
                            $badge = $userdet['badge'];
                            $badge += 1;


                            $querys = $userdevicestable->query();
                            $querys->update()
                            ->set(['badge' => $badge])
                            ->where(['deviceToken' => $deviceTToken])
                            ->execute();

                            if (isset($deviceTToken)) {
                                $pushMessage['type'] = 'mention_status';
                                $pushMessage['user_id'] = $loguser['id'];
                                $pushMessage['feed_id'] = $comment_id;
                                $pushMessage['user_name'] = $loguser['username'];
                                $pushMessage['user_image'] = $userImg;
                                $user_detail = TableRegistry::get('Users')->find()->where(['id' => $notifyto])->first();
                                I18n::locale($user_detail['languagecode']);
                                $pushMessage['message'] = __d('user', "mentioned you in the status");
                                $messages = json_encode($pushMessage);
                                $this->pushnot($deviceTToken, $messages, $badge);
                            }
                        }

                    }
                }
            }

            $this->set('decoded_value', $decoded_value);
            $this->set('userid', $logusrid);
            $this->set('loguserdetails', $userlogd);
            $this->set('newstatus', 1);
            $this->set('result', 'livefeeds');
            $this->render('getmorefeeds');
        }

        public function getmorefeeds($status = null)
        {
            global $loguser;
            $userid = $loguser['id'];

            $itemstable = TableRegistry::get('Items');
            $commentstable = TableRegistry::get('Comments');
            $itemfavstable = TableRegistry::get('Itemfavs');
            $followerstable = TableRegistry::get('Followers');
            $storefollowerstable = TableRegistry::get('Storefollowers');
            $logstable = TableRegistry::get('Logs');
            $userstable = TableRegistry::get('Users');

            $itemfavid = array();

            $offset = $_GET['startIndex'];
            $offset = $offset / 15;
            $offset = $offset + 1;
            $userModel = $userstable->find('all')->where(['id' => $userid])->first();

            $followcnt = $followerstable->followcnt($loguser['id']);
            if (!empty($followcnt)) {
                foreach ($followcnt as $flcnt) {
                    $flwngusrids[] = $flcnt['user_id'];
                }

                $flwngusrids[] = $userid;
            } else {
                $flwngusrids = $userid;
            }
            $userlevels = array('god', 'moderator');
            $people_details = $userstable->find('all')->where(['id NOT IN' => $flwngusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                return $exp->notEq('activation', '0');
            })->order(['Users.id DESC'])->limit(5);

            $flwrscnt = $followerstable->find('all')->where(['follow_user_id' => $userid])->first();

            foreach ($flwrscnt as $flwr) {
                $flwruserid[] = $flwr['user_id'];
            }

            $notificationSettings = json_decode($userModel['push_notifications'], true);
            if ($notificationSettings['somone_cmnts_push'] == 1) {
                $itemfav = $itemfavstable->find('all')->where(['user_id' => $userid])->all();
                foreach ($itemfav as $fav) {
                    $itemfavid[] = $fav['item_id'];
                }
            }
            $followType = 'additem';
            if ($notificationSettings['frends_cmnts_push'] == 0) {
                $followType = array();
                $followType[] = 'additem';
                $followType[] = 'comment';
            }
            $addedItems = array();
            if ($notificationSettings['frends_flw_push'] == 1) {
                $addedItems['userid IN'] = $flwruserid;
                $addedItems['type'] = 'additem';
            }

            if ($status == 'livefeeds') {
                $typeAs[] = 'follow';
                $typeAs[] = 'favorite';
                $typeAs[] = 'admin';
                $typeAs[] = 'dispute';
                $typeAs[] = 'orderstatus';
                $typeAs[] = 'ordermessage';
                $typeAs[] = 'itemapprove';
                $typeAs[] = 'chatmessage';
                $typeAs[] = 'invite';
                $typeAs[] = 'credit';
                $typeConditions['type NOT IN'] = $typeAs;
            } else {
                $typeAs[] = 'comment';
                $typeAs[] = 'mentioned';
                $typeAs[] = 'status';
                $typeAs[] = 'additem';
                $typeAs[] = 'sellermessage';
                $typeConditions['type NOT IN'] = $typeAs;
            }


            $adminnotify = array('0', $userid);
            if ($userModel['user_level'] == 'shops') {

                if (!empty($flwruserid) && !empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['OR' => ['type' => 'admin', 'type' => 'admincommission'], 'notifyto IN' => $adminnotify, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit(15)->page($offset)->all();


                } elseif (!empty($flwruserid)) {

                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['OR' => ['type' => 'admin', 'type' => 'admincommission'], 'notifyto IN' => $adminnotify, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit(15)->page($offset)->all();

                } elseif (!empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            ['OR' => ['type' => 'admin', 'type' => 'admincommission'], 'notifyto IN' => $adminnotify, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit(15)->page($offset)->all();

                } else {
                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['notifyto' => $userid],
                            ['OR' => [['type' => 'admin'], ['type' => 'admincommission']], 'notifyto IN' => $adminnotify, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit(15)->page($offset)->all();
                }

            } else {

                if (!empty($flwruserid) && !empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['type' => 'admin', 'notifyto IN' => $adminnotify],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit(15)->page($offset)->all();

                } elseif (!empty($flwruserid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['type' => 'admin', 'notifyto IN' => $adminnotify],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit(15)->page($offset)->all();

                } elseif (!empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            ['type' => 'admin', 'notifyto IN' => $adminnotify],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->order(['id DESC'])->limit(15)->page($offset)->all();

                } else {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['notifyto' => $userid],
                            ['type' => 'admin', 'notifyto IN' => $adminnotify],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit(15)->page($offset)->all();

                }

            }

            $userDetails = $loguser;//$this->User->find('first',array('conditions' =>array('User.id' =>$userid)));
            $decoded_value = json_decode($userDetails['push_notifications']);

            $recentactivityType = array('comment', 'orderstatus', 'status', 'sellermessage');
            $recentactivity = $logstable->find('all')->where(['userid' => $userid])->where(['type IN' => $recentactivityType])->order(['id DESC'])->limit('5')->all();
            $userDetails = array();
            foreach ($recentactivity as $activity) {
                $activityType = $activity['type'];
                if ($activityType == 'follow') {
                    $followId = $activity['userid'];
                    $userDetails[$followId] = $userstable->get($followId);
                }
            }

            $query = $userstable->query();
            $query->update()
            ->set(['unread_livefeed_cnt' => "'0'"])
            ->where(['Users.id' => $userid])
            ->execute();

            $this->set('decoded_value', $decoded_value);
            $this->set('userid', $userid);
            $this->set('loguserdetails', $userlogd);
            $this->set('recentactivity', $recentactivity);
            $this->set('people_details', $people_details);
            $this->set('userDetails', $userDetails);
            $this->set('fantacy', $setngs[0]['Sitesetting']['liked_btn_cmnt']);
            $this->set('result', $status);
        }

        public function createGroupGift($details)
        {
            global $loguser;
            $detail = base64_decode($details);
            $detarr = explode('-_-', $detail);
            $countriestable = TableRegistry::get('Countries');
            $itemstable = TableRegistry::get('Items');
            $contry_datas = $countriestable->find('all')->all();
            $itemdata = $itemstable->find('all')->contain('Photos')->contain('Shipings')->contain('Forexrates')->where(['Items.id' => $detarr[0]])->first();
            $possibleCountry = array();
            foreach ($itemdata['shipings'] as $shipping) {
                $possibleCountry[] = $shipping['country_id'];
            }

            if ($detarr[1] == 'undefined')
                $sizeset = '0';
            else
                $sizeset = '1';
            $this->set('sizeset', $sizeset);
            $this->set('possibleCountry', $possibleCountry);
            $this->set('contry_datas', $contry_datas);
            $this->set('detarr', $detarr);
            $this->set('loguser', $loguser);
            $this->set('itemdata', $itemdata);
            $currency = $itemdata['currencyid'];
            $forexratestable = TableRegistry::get('Forexrates');
            $forexrateModel = $forexratestable->find()->where(['id' => $currency])->first();
            $item_rate = $forexrateModel['price'];
            $this->set('itemrate', $item_rate);

        }

        public function ajaxUserAutogroupgift()
        {
            $this->autoRender = false;

            $userstable = TableRegistry::get('Users');
            $itemstable = TableRegistry::get('Items');

            $searchWord = $_POST['searchStr'];
            global $loguser;
            $loguserid = $loguser['id'];
            $userContent = '';
            $userDetails = $userstable->find('all')->where(['username LIKE' => $searchWord . '%'])
            ->where(['id <>' => $loguserid])
            ->where(function ($exp, $q) {
                return $exp->notEq('user_level', 'god')
                ->notEq('user_level', 'moderator')
                ->notEq('id', '$loguserid');
            })->limit(5)->all();

            if (count($userDetails) > 0) {
                $k = 0;
                foreach ($userDetails as $userData) {
                    $usernameurl = $userData['username_url'];
                    $usernam = $userData['username'];
                    $userimg = $userData['profile_image'];
                    $userselid = $userData['id'];
                    $useremail = $userData['email'];
                    if (empty($userimg)) {
                        $userimg = "usrimg.jpg";
                    } else {
                        $userimg = $userimg;
                    }
                    $url = SITE_URL . 'people/' . $usernameurl;

                    if ($userContent == '') {
                        $userContent = "<li class='usernamegroup'><a><img style='top:5px;' class='photo' src='" . $_SESSION['media_url'] . "media/avatars/thumb70/" . $userimg . "'  ><input type='hidden' class = 'userselid " . $usernameurl . "'  value='" . $userselid . "' /><input type='hidden' class = 'nam'  value='" . $usernam . "' /><span class='usernamegroup'  $usernameurl='$userselid' >" . $usernameurl . "</span></a></li>";


                    } else {
                        $userContent = $userContent . "<li class='usernamegroup'><a><img style='top:5px;' class='photo' src='" . $_SESSION['media_url'] . "media/avatars/thumb70/" . $userimg . "'><input type='hidden' class = 'userselid " . $usernameurl . "'  value='" . $userselid . "' /><input type='hidden' class = 'nam'  value='" . $usernam . "' /><span class='usernamegroup'  $usernameurl='$userselid' >" . $usernameurl . "</span></a></li>";

                    }
                    $k++;
                    $this->set('userDetails', $userDetails);
                    $this->set('userselid', $userselid);
                }
            } else {
                $userContent = "No Data";
            }
            $json = array();
            $json[] = $userContent;
            $json[] = $userselid;
            echo json_encode($json);
        }

        public function ajaxUsergroupgiftcard($currentUserid = null)
        {
            $this->autoRender = false;

            $userstable = TableRegistry::get('Users');
            $countriestable = TableRegistry::get('Countries');
            $tempaddrtable = TableRegistry::get('Tempaddresses');

            echo $currentUserid = $_POST['currentUserid'] . "#";
            $usernamedetails = $userstable->find('all')->where(['id' => $currentUserid])->first();
            $fname = $usernamedetails['first_name'];
            $lname = $usernamedetails['last_name'];
            $image_computer = $usernamedetails['profile_image'];
            echo $fullname = $fname . $lname . "#";
            echo $cemail = $usernamedetails['email'] . "#";

            $query = $tempaddrtable->query();
            $usernameaddrdetails = $query->find('all')->where(['userid' => $currentUserid])->first();

            echo $addr1 = $usernameaddrdetails['address1'] . "#";
            echo $addr2 = $usernameaddrdetails['address2'] . "#";
            $coun = $usernameaddrdetails['country'];
            echo $country = $usernameaddrdetails['country'] . "#";
            echo $state = $usernameaddrdetails['state'] . "#";
            echo $city = $usernameaddrdetails['city'] . "#";
            echo $zip = $usernameaddrdetails['zipcode'] . "#";
            echo $ph = $usernameaddrdetails['phone'] . "#";

            $coun = $countriestable->find('all')->where(['country' => $coun])->first();

            $cd = $coun['id'];
            if ($image_computer == "")
                $image_computer = "usrimg.jpg";
            echo $image_computer . "#";
            echo $cd;
            $this->set('usernamedetails', $usernamedetails);
            $this->set('usernameaddrdetails', $usernameaddrdetails);
            $this->set('coun', $coun);
        }

        public function ggusersave()
        {
            $this->autoRender = false;
            global $loguser;
            $groupgiftuserdetailstable = TableRegistry::get('Groupgiftuserdetails');
            $itemstable = TableRegistry::get('Items');

            $flag = $_GET['flag'];
            $item_id = $_GET['item_id'];
            $size = $_GET['size'];
            $quantity = $_GET['qty'];
            $country = $_GET['country'];
            $zipcode = $_GET['zipcode'];
            $item_datas = $itemstable->find()->contain('Users')->contain('Shipings')->where(['Items.id' => $item_id])->first();


            $usertable = TableRegistry::get('Users');

            $name = $_GET['recipient'];
            $email = $loguser['email'];
            $logusername = $loguser['username'];

            if(($name == $email) || ($name == $logusername))
            {
                echo '/2';
                exit;
            }



            $sizeoptions = $item_datas['size_options'];
            $sizes = json_decode($sizeoptions, true);
            if (!empty($sizes)) {
                $sizeoptions = $item_datas['size_options'];
                $sizes = json_decode($sizeoptions, true);
                $itemtotal = $sizes['price'][$size] * $quantity;
            } else
            $itemtotal = $item_datas['price'] * $quantity;

            $taxtable = TableRegistry::get('Taxes');
            $tax_datas = $taxtable->find()->where(['countryid' => $country])->where(['status' => 'enable'])->all();
            $this->set('tax_datas', $tax_datas);
            foreach ($tax_datas as $taxes) {
                $tax_perc += $taxes['percentage'];
            }

            $tax = ($itemtotal * $tax_perc) / 100;

            /* Item Currency*/
            $currency = $item_datas->currencyid;
            $forexratestable = TableRegistry::get('Forexrates');
            $forexrateModel = $forexratestable->find()->where(['id' => $currency])->first();
            $item_rate = $forexrateModel['price'];
            /* Currency Conversion */
            if (isset($_SESSION['currency_code'])) {
                $forexrateModel = $forexratestable->find()->where(['currency_code' => $_SESSION['currency_code']])->first();
                $currency_rate = $forexrateModel['price'];
                $currency_id = $forexrateModel['id'];
            } else {
                $forexrateModel = $forexratestable->find()->where(['currency_code' => $_SESSION['default_currency_code']])->first();
                $currency_rate = $forexrateModel['price'];
                $currency_id = $forexrateModel['id'];
            }

            $this->loadModel('Shops');
            $this->loadModel('Forexrates');
            $shop_data = $this->Shops->find()->where(['id' => $item_datas['shop_id']])->first();
            $shopCurrencyDetails = $this->Forexrates->find()->where(['currency_code' => $shop_data['currency']])->first();
            $freeamt = $this->Currency->conversion($shopCurrencyDetails['price'], $currency_rate, $shop_data['freeamt']);
            $itemtotal = $this->Currency->conversion($item_rate, $currency_rate, $itemtotal);

            $postalcode = json_decode($shop_data['postalcodes'], true);

            if (in_array($zipcode, $postalcode)) {
                $shipping_amt = 0;
            } elseif ($itemtotal >= $freeamt && $shop_data['pricefree'] == 'yes') {
                $shipping_amt = 0;
            } else {
                foreach ($item_datas['shipings'] as $shpng) {
                    $shpngs[$shpng['country_id']] = $shpng['primary_cost'];
                }

                if (isset($shpngs[$country])) {
                    $shipping_amt = $shpngs[$country];
                } else if (isset($shpngs[0])) {
                    $shipping_amt = $shpngs[0];
                }
            }


            $shipping_amt = $this->Currency->conversion($item_rate, $currency_rate, $shipping_amt);

            $totals_amt = $this->Currency->conversion($item_rate, $currency_rate, $totals_amt);
            $tax = $this->Currency->conversion($item_rate, $currency_rate, $tax);

            $totals_amt = ($itemtotal) + $shipping_amt + $tax;

            if ($flag == "1") {
                $name = $_GET['name'];
                $recipient = $_GET['recipient'];
                $address1 = $_GET['address1'];
                $address2 = $_GET['address2'];
                $state = $_GET['state'];
                $city = $_GET['city'];
                $zipcode = $_GET['zipcode'];
                $telephone = $_GET['telephone'];
                $image = $_GET['image'];
                $lastestidgg = $_GET['lastestidgg'];
                $userId = $loguser['id'];

                if ($lastestidgg == '' || empty($lastestidgg)) {
                    $grouogiftuserdetail = $groupgiftuserdetailstable->newEntity();
                } else {
                    $grouogiftuserdetail = $groupgiftuserdetailstable->find('all')->where(['id' => $lastestidgg])->first();
                }
                $grouogiftuserdetail->user_id = $userId;
                $grouogiftuserdetail->item_id = $item_id;
                $grouogiftuserdetail->recipient = $recipient;
                $grouogiftuserdetail->name = $name;
                $grouogiftuserdetail->address1 = $address1;
                $grouogiftuserdetail->address2 = $address2;
                $grouogiftuserdetail->country = $country;
                $grouogiftuserdetail->state = $state;
                $grouogiftuserdetail->city = $city;
                $grouogiftuserdetail->zipcode = $zipcode;
                $grouogiftuserdetail->telephone = $telephone;
                $grouogiftuserdetail->image = $image;
                $grouogiftuserdetail->c_date = time();
                $grouogiftuserdetail->status = 'Pending';

                if ($lastestidgg == '' || empty($lastestidgg)) {
                    $result = $groupgiftuserdetailstable->save($grouogiftuserdetail);
                    $lasttId = $result->id;
                } else {
                    $groupgiftuserdetailstable->save($grouogiftuserdetail);
                    $lasttId = $lastestidgg;
                }

                $image = array();
                $logusrid = $loguser['id'];
                $item_user_id = $item_datas['user_id'];
                $itemname = $item_datas['item_title'];
                $logusername = $loguser['username'];
                $logfirstname = $loguser['first_name'];
                $logusernameurl = $loguser['username_url'];
                $userDesc = "";
                $userImg = $loguser['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                $giftlink = '<a href="' . SITE_URL . 'gifts/' . $lasttId . '">' . $lasttId . '</a>';
                $notifymsg = $loguserlink . " -___-Created a group gift on your product, Group Gift Id :-___-" . $giftlink;
                $logdetails = $this->addlog('groupgift', $logusrid, $item_user_id, 0, $notifymsg, $userDesc, $loguserimage);

                $creatornotifymsg = "You have created a group gift on the product-___-" . $itemname . " for " . $name;
                $logdetails = $this->addlog('groupgift', 0, $logusrid, 0, $creatornotifymsg, $userDesc, $loguserimage);

                $sitesettings = TableRegistry::get('sitesettings');
                $setngs = $sitesettings->find()->first();
                $selleremail = $item_datas['user']['email'];
                $sellername = $item_datas['user']['first_name'];
                $itemname = $item_datas['item_title'];
                $itemid = $item_datas['id'];
                $itemurl = base64_encode($itemid . "_" . rand(1, 9999));
                $creatorname = $loguser['first_name'];
                $creatoremail = $loguser['email'];
                $aSubject = $setngs['site_name'] . " - " . __d('user', 'Group gift created on your product in') . " " . $setngs['site_name'];
                $aBody = "test";
                $template = 'sellergroupgift';
                $setdata = array('name' => $sellername, 'creator' => $creatorname, 'itemname' => $itemname, 'itemurl' => $itemurl, 'giftlink' => $giftlink, 'setngs' => $setngs);
                $this->sendmail($selleremail, $aSubject, $aBody, $template, $setdata);

                $bsubject = $setngs['site_name'] . " - " . __d('user', 'You have created group gift on the product in') . " " . $setngs['site_name'];
                $btemplate = 'creatorgroupgift';
                $setdata1 = array('name' => $sellername, 'creator' => $creatorname, 'itemname' => $itemname, 'itemurl' => $itemurl, 'giftlink' => $giftlink, 'setngs' => $setngs);
                $this->sendmail($creatoremail, $bsubject, $aBody, $btemplate, $setdata1);

                $grouogiftuserdetail = $groupgiftuserdetailstable->find('all')->where(['id' => $lasttId])->first();
                $grouogiftuserdetail->itemcost = $item_datas['price'];
                if ($size != 'null') {
                    $grouogiftuserdetail->itemsize = $size;
                } else {
                    $grouogiftuserdetail->itemsize = '';
                }

                $grouogiftuserdetail->currencyid = $currency_id;
                $grouogiftuserdetail->itemquantity = $quantity;
                $grouogiftuserdetail->shipcost = $shipping_amt;
                $grouogiftuserdetail->tax = $tax;
                $grouogiftuserdetail->total_amt = round($totals_amt);
                $grouogiftuserdetail->balance_amt = round($totals_amt);
                $groupgiftuserdetailstable->save($grouogiftuserdetail);
                echo $lasttId . ',' . $shipping_amt . ',' . $itemtotal . ',' . $totals_amt . ',' . $tax;
                die;
            } else {
                echo ',' . $shipping_amt . ',' . $itemtotal . ',' . $totals_amt . ',' . $tax;
                die;
            }
        }

        public function groupgiftreason()
        {
            $this->autoRender = false;

            $groupgiftuserdetailstable = TableRegistry::get('Groupgiftuserdetails');
            $itemstable = TableRegistry::get('Items');

            $title = $_GET['title'];
            $description = $_GET['description'];
            $notes = $_GET['notes'];
            $lastestidgg = $_GET['lastestidgg'];
            $quantity = $_GET['quantity'];
            $size = $_GET['size'];

            $ggdata = $groupgiftuserdetailstable->find()->where(['id' => $lastestidgg])->first();
            $item_id = $ggdata['item_id'];

            $item_data = $itemstable->find()->where(['id' => $item_id])->first();
            $tot_qnty = $item_data['quantity'];

            $rem_qnty = $tot_qnty - $quantity;

            $sizeoptions = $item_data['size_options'];
            $sizes = json_decode($sizeoptions, true);
            if (!empty($sizes)) {
                $sizeoptions = $item_data['size_options'];
                $sizes = json_decode($sizeoptions, true);
                $sizes['unit'][$size] = $sizes['unit'][$size] - $quantity;
                $size_options = json_encode($sizes);
                $query = $itemstable->query();
                $query->update()
                ->set(['quantity' => $rem_qnty])
                ->set(['size_options' => $size_options])
                ->where(['Items.id' => $item_id])
                ->execute();
            } else {
                $query = $itemstable->query();
                $query->update()
                ->set(['quantity' => $rem_qnty])
                ->where(['Items.id' => $item_id])
                ->execute();
            }

            $groupgiftuserdetail = $groupgiftuserdetailstable->find()->where(['id' => $lastestidgg])->first();
            $groupgiftuserdetail->title = $title;
            $groupgiftuserdetail->description = $description;
            $groupgiftuserdetail->notes = $notes;
            $groupgiftuserdetailstable->save($groupgiftuserdetail);

            $updatequery = $groupgiftuserdetailstable->query();
            $updatequery->update()
            ->set(['status' => "Active"])
            ->where(['id' => $lastestidgg])->execute();
        }

        public function gifts($id = null)
        {

             global $loguser;

            $groupgiftuserdetailstable = TableRegistry::get('Groupgiftuserdetails');
            $groupgiftpayamtstable = TableRegistry::get('Groupgiftpayamts');
            $countriestable = TableRegistry::get('Countries');
            $itemstable = TableRegistry::get('Items');
            $userstable = TableRegistry::get('Users');

            
            if (!isset($loguser) || empty($loguser)) {
                $this->set('currentUser', 0);
            } else {
                $this->set('currentUser', $loguser['id']);
            }
            $items_list_data = $groupgiftuserdetailstable->find()->where(['id' => $id])->first();
            $ggAmtDatas = $groupgiftpayamtstable->find()->contain('Users')->where(['ggid' => $id])->all();
            foreach ($ggAmtDatas as $ggAmtData) {
                $paidamt += $ggAmtData['amount'];
                $paidUserId[] = $ggAmtData['paiduser_id'];
            }
            if (empty($items_list_data)) {
                $this->redirect('/');
            }
            $ItemId = $items_list_data['item_id'];
            $userId = $items_list_data['user_id'];
            $countryId = $items_list_data['country'];
            $currency = $items_list_data['currencyid'];

            $countrys_list_data = $countriestable->find()->where(['id' => $countryId])->first();

            $item_datas = $itemstable->find()->contain('Photos')->contain('Forexrates')->where(['Items.id' => $ItemId])->first();

            $createuserDetails = $userstable->find()->where(['id' => $userId])->first();

            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            $socialId = $setngs['social_id'];
            $socialId = json_decode($socialId, true); //print_r($socialId);die;

            $this->set('item_datas', $item_datas);
            $this->set('createuserDetails', $createuserDetails);
            $this->set('items_list_data', $items_list_data);
            $this->set('countrys_list_data', $countrys_list_data);
            $this->set('paidamt', $paidamt);
            $this->set('paidUserId', $paidUserId);
            $this->set('ggAmtDatas', $ggAmtDatas);
            $this->set('setngs', $setngs);
            $this->set('loguser', $loguser);
            $this->set('roundProf', $siteChanges['profile_image_view']);
            $this->set('fbapp_id', $socialId['FB_ID']);
            $this->set('fbtitle', SITE_NAME . " Group Gift Share");
            $this->set('fbdescription', "Contribution Request from your friend");
            $this->set('fbtype', "photo");
            $this->set('fburl', SITE_URL . "gifts/" . $items_list_data['Groupgiftuserdetail']['id']);
            $this->set('fbimage', $_SESSION['media_url'] . 'media/items/original/' . $item_datas['Photo'][0]['image_name']);
            $forexratestable = TableRegistry::get('Forexrates');
            $forexrateModel = $forexratestable->find()->where(['id' => $currency])->first();
            $this->set('gift_currency_symbol', $forexrateModel['currency_symbol']);
            $this->set('gift_currency_code', $forexrateModel['currency_code']);
            $this->set('gift_currency_rate', $forexrateModel['price']);
            $this->set('metavalue', 'groupgift');
        }

        public function gglists()
        {
            if (!$this->isauthenticated())
                $this->redirect('/');

            $groupgiftuserdetailstable = TableRegistry::get('Groupgiftuserdetails');
            $groupgiftpayamtstable = TableRegistry::get('Groupgiftpayamts');
            $itemstable = TableRegistry::get('Items');

            global $loguser;
            $userid = $loguser['id'];

            $first_name = $loguser['first_name'];
            $this->set('first_name', $first_name);

            $gglistsData = $groupgiftuserdetailstable->find()->where(['user_id' => $userid])
            ->where(function ($exp, $q) {
                return $exp->notEq('status', 'Pending');
            })
            ->order(['Groupgiftuserdetails.id DESC'])->all();
            foreach ($gglistsData as $gglist) {
                $ggid = $gglist['id'];
                $itemid = $gglist['item_id'];
                $itemdata = $itemstable->find()->contain('Forexrates')->where(['Items.id' => $itemid])->first();
                $gglists[$ggid]['currency_symbol'] = $itemdata['forexrate']['currency_symbol'];
            }
            $this->set('gglists', $gglists);

            $groupgiftpayment = $groupgiftpayamtstable->find()->contain('Users')->contain('Groupgiftuserdetails')->where(['Groupgiftuserdetails.user_id' => $userid])

            ->order(['cdate DESC'])->limit(5)->all();
            $this->set('groupgiftpayment', $groupgiftpayment);

            foreach ($groupgiftpayment as $ggpayment) {
                $ggpayid = $ggpayment['id'];
                $itemid = $ggpayment['groupgiftuserdetail']['item_id'];
                $itemstable = TableRegistry::get('Items');
                $itemdata = $itemstable->find()->contain('Forexrates')->where(['Items.id' => $itemid])->first();
                $ggpays[$ggpayid]['currency_symbol'] = $itemdata['forexrate']['currency_symbol'];
            }
            $this->set('ggpays', $ggpays);

            $this->set('gglistdatas', $gglistsData);
        }

        function groupgifts()
        {

        }

        public function getpushajax()
        {
            $this->loadModel('Items');
            $this->loadModel('Comments');
            $this->loadModel('Followers');
            $this->loadModel('Storefollowers');
            $this->loadModel('Logs');
            $this->loadModel('Users');
            $this->loadModel('Itemfavs');
            global $loguser;
            global $setngs;
            $userid = $loguser['id'];
            $usercreated = $loguser['created_at'];
            $usercreated = strtotime($usercreated);

            $userstable = TableRegistry::get('Users');
            $itemfavstable = TableRegistry::get('Itemfavs');
            $logstable = TableRegistry::get('Logs');
            $userModel = $userstable->find()->where(['id' => $userid])->first();
            $followerstable = TableRegistry::get('Followers');
            $flwrscnt = $followerstable->find()->where(['follow_user_id' => $userid])->first();
            foreach ($flwrscnt as $flwr) {
                $flwruserid[] = $flwr['user_id'];
            }
            $notificationSettings = json_decode($userModel['push_notifications'], true);
            if ($notificationSettings['somone_cmnts_push'] == 1) {
                $itemfav = $itemfavstable->find()->where(['user_id' => $userid])->first();
                foreach ($itemfav as $fav) {
                    $itemfavid[] = $fav['item_id'];
                }
            }
            $followType = 'additem';
            if ($notificationSettings['frends_cmnts_push'] == 0) {
                $followType = array();
                $followType[] = 'additem';
                $followType[] = 'comment';
            }
            $addedItems = array();
            if ($notificationSettings['frends_flw_push'] == 1) {
                $addedItems['userid IN'] = $flwruserid;
                $addedItems['type'] = 'additem';
            }
            $typeAs[] = 'comment';
            $typeAs[] = 'mentioned';
            $typeAs[] = 'status';
            $typeAs[] = 'additem';
            $typeAs[] = 'favorite';
            $typeConditions['type NOT IN'] = $typeAs;

            if ($userModel['user_level'] == 'shops') {

                if (!empty($flwruserid) && !empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['OR' => ['type' => 'admin', 'type' => 'admincommission'], 'notifyto' => 0, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit('4')->all();


                } elseif (!empty($flwruserid)) {

                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['OR' => ['type' => 'admin', 'type' => 'admincommission'], 'notifyto' => 0, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit('4')->all();

                } elseif (!empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            ['OR' => ['type' => 'admin', 'type' => 'admincommission'], 'notifyto' => 0, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit('4')->all();

                } else {
                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['notifyto' => $userid],
                            ['OR' => [['type' => 'admin'], ['type' => 'admincommission']], 'notifyto' => 0, 'cdate >' => $usercreated],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit('4')->all();
                }

            } else {

                if (!empty($flwruserid) && !empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit('4')->all();

                } elseif (!empty($flwruserid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0],
                            ['notifyto' => $userid],
                            [$addedItems],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit('4')->all();

                } elseif (!empty($itemfavid)) {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['itemid IN' => $itemfavid, 'type' => 'comment'],
                            ['notifyto' => $userid],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->order(['id DESC'])->limit('4')->all();

                } else {

                    $query = $logstable->query();
                    $userlogd = $query->where(['OR' =>
                        [
                            ['notifyto' => $userid],
                            ['type' => 'admin', 'notifyto' => 0],
                            ['userid' => $userid, 'type' => 'status']
                        ]])->where($typeConditions)
                    ->where(['cdate >' => $usercreated])->order(['id DESC'])->limit('4')->all();

                }

            }
            $this->set('decoded_value', $notificationSettings);
            $this->set('userlogd', $userlogd);
            $this->set('userid', $userid);
            $userstable = TableRegistry::get('Users');
            $query = $userstable->query();
            $query->update()
            ->set(['unread_notify_cnt' => "0"])
            ->where(['Users.id' => $userid])
            ->execute();




        }

        function hashtag($tagName)
        {
            if (empty($tagName)) {
                $this->Flash->error(__d('user', 'Please mention a valid Hashtag'));
                $this->redirect('/');
            }
            global $loguser;
            global $setngs;
            global $siteChanges;
            $userid = $loguser['id'];
            $this->loadModel('Comments');
            $this->loadModel('Users');
            $this->loadModel('Hashtags');
            $this->loadModel('Followers');
            $followerstable = TableRegistry::get('Followers');
            $followcnt = $followerstable->followcnt($loguser['id']);
            if (!empty($followcnt)) {
                foreach ($followcnt as $flcnt) {
                    $flwngusrids[] = $flcnt['user_id'];
                }
            }
            $flwngusrids[] = $userid;
            $userlevels = array('god', 'moderator');
            $userstable = TableRegistry::get('Users');
            $people_details = $userstable->find('all')->where(['id NOT IN' => $flwngusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                return $exp->notEq('activation', '0');
            })->order(['Users.id DESC'])->limit(5);

            $commentstable = TableRegistry::get('Comments');
            $commentModel = $commentstable->find()->contain('Users')->contain('Items')->where(['comments LIKE' => '%#%>' . $tagName . '<%'])
            ->group(['Comments.id'])->order(['Comments.id DESC'])->limit(10)->all();
            $hashtagstable = TableRegistry::get('Hashtags');
            $trendingHashtags = $hashtagstable->find('all')
            ->where(['hashtag is NOT' => $tagName])
            ->order(['usedcount DESC'])->limit(10)->all();

            $sitesettings = TableRegistry::get('sitesettings')->find('all')->first();
            $siteChanges = json_decode($sitesettings->site_changes, true);
            $this->set('roundProf', $siteChanges['profile_image_view']);
            $this->set('trendingHashtags', $trendingHashtags);
            $this->set('commentModel', $commentModel);
            $this->set('people_details', $people_details);
            $this->set('tagName', $tagName);
            $this->set('userid', $userid);

        }

        function getmorehashtag($tagName)
        {
            global $loguser;
            global $setngs;
            global $siteChanges;
            $this->layout = 'ajax';
            $userid = $loguser['id'];
            $this->loadModel('Comments');
            $this->loadModel('Hashtags');
            $offset = $_GET['startIndex'];
            $page = ($offset / 10) + 1;

            $commentstable = TableRegistry::get('Comments');
            $commentModel = $commentstable->find()->contain('Items')->contain('Users')->where(['comments LIKE' => '%#%>' . $tagName . '<%'])
            ->group(['Comments.id'])->order(['Comments.id DESC'])->limit(10)->page($page)->all();

            $sitesettings = TableRegistry::get('sitesettings')->find('all')->first();
            $siteChanges = json_decode($sitesettings->site_changes, true);

            $this->set('roundProf', $siteChanges['profile_image_view']);
            $this->set('commentModel', $commentModel);
            $this->set('tagName', $tagName);
            $this->set('userid', $userid);
        }

        public function cartmousehover()
        {
            $this->loadModel('Carts');
            $this->loadModel('Giftcards');
            $this->loadModel('Items');
            $itemstable = TableRegistry::get('Items');
            global $loguser;
            global $setngs;
            $userid = $loguser['id'];
            $gifttot = 0;
            $itmtot = 0;
            $total_itms = 0;
            $giftcarduseradded = $this->Giftcards->find('all', array('conditions' => array('Giftcards.user_id' => $userid, 'Giftcards.status' => 'Pending'), 'limit' => '2', 'order' => 'Giftcards.id DESC'));
            $gifttot = count($giftcarduseradded);
            if (!empty($userid)) {
                $cartModel = $this->Carts->find('all', array('conditions' => array('user_id' => $userid, 'payment_status' => 'progress')));
                $total_itms = count($cartModel);
                if ($total_itms > 0) {
                    foreach ($cartModel as $cart) {


                        $checck = $this->Items->find('all', array('conditions' => array('Items.id' => $cart['item_id'])));
                        foreach ($checck as $checck1) {
                            if ($checck1['status'] == 'publish') {


                                $cartIds[] = $cart['item_id'];
                                $cartQuantity[$cart['item_id']] = $cart['quantity'];
                                $cartsizeoptions[$cart['item_id']] = $cart['size_options'];
                                $sizes[] = $cart['size_options'];
                                $quantitys[] = $cart['quantity'];
                            }
                        }
                    }
                    foreach ($cartIds as $itmid) {

                        $itm_datass[] = $itemstable->find()->contain('Photos')->contain('Forexrates')->where(['Items.id' => $itmid])->where(['Items.status' => 'publish'])->first();

                        $total_itms = count($itm_datass);

                    }

                    foreach ($itm_datass as $key => $itm_data) {
                        $itemModel[] = $itm_data;
                    }


                    $arrKeys = $cartIds;
                    $arrVals = $sizes;
                    function foo($key, $val)
                    {
                        return array($key => $val);
                    }

                    $arrSize = array_map('foo', $arrKeys, $arrVals);

                    $arrKeys = $cartIds;
                    $arrVals = $quantitys;
                    function fooo($key, $val)
                    {
                        return array($key => $val);
                    }

                    $arrQuantity = array_map('fooo', $arrKeys, $arrVals);
                    $key = 0;
                    foreach ($itemModel as $item) {
                        $cartitem[$key]['image'] = $item['photos']['0']['image_name'];
                        $cartitem[$key]['quantity'] = $arrQuantity[$key][$item['id']];
                        $cartitem[$key]['title'] = $item['item_title'];
                        $sizeoptions = $item['size_options'];
                        $sizes = json_decode($sizeoptions, true);
                        if (!empty($arrSize[$key][$item['id']]))
                            $cartitem[$key]['price'] = $sizes['price'][$arrSize[$key][$item['id']]] * $arrQuantity[$key][$item['id']];
                        else
                            $cartitem[$key]['price'] = $item['price'] * $arrQuantity[$key][$item['id']];
                        $cartitem[$key]['titleurl'] = $item['item_title_url'];
                        $cartitem[$key]['itemid'] = $item['id'];
                        $cartitem[$key]['currencysymbol'] = $item['forexrate']['currency_symbol'];
                        $key += 1;
                    }

                    $this->set('cartModel', $cartitem);
                }
            }

            /* Giftcard Details */
            if (!empty($giftcarduseradded)) {
                $giftcarditemDetails = json_decode($setngs['giftcard'], true);
                $this->set('giftcarditemDetails', $giftcarditemDetails);
                $this->set('giftcarduseradded', $giftcarduseradded);
                $this->set('countgiftcarduseradded', count($giftcarduseradded));


            }
            /* Giftcard Details */

            $itmtot = $gifttot + $total_itms;
            $this->set('total_itms', $itmtot);
        }

        public function userlike()
        {
            global $loguser;
            global $setngs;
            $userid = $loguser['id'];

            $itemid = $_REQUEST['itemid'];
            $this->loadModel('Itemfavs');
            $this->loadModel('Items');
            $this->loadModel('Itemlists');
            $itemstable = TableRegistry::get('Items');
            $itemfavstable = TableRegistry::get('Itemfavs');
            $userdatasall = $itemstable->find()->contain('Photos')->where(['Items.id' => $itemid])->first();
            $itemfavs = $itemfavstable->find()->where(['item_id' => $itemid])->where(['user_id' => $userid])->count();
            //echo $itemfavs; die;
            if ($itemfavs <= 0) {

                $itemfavs = $itemstable->newEntity();
                $itemfavs->user_id = $userid;
                $itemfavs->item_id = $itemid;
                $result = $itemfavstable->save($itemfavs);

                //echo $lastinsertId = $result->id; die;

                $favcountss = $userdatasall['fav_count'];
                $favcounts = $favcountss + 1;

                $query = $itemstable->query();
                $query->update()
                ->set(['fav_count' => $favcounts])
                ->where(['id' => $itemid])
                ->execute();

                $notifyto = $userdatasall['user_id'];
                $userstable = TableRegistry::get('Users');
                $users = $userstable->find()->where(['id' => $notifyto])->first();
                $notificationSettings = json_decode($users['push_notifications'], true);
                if ($notificationSettings['somone_likes_ur_item_push'] == 1 && $userid != $notifyto) {
                    $logusername = $loguser['username'];
                    $logfirstname = $loguser['first_name'];
                    $logusernameurl = $loguser['username_url'];
                    $itemname = $userdatasall['item_title'];
                    $itemurl = $userdatasall['item_title_url'];
                    $liked = $setngs['liked_btn_cmnt'];
                    $userImg = $loguser['profile_image'];
                    if (empty($userImg)) {
                        $userImg = 'usrimg.jpg';
                    }
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    $image['item']['image'] = $userdatasall['photos'][0]['image_name'];
                    $image['item']['link'] = SITE_URL . "listing/" . $itemid . "/" . $itemurl;
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
                    $productlink = "<a href='" . SITE_URL . "listing/" . $itemid . "/" . $itemurl . "'>" . $itemname . "</a>";
                    $notifymsg = $loguserlink . " " . $liked . " -___-your product-___- " . $productlink;
                    $logdetails = $this->addloglive('favorite', $userid, $notifyto, $lastinsertId, $notifymsg, null, $loguserimage, $itemid);
                }

                $this->loadModel('Userdevices');
                $userstable = TableRegistry::get('Users');
                $userdevicestable = TableRegistry::get('Userdevices');
                $getuserIdd = $itemstable->find()->contain('Users')->where(['Items.id' => $itemid])->first();
                if ($getuserIdd['user']['id'] != $userid) {
                    $usernamedetails = $userstable->find()->where(['id' => $userid])->first();
                    $userddett = $userdevicestable->find()->where(['user_id' => $getuserIdd['user']['id']])->all();

                    $logusername = $usernamedetails['username'];
                    $logfirstname = $usernamedetails['first_name'];
                    $liked = $setngs['liked_btn_cmnt'];
                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge += 1;
                        $this->Userdevices->updateAll(array('badge' => $badge), array('deviceToken' => $deviceTToken));
                        if (isset($deviceTToken)) {
                            $messages = $logfirstname . " " . $liked . " your item " . $getuserIdd['item_title'];
                        }
                    }
                }
            }
            $itemlistModel = $this->Itemlists->find('all', array('conditions' => array('user_id' => $userid)));
            $listexist = array();
            foreach ($itemlistModel as $key => $itemlist) {
                $listexist[$key]['listname'] = $itemlist['lists'];
                $listexist[$key]['listid'] = $itemlist['id'];
                $listexist[$key]['listcheck'] = 0;
                $listItems = json_decode($itemlist['list_item_id'], true);
                if (in_array($itemid, $listItems)) {
                    $listexist[$key]['listcheck'] = 1;
                }
            }
            $itemdata = $itemstable->find()->where(['id' => $itemid])->first();
            echo $itemdata['fav_count'] . "-_-";
            echo json_encode($listexist);
            die;
        }

        public function userUnlike()
        {
            global $loguser;
            $this->autoRender = false;
            $userid = $loguser['id'];
            $itemid = $_REQUEST['itemid'];
            $this->loadModel('Itemfavs');
            $this->loadModel('Items');
            $this->loadModel('Itemlists');
            $itemstable = TableRegistry::get('Items');
            $itemfavstable = TableRegistry::get('Itemfavs');
            $itemliststable = TableRegistry::get('Itemlists');
            $userdatasall = $itemstable->find()->where(['id' => $itemid])->first();
            $itemfavs = $itemfavstable->find()->where(['item_id' => $itemid])->where(['user_id' => $userid])->count();
            if ($itemfavs > 0) {

                $itemfavquery = $itemfavstable->query();
                $itemfavquery->delete()
                ->where(['user_id' => $userid])
                ->where(['item_id' => $itemid])
                ->execute();

                $favcountss = $userdatasall['fav_count'];
                $favcounts = $favcountss - 1;

                $query = $itemstable->query();
                $query->update()
                ->set(['fav_count' => $favcounts])
                ->where(['id' => $itemid])
                ->execute();

                $itemlistModel = $this->Itemlists->find('all', array('conditions' => array('user_id' => $userid)));
                foreach ($itemlistModel as $itemlist) {
                    $listItems = json_decode($itemlist['list_item_id'], true);
                    $listItems = array_diff($listItems, array($itemid));

                    $itemlists = $itemliststable->find()->where(['id' => $itemlist['id']])->first();
                    $itemlists->list_item_id = json_encode($listItems);
                    $itemliststable->save($itemlists);

                }
            }
            $items = $itemstable->find()->where(['id' => $itemid])->first();
            echo $items['fav_count'];

        }
        /***** Seller Rating & reviews ********/
        public function rating()
        {
            $this->autoRender = false;
            $this->loadModel('Reviews');
            $this->loadModel('Users');
            $this->loadModel('Shops');
            $this->loadModel('Orders');
            $userid = $_REQUEST['user_id'];
            $orderid = $_REQUEST['order_id'];
            $sellerid = $_REQUEST['seller_id'];
            $rateval = $_REQUEST['rate_val'];
            $reviewtitle = $_REQUEST['review_tit'];
            $reviewcontent = $_REQUEST['review_cont'];
            $count = $_REQUEST['loadcount'];
            global $loguser;
            $reviewstable = TableRegistry::get('Reviews');
            $reviews = $reviewstable->newEntity();
            $reviews->orderid = $orderid;
            $reviews->ratings = $rateval;
            $reviews->review_title = $reviewtitle;
            $reviews->reviews = $reviewcontent;
            $reviews->userid = $userid;
            $reviews->sellerid = $sellerid;


            $ordercount = $reviewstable->find()->where(['userid' => $userid])->where(['sellerid' => $sellerid])->where(['orderid' => $orderid])->count();
            if ($ordercount == 0)
                $reviewstable->save($reviews);

            $this->Orders->updateAll(array('reviews' => '1'), array('userid' => $userid, 'merchant_id' => $sellerid, 'orderid' => $orderid));
            $rateval_data = $this->Reviews->find('all', array('conditions' => array('sellerid' => $sellerid)));
            $review_count = count($rateval_data);
            foreach ($rateval_data as $ratevaldata) {
                echo $rateval_total += $ratevaldata['ratings'];
                echo '<br />';
            }
            $average_rate = $rateval_total / $review_count;
            $average_rate = floor($average_rate * 2) / 2;
            echo $average_rate;

            $this->Users->updateAll(array('seller_ratings' => $average_rate), array('id' => $sellerid));

            $reviews_added = $this->Reviews->find("all", array('conditions' => array('sellerid' => $sellerid), 'limit' => '2'));

            $shopstable = TableRegistry::get('Shops');
            $shop_details = $shopstable->find()->where(['user_id' => $sellerid])->first();
            $shop_description = $this->Users->find("all", array('conditions' => array('User.id' => $sellerid)));
            $this->set('shop_description', $shop_description);
            $this->set('shop_details', $shop_details);

            $this->set('reviews_added', $reviews_added);
            $this->set('count', $count);
            $this->set('rateval_data', $rateval_data);
            $this->set('review_count', $review_count);

            $logusername = $loguser['username'];
            $logfirstname = $loguser['first_name'];
            $logusrid = $loguser['id'];
            $logusernameurl = $loguser['username_url'];
            $userDesc = $reviewcontent;
            $userImg = $loguser['profile_image'];
            $shopid = $shop_details['user_id'];
            $shopurl = $shop_details['shop_name_url'];
            if (empty($userImg)) {
                $userImg = 'usrimg.jpg';
            }
            $image['user']['image'] = $userImg;
            $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
            $loguserimage = json_encode($image);
            $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
            $notifymsg = $loguserlink . " -___-wrote a review for you";
            $logdetails = $this->addlog('review', $logusrid, $sellerid, 0, $notifymsg, $userDesc, $loguserimage);

            $userstable = TableRegistry::get('Users');
            $sellerdetail = $userstable->find()->where(['id' => $sellerid])->first();
            $setngs = TableRegistry::get('sitesettings')->find('all')->first();
            $email = $sellerdetail['email'];
            $aSubject = $setngs['site_name'] . ' - ' . __d('user', 'You got a review');
            $aBody = '';
            $template = 'review';
            $setdata = array('name' => $sellerdetail['first_name'], 'loguser' => $logfirstname, 'review' => $userDesc, 'setngs' => $setngs);
            $this->sendmail($email, $aSubject, $aBody, $template, $setdata);

        }


            //GIFTCARD PAGE
        public function CreateGiftcard()
        {
            global $loguser;
            $userid = $loguser['id'];
            $first_name = $loguser['first_name'];
            $this->set('first_name', $first_name);
            $email = $loguser['email'];
            $username = $loguser['username'];
            if (!$this->isauthenticated()) {
                $this->redirect('/');
            }
            $this->viewBuilder()->setLayout('default');
            $this->set('title_for_layout', 'Create Gift Card');
            if (!empty($this->request->data)) {
                if ($this->request->data['recipient_email'] == $loguser['email']) {
                    $this->Flash->error(__d('user', 'Gift card can not be send to your own'));
                    $this->redirect('/create/giftcard');
                } else {
                            //Save new giftcards
                    $giftcardsTable = TableRegistry::get('Giftcards');
                    $giftcards = $giftcardsTable->newEntity();
                    $giftcards->user_id = $userid;
                    $giftcards->reciptent_name = $this->request->data['recipient_username'];
                    $giftcards->amount = $this->request->data['giftamt'];
                    $giftcards->avail_amount = $this->request->data['giftamt'];
                    $giftcards->status = 'Pending';
                    $giftcards->cdate = time();
                    $giftcardsTable->save($giftcards);
                }
            } else {

                $sitesettings = TableRegistry::get('sitesettings')->find('all')->first();
                $siteChanges = json_decode($sitesettings->site_changes);
                if (isset($userid)) {
                } else {
                    $usershipping = '';
                }

                $giftcardstable = TableRegistry::get('Giftcards');
                $giftcarddets = $giftcardstable->find('all')->contain('Users')->contain('Forexrates')->where(['Giftcards.user_id' => $userid])->where(['Giftcards.status' => 'Paid'])->order(['Giftcards.id DESC'])->all();
                $giftcarddets_recv = $giftcardstable->find('all')->contain('Users')->contain('Forexrates')->where(['Giftcards.reciptent_email' => $email])->where(['Giftcards.status' => 'Paid'])->order(['Giftcards.id DESC'])->all();
                        //set data
                $this->set('item_datas', json_decode($sitesettings['giftcard'], true));
                $this->set('giftcarddets', $giftcarddets);
                $this->set('giftcarddets_recv', $giftcarddets_recv);
                $this->set('roundProf', $siteChanges->profile_image_view);
                $this->set('userid', $userid);
                $this->set('usershipping', $usershipping);
            }
        }

                //INVITE FRIENDS
        public function Invitefriends($provider = null)
        {
            global $loguser;
            $username = $loguser['username'];
            $siteurlsfor_ref = SITE_URL . 'signup?referrer=' . $username . '';
            $siteurlsref = $siteurlsfor_ref;
            $this->set('title_for_layout', 'Invite Friends');
            $sitesettings = TableRegistry::get('sitesettings')->find('all')->first();
            $socialId = json_decode($sitesettings->social_id, true);
            $banner_datas = TableRegistry::get('Banners')->find('all')->where(['banner_type' => 'invitefriends'])->first();
            $this->set(compact("banner_datas", "socialId", "sitesettings", "username", "siteurlsref", ""));
            try {
                if ($provider == "Twitter") {
                    require_once(WWW_ROOT . 'hybridauth/Hybrid/Auth.php');
                    $hybridauth_config = array(
                        "base_url" => $_SESSION['media_url'] . "hybridauth/", // set hybridauth path

                        "providers" => array(
                            "Twitter" => array(
                                "enabled" => true,
                                "keys" => array("key" => $socialId['TWITTER_ID'], "secret" => $socialId['TWITTER_SECRET'])
                            )
                                        // for another provider refer to hybridauth documentation
                        )
                    );

                        // create an instance for Hybridauth with the configuration file path as parameter

                    if (!empty($hybridauth_config)) {
                        $hybridauth = new \Hybrid_Auth($hybridauth_config);
                    }
                    $adapter = $hybridauth->authenticate("Twitter");
                    echo "<pre>";
                    print_r($adapter);
                    die;
                    $user_contacts = $adapter->getUserContacts();
                    foreach ($user_contacts as $contact) {
                        $contact->displayName . " " . $contact->profileURL . "<hr />";
                    }

                    $this->set('user_contacts', $user_contacts);
                }

                if ($provider == "Google") {
                    $client_id = $socialId['GMAIL_CLIENT_ID'];
                    $client_secret = $socialId['GMAIL_CLIENT_SECRET'];
                    $redirect_uri = SITE_URL . 'invite_friends/Google/';
                    $max_results = 500;
                    $auth_code = $_GET["code"];
                    $fields = array(
                        'code' => urlencode($auth_code),
                        'client_id' => urlencode($client_id),
                        'client_secret' => urlencode($client_secret),
                        'redirect_uri' => urlencode($redirect_uri),
                        'grant_type' => urlencode('authorization_code')
                    );
                    $post = '';
                    foreach ($fields as $key => $value) {
                        $post .= $key . '=' . $value . '&';
                    }
                    $post = rtrim($post, '&');

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
                    curl_setopt($curl, CURLOPT_POST, 5);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    $result = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($result);
                    $accesstoken = $response->access_token;
                    $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&oauth_token=' . $accesstoken;
                    $curl = curl_init();
                    $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

                    curl_setopt($curl, CURLOPT_URL, $url);    //The URL to fetch. This can also be set when initializing a session with curl_init().
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
                    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);    //The number of seconds to wait while trying to connect.

                    curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);  //The contents of the "User-Agent: " header to be used in a HTTP request.
                    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);   //To follow any "Location: " header that the server sends as part of the HTTP header.
                    curl_setopt($curl, CURLOPT_AUTOREFERER, true);  //To automatically set the Referer: field in requests where it follows a Location: redirect.
                    curl_setopt($curl, CURLOPT_TIMEOUT, 10);    //The maximum number of seconds to allow cURL functions to execute.
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  //To stop cURL from verifying the peer's certificate.
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

                    $xmlresponse = curl_exec($curl);
                    curl_close($curl);
                    if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr($xmlresponse, 'Error ')) > 0)) {
                        echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
                        exit();
                    }
                    $xml = new SimpleXMLElement($xmlresponse);
                    $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
                    $result = $xml->xpath('//gd:email');

                    $this->set('result', $result);

                }
            } catch (Exception $e) {
                $this->Flash->error(__d('user', 'Something went wrong, please try again.'));
                $this->redirect($this->referer());
            }
        }

                //PEOPLE SEARCH
        public function peoplesearch($name = null)
        {
            $this->set('title_for_layout', 'Find People');
            global $loguser;
            $sitesettings = TableRegistry::get('sitesettings')->find('all')->first();
            $siteChanges = json_decode($sitesettings->site_changes, true);
            $user_id = $loguser['id'];
            $issearch = 0;
            $username = $loguser['username'];
            $_SESSION['username_urls'] = $name;
            $banner_datas = TableRegistry::get('Banners')->find('all')->where(['banner_type' => 'findfriends'])->first();
            $followcnt = TableRegistry::get('Followers')->find()->where(['follow_user_id' => $user_id])->all();
            $userlevels = array('god', 'moderator', 'shop');
                    //set data
            $this->set(compact('banner_datas', 'followcnt', 'username'));
            $flwngusrids[] = 0;
            if (!empty($followcnt)) {
                foreach ($followcnt as $flcnt) {
                    $flwngusrids[] = $flcnt->user_id;
                }
            }
            if (!empty($this->request->data)) {
                $username_val = trim($this->request->data['search_people']) . '%';
                $issearch = 1;
            }
            if (!empty($username_val)) {
                $people_details = TableRegistry::get('Users')->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(function ($exp) use ($username_val, $user_id) {
                    return $exp
                    ->notEq('Users.activation', 0)
                    ->notEq('Users.id', $user_id)
                    ->like('Users.username', $username_val);
                })->order(['Users.id' => 'DESC'])->all();

            } elseif ($name == 1) {
                $people_details = TableRegistry::get('Users')->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(['Users.id NOT IN' => $flwngusrids])->where(function ($exp) use ($username_val, $user_id) {
                    return $exp
                    ->notEq('Users.activation', 0)
                    ->notEq('Users.id', $user_id);
                })->order(['Users.id' => 'DESC'])->all();
            } else {
                $people_details = TableRegistry::get('Users')->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(['Users.id NOT IN' => $flwngusrids])->where(function ($exp) use ($username_val, $user_id) {
                    return $exp
                    ->notEq('Users.activation', 0)
                    ->notEq('Users.id', $user_id);
                })->order(['Users.id' => 'DESC'])->all();
            }
            foreach ($people_details as $ppl_dtl) {
                $itemfavs = $ppl_dtl->itemfavs;
                foreach ($itemfavs as $ppl_dt) {
                    $ppl_dtda = $ppl_dt['item_id'];
                    $pho_datas[$ppl_dtda] = TableRegistry::get('Photos')->find('all')->where(['item_id' => $ppl_dtda])->all;
                }
            }
            if (isset($people_details)) {
                $this->set('people_details', $people_details);
            }
            if (isset($username_val)) {
                $this->set('username_val', $username_val);
            }
            $this->set('userid', $loguser['id']);
            $this->set('issearch', $issearch);
            $this->set('followcnt', $followcnt);
            $this->set('roundProf', $siteChanges['profile_image_view']);

        }

        public function getmorepeoplesearch($name = null)
        {
            $offset = $_POST['offset'];

            global $loguser;
            $sitesettings = TableRegistry::get('sitesettings')->find('all')->first();
            $siteChanges = json_decode($sitesettings->site_changes, true);
            $user_id = $loguser['id'];

            $issearch = 0;
            $username = $loguser['username'];
            $_SESSION['username_urls'] = $name;
            $banner_datas = TableRegistry::get('Banners')->find('all')->where(['banner_type' => 'findfriends'])->first();
            $followcnt = TableRegistry::get('Followers')->find()->where(['follow_user_id' => $user_id])->all();
            $userlevels = array('god', 'moderator', 'shop');
                    //set data
            $this->set(compact('banner_datas', 'followcnt', 'username'));
            $flwngusrids[] = 0;
            if (!empty($followcnt)) {
                foreach ($followcnt as $flcnt) {
                    $flwngusrids[] = $flcnt->user_id;
                }
            }
            if (!empty($this->request->data)) {
                $username_val = trim($this->request->data['search_people']) . '%';
                $issearch = 1;
            }
            if (!empty($username_val)) {
                $people_details = TableRegistry::get('Users')->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(['Users.id NOT IN' => $flwngusrids])->where(function ($exp) use ($username_val, $user_id) {
                    return $exp
                    ->notEq('Users.activation', 0)
                    ->notEq('Users.id', $user_id)
                    ->like('Users.username', $username_val);
                })->limit(10)->offset($offset)->order(['Users.id' => 'DESC'])->all();

            } elseif ($name == 1) {
                $people_details = TableRegistry::get('Users')->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(['Users.id NOT IN' => $flwngusrids])->where(function ($exp) use ($username_val, $user_id) {
                    return $exp
                    ->notEq('Users.activation', 0)
                    ->notEq('Users.id', $user_id);
                })->offset($offset)->order(['Users.id' => 'DESC'])->all();
            } else {
                $people_details = TableRegistry::get('Users')->find()->contain('Itemfavs')->where(['Users.user_level NOT IN' => $userlevels])->where(['Users.id NOT IN' => $flwngusrids])->where(function ($exp) use ($username_val, $user_id) {
                    return $exp
                    ->notEq('Users.activation', 0)
                    ->notEq('Users.id', $user_id);
                })->limit(10)->offset($offset)->order(['Users.id' => 'DESC'])->all();
            }
            foreach ($people_details as $ppl_dtl) {
                $itemfavs = $ppl_dtl->itemfavs;
                foreach ($itemfavs as $ppl_dt) {
                    $ppl_dtda = $ppl_dt['item_id'];
                    $pho_datas[$ppl_dtda] = TableRegistry::get('Photos')->find('all')->where(['item_id' => $ppl_dtda])->all;
                }
            }
            if (isset($people_details)) {
                $this->set('people_details', $people_details);
            }
            if (isset($username_val)) {
                $this->set('username_val', $username_val);
            }
            $this->set('userid', $loguser['id']);
            $this->set('issearch', $issearch);
            $this->set('followcnt', $followcnt);
            $this->set('roundProf', $siteChanges['profile_image_view']);

        }
                //USERNAME AUTOCOMPLETE
        public function autocompleteusernames()
        {
            $this->layout = "ajax";
            $this->autoRender = false;
            global $loguser;
            $loguserid = $loguser['id'];
            $searchWord = '%' . trim($this->request->data['searchStr']) . '%';
            $userDetails = TableRegistry::get('Users')->find()->where(function ($exp) use ($searchWord, $loguserid) {
                return $exp
                ->notEq('Users.user_level', 'god')
                ->notEq('Users.user_level', 'moderator')
                ->notEq('Users.user_level', 'shop')
                ->notEq('Users.id', $loguserid)
                ->like('Users.username', $searchWord);
            })->limit(10)->order(['Users.id' => 'DESC'])->all();


            foreach ($userDetails as $userData) {
                $usernames[] = $userData->username;
            }
            echo json_encode($usernames);
        }

                //NOTIFICATIONS PAGE
        public function pushnotifications($status = null)
        {
            global $loguser;
            $userid = $loguser['id'];
            $usercreateddate = strtotime($loguser['created_at']);
            $user_created = strtotime($loguser['created_at']);
            $itemstable = TableRegistry::get('Items');
            $commentstable = TableRegistry::get('Comments');
            $itemsfavstable = TableRegistry::get('Itemfavs');
            $followerstable = TableRegistry::get('Followers');
            $logstable = TableRegistry::get('Logs');
            $userstable = TableRegistry::get('Users');
            $storefollowerstable = TableRegistry::get('Storefollowers');
            $shopstable = TableRegistry::get('Shops');

            $itemfavid = array();
            $userModel = $userstable->find('all')->where(['id' => $userid])->first();
            $followcnt = $followerstable->followcntarray($userid);
            if (!empty($followcnt)) {
                foreach ($followcnt as $flcnt) {
                    $flwngusrids[] = $flcnt->user_id;
                    $flwruserid[] = $flcnt->user_id;
                }
                $flwngusrids[] = $userid;
            } else {
                $flwngusrids = $userid;
                $flwruserid = $userid;
            }
            $userlevels = array('god', 'moderator');

                    //PEOPLE FOLLOWED BY USER
            $people_details = $userstable->find('all')->where(['id NOT IN' => $flwngusrids])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
                return $exp->notEq('activation', '0');
            })->order(['Users.id DESC'])->limit(5);

                    //STORES FOLLOWED BY USER
            $storeflwrscnt = $storefollowerstable->find('all')->where(['follow_user_id' => $userid])->all();
            foreach ($storeflwrscnt as $storeflwr) {
                $flwshopid = $storeflwr['store_id'];
                $shopModel = $shopstable->find('all')->where(['id' => $flwshopid])->first();
                $storeflwruserid[] = $shopModel->user_id;

            }

            if (empty($flwruserid)) {
                $flwruserid = array();
            }
            if (empty($storeflwruserid)) {
                $storeflwruserid = array();
            }
            $flwruserid = array_merge($storeflwruserid, $flwruserid);
            $notificationSettings = json_decode($userModel['push_notifications'], true);
            if ($notificationSettings['somone_cmnts_push'] == 1) {
                $itemfav = $itemsfavstable->find('all')->where(['user_id' => $userid])->all();
                foreach ($itemfav as $fav) {
                    $itemfavid[] = $fav->item_id;
                }
            }
            $followType = 'additem';
            if ($notificationSettings['frends_cmnts_push'] == 0) {
                $followType = array();
                $followType[] = 'additem';
                $followType[] = 'comment';
            }
            $addedItems = array();
            if ($notificationSettings['frends_flw_push'] == 1) {
                $addedItems['userid IN'] = $flwruserid;
                $addedItems['type'] = 'additem';
            }

            if ($status == 'livefeeds') {
                $typeAs[] = 'follow';
                $typeAs[] = 'review';
                $typeAs[] = 'groupgift';
                $typeAs[] = 'sellermessage';
                $typeAs[] = 'admin';
                $typeAs[] = 'dispute';
                $typeAs[] = 'orderstatus';
                $typeAs[] = 'ordermessage';
                $typeAs[] = 'itemapprove';
                $typeAs[] = 'chatmessage';
                $typeAs[] = 'invite';
                $typeAs[] = 'credit';
                $typeAs[] = 'cartnotification';
                $typeConditions['type NOT IN'] = $typeAs;
            } else {
                $typeAs[] = 'comment';
                $typeAs[] = 'mentioned';
                $typeAs[] = 'status';
                $typeAs[] = 'additem';
                $typeAs[] = 'favorite';
                $typeConditions['type NOT IN'] = $typeAs;
            }
            $adminnotify = array('0', $userid);
                    // LOG NOTIFICATIONS
            $query = $logstable->query();
            if (!empty($flwruserid) && !empty($itemfavid)) {
                $userlogd = $query->where(['OR' =>
                    [
                        ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0, 'type <>' => 'sellermessage'],
                        ['itemid IN' => $itemfavid, 'type' => 'comment'],
                        ['notifyto' => $userid],
                        [$addedItems],
                        ['type' => 'admin', 'notifyto IN' => $adminnotify],
                        ['userid' => $userid, 'type' => 'status']
                    ]])->where($typeConditions)->where(['cdate >' => $usercreateddate])->order(['id DESC'])->limit(15)->all();

            } elseif (!empty($flwruserid)) {
                $userlogd = $query->where(['OR' =>
                    [
                        ['userid IN' => $flwruserid, 'type NOT IN' => $followType, 'notifyto' => 0, 'type <>' => 'sellermessage'],
                        ['notifyto' => $userid],
                        [$addedItems],
                        ['type' => 'admin', 'notifyto IN' => $adminnotify],
                        ['userid' => $userid, 'type' => 'status']
                    ]])->where($typeConditions)->where(['cdate >' => $usercreateddate])->order(['id DESC'])->limit(15)->all();

            } elseif (!empty($itemfavid)) {
                $userlogd = $query->where(['OR' =>
                    [
                        ['notifyto' => $userid],
                        ['itemid IN' => $itemfavid, 'type' => 'comment'],
                        ['type' => 'admin', 'notifyto IN' => $adminnotify],
                        ['userid' => $userid, 'type' => 'status']
                    ]])->where($typeConditions)->where(['cdate >' => $usercreateddate])->order(['id DESC'])->limit(15)->all();

            } else {
                $userlogd = $query->where(['OR' =>
                    [
                        ['notifyto' => $userid],
                        ['type' => 'admin', 'notifyto IN' => $adminnotify, 'cdate >=' => $user_created],
                        ['userid' => $userid, 'type' => 'status']
                    ]])->where($typeConditions)->where(['cdate >' => $usercreateddate])->order(['id DESC'])->limit(15)->all();

            }

            $decoded_value = json_decode($userModel['push_notifications']);
                    //RECENT ACTIVITY
            $recentactivityType = array('comment', 'orderstatus', 'status', 'sellermessage');
            $recentactivity = $logstable->find('all')->where(['userid' => $userid])->where(['cdate >' => $usercreateddate])->where(['type IN' => $recentactivityType])->order(['id DESC'])->limit('5')->all();

            $userDetails = array();
            foreach ($recentactivity as $activity) {
                $activityType = $activity['type'];
                if ($activityType == 'follow') {
                    $followId = $activity['userid'];
                    $userDetails[$followId] = $userstable->get($followId);
                }
            }

            $query = $userstable->query();
            $query->update()
            ->set(['unread_livefeed_cnt' => "'0'"])
            ->where(['Users.id' => $userid])
            ->execute();
                    //SET DATA
            $this->set('loguserdetails', $userlogd);
            $this->set('fantacy', $setngs[0]['Sitesetting']['liked_btn_cmnt']);
            $this->set('result', $status);
            $this->set(compact("decoded_value", "userid", "recentactivity", "people_details", "userDetails"));
        }


        /* FLASH MESSAGE */
        public function Flashmessage($status = null, $message = null, $url = null)
        {
            if ($status == 'success' && !empty($message)) {
                $this->Flash->success(__($message));
            } else if ($status == 'error' && !empty($message)) {
                $this->Flash->error(__($message));
            }
            if (!empty($url))
                $this->redirect($url);
            return true;
        }


        /** SET LANGUAGE **/
        public function Setlanguage()
        {
            $this->autoLayout = false;
            $this->autoRender = false;
            if (isset($_POST['language']) && $_POST['language'] != '') {
                $lang_count = TableRegistry::get('Languages')->find()->where(['languagename' => $_POST['language']])->count();
                if ($lang_count > 0) {
                    $lang_details = TableRegistry::get('Languages')->find()->where(['languagename' => $_POST['language']])->first();
                    $session = $this->request->session();
                    $session->write('Config.languagecode', $lang_details['languagecode']);
                    unset($_SESSION['languagecode']);
                    unset($_SESSION['languagename']);
                    $_SESSION['languagecode'] = $lang_details['languagecode'];
                    $_SESSION['languagename'] = $lang_details['languagename'];
                    echo $_SESSION['languagecode'];

                }
            }
        }

        /** SEND MAILS **/
        public function samplemailfunction()
        {
            $email = 'sarvanan@hitasoft.com';
            $aSubject = 'dsdad';
            $aBody = 'dsadsadsadsadsadas';
            $template = 'useradded';
            $setdata = array('name' => 'kannan');
            $this->sendmail($email, $aSubject, $aBody, $template, $setdata);
        }

        public function changecurrency($currency)
        {
            $this->autoRender = false;
            $forexratestable = TableRegistry::get('Forexrates');

            $forexrateModel = $forexratestable->find()->where(['currency_code' => $currency])->first();
            $_SESSION['currency_symbol'] = $forexrateModel['currency_symbol'];
            $_SESSION['currency_value'] = $forexrateModel['price'];
            $_SESSION['currency_code'] = $forexrateModel['currency_code'];

            $session = $this->request->session();
            $session->write('Config.currency_symbol', $forexrateModel['currency_symbol']);
            $this->redirect($this->referer());
        }


        function sitemaintenance()
        {
            $this->loadModel('Managemodules');
            $sitesettings = TableRegistry::get('sitesettings');
            $setngs = $sitesettings->find()->first();
            $managemoduleModel = $this->Managemodules->find()->first();
            if ($managemoduleModel->site_maintenance_mode == 'no') {
                $this->redirect('/');
            }
            $this->autoLayout = false;
            $this->set('title_for_layout', 'Site Maintenance');
            $this->set('setngs', $setngs);

            $this->set('adminmessage', $managemoduleModel->maintenance_text);
        }

        function updateprice()
        {
            $itemstable = TableRegistry::get('Items');
            $itemdatas = $itemstable->find()->all();
            foreach ($itemdatas as $key => $item) {
                $sizeoptions = json_decode($item['size_options'], true);
                if (!empty($sizeoptions)) {
                    $prices = [];
                    foreach ($sizeoptions['price'] as $key => $value) {
                        $prices[] = $value;
                    }
                    print_r($prices);
                    $itemquery = $itemstable->query();
                    if ($itemquery->update()
                        ->set(['price' => $prices[0]])
                        ->where(['Items.id' => $item['id']])
                        ->execute())
                        echo "success";
                    else
                        echo "error";
                }
            }
        }

        /* INVITE FRIENDS */
        public function sendinviteemailref()
        {
            global $loguser;
            global $setngs;
            $inviter_email = $loguser['email'];
            $user_id = $loguser['id'];
            $username = $loguser['username'];
            $firstname = $loguser['first_name'];
            $this->autoRender = false;
            $sitesettings = TableRegistry::get('sitesettings');
            $setngs = $sitesettings->find()->first();
            $emailids = $_POST['emails'];
            $msg = $_POST['msg'];
            $toemail = json_decode($emailids, 'true');
            for ($i = 0; $i < count($toemail); $i++) {
                $this->loadModel('Userinvites');
                $userinvitestable = TableRegistry::get('Userinvites');
                $userinviteModel = $userinvitestable->find()->where(['invited_email' => $toemail[$i], 'user_id' => $user_id])->count();
                if ($userinviteModel == 0) {
                    $userinvitedatas = $userinvitestable->newEntity();
                    $userinvitedatas->user_id = $user_id;
                    $userinvitedatas->invited_email = $toemail[$i];
                    $userinvitedatas->status = 'Invited';
                    $userinvitedatas->invited_date = time();
                    $userinvitedatas->cdate = time();
                    $userinvitestable->save($userinvitedatas);
                }
                $emails = $toemail[$i];
                $aSubjects = $setngs['site_name'] . " – $firstname invites you to join " . $setngs['site_name'];
                $aBodys = '';
                $templates = 'invitemail';
                $setdatas = array('userr' => $toemail[$i], 'msg' => $msg, 'loguser' => $loguser, 'username' => $username, 'sitename' => $setngs['site_name']);
                $this->sendmail($emails, $aSubjects, $aBodys, $templates, $setdatas);

            }

        }

        public function sociallogin()
        {

        }


        /*
            Code start kalidas
        */

        public function convertJsonHome($items_data, $favitems_ids = null, $user_id = null, $temp = null)
    {
        //echo "herecomes";die;
        $this->loadModel('Contactsellers');
        $this->loadModel('Itemfavs');
        $this->loadModel('Sitequeries');
        $this->loadModel('Facebookcoupons');
        $this->loadModel('Forexrates');
        $this->loadModel('Photos');
        $this->loadModel('Users');
        $this->loadModel('Sitesettings');
        $this->loadModel('Shops');
        $this->loadModel('Itemreviews');
        $setngs = $this->Sitesettings->find()->toArray();
        $photos = $this->Photos->find()->order(['id DESC'])->all();

        $forexrateModel = $this->Forexrates->find()->where(['cstatus' => 'default'])->first();
      //  echo"<pre>"; print_r($items_data);die;
        $resultArray = array();
        $resultArray['type'] = "Everything";
        if ($type != null)
            $resultArray['type'] = $type;
        $resultArray = array();
        $shareCouponDetail = array();

        if (SITE_URL == $setngs[0]['media_url']) {
            $img_path = $setngs[0]['media_url'];
        } else {
            $img_path = $setngs[0]['media_url'];
        }
        $userDetail = $this->Users->find()->where(['id' => $user_id])->first();

        if (!empty($userDetail))
            $userId = $userDetail['id'];
        else
            $userId = $userId;

        $currency_value = $this->Forexrates->find()->where(['id' => $userDetail['currencyid']])->first();
        if ($currency_value['currency_code'] == $forexrateModel['currency_code'] || $currency_value['currency_code'] == "" || count($userDetail) == 0) {
            $cur_symbol = $forexrateModel['currency_symbol'];
            $cur = $forexrateModel['price'];
        } else {
            $cur_symbol = $currency_value['currency_symbol'];
            $cur = $currency_value['price'];
        }
        $items_fav_data = $this->Itemfavs->find()->where(['user_id' => $user_id])->all();//
        if (count($items_fav_data) > 0) {
            foreach ($items_fav_data as $favitems) {
                $favitems_ids[] = $favitems['item_id'];
            }
        } else {
            $favitems_ids = array();
        }

        foreach ($items_data as $key => $listitem) {
           // echo"<pre>";print_r($listitem);


            $sizeprice = [];

            $reportUsers = '';
            $process_time = $listitem['processing_time'];
            if ($process_time == '1d') {
                $process_time = "One business day";
            } elseif ($process_time == '2d') {
                $process_time = "Two business days";
            } elseif ($process_time == '3d') {
                $process_time = "Three business days";
            } elseif ($process_time == '4d') {
                $process_time = "Four business days";
            } elseif ($process_time == '2ww') {
                $process_time = "One-Two weeks";
            } elseif ($process_time == '3w') {
                $process_time = "Two-Three weeks";
            } elseif ($process_time == '4w') {
                $process_time = "Three-Four weeks";
            } elseif ($process_time == '6w') {
                $process_time = "Four-Six weeks";
            } elseif ($process_time == '8w') {
                $process_time = "Six-Eight weeks";
            }
            $shareSeller = $listitem['share_coupon'];

            $shareCouponDetail = $this->Facebookcoupons->find()->where(['item_id' => $listitem['id']])->andWhere(['user_id' => $user_id])->all();//all',array('conditions'=>array('Facebookcoupon.item_id'=> $listitem['Item']['id'] , 'Facebookcoupon.user_id'=> $userId )));
            if (count($shareCouponDetail) != 0)
                $shareUser = "yes";
            else
                $shareUser = "no";

            $resultArray[$key]['id'] = $listitem['id'];
            $resultArray[$key]['item_title'] = substr($listitem['item_title'], 0, 40);
            $resultArray[$key]['item_title_url'] = substr($listitem['item_title_url'], 0, 40);

            $resultArray[$key]['item_description'] = $listitem['item_description'];
            $resultArray[$key]['currency'] = $cur_symbol;
            $resultArray[$key]['avg_rating'] = $listitem['avg_rating'];
             $totalreviews = $this->Itemreviews->find()->where(['itemid' => $listitem['id']])->all();//
         $resultArray[$key]['rating_count'] = count($totalreviews);
            //echo "userid===";$listitem['item']['user_id'];die;
             $sellerdetails = $this->Users->find()->where(['id' => $listitem['user_id'] ])->first();
            $shopdetails = $this->Shops->find()->where(['id' => $listitem['shop_id'] ])->first();

              $resultArray[$key]['username'] = $sellerdetails->username;
               $resultArray[$key]['shop_name'] = $shopdetails->shop_name;
            // echo"<pre>";print_r($sellerdetails);die;

            if(isset($listitem['related_items']))
            {
                //echo '<pre>'; print_r($listitem); die;
                //$arraylists =  (array)$listitem;

                //echo '<pre>'; print_r($listitem['related_items']); die;
                $resultArray[$key]['related_items'] = $this->convertJsonHomesuggested($listitem['related_items'], $favitems_ids, $_POST['user_id']);             
            }


            if ($listitem['size_options'] != "") {
                $sizes = json_decode($listitem['size_options'], true);

                //  if($sizes!=""){

                foreach ($sizes['price'] as $key1 => $value) {

                    $sizeprice[] = $value;
                }

                $resultArray[$key]['mainprice'] = $sizeprice[0];
                $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $sizeprice[0]);
                $resultArray[$key]['price'] = $price;

                    //}
            } else {

                $resultArray[$key]['mainprice'] = $listitem['price'];
                $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $listitem['price']);
                $resultArray[$key]['price'] = $price;
            }

            $today = strtotime(date("Y-m-d"));
            $dealdate1 = date("Y-m-d", strtotime($listitem['dealdate']));
            $dealDate = strtotime($dealdate1);
            $resultArray[$key]['discount_type'] = $listitem['discount_type'];
            if ($listitem['discount_type'] == 'daily' && $dealDate == $today) {
                $discount = $listitem['discount'];
                $dealdate = date("Y-m-d", strtotime($listitem['dealdate']));//.' 24:00:00';
                $dealdate = strtotime($dealdate);

                $resultArray[$key]['deal_enabled'] = 'yes';
                $resultArray[$key]['discount_percentage'] = $discount;
                $resultArray[$key]['valid_till'] = $dealdate;
                  $dealprice = $listitem['price'] * ( 1 - $listitem['discount'] / 100 );
                 $user_currency_dealprice =  $this->Currency->conversion($listitem['forexrate']['price'],$_SESSION['currency_value'],$dealprice);
                $resultArray[$key]['discount_price'] = $dealprice;
                 $resultArray[$key]['currency_discount_price'] = $user_currency_dealprice;
                 
            } elseif($listitem['discount_type'] == 'regular') {
                $resultArray[$key]['deal_enabled'] = 'yes';
                $resultArray[$key]['discount_percentage'] = $discount;
                $resultArray[$key]['valid_till'] = "";
                  $dealprice = $listitem['price'] * ( 1 - $listitem['discount'] / 100 );

$user_currency_dealprice = $this->Currency->conversion($listitem['forexrate']['price'],$_SESSION['currency_value'],$dealprice);
                 $resultArray[$key]['discount_price'] = $dealprice;
                 $resultArray[$key]['currency_discount_price'] = $user_currency_dealprice;
            } else {
                $resultArray[$key]['deal_enabled'] = 'no';
                $resultArray[$key]['discount_percentage'] = "";
                $resultArray[$key]['valid_till'] = "";
               
            }

            

            $resultArray[$key]['discount_type'] = $listitem['discount_type'];
            $resultArray[$key]['discount'] = $listitem['discount'];
            $resultArray[$key]['dealdate'] = $listitem['dealdate'];
            $resultArray[$key]['dealdatetwo'] = $listitem['dealdate'];
            


            $resultArray[$key]['quantity'] = $listitem['quantity'];
            $resultArray[$key]['cod'] = $listitem['cod'];

            $resultArray[$key]['forexrate'] = $listitem['forexrate'];

            if (in_array($listitem['id'], $favitems_ids)) {
                $resultArray[$key]['liked'] = 'yes';
            } else {
                $resultArray[$key]['liked'] = 'no';
            }

            $item_status = json_decode($listitem['report_flag'], true); //print_r($item_status); die;

            if (in_array($userId, $item_status)) {
                $report_status = "yes";
            } else {
                $report_status = "no";

            }

            $resultArray[$key]['report'] = $report_status;
            $likedcount = $this->Itemfavs->find()->where(['item_id' => $listitem['id']])->count();
            $resultArray[$key]['like_count'] = $likedcount;
            $resultArray[$key]['fbshare_discount'] = $listitem['share_discountAmount'];
            $resultArray[$key]['reward_points'] = floor($convertdefaultprice);
            $resultArray[$key]['share_seller'] = $shareSeller;
            $resultArray[$key]['share_user'] = $shareUser;
            if ($listitem['status'] == 'publish') {
                $resultArray[$key]['approve'] = true;
            } else {
                $resultArray[$key]['approve'] = false;
            }
            if ($listitem['status'] == 'things') {
                $resultArray[$key]['buy_type'] = "affiliate";
            } else if ($listitem['status'] == 'publish') {
                $resultArray[$key]['buy_type'] = "buy";
            }

            
            $resultArray[$key]['affiliate_link'] = $listitem['bm_redircturl'];
            $resultArray[$key]['shipping_time'] = $process_time;
                //$resultArray[$key]['product_url'] = SITE_URL.'listing/'.$listitem['id'].'/'.$listitem['item_title_url'];
            $itemid = base64_encode($listitem['id'] . "_" . rand(1, 9999));
            $resultArray[$key]['product_url'] = SITE_URL . 'listing/' . $itemid;
            if ($temp == 1) {
                $resultArray[$key]['size'] = [];
                if (empty($listitem['size_options'])) {//size":[{"name":"No size","qty":"100","price":"91"}]
                $resultArray[$key]['size'][0]['name'] = "";
                $resultArray[$key]['size'][0]['qty'] = $listitem['quantity'];
                $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $listitem['price']);
                $resultArray[$key]['size'][0]['price'] = $price;
            } else {
                $sizes = json_decode($listitem['size_options'], true);
                $sqkey = 0;
                foreach ($sizes['size'] as $val) {
                    if (count($sizes['unit'][$val]) > 0) {
                        $resultArray[$key]['size'][$sqkey]['name'] = $val;
                        $resultArray[$key]['size'][$sqkey]['qty'] = $sizes['unit'][$val];
                        $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $sizes['price'][$val]);
                        $resultArray[$key]['size'][$sqkey]['price'] = $price;
                        $sqkey++;
                    }
                }
            }
        }

            $sitequeriesModel = $this->Sitequeries->find()->where(['type' => 'contact_seller'])->first();//
            $csqueries = json_decode($sitequeriesModel['queries'], true);



            foreach ($photos as $keys => $photo) {
                $itemIds[] = $photo['item_id'];

                if ($listitem['id'] == $photo['item_id']) {
                    $imageName = $photo['image_name'];
                    if ($imageName == '') {
                        $imageName = "usrimg.jpg";
                    }

                    $resultArray[$key]['orig_image'] = $img_path . 'media/items/original/' . $photo['image_name'];

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    }

                    if ($keys == 0) {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    } else {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    }

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    }
                }

            }

            if (!in_array($listitem['id'], $itemIds)) {
                $image = $img_path . 'media/items/thumb350/usrimg.jpg';
                list($width, $height) = getimagesize($image);
                $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/usrimg.jpg';
                $resultArray[$key]['height'] = $height;
                $resultArray[$key]['width'] = $width;
            }

        }
       // echo"<pre>";print_r($resultArray); die;
        return $resultArray;
    }


    public function convertJsonHomenew($items_data, $favitems_ids = null, $user_id = null, $temp = null)
    {

        $this->loadModel('Contactsellers');
        $this->loadModel('Itemfavs');
        $this->loadModel('Sitequeries');
        $this->loadModel('Facebookcoupons');
        $this->loadModel('Forexrates');
        $this->loadModel('Photos');
        $this->loadModel('Users');
        $this->loadModel('Sitesettings');
        $setngs = $this->Sitesettings->find()->toArray();
        $photos = $this->Photos->find()->order(['id DESC'])->all();

        $forexrateModel = $this->Forexrates->find()->where(['cstatus' => 'default'])->first();

        $resultArray = array();
        $resultArray['type'] = "Everything";
        if ($type != null)
            $resultArray['type'] = $type;
        $resultArray = array();
        $shareCouponDetail = array();

        if (SITE_URL == $setngs[0]['media_url']) {
            $img_path = $setngs[0]['media_url'];
        } else {
            $img_path = $setngs[0]['media_url'];
        }
        $userDetail = $this->Users->find()->where(['id' => $user_id])->first();

        if (!empty($userDetail))
            $userId = $userDetail['id'];
        else
            $userId = $userId;

        $currency_value = $this->Forexrates->find()->where(['id' => $userDetail['currencyid']])->first();
        if ($currency_value['currency_code'] == $forexrateModel['currency_code'] || $currency_value['currency_code'] == "" || count($userDetail) == 0) {
            $cur_symbol = $forexrateModel['currency_symbol'];
            $cur = $forexrateModel['price'];
        } else {
            $cur_symbol = $currency_value['currency_symbol'];
            $cur = $currency_value['price'];
        }
        $items_fav_data = $this->Itemfavs->find()->where(['user_id' => $user_id])->all();//
        if (count($items_fav_data) > 0) {
            foreach ($items_fav_data as $favitems) {
                $favitems_ids[] = $favitems['item_id'];
            }
        } else {
            $favitems_ids = array();
        }
        



        foreach ($items_data as $key => $listitem) {

            

            $sizeprice = [];

            $reportUsers = '';
            $process_time = $listitem['processing_time'];
            if ($process_time == '1d') {
                $process_time = "One business day";
            } elseif ($process_time == '2d') {
                $process_time = "Two business days";
            } elseif ($process_time == '3d') {
                $process_time = "Three business days";
            } elseif ($process_time == '4d') {
                $process_time = "Four business days";
            } elseif ($process_time == '2ww') {
                $process_time = "One-Two weeks";
            } elseif ($process_time == '3w') {
                $process_time = "Two-Three weeks";
            } elseif ($process_time == '4w') {
                $process_time = "Three-Four weeks";
            } elseif ($process_time == '6w') {
                $process_time = "Four-Six weeks";
            } elseif ($process_time == '8w') {
                $process_time = "Six-Eight weeks";
            }
            $shareSeller = $listitem['share_coupon'];

            $shareCouponDetail = $this->Facebookcoupons->find()->where(['item_id' => $listitem['id']])->andWhere(['user_id' => $user_id])->all();//all',array('conditions'=>array('Facebookcoupon.item_id'=> $listitem['Item']['id'] , 'Facebookcoupon.user_id'=> $userId )));
            if (count($shareCouponDetail) != 0)
                $shareUser = "yes";
            else
                $shareUser = "no";

            $resultArray[$key]['id'] = $listitem['id'];
            $resultArray[$key]['item_title'] = $listitem['item_title'];
            $resultArray[$key]['item_description'] = $listitem['item_description'];
            $resultArray[$key]['currency'] = $cur_symbol;


            if(isset($listitem['related_products']))
            {
                //echo '<pre>'; print_r($listitem); die;
                //$arraylists =  (array)$listitem;
                $resultArray[$key]['related_items'] = $this->convertJsonHomesuggested($listitem['related_products'], $favitems_ids, $_POST['user_id']);             
            }


            if ($listitem['size_options'] != "") {
                $sizes = json_decode($listitem['size_options'], true);

                //  if($sizes!=""){

                foreach ($sizes['price'] as $key1 => $value) {

                    $sizeprice[] = $value;
                }

                $resultArray[$key]['mainprice'] = $sizeprice[0];
                $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $sizeprice[0]);
                $resultArray[$key]['price'] = $price;

                    //}
            } else {
                
                $resultArray[$key]['mainprice'] = $listitem['price'];
                $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $listitem['price']);
                $resultArray[$key]['price'] = $price;
            }

            $today = strtotime(date("Y-m-d"));
            $dealdate1 = date("Y-m-d", strtotime($listitem['dealdate']));
            $dealDate = strtotime($dealdate1);
            $resultArray[$key]['discount_type'] = $listitem['discount_type'];
            if ($listitem['discount_type'] == 'daily' && $dealDate == $today) {
                $discount = $listitem['discount'];
                $dealdate = date("Y-m-d", strtotime($listitem['dealdate']));//.' 24:00:00';
                $dealdate = strtotime($dealdate);

                $resultArray[$key]['deal_enabled'] = 'yes';
                $resultArray[$key]['discount_percentage'] = $discount;
                $resultArray[$key]['valid_till'] = $dealdate;
            } elseif($listitem['discount_type'] == 'regular') {
                $resultArray[$key]['deal_enabled'] = 'yes';
                $resultArray[$key]['discount_percentage'] = $discount;
                $resultArray[$key]['valid_till'] = "";
            } else {
                $resultArray[$key]['deal_enabled'] = 'no';
                $resultArray[$key]['discount_percentage'] = "";
                $resultArray[$key]['valid_till'] = "";
            }


            $resultArray[$key]['discount_type'] = $listitem['discount_type'];
            $resultArray[$key]['discount'] = $listitem['discount'];
            $resultArray[$key]['dealdate'] = strtotime($listitem['dealdate']);

            $resultArray[$key]['quantity'] = $listitem['quantity'];
            $resultArray[$key]['cod'] = $listitem['cod'];

            if (in_array($listitem['id'], $favitems_ids)) {
                $resultArray[$key]['liked'] = 'yes';
            } else {
                $resultArray[$key]['liked'] = 'no';
            }

            $item_status = json_decode($listitem['report_flag'], true); //print_r($item_status); die;

            if (in_array($userId, $item_status)) {
                $report_status = "yes";
            } else {
                $report_status = "no";

            }

            $resultArray[$key]['report'] = $report_status;
            $likedcount = $this->Itemfavs->find()->where(['item_id' => $listitem['id']])->count();
            $resultArray[$key]['like_count'] = $likedcount;
            $resultArray[$key]['fbshare_discount'] = $listitem['share_discountAmount'];
            $resultArray[$key]['reward_points'] = floor($convertdefaultprice);
            $resultArray[$key]['share_seller'] = $shareSeller;
            $resultArray[$key]['share_user'] = $shareUser;
            if ($listitem['status'] == 'publish') {
                $resultArray[$key]['approve'] = true;
            } else {
                $resultArray[$key]['approve'] = false;
            }
            if ($listitem['status'] == 'things') {
                $resultArray[$key]['buy_type'] = "affiliate";
            } else if ($listitem['status'] == 'publish') {
                $resultArray[$key]['buy_type'] = "buy";
            }

            
            $resultArray[$key]['affiliate_link'] = $listitem['bm_redircturl'];
            $resultArray[$key]['shipping_time'] = $process_time;
                //$resultArray[$key]['product_url'] = SITE_URL.'listing/'.$listitem['id'].'/'.$listitem['item_title_url'];
            $itemid = base64_encode($listitem['id'] . "_" . rand(1, 9999));
            $resultArray[$key]['product_url'] = SITE_URL . 'listing/' . $itemid;
            if ($temp == 1) {
                $resultArray[$key]['size'] = [];
                if (empty($listitem['size_options'])) {//size":[{"name":"No size","qty":"100","price":"91"}]
                $resultArray[$key]['size'][0]['name'] = "";
                $resultArray[$key]['size'][0]['qty'] = $listitem['quantity'];
                $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $listitem['price']);
                $resultArray[$key]['size'][0]['price'] = $price;
            } else {
                $sizes = json_decode($listitem['size_options'], true);
                $sqkey = 0;
                foreach ($sizes['size'] as $val) {
                    if (count($sizes['unit'][$val]) > 0) {
                        $resultArray[$key]['size'][$sqkey]['name'] = $val;
                        $resultArray[$key]['size'][$sqkey]['qty'] = $sizes['unit'][$val];
                        $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $sizes['price'][$val]);
                        $resultArray[$key]['size'][$sqkey]['price'] = $price;
                        $sqkey++;
                    }
                }
            }
        }

            $sitequeriesModel = $this->Sitequeries->find()->where(['type' => 'contact_seller'])->first();//
            $csqueries = json_decode($sitequeriesModel['queries'], true);

            foreach ($photos as $keys => $photo) {
                $itemIds[] = $photo['item_id'];

                if ($listitem['id'] == $photo['item_id']) {
                    $imageName = $photo['image_name'];
                    if ($imageName == '') {
                        $imageName = "usrimg.jpg";
                    }

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    }

                    if ($keys == 0) {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    } else {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    }

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    }
                }

            }
            if (!in_array($listitem['id'], $itemIds)) {
                $image = $img_path . 'media/items/thumb350/usrimg.jpg';
                list($width, $height) = getimagesize($image);
                $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/usrimg.jpg';
                $resultArray[$key]['height'] = $height;
                $resultArray[$key]['width'] = $width;
            }

        }

        return $resultArray;
    }


    public function convertJsonHomesuggested($items_data, $favitems_ids = null, $user_id = null, $temp = null)
    {

        $this->loadModel('Contactsellers');
        $this->loadModel('Itemfavs');
        $this->loadModel('Sitequeries');
        $this->loadModel('Facebookcoupons');
        $this->loadModel('Forexrates');
        $this->loadModel('Photos');
        $this->loadModel('Users');
        $this->loadModel('Sitesettings');
        $setngs = $this->Sitesettings->find()->toArray();
        $photos = $this->Photos->find()->order(['id DESC'])->all();

        $forexrateModel = $this->Forexrates->find()->where(['cstatus' => 'default'])->first();

        $resultArray = array();
        $resultArray['type'] = "Everything";
        if ($type != null)
            $resultArray['type'] = $type;
        $resultArray = array();
        $shareCouponDetail = array();

        if (SITE_URL == $setngs[0]['media_url']) {
            $img_path = $setngs[0]['media_url'];
        } else {
            $img_path = $setngs[0]['media_url'];
        }
        $userDetail = $this->Users->find()->where(['id' => $user_id])->first();

        if (!empty($userDetail))
            $userId = $userDetail['id'];
        else
            $userId = $userId;

        $currency_value = $this->Forexrates->find()->where(['id' => $userDetail['currencyid']])->first();
        if ($currency_value['currency_code'] == $forexrateModel['currency_code'] || $currency_value['currency_code'] == "" || count($userDetail) == 0) {
            $cur_symbol = $forexrateModel['currency_symbol'];
            $cur = $forexrateModel['price'];
        } else {
            $cur_symbol = $currency_value['currency_symbol'];
            $cur = $currency_value['price'];
        }
        $items_fav_data = $this->Itemfavs->find()->where(['user_id' => $user_id])->all();//
        if (count($items_fav_data) > 0) {
            foreach ($items_fav_data as $favitems) {
                $favitems_ids[] = $favitems['item_id'];
            }
        } else {
            $favitems_ids = array();
        }
        foreach ($items_data as $key => $listitem) {
            $sizeprice = [];

            $reportUsers = '';
            $process_time = $listitem['processing_time'];
            if ($process_time == '1d') {
                $process_time = "One business day";
            } elseif ($process_time == '2d') {
                $process_time = "Two business days";
            } elseif ($process_time == '3d') {
                $process_time = "Three business days";
            } elseif ($process_time == '4d') {
                $process_time = "Four business days";
            } elseif ($process_time == '2ww') {
                $process_time = "One-Two weeks";
            } elseif ($process_time == '3w') {
                $process_time = "Two-Three weeks";
            } elseif ($process_time == '4w') {
                $process_time = "Three-Four weeks";
            } elseif ($process_time == '6w') {
                $process_time = "Four-Six weeks";
            } elseif ($process_time == '8w') {
                $process_time = "Six-Eight weeks";
            }
            $shareSeller = $listitem['share_coupon'];

            $shareCouponDetail = $this->Facebookcoupons->find()->where(['item_id' => $listitem['id']])->andWhere(['user_id' => $user_id])->all();//all',array('conditions'=>array('Facebookcoupon.item_id'=> $listitem['Item']['id'] , 'Facebookcoupon.user_id'=> $userId )));
            if (count($shareCouponDetail) != 0)
                $shareUser = "yes";
            else
                $shareUser = "no";


            $getItems = $this->Items->find()->where(['id' => $listitem['id']])->first();

            $resultArray[$key]['id'] = $listitem['id'];
            $resultArray[$key]['item_title'] = $listitem['item_title'];
            $resultArray[$key]['item_description'] = $listitem['item_description'];
            $resultArray[$key]['currency'] = $cur_symbol;
            $resultArray[$key]['forexrate_price'] = $listitem['forexrate']['price'];
            if ($listitem['size_options'] != "") {
                $sizes = json_decode($listitem['size_options'], true);

                //  if($sizes!=""){

                foreach ($sizes['price'] as $key1 => $value) {

                    $sizeprice[] = $value;
                }

                $resultArray[$key]['mainprice'] = $sizeprice[0];
                $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $sizeprice[0]);
                $resultArray[$key]['price'] = $price;

                    //}
            } else {
                $resultArray[$key]['mainprice'] = $listitem['price'];
                $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $listitem['price']);
                $resultArray[$key]['price'] = $price;
            }
            $today = strtotime(date("Y-m-d"));
            $dealdate1 = date("Y-m-d", strtotime($listitem['dealdate']));
            $dealDate = strtotime($dealdate1);
            if ($listitem['dailydeal'] == 'yes' && $dealDate == $today) {
                $discount = $listitem['discount'];
                $dealdate = date("Y-m-d", strtotime($listitem['dealdate']));
                $dealdate = strtotime($dealdate);

                $resultArray[$key]['deal_enabled'] = 'yes';
                $resultArray[$key]['discount_percentage'] = $discount;
                $resultArray[$key]['valid_till'] = $dealdate;
            } else {
                $resultArray[$key]['deal_enabled'] = 'no';
                $resultArray[$key]['discount_percentage'] = "";
                $resultArray[$key]['valid_till'] = "";
            }


            $resultArray[$key]['discount_type'] = $listitem['discount_type'];
            $resultArray[$key]['discount'] = $listitem['discount'];
            $resultArray[$key]['dealdate'] = $listitem['dealdate'];
            if((isset($getItems->dealdate) && $getItems->dealdate != '') && isset($_SESSION['languagecode']) && $_SESSION['languagecode'] == "ar")
            {
                $resultArray[$key]['dealdatetwo'] = $getItems->dealdate->format('Y-m-d');
                //die;
            }

            $resultArray[$key]['quantity'] = $listitem['quantity'];
            $resultArray[$key]['cod'] = $listitem['cod'];

            if (in_array($listitem['id'], $favitems_ids)) {
                $resultArray[$key]['liked'] = 'yes';
            } else {
                $resultArray[$key]['liked'] = 'no';
            }

            $item_status = json_decode($listitem['report_flag'], true); //print_r($item_status); die;

            if (in_array($userId, $item_status)) {
                $report_status = "yes";
            } else {
                $report_status = "no";

            }
            $resultArray[$key]['report'] = $report_status;
            $likedcount = $this->Itemfavs->find()->where(['item_id' => $listitem['id']])->count();
            $resultArray[$key]['like_count'] = $likedcount;
            $resultArray[$key]['fbshare_discount'] = $listitem['share_discountAmount'];
            $resultArray[$key]['reward_points'] = floor($convertdefaultprice);
            $resultArray[$key]['share_seller'] = $shareSeller;
            $resultArray[$key]['share_user'] = $shareUser;
            if ($listitem['status'] == 'publish') {
                $resultArray[$key]['approve'] = true;
            } else {
                $resultArray[$key]['approve'] = false;
            }
            if ($listitem['status'] == 'things') {
                $resultArray[$key]['buy_type'] = "affiliate";
            } else if ($listitem['status'] == 'publish') {
                $resultArray[$key]['buy_type'] = "buy";
            }

            $resultArray[$key]['affiliate_link'] = $listitem['bm_redircturl'];
            $resultArray[$key]['shipping_time'] = $process_time;
                //$resultArray[$key]['product_url'] = SITE_URL.'listing/'.$listitem['id'].'/'.$listitem['item_title_url'];
            $itemid = base64_encode($listitem['id'] . "_" . rand(1, 9999));
            $resultArray[$key]['product_url'] = SITE_URL . 'listing/' . $itemid;
            if ($temp == 1) {
                $resultArray[$key]['size'] = [];
                if (empty($listitem['size_options'])) {//size":[{"name":"No size","qty":"100","price":"91"}]
                $resultArray[$key]['size'][0]['name'] = "";
                $resultArray[$key]['size'][0]['qty'] = $listitem['quantity'];
                $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $listitem['price']);
                $resultArray[$key]['size'][0]['price'] = $price;
            } else {
                $sizes = json_decode($listitem['size_options'], true);
                $sqkey = 0;
                foreach ($sizes['size'] as $val) {
                    if (count($sizes['unit'][$val]) > 0) {
                        $resultArray[$key]['size'][$sqkey]['name'] = $val;
                        $resultArray[$key]['size'][$sqkey]['qty'] = $sizes['unit'][$val];
                        $price = $this->Currency->conversion($listitem['forexrate']['price'], $cur, $sizes['price'][$val]);
                        $resultArray[$key]['size'][$sqkey]['price'] = $price;
                        $sqkey++;
                    }
                }
            }
        }

            $sitequeriesModel = $this->Sitequeries->find()->where(['type' => 'contact_seller'])->first();//
            $csqueries = json_decode($sitequeriesModel['queries'], true);

            foreach ($photos as $keys => $photo) {
                $itemIds[] = $photo['item_id'];

                if ($listitem['id'] == $photo['item_id']) {
                    $imageName = $photo['image_name'];
                    if ($imageName == '') {
                        $imageName = "usrimg.jpg";
                    }

                    $resultArray[$key]['orig_image'] = $img_path . 'media/items/original/' . $photo['image_name'];

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    }

                    if ($keys == 0) {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    } else {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    }

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    }
                }

            }
            if (!in_array($listitem['id'], $itemIds)) {
                $image = $img_path . 'media/items/thumb350/usrimg.jpg';
                list($width, $height) = getimagesize($image);
                $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/usrimg.jpg';
                $resultArray[$key]['height'] = $height;
                $resultArray[$key]['width'] = $width;
            }

        }

        return $resultArray;
    }
    function discountProducts1()
    {
            $items_data = array();
            $this->loadModel('Items');
            $itemstable = TableRegistry::get('Items');

            $dataSourceObject = ConnectionManager::get('default');
            $getDiscounts = $dataSourceObject->execute("SELECT `id`,`user_id`,`dailydeal`,`discount_type`,`dealdate` from fc_items where status='publish' AND discount_type = 'regular' ORDER BY `id` DESC ")->fetchAll('assoc');

            
            $d = 0;
            foreach($getDiscounts as $key=>$valspro){
                $getitems = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.id'=>$valspro['id']])->where(['Items.affiliate_commission IS NULL'])->first();

                $set = json_decode(json_encode($getitems));
                $getitems = (array)$set;
                $items_data[$d] = $getitems;

                $d++;
            }

            $resultArray = $this->convertJsonHomenew($items_data, $favitems_ids, $_POST['user_id']);
            return $resultArray;
    }

    function discountProducts($limit=null)
    {
          //  echo "limit=".$limit;
            $items_data = array();
            $this->loadModel('Items');
            $this->loadModel('Forexrates');
            $this->loadModel('Photos');
            $itemstable = TableRegistry::get('Items');

            $dataSourceObject = ConnectionManager::get('default');
            $getDiscounts = $dataSourceObject->execute("SELECT `id`,`user_id`,`dailydeal`,`discount_type`,`dealdate` from fc_items where status='publish' AND discount_type = 'regular' ORDER BY `id` DESC ")->fetchAll('assoc');

            
            //$d = 0;
            foreach($getDiscounts as $key=>$valspro){
                $itemids[] = $valspro['id'];
                // $getitems = $itemstable->f;ind()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.id'=>$valspro['id']])->all();
                // //echo '<pre>'; print_r($getitems); die;
                // $set = json_decode(json_encode($getitems));
                // //echo '<pre>'; print_r($set); die;
                // $getitems = (array)$set;
                // $items_data[$d] = $getitems;
                // //echo '<pre>'; print_r($items_data); 

                // $d++;
            }
            //print_r($itemids);
            if($limit!=null && $limit!="" && $limit>0 ){
               // echo "here";die;
                 $items_data = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.id IN' => $itemids])->where(['Items.status'=>'publish'])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit($limit)->all();
            }
            else{
                //echo "nope";die;
                 $items_data = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.id IN' => $itemids])->where(['Items.status'=>'publish'])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->all();
            }
           

            //echo '<pre>';print_r($items_data);die;
            $resultArray = $this->convertJsonHome($items_data, $favitems_ids, $_POST['user_id']);
            return $resultArray;
    }


function categoryProducts($val)
        {
            //$category = array('0'=>'1');

            $category = $val;
            $itemstable = TableRegistry::get('Items');
            //foreach($category as $key=>$cateval)
            //{
            $items_data = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.category_id'=>$category])->where(['Items.affiliate_commission IS NULL'])->limit(20)->order(['Items.id DESC'])->all();
            $resultArray = $this->convertJsonHome($items_data, '', '');
            //print_r($resultArray); die;
            return $resultArray;
            //}
            
        }


        function popularStores($setlimit=null)
    {

        $this->loadModel('Shops');
        $this->loadModel('Storefollowers');
        $this->loadModel('Sitesettings');
        $userId = $_POST['user_id'];

        $offset = 0;
        $limit = 10;
        if (isset($_POST['offset'])) {
            $offset = $_POST['offset'];
        }
        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        }
        else if ($setlimit!="" && $setlimit>0) {
            $limit=$setlimit;
        }
        $setngs = $this->Sitesettings->find()->toArray();
        if (SITE_URL == $setngs[0]['media_url']) {
            $img_path = $setngs[0]['media_url'];
        } else {
            $img_path = $setngs[0]['media_url'];
        }

        if (isset($_POST['offset'])) {
            $shopsdet = $this->Shops->find('all', array(
                'conditions' => array('seller_status' => 1, 'item_count >' => '0', 'store_enable' => 'enable'),
                'limit' => $limit,
                'offset' => $_POST['offset'],
                'order' => 'follow_count DESC',
            ));

        } else {
            $shopsdet = $this->Shops->find('all', array(
                'conditions' => array('seller_status' => 1, 'item_count >' => '0', 'store_enable' => 'enable'),
                'limit' => $limit,
                'order' => 'follow_count DESC',
            ));
        }



        foreach ($shopsdet as $key => $shops) {

            $profileimage = $shops['shop_image'];
            if (empty($profileimage)) {
                $profileimage = "usrimg.jpg";
            }
            $storeid = $shops['id'];

            $followers = $this->Storefollowers->find()->where(['store_id' => $storeid])->all();//all',array('conditions'=>array('Storefollower.store_id'=>$storeid)));
            $flwrusrids = array();
            foreach ($followers as $follower) {
                $flwrusrids[] = $follower['follow_user_id'];
            }
            $resultarray[$key]['store_id'] = $shops['id'];
            $resultarray[$key]['shop_name_url'] = $shops['shop_name_url'];
            $resultarray[$key]['store_name'] = $shops['shop_name'];
            $resultarray[$key]['wifi'] = $shops['wifi'];
            $resultarray[$key]['merchant_name'] = $shops['merchant_name'];

            if (in_array($userId, $flwrusrids)) {
                $resultarray[$key]['status'] = 'unfollow';
            } else {
                $resultarray[$key]['status'] = 'follow';
            }
            $resultarray[$key]['image'] = $img_path . 'media/avatars/thumb150/' . $profileimage;
        }

        //echo '<pre>'; print_r($resultarray); die;
        if (!empty($resultarray) && !isset($_POST['offset'])) {
            return $resultarray;
        } elseif(!empty($resultarray) && isset($_POST['offset'])) {
            echo '{"status":"true","result":'.json_encode($resultarray).'}';    
        }else{
            echo '{"status":"false","message":"No stores found"}';  
        }
        
        die;

    }

        function topRatedproducts($limit=null)
        {
            $this->loadModel('Itemreviews');
            $itemstable = TableRegistry::get('Items');
            $itemreviewTable = TableRegistry::get('Itemreviews');
            if($limit!="" && $limit>0){
                 $results = $this->Items->find('all', array(
                            'conditions' => array(
                                'Items.status' => 'publish',
                                'Items.avg_rating !=' => ''
                            ),
                            'limit' => $limit,
                            'order' => 'avg_rating DESC',
                        ))->contain('Forexrates');
            }
            else{
                 
                  $results = $this->Items->find('all', array(
                            'conditions' => array(
                                'Items.status' => 'publish',
                                'Items.avg_rating !=' => ''
                            ),
                            'order' => 'avg_rating DESC',
                        ))->contain('Forexrates');
            }
           

            $favitems_ids = array();
            $resultArray = $this->convertJsonHome($results, $favitems_ids, $_POST['user_id']);
            return $resultArray;

            /*
                
            //echo '<pre>'; print_r($results); die;

            $items_data = array();
            $topRated = 0;
            //echo '<pre>'; print_r($results); die;
            foreach($results as $key=>$item_id)
            {
                //print_r($item_id->itemid); die;
                $getitems = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.id'=>$item_id->itemid])->first();
                if(!empty($getitems))
                {
                    $set = json_decode(json_encode($getitems));
                    $getitems = (array)$set;
                    $items_data[$topRated] = $getitems;    
                }
                $topRated++;
            }
            
            $resultArray = $this->convertJsonHomenew($items_data);
            return $resultArray;
            */
        }


        function topRatedproducts_viewmore()
        {
            $this->loadModel('Itemreviews');
            $this->loadModel('Items');
            $itemstable = TableRegistry::get('Items');
            $itemreviewTable = TableRegistry::get('Itemreviews');

            /*
            $results = $this->Itemreviews->find('all',
                array('fields'=>array('DISTINCT Itemreviews.itemid','itemid'), 
                      'order'=>array('Itemreviews.ratings DESC'))
            )->toArray();
            */
             $results = $this->Items->find('all', array(
                            'conditions' => array(
                                'Items.status' => 'publish',
                                'Items.avg_rating !=' => ''
                            ),
                            'order' => 'avg_rating DESC',
                        ))->contain('Forexrates');

            

            $items_data = array();
            $topRated = 0;
            //echo '<pre>'; print_r($results); die;
            foreach($results as $key=>$item_id)
            {
                //echo '<pre>'; print_r($item_id); die;
                $getitems = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.id'=>$item_id->id])->where(['Items.affiliate_commission IS NULL'])->first();
                $items_data[$topRated] = $getitems;    
                /*
                if(!empty($getitems))
                {
                    $set = json_decode(json_encode($getitems));
                    $getitems = (array)$set;
                    $items_data[$topRated] = $getitems;    
                }
                */
                $topRated++;
            }
            //echo '<pre>'; print_r($items_data); die;
            //$resultArray = $this->convertJsonHomenew($items_data);
            return $items_data;
        }

        function suggestedItems($userid=null)
        {
            if(empty($userid))
                return array();

            $searchitemstable = TableRegistry::get('Searchitems');
            $itemstable = TableRegistry::get('Items');
            $this->loadModel('Searchitems');

            $datanewSourceObject = ConnectionManager::get('default');
            $getSearchlist = $datanewSourceObject->execute("SELECT * from fc_searchitems where userid=".$userid." ORDER BY `id` DESC
            ")->fetchAll('assoc');

            $result = array();
            foreach ($getSearchlist as $element) {
                $result[$element['category_id']][] = $element;
            }

            
            $results = array();
            
            $key=0;
            foreach($result as $eachItem)
            {
                $getitems = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.id'=>$eachItem[0]['sourceid']])->where(['Items.affiliate_commission IS NULL'])->first();
                $related_items = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.id !='=>$getitems->id,'Items.category_id'=>$eachItem[0]['category_id']])->where(['Items.affiliate_commission IS NULL'])->offset(0)->limit(8)->toArray();
                if(!empty($getitems))
                {
                    $firstItem = json_decode(json_encode($getitems), true);
                    $pendingItems = json_decode(json_encode($related_items), true);
                    $results[$key] = $firstItem;
                    $mergeArray = array_merge(array($firstItem),$pendingItems);
                    $results[$key]['related_items'] = $mergeArray;
                    $key++;
                }
            }

            

            $favitems_ids = array();
            $resultArray = $this->convertJsonHome($results, $favitems_ids, $userid);
            return $resultArray;
        }


        function recentProducts()
    {

        $this->loadModel('Items');
        $this->loadModel('Followers');
        $favitems_ids = array();
        $items_data = array();
        $tdy = strtotime(date("Y-m-d"));

        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            $limit = 20;
        }
        if (isset($_POST['offset'])) {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'status' => 'publish'
                ),
                'limit' => $limit,
                'offset' => $_POST['offset'],
                'order' => 'Items.id DESC',
            ))->contain('Forexrates')->where(['Items.affiliate_commission IS NULL']);

        } else {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'status' => 'publish'
                ),
                'limit' => $limit,
                'order' => 'Items.id DESC',
            ))->contain('Forexrates')->where(['Items.affiliate_commission IS NULL']);
        }

        //echo '<pre>'; print_r($items_data->all()); die;
        if (empty($items_data)) {
            echo '{"status":"false","message":"No data found"}';
            die;
        } else {
            $resultArray = $this->convertJsonHome($items_data, $favitems_ids, $_POST['user_id']);

            return $resultArray;
        }
    }
    function loadMore()
    {
        $this->loadModel('Items');
        $this->loadModel('Followers');
        $favitems_ids = array();
        $items_data = array();
        $tdy = strtotime(date("Y-m-d"));
        $loguserid = $_POST['loguserid'];
        global $loguser;
        $userid = $loguser['id'];

        $itemfavtable = TableRegistry::get('Itemfavs');
        $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $this->set('setngs', $setngs);
        if (count($itemfavmodel) > 0) {
            foreach ($itemfavmodel as $itms) {
                $liked_itmid[] = $itms->item_id;
            }
            //$this->set('likeditemid', $itmid);
        }

        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            $limit = 18;
        }

        if (isset($_POST['offset'])) {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'status' => 'publish'
                ),
                'limit' => $limit,
                'offset' => $_POST['offset'],
                'order' => 'Items.id DESC',
            ))->contain('Forexrates')->contain('Photos')->where(['Items.affiliate_commission IS NULL']);

        } else {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'status' => 'publish'
                ),
                'limit' => $limit,
                'order' => 'Items.id DESC',
            ))->contain('Forexrates')->contain('Photos')->where(['terItems.affiliate_commission IS NULL']);
        }
        //echo count($items_data->toArray());//die;
        if (count($items_data->toArray()) == 0) {
            echo 0;
            die;
        } else {
            //$resultArray = $this->convertJsonHome($items_data, $favitems_ids, $loguserid);
            //echo '<pre>';print_r();die;
            $firstdata = $items_data->first();
            $firstid = $firstdata->id;
            echo '<input type="hidden" class="firstid" value="'.$firstid.'"/>';
            foreach ($items_data as $itms) {
                $itm_id = $itms['id'];
                $item_title_url = $itms['item_title_url'];
                $item_title = $itms['item_title'];
                $image_name = $itms['photos'][0]['image_name'];
                $price = $itms['price'];
                $user_id = $itms['user_id'];
                $item_price = $itms['price'];
                $item_default_price = round($itms['price'] * $itms['forexrate']['price'], 2);
                $itemid = base64_encode($itm_id . "_" . rand(1, 9999));
                $item_price = $itms['price'];
                $favorte_count = $itms['fav_count'];
                $username = $itms['user']['username'];
                $currencysymbol = $itms['forexrate']['currency_symbol'];
                $items_image = $itms['photos'][0]['image_name'];
                        //$item_title = UrlfriendlyComponent::limit_char($item_title,12);

                if (isset($itms['photos'][0])) {
                    $image_name = $itms['photos'][0]['image_name'];
                } else {
                    $image_name = "usrimg.jpg";
                }
                $shopname_url = $itms['shop']['shop_image'];
                $username_url = $itms['user']['profile_image'];
                if ($shopname_url == '') {
                    $shopname_url = 'usrimg.jpg';
                }
                if ($username_url == '') {
                    $username_url = 'usrimg.jpg';
                }
                $user_level = $itms['user']['user_level'];
                $username = $itms['user']['username'];
                $sellername = $itms['shop']['shop_name'];
                $sellername_id = $itms['shop']['user_id'];
                $sellername_url_ori = $itms['shop']['shop_name_url'];

                $username_url_ori = $itms['user']['username_url'];
                $favorte_count = $itms['fav_count'];

                $item_price = $itms['price'];
                $item_default_price = round($item_price * $itms['forexrate']['price'], 2);
                $size_options = $itms['size_options'];
                $sizeoptions = json_decode($size_options, true);
                if (!empty($sizeoptions['size'])) {
                    $item_price = reset($sizeoptions['price']);
                    $item_default_price = round(reset($sizeoptions['price']) * $itms['Forexrates']['price'], 2);
                }


                $itemprice = $itms['price'];

                //$user_currency_price = $currencycomponent->conversion($itms['forexrate']['price'], $_SESSION['currency_value'], $itemprice);
                
                echo '<span id="figcaption_titles' . $itms['id'] . '" figcaption_title ="' . $item_title . '" ></span>';
                echo '<span class="figcaption" id="figcaption_title_url' . $itms['id'] . '" figcaption_url ="' . $item_title_url . '" style="position: relative; top: 10px; left: 7px;display:none;" >' . $item_title_url . '</span>';
                echo '<span id="price_vals' . $itms['id'] . '" price_val="' . $_SESSION['currency_symbol'] . $itemprice . '" ></span>';
                echo '<a href="' . SITE_URL . "people/" . $username . '"  id="user_n' . $itms['id'] . '" usernameval ="' . $username . '"></a>';
                echo '<span id="img_' . $itms['id'] . '" class="nodisply">' . SITE_URL . 'media/items/original/' . $items_image . '</span>';
                echo '<span class="fav_count" id="fav_count' . $itms['id'] . '" fav_counts ="' . $favorte_count . '" ></span>';
                if ($loguser == "") {
                    $temp = "";
                    $temp1 = "";
                } else {
                    $temp = "modal";
                    $temp1 = "#share-modal";
                }

                echo '<div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4" id="item_cnt'.$itms['id'].'">
                    <div class="bg_product">
                        <img src="' . SITE_URL . 'media/items/original/' . $image_name . '" class="img-responsive">
                    </div>
                    <div class="prodDescrip new_prod_nam bold-font ">
                        <div class="prdDescrip">
                            <div class="imgDes">
                                <a class="" href="' . SITE_URL . 'listing/' . $itemid . '">
                                    <div class="desCri">' . $item_title . '</div>
                                </a>
                                <span id="price_vals6" price_val="$300" style="display:none;width:0px !important;"></span>
                            </div>
                            <div class="desIcon">
                                <div class="likeIcon" style="cursor:pointer;" onclick="itemcou(' . $itms['id'] . ')">
                                ';
                                if (count($liked_itmid) != 0 && in_array($itms['id'], $liked_itmid)) {
                                    echo '<img src="' . SITE_URL . 'images/icons/Heart_after_like@2x.png" id="like-icon' . $itms['id'] . '" class="like-icon" alt="liked">
                                    <span style="display:none" class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
                                } else {
                                    
                                    echo '<img src="' . SITE_URL . 'img/like.png" id="like-icon' . $itms['id'] . '" class="like-icon"  alt="unliked">
                                    <span style="display:none" class="like-txt' . $itms['id'] . ' nodisply" id="like-txt' . $itms['id'] . '" >' . $setngs['like_btn_cmnt'] . '</span>';
                                }
                                echo '</div>
                                <div class="shareIcon" onclick="share_posts(' . $itms['id'] . ')" data-toggle="' . $temp . '" data-target="' . $temp1 . '"><img src="' . SITE_URL . '/img/share.png" alt="share"></div>
                            </div>
                        </div>
                        ';
                  
                $date = date('d');
                $month = date('m');
                $year = date('y');
                $tdy = strtotime($month . '/' . $date . '/' . $year);
                $newdate = strtotime($itms['dealdate']);
                //$newdate = new Time($itms['dealdate']);
                //$dealdate = $newdate->i18nFormat(Time::UNIX_TIMESTAMP_FORMAT);


                
                    echo '<div class="price">';

                    
                        echo $itms['forexrate']['currency_symbol'] . ' ' . $itms['price'];
                

                    echo '</div>';
                            
                   echo '</div>
                </div>';
            }
                 //echo '<div class="view-all-btn loadMore btn primary-color-bg primary-color-bg deals"><a href="javascript:void(0);" onclick="loadmore();">Load more</a></div>';
            
        }
    }        
    function popularProducts()
    {

        $this->loadModel('Items');
        $this->loadModel('Followers');
        $favitems_ids = array();
        $items_data = array();

        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            $limit = 15;
        }
        if (isset($_POST['offset'])) {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'Items.status' => 'publish'
                ),
                'limit' => $limit,
                'offset' => $_POST['offset'],
                'order' => 'fav_count DESC',
            ))->contain('Forexrates')->where(['Items.affiliate_commission IS NULL']);
        } else {
            $items_data = $this->Items->find('all', array(
                'conditions' => array(
                    'Items.status' => 'publish'
                ),
                'limit' => $limit,
                'order' => 'fav_count DESC',
            ))->contain('Forexrates')->where(['Items.affiliate_commission IS NULL']);

        }

        if (empty($items_data)) {
            echo '{"status":"false","message":"No data found"}';
            die;
        } else {
            $resultArray = $this->convertJsonHome($items_data, $favitems_ids, $_POST['user_id']);
            //die;
            return $resultArray;
        }
    }

    /*
    Custom functions
    */
    function getAverage($value='')
    {
        $this->loadModel('Itemreviews');
        $itemreviewTable = TableRegistry::get('Itemreviews');
        $reviews = $this->Itemreviews->find('all', array(
                'conditions' => array(
                    'itemid' => $value
                ),
                'order' => 'id DESC'
            ))->all();
        
        $max = 0;
        $n = count($reviews); // get the count of comments 
        foreach ($reviews as $rate => $count) { // iterate through array

            $max = $max+$count->ratings;
        }
        $Rating = ($n != 0) ? $max / $n : 0;
        return round($Rating,1);
    }

    function suggestitem_viewmore()
    {
        global $loguser;
        $this->loadModel('Items');
        $this->loadModel('Searchitems');
        $itemsTable = TableRegistry::get('Items');
        $searchitemstable = TableRegistry::get('Searchitems');
        
        $suggestItemModel = $this->Searchitems->find()->where(['userid' => $loguser['id']])->order(['id'=>'desc'])->all();

        $s = 0;
        $items_data = array();
        foreach($suggestItemModel as $key=>$val)
        {
            $getitems = $itemsTable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish','Items.id'=>$val->sourceid])->where(['Items.affiliate_commission IS NULL'])->first();
            $items_data[$s] = $getitems; 
            $s++;   
        }
        return $items_data;
    }


    public function convertJsonHomeitemsuggest($items_data, $favitems_ids = null, $user_id = null, $temp = null)
    {

        $this->loadModel('Contactsellers');
        $this->loadModel('Itemfavs');
        $this->loadModel('Sitequeries');
        $this->loadModel('Facebookcoupons');
        $this->loadModel('Forexrates');
        $this->loadModel('Photos');
        $this->loadModel('Users');
        $this->loadModel('Sitesettings');
        $setngs = $this->Sitesettings->find()->toArray();
        $photos = $this->Photos->find()->order(['id DESC'])->all();

        $forexrateModel = $this->Forexrates->find()->where(['cstatus' => 'default'])->first();

        $resultArray = array();
        $resultArray['type'] = "Everything";
        if ($type != null)
            $resultArray['type'] = $type;
        $resultArray = array();
        $shareCouponDetail = array();

        if (SITE_URL == $setngs[0]['media_url']) {
            $img_path = $setngs[0]['media_url'];
        } else {
            $img_path = $setngs[0]['media_url'];
        }
        $userDetail = $this->Users->find()->where(['id' => $user_id])->first();

        if (!empty($userDetail))
            $userId = $userDetail['id'];
        else
            $userId = $userId;

        $currency_value = $this->Forexrates->find()->where(['id' => $userDetail['currencyid']])->first();
        if ($currency_value['currency_code'] == $forexrateModel['currency_code'] || $currency_value['currency_code'] == "" || count($userDetail) == 0) {
            $cur_symbol = $forexrateModel['currency_symbol'];
            $cur = $forexrateModel['price'];
        } else {
            $cur_symbol = $currency_value['currency_symbol'];
            $cur = $currency_value['price'];
        }
        $items_fav_data = $this->Itemfavs->find()->where(['user_id' => $user_id])->all();//
        if (count($items_fav_data) > 0) {
            foreach ($items_fav_data as $favitems) {
                $favitems_ids[] = $favitems['item_id'];
            }
        } else {
            $favitems_ids = array();
        }
        



        foreach ($items_data as $key => $listitem) {

            

            $sizeprice = [];

            $reportUsers = '';
            $process_time = $listitem['processing_time'];
            if ($process_time == '1d') {
                $process_time = "One business day";
            } elseif ($process_time == '2d') {
                $process_time = "Two business days";
            } elseif ($process_time == '3d') {
                $process_time = "Three business days";
            } elseif ($process_time == '4d') {
                $process_time = "Four business days";
            } elseif ($process_time == '2ww') {
                $process_time = "One-Two weeks";
            } elseif ($process_time == '3w') {
                $process_time = "Two-Three weeks";
            } elseif ($process_time == '4w') {
                $process_time = "Three-Four weeks";
            } elseif ($process_time == '6w') {
                $process_time = "Four-Six weeks";
            } elseif ($process_time == '8w') {
                $process_time = "Six-Eight weeks";
            }
            $shareSeller = $listitem['share_coupon'];

            $shareCouponDetail = $this->Facebookcoupons->find()->where(['item_id' => $listitem['id']])->andWhere(['user_id' => $user_id])->all();//all',array('conditions'=>array('Facebookcoupon.item_id'=> $listitem['Item']['id'] , 'Facebookcoupon.user_id'=> $userId )));
            if (count($shareCouponDetail) != 0)
                $shareUser = "yes";
            else
                $shareUser = "no";

            $resultArray[$key]['id'] = $listitem['id'];
            $resultArray[$key]['item_title'] = $listitem['item_title'];
            $resultArray[$key]['item_description'] = $listitem['item_description'];
            $resultArray[$key]['currency'] = $cur_symbol;
            $resultArray[$key]['related_items'] = $this->convertJsonHomesuggested($listitem, $favitems_ids, $_POST['user_id']);             
            
            if ($listitem['size_options'] != "") {
                $sizes = json_decode($listitem['size_options'], true);

                //  if($sizes!=""){

                foreach ($sizes['price'] as $key1 => $value) {

                    $sizeprice[] = $value;
                }

                $resultArray[$key]['mainprice'] = $sizeprice[0];
                $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $sizeprice[0]);
                $resultArray[$key]['price'] = $price;

                    //}
            } else {
                
                $resultArray[$key]['mainprice'] = $listitem['price'];
                $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $listitem['price']);
                $resultArray[$key]['price'] = $price;
            }

            $today = strtotime(date("Y-m-d"));
            $dealdate1 = date("Y-m-d", strtotime($listitem['dealdate']));
            $dealDate = strtotime($dealdate1);
            if ($listitem['dailydeal'] == 'yes' && $dealDate == $today) {
                $discount = $listitem['discount'];
                $dealdate = date("Y-m-d", strtotime($listitem['dealdate']));//.' 24:00:00';
                $dealdate = strtotime($dealdate);

                $resultArray[$key]['deal_enabled'] = 'yes';
                $resultArray[$key]['discount_percentage'] = $discount;
                $resultArray[$key]['valid_till'] = $dealdate;
            } else {
                $resultArray[$key]['deal_enabled'] = 'no';
                $resultArray[$key]['discount_percentage'] = "";
                $resultArray[$key]['valid_till'] = "";
            }
            $resultArray[$key]['quantity'] = $listitem['quantity'];
            $resultArray[$key]['cod'] = $listitem['cod'];

            if (in_array($listitem['id'], $favitems_ids)) {
                $resultArray[$key]['liked'] = 'yes';
            } else {
                $resultArray[$key]['liked'] = 'no';
            }

            $item_status = json_decode($listitem['report_flag'], true); //print_r($item_status); die;

            if (in_array($userId, $item_status)) {
                $report_status = "yes";
            } else {
                $report_status = "no";

            }

            $resultArray[$key]['report'] = $report_status;
            $likedcount = $this->Itemfavs->find()->where(['item_id' => $listitem['id']])->count();
            $resultArray[$key]['like_count'] = $likedcount;
            $resultArray[$key]['fbshare_discount'] = $listitem['share_discountAmount'];
            $resultArray[$key]['reward_points'] = floor($convertdefaultprice);
            $resultArray[$key]['share_seller'] = $shareSeller;
            $resultArray[$key]['share_user'] = $shareUser;
            if ($listitem['status'] == 'publish') {
                $resultArray[$key]['approve'] = true;
            } else {
                $resultArray[$key]['approve'] = false;
            }
            if ($listitem['status'] == 'things') {
                $resultArray[$key]['buy_type'] = "affiliate";
            } else if ($listitem['status'] == 'publish') {
                $resultArray[$key]['buy_type'] = "buy";
            }

            
            $resultArray[$key]['affiliate_link'] = $listitem['bm_redircturl'];
            $resultArray[$key]['shipping_time'] = $process_time;
                //$resultArray[$key]['product_url'] = SITE_URL.'listing/'.$listitem['id'].'/'.$listitem['item_title_url'];
            $itemid = base64_encode($listitem['id'] . "_" . rand(1, 9999));
            $resultArray[$key]['product_url'] = SITE_URL . 'listing/' . $itemid;
            if ($temp == 1) {
                $resultArray[$key]['size'] = [];
                if (empty($listitem['size_options'])) {//size":[{"name":"No size","qty":"100","price":"91"}]
                $resultArray[$key]['size'][0]['name'] = "";
                $resultArray[$key]['size'][0]['qty'] = $listitem['quantity'];
                $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $listitem['price']);
                $resultArray[$key]['size'][0]['price'] = $price;
            } else {
                $sizes = json_decode($listitem['size_options'], true);
                $sqkey = 0;
                foreach ($sizes['size'] as $val) {
                    if (count($sizes['unit'][$val]) > 0) {
                        $resultArray[$key]['size'][$sqkey]['name'] = $val;
                        $resultArray[$key]['size'][$sqkey]['qty'] = $sizes['unit'][$val];
                        $price = $this->Currency->conversion($listitem['forexrate']->price, $cur, $sizes['price'][$val]);
                        $resultArray[$key]['size'][$sqkey]['price'] = $price;
                        $sqkey++;
                    }
                }
            }
        }

            $sitequeriesModel = $this->Sitequeries->find()->where(['type' => 'contact_seller'])->first();//
            $csqueries = json_decode($sitequeriesModel['queries'], true);

            foreach ($photos as $keys => $photo) {
                $itemIds[] = $photo['item_id'];

                if ($listitem['id'] == $photo['item_id']) {
                    $imageName = $photo['image_name'];
                    if ($imageName == '') {
                        $imageName = "usrimg.jpg";
                    }

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb70/' . $imageName;
                    }

                    if ($keys == 0) {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    } else {
                        $image = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        list($width, $height) = getimagesize($image);
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                        $resultArray[$key]['height'] = $height;
                        $resultArray[$key]['width'] = $width;
                    }

                    if ($keys == 0) {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    } else {
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $photo['image_name'];
                        $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/' . $imageName;
                    }
                }

            }
            if (!in_array($listitem['id'], $itemIds)) {
                $image = $img_path . 'media/items/thumb350/usrimg.jpg';
                list($width, $height) = getimagesize($image);
                $resultArray[$key]['image'] = $img_path . 'media/items/thumb350/usrimg.jpg';
                $resultArray[$key]['height'] = $height;
                $resultArray[$key]['width'] = $width;
            }

        }

        return $resultArray;
    }

    public function affiliateproducts()
    {
        global $loguser;
        $userid = $loguser['id'];
        
        $this->loadModel('Items');
        $this->loadModel('Itemfavs');
        $this->loadModel('Itemlists');

        $itemstable = TableRegistry::get('Items');



        $userid = $loguser['id'];

        $itemfavtable = TableRegistry::get('Itemfavs');
        $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $this->set('setngs', $setngs);
        if (count($itemfavmodel) > 0) {
            foreach ($itemfavmodel as $itms) {
                $itmid[] = $itms->item_id;
            }

            $this->set('likeditemid', $itmid);


        }

        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();

        if ($setngs == 'enable') {
            $itemStatus['Items.status <>'] = 'draft';
        } else {
            $itemStatus['Items.status'] = 'publish';
        }
        $itemStatus['Shops.seller_status'] = 1;
        $itemStatus['Users.user_status'] = 'enable';
        $itemStatus['Items.affiliate_commission <>'] = 0;

        $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->order(['Items.id DESC'])->limit('20')->all();
        $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->order(['Items.id DESC'])->count();
        $this->set('pagetitle', 'Affiliate Products');
        
        
        $this->set('items_data', $itemModel);
        $this->set('countitemModel', $countitemModel);
        $this->set('userid', $userid);
        $this->set('loguser', $loguser);
        $this->set('setngs', $setngs);
        
    }

    public function getitembycommission()
        {
            global $loguser;
            $userid = $loguser['id'];
            $itemfavtable = TableRegistry::get('Itemfavs');
            $itemfavmodel = $itemfavtable->find('all')->where(['user_id' => $userid])->all();
            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            $this->set('setngs', $setngs);
            if (count($itemfavmodel) > 0) {
                foreach ($itemfavmodel as $itms) {
                    $itmid[] = $itms->item_id;
                }
                $this->set('likeditemid', $itmid);
            }
            $itemstable = TableRegistry::get('Items');
            $itemliststable = TableRegistry::get('Itemlists');
           

            // $sortvalue = $_POST['sortCommission'];
             if(isset($_POST['sortCommission']) && $_POST['sortCommission']!=""){
                 $sortvalue = $_POST['sortCommission'];
            }
            else{
               $sortvalue = $_GET['sortCommission'];  
            }
            $sort = explode('-', $sortvalue);
            $limit = 20;
            if (isset($_GET['limit'])) {
                $limit = $_GET['limit'];
            }

            $offset = 0;
            if (isset($_GET['offset'])) {
                $offset = $_GET['offset'];
            }


            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            
              if ($setngs == 'enable') {
                 $itemStatus['Items.status <>'] = 'draft';
              } else {
                 $itemStatus['Items.status'] = 'publish';
              }
            $itemStatus['Shops.seller_status'] = 1;
            $itemStatus['Users.user_status'] = 'enable';
            if($sortvalue != 0) {
            $itemStatus['Items.affiliate_commission >='] = $sort[0];
            $itemStatus['Items.affiliate_commission <='] = $sort[1];
            } else {
            $itemStatus['Items.affiliate_commission <>'] = 0;
            }

       

        $itemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->order(['Items.id DESC'])->limit($limit)->offset($offset)->all();
        $countitemModel = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where([$itemStatus])->order(['Items.id DESC'])->count();
        $this->set('pagetitle', 'Affiliate Products');
        //print_r($countitemModel);die;
        
        $this->set('itemdata', $itemModel);
        $this->set('item_count', $countitemModel);
        $this->set('userid', $userid);
        $this->set('loguser', $loguser);
        $this->set('setngs', $setngs);
        

            
        }
         public function allcategories()
        {
            // global $loguser;
            // $userid = $loguser['id'];
            $limit=15;
            $categories = TableRegistry::get('categories');
           $parent_categories = $categories->find()->where(['category_parent'=>0])->where(['category_sub_parent'=>0])->limit($limit)->offset(0)->all();
           $loadmore_exists = $categories->find()->where(['category_parent'=>0])->where(['category_sub_parent'=>0])->limit($limit)->offset($limit)->all();
           if($loadmore_exists!="" && count($loadmore_exists)>0){
            $show_loadmore="block";
           }
           else{
            $show_loadmore='none';
           }
           //print_r($parent_categories);die;
            $this->set('parent_categories', $parent_categories);
             $this->set('show_loadmore', $show_loadmore);
          
            
        }
         public function getmorecategories()
        {
            // global $loguser;
            // $userid = $loguser['id'];
            $limit=$_POST['limit'];
            if($limit==""){
                $limit=6;
            }
            $offset=$_POST['offset'];

            $categories = TableRegistry::get('categories');
           $parent_categories = $categories->find()->where(['category_parent'=>0])->where(['category_sub_parent'=>0])->limit($limit)->offset($offset)->all();

           //print_r($parent_categories);die;
        
            $this->set('parent_categories', $parent_categories);
          
            
        }







    } // E O class
