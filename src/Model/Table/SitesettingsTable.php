<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SitesettingsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_sitesettings');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

      
    }

     public function validationDefault(Validator $validator) {
    
$validator = new Validator();
       
        $validator
    ->requirePresence('paypal_id')
    ->notEmpty('paypal_id', 'You need to give E-mail.')
    ->add('paypal_id', 'validFormat', [
        'rule' => 'email',
        'message' => 'E-mail must be valid.'
    ]);
    
    
return $validator;
 
}
    
 
}
?>
