<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({ orders: Array })
const page = usePage()
const user = computed(() => page.props.auth?.user)

const formatPrice = (n) => new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', maximumFractionDigits: 0 }).format(n || 0)
const fmtDate = (s) => s ? new Date(s).toLocaleString('ru-RU') : ''

const statusLabel = (status) => ({
    new: 'Новый', processing: 'В обработке', shipped: 'Отправлен',
    completed: 'Завершён', cancelled: 'Отменён',
}[status] || status)

const statusBg = (status) => ({
    new: 'bg-secondary', processing: 'bg-info', shipped: 'bg-primary',
    completed: 'bg-success', cancelled: 'bg-danger',
}[status] || 'bg-secondary')
</script>

<template>
    <StorefrontLayout title="Личный кабинет">
        <section class="section pt-30 pb-30 bg-light">
            <div class="container">
                <h1 class="mb-2">Личный кабинет</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><Link href="/">Главная</Link></li>
                        <li class="breadcrumb-item active">Личный кабинет</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="section pt-50 pb-60">
            <div class="container">
                <div class="row">
                    <aside class="col-lg-3 mb-4">
                        <div class="card border-0 shadow-sm p-3">
                            <h6 class="mb-2">{{ user?.name }}</h6>
                            <p class="small text-muted mb-3">{{ user?.email }}</p>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><Link href="/account">Мои заказы</Link></li>
                                <li class="mb-2"><Link href="/profile">Профиль</Link></li>
                                <li class="mb-2">
                                    <Link href="/logout" method="post" as="button" class="btn btn-link p-0 text-danger">Выйти</Link>
                                </li>
                            </ul>
                        </div>
                    </aside>
                    <div class="col-lg-9">
                        <h3 class="mb-3">Мои заказы</h3>
                        <div v-if="orders.length === 0" class="text-center py-5 card border-0 shadow-sm">
                            <p class="text-muted mb-3">У вас пока нет заказов</p>
                            <div><Link href="/catalog" class="btn btn-brand-3">В каталог</Link></div>
                        </div>
                        <div v-else>
                            <div v-for="order in orders" :key="order.id" class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>Заказ {{ order.number }}</strong>
                                        <span class="badge" :class="statusBg(order.status)">{{ statusLabel(order.status) }}</span>
                                    </div>
                                    <div class="text-muted small mb-2">{{ fmtDate(order.created_at) }}</div>
                                    <div class="d-flex justify-content-between">
                                        <span>{{ order.items.length }} тов.</span>
                                        <strong>{{ formatPrice(order.total) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
