<?php

namespace App\Services;

use App\Events\OrderStatusChangeEvent;
use App\Models\Category as ModelsCategory;
use App\Models\Command;
use App\Models\CommandDetail;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Validation\Rules\In;

class RestaurantService
{
    public function list(int $businessId)
    {
        return Table::with(['waiter'])
            ->where('business_id', $businessId)
            ->get();
    }

    public function listProducts(int $businessId)
    {
        return Product::with(['category', 'inventoryDetail'])
            ->where('business_id', $businessId)
            ->get();
    }

    public function listItems(int $tableId)
    {
        return Command::where('table_id', $tableId)->with('details.product')->get();
    }

    public function listItemCook()
    {
        $commands = Command::with('details.product')->get();
        $newArray = $commands->map(function ($command) {
            return [
                'id' => $command->id,
                'table' => $command->table_id,
                'status' => $command->status,
                'total' => $command->details->sum(fn($d) => $d->quantity * $d->price),
                'items' => $command->details->map(function ($detail) {
                    return [
                        'product' => $detail->product->name,
                        'qty'     => $detail->quantity,
                        'price'   => floatval($detail->price),
                        'subtotal' => $detail->quantity * $detail->price,
                    ];
                }),
            ];
        });

        $statuses = [
            ['title' => 'pending'],
            ['title' => 'in_process'],
            ['title' => 'ready'],
        ];

        // event(new OrderStatusChangeEvent($newArray));
        return [
            'orders'   => $newArray,
            'statuses' => $statuses,
        ];
    }

    public function listCategories(int $businessId)
    {
        $categories = ModelsCategory::where('business_id', $businessId)
            ->orderBy('name')
            ->get();
        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        })->prepend(['id' => 0, 'name' => 'Ver todo']);
    }

    public function addToAccount(int $tableId, array $items, int $total, int $user)
    {
        try {
            $command = Command::create([
                'table_id' => $tableId,
                'chef_id' => 1,
                'user_id' => $user,
                'total_amount' => $total,
                'note' => null,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {

                $productId = $item['product_id'];
                $quantity = $item['qty'];
                $total = $item['price'] * $quantity;
                $price = $item['price'];
                $note = $item['comment'] ?? null;
                $this->addCommandDetail($command, $productId, $quantity, $total, $price,  $note);
            }
            event(new OrderStatusChangeEvent($this->listItemCook()['orders']));
            return ['success' => true, 'item' => $command];
        } catch (\Exception $e) {
            // Log the error message if needed
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function addCommandDetail(Command $command, int $productId, int $quantity, int $total, int $price, ?string $note)
    {
        return CommandDetail::create([
            'command_id' => $command->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'total' => $total,
            'price' => $price,
            'notes' => $note,
            'status' => 'pending',
        ]);
    }

    public function updateItemStatus(int $commandId, string $newStatus)
    {
        $validStatuses = ['pending', 'in_process', 'ready'];

        if (!in_array($newStatus, $validStatuses)) {
            return ['success' => false, 'error' => 'Estado inválido'];
        }

        $command = Command::find($commandId);
        if (!$command) {
            return ['success' => false, 'error' => 'Detalle del comando no encontrado'];
        }

        $commandDetails = CommandDetail::where('command_id', $commandId)->get();
        foreach ($commandDetails as $detail) {
            $detail->status = $newStatus;
            $detail->save();
        }


        $command->status = $newStatus;
        $command->save();

        event(new OrderStatusChangeEvent($this->listItemCook()['orders']));

        return ['success' => true, 'item' => $command];
    }
}
