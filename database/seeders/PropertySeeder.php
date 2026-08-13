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
        // 1. Create or Find an Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@inmobiliaria.com'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Create or Find an Agent User
        $agent = User::firstOrCreate(
            ['email' => 'agente@inmobiliaria.com'],
            [
                'name' => 'Carlos Mendoza',
                'password' => Hash::make('password123'),
                'role' => 'agent',
            ]
        );

        // 3. Create or Find a Buyer User (for leads)
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
                'title' => 'Residencia Histórica con Amplio Jardín - Centro Nopalucan',
                'description' => 'Espectacular propiedad de diseño tradicional de 450m² construidos sobre gran parcela de 1.200m². Ubicada en la emblemática zona centro de Nopalucan de la Granja. Cuenta con acabados rústicos de alta calidad, amplio patio, cocina equipada y cochera para 3 autos.',
                'price' => 3800000.00,
                'address' => 'Calle Constitución Oriente s/n, Centro, 75120 Nopalucan de la Granja, Pue., México',
                'latitude' => 19.21620000,
                'longitude' => -97.82290000,
                'type' => 'house',
                'status' => 'available',
                'images' => ['properties/sample_chalet_1.jpg', 'properties/sample_chalet_2.jpg'],
            ],
            [
                'title' => 'Casa de Campo Familiar cerca del Cerro del Pinal',
                'description' => 'Hermosa casa de campo con vistas despejadas al majestuoso Cerro del Pinal. Cuenta con 3 recámaras amplias, estancia de doble altura, chimenea acogedora, cisterna de gran capacidad y excelente iluminación natural.',
                'price' => 2450000.00,
                'address' => 'Calle Juan de la Granja Sur 3, Centro, 75120 Nopalucan de la Granja, Pue., México',
                'latitude' => 19.21550000,
                'longitude' => -97.82360000,
                'type' => 'apartment',
                'status' => 'available',
                'images' => ['properties/sample_atico_1.jpg'],
            ],
            [
                'title' => 'Local Comercial Estratégico Frente a la Colecturía',
                'description' => 'Excelente local comercial ideal para negocio, oficina o punto de atención a clientes. Ubicado en zona de alto tránsito peatonal a unos pasos de la histórica Colecturía de Nopalucan. Cuenta con medio baño, ventanales frontales de exhibición y techos altos.',
                'price' => 1200000.00,
                'address' => 'Avenida 2 Poniente 4, Centro, 75120 Nopalucan de la Granja, Pue., México',
                'latitude' => 19.21700000,
                'longitude' => -97.82180000,
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
                    'message' => 'Hola, estoy muy interesada en visitar esta residencia histórica en Nopalucan. ¿Tienen disponibilidad este sábado por la mañana?',
                ]);
            }
        }
    }
}
