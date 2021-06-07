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
namespace App\Controller\Shops;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Component\UrlfriendlyComponent;
use Cake\View\Helper\FlashHelper;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\Model\Table\LanguagesTable;
use Cake\Datasource\ConnectionManager;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ShopsController extends AppController
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

        public function showByCategory ($category=null, $subCat = null, $supercat = null ) {
            
          // echo "Eureka<pre>";print_r($_POST);
            global $loguser;
            $userid = $loguser['id'];
            if(isset($_POST)){
                $price=isset($_POST['price'])?$_POST['price']:"";
                if($price=='5000' || $price==5000){
                   
                    $price="";
                }
                
                $searchkey=isset($_POST['searchkey'])?$_POST['searchkey']:"";
            }

            $itemfavtable = TableRegistry::get('Itemfavs');
            $itemfavmodel = $itemfavtable->find('all')->where(['user_id'=>$userid])->all();
           // echo "category=".$category;die;
                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id'=>1])->first();
                $this->set('setngs',$setngs);
            if(count($itemfavmodel)>0){
                foreach($itemfavmodel as $itms){
                    $itmid[] = $itms->item_id;
                }
                $this->set('likeditemid',$itmid);
            }

            $itemstable = TableRegistry::get('Items');
            $itemliststable = TableRegistry::get('Itemlists');
            $colorstable = TableRegistry::get('Colors');
            $pricestable = TableRegistry::get('Prices');
            $bannerstable = TableRegistry::get('Banners');
            $categoriestable = TableRegistry::get('Categories');

            $mangagemodulestable = TableRegistry::get('Managemodules');
            $managemodules = $mangagemodulestable->find()->where(['id'=>1])->first();
            $displaybanner = $managemodules['display_banner'];
            $this->set('displaybanner',$displaybanner);
            $bannerstable = TableRegistry::get('Banners');
            $bannerdatas = $bannerstable->find()->where(['banner_type'=>'shop'])->where(['status'=>'Active'])->first();
            $this->set('bannerdatas',$bannerdatas);

            $this->loadModel('Itemlists');
            $this->loadModel('Items');
            $this->loadModel('Colors');
            $this->loadModel('Prices');
            $this->loadModel('Banners');
            $this->loadModel('Categories');
            $this->set('currentUrl',$category);

            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id'=>1])->first();


            $banner_datas = $bannerstable->find()->where(['banner_type'=>'shop'])->first();
            $this->set('banner_datas',$banner_datas);
            // new search query
             if($searchkey!=""){
              // echo"SE".$searchkey;
                  $conditions['Items.item_title LIKE'] = '%'.$searchkey.'%';
                    $this->set('searchkey',$searchkey);
            }
            if($price!="" && $price>0){
              //  echo "PE".$price;
                 $conditions['Items.price <='] = $price;
                  $this->set('search_price',$price);
            }
           
           //dd($item->sql());
        //  echo"<pre>"; print_r($item);die;
          //  echo "BEF<pre>";print_R($itemByCategory);

            if ($category == 'browse') {
                $subCategory = $categoriestable->find()->where(['category_parent'=>'0'])->all();

                if($setngs['affiliate_enb']=='enable'){
                    $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.affiliate_commission IS NULL'])
                    ->where(function ($exp, $q) {
                    return $exp->notEq('Items.Items.status','draft');
                        })->order(['Items.id DESC'])->limit('20')->all();
                }
                else {
                    $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.status'=>'publish'])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('20')->all();
                }
                $categoryData = null;
                $categoryId = 0;
                $this->set('currentIds',$categoryId.'-_-0-_-0');
            }else {
                //echo "cat".$category;
                $categoryData = $categoriestable->find()->where(['category_urlname'=>$category])->first();
                $categoryId = $categoryData['id'];
             //  echo"<pre>"; print_r($categoryData);die;
                if ($subCat == null) {
                    $this->set('currentIds',$categoryId.'-_-0-_-0');
                    $subCategory = $categoriestable->find()->where(['category_parent'=>$categoryId])
                    ->where(['category_sub_parent'=>'0'])->all();

                    if($setngs['affiliate_enb']=='enable'){
                            $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.affiliate_commission IS NULL'])->where(['category_id'=>$categoryId])
                            ->where(function ($exp, $q) {
                                return $exp->notEq('Items.status','draft');
                            })->order(['Items.id DESC'])->limit('20')->all();

                    }
                    else {
                        $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['category_id'=>$categoryId])
                        ->where(['Items.status'=>'publish'])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id DESC'])->limit('20')->all();
                    }
                  //  echo"<pre>"; print_r($itemByCategory);die;
                    $this->set('subCatName',null);
                }else {

                    //echo $supercat.'super cat'; die;

                    if($supercat == null){

                        $subCatBread = $categoriestable->find()->where(['category_urlname'=>$subCat])->first();
                        $this->set('currentIds',$categoryId.'-_-'.$subCatBread['id'].'-_-0');
                        
                        $categoryId = $categoryId."-".$subCatBread['id'];
                        
                        $subCatData = $categoriestable->find()->where(['category_urlname'=>$subCat])->first();
                        $subCatId = $subCatData['id'];
                        $subCategory = $this->Categories->find('all',array('conditions'=>array('category_parent'=>$categoryId,'category_sub_parent'=>$subCatId)));
                        if($setngs['affiliate_enb']=='enable'){
                            $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['category_id'=>$categoryId])
                            ->where(['super_catid'=>$subCatId])->where(['Items.affiliate_commission IS NULL'])
                            ->where(function ($exp, $q) {
                                return $exp->notEq('Items.status','draft');
                            })->order(['Items.id DESC'])->limit('20')->all();
                        }
                        else {
                            $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['category_id'=>$categoryId])
                            ->where(['super_catid'=>$subCatId])->where(['Items.affiliate_commission IS NULL'])
                            ->where(['Items.status'=>'publish'])->order(['Items.id DESC'])->limit('20')->all();
                        }
                    }else{
                        $subCatBread = $categoriestable->find()->where(['category_urlname'=>$supercat,'category_parent'=>$categoryId])->first();
                        //$categoryId = $categoryId."-".$subCatBread['id'];
                        $subCatData = $categoriestable->find()->where(['category_urlname'=>$supercat])->first();

                        $this->set('currentIds',$categoryId.'-_-'.$subCatBread['category_sub_parent'].'-_-'.$subCatBread['id'].'');

                        $subCatId = $subCatData['id'];
                        $subCategory = $this->Categories->find('all',array('conditions'=>array('category_parent'=>$categoryId,'category_sub_parent'=>$subCatId)));


                        if($setngs['affiliate_enb']=='enable'){
                            
                            $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.affiliate_commission IS NULL'])->where(['category_id'=>$categoryId])
                            ->where(['sub_catid'=>$subCatId])
                            ->where(function ($exp, $q) {
                                return $exp->notEq('Items.status','draft');
                            })->order(['Items.id DESC'])->limit('20')->all();
                        }
                        else {

                            $itemByCategory = $itemstable->find()->contain('Photos')->contain('Forexrates')->contain('Users')->contain('Shops')->where(['Items.affiliate_commission IS NULL'])->where(['category_id'=>$categoryId])
                            ->where(['sub_catid'=>$subCatBread->id])
                            ->where(['Items.status'=>'publish'])->order(['Items.id DESC'])->offset('0')->limit('20')->all();

                            //echo '<pre>'; print_r($itemByCategory); die;
                        }
                        $this->set('superCatName',$supercat);
                    }
                    

                    $this->set('subCatName',$subCat);
                }
            }
             if(isset($_POST) && $_POST!="" && count($_POST)>0){
                //echo "here";print_R($_POST);die;
                  $itemByCategory = $itemstable->find()->contain('Photos')->contain('Shops')->contain('Forexrates')->where([$conditions])->where(['Items.status' => 'publish'])->where(['Items.affiliate_commission IS NULL'])->order(['Items.id'=>'DESC'])->all();
                   $categoryData = null;
                $categoryId = 0;
                $this->set('currentIds',$categoryId.'-_-0-_-0');
            }
            $items_list_data = $this->Itemlists->find('all',array('conditions'=>array('user_id'=>$userid,'user_create_list'=>'1')));
            $prnt_cat_data = $this->Categories->find('all',array('conditions'=>array('category_parent'=>0,'category_sub_parent'=>0)));


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

            //$bannerBreadcrumb = 
            if($supercat != '')
            {
                $this->set('bannerBreadcrumb',$supercat);
            }elseif($subCat != ''){
                $this->set('bannerBreadcrumb',$subCat);
            }
