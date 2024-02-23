<?php

namespace App\Apis;

use Exception;
use Log;
use VK\Client\VKApiClient;

class VKApi
{
    public VKApiClient $vk;

    public string $accessToken;

    public int $groupId;

    public function __construct($accessToken, $groupId)
    {
        $this->vk = new VKApiClient();
        $this->accessToken = $accessToken;
        $this->groupId = $groupId;
    }

    public function isMessagesFromGroupAllowed(int $userId): bool
    {
        try {
            $result = $this->vk->messages()->isMessagesFromGroupAllowed($this->accessToken, [
                'group_id' => $this->groupId,
                'user_id' => $userId,
            ]);
        } catch (Exception $e) {
            Log::error('Ошибка при отправке сообщения пользователю в ВКонтакте')
                ->withContext(['message' => $e->getMessage()]);
            return false;
        }

        if (isset($result['is_allowed'])) {
            return $result['is_allowed'];
        }

        return false;
    }

    public function sendMessage($userId, $message): void
    {
        try {
            $this->vk->messages()->send($this->accessToken, [
                'user_id' => $userId,
                'random_id' => 0,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            
        }
    }
}
