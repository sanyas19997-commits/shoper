<script setup>
import StorefrontLayout from '@/Layouts/StorefrontLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <StorefrontLayout title="О магазине">
        <section class="section pt-30 pb-30 bg-light">
            <div class="container">
                <h1 class="mb-2">О нашем магазине</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><Link href="/">Главная</Link></li>
                        <li class="breadcrumb-item active">О нас</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="section pt-50 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <h2 class="mb-3">Качественные товары для&nbsp;счастливого детства</h2>
                        <p class="lead">Billaro Store — это магазин товаров для детей, в&nbsp;котором собрано всё самое нужное и&nbsp;интересное: от&nbsp;игрушек и&nbsp;книг до&nbsp;одежды и&nbsp;средств по&nbsp;уходу.</p>
                        <p>Мы тщательно отбираем поставщиков, проверяем сертификаты и&nbsp;следим за&nbsp;тем, чтобы каждый товар был безопасен. Наша команда — это родители, которые понимают, как важно дать ребёнку только лучшее.</p>
                        <ul>
                            <li>Большой ассортимент: тысячи позиций в&nbsp;каталоге</li>
                            <li>Безопасные сертифицированные материалы</li>
                            <li>Доставка по&nbsp;всей России</li>
                            <li>Возврат в&nbsp;течение 14&nbsp;дней без&nbsp;объяснений</li>
                            <li>Поддержка клиентов 7&nbsp;дней в&nbsp;неделю</li>
                        </ul>
                        <Link href="/catalog" class="btn btn-brand-3 btn-lg mt-3">Перейти в каталог</Link>
                    </div>
                    <div class="col-lg-5">
                        <img src="/kidify/imgs/page/homepage1/bg-kid.png" alt="" class="img-fluid rounded-3">
                    </div>
                </div>
            </div>
        </section>
    </StorefrontLayout>
</template>
