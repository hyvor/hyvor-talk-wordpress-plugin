<script lang="ts">
    export let size: "medium" | "small" | number = "medium";

    if (size === "medium") {
        size = 30;
    } else if (size === "small") {
        size = 26;
    }
</script>

<button class="ht-icon-button" style="width:{size}px;height:{size}px" on:click>
    <slot />
</button>

<style>
    .ht-icon-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: var(--ht-input);
        border-radius: 50%;
    }
    .ht-icon-button:hover {
        cursor: pointer;
    }
    .ht-icon-button:active {
        outline: 1px solid var(--ht-link);
    }
</style>
