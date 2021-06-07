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
use Cake\Controller\Component\FlashComponent;
use Cake\View\Helper\FlashHelper;
use Cake\I18n\I18n;

class PaypalsController extends AppController {

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
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Captcha', ['field' => 'securitycode']);
        $this->loadComponent('Flash');
    }

    public function captcha() {
        $this->autoRender = false;
        $this->viewBuilder()->layout('ajax');
        $this->Captcha->create();
    }

    public function isAuthorized($user) {
        return true;
    }

    /** ADD TO CART * */
    public function paycart() {
        global $loguser;
        $this->autoLayout = false;
        $this->autoRender = false;
        $userid = $loguser['id'];
        $cartstable = TableRegistry::get('Carts');
        $productstable = TableRegistry::get('Items');
        //POSTED VALUES
        $listingid = $this->request->data['listing_id'];
        $quantity = $this->request->data['quantity'];
        $size_opt = $this->request->data['size_opt'];
        $itemUserId = $this->request->data['itemuserid'];
        $shipping_method_id = $this->request->data['shipping_method_id'];
        $_SESSION['shpngid'] = $shipping_method_id;

        if (!empty($listingid) && $itemUserId != $userid) {
            if ($size_opt != "") {
                $itemExist = $cartstable->find('all')->where(['item_id' => $listingid])->where(['user_id' => $userid])->where(['payment_status' => 'progress'])->where(['size_options' => $size_opt])->count();
            } else {
                $itemExist = $cartstable->find('all')->where(['item_id' => $listingid])->where(['user_id' => $userid])->where(['payment_status' => 'progress'])->count();
            }

            if ($itemExist == 0) {
                $cartdatas = $cartstable->newEntity();
                $cartdatas->item_id = $listingid;
                $cartdatas->user_id = $userid;
                $cartdatas->quantity = $quantity;
                $cartdatas->size_options = $size_opt;
                $cartdatas->created_at = date("Y-m-d H:i:s");
                $result = $cartstable->save($cartdatas);
            } else {
                $query = $cartstable->query();
                if ($size_opt != "") {
                    $query->update()->set(['quantity' => $quantity])
                    ->where(['item_id' => $listingid])
                    ->where(['user_id' => $userid])
                    ->where(['size_options' => $size_opt])->execute();
                } else {
                    $query->update()->set(['quantity' => $quantity])
                    ->where(['item_id' => $listingid])
                    ->where(['user_id' => $userid])->execute();
                }
            }
            // echo "totalcount=";die;
            //CHECK ITEM STATUS
            $totalcount = $productstable->find('all')->where(['id' => $listingid])->where(['status' => 'publish'])->count();

            if ($totalcount < 0) {
                $this->Flash->error(__d('user', 'Unfortunately Item is not Available now.'));
                $this->redirect('/');
            } else {
                $this->Flash->success(__d('user', 'Item added to cart successfully.'));
                echo $totalcount;
            }
        } elseif ($itemUserId == $userid) {
            echo '0';
        } else {
            echo '0';
        }
    }

    /** CART VIEW PAGE * */
    public function pay() {
        global $loguser;
        $userid = $loguser['id'];
        $this->set('title_for_layout', 'Cart Items');
        //check account disabled or not
        $user_status_val = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->where(['user_status' => 'disable'])->count();
        if ($user_status_val > 0) {
            $this->Flash->error(__d('user', 'Your account has been disabled please contact our support.'));
            $this->redirect($this->Auth->logout());
            $this->redirect('/login');
        }
        /* OPEN CART */
        $shopid = array();
        $carts = $this->Carts->find('all', array('conditions' => array('user_id' => $userid, 'payment_status' => 'progress')))->order(['id DESC'])->all();

        //echo '<pre>'; print_r($carts); die;
        $totalitem_count = 0;
        $items_price = 0;
        if (count($carts) > 0) {
            foreach ($carts as $key => $crt) {
                $item_datas_count = TableRegistry::get('Items')->find()->where(['Items.id' => $crt['item_id']])->where(['Items.status' => 'publish'])
                ->count();
                if ($item_datas_count > 0) {
                    //ITEMS DETAILS
                    $item_datas = TableRegistry::get('Items')->find()->where(['Items.id' => $crt['item_id']])->where(['Items.status' => 'publish'])
                    ->first();
                    $item_photos = TableRegistry::get('Photos')->find()->where(['item_id' => $crt['item_id']])->first();
                    //SELLER DETAILS
                    $item_sellers = TableRegistry::get('Users')->find()->where(['id' => $item_datas['user_id']])->first();
                    //CURRENCY DETAILS
                    $item_currencies = TableRegistry::get('Forexrates')->find()->where(['id' => $item_datas['currencyid']])->first();
                    //SHOP DETAILS
                    $item_shops = TableRegistry::get('Shops')->find()->where(['id' => $item_datas['shop_id']])->first();
                    //SHIPPING DETAILS
                    $item_shipings = TableRegistry::get('Shipings')->find()->where(['item_id' => $crt['item_id']])->toArray();
                    $opencart[$key]['cartid'] = $crt['id'];
                    $opencart[$key]['itemid'] = $item_datas['id'];
                    $opencart[$key]['category_id'] = $item_datas['category_id'];
                    $opencart[$key]['item_title_url'] = $item_datas['item_title_url'];
                    $opencart[$key]['name'] = $item_datas['item_title'];
                    $opencart[$key]['qty'] = $crt['quantity'];
                    $opencart[$key]['maxqty'] = $item_datas['quantity'];
                    $opencart[$key]['size'] = $crt['size_options'];
                    $opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');
                    $opencart[$key]['image'] = $item_photos['image_name'];
                    $opencart[$key]['sellername'] = $item_sellers['username'];
                    $opencart[$key]['shopid'] = $item_datas['shop_id'];
                    $opencart[$key]['userid'] = $item_datas['user_id'];
                    $opencart[$key]['shop_name'] = $item_shops['shop_name_url'];
                    $opencart[$key]['sellerid'] = $item_datas['user_id'];
                    $opencart[$key]['processtime'] = $item_datas['processing_time'];
                    $opencart[$key]['currencysymbol'] = $item_currencies['currency_symbol'];
                    $opencart[$key]['foxexprice'] = $item_currencies['price'];
                    $opencart[$key]['pricefree'] = $item_shops['pricefree'];
                    $opencart[$key]['postalfree'] = $item_shops['postalfree'];
                    $opencart[$key]['freeamt'] = $item_shops['freeamt'];
                    $opencart[$key]['postalcodes'] = json_decode($item_shops['postalcodes'], true);
                    $opencart[$key]['shippingavailability'] = $item_shipings;
                    $opencart[$key]['cod'] = $item_datas['cod'];
                    if ($opencart[$key]['currencysymbol'] == "") {
                        $opencart[$key]['currencysymbol'] = $_SESSION['default_currency_symbol'];
                    }

                    /* CHECKMULTIPLE CURRENCY */
                    $itms_currency[] = $item_currencies['currency_code'];
                    $itms_currencysymbol[] = $item_currencies['currency_symbol'];
                    $itms_rate[] = $item_currencies['price'];

                    if ($opencart[$key]['size'] != "") {
                        $product_store = json_decode($item_datas['size_options'], true);
                        $product_price = $product_store['price'][$opencart[$key]['size']];
                        $product_total_qty = $product_store['unit'][$opencart[$key]['size']];
                        if ($product_price != "") {
                            $opencart[$key]['price'] = number_format((float) $product_price, 2, '.', '');
                        }
                        if ($product_total_qty != "" && $product_total_qty != '0') {
                            $opencart[$key]['maxqty'] = $product_total_qty;
                        } else {
                            $opencart[$key]['maxqty'] = 0;
                        }
                    }

                    /** CHECK PRODUCT DETAILS CHANGED AFTER ADDED TO CART * */
                    $opencart[$key]['newvariants'] = '';
                    if ($opencart[$key]['size'] != "" && $item_datas['size_options'] == "") {
                        $opencart[$key]['newvariants'] = '1';
                    }

                    if ($opencart[$key]['size'] == "" && $item_datas['size_options'] != "") {
                        $opencart[$key]['newvariants'] = '1';
                    }

                    $opencart[$key]['priceas'] = number_format((float) $opencart[$key]['price'], 2, '.', '');

                    /* TOTAL AMOUNT BY SELLER & USER */
                    $items_price = $opencart[$key]['price'] * $opencart[$key]['qty'];
                    $useritemprice=$this->Currency->conversion($opencart[$key]['foxexprice'], $_SESSION['currency_value'], $items_price);
                    $selleramount[$opencart[$key]['sellerid']] += $useritemprice;
                    $shopamount[$opencart[$key]['shopid']] += $useritemprice;


                    $dailydealstatus = $item_datas['dailydeal'];
                    
                    $date = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $tdy = strtotime($month . '/' . $date . '/' . $year);
                    //$dealdate = $item_datas->dealdate->format('Y-m-d');

                    if($item_datas['discount_type'] == 'daily' && isset($item_datas->dealdate) && $item_datas->dealdate != '' )
                    {
                        $dealdate = $item_datas->dealdate->format('Y-m-d');
                        $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }else{
                        $dealstrtime = '';
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }
                    if (($item_datas['discount_type'] == 'daily' && $todaystrtime == $dealstrtime) || $item_datas['discount_type'] == 'regular' ) {
                        $dailydealdiscount = $item_datas['discount'];
                        $unitPriceConvert = number_format((float) $opencart[$key]['price'], 2, '.', '');
                        $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
                        if ($daily_price != "") {
                            $opencart[$key]['price'] = number_format((float) $daily_price, 2, '.', '');
                            $opencart[$key]['dailydeals'] = 'YES';
                            $opencart[$key]['discount'] = $dailydealdiscount;
                        }
                    }

                    $total_count++;
                }
            }

            //echo '<pre>'; print_r($opencart); die;
            $total_itms = $total_count;
            $itmscurrency = count(array_unique($itms_currency));
            $itmscurrencysymbol = count(array_unique($itms_currencysymbol));
        }
        /* USER SHIPPING ADDRESS */
        $shippid = $_SESSION['last_ship_id'];
        $usershipping = TableRegistry::get('Tempaddresses')->find()->where(['userid' => $userid])->toArray();
        $usershippingdefaults = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
        $usershippingdefaultval = $usershippingdefaults['defaultshipping'];
        if (empty($shippid))
            $usershippingdefault = $usershippingdefaults['defaultshipping'];
        else
            $usershippingdefault = $shippid;
        $available_bal = $usershippingdefaults['credit_total'];
        foreach ($usershipping as $ship) {
            if ($ship['shippingid'] == $usershippingdefault) {
                $_SESSION['shpngid'] = $ship['countrycode'];
                $userpostcode = $ship['zipcode'];
            }
        }

        /** TAXES **/
        $tax_datas = TableRegistry::get('Taxes')->find('all')->where(['countryid' => $_SESSION['shpngid']])->where(['status' => 'enable'])->toArray();

        /** COMMISSION * */
        $commissionDetails = TableRegistry::get('Commissions')->find('all');

        /** COMMISSION COUNT * */
        $commissionCount = TableRegistry::get('Commissions')->find()->count();

        /** SITE SETTINGS * */
        $sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();

        $this->set('tax_datas', $tax_datas);
        $this->set('commissionDetails', $commissionDetails);
        $this->set('commissionCount', $commissionCount);
        $this->set('itmscurrency', $itmscurrency);
        $this->set('itmscurrencysymbol', $itmscurrencysymbol);
        $this->set('itms_currencysymbol', $itms_currencysymbol);
        $this->set('itms_currency', $itms_currency);
        $this->set('itms_rate', $itms_rate);
        $this->set('selleramount', $selleramount);
        $this->set('shopamount', $shopamount);
        $this->set('shipping_method_id', $_SESSION['shpngid']);
        unset($_SESSION['last_ship_id']);
        $this->set(compact('opencart', 'total_itms', 'userid', 'userpostcode', 'usershipping', 'usershippingdefault', 'available_bal', 'sitesettings'));
    }

    /** BUYNOW PRODUCT * */
    public function paycod() {
        unset($_SESSION['buynow_size']);
        unset($_SESSION['buynow_qty']);
        unset($_SESSION['buynow_product']);
        $this->layout = FALSE;
        $this->autoRender = false;
        $item_id = $_POST['itm_id'];
        $item_qty = $_POST['itm_qty'];
        $item_size = $_POST['itm_size'];
        $_SESSION['buynow_size'] = $item_size;
        $_SESSION['buynow_qty'] = $item_qty;
        $_SESSION['buynow_product'] = $item_id;
        if ($item_size == '' || $item_size == null) {
            $item_size = '';
        }
        echo $item_id;
        die;
    }

    /** COD VIEW PAGE * */
    public function cod($item_id) {
        if (isset($_SESSION['buynow_product']) && isset($_SESSION['buynow_qty'])) {

            global $loguser;
            $userid = $loguser['id'];
            $item_qty = $_SESSION['buynow_qty'];
            $item_size = $_SESSION['buynow_size'];
            $this->set('title_for_layout', 'Cart Items');
            //check account disabled or not
            $user_status_val = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->where(['user_status' => 'disable'])->count();
            if ($user_status_val > 0) {
                $this->Flash->error(__d('user', 'Your account has been disabled please contact our support.'));
                $this->redirect($this->Auth->logout());
                $this->redirect('/login');
            }

            /* BUYNOW */
            $buynow = $this->Items->find('all', array('conditions' => array('id' => $item_id, 'status' => 'publish')))->order(['id DESC'])->all();
            $shopid = array();
            $totalitem_count = 0;
            $items_price = 0;
            if (count($buynow) > 0) {
                foreach ($buynow as $key => $crt) {
                    $item_datas_count = TableRegistry::get('Items')->find()->where(['Items.id' => $item_id])->where(['Items.status' => 'publish'])
                    ->count();
                    if ($item_datas_count > 0) {
                        //ITEMS DETAILS
                        $item_datas = TableRegistry::get('Items')->find()->where(['Items.id' => $item_id])->where(['Items.status' => 'publish'])
                        ->first();
                        $item_photos = TableRegistry::get('Photos')->find()->where(['item_id' => $item_id])->first();
                        //SELLER DETAILS
                        $item_sellers = TableRegistry::get('Users')->find()->where(['id' => $item_datas['user_id']])->first();
                        //CURRENCY DETAILS
                        $item_currencies = TableRegistry::get('Forexrates')->find()->where(['id' => $item_datas['currencyid']])->first();
                        //SHOP DETAILS
                        $item_shops = TableRegistry::get('Shops')->find()->where(['id' => $item_datas['shop_id']])->first();
                        //SHIPPING DETAILS
                        $item_shipings = TableRegistry::get('Shipings')->find()->where(['item_id' => $item_id])->toArray();
                        $opencart[$key]['cartid'] = $item_id;
                        $opencart[$key]['itemid'] = $item_datas['id'];
                        $opencart[$key]['category_id'] = $item_datas['category_id'];
                        $opencart[$key]['item_title_url'] = $item_datas['item_title_url'];
                        $opencart[$key]['name'] = $item_datas['item_title'];
                        $opencart[$key]['qty'] = $item_qty;
                        $opencart[$key]['maxqty'] = $item_datas['quantity'];
                        $opencart[$key]['size'] = $item_size;

                        /*
                        if(($item_datas['discount_type'] == 'daily' && strtotime(date('Y-m-d')) == strtotime($item_datas['dealdate'])) || $item_datas['discount_type'] == 'regular')
                        {
                            $dailydealdiscount = $item_datas['discount'];
                            $unitPriceConvert = number_format((float)$item_datas['price'], 2, '.', '');
                            $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
                            if ($daily_price != "") {
                                $price = number_format((float)$daily_price, 2, '.', '');
                            }
                            $dealPercentage = $dailydealdiscount;
                            $opencart[$key]['price'] = number_format((float) $price, 2, '.', '');
                        }else{
                            $opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');
                            $dealPercentage = 0; 
                        }
                        */

                        $opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');


                        $opencart[$key]['image'] = $item_photos['image_name'];
                        $opencart[$key]['sellername'] = $item_sellers['username'];
                        $opencart[$key]['shopid'] = $item_datas['shop_id'];
                        $opencart[$key]['userid'] = $item_datas['user_id'];
                        $opencart[$key]['shop_name'] = $item_shops['shop_name_url'];
                        $opencart[$key]['sellerid'] = $item_datas['user_id'];
                        $opencart[$key]['processtime'] = $item_datas['processing_time'];
                        $opencart[$key]['currencysymbol'] = $item_currencies['currency_symbol'];
                        $opencart[$key]['foxexprice'] = $item_currencies['price'];
                        $opencart[$key]['pricefree'] = $item_shops['pricefree'];
                        $opencart[$key]['postalfree'] = $item_shops['postalfree'];
                        $opencart[$key]['freeamt'] = $item_shops['freeamt'];
                        $opencart[$key]['postalcodes'] = json_decode($item_shops['postalcodes'], true);
                        $opencart[$key]['shippingavailability'] = $item_shipings;
                        $opencart[$key]['cod'] = $item_datas['cod'];
                        if ($opencart[$key]['currencysymbol'] == "") {
                            $opencart[$key]['currencysymbol'] = $_SESSION['default_currency_symbol'];
                        }

                        /* CHECKMULTIPLE CURRENCY */
                        $itms_currency[] = $item_currencies['currency_code'];
                        $itms_currencysymbol[] = $item_currencies['currency_symbol'];
                        $itms_rate[] = $item_currencies['price'];

                        if ($opencart[$key]['size'] != "") {
                            $product_store = json_decode($item_datas['size_options'], true);
                            $product_price = $product_store['price'][$opencart[$key]['size']];
                            $product_total_qty = $product_store['unit'][$opencart[$key]['size']];
                            if ($product_price != "") {
                                $opencart[$key]['price'] = number_format((float) $product_price, 2, '.', '');
                            }
                            if ($product_total_qty != "" && $product_total_qty != '0') {
                                $opencart[$key]['maxqty'] = $product_total_qty;
                            } else {
                                $opencart[$key]['maxqty'] = '0';
                            }
                        }


                        /** CHECK PRODUCT DETAILS CHANGED AFTER ADDED TO CART * */
                        $opencart[$key]['newvariants'] = '';
                        if ($opencart[$key]['size'] != "" && $item_datas['size_options'] == "") {
                            $opencart[$key]['newvariants'] = '1';
                        }

                        if ($opencart[$key]['size'] == "" && $item_datas['size_options'] != "") {
                            $opencart[$key]['newvariants'] = '1';
                        }

                        $opencart[$key]['priceas'] = number_format((float) $opencart[$key]['price'], 2, '.', '');

                        /* TOTAL AMOUNT BY SELLER & USER */
                        $items_price = $opencart[$key]['price'] * $opencart[$key]['qty'];
                        $useritemprice=$this->Currency->conversion($opencart[$key]['foxexprice'], $_SESSION['currency_value'], $items_price);
                        $selleramount[$opencart[$key]['sellerid']] += $useritemprice;
                        $shopamount[$opencart[$key]['shopid']] += $useritemprice;


                        $dailydealstatus = $item_datas['dailydeal'];
                        
                        $date = date('d');
                        $month = date('m');
                        $year = date('Y');
                        $tdy = strtotime($month . '/' . $date . '/' . $year);
                        if(isset($item_datas->dealdate) && $item_datas->dealdate != '' )
                        {
                            $dealdate = $item_datas->dealdate->format('Y-m-d');
                            $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                            $todaystrtime = strtotime(date('Y-m-d',$tdy));
                        }else{
                            $dealstrtime = '';
                            $todaystrtime = strtotime(date('Y-m-d',$tdy));
                        }


                       if (($item_datas['discount_type'] == 'daily' && $dealstrtime == $todaystrtime) || $item_datas['discount_type'] == 'regular' ) {
                            $dailydealdiscount = $item_datas['discount'];
                            $unitPriceConvert = number_format((float) $opencart[$key]['price'], 2, '.', '');
                            $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
                            if ($daily_price != "") {
                                $opencart[$key]['price'] = number_format((float) $daily_price, 2, '.', '');
                                $opencart[$key]['dailydeals'] = 'YES';
                                $opencart[$key]['discount'] = $dailydealdiscount;
                            }
                        }

                        $total_count++;
                    }
                }

                //echo '<pre>'; print_r($opencart); die;
                $total_itms = $total_count;
                $itmscurrency = count(array_unique($itms_currency));
                $itmscurrencysymbol = count(array_unique($itms_currencysymbol));
            }

            /* USER SHIPPING ADDRESS */
            $shippid = $_SESSION['last_ship_id'];
            $usershipping = TableRegistry::get('Tempaddresses')->find()->where(['userid' => $userid])->toArray();
            $usershippingdefaults = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
            $usershippingdefaultval = $usershippingdefaults['defaultshipping'];
            if (empty($shippid))
                $usershippingdefault = $usershippingdefaults['defaultshipping'];
            else
                $usershippingdefault = $shippid;
            $available_bal = $usershippingdefaults['credit_total'];
            foreach ($usershipping as $ship) {
                if ($ship['shippingid'] == $usershippingdefault) {
                    $_SESSION['shpngid'] = $ship['countrycode'];
                    $userpostcode = $ship['zipcode'];
                }
            }

            /** TAXES * */
            $tax_datas = TableRegistry::get('Taxes')->find('all')->where(['countryid' => $_SESSION['shpngid']])->where(['status' => 'enable'])->toArray();

            /** COMMISSION * */
            $commissionDetails = TableRegistry::get('Commissions')->find('all');

            /** COMMISSION COUNT * */
            $commissionCount = TableRegistry::get('Commissions')->find()->count();

            /** SITE SETTINGS * */
            $sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();

            $this->set('tax_datas', $tax_datas);
            $this->set('commissionDetails', $commissionDetails);
            $this->set('commissionCount', $commissionCount);
            $this->set('itmscurrency', $itmscurrency);
            $this->set('itmscurrencysymbol', $itmscurrencysymbol);
            $this->set('itms_currencysymbol', $itms_currencysymbol);
            $this->set('itms_currency', $itms_currency);
            $this->set('itms_rate', $itms_rate);
            $this->set('selleramount', $selleramount);
            $this->set('shopamount', $shopamount);
            $this->set('shipping_method_id', $_SESSION['shpngid']);
            unset($_SESSION['last_ship_id']);
            $this->set(compact('opencart', 'total_itms', 'userid', 'userpostcode', 'usershipping', 'usershippingdefault', 'available_bal', 'sitesettings'));
        } else {
            $this->Flash->error(__d('user', 'Item removed'));
            $this->redirect('/cart');
        }
    }

    /** CHECK COUPONS VALIDITY * */
    public function checksellercouponcode($id = NULL) {
        $code = $_GET['coupon_value'];
        $userId = $_POST['userid'];
        $shopId = $_POST['shopid'];
        $itemshopId = $_POST['itemuserid'];
        $itemId = $_POST['itemid'];
        $itemids = json_decode($itemId, true);
        foreach($itemids as $itemidss)
        {
           
            $item_datas[] = TableRegistry::get('Items')->find()->where(['Items.id' => $itemidss])->first();
        }
    
       
        foreach ($item_datas as $items) {
            $catids[] = $items->category_id;
            $itemuserids[] = $items->user_id;
        }
        $getcouponval = TableRegistry::get('Sellercoupons')->find()->where(['couponcode' => $code])->first();
        if (!empty($getcouponval)) {
            $last_date = $getcouponval->validto;
            $range = $getcouponval->remainrange;
            $couponid = $getcouponval->id;
            $discount_amount = $getcouponval->couponpercentage;
            $sellerid = $getcouponval->sellerid;
            $sourceid = $getcouponval->sourceid;
            $type = $getcouponval->type;
            $today_date = time();
            $ldate = $last_date . " 24:00:00";
            $today_date = (is_string($today_date) ? strtotime($today_date) : $today_date);
            $last_date = (is_string($ldate) ? strtotime($ldate) : $ldate);
            if ($last_date > $today_date && $range >= 1) {
                if ($type == "item" || $type == "facebook") {
                    if (in_array($sourceid, $itemids)) {
                        echo "2 $couponid";
                        die;
                    } else {
                        echo "3";
                        die;
                    }
                } else if ($type == "category") {
                    if (in_array($sellerid, $itemuserids)) {
                        if (in_array($sourceid, $catids)) {
                            echo "4 $couponid";
                            die;
                        } else {
                            echo "5";
                            die;
                        }
                    } else {
                        echo "5";
                        die;
                    }
                } else if ($type == "cart") {
                    echo "6 $couponid";
                    die;
                }
            } else {
                echo "1";
                die;
            }
        } else {
            echo '0';
            die;
        }
    }

    /* REMOVE AN ITEM IN CART */

    public function deletecartitem() {
        $userId = $_POST['userId'];
        $itemId = $_POST['itemId'];
        $shopId = $_POST['shopId'];
        $size = $_POST['size'];
        if (isset($_POST['qnty'])) {
            $qnty = $_POST['qnty'];
        } else {
            $qnty = 0;
        }
        $cartId = TableRegistry::get('Carts');
        // DELETE & UPDATE ITEM & QUANTITY IN CART
        $query = $cartId->query();
        if ($qnty == 0) {
            $query->delete()
            ->where(['user_id' => $userId])
            ->where(['payment_status' => 'progress'])
            ->where(['id' => $itemId])
            ->execute();
        } else {
            $query->update()
            ->set(['quantity' => $qnty])
            ->where(['user_id' => $userId])
            ->where(['id' => $itemId])
            ->execute();
        }

        $itemCount = TableRegistry::get('Carts')->find('all')->where(['user_id' => $userId])->where(['payment_status' => 'progress'])->count();
        if ($itemCount == 0) {
            $this->Flash->success('Your Shopping Cart is Empty');
            echo '0';
            die;
        } else {
            return $this->updatecart();
        }
    }

    public function deletecartcod() {
        unset($_SESSION['buynow_size']);
        unset($_SESSION['buynow_qty']);
        unset($_SESSION['buynow_product']);
        $this->Flash->error(__d('user', 'Item removed successfully'));
        $this->redirect('/cart');
    }

    public function removeupdatecart() {
        global $loguser;
        $userid = $loguser['id'];
        $this->set('title_for_layout', 'Cart Items');
        if (isset($_POST['coupon_id']) && $_POST['coupon_id'] != "") {
            $couponId = $_POST['coupon_id'];
        }

        if (isset($_POST['shippingid']) && $_POST['shippingid'] != "") {
            $_SESSION['last_ship_id'] = $_POST['shippingid'];
        }

        //check account disabled or not
        $user_status_val = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->where(['user_status' => 'disable'])->count();
        if ($user_status_val > 0) {
            $this->Flash->error(__d('user', 'Your account has been disabled please contact our support.'));
            $this->redirect($this->Auth->logout());
            $this->redirect('/login');
        }
        /* OPEN CART */
        $shopid = array();
        $carts = $this->Carts->find('all', array('conditions' => array('user_id' => $userid, 'payment_status' => 'progress')))->order(['id DESC'])->all();
        $totalitem_count = 0;
        $items_price = 0;
        if (count($carts) > 0) {
            foreach ($carts as $key => $crt) {
                $item_datas_count = TableRegistry::get('Items')->find()->where(['Items.id' => $crt['item_id']])->where(['Items.status' => 'publish'])
                ->count();
                if ($item_datas_count > 0) {
                    //ITEMS DETAILS
                    $item_datas = TableRegistry::get('Items')->find()->where(['Items.id' => $crt['item_id']])->where(['Items.status' => 'publish'])
                    ->first();
                    $item_photos = TableRegistry::get('Photos')->find()->where(['item_id' => $crt['item_id']])->first();
                    //SELLER DETAILS
                    $item_sellers = TableRegistry::get('Users')->find()->where(['id' => $item_datas['user_id']])->first();
                    //CURRENCY DETAILS
                    $item_currencies = TableRegistry::get('Forexrates')->find()->where(['id' => $item_datas['currencyid']])->first();
                    //SHOP DETAILS
                    $item_shops = TableRegistry::get('Shops')->find()->where(['id' => $item_datas['shop_id']])->first();
                    // SHIPPING DETAILS
                    $item_shipings = TableRegistry::get('Shipings')->find()->where(['item_id' => $crt['item_id']])->toArray();
                    $opencart[$key]['cartid'] = $crt['id'];
                    $opencart[$key]['itemid'] = $item_datas['id'];
                    $opencart[$key]['item_title_url'] = $item_datas['item_title_url'];
                    $opencart[$key]['name'] = $item_datas['item_title'];
                    $opencart[$key]['qty'] = $crt['quantity'];
                    $opencart[$key]['maxqty'] = $item_datas['quantity'];
                    $opencart[$key]['size'] = $crt['size_options'];
                    $opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');
                    $opencart[$key]['image'] = $item_photos['image_name'];
                    $opencart[$key]['sellername'] = $item_sellers['username'];
                    $opencart[$key]['shopid'] = $item_datas['shop_id'];
                    $opencart[$key]['shop_name'] = $item_shops['shop_name_url'];
                    $opencart[$key]['sellerid'] = $item_datas['user_id'];
                    $opencart[$key]['processtime'] = $item_datas['processing_time'];
                    $opencart[$key]['currencysymbol'] = $item_currencies['currency_symbol'];
                    $opencart[$key]['foxexprice'] = $item_currencies['price'];
                    $opencart[$key]['pricefree'] = $item_shops['pricefree'];
                    $opencart[$key]['postalfree'] = $item_shops['postalfree'];
                    $opencart[$key]['freeamt'] = $item_shops['freeamt'];
                    $opencart[$key]['postalcodes'] = json_decode($item_shops['postalcodes'], true);
                    $opencart[$key]['shippingavailability'] = $item_shipings;
                    $opencart[$key]['cod'] = $item_datas['cod'];
                    if ($opencart[$key]['currencysymbol'] == "") {
                        $opencart[$key]['currencysymbol'] = $_SESSION['default_currency_symbol'];
                    }

                    /* CHECKMULTIPLE CURRENCY */
                    $itms_currency[] = $item_currencies['currency_code'];
                    $itms_currencysymbol[] = $item_currencies['currency_symbol'];
                    $itms_rate[] = $item_currencies['price'];

                    if ($opencart[$key]['size'] != "") {
                        $product_store = json_decode($item_datas['size_options'], true);
                        $product_price = $product_store['price'][$opencart[$key]['size']];
                        $product_total_qty = $product_store['unit'][$opencart[$key]['size']];
                        if ($product_price != "") {
                            $opencart[$key]['price'] = number_format((float) $product_price, 2, '.', '');
                        }
                        if ($product_total_qty != "" && $product_total_qty != '0') {
                            $opencart[$key]['maxqty'] = $product_total_qty;
                        } else {
                            $opencart[$key]['maxqty'] = '0';
                        }
                    }

                    $opencart[$key]['priceas'] = number_format((float) $opencart[$key]['price'], 2, '.', '');

                    /* TOTAL AMOUNT BY SELLER & USER */
                    $items_price = $opencart[$key]['price'] * $opencart[$key]['qty'];
                    $selleramount[$opencart[$key]['sellerid']] += $items_price;
                    $shopamount[$opencart[$key]['shopid']] += $items_price;

                    $dailydealstatus = $item_datas['dailydeal'];
                    $dailydealdate = date('m/d/Y', strtotime($item_datas['dealdate']));
                    $today = date('m/d/Y');
                    if (($item_datas['discount_type'] == 'daily' && $dailydealdate == $today) || $item_datas['discount_type'] == 'regular' ) {
                        $dailydealdiscount = $item_datas['discount'];
                        $unitPriceConvert = number_format((float) $opencart[$key]['price'], 2, '.', '');
                        $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
                        if ($daily_price != "") {
                            $opencart[$key]['price'] = number_format((float) $daily_price, 2, '.', '');
                            $opencart[$key]['dailydeals'] = 'YES';
                            $opencart[$key]['discount'] = $dailydealdiscount;
                        }
                    }
                    $total_count++;
                }
            }
            $total_itms = $total_count;
            $itmscurrency = count(array_unique($itms_currency));
            $itmscurrencysymbol = count(array_unique($itms_currencysymbol));
        }

        /* USER SHIPPING ADDRESS */
        $shippid = $_SESSION['last_ship_id'];
        $usershipping = TableRegistry::get('Tempaddresses')->find()->where(['userid' => $userid])->toArray();
        $usershippingdefaults = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
        $usershippingdefaultval = $usershippingdefaults['defaultshipping'];
        if (empty($shippid))
            $usershippingdefault = $usershippingdefaults['defaultshipping'];
        else
            $usershippingdefault = $shippid;
        $available_bal = $usershippingdefaults['credit_total'];
        foreach ($usershipping as $ship) {
            if ($ship['shippingid'] == $usershippingdefault) {
                $_SESSION['shpngid'] = $ship['countrycode'];
                $userpostcode = $ship['zipcode'];
            }
        }

        /** TAXES * */
        $tax_datas = TableRegistry::get('Taxes')->find('all')->where(['countryid' => $getcountrycode])->where(['status' => 'enable'])->toArray();

        /* COUPONS */
        if (isset($couponId) && $couponId != 0) {
            $getcouponvalue = TableRegistry::get('Sellercoupons')->find()->where(['id' => $couponId])->first();
            $this->set('getcouponvalue', $getcouponvalue);
        }

        /** COMMISSION * */
        $commiDetails = TableRegistry::get('Commissions')->find('all')->where(['active' => '1']);
        $this->set('tax_datas', $tax_datas);
        $this->set('commiDetails', $commiDetails);
        $this->set('itmscurrency', $itmscurrency);
        $this->set('itmscurrencysymbol', $itmscurrencysymbol);
        $this->set('itms_currencysymbol', $itms_currencysymbol);
        $this->set('itms_currency', $itms_currency);
        $this->set('itms_rate', $itms_rate);
        $this->set('selleramount', $selleramount);
        $this->set('shopamount', $shopamount);
        $this->set(compact('opencart', 'total_itms', 'userid', 'userpostcode', 'usershipping', 'usershippingdefault', 'available_bal'));
    }

    public function updatecart() {
        global $loguser;
        $userid = $loguser['id'];
        $this->set('title_for_layout', 'Cart Items');
        $setcoupon = 0;
        $setgiftcard = 0;
        $setcreditamount = 0;
        $codavailability = 0; 
        if (isset($_POST['shippingid']) && $_POST['shippingid'] != "") {
            $shippid = $_POST['shippingid'];
        }

        if (isset($_POST['coupon_id']) && $_POST['coupon_id'] != "") {
            $couponId = $_POST['coupon_id'];
            $setcoupon++;
        }

        if (isset($_POST['giftcard_id']) && $_POST['giftcard_id'] != "" && $setcoupon == 0) {
            $giftcardId = $_POST['giftcard_id'];
            $setgiftcard++;
            $codavailability++;
        }

        if (isset($_POST['creditamt']) && $_POST['creditamt'] != "" && $setcoupon == 0 && $setgiftcard == 0) {
            $creditamt = $_POST['creditamt'];
            $setcreditamount++;
            $codavailability++;
            $this->set('creditamt', $creditamt);
        }
        $this->set('setcoupon', $setcoupon);
        $this->set('setgiftcard', $setgiftcard);
        $this->set('setcreditamount', $setcreditamount);
        //check account disabled or not
        $user_status_val = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->where(['user_status' => 'disable'])->count();
        if ($user_status_val > 0) {
            $this->Flash->error(__d('user', 'Your account has been disabled please contact our support.'));
            $this->redirect($this->Auth->logout());
            $this->redirect('/login');
        }

        /* OPEN CART */
        $shopid = array();
        $carts = $this->Carts->find('all', array('conditions' => array('user_id' => $userid, 'payment_status' => 'progress')))->order(['id DESC'])->all();
        $totalitem_count = 0;
        $items_price = 0;
        if (count($carts) > 0) {
            foreach ($carts as $key => $crt) {
                $item_datas_count = TableRegistry::get('Items')->find()->where(['Items.id' => $crt['item_id']])->where(['Items.status' => 'publish'])
                ->count();
                if ($item_datas_count > 0) {
                    //ITEMS DETAILS
                    $item_datas = TableRegistry::get('Items')->find()->where(['Items.id' => $crt['item_id']])->where(['Items.status' => 'publish'])
                    ->first();
                    $item_photos = TableRegistry::get('Photos')->find()->where(['item_id' => $crt['item_id']])->first();
                    //SELLER DETAILS
                    $item_sellers = TableRegistry::get('Users')->find()->where(['id' => $item_datas['user_id']])->first();
                    //CURRENCY DETAILS
                    $item_currencies = TableRegistry::get('Forexrates')->find()->where(['id' => $item_datas['currencyid']])->first();
                    //SHOP DETAILS
                    $item_shops = TableRegistry::get('Shops')->find()->where(['id' => $item_datas['shop_id']])->first();
                    // SHIPPING DETAILS
                    $item_shipings = TableRegistry::get('Shipings')->find()->where(['item_id' => $crt['item_id']])->toArray();
                    $opencart[$key]['cartid'] = $crt['id'];
                    $opencart[$key]['itemid'] = $item_datas['id'];
                    $opencart[$key]['category_id'] = $item_datas['category_id'];
                    $opencart[$key]['item_title_url'] = $item_datas['item_title_url'];
                    $opencart[$key]['name'] = $item_datas['item_title'];
                    $opencart[$key]['qty'] = $crt['quantity'];
                    $opencart[$key]['maxqty'] = $item_datas['quantity'];
                    $opencart[$key]['size'] = $crt['size_options'];
                    $opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');
                    $opencart[$key]['image'] = $item_photos['image_name'];
                    $opencart[$key]['sellername'] = $item_sellers['username'];
                    $opencart[$key]['shopid'] = $item_datas['shop_id'];
                    $opencart[$key]['userid'] = $item_datas['user_id'];
                    $opencart[$key]['shop_name'] = $item_shops['shop_name_url'];
                    $opencart[$key]['sellerid'] = $item_datas['user_id'];
                    $opencart[$key]['processtime'] = $item_datas['processing_time'];
                    $opencart[$key]['currencysymbol'] = $item_currencies['currency_symbol'];
                    $opencart[$key]['foxexprice'] = $item_currencies['price'];
                    $opencart[$key]['pricefree'] = $item_shops['pricefree'];
                    $opencart[$key]['postalfree'] = $item_shops['postalfree'];
                    $opencart[$key]['freeamt'] = $item_shops['freeamt'];
                    $opencart[$key]['postalcodes'] = json_decode($item_shops['postalcodes'], true);
                    $opencart[$key]['shippingavailability'] = $item_shipings;
                    $opencart[$key]['cod'] = $item_datas['cod'];
                    if ($opencart[$key]['currencysymbol'] == "") {
                        $opencart[$key]['currencysymbol'] = $_SESSION['default_currency_symbol'];
                    }

                    /* CHECKMULTIPLE CURRENCY */
                    $itms_currency[] = $item_currencies['currency_code'];
                    $itms_currencysymbol[] = $item_currencies['currency_symbol'];
                    $itms_rate[] = $item_currencies['price'];

                    if ($opencart[$key]['size'] != "") {
                        $product_store = json_decode($item_datas['size_options'], true);
                        $product_price = $product_store['price'][$opencart[$key]['size']];
                        $product_total_qty = $product_store['unit'][$opencart[$key]['size']];
                        if ($product_price != "") {
                            $opencart[$key]['price'] = number_format((float) $product_price, 2, '.', '');
                        }
                        if ($product_total_qty != "" && $product_total_qty != '0') {
                            $opencart[$key]['maxqty'] = $product_total_qty;
                        } else {
                            $opencart[$key]['maxqty'] = '0';
                        }
                    }

                    /** CHECK PRODUCT DETAILS CHANGED AFTER ADDED TO CART * */
                    $opencart[$key]['newvariants'] = '';
                    if ($opencart[$key]['size'] != "" && $item_datas['size_options'] == "") {
                        $opencart[$key]['newvariants'] = '1';
                    }
                    if ($opencart[$key]['size'] == "" && $item_datas['size_options'] != "") {
                        $opencart[$key]['newvariants'] = '1';
                    }

                    $opencart[$key]['priceas'] = number_format((float) $opencart[$key]['price'], 2, '.', '');

                    /* TOTAL AMOUNT BY SELLER & USER */
                    $items_price = $opencart[$key]['price'] * $opencart[$key]['qty'];
                    $useritemprice=$this->Currency->conversion($opencart[$key]['foxexprice'], $_SESSION['currency_value'], $items_price);
                    $selleramount[$opencart[$key]['sellerid']] += $useritemprice;
                    $shopamount[$opencart[$key]['shopid']] += $useritemprice;

                    $dailydealstatus = $item_datas['dailydeal'];
                    //$dailydealdate = date('m/d/Y', strtotime($item_datas['dealdate']));
                    //$today = date('m/d/Y');
                    $date = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $tdy = strtotime($month . '/' . $date . '/' . $year);
                    if(isset($item_datas->dealdate) && $item_datas->dealdate != '' )
                    {
                        $dealdate = $item_datas->dealdate->format('Y-m-d');
                        $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }else{
                        $dealstrtime = '';
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }
                    if (($item_datas['discount_type'] == 'daily' && $todaystrtime == $dealstrtime) || $item_datas['discount_type'] == 'regular' ) {
                        $dailydealdiscount = $item_datas['discount'];
                        $unitPriceConvert = number_format((float) $opencart[$key]['price'], 2, '.', '');
                        $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
                        if ($daily_price != "") {
                            $opencart[$key]['price'] = number_format((float) $daily_price, 2, '.', '');
                            $opencart[$key]['dailydeals'] = 'YES';
                            $opencart[$key]['discount'] = $dailydealdiscount;
                        }
                    }
                    $total_count++;
                }
            }
            $total_itms = $total_count;
            $itmscurrency = count(array_unique($itms_currency));
            $itmscurrencysymbol = count(array_unique($itms_currencysymbol));
        }

        /* USER SHIPPING ADDRESS */
        $usershippingdefault = $shippid;
        $usershipping = TableRegistry::get('Tempaddresses')->find()->where(['userid' => $userid])->toArray();
        $usershippingdefaults = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
        $usershippingdefaultval = $usershippingdefaults['defaultshipping'];

        $available_bal = $usershippingdefaults['credit_total'];
        foreach ($usershipping as $ship) {
            if ($ship['shippingid'] == $usershippingdefault) {
                $_SESSION['shpngid'] = $ship['countrycode'];
                $userpostcode = $ship['zipcode'];
            }
        }

        /** TAXES * */
        $tax_datas = TableRegistry::get('Taxes')->find('all')->where(['countryid' => $_SESSION['shpngid']])->where(['status' => 'enable'])->toArray();

        /* COUPONS */
        if ($setcoupon > 0) {
            $getcouponvalue = TableRegistry::get('Sellercoupons')->find()->where(['id' => $couponId])->first();
            $this->set('getcouponvalue', $getcouponvalue);
        }
        if (isset($_POST['giftcard_id']) && $_POST['giftcard_id'] != "" && $setcoupon == 0 && $creditamt == 0) {
            $getgiftcardValue = TableRegistry::get('Giftcards')->find()->where(['id' => $giftcardId])->first();
            $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getgiftcardValue->currencyid])->first();
            $giftcardrate = $forexrateModel['price'];
            $this->set('giftcardrate', $giftcardrate);
            $this->set('getgiftcardValue', $getgiftcardValue);
        }

        /** COMMISSION * */
        $commissionDetails = TableRegistry::get('Commissions')->find('all');

        /** COMMISSION COUNT * */
        $commissionCount = TableRegistry::get('Commissions')->find()->count();

        $this->set('tax_datas', $tax_datas);
        $this->set('commissionDetails', $commissionDetails);
        $this->set('commissionCount', $commissionCount);
        $this->set('itmscurrency', $itmscurrency);
        $this->set('itmscurrencysymbol', $itmscurrencysymbol);
        $this->set('itms_currencysymbol', $itms_currencysymbol);
        $this->set('itms_currency', $itms_currency);
        $this->set('itms_rate', $itms_rate);
        $this->set('selleramount', $selleramount);
        $this->set('shopamount', $shopamount);
        $this->set('shipping_method_id', $_SESSION['shpngid']);
        $this->set('codavailability', $codavailability);
        $this->set(compact('opencart', 'total_itms', 'userid', 'userpostcode', 'usershipping', 'usershippingdefault', 'available_bal'));
        $this->render('deletecartitem');
    }

    public function updatecartcod() {
        global $loguser;
        $userid = $loguser['id'];
        $this->set('title_for_layout', 'Cart Items');
        $setcoupon = 0;
        $setgiftcard = 0;
        $setcreditamount = 0;
        $codavailability = 0; 
        if (isset($_POST['shippingid']) && $_POST['shippingid'] != "") {
            $shippid = $_POST['shippingid'];
        }

        if (isset($_POST['coupon_id']) && $_POST['coupon_id'] != "") {
            $couponId = $_POST['coupon_id'];
            $setcoupon++;
        }

        if (isset($_POST['giftcard_id']) && $_POST['giftcard_id'] != "" && $setcoupon == 0) {
            $giftcardId = $_POST['giftcard_id'];
            $setgiftcard++;
            $codavailability++; 
        }

        if (isset($_POST['creditamt']) && $_POST['creditamt'] != "" && $setcoupon == 0 && $setgiftcard == 0) {
            $creditamt = $_POST['creditamt'];
            $setcreditamount++;
            $codavailability++; 
            $this->set('creditamt', $creditamt);
        }
        $this->set('setcoupon', $setcoupon);
        $this->set('setgiftcard', $setgiftcard);
        $this->set('setcreditamount', $setcreditamount);

        //check account disabled or not
        $user_status_val = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->where(['user_status' => 'disable'])->count();
        if ($user_status_val > 0) {
            $this->Flash->error(__d('user', 'Your account has been disabled please contact our support.'));
            $this->redirect($this->Auth->logout());
            $this->redirect('/login');
        }

        $item_qty = $_POST['qnty'];
        $item_size = $_SESSION['buynow_size'];
        $item_id = $_SESSION['buynow_product'];
        /* BUYNOW */
        $shopid = array();

        $buynow = $this->Items->find('all', array('conditions' => array('id' => $item_id, 'status' => 'publish')))->order(['id DESC'])->all();
        $totalitem_count = 0;
        $items_price = 0;
        if (count($buynow) > 0) {
            foreach ($buynow as $key => $crt) {
                $item_datas_count = TableRegistry::get('Items')->find()->where(['Items.id' => $item_id])->where(['Items.status' => 'publish'])
                ->count();
                if ($item_datas_count > 0) {
                    //ITEMS DETAILS
                    $item_datas = TableRegistry::get('Items')->find()->where(['Items.id' => $item_id])->where(['Items.status' => 'publish'])
                    ->first();
                    $item_photos = TableRegistry::get('Photos')->find()->where(['item_id' => $item_id])->first();
                    //SELLER DETAILS
                    $item_sellers = TableRegistry::get('Users')->find()->where(['id' => $item_datas['user_id']])->first();
                    //CURRENCY DETAILS
                    $item_currencies = TableRegistry::get('Forexrates')->find()->where(['id' => $item_datas['currencyid']])->first();
                    //SHOP DETAILS
                    $item_shops = TableRegistry::get('Shops')->find()->where(['id' => $item_datas['shop_id']])->first();
                    // SHIPPING DETAILS
                    $item_shipings = TableRegistry::get('Shipings')->find()->where(['item_id' => $item_id])->toArray();
                    $opencart[$key]['cartid'] = $item_id;
                    $opencart[$key]['itemid'] = $item_datas['id'];
                    $opencart[$key]['category_id'] = $item_datas['category_id'];
                    $opencart[$key]['item_title_url'] = $item_datas['item_title_url'];
                    $opencart[$key]['name'] = $item_datas['item_title'];
                    $opencart[$key]['qty'] = $item_qty;
                    $opencart[$key]['maxqty'] = $item_datas['quantity'];
                    $opencart[$key]['size'] = $item_size;

                    
                    /*
                    if(($item_datas['discount_type'] == 'daily' && $dealstrtime == $todaystrtime) || $item_datas['discount_type'] == 'regular')
                        {
                            $dailydealdiscount = $item_datas['discount'];
                            $unitPriceConvert = number_format((float)$item_datas['price'], 2, '.', '');
                            $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
                            if ($daily_price != "") {
                                $price = number_format((float)$daily_price, 2, '.', '');
                            }
                            $dealPercentage = $dailydealdiscount;
                            $opencart[$key]['price'] = number_format((float) $price, 2, '.', '');
                        }else{
                            $opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');
                            $dealPercentage = 0; 
                        }
                        */

                    $opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');

                    //$opencart[$key]['price'] = number_format((float) $item_datas['price'], 2, '.', '');
                    $opencart[$key]['image'] = $item_photos['image_name'];
                    $opencart[$key]['sellername'] = $item_sellers['username'];
                    $opencart[$key]['shopid'] = $item_datas['shop_id'];
                    $opencart[$key]['userid'] = $item_datas['user_id'];
                    $opencart[$key]['shop_name'] = $item_shops['shop_name_url'];
                    $opencart[$key]['sellerid'] = $item_datas['user_id'];
                    $opencart[$key]['processtime'] = $item_datas['processing_time'];
                    $opencart[$key]['currencysymbol'] = $item_currencies['currency_symbol'];
                    $opencart[$key]['foxexprice'] = $item_currencies['price'];
                    $opencart[$key]['pricefree'] = $item_shops['pricefree'];
                    $opencart[$key]['postalfree'] = $item_shops['postalfree'];
                    $opencart[$key]['freeamt'] = $item_shops['freeamt'];
                    $opencart[$key]['postalcodes'] = json_decode($item_shops['postalcodes'], true);
                    $opencart[$key]['shippingavailability'] = $item_shipings;
                    $opencart[$key]['cod'] = $item_datas['cod'];
                    if ($opencart[$key]['currencysymbol'] == "") {
                        $opencart[$key]['currencysymbol'] = $_SESSION['default_currency_symbol'];
                    }

                    /* CHECKMULTIPLE CURRENCY */
                    $itms_currency[] = $item_currencies['currency_code'];
                    $itms_currencysymbol[] = $item_currencies['currency_symbol'];
                    $itms_rate[] = $item_currencies['price'];

                    if ($opencart[$key]['size'] != "") {
                        $product_store = json_decode($item_datas['size_options'], true);
                        $product_price = $product_store['price'][$opencart[$key]['size']];
                        $product_total_qty = $product_store['unit'][$opencart[$key]['size']];
                        if ($product_price != "") {
                            $opencart[$key]['price'] = number_format((float) $product_price, 2, '.', '');
                        }
                        if ($product_total_qty != "" && $product_total_qty != '0') {
                            $opencart[$key]['maxqty'] = $product_total_qty;
                        } else {
                            $opencart[$key]['maxqty'] = '0';
                        }
                    }

                    /** CHECK PRODUCT DETAILS CHANGED AFTER ADDED TO CART * */
                    $opencart[$key]['newvariants'] = '';
                    if ($opencart[$key]['size'] != "" && $item_datas['size_options'] == "") {
                        $opencart[$key]['newvariants'] = '1';
                    }
                    if ($opencart[$key]['size'] == "" && $item_datas['size_options'] != "") {
                        $opencart[$key]['newvariants'] = '1';
                    }

                    $opencart[$key]['priceas'] = number_format((float) $opencart[$key]['price'], 2, '.', '');

                    /* TOTAL AMOUNT BY SELLER & USER */
                    $items_price = $opencart[$key]['price'] * $opencart[$key]['qty'];
                    $useritemprice=$this->Currency->conversion($opencart[$key]['foxexprice'], $_SESSION['currency_value'], $items_price);
                    $selleramount[$opencart[$key]['sellerid']] += $useritemprice;
                    $shopamount[$opencart[$key]['shopid']] += $useritemprice;

                    $dailydealstatus = $item_datas['dailydeal'];
                    $date = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $tdy = strtotime($month . '/' . $date . '/' . $year);
                    if(isset($item_datas->dealdate) && $item_datas->dealdate != '' )
                    {
                        $dealdate = $item_datas->dealdate->format('Y-m-d');
                        $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }else{
                        $dealstrtime = '';
                        $todaystrtime = strtotime(date('Y-m-d',$tdy));
                    }

                    if (($item_datas['discount_type'] == 'daily' && $dealstrtime == $todaystrtime) || $item_datas['discount_type'] == 'regular' ) {
                        $dailydealdiscount = $item_datas['discount'];
                        $unitPriceConvert = number_format((float) $opencart[$key]['price'], 2, '.', '');
                        $daily_price = $unitPriceConvert * (1 - $dailydealdiscount / 100);
                        if ($daily_price != "") {
                            $opencart[$key]['price'] = number_format((float) $daily_price, 2, '.', '');
                            $opencart[$key]['dailydeals'] = 'YES';
                            $opencart[$key]['discount'] = $dailydealdiscount;
                        }
                    }
                    $total_count++;
                }
            }
            $total_itms = $total_count;
            $itmscurrency = count(array_unique($itms_currency));
            $itmscurrencysymbol = count(array_unique($itms_currencysymbol));
        }

        /* USER SHIPPING ADDRESS */
        $usershippingdefault = $shippid;
        $usershipping = TableRegistry::get('Tempaddresses')->find()->where(['userid' => $userid])->toArray();
        $usershippingdefaults = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
        $usershippingdefaultval = $usershippingdefaults['defaultshipping'];
        $available_bal = $usershippingdefaults['credit_total'];
        foreach ($usershipping as $ship) {
            if ($ship['shippingid'] == $usershippingdefault) {
                $_SESSION['shpngid'] = $ship['countrycode'];
                $userpostcode = $ship['zipcode'];
            }
        }

        /** TAXES * */
        $tax_datas = TableRegistry::get('Taxes')->find('all')->where(['countryid' => $_SESSION['shpngid']])->where(['status' => 'enable'])->toArray();

        /* COUPONS */
        if ($setcoupon > 0) {
            $getcouponvalue = TableRegistry::get('Sellercoupons')->find()->where(['id' => $couponId])->first();
            $this->set('getcouponvalue', $getcouponvalue);
        }


        /* GIFTCARDS */
        if (isset($_POST['giftcard_id']) && $_POST['giftcard_id'] != "" && $setcoupon == 0 && $creditamt == 0) {
            $getgiftcardValue = TableRegistry::get('Giftcards')->find()->where(['id' => $giftcardId])->first();
            $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getgiftcardValue->currencyid])->first();
            $giftcardrate = $forexrateModel['price'];
            $this->set('giftcardrate', $giftcardrate);
            $this->set('getgiftcardValue', $getgiftcardValue);
        }

        /** COMMISSION * */
        $commissionDetails = TableRegistry::get('Commissions')->find('all');

        /** COMMISSION COUNT * */
        $commissionCount = TableRegistry::get('Commissions')->find()->count();

        $this->set('tax_datas', $tax_datas);
        $this->set('commissionDetails', $commissionDetails);
        $this->set('commissionCount', $commissionCount);
        $this->set('itmscurrency', $itmscurrency);
        $this->set('itmscurrencysymbol', $itmscurrencysymbol);
        $this->set('itms_currencysymbol', $itms_currencysymbol);
        $this->set('itms_currency', $itms_currency);
        $this->set('itms_rate', $itms_rate);
        $this->set('selleramount', $selleramount);
        $this->set('shopamount', $shopamount);
        $this->set('codavailability', $codavailability);
        $this->set('shipping_method_id', $_SESSION['shpngid']);
        $this->set(compact('opencart', 'total_itms', 'userid', 'userpostcode', 'usershipping', 'usershippingdefault', 'available_bal'));
        $this->render('deletecartcod');
    }

    /** CHECK GROUP GIFT CARD VALIDITY * */
    public function checkgiftcardcode() {
        global $loguser;
        $curr_email = $loguser['email'];
        $code = $_GET['gfcode_value'];
        $getgfcardval = TableRegistry::get('Giftcards')->find()->where(['giftcard_key' => $code])->first();
        if (!empty($getgfcardval)) {
            $recEmail = $getgfcardval->reciptent_email;
            $gfcardId = $getgfcardval->id;
            $gfcardAmt = $getgfcardval->avail_amount;
            if ($gfcardAmt <= 0) {
                echo "2";
                die;
            } else if ($recEmail == $curr_email) {
                echo '1' . '*|*' . $gfcardId;
                die;
            } else {
                echo '0';
                die;
            }
        } else {
            echo '0';
            die;
        }
    }

    /* BRAINTREE PAYMENT */

    public function braintreecheckouttoken() {
        include_once( WWW_ROOT . 'braintree/lib/Braintree.php' );
        $this->layout = FALSE;
        $this->autoRender = false;
        global $loguser;
        $userid = $loguser['id'];

        //echo '<pre>'; print_r($_POST); die;
        // Braintree Settings
        $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $braintreesettings = json_decode($Sitesettings['merchantid_setting'], true);
        $merchantidsettings = json_decode($Sitesettings['braintree_setting'], true);
        
        foreach ($merchantidsettings as $key => $value) {
          if($key == $_POST['currency'])
          {
              
            $merchantAccountId = $value['merchant_account_id'];
            
        }
    }
    $params = array(
        "testmode" =>   $braintreesettings['type'],
        "merchantid" => $braintreesettings['merchant_id'],
        "publickey" =>  $braintreesettings['public_key'],
        "privatekey" => $braintreesettings['private_key'],
    );

    if ($params['testmode'] == "sandbox") {
        \Braintree_Configuration::environment('sandbox');
    } else {
        \Braintree_Configuration::environment('production');
    }
    \Braintree_Configuration::merchantId($params["merchantid"]);
    \Braintree_Configuration::publicKey($params["publickey"]);
    \Braintree_Configuration::privateKey($params["privatekey"]);

    $user_detls = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
    



    if (empty($user_detls['customer_id'])) {
        $clientToken = \Braintree\ClientToken::generate([
         
            "merchantAccountId" => $merchantAccountId 
        ]);
    } else {
        $clientToken = \Braintree_ClientToken::generate([
            "customerId" => $user_detls['customer_id'],
            "merchantAccountId" => $merchantAccountId 
        ]);
    }



        //@braintree
    $shippingId = $_POST['shippingId'];
    $itemids = $_POST['itemids'];
    $shipamnt = $_POST['shipamnt'];
    $itmunitprice = $_POST['itmunitPrice'];
    $taxamt = $_POST['taxamt'];
    $couponId = $_POST['couponId'];
    $giftcardId = $_POST['giftcardId'];
    $totalprice = $_POST['totalPrice'];
    $currency = $currencyCode = $_POST['currency'];
    $totalsprice = $_POST['totalsPrice'];
    $userEnterCreditAmt = $_POST['userEnterCreditAmt'];
    $currentTime = $_POST['currentTime'];
    $delivertype = $_POST['delivertype'];
    $totalamount = $_POST['totalamount'];
    $buynow = 0;
    $buynow_qty = $_POST['buynow_qty'];
    $buynow_size = $_POST['buynow_size'];
    if (isset($_POST['buynow']) && $_POST['buynow'] == '1') {
        $buynow = 1;
    }
    $prices = $totalprice / 100;
    if ($clientToken && $clientToken != "") {
        $this->set('clienttoken', $clientToken);
        $this->set(compact('shippingId', 'itemids', 'shipamnt', 'itmunitprice', 'taxamt', 'couponId', 'giftcardId', 'totalsprice', 'totalprice', 'prices', 'userEnterCreditAmt', 'currentTime', 'delivertype', 'currency', 'userid', 'buynow_qty', 'buynow_size', 'buynow','totalamount'));
        $this->render('braintree_cart');
    } else {
        $this->redirect('/payment-cancelled/');
    }
}

    //BRAINTREE PAYMENT FAILURE CASE