//echo "AFT=<pre>";print_R($itemByCategory);die;
             $itemreviews = TableRegistry::get('Itemreviews');
              foreach ($itemByCategory as $key => $value) {
               // echo "id=".$value['id'];
            $itemreviewsmodel = $itemreviews->find('all')->where(['itemid' => $value['id']])->all();
            $reviewscount[]=count($itemreviewsmodel);

              }

              $this->set('reviewscount', $reviewscount);

            $price_val = $this->Prices->find('all');
            $color_val = $this->Colors->find('all');   
            $this->set('prnt_cat_data',$prnt_cat_data);
            $this->set('items_list_data',$items_list_data);
            $this->set('parent_categories',$parent_categories);
            $this->set('sub_categories',$sub_categories);
            $this->set('super_categories',$super_categories);
            $this->set('item',$itemByCategory);
            $this->set('subCategory',$subCategory);
            $this->set('categoryData',$categoryData);
            $this->set('categoryId',$categoryId);
            $this->set('userid',$userid);
            $this->set('color_val',$color_val);
            $this->set('price_val',$price_val);
            $this->set('setngs',$setngs);
            $this->set('categoryName',$categoryData['category_name']);
        }

        public function getItemByCategory()
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
            //echo "itemstable=".$itemtable;
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
               // echo 'test one'; die;
                if (isset($_POST['price']) && $_POST['price'] != "") {
                    $price = explode('-', $_POST['price']);
                    $price1 = $price[0];
                    $price2 = $price[1];
                    if($price2=='5000' || $price2==5000){
                   
                    $price2="";
                }
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
               // echo 'test two'; die;
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
                    //echo "here";
                    if ($catcondition == "" && $colorcondition == "" && $searchcondition == "") {
                        //echo "if".$orderby."===".$startIndex."===".$offset;
                        // $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status="publish" and' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');
                        // $query='select id from ' . $itemtable . ' as i where status="publish" and ' . $catcondition . ' ' . $colorcondition . ' ' . $searchcondition . ' ' . $orderby . ' limit ' . $startIndex . ',' . $offset . '';
                        //  echo 'query<pre>'; print_r($query); die;
                           $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status="publish"' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');
                      
                          
                    } else {
                        //echo "else";
                        $item_datas = $conn->execute('select id from ' . $itemtable . ' as i where status = "publish" and ' . $catcondition . ' ' . $colorcondition . ' ' . $searchcondition . ' ' . $orderby . ' limit ' . $startIndex . ',' . $offset . '');
                    }
                    
                    $rows = $item_datas->fetchAll('assoc');
                     //echo '<pre>'; print_r($rows);die; 
                    foreach ($rows as $key => $value) {
                        $newarray[] = $value['id'];

                    }
                }
            }
            //echo $startIndex.' index '.$offset.'sdf';
          //  echo '<pre>'; print_r($newarray); //die;
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
             // echo '<pre>'; print_r($newarray);
                // foreach ($newarray as $key => $value) {
                //    // echo "val=".$value;
                //     $item[] = $itemstable->find()->contain('Photos')->contain('Shops')->contain('Forexrates')->where([$conditions])->where(['Items.id' => $value,'Items.status' => 'publish'])->where(['Items.affiliate_commission IS NULL'])->all();
                // }
                 $item = $itemstable->find()->contain('Photos')->contain('Shops')->contain('Forexrates')->where([$conditions])->where(['Items.id IN' => $newarray])->where(['Items.status' => 'publish'])->where(['Items.affiliate_commission IS NULL'])->order($sorting)->all();
            } else {
                $item = "";
            }
           // echo 'before<pre>'; print_r($item); die;
            //$item= array_filter(array_map('array_filter', $item));
