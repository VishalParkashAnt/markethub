<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!-- div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div -->
<?php
if(!empty($message)){ ?>
<div id="notify-message" class="jq-toast-wrap top-right notify-message">
	<div class="jq-toast-single jq-has-icon jq-icon-info" style="text-align: left;">
		<h2 class="jq-toast-heading"><?= $message ?></h2>
	</div>
</div>
<?php }?>
