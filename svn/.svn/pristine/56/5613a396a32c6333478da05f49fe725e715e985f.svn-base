<?php
/**
 * 
 *
 * @link       https://talk.hyvor.com
 * @since      1.0
 *
 * @package    HyvorTalk
 * @subpackage HyvorTalk/html
 */

$webpage = new HyvorTalk\WebPage(null, null, HYVOR_TALK_WEBSITE_ID);
$webpage -> setEmbedVariables();
$var = $webpage -> embedVariables;
?>

<div class="comments-area">

	<?php if ($var['loadMode'] === "click") : ?>

		<div style="text-align:center">
			<button id="hyvor-talk-load-button">
				Load Comments
			</button>
		</div>

	<?php endif; ?>

	<div id="hyvor-talk-view"></div>
</div>
<script type="text/javascript">
	var HYVOR_TALK_WEBSITE = <?= $var['websiteId'] ?>; // DO NOT CHANGE THIS
	var HYVOR_TALK_CONFIG = {
		url: "<?= $var['url'] ?>", // THE CANONICAL URL OF THE WEBPAGE
		id: "<?= $var['identifier'] ?>", // UNIQUE ID TO IDENTIFY THE PAGE
		title: "<?= $var['title'] ?>",
		loadMode: "<?= $var['loadMode'] ?>",
		clickId: "hyvor-talk-load-button"
	};
</script>
<script type="text/javascript" src="//talk.hyvor.com/web-api/embed"></script>