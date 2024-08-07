<script lang="ts">
    import Notice from "../@components/Notice.svelte";
    import { callApi } from "../api";
    import { options, optionsEditing, type Options } from "../store";

    export let key: keyof Options;

    $: value = $options[key];

    let valueEditing: any = "";
    $: {
        valueEditing = $optionsEditing[key];
        valueEditing = valueEditing === "" ? null : valueEditing;
    }

    let editing = false;
    let saved = false;

    function getSavableValue() {
        let val = valueEditing;

        if (typeof val === "string") {
            val = val.trim();
            if (val === "") {
                return null;
            }
        }

        return val;
    }

    function handleSave() {
        editing = true;
        callApi(
            "PATCH",
            "/option",
            {
                [key]: getSavableValue(),
            },
            (response) => {
                options.set(response);
                optionsEditing.set(response);
                editing = false;

                saved = true;
                setTimeout(() => {
                    saved = false;
                }, 2000);
            },
            (err) => {
                alert(err.message);
                editing = false;
            },
        );
    }
</script>

{#if value !== valueEditing}
    <div class="ht-option-save">
        <button class="button" on:click={handleSave} disabled={editing}>
            Save
        </button>
    </div>
{/if}

{#if saved}
    <Notice type="success">Saved!</Notice>
{/if}

<style>
    .ht-option-save {
        margin-top: 10px;
    }
</style>
