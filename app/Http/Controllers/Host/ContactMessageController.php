<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    // LIST
    public function index()
    {
        $messages = ContactMessage::with('user')
            ->latest()
            ->paginate(10);

        return view('host.contact-messages.index', compact('messages'));
    }

    // SHOW DETAIL
    public function show(ContactMessage $contactMessage)
    {
        // auto mark as read
        if ($contactMessage->status === 'unread') {
            $contactMessage->update([
                'status' => 'read'
            ]);
        }

        $contactMessage->load('user');

        return view('host.contact-messages.show', compact('contactMessage'));
    }

    // MARK AS REPLIED (KHÔNG GỬI MAIL)
    public function reply(ContactMessage $contactMessage)
    {
        $contactMessage->update([
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Đã đánh dấu đã phản hồi.');
    }

    public function sendReply(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'reply_message' => ['required', 'string', 'max:2000'],
        ], [
            'reply_message.required' => 'Vui lòng nhập nội dung phản hồi.',
            'reply_message.max' => 'Nội dung phản hồi không được vượt quá 2000 ký tự.',
        ]);

        try {
            Mail::to($contactMessage->email)
                ->send(new ContactReplyMail($contactMessage, $validated['reply_message']));
        } catch (\Throwable $exception) {
            Log::warning('Unable to send contact reply email.', [
                'contact_message_id' => $contactMessage->id,
                'exception' => $exception,
            ]);

            return back()
                ->withInput()
                ->withErrors(['reply_message' => 'Chưa gửi được email phản hồi (lỗi kết nối mail). Nội dung chưa được lưu, vui lòng thử lại sau.']);
        }

        $contactMessage->update([
            'reply_message' => $validated['reply_message'],
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        return redirect()
            ->route('host.contact-messages.show', $contactMessage)
            ->with('success', 'Gửi phản hồi thành công');
    }

    // DELETE
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('host.contact-messages.index')
            ->with('success', 'Đã xoá tin nhắn.');
    }
}