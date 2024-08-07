<script lang="ts">
    export let label: string;
    export let value: string;
    export let group: any;

    let id = label.replace(/\s+/g, '').replace(/^\w/, (c) => c.toLowerCase());
</script>

<div class="ht-radio-button">
    <input type="radio" id={id} value={value} bind:group={group} />
    <label for={id}>{label}</label>
</div>

<style>
    .ht-radio-button {
        margin-bottom: 8px;
    }
    label {
        vertical-align:top;
    }
</style>