<script lang="ts">
    export let name: string;
    export let label: string;
    export let value: string;
    export let group: any;

    let id = label.replace(/\s+/g, "").replace(/^\w/, (c) => c.toLowerCase());
</script>

<div class="ht-radio-button">
    <input {name} type="radio" {id} {value} bind:group on:change />
    <label for={id}>{label}</label>
</div>

<style>
    .ht-radio-button {
        margin-bottom: 8px;
    }
    label {
        vertical-align: top;
    }
</style>
