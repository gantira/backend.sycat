<template>
    <div
        v-if="alertOpen"
        class="text-grey-500 px-6 py-4 rounded-lg relative mb-4 bg-white hover:text-grey-700 shadow"
    >
        <span class="text-xl inline-block mr-5 align-middle">
            <i class="fa fa-check"></i>
        </span>
        <span class="inline-block align-middle mr-8">
            <b class="capitalize">Success!</b> {{ message }}
        </span>
        <button
            class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none"
            v-on:click="closeAlert()"
        >
            <span>×</span>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        message: String,
    },

    data() {
        return {
            alertOpen: true,
        };
    },
    methods: {
        closeAlert: function () {
            this.alertOpen = false;
        },
    },
};
</script>

<style>
</style>
