<script>
    import SplitControl from "../@components/SplitControl.svelte";
</script>

<div class="wrap">
    <h3 style="margin-top:0;">Comments</h3>

    <SplitControl
        label="Loading Mode"
        caption="When to load the comments in the page"
    >
        <input type="text" value="1" />
    </SplitControl>

    <SplitControl
        label="Sync Comments"
        caption="Sync comments from Hyvor Talk to WordPress daily"
    >
        <input type="checkbox" value="1" />
    </SplitControl>

    <hr style="margin:20px 0;" />

    <h3>Shortcodes</h3>

    <p>Coming soon...</p>
</div>

<style>
    .wrap {
        padding: 30px 35px;
    }
</style>
