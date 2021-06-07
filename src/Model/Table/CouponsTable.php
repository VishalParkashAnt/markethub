<?php
namespace App\Model\Table;
use App\Model\Entity\Coupons;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CouponsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_coupons');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
 
      
    }
    
  
}
?>
