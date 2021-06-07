<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div>
<script type="text/javascript">
	setTimeout(function(){$('.success').fadeOut();}, 5000);
</script>
