<template>
    <div
        v-if="showPagination"
        class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
    >
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <nav
                class="relative z-0 flex justify-center rounded-md shadow-sm -space-x-px "
                aria-label="Pagination"
            >
                <ul class="inline-flex align-middle">
                    <li
                        class="p-1 rounded"
                        v-for="(link, key) in links"
                        :key="key"
                        :class="isActive(link)"
                    >
                        <inertia-link
                            class="p-1 rounded"
                            :href="link.url"
                            v-if="link.url"
                            preserve-state
                            preserve-scroll
                        >{{ link.label }}</inertia-link>
                        <a
                            class=""
                            href="#"
                            v-else
                            @click.prevent="handleNoLink"
                        >{{ link.label }}</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        links: Array,
    },
    computed: {
        showPagination() {
            return this.links.length > 3;
        },
    },
    methods: {
        isActive(link) {
            return link.active === true ? "bg-gray-100" : "normal";
        },
        handleNoLink() {
            return false;
        },
    },
};
</script>
