import { writable } from "svelte/store";

export type SectionType = 'settings' | 'comments' | 'newsletters' | 'memberships';

export const section = writable<SectionType>('settings');

export interface Options {

    // basic
    website_id: number;
    console_api_key: string;
    sso_private_key: string;
    encryption_key: string;
    instance: string;

    // comments
    comments_enabled: boolean;
    comment_counts_enabled: boolean;
    loading_mode: 'default' | 'scroll' | 'click';
    default_post_id: 'post_id' | 'url' | 'slug';

    // memberships
    memberships_enabled: boolean;
    memberships_pages: SelectedPages;
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

export const options = writable<Options>({} as Options);
export const optionsEditing = writable<Options>({} as Options);

export function setOptions(newOptions: Options) {
    options.set(newOptions);
    optionsEditing.set({...newOptions});
}
