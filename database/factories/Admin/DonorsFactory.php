<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Donors;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonorsFactory extends Factory
{
    protected $model = Donors::class;

    public function definition()
    {
        return [
            'name'        => $this->faker->name(),
            'phone'       => $this->faker->phoneNumber(),
            'link'        => $this->faker->optional()->url(),
            'is_active'   => true, 
            'type_donor'  => $this->faker->randomElement([0, 1]), // 1 para PF, 0 para PJ
            'description' => $this->faker->sentence(10),
            'delete'      => 0,
            'status'      => 1,
            // created_at e updated_at são automáticos pelo banco (useCurrent), 
            // então não precisamos declarar aqui, a menos que queira datas fakes no passado.
        ];
    }
}