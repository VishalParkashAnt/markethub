<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LikedusersTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_likedusers');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }


}
?>
