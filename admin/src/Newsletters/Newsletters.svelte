<script>
    import Shortcode from "../@components/Shortcode.svelte";
    import SplitControl from "../@components/SplitControl.svelte";
</script>

<div class="ht-wrap">
    <h3 style="margin-top:0;">Newsletter</h3>

    <SplitControl
        label="Auto-subsribe on signup"
        caption="Subscribe users to the newsletter when they sign up"
    >
        <input type="checkbox" value="1" />
    </SplitControl>

    <SplitControl
        label="Auto-subsribe on comment"
        caption="Subscribe users to the newsletter when they comment"
    >
        <input type="checkbox" value="1" />
        <p>
            This option is only for the WordPress comments. For Hyvor Talk
            comments, visit Settings &rarr; Newsletter in the Hyvor Talk
            Console.
        </p>
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
