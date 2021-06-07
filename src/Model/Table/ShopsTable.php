<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShopsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_shops');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Users')->setForeignKey('user_id');

	//$this->hasOne('Forexrates')->setName('Forexrates')->setConditions(['Forexrates.currency_code = Shops.currency']);


    }

    public function validationDefault(Validator $validator) {
    
        $validator = new Validator();
       
        /*$validator
        ->notEmpty('paypalid')
        ->add('paypalid', 'valid-email', ['rule' => 'email']);*/

        $validator
        ->notEmpty('paypaltype')
        ->notEmpty('braintreeid')
        ->notEmpty('publickey')
        ->notEmpty('privatekey');
   

        return $validator;
 
    }


}
?>
