<script lang="ts">
    import { onMount } from "svelte";
    import NavLink from "./@components/NavLink.svelte";
    import {
        options,
        optionsEditing,
        section,
        setOptions,
        type SectionType,
    } from "./store";
    import { callApi } from "./api";
    import Settings from "./Settings/Settings.svelte";
    import IconGear from "./@icons/IconGear.svelte";
    import IconChat from "./@icons/IconChat.svelte";
    import IconEnvelope from "./@icons/IconEnvelope.svelte";
    import IconPersonUp from "./@icons/IconPersonUp.svelte";
    import Comments from "./Comments/Comments.svelte";
    import Newsletters from "./Newsletters/Newsletters.svelte";
    import Memberships from "./Memberships/Memberships.svelte";
    import IconBoxArrowUpRight from "./@icons/IconBoxArrowUpRight.svelte";

    function setSection(newSection: SectionType) {
        $section = newSection;

        const url = new URL(window.location.href);
        if (newSection === "settings") {
            url.searchParams.delete("section");
        } else {
            url.searchParams.set("section", newSection);
        }
        window.history.replaceState({}, "", url);
    }

    let loading = true;

    onMount(() => {
        callApi(
            "GET",
            "/init",
            {},
            (response) => {
                setOptions(response.options);
                loading = false;

                const url = new URL(window.location.href);
                const section = url.searchParams.get("section");
                if (section) {
                    setSection(section as SectionType);
                }
            },
            (err) => {
                alert(err.message);
            },
        );
    });
</script>

<div class="ht-main-wrap">
    {#if !loading}
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

            <div style="height:1px;background:#eee;margin:20px 0;"></div>

            <NavLink href={$options.instance + "/docs/wordpress"}>
                <IconBoxArrowUpRight slot="start" size={12} />
                Plugin Docs
            </NavLink>

            <NavLink
                href="https://wordpress.org/support/plugin/hyvor-talk/reviews/#new-post"
            >
                <IconBoxArrowUpRight slot="start" size={12} />
                Rate Us
            </NavLink>
        </div>
        <div class="ht-content ht-global-box">
            {#if $section === "settings"}
                <Settings />
            {:else if $section === "comments"}
                <Comments />
            {:else if $section === "newsletters"}
                <Newsletters />
            {:else if $section === "memberships"}
                <Memberships />
            {/if}
        </div>
    {/if}
</div>

<style>
    .ht-main-wrap {
        display: flex;
        font-size: 16px;
        padding: 20px 0;
        align-items: flex-start;
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
