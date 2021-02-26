<template>
    <span :class="classes" class="capitalize">
        {{ status }}
    </span>
</template>

<script>
export default {
    props: {
        status: String,
    },

    computed: {
        classes() {
            return this.status == 'published'
                ? "px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                : "px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800";
        },
    },
};
</script>

<style>
</style>
