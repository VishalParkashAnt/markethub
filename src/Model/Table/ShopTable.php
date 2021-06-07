<?php
namespace App\Model\Table;
use App\Model\Entity\Shops;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShopTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_shop');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Forexrates')->setForeignKey('currencyid');


    }


}
?>
