<script lang="ts">
    import {
        getPostType,
        getPostTypeName,
    } from "../@components/SelectPageType/pageSearch";
    import { updateOption } from "../actions";
    import { options, type GatedContentRule } from "../store";
    import RuleCreator from "./RuleCreator.svelte";

    export let rule: GatedContentRule;
    export let index: number;

    let editing = false;
    let deleting = false;

    function onDelete() {
        if (!confirm("Are you sure you want to delete this rule?")) {
            return;
        }

        deleting = true;

        const newRules = $options.memberships_gated_content_rules.filter(
            (r, i) => i !== index,
        );

        updateOption(
            "memberships_gated_content_rules",
            newRules,
            () => {
                deleting = false;
            },
            () => {
                deleting = false;
            },
        );
    }
</script>

{#if editing}
    <RuleCreator {rule} {index} on:cancel={() => (editing = false)} />
{:else}
    <div class="ht-rule">
        <div class="ht-minimum-plan">
            <div class="ht-value">
                {#if !rule.post_types}
                    All posts
                {:else}
                    <span class="ht-tags">
                        {#each rule.post_types.types as type}
                            <span class="ht-tag">
                                <span class="ht-type-name"
                                    >{getPostTypeName(type)}</span
                                >
                                <span class="ht-post"
                                    >({getPostType(type)})</span
                                >
                            </span>
                        {/each}
                    </span>
                {/if}
            </div>
            <div class="ht-desc">Posts</div>
        </div>

        <div class="ht-minimum-plan">
            <div class="ht-value">
                {rule.minimum_plan}
            </div>
            <div class="ht-desc">Minimum Plan</div>
        </div>

        <div class="ht-gate">
            <div class="ht-value">
                {#if rule.gate}
                    {rule.gate.substring(0, 20)}
                {:else}
                    Default gate
                {/if}
            </div>
            <div class="ht-desc">Gate</div>
        </div>

        <div class="ht-actions">
            <button class="button" on:click={() => (editing = true)}
                >Edit</button
            >
            <button class="button button-danger" on:click={onDelete}
                >Delete</button
            >
        </div>
    </div>
{/if}

<style>
    .ht-rule {
        margin: 10px 0;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .ht-minimum-plan {
        flex: 1;
    }
    .ht-tags {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 4px;
    }
    .ht-tag {
        display: inline-flex;
        background-color: var(--ht-input);
        border-radius: 5px;
        padding: 2px 8px;
        font-size: 14px;
        border: 1px solid #ccc;
    }
    .ht-post {
        margin-left: 3px;
    }
    .ht-gate {
        flex: 1;
    }
    .button-danger {
        color: var(--ht-red);
        border-color: var(--ht-red);
    }
    .ht-desc {
        font-size: 13px;
        color: var(--ht-text-light);
    }
</style>
