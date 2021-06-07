<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TempaddressesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_tempaddresses');

        $this->primaryKey('shippingid');

        $this->addBehavior('Timestamp');


    }


}
?>
