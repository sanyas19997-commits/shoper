<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'

const page = usePage()
const visible = ref(false)
const flash = computed(() => page.props.flash || {})

watch(() => [flash.value.success, flash.value.error], ([s, e]) => {
    if (s || e) {
        visible.value = true
        setTimeout(() => (visible.value = false), 4000)
    }
}, { immediate: true })
</script>

<template>
    <div v-if="visible && (flash.success || flash.error)" class="position-fixed end-0 top-0 m-3" style="z-index:9999">
        <div class="alert" :class="flash.success ? 'alert-success' : 'alert-danger'">
            {{ flash.success || flash.error }}
        </div>
    </div>
</template>
