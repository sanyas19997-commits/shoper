<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({ product: Object, categories: Array })

const form = useForm({
    category_id: props.product?.category_id || '',
    name: props.product?.name || '',
    slug: props.product?.slug || '',
    sku: props.product?.sku || '',
    brand: props.product?.brand || '',
    short_description: props.product?.short_description || '',
    description: props.product?.description || '',
    price: props.product?.price || '',
    sale_price: props.product?.sale_price || '',
    stock: props.product?.stock ?? 0,
    is_active: props.product?.is_active ?? true,
    is_featured: props.product?.is_featured ?? false,
    is_new: props.product?.is_new ?? false,
    sort_order: props.product?.sort_order ?? 0,
    images: [],
    _method: props.product ? 'put' : 'post',
})

const submit = () => {
    if (props.product) {
        form.post(`/admin/products/${props.product.id}`, { forceFormData: true })
    } else {
        form.post('/admin/products', { forceFormData: true })
    }
}

const removeImage = (id) => {
    if (confirm('Удалить изображение?')) router.delete(`/admin/product-images/${id}`, { preserveScroll: true })
}
</script>

<template>
    <AdminLayout :title="product ? `Редактирование: ${product.name}` : 'Новый товар'">
        <form @submit.prevent="submit">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 mb-3">
                        <div class="mb-3">
                            <label class="form-label">Название *</label>
                            <input v-model="form.name" required class="form-control" :class="{ 'is-invalid': form.errors.name }">
                            <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input v-model="form.slug" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Артикул</label>
                                <input v-model="form.sku" class="form-control" :class="{ 'is-invalid': form.errors.sku }">
                                <div v-if="form.errors.sku" class="invalid-feedback">{{ form.errors.sku }}</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Бренд</label>
                                <input v-model="form.brand" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Категория</label>
                                <select v-model="form.category_id" class="form-select">
                                    <option value="">— Не выбрана —</option>
                                    <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Краткое описание</label>
                            <textarea v-model="form.short_description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание (HTML)</label>
                            <textarea v-model="form.description" class="form-control" rows="8"></textarea>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-4 mb-3">
                        <h5 class="mb-3">Изображения</h5>
                        <div class="row g-2 mb-3" v-if="product?.images?.length">
                            <div v-for="img in product.images" :key="img.id" class="col-md-3 col-6">
                                <div class="position-relative">
                                    <img :src="img.url" :alt="img.alt" class="img-fluid rounded border">
                                    <button type="button" @click="removeImage(img.id)" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1">×</button>
                                    <div v-if="img.is_main" class="position-absolute bottom-0 start-0 m-1 badge bg-success">Главное</div>
                                </div>
                            </div>
                        </div>
                        <input type="file" multiple @change="e => form.images = Array.from(e.target.files)" class="form-control" accept="image/*">
                        <div class="form-text">Можно загрузить несколько файлов одновременно.</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 mb-3">
                        <h5 class="mb-3">Цена и наличие</h5>
                        <div class="mb-3">
                            <label class="form-label">Цена, ₽ *</label>
                            <input type="number" step="0.01" v-model="form.price" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Цена со скидкой, ₽</label>
                            <input type="number" step="0.01" v-model="form.sale_price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Остаток *</label>
                            <input type="number" v-model="form.stock" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Сортировка</label>
                            <input type="number" v-model="form.sort_order" class="form-control">
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-4 mb-3">
                        <h5 class="mb-3">Статус</h5>
                        <div class="form-check mb-2">
                            <input type="checkbox" v-model="form.is_active" id="p_active" class="form-check-input">
                            <label class="form-check-label" for="p_active">Опубликован</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" v-model="form.is_featured" id="p_featured" class="form-check-input">
                            <label class="form-check-label" for="p_featured">Хит продаж</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" v-model="form.is_new" id="p_new" class="form-check-input">
                            <label class="form-check-label" for="p_new">Новинка</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <Link href="/admin/products" class="btn btn-outline-secondary">← Назад</Link>
                        <button type="submit" :disabled="form.processing" class="btn btn-primary">
                            {{ form.processing ? 'Сохраняем...' : 'Сохранить' }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
