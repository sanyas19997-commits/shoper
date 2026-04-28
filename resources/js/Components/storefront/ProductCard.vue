<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    product: { type: Object, required: true },
})

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)

const mainImage = computed(() => {
    return props.product.main_image?.url
        || props.product.images?.[0]?.url
        || '/kidify/imgs/page/homepage1/product1.png'
})

const onSale = computed(() => props.product.sale_price && Number(props.product.sale_price) < Number(props.product.price))

const addForm = useForm({
    product_id: props.product.id,
    quantity: 1,
})

const addToCart = () => {
    addForm.post('/cart/add', {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="card-grid-style-2 hover-up">
        <div class="card-grid-inner">
            <div class="image-box position-relative">
                <Link :href="`/products/${product.slug}`">
                    <img :src="mainImage" :alt="product.name" loading="lazy" style="width:100%;height:auto;object-fit:cover;aspect-ratio:1/1;">
                </Link>
                <span v-if="onSale" class="label-hot bg-danger text-white px-2 py-1 position-absolute" style="top:8px;left:8px;border-radius:6px;">Sale</span>
                <span v-else-if="product.is_new" class="label-new bg-success text-white px-2 py-1 position-absolute" style="top:8px;left:8px;border-radius:6px;">Новинка</span>
            </div>
            <div class="info-right p-3">
                <span v-if="product.brand" class="font-xs color-gray-500">{{ product.brand }}</span>
                <h6 class="text-md-bold color-gray-900 mb-10">
                    <Link :href="`/products/${product.slug}`">{{ product.name }}</Link>
                </h6>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span v-if="onSale" class="text-decoration-line-through color-gray-500 me-2">{{ formatPrice(product.price) }}</span>
                        <strong class="text-danger">{{ formatPrice(product.sale_price ?? product.price) }}</strong>
                    </div>
                    <button @click="addToCart" :disabled="addForm.processing || (product.stock !== undefined && product.stock <= 0)" class="btn btn-brand-3-sm" type="button">
                        В корзину
                    </button>
                </div>
                <p v-if="product.stock !== undefined && product.stock <= 0" class="font-xs color-danger mt-2 mb-0">Нет в наличии</p>
            </div>
        </div>
    </div>
</template>
