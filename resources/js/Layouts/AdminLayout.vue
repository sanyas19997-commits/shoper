<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'

defineProps({ title: { type: String, default: 'Админка' } })

const page = usePage()
const user = computed(() => page.props.auth?.user)
const flash = computed(() => page.props.flash || {})

const showFlash = ref(false)
watch(() => [flash.value.success, flash.value.error], ([s, e]) => {
    if (s || e) {
        showFlash.value = true
        setTimeout(() => (showFlash.value = false), 4000)
    }
}, { immediate: true })
</script>

<template>
    <Head :title="title + ' · Billaro Admin'" />
    <div class="d-flex" style="min-height: 100vh;">
        <aside class="bg-dark text-white d-flex flex-column" style="width: 240px; flex-shrink: 0;">
            <div class="p-3 border-bottom border-secondary">
                <Link href="/admin" class="text-white text-decoration-none">
                    <h5 class="mb-0">Billaro Admin</h5>
                </Link>
                <small class="text-secondary">Панель управления</small>
            </div>
            <nav class="flex-grow-1 p-3">
                <ul class="list-unstyled">
                    <li class="mb-2"><Link href="/admin" class="text-white text-decoration-none">📊 Дашборд</Link></li>
                    <li class="mb-2"><Link href="/admin/products" class="text-white text-decoration-none">📦 Товары</Link></li>
                    <li class="mb-2"><Link href="/admin/categories" class="text-white text-decoration-none">🗂 Категории</Link></li>
                    <li class="mb-2"><Link href="/admin/orders" class="text-white text-decoration-none">🧾 Заказы</Link></li>
                    <li class="mb-2"><Link href="/admin/users" class="text-white text-decoration-none">👤 Пользователи</Link></li>
                    <li class="mt-4"><Link href="/" class="text-secondary text-decoration-none">↩ К сайту</Link></li>
                </ul>
            </nav>
            <div class="p-3 border-top border-secondary small">
                <div class="text-secondary">{{ user?.email }}</div>
                <Link href="/logout" method="post" as="button" class="btn btn-sm btn-outline-light mt-2">Выйти</Link>
            </div>
        </aside>
        <main class="flex-grow-1 bg-light">
            <header class="bg-white shadow-sm px-4 py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ title }}</h4>
                <div>{{ user?.name }}</div>
            </header>
            <div v-if="showFlash && (flash.success || flash.error)" class="position-fixed end-0 top-0 m-3" style="z-index:9999">
                <div class="alert" :class="flash.success ? 'alert-success' : 'alert-danger'">{{ flash.success || flash.error }}</div>
            </div>
            <div class="p-4">
                <slot />
            </div>
        </main>
    </div>
</template>
