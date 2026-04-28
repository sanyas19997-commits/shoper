<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const page = usePage()
const search = ref('')

const cart = computed(() => page.props.cart || { count: 0, subtotal: 0 })
const auth = computed(() => page.props.auth || { user: null })
const categories = computed(() => page.props.categoriesNav || [])

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)

const submitSearch = () => {
    router.get('/catalog', { search: search.value })
}
</script>

<template>
    <header class="header sticky-bar header-style-1">
        <div class="box-top-header">
            <div class="container">
                <div class="top-header">
                    <div class="top-menu">
                        <ul class="menu-top">
                            <li><Link href="/about">О нас</Link></li>
                            <li><Link href="/contact">Контакты</Link></li>
                            <li><Link href="/catalog">Каталог</Link></li>
                        </ul>
                    </div>
                    <div class="header-top-info">
                        <span class="mr-10">Бесплатная доставка от 5 000 ₽!</span>
                        <Link class="btn btn-brand-3-sm" href="/catalog">Подробнее</Link>
                    </div>
                    <div class="lang-currency">
                        <span class="btn btn-line-bottom">RU · ₽</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="main-header">
                <div class="header-logo">
                    <Link class="d-flex" href="/">
                        <img alt="Billaro Store" src="/kidify/imgs/template/logo.svg" style="max-height:50px">
                    </Link>
                </div>
                <div class="header-menu">
                    <div class="header-nav">
                        <nav class="nav-main-menu d-none d-xl-block">
                            <ul class="main-menu">
                                <li><Link class="active" href="/">Главная</Link></li>
                                <li class="has-children">
                                    <Link href="/catalog">Каталог</Link>
                                    <ul class="sub-menu" v-if="categories.length">
                                        <li v-for="cat in categories" :key="cat.id">
                                            <Link :href="`/catalog/${cat.slug}`">{{ cat.name }}</Link>
                                        </li>
                                    </ul>
                                </li>
                                <li><Link href="/about">О нас</Link></li>
                                <li><Link href="/contact">Контакты</Link></li>
                                <li v-if="auth.user?.is_admin">
                                    <Link href="/admin"><strong>Админка</strong></Link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="burger-icon burger-icon-white border rounded-3">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <div class="header-right">
                    <div class="d-none d-md-block mr-15">
                        <form class="form-search" @submit.prevent="submitSearch">
                            <input v-model="search" type="text" placeholder="Поиск товаров...">
                            <button type="submit" class="btn-search"><i class="fi-rr-search"></i></button>
                        </form>
                    </div>
                    <div class="block-signin">
                        <template v-if="auth.user">
                            <Link class="btn btn-line-bottom mr-15" href="/account">{{ auth.user.name }}</Link>
                        </template>
                        <template v-else>
                            <Link class="btn btn-line-bottom mr-15" href="/login">Войти</Link>
                            <Link class="btn btn-brand-3" href="/register">Регистрация</Link>
                        </template>
                        <Link class="btn btn-cart ms-3 position-relative" href="/cart" aria-label="Корзина">
                            <i class="fi-rr-shopping-bag"></i>
                            <span class="ms-2">{{ formatPrice(cart.subtotal) }}</span>
                            <span v-if="cart.count > 0" class="badge bg-danger position-absolute" style="top:-8px; right:-8px;">{{ cart.count }}</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<style scoped>
.btn-cart { display: inline-flex; align-items: center; gap: 4px; }
.form-search { position: relative; }
.form-search input { border: 1px solid #eee; border-radius: 24px; padding: 8px 38px 8px 16px; min-width: 220px; }
.form-search .btn-search { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: 0; }
</style>
