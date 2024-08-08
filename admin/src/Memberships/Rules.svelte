<script>
    import RuleCreator from "./RuleCreator.svelte";

    let creating = false;
</script>

<h3>Gated Content Rules</h3>

<p>
    Gated content can be used to restrict access to certain content based on a
    user's membership status.
</p>

{#if creating}
    <RuleCreator on:cancel={() => (creating = false)} />
{:else}
    <button class="button" on:click={() => (creating = true)}>
        Create Rule
    </button>
{/if}
