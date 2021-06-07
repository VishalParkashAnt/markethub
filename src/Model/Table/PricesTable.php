<?php
namespace App\Model\Table;
use App\Model\Entity\Photos;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PricesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setPrimaryKey('id');
        
        $this->table('fc_prices');


    }


}
?>
