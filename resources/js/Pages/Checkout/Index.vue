<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    summary: Object,
    user: Object,
})

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)

const form = useForm({
    customer_name: props.user?.name || '',
    customer_email: props.user?.email || '',
    customer_phone: props.user?.phone || '',
    shipping_city: '',
    shipping_postcode: '',
    shipping_street: '',
    shipping_apartment: '',
    payment_method: 'cod',
    shipping_method: 'courier',
    notes: '',
})

const submit = () => form.post('/checkout')
</script>

<template>
    <StorefrontLayout title="Оформление заказа">
        <section class="section pt-30 pb-30 bg-light">
            <div class="container">
                <h1 class="mb-2">Оформление заказа</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><Link href="/">Главная</Link></li>
                        <li class="breadcrumb-item"><Link href="/cart">Корзина</Link></li>
                        <li class="breadcrumb-item active">Оформление</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section class="section pt-50 pb-60">
            <div class="container">
                <div v-if="summary.items.length === 0" class="text-center py-5">
                    <h3>Корзина пуста</h3>
                    <Link href="/catalog" class="btn btn-brand-3 mt-3">В каталог</Link>
                </div>
                <form v-else @submit.prevent="submit" class="row">
                    <div class="col-lg-8 mb-4">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-4">
                                <h5 class="mb-3">Контактные данные</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">ФИО *</label>
                                        <input v-model="form.customer_name" required class="form-control" :class="{ 'is-invalid': form.errors.customer_name }">
                                        <div v-if="form.errors.customer_name" class="invalid-feedback">{{ form.errors.customer_name }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <input v-model="form.customer_email" type="email" required class="form-control" :class="{ 'is-invalid': form.errors.customer_email }">
                                        <div v-if="form.errors.customer_email" class="invalid-feedback">{{ form.errors.customer_email }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Телефон</label>
                                        <input v-model="form.customer_phone" class="form-control" placeholder="+7 (___) ___-__-__">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-4">
                                <h5 class="mb-3">Адрес доставки</h5>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label">Город *</label>
                                        <input v-model="form.shipping_city" required class="form-control" :class="{ 'is-invalid': form.errors.shipping_city }">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Индекс</label>
                                        <input v-model="form.shipping_postcode" class="form-control">
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-label">Улица, дом *</label>
                                        <input v-model="form.shipping_street" required class="form-control" :class="{ 'is-invalid': form.errors.shipping_street }">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Квартира</label>
                                        <input v-model="form.shipping_apartment" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-4">
                                <h5 class="mb-3">Доставка и оплата</h5>
                                <div class="mb-3">
                                    <label class="form-label">Способ доставки</label>
                                    <div class="form-check">
                                        <input v-model="form.shipping_method" type="radio" value="courier" id="ship_courier" class="form-check-input">
                                        <label class="form-check-label" for="ship_courier">Курьер по адресу</label>
                                    </div>
                                    <div class="form-check">
                                        <input v-model="form.shipping_method" type="radio" value="pickup" id="ship_pickup" class="form-check-input">
                                        <label class="form-check-label" for="ship_pickup">Самовывоз</label>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Способ оплаты</label>
                                    <div class="form-check">
                                        <input v-model="form.payment_method" type="radio" value="cod" id="pay_cod" class="form-check-input">
                                        <label class="form-check-label" for="pay_cod">Наличными при получении</label>
                                    </div>
                                    <div class="form-check">
                                        <input v-model="form.payment_method" type="radio" value="card" id="pay_card" class="form-check-input">
                                        <label class="form-check-label" for="pay_card">Картой курьеру</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <label class="form-label">Комментарий к заказу</label>
                                <textarea v-model="form.notes" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 20px">
                            <div class="card-body p-4">
                                <h5 class="mb-3">Ваш заказ</h5>
                                <ul class="list-unstyled mb-3">
                                    <li v-for="item in summary.items" :key="item.product_id" class="d-flex justify-content-between mb-2">
                                        <span>{{ item.name }} × {{ item.quantity }}</span>
                                        <strong>{{ formatPrice(item.total) }}</strong>
                                    </li>
                                </ul>
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Сумма</span>
                                    <span>{{ formatPrice(summary.subtotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>К оплате</strong>
                                    <strong class="fs-5">{{ formatPrice(summary.total) }}</strong>
                                </div>
                                <button type="submit" :disabled="form.processing" class="btn btn-brand-3 w-100">
                                    {{ form.processing ? 'Оформляем...' : 'Подтвердить заказ' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </StorefrontLayout>
</template>