public function paymentcancel($status = NULL) {
    $this->set('title_for_layout', 'Payment Cancel');
    global $loguser;
    $this->layout = FALSE;
    $this->autoRender = false;
    $userid = $loguser['id'];
    if (isset($status) && !empty($status)) {
        $userDetails = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
        $shareData = json_decode($userDetails->share_status, true);
        $shareNewData = array();
        foreach ($shareData as $shareKey => $shareVal) {

            if (!array_key_exists($status, $shareVal)) {
                $shareNewData[] = $shareVal;
            }
        }
        $this->request->data['id'] = $userid;
        $this->request->data['share_status'] = json_encode($shareNewData);
        $querys = TableRegistry::get('Users')->query();
        $querys->update()
        ->set(['share_status' => json_encode($shareNewData)])
        ->where(['id' => $userid])
        ->execute();
    }
    $this->Flash->error(__d('user', "Payment didn't go through Please try again"));
    $this->redirect('/');
}

    //GIFTCARD CHECKOUT
public function checkoutgiftcard() {
    $this->autoLayout = false;
    $this->autoRender = false;
    global $loguser;
    $userid = $loguser['id'];
    $giftcardchkid = 11;
    $giftcartDetail = TableRegistry::get('Giftcards')->find('all')->where(['id' => $giftcardchkid])->first();
    $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
    $amount = $giftcartDetail->amount;
    $giftcardId = $giftcartDetail->id;
    $reciptent_name = $giftcartDetail->reciptent_name;
    $useremail = $giftcartDetail->reciptent_email;
    $this->set('useremail', $useremail);
    $this->set('reciptent_name', $reciptent_name);
    $this->set('giftcardId', $giftcardId);
    $this->set('amount', $amount);
    $this->set('setngs', $Sitesettings);
    $this->render('giftcardcheckout');
}

    //GIFTCARD IPN
