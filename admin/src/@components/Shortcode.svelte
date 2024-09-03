<script lang="ts">
    import { fade } from "svelte/transition";
    import IconBoxArrowUpRight from "../@icons/IconBoxArrowUpRight.svelte";
    import IconCopy from "../@icons/IconCopy.svelte";
    import IconButton from "./IconButton.svelte";

    export let title: string;
    export let code: string;
    export let href: string;

    let copied = false;

    function copy() {
        navigator.clipboard.writeText(code);
        copied = true;
        setTimeout(() => {
            copied = false;
        }, 2000);
    }
</script>

<div class="ht-shortcode">
    <div class="ht-title">
        {title}
        <a class="ht-docs-link" {href} target="_blank">
            Docs <IconBoxArrowUpRight size={12} />
        </a>
    </div>
    <div>
        <code>{code}</code>
        <IconButton size="small" on:click={copy}>
            <IconCopy size={10} />
        </IconButton>
        {#if copied}
            <span class="ht-copied" transition:fade>Copied!</span>
        {/if}
    </div>
    <div class="ht-description">
        <slot />
    </div>
</div>

<style>
    .ht-shortcode {
        margin-bottom: 25px;
    }
    .ht-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .ht-docs-link {
        font-size: 13px;
        color: var(--ht-link);
        font-weight: normal;
        vertical-align: middle;
    }
    .ht-docs-link :global(svg) {
        margin-bottom: 2px;
    }
    .ht-description {
        font-size: 13px;
    }
    .ht-description :global(ul) {
        list-style: circle;
        margin-left: 25px;
    }
    .ht-copied {
        font-size: 13px;
        color: var(--ht-text-light);
    }
</style>
