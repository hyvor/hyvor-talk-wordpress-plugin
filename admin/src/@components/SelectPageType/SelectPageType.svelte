<script lang="ts">
    import Radio from "../Radio.svelte";
    import type { PostType, SelectedPages } from "../../store";
    import PageSearch from "./PageSearch.svelte";
    import { createEventDispatcher } from "svelte";

    export let config: SelectedPages;

    $: group = !config ? "all" : config.logic;

    const dispatch = createEventDispatcher<{ change: SelectedPages }>();

    function onLogicChange(value: "all" | "include" | "exclude") {
        if (value === "all") {
            config = null;
        } else {
            config = {
                logic: value,
                types: [],
            };
        }

        dispatch("change", config);
    }

    function onTypesChange(e: CustomEvent<PostType[]>) {
        if (!config) {
            return;
        }
        config.types = e.detail;

        dispatch("change", config);
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
        <PageSearch bind:types={config.types} on:change={onTypesChange} />
    {/if}
    <Radio
        name="page-type"
        label="On all pages except selected pages"
        value="exclude"
        {group}
        on:change={() => onLogicChange("exclude")}
    />
</div>
