<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

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

    // DELETE
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('host.contact-messages.index')
            ->with('success', 'Đã xoá tin nhắn.');
    }
}