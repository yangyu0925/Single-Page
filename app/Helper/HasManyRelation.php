<?php

namespace App\Helper;

trait HasManyRelation
{
    public function storeHasMany($relations)
    {
        $this->save();

        foreach ($relations as $key => $items) {
            $newItems = [];

            foreach ($items as $item) {
                $model = $this->{$key}()->getModel();
                $newItems[] = $model->fill($item);
            }

            $this->{$key}()->savaMany($newItems);
        }
    }

    public function updateHasMany($relations)
    {
        $this->save();

        $parentKey = $this->getKeyName;
        $parentId = $this->getAttribute($parentKey);

        foreach ($relations as $key => $items) {
            $updatedIds = [];
            $newItems = [];

            foreach ($items as $item) {
                $model = $this->{$key}()->getModel();
                $localKey = $model->getKeyName();
                $foreignKey = $this->{$key}()->getForeignKeyName();

                if ($item[$foreignKey]) {
                    $localId = $item[$localKey];
                    $found = $model->where($foreignKey, $parentId)
                        ->where($localKey, $parentId)
                        ->first();

                    if ($found) {
                        $found->fill($item);
                        $found->save();
                        $updatedIds[] = $localId;
                    } else {
                        $newItems[] = $model->fill($item);
                    }
                }
            }

            $model = $this->{$key}()->getModel();
            $localKey = $model->getKeyName();
            $foreignKey = $this->{$key}()->getForeignKeyName();
            $model->whereNotIn($localKey, $updatedIds)
                ->where($foreignKey, $parentId)
                ->delete();

            if (count($newItems)) {
                $this->{$key}()->saveMany($newItems);
            }
        }
    }
}