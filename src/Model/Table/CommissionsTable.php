<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\Users;
class CommissionsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_commissions');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

      
    }

     
    
 
}
?>
