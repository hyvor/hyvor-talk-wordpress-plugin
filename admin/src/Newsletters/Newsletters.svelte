<script>
    import Notice from "../@components/Notice.svelte";
    import OptionSave from "../@components/OptionSave.svelte";
    import Shortcode from "../@components/Shortcode.svelte";
    import SplitControl from "../@components/SplitControl.svelte";
    import { options, optionsEditing, section } from "../store";
</script>

<div class="ht-wrap">
    <h3 style="margin-top:0;">Newsletter</h3>

    <SplitControl
        label="Auto-subsribe on signup"
        caption="Subscribe users to the newsletter when they sign up"
    >
        <input
            type="checkbox"
            bind:checked={$optionsEditing.newsletters_auto_subscribe_on_signup}
        />
        <OptionSave key="newsletters_auto_subscribe_on_signup" />

        {#if !$options.console_api_key}
            <Notice type="warning">
                You need to <a
                    href="#console-api-key"
                    on:click={() => ($section = "settings")}
                    >set up the console API key</a
                > to use this feature.
            </Notice>
        {/if}
    </SplitControl>

    <hr style="margin:20px 0;" />

    <h3>Shortcodes</h3>

    <Shortcode
        title="1. Newsletter Form"
        code={`[hyvor-talk-newsletter]`}
        href="https://talk.hyvor.com/docs/wordpress#shortcode-newsletters"
    >
        <p>Use this shortcode to display the newsletter form on a page.</p>
    </Shortcode>
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
</style>
