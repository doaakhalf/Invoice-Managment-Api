<?php
namespace App\Interfaces;

interface ContractRepositoryInterface
{
   public function all();
   public function findById(int $id);
   public function create(array $data);
   public function update(int $id, array $data);
   public function delete(int $id);
}
