import { writable } from "svelte/store";

export type SectionType = 'settings' | 'comments' | 'newsletters' | 'memberships';

export const section = writable<SectionType>('settings');
