<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Admin\Product\ProductStoreRequest;
use App\Http\Requests\Admin\Product\ProductUpdateRequest;
use App\Services\Campaigns\Admin\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->indexProduct();
        if($products->isEmpty()){
            return ResponseHelper::notFound('Ürün bulunamadı');
        }
        return ResponseHelper::success('Products fetched successfully', $products);
    }
    public function store(ProductStoreRequest $request)
    {
        $products = $this->productService->createProduct($request);
        if(!$products){
            return ResponseHelper::error('Ürün oluşturulamadı');
        }
        return ResponseHelper::success('Product created successfully', $products);
    }
    public function show($id)
    {
        $products = $this->productService->showProduct($id);
        if(!$products){
            return ResponseHelper::notFound('Ürün bulunamadı');
        }
        return ResponseHelper::success('Product fetched successfully', $products);
    }
    public function update(ProductUpdateRequest $request, $id)
    {
        $products = $this->productService->updateProduct($request, $id);
        if(!$products){
            return ResponseHelper::notFound('Ürün bulunamadı');
        }
        return ResponseHelper::success('Product updated successfully', $products);
    }
    public function destroy($id)
    {
        $products = $this->productService->deleteProduct($id);
        if(!$products){
            return ResponseHelper::notFound('Ürün bulunamadı');
        }
        return ResponseHelper::success('Ürün başarıyla silindi', $products);
    }
}