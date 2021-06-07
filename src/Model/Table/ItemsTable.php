<?php
namespace App\Model\Table;
use App\Model\Entity\Items;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ItemsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_items');

        $this->hasMany('Photos')->setForeignKey('item_id');
        $this->hasMany('Shipings')->setForeignKey('item_id');
        $this->belongsTo('Forexrates')->setForeignKey('currencyid');
        $this->belongsTo('Users')->setForeignKey('user_id');
        $this->belongsTo('Shops')->setForeignKey('shop_id');
        $this->hasMany('Logs')->setForeignKey('notification_id');
        $this->hasMany('Itemfavs')->setForeignKey('item_id');
        $this->hasMany('Comments')->setForeignKey('item_id');
        $this->hasMany('Shareproducts')->setForeignKey('item_id');
        //belongs to
        $this->belongsTo('Users')->setForeignKey('user_id');
        $this->belongsTo('Shops')->setForeignKey('shop_id');
        $this->belongsTo('Forexrates')->setForeignKey('currencyid');

    }

    public function getcurrency($currencyid)
    {
    	//return
        $this->addBehavior('Timestamp');
 $this->belongsTo('Forexrates')->setForeignKey('currencyid');


    }


}
?>
