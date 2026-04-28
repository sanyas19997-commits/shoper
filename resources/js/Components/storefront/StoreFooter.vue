<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const categories = computed(() => page.props.categoriesNav || [])
const year = new Date().getFullYear()
</script>

<template>
    <footer class="footer">
        <div class="container">
            <div class="row pt-50 pb-50">
                <div class="col-md-4 mb-30">
                    <Link class="d-block mb-20" href="/">
                        <img alt="Billaro Store" src="/kidify/imgs/template/logo.svg" style="max-height: 50px">
                    </Link>
                    <p class="font-md color-gray-500">Магазин качественных детских товаров. Доставка по всей России. Возврат и обмен в течение 14 дней.</p>
                    <div class="mt-20 d-flex gap-2 flex-wrap">
                        <Link class="btn btn-line-bottom" href="/contact">Контакты</Link>
                        <Link class="btn btn-line-bottom" href="/about">О нас</Link>
                    </div>
                </div>
                <div class="col-md-3 mb-30">
                    <h4 class="font-lg-bold mb-20">Каталог</h4>
                    <ul class="menu-footer">
                        <li v-for="c in categories" :key="c.id" class="mb-10">
                            <Link :href="`/catalog/${c.slug}`">{{ c.name }}</Link>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 mb-30">
                    <h4 class="font-lg-bold mb-20">Покупателю</h4>
                    <ul class="menu-footer">
                        <li class="mb-10"><Link href="/account">Личный кабинет</Link></li>
                        <li class="mb-10"><Link href="/cart">Корзина</Link></li>
                        <li class="mb-10"><Link href="/checkout">Оформление</Link></li>
                        <li class="mb-10"><Link href="/about">О магазине</Link></li>
                        <li class="mb-10"><Link href="/contact">Контакты</Link></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-30">
                    <h4 class="font-lg-bold mb-20">Связь</h4>
                    <p class="mb-10">Email: <a href="mailto:info@billaro.store">info@billaro.store</a></p>
                    <p class="mb-10">Телефон: <a href="tel:+74950000000">+7 (495) 000-00-00</a></p>
                    <p class="mb-10">Москва, Россия</p>
                </div>
            </div>
            <div class="row pt-30 pb-30 border-top">
                <div class="col-12 text-center">
                    <p class="font-md color-gray-500 mb-0">© {{ year }} Billaro Store. Все права защищены.</p>
                </div>
            </div>
        </div>
    </footer>
</template>
