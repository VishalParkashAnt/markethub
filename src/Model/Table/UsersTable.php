<?php
namespace App\Model\Table;
use App\Model\Entity\Users;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

class UsersTable extends Table
{
 public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('fc_users');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasOne('Shops')->setForeignKey('user_id');
        $this->hasOne('Shops')
               ->setName('Shops')
                ->setConditions(['Users.id = Shops.user_id']);
        $this->hasMany('Itemfavs',['className'=>'Itemfavs'])->setForeignKey('user_id')->setProperty('itemfavs');

    }

  public function validationDefault(Validator $validator) {

    $validator = new Validator();

            $validator
        ->requirePresence('email')
        ->notEmpty('email', 'You need to give E-mail.')
        ->add('email', 'validFormat', [
            'rule' => 'email',
            'message' => 'E-mail must be valid.'
        ]);

        //->requirePresence('password')
        //->notEmpty('password', 'You need to give a password.');
       return $validator;

    }
    public function validationPassword(Validator $validator)
    {
        $validator
                ->add('oldpassword','custom',[
                    'rule' => function($value, $context){
                        $user = $this->get($context['data']['id']);
                        if($user)
                        {
                            if((new DefaultPasswordHasher)->check($value, $user->password))
                            {
                                return true;
                            }
                        }
                        return false;
                    },
                    'message' => 'Your old password does not match the entered password!',
                ])
                ->notEmpty('oldpassword');
        
        $validator
                ->add('newpassword',[
                    'length' => [
                        'rule' => ['minLength',6],
                        'message' => 'Please enter atleast 6 characters in your password.'
                    ]
                ])
                ->add('newpassword',[
                    'match' => [
                        'rule' => ['compareWith','cpassword'],
                        'message' => 'Sorry! Password does not match. Please try again!'
                    ]
                ])
                ->notEmpty('newpassword');
        
        $validator
                ->add('cpassword',[
                    'length' => [
                        'rule' => ['minLength',6],
                        'message' => 'Please enter atleast 6 characters in your password.'
                    ]
                ])
                ->add('cpassword',[
                    'match' => [
                        'rule' => ['compareWith','newpassword'],
                        'message' => 'Sorry! Password does not match. Please try again!'
                    ]
                ])
                ->notEmpty('cpassword');
        
        return $validator;
    }

    public function validationSetpassword(Validator $validator)
    {     
        $validator
                ->add('newpassword',[
                    'length' => [
                        'rule' => ['minLength',6],
                        'message' => 'Please enter atleast 6 characters in your password.'
                    ]
                ])
                ->add('newpassword',[
                    'match' => [
                        'rule' => ['compareWith','cpassword'],
                        'message' => 'Sorry! Password does not match. Please try again!'
                    ]
                ])
                ->notEmpty('newpassword');
        
        $validator
                ->add('cpassword',[
                    'length' => [
                        'rule' => ['minLength',6],
                        'message' => 'Please enter atleast 6 characters in your password.'
                    ]
                ])
                ->add('cpassword',[
                    'match' => [
                        'rule' => ['compareWith','newpassword'],
                        'message' => 'Sorry! Password does not match. Please try again!'
                    ]
                ])
                ->notEmpty('cpassword');
        
        return $validator;
    }


    public function getUser(\Cake\Datasource\EntityInterface $profile) {
        // Make sure here that all the required fields are actually present
        if (empty($profile->email)) {
            throw new \RuntimeException('Could not find email in social profile.');
        }

        // Check if user with same email exists. This avoids creating multiple
        // user accounts for different social identities of same user. You should
        // probably skip this check if your system doesn't enforce unique email
        // per user.

        // Check Existence of facebook profile email
        $user = $this->find()
        ->where(['email' => $profile->email])
        ->first();
        
        //$_SESSION['Auth']=$user;

        if ($user) {
            //Existing Id need any update mention here.

            $_SESSION['SocialAuthUsername'] = 0;
            return $user;
        } else {
            // Create new user account
            $uname = $profile->first_name.$profile->identifier;
            $users = $this->newEntity(['email' => $profile->email, 'first_name' => $profile->first_name,'username' => $uname, 'last_name' => $profile->last_name, 'gender' => $profile->gender, 'activation' => '1', 'user_status' => 'enable', 'login_type' => 'facebook', 'created_at' => date('Y-m-d H:i:s')]);
            $user = $this->save($users);

            // Fetch last saved record id
            $userid = $user->id;

            // Save own generation password
            $autopassword = $userid."~".$profile->email;
            $autopassword = (new DefaultPasswordHasher)->hash($autopassword);

            $connection = ConnectionManager::get('default');
            $connection->update('fc_users', ['password' => $autopassword], ['id' => $userid]);

            $_SESSION['SocialAuthUsername'] = 1;

            if (!$user) {
                throw new \RuntimeException('Unable to save new user');
            }

            return $user;
        }
    }

}
?>
