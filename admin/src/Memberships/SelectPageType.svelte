<script lang="ts">
    import { callApi } from "../api";

    function search() {
        callApi(
            "GET",
            "/post-taxonomy-search",
            {
                search: "p",
            },
            (response) => {
                console.log(response);
            },
        );
    }
</script>
