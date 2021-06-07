<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!-- div class="<?= h($class) ?>" onclick="this.classList.add('hidden');"><?= $message ?></div -->

<div id="notify-message" class="jq-toast-wrap top-right <?= h($class) ?>">
	<div class="jq-toast-single jq-has-icon jq-icon-error" style="text-align: left;">
		<h2 class="jq-toast-heading"><?= $message ?></h2>
	</div>
</div>
