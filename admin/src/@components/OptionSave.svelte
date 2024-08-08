<script lang="ts">
    import Notice from "./Notice.svelte";
    import { callApi } from "../api";
    import {
        options,
        optionsEditing,
        setOptions,
        type Options,
    } from "../store";
    import { updateOption } from "../actions";

    export let key: keyof Options;
    export let validate: ((value: any) => string | true) | undefined =
        undefined;

    $: value = $options[key];

    let valueEditing: any = "";
    $: {
        valueEditing = $optionsEditing[key];
        valueEditing = valueEditing === "" ? null : valueEditing;
    }

    let editing = false;
    let saved = false;

    let error = "";

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
        const val = getSavableValue();
        error = "";

        const validation = validate !== undefined ? validate(val) : true;
        if (validation !== true) {
            error = validation;
            setTimeout(() => {
                error = "";
            }, 2000);
            return;
        }

        editing = true;

        updateOption(
            key,
            val,
            () => {
                editing = false;
                saved = true;
                setTimeout(() => {
                    saved = false;
                }, 2000);
            },
            (err) => {
                error = err.message;
                editing = false;
            },
        );
    }
</script>

{#if JSON.stringify(value) !== JSON.stringify(valueEditing)}
    <div class="ht-option-save">
        <button class="button" on:click={handleSave} disabled={editing}>
            Save
        </button>
    </div>
{/if}

{#if saved}
    <Notice type="success">Saved!</Notice>
{/if}

{#if error}
    <Notice type="error">{error}</Notice>
{/if}

<style>
    .ht-option-save {
        margin-top: 10px;
    }
</style>
