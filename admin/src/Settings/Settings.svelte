<script>
    import Notice from "../@components/Notice.svelte";
    import SplitControl from "../@components/SplitControl.svelte";
    import { options, optionsEditing } from "../store";
    import OptionSave from "../@components/OptionSave.svelte";

    let advanced = false;
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
        caption="To connect WordPress users with Hyvor Talk using Single Sign-On"
        disabled={!$options.website_id}
    >
        <input
            type="password"
            name="hyvor-talk-private-key"
            bind:value={$optionsEditing.sso_private_key}
        />
        <OptionSave key="sso_private_key" />

        {#if $options.website_id && !$options.sso_private_key}
            <Notice>
                Enter your SSO Private Key to enable Single Sign-On.
                <a
                    href="https://talk.hyvor.com/console/{$options.website_id}/settings/sso"
                    target="_blank"
                >
                    Get SSO Private Key
                </a>
            </Notice>
        {/if}
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

        {#if $options.website_id && !$options.encryption_key}
            <Notice>
                Enter your Encryption Key to enable the gated content feature.
                <a
                    href="https://talk.hyvor.com/console/{$options.website_id}/settings/api"
                    target="_blank"
                >
                    Get Encryption Key
                </a>
            </Notice>
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
</style>
