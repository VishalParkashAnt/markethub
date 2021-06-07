<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GroupgiftuserdetailsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_groupgiftuserdetails');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
$this->belongsTo('Items')->setForeignKey('item_id');


      
    }
    
  
}
?>
