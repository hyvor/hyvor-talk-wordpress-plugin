<?php
/**
* @var 	$this 	the context of HyvorTalk\Admin 
* This file is required from HyvorTalk\Admin -> createView()
*/

use HyvorTalk\HyvorTalk as HyvorTalk;

$websiteId = $this -> websiteId;
$loadingMode = HyvorTalk::getLoadingMode();
$selectedOption = 'selected="selected"';
?>

<div id="hyvor-talk-admin">

	<div class="wrap">
		<img src="<?= HYVOR_TALK_DIR_URL ?>static/talk-logo.png" width="40" class="talk-title-img">
		<span class="talk-title">Hyvor Talk</span>
	</div>
	
	<div class="wrap">
		<div class="talk-native-panel">
			

			<div class="dual-item">
				
				<div class="dual-item-left">Website ID</div>

				<div class="dual-item-right">

					<input type="text" name="talk-website-id" id="talk-website-id-input" class="input-item" value="<?= $websiteId ? $websiteId : '' ?>">

					<?php if (!$websiteId) : ?>

						<div class="talk-message">
							<strong>Important!</strong> Add your website ID to configure Hyvor Talk with Wordpress. It can be found from the Hyvor Talk console. 
						</div>

						<p class="help">
							<a class="margin-link" href="https://talk.hyvor.com/console/new-website" target="_blank">Create New Website</a>
							<a href="https://talk.hyvor.com/console/general?action=choose-website" target="_blank">Get My Website's ID</a>
						</p>

					<?php else : ?>

						<p class="help">The ID given by Hyvor Talk. 
						<a 
						target="_blank" 
						href="https://talk.hyvor.com/console/account/add-website">Create New Website ID</a></p>

					<?php endif; ?>

					
				</div>
			</div>

			<?php if ($websiteId) : ?>
				<div class="dual-item">
					
					<div class="dual-item-left">Loading Mode</div>

					<div class="dual-item-right">
						<select id="ht-loading-mode-select">
							<option 
								value="default" 
								<?= $loadingMode !== "scroll" && $loadingMode !== "click" ? 
								$selectedOption : '' ?>
							>on load</option>
							<option 
								value="scroll"
								<?= $loadingMode === "scroll" ? $selectedOption : '' ?>
							>on scroll</option>
							<option 
								value="click"
								<?= $loadingMode === "click" ? $selectedOption : '' ?>
							>on button click</option>
						</select>
					</div>
				</div>
			<?php endif; ?>

			<div class="save-button-view">
				<span class="button-filled" onclick="hyvorTalk.saveSettings()"><?= $websiteId ? 'CHANGE' : 'SAVE' ?></span>
			</div>


		</div>

	</div>

</div>