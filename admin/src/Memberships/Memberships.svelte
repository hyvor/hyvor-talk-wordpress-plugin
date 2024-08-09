<script lang="ts">
    import SplitControl from "../@components/SplitControl.svelte";
    import SelectPageType from "../@components/SelectPageType/SelectPageType.svelte";
    import { options, optionsEditing, type SelectedPages } from "../store";
    import OptionSave from "../@components/OptionSave.svelte";
    import Rules from "./Rules.svelte";
    import Shortcode from "../@components/Shortcode.svelte";

    function onMembershipPagesChange(e: CustomEvent<SelectedPages>) {
        $optionsEditing.memberships_pages = e.detail;
    }

    function validatePages(p: SelectedPages) {
        if (p && p.types.length === 0) {
            return "Please select at least one page type";
        }
        return true;
    }
</script>

<div class="ht-wrap">
    <h3 style="margin-top:0;">Memberships</h3>

    <SplitControl
        label="Enable Memberships"
        caption="Show membership subscription button on your website"
    >
        <input
            type="checkbox"
            bind:checked={$optionsEditing.memberships_enabled}
        />
        <OptionSave key="memberships_enabled" />
    </SplitControl>

    {#if $options.memberships_enabled}
        <SplitControl
            label="Available on"
            caption="On which pages the membership button should be shown"
        >
            <SelectPageType
                config={$optionsEditing.memberships_pages}
                configOriginal={$options.memberships_pages}
                on:change={onMembershipPagesChange}
            />
            <OptionSave key="memberships_pages" validate={validatePages} />
        </SplitControl>

        <hr style="margin: 30px 0;" />

        <Rules />

        <hr style="margin: 30px 0;" />

        <h3>Shortcodes</h3>

        <Shortcode
            title="Gated Content"
            code={`[hyvor-talk-gated-content key="YOUR_KEY"]`}
            href="https://talk.hyvor.com/docs/wordpress#shortcode-gated-content"
        >
            <ul>
                <li>Use this shortcode to display gated content on a page.</li>
                <li>
                    Replace<code>YOUR_KEY</code>
                    with the key of the gated content block.
                </li>
            </ul>
        </Shortcode>
    {/if}
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
</style>
