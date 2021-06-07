<?php
namespace App\Model\Table;
use App\Model\Entity\Photos;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShipingsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_shipings');

          $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }


}
?>
