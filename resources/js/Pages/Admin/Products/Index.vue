<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({ products: Object, categories: Array, filters: Object })

const localFilters = reactive({
    search: props.filters?.search || '',
    category_id: props.filters?.category_id || '',
})

const apply = () => router.get('/admin/products', {
    search: localFilters.search || undefined,
    category_id: localFilters.category_id || undefined,
}, { preserveState: true })

const remove = (id) => {
    if (confirm('Удалить товар?')) router.delete(`/admin/products/${id}`)
}

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)
</script>

<template>
    <AdminLayout title="Товары">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="mb-0">Товары</h2>
            <Link href="/admin/products/create" class="btn btn-primary">+ Добавить товар</Link>
        </div>

        <form @submit.prevent="apply" class="row g-2 mb-3">
            <div class="col-md-5">
                <input v-model="localFilters.search" type="search" class="form-control" placeholder="Поиск по названию или артикулу">
            </div>
            <div class="col-md-4">
                <select v-model="localFilters.category_id" class="form-select">
                    <option value="">Все категории</option>
                    <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                </select>
            </div>
            <div class="col-md-3"><button class="btn btn-outline-primary w-100">Найти</button></div>
        </form>

        <div class="card border-0 shadow-sm">
            <table class="table mb-0 align-middle">
                <thead class="bg-light">
                    <tr><th></th><th class="ps-3">Название</th><th>Артикул</th><th>Категория</th><th>Цена</th><th>Остаток</th><th>Активен</th><th></th></tr>
                </thead>
                <tbody>
                    <tr v-for="p in products.data" :key="p.id">
                        <td class="ps-3" style="width: 60px">
                            <img v-if="p.main_image?.url" :src="p.main_image.url" alt="" style="width:48px;height:48px;object-fit:cover" class="rounded">
                        </td>
                        <td><strong>{{ p.name }}</strong><div class="text-muted small">{{ p.slug }}</div></td>
                        <td>{{ p.sku }}</td>
                        <td>{{ p.category?.name || '—' }}</td>
                        <td>{{ formatPrice(p.sale_price ?? p.price) }}</td>
                        <td>{{ p.stock }}</td>
                        <td><span :class="p.is_active ? 'text-success' : 'text-muted'">{{ p.is_active ? 'Да' : 'Нет' }}</span></td>
                        <td class="text-end pe-3">
                            <Link :href="`/admin/products/${p.id}/edit`" class="btn btn-sm btn-outline-primary me-1">Изменить</Link>
                            <button @click="remove(p.id)" class="btn btn-sm btn-outline-danger">Удалить</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <nav v-if="products.last_page > 1" class="mt-3">
            <ul class="pagination">
                <li v-for="link in products.links" :key="link.label" class="page-item" :class="{ active: link.active, disabled: !link.url }">
                    <Link v-if="link.url" :href="link.url" class="page-link" v-html="link.label" />
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </AdminLayout>
</template>
