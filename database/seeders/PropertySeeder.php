<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Lead;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create or Find an Agent User
        $agent = User::firstOrCreate(
            ['email' => 'agente@inmobiliaria.com'],
            [
                'name' => 'Carlos Mendoza',
                'password' => Hash::make('password123'),
                'role' => 'agent',
            ]
        );

        // 2. Create or Find a Buyer User (for leads)
        $buyer = User::firstOrCreate(
            ['email' => 'comprador@correo.com'],
            [
                'name' => 'Lucía Gómez',
                'password' => Hash::make('password123'),
                'role' => 'buyer',
            ]
        );

        // 3. Seed Properties
        $properties = [
            [
                'title' => 'Chalet Exclusivo con Piscina en La Moraleja',
                'description' => 'Espectacular chalet independiente de 500m² construidos sobre parcela de 2.000m². Cuenta con piscina privada, jardín de diseño, 5 habitaciones con baño en suite, cocina americana y acabados premium de mármol y madera noble.',
                'price' => 1250000.00,
                'address' => 'Paseo de la Marquesa Viuda de Aldama, 28109 Alcobendas, Madrid, España',
                'latitude' => 40.51860000,
                'longitude' => -3.63390000,
                'type' => 'house',
                'status' => 'available',
                'images' => ['properties/sample_chalet_1.jpg', 'properties/sample_chalet_2.jpg'],
            ],
            [
                'title' => 'Ático Moderno con Terraza en Gran Vía',
                'description' => 'Increíble ático de diseño de 120m² con terraza privada de 40m² y vistas panorámicas de la ciudad. Completamente reformado con domótica avanzada, aire acondicionado, suelo radiante y plaza de garaje incluida.',
                'price' => 680000.00,
                'address' => 'Calle de la Gran Vía, 32, 28013 Madrid, España',
                'latitude' => 40.42030000,
                'longitude' => -3.70310000,
                'type' => 'apartment',
                'status' => 'available',
                'images' => ['properties/sample_atico_1.jpg'],
            ],
            [
                'title' => 'Local Comercial Estratégico en Plaza Mayor',
                'description' => 'Excelente local comercial a pie de calle en zona de altísimo tránsito peatonal y turístico. 150m² distribuidos en dos plantas, amplia fachada acristalada para escaparate, salida de humos e instalación eléctrica nueva.',
                'price' => 450000.00,
                'address' => 'Calle Mayor, 15, 28012 Madrid, España',
                'latitude' => 40.41580000,
                'longitude' => -3.70740000,
                'type' => 'commercial',
                'status' => 'available',
                'images' => ['properties/sample_local_1.jpg'],
            ]
        ];

        foreach ($properties as $propData) {
            $images = $propData['images'];
            unset($propData['images']);

            // Create Property
            $property = $agent->properties()->create($propData);

            // Create Images
            foreach ($images as $imagePath) {
                $property->images()->create([
                    'image_path' => $imagePath,
                ]);
            }

            // Create a Sample Lead from Buyer to the first property
            if ($property->type === 'house') {
                Lead::create([
                    'property_id' => $property->id,
                    'user_id' => $buyer->id,
                    'message' => 'Hola, estoy muy interesada en visitar este chalet de La Moraleja. ¿Tienen disponibilidad este sábado por la mañana?',
                ]);
            }
        }
    }
}
