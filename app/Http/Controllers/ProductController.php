<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\UpsertProduct;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(private readonly UpsertProduct $createProduct)
    {
    }

    public function index()
    {
        return [
            'data' => ProductResource::collection(Product::all()),
        ];
    }

    public function show(Product $product)
    {
        return [
            'data' => new ProductResource($product)
        ];
    }

    public function store(StoreProductRequest $request)
    {
        return response([
            'data' => new ProductResource($this->upsert($request, new Product()))
        ], Response::HTTP_CREATED);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        return response([
            'data' => new ProductResource($this->upsert($request, $product))
        ], Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }

    private function upsert(StoreProductRequest $request, Product $product): Product
    {
        $product = $this->createProduct->handle(
            Category::find($request->getCategoryId()),
            $request->getName(),
            $request->getPrices(),
            $request->getDescription(),
            $product->id,
        );

        $product->load('category');
        return $product;
    }
}
