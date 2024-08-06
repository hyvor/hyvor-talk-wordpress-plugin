<script lang="ts">
    export let active = false;
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-static-element-interactions -->
<!-- svelte-ignore a11y-missing-attribute -->
<a on:click class:active>
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
    }
    a:hover {
        background-color: var(--ht-hover);
    }
    a.active {
        background-color: var(--ht-accent-lightest);
        border-left-color: var(--ht-accent);
    }
</style>
