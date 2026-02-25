<?php

namespace App\Interfaces;


interface InvoiceRepositoryInterface{

    public function all();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getByContractId(int $contractId);
    public function getRemainingBalance(int $invoiceId);
    public function updateStatus(int $invoiceId, string $status);
    public function getpaidAmount(int $invoiceId);
    public function getTotal(int $invoiceId);
}