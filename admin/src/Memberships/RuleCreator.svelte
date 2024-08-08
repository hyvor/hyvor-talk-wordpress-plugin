<script lang="ts">
    import { createEventDispatcher } from "svelte";
    import SplitControl from "../@components/SplitControl.svelte";
    import { options, type GatedContentRule } from "../store";
    import SelectPageType from "../@components/SelectPageType/SelectPageType.svelte";

    export let rule: GatedContentRule | undefined = undefined;

    const disptach = createEventDispatcher();

    let minimumPlan = rule?.minimum_plan ?? "";
    let postTypes = rule?.post_types ?? null;
    let gate = rule?.gate ?? "";
    let showExcerpt = rule?.show_excerpt ?? false;

    function cancel() {
        disptach("cancel");
    }
</script>

<div class="ht-rule-creator">
    <div class="ht-content">
        <SplitControl label="Minimum Plan">
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
        <SplitControl label="Post Types">
            <SelectPageType name="rule-post-types" config={postTypes} />
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

    <div class="ht-footer">
        <button class="button button-secondary" on:click={cancel}>Cancel</button
        >
        <button class="button button-primary">Create Rule</button>
    </div>
</div>

<style>
    .ht-rule-creator {
        padding: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 1rem;
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
