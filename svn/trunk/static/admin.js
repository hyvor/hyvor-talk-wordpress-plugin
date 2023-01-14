/*
	The Javascript handler for 
*/

var hyvorTalk = (function($) {

	/*
		These variables are set at HyvorTalk\Admin -> addScripts()
	*/
	var options = talkAdminOptions,
		ajaxURL = options.ajaxURL,
		nonce = options.nonce; // for security checking

	function saveSettings() {

		var data = {};

		var websiteID = $("#talk-website-id-input").val();
		if (websiteID) 
			data.websiteId = websiteID;

		var loadingModeSelect = document.getElementById("ht-loading-mode-select"),
			loadingMode = loadingModeSelect ?  loadingModeSelect.options[ loadingModeSelect.selectedIndex ].value : null;

		if (loadingMode)
			data.loadingMode = loadingMode;

		// sso
		var ssoId = $.trim($("#talk-sso-id-input").val());
		data.ssoId = ssoId;
		var ssoPrivateKey = $.trim($("#talk-sso-private-key-input").val());
		data.ssoPrivateKey = ssoPrivateKey;

		var v3Input = $("#talk-v3-input")[0];
		var isV3 = v3Input ? v3Input.checked : false;
		data.isV3 = isV3;

		// nothing to update
		if (data === {})
			return;

		data.time = new Date().getTime();

		data.action = 'save_settings';
		data.security = nonce;

		$.ajax({
			url: ajaxURL,
			method: "POST",
			data: data,
			success: function(json) {
				if (json && json.status === true)
					location.reload();
			}
		})

	}

	return {
		saveSettings: saveSettings
	}

})( jQuery );