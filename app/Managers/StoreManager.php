<?php

namespace App\Managers;

use App\Models\Store;
use App\Data\StoreData;
use App\Models\User;

class StoreManager
{
    private static function fillStore(Store $store, StoreData $data): void
    {
        $store->name = $data->name;
        $store->siret = $data->siret;
        $store->customs_code = $data->customs_code;
        $store->document_path = $data->document_path;
    }

    public static function createStore(StoreData $data, User $owner): Store
    {
        $store = new Store();
        self::fillStore($store, $data);
        $store->save();
        $store->activities()->sync($data->activities);
        $store->users()->attach($owner->id, ['role' => 'owner']);
        return $store;
    }

    public static function updateStore(Store $store, StoreData $data): void
    {
        self::fillStore($store, $data);
        $store->save();
        $store->activities()->sync($data->activities);
    }
}
