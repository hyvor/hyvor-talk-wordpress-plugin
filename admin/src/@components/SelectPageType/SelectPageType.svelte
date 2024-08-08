<script lang="ts">
    import Radio from "../Radio.svelte";
    import { options, type PostType, type SelectedPages } from "../../store";
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
                types:
                    $options.memberships_pages?.logic === value
                        ? $options.memberships_pages.types
                        : [],
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
    {#if config && config.logic === "exclude"}
        <PageSearch bind:types={config.types} on:change={onTypesChange} />
    {/if}
</div>
