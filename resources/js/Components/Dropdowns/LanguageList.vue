<template>
    <Listbox v-model="currentLanguage">
        <div class="relative">
            <ListboxButton
                class="relative w-full cursor-default rounded-lg bg-white dark:bg-secondary-dark py-2 pl-3 pr-10 text-left shadow-md focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-orange-300 sm:text-sm">
                <span class="block truncate text-black dark:text-white">{{ languageName.of(currentLanguage) }}</span>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                    <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
            </ListboxButton>

            <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <ListboxOptions
                    class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white dark:bg-secondary-dark py-1 text-center text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ListboxOption v-slot="{ active, selected }" v-for="(language, index) in languages" :key="index"
                        :value="language" as="template">
                        <Link :href="route('lang', { locale: language })">
                        <li :class="[
                            active ? 'dark:bg-golden-yellow dark:text-white text-amber-900' : 'text-gray-900 dark:text-white',
                            'relative cursor-default select-none py-2 px-2',
                        ]">
                            <span :class="[
                                selected ? 'font-bold' : 'font-normal',
                                'block truncate',
                            ]">{{ languageName.of(language) }}</span>
                        </li>
                        </Link>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'
import { usePage, Link } from '@inertiajs/inertia-vue3';

const languages = usePage().props.value.app.available_languages
const languageName = new Intl.DisplayNames(['en'], { type: 'language' });

const currentLanguage = ref(usePage().props.value.locale)
</script>