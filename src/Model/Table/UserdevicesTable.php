<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserdevicesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_userdevices');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }


}
?>
