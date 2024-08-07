<script lang="ts">
    import { tick } from "svelte";
    import { callApi } from "../../api";
    import type { PostType } from "../../store";
    import Loader from "../Loader.svelte";

    export let types: PostType[] = [];

    let searchedTypes: PostType[] = [];

    let search = "";
    let loading = false;
    let timeout: null | ReturnType<typeof setTimeout> = null;

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

    function getPostTypeName(type: PostType) {
        if (type.type === "post_type") {
            return type.post_type;
        } else {
            return type.term;
        }
    }

    function getPostType(type: PostType) {
        if (type.type === "post_type") {
            return "post type";
        } else {
            const taxonomy = type.taxonomy || "";
            const taxonomyName = taxonomy.replace("_", " ");
            return "taxonomy - " + taxonomyName;
        }
    }
</script>

<div class="ht-wrap">
    <div class="ht-search-wrap">
        <input
            type="text"
            placeholder="Search page type"
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
                        <div
                            class="ht-searched-type"
                            class:disabled={includedInCurrent(type)}
                        >
                            <div class="ht-left">
                                {getPostTypeName(type)}
                            </div>
                            <div class="ht-right">
                                {getPostType(type)}
                            </div>
                        </div>
                    {/each}
                {/if}
            </div>
        {/if}
    </div>

    {#each types as type}
        <div>{type.post_type} {type?.term || type?.post_type}</div>
    {/each}
</div>

<style>
    .ht-wrap {
        margin-bottom: 15px;
        margin-left: 25px;
    }
    .ht-search-wrap {
        display: inline-block;
        position: relative;
    }
    .ht-search {
        position: absolute;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        left: 50%;
        top: 100%;
        width: 350px;
        z-index: 100;
        padding: 15px 0;
        max-height: 300px;
        overflow: auto;
        transform: translateX(-50%);
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
</style>
