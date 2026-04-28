<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({ summary: Object })

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)

const updateQty = (id, qty) => {
    router.patch('/cart/update', { product_id: id, quantity: qty }, { preserveScroll: true })
}
const remove = (id) => {
    router.delete('/cart/remove', { data: { product_id: id }, preserveScroll: true })
}
const clear = () => {
    if (confirm('Очистить корзину?')) router.delete('/cart/clear', { preserveScroll: true })
}
</script>

<template>
    <StorefrontLayout title="Корзина">
        <section class="section pt-30 pb-30 bg-light">
            <div class="container">
                <h1 class="mb-2">Корзина</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><Link href="/">Главная</Link></li>
                        <li class="breadcrumb-item active">Корзина</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section class="section pt-50 pb-60">
            <div class="container">
                <div v-if="summary.items.length === 0" class="text-center py-5">
                    <h3 class="mb-3">Корзина пуста</h3>
                    <p class="color-gray-500 mb-4">Загляните в каталог и выберите что-нибудь для вашего ребёнка.</p>
                    <Link href="/catalog" class="btn btn-brand-3 btn-lg">Перейти в каталог</Link>
                </div>

                <div v-else class="row">
                    <div class="col-lg-8 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-3">Товар</th>
                                            <th class="text-end">Цена</th>
                                            <th class="text-center" style="width:170px">Кол-во</th>
                                            <th class="text-end">Итого</th>
                                            <th class="pe-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in summary.items" :key="item.product_id">
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img v-if="item.image" :src="item.image" :alt="item.name" style="width:64px;height:64px;object-fit:cover" class="rounded">
                                                    <div>
                                                        <Link :href="`/products/${item.slug}`" class="fw-semibold text-dark">{{ item.name }}</Link>
                                                        <div v-if="item.sku" class="small text-muted">Арт: {{ item.sku }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">{{ formatPrice(item.price) }}</td>
                                            <td class="text-center">
                                                <div class="input-group input-group-sm" style="max-width:140px;margin:0 auto;">
                                                    <button @click="updateQty(item.product_id, item.quantity - 1)" :disabled="item.quantity <= 1" class="btn btn-outline-secondary">−</button>
                                                    <input type="text" :value="item.quantity" readonly class="form-control text-center">
                                                    <button @click="updateQty(item.product_id, item.quantity + 1)" class="btn btn-outline-secondary">+</button>
                                                </div>
                                            </td>
                                            <td class="text-end fw-semibold">{{ formatPrice(item.total) }}</td>
                                            <td class="pe-3 text-end">
                                                <button @click="remove(item.product_id)" class="btn btn-sm btn-link text-danger" aria-label="Удалить">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <Link href="/catalog" class="btn btn-outline-secondary">← Продолжить покупки</Link>
                            <button @click="clear" class="btn btn-link text-danger">Очистить корзину</button>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="mb-4">Итого</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Товары ({{ summary.count }})</span>
                                    <span>{{ formatPrice(summary.subtotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Доставка</span>
                                    <span>Рассчитывается при оформлении</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>К оплате</strong>
                                    <strong class="fs-5">{{ formatPrice(summary.total) }}</strong>
                                </div>
                                <Link href="/checkout" class="btn btn-brand-3 w-100">Оформить заказ</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
