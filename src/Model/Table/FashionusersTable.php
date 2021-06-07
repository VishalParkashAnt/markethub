<?php
namespace App\Model\Table;
use App\Model\Entity\Shops;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class FashionusersTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_fashionusers');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users')->setForeignKey('user_id');
        $this->belongsTo('Items')->setForeignKey('itemId');
    }


}
?>
