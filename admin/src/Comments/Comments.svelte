<script>
    import Notice from "../@components/Notice.svelte";
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
        caption="Enable or disable Hyvor Talk Comments on your site. This will replace the default WordPress comments."
    >
        <input
            type="checkbox"
            bind:checked={$optionsEditing.comments_enabled}
        />
        <OptionSave key="comments_enabled" />
    </SplitControl>

    {#if $options.comments_enabled}
        <SplitControl
            label="Enable Comment Counts"
            caption="Enable or disable comment counts on your site (must be supported by the theme)."
        >
            <input
                type="checkbox"
                bind:checked={$optionsEditing.comment_counts_enabled}
            />
            <OptionSave key="comment_counts_enabled" />
        </SplitControl>

        <SplitControl
            label="Loading Mode"
            caption="When to load the comments in the page"
        >
            <div>
                <Radio
                    label="On Load"
                    value="default"
                    bind:group={$optionsEditing.loading_mode}
                />
                <Radio
                    label="On Scroll"
                    value="scroll"
                    bind:group={$optionsEditing.loading_mode}
                />
                <Radio
                    label="On Button Click"
                    value="click"
                    bind:group={$optionsEditing.loading_mode}
                />
            </div>
            <OptionSave key="loading_mode" />
        </SplitControl>

        <SplitControl
            label="Default page-id"
            caption="The default page-id to use when the post-id is not set"
        >
            <!-- double check the caption -->
            <div>
                <Radio
                    label="Post ID"
                    value="post_id"
                    bind:group={$optionsEditing.default_page_id}
                />
                <Radio
                    label="URL"
                    value="url"
                    bind:group={$optionsEditing.default_page_id}
                />
                <Radio
                    label="Slug"
                    value="slug"
                    bind:group={$optionsEditing.default_page_id}
                />
            </div>

            {#if $options.default_page_id !== $optionsEditing.default_page_id}
                <Notice type="warning">
                    <strong>Warning!</strong> Changing the page-id may cause old
                    comments threads to dissapear. You can always revert back to
                    the previous setting to get them back.
                </Notice>
            {/if}

            <OptionSave key="default_page_id" />
        </SplitControl>

        <!-- <SplitControl
            label="Sync Comments"
            caption="Sync comments from Hyvor Talk to WordPress daily"
        >
            Coming soon
        </SplitControl> -->
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
</style>
