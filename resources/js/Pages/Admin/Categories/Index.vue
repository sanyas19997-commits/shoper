<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({ categories: Array })

const remove = (id) => {
    if (confirm('Удалить категорию?')) router.delete(`/admin/categories/${id}`)
}
</script>

<template>
    <AdminLayout title="Категории">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="mb-0">Категории</h2>
            <Link href="/admin/categories/create" class="btn btn-primary">+ Добавить</Link>
        </div>
        <div class="card border-0 shadow-sm">
            <table class="table mb-0 align-middle">
                <thead class="bg-light">
                    <tr><th class="ps-3">Название</th><th>Slug</th><th>Активна</th><th>Товаров</th><th>Порядок</th><th></th></tr>
                </thead>
                <tbody>
                    <tr v-for="c in categories" :key="c.id">
                        <td class="ps-3"><strong>{{ c.name }}</strong></td>
                        <td class="text-muted small">{{ c.slug }}</td>
                        <td><span :class="c.is_active ? 'text-success' : 'text-muted'">{{ c.is_active ? 'Да' : 'Нет' }}</span></td>
                        <td>{{ c.products_count }}</td>
                        <td>{{ c.sort_order }}</td>
                        <td class="text-end pe-3">
                            <Link :href="`/admin/categories/${c.id}/edit`" class="btn btn-sm btn-outline-primary me-1">Изменить</Link>
                            <button @click="remove(c.id)" class="btn btn-sm btn-outline-danger">Удалить</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
