<script lang="ts">
    import SplitControl from "../@components/SplitControl.svelte";
    import SelectPageType from "../@components/SelectPageType/SelectPageType.svelte";
    import { optionsEditing, type SelectedPages } from "../store";
    import OptionSave from "../@components/OptionSave.svelte";

    function onMembershipPagesChange(e: CustomEvent<SelectedPages>) {
        $optionsEditing.memberships_pages = e.detail;
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

    {#if $optionsEditing.memberships_enabled}
        <SplitControl
            label="Available on"
            caption="On which pages the membership button should be shown"
        >
            <SelectPageType
                config={$optionsEditing.memberships_pages}
                on:change={onMembershipPagesChange}
            />
            <OptionSave key="memberships_pages" />
        </SplitControl>
    {/if}
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
</style>
