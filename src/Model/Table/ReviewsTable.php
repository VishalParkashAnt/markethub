<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ReviewsTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_reviews');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Users')->setForeignKey('userid');



    }


}
?>
