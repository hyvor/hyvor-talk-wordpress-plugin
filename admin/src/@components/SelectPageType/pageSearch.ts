import type { PostType } from "../../store";

export function getPostTypeName(type: PostType) {
    if (type.type === "post_type") {
        return type.post_type;
    } else {
        return type.term;
    }
}

export function getPostType(type: PostType) {
    if (type.type === "post_type") {
        return "post type";
    } else {
        const taxonomy = type.taxonomy || "";
        const taxonomyName = taxonomy.replace("_", " ");
        return "taxonomy - " + taxonomyName;
    }
}
