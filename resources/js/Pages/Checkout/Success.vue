<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({ order: Object })

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)
</script>

<template>
    <StorefrontLayout title="Заказ оформлен">
        <section class="section pt-50 pb-60">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card border-0 shadow-sm text-center p-5">
                            <div class="mb-3" style="font-size: 64px">✅</div>
                            <h2 class="mb-2">Спасибо за заказ!</h2>
                            <p class="text-muted">Номер вашего заказа: <strong>{{ order.number }}</strong></p>
                            <p>Мы свяжемся с вами в ближайшее время для подтверждения. Подробности отправлены на email <strong>{{ order.customer_email }}</strong>.</p>
                            <ul class="list-unstyled text-start mb-4 mt-3">
                                <li v-for="item in order.items" :key="item.id" class="d-flex justify-content-between border-bottom py-2">
                                    <span>{{ item.product_name }} × {{ item.quantity }}</span>
                                    <strong>{{ formatPrice(item.total) }}</strong>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Итого</strong>
                                <strong class="fs-5">{{ formatPrice(order.total) }}</strong>
                            </div>
                            <Link href="/" class="btn btn-brand-3">На главную</Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
