<script lang="ts">
    import Notice from "../@components/Notice.svelte";
    import SplitControl from "../@components/SplitControl.svelte";
    import { options, optionsEditing } from "../store";
    import OptionSave from "../@components/OptionSave.svelte";
    import SsoButton from "./SsoButton.svelte";
    import WebhookButton from "./WebhookButton.svelte";

    let advanced = false;

    function getTimestamp($timestamp: number) {
        return new Date($timestamp * 1000).toLocaleString();
    }
</script>

<div class="ht-settings-wrap">
    <h3 style="margin-top:0;">Welcome to Hyvor Talk!</h3>

    <SplitControl label="Website ID" caption="Your Hyvor Talk Website ID">
        <input type="text" bind:value={$optionsEditing.website_id} />
        <OptionSave key="website_id" />

        {#if !$options.website_id}
            <Notice
                >Enter your Hyvor Talk Website ID to get started.
                <a href="https://talk.hyvor.com/console" target="_blank">
                    Get Website ID
                </a>
            </Notice>
        {/if}
    </SplitControl>

    <SplitControl
        label="Console API Key"
        caption="To communicate with Hyvor Talk servers. Required for admin features"
        disabled={!$options.website_id}
    >
        <input
            type="password"
            name="hyvor-talk-console-api-key"
            bind:value={$optionsEditing.console_api_key}
        />
        <OptionSave key="console_api_key" />

        {#if $options.website_id && !$options.console_api_key}
            <Notice>
                Enter your Console API Key to enable admin features.
                <a
                    href="https://talk.hyvor.com/console/{$options.website_id}/settings/api"
                    target="_blank"
                >
                    Get Console API Key
                </a>
            </Notice>
        {/if}
    </SplitControl>

    <SplitControl
        label="SSO Private Key"
        caption="Connect WordPress authentication with Hyvor Talk. Users will be able to login with their WordPress accounts."
        disabled={!$options.website_id}
    >
        <input
            type="password"
            name="hyvor-talk-private-key"
            bind:value={$optionsEditing.sso_private_key}
        />
        <OptionSave key="sso_private_key" />
        <SsoButton
            buttonText="Configure & Enable SSO"
            loadingText="Configuring SSO..."
            note="Click to automatically configure and enable SSO using the Console API Key."
            successText="SSO has been configured and enabled."
            option="sso_private_key"
        />
    </SplitControl>

    <SplitControl
        label="Encryption Key"
        caption="Required for the gated content feature"
        disabled={!$options.website_id}
    >
        <input
            type="password"
            name="hyvor-talk-encryption-key"
            bind:value={$optionsEditing.encryption_key}
        />
        <OptionSave key="encryption_key" />
    </SplitControl>

    <SplitControl
        label="Webhook Secret"
        caption="Required to configure webhooks (For developers)"
        disabled={!$options.website_id}
    >
        <input
            type="password"
            name="hyvor-talk-webhook-secret"
            bind:value={$optionsEditing.webhook_secret}
        />
        <OptionSave key="webhook_secret" />
        <WebhookButton />
        {#if $options.last_webhook_delivered_at}
            <div class="ht-note">
                Last webhook delivered at: {getTimestamp($options.last_webhook_delivered_at)}
            </div>
        {/if}
    </SplitControl>

    <div class="ht-advanced">
        <button on:click={() => (advanced = !advanced)}>
            {advanced ? "Hide" : "Show"} Advanced Settings
        </button>
        {#if advanced}
            <SplitControl
                label="Hyvor Talk Instance"
                caption="If you are self-hosting HYVOR, set this to the Hyvor Talk URL"
            >
                <input
                    type="text"
                    name="hyvor-talk-instance"
                    placeholder="https://talk.hyvor.example.org"
                    bind:value={$optionsEditing.instance}
                />
                <OptionSave key="instance" />
            </SplitControl>
        {/if}
    </div>
</div>

<style>
    .ht-settings-wrap {
        padding: 35px;
    }
    input[type="text"],
    input[type="password"] {
        display: block;
        width: 100%;
    }
    .ht-advanced {
        margin-top: 10px;
    }
    .ht-advanced button {
        font-size: 14px;
        color: var(--ht-link);
        text-decoration: underline;
    }
    .ht-note {
        margin-top: 6px;
        font-size: 13px;
        color: var(--ht-text-light);
    }
</style>
