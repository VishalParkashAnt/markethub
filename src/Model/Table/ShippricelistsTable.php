<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShippricelistsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_shippricelists');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }


}
?>
