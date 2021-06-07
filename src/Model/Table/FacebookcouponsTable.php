<?php
namespace App\Model\Table;
use App\Model\Entity\Coupons;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class FacebookcouponsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_facebookcoupons');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
 
      
    }
    
  
}
?>
