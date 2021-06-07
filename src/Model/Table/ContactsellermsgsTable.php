<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContactsellermsgsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_contactsellermsgs');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }


}
?>
