<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShippingaddressesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_shippingaddresses');
       
        $this->primaryKey('shippingid');

        $this->addBehavior('Timestamp');
 
      
    }
    
  
}
?>
