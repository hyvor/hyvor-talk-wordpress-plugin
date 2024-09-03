<script lang="ts">
    import { createEventDispatcher, tick } from "svelte";
    import { callApi } from "../../api";
    import type { PostType } from "../../store";
    import Loader from "../Loader.svelte";
    import { getPostType, getPostTypeName } from "./pageSearch";

    export let types: PostType[] = [];

    let searchedTypes: PostType[] = [];

    let search = "";
    let loading = false;
    let timeout: null | ReturnType<typeof setTimeout> = null;

    const dispatch = createEventDispatcher<{ change: PostType[] }>();

    async function onInput() {
        await tick();
        loading = true;

        if (timeout) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => {
            if (search.trim() === "") {
                searchedTypes = [];
                loading = false;
                return;
            }

            callApi(
                "GET",
                "/post-taxonomy-search",
                {
                    search,
                },
                (response) => {
                    searchedTypes = response;
                    loading = false;
                },
                (err) => {
                    alert(err.message);
                    loading = false;
                },
            );
        }, 250);
    }

    function includedInCurrent(type: PostType) {
        return types.some((t) => {
            if (t.type === "post_type") {
                return t.post_type === type.post_type;
            } else {
                return t.taxonomy === type.taxonomy && t.term === type.term;
            }
        });
    }

    function dispatchChange() {
        dispatch("change", types);
    }

    function onSearchTypeClick(type: PostType) {
        if (includedInCurrent(type)) {
            return;
        }
        types = [...types, type];
        searchedTypes = [];
        search = "";
        dispatchChange();
    }

    function onRemoveType(type: PostType) {
        types = types.filter((t) => {
            if (t.type === "post_type") {
                return t.post_type !== type.post_type;
            } else {
                return t.taxonomy !== type.taxonomy || t.term !== type.term;
            }
        });
        dispatchChange();
    }
</script>

<div class="ht-wrap">
    <div class="ht-search-wrap">
        <input
            type="text"
            placeholder="Search post type or taxonomy (e.g. post, category)"
            on:input={onInput}
            bind:value={search}
        />

        {#if search}
            <div class="ht-search">
                {#if loading}
                    <Loader block padding={15} size="small" />
                {:else}
                    {#if searchedTypes.length === 0}
                        <div class="ht-no-results">No results found</div>
                    {/if}

                    {#each searchedTypes as type}
                        <button
                            class="ht-searched-type"
                            class:disabled={includedInCurrent(type)}
                            on:click={() => onSearchTypeClick(type)}
                        >
                            <div class="ht-left">
                                {getPostTypeName(type)}
                            </div>
                            <div class="ht-right">
                                {getPostType(type)}
                            </div>
                        </button>
                    {/each}
                {/if}
            </div>
        {/if}
    </div>

    {#if types.length}
        <div class="ht-selected-types">
            {#each types as type}
                <span class="ht-tag">
                    <span class="ht-type-name">{getPostTypeName(type)}</span>
                    <span class="ht-post">({getPostType(type)})</span>
                    <button
                        class="ht-remove"
                        on:click={() => onRemoveType(type)}
                    >
                        &times;
                    </button>
                </span>
            {/each}
        </div>
    {/if}
</div>

<style>
    .ht-wrap {
        margin-bottom: 15px;
        margin-left: 25px;
    }
    .ht-search-wrap {
        display: block;
        position: relative;
    }
    input {
        display: block;
        width: 100%;
    }
    .ht-search {
        position: absolute;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        left: 0;
        top: 100%;
        width: 450px;
        z-index: 100;
        padding: 15px 0;
        max-height: 300px;
        overflow: auto;
        margin-top: 5px;
    }
    .ht-no-results {
        color: var(--ht-text-light);
        font-size: 13px;
        text-align: center;
        padding: 4px;
    }
    .ht-searched-type {
        display: flex;
        font-size: 14px;
        padding: 4px 15px;
        cursor: pointer;
        width: 100%;
        text-align: left;
    }
    .ht-searched-type:hover {
        background-color: var(--ht-hover);
    }
    .ht-searched-type.disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .ht-left {
        flex: 1;
    }
    .ht-right {
        font-size: 13px;
        color: var(--ht-text-light);
    }
    .ht-selected-types {
        margin-top: 5px;
        display: flex;
        gap: 5px;
    }
    .ht-selected-types .ht-tag {
        display: inline-flex;
        background-color: var(--ht-input);
        border-radius: 5px;
        padding: 2px 8px;
    }
    .ht-selected-types .ht-post {
        color: var(--ht-text-light);
        font-size: 13px;
        margin-left: 5px;
    }
    .ht-remove {
        margin-left: 5px;
    }
</style>
