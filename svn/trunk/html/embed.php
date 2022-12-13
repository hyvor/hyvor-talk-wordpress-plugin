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

$var = $GLOBALS['HYVOR_TALK_PLUGIN_JS_CONFIG'];

include 'variables.php';
?>
<div class="comments-area">

	<?php if ($var['loadMode'] === "click") : ?>

		<div style="text-align:center">
			<button id="hyvor-talk-load-button">
				<?php echo __('Load Comments') ?>
			</button>
		</div>

	<?php endif; ?>

	<div id="hyvor-talk-view"></div>
</div>
<script async type="text/javascript" src="//talk.hyvor.com/web-api/embed.js"></script>