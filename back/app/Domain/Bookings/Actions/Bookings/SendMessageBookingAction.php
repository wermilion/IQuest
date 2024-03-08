<?php

namespace App\Domain\Bookings\Actions\Bookings;

use App\Apis\VKApi;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Carbon\Carbon;

/**
 * Class SendMessageBookingAction
 *
 * @property VKApi $vk
 */
class SendMessageBookingAction
{
    public function __construct(private readonly VKApi $vk)
    {
    }

    public function execute(Booking $booking): void
    {
        $city = $booking->city;
        $userIds = User::query()
            ->whereHas('filials', fn($query) => $query->where('city_id', $city->id))
            ->whereNotNull('vk_id')
            ->whereIn('role', [Role::ADMIN->value, Role::OPERATOR->value])
            ->pluck('vk_id')
            ->toArray();

        $message = [
            'Новая заявка: ' . $booking->type->value,
            'Имя клиента: ' . $booking->name,
            'Телефон: ' . $booking->phone,
        ];

        $userIds = array_filter($userIds, function ($userId) {
            return $this->vk->isMessagesFromGroupAllowed($userId);
        });

        if (!empty($userIds)) {
            match ($booking->type->value) {
                BookingType::QUEST->value => $this->sendMessageQuest($booking, $userIds),
                BookingType::LOUNGE->value => $this->sendMessageLounge($userIds, $message),
                BookingType::HOLIDAY->value => $this->sendMessageHoliday($booking, $userIds, $message),
                BookingType::CERTIFICATE->value => $this->sendMessageCertificate($booking, $userIds, $message),
            };
        }
    }

    private function sendMessageQuest(Booking $booking, $userIds): void
    {
        $bookingScheduleQuest = $booking->bookingScheduleQuest;

        $adminFilials = User::query()
            ->whereHas('filials', fn($query) => $query
                ->where('filial_id', $bookingScheduleQuest->timeslot->scheduleQuest->quest->filial_id))
            ->whereNotNull('vk_id')
            ->where('role', Role::FILIAL_ADMIN->value)
            ->pluck('vk_id')
            ->toArray();

        $userIds = array_merge($userIds, $adminFilials);

        $comment = $bookingScheduleQuest->comment ? 'Комментарий: ' . $bookingScheduleQuest->comment : '';
        $questMessage = [
            'Новая заявка: ' . $booking->type->value,
            'Квест: ' . $bookingScheduleQuest->timeslot->scheduleQuest->quest->slug,
            'Дата и время: ' . Carbon::parse($bookingScheduleQuest->timeslot->scheduleQuest->date)
                ->translatedFormat('d.m.Y') . ' ' . $bookingScheduleQuest->timeslot->time,
            'Имя клиента: ' . $booking->name,
            'Телефон: ' . $booking->phone,
            'Кол-во участников: ' . $bookingScheduleQuest->count_participants,
            'Цена: ' . $bookingScheduleQuest->final_price,
            $comment
        ];

        $messageString = implode('<br>', $questMessage);

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function sendMessageLounge(array $userIds, array $message): void
    {
        $messageString = implode('<br>', $message);

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function sendMessageHoliday(Booking $booking, $userIds, array $message): void
    {
        $holidayPackage = $booking->bookingHoliday->holidayPackage;

        $message[] = 'Тип праздника: ' . $holidayPackage->holiday->type->value;
        $message[] = 'Пакет: ' . $holidayPackage->package->name;

        $messageString = implode('<br>', $message);

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function sendMessageCertificate(Booking $booking, $userIds, array $message): void
    {
        $bookingCertificate = $booking->bookingCertificate;

        $message[] = 'Тип сертификата: ' . $bookingCertificate->certificateType->name;

        $messageString = implode('<br>', $message);

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }
}
