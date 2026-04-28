<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({ user: Object })

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone || '',
    is_admin: !!props.user.is_admin,
    password: '',
})

const submit = () => form.put(`/admin/users/${props.user.id}`)
</script>

<template>
    <AdminLayout :title="`Пользователь: ${user.name}`">
        <form @submit.prevent="submit" class="card border-0 shadow-sm p-4" style="max-width: 700px">
            <div class="mb-3">
                <label class="form-label">Имя *</label>
                <input v-model="form.name" required class="form-control" :class="{ 'is-invalid': form.errors.name }">
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input v-model="form.email" type="email" required class="form-control" :class="{ 'is-invalid': form.errors.email }">
            </div>
            <div class="mb-3">
                <label class="form-label">Телефон</label>
                <input v-model="form.phone" class="form-control">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" v-model="form.is_admin" id="u_admin" class="form-check-input">
                <label class="form-check-label" for="u_admin">Администратор</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Новый пароль</label>
                <input type="password" v-model="form.password" class="form-control" placeholder="Оставьте пустым, чтобы не менять">
            </div>
            <div class="d-flex justify-content-between">
                <Link href="/admin/users" class="btn btn-outline-secondary">← Назад</Link>
                <button type="submit" :disabled="form.processing" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </AdminLayout>
</template>
