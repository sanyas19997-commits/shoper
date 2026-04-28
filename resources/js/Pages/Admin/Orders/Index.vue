<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({ orders: Object, statuses: Object, filters: Object })
const localFilters = reactive({
    search: props.filters?.search || '',
    status: props.filters?.status || '',
})

const apply = () => router.get('/admin/orders', {
    search: localFilters.search || undefined,
    status: localFilters.status || undefined,
}, { preserveState: true })

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)
const fmtDate = (s) => s ? new Date(s).toLocaleString('ru-RU') : ''
const statusBg = (status) => ({
    new: 'bg-secondary', processing: 'bg-info', shipped: 'bg-primary',
    completed: 'bg-success', cancelled: 'bg-danger',
}[status] || 'bg-secondary')
</script>

<template>
    <AdminLayout title="Заказы">
        <h2 class="mb-3">Заказы</h2>
        <form @submit.prevent="apply" class="row g-2 mb-3">
            <div class="col-md-5">
                <input v-model="localFilters.search" class="form-control" placeholder="Номер, имя, email или телефон">
            </div>
            <div class="col-md-4">
                <select v-model="localFilters.status" class="form-select">
                    <option value="">Все статусы</option>
                    <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
                </select>
            </div>
            <div class="col-md-3"><button class="btn btn-outline-primary w-100">Найти</button></div>
        </form>

        <div class="card border-0 shadow-sm">
            <table class="table mb-0 align-middle">
                <thead class="bg-light">
                    <tr><th class="ps-3">Номер</th><th>Покупатель</th><th>Email/Тел</th><th>Сумма</th><th>Статус</th><th>Дата</th><th></th></tr>
                </thead>
                <tbody>
                    <tr v-for="o in orders.data" :key="o.id">
                        <td class="ps-3"><strong>{{ o.number }}</strong></td>
                        <td>{{ o.customer_name }}</td>
                        <td class="small">
                            <div>{{ o.customer_email }}</div>
                            <div class="text-muted">{{ o.customer_phone }}</div>
                        </td>
                        <td>{{ formatPrice(o.total) }}</td>
                        <td><span class="badge" :class="statusBg(o.status)">{{ statuses[o.status] }}</span></td>
                        <td class="small text-muted">{{ fmtDate(o.created_at) }}</td>
                        <td><Link :href="`/admin/orders/${o.id}`" class="btn btn-sm btn-outline-primary">Открыть</Link></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <nav v-if="orders.last_page > 1" class="mt-3">
            <ul class="pagination">
                <li v-for="link in orders.links" :key="link.label" class="page-item" :class="{ active: link.active, disabled: !link.url }">
                    <Link v-if="link.url" :href="link.url" class="page-link" v-html="link.label" />
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </AdminLayout>
</template>
