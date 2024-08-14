import { writable } from "svelte/store";

export type SectionType = 'settings' | 'comments' | 'newsletters' | 'memberships';

export const section = writable<SectionType>('settings');

export interface Options {

    // basic
    website_id: number;
    console_api_key: string;
    sso_private_key: string;
    encryption_key: string;
    webhook_secret: string;
    last_webhook_delivered_at: number;
    instance: string;

    // comments
    comments_enabled: boolean;
    comment_counts_enabled: boolean;
    comments_pages: SelectedPages;
    loading_mode: 'default' | 'scroll' | 'click';
    default_page_id: 'post_id' | 'url' | 'slug';

    // newsletters
    newsletters_auto_subscribe_on_signup: boolean;

    // memberships
    memberships_enabled: boolean;
    memberships_pages: SelectedPages;
    memberships_gated_content_rules: GatedContentRule[]
}

export type SelectedPages = null | { // null = all pages
    logic: 'include' | 'exclude';
    types: PostType[]
}


export interface PostType {

    type: 'post_type' | 'taxonomy_term';
    post_type?: string;
    taxonomy?: string;
    term?: string;

}

export interface GatedContentRule {

    minimum_plan: string;
    post_types: SelectedPages;
    gate: string;
    show_excerpt: boolean;

}

export const options = writable<Options>({} as Options);
export const optionsEditing = writable<Options>({} as Options);

export function setOptions(newOptions: Options) {
    options.set(newOptions);
    optionsEditing.set(structuredClone(newOptions));
}
