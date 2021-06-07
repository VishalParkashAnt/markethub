<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LogcouponsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_logcoupons');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
 
      
    }
    
  
}
?>
