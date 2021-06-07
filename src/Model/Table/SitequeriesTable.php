<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SitequeriesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_sitequeries');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }



}
?>
