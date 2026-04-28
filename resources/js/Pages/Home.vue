<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import ProductCard from '@/Components/storefront/ProductCard.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    featured: Array,
    newArrivals: Array,
    onSale: Array,
    categories: Array,
})
</script>

<template>
    <StorefrontLayout title="Главная">
        <!-- Hero Banner -->
        <section class="section banner-homepage1" style="background-image:url('/kidify/imgs/page/homepage1/banner.png'); background-size:cover; background-position:center;">
            <div class="container py-5">
                <div class="row align-items-center" style="min-height: 480px">
                    <div class="col-lg-6 text-white">
                        <span class="badge bg-warning text-dark mb-3 px-3 py-2">Новая коллекция</span>
                        <h1 class="display-3 fw-bold mb-3" style="line-height:1.1">Магазин товаров для&nbsp;детей</h1>
                        <p class="lead mb-4">Тысячи качественных товаров: одежда, игрушки, аксессуары. Быстрая доставка и удобная оплата.</p>
                        <Link href="/catalog" class="btn btn-warning btn-lg me-2">В каталог</Link>
                        <Link href="/about" class="btn btn-outline-light btn-lg">О магазине</Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories -->
        <section class="section pt-60 pb-30">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-md-8">
                        <h2 class="font-xxxl-bold mb-2">Категории</h2>
                        <p class="font-md color-gray-500 mb-0">Выберите интересующий раздел</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <Link href="/catalog" class="btn btn-line-bottom">Все товары →</Link>
                    </div>
                </div>
                <div class="row g-3">
                    <div v-for="cat in categories" :key="cat.id" class="col-6 col-md-4 col-lg-2">
                        <Link :href="`/catalog/${cat.slug}`" class="card h-100 text-decoration-none border-0 shadow-sm hover-up">
                            <div class="ratio ratio-1x1 bg-light rounded-3 overflow-hidden">
                                <img v-if="cat.image" :src="`/${cat.image}`" :alt="cat.name" style="object-fit:cover;width:100%;height:100%">
                                <div v-else class="d-flex align-items-center justify-content-center text-secondary fs-3">{{ cat.name[0] }}</div>
                            </div>
                            <div class="card-body text-center p-2">
                                <strong class="text-dark">{{ cat.name }}</strong>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured -->
        <section v-if="featured.length" class="section pt-60 pb-30">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-md-8">
                        <h2 class="font-xxxl-bold mb-2">Хиты продаж</h2>
                        <p class="font-md color-gray-500 mb-0">Самые популярные товары</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <Link href="/catalog" class="btn btn-line-bottom">Смотреть все →</Link>
                    </div>
                </div>
                <div class="row g-4">
                    <div v-for="p in featured" :key="p.id" class="col-6 col-md-4 col-lg-3">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Sale -->
        <section v-if="onSale.length" class="section pt-60 pb-30 bg-light">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-md-8">
                        <h2 class="font-xxxl-bold mb-2">Скидки</h2>
                        <p class="font-md color-gray-500 mb-0">Успейте купить со скидкой</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div v-for="p in onSale" :key="p.id" class="col-6 col-md-4 col-lg-3">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </div>
        </section>

        <!-- New Arrivals -->
        <section v-if="newArrivals.length" class="section pt-60 pb-60">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-md-8">
                        <h2 class="font-xxxl-bold mb-2">Новинки</h2>
                        <p class="font-md color-gray-500 mb-0">Свежие поступления</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div v-for="p in newArrivals" :key="p.id" class="col-6 col-md-4 col-lg-3">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
