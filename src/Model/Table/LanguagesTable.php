<?php
namespace App\Model\Table;
use App\Model\Entity\Languages;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LanguagesTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fc_languages');
       
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
  $this->belongsTo('Countries')->setForeignKey('countryid');
      
    }
    
  
}
?>
