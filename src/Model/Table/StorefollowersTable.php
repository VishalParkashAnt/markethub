<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StorefollowersTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_storefollowers');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }

    public function sellerflwrscnt($shopid = null)
    	{
			return $this->find()->select(['totl_flwrscnt' => $this->find()->func()->count('Storefollowers.store_id')])->select(['Storefollowers.store_id','Storefollowers.follow_user_id'])->where(['Storefollowers.store_id'=>$shopid])->group('Storefollowers.follow_user_id')->toArray();
	}

	public function flwrscnt($shopid = null){
		$query = $this->find();
		return $this->find('all')->where(['Storefollowers.store_id'=>$shopid])->select(['store_id','follow_user_id','totl_flwrscnt'=>$query->func()->count('store_id')])->group(['follow_user_id'])->all();
	}

	public function followcnt($shopid = null){
		return $this->find('all')->where(['follow_user_id'=>$shopid])->group(['store_id'])->all();
	}

	public function flwrscntlimit($shopid = null, $offset, $limit){
		return $this->find('all')->where(['store_id'=>$shopid])->group(['follow_user_id'])->limit($limit)->page($offset)->all();
	}

	public function followcntlimit($shopid = null, $offset, $limit){
		return $this->find('all')->where(['follow_user_id'=>$shopid])->group(['store_id'])->limit($limit)->page($offset)->all();
	}

	public function indivflwrscnt($shopid = null){
		$query = $this->find();
		return $this->find('all')->where(['store_id'=>$shopid])->select(['totl_flwrscnt'=>$query->func()->count('store_id')])->group(['store_id'])->all();
	}


}
?>
