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
namespace App\Controller\Items;
use Cake\Auth\DefaultPasswordHasher;
use App\Model\Table\UsersTable;
use App\Model\Table\ShopTable;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Routing\Router;

use Cake\Datasource\ConnectionManager;


class ItemsController extends AppController
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
        $this->loadComponent('Captcha');
    }

    function group_by($key, $data) {
    $result = array();


    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}

    public function view($details)
    {
        //echo "here";die;
        $detail = base64_decode($details);
        $idval = explode('_', $detail);
        //print_r($idval);die;
        $this->loadModel('Itemreviews');
        $this->loadModel('Orders');
        $this->loadModel('OrderItems');
        $this->loadModel('Items');
        $this->loadModel('Searchitems');

        global $user_level;
        global $loguser;


        $id = $idval[0];
        //$id = 'sdfsdfsdf';
        

        $itemstable = TableRegistry::get('Items');
        $shippingaddressestable = TableRegistry::get('Shippingaddresses');
        $item_datas = $itemstable->find('all')->contain('Forexrates')->contain('Shops')->contain('Users')->contain(['Photos'])->where(['Items.id' => $id])->first();


    // if (!isset($_SESSION["visits"]))
    //     $_SESSION["visits"] = 0;
    //     $_SESSION["visits"] = $_SESSION["visits"] + 1;
    //  echo $_SESSION["visits"]; die;
    // if ($_SESSION["visits"] > 1)
    // {
    //     echo "you refreshed the page!";
    //     unset($_SESSION["visits"]);die;
    // }
    // else
    // {
    //     echo "nothing to do here!";
        
    // }

        if(isset($idval[2]) && $idval[2] != "") {
            $actual_link = Router::url(null, true);
            $back_url = $_SESSION['backURL'];
       
            if(isset($back_url) && !empty($back_url)) {
                unset($_SESSION['backURL']);
            } 
       
            $_SESSION['backURL'] = $actual_link;
        }

        $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['receiver_id' => $loguser['id']])->where(['item_id' => $id])->where(['status' => 'visit'])->all();

        if(isset($idval[2]) && $idval[2] != "" && $item_datas['affiliate_commission'] != '' && isset($loguser['id']) && count($shareproducts) == 0 && $idval[2] != $loguser['id']) {
        

        $shareproductstable = TableRegistry::get('Shareproducts');
        $shareproducts = $shareproductstable->newEntity();
        
        $shareproducts->sender_id = $idval[2];
        $shareproducts->receiver_id = $loguser['id'];
        $shareproducts->item_id = $id;
        $shareproducts->status = 'visit';
        $shareproducts->created_date = time();
        $result = $shareproductstable->save($shareproducts);

        }


        //echo '<pre>'; print_r($item_datas); die;

        $UsersTable = TableRegistry::get('Users');
        $users = $UsersTable->find('all')->contain('Shops')->where(['Users.id' => $item_datas['user_id']])->first();
        $fashionusers = TableRegistry::get('Fashionusers');
        $fashionimages = $fashionusers->find('all')->contain('Users')->where(['itemId' => $item_datas['id']])->where(['status' => 'Yes'])->all();
        $photosTable = TableRegistry::get('Photos');
        $photos = $photosTable->find('all')->where(['item_id' => $item_datas['id']])->all();

        $searchitemstable = TableRegistry::get('Searchitems');

        if(!empty($loguser['id']))
        {
            $this->Searchitems->deleteAll(array('sourceid' => $id, 'userid' => $loguser['id']), false);

            $searchitems = $searchitemstable->newEntity();
            $searchitems->sourceid = $id;
            $searchitems->category_id = $item_datas['category_id'];
            $searchitems->userid = $loguser['id'];
            $searchitems->type = 'item';
            $result = $searchitemstable->save($searchitems);
            $searchitemId = $result->id;
        }

        $productfaqTable = TableRegistry::get('Productfaq');
        $faq_datas = $productfaqTable->find('all', [
                        'keyField' => 'user_id',
                        'valueField' => 'users.id'
                    ])->contain(['Users'])->where(['Productfaq.item_id' => $item_datas['id']])->all();

        $dataSourceObject = ConnectionManager::get('default');

    $stmt = $dataSourceObject->execute("SELECT  t1.id AS question_id, 
                                                t1.parent_id AS question_parent_id, 
                                                t1.user_id AS question_user_id, 
                                                t1.item_id AS question_item_id,
                                                t1.content AS question_content, 
                                                t2.id AS answer_id, 
                                                t2.parent_id AS answer_parentid, 
                                                t2.user_id AS answer_user_id, 
                                                t2.item_id AS answer_item_id,
                                                t2.content as answer_content
FROM fc_productfaq AS t1
LEFT JOIN fc_productfaq AS t2 ON t2.parent_id = t1.id
LEFT JOIN fc_productfaq AS t3 ON t3.parent_id = t2.id
LEFT JOIN fc_productfaq AS t4 ON t4.parent_id = t3.id
WHERE t1.item_id = ".$item_datas['id']." AND t1.parent_id='0' ORDER BY t1.id DESC")->fetchAll('assoc');


        

     $byGroup = $this->group_by("question_id", $stmt);

     $results = array();
     $q=0;
    foreach($byGroup as $ssval)
    {

        $byssssks = $this->group_by('answer_parentid',$ssval);
        $a = 0;
        foreach($byssssks as $key=>$ksk)
        {
            foreach($ksk as $ksey=>$dfsdfsdfs)
            {
                $userstable = TableRegistry::get('Users');
                $q_user = $userstable->find()->where(['id' => $dfsdfsdfs['question_user_id']])->first();

                $results[$q]['content'] = $dfsdfsdfs['question_content'];
                $results[$q]['question_id'] = $dfsdfsdfs['question_id'];
                $results[$q]['user_id'] = $dfsdfsdfs['question_user_id'];
                $results[$q]['username'] = $q_user['username'];
                $results[$q]['username_url'] = $q_user['username_url'];
                $results[$q]['profile_image'] = $q_user['profile_image'];
                $results[$q]['item_id'] = $dfsdfsdfs['question_item_id'];

                if($dfsdfsdfs['answer_content'] != '')
                {
                    $ans = $productfaqTable->find()->where(['parent_id' => $dfsdfsdfs['question_id']])->order(['id'=>'DESC'])->first();
                    

                    $a_user = $userstable->find()->where(['id' => $ans->user_id])->first();

                    $results[$q]['answer'][0]['user_id'] = $a_user->id;
                    $results[$q]['answer'][0]['answer_id'] = $ans->id; 
                    $results[$q]['answer'][0]['username'] = $a_user->username;
                    $results[$q]['answer'][0]['username_url'] = $a_user->username_url;
                    $results[$q]['answer'][0]['profile_image'] = ($a_user->profile_image == '') ? SITE_URL.'/media/avatars/thumb70/usrimg.jpg' : SITE_URL.'/media/avatars/thumb70/'.$a_user->profile_image;
                    $results[$q]['answer'][0]['parent_id'] = $ans->parent_id;
                    $results[$q]['answer'][0]['item_id'] = $ans->item_id;
                    $results[$q]['answer'][0]['content'] = $ans->content;
                }

                //echo '<pre>'; print_r($results); die;
                $a++;
            }
        }
        $q++;
    }

    //print_r($results)
    //echo '<pre>'; print_r($results); die;

        $itemreviewTable = TableRegistry::get('Itemreviews');
        $reviewData = $this->Itemreviews->find('all', array(
                'conditions' => array(
                    'itemid' => $id
                ),
                'limit' => 2,
                'offset' => 0,
                'order' => 'id DESC',
            ))->all();

        $reviewCount = $this->Itemreviews->find('all', array(
                'conditions' => array(
                    'itemid' => $id,
                    'not' => array('Itemreviews.reviews' => '')
                ),
                'order' => 'id DESC',
            ))->count();

        

        $getAvgrat = $this->getAverage($id); 

        

        $result = array();
        $this->loadModel('Users');
        
        foreach($reviewData as $key=>$eachreview)
        {

            $user_data = $this->Users->find()->where(['id' => $eachreview->userid])->first();

            
            $result[$key]['user_id'] = $eachreview->userid;
            $result[$key]['user_name'] = $user_data->username;
            $result[$key]['user_image'] = ($user_data->profile_image == '') ? SITE_URL.'img/user.png' : SITE_URL.'/media/avatars/thumb70/'.$user_data->profile_image;
            $result[$key]['id'] = $eachreview->orderid;
            $result[$key]['review_title'] = $eachreview->review_title;
            $result[$key]['username_url'] = SITE_URL . "people/" . $user_data['username_url'];
            $result[$key]['rating'] = $eachreview->ratings;
            $result[$key]['review'] = $eachreview->reviews;
        }

        

        $datanewSourceObject = ConnectionManager::get('default');
        $ratingstmt = $datanewSourceObject->execute("SELECT count(*) as Total, ratings from fc_itemreviews where itemid=".$id." group by ratings order by ratings desc
        ")->fetchAll('assoc');



        if(count($ratingstmt) > 0)
        {
            $byrateGroup = $this->group_by("ratings", $ratingstmt);

             $roundRat = array();
                foreach($byrateGroup as $key=>$val)
                {
                    $roundRat[round($key)] = $val;
                }

            //echo '<pre>'; print_r($byrateGroup); die;
            $rating_count = ($roundRat[5][0]['Total']+$roundRat[4][0]['Total']+$roundRat[3][0]['Total']+$roundRat[2][0]['Total']+$roundRat[1][0]['Total']);

           
            
            $five = (empty($roundRat[5][0]['Total'])) ? 0 : $roundRat[5][0]['Total'] ;
            $four = (empty($roundRat[4][0]['Total'])) ? 0 : $roundRat[4][0]['Total'] ;
            $three = (empty($roundRat[3][0]['Total'])) ? 0 : $roundRat[3][0]['Total'] ;
            $two = (empty($roundRat[2][0]['Total'])) ? 0 : $roundRat[2][0]['Total'] ;
            $one = (empty($roundRat[1][0]['Total'])) ? 0 : $roundRat[1][0]['Total'] ;

            
            $resultArray['item_reviews'] = array(
                'review_count'=>$reviewCount,
                'rating'=>$getAvgrat['rating'],
                'rating_count'=>$rating_count,
                'five'=>$five,
                'four'=>$four,
                'three'=>$three,
                'two'=>$two,
                'one'=>$one,
                'result'=>$result
                );
        }else{
            $result = array();

            $resultArray['item_reviews'] = array(
                'review_count'=>0,
                'rating'=>0,
                'rating_count'=>0,
                'five'=>0,
                'four'=>0,
                'three'=>0,
                'two'=>0,
                'one'=>0,
                'result'=>$result
                );
        }

        //echo '<pre>'; print_r($resultArray['item_reviews']); die;


        $orderstable = TableRegistry::get('Orders');
        $orderitemstable = TableRegistry::get('OrderItems');

        $ordersModel = $orderstable->find('all')->where(['userid' => $loguser['id']])->order(['orderid DESC'])->all();

        //echo '<pre>'; print_r($ordersModel); die;

        $orderid = array();
        foreach ($ordersModel as $value) {
        	if($value->status == 'Delivered' || $value->status == 'Paid')
        	{
        		$orderid[] = $value->orderid;
        	}
        }

        if(!empty($orderid))
        {
            $orderitemModel = $orderitemstable->find('all')->where(['itemid'=>$id,'orderid IN' => $orderid])->order(['orderid DESC'])->first();

            $resultArray['order_id'] = (isset($orderitemModel->orderid)) ? $orderitemModel->orderid : '';
            

            if(isset($orderitemModel->orderid)){
                $get_review = TableRegistry::get('Itemreviews');
                

                $firstreviewData = $this->Itemreviews->find('all', array(
                        'conditions' => array(
                            'itemid' => $id,
                            'orderid'=> $orderitemModel->orderid
                        ),
                        'order' => 'id DESC',
                    ))->first();
                
                $resultArray['review_id'] = (isset($firstreviewData->id)) ? $firstreviewData->id : '';
                $resultArray['reviews'] = (isset($firstreviewData->id)) ? $firstreviewData->reviews : '';
                $resultArray['rating'] = $firstreviewData->ratings;
            }
        }else{
            $resultArray['order_id'] = '';
            $resultArray['review_id'] = '';
            $resultArray['reviews'] = '';
            $resultArray['rating'] = '';

        }

        //echo '<pre>'; print_r($resultArray); die;

        $this->set('rating_reviews', $resultArray);
        $this->set('item_datas', $item_datas);
        $this->set('metavalue','itemdetails');
        $this->set('order_id',$resultArray['order_id']);
        $this->set('review_id',$resultArray['review_id']);
        $this->set('users', $users);
        $this->set('userid', $users->id);
        $this->set('fashionimages', $fashionimages);
        $this->set('photos', $photos);
        $this->set('productfaq', $results);
        

        $mangagemodulestable = TableRegistry::get('Managemodules');
        $managemodules = $mangagemodulestable->find()->where(['id' => 1])->first();
        $displaybanner = $managemodules['display_banner'];
        $this->set('displaybanner', $displaybanner);
        $bannerstable = TableRegistry::get('Banners');
        $bannerdatas = $bannerstable->find()->where(['banner_type' => 'product'])->where(['status' => 'Active'])->first();
        $this->set('bannerdatas', $bannerdatas);
        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $socialId = $setngs['social_id'];
        $socialId = json_decode($socialId, true);
        $userid = $loguser['id'];
        $this->loadModel('Countries');
        $this->loadModel('Shippingaddresses');
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Itemlists');
        $this->loadModel('Sellercoupons');
        $this->loadModel('Photos');
        $this->loadModel('Comments');
        $this->loadModel('Itemfavs');
        $this->loadModel('Followers');
        $this->loadModel('Wantownits');
        $this->loadModel('Fashionusers');
        $this->loadModel('Contactsellers');
        $this->loadModel('Sitequeries');
        $this->loadModel('Banners');
        $this->loadModel('Storefollowers');
         $categoriestable = TableRegistry::get('Categories');
        $liked_items_model = $this->Itemfavs->find('all', array('conditions' => array('user_id' => $userid)));
        foreach ($liked_items_model as $i => $liked_items) {
            $user_liked_items[] = $liked_items['item_id'];
        }
        $this->set('user_liked_items', $user_liked_items);
        $sitesettings = TableRegistry::get('sitesettings');
        $setngs = $sitesettings->find()->first();
        if ($setngs['affiliate_enb'] == 'enable') {
            $itemStatus['Items.status <>'] = 'draft';
        } else {
            $itemStatus['Items.status'] = 'publish';
        }
        $popular_products = $itemstable->find('all')->contain('Users')->contain('Forexrates')->contain(['Photos'])->contain('Itemfavs')->where([$itemStatus])->where(['Items.affiliate_commission IS NULL'])->order(['Items.fav_count' => 'DESC'])->all();
        $this->set('popular_products', $popular_products);
        $item_all = $itemstable->find()->contain('Users')->contain('Forexrates')->contain(['Photos'])->where(['Items.user_id' => $item_datas['user_id']])->where(['Items.affiliate_commission IS NULL'])
        ->where(function ($exp, $q) {
            return $exp->notEq('Items.status', 'draft');
        })->order(['Items.id DESC'])->all();
        $this->set('item_all', $item_all);
        $item_datas = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->contain('Itemfavs')->contain('Shipings')->where(['Items.id' => $id])
        ->where(function ($exp, $q) {
            return $exp->notEq('Items.status', 'draft');
        })->first();
        $this->set('fbimage', $_SESSION['media_url'] . "media/items/thumb350/" . $item_datas['photos'][0]['image_name']);
        $itemid = base64_encode($item_datas['id'] . "_" . rand(1, 9999));
        $this->set('fburl', SITE_URL . "listing/" . $itemid);
    $this->set('fbid', $socialId['FB_ID']); //echo FB_ID;die;
    $this->set('fbtitle', $item_datas['item_title']);
    $this->set('fbdescription', strip_tags($item_datas['item_description']));
    $this->set('fbtype', "product");
    $bannerstable = TableRegistry::get('Banners');
    $banner_datas = $bannerstable->find()->where(['banner_type' => 'product'])->first();
    $this->set('banner_datas', $banner_datas);
    $sitequeriestable = TableRegistry::get('Sitequeries');
    $sitequeriesModel = $sitequeriestable->find()->where(['type' => 'contact_seller'])->first();
    $csqueries = json_decode($sitequeriesModel['queries'], true);
    $followcnt = $this->Followers->followcnt($userid);
    if (!empty($followcnt)) {
        foreach ($followcnt as $flcnt) {
            $flwngusrids[] = $flcnt['user_id'];
        }
    }
    $this->set('followcnt', $followcnt);
    $storefollowcnt = $this->Storefollowers->followcnt($userid);
    if (!empty($storefollowcnt)) {
        foreach ($storefollowcnt as $flcnt) {
            $storeflwngusrids[] = $flcnt['store_id'];
        }
    }
    $this->set('storefollowcnt', $storefollowcnt);
    $prnt_cat_data = $this->Categories->find('all', array('recursive' => '-1', 'conditions' => array('category_parent' => 0, 'category_sub_parent' => 0)));
    $itemliststable = TableRegistry::get('Itemlists');
    $items_list_data = $itemliststable->find()->where(['user_id' => $userid])->where(['user_create_list' => '1'])->all();
    $contactsellerstable = TableRegistry::get('Contactsellers');
    $contactsellerModel = $contactsellerstable->find()->where(['itemid' => $id])->where(['buyerid' => $userid])->first();
    if (empty($id)) {
        $this->Flash->error(__d('user', 'Url is not valid'));
        $this->redirect('/');
    }
    if (empty($item_datas)) {
        $this->Flash->error(__d('user', 'The item you are searching was not found.'));
        $this->redirect('/');
    }
    $categoryID = $item_datas['category_id'];
    $moreFromCategory = $this->Items->find('all', array('conditions' => array('Item.category_id' => $categoryID, 'Item.status' => 'publish', 'Item.id <>' => $id), 'order' => 'rand()', 'limit' => 3));
    $wantOwnModel = $this->Wantownits->find('all', array('conditions' => array('userid' => $userid, 'itemid' => $id, 'type' => 'want')));
    $wantOwnModel = count($wantOwnModel);
    $wantIt = 0;
    if ($wantOwnModel > 0) {
        $wantIt = 1;
    }
    $ownIt = 0;
    $wantOwnModel = $this->Wantownits->find('all', array('conditions' => array('userid' => $userid, 'itemid' => $id, 'type' => 'own')));
    $wantOwnModel = count($wantOwnModel);
    if ($wantOwnModel > 0) {
        $ownIt = 1;
    }
    $this->set('wantIt', $wantIt);
    $this->set('ownIt', $ownIt);
    $current_page_userid = $item_datas['user']['id'];
    if (isset($userid)) {
        $usershipping = $UsersTable->find()->where(['id' => $userid])->first();
        $usershippingid = $usershipping['defaultshipping'];
        $cntry_code = $shippingaddressestable->find()->where(['shippingid' => $usershippingid])->first();
        $cntry_code = $cntry_code['countrycode'];
    } else {
        $cntry_code = '';
        $usershipping = '';
    }
    $countriestable = TableRegistry::get('Countries');
    $cntry_datas = $countriestable->find()->all();
    $commentstable = TableRegistry::get('Comments');
    $commentss_item = $commentstable->find()->contain('Users')->contain('Items')->where(['Comments.item_id' => $id])->order(['Comments.id DESC'])->group(['Comments.id'])->all();
    $itemfavs = $this->Itemfavs->find('all', array('conditions' => array('item_id' => $id)));
    foreach ($itemfavs as $i => $row) {
        $itemusr[] = $row['user_id'];
    }
    $userlevels = array('god', 'moderator');
    if (!empty($itemusr)) {
        $people_details = $UsersTable->find('all')->contain('Itemfavs')->where(['Users.id IN' => $itemusr])->where(['user_level NOT IN' => $userlevels])->where(function ($exp, $q) {
            return $exp->notEq('activation', '0');
        })->order(['Users.id DESC'])->all();
    } else {
        $people_details = "";
    }
    foreach ($people_details as $ppl_dtl) {
        $user_id = $ppl_dtl['User']['id'];
        $ppl_dtda = array();
        foreach ($ppl_dtl['itemfavs'] as $favkey => $ppl_dt) {
            $ppl_dtda[] = $ppl_dt['item_id'];
        }
        $pho_datas = $itemstable->find()->contain('Photos')->contain('Itemfavs')->where(['Items.id IN' => $ppl_dtda])->order(['Items.id DESC'])->all();
        foreach ($pho_datas as $key => $ppl_dt1) {
            $itemIdses = $ppl_dt1['id'];
            $itemnames = $ppl_dt1['item_title'];
            $itemnamesUrl = $ppl_dt1['item_title_url'];
            $photimgName = $ppl_dt1['photos'][0]['image_name'];
            $favitemcount = $ppl_dt1['fav_count'];
            $itemfavdata = $ppl_dt1['itemfavs'];
            if ($key < 8) {
                $allitemdatta[$user_id][$key]['Itemidd'] = $itemIdses;
                $allitemdatta[$user_id][$key]['item_title'] = $itemnames;
                $allitemdatta[$user_id][$key]['item_title_url'] = $itemnamesUrl;
                $allitemdatta[$user_id][$key]['image_name'] = $photimgName;
            } else {
                break;
            }
        }
    }
    $possibleCountry = array();
    foreach ($item_datas['shipings'] as $shipping) {
        $possibleCountry[] = $shipping['country_id'];
    }
    $FashionuserDet = $this->Fashionusers->find('all', array('conditions' => array('Fashionuser.itemId' => $id, 'Fashionuser.status' => 'Yes'), 'limit' => 3, 'order' => array('Fashionuser.id' => 'desc')));
    $this->set('FashionuserDet', $FashionuserDet);
    /****** Rating ***********/
    $this->loadModel('Reviews');
    $this->loadModel('Orders');
    $usrid = $loguser['id'];
    $sellerid = $item_datas["user"]["id"];
    $rateval_data = $this->Itemreviews->find('all', array('conditions' => array('seller_id' => $sellerid)));


    $count = count($rateval_data->all());
    foreach ($rateval_data as $ratevaldata) {
        $rateval_total += $ratevaldata['ratings'];
    }

    
    $orderstable = TableRegistry::get('Orders');
    $order_datas = $this->Orders->find('all', array('conditions' => array('Orders.userid' => $usrid, 'Orders.merchant_id' => $sellerid, 'Orders.reviews !=' => '1')));
    //print_r($order_datas);
    $order_count = count($order_datas);
    $query = $orderstable->find();
    $order_date = $orderstable->find('all')->where(['Orders.userid' => $usrid])->where(['Orders.merchant_id' => $sellerid])->select(['maxorderdate' => $query->func()->max('orderdate')])->first();


    $rateval_data = $this->Itemreviews->find('all', array('conditions' => array('seller_id' => $sellerid)));

    $getsellerAvg = $this->getsellerAverage( $sellerid);
    //$average_rate = $rateval_total / $count;
    $average_rate = $getsellerAvg['rating'];



    $itemDiscount = $this->Sellercoupons->find()->where([
            'sourceid' => $id,
            'type'=>'item'
            ])->first();

    $categoryDiscount = $this->Sellercoupons->find()->where([
            'sourceid' => $item_datas->category_id,
            'sellerid'=> $item_datas->user_id,
            'type'=>'category'
            ])->order(['id'=>'desc'])->first();

    //print_r($item_datas);
    //echo $item_datas->category_id;
    //print_r($categoryDiscount); die;
    $itemRemainrange = $itemDiscount->remainrange;
    $categoryRemainrange = $categoryDiscount->remainrange;

    $today_date = strtotime(date('m/d/Y'));

    if (strtotime($itemDiscount->validfrom) <= $today_date && 
                                $today_date <= strtotime($itemDiscount->validto) && 
                                $itemRemainrange > 0)
    {
        //echo 'offer';
        $seller_offer = (!empty($itemDiscount)) ? '<span class="primary-color-txt">'.$itemDiscount->couponcode.'</span> use this coupon to get extra <span class="">'.$itemDiscount->couponpercentage.'%</span> discount from <span class="">'.date("M d", strtotime($itemDiscount->validfrom)).'</span> to <span class="">'.date("M d", strtotime($itemDiscount->validto)).'</span> limited for first '.$itemDiscount->totalrange : '';
    }else{
        $seller_offer = '';
        //echo 'no offer';
    }
    //die;


    if (strtotime($categoryDiscount->validfrom) <= $today_date && 
                                $today_date <= strtotime($categoryDiscount->validto) && 
                                $categoryRemainrange > 0)
    {
        $category_offer = (!empty($categoryDiscount)) ? '<span class="primary-color-txt">'.$categoryDiscount->couponcode.'</span> use this coupon to get extra <span class="">'.$categoryDiscount->couponpercentage.'%</span> discount from <span class="">'.date("M d", strtotime($categoryDiscount->validfrom)).'</span> to <span class="">'.date("M d", strtotime($categoryDiscount->validto)).'</span> limited for first '.$categoryDiscount->totalrange : '';
    }else{
        $category_offer = '';
    }

    // cat
      // categories data
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
             $this->set('parent_categories',$parent_categories);
            $this->set('sub_categories',$sub_categories);
            $this->set('super_categories',$super_categories);


    $this->set('rateval_data', $rateval_data);
    $this->set('average_rate', $average_rate);

    $this->set('seller_offer', $seller_offer);
    $this->set('category_offer', $category_offer);


    $this->set('review_count', $count);
    $this->set('order_count', $order_count);
    $this->set('order_datas', $order_datas);
    $this->set('order_date', $order_date['maxorderdate']);
    /****** Rating ***********/
    $this->set('allitemdatta', $allitemdatta);
    $this->set('people_details', $people_details);
    $this->set('item_all', $item_all);
    $this->set('contry_datas', $cntry_datas);
    $this->set('item_datas', $item_datas);
    $this->set('moreFromCategory', $moreFromCategory);
    $this->set('loguser', $loguser);
    $this->set('userid', $userid);
    $this->set('cntry_code', $cntry_code);
    $this->set('commentss_item', $commentss_item);
    $this->set('contactsellerModel', $contactsellerModel);
    $this->set('usershipping', $usershipping);
    $this->set('possibleCountry', $possibleCountry);
    $this->set('prnt_cat_data', $prnt_cat_data);
    $this->set('items_list_data', $items_list_data);
    $this->set('roundProf', $siteChanges['profile_image_view']);
    $this->set('setngs', $setngs);
    $this->set('csqueries', $csqueries);
    $lat2 = $item_datas['shop']['shop_latitude'];
    $lon2 = $item_datas['shop']['shop_longitude'];
    $lat1 = $_SESSION['cur_lat'];
    $lon1 = $_SESSION['cur_lon'];
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $distance = $miles * 1.609344;
    $this->set('distance', $distance);
    // Top Store
    $shopstable = TableRegistry::get('Shops');
    $shopsdet = $shopstable->find('all')->contain('Users')
    ->where(['Users.user_level' => 'shop'])
    ->where(['item_count >' => '0'])
    ->where(['seller_status' => '1'])
    ->where(['store_enable' => 'enable'])
    ->where(function ($exp, $q) {
        return $exp->notEq('Shops.paypal_id', '')
        ->notEq('Shops.user_id', '$userid');
    })->order(['item_count DESC', 'Shops.follow_count DESC'])->limit('3')->all();

    // Facebook coupon
    $facebookcoup = TableRegistry::get('facebookcoupons');
    $facedata = $facebookcoup->find('all')
    ->where(['item_id' => $item_datas['id']])
    ->where(['user_id' => $usrid])
    ->first();
    $this->set('facedata', $facedata);

    $topshoparr = array();
    $skey = 0;
    foreach ($shopsdet as $shopdata) {
        $topshoparr[$skey]['username_url'] = $shopdata['user']['profile_image'];
        $topshoparr[$skey]['username'] = $shopdata['user']['username'];
        $topshoparr[$skey]['username_url_ori'] = $shopdata['user']['username_url'];
        $topshoparr[$skey]['item_count'] = $shopdata['item_count'];
        $topshoparr[$skey]['shopid'] = $shopdata['user_id'];
        $topshoparr[$skey]['shopurl'] = $shopdata['shop_name_url'];
        $topshoparr[$skey]['shopname'] = $shopdata['shop_name'];
        $topshoparr[$skey]['shop_image'] = $shopdata['shop_image'];
        $userid = $shopdata['user']['id'];
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


    } // E O function
    public function adduserlist()
    {
        global $loguser;
        $this->autoRender = false;
        $this->loadModel('Itemlists');
        $itemliststable = TableRegistry::get('Itemlists');
        $userid = $loguser['id'];
        $itemid = array();
        $itemid[] = $_REQUEST['itemid'];
        $newlist = $_REQUEST['newlist'];
        $item_ids = json_encode($itemid);
        $itemlistcount = $itemliststable->find()->where(['lists' => $newlist])->where(['user_id' => $userid])->count();
        if ($itemlistcount <= 0) {
            $itemlists = $itemliststable->newEntity();
            $itemlists->user_id = $userid;
            $itemlists->list_item_id = $item_ids;
            $itemlists->lists = $newlist;
            $itemlists->user_create_list = '1';
            $itemlists->created_on = date('Y-m-d H:i:s');
            $result = $itemliststable->save($itemlists);
            $newlistid = $result->id;
            echo $newlistid . '-_-' . $newlist;
        } else {
            echo $newlist . '-_-' . "exists";
        }
    }
    public function totaladduserlist()
    {
        global $loguser;
        $this->autoRender = false;
        $this->loadModel('Itemlists');
        $userid = $loguser['id'];
        $itemid = $_POST['itemid'];
        $allData = $_POST['alldata'];
        $params = array();
        $lists = array();
        parse_str($_POST['alldata'], $params);
        $itemliststable = TableRegistry::get('Itemlists');
        $itemstable = TableRegistry::get('Items');
        $itemlistModel = $this->Itemlists->find('all', array('conditions' => array('user_id' => $userid)));
        foreach ($itemlistModel as $itemlist) {
            $listexist[] = $itemlist['lists'];
            if (!in_array($itemlist['lists'], $params['category_items'])) {
                $listItems = json_decode($itemlist['list_item_id'], true);
                $listItems = array_diff($listItems, array($itemid));
                $itemlists = $itemliststable->find()->where(['id' => $itemlist['id']])->first();
                $itemlists->list_item_id = json_encode($listItems);
                $itemliststable->save($itemlists);
            }
        }
        $userdatasall = $itemstable->find()->contain('Photos')->where(['Items.id' => $itemid])->first();
        $notifyto = $userdatasall['user_id'];
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
        $loguserimage = json_encode($image);
        $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
        $productlink = "<a href='" . SITE_URL . "listing/" . $itemid . "/" . $itemurl . "'>" . $itemname . "</a>";
        $notifymsg = $loguserlink . " -___-added your product in their collection -___- " . $productlink;
        $logdetails = $this->addloglive('favorite', $userid, $notifyto, $itemid, $notifymsg, null, $loguserimage, $itemid);
        foreach ($params['category_items'] as $key => $para) {
            $itemlistcount = $itemliststable->find()->where(['lists' => $para])->where(['user_id' => $userid])->all();
            if (count($itemlistcount) == 0) {
                $item_lis[] = $itemid;
                $item_ids = json_encode($item_lis);
                $itemLists = $itemliststable->newEntity();
                $itemLists->user_id = $userid;
                $itemLists->list_item_id = $item_ids;
                $itemLists->lists = $para;
                $itemLists->created_on = date('Y-m-d H:i:s');
                $itemliststable->save($itemLists);
                $item_lis = '';
            } else {
                foreach ($itemlistcount as $item) {
                    $lists = json_decode($item['list_item_id'], true);
                    $lists[] = $itemid;
                    $lists = array_unique($lists);
                    $item_ids = json_encode($lists);
                    $itemLists = $itemliststable->find()->where(['id' => $item['id']])->first();
                    $itemLists->user_id = $userid;
                    $itemLists->list_item_id = $item_ids;
                    $itemLists->lists = $para;
                    $itemliststable->save($itemLists);
                    $lists = '';
                }
            }
        }
    }

    public function sendmessage()
    {
        $this->autoRender = false;
        $this->loadModel('Users');
        $this->loadModel('Contactsellers');
        $this->loadModel('Contactsellermsgs');
        $this->loadModel('Photos');
        $this->loadModel('Userdevices');
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
        $contactsellerstable = TableRegistry::get('Contactsellers');
        $contactsellers = $contactsellerstable->newEntity();
        $contactsellers->itemid = $itemId;
        $contactsellers->merchantid = $merchantId;
        $contactsellers->buyerid = $buyerId;
        $contactsellers->subject = $subject;
        $contactsellers->itemname = $itemName;
        $contactsellers->buyername = $username;
        $contactsellers->sellername = $sellername;
        $contactsellers->lastsent = $sender;
        if ($sender == 'buyer') {
            $contactsellers->sellerread = 1;
            $contactsellers->buyerread = 0;
        } else {
            $contactsellers->sellerread = 0;
            $contactsellers->buyerread = 1;
        }
        $contactsellers->lastmodified = $timenow;
        $results = $contactsellerstable->save($contactsellers);
        $lastInserId = $results->id;
        $contactsellermsgstable = TableRegistry::get('Contactsellermsgs');
        $contactsellermsgs = $contactsellermsgstable->newEntity();
        $contactsellermsgs->contactsellerid = $lastInserId;
        $contactsellermsgs->message = $message;
        $contactsellermsgs->sentby = $sender;
        $contactsellermsgs->createdat = $timenow;
        $contactsellermsgstable->save($contactsellermsgs);
        $photostable = TableRegistry::get('Photos');
        $itemImage = $photostable->find()->where(['item_id' => $itemId])->first();
        $logusername = $loguser['username'];
        $logfirstname = $loguser['first_name'];
        $logusernameurl = $loguser['username_url'];
        $itemname = $itemName;
        $itemid = base64_encode($itemId . "_" . rand(1, 9999));
        $userImg = $loguser['profile_image'];
        if (empty($userImg)) {
            $userImg = 'usrimg.jpg';
        }
        $image['user']['image'] = $userImg;
        $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
        $image['item']['image'] = $itemImage['image_name'];
        $image['item']['link'] = SITE_URL . "listing/" . $itemid;
        $loguserimage = json_encode($image);
        $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logfirstname . "</a>";
        $productlink = "<a href='" . SITE_URL . "listing/" . $itemid . "'>" . $itemname . "</a>";
        $notifymsg = $loguserlink . " -___-sent a query on your product: -___- " . $productlink;
        $logdetails = $this->addlog('chatmessage', $buyerId, $merchantId, $lastInserId, $notifymsg, $message, $loguserimage, $itemId);
        $this->loadModel('Userdevices');
        $this->loadModel('Users');
        $logusername = $username;
        $userstable = TableRegistry::get('Users');
        $logfirstnam = $userstable->find()->where(['username' => $logusername])->first();
        $logfirstname1 = $logfirstnam['first_name'];
        $userdevicestable = TableRegistry::get('Userdevices');
        $userddett = $userdevicestable->find()->where(['user_id' => $merchantId])->all();
        if (count($userddett) > 0) {
            foreach ($userddett as $userdet) {
                $deviceTToken = $userdet['deviceToken'];
                $badge = $userdet['badge'];
                $badge += 1;
                $query = $userdevicestable->query();
                $query->update()
                ->set(['badge' => "'$badge'"])
                ->where(['deviceToken' => $deviceTToken])
                ->execute();
                if (isset($deviceTToken)) {
                    $messages = $logfirstname1 . " sent a query on your product " . $itemName;
    //$Users->pushnot($deviceTToken,$messages,$badge);
                }
            }
        }
        $result[] = 'success';
        $result[] = '<a href="' . SITE_URL . 'viewmessage/' . $lastInserId . '" class="sold-contact-seller-cnt col-xs-12 col-sm-12"><span class="sold-contact-seller-txt">Contact Seller</span><i class="fa fa-angle-right pull-right"></i></a>';
        echo json_encode($result);
        $userstable = TableRegistry::get('Users');
        $email_address = $userstable->find()->where(['id' => $merchantId])->first();
        $emailaddress = $email_address['email'];
        $name = $email_address['first_name'];
        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        $email = $emailaddress;
        $aSubject = $setngs['site_name'] . " – " . __d('user', 'You have got a message');
        $aBody = '';
        $template = 'contactseller';
        $setdata = array('name' => $name, 'email' => $emailaddress, 'username' => $username, 'message' => $message, 'access_url' => SITE_URL . 'login', 'setngs' => $setngs);
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
        $this->set('username', $username);
        $this->set('message', $message);
        $this->set('access_url', SITE_URL . "login");
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
        $unread_notify_cnt = $userdata->unread_notify_cnt + 1;
        $query = $userstable->query();
        $query->update()
        ->set(['unread_notify_cnt' => "'$unread_notify_cnt'"])
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
        $userstable = TableRegistry::get('Users');
        $query = $userstable->query();
        $query->update()->set($query->newExpr('unread_livefeed_cnt = unread_livefeed_cnt + 1'))->where(['id IN' => $notifyTo])
        ->execute();
    }

    public function reportitem()
    {
        $this->autoRender = false;
        $this->loadModel('Items');
        $itemstable = TableRegistry::get('Items');
        if (isset($_GET['itemid']) && isset($_GET['userid'])) {
            $itemId = $_GET['itemid'];
            $userId = $_GET['userid'];
            $itemModel = $itemstable->find()->where(['id' => $itemId])->first();
            if (!empty($itemModel['report_flag'])) {
                $reportFlag = json_decode($itemModel['report_flag'], true);
        $reportFlag[] = $userId;
        $query = $itemstable->query();
        $query->update()
        ->set(['report_flag' => json_encode($reportFlag)])
        ->where(['id' => $itemId])
        ->execute();
    } else {
        $reportFlag[] = $userId;
        $query = $itemstable->query();
        $query->update()
        ->set(['report_flag' => json_encode($reportFlag)])
        ->where(['id' => $itemId])
        ->execute();
    }
    echo true;
    }
    }
    public function undoreportitem()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Items');
        $itemstable = TableRegistry::get('Items');
        if (isset($_GET['itemid']) && isset($_GET['userid'])) {
            $itemId = $_GET['itemid'];
            $userId = $_GET['userid'];
            $itemModel = $itemstable->find()->where(['id' => $itemId])->first();
            if (count($itemModel['report_flag']) > 0) {
                $reportFlag = json_decode($itemModel['report_flag'], true);
                $newreportflag = array();
                foreach ($reportFlag as $flag) {
                    if ($flag != $userId) {
                        $newreportflag[] = $flag;
                    }
                }
                if (!empty($newreportflag)) {
                    $query = $itemstable->query();
                    $query->update()
                    ->set(['report_flag' => json_encode($newreportflag)])
                    ->where(['id' => $itemId])
                    ->execute();
                } else {
                    $query = $itemstable->query();
                    $query->update()
                    ->set(['report_flag' => ''])
                    ->where(['id' => $itemId])
                    ->execute();
                }
            }
            echo true;
        }
    }
    public function ajaxHashAuto()
    {
        $this->autoRender = false;
        $this->loadModel('Hashtags');
        $searchWord = $_POST['searchStr'];
        $hashtagModel = $this->Hashtags->find('all', array('conditions' => array(
            'hashtag like' => $searchWord . '%'
        ), 'order' => 'usedcount DESC'));
        $hashContent = '';
        if (!empty($hashtagModel)) {
            foreach ($hashtagModel as $hashtag) {
                $tagName = $hashtag['hashtag'];
                $hashContent .= "<li><input type='hidden' class = 'nam'  value='" . $tagName . "' /><a class='username'>" . $tagName . "</a></li>";
                $hashcontents[] = "#" . $tagName;
            }
        } else {
            $hashContent = "No Data";
        }
        $json = array();
        $json[] = $hashContent;
        echo json_encode($hashcontents);
    }
    public function ajaxUserAuto()
    {
        $this->autoRender = false;
        $this->loadModel('Users');
        $this->loadModel('Items');
        global $siteChanges;
        $roundProf = "";
        if ($siteChanges['profile_image_view'] == "round") {
            $roundProfile = "border-radius:50%;";
        } else {
            $roundProfile = "border-radius:0 !important;";
        }
        $searchWord = $_POST['searchStr'];
        $userContent = '';
        $userstable = TableRegistry::get('Users');
        $userDetails = $userstable->find()->where(['username LIKE' => $searchWord . '%'])
        ->where(['user_level' => 'normal'])
        ->limit('50')->all();
        if (count($userDetails) > 0) {
            $k = 0;
            foreach ($userDetails as $userData) {
                $usernameurl = $userData['username_url'];
                $usernam = $userData['username'];
                $userimg = $userData['profile_image'];
                if (empty($userimg)) {
                    $userimg = "usrimg.jpg";
                } else {
                    $userimg = $userimg;
                }
                $url = SITE_URL . 'people/' . $usernameurl;
    if ($usernameurl != "")
        $usercontents[] = "@" . $usernameurl . "";
    $k++;
    }
    } else {
        $userContent = "No Data";
    }
    $json = array();
    $json[] = $userContent;
    echo json_encode($usercontents);
    }

    function addcomments()
    {
        global $loguser;
        global $setngs;
        $logusername = $loguser['username'];
        $this->autoRender = false;
        $this->loadModel('Hashtags');
        $userid = $_REQUEST['userid'];
        $itemid = $_REQUEST['itemid'];
        $commentss = $_REQUEST['commentss'];
        $usedHashtags = $_REQUEST['hashtags'];
        $mentionedUsers = $_REQUEST['atusers'];
        $oldHashtags = array();
        $hashtagstable = TableRegistry::get('Hashtags');
        $commentstable = TableRegistry::get('Comments');
        $itemstable = TableRegistry::get('Items');
        $userstable = TableRegistry::get('Users');

        if ($usedHashtags != '') {
            $hashTags = explode(',', $usedHashtags);
            $hashtagstable = TableRegistry::get('Hashtags');
            $hashtagsModel = $hashtagstable->find()->where(['hashtag IN' => $hashTags])->all();
            if (!empty($hashtagsModel)) {
                foreach ($hashtagsModel as $hashtags) {
                    $id = $hashtags['id'];
                    $count = $hashtags['usedcount'] + 1;
                    $hashquery = $hashtagstable->query();
                    $hashquery->update()
                    ->set(['usedcount' => "'$count'"])
                    ->where(['id' => $id])
                    ->execute();
                    $oldHashtags[] = $hashtags['hashtag'];
                }
            }
            foreach ($hashTags as $hashtag) {
                if (!in_array($hashtag, $oldHashtags)) {
                    $hasgtags = $hashtagstable->newEntity();
                    $hasgtags->hashtag = $hashtag;
                    $hasgtags->usedcount = 1;
                    $hashtagstable->save($hasgtags);
                }
            }
        }
        $comments_datas = $commentstable->newEntity();
        $comments_datas->user_id = $userid;
        $comments_datas->item_id = $itemid;
        $comments_datas->comments = $commentss;
        $comments_datas->created_on = date("Y-m-d H:i:s");
        $results = $commentstable->save($comments_datas);
        $comment_id = $results->id;
        $userdatasall = $itemstable->find()->contain('Photos')->contain('Users')->contain('Itemfavs')->where(['Items.id' => $itemid])->first();

        if ($mentionedUsers != "") 
        {
            $mentionedUsers = explode(",", $mentionedUsers);
            foreach ($mentionedUsers as $musers) 
            {
                $userModel = $userstable->find()->where(['username' => $musers])->first();
                $unread_notify_cnt = $userModel['unread_livefeed_cnt'] + 1;
                $query = $userstable->query();
                $query->update()
                ->set(['unread_livefeed_cnt' => $unread_notify_cnt])
                ->where(['username' => $musers])
                ->execute();

                $notificationSettings = json_decode($userModel['push_notifications'], true);
                $notifyto = $userModel['id'];
                $userImg = 'usrimg.jpg';
                if ($notificationSettings['somone_mentions_push'] == 1 && $userid != $notifyto) {
                    $logusername = $loguser['username'];
                    $logusernameurl = $loguser['username_url'];
                    $itemname = $userdatasall['item_title'];
                    $itemurl = $userdatasall['item_title_url'];
                    $liked = $setngs['liked_btn_cmnt'];
                    $userImg = $loguser['profile_image'];
                    $item_url = base64_encode($itemid . "_" . rand(1, 9999));
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                    if ($userdatasall['photos'][0]['image_name'] != '')
                        $image['item']['image'] = $userdatasall['photos'][0]['image_name'];
                    if ($itemid == 0) {
                        $image['item']['link'] = 0;
                    } else {
                        $image['item']['link'] = SITE_URL . "listing/" . $item_url;
                    }
                    $loguserimage = json_encode($image);
                    $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                    $productlink = "<a href='" . SITE_URL . "listing/" . $item_url . "'>" . $itemname . "</a>";
                    $notifymsg = $loguserlink . " -___-mentioned you in a comment on: -___- " . $productlink;
                    if ($itemid == 0) {
                        $productlink = "<a href='" . SITE_URL . "create/giftcard/'>Gift Card.</a>";
                        $notifymsg = $loguserlink . " -___-mentioned you in a comment on: -___- " . $productlink;
                        $itemname = "Gift Card";
                    }
                    $logdetails = $this->addloglive('mentioned', $userid, $notifyto, $comment_id, $notifymsg, $commentss, $loguserimage, $itemid);
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
                            $pushMessage['type'] = 'mentioned';
                            $pushMessage['user_id'] = $loguser['id'];
                            $pushMessage['item_id'] = $itemid;
                            $pushMessage['user_name'] = $loguser['username'];
                            $pushMessage['user_image'] = $userImg;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $notifyto])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "mentioned you in a item comment");
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }
                }
            }
        }

        $favUsers = $userdatasall['itemfavs'];
        if (!empty($favUsers)) 
        {
            foreach ($favUsers as $fuser) {
                $userModel = $userstable->find()->where(['id' => $fuser['user_id']])->first();
                $notificationSettings = json_decode($userModel['push_notifications'], true);
                $notifyto = $userdatasall['user']['id'];
                if ($notificationSettings['somone_cmnts_push'] == 1 && $userid != $notifyto) {
                    $favnotifyto[] = $userModel['id'];
                }
            }
            if (!empty($favnotifyto)) {
                $logusername = $loguser['username'];
                $logusernameurl = $loguser['username_url'];
                $itemname = $userdatasall['item_title'];
                $itemurl = $userdatasall['item_title_url'];
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
                $notifymsg = $loguserlink . " -___-commented on-___- " . $productlink;
                $logdetails = $this->addloglive('comment', $userid, $favnotifyto, $comment_id, $notifymsg, $commentss, $loguserimage);
            }
        }

        $this->loadModel('Userdevices');
        $this->loadModel('Items');
        $userdevicestable = TableRegistry::get('Userdevices');
        $getuserIdd = $itemstable->find()->where(['id' => $itemid])->first();
        $ItemaddUserid = $getuserIdd['user_id'];
        if ($ItemaddUserid != $userid) {
            $userddett = $userdevicestable->find()->where(['user_id' => $ItemaddUserid])->all();
            foreach ($userddett as $userd) {
                $deviceTToken = $userd['deviceToken'];
                $badge = $userd['badge'];
                $badge += 1;
                $this->Userdevices->updateAll(array('badge' => "'$badge'"), array('deviceToken' => $deviceTToken));
                if (isset($deviceTToken)) {
                    $messages = $logusername . " is commented on your item : " . $commentss;
                }
            }
        }
        $cmntCount = $commentstable->find()->where(['item_id' => $itemid])->count();
        $itemquery = $itemstable->query();
        $itemquery->update()
        ->set(['comment_count' => $cmntCount])
        ->where(['id' => $itemid])
        ->execute();
        $item_status = $userdatasall['user']['someone_cmnt_ur_things'];
        $sitesettingstable = TableRegistry::get('Sitesettings');
        $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
        if ($item_status == 1) {
            $item_url = base64_encode($itemid . "_" . rand(1, 9999));
            $email = $userdatasall['user']['email'];
            $aSubject = $setngs['site_name'] . " - " . __d('user', 'Some one commented on your product - Product ID') . " #" . $itemid;
            $aBody = '';
            $template = 'addcomment';
            $setdata = array('name' => $userdatasall['user']['first_name'], 'itemname' => $userdatasall['item_title'], 'itemurl' => $item_url, 'itemid' => $itemid, 'comments' => $commentss);
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
            $this->Email->to = $userdatasall['user']['email'];
            $this->Email->subject = $setngs['site_name'] . " - Some one commented on your product - Product ID #" . $itemid;
            $this->Email->from = SITE_NAME . "<" . $setngs['noreply_email'] . ">";
            $this->Email->sendAs = "html";
            $this->Email->template = 'addcomment';
            $this->set('name', $userdatasall['user']['first_name']);
            $this->set('itemname', $userdatasall['item_title']);
            $this->set('$itemurl', $userdatasall['item_title_url']);
            $this->set('itemid', $itemid);
            $this->set('comments', $commentss);
        }

        echo $comment_id;
        die;

    }

    function editcommentsave()
    {
        $cmtid = $_REQUEST['cmtid'];
        $cmntval = $_REQUEST['cmntval'];
        $commentstable = TableRegistry::get('Comments');
        $query = $commentstable->query();
        $query->update()
        ->set(['comments' => $cmntval])
        ->where(['id' => $cmtid])
        ->execute();
        echo strip_tags($cmntval);
        die;
    }
    function deletecomments()
    {
        $cmtid = $_REQUEST['addid'];
        $this->loadModel('Comments');
        $this->loadModel('Logs');
        $itemid = $_REQUEST['itemid'];
        $commentstable = TableRegistry::get('Comments');
        $commentquery = $commentstable->query();
        $commentquery->delete()
        ->where(['id' => $cmtid])
        ->execute();
        $logstable = TableRegistry::get('Logs');
        $logsquery = $logstable->query();
        $logsquery->delete()
        ->where(['notification_id' => $cmtid])
        ->where(['type' => 'comment'])
        ->execute();
        $cmntCount = $commentstable->find()->where(['item_id' => $itemid])->count();
        $itemstable = TableRegistry::get('Items');
        $query = $itemstable->query();
        $query->update()
        ->set(['comment_count' => "'$cmntCount'"])
        ->where(['id' => $itemid])
        ->execute();
        echo "1";
        die;
    }
    //CHANGE QUANTITY AND SIZES
    function getsizeqty()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $itemId = $_POST['id'];
        $seltsize = $_POST['size'];
        $itemstable = TableRegistry::get('Items');
        $itemModel = $itemstable->find('all')->contain('Forexrates')->where(['Items.id' => $itemId])->first();
        $sizeqty = $itemModel['size_options'];
        $sizeQty = json_decode($sizeqty, true);
        $prices = $sizeQty['price'][$seltsize];
        if ($prices == 0 || $prices == '')
            $price = $itemModel['price'];
        else
            $price = $sizeQty['price'][$seltsize];
        $qty = $sizeQty['unit'][$seltsize];
        $qtyOptions = '' . '<option value="" >' . __d('user', 'QUANTITY') . '</option>';
        for ($i = 1; $i <= $qty; $i++) {
            $qtyOptions .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $date = date('d');
        $month = date('m');
        $year = date('Y');
        $today = date('m/d/Y');
        $tdy = strtotime($month . '/' . $date . '/' . $year);
        if(isset($itemModel->dealdate) && $itemModel->dealdate != '' )
                    {
                        $dealdate = $itemModel->dealdate->format('Y-m-d');
                        $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }else{
                        $dealstrtime = '';
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }
        if (($itemModel['discount_type'] == 'daily' && $todaystrtime == $dealstrtime ) || ($itemModel['discount_type'] == 'regular')) {
            if (isset($_SESSION['currency_code'])) {
                $dealprice = $price * (1 - $itemModel['discount'] / 100);
                $dealprice = $this->Currency->conversion($itemModel['forexrate']['price'], $_SESSION['currency_value'], $dealprice);
                $price = $this->Currency->conversion($itemModel['forexrate']['price'], $_SESSION['currency_value'], $price);
                $convertprice = round($price, 2);
                $convertdealprice = round($dealprice, 2);
            } else {
                $price = $price;
                $dealprice = $price * (1 - $itemModel['discount'] / 100);
                $convertprice = round($price, 2);
                $convertdealprice = round($dealprice, 2);
            }
            $convertprice = $convertdealprice;
            $priceval = $price * (1 - $itemModel['discount'] / 100);
            $deal = "deal";
            if (isset($_SESSION['currency_symbol'])){
                $price = $_SESSION['currency_symbol'] . "&nbsp;" . $price;
                 $convertprice=$_SESSION['currency_symbol'] . "&nbsp;" . $convertprice;
            }
            else{
                $price = $itemModel['forexrate']['currency_symbol'] . "&nbsp;" . $price;
                $convertprice = $itemModel['forexrate']['currency_symbol'] . "&nbsp;" . $convertprice;
            }

            //echo "HERE".$price;
        } else {
            $price = $price;
            $convertprice = round($price * $itemModel['forexrate']['price'], 2);
            $priceval = $price;
            if (isset($_SESSION['currency_symbol'])){
                $price = $_SESSION['currency_symbol'] . "&nbsp;" . $this->Currency->conversion($itemModel['forexrate']['price'], $_SESSION['currency_value'], $price);
                 $convertprice = $_SESSION['currency_symbol'] . "&nbsp;" . $this->Currency->conversion($itemModel['forexrate']['price'], $_SESSION['currency_value'], $convertprice);
            }
            else{
                $price = $itemModel['forexrate']['currency_symbol'] . "&nbsp;" . $price;
                 $convertprice = $itemModel['forexrate']['currency_symbol'] . "&nbsp;" . $convertprice;
            }
            $deal = "nodeal";
            //echo "THERE";
        }
      // echo "PRICE=".$price."CUR".$_SESSION['currency_symbol']."==".$itemModel['forexrate']['currency_symbol'];

        $output = array();
        $output[] = $qtyOptions;
        $output[] = $price;
        $output[] = $priceval . "&nbsp;";
        $output[] = $convertprice;
        $output[] = $deal;
        if ($oldprice != $price && $price_old == 1)
            $output[] = '<span style="text-decoration:line-through;color:#8D8D8D;"><span style="font-size:20px;">' . $oldprice . '</span>' . $_SESSION['currency_code'] . '</span>';
        else
            $output[] = '';
        echo json_encode($output);
    }
    function getfacebookcoupon()
    {
                echo 'cec';die;

        die;
        $this->autoRender = false;
        global $loguser;
        $userId = $loguser['id'];
        $itemId = $_REQUEST['itemId'];
        $shopId = $_REQUEST['shopId'];
        $this->loadModel('Facebookcoupons');
        $this->loadModel('Sellercoupons');
        $this->loadModel('Shops');
        $this->loadModel('Items');
        $itemstable = TableRegistry::get('Items');
        $sellercouponstable = TableRegistry::get('Sellercoupons');
        $facebookcouponstable = TableRegistry::get('Facebookcoupons');
        $generatevalue = $this->Urlfriendly->get_uniquecode('8');
        $itemDatas = $itemstable->find()->where(['id' => $itemId])->first();
        $couponPercent = $itemDatas['share_discountAmount'];
        $getcouponval = $sellercouponstable->find()->where(['couponcode' => $generatevalue])->first();
        $todayDate = date("Y-m-d");
        $lastDate = date("Y-m-d", strtotime("tomorrow"));
        if (empty($getcouponval)) {
            $sellercoupon = $sellercouponstable->newEntity();
            $sellercoupon->type = 'facebook';
            $sellercoupon->couponcode = $generatevalue;
            $sellercoupon->couponpercentage = $couponPercent;
            $sellercoupon->remainrange = 1;
            $sellercoupon->sellerid = $shopId;
    $sellercoupon->sourceid = $itemId; //Item is the source
    $sellercoupon->totalrange = 1;
    $sellercoupon->validfrom = $todayDate;
    $sellercoupon->validto = $lastDate;
    $couponid = $sellercouponstable->save($sellercoupon);
    $couponId = $couponid->id;
    $facebookcoupon = $facebookcouponstable->newEntity();
    $facebookcoupon->couponcode = $generatevalue;
    $facebookcoupon->item_id = $itemId;
    $facebookcoupon->user_id = $userId;
    $facebookcoupon->coupon_id = $couponId;
    $facebookcoupon->cdate = time();
    $facebookcouponid = $facebookcouponstable->save($facebookcoupon);
    $shareCouponId = $facebookcouponid->id;
    echo $generatevalue;
    } else {
        echo 'false';
    }
    die;
    }
    public function sociallogin()
    {
        $this->autoRender = false;
        global $loguser;
        $userId = $loguser['id'];
        $itemId = $_REQUEST['itemId'];
        $shopId = $_REQUEST['shopId'];
        $this->loadModel('Facebookcoupons');
        $this->loadModel('Sellercoupons');
        $this->loadModel('Shops');
        $this->loadModel('Items');
        $itemstable = TableRegistry::get('Items');
        $sellercouponstable = TableRegistry::get('Sellercoupons');
        $facebookcouponstable = TableRegistry::get('Facebookcoupons');
        $generatevalue = $this->Urlfriendly->get_uniquecode('8');
        $itemDatas = $itemstable->find()->where(['id' => $itemId])->first();
        $couponPercent = $itemDatas['share_discountAmount'];
        $getcouponval = $sellercouponstable->find()->where(['couponcode' => $generatevalue])->first();
        $todayDate = date("Y-m-d");
        $lastDate = date("Y-m-d", strtotime("tomorrow"));
        if (empty($getcouponval)) {
            $sellercoupon = $sellercouponstable->newEntity();
            $sellercoupon->type = 'facebook';
            $sellercoupon->couponcode = $generatevalue;
            $sellercoupon->couponpercentage = $couponPercent;
            $sellercoupon->remainrange = 1;
            $sellercoupon->sellerid = $shopId;
            $sellercoupon->sourceid = $itemId; 
            $sellercoupon->totalrange = 1;
            $sellercoupon->validfrom = $todayDate;
            $sellercoupon->validto = $lastDate;
            $couponid = $sellercouponstable->save($sellercoupon);
            $couponId = $couponid->id;
            $facebookcoupon = $facebookcouponstable->newEntity();
            $facebookcoupon->couponcode = $generatevalue;
            $facebookcoupon->item_id = $itemId;
            $facebookcoupon->user_id = $userId;
            $facebookcoupon->coupon_id = $couponId;
            $facebookcoupon->cdate = time();
            $facebookcouponid = $facebookcouponstable->save($facebookcoupon);
            $shareCouponId = $facebookcouponid->id;
            echo $generatevalue;
        } else {
            echo 'false';
        }
        die;
    }

    public function addfaqdata()
    {
       // echo "addfaqdata";die;

        $itemstable = TableRegistry::get('Items');
        $item_datas = $itemstable->find('all')->contain('Forexrates')->contain('Shops')->contain('Users')->contain(['Photos'])->where(['Items.id' => $_POST['item_id']])->first();
        if($_POST['type'] == 'question')
        {
            $productfaqTable = TableRegistry::get('Productfaq');
            $productfaq = $productfaqTable->newEntity();
            $productfaq->item_id = $_POST['item_id'];
            $productfaq->user_id = $_POST['user_id'];
            $productfaq->seller_id = $item_datas->user_id;
            $productfaq->content = nl2br($_POST['content']);
            $productfaq->type = $_POST['type'];
            $productfaq->status = '1';
        }elseif($_POST['type'] == 'answer'){

            $itemstable = TableRegistry::get('Productfaq');
            $query = $itemstable->query();
            $query->update()
                ->set(['answer_count' => 'answer_count+1'])
                ->where(['id' => $_POST['parent_id']])
                ->execute();

            $productfaqTable = TableRegistry::get('Productfaq');
            $productfaq = $productfaqTable->newEntity();
            $productfaq->item_id = $_POST['item_id'];
            $productfaq->user_id = $_POST['user_id'];
            $productfaq->seller_id = $item_datas->user_id;
            $productfaq->content = nl2br($_POST['content']);
            $productfaq->parent_id = $_POST['parent_id'];
            $productfaq->type = $_POST['type'];
            $productfaq->status = '1';
        }
        
        if ($productfaqTable->save($productfaq)) {
            echo json_encode(array(
                    'id'=>$productfaq->id,
                    'item_id'=>$productfaq->item_id,
                    'user_id'=>$productfaq->user_id,
                    'content'=>$productfaq->content,
                    'type'=>$productfaq->type
                    )
                );
            
        }else{
            echo 'false';
            
        }
        die;
    }

    /*
        Common functions..
    */
    function getanswerlists()
    {
        $this->loadModel('Productfaq');
        $this->loadModel('Users');
        $this->loadModel('Shops');

        $faqtable = TableRegistry::get('Productfaq');
        $faq_datas = $faqtable->find()->where(['parent_id'=>$_POST['question_id']])->order(['id'=>'DESC'])->toArray();

        $getQuestion = $faqtable->find()->where(['id'=>$_POST['question_id']])->first();
        $val = '';
        foreach($faq_datas as $faq_key=>$faq_val)
        {
            $userTable = TableRegistry::get('Users');
            $userData = $userTable->find()->where(['id'=>$faq_val->user_id])->first();
            $usrimg = ($userData->profile_image == '') ? SITE_URL.'/media/avatars/thumb70/usrimg.jpg' : SITE_URL.'/media/avatars/thumb70/'.$userData->profile_image;

            if($userData->user_level == 'normal')
            {
                $usrHreflink = SITE_URL.'people/'.$userData->username_url;
            }elseif($userData->user_level == 'shop'){
                $shopData = $this->Shops->find('all', array(
                        'conditions' => array(
                            'user_id' => $userData->id
                        ),
                        'order' => 'id DESC',
                    ))->first();
                $usrHreflink = SITE_URL.'stores/'.$shopData->shop_name_url;
            }

            /*
                $val .= '<div class="modal_ques-ans_sec"><div class="quanswre_two"><p class="mod_ans_sty"> <span><a href="'.$usrHreflink.'" target="_blank"><img class="ansimg" src="'.$usrimg.'" /></a></span></p><p class="prd_ans_det"><span class="answr">'.$faq_val->content.'</span><span class="cus_nam"><a href="'.$usrHreflink.'" target="_blank">'.$userData->username.'</a></span></p></div></div>';
            */
            
            $content = str_replace('<p dir="ltr">', '', $faq_val->content);
            $content = str_replace('</p>', '', $content);

            $val .= '<div class="modal_ques-ans_sec"><div class="quanswre_two"><p class="mod_ans_sty"> <span><a href="'.$usrHreflink.'" target="_blank"><img class="ansimg" src="'.$usrimg.'" /></a></span></p><div class="prd_ans_det">'.$content.'<br/><span class="cus_nam"><a href="'.$usrHreflink.'" target="_blank">'.$userData->username.'</a></span></div></div></div>';
        }
        echo 'Q: '.$getQuestion->content.'ans#list'.$val.'author_id'.$getQuestion->user_id; die;
    }

    function viewallfaq($item_id)
    {
        global $loguser;
        $productfaqtable = TableRegistry::get('Productfaq');
        $userstable = TableRegistry::get('Users');
        $faq_count = $productfaqtable->find()->where(['item_id' => $item_id,'parent_id'=>'0'])->count();

        if(isset($_POST['offset']) && isset($_POST['limit']))
        {

            $offset = $_POST['offset'];
            $limit = $_POST['limit'];

            $faq_datas = $productfaqtable->find()->where(['item_id' => $item_id,'parent_id'=>'0'])->limit($limit)->offset($offset)->order(['id'=>'DESC'])->toArray();    
        }else{
            
            $faq_datas = $productfaqtable->find()->where(['item_id' => $item_id,'parent_id'=>'0'])->limit(10)->offset(0)->order(['id'=>'DESC'])->toArray();    
        }

        $orderstable = TableRegistry::get('Orders');
        $orderitemstable = TableRegistry::get('OrderItems');

        $ordersModel = $orderstable->find('all')->where(['userid' => $loguser['id'],'status'=>'Delivered'])->order(['orderid DESC'])->all();

        $orderid = array();
        foreach ($ordersModel as $value) {
            $orderid[] = $value->orderid;
        }

        //print_r($orderid); die;
        if(!empty($orderid))
        {

            $orderitemModel = $orderitemstable->find('all')->where(['itemid'=>$item_id,'orderid IN' => $orderid])->order(['orderid DESC'])->first();  

            //print_r($orderitemModel); die;

            $order_id = (isset($orderitemModel->orderid)) ? $orderitemModel->orderid : '';
            if(isset($orderitemModel->orderid)){

                $this->loadModel('Itemreviews');
                $get_review = TableRegistry::get('Itemreviews');
                $firstreviewData = $this->Itemreviews->find('all', array(
                        'conditions' => array(
                            'itemid' => $item_id,
                            'orderid'=> $orderitemModel->orderid
                        ),
                        'order' => 'id DESC',
                    ))->first();

                //print_r($firstreviewData); die;
                $review_id = (isset($firstreviewData->id)) ? $firstreviewData->id : '';
                $order_id = $orderitemModel->orderid;
            }
        }else{
            $order_id = '';
            $review_id = '';
        }


        foreach($faq_datas as $eachfaq=>$eachval)
        {
            $userdata = $userstable->find()->where(['id' => $eachval->user_id])->first();

            $results[$eachfaq]['content'] = $eachval->content;
            $results[$eachfaq]['question_id'] = $eachval->id;
            $results[$eachfaq]['user_id'] = $eachval->user_id;
            $results[$eachfaq]['username'] = $userdata->username;
            $results[$eachfaq]['username_url'] = $userdata->username_url;
            $results[$eachfaq]['profile_image'] = $userdata->profile_image;
            $results[$eachfaq]['item_id'] = $eachval->item_id;

            $ans = $productfaqtable->find()->where(['parent_id' => $eachval->id])->order(['id'=>'DESC'])->first();
            $ansCount = $productfaqtable->find()->where(['parent_id' => $eachval->id])->count();
            $a_user = $userstable->find()->where(['id' => $ans->user_id])->first();

            if($ans->content != '')
            {
                $results[$eachfaq]['answer']['user_id'] = $ans->user_id;
                $results[$eachfaq]['answer']['answer_id'] = $ans->id;
                $results[$eachfaq]['answer']['username'] = $a_user['username'];
                $results[$eachfaq]['answer']['username_url'] = $a_user['username_url'];
                $results[$eachfaq]['answer']['profile_image'] = $a_user['profile_image'];
                $results[$eachfaq]['answer']['parent_id'] = $ans->parent_id;
                $results[$eachfaq]['answer']['item_id'] = $ans->item_id;
                $results[$eachfaq]['answer']['content'] = $ans->content;    
            }
            
            
        }

        if(isset($_POST['ajaxrequest']))
        {
            $val = '';
            foreach($results as $faqkey=>$faqval)
            {
                $val .= '<div class="ques-ans_sec"><div class="quanswre"><h2> Q: '.$faqval['content'].'</h2>';

                
                if(isset($faqval['answer']))
                {
                    $val .= '<p class="ans_sty"> <strong>A:</strong> <span> '.$faqval['answer']['content'].' </span></p>';
                    $val .= '</div></div><div>';
                    $val .= '<a href="javascript:void(0);" class="view_QA"  onclick="read_other_answers('.$faqval["question_id"].');">Read other answers</a></div><hr>';    
                }elseif((isset($order_id) && $order_id != '') && !isset($faqval['answer']))
                {
                    
                    if($faqval['user_id'] == $_POST['loguserid'])
                    {
                        $val .= '<p class="ans_sty"> <strong>No answer</strong> </p>';
                    }else{
                        $val .= '<a href="javascript:void(0);" class="view_QA"  onclick="read_other_answers('.$faqval["question_id"].');">Write answer</a></div><hr>';
                        
                        //$val .= '</div></div><div>';
                    }
                    $val .= '</div></div><div>';
                    
                }else{
                    $val .= '<p class="ans_sty"> <strong>No answer</strong> </p>';
                    $val .= '</div></div><div>';
                }
                
            }
            echo $val; die;
        }
        $itemstable = TableRegistry::get('Items');
        $item_datas = $itemstable->find('all')->contain('Forexrates')->contain('Shops')->contain('Users')->contain(['Photos'])->where(['Items.id' => $item_id])->first();


        $item_url = SITE_URL . "listing/" . base64_encode($item_datas->id . "_" . rand(1, 9999));
        

        $this->set('productfaq', $results);
        $this->set('faq_count',$faq_count);
        $this->set('ans_count',$ansCount);
        $this->set('loguser', $loguser);
        $this->set('item_url',$item_url);
        $this->set('order_id', $order_id);
        $this->set('review_id', $review_id);
        $this->set('item_data',$item_datas);
    }

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
        return array('reviews'=>$n, 'rating'=>round($Rating,1));
    }

    /*
        Add Item reviews.
    */
    // function additemReviews()
    // {
    //     $this->loadModel('Itemreviews');
    //     $userstable = TableRegistry::get('Users');
    //     $itemstable = TableRegistry::get('Items');
    //     $itemreviewTable = TableRegistry::get('Itemreviews');
        
    //     $user_id = $_POST['user_id'];
    //     $item_id = $_POST['item_id'];
    //     $order_id = $_POST['order_id'];
    //     //$reviewtitle = $_POST['review_title'];
    //     $reviews = nl2br(trim($_POST['review']));
    //     //$reviews = preg_replace("/[\n\r]/","&#13;&#10;",$_POST['review']);
    //     //$stringWithPs = str_replace("<br /><br />", "</p>\n<p>", $reviews);
    //     //$reviews = $stringWithPs;
    //     //$reviews = preg_replace("/[\r\n]/","<p>",$_POST['review']);

    //     //secho $reviews; die;
    //     $rating = $_POST['rating'];

    //     $this->loadModel('Items');

    //     if(isset($_POST['review_id']) && $_POST['review_id'] != '')
    //     {
    //         $this->Itemreviews->updateAll(array('reviews' => $reviews,'ratings'=>$rating), array('id' => $_POST['review_id']));

    //         //Item ratings.
    //         $getAvg = $this->getAverage($item_id);
    //         //Seller ratings.
    //         $getsellerAvg = $this->getsellerAverage($itemData->user_id);

    //         $querys = $itemstable->query();
    //                 $querys->update()
    //                 ->set(['avg_rating' => $getAvg['rating']])
    //                 ->where(['id' => $item_id])
    //                 ->execute();

    //         $querys = $userstable->query();
    //                 $querys->update()
    //                 ->set(['seller_ratings' => $getsellerAvg['rating']])
    //                 ->where(['id' => $itemData->user_id])
    //                 ->execute();
    //         echo '{"status":"true","message":"Successfully updated."}';
    //         die;
    //     }



    //     $itemData = $this->Items->find()->where(['id' => $item_id])->first();

        
    //     $itemreview = $itemreviewTable->newEntity();
    //     $itemreview->userid = $user_id;
    //     $itemreview->itemid = $item_id;
    //     $itemreview->orderid = $order_id;
    //     $itemreview->seller_id = $itemData->user_id;
    //     $itemreview->reviews = $reviews;
    //     $itemreview->ratings = $rating;
    //     $result = $itemreviewTable->save($itemreview);

    //     $getAvg = $this->getAverage($item_id);

        
    //     $querys = $itemstable->query();
    //             $querys->update()
    //             ->set(['avg_rating' => $getAvg['rating']])
    //             ->where(['id' => $item_id])
    //             ->execute();

    //     $querys = $userstable->query();
    //                 $querys->update()
    //                 ->set(['seller_ratings' => $getsellerAvg['rating']])
    //                 ->where(['id' => $itemData->user_id])
    //                 ->execute();
        
    //     if(isset($result))
    //     {
    //         echo json_encode(array('status'=>'true','message'=>'successfully added')); die;
    //     }else{
    //         echo json_encode(array('status'=>'false','message'=>'something went wrong')); die;
    //     }
        
        
    // }
    function additemReviews()
    {

     
        $this->loadModel('Itemreviews');
        
        $userstable = TableRegistry::get('Users');
        $itemstable = TableRegistry::get('Items');
        $itemreviewTable = TableRegistry::get('Itemreviews');
        
        $user_id = $_POST['user_id'];
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
            $this->Itemreviews->updateAll(array('reviews' => $reviews,'ratings'=>$rating), array('id' => $_POST['review_id']));

            //Item ratings.
            $getAvg = $this->getAverage($item_id);
            //Seller ratings.
            $getsellerAvg = $this->getsellerAverage($itemData->user_id);

            $querys = $itemstable->query();
                    $querys->update()
                    ->set(['avg_rating' => $getAvg['rating']])
                    ->where(['id' => $item_id])
                    ->execute();

            $querys = $userstable->query();
                    $querys->update()
                    ->set(['seller_ratings' => $getsellerAvg['rating']])
                    ->where(['id' => $itemData->user_id])
                    ->execute();
            echo '{"status":"true","message":"Successfully updated."}';
            die;
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
                ->set(['avg_rating' => $getAvg['rating']])
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
        return array('reviews'=>$n, 'rating'=>round($Rating,1));die;
    }

    function viewallreviews($value='')
    {

       // echo 'check';die;
        global $loguser;
        
        $itemreviewTable = TableRegistry::get('Itemreviews');
        $this->loadModel('Users');
        $this->loadModel('Itemreviews');
        $reviewData = $this->Itemreviews->find('all', array(
                'conditions' => array(
                    'itemid' => $value
                ),
                'order' => 'id DESC',
            ))->all();

        $result = array();
        foreach($reviewData as $key=>$eachreview)
                {

                    $user_data = $this->Users->find()->where(['id' => $eachreview->userid])->first();

                    
                    $result[$key]['user_id'] = $eachreview->userid;
                    $result[$key]['user_name'] = $user_data->username;
                    $result[$key]['user_image'] = ($user_data->profile_image == '') ? SITE_URL.'img/user.png' : SITE_URL.'/media/avatars/thumb70/'.$user_data->profile_image;
                    $result[$key]['id'] = $eachreview->orderid;
                    $result[$key]['review_title'] = $eachreview->review_title;
                    $result[$key]['username_url'] = SITE_URL . "people/" . $user_data['username_url'];
                    $result[$key]['rating'] = $eachreview->ratings;
                    $result[$key]['review'] = $eachreview->reviews;
                }

                $itemstable = TableRegistry::get('Items');
            $item_datas = $itemstable->find('all')->contain('Forexrates')->contain('Shops')->contain('Users')->contain(['Photos'])->where(['Items.id' => $value])->first();
            
            $item_url = SITE_URL . "listing/" . base64_encode($item_datas->id . "_" . rand(1, 9999));

                $this->set('item_url',$item_url);
                $this->set('item_data',$item_datas);

                $this->set('reviews',$result);
                $this->set('loguser',$loguser);
    }


    public function getItemByCategoryView()
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
            $colorstable = TableRegistry::get('Colors');
            $pricestable = TableRegistry::get('Prices');
            $bannerstable = TableRegistry::get('Banners');
            $categoriestable = TableRegistry::get('Categories');

            $this->loadModel('Prices');
            $this->loadModel('Colors');

            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            $banner_datas = $bannerstable->find()->where(['banner_type' => 'shop'])->first();
            $this->set('banner_datas', $banner_datas);

            $category = $_POST['category'];
            $category = explode('/', $category);
            $count = count($category);
            $resultCategory = $category[$count - 1];

            $refreshCatergory = 1;
            $searchKeyString = "";
            $sortText = 'Sort by : Newest';
            if (isset($_POST['categorychanged']) && !empty($_POST['categorychanged'])) {
                $refreshCatergory = 0;
            }

            if (isset($_POST['catids']) && !empty($_POST['catids'])) {
                $prevCat = explode('-', $_POST['catids']);
                $count = count($prevCat);
            } else
                $count = 0;

            $startIndex = 0;
            $offset = 20;
            if (isset($_GET['startIndex'])) {
                $startIndex = $_GET['startIndex'];
            }



            //echo $startIndex.'start index'; die;
            $itemstable = TableRegistry::get('Items');
            $itemarray = (array)$itemstable;
            $array = json_decode(json_encode($itemarray), true);
            $itemtablename = [];
            foreach ($itemarray as $key => $value) {
                $itemtablename[] = $value;
            }
            $itemtable = $itemtablename[0];
            $selectedcategory = 0;
            $forexratestable = TableRegistry::get('Forexrates');

            $forexratearray = (array)$forexratestable;
            $array = json_decode(json_encode($forexratearray), true);
            $forexratetablename = [];
            foreach ($forexratearray as $key => $value) {
                $forexratetablename[] = $value;
            }
            $forexratetable = $forexratetablename[0];
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute('select id from fc_items');
            $rows = $stmt->fetchAll('assoc');
            if ($_POST['sortPrice'] == 'desc') {
                $sortBy = "desc";
                $sortText = 'Sort by: Price - High to Low';
                $orderby = 'order by (select (price/(select price from ' . $forexratetable . ' as f where f.id=i.currencyid))*' . $_SESSION['currency_value'] . ' as price) desc';
                $sorting = 'Items.price DESC';
            } elseif ($_POST['sortPrice'] == 'asc') {
                $sortBy = "asc";
                $sortText = 'Sort by: Price - Low to High';
                $orderby = 'order by (select (price/(select price from ' . $forexratetable . ' as f where f.id=i.currencyid))*' . $_SESSION['currency_value'] . ' as price) asc';
                $sorting = 'Items.price ASC';
            } else {
                $sortBy = "new";
                $orderby = "ORDER BY id DESC ";
                $sorting = 'Items.id DESC';
            }

            if ($_POST['catids'] && $_POST['catids'] != "" && $prevCat[0] != '0') {
                $catcondition = 'category_id=' . $prevCat[0];
                $selectedcategory = $prevCat[0];
                if ($prevCat[2] != '0') {
                    $catcondition .= ' and super_catid=' . $prevCat[2];
                    $selectedcategory = $prevCat[2];
                }
                if ($prevCat[4] != '0') {
                    $catcondition .= ' and sub_catid=' . $prevCat[4];
                    $selectedcategory = $prevCat[4];
                }
            } else {
                $catcondition = "";
            }

            if (isset($_POST['color']) && $_POST['color'] != "") {
                if ($catcondition == "")
                    $colorcondition = "item_color like '%" . $_POST['color'] . "%'";
                else
                    $colorcondition = "and item_color like '%" . $_POST['color'] . "%'";
            } else {
                $colorcondition = "";
            }

            if (isset($_POST['q']) && $_POST['q'] != "") {
                $searchKeyString = $_POST['q'];
                if ($colorcondition == "" && $catcondition == "")
                    $searchcondition = "item_title like '%" . $_POST['q'] . "%'";
                else
                    $searchcondition = "and item_title like '%" . $_POST['q'] . "%'";

            } else {
                $searchcondition = "";
            }


            if ($prevCat[0] != '0') {
                //echo 'test one'; die;
                if (isset($_POST['price']) && $_POST['price'] != "") {
                    $price = explode('-', $_POST['price']);
                    $price1 = $price[0];
                    $price2 = $price[1];
                    $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status="publish" and (select (price/(select price from ' . $forexratetable . ' as f where f.id=i.currencyid))*' . $_SESSION['currency_value'] . ' as price) between ' . $price1 . ' and ' . $price2 . ' and ' . $catcondition . ' ' . $colorcondition . ' ' . $searchcondition . ' ' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');
                    $rows = $item_datas->fetchAll('assoc');
                    foreach ($rows as $key => $value) {
                        $newarray[] = $value['id'];

                    }
                } else {
                    $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status="publish" and ' . $catcondition . ' ' . $colorcondition . ' ' . $searchcondition . ' ' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');


                    $rows = $item_datas->fetchAll('assoc');
                    foreach ($rows as $key => $value) {
                        $newarray[] = $value['id'];

                    }
                }

            } else {
                //echo 'test two'; die;
                if (isset($_POST['price']) && $_POST['price'] != "") {
                    $price = explode('-', $_POST['price']);
                    $price1 = $price[0];
                    $price2 = $price[1];
                    if ($catcondition == "" && $colorcondition != "")
                        $colorcondition = "and " . $colorcondition;
                    if ($catcondition == "" && $colorcondition == "" && $searchcondition != "")
                        $searchcondition = "and " . $searchcondition;
                    $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status="publish" and (select (price/(select price from ' . $forexratetable . ' as f where f.id=i.currencyid))*' . $_SESSION['currency_value'] . ' as price) between ' . $price1 . ' and ' . $price2 . ' ' . $catcondition . ' ' . $colorcondition . ' ' . $searchcondition . ' ' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');
                    $rows = $item_datas->fetchAll('assoc');
                    foreach ($rows as $key => $value) {
                        $newarray[] = $value['id'];

                    }
                } else {
                    if ($catcondition == "" && $colorcondition == "" && $searchcondition == "") {
                        $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status="publish" and' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');
                    } else {
                        $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status = "publish" and ' . $catcondition . ' ' . $colorcondition . ' ' . $searchcondition . ' ' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');
                    }
                    $rows = $item_datas->fetchAll('assoc');
                    foreach ($rows as $key => $value) {
                        $newarray[] = $value['id'];

                    }
                }
            }
            //echo $startIndex.' index '.$offset.'sdf';
            //echo '<pre>'; print_r($newarray); //die;
            $categoryId = '';
            if ($prevCat[0] == 0 && $category['1'] != 'browse') {
                $newCategory = $categoriestable->find()->where(['category_urlname' => $category['1']])->first();
                $prevCat[0] = $newCategory['id'];
            }
            if (($prevCat[2] == 0 && $prevCat[4] == 0) || ($prevCat[2] == "" && $prevCat[4] == "")) {
                $resultCategoryId = $categoriestable->find()->where(['id' => $prevCat[0]])->first();
            } else if ($prevCat[4] == 0 || $prevCat[4] == "") {
                $resultCategoryId = $categoriestable->find()->where(['id' => $prevCat[0]])
                    ->where(['category_parent' => $prevCat[2]])->first();
            } else if (($prevCat[2] != 0 && $prevCat[4] != 0) || ($prevCat[2] != "" && $prevCat[4] != "")) {
                $resultCategoryId = $categoriestable->find()->where(['id' => $prevCat[0]])
                    ->where(['category_sub_parent' => $prevCat[4]])->first();
            }
            $resultCategoryId = $resultCategoryId['id'];
            if ($categoryId == '') {
                $categoryId = $resultCategoryId;
            } else {
                $categoryId = $categoryId . "-" . $resultCategoryId;
            }
            if ($setngs['affiliate_enb'] == 'enable') {
                $conditions['Items.status !='] = 'draft';
            } else {
                $conditions['Items.status'] = 'publish';
            }
            if (!empty($newarray)) {
                //echo '<pre>'; print_r($newarray); die;
                foreach ($newarray as $key => $value) {
                    $item[] = $itemstable->find()->contain('Photos')->contain('Forexrates')->where([$conditions])->where(['Items.id' => $value,'Items.status' => 'publish'])->where(['Items.affiliate_commission IS NULL'])->all();
                }
            } else {
                $item = "";
            }


            $item_count = count($newarray);
            $categoryData = null;
            if ($category['1'] != 'browse') {
                $categoryData = $categoriestable->find()->where(['category_urlname' => $category[1]])->first();
            }
            $items_list_data = $itemliststable->find()->where(['user_id' => $userid])->where(['user_create_list' => '1'])->all();
            $prnt_cat_data = $categoriestable->find()->where(['category_parent' => 0])->where(['category_sub_parent' => 0])->all();
            $selectedcategories = $categoriestable->find()->select('category_name')->where(['id' => $selectedcategory])->first();




            $price_val = $this->Prices->find('all');
            $color_val = $this->Colors->find('all');
            $this->set('item_count', $item_count);
            $this->set('prnt_cat_data', $prnt_cat_data);
            $this->set('items_list_data', $items_list_data);
            $this->set('item', $item);
            $this->set('subCategory', $subCategory);
            $this->set('categoryData', $categoryData);
            $this->set('categoryId', $categoryId);
            $this->set('prev', $category);
            $this->set('resultCategory', $resultCategory);
            $this->set('price', $_POST['price']);
            $this->set('color', $_POST['color']);
            $this->set('sortPrice', $_POST['sortPrice']);
            $this->set('userid', $userid);
            $this->set('q', $_POST['q']);
            $this->set('color_val', $color_val);
            $this->set('price_val', $price_val);
            $this->set('loguser', $loguser);
            $this->set('setngs', $setngs);

            $this->set('categoryName', $selectedcategories->category_name);
            $this->set('refreshCatergory', $refreshCatergory);
            $this->set('searchKeyString', $searchKeyString);
            $this->set('sortBy', $sortBy);
            $this->set('sortText', $sortText);

            
        }










}
