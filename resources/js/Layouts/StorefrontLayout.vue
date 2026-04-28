<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed, onMounted, watch, nextTick } from 'vue'
import StoreHeader from '@/Components/storefront/StoreHeader.vue'
import StoreFooter from '@/Components/storefront/StoreFooter.vue'
import FlashMessages from '@/Components/storefront/FlashMessages.vue'

defineProps({
    title: { type: String, default: '' },
})

const page = usePage()

// Re-init Kidify jQuery widgets after Inertia navigation
const reinitKidify = () => {
    nextTick(() => {
        if (typeof window === 'undefined' || !window.jQuery) return
        const $ = window.jQuery
        // Activate sliders & WOW animations again
        try {
            if (typeof window.WOW !== 'undefined') new window.WOW().init()
        } catch (e) {}
        try {
            $('.preloader').fadeOut('slow')
            $('#preloader-active').delay(150).fadeOut('slow')
        } catch (e) {}
    })
}

onMounted(reinitKidify)
watch(() => page.url, reinitKidify)
</script>

<template>
    <Head :title="title" />

    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="page-loading text-center">
                    <img class="d-inline-block" src="/kidify/imgs/template/favicon.svg" alt="Billaro Store">
                    <div class="page-loading-inner">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <StoreHeader />

    <FlashMessages />

    <main class="main">
        <slot />
    </main>

    <StoreFooter />
</template>
