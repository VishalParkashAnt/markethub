<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GroupgiftpayamtsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_groupgiftpayamts');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Users')->setForeignKey('paiduser_id');
        $this->belongsTo('Groupgiftuserdetails')->setForeignKey('ggid');



    }


}
?>
