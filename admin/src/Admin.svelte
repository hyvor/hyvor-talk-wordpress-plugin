<script lang="ts">
    import { onMount } from "svelte";
    import NavLink from "./@components/NavLink.svelte";
    import { section, type SectionType } from "./store";
    import { callApi } from "./api";

    function setSection(newSection: SectionType) {
        $section = newSection;
    }

    onMount(() => {
        callApi("GET", "/init");
    });
</script>

<div class="ht-main-wrap">
    <div class="ht-nav ht-box">
        <NavLink
            on:click={() => setSection("settings")}
            active={$section === "settings"}
        >
            Plugin Configuration
        </NavLink>
        <NavLink
            on:click={() => setSection("comments")}
            active={$section === "comments"}
        >
            Comments
        </NavLink>
        <NavLink
            on:click={() => setSection("newsletters")}
            active={$section === "newsletters"}
        >
            Newsletters
        </NavLink>
        <NavLink
            on:click={() => setSection("memberships")}
            active={$section === "memberships"}
        >
            Memberships
        </NavLink>
    </div>
</div>

<style>
    .ht-main-wrap {
        display: flex;
        font-size: 16px;
        padding: 20px 0;
    }
    .ht-nav {
        padding: 20px 0;
        width: 250px;
    }
</style>
