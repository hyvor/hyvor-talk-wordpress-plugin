<script lang="ts">
    import Notice from "../@components/Notice.svelte";
    import { setWebsiteConfig } from "../actions";
    import { options } from "../store";

    let loading = false;
    let success = false;

    function handleWebhooks() {
        loading = true;
        setWebsiteConfig(
            "webhooks_enable",
            null,
            () => {
                loading = false;
                success = true;

                setTimeout(() => {
                    success = false;
                }, 5000);
            },
            () => {
                loading = false;
                alert("Failed to configure webhooks.");
            },
        );
    }
</script>

{#if !$options.webhook_secret}
    <div class="ht-wrap">
        <button
            class="button"
            on:click={handleWebhooks}
            disabled={!$options.console_api_key || loading}
        >
            Configure & Enable Webhooks
        </button>

        <div class="ht-note">
            {#if loading}
                Configuring Webhooks...
            {:else}
                &larr;
                {#if $options.console_api_key}
                    Click to automatically configure and enable webhooks using the
                    Console API Key.
                {:else}
                    You need to configure the Console API Key first.
                {/if}
            {/if}
        </div>
    </div>

    {#if success}
        <Notice type="success">Webhooks has been configured and enabled.</Notice>
    {/if}
{:else}
    <div class="ht-wrap">
        <div class="ht-note">
            You can update your webhook and subscribed events <a href="{$options.instance}/console/{$options.website_id}/settings/webhooks" target="_blank">here</a>!
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
