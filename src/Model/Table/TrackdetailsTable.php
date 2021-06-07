<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TrackdetailsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_trackdetails');
       
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

      
    }
    
  
}
?>
