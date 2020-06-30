<?php
/**
* @var 	$this 	the context of HyvorTalk\Admin 
* This file is required from HyvorTalk\Admin -> createView()
*/

use HyvorTalk\HyvorTalk as HyvorTalk;

$websiteId = $this -> websiteId;
$loadingMode = HyvorTalk::getLoadingMode();
$ssoId = HyvorTalk::getSSOId();
$ssoPrivateKey = HyvorTalk::getSSOPrivateKey();
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
				
				<div class="dual-item-left"><?= __('Website ID', 'hyvor-talk') ?></div>

				<div class="dual-item-right">

					<input type="text" name="talk-website-id" id="talk-website-id-input" class="input-item" value="<?= $websiteId ? $websiteId : '' ?>">

					<?php if (!$websiteId) : ?>

						<div class="talk-message">
							<strong>
								<?= __('Important!', 'hyvor-takl') ?>
							</strong>
							<?= __('Add your website ID to configure Hyvor Talk with Wordpress. It can be found from the Hyvor Talk console.', 'hyvor-talk') ?> 
						</div>

						<p class="help">
							<a 
								class="margin-link" 
								href="https://talk.hyvor.com/console/account/add-website" target="_blank">
								<?= __('Create New Website', 'hyvor-talk') ?>
							</a>
							<a 
								href="https://talk.hyvor.com/console/moderate/general" 
								target="_blank">
								<?= __('Get My Website ID', 'hyvor-talk') ?>
							</a>
						</p>

					<?php else : ?>

						<p class="help"><?= __('The ID given by Hyvor Talk.') ?>
							<a 
								target="_blank" 
								href="https://talk.hyvor.com/console/account/add-website">
								<?= __('Create New Website ID', 'hyvor-talk') ?>
							</a>
						</p>

					<?php endif; ?>

					
				</div>
			</div>

			<?php if ($websiteId) : ?>
				<div class="dual-item">
					
					<div class="dual-item-left"><?= __('Loading Mode', 'hyvor-talk') ?></div>

					<div class="dual-item-right">
						<select id="ht-loading-mode-select">
							<option 
								value="default" 
								<?= $loadingMode !== "scroll" && $loadingMode !== "click" ? 
								$selectedOption : '' ?>
							><?= __('on load', 'hyvor-talk') ?></option>
							<option 
								value="scroll"
								<?= $loadingMode === "scroll" ? $selectedOption : '' ?>
							><?= __('on scroll', 'hyvor-talk') ?></option>
							<option 
								value="click"
								<?= $loadingMode === "click" ? $selectedOption : '' ?>
							><?= __('on button click', 'hyvor-talk') ?></option>
						</select>
					</div>
				</div>

				<div class="dual-item">
					<div class="dual-item-left"><?= __('Single Sign-On', 'hyvor-talk') ?></div>

					<div class="dual-item-right">
						<input
							placeholder="SSO Private Key"
							type="text" 
							name="talk-sso-private-key" 
							id="talk-sso-private-key-input" 
							class="input-item" 
							value="<?= $ssoPrivateKey ?? '' ?>">

						<p class="help">
							<a target="_blank" href="https://talk.hyvor.com/documentation/sso/introduction"><?= __('Learn more about SSO', 'hyvor-talk') ?></a>
						</p>
					</div>
				</div>


			<?php endif; ?>

			<div class="save-button-view">
				<span 
					class="button-filled" 
					onclick="hyvorTalk.saveSettings()">
					<?= $websiteId ? __('CHANGE', 'hyvor-talk') : __('SAVE', 'hyvor-talk') ?>
				</span>
			</div>


		</div>

	</div>

</div>