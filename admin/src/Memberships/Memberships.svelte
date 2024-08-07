<script>
    import SplitControl from "../@components/SplitControl.svelte";
</script>

<div class="ht-wrap">
    <h3 style="margin-top:0;">Memberships</h3>

    <SplitControl
        label="Enable Memberships"
        caption="Show membership subscription button on your website"
    >
        <input type="checkbox" value="1" />
    </SplitControl>

    <SplitControl
        label="Available on"
        caption="On which pages the membership button should be shown"
    >
        <input type="radio" value="all" /> All Pages
        <input type="radio" value="only" /> Only on selected pages
        <input type="radio" value="except" /> On all pages except selected pages
    </SplitControl>
</div>

<style>
    .ht-wrap {
        padding: 30px 35px;
    }
</style>
