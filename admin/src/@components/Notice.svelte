<script lang="ts">
    export let type: "info" | "success" | "warning" | "error" = "info";
</script>

<div class="notice notice-{type}">
    <slot></slot>
</div>

<style>
    .notice {
        margin: 10px 0;
        font-size: 13px;
        padding: 10px 15px;
    }
</style>
