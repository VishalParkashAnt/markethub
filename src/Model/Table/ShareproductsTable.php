<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShareproductsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_shareproducts');

        $this->primaryKey('id');
        
        $this->belongsTo('Items')->setForeignKey('item_id');


    }
}
?>
