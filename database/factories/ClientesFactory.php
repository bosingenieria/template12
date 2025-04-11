<?php

namespace Database\Factories;

use App\Models\Clientes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clientes>
 */
class ClientesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Clientes::class;

    public function definition(): array
    {
        return [
            'tipo_doc' => 'Cédula de ciudadanía',
            'documento_identidad' => $this->faker->unique()->numerify('##########'),
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'telefono_principal' => $this->faker->numerify('3#########'),
            'telefono_secundario' => $this->faker->boolean(50) ? $this->faker->numerify('3#########') : null,
            'direccion_principal' => $this->faker->address,
            'direccion_secundaria' => $this->faker->boolean(40) ? $this->faker->address : null,
            'estado' => 1, // activo por defecto
        ];
    }
}
