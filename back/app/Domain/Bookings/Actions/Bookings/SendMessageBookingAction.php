<?php

namespace App\Domain\Bookings\Actions\Bookings;

use App\Apis\VKApi;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use App\Dto\CertificateNewRequest;
use App\Dto\HolidayNewRequest;
use App\Dto\LoungeNewRequest;
use App\Dto\QuestNewRequest;

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

        $userIds = array_filter($userIds, function ($userId) {
            return $this->vk->isMessagesFromGroupAllowed($userId);
        });

        if (!empty($userIds)) {
            match ($booking->type->value) {
                BookingType::QUEST->value => $this->sendMessageQuest($booking, $userIds),
                BookingType::LOUNGE->value => $this->sendMessageLounge($booking, $userIds),
                BookingType::HOLIDAY->value => $this->sendMessageHoliday($booking, $userIds),
                BookingType::CERTIFICATE->value => $this->sendMessageCertificate($booking, $userIds),
            };
        }
    }

    private function sendMessageQuest(Booking $booking, $userIds): void
    {
        $bookingScheduleQuest = $booking->bookingScheduleQuest;

        $adminFilials = $this->getAdminFilials($bookingScheduleQuest->timeslot->scheduleQuest->quest->filial_id);

        $userIds = array_merge($userIds, $adminFilials);

        $comment = $bookingScheduleQuest->comment ? "Комментарий: $bookingScheduleQuest->comment" : "";

        $message = new QuestNewRequest([
            'new_request' => "Новая заявка: {$booking->type->value}",
            'quest' => "Квест: {$bookingScheduleQuest->timeslot->scheduleQuest->quest->slug}",
            'date_and_time' => "Дата и время: {$bookingScheduleQuest->timeslot->scheduleQuest->date} {$bookingScheduleQuest->timeslot->time}",
            'customer_name' => "Имя клиента: $booking->name",
            'customer_phone' => "Телефон: $booking->phone",
            'count_participants' => "Кол - во участников: $bookingScheduleQuest->count_participants",
            'final_price' => "Цена: $bookingScheduleQuest->final_price",
            'comment' => $comment
        ]);

        $messageString = implode('<br>', $message->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    public function sendMessageLounge(Booking $booking, array $userIds = []): void
    {
        $message = new LoungeNewRequest([
            'new_request' => $booking->type->value,
            'customer_name' => $booking->name,
            'customer_phone' => $booking->phone,
        ]);

        $scheduleLounge = $booking->bookingScheduleLounge->scheduleLounge;

        if ($scheduleLounge) {
            $message->lounge = $scheduleLounge->lounge->name;
            $message->date_and_time = "$scheduleLounge->date с $scheduleLounge->time_from по $scheduleLounge->time_to";

            $adminFilials = $this->getAdminFilials($scheduleLounge->lounge->filial_id);
            $userIds = array_merge($userIds, $adminFilials);
        }

        $messageString = implode('<br>', $message->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function sendMessageHoliday(Booking $booking, $userIds): void
    {
        $holidayPackage = $booking->bookingHoliday->holidayPackage;

        $message = new HolidayNewRequest([
            'new_request' => "Новая заявка: {$booking->type->value}",
            'holiday_and_package' => "Праздник и пакет: {$holidayPackage->holiday->type->value} {$holidayPackage->package->name}",
            'customer_name' => "Имя клиента: $booking->name",
            'customer_phone' => "Телефон: $booking->phone",
        ]);

        $messageString = implode('<br>', $message->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function sendMessageCertificate(Booking $booking, $userIds): void
    {
        $bookingCertificate = $booking->bookingCertificate;

        $message = new CertificateNewRequest([
            'new_request' => "Новая заявка: {$booking->type->value}",
            'certificate' => "Тип сертификата: {$bookingCertificate->certificate->type->value}",
            'customer_name' => "Имя клиента: $booking->name",
            'customer_phone' => "Телефон: $booking->phone",
        ]);

        $messageString = implode('<br>', $message->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function getAdminFilials($filialId): array
    {
        return User::query()
            ->whereHas('filials', fn($query) => $query
                ->where('filial_id', $filialId))
            ->whereNotNull('vk_id')
            ->where('role', Role::FILIAL_ADMIN->value)
            ->pluck('vk_id')
            ->toArray();
    }
}
