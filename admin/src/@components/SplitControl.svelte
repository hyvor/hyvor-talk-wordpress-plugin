<script lang="ts">
    export let label: string;
    export let caption: string | undefined = undefined;
</script>

<div class="ht-split-control">
    <div class="ht-split-control-left">
        <div class="ht-label">{label}</div>
        {#if caption}
            <div class="ht-caption">{caption}</div>
        {/if}
    </div>

    <div class="ht-split-control-right">
        <slot />
    </div>
</div>

<style>
    .ht-split-control {
        padding: 15px 0;
        display: flex;
    }
    .ht-split-control-left {
        flex: 1;
    }
    .ht-split-control-right {
        flex: 2;
    }
    .ht-label {
        font-weight: 600;
    }
    .ht-caption {
        font-size: 14px;
        color: var(--ht-text-light);
        margin-top: 3px;
    }
</style>
