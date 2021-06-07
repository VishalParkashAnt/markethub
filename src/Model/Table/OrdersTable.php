<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_orders');
       
        $this->primaryKey('orderid');

        $this->addBehavior('Timestamp');
 
       $this->belongsTo('Users')->setForeignKey('merchant_id');
    }
    
  
}
?>
