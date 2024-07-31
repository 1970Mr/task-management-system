<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    private array $data;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->data = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'deadline' => $this->deadline->toDateTimeString(),
            'user' => new UserResource($this->user),
        ];

        $this->setFieldIfExists('parentTask');
        $this->setFieldIfExists('subtask');
        $this->setUsers();
        return $this->data;
    }

    private function setFieldIfExists(string $fieldName): void
    {
        if ($this->{$fieldName}) {
            $this->data[$fieldName] = $this->{$fieldName};
        }
    }

    private function setUsers(): void
    {
        if ($this->users) {
            $this->data['users'] = new UserCollection($this->users);
        }
    }
}
