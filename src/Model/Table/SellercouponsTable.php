<?php
namespace App\Model\Table;
//use App\Model\Entity\Sellercoupons;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SellercouponsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fc_sellercoupons');
       
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
 	  
        $this->belongsTo('Items')
            ->setForeignKey('sourceid')
            ->setJoinType('INNER');

        $this->belongsTo('Categories')
            ->setForeignKey('sourceid')
            ->setJoinType('INNER');
            
 		/*$this->belongsTo('Countries', [
		    'className' => 'country',
		    'foreignKey' => 'countryid',
		    'order'      => 'Countries.country asc'
		    
		]);*/
      
    }
    
  
}
?>
