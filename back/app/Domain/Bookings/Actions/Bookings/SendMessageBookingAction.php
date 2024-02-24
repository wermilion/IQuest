<?php

namespace App\Domain\Bookings\Actions\Bookings;

use App\Apis\VKApi;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Carbon\Carbon;

class SendMessageBookingAction
{
    public function execute(Booking $booking): void
    {
        $vk = new VKApi(env('VK_ACCESS_TOKEN'), env('VK_GROUP_ID'));

        $userIds = User::query()
            ->whereNotNull('vk_id')
            ->whereIn('role', [Role::ADMIN->value, Role::OPERATOR->value])
            ->pluck('vk_id')
            ->toArray();

        $message = [
            'Новая заявка. Тип: ' . $booking->type->value,
            'Имя клиента: ' . $booking->name,
            'Телефон: ' . $booking->phone,
        ];

        foreach ($userIds as $userId) {
            if (!$vk->isMessagesFromGroupAllowed($userId)) {
                unset($userIds[$userId]);
            }
        }

        if (empty($userIds)) {
            return;
        }

        match ($booking->type->value) {
            BookingType::QUEST->value => $this->sendMessageQuest($vk, $booking, $userIds, $message),
            BookingType::LOUNGE->value => $this->sendMessageLounge($vk, $userIds, $message),
            BookingType::HOLIDAY->value => $this->sendMessageHoliday($vk, $booking, $userIds, $message),
            BookingType::CERTIFICATE->value => $this->sendMessageCertificate($vk, $booking, $userIds, $message),
        };
    }

    private function sendMessageQuest(VKApi $vk, Booking $booking, $userIds, array $message): void
    {
        $bookingScheduleQuest = $booking->bookingScheduleQuest;

        $adminFilials = User::query()
            ->whereNotNull('vk_id')
            ->where('filial_id', $bookingScheduleQuest->scheduleQuest->quest->filial->id)
            ->where('role', Role::FILIAL_ADMIN->value)
            ->pluck('vk_id')
            ->toArray();

        $userIds = array_merge($userIds, $adminFilials);

        $comment = $bookingScheduleQuest->comment ? 'Комментарий: ' . $bookingScheduleQuest->comment : '';
        array_push($message,
            'Квест: ' . $bookingScheduleQuest->scheduleQuest->quest->slug,
            'Дата и время: ' . Carbon::parse($bookingScheduleQuest->scheduleQuest->date)
                ->translatedFormat('d.m.Y') . ' ' . $bookingScheduleQuest->scheduleQuest->time,
            'Кол-во участников: ' . $bookingScheduleQuest->count_participants,
            'Цена: ' . $bookingScheduleQuest->final_price,
            $comment
        );

        foreach ($userIds as $userId) {
            $vk->sendMessage($userId, implode('<br>', $message));
        }
    }

    private function sendMessageLounge(VKApi $vk, $userIds, array $message): void
    {
        foreach ($userIds as $userId) {
            $vk->sendMessage($userId, implode('<br>', $message));
        }
    }

    private function sendMessageHoliday(VKApi $vk, Booking $booking, $userIds, array $message): void
    {
        $holidayPackage = $booking->bookingHoliday->holidayPackage;

        array_push($message,
            'Тип праздника: ' . $holidayPackage->holiday->type->value,
            'Пакет: ' . $holidayPackage->package->name
        );

        foreach ($userIds as $userId) {
            $vk->sendMessage($userId, implode('<br>', $message));
        }
    }

    private function sendMessageCertificate(VKApi $vk, Booking $booking, $userIds, array $message): void
    {
        $bookingCertificate = $booking->bookingCertificate;

        array_push($message,
            'Тип сертификата: ' . $bookingCertificate->certificateType->name,
            'Цена: ' . $bookingCertificate->certificateType->price
        );

        foreach ($userIds as $userId) {
            $vk->sendMessage($userId, implode('<br>', $message));
        }
    }
}
