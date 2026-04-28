<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
})

const submit = () => form.post('/contact', { onSuccess: () => form.reset() })
</script>

<template>
    <StorefrontLayout title="Контакты">
        <section class="section pt-30 pb-30 bg-light">
            <div class="container">
                <h1 class="mb-2">Контакты</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><Link href="/">Главная</Link></li>
                        <li class="breadcrumb-item active">Контакты</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="section pt-50 pb-60">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <h3 class="mb-3">Напишите нам</h3>
                        <p class="text-muted">Мы ответим в течение 1 рабочего дня.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><strong>Email:</strong> <a href="mailto:info@billaro.store">info@billaro.store</a></li>
                            <li class="mb-2"><strong>Телефон:</strong> <a href="tel:+74950000000">+7 (495) 000-00-00</a></li>
                            <li class="mb-2"><strong>Адрес:</strong> Москва, Россия</li>
                            <li class="mb-2"><strong>Часы работы:</strong> ежедневно 9:00–21:00</li>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <form @submit.prevent="submit" class="card border-0 shadow-sm p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Имя *</label>
                                    <input v-model="form.name" required class="form-control" :class="{ 'is-invalid': form.errors.name }">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input v-model="form.email" type="email" required class="form-control" :class="{ 'is-invalid': form.errors.email }">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Тема *</label>
                                    <input v-model="form.subject" required class="form-control" :class="{ 'is-invalid': form.errors.subject }">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Сообщение *</label>
                                    <textarea v-model="form.message" required rows="5" class="form-control" :class="{ 'is-invalid': form.errors.message }"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" :disabled="form.processing" class="btn btn-brand-3 btn-lg">
                                        {{ form.processing ? 'Отправляем…' : 'Отправить' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
