<?php
namespace App\Interfaces;
interface PaymentRepositoryInterface
{
   public function all();
   public function findById(int $id);
   public function create(array $data);
   public function update(int $id, array $data);
   public function delete(int $id);
   public function getByInvoiceId(int $invoiceId);
}
