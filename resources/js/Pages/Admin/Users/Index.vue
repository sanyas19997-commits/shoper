<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({ users: Object, filters: Object })
const localFilters = reactive({ search: props.filters?.search || '' })

const apply = () => router.get('/admin/users', { search: localFilters.search || undefined }, { preserveState: true })
const remove = (id) => { if (confirm('Удалить пользователя?')) router.delete(`/admin/users/${id}`) }

const fmtDate = (s) => s ? new Date(s).toLocaleDateString('ru-RU') : ''
</script>

<template>
    <AdminLayout title="Пользователи">
        <h2 class="mb-3">Пользователи</h2>
        <form @submit.prevent="apply" class="row g-2 mb-3">
            <div class="col-md-9"><input v-model="localFilters.search" class="form-control" placeholder="Поиск по имени или email"></div>
            <div class="col-md-3"><button class="btn btn-outline-primary w-100">Найти</button></div>
        </form>

        <div class="card border-0 shadow-sm">
            <table class="table mb-0 align-middle">
                <thead class="bg-light">
                    <tr><th class="ps-3">Имя</th><th>Email</th><th>Телефон</th><th>Админ</th><th>Регистрация</th><th></th></tr>
                </thead>
                <tbody>
                    <tr v-for="u in users.data" :key="u.id">
                        <td class="ps-3"><strong>{{ u.name }}</strong></td>
                        <td>{{ u.email }}</td>
                        <td>{{ u.phone || '—' }}</td>
                        <td><span :class="u.is_admin ? 'text-success' : 'text-muted'">{{ u.is_admin ? 'Да' : 'Нет' }}</span></td>
                        <td class="small text-muted">{{ fmtDate(u.created_at) }}</td>
                        <td class="text-end pe-3">
                            <Link :href="`/admin/users/${u.id}/edit`" class="btn btn-sm btn-outline-primary me-1">Изменить</Link>
                            <button @click="remove(u.id)" class="btn btn-sm btn-outline-danger">Удалить</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
