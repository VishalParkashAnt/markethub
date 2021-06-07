<?php
namespace App\Model\Table;
use App\Model\Entity\Invoiceorders;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class InvoiceordersTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_invoiceorders');

        $this->primaryKey('invoiceid');

        $this->addBehavior('Timestamp');




    }

  public function validationDefault(Validator $validator) {

$validator = new Validator();

        $validator
    ->requirePresence('email')
    ->notEmpty('email', 'You need to give E-mail.')
    ->add('email', 'validFormat', [
        'rule' => 'email',
        'message' => 'E-mail must be valid.'
    ])

    ->requirePresence('password')
    ->notEmpty('password', 'You need to give a password.');
return $validator;

}
}
?>
