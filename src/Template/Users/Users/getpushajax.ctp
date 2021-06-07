<?php
use Cake\Routing\Router;
$baseurl = Router::url('/');
echo $this->element('numberconversion');
if(count($userlogd) > 0) {
    echo '<li class="dd-heading bold-font">';
    echo __d('user', 'Notifications');
    echo ':</li>';
    $i      = 0;
    $keyses = 0;
    foreach($userlogd as $key => $logg) {
        $notifyto       = $logg['notifyto'];
        $type           = $logg['type'];
        $images         = json_decode($logg['image'], true);
        $notifymsg      = explode("-___-", $logg['notifymessage']);
        $message_header = strip_tags($notifymsg[0]);
        $message_body   = strip_tags($notifymsg[1]);
        $message_footer = strip_tags($notifymsg[2]);
        $notifytitle    = "";
        $logTime        = txt_time_diff($logg['cdate']);
        foreach($notifymsg as $msg) {
            $notifytitle .= $msg;
        }
        $message = $logg['message'];
        if($notifyto != 0) {
            $itemimages = $images['item']['image'];
            $userimages = $images['user']['image'];
            if($itemimages == "") {
                $itemimages = "usrimg.jpg";
            }
            if($userimages == "") {
                $userimages = "usrimg.jpg";
            }
            echo '<li style="font-size: 13px;" class="custom_notification">
            <a href="'.SITE_URL.'push_notifications">
            <span class="profile">
            <div class="profile-circle">
            <img src="' . SITE_URL . 'media/avatars/thumb70/' . $userimages . '" style="width:40px;height:40px;">
            </div>
            </span>

            <span class="notification-text"><span>';
            echo __d('user', trim($message_header)) . " " . $message_body . " " . __d('user', trim($message_footer));
            echo '</span><span class="days-counter ">' . $logTime . '</span>
            </span>
            </a>
            </li>';
        } else if($type == 'admin') {

            $userimages = $images['user']['image'];
            if($userimages == "")
                $userimages = "usrimg.jpg";
            // echo '<li style="font-size: 13px;" class="custom_notification">
            // <a href="javascript:void(0)">
            // <span class="profile">
            // <div class="profile-circle">
            // <img src="' . SITE_URL . 'media/avatars/thumb70/' . $userimages . '" style="width:40px;height:40px;">
            // </div>
            // </span>

            // <span class="notification-text"><span>';
            // echo __d('user','Admin') . " " .__d('user', trim($message_header)) . " " . $message_body . " " . __d('user', trim($message_footer));
            // if(!empty($message)) {
            //     echo limit_char($message, 40);
            // }
            // echo '</span><span class="days-counter ">' . $logTime . '</span></span>

            // </a>
            // </li>';
             echo '<li style="font-size: 13px;" class="custom_notification">
             <a href="javascript:void(0)">
            <span class="profile">
            <div class="profile-circle">
            <img src="' . SITE_URL . 'media/avatars/thumb70/' . $userimages . '" style="width:40px;height:40px;">
            </div>
            </span>

            <span class="notification-text"><span style="padding-left:20px;">';
           echo "  ".__d('user','Admin') . " " .__d('user', trim($message_header)) . " " . $message_body . " " . __d('user', trim($message_footer));
            if(!empty($message)) {
                echo limit_char($message, 40);
            }
            echo '</span><span class="days-counter " style="padding-left:20px;">' . $logTime . '</span>
            </span>
            </a>
            </li>';
        } else {
            $userimages = $images['user']['image'];
            if($userimages == "")
                $userimages = "usrimg.jpg";
            // echo '<li style="font-size: 13px;" class="custom_notification">
            // <a href="javascript:void(0)">
            // <span class="profile">
            // <div class="profile-circle">
            // <img src="' . SITE_URL . 'media/avatars/thumb70/' . $userimages . '" style="width:40px;height:40px;">
            // </div>
            // </span>
            // <span class="notification-text"><span>';
            // echo __d('user', trim($message_header)) . " " . $message_body . " " . __d('user', trim($message_footer));
            // echo '</span><span class="days-counter ">' . $logTime . '</span></span>
            // </a>
            // </li>';
             echo '<li style="font-size: 13px;" class="custom_notification">
            <a href="'.SITE_URL.'push_notifications">
            <span class="profile">
            <div class="profile-circle">
            <img src="' . SITE_URL . 'media/avatars/thumb70/' . $userimages . '" style="width:40px;height:40px;">
            </div>
            </span>

            <span class="notification-text"><span>';
            echo __d('user', trim($message_header)) . " " . $message_body . " " . __d('user', trim($message_footer));
            echo '</span><span class="days-counter ">' . $logTime . '</span>
            </span>
            </a>
            </li>';
        }
    }
    echo '<li class="dd-footer top-border">
    <div class="all-notification-text"><a class="centered-text" href="' . SITE_URL . 'push_notifications">' . __d('user', 'See all notifications') . '</a></div>
    </li>';
} else {
    echo '<li class="dd-heading bold-font">Notifications:</li>
    <li class="dd-footer top-border">
    <div class="all-notification-text"><a class="centered-text" href="javascript:void(0);">' . __d('user', 'No notifications') . '</a></div>
    </li>';
}
?>