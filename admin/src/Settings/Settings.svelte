<script>
    import SplitControl from "../@components/SplitControl.svelte";
</script>

<div class="ht-settings-wrap">
    <h3 style="margin-top:0;">Welcome to Hyvor Talk!</h3>

    <SplitControl label="Website ID" caption="Your Hyvor Talk Website ID">
        <input type="text" value="1" />
    </SplitControl>
    <SplitControl
        label="Console API Key"
        caption="To communicate with Hyvor Talk servers. Required for admin features"
    >
        <input type="text" value="1" />
    </SplitControl>
    <SplitControl
        label="SSO Private Key"
        caption="To connect WordPress users with Hyvor Talk using Single Sign-On"
    >
        <input type="text" value="1" />
    </SplitControl>
    <SplitControl
        label="Encryption Key"
        caption="Required for the gated content feature"
    >
        <input type="text" value="1" />
    </SplitControl>
</div>

<style>
    .ht-settings-wrap {
        padding: 30px 35px;
    }
    input[type="text"] {
        display: block;
        width: 100%;
    }
</style>
