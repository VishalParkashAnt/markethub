<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GiftcardsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_giftcards');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
 		$this->belongsTo('Users')->setForeignKey('user_id');
 		$this->belongsTo('Forexrates')->setForeignKey('currencyid');

      
    }
    
  
}
?>
