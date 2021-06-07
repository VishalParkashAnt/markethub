<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ItemreviewsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_itemreviews');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Users')->setForeignKey('userid');



    }


}
?>
