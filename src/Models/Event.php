<?php

namespace MarcReichel\LaravelFathom\Models;

class Event extends Model
{
    public string|null $siteId;
    public string|null $id;

    public function __construct(string|null $siteId, string $id = null)
    {
        parent::__construct();

        $this->siteId = $siteId;
        $this->id = $id;
    }

    public function all(int $limit = null, string $starting_after = null, string $ending_before = null): array|null
    {
        // TODO: Implement cursor pagination
        $siteId = $this->siteId;
        $endpoint = "sites/$siteId/events";
        return $this->resolveResponse($this->client->get($endpoint), $endpoint);
    }

    public function get(): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        $endpoint = "sites/$siteId/events/$eventId";
        return $this->resolveResponse($this->client->get($endpoint), $endpoint);
    }

    public function create(string $name): array|null
    {
        $siteId = $this->siteId;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events", [
            'name' => $name,
        ]));
    }

    public function update(array $data): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->asForm()->post("sites/$siteId/events/$eventId",
            collect($data)->only('name')->toArray()));
    }

    public function wipe(): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$siteId/events/$eventId/data"));
    }

    public function delete(): array|null
    {
        $siteId = $this->siteId;
        $eventId = $this->id;
        return $this->resolveResponse($this->client->delete("sites/$siteId/events/$eventId"));
    }
}
