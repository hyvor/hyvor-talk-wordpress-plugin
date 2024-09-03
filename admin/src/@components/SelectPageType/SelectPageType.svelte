<script lang="ts">
    import Radio from "../Radio.svelte";
    import { type PostType, type SelectedPages } from "../../store";
    import PageSearch from "./PageSearch.svelte";
    import { createEventDispatcher } from "svelte";

    export let name = "page-type";

    export let config: SelectedPages;
    export let configOriginal: SelectedPages | undefined = undefined;

    $: group = !config ? "all" : config.logic;

    const dispatch = createEventDispatcher<{ change: SelectedPages }>();

    function onLogicChange(value: "all" | "include" | "exclude") {
        if (value === "all") {
            config = null;
        } else {
            config = {
                logic: value,
                types:
                    configOriginal?.logic === value ? configOriginal.types : [],
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
        {name}
        label="All Pages"
        value="all"
        {group}
        on:change={() => onLogicChange("all")}
    />
    <Radio
        {name}
        label="Only on selected pages"
        value="include"
        {group}
        on:change={() => onLogicChange("include")}
    />
    {#if config && config.logic === "include"}
        <PageSearch bind:types={config.types} on:change={onTypesChange} />
    {/if}
    <Radio
        {name}
        label="On all pages except selected pages"
        value="exclude"
        {group}
        on:change={() => onLogicChange("exclude")}
    />
    {#if config && config.logic === "exclude"}
        <PageSearch bind:types={config.types} on:change={onTypesChange} />
    {/if}
</div>