function giftcardipnIpn() {
    $this->autoLayout = false;
    $this->autoRender = false;
    global $loguser;
    $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
    $postFields = 'cmd=_notify-validate';
    if ($Sitesettings->payment_type == 'sandbox') {
        $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    } elseif ($Sitesettings->payment_type == 'paypal') {
        $url = 'https://www.paypal.com/cgi-bin/webscr';
    }
    foreach ($_POST as $key => $value) {
        $postFields .= "&$key=" . urlencode(stripslashes($value));
        $keyarray[urldecode($key)] = urldecode($value);
    }

    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields
    ));

    $result = curl_exec($ch);
    curl_close($ch);

    $custom = '11';
    $giftdet = TableRegistry::get('Giftcards')->find('all')->where(['id' => $custom])->first();
        //Giftcard values
    $current_user_id = $giftdet->user_id;
    $userModl = TableRegistry::get('Users')->find('all')->where(['id' => $current_user_id])->first();
    $current_user_email = $userModl->email;
    $giftcardId = $giftdet->user_id;
    $gfName = $giftdet->user_id;
    $gcEmail = $giftdet->reciptent_email;
    $gcmessage = $giftdet->message;
    $gcamount = $giftdet->amount;
    $gcstatus = $giftdet->status;
    $uniquecode = $this->Urlfriendly->get_uniquecode(8);

        //Update giftcard status
    $users = TableRegistry::get('Giftcards');
    $user = $users->get($custom);
    $user->status = 'Paid';
    $user->giftcard_key = $uniquecode;
    $users->save($user);
       
      }

    //PAYMENT SUCCESS CASE
      function payment_success($status = NULL) {
        global $loguser;
        $userid = $loguser['id'];
        $this->set('title_for_layout', 'Payment Successfull');
        if (isset($status) && !empty($status)) {
            $userDetails = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
            $shareData = json_decode($userDetails->share_status, true);
            foreach ($shareData as $shareKey => $shareVal) {
                if (array_key_exists($status, $shareVal)) {
                    $this->set('status', $status);
                    $this->set('amount', $shareVal['amount']);
                }
            }
        }
    }

    //GROUP GIFT CHECKOUT
    function checkoutgroupgift() {
        $this->autoLayout = false;
        $this->autoRender = false;
        global $loguser;
        $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $userid = $loguser['id'];
        $itemIds = $_POST['itemId'];
        $ggid = $_POST['ggid'];
        $UserEntrAmt = $_POST['UserEntrAmt'];
        if (!(empty($itemIds))) {
            $item_datas = TableRegistry::get('Items')->find()->where(['Items.id IN' => $itemIds])->all();
        }
        $Groupgiftuserdetail_datas = TableRegistry::get('Groupgiftuserdetails')->find()->where(['id' => $ggid])->all();
        //Set datas
        $this->set('item_datas', $item_datas);
        $this->set('UserEntrAmt', $UserEntrAmt);
        $this->set('Ggdatas', $Groupgiftuserdetail_datas);
        $this->set('UserId', $userid);
        $this->set('setngs', $Sitesettings);
    }

    //GROUP GIFT BRAINTREE
    function braintreecheckouttokengroupgift() {
        include_once( WWW_ROOT . 'braintree/lib/Braintree.php' );
        $this->layout = FALSE;
        $this->autoRender = false;
        global $loguser;
        $userid = $loguser['id'];
        // Braintree Settings
        $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $merchantidsettings = json_decode($Sitesettings['merchantid_setting'], true);
        $braintreesettings = json_decode($Sitesettings['braintree_setting'], true);
        foreach ($braintreesettings as $key => $value) {
          if($key == $_POST['currency'])
          {
            
            $merchant_account_id = $value['merchant_account_id'];
            
        }
    }
    $params = array(
        "testmode" => $merchantidsettings['type'],
        "merchantid" => $merchantidsettings['merchant_id'],
        "publickey" =>  $merchantidsettings['public_key'],
        "privatekey" => $merchantidsettings['private_key'],
    );

    if ($params['testmode'] == "sandbox") {
        \Braintree_Configuration::environment('sandbox');
    } else {
        \Braintree_Configuration::environment('production');
    }
    \Braintree_Configuration::merchantId($params["merchantid"]);
    \Braintree_Configuration::publicKey($params["publickey"]);
    \Braintree_Configuration::privateKey($params["privatekey"]);

    $user_detls = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
    if (empty($user_detls['customer_id'])) {
        $clientToken = \Braintree\ClientToken::generate([
            "merchantAccountId" => $merchant_account_id
        ]);
    } else {
        $clientToken = \Braintree_ClientToken::generate([
            "customerId" => $user_detls['customer_id'],
            "merchantAccountId" => $merchant_account_id
        ]);
    }
        //POSTED VALUES
    $itemIds = $_POST['itemid'];
    $ggId = $_POST['ggid'];
    $amount = $_POST['giftamount'];
    $currency = $_POST['currency'];
        //CHECK CLIENT TOKEN
    if ($clientToken && $clientToken != "") {
        $this->set('clienttoken', $clientToken);
        $this->set('itemIds', $itemIds);
        $this->set('ggId', $ggId);
        $this->set('amount', $amount);
        $this->set('currency', $currency);
        $this->set('prices', $amount);
        $this->render('braintree_cartgroupgift');
    } else {
        $this->redirect('/payment-cancelled/');
    }
}

/* GROUP GIFT BRAINTREE */

function braintreegroupgift() {
    include_once( WWW_ROOT . 'braintree/lib/Braintree.php' );
    $this->autoLayout = false;
    $this->autoRender = false;
    global $loguser;
    $currentUserId = $loguser['id'];
        //POSTED VALUES
    $itemIds = $_POST['itemid'];
    $ggId = $_POST['ggid'];
    $amount = $_POST['giftamount'];
    $currency = $_POST['currency'];
    $totalprice = $amount;

        // Braintree Settings
    $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
    $braintreesettings = json_decode($Sitesettings['braintree_setting'], true);
    $merchantidsettings = json_decode($Sitesettings['merchantid_setting'], true);
    foreach ($braintreesettings as $key => $value) {
      if($key == $_POST['currency'])
      {
         
        $merchant_account_id = $value['merchant_account_id'];
        
    }
}
$params = array(
    "testmode" =>   $merchantidsettings['type'],
    "merchantid" => $merchantidsettings['merchant_id'],
    "publickey" =>  $merchantidsettings['public_key'],
    "privatekey" => $merchantidsettings['private_key'],
);

if ($params['testmode'] == "sandbox") {
    \Braintree_Configuration::environment('sandbox');
} else {
    \Braintree_Configuration::environment('production');
}
\Braintree_Configuration::merchantId($params["merchantid"]);
\Braintree_Configuration::publicKey($params["publickey"]);
\Braintree_Configuration::privateKey($params["privatekey"]);

$prices = $_POST['prices'];
$nonce = $_POST["payment_method_nonce"];

$user_detls = TableRegistry::get('Users')->find('all')->where(['id' => $currentUserId])->first();
if (empty($user_detls['customer_id'])) {
    $result1 = \Braintree_Customer::create([
        'firstName' => $user_detls['first_name'],
        'lastName' => $user_detls['last_name'],
        'paymentMethodNonce' => $nonce
    ]);

    $customer_id = $result1->customer->id;
    $result = \Braintree_Transaction::sale(
        [
            'paymentMethodToken' => $result1->customer->paymentMethods[0]->token,
            'amount' => $prices,
            'merchantAccountId' => $merchant_account_id,
            'options' => [
                'submitForSettlement' => True
            ]
        ]
    );
} else {
    $customer_id = $user_detls['customer_id'];
    $result = \Braintree\Transaction::sale([
        'amount' => $prices,
        'merchantAccountId' => $merchant_account_id,
        'paymentMethodNonce' => $nonce,
        'options' => [
            'submitForSettlement' => True,
            'threeDSecure' => [
                'required' => true
            ]
        ]
    ]);
}
if ($result->success == '1') {

    if (empty($user_detls['customer_id'])) {
        $querys = TableRegistry::get('Users')->query();
        $querys->update()
        ->set(['customer_id' => "$customer_id"])
        ->where(['id' => $currentUserId])
        ->execute();
    }

            //SAVE GROUP GIFT PAYMENTS
    $Groupgiftpayamts = TableRegistry::get('Groupgiftpayamts');
    $groupgifts = $Groupgiftpayamts->newEntity();
    $groupgifts->ggid = $ggId;
    $groupgifts->paiduser_id = $currentUserId;
    $groupgifts->transactionId = $result->transaction->id;
    $groupgifts->amount = 0;
    $groupgifts->cdate = time();
    $groupgiftresult = $Groupgiftpayamts->save($groupgifts);
    $payment_id = $groupgiftresult->id;

    $ggitemDetails = TableRegistry::get('Groupgiftuserdetails')->find('all')->where(['id' => $ggId])->first();
    $balance_amt = $ggitemDetails['balance_amt'];
    $itemId = $ggitemDetails['item_id'];
    $ggcreateuserId = $ggitemDetails['user_id'];
    $name = $ggitemDetails['name'];
    $address1 = $ggitemDetails['address1'];
    $address2 = $ggitemDetails['address2'];
    $state = $ggitemDetails['state'];
    $city = $ggitemDetails['city'];
    $zipcode = $ggitemDetails['zipcode'];
    $telephone = $ggitemDetails['telephone'];
    $country = $ggitemDetails['country'];
    $itemcost = $ggitemDetails['total_amt'];
    $tax =  $ggitemDetails['tax'];
    $itemsize = $ggitemDetails['itemsize'];
    $itemquantity = $ggitemDetails['itemquantity'];
    $shipcost = $ggitemDetails['shipcost'];
    if ($shipcost == '') {
        $shipcost = 0;
    } else {
        $shipcost = $shipcost;
    }

    $countryDetails = TableRegistry::get('Countries')->find('all')->where(['id' => $country])->first();
    $countryName = $countryDetails['country'];
            //SAVE SHIPPING ADDRESS
    $Shippingaddresses = TableRegistry::get('Shippingaddresses');
    $shipping = $Shippingaddresses->newEntity();
    $shipping->userid = $ggcreateuserId;
    $shipping->name = $name;
    $shipping->nickname = time();
    $shipping->country = $countryName;
    $shipping->state = $state;
    $shipping->address1 = $address1;
    $shipping->address2 = $address2;
    $shipping->city = $city;
    $shipping->zipcode = $zipcode;
    $shipping->phone = $telephone;
    $shipping->countrycode = $country;
    $shippingresult = $Shippingaddresses->save($shipping);
    $shippingid = $shippingresult->shippingid;

    $item_datas = TableRegistry::get('Items')->find('all')->contain('Users')->where(['Items.id' => $itemId])->first();
    $userDatass = TableRegistry::get('Users')->find('all')->where(['id' => $ggcreateuserId])->first();
    $shopEmailId = $item_datas['user']['email'];
    $itemmerchant = $item_datas['user']['id'];
    $itemName[] = $item_datas['item_title'];
    $usernameforsupp = $item_datas['user']['first_name'];
    $usernameforcust = $userDatass['first_name'];
    $CrntUserEmailId = $userDatass['email'];
    $tot_quantity[] = $itemquantity;
    $tot_size[] = $itemsize;

    /* USER PAYABLE CURRENCY */
    $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['currency_code' => $currency])->first();
    $forexRate = $forexrateModel['price'];
    $giftforexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $ggitemDetails['currencyid']])->first();
    $giftforexRate = $giftforexrateModel['price'];
    $amount = $this->Currency->conversion($forexRate, $giftforexRate, $amount);
    $balance_amt = round($balance_amt - $amount, 2);
    $querys = TableRegistry::get('GroupgiftuserdetailS')->query();
    $querys->update()
    ->set(['balance_amt' => "$balance_amt"])
    ->where(['id' => $ggId])
    ->execute();

    $querys1 = TableRegistry::get('Groupgiftpayamts')->query();
    $querys1->update()
    ->set(['amount' => "$amount"])
    ->where(['id' => $payment_id])
    ->execute();

    if ($balance_amt <= 0) {

        $querys = TableRegistry::get('GroupgiftuserdetailS')->query();
        $querys->update()
        ->set(['status' => "Completed"])
        ->where(['id' => $ggId])
        ->execute();

        /* SAVE ORDERS */
        $payorders = TableRegistry::get('Orders');
        $createorders = $payorders->newEntity();
        $createorders->userid = $ggcreateuserId;
        $createorders->merchant_id = $itemmerchant;
        $createorders->totalcost = $itemcost - $shipcost - $tax;
        $createorders->tax = $tax;
        $createorders->orderdate = time();
        $createorders->shippingaddress = $shippingid;
        $createorders->coupon_id = '0';
        $createorders->discount_amount = '0';
        $createorders->totalCostshipp = $shipcost;
        $createorders->currency = $currency;
        $createorders->status = "Pending";
        $orderresult = $payorders->save($createorders);
        $orderId = $orderresult->orderid;

        /* SAVE ORDER ITEMS */
        $payorderitems = TableRegistry::get('Order_items');
        $createitemorders = $payorderitems->newEntity();
        $createitemorders->orderid = $orderId;
        $createitemorders->itemid = $itemId;
        $createitemorders->itemname = $itemName[0];
        $createitemorders->itemprice = $itemcost - $shipcost - $tax;
        $createitemorders->tax = $tax;
        $createitemorders->itemquantity = $itemquantity;
        $createitemorders->itemunitprice = ($itemcost - $shipcost - $tax) / $itemquantity;
        $createitemorders->shippingprice = $shipcost;
        $createitemorders->item_size = $itemsize;
        $orderitemresult = $payorderitems->save($createitemorders);

        $itemModel = TableRegistry::get('Items')->find('all')->where(['id' => $itemId])->first();
        $quantityItem = $itemModel['quantity'];
        $user_id = $itemModel['user_id'];
        $itemopt = $itemModel['size_options'];

        if (!empty($itemopt)) {
            if ($itemsize != '0') {
                $seltsize = $itemsize;
                $sizeqty = $itemopt;
                $sizeQty = json_decode($sizeqty, true);
                $sizeQty['unit'][$seltsize] = $sizeQty['unit'][$seltsize] - $itemquantity;
            }
        }
        if ($cartSize != '0') {
            $this->request->data['Item']['size_options'] = json_encode($sizeQty);
        } else {
            $this->request->data['Item']['size_options'] = '';
        }

                //UPDATE MERCHANT ID
        $querys = TableRegistry::get('Orders')->query();
        $querys->update()
        ->set(['merchant_id' => $user_id])
        ->where(['orderid' => $orderId])
        ->execute();

        $invoices = TableRegistry::get('Invoices');
        $invoiceTables = TableRegistry::get('Invoices')->find('all')->order(['invoiceid' => 'DESC'])->first();
        $createinvoices = $invoices->newEntity();
        $createinvoices->invoiceno = 'INV' . $invoiceId . $ggcreateuserId;
        $createinvoices->invoicedate = time();
        $createinvoices->invoicestatus = 'Completed';
        $createinvoices->paymentmethod = $result->transaction->paymentInstrumentType;
        $invoiceorderresult = $invoices->save($createinvoices);
        $invoiceId = $invoiceorderresult->invoiceid;

                //SAVE INVOICE ORDERS
        $invoiceorders = TableRegistry::get('Invoiceorders');
        $createinvoiceorders = $invoiceorders->newEntity();
        $createinvoiceorders->invoiceid = $invoiceId;
        $createinvoiceorders->orderid = $orderId;
        $invoiceorderresult = $invoiceorders->save($createinvoiceorders);

        /* * Update the Affiliate Product Share commission save to Sharing person * */
            
            $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['receiver_id' => $ggcreateuserId])->where(['status' => 'visit'])->all();
            if(!empty($shareproducts)){
                foreach($shareproducts as $sharepdt) {
                    $sharepdtid = $sharepdt['item_id'];
                    //if(in_array($sharepdtid, $itemmailids)) {

                 $itemModel = TableRegistry::get('Items')->find()->where(['id' => $sharepdtid])->first();
                 
                 $orderitemModel = TableRegistry::get('Order_items')->find('all')->where(['orderid' => $orderId])->first();
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
                    $sharedquery->update()->set(['order_id' => $orderId, 'status' => 'purchased', 'share_amount' => $commission_amount])->where(['receiver_id' => $ggcreateuserId])->where(['item_id' => $sharepdtid])->where(['status' => 'visit'])->execute();

                   // }
                }
            }
           
            /* * End Update the Affiliate Product Share commission save to Sharing person * */

        /* GROUPGIFTCARD EMAILS */
        $subject = __d('user', 'Group Gift Notification');
        $template = 'ggcust';
        $messages = "";
        $emailidcust = base64_encode($CrntUserEmailId);
        $orderIdcust = base64_encode($orderId);
        $setdata = array('sitelogo' => $Sitesettings['site_logo'], 'sitename' => $Sitesettings['site_name'], 'custom' => $usernameforcust, 'loguser' => $loguser, 'itemname' => $itemName, 'tot_quantity' => $tot_quantity, 'tot_size' => $tot_size, 'access_url' => $_SESSION['site_url'] . "custupdate/" . $emailidcust . "~" . $orderIdcust, 'access_url_n_d' => $_SESSION['site_url'] . "custupdatend/" . $emailidcust . "~" . $orderIdcust);
        $this->sendmail($CrntUserEmailId, $subject, $messages, $template, $setdata);

        $userinfo = TableRegistry::get('Users')->find('all')->where(['email' => $CrntUserEmailId])->first();
        $this->loadModel('Userdevices');
        $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $userinfo['id'])));
        $userdevicestable = TableRegistry::get('Userdevices');
        $userddett = $userdevicestable->find('all')->where(['user_id' => $userinfo['id']])->all();
        foreach ($userddett as $userdet) {
            $deviceTToken = $userdet['deviceToken'];
            $badge = $userdet['badge'];
            $badge +=1;
            $querys = $userdevicestable->query();
            $querys->update()
            ->set(['badge' => $badge])
            ->where(['deviceToken' => $deviceTToken])
            ->execute();
            if (isset($deviceTToken)) {
                $userprofileimage = $userinfo['profile_image'];
                if ($userprofileimage == "")
                    $userprofileimage = "usrimg.jpg";
                $pushMessage['type'] = "groupgift";
                $pushMessage['user_id'] = $userinfo['id'];
                $pushMessage['user_name'] = $userinfo['username'];
                $pushMessage['user_image'] = $userprofileimage;
                $pushMessage['gift_id'] = $ggId;
                $user_detail = TableRegistry::get('Users')->find()->where(['id' => $userinfo['id']])->first();
                I18n::locale($user_detail['languagecode']);
                $pushMessage['message'] = __d('user', "You have Created the item for Group gift. Soon your friend  will get the Item from") . ' ' . $Sitesettings['site_name'];
                $messages = json_encode($pushMessage);
                $this->pushnot($deviceTToken, $messages, $badge);
            }
        }

        $userDET = TableRegistry::get('Groupgiftpayamts')->find()->where(['ggid' => $ggId])->all();
        foreach ($userDET as $userss) {
            $userdetails = TableRegistry::get('Users')->find('all')->where(['id' => $userss->paiduser_id])->first();
            $emailss[] = $userdetails['email'];
            $usernamess[] = $userdetails['username'];
            $userids[] = $userdetails['id'];
            if ($userdetails['profile_image'] == "")
                $userimage[] = "usrimg.jpg";
            else
                $userimage[] = $userdetails['profile_image'];
        }
        foreach ($emailss as $keyy => $emailss1) {
            $subject = __d('user', 'Group Gift Notification');
            $template = 'ggcontribute';
            $messages = "";
            $emailidcust = base64_encode($CrntUserEmailId);
            $orderIdcust = base64_encode($orderId);
            $setdata = array('custom' => $usernamess[$keyy], 'loguser' => $loguser, 'itemname' => $itemName, 'tot_quantity' => $tot_quantity, 'tot_size' => $tot_size, 'access_url' => $_SESSION['site_url'] . "custupdate/" . $emailidcust . "~" . $orderIdcust, 'access_url_n_d' => $_SESSION['site_url'] . "custupdatend/" . $emailidcust . "~" . $orderIdcust);
            $this->sendmail($emailss1, $subject, $messages, $template, $setdata);

            $userinfo = TableRegistry::get('Users')->find('all')->where(['email' => $emailss1])->first();
            /* GIFTCARD PUSH NOTIFICATIONS */
            $this->loadModel('Userdevices');
            $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $userinfo['id'])));
            $userdevicestable = TableRegistry::get('Userdevices');
            $userddett = $userdevicestable->find('all')->where(['user_id' => $userinfo['id']])->all();
            foreach ($userddett as $userdet) {
                $deviceTToken = $userdet['deviceToken'];
                $badge = $userdet['badge'];
                $badge +=1;
                $querys = $userdevicestable->query();
                $querys->update()
                ->set(['badge' => $badge])
                ->where(['deviceToken' => $deviceTToken])
                ->execute();
                if (isset($deviceTToken)) {

                    $pushMessage['type'] = "groupgift";
                    $pushMessage['user_id'] = $userids[$keyy];
                    $pushMessage['user_name'] = $usernamess[$keyy];
                    $pushMessage['user_image'] = $userimage[$keyy];
                    $pushMessage['gift_id'] = $ggId;
                    $user_detail = TableRegistry::get('Users')->find()->where(['id' => $userinfo['id']])->first();
                    I18n::locale($user_detail['languagecode']);
                    $pushMessage['message'] = $usernamess[$keyy] . " " . __d('user', 'Contributed the product for Group gift . Soon your friend  will get the Product from') . " " . $Sitesettings['site_name'];
                    $messages = json_encode($pushMessage);
                    $this->pushnot($deviceTToken, $messages, $badge);
                }
            }
        }

        $subject = __d('user', 'Order notification');
        $template = 'ggsupp';
        $messages = "";
        $emailidsell = base64_encode($shopEmailId);
        $orderIdmer = base64_encode($orderId);
        $setdata = array('custom' => $usernameforsupp, 'loguser' => $loguser, 'itemname' => $itemName, 'tot_quantity' => $tot_quantity, 'tot_size' => $tot_size, 'access_url' => $_SESSION['site_url'] . "custupdate/" . $emailidcust . "~" . $orderIdcust, 'access_url_n_d' => $_SESSION['site_url'] . "custupdatend/" . $emailidcust . "~" . $orderIdcust, 'name' => $name, 'address1' => $address1, 'address2' => $address2, 'state' => $state, 'city' => $city, 'countryName' => $countryName, 'telephone' => $telephone, 'access_url' => $_SESSION['site_url'] . "merupdate/" . $emailidsell . "~" . $orderIdmer);


        $userinfo = TableRegistry::get('Users')->find('all')->where(['email' => $shopEmailId])->first();
        $this->loadModel('Userdevices');
        $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $userinfo['id'])));
        foreach ($userddett as $userdet) {
            $deviceTToken = $userdet['Userdevices']['deviceToken'];
            $badge = $userdet['Userdevices']['badge'];
            $badge +=1;
            $this->Userdevices->updateAll(array('badge' => $badge), array('deviceToken' => $deviceTToken));
            if (isset($deviceTToken)) {
                $pushMessage['message'] = "There is an order placed on you shop at" . $Sitesettings['site_name'];
                $messages = json_encode($pushMessage);
            }
        }
    }
    $this->redirect('/gifts/' . $ggId);
} else {
    $this->redirect('/gifts/' . $ggId);
}
}

