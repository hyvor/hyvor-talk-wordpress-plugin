<script>
    import OptionSave from "../@components/OptionSave.svelte";
    import Radio from "../@components/Radio.svelte";
    import SplitControl from "../@components/SplitControl.svelte";
    import { options, optionsEditing } from "../store";

</script>

<div class="ht-wrap">
    <h3 style="margin-top:0;">Comments</h3>

    <SplitControl
        label="Enable Comments"
        caption="Enable or disable Hyvor Talk Comments on your site"
    >
        <input type="checkbox" bind:checked={$optionsEditing.comments_enabled} />
    </SplitControl>
    <OptionSave key="comments_enabled" />

    {#if $options.comments_enabled}
        <SplitControl
            label="Loading Mode"
            caption="When to load the comments in the page"
        >
        <div>
            <Radio label="On Load" value="default" radioGroup={$optionsEditing.loading_mode} />
            <Radio label="On Scroll" value="scroll" radioGroup={$optionsEditing.loading_mode} />
            <Radio label="On Button Click" value="click" radioGroup={$optionsEditing.loading_mode} />
        </div>
        </SplitControl>
        <OptionSave key="loading_mode" />
        
        <SplitControl
            label="Sync Comments"
            caption="Sync comments from Hyvor Talk to WordPress daily"
        >
            <input type="checkbox" value="1" />
        </SplitControl>
    {/if}

    <hr style="margin:20px 0;" />

    <h3>Shortcodes</h3>

    <p>Coming soon...</p>
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
   
    .ht-wrap label {
        vertical-align: unset;
    }
</style>
