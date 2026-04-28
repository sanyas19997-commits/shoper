<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({ order: Object })

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)
</script>

<template>
    <StorefrontLayout :title="`Заказ ${order.number}`">
        <section class="section pt-50 pb-60">
            <div class="container">
                <Link href="/account">← Все заказы</Link>
                <h2 class="my-3">Заказ {{ order.number }}</h2>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <table class="table">
                            <thead><tr><th>Товар</th><th class="text-end">Цена</th><th class="text-center">Кол-во</th><th class="text-end">Сумма</th></tr></thead>
                            <tbody>
                                <tr v-for="item in order.items" :key="item.id">
                                    <td>{{ item.product_name }}</td>
                                    <td class="text-end">{{ formatPrice(item.price) }}</td>
                                    <td class="text-center">{{ item.quantity }}</td>
                                    <td class="text-end">{{ formatPrice(item.total) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr><td colspan="3" class="text-end"><strong>Итого</strong></td><td class="text-end"><strong>{{ formatPrice(order.total) }}</strong></td></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