public function braintreecheckout()
{
    include_once( WWW_ROOT . 'braintree/lib/Braintree.php' );
    $this->autoLayout = false;
    $this->autoRender = false;
    global $loguser;
    global $paypalAdaptive;
    $userid = $loguser['id'];
    $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
    $siteChanges = json_decode($Sitesettings['site_changes'], true);
    $creditAmtByAdmin = $siteChanges['credit_amount'];

    /* POSTED VALUES */
    $shippingId = $_POST['shippingId'];
    $itemids = $_POST['itemids'];
    $shipamnt = unserialize($_POST['shipamnt']);
    $itmunitprice = unserialize($_POST['itmunitPrice']);
    $taxamt = $_POST['taxamt'];
    $couponId = $_POST['couponId'];
    $giftcardId = $_POST['giftcardId'];
    $totalprice = $_POST['totalPrice'];
    $totalamount = $_POST['totalamount'];
    $giftcardAmount = $_POST['giftcardAmount'];
    $paidtotalprice = ($totalamount/100);
    $currency = $currencyCode = $_POST['currency'];
    $totalsprice = $_POST['totalsPrice'];
    $userEnterCreditAmt = $_POST['userEnterCreditAmt'];
    $currentTime = $_POST['currentTime'];
    $delivertype = $_POST['delivertype'];
    $prices = $_POST['prices'];
    $userid = $_POST['userid'];
    $nonce = $_POST["payment_method_nonce"];
    $buynow = 0;
    if (isset($_POST["buynow"]) && $_POST["buynow"] == '1') {
        $buynow = 1;
        $buynow_qty = $_POST["buynow_qty"];
        $buynow_size = $_POST["buynow_size"];
    }
    $braintreesettings = json_decode($Sitesettings['merchantid_setting'], true);
    $merchantidsettings = json_decode($Sitesettings['braintree_setting'], true);
    foreach ($merchantidsettings as $key => $value) {
      if($key == $_POST['currency'])
      {
          
        $merchant_account_id = $value['merchant_account_id'];
        
    }
}
$params = array(
    "testmode" => $braintreesettings['type'],
    "merchantid" => $braintreesettings['merchant_id'],
    "publickey" => $braintreesettings['public_key'],
    "privatekey" => $braintreesettings['private_key'],
);
if ($params['testmode'] == "sandbox") {
    \Braintree_Configuration::environment('sandbox');
} else {
    \Braintree_Configuration::environment('production');
}
\Braintree_Configuration::merchantId($params["merchantid"]);
\Braintree_Configuration::publicKey($params["publickey"]);
\Braintree_Configuration::privateKey($params["privatekey"]);

$user_detls = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
if (empty($user_detls['customer_id'])) {
    $result1 = \Braintree_Customer::create([
        'firstName' => $user_detls['User']['first_name'],
        'lastName' => $user_detls['User']['last_name'],
        'paymentMethodNonce' => $nonce
    ]);

    $customer_id = $result1->customer->id;
    $result = \Braintree_Transaction::sale(
        [
            'paymentMethodToken' => $result1->customer->paymentMethods[0]->token,
            'amount' => $prices,
            'merchantAccountId' => $merchant_account_id,
            'options' => [
                'submitForSettlement' => True
            ]
        ]
    );
} else {
    $customer_id = $user_detls['customer_id'];
    $result = \Braintree\Transaction::sale([
        'amount' => $prices,
        'merchantAccountId' => $merchant_account_id,
        'paymentMethodNonce' => $nonce,
        'options' => [
            'submitForSettlement' => True,
            'threeDSecure' => [
                'required' => true
            ]
        ]
    ]);
}
$userquery = TableRegistry::get('Users')->query();
/* PAYMENT SUCCESS */
//echo "<pre>";print_r($result);die;

if ($result->success == '1') {
    $braintree_cust_id = $result->transaction->id;
    if (empty($user_detls['customer_id'])) {
        $userquery->update()->set(['customer_id' => $customer_id])
        ->where(['id' => $userid])->execute();
    }
            //FOXEX RATES
    $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['currency_code' => $currency])->first();
    $forexRate = $forexrateModel['price'];

            //SHIPPING ADDRESS
    $tempShippingModel = TableRegistry::get('Tempaddresses')->find()->where(['shippingid' => $shippingId])->first();
    $shippingid = $tempShippingModel['shippingid'];
    $userid = $tempShippingModel['userid'];
    $nickname = $tempShippingModel['nickname'];
    $name = $tempShippingModel['name'];
    $address1 = $tempShippingModel['address1'];
    $address2 = $tempShippingModel['address2'];
    $city = $tempShippingModel['city'];
    $state = $tempShippingModel['state'];
    $country = $tempShippingModel['country'];
    $zipcode = $tempShippingModel['zipcode'];
    $phone = $tempShippingModel['phone'];
    $countrycode = $tempShippingModel['countrycode'];

    $shippingaddressescount = TableRegistry::get('Shippingaddresses')->find()->where([
        'shippingid' => $shippingid,
        'userid' => $userid,
        'nickname' => $nickname,
        'name' => $name,
        'address1' => $address1,
        'address2' => $address2,
        'city' => $city,
        'state' => $state,
        'country' => $country,
        'zipcode' => $zipcode,
        'phone' => $phone])->count();


    $shippingaddressesdataModel = TableRegistry::get('Shippingaddresses')->find()->where([
        'userid' => $userid,
        'nickname' => $nickname,
        'name' => $name,
        'address1' => $address1,
        'address2' => $address2,
        'city' => $city,
        'state' => $state,
        'country' => $country,
        'zipcode' => $zipcode,
        'phone' => $phone])->first();

    if ($shippingaddressescount > 0) {
        $shippingId = $shippingaddressesdataModel['shippingid'];
    } else {
        $shippingorders = TableRegistry::get('Shippingaddresses');
        $createshippingorders = $shippingorders->newEntity();
        $createshippingorders->userid = $userid;
        $createshippingorders->name = $name;
        $createshippingorders->nickname = $nickname;
        $createshippingorders->country = $country;
        $createshippingorders->state = $state;
        $createshippingorders->address1 = $address1;
        $createshippingorders->address2 = $address2;
        $createshippingorders->city = $city;
        $createshippingorders->zipcode = $zipcode;
        $createshippingorders->phone = $phone;
        $createshippingorders->countrycode = $countrycode;
        $shippingorderresult = $shippingorders->save($createshippingorders);
        $shippingId = $shippingorderresult->shippingid;
    }

    $users = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
    $itemids = str_replace('[', "", $itemids);
    $itemids = str_replace(']', "", $itemids);
    $itemids = explode(',', $itemids);
    foreach($itemids as $itemidss)
        {
           
            $item_datas[] = TableRegistry::get('Items')->find()->where(['Items.id' => $itemidss])->order(['Items.user_id' => 'DESC'])->first();
        }
    $prevUserId = 0;
    $mercount = 0;
    $meritemcount = 0;
    foreach ($item_datas as $itemModel) {
        if ($prevUserId != $itemModel->user_id) {
            $prevUserId = $itemModel->user_id;
            $itemUsers[$mercount]['userid'] = $prevUserId;
            $prevcount = $mercount;
            $mercount ++;
            $meritemcount = 0;
        }
        $itemUsers[$prevcount]['items'][$meritemcount]['itemid'] = $itemModel->id;
        $itemUsers[$prevcount]['items'][$meritemcount]['itemname'] = $itemModel->item_title;
        $itemUsers[$prevcount]['items'][$meritemcount]['featured'] = $itemModel->featured;
        $itemUsers[$prevcount]['items'][$meritemcount]['item_skucode'] = $itemModel->skuid;
        $meritemcount ++;
    }
    if (!empty($couponId)) {
        $coupon_id = $couponId;
        $getcouponvalue = TableRegistry::get('Sellercoupons')->find()->where(['id' => $coupon_id])->first();
        $rangeval = $getcouponvalue['remainrange'];
        $rangevals = $rangeval - 1;
        $sellercouponquery = TableRegistry::get('Sellercoupons')->query();
        $sellercouponquery->update()->set(['remainrange' => $rangevals])
        ->where(['id' => $coupon_id])->execute();
    } else {
        $coupon_id = 0;
    }

    if ($userEnterCreditAmt != 0) {
        $credit_amt_reduce = $users['credit_total'];
        $usedCreditInUSD = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $userEnterCreditAmt);
        $credit_amt_reduce -= $usedCreditInUSD;
        $credit_amt_reduce = round($credit_amt_reduce, 2);
        $userquery->update()->set(['credit_total' => $credit_amt_reduce])
        ->where(['id' => $userid])->execute();
    }
    $usernameforcust = $users['first_name'];
    $ordersId = "";
    $itemTotal = 0;
    $productsId = array();
    foreach ($itemUsers as $itemUser) {
        $orderComission = 0;
        $totalcost = 0;
        $totalCostshipp = 0;
        /* SAVE ORDERS */
        $payorders = TableRegistry::get('Orders');
        $createorders = $payorders->newEntity();
        $createorders->userid = $userid;
        $createorders->orderdate = time();
        $createorders->totalcost = '0';
        $createorders->shippingaddress = $shippingId;
        $createorders->coupon_id = $couponId;
        $createorders->currency = $currency;
        $createorders->status = "Pending";
        $createorders->deliverytype = "braintree";
        if ($userEnterCreditAmt != 0 || $_POST['giftcardId'] != 0) {
            if ($userEnterCreditAmt != 0) {
                $createorders->discount_amount = $userEnterCreditAmt;
                $discount = $userEnterCreditAmt;
            } else {
                $getiftcardvalueGC = TableRegistry::get('Giftcards')->find()->where(['id' => $giftcardId])->first();
                $discount_amountGC = $getiftcardvalueGC['avail_amount'];
                $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getiftcardvalueGC->currencyid])->first();
                $giftcardrate = $forexrateModel['price'];
                $discount_amountGC = $this->Currency->conversion($giftcardrate, $forexRate, $discount_amountGC);
                $createorders->discount_amount = $discount_amountGC;
            }
        }

        $orderresult = $payorders->save($createorders);
        $orderId = $orderresult->orderid;
        if ($ordersId == "") {
            $ordersId .= "#" . $orderId;
        } else {
            $ordersId .= ", #" . $orderId;
        }
        $totalamountpay = 0;
        /* SAVE ORDER ITEMS */
        $payorderitems = TableRegistry::get('Order_items');
        for ($j = 0; $j < count($itemUser['items']); $j++) {
            $createitemorders = $payorderitems->newEntity();
            $createitemorders->orderid = $orderId;
            $createitemorders->itemid = $itemUser['items'][$j]['itemid'];
            $createitemorders->itemname = $itemUser['items'][$j]['itemname'];
            $createitemorders->item_skucode = $itemUser['items'][$j]['item_skucode'];
            $itm_qty = 0;

            if ($buynow == '0') {
                $cartDetails = TableRegistry::get('Carts')->find()->where(['item_id' => $createitemorders->itemid])->where(['user_id' => $userid])->where(['payment_status' => 'progress'])->first();
                if ($cartDetails['size_options'] != NULL) {
                    $cartSize = $cartDetails['size_options'];
                } else {
                    $cartSize = '0';
                }
                $itm_qty = $cartDetails['quantity'];
            } else {
                $cartSize = $buynow_size;
                $itm_qty = $buynow_qty;
            }

            $itemDetails = TableRegistry::get('Items')->find()->where(['id' => $createitemorders->itemid])->first();
            $createitemorders->item_size = $cartSize;
            $forexrateModell = TableRegistry::get('Forexrates')->find()->where(['id' => $itemDetails->currencyid])->first();
                        $currate = $forexrateModell['price'];
            $amo = $itmunitprice[$itemUser['items'][$j]['itemid']];
                
                if ($cartSize != "") {
                    $product_store = json_decode($itemDetails['size_options'], true);
                    if(in_array($cartSize,$product_store['size']))
                    {
                        $date = date('d');
                        $month = date('m');
                        $year = date('Y');
                        $tdy = strtotime($month . '/' . $date . '/' . $year);
                        

                        if(isset($itemDetails->dealdate) && $itemDetails->dealdate != '' )
                        {
                            $dealdate = $itemDetails->dealdate->format('Y-m-d');
                            $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                            $todaystrtime = strtotime(date('Y-m-d',$tdy));
                        }else{
                            $dealstrtime = '';
                            $todaystrtime = strtotime(date('Y-m-d',$tdy));
                        }

                        if(($itemDetails['discount_type'] == 'daily' && $dealstrtime == $todaystrtime) || $itemDetails['discount_type'] == 'regular')
                        {
                            
                            $price = $product_store['price'][$cartSize];
                            $curramou = $price * (1 - $itemDetails['discount'] / 100);
                        }else{
                            $curramou = $product_store['price'][$cartSize];
                        }

                        
                        $amo = $this->Currency->conversion($currate,$forexRate, $curramou);
                    }
                } 

                $totalprice = substr_replace($totalprice, "", -2);
                $totalsprice = substr_replace($totalsprice, "", -2);
                $ItemTottalPricee = $totalsprice - array_sum($shipamnt) - $taxamt;
                $itemPrice = $itm_qty * $amo;

            if (!in_array($itemUser['items'][$j]['itemid'], $productsId)) {
                $shipamount = $shipamnt[$itemUser['items'][$j]['itemid']];
                $productsId[] = $itemUser['items'][$j]['itemid'];
            } else {
                $shipamount = 0;
            }
            $totalcost += $itemPrice;
            $itemUSD = $itemPrice;
            if ($itemUser['items'][$j]['featured'] == 1) {
                $itemTotal += ($itemPrice * 2);
            } else {
                        $itemTotal += $itemPrice; // Change to USD whatever the currency is
                    }
                    $createitemorders->itemprice = $itemPrice;
                    $createitemorders->itemquantity = $itm_qty;
                    $item_unit_price = $itmunitprice[$itemUser['items'][$j]['itemid']];
                    $createitemorders->itemunitprice = $itemPrice / $itm_qty;
                    $createitemorders->shippingprice = $shipamount;
                    $shippingbyseller[$orderId]+=$shipamount;


                    if ($couponId != 0) {
                        $coupon_id = $couponId;
                        $getcouponvaluetwo = TableRegistry::get('Sellercoupons')->find()->where(['id' => $coupon_id])->first();
                        $coupontype = $getcouponvaluetwo['type'];
                        $sourceid = $getcouponvaluetwo['sourceid'];
                        $sellerid = $getcouponvaluetwo['sellerid'];
                        $discount_amountTwo = $getcouponvaluetwo['couponpercentage'];
                        $discount_amountTwo = ($discount_amountTwo / 100);
                        if (!empty($getcouponvaluetwo)) {
                            $iteid = $itemUser['items'][$j]['itemid'];
                            $itemdata = TableRegistry::get('Items')->find()->where(['id' => $iteid])->first();
                            $cateid = $itemdata['category_id'];
                            if ($coupontype == "item" || $coupontype == "facebook") {
                                if ($sourceid == $iteid) {
                                    $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                    $commissionCost = round($commiItemTotalPrice, 2);
                                    $createitemorders->discountType = 'Coupon Discount';
                                    $createitemorders->discountAmount = $commissionCost;
                                    $createitemorders->discountId = $coupon_id;
                                    $commiItemTotalPrice = '';
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            } else if ($coupontype == "category") {
                                if ($sellerid == $itemdata['user_id']) {
                                    if ($sourceid == $cateid) {
                                        $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                        $commissionCost = round($commiItemTotalPrice, 2);
                                        $createitemorders->discountType = 'Coupon Discount';
                                        $createitemorders->discountAmount = $commissionCost;
                                        $createitemorders->discountId = $coupon_id;
                                        $commiItemTotalPrice = '';
                                    } else {
                                        $createitemorders->discountType = '';
                                        $createitemorders->discountAmount = '';
                                        $commissionCost = 0;
                                    }
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            } else if ($coupontype == "cart") {
                                if ($sellerid == $itemdata['user_id']) {
                                    $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                    $commissionCost = round($commiItemTotalPrice, 2);
                                    $createitemorders->discountType = 'Coupon Discount';
                                    $createitemorders->discountAmount = $commissionCost;
                                    $createitemorders->discountId = $coupon_id;
                                    $commiItemTotalPrice = '';
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            }
                        }
                    }

                    $taxperc = 0;
                    if ($taxamt) {
                        $tax_datas = TableRegistry::get('Taxes')->find()->where(['countryid' => $tempShippingModel['countrycode'], 'status' => 'enable'])->all();
                        $item_price = $itemPrice;
                        foreach ($tax_datas as $taxes) {
                            $taxperc += ($item_price * $taxes->percentage) / 100;
                        }
                        $createitemorders->tax =round($taxperc,2);
                        $taxbyseller[$orderId]+=round($taxperc,2);
                    } else
                    $createitemorders->tax = 0;

                    if ($_POST['giftcardId'] != 0) {
                        $giftCardId = $_POST['giftcardId'];
                        $getiftcardvalueGC = TableRegistry::get('Giftcards')->find()->where(['id' => $giftCardId])->first();
                        $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getiftcardvalueGC->currencyid])->first();
                        $giftcardrate = $forexrateModel['price'];
                        $discount_amountGC = $getiftcardvalueGC['avail_amount'];
                        $discount_amountGC = $this->Currency->conversion($giftcardrate, $forexRate, $discount_amountGC);
                        $commiItemTotalPrice = floatval(($itemPrice) / ($ItemTottalPricee)) * ($discount_amountGC);
                        $commissionCost = round($commiItemTotalPrice, 2);
                        $createitemorders->discountType = 'Giftcard Discount';
                        $createitemorders->discountAmount = $commissionCost;
                        $createitemorders->discountId = $getiftcardvalueGC['giftcard_key'];
                       $giftamount=$itemPrice+$shipamount+$createitemorders->tax-$discount_amountGC;
                        if ($giftamount >= 0) {
                            $createitemorders->giftamount = $discount_amountGC;
                            $amo = 0;
                        }
                        else
                        {
                             $createitemorders->giftamount = $itemPrice+$shipamount+$createitemorders->tax;
                             $amo = -($giftamount);
                        }
                        $commiItemTotalPrice = '';
                           $referalquery = TableRegistry::get('Giftcards')->query();
                $referalquery->update()->set(['avail_amount' => $amo])
                ->where(['id' => $giftCardId])->execute();
                    }

                    
                    if ($userEnterCreditAmt != 0) {
                        $commiDetails = TableRegistry::get('Commissions')->find()->all();
                        foreach ($commiDetails as $commi) {
                            $min_val = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $min_val);
                            $max_value = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $max_value);
                            $active = $commi->active;
                            if ($item_unit_price >= $min_val && $item_unit_price <= $max_val) {
                                if ($commi->type == '%') {
                                    if ($active == "1")
                                        $amount = (floatval($item_unit_price) / 100) * ($commi->type * $forexRate);
                                    else if ($active == "0")
                                        $amount = (floatval($item_unit_price) / 100) * ($Sitesettings['credit_percentage'] * $forexRate);
                                    $amount = $itm_qty * $amount;
                                    $commiItemTotalPrice +=$amount;
                                }else {
                                    if ($active == "1")
                                        $amount = $commi->amount * $forexRate;
                                    else if ($active == "0")
                                        $amount = (floatval($item_unit_price) / 100) * ($Sitesettings['credit_percentage'] * $forexRate);
                                    $amount = $itm_qty * $amount;
                                    $commiItemTotalPrice +=$amount;
                                }
                            }
                        }

                        $commissionCost = floatval($discount);
                        $commissionCost = round($commissionCost, 2);
                        $createitemorders->discountType = 'User Credits';
                        $createitemorders->discountAmount = $commissionCost;
                        $commiItemTotalPrice = '';
                    }

                    $itemComission = 0;
                    $commiDetails = TableRegistry::get('Commissions')->find()->where(['active' => '1'])->all();
                    $countCommission = TableRegistry::get('Commissions')->find()->where(['active' => '1'])->count();
                    foreach ($commiDetails as $commi) {
                        $minimum_value= $commi->min_value;
                        $maximum_value= $commi->max_value;
                        $min_val = $this->Currency->conversion($_SESSION['default_currency_value'],$forexRate, $minimum_value);
                        $max_val = $this->Currency->conversion($_SESSION['default_currency_value'],$forexRate, $maximum_value);
                        if ($itemUSD >= $min_val && $itemUSD <= $max_val) {
                            if ($commi->type == '%') {
                                $amount = (floatval($itemUSD) / 100) * $commi->amount;
                                $itemComission +=$amount;
                            }
                        }
                    }
                    
                    if($countCommission=='0'){
                        $commission_amount = (floatval($itemUSD) / 100) * $Sitesettings['credit_percentage'];
                        $itemComission =$commission_amount;
                    }
                    $itemComission = round($itemComission,2);
                    $orderComission += $itemComission;
                    $orderitemresult = $payorderitems->save($createitemorders);

                    if ($buynow == '0') {
                        /* PLACE CART SUCCESS */
                        $cartid = $cartDetails['id'];
                        $cartdataquery = TableRegistry::get('Carts')->query();
                        $cartdataquery->update()->set(['payment_status' => 'success'])
                        ->where(['id' => $cartid])->execute();
                    }

                    $itemModel = TableRegistry::get('Items')->find()->where(['id' => $itemUser['items'][$j]['itemid']])->first();
                    $quantityItem = $itemModel['quantity'];
                    $user_id = $itemModel['user_id'];
                    $itemname[] = $itemModel['item_title'];
                    $itemmailids[] = $itemModel['id'];
                    $custmrsizeopt[] = $cartSize;
                    $sellersizeopt[] = $cartSize;
                    $selleritemmailids[] = $itemModel['id'];
                    $selleritemname[] = $itemModel['item_title'];
                    $itemopt = '';
                    $itemopt = $itemModel['size_options'];
                    $totquantity[] = $itm_qty;
                    $sellertotquantity[] = $itm_qty;
                    $item_id = $itemUser['items'][$j]['itemid'];
                    $item_quantity = $quantityItem - $itm_qty;
                    $final = '';

                    if (!empty($itemopt)) {
                        if ($cartSize != '0') {
                            $seltsize = $cartSize;
                            $sizeqty = $itemopt;
                            $sizeQty = json_decode($sizeqty, true);
                            $sizeQty['unit'][$seltsize] = $sizeQty['unit'][$seltsize] - $itm_qty;
                            $itemsize = json_encode($sizeQty);
                        }
                    }
                    else
                    {
                        $itemsize='';
                    }
                    $itemorderstablequery = TableRegistry::get('Items')->query();
                    $itemorderstablequery->update()->set(['quantity' => $item_quantity, 'size_options' => $itemsize])
                    ->where(['id' => $item_id])->execute();
                    $final = '';
                    $item_user_id = $itemModel['user_id'];
                    $itemproductid = $itemModel['id'];
                }

                if ($totalCostshipp == 0) {
                    $totalCostshipp = array_sum($shipamnt);
                }

                $tax_rate = $taxamt;
                $ordersitemtablequery = TableRegistry::get('Orders')->query();
                $ordersitemtablequery->update()->set(['merchant_id' => $user_id, 'totalcost' => $totalcost, 'totalCostshipp' => $shippingbyseller[$orderId], 'tax' => $taxbyseller[$orderId], 'admin_commission' => $orderComission])
                ->where(['orderid' => $orderId])->execute();

                if (empty($commissionCost))
                    $commissionCost = 0;
                $totalcost_grandtotal = $totalcost + $tax_rate - $commissionCost;
                $totalcost_discount = $commissionCost;

                $seller_details = TableRegistry::get('Users')->find()->where(['id' => $user_id])->first();
                $seller_name[] = $seller_details['first_name'];
                $seller_name_url[] = $seller_details['username_url'];

                /** INVOICES * */
                $invoiceId = TableRegistry::get('Invoices')->find()->order(['invoiceid DESC'])->first(); //getLastInsertID()+1;
                $invoiceId = $invoiceId['invoiceid'] + 1;
                $invoiceitems = TableRegistry::get('Invoices');
                $inv_data = $invoiceitems->newEntity();
                $inv_data->invoiceno = 'INV' . $invoiceId . $userid;
                $inv_data->invoicedate = time();
                $inv_data->invoicestatus = 'Completed';
                $inv_data->paymentmethod = $result->transaction->paymentInstrumentType;
                $inv_data->paypaltransactionid = $braintree_cust_id;
                $inv_dataresult = $invoiceitems->save($inv_data);
                $invoiceId = $inv_dataresult->invoiceid;

                /** INVOICE ORDERS * */
                $invoiceorders = TableRegistry::get('Invoiceorders');
                $invoice_data = $invoiceorders->newEntity();
                $invoice_data->invoiceid = $invoiceId;
                $invoice_data->orderid = $orderId;
                $invoiceorders->save($invoice_data);


                /** EMAILS & PUSH NOTIFICATIONS */
                $user_id = $itemDetails['user_id'];
                $userModel = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                $logusernameurl = $userModel['username_url'];
                $logusername = $userModel['first_name'];
                $loguserid = $userModel['id'];
                $userImg = $userModel['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                $logusrid = $userid;
                $notifymsg = $loguserlink . "-___-placed an order in your shop, order id : -___-<a href='" . SITE_URL . "merchant/fulfillorders'>" . $orderId . '</a>';
                $logdetails = $this->addlog('orderstatus', $loguserid, $user_id, $orderId, $notifymsg, NULL, $loguserimage);

                $userModelemail = TableRegistry::get('Users')->find()->where(['id' => $user_id])->first();
                if ($delivertype == "door")
                    $usershipping_addr = TableRegistry::get('Shippingaddresses')->find()->where(['shippingid' => $shippingId])->first();

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                $email = $userModelemail['email'];
                $name = $userModelemail['first_name'];
                $aSubject = $setngs['site_name'] . ' -  ' . __d('user', 'Order placed an order in your shop');
                $aBody = '';
                $template = 'ipnmail_supp';
                $setdata = array(
                    'custom' => $userModelemail['first_name'],
                    'loguser' => $loguser,
                    'itemname' => $selleritemname,
                    'itemid' => $selleritemmailids,
                    'tot_quantity' => $sellertotquantity,
                    'sizeopt' => $sellersizeopt,
                    'usershipping_addr' => $usershipping_addr,
                    'orderId' => $orderId,
                    'totalcost' => $totalcost,
                    'currencyCode' => $currencyCode,
                    'buyername' => $userModel['username'],
                    'buyernameurl' => $userModel['username_url'],
                    'paymentmethod' => $result->transaction->paymentInstrumentType,
                    'totalcost_discount' => $totalcost_discount,
                    'totalcost_grandtotal' => $totalcost_grandtotal,
                    'setngs' => $setngs
                );
                $this->sendmail($email, $aSubject, $aBody, $template, $setdata);

                $this->loadModel('Userdevices');
                $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $user_id)));
                foreach ($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge +=1;
                    $this->Userdevice->updateAll(array('badge' => $badge), array('deviceToken' => $deviceTToken));
                    if (isset($deviceTToken)) {
                        $messages = $logusername . " placed a order in your shop, order id : " . $orderId;
                    }
                }
                // $selleritemname = '';
                // $sellertotquantity = '';
                // $selleritemmailids = '';
                // $sellersizeopt = '';
            }


            /** CREDIT AMOUNT CACULATION * */
            $user_datas = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
            $userid = $user_datas['id'];

            /* * * Update the credit amount while share the product** */
            if (isset($currentTime) && !empty($currentTime)) {
                $shareData = array();
                $shareData = json_decode($user_datas['share_status'], true);
                $creditPoints = $user_datas['credit_points'];
                $count = 0;
                if (empty($shareData)) {
                    $shareData[$count][$orderId] = 0;
                    $shareData[$count]['amount'] = $itemTotal;
                    $shareData = json_encode($shareData);
                } else {
                    $count = count($shareData);
                    $shareData[$count][$orderId] = 0;
                    $shareData[$count]['amount'] = $itemTotal;
                    $shareData = json_encode($shareData);
                }

                $sharedataquery = TableRegistry::get('Users')->query();
                $sharedataquery->update()->set(['share_status' => $shareData])
                ->where(['id' => $userid])->execute();
            }


            /* * Update the Affiliate Product Share commission save to Sharing person * */
            
            $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['receiver_id' => $userid])->where(['status' => 'visit'])->all();
            if(!empty($shareproducts)){
                foreach($shareproducts as $sharepdt) {
                    $sharepdtid = $sharepdt['item_id'];
                    if(in_array($sharepdtid, $itemmailids)) {

                 $itemModel = TableRegistry::get('Items')->find()->where(['id' => $sharepdtid])->first();
                 
                 $orderitemModel = TableRegistry::get('Order_items')->find('all')->where(['orderid' => $orderId])->first();
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
                    $sharedquery->update()->set(['order_id' => $orderId, 'status' => 'purchased', 'share_amount' => $commission_amount])->where(['receiver_id' => $userid])->where(['item_id' => $sharepdtid])->where(['status' => 'visit'])->execute();

                    }
                }
            }
           
            /* * End Update the Affiliate Product Share commission save to Sharing person * */

            $referrer_id = $user_datas['referrer_id'];
            if (!empty($referrer_id)) {
                $referrer_ids = json_decode($referrer_id);
                $sixtythdate = strtotime($user_datas['created_at']) + 5184000;
                $createddate = strtotime($user_datas['created_at']);
                if ($createddate < $sixtythdate && time() <= $sixtythdate && $referrer_ids->first == 'first') {

                    $userinvites = TableRegistry::get('Userinvitecredits');
                    $userinvite_data = $userinvites->newEntity();
                    $userinvite_data->user_id = $userid;
                    $userinvite_data->invited_friend = $referrer_ids->reffid;
                    $userinvite_data->credit_amount = $creditAmtByAdmin;
                    $userinvite_data->status = "Used";
                    $userinvite_data->cdate = time();
                    $userinvites->save($userinvite_data);

                    $reff_id['reffid'] = $referrer_ids->reffid;
                    $reff_id['first'] = 'Purchased';
                    $json_ref_id = json_encode($reff_id);

                    $referalquery = TableRegistry::get('Users')->query();
                    $referquery = TableRegistry::get('Users')->query();
                    $referalquery->update()->set(['referrer_id' => $json_ref_id])
                    ->where(['id' => $userid])->execute();

                    $usercredit_amt = TableRegistry::get('Users')->find()->where(['id' => $referrer_ids->reffid])->first();
                    $total_credited_amount = $usercredit_amt['credit_total'];
                    $total_credited_amount = $total_credited_amount + $creditAmtByAdmin;

                    $referid = $referrer_ids->reffid;
                    $referquery->update()->set(['credit_total' => $total_credited_amount])
                    ->where(['id' => $referid])->execute();

                    $userdevicestable = TableRegistry::get('Userdevices');
                    $userddett = $userdevicestable->find('all')->where(['user_id' => $referrer_ids->reffid])->all();

                    foreach ($userddett as $userd) {
                        $deviceTToken = $userd['deviceToken'];
                        $badge = $userd['badge'];
                        $badge +=1;
                        $querys = $userdevicestable->query();
                        $querys->update()
                        ->set(['badge' => $badge])
                        ->where(['deviceToken' => $deviceTToken])
                        ->execute();

                        $user_datas = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                        $user_profile_image = $user_datas['profile_image'];
                        if ($user_profile_image == "")
                            $user_profile_image = "usrimg.jpg";

                        if (isset($deviceTToken)) {
                            $pushMessage['type'] = 'credit';
                            $pushMessage['user_id'] = $userid;
                            $pushMessage['user_name'] = $user_datas['username'];
                            $pushMessage['user_image'] = $user_profile_image;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $referrer_ids->reffid])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "You have received a") . " " . $creditAmtByAdmin . " " . __d('user', 'credit regarding your friends first purchase');
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }
                    if (!empty($referrer_id)) {
                if(trim($user_datas['profile_image']) == "")
                    $userImg = "usrimg.jpg";
                else
                    $userImg = $user_datas['profile_image'];
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL."people/".$user_datas['username_url'];
                $loguserimage = json_encode($image);
                $loguserlink = "".$user_datas['username']."";
                $notifymsg = $loguserlink." -___- Your account has credited for referral bonus";
                $messages = "Your account has credited for referral bonus with ".$_SESSION['default_currency_symbol'].$setngs['signup_credit'];
                $logdetails = $this->addlog('credit',$reff_id['reffid'],$userid,0,$notifymsg,$messages,$loguserimage);
            }
                }
            }

            
            /** USER MAIL ORDERS */
            $userModelemail = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            $email = $userModelemail['email'];
            $name = $userModelemail['first_name'];
            $aSubject = $setngs['site_name'] . ' ' . __d('user', 'Confirmation of your order number(s)') . $ordersId;
            $aBody = '';
            $template = 'ipnmail_cust';
            $setdata = array(
                'custom' => $userModelemail['first_name'],
                'loguser' => $loguser,
                'itemname' => $itemname,
                'itemid' => $itemmailids,
                'tot_quantity' => $totquantity,
                'sizeopt' => $custmrsizeopt,
                'totalcost' => $totalcost,
                'totalcost_discount' => $totalcost_discount,
                'totalcost_grandtotal' => $totalcost_grandtotal,
                'seller_name' => $seller_name,
                'seller_name_url' => $seller_name_url,
                'currencyCode' => $currencyCode,
                'usershipping_addr' => $usershipping_addr,
                'setngs' => $setngs
            );
            $this->sendmail($email, $aSubject, $aBody, $template, $setdata); 
            unset($_SESSION['buynow_product']);
            $this->redirect('/payment-successful/' . $orderId);
        } else {
            $_SESSION['payment_failure'] = 1;
            $this->redirect('/cart');
        }
    }


    public function codcartcheckout(){
        //echo "works";die;
        $this->autoLayout = false;
        $this->autoRender = false;
        global $loguser;
        $userid = $loguser['id'];
        $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $siteChanges = json_decode($Sitesettings['site_changes'], true);
        $creditAmtByAdmin = $siteChanges['credit_amount'];

        //print_r($_POST['totalamount']);exit;
        
        /* POSTED VALUES */
        $shippingId = $_POST['shippingId'];
        $itemids = $_POST['itemids'];
        $shipamnt = unserialize($_POST['shipamnt']);
        $itmunitprice = unserialize($_POST['itmunitPrice']);
        $taxamt = $_POST['taxamt'];
        $couponId = $_POST['couponId'];
        $giftcardId = $_POST['giftcardId'];
        $totalprice = $_POST['totalPrice'];
        $totalamount = $_POST['totalamount'];
        $giftcardAmount = $_POST['giftcardAmount'];
        $paidtotalprice = ($totalamount/100);
        $currency = $currencyCode = $_POST['currency'];
        $totalsprice = $_POST['totalsPrice'];
        $userEnterCreditAmt = $_POST['userEnterCreditAmt'];
        $currentTime = $_POST['currentTime'];
        $delivertype = $_POST['delivertype'];
        $prices = $_POST['prices'];
        $userid = $_POST['userid'];
        if(($totalprice=='0' || $totalprice<0) && ($giftcardId!="")){
            $paymentby='giftcard';
        }
        else if(($totalprice=='0' || $totalprice<0) && ($userEnterCreditAmt!="")){
            $paymentby='credit';
        }
        else
        {
         $paymentby='cod'; 
     }
        // cod security check
     $getc = $this->Captcha->getCode('securitycode');
     $captcha = trim($_POST['captcha']);

     $buynow = 0;
     if (isset($_POST["buynow"]) && $_POST["buynow"] == '1') {
        $buynow = 1;
        $buynow_qty = $_POST["buynow_qty"];
        $buynow_size = $_POST["buynow_size"];
    }
    $userquery = TableRegistry::get('Users')->query();
    /* COD SUCCESS */
    if ($getc==$captcha) {
            //FOXEX RATES
        $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['currency_code' => $currency])->first();
        $forexRate = $forexrateModel['price'];

            //SHIPPING ADDRESS
        $tempShippingModel = TableRegistry::get('Tempaddresses')->find()->where(['shippingid' => $shippingId])->first();
        $shippingid = $tempShippingModel['shippingid'];
        $userid = $tempShippingModel['userid'];
        $nickname = $tempShippingModel['nickname'];
        $name = $tempShippingModel['name'];
        $address1 = $tempShippingModel['address1'];
        $address2 = $tempShippingModel['address2'];
        $city = $tempShippingModel['city'];
        $state = $tempShippingModel['state'];
        $country = $tempShippingModel['country'];
        $zipcode = $tempShippingModel['zipcode'];
        $phone = $tempShippingModel['phone'];
        $countrycode = $tempShippingModel['countrycode'];

        $shippingaddressescount = TableRegistry::get('Shippingaddresses')->find()->where([
            'shippingid' => $shippingid,
            'userid' => $userid,
            'nickname' => $nickname,
            'name' => $name,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'zipcode' => $zipcode,
            'phone' => $phone])->count();


        $shippingaddressesdataModel = TableRegistry::get('Shippingaddresses')->find()->where([
            'userid' => $userid,
            'nickname' => $nickname,
            'name' => $name,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'zipcode' => $zipcode,
            'phone' => $phone])->first();

        if ($shippingaddressescount > 0) {
            $shippingId = $shippingaddressesdataModel['shippingid'];
        } else {
            $shippingorders = TableRegistry::get('Shippingaddresses');
            $createshippingorders = $shippingorders->newEntity();
            $createshippingorders->userid = $userid;
            $createshippingorders->name = $name;
            $createshippingorders->nickname = $nickname;
            $createshippingorders->country = $country;
            $createshippingorders->state = $state;
            $createshippingorders->address1 = $address1;
            $createshippingorders->address2 = $address2;
            $createshippingorders->city = $city;
            $createshippingorders->zipcode = $zipcode;
            $createshippingorders->phone = $phone;
            $createshippingorders->countrycode = $countrycode;
            $shippingorderresult = $shippingorders->save($createshippingorders);
            $shippingId = $shippingorderresult->shippingid;
        }

        $users = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
        $itemids = str_replace('[', "", $itemids);
        $itemids = str_replace(']', "", $itemids);
        $itemids = explode(',', $itemids);
        foreach($itemids as $itemidss)
    {
       
        $item_datas[] = TableRegistry::get('Items')->find()->where(['Items.id' => $itemidss])->order(['Items.user_id' => 'DESC'])->first();
    }

        $prevUserId = 0;
        $mercount = 0;
        $meritemcount = 0;
        foreach ($item_datas as $itemModel) {
            if ($prevUserId != $itemModel->user_id) {
                $prevUserId = $itemModel->user_id;
                $itemUsers[$mercount]['userid'] = $prevUserId;
                $prevcount = $mercount;
                $mercount ++;
                $meritemcount = 0;
            }
            $itemUsers[$prevcount]['items'][$meritemcount]['itemid'] = $itemModel->id;
            $itemUsers[$prevcount]['items'][$meritemcount]['itemname'] = $itemModel->item_title;
            $itemUsers[$prevcount]['items'][$meritemcount]['featured'] = $itemModel->featured;
            $itemUsers[$prevcount]['items'][$meritemcount]['item_skucode'] = $itemModel->skuid;
            $meritemcount ++;
        }
        if (!empty($couponId)) {
            $coupon_id = $couponId;
            $getcouponvalue = TableRegistry::get('Sellercoupons')->find()->where(['id' => $coupon_id])->first();
            $rangeval = $getcouponvalue['remainrange'];
            $rangevals = $rangeval - 1;
            $sellercouponquery = TableRegistry::get('Sellercoupons')->query();
            $sellercouponquery->update()->set(['remainrange' => $rangevals])
            ->where(['id' => $coupon_id])->execute();
        } else {
            $coupon_id = 0;
        }

        if ($userEnterCreditAmt != 0) {
            $credit_amt_reduce = $users['credit_total'];
            $usedCreditInUSD = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $userEnterCreditAmt);
            $credit_amt_reduce -= $usedCreditInUSD;
            $credit_amt_reduce = round($credit_amt_reduce, 2);
            $userquery->update()->set(['credit_total' => $credit_amt_reduce])
            ->where(['id' => $userid])->execute();
        }
        $usernameforcust = $users['first_name'];
        $ordersId = "";
        $itemTotal = 0;
        $productsId = array();
        foreach ($itemUsers as $itemUser) {
            $orderComission = 0;
            $totalcost = 0;
            $totalCostshipp = 0;
            /* SAVE ORDERS */
            $payorders = TableRegistry::get('Orders');
            $createorders = $payorders->newEntity();
            $createorders->userid = $userid;
            $createorders->orderdate = time();
            $createorders->totalcost = '0';
            $createorders->shippingaddress = $shippingId;
            $createorders->coupon_id = $couponId;
            $createorders->currency = $currency;
            $createorders->status = "Pending";
            $createorders->deliverytype = $paymentby;
            if ($userEnterCreditAmt != 0 || $_POST['giftcardId'] != 0) {
                if ($userEnterCreditAmt != 0) {
                    $createorders->discount_amount = $userEnterCreditAmt;
                    $discount = $userEnterCreditAmt;
                } else {
                    $getiftcardvalueGC = TableRegistry::get('Giftcards')->find()->where(['id' => $giftcardId])->first();
                    $discount_amountGC = $getiftcardvalueGC['avail_amount'];
                    $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getiftcardvalueGC->currencyid])->first();
                    $giftcardrate = $forexrateModel['price'];
                    $discount_amountGC = $this->Currency->conversion($giftcardrate, $forexRate, $discount_amountGC);
                    $createorders->discount_amount = $discount_amountGC;
                }
            }

            $orderresult = $payorders->save($createorders);
            $orderId = $orderresult->orderid;
            if ($ordersId == "") {
                $ordersId .= "#" . $orderId;
            } else {
                $ordersId .= ", #" . $orderId;
            }
            $totalamountpay = 0;
            /* SAVE ORDER ITEMS */
     
            $payorderitems = TableRegistry::get('Order_items');
            for ($j = 0; $j < count($itemUser['items']); $j++) {
                $createitemorders = $payorderitems->newEntity();
                $createitemorders->orderid = $orderId;
                $createitemorders->itemid = $itemUser['items'][$j]['itemid'];
                $createitemorders->itemname = $itemUser['items'][$j]['itemname'];
                $createitemorders->item_skucode = $itemUser['items'][$j]['item_skucode'];
                $itm_qty = 0;

                if ($buynow == '0') {
                    $cartDetails = TableRegistry::get('Carts')->find()->where(['item_id' => $createitemorders->itemid])->where(['user_id' => $userid])->where(['payment_status' => 'progress'])->first();
                    if ($cartDetails['size_options'] != NULL) {
                        $cartSize = $cartDetails['size_options'];
                    } else {
                        $cartSize = '0';
                    }
                    $itm_qty = $cartDetails['quantity'];
                } else {
                    $cartSize = $buynow_size;
                    $itm_qty = $buynow_qty;
                }

                if ($buynow == '0') {
                    /* PLACE CART SUCCESS */
                    $cartid = $cartDetails['id'];
                    $cartdataquery = TableRegistry::get('Carts')->query();
                    $cartdataquery->update()->set(['payment_status' => 'success'])
                    ->where(['id' => $cartid])->execute();
                }



                $itemDetails = TableRegistry::get('Items')->find()->where(['id' => $createitemorders->itemid])->first();
                $createitemorders->item_size = $cartSize;
                 $forexrateModell = TableRegistry::get('Forexrates')->find()->where(['id' => $itemDetails->currencyid])->first();
                        $currate = $forexrateModell['price'];
                $amo = $itmunitprice[$itemUser['items'][$j]['itemid']];
                
                if ($cartSize != "") {
                    $product_store = json_decode($itemDetails['size_options'], true);
                    if(in_array($cartSize,$product_store['size']))
                    {
                          $date = date('d');
                            $month = date('m');
                            $year = date('Y');
                            $tdy = strtotime($month . '/' . $date . '/' . $year);

                            if(isset($itemDetails->dealdate) && $itemDetails->dealdate != '' )
                            {
                                $dealdate = $itemDetails->dealdate->format('Y-m-d');
                                $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                                $todaystrtime = strtotime(date('Y-m-d',$tdy));
                            }else{
                                $dealstrtime = '';
                                $todaystrtime = strtotime(date('Y-m-d',$tdy));
                            }

                            if(($itemDetails['discount_type'] == 'daily' && $dealstrtime == $todaystrtime) || $itemDetails['discount_type'] == 'regular')
                            {
                                
                                $price = $product_store['price'][$cartSize];
                                $curramou = $price * (1 - $itemDetails['discount'] / 100);
                            }else{
                                $curramou = $product_store['price'][$cartSize];
                            }
                            $amo = $this->Currency->conversion($currate,$forexRate, $curramou);
                    }
                } 

                $totalprice = substr_replace($totalprice, "", -2);
                $totalsprice = substr_replace($totalsprice, "", -2);
                $ItemTottalPricee = $totalsprice - array_sum($shipamnt) - $taxamt;
                $itemPrice = $itm_qty * $amo;

        
                
                if (!in_array($itemUser['items'][$j]['itemid'], $productsId)) {
                    $shipamount = $shipamnt[$itemUser['items'][$j]['itemid']];
                    $productsId[] = $itemUser['items'][$j]['itemid'];
                } else {
                    $shipamount = 0;
                }
                $totalcost += $itemPrice;
                $itemUSD = $itemPrice;
                if ($itemUser['items'][$j]['featured'] == 1) {
                    $itemTotal += ($itemPrice * 2);
                } else {
                        $itemTotal += $itemPrice; // Change to USD whatever the currency is
                    }
                    $createitemorders->itemprice = $itemPrice;
                    $createitemorders->itemquantity = $itm_qty;
                    $item_unit_price = $itmunitprice[$itemUser['items'][$j]['itemid']];
                    $createitemorders->itemunitprice =  $itemPrice / $itm_qty;
                    $createitemorders->shippingprice = $shipamount;
                    $shippingbyseller[$orderId]+=$shipamount;


                    if ($couponId != 0) {
                        $coupon_id = $couponId;
                        $getcouponvaluetwo = TableRegistry::get('Sellercoupons')->find()->where(['id' => $coupon_id])->first();
                        $coupontype = $getcouponvaluetwo['type'];
                        $sourceid = $getcouponvaluetwo['sourceid'];
                        $sellerid = $getcouponvaluetwo['sellerid'];
                        $discount_amountTwo = $getcouponvaluetwo['couponpercentage'];
                        $discount_amountTwo = ($discount_amountTwo / 100);
                        if (!empty($getcouponvaluetwo)) {
                            $iteid = $itemUser['items'][$j]['itemid'];
                            $itemdata = TableRegistry::get('Items')->find()->where(['id' => $iteid])->first();
                            $cateid = $itemdata['category_id'];
                            if ($coupontype == "item" || $coupontype == "facebook") {
                                if ($sourceid == $iteid) {
                                    $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                    $commissionCost = round($commiItemTotalPrice, 2);
                                    $createitemorders->discountType = 'Coupon Discount';
                                    $createitemorders->discountAmount = $commissionCost;
                                    $createitemorders->discountId = $coupon_id;
                                    $commiItemTotalPrice = '';
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            } else if ($coupontype == "category") {
                                if ($sellerid == $itemdata['user_id']) {
                                    if ($sourceid == $cateid) {
                                        $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                        $commissionCost = round($commiItemTotalPrice, 2);
                                        $createitemorders->discountType = 'Coupon Discount';
                                        $createitemorders->discountAmount = $commissionCost;
                                        $createitemorders->discountId = $coupon_id;
                                        $commiItemTotalPrice = '';
                                    } else {
                                        $createitemorders->discountType = '';
                                        $createitemorders->discountAmount = '';
                                        $commissionCost = 0;
                                    }
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            } else if ($coupontype == "cart") {
                                if ($sellerid == $itemdata['user_id']) {
                                    $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                    $commissionCost = round($commiItemTotalPrice, 2);
                                    $createitemorders->discountType = 'Coupon Discount';
                                    $createitemorders->discountAmount = $commissionCost;
                                    $createitemorders->discountId = $coupon_id;
                                    $commiItemTotalPrice = '';
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            }
                        }
                    }

                     $taxperc = 0;
                    if ($taxamt) {
                        $tax_datas = TableRegistry::get('Taxes')->find()->where(['countryid' => $tempShippingModel['countrycode'], 'status' => 'enable'])->all();
                        $item_price = $itemPrice;
                        foreach ($tax_datas as $taxes) {
                            $taxperc += ($item_price * $taxes->percentage) / 100;
                        }
                        $createitemorders->tax = round($taxperc,2);
                        $taxbyseller[$orderId]+=round($taxperc,2);
                    } else
                    $createitemorders->tax = 0;

                    if ($_POST['giftcardId'] != 0) {
                        $giftCardId = $_POST['giftcardId'];
                        $getiftcardvalueGC = TableRegistry::get('Giftcards')->find()->where(['id' => $giftCardId])->first();
                        $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getiftcardvalueGC->currencyid])->first();
                        $giftcardrate = $forexrateModel['price'];
                        $discount_amountGC = $getiftcardvalueGC['avail_amount'];
                        $discount_amountGC = $this->Currency->conversion($giftcardrate, $forexRate, $discount_amountGC);
                        $commiItemTotalPrice = floatval(($itemPrice) / ($ItemTottalPricee)) * ($discount_amountGC);
                        $commissionCost = round($commiItemTotalPrice, 2);
                        $createitemorders->discountType = 'Giftcard Discount';
                        $createitemorders->discountAmount = $commissionCost;
                        $createitemorders->discountId = $getiftcardvalueGC['giftcard_key'];
                      $giftamount=$itemPrice+$shipamount+$createitemorders->tax-$discount_amountGC;
                         if ($giftamount >= 0) {
                            $createitemorders->giftamount = $discount_amountGC;
                            $amo = 0;
                        }
                        else
                        {
                             $createitemorders->giftamount = $itemPrice+$shipamount+$createitemorders->tax;
                             $amo = -($giftamount);
                        }
                        $commiItemTotalPrice = '';
                           $referalquery = TableRegistry::get('Giftcards')->query();
                $referalquery->update()->set(['avail_amount' => $amo])
                ->where(['id' => $giftCardId])->execute();
                    }
                   
                    if ($userEnterCreditAmt != 0) {
                        $commiDetails = TableRegistry::get('Commissions')->find()->all();
                        foreach ($commiDetails as $commi) {
                            $min_val = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $min_val);
                            $max_value = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $max_value);
                            $active = $commi->active;
                            if ($item_unit_price >= $min_val && $item_unit_price <= $max_val) {
                                if ($commi->type == '%') {
                                    if ($active == "1")
                                        $amount = (floatval($item_unit_price) / 100) * ($commi->type * $forexRate);
                                    else if ($active == "0")
                                        $amount = (floatval($item_unit_price) / 100) * ($Sitesettings['credit_percentage'] * $forexRate);
                                    $amount = $itm_qty * $amount;
                                    $commiItemTotalPrice +=$amount;
                                }else {
                                    if ($active == "1")
                                        $amount = $commi->amount * $forexRate;
                                    else if ($active == "0")
                                        $amount = (floatval($item_unit_price) / 100) * ($Sitesettings['credit_percentage'] * $forexRate);
                                    $amount = $itm_qty * $amount;
                                    $commiItemTotalPrice +=$amount;
                                }
                            }
                        }

                        $commissionCost = floatval($discount);
                        $commissionCost = round($commissionCost, 2);
                        $createitemorders->discountType = 'User Credits';
                        $createitemorders->discountAmount = $commissionCost;
                        $commiItemTotalPrice = '';
                    }

                    $itemComission = 0;
                    $commiDetails = TableRegistry::get('Commissions')->find()->where(['active' => '1'])->all();
                    $countCommission = TableRegistry::get('Commissions')->find()->where(['active' => '1'])->count();
                    foreach ($commiDetails as $commi) {
                        $minimum_value= $commi->min_value;
                        $maximum_value= $commi->max_value;
                        $min_val = $this->Currency->conversion($_SESSION['default_currency_value'],$forexRate, $minimum_value);
                        $max_val = $this->Currency->conversion($_SESSION['default_currency_value'],$forexRate, $maximum_value);
                        if ($itemUSD >= $min_val && $itemUSD <= $max_val) {
                            if ($commi->type == '%') {
                                $amount = (floatval($itemUSD) / 100) * $commi->amount;
                                $itemComission +=$amount;
                            }
                        }
                    }
                    
                    if($countCommission=='0'){
                        $commission_amount = (floatval($itemUSD) / 100) * $Sitesettings['credit_percentage'];
                        $itemComission =$commission_amount;
                    }
                    $itemComission = round($itemComission,2);
                    $orderComission += $itemComission;
                    $orderitemresult = $payorderitems->save($createitemorders);

                   

                    $itemModel = TableRegistry::get('Items')->find()->where(['id' => $itemUser['items'][$j]['itemid']])->first();
                    $quantityItem = $itemModel['quantity'];
                    $user_id = $itemModel['user_id'];
                    $itemname[] = $itemModel['item_title'];
                    $itemmailids[] = $itemModel['id'];
                    $custmrsizeopt[] = $cartSize;
                    $sellersizeopt[] = $cartSize;
                    $selleritemmailids[] = $itemModel['id'];
                    $selleritemname[] = $itemModel['item_title'];
                    $itemopt = '';
                    $itemopt = $itemModel['size_options'];
                    $totquantity[] = $itm_qty;
                    $sellertotquantity[] = $itm_qty;
                    $item_id = $itemUser['items'][$j]['itemid'];
                    $item_quantity = $quantityItem - $itm_qty;
                    $final = '';

                    if (!empty($itemopt)) {
                        if ($cartSize != '0') {
                            $seltsize = $cartSize;
                            $sizeqty = $itemopt;
                            $sizeQty = json_decode($sizeqty, true);
                            $sizeQty['unit'][$seltsize] = $sizeQty['unit'][$seltsize] - $itm_qty;
                            $itemsize = json_encode($sizeQty);
                        }
                    }
                    else
                    {
                        $itemsize='';
                    }
                    $itemorderstablequery = TableRegistry::get('Items')->query();
                    $itemorderstablequery->update()->set(['quantity' => $item_quantity, 'size_options' => $itemsize])
                    ->where(['id' => $item_id])->execute();
                    $final = '';
                    $item_user_id = $itemModel['user_id'];
                    $itemproductid = $itemModel['id'];
                }

                if ($totalCostshipp == 0) {
                    $totalCostshipp = array_sum($shipamnt);
                }

                $tax_rate = $taxamt;

                $ordersitemtablequery = TableRegistry::get('Orders')->query();
                $ordersitemtablequery->update()->set(['merchant_id' => $user_id, 'totalcost' => $totalcost, 'totalCostshipp' => $shippingbyseller[$orderId], 'tax' => $taxbyseller[$orderId], 'admin_commission' => $orderComission])
                ->where(['orderid' => $orderId])->execute();

                if (empty($commissionCost))
                    $commissionCost = 0;
                $totalcost_grandtotal = $totalcost + $tax_rate - $commissionCost;
                $totalcost_discount = $commissionCost;

                $seller_details = TableRegistry::get('Users')->find()->where(['id' => $user_id])->first();
                $seller_name[] = $seller_details['first_name'];
                $seller_name_url[] = $seller_details['username_url'];

                /** INVOICES * */
                $invoiceId = TableRegistry::get('Invoices')->find()->order(['invoiceid DESC'])->first(); //getLastInsertID()+1;
                $invoiceId = $invoiceId['invoiceid'] + 1;
                $invoiceitems = TableRegistry::get('Invoices');
                $inv_data = $invoiceitems->newEntity();
                $inv_data->invoiceno = 'INV' . $invoiceId . $userid;
                $inv_data->invoicedate = time();
                $inv_data->invoicestatus = 'Completed';
                $inv_data->paymentmethod = 'COD';
                $inv_dataresult = $invoiceitems->save($inv_data);
                $invoiceId = $inv_dataresult->invoiceid;

                /** INVOICE ORDERS * */
                $invoiceorders = TableRegistry::get('Invoiceorders');
                $invoice_data = $invoiceorders->newEntity();
                $invoice_data->invoiceid = $invoiceId;
                $invoice_data->orderid = $orderId;
                $invoiceorders->save($invoice_data);


                /** EMAILS & PUSH NOTIFICATIONS */
                $user_id = $itemDetails['user_id'];
                $userModel = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                $logusernameurl = $userModel['username_url'];
                $logusername = $userModel['first_name'];
                $loguserid = $userModel['id'];
                $userImg = $userModel['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                $logusrid = $userid;
                $notifymsg = $loguserlink . "-___-placed an order in your shop, order id : -___-<a href='" . SITE_URL . "merchant/fulfillorders'>" . $orderId . '</a>';
                $logdetails = $this->addlog('orderstatus', $loguserid, $user_id, $orderId, $notifymsg, NULL, $loguserimage);

                $userModelemail = TableRegistry::get('Users')->find()->where(['id' => $user_id])->first();
                if ($delivertype == "door")
                    $usershipping_addr = TableRegistry::get('Shippingaddresses')->find()->where(['shippingid' => $shippingId])->first();

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                $email = $userModelemail['email'];
                $name = $userModelemail['first_name'];
                $aSubject = $setngs['site_name'] . ' -  ' . __d('user', 'Order placed an order in your shop');
                $aBody = '';
                $template = 'ipnmail_supp';
                $setdata = array(
                    'custom' => $userModelemail['first_name'],
                    'loguser' => $loguser,
                    'itemname' => $selleritemname,
                    'itemid' => $selleritemmailids,
                    'tot_quantity' => $sellertotquantity,
                    'sizeopt' => $sellersizeopt,
                    'usershipping_addr' => $usershipping_addr,
                    'orderId' => $orderId,
                    'totalcost' => $totalcost,
                    'currencyCode' => $currencyCode,
                    'buyername' => $userModel['username'],
                    'buyernameurl' => $userModel['username_url'],
                    'paymentmethod' => $result->transaction->paymentInstrumentType,
                    'totalcost_discount' => $totalcost_discount,
                    'totalcost_grandtotal' => $totalcost_grandtotal,
                    'setngs' => $setngs
                );
                //$this->sendmail($email, $aSubject, $aBody, $template, $setdata);

                $this->loadModel('Userdevices');
                $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $user_id)));
                foreach ($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge +=1;
                    $this->Userdevice->updateAll(array('badge' => $badge), array('deviceToken' => $deviceTToken));
                    if (isset($deviceTToken)) {
                        $messages = $logusername . " placed a order in your shop, order id : " . $orderId;
                    }
                }
                // $selleritemname = '';
                // $sellertotquantity = '';
                // $selleritemmailids = '';
                // $sellersizeopt = '';
            }


            /** CREDIT AMOUNT CACULATION * */
            $user_datas = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
            $userid = $user_datas['id'];

            /** * Update the credit amount while share the product** */
            if (isset($currentTime) && !empty($currentTime)) {
                $shareData = array();
                $shareData = json_decode($user_datas['share_status'], true);
                $creditPoints = $user_datas['credit_points'];
                $count = 0;
                if (empty($shareData)) {
                    $shareData[$count][$orderId] = 0;
                    $shareData[$count]['amount'] = $itemTotal;
                    $shareData = json_encode($shareData);
                } else {
                    $count = count($shareData);
                    $shareData[$count][$orderId] = 0;
                    $shareData[$count]['amount'] = $itemTotal;
                    $shareData = json_encode($shareData);
                }

                $sharedataquery = TableRegistry::get('Users')->query();
                $sharedataquery->update()->set(['share_status' => $shareData])
                ->where(['id' => $userid])->execute();
            }

            /* * Update the Affiliate Product Share commission save to Sharing person * */
            if($paymentby == 'giftcard' || $paymentby == 'credit') {
            $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['receiver_id' => $userid])->where(['status' => 'visit'])->all();
            if(!empty($shareproducts)){
                foreach($shareproducts as $sharepdt) {
                    $sharepdtid = $sharepdt['item_id'];
                    if(in_array($sharepdtid, $itemmailids)) {

                 $itemModel = TableRegistry::get('Items')->find()->where(['id' => $sharepdtid])->first();
                 
                 $orderitemModel = TableRegistry::get('Order_items')->find('all')->where(['orderid' => $orderId])->first();
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
                    $sharedquery->update()->set(['order_id' => $orderId, 'status' => 'purchased', 'share_amount' => $commission_amount])->where(['receiver_id' => $userid])->where(['item_id' => $sharepdtid])->where(['status' => 'visit'])->execute();

                    }
                }
            }
            }
           
            /* * End Update the Affiliate Product Share commission save to Sharing person * */

            
            $referrer_id = $user_datas['referrer_id'];

            if (!empty($referrer_id)) {
                $referrer_ids = json_decode($referrer_id);
                $sixtythdate = strtotime($user_datas['created_at']) + 5184000;
                $createddate = strtotime($user_datas['created_at']);
                if ($createddate < $sixtythdate && time() <= $sixtythdate && $referrer_ids->first == 'first') {

                    $userinvites = TableRegistry::get('Userinvitecredits');
                    $userinvite_data = $userinvites->newEntity();
                    $userinvite_data->user_id = $userid;
                    $userinvite_data->invited_friend = $referrer_ids->reffid;
                    $userinvite_data->credit_amount = $creditAmtByAdmin;
                    $userinvite_data->status = "Used";
                    $userinvite_data->cdate = time();
                    $userinvites->save($userinvite_data);

                    $reff_id['reffid'] = $referrer_ids->reffid;
                    $reff_id['first'] = 'Purchased';
                    $json_ref_id = json_encode($reff_id);

                    $referalquery = TableRegistry::get('Users')->query();
                    $referquery = TableRegistry::get('Users')->query();
                    $referalquery->update()->set(['referrer_id' => $json_ref_id])
                    ->where(['id' => $userid])->execute();

                    $usercredit_amt = TableRegistry::get('Users')->find()->where(['id' => $referrer_ids->reffid])->first();
                    $total_credited_amount = $usercredit_amt['credit_total'];
                    $total_credited_amount = $total_credited_amount + $creditAmtByAdmin;

                    $referid = $referrer_ids->reffid;
                    $referquery->update()->set(['credit_total' => $total_credited_amount])
                    ->where(['id' => $referid])->execute();

                    $userdevicestable = TableRegistry::get('Userdevices');
                    $userddett = $userdevicestable->find('all')->where(['user_id' => $referrer_ids->reffid])->all();

                    foreach ($userddett as $userd) {
                        $deviceTToken = $userd['deviceToken'];
                        $badge = $userd['badge'];
                        $badge +=1;
                        $querys = $userdevicestable->query();
                        $querys->update()
                        ->set(['badge' => $badge])
                        ->where(['deviceToken' => $deviceTToken])
                        ->execute();

                        $user_datas = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                        $user_profile_image = $user_datas['profile_image'];
                        if ($user_profile_image == "")
                            $user_profile_image = "usrimg.jpg";

                        if (isset($deviceTToken)) {
                            $pushMessage['type'] = 'credit';
                            $pushMessage['user_id'] = $userid;
                            $pushMessage['user_name'] = $user_datas['username'];
                            $pushMessage['user_image'] = $user_profile_image;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $referrer_ids->reffid])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "You have received a") . " " . $creditAmtByAdmin . " " . __d('user', 'credit regarding your friends first purchase');
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }
                    if (!empty($referrer_id)) {
                if(trim($user_datas['profile_image']) == "")
                    $userImg = "usrimg.jpg";
                else
                    $userImg = $user_datas['profile_image'];
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL."people/".$user_datas['username_url'];
                $loguserimage = json_encode($image);
                $loguserlink = "".$user_datas['username']."";
                $notifymsg = $loguserlink." -___- rYour account has credited for referral bonus";
                $messages = "Your account has credited for referral bonus with ".$_SESSION['default_currency_symbol'].$setngs['signup_credit'];
                $logdetails = $this->addlog('credit',$reff_id['reffid'],$userid,0,$notifymsg,$messages,$loguserimage);
            }
                }

            }

            

           

            /** USER MAIL ORDERS */
            $userModelemail = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            $email = $userModelemail['email'];
            $name = $userModelemail['first_name'];
            $aSubject = $setngs['site_name'] . ' ' . __d('user', 'Confirmation of your order number(s)') . $ordersId;
            $aBody = '';
            $template = 'ipnmail_cust';
            $setdata = array(
                'custom' => $userModelemail['first_name'],
                'loguser' => $loguser,
                'itemname' => $itemname,
                'itemid' => $itemmailids,
                'tot_quantity' => $totquantity,
                'sizeopt' => $custmrsizeopt,
                'totalcost' => $totalcost,
                'totalcost_discount' => $totalcost_discount,
                'totalcost_grandtotal' => $totalcost_grandtotal,
                'seller_name' => $seller_name,
                'seller_name_url' => $seller_name_url,
                'currencyCode' => $currencyCode,
                'usershipping_addr' => $usershipping_addr,
                'setngs' => $setngs
            );
           // $this->sendmail($email, $aSubject, $aBody, $template, $setdata);
            echo "success";
        } else {
            $_SESSION['payment_failure'] = 1;
            echo "error";
        }
    }



    public function codbuynowcheckout(){
        $this->autoLayout = false;
        $this->autoRender = false;
        global $loguser;
        $userid = $loguser['id'];
        $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $siteChanges = json_decode($Sitesettings['site_changes'], true);
        $creditAmtByAdmin = $siteChanges['credit_amount'];
        
        /* POSTED VALUES */
        $shippingId = $_POST['shippingId'];
        $itemids = $_POST['itemids'];
        $shipamnt = unserialize($_POST['shipamnt']);
        $itmunitprice = unserialize($_POST['itmunitPrice']);

        $taxamt = $_POST['taxamt'];
        $couponId = $_POST['couponId'];
        $giftcardId = $_POST['giftcardId'];
        $totalprice = $_POST['totalPrice'];
        $giftcardAmount = $_POST['giftcardAmount'];
        $totalamount= $_POST['totalamount'];
        $paidtotalprice = ($totalamount/100);
        $currency = $currencyCode = $_POST['currency'];
        $totalsprice = $_POST['totalsPrice'];
        $userEnterCreditAmt = $_POST['userEnterCreditAmt'];
        $currentTime = $_POST['currentTime'];
        $delivertype = $_POST['delivertype'];
        $prices = $_POST['prices'];
        $userid = $_POST['userid'];

        if(($totalprice=='0' || $totalprice<0) && ($giftcardId!="")){
            $paymentby='giftcard';
        }
        else if(($totalprice=='0' || $totalprice<0) && ($userEnterCreditAmt!="")){
            $paymentby='credit';
        }
        else
        {
         $paymentby='cod'; 
     }
     
        // cod security check
     $getc = $this->Captcha->getCode('securitycode');
     $captcha = trim($_POST['captcha']);

     $buynow = 0;
     if (isset($_POST["buynow"]) && $_POST["buynow"] == '1') {
        $buynow = 1;
        $buynow_qty = $_POST["buynow_qty"];
        $buynow_size = $_POST["buynow_size"];
    }
    $userquery = TableRegistry::get('Users')->query();
    /* COD SUCCESS */
    if ($getc==$captcha) {
            //FOXEX RATES
        $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['currency_code' => $currency])->first();
        $forexRate = $forexrateModel['price'];

            //SHIPPING ADDRESS
        $tempShippingModel = TableRegistry::get('Tempaddresses')->find()->where(['shippingid' => $shippingId])->first();
        $shippingid = $tempShippingModel['shippingid'];
        $userid = $tempShippingModel['userid'];
        $nickname = $tempShippingModel['nickname'];
        $name = $tempShippingModel['name'];
        $address1 = $tempShippingModel['address1'];
        $address2 = $tempShippingModel['address2'];
        $city = $tempShippingModel['city'];
        $state = $tempShippingModel['state'];
        $country = $tempShippingModel['country'];
        $zipcode = $tempShippingModel['zipcode'];
        $phone = $tempShippingModel['phone'];
        $countrycode = $tempShippingModel['countrycode'];

        $shippingaddressescount = TableRegistry::get('Shippingaddresses')->find()->where([
            'shippingid' => $shippingid,
            'userid' => $userid,
            'nickname' => $nickname,
            'name' => $name,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'zipcode' => $zipcode,
            'phone' => $phone])->count();


        $shippingaddressesdataModel = TableRegistry::get('Shippingaddresses')->find()->where([
            'userid' => $userid,
            'nickname' => $nickname,
            'name' => $name,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'zipcode' => $zipcode,
            'phone' => $phone])->first();

        if ($shippingaddressescount > 0) {
            $shippingId = $shippingaddressesdataModel['shippingid'];
        } else {
            $shippingorders = TableRegistry::get('Shippingaddresses');
            $createshippingorders = $shippingorders->newEntity();
            $createshippingorders->userid = $userid;
            $createshippingorders->name = $name;
            $createshippingorders->nickname = $nickname;
            $createshippingorders->country = $country;
            $createshippingorders->state = $state;
            $createshippingorders->address1 = $address1;
            $createshippingorders->address2 = $address2;
            $createshippingorders->city = $city;
            $createshippingorders->zipcode = $zipcode;
            $createshippingorders->phone = $phone;
            $createshippingorders->countrycode = $countrycode;
            $shippingorderresult = $shippingorders->save($createshippingorders);
            $shippingId = $shippingorderresult->shippingid;
        }

        $users = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
        $itemids = str_replace('[', "", $itemids);
        $itemids = str_replace(']', "", $itemids);
        $itemids = explode(',', $itemids);
        foreach($itemids as $itemidss)
        {
           
            $item_datas[] = TableRegistry::get('Items')->find()->where(['Items.id' => $itemidss])->order(['Items.user_id' => 'DESC'])->first();
        }
    
        $prevUserId = 0;
        $mercount = 0;
        $meritemcount = 0;
        foreach ($item_datas as $itemModel) {
            if ($prevUserId != $itemModel->user_id) {
                $prevUserId = $itemModel->user_id;
                $itemUsers[$mercount]['userid'] = $prevUserId;
                $prevcount = $mercount;
                $mercount ++;
                $meritemcount = 0;
            }
            $itemUsers[$prevcount]['items'][$meritemcount]['itemid'] = $itemModel->id;
            $itemUsers[$prevcount]['items'][$meritemcount]['itemname'] = $itemModel->item_title;
            $itemUsers[$prevcount]['items'][$meritemcount]['featured'] = $itemModel->featured;
            $itemUsers[$prevcount]['items'][$meritemcount]['item_skucode'] = $itemModel->skuid;
            $meritemcount ++;
        }
        if (!empty($couponId)) {
            $coupon_id = $couponId;
            $getcouponvalue = TableRegistry::get('Sellercoupons')->find()->where(['id' => $coupon_id])->first();
            $rangeval = $getcouponvalue['remainrange'];
            $rangevals = $rangeval - 1;
            $sellercouponquery = TableRegistry::get('Sellercoupons')->query();
            $sellercouponquery->update()->set(['remainrange' => $rangevals])
            ->where(['id' => $coupon_id])->execute();
        } else {
            $coupon_id = 0;
        }

        if ($userEnterCreditAmt != 0) {
            $credit_amt_reduce = $users['credit_total'];
            $usedCreditInUSD = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $userEnterCreditAmt);
            $credit_amt_reduce -= $usedCreditInUSD;
            $credit_amt_reduce = round($credit_amt_reduce, 2);
            $userquery->update()->set(['credit_total' => $credit_amt_reduce])
            ->where(['id' => $userid])->execute();
        }
        $usernameforcust = $users['first_name'];
        $ordersId = "";
        $itemTotal = 0;
        $productsId = array();
        foreach ($itemUsers as $itemUser) {
            $orderComission = 0;
            $totalcost = 0;
            $totalCostshipp = 0;
            /* SAVE ORDERS */
            $payorders = TableRegistry::get('Orders');
            $createorders = $payorders->newEntity();
            $createorders->userid = $userid;
            $createorders->orderdate = time();
            $createorders->totalcost = '0';
            $createorders->shippingaddress = $shippingId;
            $createorders->coupon_id = $couponId;
            $createorders->currency = $currency;
            $createorders->status = "Pending";
            $createorders->deliverytype = $paymentby;
            if ($userEnterCreditAmt != 0 || $_POST['giftcardId'] != 0) {
                if ($userEnterCreditAmt != 0) {
                    $createorders->discount_amount = $userEnterCreditAmt;
                    $discount = $userEnterCreditAmt;
                } else {
                    $getiftcardvalueGC = TableRegistry::get('Giftcards')->find()->where(['id' => $giftcardId])->first();
                    $discount_amountGC = $getiftcardvalueGC['avail_amount'];
                    $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getiftcardvalueGC->currencyid])->first();
                    $giftcardrate = $forexrateModel['price'];
                    $discount_amountGC = $this->Currency->conversion($giftcardrate, $forexRate, $discount_amountGC);
                    $createorders->discount_amount = $discount_amountGC;
                }
            }

            $orderresult = $payorders->save($createorders);
            $orderId = $orderresult->orderid;
            if ($ordersId == "") {
                $ordersId .= "#" . $orderId;
            } else {
                $ordersId .= ", #" . $orderId;
            }
            $totalamountpay = 0;
            /* SAVE ORDER ITEMS */
            $payorderitems = TableRegistry::get('Order_items');
            for ($j = 0; $j < count($itemUser['items']); $j++) {
                $createitemorders = $payorderitems->newEntity();
                $createitemorders->orderid = $orderId;
                $createitemorders->itemid = $itemUser['items'][$j]['itemid'];
                $createitemorders->itemname = $itemUser['items'][$j]['itemname'];
                $createitemorders->item_skucode = $itemUser['items'][$j]['item_skucode'];
                $itm_qty = 0;

                if ($buynow == '0') {
                    $cartDetails = TableRegistry::get('Carts')->find()->where(['item_id' => $createitemorders->itemid])->where(['user_id' => $userid])->where(['payment_status' => 'progress'])->first();
                    if ($cartDetails['size_options'] != NULL) {
                        $cartSize = $cartDetails['size_options'];
                    } else {
                        $cartSize = '0';
                    }
                    $itm_qty = $cartDetails['quantity'];
                } else {
                    $cartSize = $buynow_size;
                    $itm_qty = $buynow_qty;
                }

                $itemDetails = TableRegistry::get('Items')->find()->where(['id' => $createitemorders->itemid])->first();
                $createitemorders->item_size = $cartSize;
                $forexrateModell = TableRegistry::get('Forexrates')->find()->where(['id' => $itemDetails->currencyid])->first();
                        $currate = $forexrateModell['price'];
                $amo = $itmunitprice[$itemUser['items'][$j]['itemid']];
                
                if ($cartSize != "") {
                    $product_store = json_decode($itemDetails['size_options'], true);
                    //echo '<pre>'; print_r($product_store); die;
                    if(in_array($cartSize,$product_store['size']))
                    {
                        $date = date('d');
                        $month = date('m');
                        $year = date('Y');
                        $tdy = strtotime($month . '/' . $date . '/' . $year);

                        if(isset($itemDetails->dealdate) && $itemDetails->dealdate != '' )
                        {
                            $dealdate = $itemDetails->dealdate->format('Y-m-d');
                            $dealstrtime = strtotime(date('Y-m-d',strtotime($dealdate)));
                            $todaystrtime = strtotime(date('Y-m-d',$tdy));
                        }else{
                            $dealstrtime = '';
                            $todaystrtime = strtotime(date('Y-m-d',$tdy));
                        }

                        if(($itemDetails['discount_type'] == 'daily' && $dealstrtime == $todaystrtime) || $itemDetails['discount_type'] == 'regular')
                        {
                            
                            $price = $product_store['price'][$cartSize];
                            $curramou = $price * (1 - $itemDetails['discount'] / 100);
                        }else{
                            $curramou = $product_store['price'][$cartSize];
                        }
                        $amo = $this->Currency->conversion($currate,$forexRate, $curramou);
                        //$curramou = $product_store['price'][$cartSize];
                        //$amo = $this->Currency->conversion($currate,$forexRate, $curramou);
                    }
                } 

                //echo 'amount - '.$amo; die;
                $totalprice = substr_replace($totalprice, "", -2);
                $totalsprice = substr_replace($totalsprice, "", -2);
                $ItemTottalPricee = $totalsprice - array_sum($shipamnt) - $taxamt;
                $itemPrice = $itm_qty * $amo;

                if (!in_array($itemUser['items'][$j]['itemid'], $productsId)) {
                    $shipamount = $shipamnt[$itemUser['items'][$j]['itemid']];
                    $productsId[] = $itemUser['items'][$j]['itemid'];
                } else {
                    $shipamount = 0;
                }
                $totalcost += $itemPrice;
                $itemUSD = $itemPrice;
                if ($itemUser['items'][$j]['featured'] == 1) {
                    $itemTotal += ($itemPrice * 2);
                } else {
                        $itemTotal += $itemPrice; // Change to USD whatever the currency is
                    }
                    $createitemorders->itemprice = $itemPrice;
                    $createitemorders->itemquantity = $itm_qty;
                    $item_unit_price = $itmunitprice[$itemUser['items'][$j]['itemid']];
                    $createitemorders->itemunitprice = $itemPrice / $itm_qty;
                    $createitemorders->shippingprice = $shipamount;
                    $shippingbyseller[$orderId]+=$shipamount;


                    if ($couponId != 0) {
                        $coupon_id = $couponId;
                        $getcouponvaluetwo = TableRegistry::get('Sellercoupons')->find()->where(['id' => $coupon_id])->first();
                        $coupontype = $getcouponvaluetwo['type'];
                        $sourceid = $getcouponvaluetwo['sourceid'];
                        $sellerid = $getcouponvaluetwo['sellerid'];
                        $discount_amountTwo = $getcouponvaluetwo['couponpercentage'];
                        $discount_amountTwo = ($discount_amountTwo / 100);
                        if (!empty($getcouponvaluetwo)) {
                            $iteid = $itemUser['items'][$j]['itemid'];
                            $itemdata = TableRegistry::get('Items')->find()->where(['id' => $iteid])->first();
                            $cateid = $itemdata['category_id'];
                            if ($coupontype == "item" || $coupontype == "facebook") {
                                if ($sourceid == $iteid) {
                                    $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                    $commissionCost = round($commiItemTotalPrice, 2);
                                    $createitemorders->discountType = 'Coupon Discount';
                                    $createitemorders->discountAmount = $commissionCost;
                                    $createitemorders->discountId = $coupon_id;
                                    $commiItemTotalPrice = '';
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            } else if ($coupontype == "category") {
                                if ($sellerid == $itemdata['user_id']) {
                                    if ($sourceid == $cateid) {
                                        $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                        $commissionCost = round($commiItemTotalPrice, 2);
                                        $createitemorders->discountType = 'Coupon Discount';
                                        $createitemorders->discountAmount = $commissionCost;
                                        $createitemorders->discountId = $coupon_id;
                                        $commiItemTotalPrice = '';
                                    } else {
                                        $createitemorders->discountType = '';
                                        $createitemorders->discountAmount = '';
                                        $commissionCost = 0;
                                    }
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            } else if ($coupontype == "cart") {
                                if ($sellerid == $itemdata['user_id']) {
                                    $commiItemTotalPrice = floatval(($itemPrice) * ($discount_amountTwo));
                                    $commissionCost = round($commiItemTotalPrice, 2);
                                    $createitemorders->discountType = 'Coupon Discount';
                                    $createitemorders->discountAmount = $commissionCost;
                                    $createitemorders->discountId = $coupon_id;
                                    $commiItemTotalPrice = '';
                                } else {
                                    $createitemorders->discountType = '';
                                    $createitemorders->discountAmount = '';
                                    $commissionCost = 0;
                                }
                            }
                        }
                    }

                     $taxperc = 0;
                    if ($taxamt) {
                        $tax_datas = TableRegistry::get('Taxes')->find()->where(['countryid' => $tempShippingModel['countrycode'], 'status' => 'enable'])->all();
                        $item_price = $itemPrice;
                        foreach ($tax_datas as $taxes) {
                            $taxperc += ($item_price * $taxes->percentage) / 100;
                        }
                        $createitemorders->tax = round($taxperc,2);
                        $taxbyseller[$orderId]+=round($taxperc,2);
                    } else
                    $createitemorders->tax = 0;

                    if ($_POST['giftcardId'] != 0) {
                        $giftCardId = $_POST['giftcardId'];
                        $getiftcardvalueGC = TableRegistry::get('Giftcards')->find()->where(['id' => $giftCardId])->first();
                        $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['id' => $getiftcardvalueGC->currencyid])->first();
                        $giftcardrate = $forexrateModel['price'];
                        $discount_amountGC = $getiftcardvalueGC['avail_amount'];
                        $discount_amountGC = $this->Currency->conversion($giftcardrate, $forexRate, $discount_amountGC);
                        $commiItemTotalPrice = floatval(($itemPrice) / ($ItemTottalPricee)) * ($discount_amountGC);
                        $commissionCost = round($commiItemTotalPrice, 2);
                        $createitemorders->discountType = 'Giftcard Discount';
                        $createitemorders->discountAmount = $commissionCost;
                        $createitemorders->discountId = $getiftcardvalueGC['giftcard_key'];
                        $giftamount=$itemPrice+$shipamount+$createitemorders->tax-$discount_amountGC;
                          if ($giftamount >= 0) {
                            $createitemorders->giftamount = $discount_amountGC;
                            $amo = 0;
                        }
                        else
                        {
                             $createitemorders->giftamount = $itemPrice+$shipamount+$createitemorders->tax;
                             $amo = -($giftamount);
                        }
                        $commiItemTotalPrice = '';
                           $referalquery = TableRegistry::get('Giftcards')->query();
                $referalquery->update()->set(['avail_amount' => $amo])
                ->where(['id' => $giftCardId])->execute();
                    }

                   
                    if ($userEnterCreditAmt != 0) {
                        $commiDetails = TableRegistry::get('Commissions')->find()->all();
                        foreach ($commiDetails as $commi) {
                            $min_val = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $min_val);
                            $max_value = $this->Currency->conversion($forexRate, $_SESSION['default_currency_value'], $max_value);
                            $active = $commi->active;
                            if ($item_unit_price >= $min_val && $item_unit_price <= $max_val) {
                                if ($commi->type == '%') {
                                    if ($active == "1")
                                        $amount = (floatval($item_unit_price) / 100) * ($commi->type * $forexRate);
                                    else if ($active == "0")
                                        $amount = (floatval($item_unit_price) / 100) * ($Sitesettings['credit_percentage'] * $forexRate);
                                    $amount = $itm_qty * $amount;
                                    $commiItemTotalPrice +=$amount;
                                }else {
                                    if ($active == "1")
                                        $amount = $commi->amount * $forexRate;
                                    else if ($active == "0")
                                        $amount = (floatval($item_unit_price) / 100) * ($Sitesettings['credit_percentage'] * $forexRate);
                                    $amount = $itm_qty * $amount;
                                    $commiItemTotalPrice +=$amount;
                                }
                            }
                        }

                        $commissionCost = floatval($discount);
                        $commissionCost = round($commissionCost, 2);
                        $createitemorders->discountType = 'User Credits';
                        $createitemorders->discountAmount = $commissionCost;
                        $commiItemTotalPrice = '';
                    }

                    $itemComission = 0;
                    $commiDetails = TableRegistry::get('Commissions')->find()->where(['active' => '1'])->all();
                    $countCommission = TableRegistry::get('Commissions')->find()->where(['active' => '1'])->count();
                    foreach ($commiDetails as $commi) {
                        $minimum_value= $commi->min_value;
                        $maximum_value= $commi->max_value;
                        $min_val = $this->Currency->conversion($_SESSION['default_currency_value'],$forexRate, $minimum_value);
                        $max_val = $this->Currency->conversion($_SESSION['default_currency_value'],$forexRate, $maximum_value);
                        if ($itemUSD >= $min_val && $itemUSD <= $max_val) {
                            if ($commi->type == '%') {
                                $amount = (floatval($itemUSD) / 100) * $commi->amount;
                                $itemComission +=$amount;
                            }
                        }
                    }
                    
                    if($countCommission=='0'){
                        $commission_amount = (floatval($itemUSD) / 100) * $Sitesettings['credit_percentage'];
                        $itemComission =$commission_amount;
                    }
                    $itemComission = round($itemComission,2);
                    $orderComission += $itemComission;
                    $orderitemresult = $payorderitems->save($createitemorders);

                    if ($buynow == '0') {
                        /* PLACE CART SUCCESS */
                        $cartid = $cartDetails['id'];
                        $cartdataquery = TableRegistry::get('Carts')->query();
                        $cartdataquery->update()->set(['payment_status' => 'success'])
                        ->where(['id' => $cartid])->execute();
                    }

                    $itemModel = TableRegistry::get('Items')->find()->where(['id' => $itemUser['items'][$j]['itemid']])->first();
                    $quantityItem = $itemModel['quantity'];
                    $user_id = $itemModel['user_id'];
                    $itemname[] = $itemModel['item_title'];
                    $itemmailids[] = $itemModel['id'];
                    $custmrsizeopt[] = $cartSize;
                    $sellersizeopt[] = $cartSize;
                    $selleritemmailids[] = $itemModel['id'];
                    $selleritemname[] = $itemModel['item_title'];
                    $itemopt = '';
                    $itemopt = $itemModel['size_options'];
                    $totquantity[] = $itm_qty;
                    $sellertotquantity[] = $itm_qty;
                    $item_id = $itemUser['items'][$j]['itemid'];
                    $item_quantity = $quantityItem - $itm_qty;
                    $final = '';

                    if (!empty($itemopt)) {
                        if ($cartSize != '0') {
                            $seltsize = $cartSize;
                            $sizeqty = $itemopt;
                            $sizeQty = json_decode($sizeqty, true);
                            $sizeQty['unit'][$seltsize] = $sizeQty['unit'][$seltsize] - $itm_qty;
                            $itemsize = json_encode($sizeQty);
                        }
                    }
                    else
                    {
                        $itemsize='';
                    }
                    $itemorderstablequery = TableRegistry::get('Items')->query();
                    $itemorderstablequery->update()->set(['quantity' => $item_quantity, 'size_options' => $itemsize])
                    ->where(['id' => $item_id])->execute();
                    $final = '';
                    $item_user_id = $itemModel['user_id'];
                    $itemproductid = $itemModel['id'];
                }

                if ($totalCostshipp == 0) {
                    $totalCostshipp = array_sum($shipamnt);
                }

                $tax_rate = $taxamt;

                $ordersitemtablequery = TableRegistry::get('Orders')->query();
                $ordersitemtablequery->update()->set(['merchant_id' => $user_id, 'totalcost' => $totalcost, 'totalCostshipp' => $shippingbyseller[$orderId], 'tax' => $taxbyseller[$orderId], 'admin_commission' => $orderComission])
                ->where(['orderid' => $orderId])->execute();

                if (empty($commissionCost))
                    $commissionCost = 0;
                $totalcost_grandtotal = $totalcost + $tax_rate - $commissionCost;
                $totalcost_discount = $commissionCost;

                $seller_details = TableRegistry::get('Users')->find()->where(['id' => $user_id])->first();
                $seller_name[] = $seller_details['first_name'];
                $seller_name_url[] = $seller_details['username_url'];

                /** INVOICES * */
                $invoiceId = TableRegistry::get('Invoices')->find()->order(['invoiceid DESC'])->first(); //getLastInsertID()+1;
                $invoiceId = $invoiceId['invoiceid'] + 1;
                $invoiceitems = TableRegistry::get('Invoices');
                $inv_data = $invoiceitems->newEntity();
                $inv_data->invoiceno = 'INV' . $invoiceId . $userid;
                $inv_data->invoicedate = time();
                $inv_data->invoicestatus = 'Completed';
                $inv_data->paymentmethod = 'COD';
                $inv_dataresult = $invoiceitems->save($inv_data);
                $invoiceId = $inv_dataresult->invoiceid;

                /** INVOICE ORDERS * */
                $invoiceorders = TableRegistry::get('Invoiceorders');
                $invoice_data = $invoiceorders->newEntity();
                $invoice_data->invoiceid = $invoiceId;
                $invoice_data->orderid = $orderId;
                $invoiceorders->save($invoice_data);


                /** EMAILS & PUSH NOTIFICATIONS */
                $user_id = $itemDetails['user_id'];
                $userModel = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                $logusernameurl = $userModel['username_url'];
                $logusername = $userModel['first_name'];
                $loguserid = $userModel['id'];
                $userImg = $userModel['profile_image'];
                if (empty($userImg)) {
                    $userImg = 'usrimg.jpg';
                }
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL . "people/" . $logusernameurl;
                $loguserimage = json_encode($image);
                $loguserlink = "<a href='" . SITE_URL . "people/" . $logusernameurl . "'>" . $logusername . "</a>";
                $logusrid = $userid;
                $notifymsg = $loguserlink . "-___-placed an order in your shop, order id : -___-<a href='" . SITE_URL . "merchant/fulfillorders'>" . $orderId . '</a>';
                $logdetails = $this->addlog('orderstatus', $loguserid, $user_id, $orderId, $notifymsg, NULL, $loguserimage);

                $userModelemail = TableRegistry::get('Users')->find()->where(['id' => $user_id])->first();
                if ($delivertype == "door")
                    $usershipping_addr = TableRegistry::get('Shippingaddresses')->find()->where(['shippingid' => $shippingId])->first();

                $sitesettingstable = TableRegistry::get('Sitesettings');
                $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
                $email = $userModelemail['email'];
                $name = $userModelemail['first_name'];
                $aSubject = $setngs['site_name'] . ' -  ' . __d('user', 'Order placed an order in your shop');
                $aBody = '';
                $template = 'ipnmail_supp';
                $setdata = array(
                    'custom' => $userModelemail['first_name'],
                    'loguser' => $loguser,
                    'itemname' => $selleritemname,
                    'itemid' => $selleritemmailids,
                    'tot_quantity' => $sellertotquantity,
                    'sizeopt' => $sellersizeopt,
                    'usershipping_addr' => $usershipping_addr,
                    'orderId' => $orderId,
                    'totalcost' => $totalcost,
                    'currencyCode' => $currencyCode,
                    'buyername' => $userModel['username'],
                    'buyernameurl' => $userModel['username_url'],
                    'paymentmethod' => $result->transaction->paymentInstrumentType,
                    'totalcost_discount' => $totalcost_discount,
                    'totalcost_grandtotal' => $totalcost_grandtotal,
                    'setngs' => $setngs
                );
                $this->sendmail($email, $aSubject, $aBody, $template, $setdata);

                $this->loadModel('Userdevices');
                $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $user_id)));
                foreach ($userddett as $userdet) {
                    $deviceTToken = $userdet['deviceToken'];
                    $badge = $userdet['badge'];
                    $badge +=1;
                    $this->Userdevice->updateAll(array('badge' => $badge), array('deviceToken' => $deviceTToken));
                    if (isset($deviceTToken)) {
                        $messages = $logusername . " placed a order in your shop, order id : " . $orderId;
                    }
                }
                // $selleritemname = '';
                // $sellertotquantity = '';
                // $selleritemmailids = '';
                // $sellersizeopt = '';
            }


            /** CREDIT AMOUNT CACULATION * */
            $user_datas = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
            $userid = $user_datas['id'];

            /** * Update the credit amount while share the product** */
            if (isset($currentTime) && !empty($currentTime)) {
                $shareData = array();
                $shareData = json_decode($user_datas['share_status'], true);
                $creditPoints = $user_datas['credit_points'];
                $count = 0;
                if (empty($shareData)) {
                    $shareData[$count][$orderId] = 0;
                    $shareData[$count]['amount'] = $itemTotal;
                    $shareData = json_encode($shareData);
                } else {
                    $count = count($shareData);
                    $shareData[$count][$orderId] = 0;
                    $shareData[$count]['amount'] = $itemTotal;
                    $shareData = json_encode($shareData);
                }

                $sharedataquery = TableRegistry::get('Users')->query();
                $sharedataquery->update()->set(['share_status' => $shareData])
                ->where(['id' => $userid])->execute();
            }

            /* * Update the Affiliate Product Share commission save to Sharing person * */
            if($paymentby == 'giftcard' || $paymentby == 'credit') {
            $shareproducts = TableRegistry::get('Shareproducts')->find()->where(['receiver_id' => $userid])->where(['status' => 'visit'])->all();
            if(!empty($shareproducts)){
                foreach($shareproducts as $sharepdt) {
                    $sharepdtid = $sharepdt['item_id'];
                    if(in_array($sharepdtid, $itemmailids)) {

                 $itemModel = TableRegistry::get('Items')->find()->where(['id' => $sharepdtid])->first();
                 
                 $orderitemModel = TableRegistry::get('Order_items')->find('all')->where(['orderid' => $orderId])->first();
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
                    $sharedquery->update()->set(['order_id' => $orderId, 'status' => 'purchased', 'share_amount' => $commission_amount])->where(['receiver_id' => $userid])->where(['item_id' => $sharepdtid])->where(['status' => 'visit'])->execute();

                    }
                }
            }
            }
           
            /* * End Update the Affiliate Product Share commission save to Sharing person * */

            $referrer_id = $user_datas['referrer_id'];

            if (!empty($referrer_id)) {
                $referrer_ids = json_decode($referrer_id);
                $sixtythdate = strtotime($user_datas['created_at']) + 5184000;
                $createddate = strtotime($user_datas['created_at']);

                if ($createddate < $sixtythdate && time() <= $sixtythdate && $referrer_ids->first == 'first') {


                    $userinvites = TableRegistry::get('Userinvitecredits');
                    $userinvite_data = $userinvites->newEntity();
                    $userinvite_data->user_id = $userid;
                    $userinvite_data->invited_friend = $referrer_ids->reffid;
                    $userinvite_data->credit_amount = $creditAmtByAdmin;
                    $userinvite_data->status = "Used";
                    $userinvite_data->cdate = time();
                    $userinvites->save($userinvite_data);

                    $reff_id['reffid'] = $referrer_ids->reffid;
                    $reff_id['first'] = 'Purchased';
                    $json_ref_id = json_encode($reff_id);

                    $referalquery = TableRegistry::get('Users')->query();
                    $referquery = TableRegistry::get('Users')->query();
                    $referalquery->update()->set(['referrer_id' => $json_ref_id])
                    ->where(['id' => $userid])->execute();

                    $usercredit_amt = TableRegistry::get('Users')->find()->where(['id' => $referrer_ids->reffid])->first();
                    $total_credited_amount = $usercredit_amt['credit_total'];
                    $total_credited_amount = $total_credited_amount + $creditAmtByAdmin;

                    $referid = $referrer_ids->reffid;
                    $referquery->update()->set(['credit_total' => $total_credited_amount])
                    ->where(['id' => $referid])->execute();

                    $userdevicestable = TableRegistry::get('Userdevices');
                    $userddett = $userdevicestable->find('all')->where(['user_id' => $referrer_ids->reffid])->all();

                    foreach ($userddett as $userd) {
                        $deviceTToken = $userd['deviceToken'];
                        $badge = $userd['badge'];
                        $badge +=1;
                        $querys = $userdevicestable->query();
                        $querys->update()
                        ->set(['badge' => $badge])
                        ->where(['deviceToken' => $deviceTToken])
                        ->execute();

                        $user_datas = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
                        $user_profile_image = $user_datas['profile_image'];
                        if ($user_profile_image == "")
                            $user_profile_image = "usrimg.jpg";

                        if (isset($deviceTToken)) {
                            $pushMessage['type'] = 'credit';
                            $pushMessage['user_id'] = $userid;
                            $pushMessage['user_name'] = $user_datas['username'];
                            $pushMessage['user_image'] = $user_profile_image;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $referrer_ids->reffid])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "You have received a") . " " . $creditAmtByAdmin . " " . __d('user', 'credit regarding your friends first purchase');
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }

                      if (!empty($referrer_id)) {
                if(trim($user_datas['profile_image']) == "")
                    $userImg = "usrimg.jpg";
                else
                    $userImg = $user_datas['profile_image'];
                $image['user']['image'] = $userImg;
                $image['user']['link'] = SITE_URL."people/".$user_datas['username_url'];
                $loguserimage = json_encode($image);
                $loguserlink = "".$user_datas['username']."";
                $notifymsg = $loguserlink." -___- Your account has credited for referral bonus";
                $messages = "Your account has credited for referral bonus with ".$_SESSION['default_currency_symbol'].$setngs['signup_credit'];
                $logdetails = $this->addlog('credit',$userid,$reff_id['reffid'],0,$notifymsg,$messages,$loguserimage);
            }
                }
            }


            /** USER MAIL ORDERS */
            $userModelemail = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
            $sitesettingstable = TableRegistry::get('Sitesettings');
            $setngs = $sitesettingstable->find()->where(['id' => 1])->first();
            $email = $userModelemail['email'];
            $name = $userModelemail['first_name'];
            $aSubject = $setngs['site_name'] . ' ' . __d('user', 'Confirmation of your order number(s)') . $ordersId;
            $aBody = '';
            $template = 'ipnmail_cust';
            $setdata = array(
                'custom' => $userModelemail['first_name'],
                'loguser' => $loguser,
                'itemname' => $itemname,
                'itemid' => $itemmailids,
                'tot_quantity' => $totquantity,
                'sizeopt' => $custmrsizeopt,
                'totalcost' => $totalcost,
                'totalcost_discount' => $totalcost_discount,
                'totalcost_grandtotal' => $totalcost_grandtotal,
                'seller_name' => $seller_name,
                'seller_name_url' => $seller_name_url,
                'currencyCode' => $currencyCode,
                'usershipping_addr' => $usershipping_addr,
                'setngs' => $setngs
            );
            $this->sendmail($email, $aSubject, $aBody, $template, $setdata);
            echo "success";
        } else {
            $_SESSION['payment_failure'] = 1;
            echo "error";
        }
    }

    /* FLASH MESSAGE */
    public function Flashmessage($status = NULL, $message = NULL, $url = NULL) {
        if ($status == 'success' && !empty($message)) {
            $this->Flash->success(__($message));
        } else if ($status == 'error' && !empty($message)) {
            $this->Flash->error(__($message));
        }
        if (!empty($url))
            $this->redirect('/merchant/' . $url);
        return true;
    }

    /** BRAINTREE GIFTCARD * */
    public function braintreecheckouttokengift() {

        include_once( WWW_ROOT . 'braintree/lib/Braintree.php' );
        $this->layout = FALSE;
        $this->autoRender = false;
        global $loguser;
        $userid = $loguser['id'];
        $giftamount = $_POST['gift_amount'];
        $giftmessage = $_POST['gift_message'];
        $giftusername = $_POST['gift_recipient'];
        $currency = $_POST['giftcard_currencycode'];
      $userModel = TableRegistry::get('Users')->find()->where(['username' => $giftusername])->first();

      /* MULTIPLE CURRENCY ON GIFTCARDS */
      $forexrateModel = TableRegistry::get('Forexrates')->find()->where(['currency_code' => $currency])->first();

      /* SAVE GIFTCARDS * */
      $giftcardsTable = TableRegistry::get('Giftcards');
      $giftcards = $giftcardsTable->newEntity();
      $giftcards->user_id = $userid;
      $giftcards->reciptent_name = $giftusername;
      $giftcards->reciptent_email = $userModel['email'];
      $giftcards->amount = $giftamount;
      $giftcards->message = $giftmessage;
      $giftcards->avail_amount = $giftamount;
      $giftcards->status = 'Pending';
      $giftcards->currencyid = $forexrateModel['id'];
      $giftcards->cdate = time();
      $result = $giftcardsTable->save($giftcards);
      $giftcardid = $result->id;
      $clientToken = $this->getclienttoken($userid,$currency);
      if ($clientToken && $clientToken != "") {
        $this->set('clienttoken', $clientToken);
        $this->set('giftamount', $giftamount);
        $this->set('giftcardid', $giftcardid);
        $this->set('currency', $currency);
        $this->set('prices', $giftamount);
        $this->render('braintree_cartgift');
    } else {
        $this->redirect('/payment-cancelled/');
    }
}

