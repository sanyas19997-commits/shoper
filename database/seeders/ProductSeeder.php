<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            // Игрушки
            ['cat' => 'igrushki', 'name' => 'Конструктор «Город приключений»', 'brand' => 'Kidify', 'price' => 3490, 'sale' => 2790, 'stock' => 25, 'featured' => true, 'new' => true],
            ['cat' => 'igrushki', 'name' => 'Деревянная пирамидка «Радуга»', 'brand' => 'WoodPlay', 'price' => 1290, 'sale' => null, 'stock' => 60, 'featured' => true],
            ['cat' => 'igrushki', 'name' => 'Мягкая игрушка «Слонёнок Тимоша»', 'brand' => 'PlushFriends', 'price' => 990, 'sale' => 790, 'stock' => 80, 'new' => true],
            ['cat' => 'igrushki', 'name' => 'Развивающий куб «Умные грани»', 'brand' => 'Kidify', 'price' => 2190, 'sale' => null, 'stock' => 35, 'featured' => true],
            ['cat' => 'igrushki', 'name' => 'Набор машинок «Гонки»', 'brand' => 'SpeedKid', 'price' => 1490, 'sale' => 1190, 'stock' => 45],
            ['cat' => 'igrushki', 'name' => 'Кукла «Анна» с гардеробом', 'brand' => 'PrettyDoll', 'price' => 2790, 'sale' => null, 'stock' => 20, 'new' => true],

            // Одежда
            ['cat' => 'odezhda', 'name' => 'Комбинезон демисезонный', 'brand' => 'BabyComfort', 'price' => 3990, 'sale' => 2990, 'stock' => 30, 'featured' => true, 'new' => true],
            ['cat' => 'odezhda', 'name' => 'Платье «Принцесса» с пайетками', 'brand' => 'PrettyDoll', 'price' => 2490, 'sale' => null, 'stock' => 18],
            ['cat' => 'odezhda', 'name' => 'Футболка хлопок «Динозаврик»', 'brand' => 'Kidify', 'price' => 690, 'sale' => 490, 'stock' => 150, 'featured' => true],
            ['cat' => 'odezhda', 'name' => 'Джинсы детские «Классика»', 'brand' => 'JeansKid', 'price' => 1890, 'sale' => null, 'stock' => 50],
            ['cat' => 'odezhda', 'name' => 'Куртка тёплая зимняя', 'brand' => 'WarmKids', 'price' => 4990, 'sale' => 3990, 'stock' => 22, 'new' => true],

            // Аксессуары
            ['cat' => 'aksessuary', 'name' => 'Рюкзак детский «Космос»', 'brand' => 'Kidify', 'price' => 1990, 'sale' => null, 'stock' => 40, 'featured' => true, 'new' => true],
            ['cat' => 'aksessuary', 'name' => 'Шапочка вязаная с помпоном', 'brand' => 'WarmKids', 'price' => 590, 'sale' => 390, 'stock' => 90],
            ['cat' => 'aksessuary', 'name' => 'Перчатки тёплые', 'brand' => 'WarmKids', 'price' => 490, 'sale' => null, 'stock' => 100],
            ['cat' => 'aksessuary', 'name' => 'Очки солнцезащитные детские', 'brand' => 'SunnyKid', 'price' => 890, 'sale' => 690, 'stock' => 60, 'new' => true],

            // Обувь
            ['cat' => 'obuv', 'name' => 'Кроссовки «Скорость»', 'brand' => 'SpeedKid', 'price' => 2790, 'sale' => 2290, 'stock' => 35, 'featured' => true],
            ['cat' => 'obuv', 'name' => 'Сандалии летние', 'brand' => 'BabyComfort', 'price' => 1690, 'sale' => null, 'stock' => 50, 'new' => true],
            ['cat' => 'obuv', 'name' => 'Сапоги резиновые', 'brand' => 'RainKid', 'price' => 1290, 'sale' => 990, 'stock' => 70],

            // Книги и развитие
            ['cat' => 'knigi-i-razvitie', 'name' => 'Книга «Сказки для малышей»', 'brand' => 'Kidify Books', 'price' => 690, 'sale' => null, 'stock' => 200, 'featured' => true],
            ['cat' => 'knigi-i-razvitie', 'name' => 'Раскраска «Животный мир»', 'brand' => 'ArtKid', 'price' => 290, 'sale' => 190, 'stock' => 300],
            ['cat' => 'knigi-i-razvitie', 'name' => 'Магнитная азбука', 'brand' => 'Kidify', 'price' => 1490, 'sale' => null, 'stock' => 40, 'new' => true],

            // Уход за малышом
            ['cat' => 'uhod-za-malyshom', 'name' => 'Набор детских полотенец', 'brand' => 'BabyComfort', 'price' => 1190, 'sale' => 890, 'stock' => 60, 'featured' => true],
            ['cat' => 'uhod-za-malyshom', 'name' => 'Шампунь без слёз 250 мл', 'brand' => 'KidsCare', 'price' => 390, 'sale' => null, 'stock' => 150],
            ['cat' => 'uhod-za-malyshom', 'name' => 'Бутылочка для кормления', 'brand' => 'BabyComfort', 'price' => 490, 'sale' => null, 'stock' => 120, 'new' => true],
        ];

        $productImagesPool = [];
        for ($i = 1; $i <= 29; $i++) {
            $productImagesPool[] = "kidify/imgs/page/homepage1/product{$i}.png";
        }

        $detailImages = [
            'kidify/imgs/page/product/img.png',
            'kidify/imgs/page/product/img-2.png',
            'kidify/imgs/page/product/img-3.png',
            'kidify/imgs/page/product/img-4.png',
            'kidify/imgs/page/product/img-5.png',
            'kidify/imgs/page/product/img-6.png',
        ];

        foreach ($catalog as $idx => $row) {
            $category = Category::where('slug', $row['cat'])->first();

            $product = Product::create([
                'category_id' => $category?->id,
                'name' => $row['name'],
                'slug' => Str::slug($row['name'].'-'.uniqid()),
                'sku' => 'BS-'.str_pad((string) ($idx + 1), 4, '0', STR_PAD_LEFT),
                'brand' => $row['brand'],
                'short_description' => 'Качественный товар для вашего ребёнка. Безопасные материалы, проверенный производитель, быстрая доставка.',
                'description' => $this->buildDescription($row['name']),
                'price' => $row['price'],
                'sale_price' => $row['sale'] ?? null,
                'stock' => $row['stock'],
                'is_active' => true,
                'is_featured' => $row['featured'] ?? false,
                'is_new' => $row['new'] ?? false,
                'sort_order' => $idx + 1,
                'attributes' => [
                    'sizes' => ['XS', 'S', 'M', 'L'],
                    'colors' => ['красный', 'синий', 'зелёный'],
                ],
            ]);

            $mainImg = $productImagesPool[$idx % count($productImagesPool)];
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $mainImg,
                'alt' => $product->name,
                'is_main' => true,
                'sort_order' => 0,
            ]);

            // Дополнительные картинки для страницы товара
            foreach (array_slice($detailImages, 0, 3) as $j => $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $img,
                    'alt' => $product->name.' #'.($j + 2),
                    'is_main' => false,
                    'sort_order' => $j + 1,
                ]);
            }
        }
    }

    private function buildDescription(string $name): string
    {
        return <<<HTML
<p>{$name} — отличный выбор для вашего ребёнка. Изделие выполнено из безопасных гипоаллергенных материалов и прошло все необходимые сертификации.</p>
<ul>
  <li>Безопасные материалы (без BPA, без фталатов)</li>
  <li>Проверенное качество и долгий срок службы</li>
  <li>Подходит для повседневного использования</li>
  <li>Простая чистка и уход</li>
</ul>
<p>Подробные характеристики, размерная сетка и инструкция по уходу — на вкладке «Описание». Если у вас есть вопросы, свяжитесь с нами через раздел «Контакты».</p>
HTML;
    }
}
