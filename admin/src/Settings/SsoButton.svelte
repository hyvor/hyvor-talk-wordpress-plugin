<script lang="ts">
    import Notice from "../@components/Notice.svelte";
    import { setWebsiteConfig } from "../actions";
    import { options } from "../store";

    export let buttonText: string;
    export let loadingText: string;
    export let note: string;
    export let successText: string;

    export let option: "sso_private_key" | "encryption_key";

    let loading = false;
    let success = false;

    function handleCreateSso() {
        loading = true;
        setWebsiteConfig(
            "sso_enable",
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
                alert("Failed to configure SSO.");
            },
        );
    }
</script>

{#if !$options[option]}
    <div class="ht-wrap">
        <button
            class="button"
            on:click={handleCreateSso}
            disabled={!$options.console_api_key || loading}
        >
            {buttonText}
        </button>

        <div class="ht-note">
            {#if loading}
                {loadingText}
            {:else}
                &larr;
                {#if $options.console_api_key}
                    {note}
                {:else}
                    You need to configure the Console API Key first.
                {/if}
            {/if}
        </div>
    </div>

    {#if success}
        <Notice type="success">{successText}</Notice>
    {/if}
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
