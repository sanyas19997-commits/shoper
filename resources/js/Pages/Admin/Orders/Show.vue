<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({ order: Object, statuses: Object })
const form = useForm({ status: props.order.status })

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)
const fmtDate = (s) => s ? new Date(s).toLocaleString('ru-RU') : ''

const updateStatus = () => form.patch(`/admin/orders/${props.order.id}/status`, { preserveScroll: true })
</script>

<template>
    <AdminLayout :title="`Заказ ${order.number}`">
        <Link href="/admin/orders" class="btn btn-link mb-3">← Все заказы</Link>
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mb-0">Заказ {{ order.number }}</h4>
                        <span class="text-muted">{{ fmtDate(order.created_at) }}</span>
                    </div>
                    <table class="table">
                        <thead><tr><th>Товар</th><th class="text-end">Цена</th><th class="text-center">Кол-во</th><th class="text-end">Сумма</th></tr></thead>
                        <tbody>
                            <tr v-for="item in order.items" :key="item.id">
                                <td>
                                    <strong>{{ item.product_name }}</strong>
                                    <div class="text-muted small">{{ item.product_sku }}</div>
                                </td>
                                <td class="text-end">{{ formatPrice(item.price) }}</td>
                                <td class="text-center">{{ item.quantity }}</td>
                                <td class="text-end">{{ formatPrice(item.total) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="3" class="text-end">Сумма товаров</td><td class="text-end">{{ formatPrice(order.subtotal) }}</td></tr>
                            <tr><td colspan="3" class="text-end">Доставка</td><td class="text-end">{{ formatPrice(order.shipping_total) }}</td></tr>
                            <tr><td colspan="3" class="text-end fw-bold">Итого</td><td class="text-end fw-bold fs-5">{{ formatPrice(order.total) }}</td></tr>
                        </tfoot>
                    </table>
                </div></div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h5 class="mb-3">Статус</h5>
                    <select v-model="form.status" class="form-select mb-2">
                        <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
                    </select>
                    <button @click="updateStatus" :disabled="form.processing" class="btn btn-primary w-100">Обновить</button>
                </div></div>
                <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                    <h5 class="mb-3">Покупатель</h5>
                    <p class="mb-1"><strong>{{ order.customer_name }}</strong></p>
                    <p class="mb-1">{{ order.customer_email }}</p>
                    <p class="mb-1">{{ order.customer_phone }}</p>
                </div></div>
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h5 class="mb-3">Доставка</h5>
                    <p class="mb-1">{{ order.shipping_method === 'pickup' ? 'Самовывоз' : 'Курьер' }}</p>
                    <p class="mb-1">{{ order.shipping_country }}, {{ order.shipping_city }}</p>
                    <p class="mb-1">{{ order.shipping_postcode }} {{ order.shipping_street }}<span v-if="order.shipping_apartment">, кв. {{ order.shipping_apartment }}</span></p>
                    <hr>
                    <h5 class="mb-3 mt-3">Оплата</h5>
                    <p class="mb-1">{{ order.payment_method === 'card' ? 'Картой' : 'Наличными' }}</p>
                    <p class="mb-0 text-muted">{{ order.payment_status }}</p>
                    <hr v-if="order.notes">
                    <p v-if="order.notes" class="mb-0 mt-2"><em>{{ order.notes }}</em></p>
                </div></div>
            </div>
        </div>
    </AdminLayout>
</template>
