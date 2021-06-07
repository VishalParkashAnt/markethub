<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TrackingdetailsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_trackingdetails');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }


}
?>
