<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductfaqTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_productfaq');
		$this->primaryKey('id');
		$this->belongsTo('Users')->setForeignKey('user_id');
        $this->addBehavior('Timestamp');


    }


}
?>
