<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommentsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_comments');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
 		$this->belongsTo('Users')->setForeignKey('user_id');
 		$this->belongsTo('Items')->setForeignKey('item_id');

    }


}
?>
