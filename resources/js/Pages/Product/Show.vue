<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import ProductCard from '@/Components/storefront/ProductCard.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
    product: Object,
    related: Array,
})

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)

const onSale = computed(() => props.product.sale_price && Number(props.product.sale_price) < Number(props.product.price))

const activeImage = ref(props.product.images?.[0]?.url || '/kidify/imgs/page/homepage1/product1.png')

const addForm = useForm({
    product_id: props.product.id,
    quantity: 1,
})

const addToCart = () => addForm.post('/cart/add', { preserveScroll: true })

const inc = () => { if (addForm.quantity < 99) addForm.quantity++ }
const dec = () => { if (addForm.quantity > 1) addForm.quantity-- }
</script>

<template>
    <StorefrontLayout :title="product.name">
        <section class="section pt-30 pb-30 bg-light">
            <div class="container">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><Link href="/">Главная</Link></li>
                        <li class="breadcrumb-item"><Link href="/catalog">Каталог</Link></li>
                        <li v-if="product.category" class="breadcrumb-item">
                            <Link :href="`/catalog/${product.category.slug}`">{{ product.category.name }}</Link>
                        </li>
                        <li class="breadcrumb-item active">{{ product.name }}</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section class="section pt-50 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="border rounded-3 overflow-hidden mb-3 bg-white">
                            <img :src="activeImage" :alt="product.name" class="w-100" style="object-fit:cover; aspect-ratio:1/1">
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button v-for="img in product.images" :key="img.id"
                                    @click="activeImage = img.url"
                                    type="button"
                                    class="btn p-0 border rounded-3 overflow-hidden"
                                    :class="{ 'border-primary': activeImage === img.url }"
                                    style="width:80px;height:80px">
                                <img :src="img.url" :alt="img.alt || product.name" class="w-100 h-100" style="object-fit:cover">
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div v-if="product.brand" class="text-muted mb-1">{{ product.brand }}</div>
                        <h1 class="mb-3">{{ product.name }}</h1>
                        <div class="mb-3">
                            <span v-if="onSale" class="text-decoration-line-through color-gray-500 me-2 fs-5">{{ formatPrice(product.price) }}</span>
                            <strong class="fs-2 text-danger">{{ formatPrice(product.sale_price ?? product.price) }}</strong>
                        </div>
                        <p v-if="product.short_description" class="lead">{{ product.short_description }}</p>
                        <div class="mb-3">
                            <span v-if="product.stock > 0" class="badge bg-success">В наличии: {{ product.stock }} шт.</span>
                            <span v-else class="badge bg-danger">Нет в наличии</span>
                            <span v-if="product.sku" class="ms-2 text-muted small">Артикул: {{ product.sku }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="input-group" style="max-width: 160px">
                                <button type="button" @click="dec" class="btn btn-outline-secondary">−</button>
                                <input type="number" v-model.number="addForm.quantity" min="1" max="99" class="form-control text-center">
                                <button type="button" @click="inc" class="btn btn-outline-secondary">+</button>
                            </div>
                            <button @click="addToCart" :disabled="addForm.processing || product.stock <= 0" class="btn btn-brand-3 btn-lg flex-grow-1">
                                {{ addForm.processing ? 'Добавляем…' : 'В корзину' }}
                            </button>
                        </div>

                        <ul class="list-unstyled small color-gray-500">
                            <li class="mb-1">🚚 Бесплатная доставка от 5&nbsp;000&nbsp;₽</li>
                            <li class="mb-1">↩️ Возврат в течение 14&nbsp;дней</li>
                            <li class="mb-1">🔒 Безопасная оплата</li>
                        </ul>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="font-lg-bold mb-3">Описание</h3>
                        <article v-html="product.description" class="prose"></article>
                    </div>
                </div>

                <div v-if="related.length" class="mt-5">
                    <h3 class="font-lg-bold mb-3">Похожие товары</h3>
                    <div class="row g-4">
                        <div v-for="p in related" :key="p.id" class="col-6 col-md-3">
                            <ProductCard :product="p" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>

<style scoped>
.prose ul { padding-left: 1.25rem; }
.prose p { margin-bottom: .75rem; }
</style>
