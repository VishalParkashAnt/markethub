<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>

<script type="text/javascript">
	setTimeout(function(){$('.error').fadeOut();}, 5000);
</script>
