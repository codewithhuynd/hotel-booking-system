<?php

namespace App\Http\Controllers;

use App\Models\BookingCancellation;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Phục vụ ảnh minh chứng thanh toán / hoàn tiền (có thông tin ngân hàng) qua route
 * có kiểm tra quyền, thay vì để công khai trong /storage.
 * Chỉ host và chính khách của booking được xem.
 */
class ProofFileController extends Controller
{
    /** Disk lưu ảnh minh chứng mới (riêng tư, không truy cập trực tiếp qua URL). */
    public const DISK = 'local';

    public function paymentProof(Payment $payment): Response
    {
        $payment->loadMissing('booking');

        $this->authorizeFor($payment->booking?->user_id);

        return $this->serve($payment->proof_image);
    }

    public function refundProof(BookingCancellation $cancellation): Response
    {
        $cancellation->loadMissing('booking');

        $this->authorizeFor($cancellation->booking?->user_id);

        return $this->serve($cancellation->refund_proof_image);
    }

    /** Xoá file minh chứng ở cả disk riêng tư và disk public (dữ liệu cũ). */
    public static function delete(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        Storage::disk(self::DISK)->delete($path);
        Storage::disk('public')->delete($path);
    }

    private function authorizeFor(?int $ownerId): void
    {
        $user = Auth::user();

        abort_unless($user && ($user->role === 'host' || $user->id === $ownerId), 403);
    }

    private function serve(?string $path): Response
    {
        abort_if(blank($path), 404);

        // File mới nằm ở disk riêng tư; file tải lên trước khi đổi vẫn nằm ở disk public.
        foreach ([self::DISK, 'public'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return response()->file(Storage::disk($disk)->path($path), [
                    'Cache-Control' => 'private, max-age=600',
                    'X-Content-Type-Options' => 'nosniff',
                ]);
            }
        }

        abort(404);
    }
}
