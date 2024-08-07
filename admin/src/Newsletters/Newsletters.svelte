<script>
    import SplitControl from "../@components/SplitControl.svelte";
</script>

<div class="wrap">
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
</div>

<style>
    .wrap {
        padding: 30px 35px;
    }
</style>
