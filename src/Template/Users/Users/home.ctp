<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
if($_SESSION['Auth']['User']['id']=='')
{
echo 'invalid';
}
else
{
echo 'Welcome 	'. $user[0];
?>
<a href="<?php echo $baseurl;?>logout">LOGOUT</a>
<?php //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
}
