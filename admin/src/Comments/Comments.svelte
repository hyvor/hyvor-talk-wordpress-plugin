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
            label="Enable Comment Counts"
            caption="Enable or disable comment counts on your site"
        >
            <input type="checkbox" bind:checked={$optionsEditing.comment_counts_enabled} />
        </SplitControl>
        <OptionSave key="comment_counts_enabled" />

        <SplitControl
            label="Loading Mode"
            caption="When to load the comments in the page"
        >
        <div>
            <Radio label="On Load" value="default" bind:group={$optionsEditing.loading_mode} />
            <Radio label="On Scroll" value="scroll" bind:group={$optionsEditing.loading_mode} />
            <Radio label="On Button Click" value="click" bind:group={$optionsEditing.loading_mode} />
        </div>
        </SplitControl>
        <OptionSave key="loading_mode" />
        

        <SplitControl
            label="Default post-id"
            caption="The default post-id to use when the post-id is not set"
        >                                                                               <!-- double check the caption -->
            <div>
                <Radio label="Post ID" value="post_id" bind:group={$optionsEditing.default_post_id} />
                <Radio label="URL" value="url" bind:group={$optionsEditing.default_post_id} />
                <Radio label="Slug" value="slug" bind:group={$optionsEditing.default_post_id} />
            </div>
        </SplitControl>

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

    <!-- <div class="shortcode">
        <div>
            <code> [hyvor-talk-comments page-id="YOUR_PAGE_ID"] </code>
            <IconButton>
                <IconCopy size={12} />
            </IconButton>
        </div>
        <p>
            Use this shortcode to display the comments embed on a page. Replace <code
                >YOUR_PAGE_ID</code
            >
            with a unique identifier for the page. Each value of
            <code>page-id</code> will have a separate comment thread.
        </p>
    </div> -->
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
   
    .ht-wrap label {
        vertical-align: unset;
    }
</style>
