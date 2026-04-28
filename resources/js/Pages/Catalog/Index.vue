<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import ProductCard from '@/Components/storefront/ProductCard.vue'
import { Link, router } from '@inertiajs/vue3'
import { reactive, watch } from 'vue'

const props = defineProps({
    products: Object,
    categories: Array,
    currentCategory: Object,
    filters: Object,
    priceRange: Object,
})

const localFilters = reactive({
    search: props.filters?.search || '',
    min_price: props.filters?.min_price || '',
    max_price: props.filters?.max_price || '',
    on_sale: !!props.filters?.on_sale,
    sort: props.filters?.sort || 'popular',
})

const apply = () => {
    const url = props.currentCategory ? `/catalog/${props.currentCategory.slug}` : '/catalog'
    router.get(url, {
        search: localFilters.search || undefined,
        min_price: localFilters.min_price || undefined,
        max_price: localFilters.max_price || undefined,
        on_sale: localFilters.on_sale ? 1 : undefined,
        sort: localFilters.sort !== 'popular' ? localFilters.sort : undefined,
    }, { preserveScroll: true, preserveState: true })
}

watch(() => localFilters.sort, apply)

const reset = () => {
    localFilters.search = ''
    localFilters.min_price = ''
    localFilters.max_price = ''
    localFilters.on_sale = false
    localFilters.sort = 'popular'
    apply()
}
</script>

<template>
    <StorefrontLayout :title="currentCategory ? currentCategory.name : 'Каталог'">
        <section class="section pt-30 pb-30 bg-light">
            <div class="container">
                <h1 class="font-xxxl-bold mb-2">{{ currentCategory ? currentCategory.name : 'Все товары' }}</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><Link href="/">Главная</Link></li>
                        <li class="breadcrumb-item"><Link href="/catalog">Каталог</Link></li>
                        <li v-if="currentCategory" class="breadcrumb-item active">{{ currentCategory.name }}</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section class="section pt-30 pb-60">
            <div class="container">
                <div class="row">
                    <aside class="col-lg-3 mb-4">
                        <div class="card border-0 shadow-sm p-3 mb-3">
                            <h6 class="font-lg-bold mb-3">Категории</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <Link href="/catalog" :class="{ 'fw-bold': !currentCategory }">Все товары</Link>
                                </li>
                                <li v-for="cat in categories" :key="cat.id" class="mb-2">
                                    <Link :href="`/catalog/${cat.slug}`" :class="{ 'fw-bold': currentCategory && currentCategory.id === cat.id }">{{ cat.name }}</Link>
                                </li>
                            </ul>
                        </div>

                        <div class="card border-0 shadow-sm p-3">
                            <h6 class="font-lg-bold mb-3">Фильтры</h6>
                            <form @submit.prevent="apply">
                                <div class="mb-3">
                                    <label class="form-label">Поиск</label>
                                    <input type="text" v-model="localFilters.search" class="form-control" placeholder="Название, бренд...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Цена</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" v-model="localFilters.min_price" :placeholder="`от ${priceRange?.min ?? 0}`" class="form-control" min="0">
                                        <input type="number" v-model="localFilters.max_price" :placeholder="`до ${priceRange?.max ?? 0}`" class="form-control" min="0">
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" id="on_sale" v-model="localFilters.on_sale" class="form-check-input">
                                    <label class="form-check-label" for="on_sale">Только со скидкой</label>
                                </div>
                                <button type="submit" class="btn btn-brand-3 w-100 mb-2">Применить</button>
                                <button type="button" @click="reset" class="btn btn-outline-secondary w-100">Сбросить</button>
                            </form>
                        </div>
                    </aside>

                    <div class="col-lg-9">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="mb-0 color-gray-500">Найдено {{ products.total }} товаров</p>
                            <select v-model="localFilters.sort" class="form-select" style="max-width: 220px">
                                <option value="popular">По популярности</option>
                                <option value="newest">Сначала новые</option>
                                <option value="price_asc">Сначала дешёвые</option>
                                <option value="price_desc">Сначала дорогие</option>
                            </select>
                        </div>

                        <div v-if="products.data.length === 0" class="text-center py-5">
                            <h4>Товары не найдены</h4>
                            <p class="text-muted">Попробуйте изменить фильтры</p>
                            <button @click="reset" class="btn btn-brand-3">Сбросить фильтры</button>
                        </div>

                        <div v-else class="row g-4">
                            <div v-for="p in products.data" :key="p.id" class="col-6 col-md-4">
                                <ProductCard :product="p" />
                            </div>
                        </div>

                        <nav v-if="products.last_page > 1" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li v-for="link in products.links" :key="link.label" class="page-item" :class="{ active: link.active, disabled: !link.url }">
                                    <Link v-if="link.url" :href="link.url" class="page-link" v-html="link.label" preserve-scroll />
                                    <span v-else class="page-link" v-html="link.label"></span>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
