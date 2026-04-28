<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({ category: Object, parents: Array })

const form = useForm({
    name: props.category?.name || '',
    slug: props.category?.slug || '',
    parent_id: props.category?.parent_id || '',
    description: props.category?.description || '',
    is_active: props.category?.is_active ?? true,
    sort_order: props.category?.sort_order ?? 0,
    image: null,
    _method: props.category ? 'put' : 'post',
})

const submit = () => {
    if (props.category) {
        form.post(`/admin/categories/${props.category.id}`, { forceFormData: true })
    } else {
        form.post('/admin/categories', { forceFormData: true })
    }
}
</script>

<template>
    <AdminLayout :title="category ? 'Редактирование категории' : 'Новая категория'">
        <form @submit.prevent="submit" class="card border-0 shadow-sm p-4" style="max-width: 800px">
            <div class="mb-3">
                <label class="form-label">Название *</label>
                <input v-model="form.name" required class="form-control" :class="{ 'is-invalid': form.errors.name }">
                <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input v-model="form.slug" class="form-control" placeholder="генерируется автоматически">
            </div>
            <div class="mb-3">
                <label class="form-label">Родительская категория</label>
                <select v-model="form.parent_id" class="form-select">
                    <option value="">— Нет —</option>
                    <option v-for="p in parents" :key="p.id" :value="p.id">{{ p.name }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea v-model="form.description" class="form-control" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Изображение</label>
                <input type="file" @change="e => form.image = e.target.files[0]" class="form-control" accept="image/*">
                <div v-if="category?.image" class="mt-2"><img :src="`/storage/${category.image}`" alt="" style="max-height:80px"></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Порядок</label>
                    <input type="number" v-model="form.sort_order" class="form-control">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" v-model="form.is_active" id="cat_active" class="form-check-input">
                        <label class="form-check-label" for="cat_active">Активна</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <Link href="/admin/categories" class="btn btn-outline-secondary">← Назад</Link>
                <button type="submit" :disabled="form.processing" class="btn btn-primary">
                    {{ form.processing ? 'Сохраняем...' : 'Сохранить' }}
                </button>
            </div>
        </form>
    </AdminLayout>
</template>