/* BRAINTREE GET CLIENTTOKEN * */

    public function Getclienttoken($userid,$currency) {
        /** Braintree Settings * */
        $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $braintreesettings = json_decode($Sitesettings['braintree_setting'], true);
        $merchantidsettings = json_decode($Sitesettings['merchantid_setting'], true);
        foreach ($braintreesettings as $key => $value) {
        if($key == $currency)
        {
            
            $merchantAccountId = $value['merchant_account_id'];
            
        }
    }
    $params = array(
        "testmode" => $merchantidsettings['type'],
        "merchantid" => $merchantidsettings['merchant_id'],
        "publickey" =>  $merchantidsettings['public_key'],
        "privatekey" => $merchantidsettings['private_key'],
    );

    if ($params['testmode'] == "sandbox") {
        \Braintree_Configuration::environment('sandbox');
    } else {
        \Braintree_Configuration::environment('production');
    }
    \Braintree_Configuration::merchantId($params["merchantid"]);
    \Braintree_Configuration::publicKey($params["publickey"]);
    \Braintree_Configuration::privateKey($params["privatekey"]);

    $user_detls = TableRegistry::get('Users')->find('all')->where(['id' => $userid])->first();
    if (empty($user_detls['customer_id'])) {
        $clientToken = \Braintree\ClientToken::generate([
        
            "merchantAccountId" => $merchantAccountId 
        ]);
    } else {
        $clientToken = \Braintree_ClientToken::generate([
            "customerId" => $user_detls['customer_id'],
            "merchantAccountId" => $merchantAccountId 
        ]);
    }

    if ($clientToken == "" || $clientToken == null) {
        $this->Flash->error(__d('user', 'Sorry! Kindly check your braintree credentials'));
        $this->redirect('/');
    } else {
        return $clientToken;
    }
    }

    /** BRAINTREE SETTTINGS * */
    public function Configurebraintree($currency) {
        include_once( WWW_ROOT . 'braintree/lib/Braintree.php' );
        /** Braintree Settings * */
        $Sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $merchantidsettings = json_decode($Sitesettings['merchantid_setting'], true);
        
        $params = array(
            "testmode" => $merchantidsettings['type'],
            "merchantid" => $merchantidsettings['merchant_id'],
            "publickey" =>  $merchantidsettings['public_key'],
            "privatekey" => $merchantidsettings['private_key'],
        );

        if ($params['testmode'] == "sandbox") {
            \Braintree_Configuration::environment('sandbox');
        } else {
            \Braintree_Configuration::environment('production');
        }
        \Braintree_Configuration::merchantId($params["merchantid"]);
        \Braintree_Configuration::publicKey($params["publickey"]);
        \Braintree_Configuration::privateKey($params["privatekey"]);

        return true;
    }

    public function braintreegiftcard() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $totalprice = $_POST['giftamount'];
        $giftcardid = $_POST['giftcardid'];
        $currency = $_POST['currency'];
        $prices = $_POST['prices'];
        $nonce = $_POST["payment_method_nonce"];
        $giftdet = TableRegistry::get('Giftcards')->find('all')->where(['id' => $giftcardid])->first();
        $current_user_id = $giftdet['user_id'];
        $user_detls = TableRegistry::get('Users')->find('all')->where(['id' => $current_user_id])->first();
        /** SITE SETTINGS * */
        $sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();

        $braintreesettings = json_decode($sitesettings['braintree_setting'], true);
        foreach ($braintreesettings as $key => $value) {
        if($key == $currency)
        {
            $merchantAccountId = $value['merchant_account_id'];
            
        }
    }
    $this->Configurebraintree($currency);
    if (empty($user_detls['customer_id'])) {
        $result1 = \Braintree_Customer::create([
            'firstName' => $user_detls['first_name'],
            'lastName' => $user_detls['last_name'],
            'paymentMethodNonce' => $nonce
        ]);

        $customer_id = $result1->customer->id;
        $result = \Braintree_Transaction::sale(
            [
                'paymentMethodToken' => $result1->customer->paymentMethods[0]->token,
                'amount' => $prices,
                'merchantAccountId' => $merchantAccountId,
                'options' => [
                    'submitForSettlement' => True
                ]
            ]
        );
    } else {
        $customer_id = $user_detls['customer_id'];

        $result = \Braintree\Transaction::sale([
            'amount' => $prices,
            'merchantAccountId' => $merchantAccountId,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);
    }

    /** SUCCESS RESULT * */
    if ($result->success == '1') {
        $userquery = TableRegistry::get('Users')->query();
        $giftcardquery = TableRegistry::get('Giftcards')->query();
        if (empty($user_detls['customer_id'])) {
            $userquery->update()->set(['customer_id' => $customer_id])
            ->where(['id' => $current_user_id])->execute();
        }
        $custom = $giftcardid;
        $current_user_id = $giftdet['user_id'];
        $giftcardId = $giftdet['id'];
        $gfName = $giftdet['reciptent_name'];
        $gcEmail = $giftdet['reciptent_email'];
        $gcmessage = $giftdet['message'];
        $gcamount = $giftdet['amount'];
        $gcstatus = $giftdet['status'];
        $uniquecode = $this->Urlfriendly->get_uniquecode(8);
        $current_user_email = $user_detls['email'];

        $giftcardquery->update()->set(['status' => "Paid", "giftcard_key" => $uniquecode])
        ->where(['id' => $custom])->execute();

        $giftcarduserModelCount = TableRegistry::get('Giftcards')->find()->where(['reciptent_email' => $gcEmail])->count();
        $giftcarduserModel = TableRegistry::get('Giftcards')->find()->where(['reciptent_email' => $gcEmail])->first();
        if (count($giftcarduserModelCount) > 0) {

            /* GIFTCARD EMAIL */
            $subject = $sitesettings['site_name'] . " – " . __d('user', 'Wow! You got a gift from') . " " . $user_detls['username'];
            $template = 'giftcardemail';
            $messages = "";
            $setdata = array('sitelogo' => $sitesettings['site_logo'], 'sitename' => $sitesettings['site_name'], 'recvuser' => $gfName,
                'sentuser' => $user_detls['first_name'], 'loguser' => $loguser, 'gcmessage' => $gcmessage, 'uniquecode' => $uniquecode, 'itemname' => 'Giftcard', 'tot_quantity' => '1', 'access_url' => $_SESSION['site_url'] . 'signup?referrer=' . $user_detls['username_url']);
            $this->sendmail($gcEmail, $subject, $messages, $template, $setdata);

            $userdetails = TableRegistry::get('Users')->find('all')->where(['email' => $gcEmail])->first();

            /* GIFTCARD NOTIFICATIONS */
            $image['user']['image'] = 'usrimg.jpg';
            $image['user']['link'] = '';
            $loguserimage = json_encode($image);
            $userids = $userdetails['id'];
            $notifymsg = "You have received a gift card -___-" . $uniquecode;
            $messages = "You have received a Gift card from your friend " . $userModl['User']['first_name'] . " worth " . $gcamount . " use this code on checkout: " . $uniquecode;
            $logdetails = $this->addlog('credit', 0, $userids, 0, $notifymsg, $messages, $loguserimage);

            /* GIFTCARD PUSH NOTIFICATIONS */
            $this->loadModel('Userdevices');
            $userddett = $this->Userdevices->find('all', array('conditions' => array('user_id' => $userdetails['id'])));
            $userdevicestable = TableRegistry::get('Userdevices');
            $userddett = $userdevicestable->find()->where(['user_id' => $userdetails['id']])->all();
            foreach ($userddett as $userdet) {
                $deviceTToken = $userdet['deviceToken'];
                $badge = $userdet['badge'];
                $badge +=1;

                $querys = $userdevicestable->query();
                $querys->update()
                ->set(['badge' => $badge])
                ->where(['deviceToken' => $deviceTToken])
                ->execute();


                if (isset($deviceTToken)) {
                    $user_profile_image = $user_detls['profile_image'];
                    if ($user_profile_image == "")
                        $user_profile_image = "usrimg.jpg";
                    $pushMessage['type'] = 'gift_card';
                    $pushMessage['user_id'] = $user_detls['id'];
                    $pushMessage['user_name'] = $user_detls['username'];
                    $pushMessage['user_image'] = $user_profile_image;
                    $user_detail = TableRegistry::get('Users')->find()->where(['id' => $userdetails['id']])->first();
                    I18n::locale($user_detail['languagecode']);
                    $pushMessage['message'] = __d('user', "You have received a Gift card from your friend") . " " . $user_detls['first_name'];
                    $messages = json_encode($pushMessage);
                    $this->pushnot($deviceTToken, $messages, $badge);
                }
            }

            $this->redirect('/payment-successful/');
        }
    } else {
        $this->redirect('/payment-cancelled/');
    }
    }

