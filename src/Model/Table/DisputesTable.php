<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DisputesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_disputes');

        $this->primaryKey('disid');

        $this->addBehavior('Timestamp');
$this->belongsTo('Orders')->setForeignKey('uorderid');


    }




}
?>
