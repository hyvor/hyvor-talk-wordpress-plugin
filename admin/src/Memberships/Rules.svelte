<script>
    import Notice from "../@components/Notice.svelte";
    import { options, section } from "../store";
    import RuleCreator from "./RuleCreator.svelte";
    import RuleRow from "./RuleRow.svelte";

    let creating = false;
</script>

<h3>Gated Content Rules</h3>

<p>
    Gated content can be used to restrict access to certain content based on the
    user's membership status.
</p>

{#if creating}
    <RuleCreator on:cancel={() => (creating = false)} />
{:else}
    <button
        class="button"
        on:click={() => (creating = true)}
        disabled={$options.memberships_gated_content_rules.length >= 10}
    >
        Create Rule
    </button>
{/if}

{#each $options.memberships_gated_content_rules as rule, i}
    <RuleRow {rule} index={i} />
{/each}

{#if $options.memberships_gated_content_rules.length && !$options.encryption_key}
    <Notice type="warning">
        Encryption key is required to use gated content rules.
        <a on:click={() => ($section = "settings")} href="#encryption-key">
            Set up encryption key
        </a>
    </Notice>
{/if}