/** PAYMENT SUCCESS * */
    public function PaymentSuccess($status = NULL) {
        global $loguser;
        $userid = $loguser['id'];
        $this->set('title_for_layout', 'Payment Successful');
        /** SITE SETTINGS * */
        $sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
        $userModel = TableRegistry::get('Users')->find()->where(['id' => $userid])->first();
        if (isset($status) && !empty($status)) {
            $shareData = json_decode($userModel['share_status'], true);
            foreach ($shareData as $shareKey => $shareVal) {
                if (array_key_exists($status, $shareVal)) {
                    $this->set('status', $status);
                    $this->set('amount', $shareVal['amount']);
                }
            }
        }
        $this->set('sitesettings', $sitesettings);
    }

/* CRON JOBS * */

    public function groupgiftupdate() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $gglistsDatas = TableRegistry::get('Groupgiftuserdetails')->find()->where(['status' => 'Active'])->toArray();
        foreach ($gglistsDatas as $gglistsData) {
            $cdategg = $gglistsData['c_date'];
            $ggId = $gglistsData['id'];
            $ggEnddate = $cdategg + 604800;
            if ($ggEnddate < time()) {
                $itemid = $gglistsData['item_id'];
                $ggqnty = $gglistsData['itemquantity'];
                $ggsize = $gglistsData['itemsize'];
                $item_data = TableRegistry::get('Items')->find()->where(['Items.id' => $itemid])->where(['Items.status' => 'publish'])->first();

                $tot_qnty = $item_data['quantity'];
                $final_qnty = $ggqnty + $tot_qnty;
                $sizeoptions = $item_data['size_options'];
                $sizes = json_decode($sizeoptions, true);
                $query = TableRegistry::get('Items');
                $userquery = TableRegistry::get('Users');
                $groupgiftuser = TableRegistry::get('Groupgiftuserdetails');
                if (!empty($sizes)) {
                    $sizeoptions = $item_data['size_options'];
                    $sizes = json_decode($sizeoptions, true);
                    $sizes['unit'][$ggsize] = $sizes['unit'][$ggsize] + $ggqnty;
                    $size_options = json_encode($sizes);
                    $queryss = $query->query();
                    $queryss->update()->set(['quantity' => $final_qnty, 'size_options' => $size_options])
                    ->where(['id' => $itemid])->execute();
                } else {
                    $queryss = $query->query();
                    $queryss->update()->set(['quantity' => $final_qnty])->where(['id' => $itemid])->execute();
                }

                $ggPaidUser = TableRegistry::get('Groupgiftpayamts')->find()->where(['ggid' => $ggId])->toArray();
                foreach ($ggPaidUser as $ggrefund) {
                    $amount = $ggrefund['amount'];
                    $userId = $ggrefund['paiduser_id'];
                    $itemid = $gglistsData['item_id'];
                    $ggqnty = $gglistsData['itemquantity'];
                    $ggsize = $gglistsData['itemsize'];
                    $tot_qnty = $item_data['quantity'];
                    $convertamount = round($amount * $item_data['Forexrates']['price'], 2);
                    $userDetals = TableRegistry::get('Users')->find()->where(['Users.id' => $userId])->first();
                    $creAmount = $userDetals['credit_total'];
                    $creAmount = $creAmount + $convertamount;
                    $usersquery = $userquery->query();
                    $usersquery->update()->set(['credit_total' => $creAmount])->where(['id' => $userId])->execute();

                    /* USER INVITE CREDIT */
                    $userinviteorders = TableRegistry::get('Userinvitecredits');
                    $createorders = $userinviteorders->newEntity();
                    $createorders->user_id = '0';
                    $createorders->invited_friend = $userId;
                    $createorders->credit_amount = $convertamount;
                    $createorders->status = "NotUsed";
                    $createorders->cdate = time();
                    $orderresult = $userinviteorders->save($createorders);

                    $userdevicestable = TableRegistry::get('Userdevices');
                    $userddett = $userdevicestable->find('all')->where(['user_id' => $gglistsData['user_id']])->all();
                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge +=1;
                        $querys = $userdevicestable->query();
                        $querys->update()
                        ->set(['badge' => $badge])
                        ->where(['deviceToken' => $deviceTToken])
                        ->execute();
                        $userdata = TableRegistry::get('Users')->find()->where(['id' => $gglistsData['user_id']])->first();
                        if (isset($deviceTToken)) {
                            $userprofileimage = $userdata['profile_image'];
                            if ($userprofileimage == "")
                                $userprofileimage = "usrimg.jpg";
                            $pushMessage['type'] = "groupgift";
                            $pushMessage['user_id'] = $userdata['id'];
                            $pushMessage['user_name'] = $userdata['username'];
                            $pushMessage['user_image'] = $userprofileimage;
                            $pushMessage['gift_id'] = $ggId;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $gglistsData['user_id']])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "Group gift you have created with the item is expired");
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }
                }
                $groupgiftusers = $groupgiftuser->query();
                $groupgiftusers->update()->set(['status' => 'Expired'])->where(['id' => $ggId])->execute();
            }
        }
    }

    public function groupgiftsoldout() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $gglistsDatas = TableRegistry::get('Groupgiftuserdetails')->find()->where(['status' => 'Active'])->toArray();
        $userquery = TableRegistry::get('Users');
        $groupgiftuser = TableRegistry::get('Groupgiftuserdetails');
        foreach ($gglistsDatas as $gglistsData) {
            $itemid = $gglistsData['item_id'];
            $ggId = $gglistsData['id'];
            $groupgift_email = $gglistsDatas['recipient'];
            $groupgift_username = $gglistsDatas['name'];
            $item_datas = TableRegistry::get('Items')->find()->where(['Items.id' => $itemid])->where(['Items.status' => 'publish'])->first();
            $itemName = $item_datas['item_title'];
            $quantity = $item_datas['quantity'];
            if ($quantity <= 0) {
                $ggPaidUser = TableRegistry::get('Groupgiftpayamts')->find()->where(['ggid' => $ggId])->toArray();
                $sitesettings = TableRegistry::get('Sitesettings')->find('all')->first();
                foreach ($ggPaidUser as $ggrefund) {
                    $amount = $ggrefund['amount'];
                    $convertamount = round($amount * $item_datas['Forexrates']['price'], 2);
                    $userId = $ggrefund['paiduser_id'];
                    $userDetals = TableRegistry::get('Users')->find()->where(['Users.id' => $userId])->first();
                    $creAmount = $userDetals['credit_total'];
                    $creAmount = $creAmount + $convertamount;
                    $usersquery = $userquery->query();
                    $usersquery->update()->set(['credit_total' => $creAmount])->where(['id' => $userId])->execute();

                    $subject = __d('user', 'Group Gift Soldout') . '!';
                    $template = 'groupgiftsoldout';
                    $messages = "";
                    $setdata = array('sitelogo' => $sitesettings['site_logo'], 'sitename' => $sitesettings['site_name'], 'groupgift_email' => $groupgift_email, 'itemname' => $itemName, 'custom' => $groupgift_username);
                    $this->sendmail($groupgift_email, $subject, $messages, $template, $setdata);

                    $userdevicestable = TableRegistry::get('Userdevices');
                    $userddett = $userdevicestable->find('all')->where(['user_id' => $gglistsData['user_id']])->all();
                    foreach ($userddett as $userdet) {
                        $deviceTToken = $userdet['deviceToken'];
                        $badge = $userdet['badge'];
                        $badge +=1;
                        $querys = $userdevicestable->query();
                        $querys->update()
                        ->set(['badge' => $badge])
                        ->where(['deviceToken' => $deviceTToken])
                        ->execute();
                        $userdata = TableRegistry::get('Users')->find()->where(['id' => $gglistsData['user_id']])->first();
                        if (isset($deviceTToken)) {
                            $userprofileimage = $userdata['profile_image'];
                            if ($userprofileimage == "")
                                $userprofileimage = "usrimg.jpg";
                            $pushMessage['type'] = "groupgift";
                            $pushMessage['user_id'] = $userdata['id'];
                            $pushMessage['user_name'] = $userdata['username'];
                            $pushMessage['user_image'] = $userprofileimage;
                            $pushMessage['gift_id'] = $ggId;
                            $user_detail = TableRegistry::get('Users')->find()->where(['id' => $gglistsData['user_id']])->first();
                            I18n::locale($user_detail['languagecode']);
                            $pushMessage['message'] = __d('user', "Group gift you have created with the item is sold out");
                            $messages = json_encode($pushMessage);
                            $this->pushnot($deviceTToken, $messages, $badge);
                        }
                    }

                    /* GROUP GIFT SOLD OUT NOTIFICATIONS */
                    $userModel = TableRegistry::get('Users')->find()->where(['id' => $gglistsData['user_id']])->first();
                    $logusernameurl = $userModel['username_url'];
                    $logusername = $userModel['first_name'];
                    $user_id = $gglistsData['user_id'];
                    $loguserid = 0;
                    $userImg = 'usrimg.jpg';
                    $image['user']['image'] = $userImg;
                    $image['user']['link'] = "";
                    $loguserimage = json_encode($image);
                    $notifymsg = 'Group gift you have created with the item is sold out';
                    $logdetails = $this->addlog('groupgift', $loguserid, $user_id, $notifymsg, NULL, $loguserimage);

                    /* USER INVITE CREDIT */
                    $userinviteorders = TableRegistry::get('Userinvitecredits');
                    $createorders = $userinviteorders->newEntity();
                    $createorders->user_id = '0';
                    $createorders->invited_friend = $userId;
                    $createorders->credit_amount = $convertamount;
                    $createorders->status = "NotUsed";
                    $createorders->cdate = time();
                    $orderresult = $userinviteorders->save($createorders);
                }
                $groupgiftusers = $groupgiftuser->query();
                $groupgiftusers->update()->set(['status' => 'Expired'])->where(['id' => $ggId])->execute();
            }
        }
    }

    public function addlog($type = NULL, $userId = NULL, $notifyTo = NULL, $sourceId = NULL, $notifymsg = NULL, $message = NULL, $image = NULL, $itemid = 0) {

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

    public function addloglive($type = NULL, $userId = NULL, $notifyTo = NULL, $sourceId = NULL, $notifymsg = NULL, $message = NULL, $image = NULL, $itemid = 0) {
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
        $query->update()->set($query->newExpr('unread_notify_cnt = unread_notify_cnt + 1'))->where(['id IN' => $notifyTo])
        ->execute();
    }

    /* STORE THE CREDIT POINTS */

    public function storecredit() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $status = $_POST['status'];
        if (isset($_POST['cod']) && !empty($_POST['cod']))
            $cod = $_POST['cod'];
        else
            $cod = '';

        $this->loadModel('User');
        $this->loadModel('Orders');

        global $loguser;
        global $setngs;
        $userid = $loguser[0]['User']['id'];

        if (isset($status) && !empty($status)) {
            $userDetails = $this->User->findById($userid);
            $shareData = json_decode($userDetails['User']['share_status'], true);
            $creditPoints = $userDetails['User']['credit_points'];
            $shareNewData = array();
            $orderDetails = $this->Orders->findByorderid($status);
            if (!empty($orderDetails))
                $deiveryType = $orderDetails['Orders']['deliverytype'];
            else
                $deiveryType = '';
            foreach ($shareData as $shareKey => $shareVal) {

                if (array_key_exists($status, $shareVal)) {

                    $shareVal[$status] = '1';
                    if ($cod == '') {

                        if ($shareVal['amount'] != '0') {
                            $this->request->data['User']['id'] = $userid;
                            $this->request->data['User']['credit_points'] = $creditPoints + $shareVal['amount'];
                            $this->User->save($this->request->data['User']);
                        } else {
                            $shareNewData[] = $shareVal;
                        }
                    } else {

                        $shareNewData[] = $shareVal;
                    }
                } else {


                    $shareNewData[] = $shareVal;
                }
                } 
                $this->request->data['User']['id'] = $userid;
                $this->request->data['User']['share_status'] = json_encode($shareNewData);
                $this->User->save($this->request->data['User']);
            }
        }


    public function conversion()
    {
      $this->autoLayout = false;
      $this->autoRender = false;
      $itemconvertvalue=$_POST['from'];
      $sessionconvertvalue=$_POST['to'];
      $itemprice=$_POST['price'];
      $default_currency_price = $itemprice / $itemconvertvalue;
      $user_currency_price = $default_currency_price * $sessionconvertvalue;
      echo round($user_currency_price,2);
  }

}
