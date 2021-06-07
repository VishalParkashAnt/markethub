<?php
namespace App\Model\Table;
use App\Model\Entity\Languages;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoriesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fc_categories');
       
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Items')
        ->setForeignKey('category_id');
 
      
    }
    
  
}
?>
