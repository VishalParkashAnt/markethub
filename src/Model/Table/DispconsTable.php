<?php
namespace App\Model\Table;
use App\Model\Entity\Photos;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DispconsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_dispcons');

        $this->primaryKey('dcid');

        $this->addBehavior('Timestamp');
 
      	$this->belongsTo('Orders')->setForeignKey('uorderid');


    }


}
?>