//             foreach($item as $k=>&$arr)
// {
//     array_filter($arr,'count');
// }
// echo"Res=<pre>";print_r($arr);
         // echo 'afterrr<pre>'; print_r($item); 
          if($item!="" && count($item)>0){
            //echo"not empty";
             $item_count = count($item); 
          }
          else{
             //echo"empty";
             $item_count = 0; 
          }
           
           //echo "itemcount=".$item_count;die;
            $categoryData = null;
            if ($category['1'] != 'browse') {
                $categoryData = $categoriestable->find()->where(['category_urlname' => $category[1]])->first();
            }
            $items_list_data = $itemliststable->find()->where(['user_id' => $userid])->where(['user_create_list' => '1'])->all();
            $prnt_cat_data = $categoriestable->find()->where(['category_parent' => 0])->where(['category_sub_parent' => 0])->all();
            $selectedcategories = $categoriestable->find()->select('category_name')->where(['id' => $selectedcategory])->first();

             $itemreviews = TableRegistry::get('Itemreviews');
              foreach ($item as $key => $value) {
               // echo "id=".$value['id'];
            $itemreviewsmodel = $itemreviews->find('all')->where(['itemid' => $value['id']])->all();
            $reviewscount[]=count($itemreviewsmodel);

              }

               $this->set('reviewscount', $reviewscount);
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
