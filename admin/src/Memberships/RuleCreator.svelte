<script lang="ts">
    import { createEventDispatcher } from "svelte";
    import SplitControl from "../@components/SplitControl.svelte";
    import {
        options,
        type GatedContentRule,
        type SelectedPages,
    } from "../store";
    import SelectPageType from "../@components/SelectPageType/SelectPageType.svelte";
    import { updateOption } from "../actions";
    import Notice from "../@components/Notice.svelte";

    export let rule: GatedContentRule | undefined = undefined;
    export let index = 0; // for updating

    const disptach = createEventDispatcher();

    let minimumPlan = rule?.minimum_plan ?? "";
    let postTypes = rule?.post_types ?? null;
    let gate = rule?.gate ?? "";
    let showExcerpt = rule?.show_excerpt ?? false;

    function cancel() {
        disptach("cancel");
    }

    let loading = false;
    let error = "";

    function validate() {
        if (!minimumPlan) {
            error = "Minimum plan is required.";
            return false;
        }

        if (postTypes && postTypes.types.length === 0) {
            error = "Post types are required.";
            return false;
        }

        return true;
    }

    function create() {
        error = "";
        if (!validate()) {
            return;
        }

        loading = true;

        let newRules = [];
        if (rule) {
            newRules = $options.memberships_gated_content_rules.map((r, i) =>
                i === index
                    ? {
                          minimum_plan: minimumPlan,
                          post_types: postTypes,
                          gate,
                          show_excerpt: showExcerpt,
                      }
                    : r,
            );
        } else {
            newRules = [
                ...$options.memberships_gated_content_rules,
                {
                    minimum_plan: minimumPlan,
                    post_types: postTypes,
                    gate,
                    show_excerpt: showExcerpt,
                },
            ];
        }

        updateOption(
            "memberships_gated_content_rules",
            newRules,
            () => {
                loading = false;
                disptach("cancel");
            },
            () => {
                loading = false;
            },
        );
    }

    function onPostTypesChange(e: CustomEvent<SelectedPages>) {
        postTypes = e.detail;
    }
</script>

<div class="ht-rule-creator" class:loading>
    <div class="ht-content">
        <SplitControl
            label="Post Types"
            caption="Select the post types to apply the rule."
        >
            <SelectPageType
                name="rule-post-types"
                config={postTypes}
                on:change={onPostTypesChange}
            />
        </SplitControl>
        <SplitControl
            label="Minimum Plan"
            caption="Users who have at least this plan can view the content."
        >
            <input type="text" bind:value={minimumPlan} placeholder="Premium" />

            <p>
                Enter the name of the plan you have configured in Hyvor Talk.
                <a
                    href="https://talk.hyvor.com/console/{$options.website_id}/settings/memberships"
                    target="_blank"
                >
                    Configure Plans
                </a>
            </p>
        </SplitControl>

        <SplitControl
            label="Gate"
            caption="The content to display when a user does not have the required plan."
        >
            <textarea bind:value={gate} rows={5} />
            <p>
                Enter a pre-configured gate name or custom HTML. Keep empty to
                show the default gate.
            </p>
        </SplitControl>

        <SplitControl
            label="Show Excerpt"
            caption="Show an excerpt of the content when possible."
        >
            <input type="checkbox" bind:checked={showExcerpt} />
        </SplitControl>
    </div>

    {#if error}
        <Notice type="error">{error}</Notice>
    {/if}

    <div class="ht-footer">
        <button class="button button-secondary" on:click={cancel}>Cancel</button
        >
        <button class="button button-primary" on:click={create}>
            {rule ? "Update Rule" : "Create Rule"}
        </button>
    </div>
</div>

<style>
    .ht-rule-creator {
        padding: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 1rem;
    }
    .ht-rule-creator.loading {
        opacity: 0.5;
        pointer-events: none;
    }
    .ht-footer {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
        gap: 6px;
    }
    input[type="text"],
    textarea {
        width: 100%;
    }
</style>
