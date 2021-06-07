<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FollowersTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_followers');

        $this->primaryKey('id');

        $this->addBehavior('Timestamp');


    }

    public function sellerflwrscnt($userid = null)
    	{
		return $this->find()->select(['totl_flwrscnt' => $this->find()->func()->count('*')])->select(['Followers.user_id','Followers.follow_user_id'])->where(['Followers.user_id'=>$userid])->group('Followers.follow_user_id')->toArray();
	}

	public function sellerfollowcnt($userid = null)
	{
		return $this->find()->where(['follow_user_id'=>$userid])->group('user_id')->all();
	}
	
	public function flwrscnt($userid = null){
		$query = $this->find();
		return $this->find('all')->where(['user_id'=>$userid])->select(['user_id','follow_user_id','totl_flwrscnt'=>$query->func()->count('user_id')])->group(['follow_user_id'])->all();
	}

	public function followcnt($userid = null){
		return $this->find('all')->where(['follow_user_id'=>$userid])->group(['user_id'])->all();
	}

	public function followcntarray($userid = null){
		return $this->find('all')->where(['follow_user_id'=>$userid])->group(['user_id'])->toArray();
	}

	public function flwrscntlimit($userid = null, $offset, $limit){
		return $this->find('all')->where(['user_id'=>$userid])->group(['follow_user_id'])->limit($limit)->page($offset)->all();
	}

	public function followcntlimit($userid = null, $offset, $limit){
		return $this->find('all')->where(['follow_user_id'=>$userid])->group(['user_id'])->limit($limit)->page($offset)->all();
	}

	public function indivflwrscnt($userid = null){
		$query = $this->find();
		return $this->find('all')->where(['user_id'=>$userid])->select(['totl_flwrscnt'=>$query->func()->count('user_id')])->group(['user_id'])->all();
	}
}
?>
