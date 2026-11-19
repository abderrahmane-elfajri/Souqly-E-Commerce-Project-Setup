<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Seed the application's catalog database.
     */
    public function run(): void
    {
        // 1. Categories Creation
        $categoriesData = [
            [
                'slug' => 'luxury-watches',
                'icon' => '⌚',
                'sort_order' => 1,
                'translations' => [
                    'fr' => ['name' => 'Montres de Luxe', 'description' => 'Montres suisses et automatiques d\'exception.'],
                    'ar' => ['name' => 'ساعات فاخرة', 'description' => 'تشكيلة حصرية من الساعات الأوتوماتيكية والكلاسيكية.'],
                    'en' => ['name' => 'Luxury Watches', 'description' => 'Exceptional automatic and classic timepieces.'],
                ],
            ],
            [
                'slug' => 'electronics',
                'icon' => '📱',
                'sort_order' => 2,
                'translations' => [
                    'fr' => ['name' => 'Électronique & High-Tech', 'description' => 'Objets connectés, écouteurs et accessoires dernier cri.'],
                    'ar' => ['name' => 'إلكترونيات وهواتف', 'description' => 'أجهزة ذكية، سماعات وإكسسوارات عالية الجودة.'],
                    'en' => ['name' => 'Electronics & Tech', 'description' => 'Smart gadgets, wireless audio and modern accessories.'],
                ],
            ],
            [
                'slug' => 'fashion',
                'icon' => '👔',
                'sort_order' => 3,
                'translations' => [
                    'fr' => ['name' => 'Mode & Accessoires', 'description' => 'Maroquinerie marocaine et prêt-à-porter de prestige.'],
                    'ar' => ['name' => 'أزياء وموضة', 'description' => 'منتجات جلدية مغربية وأزياء عصرية راقية.'],
                    'en' => ['name' => 'Fashion & Style', 'description' => 'Moroccan leather goods and premium apparel.'],
                ],
            ],
            [
                'slug' => 'home',
                'icon' => '🏡',
                'sort_order' => 4,
                'translations' => [
                    'fr' => ['name' => 'Maison & Décoration', 'description' => 'Artisanat d\'art et décoration intérieure.'],
                    'ar' => ['name' => 'منزل وديكور', 'description' => 'تحف منزلية وديكورات تقليدية وعصرية.'],
                    'en' => ['name' => 'Home & Living', 'description' => 'Moroccan craftsmanship and modern home decor.'],
                ],
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $catData) {
            $category = Category::updateOrCreate(
                ['slug' => $catData['slug']],
                [
                    'icon' => $catData['icon'],
                    'sort_order' => $catData['sort_order'],
                    'is_active' => true,
                ]
            );

            foreach ($catData['translations'] as $locale => $trans) {
                CategoryTranslation::updateOrCreate(
                    ['category_id' => $category->id, 'locale' => $locale],
                    ['name' => $trans['name'], 'description' => $trans['description']]
                );
            }
            $categories[$catData['slug']] = $category;
        }

        // 2. Products Creation
        $productsData = [
            // Product 1: Luxury Watch
            [
                'category_slug' => 'luxury-watches',
                'sku' => 'SQL-WAT-001',
                'slug' => 'souqly-royal-chrono-41mm',
                'price' => 1890.00,
                'compare_at_price' => 2490.00,
                'stock' => 25,
                'is_featured' => true,
                'translations' => [
                    'fr' => [
                        'name' => 'Souqly Royal Chronographe Automatique 41mm',
                        'short_description' => 'Mouvement automatique japonais, verre saphir inrayable, étanchéité 10 ATM.',
                        'description' => 'La montre Souqly Royal Chronographe allie élégance intemporelle et haute précision horlogère. Son boîtier en acier inoxydable 316L abrite un mouvement automatique fiable. Livrée dans son coffret en bois laqué avec certificat de garantie 2 ans.',
                    ],
                    'ar' => [
                        'name' => 'ساعة سوقلي رويال كرونوغراف أوتوماتيك 41 مم',
                        'short_description' => 'محرك أوتوماتيكي دقيق، زجاج ياقوتي مقاوم للخدش، مقاومة للماء 10 ATM.',
                        'description' => 'تجسد ساعة سوقلي رويال كرونوغراف قمة الفخامة والدقة. مصنوعة من الفولاذ المقاوم للصدأ 316L مع قرص فاخر وتصميم هندسي مريح للمعصم. تأتي في علبة فاخرة مع شهادة ضمان لمدة سنتين وتوصيل مجاني لجميع المدن المغربية.',
                    ],
                    'en' => [
                        'name' => 'Souqly Royal Automatic Chronograph 41mm',
                        'short_description' => 'Japanese automatic movement, scratch-resistant sapphire crystal, 10 ATM water resistance.',
                        'description' => 'The Souqly Royal Chronograph merges timeless luxury with state-of-the-art precision. Crafted with 316L surgical stainless steel, it features an exhibition case back and comes with a 2-year warranty.',
                    ],
                ],
                'variants' => [
                    ['sku' => 'SQL-WAT-001-SLV', 'attributes' => ['Couleur' => 'Acier Argenté', 'Cadran' => 'Noir Profond'], 'price' => 1890.00, 'stock' => 15],
                    ['sku' => 'SQL-WAT-001-GLD', 'attributes' => ['Couleur' => 'Or Rose', 'Cadran' => 'Bleu Nuit'], 'price' => 2050.00, 'stock' => 10],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Souqly Royal Chrono Automatique 41mm', 'is_primary' => true, 'sort_order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Cadran et Mouvement Automatique', 'is_primary' => false, 'sort_order' => 2],
                    ['image_path' => 'https://images.unsplash.com/photo-1547996160-71dfabb1d48c?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Boîtier Acier Inoxydable 316L', 'is_primary' => false, 'sort_order' => 3],
                ],
            ],

            // Product 2: Classic Dress Watch
            [
                'category_slug' => 'luxury-watches',
                'sku' => 'SQL-WAT-002',
                'slug' => 'souqly-heritage-classic-gold',
                'price' => 1250.00,
                'compare_at_price' => 1600.00,
                'stock' => 18,
                'is_featured' => true,
                'translations' => [
                    'fr' => [
                        'name' => 'Souqly Héritage Classique Or & Cuir Véritable',
                        'short_description' => 'Boîtier plaqué or, bracelet en cuir véritable d\'Italie, cadran minimaliste.',
                        'description' => 'Une pièce d\'horlogerie épurée pensée pour les tenues de cérémonie et le quotidien élégant. Ultra-fine avec seulement 7.8mm d\'épaisseur.',
                    ],
                    'ar' => [
                        'name' => 'ساعة سوقلي هيريتيج كلاسيك ذهبية مع جلد طبيعي',
                        'short_description' => 'هيكل مطلي بالذهب، حزام من الجلد الطبيعي الأصيل، تصميم أنيق ونحيف.',
                        'description' => 'ساعة كلاسيكية راقية تناسب الإطلالات الرسمية واليومية. تتميز بسماكة فائقة النحافة (7.8 مم) ولمسة كلاسيكية خالدة.',
                    ],
                    'en' => [
                        'name' => 'Souqly Heritage Classic Gold & Genuine Leather',
                        'short_description' => 'Gold-plated ultra-slim case, authentic Italian leather strap, minimalist dial.',
                        'description' => 'A refined dress watch designed for weddings, business meetings, and daily sophistication.',
                    ],
                ],
                'variants' => [
                    ['sku' => 'SQL-WAT-002-BRN', 'attributes' => ['Bracelet' => 'Cuir Marron Foncé'], 'price' => 1250.00, 'stock' => 10],
                    ['sku' => 'SQL-WAT-002-BLK', 'attributes' => ['Bracelet' => 'Cuir Noir Ébène'], 'price' => 1250.00, 'stock' => 8],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Souqly Héritage Classique Or & Cuir', 'is_primary' => true, 'sort_order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Détail Bracelet Cuir Véritable', 'is_primary' => false, 'sort_order' => 2],
                ],
            ],

            // Product 3: ANC Earbuds
            [
                'category_slug' => 'electronics',
                'sku' => 'SQL-ELC-001',
                'slug' => 'souqly-air-pro-anc',
                'price' => 499.00,
                'compare_at_price' => 799.00,
                'stock' => 40,
                'is_featured' => true,
                'translations' => [
                    'fr' => [
                        'name' => 'Écouteurs Sans Fil Souqly Air Pro avec ANC',
                        'short_description' => 'Réduction de bruit active hybride, autonomie 32 heures, son spatial haute définition.',
                        'description' => 'Profitez d\'une immersion sonore totale dans les transports ou au bureau. 4 microphones intégrés pour des appels téléphoniques cristallins même dans le vent.',
                    ],
                    'ar' => [
                        'name' => 'سماعات سوقلي إير برو اللاسلكية مع عزل الضوضاء',
                        'short_description' => 'عزل نشط للضوضاء، بطارية تدوم 32 ساعة، صوت نقي ومحيطي عالي الدقة.',
                        'description' => 'استمتع بتجربة صوتية مذهلة مع ميزة إلغاء الضوضاء النشطة، وميكروفونات مدمجة متطورة لإجراء المكالمات الهاتفية بوضوح تام.',
                    ],
                    'en' => [
                        'name' => 'Souqly Air Pro Wireless ANC Earbuds',
                        'short_description' => 'Hybrid active noise cancellation, 32-hour battery life, high-res spatial audio.',
                        'description' => 'Total audio immersion engineered for daily commutes and workouts with sweat-resistant nano-coating.',
                    ],
                ],
                'variants' => [
                    ['sku' => 'SQL-ELC-001-WHT', 'attributes' => ['Finition' => 'Blanc Arctique'], 'price' => 499.00, 'stock' => 25],
                    ['sku' => 'SQL-ELC-001-BLK', 'attributes' => ['Finition' => 'Noir Mat'], 'price' => 499.00, 'stock' => 15],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Écouteurs Sans Fil Souqly Air Pro ANC', 'is_primary' => true, 'sort_order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1572536147248-ac59a8abfa4b?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Boîtier de Charge Sans Fil', 'is_primary' => false, 'sort_order' => 2],
                ],
            ],

            // Product 4: Smartwatch Ultra
            [
                'category_slug' => 'electronics',
                'sku' => 'SQL-ELC-002',
                'slug' => 'souqly-smart-titanium-ultra',
                'price' => 850.00,
                'compare_at_price' => 1190.00,
                'stock' => 30,
                'is_featured' => true,
                'translations' => [
                    'fr' => [
                        'name' => 'Montre Connectée Souqly Ultra Titane 2.0 AMOLED',
                        'short_description' => 'Écran AMOLED 2.04" ultra lumineux, appels Bluetooth, capteurs santé et GPS assisté.',
                        'description' => 'Le compagnon technologique idéal pour le sport et votre productivité. Compatible iOS et Android avec menu en Français et Arabe.',
                    ],
                    'ar' => [
                        'name' => 'ساعة سوقلي ألترا تيتانيوم الذكية بشاشة أموليد',
                        'short_description' => 'شاشة أموليد 2.04 بوصة، مكالمات بلوتوث مباشرة، قياس نبضات القلب والأنشطة الرياضية.',
                        'description' => 'الساعة الذكية الأقوى لرياضتك ويومياتك، متوافقة تماماً مع جميع هواتف آيفون وأندرويد مع دعم كامل للغة العربية.',
                    ],
                    'en' => [
                        'name' => 'Souqly Smart Watch Ultra Titanium 2.0 AMOLED',
                        'short_description' => 'Bright 2.04" AMOLED screen, Bluetooth calling, comprehensive fitness tracking.',
                        'description' => 'Durable titanium chassis with high-res AMOLED display and water-resistant sports straps.',
                    ],
                ],
                'variants' => [
                    ['sku' => 'SQL-ELC-002-ORG', 'attributes' => ['Bracelet' => 'Silicone Orange Sport'], 'price' => 850.00, 'stock' => 18],
                    ['sku' => 'SQL-ELC-002-BLK', 'attributes' => ['Bracelet' => 'Silicone Noir Nuit'], 'price' => 850.00, 'stock' => 12],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Montre Connectée Souqly Ultra Titane', 'is_primary' => true, 'sort_order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Écran AMOLED Tactile HD', 'is_primary' => false, 'sort_order' => 2],
                ],
            ],

            // Product 5: Handcrafted Moroccan Leather Bag
            [
                'category_slug' => 'fashion',
                'sku' => 'SQL-FAS-001',
                'slug' => 'sac-cuir-marocain-artisan',
                'price' => 690.00,
                'compare_at_price' => 890.00,
                'stock' => 14,
                'is_featured' => true,
                'translations' => [
                    'fr' => [
                        'name' => 'Sac Cabas en Cuir Véritable Tanné Végétal',
                        'short_description' => 'Cuir noble marocain tanné traditionnellement, finitions coutures main renforcées.',
                        'description' => 'Confectionné par les maîtres artisans maroquiniers de Marrakech. Un cuir naturel qui développe une splendide patine avec le temps.',
                    ],
                    'ar' => [
                        'name' => 'حقيبة كتف من الجلد الطبيعي المغربي المدبوغ نباتياً',
                        'short_description' => 'جلد مغربي أصيل مدبوغ تقليدياً، خياطة يدوية متقونة وعالية المتانة.',
                        'description' => 'صُنعت بحرفية عالية على يد أمهر معلمي الصناعة التقليدية بمراكش، جلد طبيعي 100% يزداد بهاءً مع مرور السنين.',
                    ],
                    'en' => [
                        'name' => 'Artisanal Moroccan Vegetable-Tanned Leather Tote Bag',
                        'short_description' => 'Authentic Moroccan full-grain leather, reinforced hand-stitching.',
                        'description' => 'Handcrafted by master artisans in Marrakech using century-old vegetable tanning traditions.',
                    ],
                ],
                'variants' => [
                    ['sku' => 'SQL-FAS-001-COGNAC', 'attributes' => ['Couleur' => 'Cognac Vintage'], 'price' => 690.00, 'stock' => 8],
                    ['sku' => 'SQL-FAS-001-CHOCO', 'attributes' => ['Couleur' => 'Chocolat Noir'], 'price' => 690.00, 'stock' => 6],
                ],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Sac Cabas Cuir Véritable Artisanal', 'is_primary' => true, 'sort_order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Détail Cuir Noble Pleine Fleur', 'is_primary' => false, 'sort_order' => 2],
                ],
            ],

            // Product 6: Fes Ceramic Tagine Set
            [
                'category_slug' => 'home',
                'sku' => 'SQL-HOM-001',
                'slug' => 'service-tajine-design-contemporain',
                'price' => 380.00,
                'compare_at_price' => 450.00,
                'stock' => 20,
                'is_featured' => false,
                'translations' => [
                    'fr' => [
                        'name' => 'Service à Tajine en Céramique Artisanale de Fès',
                        'short_description' => 'Céramique émaillée alimentaire, motifs contemporains peints à la main.',
                        'description' => 'L\'alliance parfaite entre tradition potière marocaine et lignes modernes pour vos tables de fête et réceptions.',
                    ],
                    'ar' => [
                        'name' => 'طقم طاجين فاسي عصري من الفخار المطلي يدوياً',
                        'short_description' => 'فخار صحي عالي الجودة، زخارف فاسية يدوية بلمسة هندسية عصرية.',
                        'description' => 'يجمع بين التراث الخزفي العريق لمدينة فاس والتصاميم الحديثة ليضفي لمسة مغربية ساحرة على مائدتكم.',
                    ],
                    'en' => [
                        'name' => 'Contemporary Fes Hand-Painted Ceramic Tagine Set',
                        'short_description' => 'Food-grade glazed terracotta, handcrafted geometric patterns.',
                        'description' => 'A fusion of centuries-old pottery heritage and modern design for festive gatherings.',
                    ],
                ],
                'variants' => [],
                'images' => [
                    ['image_path' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Service Tajine Céramique de Fès', 'is_primary' => true, 'sort_order' => 1],
                    ['image_path' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?auto=format&fit=crop&w=1200&q=85', 'alt_text' => 'Motifs Fassis Contemporains Peints à la Main', 'is_primary' => false, 'sort_order' => 2],
                ],
            ],
        ];

        foreach ($productsData as $prodData) {
            $category = $categories[$prodData['category_slug']];

            $product = Product::updateOrCreate(
                ['sku' => $prodData['sku']],
                [
                    'category_id' => $category->id,
                    'slug' => $prodData['slug'],
                    'price' => $prodData['price'],
                    'compare_at_price' => $prodData['compare_at_price'],
                    'stock' => $prodData['stock'],
                    'is_featured' => $prodData['is_featured'],
                    'status' => 'active',
                ]
            );

            // Seed Translations
            foreach ($prodData['translations'] as $locale => $trans) {
                ProductTranslation::updateOrCreate(
                    ['product_id' => $product->id, 'locale' => $locale],
                    [
                        'name' => $trans['name'],
                        'short_description' => $trans['short_description'],
                        'description' => $trans['description'],
                    ]
                );
            }

            // Seed Variants
            foreach ($prodData['variants'] as $varData) {
                ProductVariant::updateOrCreate(
                    ['sku' => $varData['sku']],
                    [
                        'product_id' => $product->id,
                        'attributes' => $varData['attributes'],
                        'price' => $varData['price'],
                        'stock' => $varData['stock'],
                        'is_active' => true,
                    ]
                );
            }

            // Seed Real High-Res Photography Images
            foreach ($prodData['images'] ?? [] as $imgData) {
                ProductImage::updateOrCreate(
                    ['product_id' => $product->id, 'image_path' => $imgData['image_path']],
                    [
                        'alt_text' => $imgData['alt_text'],
                        'is_primary' => $imgData['is_primary'],
                        'sort_order' => $imgData['sort_order'],
                    ]
                );
            }
        }
    }
}
