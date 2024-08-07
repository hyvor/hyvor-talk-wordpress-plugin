<script>
    import OptionSave from "../@components/OptionSave.svelte";
    import Radio from "../@components/Radio.svelte";
    import Shortcode from "../@components/Shortcode.svelte";
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

    <p>View docs for more available attributes in the shortcodes.</p>

    <Shortcode
        title="1. Comments"
        code={`[hyvor-talk-comments page-id="YOUR_PAGE_ID"]`}
        href="https://talk.hyvor.com/docs/wordpress#shortcode-comments"
    >
        <ul>
            <li>Use this shortcode to display the comments embed on a page.</li>
            <li>
                Replace<code>YOUR_PAGE_ID</code>
                with a unique identifier for the page.
            </li>
            <li>
                Each value of
                <code>page-id</code> will have a separate comment thread.
            </li>
        </ul>
    </Shortcode>

    <Shortcode
        title="2. Comment Counts"
        code={`[hyvor-talk-comments-count page-id="YOUR_PAGE_ID"]`}
        href="https://talk.hyvor.com/docs/wordpress#shortcode-comment-counts"
    >
        <ul>
            <li>Use this shortcode to display the comment count of a page.</li>
            <li>
                Usually, you can use this shortcode in the loop to display the
                comment count of each post.
            </li>
            <li>
                Replace <code>YOUR_PAGE_ID</code> with the <code>page-id</code>
                of the page. This is the same as the <code>page-id</code> of the
                comments shortcode.
            </li>
        </ul>
    </Shortcode>
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
   
    .ht-wrap label {
        vertical-align: unset;
    }
</style>
