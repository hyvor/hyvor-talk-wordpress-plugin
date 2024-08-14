<script lang="ts">
    export let href: string | undefined = undefined;
    export let active = false;
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-static-element-interactions -->
<!-- svelte-ignore a11y-missing-attribute -->
<a on:click class:active {href} target="_blank">
    <span class="ht-start">
        <slot name="start" />
    </span>
    <slot />
</a>

<style>
    a {
        color: inherit;
        display: flex;
        padding: 12px 29px;
        font-size: 14px;
        letter-spacing: 0.3px;
        border-left: 3px solid transparent;
        cursor: pointer;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    a:hover {
        background-color: var(--ht-hover);
    }
    a.active {
        background-color: var(--ht-accent-lightest);
        border-left-color: var(--ht-accent);
    }
    .ht-start {
        display: inline-flex;
        align-items: center;
    }
</style>
