<?php
namespace App\Repository;

use App\Interfaces\ContractRepositoryInterface;
use App\Models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    public function all()
    {
        return Contract::all();
    }
    public function findById(int $id)
    {
        return Contract::findOrFail($id);
    }
     public function create(array $data)
     {
        return Contract::create($data);
     }
     public function update(int $id, array $data)
     {
        Contract::findOrFail($id)->update($data);
     }
     public function delete(int $id)
     {
        Contract::findOrFail($id)->delete();
     }

}