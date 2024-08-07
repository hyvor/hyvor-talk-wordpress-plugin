<script lang="ts">
    import { onMount } from "svelte";
    import NavLink from "./@components/NavLink.svelte";
    import { section, type SectionType } from "./store";
    import { callApi } from "./api";
    import Settings from "./Settings/Settings.svelte";
    import IconGear from "./@icons/IconGear.svelte";
    import IconChat from "./@icons/IconChat.svelte";
    import IconEnvelope from "./@icons/IconEnvelope.svelte";
    import IconPersonUp from "./@icons/IconPersonUp.svelte";
    import Comments from "./Comments/Comments.svelte";
    import Newsletters from "./Newsletters/Newsletters.svelte";

    function setSection(newSection: SectionType) {
        $section = newSection;
    }

    onMount(() => {
        callApi("GET", "/init");
    });
</script>

<div class="ht-main-wrap">
    <div class="ht-nav ht-global-box">
        <NavLink
            on:click={() => setSection("settings")}
            active={$section === "settings"}
        >
            <IconGear slot="start" />
            Plugin Configuration
        </NavLink>
        <NavLink
            on:click={() => setSection("comments")}
            active={$section === "comments"}
        >
            <IconChat slot="start" />
            Comments
        </NavLink>
        <NavLink
            on:click={() => setSection("newsletters")}
            active={$section === "newsletters"}
        >
            <IconEnvelope slot="start" />
            Newsletters
        </NavLink>
        <NavLink
            on:click={() => setSection("memberships")}
            active={$section === "memberships"}
        >
            <IconPersonUp slot="start" />
            Memberships
        </NavLink>
    </div>
    <div class="ht-content ht-global-box">
        {#if $section === "settings"}
            <Settings />
        {:else if $section === "comments"}
            <Comments />
        {:else if $section === "newsletters"}
            <Newsletters />
        {/if}
    </div>
</div>

<style>
    .ht-main-wrap {
        display: flex;
        font-size: 16px;
        padding: 20px 0;
        justify-content: flex-start;
    }
    .ht-nav {
        padding: 20px 0;
        width: 250px;
    }
    .ht-content {
        flex: 1;
        margin-left: 15px;
        margin-right: 15px;
    }
</style>
