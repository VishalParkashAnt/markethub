<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TaxesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_taxes');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

      
    }
    
  
}
?>
