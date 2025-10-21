<?php

namespace App\Services\ToolService;

class PostService
{
    public function create(array $data)
    {
        return Driver::create($data);
    }

    public function update(array $data, int $id)
    {
        // lógica para actualizar un conductor
    }

    public function delete(int $id)
    {
        // lógica para eliminar un conductor
    }

    public function all()
    {
        // lógica para obtener todos los conductores
    }

    public function find(int $id)
    {
        // lógica para obtener un conductor específico
    }

}
