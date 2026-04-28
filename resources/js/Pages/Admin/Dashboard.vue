<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({ stats: Object, recentOrders: Array, topProducts: Array })

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)
const fmtDate = (s) => s ? new Date(s).toLocaleString('ru-RU') : ''

const statusBg = (status) => ({
    new: 'bg-secondary', processing: 'bg-info', shipped: 'bg-primary',
    completed: 'bg-success', cancelled: 'bg-danger',
}[status] || 'bg-secondary')
</script>

<template>
    <AdminLayout title="Дашборд">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <div class="text-muted small">Товаров</div>
                    <div class="fs-3 fw-bold">{{ stats.products }}</div>
                    <div class="text-success small">Активных: {{ stats.productsActive }}</div>
                </div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <div class="text-muted small">Заказов</div>
                    <div class="fs-3 fw-bold">{{ stats.orders }}</div>
                    <div class="text-warning small">Новых: {{ stats.ordersNew }}</div>
                </div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <div class="text-muted small">Пользователей</div>
                    <div class="fs-3 fw-bold">{{ stats.users }}</div>
                </div></div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <div class="text-muted small">Выручка</div>
                    <div class="fs-3 fw-bold">{{ formatPrice(stats.revenue) }}</div>
                </div></div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Последние заказы</h5>
                        <Link href="/admin/orders" class="small">Все заказы →</Link>
                    </div>
                    <div v-if="recentOrders.length === 0" class="text-muted text-center py-4">Заказов пока нет</div>
                    <table v-else class="table table-sm align-middle">
                        <thead><tr><th>Номер</th><th>Покупатель</th><th>Сумма</th><th>Статус</th><th>Дата</th></tr></thead>
                        <tbody>
                            <tr v-for="o in recentOrders" :key="o.id">
                                <td><Link :href="`/admin/orders/${o.id}`">{{ o.number }}</Link></td>
                                <td>{{ o.customer_name }}</td>
                                <td>{{ formatPrice(o.total) }}</td>
                                <td><span class="badge" :class="statusBg(o.status)">{{ o.status }}</span></td>
                                <td class="small text-muted">{{ fmtDate(o.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div></div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-0">Хиты</h5>
                        <Link href="/admin/products" class="small">Все товары →</Link>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li v-for="p in topProducts" :key="p.id" class="d-flex align-items-center gap-2 mb-2">
                            <img v-if="p.main_image?.url" :src="p.main_image.url" alt="" style="width:40px;height:40px;object-fit:cover" class="rounded">
                            <div class="flex-grow-1">
                                <div class="small fw-semibold">{{ p.name }}</div>
                                <div class="text-muted small">{{ formatPrice(p.sale_price ?? p.price) }} · остаток {{ p.stock }}</div>
                            </div>
                        </li>
                    </ul>
                </div></div>
            </div>
        </div>
    </AdminLayout>
</template>
