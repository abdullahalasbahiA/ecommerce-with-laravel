<?php

// app/Interfaces/ProductServiceInterface.php
namespace App\Interfaces;

use Illuminate\Http\UploadedFile;

interface ProductServiceInterface
{
    public function getAllProducts();
    public function getProductById($id);
    public function createProduct(array $data, ?UploadedFile $image, ?array $features);
    public function updateProduct($id, array $data, ?UploadedFile $image, ?array $features);
    public function deleteProduct($id);
    public function searchProducts(array $filters);
}