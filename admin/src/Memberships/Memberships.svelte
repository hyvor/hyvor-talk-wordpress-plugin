<script>
    import SplitControl from "../@components/SplitControl.svelte";
    import SelectPageType from "../@components/SelectPageType/SelectPageType.svelte";
    import { optionsEditing } from "../store";
    import OptionSave from "../@components/OptionSave.svelte";
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

    <SplitControl
        label="Available on"
        caption="On which pages the membership button should be shown"
    >
        <SelectPageType config={null} />
    </SplitControl>
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
</style>
