<script lang="ts">
    import Radio from "../Radio.svelte";
    import type { SelectedPages } from "../../store";
    import PageSearch from "./PageSearch.svelte";

    export let config: SelectedPages;

    $: group = !config ? "all" : config.logic;

    function onLogicChange(value: "all" | "include" | "exclude") {
        if (value === "all") {
            config = null;
        } else {
            config = {
                logic: value,
                types: [],
            };
        }
    }
</script>

<div class="ht-wrap">
    <Radio
        name="page-type"
        label="All Pages"
        value="all"
        {group}
        on:change={() => onLogicChange("all")}
    />
    <Radio
        name="page-type"
        label="Only on selected pages"
        value="include"
        {group}
        on:change={() => onLogicChange("include")}
    />
    {#if config && config.logic === "include"}
        <PageSearch bind:types={config.types} />
    {/if}
    <Radio
        name="page-type"
        label="On all pages except selected pages"
        value="exclude"
        {group}
        on:change={() => onLogicChange("exclude")}
    />
</div>
