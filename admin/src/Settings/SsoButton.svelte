<script lang="ts">
    import { setWebsiteConfig } from "../actions";
    import { options } from "../store";

    function handleCreateSso() {
        //
        setWebsiteConfig("sso_enable", null, () => {});
    }
</script>

{#if !$options.sso_private_key}
    <div class="ht-wrap">
        <button
            class="button"
            on:click={handleCreateSso}
            disabled={!$options.console_api_key}
        >
            Configure SSO Automatically
        </button>

        <div class="ht-note">
            &larr;
            {#if $options.console_api_key}
                Click to automatically configure SSO using the Console API Key.
            {:else}
                You need to configure the Console API Key first.
            {/if}
        </div>
    </div>
{/if}

<style>
    .ht-wrap {
        margin-top: 10px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .ht-note {
        margin-top: 6px;
        font-size: 13px;
        color: var(--ht-text-light);
    }
</style>
