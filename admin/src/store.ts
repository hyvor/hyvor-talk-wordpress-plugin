import { writable } from "svelte/store";

export type SectionType = 'settings' | 'comments' | 'newsletters' | 'memberships';

export const section = writable<SectionType>('settings');

export interface Options {
    website_id: number;
    console_api_key: string;
    sso_private_key: string;
    encryption_key: string;
    instance: string;
}

export const options = writable<Options>({} as Options);
export const optionsEditing = writable<Options>({} as Options);


export function setOptions(newOptions: Options) {
    options.set(newOptions);
    optionsEditing.set({...newOptions});
}
