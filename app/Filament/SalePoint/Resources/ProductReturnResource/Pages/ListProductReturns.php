<?php

namespace App\Filament\SalePoint\Resources\ProductReturnResource\Pages;

use App\Filament\SalePoint\Resources\ProductReturnResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductReturns extends ListRecords
{
    protected static string $resource = ProductReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
